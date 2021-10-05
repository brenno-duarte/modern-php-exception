<?php

namespace ModernPHPException\Exception;

use ModernPHPException\Exception\CustomLogicException;
use ModernPHPException\Exception\CustomRuntimeException;

trait HandlerExceptionTrait
{
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
    private string $theme_code = "code-2";

    /**
     * @var string
     */
    private string $theme = "light";

    /**
     * @var string
     */
    private string $color_alert = "FFD700";

    /**
     * @var array
     */
    private array $indicesServer = [
        'PHP_SELF',
        'argv',
        'argc',
        'GATEWAY_INTERFACE',
        'SERVER_ADDR',
        'SERVER_NAME',
        'SERVER_SOFTWARE',
        'SERVER_PROTOCOL',
        'REQUEST_METHOD',
        'REQUEST_TIME',
        'REQUEST_TIME_FLOAT',
        'QUERY_STRING',
        'DOCUMENT_ROOT',
        'HTTP_ACCEPT',
        'HTTP_ACCEPT_CHARSET',
        'HTTP_ACCEPT_ENCODING',
        'HTTP_ACCEPT_LANGUAGE',
        'HTTP_CONNECTION',
        'HTTP_HOST',
        'HTTP_REFERER',
        'HTTP_USER_AGENT',
        'HTTPS',
        'REMOTE_ADDR',
        'REMOTE_HOST',
        'REMOTE_PORT',
        'REMOTE_USER',
        'REDIRECT_REMOTE_USER',
        'SCRIPT_FILENAME',
        'SERVER_ADMIN',
        'SERVER_PORT',
        'SERVER_SIGNATURE',
        'PATH_TRANSLATED',
        'SCRIPT_NAME',
        'REQUEST_URI',
        'PHP_AUTH_DIGEST',
        'PHP_AUTH_USER',
        'PHP_AUTH_PW',
        'AUTH_TYPE',
        'PATH_INFO',
        'ORIG_PATH_INFO'
    ];

    /**
     * @param int $code
     * @param string $message
     * @param string $file
     * @param int $line
     * 
     * @return self
     */
    public function errorHandler($code, string $message, string $file, $line): self
    {
        $type = error_get_last();
        $e = new \ErrorException($message, $code, $type, $file, $line);

        if (E_ERROR) {
            $exception = new CustomRuntimeException($message, $code);
            $exception->setLine($line);
            $exception->setFile($file);

            $trace = $exception->getTrace();
            $main_file = $exception->getFile();

            $this->type = 'error';

            foreach ($trace as $trace) {
                $this->info_exception[] = [
                    'message' => ($trace['args'][1] ?? ''),
                    'code' => ($trace['args'][0] ?? ''),
                    'file' => ($trace['file'] ?? ''),
                    'line' => ($trace['line'] ?? ''),
                    'function' => $trace['function']
                ];
            }

            $this->main_file = pathinfo($main_file)['filename'] . str_replace(['#', '{', '}', '(', ')'], '', $this->info_exception[0]['function']);

            if ($this->getTitle() == "" || empty($this->getTitle())) {
                $this->setTitle("ModernPHPException: " . $message);
            }

            $this->setFile($file);
            $this->render();

            return $this;
        } else {
            $this->exceptionHandler($e);
        }
    }

