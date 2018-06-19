<?php
/**
 * Created by PhpStorm.
 * User: chenchangqin
 * Date: 18/6/13
 * Time: 下午5:21
 * Description: 缓存的存储抽象类
 */
namespace Qcrawler\lib\storage;

abstract class Storage
{
    protected $storage;

    abstract public function set(string $key,array $data,int $lose);
    abstract public function get(string $key);
    abstract public function update(string $key,array $data);
    abstract public function delete(string $key);
    abstract public function increase(string $key,int $num);
    abstract public function decrease(string $key,int $num);
}