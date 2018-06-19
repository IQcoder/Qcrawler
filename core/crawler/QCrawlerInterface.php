<?php
/**
 * Created by PhpStorm.
 * User: chenchangqin
 * Date: 18/6/19
 * Time: 下午12:19
 * Description: 接口类
 */
namespace Qcrawler\crawler;

interface QCrawlerInterface
{
    /**
     * @function run
     * @return mixed
     * @author chenchangqin
     * @description 爬虫开始执行
     */
    public function run();

    /**
     * @function validate
     * @return mixed
     * @author chenchangqin
     * @description 执行爬虫前的相关验证
     */
    public function validate();
}