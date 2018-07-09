<?php
/**
 * 函数库
 */

/**
 * 计算散列的函数
 * @param $array
 * @param string $method 系统内置函数
 * @return string
 * @throws Exception
 */
function create_parameters($array,$method = 'md5') {
    $data = '';
    $ret = [];
    /* 用键值来构造字符串 */
    foreach ($array as $key => $value) {
        $data .= $key . $value;
        $ret[] = "$key=$value";
    }

    $h = new \Qcrawler\lib\hmac\Crypt_HMAC(\Qcrawler\Core::component('main.secret_key'),$method);

    $hash = $h->hash($data);
    $ret[] = "hash=$hash";

    return join('&amp;',$ret);
}

/**
 * 验证脚本HASH值是否一致
 * @param $array
 * @param string $method
 * @return bool
 * @throws Exception
 */
function verify_parameters($array,$method='md5') {
    $data = '';
    $ret = [];
    /* 把散列存放在单独的一个变量，并且在数组本身注销散列 */
    $hash = $array['hash'];
    unset($array['hash']);

    foreach ($array as $key => $value) {
        $data .= $key . $value;
        $ret[] = "$key=$value";
    }

    $h = new \Qcrawler\lib\hmac\Crypt_HMAC(\Qcrawler\Core::component('main.secret_key'),$method);

    if ($hash == $h->hash($data)) {
        return true;
    } else {
        return false;
    }
}