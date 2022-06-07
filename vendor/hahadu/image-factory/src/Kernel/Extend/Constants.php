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
 *  | Date: 2020/10/28 下午6:53
 *  +----------------------------------------------------------------------
 *  | Description:   静态方法
 *  +----------------------------------------------------------------------
 **/

namespace Hahadu\ImageFactory\Kernel\Extend;
use Imagick;


class Constants extends Imagick
{
    const DS = '/';
    const DOT = '.';
    const MUS = '-';
    const UND = '_';
    const DEFAULT_FONTS = 'SourceHanSansCN-Light.otf';
    const CAPTCHA = 'captcha';

}