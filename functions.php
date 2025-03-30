<?php

use ModernPHPException\Console\CliMessage;
use ModernPHPException\ModernPHPException;
use ModernPHPException\Resources\{BrowserDump, CliDump};

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
        $dbgMsg .= "\n\e[38;5;39mDebug backtrace begin:\e[0m\n\n";

        foreach ($dbgTrace as $dbgIndex => $dbgInfo) {
            $dbgMsg .= "    at $dbgIndex " . $dbgInfo['file'] . " (line " . $dbgInfo['line'] . ") -> \e[92m" . $dbgInfo['function'] . "(" . join(",", $dbgInfo['args']) . ")\e[0m\n";
        }

        $dbgMsg .= "\n\e[38;5;39mDebug backtrace end\e[0m\n";
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
        foreach ($values as $value) {
            if (ModernPHPException::isCli() == true) {
                CliDump::set('string', ['0000FF', 'light_blue']);
                new CliDump($value);

                if (!CliMessage::colorIsSupported() || !CliMessage::are256ColorsSupported())
                    CliDump::safe($value);
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
     * @return never
     */
    function dump_die(...$values): never
    {
        foreach ($values as $value) {
            if (ModernPHPException::isCli() == true) {
                CliDump::set('string', ['0000FF', 'light_blue']);
                new CliDump($value);

                if (!CliMessage::colorIsSupported() || !CliMessage::are256ColorsSupported())
                    CliDump::safe($value);
            } else {
                $dump = new BrowserDump();
                echo $dump->dump($value);
            }
        }
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

            if ($p->isPassedByReference()) $s .= '&';
            $s .= '$' . $p->name;

            if ($p->isOptional())
                $s .= ' = ' . var_export($p->getDefaultValue(), TRUE);

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
        if (!$type || $type->isBuiltin()) return null;

        // This line triggers autoloader!
        if (!class_exists($type->getName())) return null;
        return new \ReflectionClass($type->getName());
    }
}
