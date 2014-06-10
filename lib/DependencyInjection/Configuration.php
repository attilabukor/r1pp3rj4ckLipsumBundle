<?php

/*
 * This file is part of the LipsumBundle package.
 *
 * (c) Attila Bukor <attila.bukor@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace r1pp3rj4ck\LipsumBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * {@inheritDoc}
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritDoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode    = $treeBuilder->root('r1pp3rj4ck_lipsum', 'array');

        $rootNode
            ->children()
                ->arrayNode('generator')
                ->addDefaultsIfNotSet()
                    ->children()
                        ->arrayNode('profile')
                        ->addDefaultsIfNotSet()
                            ->children()
                                ->scalarNode('male_names')->defaultValue('vendor/r1pp3rj4ck/lipsum-bundle/r1pp3rj4ck/LipsumBundle/data/malenames.txt')->cannotBeEmpty()->end()
                                ->scalarNode('female_names')->defaultValue('vendor/r1pp3rj4ck/lipsum-bundle/r1pp3rj4ck/LipsumBundle/data/femalenames.txt')->cannotBeEmpty()->end()
                                ->scalarNode('last_names')->defaultValue('vendor/r1pp3rj4ck/lipsum-bundle/r1pp3rj4ck/LipsumBundle/data/lastnames.txt')->cannotBeEmpty()->end()
                                ->scalarNode('class')->defaultValue('r1pp3rj4ck\\LipsumBundle\\Generator\\ProfileGenerator')->cannotBeEmpty()->end()
                            ->end()
                        ->end()
                        ->arrayNode('random')
                        ->addDefaultsIfNotSet()
                            ->children()
                                ->scalarNode('random')->defaultValue('vendor/r1pp3rj4ck/lipsum-bundle/r1pp3rj4ck/LipsumBundle/data/lipsum.txt')->cannotBeEmpty()->end()
                                ->scalarNode('class')->defaultValue('r1pp3rj4ck\\LipsumBundle\\Generator\\RandomGenerator')->cannotBeEmpty()->end()
                            ->end()
                        ->end()
                        ->arrayNode('address')
                        ->addDefaultsIfNotSet()
                            ->children()
                                ->scalarNode('street_names')->defaultValue('vendor/r1pp3rj4ck/lipsum-bundle/r1pp3rj4ck/LipsumBundle/data/streetnames.txt')->cannotBeEmpty()->end()
                                ->scalarNode('class')->defaultValue('r1pp3rj4ck\\LipsumBundle\\Generator\\AddressGenerator')->cannotBeEmpty()->end()
                            ->end()
                        ->end()
                    ->end()
                ->end()
            ->end()
        ->end();

        return $treeBuilder;
    }
}
