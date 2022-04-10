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
    protected string $version = "1.1.1";

    /**
     * @var array
     */
    private array $config = [
        "type" => "",
        "title" => "",
        "dark_mode" => "",
        "production_mode" => ""
    ];

    /**
     * Construct
     */
    public function __construct(array $config = [])
    {
        if (!empty($config)) {
            foreach ($config as $key => $value) {
                if (!isset($this->config[$key])) {
                    throw new \Exception("Key '$key' not exists");
                } else {
                    $this->config['type'] = $config['type'] ?? "";
                    $this->config['title'] = $config['title'] ?? "";
                    $this->config['dark_mode'] = $config['dark_mode'] ?? "";
                    $this->config['production_mode'] = $config['production_mode'] ?? "";
                }
            }
        }

        if ($this->config['production_mode'] === true) {
            $this->productionMode();
        }

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
     * @return void
     */
    public function productionMode(): void
    {
        include_once 'Exception/templates/error-production.php';
        exit;
    }
}
