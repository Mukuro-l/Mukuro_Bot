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
 *  | Date: 2020/10/28 下午7:58
 *  +----------------------------------------------------------------------
 *  | Description:   TextToImage
 *  +----------------------------------------------------------------------
 **/

namespace Hahadu\ImageFactory\Manage\TextToImage;
use Hahadu\ImageFactory\Manage\TextToImage\Model\TextAddImage;
use Hahadu\ImageFactory\Manage\TextToImage\Model\TextToAvatar;
use Hahadu\ImageFactory\Manage\TextToImage\Model\TextToIcon;
use Hahadu\ImageFactory\Manage\TextToImage\Model\TextCreateImage;
use Hahadu\ImageFactory\Manage\TextToImage\Model\Captcha;


class Client
{
    protected $TextToAvatar;
    protected $TextToIcon;
    protected $TextAddImage;
    protected $TextCreateImage;
    protected $Captcha;

    public function __construct($kernel){
        $this->TextToAvatar = new TextToAvatar($kernel);
        $this->TextToIcon = new TextToIcon($kernel);
        $this->TextAddImage = new TextAddImage($kernel);
        $this->TextCreateImage = new TextCreateImage($kernel);
        $this->Captcha = new Captcha($kernel);
    }
    public function text_to_avatar($text){
        return $this->TextToAvatar->text_to_avatar($text);
    }
    public function text_to_icon($text,$path=''){
        return $this->TextToIcon->text_to_icon($text,$path);
    }

    /****
     * @param string|null $image 图像路径
     * @param string|float $x 水印位置横向坐标 数字 字符串目前支持' left '、' right '、' center '
     * @param string|float $y 水印位置纵向坐标 数字 字符串目前支持' top '、' down '、' center '
     * @param array $option 自定义设置，覆盖config->TextStyle[]设置,
     * 如果$option['waterMarkText']则覆盖$config->waterMarkText中设置的默认值
     * 区分大小写
     * @return string
     */
    public function text_water_mark($image=null, $x='right', $y='down', $option=[]){
        return $this->TextAddImage->water_mark($image,$x,$y,$option);
    }
    public function text_create_image($text,$option=[]){
        return $this->TextCreateImage->text_create_image($text,$option);
    }
    public function captcha_creat(){
        return $this->Captcha->create();
    }
    public function captcha_check($code){
        return $this->Captcha->check($code);
    }

}