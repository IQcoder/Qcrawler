<?php
/**
 * Created by PhpStorm.
 * User: chenchangqin
 * Date: 18/6/13
 * Time: 下午5:49
 * Description:
 */

class LogServices
{
    private static $object;
    private $log;

    private function __construct(){
        $this->log = new Monolog();
    }

    public static function getInstance()
    {
        if (!self::$object) {
            self::$object = new self();
        }
        return self::$object;
    }

    public function add()
    {

    }
}