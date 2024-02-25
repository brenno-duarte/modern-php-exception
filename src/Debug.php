<?php

namespace ModernPHPException;

class Debug
{
    /**
     * @var string
     */
    private static string $log_folder = DIRECTORY_SEPARATOR . "log_files" . DIRECTORY_SEPARATOR;

    /**
     * Add a log in a file
     *
     * @param string $message
     * @param string $log_file
     * @param string|null $file
     * @param string|null $line
     * 
     * @return bool
     */
    public static function log(string $message, string $log_file, ?string $file = null, ?string $line = null): bool
    {
        $message = "[" . date('Y-m-d H:i:s') . "] " . $message;

        if (!is_null($file)) {
            $message .= " [" . $file . "]";
        }

        if (!is_null($line)) {
            $message .= " (" . $line . ")";
        }

        $res = file_put_contents(__DIR__ . self::$log_folder . $log_file . ".log", $message . "\n", FILE_APPEND);

        if (is_int($res)) {
            return true;
        }

        return false;
    }

    /**
     * Get all logs in a file
     *
     * @param string $log_file
     * 
     * @return string
     */
    public static function get(string $log_file): string
    {
        $file = __DIR__ . self::$log_folder . $log_file . ".log";
        clearstatcache(true, $file);

        if (!file_exists($file)) {
            throw new \InvalidArgumentException("Log file '" . $log_file . ".log' not found");
        }

        $log = file_get_contents($file);
        return $log;
    }
}
