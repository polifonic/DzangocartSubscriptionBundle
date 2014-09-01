<?php

namespace Dzangocart\Bundle\SubscriptionBundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

class DzangocartSubscriptionExtension extends Extension
{
    /**
     * {@inheritDoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $container->setParameter('dzangocart_subscription.pricing.theme', $config['pricing']['theme']);
		$container->setParameter('dzangocart_subscription.class', $config['class']);
		$container->setParameter('dzangocart_subscription.trial.config', $config['trial']);

        $loader = new YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config/services'));
        $loader->load('plan.yml');
		$loader->load('form.yml');
    }
}
