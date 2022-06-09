<?php
use Hahadu\ImageFactory\Config\Config;
use Hahadu\ImageFactory\Kernel\Factory;

function Text_Images(string $text,int $qq):bool{
		$config = new Config();
		$config->setSavePath="../gocq/data/images/";
Factory::setOptions($config);
$option=[
'background'=>'#f5f5dc',
'fill_color'=>'#000000',
'font_size'=>'20',
'filename'=>$qq,
'format'=>'jpg',
];
$text_mark_url = Factory::text_to_image()->text_create_image($text,$option);
$Absolute_Path=substr($_SERVER['SCRIPT_FILENAME'],0,-10);
        //本地的绝对路径
        $dst_path = 'Mukuro.png';//背景图  
        $src_path= "./images/".$qq.".jpg"; //头像
        $hz = substr(strrchr($dst_path, '.'), 1);
        $path = $Absolute_Path.'images/';
        //生成新图片名
        $image = $path.$qq.".".$hz;
        //创建图片的实例
        $dst = imagecreatefromstring(file_get_contents($dst_path));
        $src = imagecreatefromstring(file_get_contents($src_path));
        //获取水印图片的宽高
        $src_w =1920;$src_h=1080;
        list($src_w,$src_h) = getimagesize($src_path);
        //如果水印图片本身带透明色，则使用imagecopy方法
        imagecopy($dst, $src, 310,130, 0, 0, $src_w, $src_h);
        //输出图片
        list($src_w, $src_h, $dst_type) = getimagesize($dst_path);
        switch ($dst_type) {
            case 1://GIF
                imagegif($dst, $image);
                break;
            case 2://JPG
                imagejpeg($dst, $image);
                break;
            case 3://PNG
//              header('Content-Type: image/png');
                imagepng($dst, $image);
                break;
            default:
                break;
        }
copy("./images/".$qq.".png","../gocq/data/images/".$qq.".jpg");
return true;
}

function Auto_doc(int $qq):bool{
$Mukuro_doc_First = "<---六儿的小功能--->\r\n";
$data = file_get_contents("./Doc/Mukuro_Menu_Doc/Menu.doc");
$Mukuro_doc = $Mukuro_doc_First.$data;
return Text_Images($Mukuro_doc,$qq);

}

?>
