<?php
use Hahadu\ImageFactory\Config\Config;
use Hahadu\ImageFactory\Kernel\Factory;
function Text_Images(string $text, int $qq):
	bool {
		$config = new Config();
		$config->setSavePath = "../gocq/data/images/";
		Factory::setOptions($config);
		$option = ['background' => '#f5f5dc', 'fill_color' => '#000000', 'font_size' => '20', 'filename' => $qq, 'format' => 'png', ];
		$text_mark_url = Factory::text_to_image()->text_create_image($text, $option);
		$Absolute_Path = substr($_SERVER['SCRIPT_FILENAME'], 0, -10);
		//本地的绝对路径
		$dst_path = 'Mukuro.png'; //背景图
		$src_path = "./images/" . $qq . ".png"; //头像
		$hz = substr(strrchr($dst_path, '.'), 1);
		$path = $Absolute_Path . 'images/';
		//生成新图片名
		$image = $path . $qq . "." . $hz;
		//创建图片的实例
		$dst = imagecreatefromstring(file_get_contents($dst_path));
		$src = imagecreatefromstring(file_get_contents($src_path));
		list($width, $height, $type, $attr) = getimagesize("./images/" . $qq . ".png");
		//获取水印图片的宽高
		$src_w = $width;
		$src_h = $height;
		list($src_w, $src_h) = getimagesize($src_path);
		//如果水印图片本身带透明色，则使用imagecopy方法
		imagecopy($dst, $src, $width, $height, 0, 0, $src_w, $src_h);
		//输出图片
		list($src_w, $src_h, $dst_type) = getimagesize($dst_path);
		switch ($dst_type) {
			case 1: //GIF
				imagegif($dst, $image);
			break;
			case 2: //JPG
				imagejpeg($dst, $image);
			break;
			case 3: //PNG
				//              header('Content-Type: image/png');
				imagepng($dst, $image);
			break;
			default:
			break;
		}
		copy("./images/" . $qq . ".png", "../gocq/data/images/" . $qq . ".jpg");
		return true;
	}
	function Auto_doc(int $qq):
		bool {
			$Mukuro_doc_First = "<---六儿的小功能--->\r\n";
			$data = file_get_contents("./Doc/Mukuro_Menu_Doc/Menu.doc");
			$Mukuro_doc = $Mukuro_doc_First . $data;
			return Text_Images($Mukuro_doc, $qq);
		}
	function Text_Images_one(string $text, int $qq,string $path='./images/Mukuro_background.png'):string{
	$config =[
    'bg' => $path,//背景图片路径
    'format'=>'jpg',//支持jpg、png、gif
    'quality'=>75,//压缩质量（0-100），输出格式为jpg时比较明显
    'text' => [
        [
            'text' => $text,
            'left' => 100, 
            'top' => 100,
            'fontSize' =>28,
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
$img=$Poster->make("./images/".$qq.".jpg");//当$filename=''时，会返回图片数据流，可以结合response直接输出到浏览器

$image = './images/'.$qq.'.jpg';
        $config = new Config();
        $config->setSavePath = 'images/';
        $config->waterMarkText = 'Mukuro_Bot\n'.'操作者：'.$qq; //设置水印文字，支持\n换行符
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

copy('.'.$text_water_mark, "../gocq/data/images/" . $qq . ".jpg");
if(!$img){
    $err=$Poster->errMsg;
}
return "[CQ:image,file=".$qq.".jpg]";
	}
?>
