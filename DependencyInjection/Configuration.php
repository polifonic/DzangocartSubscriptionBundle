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
                ->arrayNode('pricing')
                    ->canBeDisabled()
                    ->children()
                        ->scalarNode('theme')
                            ->cannotBeEmpty()
                            ->defaultValue('default')
                        ->end()
                    ->end()
                ->end()
            ->end();

        return $treeBuilder;
    }
}
