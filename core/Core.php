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
        return new \Qcrawler\lib\storage\Redis(self::component('redis'));
    }

    public static function Log()
    {
        return new \Qcrawler\lib\log\Monolog(self::component('log.name'));
    }

    /**
     * @function component
     * @param string $name
     * @author chenchangqin
     * @description 获取一些配置数组的数据
     */
    public static function component($name = null)
    {
        $component = require CONFIG.'/component.php';

        if (!$name) {
            return $component;
        }

        if (strpos('.',$name)) {
            list($arr,$key) = explode('.',$name);
            if ($component[$arr][$key]) {
                $component = $component[$arr][$key];
            }
        } else {
            $component = $component[$name];
        }

        return $component;
    }

    /**
     * @function param
     * @param string $name
     * @author chenchangqin
     * @description 获取参数数据
     */
    public static function param($name = null)
    {
        $param = require CONFIG.'/param.php';

        if (!$name) {
            return $param;
        }

        if (strpos('.',$name)) {
            list($arr,$key) = explode('.',$name);
            if ($param[$arr][$key]) {
                $param = $param[$arr][$key];
            }
        } else {
            $param = $param[$name];
        }

        return $param;
    }
    
}