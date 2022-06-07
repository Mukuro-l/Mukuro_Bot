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
 *  | Date: 2020/10/28 下午8:07
 *  +----------------------------------------------------------------------
 *  | Description:   HELPER
 *  +----------------------------------------------------------------------
 **/

namespace Hahadu\ImageFactory\Kernel\Helper;
use Hahadu\ImageFactory\Config\Config;
use Hahadu\ImageFactory\Kernel\Extend\Constants;
use Hahadu\ImageFactory\Kernel\Extend\ImagickConfig;
use Hahadu\ImageFactory\Kernel\Models\PositionModel;
use Hahadu\ImageFactory\Kernel\Helper\Traits\StringTrait;
use Hahadu\ImageFactory\Kernel\Helper\Traits\FilesTrait;

class BaseHelper
{
    use StringTrait;
    use FilesTrait;
    private $AddText;
    private $config;
    /****
     * @var Config
     */

    private $save_path;
    private $get_font_path;
    /****
     * @var ImagickConfig $config
     */
    public function __construct($config){
        $this->config = $config;
        $this->save_path = $config->getSavePath();
    }
    private function static_path(){
        return dirname(dirname(dirname(__DIR__))).Constants::DS.'static/';
    }
    public function get_verify_bg(){
        $bg_path = $this->static_path().'verify_bgs'.Constants::DS;
        return $this->dir_files_list($bg_path);
    }

    public function get_font_path($font_name=''){
        $font_path = $this->static_path().'fonts'.Constants::DS;
        if(null !=$font_name){
            $result = $font_path.$font_name;
        }else{
            $result = $this->dir_files_list($font_path);
        }
        return $result;
    }
    /****
     * 获取字符串最长一行的长度
     * @param string $text
     * @param int|null $line
     * @return false|int|mixed
     */
    public function get_str_max_len($text,$line=null){
        if(!is_int($line)){
            $line = mb_substr_count($text,PHP_EOL)+1;
        }
        if($line>1) {
            $w_arr = explode(PHP_EOL, $text);
            for ($i = 0; $i < $line; $i++) {
                $chines_len = mb_strlen($this->get_chines($w_arr[$i]));
                $count_space = substr_count($w_arr[$i],' ')/2.5;
                if($chines_len!=0) {
                    $arr_len[$i] = mb_strlen($w_arr[$i], 'utf-8') / 3 +
                        $count_space +
                        ($chines_len);
                }else{
                    $arr_len[$i] = mb_strlen($w_arr[$i])/2.15+$count_space;
                }
            }
            $len = max($arr_len);
        }else{
            $chines_len = mb_strlen($this->get_chines($text));
            $count_space = substr_count($text,' ')/2.5;
            if($chines_len!=0){
                $len = mb_strlen($text)/3+$chines_len+$count_space;
            }else{
                $len = mb_strlen($text)/2.15+$count_space;
            }
        }
        return $len;
    }

    public function position(){
        return new PositionModel();
    }

    /****
     * 获取文本行数
     * @param $text
     * @param string $feed 换行符
     * @return int
     */
    public function get_text_line($text){
        try {
            return mb_substr_count($text,PHP_EOL)+1;
        }catch (\Exception $e){
            return json_encode($e);
        }
    }


}