<?php

declare(strict_types = 1);

namespace Constup\PhpPing\Test\Exec\HelperServices\DataProviderTrait;

use Faker\Factory;

trait ResultProcessorTrait
{
    public function extractPacketLossPercentage_HappyFlow(): array
    {
        $faker = Factory::create();
        $faker->seed($faker->randomNumber(5));

        return [
            'One bracket present' => [
                'execOutput' => '
Pinging 8.8.8.8 with 32 bytes of data:
Reply from 8.8.8.8: bytes=32 time=6ms TTL=117
Reply from 8.8.8.8: bytes=32 time=6ms TTL=117
Reply from 8.8.8.8: bytes=32 time=6ms TTL=117

Ping statistics for 8.8.8.8:
    Packets: Sent = 3, Received = 3, Lost = 0 (0% loss),
Approximate round trip times in milli-seconds:
    Minimum = 6ms, Maximum = 6ms, Average = 6ms',
                'expectedResult' => '0% loss',
            ],
            'Multiple brackets present' => [
                'execOutput' => '
Pinging 8.8.8.8 with 32 bytes of data:
Reply from 8.8.8.8: bytes=32 time=6ms TTL=117
Reply from 8.8.8.8: bytes=32 time=6ms TTL=117
Reply from 8.8.8.8: bytes=32 time=6ms TTL=117

Ping statistics for 8.8.8.8:
    Packets: Sent = 3, Received = 3, Lost = 0 (5% loss),
Approximate round trip times in milli-seconds: (another bracket)
    Minimum = 6ms, Maximum = 6ms, Average = 6ms (yet another)',
                'expectedResult' => '5% loss',
            ],
        ];
    }
}
