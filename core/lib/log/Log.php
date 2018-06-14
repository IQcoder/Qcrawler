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
    abstract public function add(string $log,string $file);
    abstract public function delete(string $log,string $file);
    abstract public function update(string $log,string $file);
}