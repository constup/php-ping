<?php

declare(strict_types = 1);

namespace Constup\PhpPing\Test\Exec\HelperServices;

use Constup\PhpPing\Exec\HelperServices\ResultProcessor;
use Constup\PhpPing\Test\Exec\HelperServices\DataProviderTrait\ResultProcessorTrait;
use PHPUnit\Framework\TestCase;

class ResultProcessorTest extends TestCase
{
    use ResultProcessorTrait;

    /**
     * @param string $execOutput
     * @param string $expectedResult
     *
     * @dataProvider extractPacketLossPercentage_HappyFlow
     */
    public function testExtractPacketLossPercentage(
        string $execOutput,
        string $expectedResult
    ) {
        $mock = $this->getMockBuilder(ResultProcessor::class)
            ->disableOriginalConstructor()
            ->onlyMethods([])
            ->getMock();

        $result = $mock->extractPacketLossPercentage($execOutput);
        $this->assertEquals($result, $expectedResult);
    }
}
