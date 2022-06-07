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
 *  | Date: 2020/10/28 下午9:33
 *  +----------------------------------------------------------------------
 *  | Description:   添加文字到图像中
 *  +----------------------------------------------------------------------
 **/

namespace Hahadu\ImageFactory\Manage\TextToImage\Model;


use Hahadu\ImageFactory\Kernel\Extend\Constants;
use Hahadu\ImageFactory\Kernel\Kernel;
use Hahadu\ImageFactory\Kernel\Models\AddText;

class TextAddImage
{
    /****
     * @var Kernel
     */
    private $_kernel;
    private $path;
    private $config;
    private $AddText;
    private $style=[];

    /****
     * TextAddImage constructor.
     * @param Kernel $kernel
     */
    public function __construct($kernel){
        $this->_kernel = $kernel;
        $this->config = $kernel->config;
        $this->style = $this->config->getTextStyle();
        $this->AddText = new AddText($kernel);
    }

    /****
     * @param null $image
     * @param string|float $x
     * @param string|float $y
     * @param null $path
     * @param array|null $option 自定义水印设置
     * @return string
     */
    public function water_mark($image=null,$x='right',$y='down',$option=[]){
        $this->style = array_replace_recursive($this->style,$option);
        $path = isset($option['path'])?$option['path']:null;
        $this->path = $this->_kernel->base->get_save_path($path);
        $image_data = $this->_kernel->Imagick($image); //图像
        //获取图像信息
        $image_format = mb_strtolower($image_data->getImageFormat());
        $image_width  = $image_data->getImageWidth();
        $image_height = $image_data->getImageHeight();
        $image_file_name  = $image_data->getImageFilename();
        if(isset($option['waterMarkText'])&&null!=$option['waterMarkText']){
            $WaterMark = $option['waterMarkText'];
        }else{
            $WaterMark = $this->config->getWaterMarkText();
        }
        $style = $this->style;
        $style['stroke_width'] = 0.01;
        $style['stroke_opacity'] = 0.1;
        $style['stroke_color'] = "#00000001";

        //字符串长度 + 字符宽度 + 空格
        $line = mb_substr_count($WaterMark,PHP_EOL)+1;
        $len = $this->_kernel->base->get_str_max_len($WaterMark,$line);

        switch ($x){
            case 'right':
                $text_x = $this->_kernel->base->position()->text_right($image_width,$len,$style['font_size']);
                break;
            case 'center':
                $text_x = $this->_kernel->base->position()->text_center_x($image_width,$len,$style['font_size']);
                break;
            case is_int($x) :
                $text_x = $x;
                break;
            default :
                $text_x = $style['font_size']/2.5;
                break;
        }
        switch ($y){
            case 'down':
                $text_y = $this->_kernel->base->position()->text_down($image_height,$line,$style['font_size']);
                break;
            case 'center':
                $text_y = $this->_kernel->base->position()->text_center_y($image_height,$line,$style['font_size']);
                break;
            case is_int($y):
                $text_y = $y;
                break;
            default :
                $text_y = $style['font_size']*1.15;
                break;
        }

        $this->AddText->add_text($image_data,$WaterMark,$text_x,$text_y,0,$style);
        $file = $this->path.(base64_encode('time'.$image.$WaterMark)).Constants::DOT.mb_strtolower($image_data->getImageFormat());

        $image_data->writeImage($file);
        $image_data->destroy();

        return Constants::DS.$file;

    }




}

