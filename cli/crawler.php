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
$crawler->base_uri = 'http://www.dytt8.net';
$crawler->selector = '#header > div > div.bd2 > div.bd3 > div:nth-child(2) > div:nth-child(1) > div > div:nth-child(2) > div.co_content8 tr';
if ($crawler->validate()) {
    $crawler->init()->run();
}
