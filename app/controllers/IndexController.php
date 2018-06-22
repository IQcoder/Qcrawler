<?php
/**
 * Created by PhpStorm.
 * User: chenchangqin
 * Date: 18/6/15
 * Time: 下午3:25
 * Description:
 */
namespace App\controllers;

class IndexController
{

    public function index()
    {
        $crawler = new \Qcrawler\crawler\QCrawler();
        $crawler->name = 'qcrawler';
        $crawler->base_uri = 'http://www.dytt8.net';
        $crawler->selector = '#header > div > div.bd2 > div.bd3 > div:nth-child(2) > div:nth-child(1) > div > div:nth-child(2) > div.co_content8 tr';
        if ($crawler->validate()) {
            $crawler->init()->run();
        }
    }
    
}