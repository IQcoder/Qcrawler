<?php
/**
 * Created by PhpStorm.
 * User: chenchangqin
 * Date: 18/6/15
 * Time: 下午1:56
 * Description:
 */

class CacheService
{
    private static $object;

    private function __construct(){
        $config = require CONFIG.'/redis.php';
        return new Redis($config);
    }

    public static function getInstance()
    {
        if (!self::$object) {
            self::$object = new self();
        }
        return self::$object;
    }

}