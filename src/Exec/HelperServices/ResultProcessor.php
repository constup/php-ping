<?php

declare(strict_types = 1);

namespace Constup\PhpPing\Exec\HelperServices;

class ResultProcessor
{
    /**
     * @param string $execOutput
     *
     * @return string
     */
    public function extractPacketLossPercentage(string $execOutput): string
    {
        $regex = '/\((.*?)\)/m';
        preg_match_all($regex, $execOutput, $matches, PREG_SET_ORDER, 0);

        return $matches[0];
    }
}
