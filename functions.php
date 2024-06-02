<?php

use ModernPHPException\Console\CliMessage;
use ModernPHPException\Resources\BrowserDump;
use ModernPHPException\Resources\CliDump;

if (!function_exists('get_debug_backtrace')) {
    /**
     * An easy function to pull all details of the debug backtrace
     * 
     * @return string
     */
    function get_debug_backtrace(): string
    {
        $dbgTrace = debug_backtrace();
        $dbgMsg = '';
        $dbgMsg .= "\nDebug backtrace begin:\n\n";

        foreach ($dbgTrace as $dbgIndex => $dbgInfo) {
            $dbgMsg .= "    at $dbgIndex  " . $dbgInfo['file'] . " (line " . $dbgInfo['line'] . ") -> " . $dbgInfo['function'] . "(" . join(",", $dbgInfo['args']) . ")\n";
        }

        $dbgMsg .= "\nDebug backtrace end\n";
        return $dbgMsg;
    }
}

if (!function_exists('var_dump_buffer')) {
    /**
     * Function to returns the value of `var_dump()` instead of outputting it
     *
     * @param mixed $value
     * 
     * @return string|false
     */
    function var_dump_buffer(mixed $value): string|false
    {
        ob_start();
        var_dump($value);
        $content = ob_get_contents();
        ob_end_clean();
        return $content;
    }
}

if (!function_exists('var_dump_debug')) {
    /**
     * PHP function to replace var_dump(), print_r() based on the XDebug style
     *
     * @param mixed $value
     * 
     * @return void
     */
    function var_dump_debug(...$values): void
    {
        foreach ($values[0] as $value) {
            if (isCli() == true) {
                CliDump::set('string', ['0000FF', 'light_blue']);
                new CliDump($value);

                if (!CliMessage::colorIsSupported() || !CliMessage::are256ColorsSupported()) {
                    CliDump::safe($value);
                }
            } else {
                $dump = new BrowserDump();
                echo $dump->dump($value);
            }
        }
    }
}

if (!function_exists('dump_die')) {
    /**
     * Dump PHP value and die script
     *
     * @param mixed $value
     * 
     * @return void
     */
    function dump_die(...$values): void
    {
        var_dump_debug($values);
        exit;
    }
}

if (!function_exists('closure_dump')) {
    /**
     * View a PHP Closure's Source
     *
     * @param \Closure $c
     * 
     * @return string
     */
    function closure_dump(\Closure $c): string
    {
        $str = 'function (';
        $r = new \ReflectionFunction($c);
        $params = [];

        foreach ($r->getParameters() as $p) {
            $s = '';

            if ($p->getType() && $p->getType()->getName() === 'array') {
                $s .= 'array ';
            } else if (getClass($p)) {
                $s .= getClass($p)->name . ' ';
            }

            if ($p->isPassedByReference()) {
                $s .= '&';
            }

            $s .= '$' . $p->name;

            if ($p->isOptional()) {
                $s .= ' = ' . var_export($p->getDefaultValue(), TRUE);
            }

            $params[] = $s;
        }

        $str .= implode(', ', $params);
        $str .= ') {' . PHP_EOL;
        $lines = file($r->getFileName());

        for ($l = $r->getStartLine(); $l < $r->getEndLine(); $l++) {
            $str .= $lines[$l];
        }

        return $str;
    }
}

if (!function_exists('getClass')) {
    /**
     * Get parameter class
     * @param \ReflectionParameter $parameter
     * @return \ReflectionClass|null
     */
    function getClass(\ReflectionParameter $parameter): ?\ReflectionClass
    {
        $type = $parameter->getType();

        if (!$type || $type->isBuiltin()) {
            return null;
        }

        // This line triggers autoloader!
        if (!class_exists($type->getName())) {
            return null;
        }

        return new \ReflectionClass($type->getName());
    }
}

if (!function_exists('isCli')) {
    function isCli(): bool
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
}
