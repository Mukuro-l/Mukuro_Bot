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
 *  | Date: 2020/10/30 下午4:54
 *  +----------------------------------------------------------------------
 *  | Description:   BaseClient
 *  +----------------------------------------------------------------------
 **/

namespace Hahadu\ImageFactory\Kernel\Models\Client;


use Hahadu\ImageFactory\Kernel\Kernel;
use Hahadu\ImageFactory\Kernel\Models\ImagickModel;

class BaseClient
{
    protected $_kernel;
    protected $config;
    protected $base;

    /*****
     * BaseClient constructor.
     * @param Kernel $kernel
     */
    public function __construct($kernel){
        $this->_kernel = $kernel;
        $this->config = $kernel->config;
        $this->base = $kernel->base;
    }
    protected function imagickModel($imagick){
        return new ImagickModel($imagick);
    }

}