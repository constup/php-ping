<?php

declare(strict_types = 1);

namespace Constup\PhpPing\Test\Exec;

use Constup\PhpPing\Exec\HelperServices\CommandBuilder;
use Constup\PhpPing\Exec\HelperServices\ExecService;
use Constup\PhpPing\Exec\HelperServices\ResultProcessor;
use Constup\PhpPing\Exec\PingService;
use Constup\PhpPing\Test\Exec\DataProvider\PingServiceTrait;
use PHPUnit\Framework\TestCase;

class PingServiceTest extends TestCase
{
    use PingServiceTrait;

    /**
     * @param string      $host
     * @param int         $tries
     * @param int|null    $ttl
     * @param int|null    $timeout
     * @param string      $commandString
     * @param             $commandResult
     * @param string|null $packetLoss
     * @param bool        $expectedResult
     *
     * @dataProvider ping_HappyFlow
     */
    public function testPing_HappyFlow(
        string $host,
        int $tries,
        ?int $ttl,
        ?int $timeout,
        string $commandString,
        $commandResult,
        ?string $packetLoss,
        bool $expectedResult
    ) {
        $commandBuilderMock = $this->getMockBuilder(CommandBuilder::class)
            ->disableOriginalConstructor()
            ->getMock();
        $commandBuilderMock
            ->expects($this->once())
            ->method('buildCommand')
            ->with($host, $tries, $ttl, $timeout)
            ->willReturn($commandString);

        $execServiceMock = $this->getMockBuilder(ExecService::class)
            ->disableOriginalConstructor()
            ->onlyMethods(['exec'])
            ->getMock();
        $execServiceMock
            ->expects($this->once())
            ->method('exec')
            ->with($commandString)
            ->willReturn($commandResult);

        $resultProcessorMock = $this->getMockBuilder(ResultProcessor::class)
            ->disableOriginalConstructor()
            ->onlyMethods(['extractPacketLossPercentage'])
            ->getMock();
        $extractPacketLossPercentageArgument = implode('', $commandResult->getOutput());
        $resultProcessorMock
            ->expects($this->once())
            ->method('extractPacketLossPercentage')
            ->with($extractPacketLossPercentageArgument)
            ->willReturn($packetLoss);

        $mock = $this->getMockBuilder(PingService::class)
            ->disableOriginalConstructor()
            ->onlyMethods(['getCommandBuilder', 'getResultProcessor', 'getExecService'])
            ->getMock();
        $mock->method('getCommandBuilder')->willReturn($commandBuilderMock);
        $mock->method('getResultProcessor')->willReturn($resultProcessorMock);
        $mock->method('getExecService')->willReturn($execServiceMock);

        $result = $mock->ping($host, $tries, $ttl, $timeout);
        $this->assertEquals($expectedResult, $result);
    }

    /**
     * @param string   $host
     * @param int      $tries
     * @param int|null $ttl
     * @param int|null $timeout
     * @param string   $commandString
     * @param $commandResult
     * @param bool $expectedResult
     *
     * @dataProvider ping_FailedExec
     */
    public function testPing_FailedExec(
        string $host,
        int $tries,
        ?int $ttl,
        ?int $timeout,
        string $commandString,
        $commandResult,
        bool $expectedResult
    ) {
        $commandBuilderMock = $this->getMockBuilder(CommandBuilder::class)
            ->disableOriginalConstructor()
            ->getMock();
        $commandBuilderMock
            ->expects($this->once())
            ->method('buildCommand')
            ->with($host, $tries, $ttl, $timeout)
            ->willReturn($commandString);

        $execServiceMock = $this->getMockBuilder(ExecService::class)
            ->disableOriginalConstructor()
            ->onlyMethods(['exec'])
            ->getMock();
        $execServiceMock
            ->expects($this->once())
            ->method('exec')
            ->with($commandString)
            ->willReturn($commandResult);

        $resultProcessorMock = $this->getMockBuilder(ResultProcessor::class)
            ->disableOriginalConstructor()
            ->getMock();

        $mock = $this->getMockBuilder(PingService::class)
            ->disableOriginalConstructor()
            ->onlyMethods(['getCommandBuilder', 'getResultProcessor', 'getExecService'])
            ->getMock();
        $mock->method('getCommandBuilder')->willReturn($commandBuilderMock);
        $mock->method('getResultProcessor')->willReturn($resultProcessorMock);
        $mock->method('getExecService')->willReturn($execServiceMock);

        $result = $mock->ping($host, $tries, $ttl, $timeout);
        $this->assertEquals($expectedResult, $result);
    }
}
