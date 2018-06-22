<?php

namespace Qcrawler\crawler;
use GuzzleHttp\Client;
use Qcrawler\Core;
use Symfony\Component\DomCrawler\Crawler;

/**
 * Class QCrawler 爬虫类
 * @package Qcrawler\crawler
 */
class QCrawler implements QCrawlerInterface
{
    /**
     * @var null
     * 爬虫名称
     */
    public $name = NULL;

    /**
     * @var string
     * 设置存储的方式
     */
    public $storage = 'redis';

    /**
     * @var bool
     * 是否开启断点爬取，不设置则每次都重新爬取
     */
    public $breakpoint = false;

    /**
     * @var int
     * 超时
     */
    public $timeout = 30;

    /**
     * @var string
     * 根域名
     */
    public $base_uri;

    /**
     * @var int
     * 设置爬取间隔时间
     */
    public $interval = 0;

    /**
     * @var int
     * 设置失败重试次数，0即为不重试
     */
    public $retry_count = 1;

    /**
     * @var string
     * 设置css选择器
     */
    public $selector;

    private $crawler;
    private $error;

    public function init()
    {

        if ($this->breakpoint) {
            return $this->breakPoint();
        }

        $client = new Client(['timeout' => $this->timeout]);
        $data = $client->get($this->base_uri);
        $result = iconv('GBK', 'UTF-8', $data->getBody()->getContents());
        $this->crawler = new Crawler();
        $this->crawler->addHtmlContent($result);
        $list = [];
        $this->crawler->filter($this->selector)->each(function(Crawler $node, $i) use (&$list) {
            $name = $this->domFilter($node,'a:nth-child(2)', 'html');
            if (empty($name)) {
                return;
            }

            $url = $this->base_uri.$this->domFilter($node,'a:nth-child(2)', 'attr', 'href');
            $data = [
                'name' => $name,
                'url' => $url,
                'time' => $this->domFilter($node,'.inddline font','html')
            ];
            $list[] = $data;
        });
        $this->data = $list;
        return $this;
    }

    public function run()
    {
        var_dump($this->data);
        return true;
    }

    public function validate()
    {

        $validate = [
            [['base_uri','name'],'require'],
            [['base_uri','name'],'string']
        ];

        if (!empty($validate)) {
            return Core::validation($this)->validate($validate);
        }

        return true;
    }

    /**
     * @function domFilter
     * @param Crawler $crawler
     * @param $selector
     * @param $method
     * @param string $arguments
     * @return null|string
     * @author chenchangqin
     * @description
     */
    public function domFilter(Crawler $crawler, $selector, $method, $arguments = '')
    {
        try {
            return trim($crawler->filter($selector)->$method($arguments));
        } catch (\Exception $e) {
            return NULL;
        }
    }

    /**
     * @function breakPoint
     * @return $this
     * @author chenchangqin
     * @description 断点续爬
     */
    public function breakPoint()
    {
        return $this;
    }

    public function __set($name, $value)
    {
        $this->$name = $value;
    }

    public function __get($name)
    {
        return $this->$name;
    }

    /**
     * @return mixed
     */
    public function getError()
    {
        return $this->error;
    }


    public function error()
    {
        // TODO: Implement error() method.
    }

    public function success()
    {
        // TODO: Implement success() method.
    }
}