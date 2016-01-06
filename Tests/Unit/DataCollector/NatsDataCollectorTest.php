<?php
/*
 * This file is part of the NatsBundle package.
 *
 * (c) Issel Guberna <issel.guberna@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Octante\NatsBundle\Tests\Unit\DataCollector;

use Octante\NatsBundle\DataCollector\NatsDataCollector;

class NatsDataCollectorTest extends \PHPUnit_Framework_TestCase
{
    /**
     * when: collectIsCalled
     * should: returnDataWithCommandsArrayKey
     */
    public function test_collectIsCalled__returnDataWithCommandsArrayKey()
    {
        $natsLoggerMock = $this->getMock('Octante\NatsBundle\Logger\NatsLogger');
        $requestMock = $this->getMock('Symfony\Component\HttpFoundation\Request');
        $responseMock = $this->getMock('Symfony\Component\HttpFoundation\Response');

        $sut = new NatsDataCollector($natsLoggerMock);
        $sut->collect($requestMock, $responseMock);
        $this->assertNull($sut->getCommands());
    }

    /**
     * when: callGetCommandCount
     * with: twoCommands
     * should: returnTwo
     */
    public function test_callGetCommandCount_twoCommands_returnTwo()
    {
        $natsLoggerMock = $this->getMockBuilder('Octante\NatsBundle\Logger\NatsLogger')
            ->disableOriginalConstructor()
            ->getMock();

        $natsLoggerMock->expects($this->once())
            ->method('getCommands')
            ->willReturn(array(1,2));

        $requestMock = $this->getMock('Symfony\Component\HttpFoundation\Request');
        $responseMock = $this->getMock('Symfony\Component\HttpFoundation\Response');

        $sut = new NatsDataCollector($natsLoggerMock);
        $sut->collect($requestMock, $responseMock);
        $this->assertEquals(2, $sut->getCommandCount());
    }

    /**
     * when: callGetErrorCommandsCount
     * with: aLoggerWithAnError
     * should: returnOne
     */
    public function test_callGetErrorCommandsCount_aLoggerWithAnError_returnOne()
    {
        $natsLoggerMock = $this->getMockBuilder('Octante\NatsBundle\Logger\NatsLogger')
            ->disableOriginalConstructor()
            ->getMock();

        $natsLoggerMock->expects($this->once())
            ->method('getCommands')
            ->willReturn(
                array(
                    'commands' => array('error' => null)
                )
            );

        $requestMock = $this->getMock('Symfony\Component\HttpFoundation\Request');
        $responseMock = $this->getMock('Symfony\Component\HttpFoundation\Response');

        $sut = new NatsDataCollector($natsLoggerMock);
        $sut->collect($requestMock, $responseMock);
        $this->assertEquals(1, $sut->getErrorCommandsCount());
    }

    /**
     * when: getTimeIsCalled
     * with: oneCommandInLogger
     * should: returnTime
     */
    public function test_getTimeIsCalled_oneCommandInLogger_returnTime()
    {
        $natsLoggerMock = $this->getMockBuilder('Octante\NatsBundle\Logger\NatsLogger')
            ->disableOriginalConstructor()
            ->getMock();

        $natsLoggerMock->expects($this->once())
            ->method('getCommands')
            ->willReturn(
                array(
                    'commands' => array('executionMS' => 1000)
                )
            );

        $requestMock = $this->getMock('Symfony\Component\HttpFoundation\Request');
        $responseMock = $this->getMock('Symfony\Component\HttpFoundation\Response');

        $sut = new NatsDataCollector($natsLoggerMock);
        $sut->collect($requestMock, $responseMock);
        $this->assertEquals(1000, $sut->getTime());
    }
}
