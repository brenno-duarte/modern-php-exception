<?php

namespace ModernPHPException;

class Debug
{
    /**
     * @var string
     */
    private static string $log_folder = "";

    public static function dirLogger(string $dir_log): void
    {
        self::$log_folder = $dir_log;
        if (!is_dir(self::$log_folder)) mkdir(self::$log_folder);
    }

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
        if (self::$log_folder == "") {
            self::dirLogger(sys_get_temp_dir() . DIRECTORY_SEPARATOR . "ModernPHPExceptionLogs" . DIRECTORY_SEPARATOR);
        }

        $message = "[" . date('Y-m-d H:i:s') . "] " . $message;

        if (!is_null($file)) $message .= " [" . $file . "]";
        if (!is_null($line)) $message .= " (" . $line . ")";

        if (!is_dir(self::$log_folder)) {
            throw new \Exception("Directory " . self::$log_folder . " not exists");
        }
        
        $res = file_put_contents(self::$log_folder . $log_file . ".log", $message . "\n", FILE_APPEND);

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
        $file = self::$log_folder . $log_file . ".log";
        clearstatcache(true, $file);

        if (!file_exists($file)) {
            throw new \InvalidArgumentException("Log file '" . $log_file . ".log' not found");
        }

        $log = file_get_contents($file);
        return $log;
    }
}
