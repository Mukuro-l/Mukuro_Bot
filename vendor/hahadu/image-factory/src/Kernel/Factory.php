<?php
/**
 *  +----------------------------------------------------------------------
 *  | Created by  hahadu (a low phper and coolephp)
 *  +----------------------------------------------------------------------
 *  | Copyright (c) 2020. [hahadu] All rights reserved.
 *  +----------------------------------------------------------------------
 *  | SiteUrl: https://github.com/hahadu/wechat
 *  +----------------------------------------------------------------------
 *  | Author: hahadu <582167246@qq.com>
 *  +----------------------------------------------------------------------
 *  | Date: 2020/10/28 上午12:24
 *  +----------------------------------------------------------------------
 *  | Description:   Factory
 *  +----------------------------------------------------------------------
 **/

namespace Hahadu\ImageFactory\Kernel;
use Hahadu\ImageFactory\Kernel\Extend\ImagickConfig;
use Hahadu\ImageFactory\Manage\ImageToText\Client as ImageToText;
use Hahadu\ImageFactory\Manage\Scale\Client as Scale;
use Hahadu\ImageFactory\Manage\TextToImage\Client as TextToImage;
use Hahadu\ImageFactory\Manage\ImageToImage\Client as ImageToImage;
use Hahadu\ImageFactory\Kernel\Helper\BaseHelper;

class Factory
{
    private static $ImageToText;
    protected $kernel;
    private static $Base;
    private static $instance;
    private static $Scale;
    private static $TextToImage;
    private static $ImageToImage;
    private static $config;

    //构造方法
    public function __construct($config){
        $this->kernel = new Kernel($config);
        self::$Base = new BaseHelper($config);
        self::$ImageToText = new ImageToText($this->kernel);
        self::$TextToImage = new TextToImage($this->kernel);
        self::$Scale = new Scale($this->kernel);
        self::$ImageToImage = new ImageToImage($this->kernel);

    }
    //参数设置
    static public function setOptions($config){
        $config = new ImagickConfig($config);
        if (!(self::$instance instanceof self)) {
            self::$instance = new self($config);
        }
        return self::$instance;
    }
    static public function base(){
        return self::$Base;
    }
    static public function scale(){
        return self::$Scale;
    }

    static public function image_to_text(){
        return self::$ImageToText;
    }
    static public function text_to_image(){
        return self::$TextToImage;
    }
    static public function image_to_image(){
        return self::$ImageToImage;
    }


}