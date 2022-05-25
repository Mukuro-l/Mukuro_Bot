<?php
include "./vendor/autoload.php";
use Hahadu\ImageFactory\Config\Config;
use Hahadu\ImageFactory\Kernel\Factory;

if (!function_exists("To_wimage")){
//带水印
function To_wimage($file,$qq){
if (!empty($file)){
$image = $file;
$config = new Config();
$config->setSavePath = 'images/';
$config->waterMarkText = 'PHProbot'; //设置水印文字，支持\n换行符
$config->TextStyle = [
'font_size' => 50, //字体大小
];
Factory::setOptions($config);
$text_water_mark = Factory::text_to_image()->text_water_mark($image,$x='right',$y='down',$option=[]);
copy($text_water_mark,"../gocq/data/images/".$qq.".jpg");
unlink($text_water_mark);
return "[CQ:image,file=".$qq.".jpg]";
}
}

}

if (!function_exists("To_image")){
function To_image($text,$qq){
if (!empty($text)){
$config = new Config();
$config->setSavePath="images/";
Factory::setOptions($config);
$option=[
'background'=>'#f5f5dc',
'fill_color'=>'#000000',
'font_size'=>'20',
'filename'=>$qq,
'format'=>'jpg',
];
$text_mark_url = Factory::text_to_image()->text_create_image($text,$option);
$file=$text_mark_url;

return To_wimage($file,$qq);
}
}
}

?>