<?php
/**
 * Created by PhpStorm.
 * User: chenchangqin
 * Date: 18/6/13
 * Time: 下午5:24
 * Description:
 */

namespace Qcrawler\lib\log;
abstract class Log
{
    protected $log;
    abstract public function add(string $message);
}