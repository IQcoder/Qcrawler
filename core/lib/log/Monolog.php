<?php
/**
 * Created by PhpStorm.
 * User: chenchangqin
 * Date: 18/6/13
 * Time: 下午5:45
 * Description:
 */

use Monolog\Logger;
class Monolog extends Log
{

    public function __construct($name)
    {
        $this->log = new Logger($name);
    }

    public function add(array $arguments)
    {
        return $this->log->addError($arguments['message']);
    }


}