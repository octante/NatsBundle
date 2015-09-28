<?php

/*
 * This file is part of the Nelmio SolariumBundle.
 *
 * (c) Nelmio <hello@nelm.io>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Octante\NatsBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Processor;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

class OctanteNatsExtension extends Extension
{
    /**
     * @param array            $configs
     * @param ContainerBuilder $container
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $processor = new Processor();
        $configuration = new Configuration();
        $config = $processor->processConfiguration($configuration, $configs);

        // Connection options instance
        $connectionOptionsDefinition = new Definition('Nats\\ConnectionOptions');
        $connectionOptionsDefinition->addMethodCall('setHost', array($config['host']));
        $connectionOptionsDefinition->addMethodCall('setPort', array($config['port']));
        $connectionOptionsDefinition->addMethodCall('setUser', array($config['user']));
        $connectionOptionsDefinition->addMethodCall('setPassword', array($config['password']));
        $connectionOptionsDefinition->addMethodCall('setVerbose', array($config['verbose']));
        $connectionOptionsDefinition->addMethodCall('setReconnect', array($config['reconnect']));
        $connectionOptionsDefinition->addMethodCall('setVersion', array($config['version']));
        $connectionOptionsDefinition->addMethodCall('setPedantic', array($config['pedantic']));
        $connectionOptionsDefinition->addMethodCall('setLang', array($config['lang']));
        $container->setDefinition('octante_nats.connection_options', $connectionOptionsDefinition);

        // Connection instance
        $connectionDefinition = new Definition('Nats\\Connection');
        $connectionDefinition->setArguments(array($container->getDefinition('octante_nats.connection_options')));
        $connectionDefinition->addMethodCall('connect');
        $container->setDefinition('octante_nats.connection', $connectionDefinition);
    }
}
