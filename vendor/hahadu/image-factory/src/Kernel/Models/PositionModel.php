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
 *  | Date: 2020/10/29 下午7:42
 *  +----------------------------------------------------------------------
 *  | Description:   position
 *  +----------------------------------------------------------------------
 **/

namespace Hahadu\ImageFactory\Kernel\Models;


class PositionModel
{
    public function text_right($image_width,$text_len,$font_size){
        return $image_width-($text_len+1)*$font_size; //出血位补偿
    }
    public function text_center_x($image_width,$text_len,$font_size){
        return ($image_width-$text_len*$font_size)/2;
    }
    public function text_center_y($image_width,$text_line,$font_size){
        return ($image_width-$text_line*1.2*$font_size)/2;
    }
    public function text_down($image_height,$text_line,$font_size){
        return $image_height-$text_line*1.2*$font_size;
    }
    public function image_center_x($image_width,$min_width){
        return ($image_width-$min_width)/2;
    }
    public function image_center_y($image_width,$min_width){
        return ($image_width-$min_width)/2;
    }
    public function image_down($image_height,$min_height){
        return $image_height-$min_height;
    }
    public function image_right($image_width,$min_width){
        return $image_width-$min_width;
    }

}