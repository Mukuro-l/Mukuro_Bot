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
 *  | Date: 2020/10/28 下午5:01
 *  +----------------------------------------------------------------------
 *  | Description:   ImagickModel thumb
 *  +----------------------------------------------------------------------
 **/

namespace Hahadu\ImageFactory\Manage\Scale\Model;

use Hahadu\ImageFactory\Kernel\Extend\Constants;
use Hahadu\ImageFactory\Kernel\Kernel;

class Thumb
{
    private $path;
    /****
     * @var Kernel
     */
    private $_kernel;
    private $file_name;
    private $imagick;
    public function __construct($kernel){
        $this->_kernel = $kernel;
        $this->path =$this->_kernel->config->getSavePath();
        $this->imagick = $this->_kernel->Imagick($this->file_name);
    }
    /****
     * 创建缩略图
     * @param string $file_name 要压缩的文件名
     * @param string $path 文件保存目录
     * @param int $width 压缩图片宽
     * @param int $height 压缩图片高
     * @return string
     */
    public function image_thumb($file_name,$path='',$width=100,$height=100){
        $this->file_name = $file_name;
        $this->imagick = $this->_kernel->Imagick($this->file_name);

        $width  = $width ?? 100;
        $height = $height ?? 100;
        $this->path = $this->_kernel->base->get_save_path($path);

        $image  = $this->imagick;
        $format = mb_strtolower($image->getImageFormat());
        $img_h = $image->getImageHeight();
        $img_w = $image->getImageWidth();

        $image->thumbnailImage($width,$height);
        $thumb_file =$this->path.base64_encode($this->file_name.time().'_'.$img_h.'x'.$img_w).'.'.$format;
        $image->writeImage($thumb_file);
        $image->destroy();
        return Constants::DS.$thumb_file;
    }


}