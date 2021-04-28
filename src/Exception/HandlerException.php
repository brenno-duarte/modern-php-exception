<?php

namespace ModernPHPException\Exception;

use ModernPHPException\Exception\CustomLogicException;
use ModernPHPException\Exception\CustomRuntimeException;

abstract class HandlerException
{
    /**
     * @var string
     */
    public string $file = "";

    /**
     * @param int $code
     * @param string $message
     * @param string $file
     * @param int $line
     * 
     * @return HandlerException
     */
    public function errorHandler($code, string $message, string $file, $line): HandlerException
    {
        $type = error_get_last();
        $e = new \ErrorException($message, $code, $type, $file, $line);

        if (E_ERROR) {
            $exception = new CustomRuntimeException($message, $code);
            $exception->setLine($line);
            $exception->setFile($file);

            $trace = $exception->getTrace();
            $main_file = $exception->getFile();
            $this->main_file = pathinfo($main_file)['filename'];
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
     * @return HandlerException
     */
    public function exceptionHandler($exception): HandlerException
    {
        $message = $exception->getMessage();
        $code = $exception->getCode();
        $main_file = $exception->getFile();
        $line = $exception->getLine();

        $exception = new CustomLogicException($message, $code);
        $exception->setLine($line);
        $exception->setFile($main_file);

        $this->main_file = pathinfo($main_file)['filename'];
        $this->type = 'exception';

        $this->info_exception = [
            'message' => $message,
            'code' => $code,
            'file' => $main_file,
            'line' => $line
        ];
        
        $this->setFile($main_file);
        $this->render();

        return $this;
    }

    /**
     * @return HandlerException
     */
    private function render(): HandlerException
    {
        if (file_exists($this->getFile())) {
            $this->loadAssets($this->info_exception);

            include_once 'templates/error-page.php';
        }

        return $this;
    }

    /**
     * @param array $line
     * 
     * @return HandlerException
     */
    private function loadAssets(array $info): HandlerException
    {
        print_r('<head>');

        /* Add style CSS */
        print_r('<style>' . file_get_contents('assets/styles/default.css', FILE_USE_INCLUDE_PATH));
        print_r(file_get_contents('assets/styles/code-1.css', FILE_USE_INCLUDE_PATH));

        if (isset($info[0]['function'])) {
            foreach ($info as $info) {
                print_r("\n\n" . '.' . pathinfo($info['file'])['filename'] . ' .hljs-ln-line[data-line-number="' . $info['line'] . '"] { background-color: #FF3030 !important; font-weight: bold; }');
            }
        } else {
            print_r("\n\n" . '.' . pathinfo($info['file'])['filename'] . ' .hljs-ln-line[data-line-number="' . $info['line'] . '"] { background-color: #FF3030 !important; font-weight: bold; }');
        }
        
        print_r('</style>');

        /* Add scripts JS */
        print_r('<script>' . file_get_contents('assets/js/highlight.pack.js', FILE_USE_INCLUDE_PATH));
        print_r(file_get_contents('assets/js/highlightjs-line-numbers.js', FILE_USE_INCLUDE_PATH) . '</script>');
        print_r('<script>hljs.highlightAll(); hljs.initLineNumbersOnLoad();</script>');

        print_r('</head>');

        return $this;
    }

    /**
     * Get the value of file
     *
     * @return  string
     */
    public function getFile()
    {
        return $this->file;
    }

    /**
     * Set the value of file
     *
     * @param  string  $file
     *
     * @return  self
     */
    public function setFile(string $file)
    {
        $this->file = $file;

        return $this;
    }
}
