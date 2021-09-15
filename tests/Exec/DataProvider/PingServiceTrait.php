<?php

declare(strict_types = 1);

namespace Constup\PhpPing\Test\Exec\DataProvider;

use Constup\PhpPing\Exec\HelperServices\ResultData\ExecResultData;
use Constup\PhpPing\Exec\PingService;
use Faker\Factory;

trait PingServiceTrait
{
    public function ping_HappyFlow(): array
    {
        $faker = Factory::create();
        $faker->seed($faker->randomNumber(5));

        return [
            'Ping success, 0% loss.' => [
                'host' => $host = $faker->unique()->lexify(),
                'tries' => $tries = $faker->unique->randomNumber(2),
                'ttl' => $ttl = $faker->unique->randomNumber(2),
                'timeoutSeconds' => $timeoutSeconds = $faker->unique->randomNumber(6),
                'commandString' => 'ping -n -c ' . $tries . ' -t ' . $ttl . ' -W ' . $timeoutSeconds . ' ' . $host . ' 2>$1',
                'commandResult' => new ExecResultData(
                    $executionResult = '    Minimum = 7ms, Maximum = 8ms, Average = 7ms',
                    $output = [
                        "",
                        "Pinging 8.8.8.8 with 32 bytes of data:",
                        "Reply from 8.8.8.8: bytes=32 time=7ms TTL=117",
                        "Reply from 8.8.8.8: bytes=32 time=8ms TTL=117",
                        "Reply from 8.8.8.8: bytes=32 time=7ms TTL=117",
                        "",
                        "Ping statistics for 8.8.8.8:",
                        "    Packets: Sent = 3, Received = 3, Lost = 0 (0% loss),",
                        "Approximate round trip times in milli-seconds:",
                        "    Minimum = 7ms, Maximum = 8ms, Average = 7ms"
                    ],
                    $resultCode = 0
                ),
                'packetLoss' => '0% loss',
                'expectedResult' => true
            ],
            'exec() command success but ping has 100% packet loss' => [
                'host' => $host = $faker->unique()->lexify(),
                'tries' => $tries = $faker->unique->randomNumber(2),
                'ttl' => $ttl = $faker->unique->randomNumber(2),
                'timeoutSeconds' => $timeoutSeconds = $faker->unique->randomNumber(6),
                'commandString' => 'ping -n -c ' . $tries . ' -t ' . $ttl . ' -W ' . $timeoutSeconds . ' ' . $host . ' 2>$1',
                'commandResult' => new ExecResultData(
                    $executionResult = '    Minimum = 7ms, Maximum = 8ms, Average = 7ms',
                    $output = [
                        "",
                        "Pinging 8.8.8.8 with 32 bytes of data:",
                        "Reply from 8.8.8.8: bytes=32 time=7ms TTL=117",
                        "Reply from 8.8.8.8: bytes=32 time=8ms TTL=117",
                        "Reply from 8.8.8.8: bytes=32 time=7ms TTL=117",
                        "",
                        "Ping statistics for 8.8.8.8:",
                        "    Packets: Sent = 3, Received = 3, Lost = 0 (0% loss),",
                        "Approximate round trip times in milli-seconds:",
                        "    Minimum = 7ms, Maximum = 8ms, Average = 7ms"
                    ],
                    $resultCode = 0
                ),
                'packetLoss' => PingService::PACKET_LOSS_TOTAL,
                'expectedResult' => false
            ]
        ];
    }

    public function ping_FailedExec(): array
    {
        $faker = Factory::create();
        $faker->seed($faker->randomNumber(5));

        return [
            'exec() command failed and returned "false"' => [
                'host' => $host = $faker->unique()->lexify(),
                'tries' => $tries = $faker->unique->randomNumber(2),
                'ttl' => $ttl = $faker->unique->randomNumber(2),
                'timeoutSeconds' => $timeoutSeconds = $faker->unique->randomNumber(6),
                'commandString' => 'ping -n -c ' . $tries . ' -t ' . $ttl . ' -W ' . $timeoutSeconds . ' ' . $host . ' 2>$1',
                'commandResult' => new ExecResultData(
                    $executionResult = false,
                    $output = [
                        "",
                        "Pinging 8.8.8.8 with 32 bytes of data:",
                        "Reply from 8.8.8.8: bytes=32 time=7ms TTL=117",
                        "Reply from 8.8.8.8: bytes=32 time=8ms TTL=117",
                        "Reply from 8.8.8.8: bytes=32 time=7ms TTL=117",
                        "",
                        "Ping statistics for 8.8.8.8:",
                        "    Packets: Sent = 3, Received = 3, Lost = 0 (0% loss),",
                        "Approximate round trip times in milli-seconds:",
                        "    Minimum = 7ms, Maximum = 8ms, Average = 7ms"
                    ],
                    $resultCode = 0
                ),
                'expectedResult' => false
            ],
            'exec() command output is empty' => [
                'host' => $host = $faker->unique()->lexify(),
                'tries' => $tries = $faker->unique->randomNumber(2),
                'ttl' => $ttl = $faker->unique->randomNumber(2),
                'timeoutSeconds' => $timeoutSeconds = $faker->unique->randomNumber(6),
                'commandString' => 'ping -n -c ' . $tries . ' -t ' . $ttl . ' -W ' . $timeoutSeconds . ' ' . $host . ' 2>$1',
                'commandResult' => new ExecResultData(
                    $executionResult = '    Minimum = 7ms, Maximum = 8ms, Average = 7ms',
                    $output = [],
                    $resultCode = 0
                ),
                'expectedResult' => false
            ],
            'exec() returned non-zero result code' => [
                'host' => $host = $faker->unique()->lexify(),
                'tries' => $tries = $faker->unique->randomNumber(2),
                'ttl' => $ttl = $faker->unique->randomNumber(2),
                'timeoutSeconds' => $timeoutSeconds = $faker->unique->randomNumber(6),
                'commandString' => 'ping -n -c ' . $tries . ' -t ' . $ttl . ' -W ' . $timeoutSeconds . ' ' . $host . ' 2>$1',
                'commandResult' => new ExecResultData(
                    $executionResult = '    Minimum = 7ms, Maximum = 8ms, Average = 7ms',
                    $output = [
                        "",
                        "Pinging 8.8.8.8 with 32 bytes of data:",
                        "Reply from 8.8.8.8: bytes=32 time=7ms TTL=117",
                        "Reply from 8.8.8.8: bytes=32 time=8ms TTL=117",
                        "Reply from 8.8.8.8: bytes=32 time=7ms TTL=117",
                        "",
                        "Ping statistics for 8.8.8.8:",
                        "    Packets: Sent = 3, Received = 3, Lost = 0 (0% loss),",
                        "Approximate round trip times in milli-seconds:",
                        "    Minimum = 7ms, Maximum = 8ms, Average = 7ms"
                    ],
                    $resultCode = 1
                ),
                'expectedResult' => false
            ]
        ];
    }
}
