<?php

namespace ModernPHPException\Trait;

use ModernPHPException\Console\MessageTrait;
use ModernPHPException\Occurrences;
use ModernPHPException\Solution;
use ModernPHPException\Resources\{CpuUsage, HtmlTag, MemoryUsage};

trait RenderTrait
{
    use MessageTrait;
    use HelpersTrait;
    use HandlerAssetsTrait;

    /**
     * @param \Throwable $e
     * @param string $message
     * 
     * @return void
     */
    public static function renderFatalError(\Throwable $e, string $message): void
    {
        $css = 'body {
            font-family: -apple-system, system-ui, BlinkMacSystemFont, "Segoe UI", Roboto, Ubuntu;
        }
        
        .title {
            color: #CD3333;
            font-weight: 700;
            font-size: 25px;
        }
        
        .solution {
            color: #008B00;
            font-weight: 500;
        }';

        $title = HtmlTag::createElement('title')->text('Modern PHP Exception: Fatal Error');
        $style = HtmlTag::createElement('style')->text($css);

        $container = HtmlTag::createElement('body');
        $container->addElement('p')->set('class', 'title')->text('Modern PHP Exception: Fatal Error');
        $container->addElement('h4')->text($e->getMessage());
        $container->addElement('span')->set('class', 'solution')->text('Solution: ');
        $container->addElement('span')->text($message);

        echo $title . PHP_EOL;
        echo $style . PHP_EOL;

        $container = str_replace(">", ">" . PHP_EOL, $container);
        echo $container;
    }

    /**
     * Register an occurrence in database
     * 
     * @return void 
     */
    protected function registerOccurrence(): void
    {
        if ($this->type == 'error') {
            $type_error = $this->getError() . "-Error";
        } elseif ($this->type == 'exception') {
            $type_error = $this->info_error_exception['type_exception'] . "-" . $this->info_error_exception['namespace_exception'];
        }

        Occurrences::enable($this->info_error_exception, $type_error, $this->config['production_mode']);
    }

    /**
     * Render full template with all resources
     * 
     * @return never
     */
    private function render(): never
    {
        if (ob_get_contents()) {
            ob_end_clean();
        }

        $this->renderCli();

        if (
            isset($_SERVER['REQUEST_METHOD']) &&
            $_SERVER['REQUEST_METHOD'] != 'GET' ||
            isset($_SERVER['CONTENT_TYPE']) &&
            $_SERVER['CONTENT_TYPE'] == 'application/json'
        ) {

            $this->renderJson();
        }

        if ($this->config['production_mode'] === true) {
            $this->productionMode();
        }

        // Don't erase `$resources` variable
        $resources = $this->loadResources();
        $main_error = basename($this->main_file, '.php');
        $main_error = strtolower($main_error);

        // Don't erase `$assets` variable
        $assets = $this->loadAssets($this->info_error_exception);

        include_once dirname(__DIR__) . '/View/templates/index.php';
        exit;
    }

    /**
     * Unset trace without 'file' and 'line' keys
     *
     * @param array $trace
     * 
     * @return array
     */
    private function filterTrace(array $trace): array
    {
        foreach ($trace as $key => $value) {
            if (!array_key_exists('file', $value) && !array_key_exists('line', $value)) {
                unset($trace[$key]);
            }
        }

        return $trace;
    }

    /**
     * Load all resources
     * 
     * @return array
     */
    private function loadResources(): array
    {
        if ($this->config['title'] !== "") {
            $this->title = $this->config['title'];
        }

        if ($this->config['dark_mode'] === true) {
            $this->useDarkTheme();
        }

        $list_occurrences = null;
        $cpu_usage = CpuUsage::getServerLoad();
        $memory_usage = (new MemoryUsage())->getUsage();

        if ($this->is_occurrence_enabled == true) {
            $this->registerOccurrence();
            $list_occurrences = Occurrences::listOccurrences();
        }

        return [
            'cpu_usage' => $cpu_usage,
            'memory_usage' => $memory_usage,
            'list_occurrences' => $list_occurrences
        ];
    }

    /**
     * Render JSON exception/error if request method isn't GET
     * 
     * @return never
     */
    private function renderJson(): never
    {
        if ($this->type == "error") {
            echo json_encode([$this->getError() => $this->info_error_exception], JSON_UNESCAPED_UNICODE);
        }

        if ($this->type == "exception") {
            echo json_encode(
                [$this->info_error_exception['type_exception'] => $this->info_error_exception],
                JSON_UNESCAPED_UNICODE
            );
        }

        exit;
    }

    /**
     * Render exception/error in CLI
     * 
     * @return void
     */
    private function renderCli(): void
    {
        if ($this->isCli() === true) {
            echo PHP_EOL;

            if (isset($this->info_error_exception['type_exception'])) {
                $this->error($this->info_error_exception['type_exception'])->print();
            } else {
                $this->error($this->getError())->print();
            }

            $this->line(" : " . $this->info_error_exception['message'])->print()->break(true);
            $this->renderSolutionCli();
            echo "at ";
            $this->warning($this->info_error_exception['file'])->print();
            echo " : ";
            $this->warning($this->info_error_exception['line'])->print()->break(true);
            $this->getLines($this->info_error_exception['file'], $this->info_error_exception['line']);

            if (!empty($this->trace)) {
                echo PHP_EOL;
                $this->warning("Exception Trace")->print()->break(true);
            }

            foreach ($this->trace as $key => $trace) {
                echo $key . "   ";
                $this->info($trace['file'])->print();
                echo " : ";
                $this->info($trace['line'])->print()->break();
            }

            echo PHP_EOL;
            exit;
        }
    }

    /**
     * @param string $context
     * @param int $line
     * 
     * @return self
     */
    private function getLines(string $context, int $line): self
    {
        for ($i = 0; $i < 4; $i++) {
            $lines_up[] = $line + $i;
        }

        for ($i = 0; $i < 4; $i++) {
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

        foreach ($result as $key => $value) {
            if ($key == $line) {
                $this->errorLine(" -> " . $key . "| " . $value)->print()->break();
            } else {
                $this->gray("   " . $key . "| ")->print();
                $this->info($value)->print()->break();
            }
        }

        echo PHP_EOL;
        return $this;
    }

    /**
     * Render solution in CLI
     * 
     * @return void
     */
    private function renderSolutionCli(): void
    {
        if (isset($this->info_error_exception['type_exception'])) {
            $exception = new $this->info_error_exception['namespace_exception']();

            if (method_exists($exception, "getSolution")) {
                $exception->getSolution();

                $solution = new Solution();

                if (!empty($this->solution->getDescription()) || $this->solution->getDescription() != "") {
                    $this->success($solution->getTitle())->print();
                    echo " : ";
                    $this->success($solution->getDescription())->print()->break(true);
                } else {
                    $this->success($solution->getTitle())->print()->break(true);
                }
            }
        }
    }

    /**
     * Render error on console JS
     * 
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
