<?php

namespace ModernPHPException\Console;

class CliMessage
{
    /**
     * @var string
     */
    protected static string $message;

    /**
     * @var mixed|null
     */
    protected static mixed $color_reset = null;

    /**
     * @var mixed|null
     */
    protected static mixed $color_success = null;

    /**
     * @var mixed|null
     */
    protected static mixed $color_info = null;

    /**
     * @var mixed|null
     */
    protected static mixed $color_warning = null;

    /**
     * @var mixed|null
     */
    protected static mixed $color_error = null;

    /**
     * @var mixed|null
     */
    protected static mixed $color_error_line = null;

    /**
     * @var mixed|null
     */
    protected static mixed $color_line = null;

    /**
     * @var mixed|null
     */
    protected static mixed $color_gray = null;

    /**
     * Get the value of message
     *
     * @return string
     */
    public function getMessage(): string
    {
        return self::$message;
    }

    /**
     * Print a single message on CLI
     * 
     * @param string $message
     * 
     * @return self
     */
    public function printMessage(mixed $message): self
    {
        self::$message = $message;
        echo self::$message;

        return $this;
    }

    /**
     * Create a success message
     * 
     * @param mixed $message
     * @param bool $space
     * 
     * @return static 
     */
    public static function success(mixed $message, bool $space = false): static
    {
        self::generateColors();
        self::$message = self::prepareMessage($message, self::$color_success, $space);
        return new static;
    }

    /**
     * Create a info message
     *
     * @param mixed $message
     * @param bool $space
     * 
     * @return static 
     */
    public static function info(mixed $message, bool $space = false): static
    {
        self::generateColors();
        self::$message = self::prepareMessage($message, self::$color_info, $space);
        return new static;
    }

    /**
     * Create a warning message
     *
     * @param mixed $message
     * @param bool $space
     * 
     * @return static 
     */
    public static function warning(mixed $message, bool $space = false): static
    {
        self::generateColors();
        self::$message = self::prepareMessage($message, self::$color_warning, $space);
        return new static;
    }

    /**
     * Create a error message
     *
     * @param mixed $message
     * @param bool $space
     * 
     * @return static 
     */
    public static function error(mixed $message, bool $space = false): static
    {
        self::generateColors();
        self::$message = self::prepareMessage($message, self::$color_error, $space);
        return new static;
    }

    /**
     * Create a error message
     *
     * @param mixed $message
     * @param bool $space
     * 
     * @return static 
     */
    public static function errorLine(mixed $message, bool $space = false): static
    {
        self::generateColors();
        self::$message = self::prepareMessage($message, self::$color_error_line, $space);
        return new static;
    }

    /**
     * Create a normal message
     * 
     * @param mixed $message
     * @param bool $space
     * 
     * @return static 
     */
    public static function line(mixed $message, bool $space = false): static
    {
        self::generateColors();
        self::$message = self::prepareMessage($message, self::$color_line, $space);
        return new static;
    }

    /**
     * Prepare message
     *
     * @param mixed $message
     * @param mixed $color
     * @param bool $space
     * 
     * @return string
     */
    private static function prepareMessage(mixed $message, mixed $color, bool $space = false): string
    {
        $space_line = "";

        if ($space == true) {
            $space_line = "  ";
        }

        $message = $space_line . $color . $message . self::$color_reset;
        return $message;
    }

    /**
     * Write message on CLI
     * 
     * @return self
     */
    public function print(): self
    {
        echo self::$message;
        return $this;
    }

    /**
     * Break a line
     * 
     * @param bool $repeat Break another line
     * 
     * @return self
     */
    public function break(bool $repeat = false): self
    {
        if ($repeat == true) {
            echo PHP_EOL . PHP_EOL;
        } else {
            echo PHP_EOL;
        }

        return $this;
    }

    /**
     * Call `exit()` function
     * 
     * @return never
     */
    public function exit(): never
    {
        exit;
    }

    /**
     * @return void
     */
    private static function generateColors(): void
    {
        if (self::colorIsSupported() || self::are256ColorsSupported()) {
            self::$color_reset = "\e[0m";
            self::$color_success = "\033[92m";
            self::$color_info = "\033[96m";
            self::$color_warning = "\033[93m";
            self::$color_error = "\033[41m";
            self::$color_error_line = "\033[1;31m";
            self::$color_line = "\033[97m";
            self::$color_gray = "\033[0;90m";
        }
    }

    /**
     * @return bool
     */
    public static function colorIsSupported(): bool
    {
        if (DIRECTORY_SEPARATOR === '\\') {
            if (function_exists('sapi_windows_vt100_support') && @sapi_windows_vt100_support(STDOUT)) {
                return true;
            } elseif (getenv('ANSICON') !== false || getenv('ConEmuANSI') === 'ON') {
                return true;
            }
            return false;
        } else {
            return function_exists('posix_isatty') && @posix_isatty(STDOUT);
        }
    }

    /**
     * @return bool
     */
    public static function are256ColorsSupported(): bool
    {
        if (DIRECTORY_SEPARATOR === '\\') {
            return function_exists('sapi_windows_vt100_support') && @sapi_windows_vt100_support(STDOUT);
        } else {
            return str_starts_with(getenv('TERM'), '256color');
        }
    }
}
