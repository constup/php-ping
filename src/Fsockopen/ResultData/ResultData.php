<?php

declare(strict_types = 1);

namespace Constup\PhpPing\Fsockopen\ResultData;

class ResultData
{
    const STATUS_OK = 'ok';
    const STATUS_ERROR = 'error';

    private string $status;
    private ?string $errorCode;
    private ?string $errorMessage;

    /**
     * @param string      $status
     * @param string|null $errorNumber
     * @param string|null $errorMessage
     */
    public function __construct(string $status, ?string $errorNumber, ?string $errorMessage)
    {
        $this->status = $status;
        $this->errorCode = $errorNumber;
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