    /**
     * @param mixed $exception
     * 
     * @return self
     */
    public function exceptionHandler($exception): self
    {
        $message = $exception->getMessage();
        $code = $exception->getCode();
        $main_file = $exception->getFile();
        $line = $exception->getLine();

        $custom_exception = new CustomLogicException($message, $code);
        $custom_exception->setLine($line);
        $custom_exception->setFile($main_file);

        $this->main_file = pathinfo($main_file)['filename'];
        $this->type = 'exception';

        $this->info_exception = [
            'message' => $message,
            'code' => $code,
            'file' => $main_file,
            'line' => $line,
            'type_exc' => get_class($exception)
        ];

        if ($this->getTitle() == "" || empty($this->getTitle())) {
            $this->setTitle("ModernPHPException: " . $message);
        }

        $this->setFile($main_file);
        $this->render();

        return $this;
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
     * @return self
     */
    public function useCodeDark(): self
    {
        $this->theme_code = "code-1";
        $this->color_alert = "FF3030";

        return $this;
    }

    /**
     * @return self
     */
    public function useCodeLight(): self
    {
        $this->theme_code = "code-2";

        return $this;
    }

    /**
     * @return self
     */
    public function useDarkTheme(): self
    {
        $this->theme = "dark";

        return $this;
    }

    /**
     * Get the value of theme_code
     *
     * @return string
     */
    private function getTheme(string $theme_code = null): string
    {
        if ($theme_code != null) {
            return $theme_code;
        }

        return $this->theme_code;
    }

    /**
     * @return self
     */
    private function render(): self
    {
        if (file_exists($this->getFile())) {

            $this->renderCli();

            if ($this->format == "json") {
                $this->renderJson();

                return $this;
            }

            $this->loadAssets($this->info_exception, true);
            include_once 'templates/error-page.php';
        }

        return $this;
    }

    /**
     * @return self
     */
    private function renderJson(): self
    {
        echo json_encode(["error" => $this->info_exception], JSON_UNESCAPED_UNICODE);

        return $this;
    }

    /**
     * @return self
     */
    private function renderCli(): self
    {
        $verify = $this->isCli();
        $array = $this->info_exception;

        if ($verify == true) {
            if (count($array) == count($array, COUNT_RECURSIVE)) {
                echo "\n\nMessage: " . $this->info_exception['message'] . "\n";
                echo "File: " . $this->info_exception['file'] . "\n";
                echo "Line: " . $this->info_exception['line'] . "\n";
            } else {
                foreach ($array as $exception) {
                    echo "\nMessage: " . $exception['message'] . "\n";
                    echo "File: " . $exception['file'] . "\n";
                    echo "Line: " . $exception['line'] . "\n";
                    echo "\n";
                }
            }

            exit;
        }

        return $this;
    }

    /**
     * @param array $line
     * 
     * @return self
     */
    private function loadAssets(array $info, $show = false): self
    {
        print_r('<head>');

        $this->loadCss($info, $show);
        $this->loadJs($show);

        print_r('</head>');

        return $this;
    }

    /**
     * @return bool
     */
    private function isCli(): bool
    {
        if (defined('STDIN')) {
            return true;
        }

        if (php_sapi_name() === "cli") {
            return true;
        }

        if (PHP_SAPI === 'cli') {
            return true;
        }

        if (stristr(PHP_SAPI, 'cgi') and getenv('TERM')) {
            return true;
        }

        if (empty($_SERVER['REMOTE_ADDR']) and !isset($_SERVER['HTTP_USER_AGENT']) and count($_SERVER['argv']) > 0) {
            return true;
        }

        return false;
    }

    /**
     * @return self
     */
    private function loadJs(bool $show = false): self
    {
        if ($show == true) {
            /* Add scripts JS */
            print_r('<script>' . file_get_contents('assets/js/highlight.pack.js', FILE_USE_INCLUDE_PATH));
            print_r(file_get_contents('assets/js/highlightjs-line-numbers.js', FILE_USE_INCLUDE_PATH) . '</script>');
            print_r('<script>hljs.highlightAll(); hljs.initLineNumbersOnLoad();</script>');
        }

        return $this;
    }

    /**
     * @param array $info
     * 
     * @return self
     */
    private function loadCss(array $info, bool $show = false): self
    {
        if ($show == true) {
            if ($this->theme == "dark") {
                $this->theme_code = "code-1";
                $this->color_alert = "FF3030";
            }

            /* Add style CSS */
            print_r('<style>' . file_get_contents('assets/styles/default.css', FILE_USE_INCLUDE_PATH));
            print_r(file_get_contents("assets/styles/{$this->getTheme()}.css", FILE_USE_INCLUDE_PATH));

            if (isset($info[0]['function'])) {
                foreach ($info as $info) {
                    print_r("\n\n" . '.' . strtolower(pathinfo($info['file'])['filename'] . str_replace(['#', '{', '}', '(', ')'], '', $info['function'])) . ' .hljs-ln-line[data-line-number="' . $info['line'] . '"] { background-color: #' . $this->color_alert . ' !important; font-weight: bold; }');
                }
            } else {
                print_r("\n\n" . '.' . pathinfo($info['file'])['filename'] . ' .hljs-ln-line[data-line-number="' . $info['line'] . '"] { background-color: #' . $this->color_alert . ' !important; font-weight: bold; }');
            }

            print_r(file_get_contents("assets/styles/{$this->theme}.css", FILE_USE_INCLUDE_PATH));
            print_r('</style>');
        }

        return $this;
    }
}
