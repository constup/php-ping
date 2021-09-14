<?php

declare(strict_types = 1);

namespace Constup\PhpPing\Test\Exec\HelperServices\DataProviderTrait;

use Constup\PhpPing\Exec\HelperServices\OSResolver;
use Faker\Factory;

trait CommandBuilderDataProviderTrait
{
    public function buildCommand_HappyFlow(): array
    {
        $faker = Factory::create();
        $faker->seed($faker->randomNumber(5));

        return [
            'Happy flow for Windows - all parameters present' => [
                'os' => OSResolver::OS_WINDOWS,
                'host' => $host = $faker->unique()->lexify(),
                'tries' => $tries = $faker->unique->randomNumber(2),
                'ttl' => $ttl =  $faker->unique->randomNumber(2),
                'timeout' => $timeout = $faker->unique->randomNumber(6),
                'expectedResult' => 'ping -n ' . $tries . ' -i ' . $ttl . ' -w ' . ($timeout * 1000) . ' ' . $host,
            ],
            'Happy flow for MacOS - all parameters present' => [
                'os' => OSResolver::OS_MAC,
                'host' => $host = $faker->unique()->lexify(),
                'tries' => $tries = $faker->unique->randomNumber(2),
                'ttl' => $ttl = $faker->unique->randomNumber(2),
                'timeout' => $timeout = $faker->unique->randomNumber(6),
                'expectedResult' => 'ping -n -c ' . $tries . ' -m ' . $ttl . ' -t ' . $timeout . ' ' . $host,
            ],
            'Happy flow for Linux - all parameters present' => [
                'os' => OSResolver::OS_LINUX,
                'host' => $host = $faker->unique()->lexify(),
                'tries' => $tries = $faker->unique->randomNumber(2),
                'ttl' => $ttl = $faker->unique->randomNumber(2),
                'timeout' => $timeout = $faker->unique->randomNumber(6),
                'expectedResult' => 'ping -n -c ' . $tries . ' -t ' . $ttl . ' -W ' . $timeout . ' ' . $host . ' 2>$1',
            ],
            'Happy flow for Windows - manual test' => [
                'os' => OSResolver::OS_WINDOWS,
                'host' => '8.8.8.8',
                'tries' => 3,
                'ttl' => 10,
                'timeout' => 5000,
                'expectedResult' => 'ping -n 3 -i 10 -w 5000000 8.8.8.8',
            ],
            'Happy flow for Mac - manual test' => [
                'os' => OSResolver::OS_MAC,
                'host' => '8.8.8.8',
                'tries' => 3,
                'ttl' => 10,
                'timeout' => 5000,
                'expectedResult' => 'ping -n -c 3 -m 10 -t 5000 8.8.8.8',
            ],
            'Happy flow for Linux - manual test' => [
                'os' => OSResolver::OS_LINUX,
                'host' => '8.8.8.8',
                'tries' => 3,
                'ttl' => 10,
                'timeout' => 5000,
                'expectedResult' => 'ping -n -c 3 -t 10 -W 5000 8.8.8.8 2>$1',
            ]
        ];
    }
}
