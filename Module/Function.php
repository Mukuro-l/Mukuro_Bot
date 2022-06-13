<?php
use Hahadu\ImageFactory\Config\Config;
use Hahadu\ImageFactory\Kernel\Factory;
 
class image_blur{
 
/**
     * 图片高斯模糊（适用于png/jpg/gif格式）
     * @param $srcImg 原图片
     * @param $savepath 保存路径
     * @param $savename 保存名字
     * @param $positon 模糊程度 
     *
     *基于Martijn Frazer代码的扩充， 感谢 Martijn Frazer
     */
    public function gaussian_blur($srcImg,$savepath=null,$savename=null,$blurFactor=3){
        $gdImageResource=$this->image_create_from_ext($srcImg);
        $srcImgObj=$this->blur($gdImageResource,$blurFactor);
        $temp = pathinfo($srcImg);
        $name = $temp['basename'];
        $path = $temp['dirname'];
        $exte = $temp['extension'];
        $savename = $savename ? $savename : $name;
        $savepath = $savepath ? $savepath : $path;
        $savefile = $savepath .'/'. $savename;
        $srcinfo = @getimagesize($srcImg);
        
        switch ($srcinfo[2]) {
            case 1: imagegif($srcImgObj, $savefile); break;
            case 2: imagejpeg($srcImgObj, $savefile); break;
            case 3: imagepng($srcImgObj, $savefile); break;
            default: return '保存失败'; //保存失败
        }
 
        return $savefile;
        imagedestroy($srcImgObj);
    }
 
    /**
    * Strong Blur
    *
    * @param  $gdImageResource  图片资源
    * @param  $blurFactor          可选择的模糊程度 
    *  可选择的模糊程度  0使用   3默认   超过5时 极其模糊
    * @return GD image 图片资源类型
    * @author Martijn Frazer, idea based on http://stackoverflow.com/a/20264482
    */
    private function blur($gdImageResource, $blurFactor = 3)
    {
        // blurFactor has to be an integer
        $blurFactor = round($blurFactor);
 
        $originalWidth = imagesx($gdImageResource);
        $originalHeight = imagesy($gdImageResource);
 
        $smallestWidth = ceil($originalWidth * pow(0.5, $blurFactor));
        $smallestHeight = ceil($originalHeight * pow(0.5, $blurFactor));
 
        // for the first run, the previous image is the original input
        $prevImage = $gdImageResource;
        $prevWidth = $originalWidth;
        $prevHeight = $originalHeight;
 
        // scale way down and gradually scale back up, blurring all the way
        for($i = 0; $i < $blurFactor; $i += 1)
        {    
            // determine dimensions of next image
            $nextWidth = $smallestWidth * pow(2, $i);
            $nextHeight = $smallestHeight * pow(2, $i);
 
            // resize previous image to next size
            $nextImage = imagecreatetruecolor($nextWidth, $nextHeight);
            imagecopyresized($nextImage, $prevImage, 0, 0, 0, 0, 
              $nextWidth, $nextHeight, $prevWidth, $prevHeight);
 
            // apply blur filter
            imagefilter($nextImage, IMG_FILTER_GAUSSIAN_BLUR);
 
            // now the new image becomes the previous image for the next step
            $prevImage = $nextImage;
            $prevWidth = $nextWidth;
            $prevHeight = $nextHeight;
        }
 
        // scale back to original size and blur one more time
        imagecopyresized($gdImageResource, $nextImage, 
        0, 0, 0, 0, $originalWidth, $originalHeight, $nextWidth, $nextHeight);
        imagefilter($gdImageResource, IMG_FILTER_GAUSSIAN_BLUR);
 
        // clean up
        imagedestroy($prevImage);
 
        // return result
        return $gdImageResource;
    }
 
    private function image_create_from_ext($imgfile)
    {
        $info = getimagesize($imgfile);
        $im = null;
        switch ($info[2]) {
        case 1: $im=imagecreatefromgif($imgfile); break;
        case 2: $im=imagecreatefromjpeg($imgfile); break;
        case 3: $im=imagecreatefrompng($imgfile); break;
        }
        return $im;
    }
 
}

//$image_blur = new image_blur();
 
//$image_blur->gaussian_blur("./2.jpg

//设置图片水印
function Text_Images(string $text, int $qq):
	string {
	$size=intval(floor(strlen($text)/3));
	if ($size > 28){
	$text_size = ($size/28)+3;
	}else{
	$text_size = 28;
	}
		$config =[
		
    'bg' => "./images/Mukuro_background.png",//背景图片路径
    'format'=>'jpg',//支持jpg、png、gif
    'quality'=>100,//压缩质量（0-100），输出格式为jpg时比较明显
    'text' => [
        [
            'text' => $text,
            'left' => 100, 
            'top' => 100,
            'fontSize' =>$text_size,
            'fontColor' => '248,248,255',
            'angle' => 0,//旋转角度
        ],
    ],
    'image' =>[
        [
            'url' => './images/xx.png',//支持图片数据流、网络地址、本地路径
            'left' => 0,
            'top' => 0,
            'width' => 110,
            'height' => 110,
            'radius' => 50,
            'opacity' => 100,
        ],
    ]
];
$Poster=new \Laofu\Image\Poster($config);
$img=$Poster->make("./images/".$qq.".jpg");
		
		
		$config = new Config();
		$image="./images/".$qq.".jpg";
		$config = new Config();
        $config->setSavePath = 'images/';
        $config->waterMarkText = "Mukuro"; //设置水印文字，支持\n换行符
        $config->TextStyle = [
        //支持的配置项
            'font_size' => 20, //字体大小
            'font_weight' => 500, //字体粗细
            'fill_color' => '#000000',//字体颜色，支持标准色值，
            'under_color' => '#F8F8FF',//背景颜色，支持标准色值
            'fill_opacity' => '0.5', //浮点数0-1，透明度，这里设置透明度会覆盖fill_color中的透明度
            'stroke_width' =>0.1, //描边
        ];
        Factory::setOptions($config);
        $text_water_mark = Factory::text_to_image()->text_water_mark($image,$x='right',$y='down',$option=[]);
        rename('.'.$text_water_mark,"./images/".$qq.".jpg");
        copy('./images/'.  $qq . ".jpg", "../gocq/data/images/" . $qq . ".jpg");
		return "[CQ:image,file=".$qq.".jpg]";
	}
	
	function Auto_doc(int $qq):
		bool {
			$Mukuro_doc_First = "<---六儿的小功能--->\r\n";
			$data = file_get_contents("./Doc/Mukuro_Menu_Doc/Menu.doc");
			$Mukuro_doc = $Mukuro_doc_First . $data;
			return Text_Images($Mukuro_doc, $qq);
		}
	//Text_Images_one("作了茧的蚕，是不会看到茧壳以外的世界的",1940826077);