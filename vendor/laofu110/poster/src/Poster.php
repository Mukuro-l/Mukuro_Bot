<?php
namespace Laofu\Image;
class Poster {

    public $errMsg = '';
    public $config = [];
    private $backGroundImage = '';
    private $fontPath = '';
    private $bgImageData = null;
	private $format='png';
	
	public function __construct($config=[],$font=false){
		if(!$font){
			$this->fontPath=dirname(__FILE__) . '/fonts/';
		}else{
			$this->fontPath=$font;
		}
		$this->backGroundImage = isset($config['bg']) ? $config['bg'] : '';
		$this->format=isset($config['format'])?$config['format']:'png';
		$this->quality=isset($config['quality'])?$config['quality']:90;
        $imageDefault = array(
            'url' => '', //图片路径
            'left' => 0,//左边距
            'top' => 0,//上边距
            'right' => 0,//有边距
            'bottom' => 0,//下边距
            'width' => 0,//宽
            'height' => 0,//高
            'radius' => 0, //圆角度数，最大值为显示宽度的一半
            'opacity' => 100//透明度
        );
        $textDefault = array(
            'text' => '',//显示文本
            'left' => 0,//左边距
            'top' => 0,//上边距
            'width' => 0, //文本框宽度，设置后可实现文字换行
            'fontSize' => 32, //字号
            'fontPath' => 'msyh.ttf', //字体文件
            'fontColor' => '255,255,255', //字体颜色
            'angle' => 0, //倾斜角度
        );

        if (isset($config['image']) && $config['image']) {
            foreach ($config['image'] as $k => $v) {
                $this->config['image'][$k] = array_merge($imageDefault, $v);
            }
        } else {
            $this->config['image'] = array();
        }
        if (isset($config['text']) && $config['text']) {
            foreach ($config['text'] as $k => $v) {
                $this->config['text'][$k] = array_merge($textDefault, $v);
            }
        } else {
            $this->config['text'] = array();
        }
	}	 

