<?php

namespace ModernPHPException\Trait;

use ModernPHPException\Console\MessageTrait;
use ModernPHPException\Solution;

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
                $this->renderSolution();
                $this->line("File: " . $this->info_error_exception['file'])->print()->break();
                $this->line("Line: " . $this->info_error_exception['line'])->print()->break(true);
                $this->getLines($this->info_error_exception['file'], $this->info_error_exception['line']);

                if (!empty($this->trace)) {
                    echo PHP_EOL;
                    $this->warning(count($this->trace) . " other error(s)")->print()->break();
                }

                foreach ($this->trace as $trace) {
                    $this->info("Line: " . $trace['line'] . " | File: " . $trace['file'])->print()->break();
                }
            } else {
                echo "\n";
                $this->error("[" . $this->getError() . "] " . $this->info_error_exception['message'])->print()->break(true);
                $this->line("File: " . $this->info_error_exception['file'])->print()->break();
                $this->line("Line: " . $this->info_error_exception['line'])->print()->break();
                $this->getLines($this->info_error_exception['file'], $this->info_error_exception['line']);
            }

            exit;
        }
    }

    private function getLines(string $context, int $line)
    {
        for ($i = 0; $i < 7; $i++) {
            $lines_up[] = $line + $i;
        }

        for ($i = 0; $i < 7; $i++) {
            $lines_down[] = $line - $i;
        }

        $lines = array_merge($lines_up, $lines_down);
        $lines = array_unique($lines);
        sort($lines);
        $is_resource = false;

        if (is_resource($context)) {
            //Você pode definir um resource ao invés de um "path"
            $fp = $context;
            $is_resource = true;
        } else if (is_file($context)) {
            $fp = fopen($context, 'r');
        } else {
            return false;
        }

        $i = 0;
        $result = [];

        if ($fp) {
            while (false === feof($fp)) {
                ++$i;
                $data = fgets($fp);
                if (in_array($i, $lines)) {
                    $result[$i] = $data;
                }
            }
        }

        //Pega última linha
        if ($i !== 1 && in_array('last', $lines)) {
            $result[] = $data;
        }

        if ($is_resource === true) {
            //Não fecha se for resource, pois pode estar sendo usada em outro lugar
            $fp = null;
        } else {
            fclose($fp);
        }

        $fp = null;

        $this->line("------------------------------------------------------------------------")->print()->break(true);

        foreach ($result as $key => $value) {
            if ($key == $line) {
                $this->warning($key . "| " . $value)->print();
            } else {
                $this->line($key . "| " . $value)->print();
            }
        }

        echo PHP_EOL . PHP_EOL;

        $this->line("------------------------------------------------------------------------")->print()->break();
    }

    /**
     * @return void
     */
    private function renderSolution(): void
    {
        $exception = new $this->info_error_exception['namespace_exception'];

        if (method_exists($exception, "getSolution")) {
            $exception->getSolution();

            $solution = new Solution();

            if (!empty($this->solution->getDescription()) || $this->solution->getDescription() != "") {
                $this->success($solution->getTitle())->print();
                $this->success(": " . $solution->getDescription())->print()->break(true);
            } else {
                $this->success($solution->getTitle())->print()->break(true);
            }
        }
    }

    /**
     * @return void
     */
    public function consoleJS(): void
    {
        if ($this->type == "error") {
            echo "console.error('[" . $this->getError() . "] " . $this->info_error_exception['message'] . "')" . PHP_EOL;
        } elseif ($this->type == "exception") {
            echo "console.error('[" . $this->info_error_exception['type_exception'] . "] " . $this->info_error_exception['message'] . "')" . PHP_EOL;
        }

        echo 'var user = {
            File:"' . addslashes($this->info_error_exception['file']) . '",
            Line:' . $this->info_error_exception['line'] . '
        }
        
        console.table(user)';
    }
}
