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

use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\Config\Definition\Processor;

/**
 * {@inheritDoc}
 */
class r1pp3rj4ckLipsumExtension extends Extension
{
    /**
     * {@inheritDoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $loader = new XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('generator.xml');

        $configuration = new Configuration();
        $processor     = new Processor();
        $config        = $processor->processConfiguration($configuration, $configs);

        $container->setParameter('r1pp3rj4ck.lipsum.male_names', $config['profileGenerator']['profile']['male_names']);
        $container->setParameter('r1pp3rj4ck.lipsum.female_names', $config['profileGenerator']['profile']['female_names']);
        $container->setParameter('r1pp3rj4ck.lipsum.last_names', $config['profileGenerator']['profile']['last_names']);
        $container->setParameter('r1pp3rj4ck.lipsum.profile_generator_class', $config['profileGenerator']['profile']['class']);

        $container->setParameter('r1pp3rj4ck.lipsum.random', $config['profileGenerator']['random']['random']);
        $container->setParameter('r1pp3rj4ck.lipsum.random_generator_class', $config['profileGenerator']['random']['class']);
    }
}
