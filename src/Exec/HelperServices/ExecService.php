<?php

declare(strict_types = 1);

namespace Constup\PhpPing\Exec\HelperServices;

use Constup\PhpPing\Exec\HelperServices\ResultData\ExecResultData;

class ExecService
{
    /**
     * @param string $command
     *
     * @return ExecResultData
     */
    public function exec(string $command): ExecResultData
    {
        $executionResult = \exec($command, $output, $resultCode);

        return new ExecResultData($executionResult, $output, $resultCode);
    }
}
