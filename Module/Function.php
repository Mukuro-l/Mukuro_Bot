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
copy("./images/".$qq.".jpg","../gocq/data/images/".$qq.".jpg");
return true;
}
?>
