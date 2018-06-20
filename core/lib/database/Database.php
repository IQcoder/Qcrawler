<?php
/**
 * Created by PhpStorm.
 * User: chenchangqin
 * Date: 18/6/20
 * Time: 上午10:35
 * Description: 封装ORM抽象类
 */

abstract class Database
{
    protected $database;

    abstract public function find();
    abstract public function insert();
    abstract public function update();
}