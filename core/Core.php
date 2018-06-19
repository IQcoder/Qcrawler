<?php
/**
 * Created by PhpStorm.
 * User: chenchangqin
 * Date: 18/6/19
 * Time: 下午1:34
 * Description: 调度器
 */
namespace Qcrawler;

class Core
{

    public static function Redis()
    {
        $config = require CONFIG.'/redis.php';
        return new \Qcrawler\lib\storage\Redis($config);
    }

    public static function Log()
    {
        return new \Qcrawler\lib\log\Monolog('Qcrawler');
    }
    
}