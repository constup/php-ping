<?php

declare(strict_types = 1);

namespace Constup\PhpPing\Exec\HelperServices;

class CommandBuilder
{
    /**
     * @param string   $host
     * @param int      $tries
     * @param int|null $ttl
     * @param int|null $timeout
     *
     * @return string
     */
    public function buildCommand(
        string $host,
        int $tries,
        ?int $ttl,
        ?int $timeout
    ): string {
        if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
            $result = $this->buildCommandWindows($host, $tries, $ttl, $timeout);
        } elseif (strtoupper(PHP_OS) === 'DARWIN') {
            $result = $this->buildCommandMacOS($host, $tries, $ttl, $timeout);
        } else {
            $result = $this->buildCommandLinux($host, $tries, $ttl, $timeout);
        }

        return $result;
    }

    /**
     * @param string   $host
     * @param int      $tries
     * @param int|null $ttl
     * @param int|null $timeout
     *
     * @return string
     */
    private function buildCommandWindows(
        string $host,
        int $tries,
        ?int $ttl,
        ?int $timeout
    ): string {
        $result = 'ping -n' . $tries;
        if (!is_null($ttl)) {
            $result .= ' -i ' . $ttl;
        }
        if (!is_null($timeout)) {
            $result .= ' -w ' . ($timeout * 1000);
        }

        $result .= ' ' . $host;

        return $result;
    }

    /**
     * @param string   $host
     * @param int      $tries
     * @param int|null $ttl
     * @param int|null $timeout
     *
     * @return string
     */
    private function buildCommandMacOS(
        string $host,
        int $tries,
        ?int $ttl,
        ?int $timeout
    ): string {
        $result = 'ping -n -c ' . $tries;
        if (!is_null($ttl)) {
            $result .= ' -m ' . $ttl;
        }
        if (!is_null($timeout)) {
            $result .= ' -t' . $timeout;
        }

        $result .= ' ' . $host;

        return $result;
    }

    /**
     * @param string   $host
     * @param int      $tries
     * @param int|null $ttl
     * @param int|null $timeout
     *
     * @return string
     */
    private function buildCommandLinux(
        string $host,
        int $tries,
        ?int $ttl,
        ?int $timeout
    ): string {
        $result = 'ping -n -c ' . $tries;
        if (!is_null($ttl)) {
            $result .= ' -t ' . $ttl;
        }
        if (!is_null($timeout)) {
            $result .= ' -W ' . $timeout;
        }

        $result .= ' ' . $host . ' 2>$1';

        return $result;
    }
}
