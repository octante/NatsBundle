<?php

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

        // Connection instance
        $connectionFactoryDefinition = new Definition('Octante\\NatsBundle\\Services\\ConnectionFactory', array($config));
        $container->setDefinition('octante_nats.connection_factory', $connectionFactoryDefinition);
    }
}