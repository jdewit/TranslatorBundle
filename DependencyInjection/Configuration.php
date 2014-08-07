<?php

namespace Avro\TranslatorBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;

/*
 * @author Joris de Wit <joris.w.dewit@gmail.com>
 */
class Configuration
{
    /**
     * Generates the configuration tree.
     *
     * @return NodeInterface
     */
    public function getConfigTree()
    {
        $treeBuilder = new TreeBuilder();

        $rootNode = $treeBuilder->root('avro_translator');

        $rootNode
            ->children()
                ->scalarNode('provider')->defaultValue('azure')->end()
                ->arrayNode('azure')
                    ->children()
                        ->scalarNode('client_id')->end()
                        ->scalarNode('client_secret')->end()
                    ->end()
                ->end()
            ->end()
        ->end();

        return $treeBuilder->buildTree();
    }
}
