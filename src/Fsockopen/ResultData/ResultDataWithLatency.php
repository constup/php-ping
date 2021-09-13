<?php

declare(strict_types = 1);

namespace Constup\PhpPing\Fsockopen\ResultData;

class ResultDataWithLatency
{
    const STATUS_OK = 'ok';
    const STATUS_ERROR = 'error';
    private string $status;
    private ?float $latency;
    private ?string $errorCode;
    private ?string $errorMessage;

    /**
     * @param string      $status
     * @param float|null  $latency
     * @param string|null $errorCode
     * @param string|null $errorMessage
     */
    public function __construct(string $status, ?float $latency, ?string $errorCode, ?string $errorMessage)
    {
        $this->status = $status;
        $this->latency = $latency;
        $this->errorCode = $errorCode;
        $this->errorMessage = $errorMessage;
    }

    /**
     * @return string
     */
    public function getStatus(): string
    {
        return $this->status;
    }

    /**
     * @return float|null
     */
    public function getLatency(): ?float
    {
        return $this->latency;
    }

    /**
     * @return string|null
     */
    public function getErrorCode(): ?string
    {
        return $this->errorCode;
    }

    /**
     * @return string|null
     */
    public function getErrorMessage(): ?string
    {
        return $this->errorMessage;
    }
}
