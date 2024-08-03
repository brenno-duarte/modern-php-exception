<?php

namespace ModernPHPException;

use Symfony\Component\Yaml\Yaml;
use ModernPHPException\Trait\{RenderTrait, HelpersTrait, HandlerAssetsTrait};

class ModernPHPException
{
    use HelpersTrait, HandlerAssetsTrait, RenderTrait;

    public const VERSION = "3.3.1";

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
     * @var string
     */
    protected static string $path_to_config_file = "";

    /**
     * @var array
     */
    private static array $config_yaml = [];

    /**
     * @var int
     */
    private int $error_code;

    /**
     * @var array
     */
    private array $ignore_errors = [];

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
     * @return string
     */
    public static function getConfigFile(): string
    {
        return self::$path_to_config_file;
    }

    /**
     * Ignore some errors
     *
     * @param array $errors
     * 
     * @return ModernPHPException
     */
    public function ignoreErrors(array $errors): ModernPHPException
    {
        $this->ignore_errors = $errors;
        return $this;
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
        register_shutdown_function([$this, 'shutdown']);

        return $this;
    }

    /**
     * @param string $config_file
     * 
     * @return void
     */
    private function setConfigFile(string $config_file): void
    {
        if (file_exists($config_file)) {
            self::$config_yaml = Yaml::parseFile($config_file);
            self::$path_to_config_file = $config_file;
        }

        if (!empty(self::$config_yaml)) {
            $this->message_production = self::$config_yaml["error_message"] ?? "";
            $this->config["title"] = self::$config_yaml["title"] ?? "";
            $this->config["dark_mode"] = filter_var(self::$config_yaml["dark_mode"], FILTER_VALIDATE_BOOLEAN);
            $this->config["production_mode"] = filter_var(self::$config_yaml["production_mode"], FILTER_VALIDATE_BOOLEAN);
            $this->config["enable_cdn_assets"] = filter_var(self::$config_yaml["enable_cdn_assets"], FILTER_VALIDATE_BOOLEAN);
        }
    }

    /**
     * Executed after script execution finishes or exit() is called
     * 
     * @return void
     */
    private function shutdown(): void
    {
        if (isset(self::$config_yaml)) {
            if (isset(self::$config_yaml['enable_logs']) && self::$config_yaml['enable_logs'] == true) {
                if (isset(self::$config_yaml['dir_logs']) && self::$config_yaml['dir_logs'] != "") {
                    Debug::dirLogger(self::$config_yaml['dir_logs']);
                }

                if (!empty($this->info_error_exception)) {
                    Debug::log(
                        $this->info_error_exception['message'],
                        'ModernPHPExceptionLogs',
                        $this->info_error_exception['file'],
                        $this->info_error_exception['line']
                    );
                }
            }
        }
    }

    /**
     * Set the error value
     * 
     * @param int $code
     * 
     * @return ModernPHPException
     */
    public function setError(int $code): ModernPHPException
    {
        $this->error_code = $code;
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
     * Get the error value
     * 
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
     * @return ModernPHPException
     */
    protected function setFile(string $file): ModernPHPException
    {
        $this->file = $file;
        return $this;
    }

    /**
     * Get the value of title
     *
     * @return string
     */
    protected function getTitle(): string
    {
        return $this->title;
    }

    /**
     * Set the value of title
     *
     * @param string $title
     *
     * @return ModernPHPException
     */
    protected function setTitle(string $title): ModernPHPException
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
        $message = htmlspecialchars($message);

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

        if (!empty($this->ignore_errors)) {
            if (!is_int(array_search($this->error_code, $this->ignore_errors, true))) $this->render();
        } else {
            $this->render();
        }
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

        if (method_exists($exception, "getSolution")) $class_name->getSolution();

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
