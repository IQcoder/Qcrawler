<?php
/**
 * Created by PhpStorm.
 * User: mq
 * Date: 18/7/9
 * Time: 下午11:25
 */

namespace Qcrawler\lib\hmac;

/**
 * Class Crypt_HMAC
 * @package Qcrawler\lib\hmac
 * @description H(K XOR opad, h(K XOR ipad,text))
 * H 用到的散列函数
 * K 用零(0x0)扩展到64字节的键值
 * opad 64字节长度的0x5Cs
 * ipad 64字节长度的0x36s
 * text 计算散列的明文
 */
class Crypt_HMAC
{
    private $_func;
    private $_opad;
    private $_ipad;

    /**
     * Crypt_HMAC constructor.
     * @param $key 字符串方法，用来计算散列
     * @param string $method
     * @throws \Exception
     */
    public function __construct($key,$method = 'md5')
    {
        if (!in_array($method,['md5','sha1']) || !function_exists($method)) {
            throw new \Exception('not found method');
        }

        $this->_func = $method;

        /* 按照PFC的要求填充关键字 (步骤1)*/
        if (strlen($key) > 64) {
            $key = pack('H32',$method($key));
        }

        if (strlen($key) < 64) {
            $key = str_pad($key,64,chr(0));
        }

        /* 计算填充的关键字，并且保存他们(步骤2和3) */
        $this->_ipad = substr($key,0,64) ^ str_repeat(chr(0x36),64);
        $this->_opad = substr($key,0,64) ^ str_repeat(chr(0x5C),64);
    }

    /**
     * 散列函数
     *
     * @param $data 字符串数据,将被散列处理的字符串(步骤4)
     * @return mixed
     */
    public function hash($data) : string
    {
        $func = $this->_func;
        $inner = pack('H32',$func($this->_ipad,$data));
        $digest = $func($this->_opad . $inner);

        return $digest;
    }
}