<?php

namespace Qcrawler\crawler;

/**
 * Interface QCrawlerInterface 接口类
 * @package Qcrawler\crawler
 */
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

    /**
     * @function success
     * @return mixed
     * @author chenchangqin
     * @description 执行成功后调用的方法
     */
    public function success();

    /**
     * @function error
     * @return mixed
     * @author chenchangqin
     * @description 执行失败后的调用方法
     */
    public function error();

    /**
     * @function init
     * @return mixed
     * @author chenchangqin
     * @description 初始化
     */
    public function init();


}