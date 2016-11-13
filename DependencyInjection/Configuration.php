<?php

namespace Dzangocart\Bundle\SubscriptionBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('dzangocart_subscription');

        $rootNode
            ->children()
                ->scalarNode('account_class')
                    ->isRequired()
                    ->cannotBeEmpty()
                ->end()
                ->scalarNode('factory')
                    ->cannotBeEmpty()
                    ->defaultValue('dzangocart.subscription.factory.propel')
                ->end()
                ->arrayNode('pricing')
                    ->canBeDisabled()
                    ->children()
                        ->scalarNode('theme')
                            ->cannotBeEmpty()
                            ->defaultValue('default')
                        ->end()
                        ->scalarNode('max_plans')
                            ->cannotBeEmpty()
                            ->defaultValue('5')
                        ->end()
                    ->end()
                ->end()
                ->arrayNode('signup')
                    ->canBeEnabled()
                    ->children()
                        ->scalarNode('class')
                        ->end()
                        ->scalarNode('success_target_path')
                        ->end()
                        ->arrayNode('trial')
                            ->canBeEnabled()
                            ->addDefaultsIfNotSet()
                            ->children()
                                ->booleanNode('options')
                                    ->defaultFalse()
                                ->end()
                                ->scalarNode('days')
                                    ->defaultValue(30)
                                ->end()
                            ->end()
                        ->end()
                    ->end()
                ->end()
            ->end();

        return $treeBuilder;
    }
}
