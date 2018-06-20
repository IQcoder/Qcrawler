<?php
/**
 * Created by PhpStorm.
 * User: chenchangqin
 * Date: 18/6/15
 * Time: 下午3:32
 * Description: demo
 */
use Qcrawler\crawler\QCrawler;
require __DIR__.'/../bootstrap.php';

$crawler = new QCrawler();
$crawler->base_uri = 'http://www.dytt8.net/';

if ($crawler->validate()) {
    $crawler->init()->run();
}