    /*
     * 合并生成海报
     * @param $fileName string 指定生成的图片路径，不传则直接返回图片数据流
     * @return string or bool 图片数据流或者处理结果状态
     */
    public function make($fileName = ''){
		$formats=['png'=>'imagepng','jpg'=>'imagejpeg','gif'=>'imagegif'];
		if(!in_array($this->format,array_keys($formats))){
			$this->errMsg = '输出图片格式错误！';
			return false;
		}
        $this->errMsg = null;
        if (!$this->backGroundImage) {
            $this->errMsg = '请先设置有效的海报背景图片';
            return false;
        }
        //背景方法
        if (!$this->bgImageData) {
			$bgRs=$this->getImgData($this->backGroundImage);
			if(!$bgRs){
				return false;
			}
            $backgroundInfo = $bgRs['info'];
            $bgData = $bgRs['res'];
            $backgroundWidth = imagesx($bgData);    //背景宽度
            $backgroundHeight = imagesy($bgData);   //背景高度
            $this->bgImageData = imageCreatetruecolor($backgroundWidth, $backgroundHeight);
            //创建透明背景色，主要127参数，其他可以0-255，因为任何颜色的透明都是透明
            $transparent = imagecolorallocatealpha($this->bgImageData, 0, 0, 0, 127);
            //指定颜色为透明
            imagecolortransparent($this->bgImageData, $transparent);
            //保留透明颜色
            imagesavealpha($this->bgImageData, true);
            //填充图片颜色
            imagefill($this->bgImageData, 0, 0, $transparent);
            imagecopyresampled($this->bgImageData, $bgData, 0, 0, 0, 0, $backgroundWidth, $backgroundHeight, $backgroundWidth, $backgroundHeight);
        }
        $bgImgData = $this->bgImageData;

        //处理图片
        if ($this->config['image']) {
            foreach ($this->config['image'] as $key => $val) {
                $imgRs=$this->getImgData($val);
				if(!$imgRs){
					return false;
				}
				$res=$imgRs['res'];
				$info=$imgRs['info'];
                imagesavealpha($res, true); //这里很重要;
                $resWidth = $info[0];
                $resHeight = $info[1];

                if ($val['radius']) {
                    if ($val['radius'] > round($val['width'] / 2)) {
                        $this->errMsg = '图片“' . $val['url'] . '”的圆角度数最大不能超过：' . (round($val['width'] / 2));
                        return false;
                    }
                    $canvas = $this->setRadiusImage($res, $resWidth, $resHeight, $val['width'], $val['height'], $val['radius']);
                } else {
                    $canvas = imagecreatetruecolor($val['width'], $val['height']);
                    //创建透明背景色，主要127参数，其他可以0-255，因为任何颜色的透明都是透明
                    $transparent = imagecolorallocatealpha($canvas, 0, 0, 0, 127);
                    //指定颜色为透明
                    imagecolortransparent($canvas, $transparent);
                    //保留透明颜色
                    imagesavealpha($canvas, true);
                    //填充图片颜色
                    imagefill($canvas, 0, 0, $transparent);
                    //关键函数，参数（目标资源，源，目标资源的开始坐标x,y, 源资源的开始坐标x,y,目标资源的宽高w,h,源资源的宽高w,h）
                    imagecopyresampled($canvas, $res, 0, 0, 0, 0, $val['width'], $val['height'], $resWidth, $resHeight);
                }
                $val['left'] = $val['left'] < 0 ? $backgroundWidth - abs($val['left']) - $val['width'] : $val['left'];
                $val['top'] = $val['top'] < 0 ? $backgroundHeight - abs($val['top']) - $val['height'] : $val['top'];
                //放置图像
                imagecopymerge($bgImgData, $canvas, $val['left'], $val['top'], $val['right'], $val['bottom'], $val['width'], $val['height'], $val['opacity']); //左，上，右，下，宽度，高度，透明度
            }
        }

        //处理文字
        if ($this->config['text']) {
            foreach ($this->config['text'] as $key => $val) {
                $fontPath = $this->fontPath . $val['fontPath'];
                if ($val['width']) {
                    $val['text'] = $this->stringAutoWrap($val['text'], $val['fontSize'], $val['angle'], $fontPath, $val['width']);
                }
                list($R, $G, $B) = explode(',', $val['fontColor']);
                $fontColor = imagecolorallocate($bgImgData, $R, $G, $B);
                $val['left'] = $val['left'] < 0 ? $backgroundWidth - abs($val['left']) : $val['left'];
                $val['top'] = $val['top'] < 0 ? $backgroundHeight - abs($val['top']) : $val['top'];
                imagettftext($bgImgData, $val['fontSize'], $val['angle'], $val['left'], $val['top'], $fontColor, $fontPath, $val['text']);
            }
        }
		$imgFn=$formats[$this->format];
		if($this->format=='png'){
			$this->quality=intval(($this->quality)/10);
		}
        if ($fileName) {
            $res = $imgFn($bgImgData, $fileName, $this->quality); //保存到本地
            ImageDestroy($bgImgData);
            if (!$res) {
                $this->errMsg = '图片保存失败';
                return false;
            } else {
                return true;
            }
        } else {
            ob_start();
            $imgFn($bgImgData,'', $this->quality);
            $content = ob_get_contents();
            ob_end_clean();
            ImageDestroy($bgImgData);
            if (!$content) {
                $this->errMsg = '图片数据获取失败';
                return false;
            }
            return $content;
        }
    }

