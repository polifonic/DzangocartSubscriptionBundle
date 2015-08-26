<?php

namespace Dzangocart\Bundle\SubscriptionBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Exception\InvalidConfigurationException;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\PrependExtensionInterface;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

class DzangocartSubscriptionExtension extends Extension implements PrependExtensionInterface
{
    /**
     * {@inheritdoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $container->setParameter('dzangocart_subscription.pricing.theme', $config['pricing']['theme']);

        $loader = new YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config/services'));
        $loader->load('plan.yml');
        $loader->load('form.yml');

        if ($config['signup']['enabled']) {
            $this->loadSignup($config['signup'], $container, $loader);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function prepend(ContainerBuilder $container)
    {
        $bundles = $container->getParameter('kernel.bundles');

        $configs = $container->getExtensionConfig($this->getAlias());

        $config = $this->processConfiguration(new Configuration(), $configs);

        if (isset($bundles['PropelBundle'])) {
            $this->configurePropelBundle($container);
        }
    }

    /**
     * @param ContainerBuilder $container The service container
     */
    protected function configurePropelBundle(ContainerBuilder $container)
    {
        $container->prependExtensionConfig(
            'propel',
            array(
                'build-properties' => array(
                    'propel.behavior.subscription.class' => 'Dzangocart\Bundle\SubscriptionBundle\Propel\Behavior\SubscriptionBehavior',
                ),
            )
        );
    }

    protected function loadSignup(array $config, ContainerBuilder $container, YamlFileLoader $loader)
    {
        if (!isset($config['class'])) {
            throw new InvalidConfigurationException(
                'The "dzangocart_subscription.signup.class" configuration class option must be set or "dzangocart_subscription.signup.enabled" must be set to false.'
            );
        }

        $container->setParameter('dzangocart_subscription.signup.class', $config['class']);
        $container->setParameter('dzangocart_subscription.signup.trial.config', $config['trial']);
        $container->setParameter('dzangocart_subscription.signup.trial.days', $config['trial']['days']);
        $container->setParameter('dzangocart_subscription.signup.success_target_path', $config['success_target_path']);

        $loader->load('signup.yml');
    }
}
