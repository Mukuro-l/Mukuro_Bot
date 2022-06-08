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
 *  | Date: 2020/10/31 下午6:04
 *  +----------------------------------------------------------------------
 *  | Description:   Captcha
 *  +----------------------------------------------------------------------
 **/

namespace Hahadu\ImageFactory\Kernel\Models\Traits;


use Hahadu\Helper\DateHelper;
use Hahadu\ImageFactory\Kernel\Extend\Constants;

trait CaptchaTrait
{

    /**
     * 画一条由两条连在一起构成的随机正弦函数曲线作干扰线(你可以改成更帅的曲线函数)
     *
     *        正弦型函数解析式：y=Asin(ωx+φ)+b
     *      各常数值对函数图像的影响：
     *        A：决定峰值（即纵向拉伸压缩的倍数）
     *        b：表示波形在Y轴的位置关系或纵向移动距离（上加下减）
     *        φ：决定波形与X轴位置关系或横向移动距离（左加右减）
     *        ω：决定周期（最小正周期T=2π/∣ω∣）
     * @param \ImagickDraw $_draw
     * @return mixed
     */
    private function _writeCurve()
    {
        $px = $py = 0;

        // 曲线前部分
        $A = mt_rand(1, $this->imageH / 1.8); // 振幅
        $b = mt_rand(-$this->imageH / 4, $this->imageH / 4); // Y轴方向偏移量
        $f = mt_rand(-$this->imageH / 4, $this->imageH / 4); // X轴方向偏移量
        $T = mt_rand($this->imageH, $this->imageW * 2); // 周期
        $w = (2 * M_PI) / $T;

        $px1 = 0; // 曲线横坐标起始位置
        $px2 = mt_rand($this->imageW / 2, $this->imageW * 0.8); // 曲线横坐标结束位置

        // 设置曲线随机颜色
        $color_1 = $this->base->re_substr($this->_color_rand,rand(3,14),1,false);
        $color_2 = $this->base->re_substr($this->_color_rand,rand(3,14),1,false);
        $color_3 = $this->base->re_substr($this->_color_rand,rand(3,14),1,false);
        $color_4 = $this->base->re_substr($this->_color_rand,rand(9,14),1,false);
        $color = "#{$color_1}{$color_2}{$color_3}{$color_4}";

        $draw = $this->_kernel->ImagickDraw();
        $pixel = $this->_kernel->ImagickPixel($color);

        $draw->setFillColor($pixel);

        $points = [];
        for ($px = $px1; $px <= $px2; $px = $px + 1) {
            if (0 != $w) {
                $py = $A * sin($w * $px + $f) + $b + $this->imageH / 2; // y = Asin(ωx+φ) + b
                $i  = (int) ($this->fontSize / 5);
                while ($i > 0) {
                    // 这里(while)循环画像素点比imagettftext和imagestring用字体大小一次画出（不用这while循环）性能要好很多
                    //draw应该返回一个多维坐标数组，一次性填入draw
                    $draw->point($px + $i,$py + $i);
                    $i--;
                }
            }
        }

        // 曲线后部分
        $A   = mt_rand(1, $this->imageH / 2); // 振幅
        $f   = mt_rand(-$this->imageH / 4, $this->imageH / 4); // X轴方向偏移量
        $T   = mt_rand($this->imageH, $this->imageW * 2); // 周期
        $w   = (2 * M_PI) / $T;
        $b   = $py - $A * sin($w * $px + $f) - $this->imageH / 2;
        $px1 = $px2;
        $px2 = $this->imageW;

        for ($px = $px1; $px <= $px2; $px = $px + 1) {
            if (0 != $w) {
                $py = $A * sin($w * $px + $f) + $b + $this->imageH / 2; // y = Asin(ωx+φ) + b
                $i  = (int) ($this->fontSize / 5);
                while ($i > 0) {
                    $draw->point($px + $i,$py + $i);
                    $i--;
                }
            }
        }
        $this->imagick->drawImage($draw);
        $draw->destroy();
        $pixel->destroy();
    }

