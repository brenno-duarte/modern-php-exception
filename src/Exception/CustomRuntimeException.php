<?php

namespace ModernPHPException\Exception;

class CustomRuntimeException extends \RuntimeException
{
    /**
     * @param int $line
     */
    public function setLine(int $line)
    {
        $this->line = $line;
    }

    /**
     * @param string $file
     */
    public function setFile(string $file)
    {
        $this->file = $file;
    }
}