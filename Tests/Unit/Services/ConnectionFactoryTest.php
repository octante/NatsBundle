<?php

/*
 * This file is part of the NatsBundle package.
 *
 * (c) Issel Guberna <issel.guberna@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Octante\NatsBundle\Tests\Unit\Connection;

use Octante\NatsBundle\Services\ConnectionFactory;

class ConnectionFactoryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * method: createConnection
     * when: calledWithAValidConfigurationKey
     * will:  returnAValidConnection.
     */
    public function test_createConnection_calledWithAValidConfigurationKey_returnAValidConnection()
    {
        $conf = [
            'test_connection' => [
                'host' => 'localhost',
                'port' => 4222,
                'user' => 'user',
                'password' => 'password',
                'verbose' => true,
                'reconnect' => true,
                'version' => '0.0.5',
                'pedantic' => true,
                'lang' => 'php',
            ],
        ];

        $logMock = $this->getMock('Octante\NatsBundle\Logger\NatsLogger');

        $sut = new ConnectionFactory($conf, $logMock);
        $connection = $sut->createConnection('test_connection');
        $this->assertInstanceOf('Octante\NatsBundle\Connection\ConnectionWrapper', $connection);
    }

    /**
     * method: createConnection
     * when: calledWithAnInvalidConfigurationKey
     * will:  throwAnException.
     *
     * @expectedException \Octante\NatsBundle\Exceptions\ConnectionNameNotFound
     */
    public function test_createConnection_calledWithAnInvalidConfigurationKey_throwAnException()
    {
        $conf = [
            'dummy_connection' => [
            ],
        ];

        $logMock = $this->getMock('Octante\NatsBundle\Logger\NatsLogger');
        $sut = new ConnectionFactory($conf, $logMock);
        $sut->createConnection('test_connection');
    }

    /**
     * method: createDefaultConnection
     * when: called
     * will:  setADefaultConnectionKey.
     */
    public function test_createDefaultConnection_called_setADefaultConnectionKey()
    {
        $conf = [
            'default_connection' => [
                'host' => 'localhost',
                'port' => 4222,
                'user' => 'user',
                'password' => 'password',
                'verbose' => true,
                'reconnect' => true,
                'version' => '0.0.5',
                'pedantic' => true,
                'lang' => 'php',
            ],
        ];

        $logMock = $this->getMock('Octante\NatsBundle\Logger\NatsLogger');
        $sut = new ConnectionFactory($conf, $logMock);
        $connection = $sut->createDefaultConnection();
        $this->assertInstanceOf('Nats\Connection', $connection);
    }
}
