<?php namespace Prettus\RequestLogger\Helpers;

/**
 * Class Benchmarking
 * @package Prettus\RequestLogger\Helpers
 * @author Anderson Andrade <contato@andersonandra.de>
 */
class Benchmarking
{

    /**
     * @var array
     */
    protected static $timers = [];

    /**
     * @param $name
     * @return mixed
     */
    public static function start($name)
    {
        $start = microtime(true);
        $memory_start = memory_get_usage();

        static::$timers[$name] = [
            'start'=>$start,
            'memory_start'=>$memory_start
        ];

        return $start;
    }

    /**
     * @param $name
     * @return float
     * @throws \Exception
     */
    public static function end($name)
    {

        $end = microtime(true);
        $memory_end = memory_get_usage();
        $memory_peak = memory_get_peak_usage();

        if( isset(static::$timers[$name]) && isset(static::$timers[$name]['start']) ) {

            if( isset(static::$timers[$name]['duration']) ){
                return static::$timers[$name];
            }

            $start = static::$timers[$name]['start'];
            $memory_start = static::$timers[$name]['memory_start'];

            static::$timers[$name]['end'] = $end;
            static::$timers[$name]['memory_end'] = $memory_end;
            static::$timers[$name]['duration'] = $end - $start;
            static::$timers[$name]['memory_peak'] = $memory_peak;
            static::$timers[$name]['memory_leak'] = $memory_end - $memory_start;


            return static::$timers[$name];
        }

        throw new \Exception("Benchmarking '{$name}' not started");
    }

    /**
     * @param $name
     * @return float
     * @throws \Exception
     */
    public static function duration($name)
    {
        return static::end($name);
    }
}
