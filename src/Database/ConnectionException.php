<?php

namespace ModernPHPException\Database;

use ModernPHPException\Resources\HtmlTag;

class ConnectionException extends \Exception
{
    /**
     * @param string $drive
     * 
     * @return void
     * @throws ConnectionException
     */
    public static function driveNotFound(string $drive): void
    {
        throw new ConnectionException("Extension " . $drive . " not installed or not enabled");
    }
}
