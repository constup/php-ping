<?php

declare(strict_types = 1);

namespace Constup\PhpPing\Exec\HelperServices;

class CommandBuilder
{
    private OSResolver $osResolver;

    /**
     * @param OSResolver $osResolver
     */
    public function __construct(OSResolver $osResolver)
    {
        $this->osResolver = $osResolver;
    }

    /**
     * @return OSResolver
     */
    public function getOsResolver(): OSResolver
    {
        return $this->osResolver;
    }

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
        $os = $this->getOsResolver()->getOS();

        switch ($os) {
            case OSResolver::OS_WINDOWS:
                return $this->buildCommandWindows($host, $tries, $ttl, $timeout);
            case OSResolver::OS_MAC:
                return $this->buildCommandMacOS($host, $tries, $ttl, $timeout);
            default:
                return $this->buildCommandLinux($host, $tries, $ttl, $timeout);
        }
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
        $result = 'ping -n ' . $tries;
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
            $result .= ' -t ' . $timeout;
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
