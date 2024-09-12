<?php

namespace ModernPHPException;

use LogicException;

class Bench
{
    /**
     * @var mixed
     */
    protected mixed $start_time;

    /**
     * @var mixed
     */
    protected mixed $end_time;

    /**
     * @var mixed
     */
    protected mixed $memory_usage;

    /**
     * Sets start microtime
     *
     * @return void
     */
    public function start(): void
    {
        $this->start_time = microtime(true);
    }

    /**
     * Sets end microtime
     *
     * @return void
     * @throws LogicException
     */
    public function end(): void
    {
        if (!$this->hasStarted()) throw new LogicException("You must call start()");
        $this->end_time = microtime(true);
        $this->memory_usage = memory_get_usage(true);
    }

    /**
     * Returns the elapsed time, readable or not
     *
     * @param bool $raw
     * @param null|string $format The format to display (printf format)
     * 
     * @return mixed
     * @throws LogicException
     */
    public function getTime(bool $raw = false, ?string $format = null): mixed
    {
        if (!$this->hasStarted()) throw new LogicException("You must call start()");
        if (!$this->hasEnded()) throw new LogicException("You must call end()");

        $elapsed = $this->end_time - $this->start_time;
        return $raw ? $elapsed : self::readableElapsedTime($elapsed, $format);
    }

    /**
     * Returns the memory usage at the end checkpoint
     *
     * @param  bool         $readable Whether the result must be human readable
     * @param  null|string  $format   The format to display (printf format)
     * 
     * @return mixed
     */
    public function getMemoryUsage(bool $raw = false, ?string $format = null): mixed
    {
        return $raw ? $this->memory_usage : self::readableSize($this->memory_usage, $format);
    }

    /**
     * Returns the memory peak, readable or not
     *
     * @param  bool         $readable Whether the result must be human readable
     * @param  null|string  $format   The format to display (printf format)
     * 
     * @return mixed
     */
    public function getMemoryPeak(bool $raw = false, ?string $format = null): mixed
    {
        $memory = memory_get_peak_usage(true);
        return $raw ? $memory : self::readableSize($memory, $format);
    }

    /**
     * Wraps a callable with start() and end() calls
     *
     * Additional arguments passed to this method will be passed to
     * the callable.
     *
     * @param callable $callable
     * 
     * @return mixed
     */
    public function run(callable $callable): mixed
    {
        $arguments = func_get_args();
        array_shift($arguments);
        $this->start();
        $result = call_user_func_array($callable, $arguments);
        $this->end();
        return $result;
    }

    /**
     * Returns a human readable memory size
     *
     * @param   int    $size
     * @param   null|string $format   The format to display (printf format)
     * @param   int    $round
     * 
     * @return  string
     */
    public static function readableSize(int $size, ?string $format = null, int $round = 3): string
    {
        $mod = 1024;
        if (is_null($format)) $format = '%.2f%s';
        $units = explode(' ', 'B Kb Mb Gb Tb');

        for ($i = 0; $size > $mod; $i++) {
            $size /= $mod;
        }

        if (0 === $i) $format = preg_replace('/(%.[\d]+f)/', '%d', $format);
        return sprintf($format, round($size, $round), $units[$i]);
    }

    /**
     * Returns a human readable elapsed time
     *
     * @param float $microtime
     * @param null|string  $format   The format to display (printf format)
     * @param int $round
     * 
     * @return string
     */
    public static function readableElapsedTime(float $microtime, ?string $format = null, int $round = 3): string
    {
        if (is_null($format)) $format = '%.3f%s';

        if ($microtime >= 1) {
            $unit = 's';
            $time = round($microtime, $round);
        } else {
            $unit = 'ms';
            $time = round($microtime * 1000);
            $format = preg_replace('/(%.[\d]+f)/', '%d', $format);
        }

        return sprintf($format, $time, $unit);
    }

    /**
     * @return null|string
     */
    public function hasEnded(): ?string
    {
        return isset($this->end_time);
    }

    /**
     * @return null|string
     */
    public function hasStarted(): ?string
    {
        return isset($this->start_time);
    }
}
