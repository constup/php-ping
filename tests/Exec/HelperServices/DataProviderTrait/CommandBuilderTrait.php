<?php

declare(strict_types = 1);

namespace Constup\PhpPing\Test\Exec\HelperServices\DataProviderTrait;

use Constup\PhpPing\Exec\HelperServices\OSResolver;
use Faker\Factory;

trait CommandBuilderTrait
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
                'timeoutSeconds' => $timeoutSeconds = $faker->unique->randomNumber(2),
                'expectedResult' => 'ping -n ' . $tries . ' -i ' . $ttl . ' -w ' . ($timeoutSeconds * 1000) . ' ' . $host,
            ],
            'Happy flow for MacOS - all parameters present' => [
                'os' => OSResolver::OS_MAC,
                'host' => $host = $faker->unique()->lexify(),
                'tries' => $tries = $faker->unique->randomNumber(2),
                'ttl' => $ttl = $faker->unique->randomNumber(2),
                'timeoutSeconds' => $timeoutSeconds = $faker->unique->randomNumber(6),
                'expectedResult' => 'ping -n -c ' . $tries . ' -m ' . $ttl . ' -t ' . $timeoutSeconds . ' ' . $host,
            ],
            'Happy flow for Linux - all parameters present' => [
                'os' => OSResolver::OS_LINUX,
                'host' => $host = $faker->unique()->lexify(),
                'tries' => $tries = $faker->unique->randomNumber(2),
                'ttl' => $ttl = $faker->unique->randomNumber(2),
                'timeoutSeconds' => $timeoutSeconds = $faker->unique->randomNumber(6),
                'expectedResult' => 'ping -c ' . $tries . ' -t ' . $ttl . ' -W ' . $timeoutSeconds . ' ' . $host,
            ],
            'Happy flow for Windows - manual test' => [
                'os' => OSResolver::OS_WINDOWS,
                'host' => '8.8.8.8',
                'tries' => 3,
                'ttl' => 10,
                'timeoutSeconds' => 5,
                'expectedResult' => 'ping -n 3 -i 10 -w 5000 8.8.8.8',
            ],
            'Happy flow for Mac - manual test' => [
                'os' => OSResolver::OS_MAC,
                'host' => '8.8.8.8',
                'tries' => 3,
                'ttl' => 10,
                'timeoutSeconds' => 5,
                'expectedResult' => 'ping -n -c 3 -m 10 -t 5 8.8.8.8',
            ],
            'Happy flow for Linux - manual test' => [
                'os' => OSResolver::OS_LINUX,
                'host' => '8.8.8.8',
                'tries' => 3,
                'ttl' => 10,
                'timeoutSeconds' => 5,
                'expectedResult' => 'ping -c 3 -t 10 -W 5 8.8.8.8',
            ]
        ];
    }
}
