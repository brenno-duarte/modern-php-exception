<?php

namespace ModernPHPException\Trait;

trait HelpersTrait
{
    /**
     * @return bool
     */
    private function isCli(): bool
    {
        if (defined('STDIN')) return true;
        if (php_sapi_name() === "cli") return true;
        if (PHP_SAPI === 'cli') return true;
        if (stristr(PHP_SAPI, 'cgi') and getenv('TERM')) return true;

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
     * @param object $classname
     * 
     * @return string
     */
    private function getClassName(object $classname): string
    {
        $class = get_class($classname);
        $class = explode("\\", $class);

        return end($class);
    }

    /**
     * @return string
     */
    private static function getUri(): string
    {
        $http = "https://";
        $ssl = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') || $_SERVER['SERVER_PORT'] == 443;

        if ($ssl == false) $http = "http://";
        return $http . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
    }

}
