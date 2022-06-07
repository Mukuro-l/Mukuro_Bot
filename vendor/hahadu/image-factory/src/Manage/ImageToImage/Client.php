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
 *  | Date: 2020/10/29 下午8:26
 *  +----------------------------------------------------------------------
 *  | Description:   ImageToImage
 *  +----------------------------------------------------------------------
 **/

namespace Hahadu\ImageFactory\Manage\ImageToImage;
use Hahadu\ImageFactory\Manage\ImageToImage\Model\ImageAddImage;

class Client
{
    private $ImageAddImage;
    public function __construct($kernel)
    {
        $this->ImageAddImage = new ImageAddImage($kernel);
    }
    public function image_water_mark($image,$x='right',$y='down',$options=[]){
        return $this->ImageAddImage->water_mark($image,$x,$y,$options);

    }

}