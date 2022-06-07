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
 *  | Date: 2020/10/30 上午11:53
 *  +----------------------------------------------------------------------
 *  | Description:   TextCreateImage
 *  +----------------------------------------------------------------------
 **/

namespace Hahadu\ImageFactory\Manage\TextToImage\Model;


use Hahadu\ImageFactory\Kernel\Extend\Constants;
use Hahadu\ImageFactory\Kernel\Kernel;
use Hahadu\ImageFactory\Kernel\Models\AddText;

class TextCreateImage
{
    private $_kernel;
    private $base;
    private $style;
    private $AddText;
    /****
     * @var Kernel $kernel
     */
    public function __construct($kernel){
        $this->_kernel = $kernel;
        $this->base = $kernel->base;
        $this->style = $kernel->config->getTextStyle();
        $this->AddText = new AddText($kernel);
    }
    public function text_create_image($text,$options=[]){
        $this->style = array_replace_recursive($this->style,$options);
        $text = mb_convert_encoding($text,"utf-8");
        $background = isset($options['background'])?$options['background']:'#fff';
        $format  = isset($options['format'])?$options['format']:'png';

        $str_line = $this->base->get_text_line($text);
        $str_max_len = $this->base->get_str_max_len($text);
        $image_width = isset($options['image_width'])?$options['image_width']:
            ($str_max_len+2)*$this->style['font_size']; //set image width
        $image_height = isset($options['image_height'])?$options['image_height']:
            ($str_line+2) * $this->style['font_size']*1.5;
        $filename = isset($options['filename'])?$options['filename']:
            base64_encode($this->base->re_substr($text,0,5).
            mb_strlen($text).Constants::UND.
            $image_width.Constants::UND.$image_height);

        $save_path = $this->_kernel->config->getSavePath().$filename.Constants::DOT.$options['format'];
        $font_point_x = $this->style['font_size']*1.5;
        $font_point_y = $this->style['font_size']*2;
        $imagick = $this->_kernel->Imagick();
        $imagick->newImage($image_width,$image_height,$background,$format);
        $this->AddText->add_text($imagick,$text,$font_point_x,$font_point_y,0,$this->style);
        $imagick->writeImage($save_path);
        $imagick->destroy();

        return Constants::DS.$save_path;

    }
}