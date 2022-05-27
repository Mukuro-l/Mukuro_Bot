<?php
use Hahadu\ImageFactory\Config\Config;
use Hahadu\ImageFactory\Kernel\Factory;

if (@$Api_data["image"]==true){
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
$text_mark_url = Factory::text_to_image()->text_create_image($Api_data["text"],$option);

copy("./images/".$qq.".jpg","../gocq/data/images/".$qq.".jpg");

}
?>