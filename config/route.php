<?php
/**
 * Created by PhpStorm.
 * User: chenchangqin
 * Date: 18/6/15
 * Time: 下午12:08
 * Description: 路由规则
 */
//use NoahBuscher\Macaw\Macaw;
use Qcrawler\Core;

$whoops = new \Whoops\Run;

$whoops->pushHandler(new \Whoops\Handler\PrettyPageHandler);

$whoops->register();

$routes = [
    '/' => 'IndexController@index'
];
foreach (glob(__DIR__.'/route/*.php') as $filename) {
    $routes = array_merge($routes, require($filename));
}

foreach ($routes as $key => $route) {
    Core::route()->get($key,$route);
}

Core::route()->error_callback = function() {
    throw new Exception("路由无匹配项 404 Not Found");
};

Core::route()->dispatch();