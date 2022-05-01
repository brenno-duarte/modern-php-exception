<?php

namespace ModernPHPException\Trait;

trait HelpersTrait
{
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

        if (
            empty($_SERVER['REMOTE_ADDR']) and
            !isset($_SERVER['HTTP_USER_AGENT']) and
            count($_SERVER['argv']) > 0
        ) {
            return true;
        }

        return false;
    }

    /**
     * @param string $path
     * 
     * @return string
     */
    public function getPathInfo(string $path): string
    {
        return strtolower(pathinfo($path)['filename']);
    }

    /**
     * @param string $value
     * 
     * @return string
     */
    private function replaceString(string $value): string
    {
        return str_replace(['#', '{', '}', '(', ')', '.'], '', $value);
    }

    /**
     * @param string $value
     * 
     * @return string
     */
    private function replaceUrl(string $value): string
    {
        return str_replace(' ', '+', $value);
    }

    /**
     * @param mixed $classname
     * 
     * @return string
     */
    private function getClassMame($classname): string
    {
        $class = get_class($classname);
        $class = explode("\\", $class);
        $class = end($class);

        return $class;
    }
}
