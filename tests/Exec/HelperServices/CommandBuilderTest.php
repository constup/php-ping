<?php

declare(strict_types = 1);

namespace Constup\PhpPing\Test\Exec\HelperServices;

use Constup\PhpPing\Exec\HelperServices\CommandBuilder;
use Constup\PhpPing\Exec\HelperServices\OSResolver;
use Constup\PhpPing\Test\Exec\HelperServices\DataProviderTrait\CommandBuilderTrait;
use PHPUnit\Framework\TestCase;

class CommandBuilderTest extends TestCase
{
    use CommandBuilderTrait;

    /**
     * @param string $os
     * @param string $host
     * @param int $tries
     * @param int|null $ttl
     * @param int|null $timeout
     * @param string $expectedResult
     * @dataProvider buildCommand_HappyFlow
     */
    public function testBuildCommand(
        string $os,
        string $host,
        int $tries,
        ?int $ttl,
        ?int $timeout,
        string $expectedResult
    )
    {
        $osResolverMock = $this->getMockBuilder(OSResolver::class)
            ->disableOriginalConstructor()
            ->onlyMethods(['getOS'])
            ->getMock();
        $osResolverMock->method('getOS')->willReturn($os);

        $mock = $this->getMockBuilder(CommandBuilder::class)
            ->disableOriginalConstructor()
            ->onlyMethods(['getOsResolver'])
            ->getMock();
        $mock->method('getOsResolver')->willReturn($osResolverMock);

        $result = $mock->buildCommand($host, $tries, $ttl, $timeout);
        $this->assertEquals($expectedResult, $result);
    }
}
