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
 *  | Date: 2020/10/29 下午9:24
 *  +----------------------------------------------------------------------
 *  | Description:   ImageAddImage
 *  +----------------------------------------------------------------------
 **/

namespace Hahadu\ImageFactory\Manage\ImageToImage\Model;
use Hahadu\ImageFactory\Kernel\Extend\Constants;
use Hahadu\ImageFactory\Kernel\Models\Client\BaseClient as Client;
use Hahadu\ImageFactory\Kernel\Models\Traits\ImagickTrait;

class ImageAddImage extends Client
{
    use ImagickTrait;
    private $path;
    public function __construct($kernel)
    {
        parent::__construct($kernel);
//        $this->config = $this->_kernel->config;
    }
    public function water_mark($image,$x='right',$y='down',$option=[]){
        $path = isset($option['path'])?$option['path']:null;
        $this->path = $this->_kernel->base->get_save_path($path);

        $imagick = $this->_kernel->Imagick($image);
        $image_width = $imagick->getImageWidth();
        $image_height= $imagick->getImageHeight();
        $format = isset($option['format'])?$option['format']:$imagick->getImageFormat();

        $img_water = $this->_kernel->Imagick($this->config->getWaterMarkImage());
        $img_water = $this->set_image($img_water);
        $img_water_width  = $img_water->getImagewidth();
        $img_water_height = $img_water->getImageHeight();
        $opacity = isset($option['opacity'])?$option=['opacity']:0;
        //设置图像透明度，图像必须带alpha通道才有效，故大多数jpg图像不支持
        $img_water->evaluateImage(Constants::EVALUATE_DIVIDE,$opacity,8);
        //图像位置
        switch ($x){
            case 'right':
                $water_x = $this->_kernel->base->position()->image_right($image_width,$img_water_width);
                break;
            case 'center':
                $water_x = $this->_kernel->base->position()->image_center_x($image_width,$img_water_width);
                break;
            case is_int($x) :
                $water_x = $x;
                break;
            default :
                $water_x = 0;
                break;
        }
        switch ($y){
            case 'down':
                $water_y = $this->_kernel->base->position()->image_down($image_height,$img_water_height);
                break;
            case 'center':
                $water_y = $this->_kernel->base->position()->image_center_y($image_height,$img_water_height);
                break;
            case is_int($y):
                $water_y = $y;
                break;
            default :
                $water_y = 0;
                break;
        }

        $imagick->compositeImage($img_water,Constants::COMPOSITE_ATOP,$water_x,$water_y);

        $imagick->setImageFormat($format);

        $save_path = $this->path.base64_encode($image.Constants::UND.$image_width."x".$image_height).Constants::DOT.$format;
        $imagick->writeImage($save_path);
        $imagick->destroy();
        return Constants::DS.$save_path;
    }


}