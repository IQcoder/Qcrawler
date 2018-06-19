<?php
/**
 * Created by PhpStorm.
 * User: chenchangqin
 * Date: 18/6/19
 * Time: 下午12:17
 * Description: 爬虫类
 */
namespace Qcrawler\crawler;
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

    public function run()
    {
        // TODO: Implement run() method.
    }

    public function validate()
    {
        if (!$this->base_uri) {
            throw new \Exception('base_uri not found');
        }
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