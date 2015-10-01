<?php

namespace Octante\NatsBundle\Services;

use Nats\Connection;
use Nats\ConnectionOptions;
use Octante\NatsBundle\Exceptions\ConnectionNameNotFound;

class ConnectionFactory
{
    /**
     * @var array
     */
    private $configuration;

    /**
     * @param array $configuration
     */
    public function __construct($configuration)
    {
        $this->configuration = $configuration;
    }

    /**
     * @param string $connectionName
     *
     * @return Connection
     *
     * @throws ConnectionNameNotFound
     */
    public function createConnection($connectionName = null)
    {
        if (!isset($this->configuration['connections'][$connectionName])) {
            throw new ConnectionNameNotFound();
        }

        $config = $this->configuration['connections'][$connectionName];

        // Connection options instance
        $connectionOptions = new ConnectionOptions();
        $connectionOptions->setHost($config['host'])
            ->setPort($config['port'])
            ->setUser($config['user'])
            ->setPass($config['password'])
            ->setVerbose($config['verbose'])
            ->setReconnect($config['reconnect'])
            ->setVersion($config['version'])
            ->setPedantic($config['pedantic'])
            ->setLang($config['lang']);

        return new Connection($connectionOptions);
    }
}