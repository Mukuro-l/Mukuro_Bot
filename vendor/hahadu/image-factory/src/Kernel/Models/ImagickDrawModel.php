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
 *  | Date: 2020/10/29 下午3:23
 *  +----------------------------------------------------------------------
 *  | Description:   setDraw
 *  +----------------------------------------------------------------------
 **/

namespace Hahadu\ImageFactory\Kernel\Models;

class ImagickDrawModel extends \ImagickDraw
{
    private $imagickDraw;

    public function set_text($set = []){
        if (isset ( $set['font'] ))

            $this->setFont( $set['font'] );

        if (isset ( $set['font_size'] ))

            $this->setFontSize( $set['font_size'] );

        if (isset ( $set['font_weight'] ))

            $this->setFontWeight( $set['font_weight'] );

        if (isset ( $set['fill_color'] ))

            $this->setFillColor( $set['fill_color'] );
        if(isset($set['stroke_width']))
            $this->setStrokeWidth($set['stroke_width']);
        if(isset($set['stroke_alpha']))
            $this->setStrokeAlpha($set['stroke_alpha']);
        if(isset($set['stroke_color']))
            $this->setStrokeColor($set['stroke_color']);
        if(isset($set['stroke_opacity']))
            $this->setStrokeOpacity($set['stroke_opacity']);

        if (isset ( $set['under_color'] ))

            $this->setTextUnderColor( $set['under_color'] );

        if (isset ( $set['font_family'] ))

            $this->setfontfamily( $set['font_family'] );

        if (isset ( $set['fill_opacity'] ))

            $this->setFillOpacity( $set['fill_opacity'] );

        $this->settextencoding('UTF-8');
        return $this;
    }

}