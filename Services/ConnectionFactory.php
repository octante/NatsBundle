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
     * @return Connection
     *
     * @throws ConnectionNameNotFound
     */
    public function createDefaultConnection()
    {
        if (!isset($this->configuration['default_connection'])) {
            throw new ConnectionNameNotFound();
        }

        return new Connection(
            $this->getConnectionOptions(
                $this->configuration['default_connection']
            )
        );
    }

    /**
     * @param string $connectionName
     *
     * @return Connection
     *
     * @throws ConnectionNameNotFound
     */
    public function createConnection($connectionName)
    {
        if (!isset($this->configuration[$connectionName])) {
            throw new ConnectionNameNotFound();
        }

        $config = $this->configuration[$connectionName];

        return new Connection(
            $this->getConnectionOptions($config)
        );
    }

    /**
     * Return a ConnectionOptions instance getting parameters from config.
     *
     * @param $config
     *
     * @return ConnectionOptions
     */
    private function getConnectionOptions($config)
    {
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

        return $connectionOptions;
    }
}
