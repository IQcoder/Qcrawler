<?php
/**
 * Created by PhpStorm.
 * User: chenchangqin
 * Date: 18/6/13
 * Time: 下午5:24
 * Description:
 */

abstract class Log
{
    protected $log;
    abstract public function add(array $arguments);
}