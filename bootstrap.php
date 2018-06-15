<?php
/**
 * Created by PhpStorm.
 * User: chenchangqin
 * Date: 18/6/13
 * Time: 下午5:10
 * Description: 引导文件
 */
define('ROOT',__DIR__);
define('CORE',ROOT.'/core');
define('APP',ROOT.'/app');
define('CONFIG',ROOT.'/config');

require ROOT . '/vendor/autoload.php';
//注入配置文件