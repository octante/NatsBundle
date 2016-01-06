<?php

/*
 * This file is part of the NatsBundle package.
 *
 * (c) Issel Guberna <issel.guberna@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Octante\NatsBundle\Services;

use Nats\Connection;
use Nats\ConnectionOptions;
use Octante\NatsBundle\Connection\ConnectionWrapper;
use Octante\NatsBundle\Exceptions\ConnectionNameNotFound;

class ConnectionFactory
{
    /**
     * @var array
     */
    private $configuration;

    /**
     * @var
     */
    private $logger;

    /**
     * @param array $configuration
     */
    public function __construct($configuration, $logger)
    {
        $this->configuration = $configuration;
        $this->logger = $logger;
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
     * @throws \Octante\NatsBundle\Exceptions\ConnectionNameNotFound
     *
     * @return Connection
     */
    public function createConnection($connectionName)
    {
        if (!isset($this->configuration[$connectionName])) {
            throw new ConnectionNameNotFound();
        }

        $config = $this->configuration[$connectionName];

        return new ConnectionWrapper(
            new Connection($this->getConnectionOptions($config)),
            $this->logger
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
