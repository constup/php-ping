<?php

declare(strict_types = 1);

namespace Constup\PhpPing\Exec\HelperServices\ResultData;

class ExecResultData
{
    private $executionResult;
    private ?array $output;
    private ?int $resultCode;

    /**
     * @param $executionResult
     * @param array|null $output
     * @param int|null   $resultCode
     */
    public function __construct($executionResult, ?array $output, ?int $resultCode)
    {
        $this->executionResult = $executionResult;
        $this->output = $output;
        $this->resultCode = $resultCode;
    }

    /**
     * @return mixed
     */
    public function getExecutionResult()
    {
        return $this->executionResult;
    }

    /**
     * @return array|null
     */
    public function getOutput(): ?array
    {
        return $this->output;
    }

    /**
     * @return int|null
     */
    public function getResultCode(): ?int
    {
        return $this->resultCode;
    }
}
