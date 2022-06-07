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
 *  | Date: 2020/10/30 下午12:12
 *  +----------------------------------------------------------------------
 *  | Description:   FilesHelper
 *  +----------------------------------------------------------------------
 **/

namespace Hahadu\ImageFactory\Kernel\Helper\Traits;


use Hahadu\Helper\FilesHelper;

trait FilesTrait
{
    public function mkdir($dirname){
        return FilesHelper::mkdir($dirname);
    }
    public function dir_files_list($dir, $pattern="*"){
        return FilesHelper::dir_files_list($dir, $pattern);
    }
    public function get_save_path($save_path=''){
        if(null!=$save_path){
            $this->save_path = $save_path;
        }
        $this->mkdir($this->save_path);
        return $this->save_path;
    }


}