    /**
     * 画杂点
     * 往图片上写不同颜色的字母或数字
     */
    private function _writeNoise()
    {
        $draw = $this->_kernel->ImagickDraw();
        //添加噪点
        $this->imagick->addNoiseImage(Constants::NOISE_GAUSSIAN,Constants::CHANNEL_RGBA);

        $setNoise = $this->_set_nosie($draw);
        foreach ($setNoise as $value){
            $pixel = $this->_kernel->ImagickPixel($value['color']);

            $draw->setFontSize($value['fontSize']);
            $draw->setFillOpacity($value['FillOpacity']);

            $draw->setFillColor($pixel);
            foreach ($value['annotate'] as $v){
                $this->imagick->annotateImage($v['draw'],$v['x'], $v['y'],$v['an'],$v['code']);
            }
            $draw->destroy();
            $pixel->destroy();
        }
        return $this->imagick;
    }

    /****
     * @param array $code 验证码
     * @return array
     */
    private function _session($code){
        $code                  = $this->password(strtoupper(implode('', $code)));
        $secode                = array();
        $secode['verify_code'] = $code; // 把校验码保存到session
        $secode['verify_time'] = time(); // 验证码创建时间
        return $_SESSION[Constants::CAPTCHA]   =  $secode;
    }

    private function _set_nosie($draw){
        $codeSet = '123456789abcdefhijkmnpqrstuvwxyz%￥@&-$';

        for ($i = 0; $i < 10; $i++) {
                //杂点颜色
                $color_1 = $this->base->re_substr($this->_color_rand,rand(3,14),1,false);
                $color_2 = $this->base->re_substr($this->_color_rand,rand(3,14),1,false);
                $color_3 = $this->base->re_substr($this->_color_rand,rand(3,14),1,false);
                $color_4 = $this->base->re_substr($this->_color_rand,rand(9,14),1,false);

                $annotate = function()use($draw,$codeSet){
                    for ($j = 0; $j < 5; $j++) {
                        yield [
                            'draw'=>$draw,
                            'x' => mt_rand(-10, $this->imageW),
                            'y' => mt_rand(-10, $this->imageH),
                            'an' =>mt_rand(-10, $this->imageW),
                            'code' =>$codeSet[mt_rand(0,38)],
                        ];
                    }
                };
                yield [
                    'color' => "#{$color_1}{$color_2}{$color_3}{$color_4}",
                    'fontSize' => rand(5,$this->fontSize * 0.8),
                    'FillOpacity' => rand(0.5,1.0),
                    'annotate' => $annotate(),
                ];
            }
    }

    /****
     * 加密验证码
     * @param string $code
     * @return false|string|null
     */
    private function password($code)
    {
        $options = [
            'cost' => 11,
        ];
        $hash = password_hash(mb_strtolower($code),PASSWORD_BCRYPT,$options);
        return $hash;
    }

    private function _set_verify(){

        // 图片宽(px)
        $this->imageW || $this->imageW = $this->length * $this->fontSize * 1.5 + $this->length * $this->fontSize / 2;
        // 图片高(px)
        $this->imageH || $this->imageH = $this->fontSize * 2.5;
        // 创建画布
        $this->imagick->newImage($this->imageW, $this->imageH,'#FFF','png');

        // 设置验证码字体随机颜色
        $color_1 = $this->base->re_substr($this->_color_rand,rand(0,14),1,false);
        $color_2 = $this->base->re_substr($this->_color_rand,rand(0,14),1,false);
        $color_3 = $this->base->re_substr($this->_color_rand,rand(0,14),1,false);
        $color = "#{$color_1}{$color_2}{$color_3}";

        $this->pixel->setColor($color);
        $this->draw->setFillColor($this->pixel);
        // 验证码使用随机字体

        if (empty($this->font)) {
            $fontPath = $this->base->get_font_path();
            $this->font = $fontPath[array_rand($fontPath)];
        }
        $this->draw->setFont($this->font);
        $this->draw->setFontSize($this->fontSize);
    }
    private function _writeBackground(){
            $bgs = $this->_kernel->base->get_verify_bg();
            $bg = $this->_kernel->Imagick($bgs[array_rand($bgs)]);
                //拉伸背景
            $bg->adaptiveResizeImage($this->imageW,$this->imageH);
            $this->imagick->compositeImage($bg,Constants::COMPOSITE_ATOP,0,0);
            $bg->destroy();
    }



}