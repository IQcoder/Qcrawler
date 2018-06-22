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
    public static $validation;

    public static function redis()
    {
        if (!self::$redis) {
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

    public static function validation(object $object)
    {
        if (!self::$validation) {
            self::$validation = new \Qcrawler\lib\validate\Validate($object);
        }
        return self::$validation;
    }



    public static function __callStatic($method, $arguments)
    {
        $return = require CONFIG.'/'.$method.'.php';
        list($name) = $arguments;

        if (!$name) {
            return $return;
        }

        if (strpos('.',$name)) {
            list($arr,$key) = explode('.',$name);
            if ($return[$arr][$key]) {
                $return = $return[$arr][$key];
            }
        } else {
            $return = $return[$name];
        }

        return $return;
    }

}