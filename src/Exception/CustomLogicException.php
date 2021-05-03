<?php

namespace ModernPHPException\Exception;

class CustomLogicException extends \LogicException
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
