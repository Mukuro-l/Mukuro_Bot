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
 *  | Date: 2020/10/28 下午5:09
 *  +----------------------------------------------------------------------
 *  | Description:   ImageToText
 *  +----------------------------------------------------------------------
 **/

namespace Hahadu\ImageFactory\Manage\ImageToText;
use Hahadu\ImageFactory\Manage\ImageToText\Model\ImageToText;

class Client
{
    private $image_to_text;

    public function __construct($kernel){
        $this->image_to_text = new ImageToText($kernel);
    }
    public function to_text_color($images='', $flage=true){
        return $this->image_to_text->to_text_color($images, $flage);
    }
    public function to_text_black($images='', $flage=true){
        return $this->image_to_text->to_text_black($images, $flage);
    }

}