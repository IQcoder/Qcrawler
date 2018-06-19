<?php
/**
 * Created by PhpStorm.
 * User: chenchangqin
 * Date: 18/6/19
 * Time: 下午7:10
 * Description:
 */
$components = [];
foreach (glob(__DIR__.'/components/*.php') as $filename) {
    $components = array_merge($components, [basename($filename) => require($filename)]);
}
return $components;