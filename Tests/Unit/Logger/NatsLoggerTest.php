<?php

/*
 * This file is part of the NatsBundle package.
 *
 * (c) Issel Guberna <issel.guberna@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Octante\NatsBundle\Tests\Unit\Logger;

use Octante\NatsBundle\Logger\NatsLogger;

class NatsLoggerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * when: callLogCommand
     * with: natsMessage
     * should: sendMessageToLogger
     */
    public function test_callLogCommand_natsMessage_sendMessageToLogger()
    {
        $loggerMock = $this->getMockBuilder('Monolog\Logger')
            ->disableOriginalConstructor()
            ->setMethods(array('info'))
            ->getMock();

        $loggerMock->expects($this->once())
            ->method('info')
            ->with('Executing "PUBLISH: test"');

        $msg = 'PUBLISH: test';
        $duration = 0.5;
        $connection = $this->getMockBuilder('Octante\NatsBundle\Connection\ConnectionWrapper')
            ->disableOriginalConstructor();
        $sut = new NatsLogger($loggerMock);
        $sut->logCommand($msg, $duration, $connection);
    }

    /**
     * when: callLogCommand
     * with: natsMessage
     * should: sendErrorToLogger
     */
    public function test_callLogCommand_natsMessage_sendErrorToLogger()
    {
        $loggerMock = $this->getMockBuilder('Monolog\Logger')
            ->disableOriginalConstructor()
            ->setMethods(array('error'))
            ->getMock();

        $loggerMock->expects($this->once())
            ->method('error')
            ->with('Executing "PUBLISH: test" failed (1)');

        $msg = 'PUBLISH: test';
        $duration = 0.5;
        $connection = $this->getMockBuilder('Octante\NatsBundle\Connection\ConnectionWrapper')
            ->disableOriginalConstructor();
        $sut = new NatsLogger($loggerMock);
        $sut->logCommand($msg, $duration, $connection, true);
    }

    /**
     * when: callGetNbCommand
     * with: callingTwoCommands
     * should: returnValueTwo
     */
    public function test_callGetNbCommand_callingTwoCommands_returnValueTwo()
    {
        $loggerMock = $this->getMockBuilder('Monolog\Logger')
        ->disableOriginalConstructor()
        ->getMock();

        $msg = 'PUBLISH: test';
        $duration = 0.5;
        $connection = $this->getMockBuilder('Octante\NatsBundle\Connection\ConnectionWrapper')
            ->disableOriginalConstructor();
        $sut = new NatsLogger($loggerMock);
        $sut->logCommand($msg, $duration, $connection, false);
        $sut->logCommand($msg, $duration, $connection, false);

        $this->assertEquals(2, $sut->getNbCommands());
    }
}
