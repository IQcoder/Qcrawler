<?php
namespace Qcrawler\lib\storage;

/**
 * Class Redis Redis存储方法
 * @package Qcrawler\lib\storage
 * @method array hgetall($key)
 */
class Redis extends Storage
{

    public function __construct($redis)
    {
        $this->storage = new \Predis\Client($redis);
    }

    public function set(string $key, array $data, int $lose)
    {
        return $this->storage->set($key,$data,$lose);
    }

    public function get(string $key)
    {
        return $this->storage->get($key);
    }

    public function update(string $key, array $data)
    {
        if ($this->storage->exists($key)) {
            return $this->storage->set($key,$data);
        }
        throw new \Exception('key not found');
    }

    public function delete(string $key)
    {
        return $this->storage->dump($key);
    }

    public function increase(string $key, int $num=1)
    {
        return $this->storage->incrby($key,$num);
    }

    public function decrease(string $key, int $num=1)
    {
        return $this->storage->decrby($key,$num);
    }

    public function __call($method, $arguments)
    {
        try{
            $return = $this->storage->$method(implode(',', $arguments));
        }catch(\Exception $e) {
            return $e->getMessage();
        }
        return $return;
    }
}