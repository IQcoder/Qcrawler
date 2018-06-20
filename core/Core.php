<?php

namespace Qcrawler;

/**
 * Class Core
 * @package Qcrawler 核心类
 * @method static Core component(string $name)
 * @method static Core param(string $name)
 */

class Core
{

    public static $redis;
    public static $route;
    public static $log;

    public static function redis()
    {
        if (self::$redis) {
            self::$redis = new \Qcrawler\lib\storage\Redis(self::component('redis'));
        }
        return self::$redis;
    }

    public static function log()
    {
        if (!self::$log) {
            self::$log = new \Qcrawler\lib\log\Monolog(self::component('log.name'));
        }
        return self::$log;
    }

    public static function route()
    {
        if (!self::$route) {
            self::$route = new \Qcrawler\lib\route\Route();
        }
        return self::$route;
    }

    public static function __callStatic($name, $arguments)
    {
        $return = require CONFIG.'/'.$name.'.php';

        if (!$arguments[0]) {
            return $return;
        }

        if (strpos('.',$arguments[0])) {
            list($arr,$key) = explode('.',$arguments[0]);
            if ($return[$arr][$key]) {
                $return = $return[$arr][$key];
            }
        } else {
            $return = $return[$arguments[0]];
        }

        return $return;
    }

}