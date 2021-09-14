<?php

declare(strict_types = 1);

namespace Constup\PhpPing\Fsockopen;

use Constup\PhpPing\ResultData\BasicResultData;

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
     * @return BasicResultData
     */
    public function pingResultWithErrorDescription(
        string $host,
        int $port = 80,
        ?float $timeout = null
    ): BasicResultData {
        $f = @fsockopen($host, $port, $errorCode, $errorMessage, $timeout);

        if ($f === false) {
            $result = new BasicResultData(BasicResultData::STATUS_ERROR, $errorCode, $errorMessage);
        } else {
            $result = new BasicResultData(BasicResultData::STATUS_OK, null, null);
        }

        return $result;
    }
}
