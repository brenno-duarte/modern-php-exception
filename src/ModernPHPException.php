<?php

namespace ModernPHPException;

use ModernPHPException\Exception\HandlerException;

class ModernPHPException extends HandlerException
{
    /**
     * @var string
     */
    public string $type;

    /**
     * @var array
     */
    public array $files = [];

    /**
     * @var array
     */
    public array $line = [];

    /**
     * @var array
     */
    public array $info_exception = [];

    /**
     * @var string
     */
    public string $main_file;

    /**
     * @return ModernPHPException
     */
    public function start(): ModernPHPException
    {
        set_exception_handler([$this, 'exceptionHandler']);
        set_error_handler([$this, 'errorHandler']);

        return $this;
    }

    /**
     * @param mixed $value
     * 
     * @return ModernPHPException
     */
    private function pre($value): ModernPHPException
    {
        echo '<pre>';
        print_r($value);
        echo '</pre>';

        return $this;
    }
}
