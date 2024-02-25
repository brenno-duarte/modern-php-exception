<?php

namespace ModernPHPException;

use Symfony\Component\Yaml\Yaml;
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

    public const VERSION = "3.1.0";

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
     * @var bool
     */
    protected bool $is_occurrence_enabled = false;

    /**
     * @var array
     */
    private array $config = [
        'title' => '',
        'dark_mode' => false,
        'production_mode' => false,
        'error_message' => '',
        'enable_cdn_assets' => true
    ];

    /**
     * @var string
     */
    protected static string $path_to_config_file = "";

    /**
     * Construct
     * 
     * @param null|string $config_file
     */
    public function __construct(
        private ?string $config_file = ""
    ) {
        http_response_code();

        $this->setConfigFile($config_file);
        $this->bench = new Bench();
        $this->solution = new Solution();
        $this->bench->start();
    }

    /**
     * @param string $config_file
     * 
     * @return void
     */
    private function setConfigFile(string $config_file): void
    {
        if (file_exists($config_file)) {
            $config = Yaml::parseFile($config_file);
            self::$path_to_config_file = $config_file;
        }

        if (isset($config)) {
            $this->message_production = $config['error_message'] ?? "";
            $this->config['title'] = $config['title'] ?? "";
            $this->config['dark_mode'] = filter_var($config['dark_mode'], FILTER_VALIDATE_BOOLEAN);
            $this->config['production_mode'] = filter_var($config['production_mode'], FILTER_VALIDATE_BOOLEAN);
            $this->config['enable_cdn_assets'] = filter_var($config['enable_cdn_assets'], FILTER_VALIDATE_BOOLEAN);
        }
    }

    /**
     * Start all custom erros and exceptions on PHP application
     * 
     * @return ModernPHPException
     */
    public function start(): ModernPHPException
    {
        set_error_handler([$this, 'errorHandler']);
        set_exception_handler([$this, 'exceptionHandler']);

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
    protected function getFile(): string
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
    protected function setFile(string $file): self
    {
        $this->file = $file;

        return $this;
    }

    /**
     * Get the value of title
     *
     * @return  string
     */
    protected function getTitle()
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
    protected function setTitle(string $title)
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
            'type_exception' => $this->getClassName($exception),
            'namespace_exception' => get_class($exception)
        ];

        if ($this->getTitle() == "" || empty($this->getTitle())) {
            $this->setTitle("ModernPHPException: " . $exception->getMessage());
        }

        $reflection_class = new \ReflectionClass($this->info_error_exception['namespace_exception']);
        $class_name = $reflection_class->newInstanceWithoutConstructor();

        if (method_exists($exception, "getSolution")) {
            $class_name->getSolution();
        }

        $this->trace = $this->filterTrace($exception->getTrace());
        $this->main_file = $exception->getFile();
        $this->type = "exception";

        $this->bench->end();
        $this->render();
    }

    /**
     * @return ModernPHPException
     */
    public function enableOccurrences(): ModernPHPException
    {
        $this->is_occurrence_enabled = true;
        return $this;
    }
}
