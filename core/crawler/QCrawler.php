<?php
/**
 * Created by PhpStorm.
 * User: chenchangqin
 * Date: 18/6/19
 * Time: 下午12:17
 * Description: 爬虫类
 */
namespace Qcrawler\crawler;
use GuzzleHttp\Client;
use Symfony\Component\DomCrawler\Crawler;

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
     * 并发线程数，默认为1
     */
    public $concurrency = 1;

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

    public function init()
    {


        $client = new Client(['timeout' => $this->timeout]);
        $data = $client->requestAsync('get', $this->base_uri);
        var_dump($data);die;
//        $this->crawler = new Crawler();


        return $this;
    }

    public function run()
    {
        $this->crawler = new Crawler();
        $this->crawler->addHtmlContent();




        $result = iconv('GBK', 'UTF-8', $result);
        $crawler = new Crawler();
        $crawler->addHtmlContent($result);

        $list = [];
        // 通过css选择器遍历影片列表
        $tr_selector = '#header > div > div.bd2 > div.bd3 > div:nth-child(2) > div:nth-child(1) > div > div:nth-child(2) > div.co_content8 tr';
        $crawler->filter($tr_selector)->each(function (Crawler $node, $i) use (&$list) {
            $name = dom_filter($node, 'a:nth-child(2)', 'html');
            if (empty($name)) {
                return;
            }
            $url = 'http://www.dytt8.net'.dom_filter($node, 'a:nth-child(2)', 'attr', 'href');

            $data = [
                'name' => $name,
                'url' => $url,
                'time' => dom_filter($node, '.inddline font', 'html'),
            ];
            // 把影片url、name推送到redis队列，以便进一步爬取影片下载链接
            redis()->lpush('dytt8:detail_queue', json_encode($data));
            $list[] = $data;
        });
        var_dump($list);
    }

    public function validate()
    {
        if (!$this->base_uri) {
            throw new \Exception('base_uri not found');
        }
        return true;
    }

    public function error()
    {
        // TODO: Implement error() method.
    }

    public function success()
    {
        // TODO: Implement success() method.
    }

    public function __set($name, $value)
    {
        $this->$name = $value;
    }

    public function __get($name)
    {
        return $this->$name;
    }
}