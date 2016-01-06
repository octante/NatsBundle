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

use Octante\NatsBundle\Connection\ConnectionWrapper;

class ConnectionWrapperTest extends \PHPUnit_Framework_TestCase
{
    /**
     * when: callPingsCount
     * should: callNatsConnectionCallPingsCount
     *
     * @dataProvider methodsDataProvider
     */
    public function test_callPingsCount_callNatsConnectionCallPingsCount($method, $parameters)
    {
        $sut = $this->getSUT($method);
        call_user_func_array(array($sut, $method), $parameters);
    }

    public function methodsDataProvider()
    {
        return array(
            array('pingsCount', array()),
            array('pubsCount', array()),
            array('reconnectsCount', array()),
            array('subscriptionsCount', array()),
            array('getSubscriptions', array()),
            array('isConnected', array()),
            array('connect', array(2)),
            array('ping', array()),
            array('request', array('subject', 'payload', 'callback', 1)),
            array('publish', array('subject', 'payload')),
            array('subscribe', array('subject', function(){})),
            array('unsubscribe', array('sid')),
            array('wait', array(1)),
            array('setStreamTimeout', array(10)),
            array('reconnect', array()),
            array('close', array())
        );
    }

    /**
     * @param $method
     * @return ConnectionWrapper
     */
    private function getSUT($method)
    {
        $connectionMock = $this->getMock('Nats\Connection');
        $loggerMock = $this->getMock('Octante\NatsBundle\Logger\NatsLogger');
        $connectionMock->expects($this->once())
            ->method($method);

        return new ConnectionWrapper($connectionMock, $loggerMock);
    }
}
