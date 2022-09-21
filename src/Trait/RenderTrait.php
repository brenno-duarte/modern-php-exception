<?php

namespace ModernPHPException\Trait;

use ModernPHPException\Console\MessageTrait;

trait RenderTrait
{
    use MessageTrait;

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
     * @return void
     */
    private function render(): void
    {
        if (ob_get_contents()) {
            ob_end_clean();
        }
        
        if ($this->config['production_mode'] === true) {
            $this->productionMode();
        }

        $this->renderCli();

        if ($this->format == "json" || $this->config['type'] === "json") {
            $this->renderJson();
        }

        if ($this->config['title'] !== "") {
            $this->title = $this->config['title'];
        }

        if ($this->config['dark_mode'] === true) {
            $this->useDarkTheme();
        }

        $main_error = basename($this->main_file, '.php');
        $main_error = strtolower($main_error);

        $assets = $this->loadAssets($this->info_error_exception);

        include_once dirname(__DIR__) . '/View/templates/index.php';
        exit;
    }

    /**
     * @return void
     */
    private function renderJson(): void
    {
        echo "<title>" . $this->getTitle() . "</title>";

        if ($this->type == "error") {
            echo json_encode([$this->getError() => $this->info_error_exception], JSON_UNESCAPED_UNICODE);
        } elseif ($this->type == "exception") {
            if (!empty($this->trace)) {
                echo json_encode([
                    $this->info_error_exception['type_exception'] => $this->info_error_exception,
                    "error" => $this->trace
                ], JSON_UNESCAPED_UNICODE);
            } else {
                echo json_encode([$this->info_error_exception['type_exception'] => $this->info_error_exception], JSON_UNESCAPED_UNICODE);
            }
        }

        exit;
    }

    /**
     * @return void
     */
    private function renderCli(): void
    {
        $verify = $this->isCli();

        if ($verify == true) {
            if (isset($this->info_error_exception['type_exception'])) {
                echo "\n";
                $this->error("[" . $this->info_error_exception['type_exception'] . "] " . $this->info_error_exception['message'])->print()->break(true);
                $this->line("File: " . $this->info_error_exception['file'])->print()->break();
                $this->line("Line: " . $this->info_error_exception['line'])->print()->break(true);
                $this->warning(count($this->trace) . " other error(s)")->print()->break();

                foreach ($this->trace as $trace) {
                    $this->info("Line: " . $trace['line'] . " | File: " . $trace['file'])->print()->break();
                }
            } else {
                echo "\n";
                $this->error("[" . $this->getError() . "] " . $this->info_error_exception['message'])->print()->break(true);
                $this->line("File: " . $this->info_error_exception['file'])->print()->break();
                $this->line("Line: " . $this->info_error_exception['line'])->print()->break();
            }

            exit;
        }
    }
}
