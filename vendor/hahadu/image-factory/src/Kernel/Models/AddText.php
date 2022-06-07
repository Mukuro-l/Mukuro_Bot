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
 *  | Date: 2020/10/28 下午10:48
 *  +----------------------------------------------------------------------
 *  | Description:   AddTextTimage
 *  +----------------------------------------------------------------------
 **/

namespace Hahadu\ImageFactory\Kernel\Models;


use Hahadu\ImageFactory\Kernel\Kernel;

class AddText
{
    private $_kernel;

    /****
     * AddText constructor.
     * @param Kernel $kernel
     */
    public function __construct($kernel){
        $this->_kernel=$kernel;
    }

    /****
     * @param \Imagick $imagick
     * @param string $text 添加的文本
     * @param int $x
     * @param int $y
     * @param int $angle
     * @param array $style
     */
    public function add_text(& $imagick, $text, $x = 0, $y = 0, $angle = 0, $style = array()) {
        $draw = $this->_kernel->ImagickDraw()->set_text($style);

        if (strtolower ($imagick->getImageFormat ()) == 'gif') {

            foreach ( $imagick as $frame ) {

                $frame->annotateImage ( $draw, $x, $y, $angle, $text );

            }

        } else {

            $imagick->annotateImage ( $draw, $x, $y, $angle, $text );
        }
    }

}