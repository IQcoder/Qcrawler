<?php
/**
 * Created by PhpStorm.
 * User: chenchangqin
 * Date: 18/6/19
 * Time: 下午7:10
 * Description:
 */
$params = [];
foreach (glob(__DIR__.'/params/*.php') as $filename) {
    $params = array_merge($params, [basename($filename) => require($filename)]);
}
return $params;