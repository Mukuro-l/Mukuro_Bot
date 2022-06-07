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
 *  | Date: 2020/10/28 下午5:00
 *  +----------------------------------------------------------------------
 *  | Description:   ImagickModel Scale
 *  +----------------------------------------------------------------------
 **/

namespace Hahadu\ImageFactory\Manage\Scale;
use Hahadu\ImageFactory\Manage\Scale\Model\Thumb;


class Client
{
    private $_kernel;
    private $Thumb;
    public function __construct($kernel){
        $this->_kernel = $kernel;
        $this->Thumb = new Thumb($kernel);
    }

    /****
     * 创建缩略图
     * @param string $file_name 要压缩的文件名
     * @param string $path 文件保存目录
     * @param int $width 压缩图片宽
     * @param int $height 压缩图片高
     * @return string
     */
    public function thumb($file_name,$path='',$width=100,$height=100){
        return $this->Thumb->image_thumb($file_name,$path,$width,$height);
    }

}