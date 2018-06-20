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
        $crawler->base_uri = 'http://www.dytt8.net/';
        if ($crawler->validate()) {
            $crawler->init()->run();
        }
    }
    
}