    //生成圆角图片
    private function setRadiusImage(&$imgData, $resWidth, $resHeight, $w, $h, $radius = 10) {
        $img = imagecreatetruecolor($w, $h);
        //创建透明背景色，主要127参数，其他可以0-255，因为任何颜色的透明都是透明
        $transparent = imagecolorallocatealpha($img, 0, 0, 0, 127);
        //指定颜色为透明
        imagecolortransparent($img, $transparent);
        //保留透明颜色
        imagesavealpha($img, true);
        //填充图片颜色
        imagefill($img, 0, 0, $transparent);
        imagecopyresampled($imgData, $imgData, 0, 0, 0, 0, $w, $h, $resWidth, $resHeight); //将原图缩放尺寸重新获得数据流
        $r = $radius; //圆 角半径
        for ($x = 0; $x < $w; $x++) {
            for ($y = 0; $y < $h; $y++) {
                $rgbColor = imagecolorat($imgData, $x, $y);
                if (($x >= $radius && $x <= ($w - $radius)) || ($y >= $radius && $y <= ($h - $radius))) {
                    //不在四角的范围内,直接画
                    imagesetpixel($img, $x, $y, $rgbColor);
                } else {
                    //在四角的范围内选择画
                    //上左
                    $yx1 = $r; //圆心X坐标
                    $yy1 = $r; //圆心Y坐标
                    if (((($x - $yx1) * ($x - $yx1) + ($y - $yy1) * ($y - $yy1)) <= ($r * $r))) {
                        imagesetpixel($img, $x, $y, $rgbColor);
                    }
                    //上右
                    $yx2 = $w - $r; //圆心X坐标
                    $yy2 = $r; //圆心Y坐标
                    if (((($x - $yx2) * ($x - $yx2) + ($y - $yy2) * ($y - $yy2)) <= ($r * $r))) {
                        imagesetpixel($img, $x, $y, $rgbColor);
                    }
                    //下左
                    $yx3 = $r; //圆心X坐标
                    $yy3 = $h - $r; //圆心Y坐标
                    if (((($x - $yx3) * ($x - $yx3) + ($y - $yy3) * ($y - $yy3)) <= ($r * $r))) {
                        imagesetpixel($img, $x, $y, $rgbColor);
                    }
                    //下右
                    $yx4 = $w - $r; //圆心X坐标
                    $yy4 = $h - $r; //圆心Y坐标
                    if (((($x - $yx4) * ($x - $yx4) + ($y - $yy4) * ($y - $yy4)) <= ($r * $r))) {
                        imagesetpixel($img, $x, $y, $rgbColor);
                    }
                }
            }
        }
        return $img;
    }

    //文字自动换行
    private function stringAutoWrap($string, $fontsize, $angle, $fontface, $width) {
        $content = '';
        $arr = array();
        preg_match_all("/./u", $string, $arr);
        $letter = $arr[0];
        foreach ($letter as $l) {
            $newStr = $content . $l;
            $box = imagettfbbox($fontsize, $angle, $fontface, $newStr);
            if (($box[2] > $width) && ($content !== '')) {
                $content .= PHP_EOL;
            }
            $content .= $l;
        }
        return $content;
    }
	
	//下载网络图片，支持设置基础的header参数
	private function downImg($url,$timeout=120,$header=[]){
        $header['user-agent'] = isset($header['user-agent'])?$header['user-agent']:'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/29.0.1547.66 Safari/537.36';
		$header['referer']=isset($header['referer'])?$header['referer']:"";
	    $ch = curl_init();
	    curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);   
	    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
	    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	    $file = curl_exec($ch);
	    curl_close($ch);
	    if(!$file){
	    	return false;
	    }
        return $file;		
	}
	
	/*
     * 获取item里设置的图片信息
     * @param $val Array or String 图片信息
     * @return Array info图片尺寸 res图片数据流信息
     */
    private function getImgData($val){
	   if(!is_array($val)){
		   $val=['url'=>$val]; 
	   }
       if(preg_match('/^[\x{4e00}-\x{9fa5}a-zA-Z0-9_.\/:\\\\]+$/u',$val['url'])){   
		   if(preg_match('/^http(.*)$/i',$val['url'])){
			    $timeout=isset($val['timeout'])?$val['timeout']:30;
				$header=isset($val['header'])?$val['header']:[];
				$stream=$this->downImg($val['url'],$timeout,$header);
				if(!$stream){
					$this->errMsg = '图片“' . $val['url'] . '”载入失败';
				    return false;
				}
				$info = getimagesizefromstring($stream);
                $res = imagecreatefromstring($stream);
				return ['info'=>$info,'res'=>$res];
		   }else{
			    if (!is_file($val['url'])) {
					$this->errMsg = '图片“' . $val['url'] . '”不存在';
					return false;
				}
				$info = getimagesize($val['url']);
				$function = 'imagecreatefrom' . image_type_to_extension($info[2], false);
				if (!function_exists($function)) {
					$this->errMsg = '图片“' . $val['url'] . '”格式不支持';
					return false;
				}
				$res = $function($val['url']);
				return ['info'=>$info,'res'=>$res];
		   }
	   }else{
		   $info = getimagesizefromstring($val['url']);
           $res = imagecreatefromstring($val['url']);
		   return ['info'=>$info,'res'=>$res];
	   }
    }
}
