<?php

namespace ModernPHPException\Trait;

trait HelpersTrait
{
    public static function isCli(): bool
    {
        if (defined('STDIN')) return true;
        if (php_sapi_name() === "cli") return true;
        if (PHP_SAPI === 'cli') return true;
        if (stristr(PHP_SAPI, 'cgi') and getenv('TERM')) return true;

        if (
            empty($_SERVER['REMOTE_ADDR']) and
            !isset($_SERVER['HTTP_USER_AGENT']) and
            count((array)$_SERVER['argv']) > 0
        ) {
            return true;
        }

        return false;
    }

    public function getPathInfo(string $path): string
    {
        return strtolower(pathinfo($path)['filename']);
    }

    private function replaceString(string $value): string
    {
        return str_replace(['#', '{', '}', '(', ')', '.'], '', $value);
    }

    private function replaceUrl(string $value): string
    {
        return str_replace(' ', '+', $value);
    }

    private function getClassName(object $classname): string
    {
        $class = get_class($classname);
        $class = explode("\\", $class);
        return end($class);
    }

    private static function getUri(): string
    {
        $http = "https://";
        $ssl = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') || $_SERVER['SERVER_PORT'] == 443;
        if ($ssl == false) $http = "http://";
        return $http . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
    }

    public function htmlSpecialCharsIgnoreCli(string $string): string
    {
        return (!self::isCli()) ? htmlspecialchars($string) : $string;
    }
}
