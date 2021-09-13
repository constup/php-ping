<?php

declare(strict_types = 1);

namespace Constup\PhpPing\Fsockopen;

use Constup\PhpPing\Fsockopen\ResultData\ResultData;
use Constup\PhpPing\Fsockopen\ResultData\ResultDataWithLatency;

class PingService
{
    /**
     * @param string     $host
     * @param int        $port
     * @param float|null $timeout
     *
     * @return bool
     */
    public function ping(
        string $host,
        int $port = 80,
        ?float $timeout = null
    ): bool {
        $f = @fsockopen($host, $port, $errorCode, $errorMessage, $timeout);

        return ($f !== false);
    }

    /**
     * @param string     $host
     * @param int        $port
     * @param float|null $timeout
     *
     * @return ResultData
     */
    public function pingResultWithErrorDescription(
        string $host,
        int $port = 80,
        ?float $timeout = null
    ): ResultData {
        $f = @fsockopen($host, $port, $errorCode, $errorMessage, $timeout);

        if ($f === false) {
            $result = new ResultData(ResultData::STATUS_ERROR, $errorCode, $errorMessage);
        } else {
            $result = new ResultData(ResultData::STATUS_OK, null, null);
        }

        return $result;
    }

    /**
     * @param string     $host
     * @param int        $port
     * @param float|null $timeout
     *
     * @return ResultDataWithLatency
     */
    public function pingResultWithLatency(
        string $host,
        int $port = 80,
        ?float $timeout = null
    ): ResultDataWithLatency {
        $start = microtime(true);
        $f = @fsockopen($host, $port, $errorCode, $errorMessage, $timeout);

        if ($f === false) {
            $result = new ResultDataWithLatency(ResultDataWithLatency::STATUS_ERROR, null, $errorCode, $errorMessage);
        } else {
            $latency = microtime(true) - $start;
            $latency = round($latency * 1000, 4);

            $result = new ResultDataWithLatency(ResultDataWithLatency::STATUS_OK, $latency, null, null);
        }

        return $result;
    }
}
