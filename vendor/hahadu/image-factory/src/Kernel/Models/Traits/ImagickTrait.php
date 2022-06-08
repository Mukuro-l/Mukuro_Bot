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
 *  | Date: 2020/10/30 下午7:14
 *  +----------------------------------------------------------------------
 *  | Description:   ImagickTrait
 *  +----------------------------------------------------------------------
 **/

namespace Hahadu\ImageFactory\Kernel\Models\Traits;


trait ImagickTrait
{
    /*****
     * @param \Imagick $imagick
     * @return \Imagick
     */
    public function set_image(& $imagick,$style=[]){
       return $imagick;
    }

}