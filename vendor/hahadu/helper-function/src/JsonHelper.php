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
 *  | Date: 2020/10/22 上午11:46
 *  +----------------------------------------------------------------------
 *  | Description:   微信公众平台SDK
 *  +----------------------------------------------------------------------
 **/

namespace Hahadu\Helper;


class JsonHelper
{
    /****
     * @param mixed $data
     * @return false|string
     */
    static public function json_encode($data){
        return json_encode($data,JSON_UNESCAPED_UNICODE);
    }
    /**
     * 判断是否是json
     * @param string $string
     * @return bool
     */
    static public function isJson(string $string)
    {
        json_decode($string);

        return JSON_ERROR_NONE == json_last_error();
    }

}