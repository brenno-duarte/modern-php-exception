<?php

namespace ModernPHPException\Trait;

use ModernPHPException\Console\MessageTrait;
use ModernPHPException\Occurrences;
use ModernPHPException\Resources\{CpuUsage, HtmlTag, MemoryUsage};
use ModernPHPException\Solution;
use function Termwind\{render};

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

        $resources = $this->loadResources();
        $main_error = basename($this->main_file, '.php');
        $main_error = strtolower($main_error);

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
    private function renderText(): void
    {
        include_once dirname(__DIR__) . '/View/templates/text-error.php';
        exit;
    }

    /**
     * @return void
     */
    private function renderCli(): void
    {
        $verify = $this->isCli();

        if ($verify == true) {
            echo PHP_EOL;

            if (isset($this->info_error_exception['type_exception'])) {
                $this->error($this->info_error_exception['type_exception'])->print();
            } else {
                $this->error($this->getError())->print();
            }

            $this->line(" : " . $this->info_error_exception['message'])->print()->break(true);
            $this->renderSolution();
            echo "at ";
            $this->warning($this->info_error_exception['file'])->print();
            echo " : ";
            $this->warning($this->info_error_exception['line'])->print()->break(true);

            $res = $this->getLines($this->info_error_exception['file'], $this->info_error_exception['line']);
            $line = $this->info_error_exception['line'];
            $start_line = (int)$this->info_error_exception['line'] - 2;

            /* $code = '<code class="text-white" line="' . $line . '" start-line="' . $start_line . '">';
            $code .= $res;
            $code .= '</code>'; */

            render('<code class="text-white" line="' . $line . '" start-line="' . $start_line . '">' . $res . '</code>');

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
     * @return string
     */
    private function getLines(string $context, int $line): string
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
        $render = '';

        foreach ($result as $value) {
            $render .= $value;
        }

        return $render;
    }

    /**
     * @return void
     */
    private function renderSolution(): void
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
}
