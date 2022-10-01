<?php

namespace ModernPHPException;

use ModernPHPException\Solution;
use ModernPHPException\{
    Trait\RenderTrait,
    Trait\HelpersTrait,
    Trait\HandlerAssetsTrait
};

class ModernPHPException
{
    use HelpersTrait;
    use HandlerAssetsTrait;
    use RenderTrait;

    const VERSION = "2.1.0";

    /**
     * @var Bench
     */
    protected Bench $bench;

    /**
     * @var Solution
     */
    private Solution $solution;

    /**
     * @var array
     */
    protected array $files = [];

    /**
     * @var array
     */
    protected array $line = [];

    /**
     * @var string
     */
    protected string $main_file;

    /**
     * @var string
     */
    protected string $format = "";

    /**
     * @var array
     */
    protected array $info_error_exception = [];

    /**
     * @var string
     */
    protected string $type;

    /**
     * @var mixed
     */
    private mixed $error_value = "";

    /**
     * @var array
     */
    protected array $trace = [];

    /**
     * @var string
     */
    private string $file = "";

    /**
     * @var string
     */
    private string $title = "";

    /**
     * @var string
     */
    private string $message_production = "";

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
        http_response_code();

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

        $this->bench = new Bench();
        $this->solution = new Solution();
        $this->bench->start();
    }

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
     * @return ModernPHPException
     */
    public function setFromJson(): ModernPHPException
    {
        $this->format = "json";

        return $this;
    }

    /**
     * @param int $code
     * 
     * @return self
     */
    public function setError(int $code): self
    {
        $this->error_value = match ($code) {
            E_PARSE => 'Parse Error',
            E_ERROR => 'Fatal Error',
            E_CORE_ERROR => 'Core Error',
            E_COMPILE_ERROR => 'Compile Error',
            E_USER_ERROR => 'User Error',
            E_WARNING => 'Warning',
            E_USER_WARNING => 'User Warning',
            E_COMPILE_WARNING => 'Compile Warning',
            E_RECOVERABLE_ERROR => 'Recoverable Warning',
            E_NOTICE => 'Notice',
            E_USER_NOTICE => 'User Notice',
            E_STRICT => 'Strict',
            E_DEPRECATED => 'Deprecated',
            E_USER_DEPRECATED => 'User Deprecated'
        };

        return $this;
    }

    /**
     * @return string
     */
    public function getError(): string
    {
        return $this->error_value;
    }

    /**
     * Get the value of file
     *
     * @return string
     */
    public function getFile(): string
    {
        return $this->file;
    }

    /**
     * Set the value of file
     *
     * @param string  $file
     *
     * @return self
     */
    public function setFile(string $file): self
    {
        $this->file = $file;

        return $this;
    }

    /**
     * Get the value of title
     *
     * @return  string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set the value of title
     *
     * @param  string  $title
     *
     * @return  self
     */
    public function setTitle(string $title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @param int $code
     * @param string $message
     * @param string $file
     * @param int $line
     * 
     * @return void
     */
    public function errorHandler(int $code, string $message, string $file, int $line): void
    {
        $this->info_error_exception = [
            'message' => ($message ?? ''),
            'code' => ($code ?? ''),
            'file' => ($file ?? ''),
            'line' => ($line ?? '')
        ];

        if ($this->getTitle() == "" || empty($this->getTitle())) {
            $this->setTitle("ModernPHPException: " . $message);
        }

        $this->setError($code);
        $this->type = "error";
        $this->main_file = $file;

        $this->bench->end();
        $this->render();
    }

    /**
     * @param mixed $exception
     * 
     * @return self
     */
    public function exceptionHandler(mixed $exception): void
    {
        $this->info_error_exception = [
            'message' => $exception->getMessage(),
            'code' => $exception->getCode(),
            'file' => $exception->getFile(),
            'line' => $exception->getLine(),
            'type_exception' => $this->getClassMame($exception),
            'namespace_exception' => get_class($exception)
        ];

        if ($this->getTitle() == "" || empty($this->getTitle())) {
            $this->setTitle("ModernPHPException: " . $exception->getMessage());
        }

        $this->trace = $exception->getTrace();
        $this->main_file = $exception->getFile();
        $this->type = "exception";

        $this->bench->end();
        $this->render();
    }

    /**
     * @param string $message_production
     * 
     * @return void
     */
    public function productionModeMessage(string $message_production = ""): void
    {
        $this->message_production = $message_production;
    }

    /**
     * @return void
     */
    private function productionMode(): void
    {
        if ($this->isCli() == true) {
            $this->renderCli();
        }

        include_once 'View/templates/error-production.php';
        exit;
    }
}
