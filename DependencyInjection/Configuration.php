<?php

namespace Dzangocart\Bundle\SubscriptionBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritDoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('dzangocart_subscription');

        $rootNode
            ->children()
                ->scalarNode('factory')
                    ->cannotBeEmpty()
                ->end()
                ->arrayNode('pricing')
                    ->canBeDisabled()
                    ->children()
                        ->scalarNode('theme')
                            ->cannotBeEmpty()
                            ->defaultValue('default')
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
