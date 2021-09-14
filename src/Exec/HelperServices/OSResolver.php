<?php

namespace Constup\PhpPing\Exec\HelperServices;

class OSResolver
{
    const OS_WINDOWS = 'windows';
    const OS_MAC = 'macos';
    const OS_LINUX = 'linux';

    /**
     * @return string
     */
    public function getOS(): string
    {
        if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
            return self::OS_WINDOWS;
        }
        if (strtoupper(PHP_OS) === 'DARWIN') {
            return self::OS_MAC;
        }

        return self::OS_LINUX;
    }
}
