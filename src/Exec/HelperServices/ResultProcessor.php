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
        // This will search for the first set of () brackets and extract the contents of it.
        // For now, this is good enough, but if the format of the ping command output changes, this regex needs
        // to be adapted.
        $regex = '/(?<=\().+?(?=\))/m';
        preg_match_all($regex, $execOutput, $matches, PREG_SET_ORDER, 0);

        return $matches[0][0];
    }
}
