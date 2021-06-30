<?php

namespace ModernPHPException;

use ModernPHPException\Exception\HandlerExceptionTrait;

class ModernPHPException
{
    use HandlerExceptionTrait;

    /**
     * @var string
     */
    protected string $type;

    /**
     * @var array
     */
    protected array $files = [];

    /**
     * @var array
     */
    protected array $line = [];

    /**
     * @var array
     */
    protected array $info_exception = [];

    /**
     * @var string
     */
    protected string $main_file;

    /**
     * @var string
     */
    protected string $format = "";

    /**
     * @var Bench
     */
    protected Bench $bench;

    /**
     * @var string
     */
    protected string $version = "0.4.0";

    /**
     * Construct
     */
    public function __construct()
    {
        $this->bench = new Bench();
        $this->bench->start();
    }

    /**
     * @return ModernPHPException
     */
    public function start(): ModernPHPException
    {
        set_exception_handler([$this, 'exceptionHandler']);
        set_error_handler([$this, 'errorHandler']);

        $this->bench->end();

        return $this;
    }

    /**
     * @return ModernPHPException
     */
    public function setFromJson(): ModernPHPException
    {
        $this->format = "json";

        return $this;
    }

    /**
     * @return ModernPHPException
     */
    public function productionMode(): ModernPHPException
    {
        $this->format = "production";

        return $this;
    }
}
