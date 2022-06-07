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
 *  | Date: 2020/10/28 下午5:16
 *  +----------------------------------------------------------------------
 *  | Description:   ImageToText
 *  +----------------------------------------------------------------------
 **/

namespace Hahadu\ImageFactory\Manage\ImageToText\Model;


use Hahadu\ImageFactory\Kernel\Kernel;

class ImageToText
{
    /****
     * @var Kernel
     */
    protected $_kernel;
    protected $chars = '';

    public function __construct($kernel){
        $this->_kernel = $kernel;
        $this->chars = $this->_kernel->config->getChars();
    }
    public function to_text_color($images='', $flage=true){
        $image_data = $this->get_img_data($images,$flage);
        $height = $image_data->getImageHeight();
        $width  = $image_data->getImageWidth();
        $result="";
        for($i=1;$i<=$height;$i++){
            for($j=1;$j<=$width;$j++){
                $color_tran = $image_data
                    ->getImagePixelColor($j-1,$i-1)
                    ->getColor();
                $result.=$this->color_img($color_tran);
            }
            $result.="<br/>";
        }
        $image_data->destroy();
        return $result;
    }
    public function to_text_black($images , $flage=true){
        $image_data = $this->get_img_data($images,$flage);
        $height = $image_data->getImageHeight();
        $width  = $image_data->getImageWidth();
        $result="";
        for($i=1;$i<=$height;$i++){
            for($j=1;$j<=$width;$j++){
                $color_tran = $image_data
                    ->getImagePixelColor($j-1,$i-1)
                    ->getColor();
                $result.=$this->black_img($color_tran);
            }
            $result.="<br/>";
        }
        $image_data->destroy();
        return $result;
    }

    private function black_img($color_tran){
        $length = strlen($this->chars);
        $alpha=$color_tran['a'];
        $r=$color_tran['r'];
        $g=$color_tran['g'];
        $b=$color_tran['b'];
        $gray = intval(0.2126 * $r + 0.7152 * $g + 0.0722 * $b); //变量转换成整型
        $rand=rand (0,  $length-1);
        $color="rgb(".$gray.",".$gray.",".$gray.","."$alpha".")";
        $char = substr($this->chars, $rand,1);
        return '<span style="color:'.$color.'" >'.$char."</span>";;
    }
    private function color_img($color_tran){
        $length = strlen($this->chars);
        $alpha=$color_tran['a'];
        $r=$color_tran['r'];
        $g=$color_tran['g'];
        $b=$color_tran['b'];
        $gray = intval(0.2126 * $r + 0.7152 * $g + 0.0722 * $b); //变量转换成整型
        $rand=rand (0,  $length-1);
        $color="rgb(".$r.",".$g.",".$b.")";
        $char = substr($this->chars, $rand,1);
        return '<span style="color:'.$color.'" >'.$char."</span>";;
    }

    private function get_img_data($file_name,$flage=true){
        $image_data = $this->_kernel->Imagick($file_name);
        $width = $image_data->getImageWidth();
        $height = $image_data->getImageHeight();
        $format = mb_strtolower($image_data->getImageFormat());
        if($format=='png'){
            $flage=false;
        }

        if($flage){
            $new_height =40;
            $percent=$height/$new_height;
            $new_width=$width/$percent*2;
            $image_data->thumbnailImage($new_width,$new_height); //压缩图像
        }
        return $image_data;

    }

}