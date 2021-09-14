<?php

declare(strict_types = 1);

namespace Constup\PhpPing\Exec;

use Constup\PhpPing\Exec\HelperServices\CommandBuilder;
use Constup\PhpPing\Exec\HelperServices\ResultProcessor;
use Constup\PhpPing\ResultData\BasicResultData;

class PingService
{
    const PACKET_LOSS_TOTAL = '100% loss';
    private CommandBuilder $commandBuilder;
    private ResultProcessor $resultProcessor;

    /**
     * @param CommandBuilder  $commandBuilder
     * @param ResultProcessor $resultProcessor
     */
    public function __construct(CommandBuilder $commandBuilder, ResultProcessor $resultProcessor)
    {
        $this->commandBuilder = $commandBuilder;
        $this->resultProcessor = $resultProcessor;
    }

    /**
     * @return CommandBuilder
     */
    public function getCommandBuilder(): CommandBuilder
    {
        return $this->commandBuilder;
    }

    /**
     * @return ResultProcessor
     */
    public function getResultProcessor(): ResultProcessor
    {
        return $this->resultProcessor;
    }

    /**
     * @param string   $host
     * @param int      $tries
     * @param int|null $ttl
     * @param int|null $timeout
     *
     * @return bool
     */
    public function ping(
        string $host,
        int $tries,
        ?int $ttl,
        ?int $timeout
    ): bool {
        $commandString = $this->getCommandBuilder()->buildCommand($host, $tries, $ttl, $timeout);
        $commandResult = exec($commandString, $output, $resultCode);

        if ($commandResult === false || empty($output) || $resultCode !== 0) {
            return false;
        }

        $packetLoss = $this->getResultProcessor()->extractPacketLossPercentage($output);
        if ($packetLoss === self::PACKET_LOSS_TOTAL) {
            return false;
        }

        return true;
    }

    /**
     * @param string   $host
     * @param int      $tries
     * @param int|null $ttl
     * @param int|null $timeout
     *
     * @return BasicResultData
     */
    public function pingWithErrorDescription(
        string $host,
        int $tries,
        ?int $ttl,
        ?int $timeout
    ): BasicResultData {
        $commandString = $this->getCommandBuilder()->buildCommand($host, $tries, $ttl, $timeout);
        $commandResult = exec($commandString, $output, $resultCode);

        if ($commandResult === false) {
            return new BasicResultData(BasicResultData::STATUS_ERROR, '1', "exec() function failed and returned 'false'.");
        }
        if (empty($output)) {
            return new BasicResultData(BasicResultData::STATUS_ERROR, '2', 'Output of exec() function is empty.');
        }
        if ($resultCode !== 0) {
            return new BasicResultData(BasicResultData::STATUS_ERROR, '3', 'exec() returned non-zero result code: ' . $resultCode . '.');
        }

        $packetLoss = $this->getResultProcessor()->extractPacketLossPercentage($output);
        if ($packetLoss === self::PACKET_LOSS_TOTAL) {
            return new BasicResultData(BasicResultData::STATUS_ERROR, '4', 'Ping returned a 100% packet loss.');
        }

        return new BasicResultData(BasicResultData::STATUS_OK, null, null);
    }
}
