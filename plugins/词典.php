<?php
use PHProbot\Api;
//图文合成
use Hahadu\ImageFactory\Config\Config;
use Hahadu\ImageFactory\Kernel\Factory;
$return=PHProbot\Api::MsgS($MsgS_Data=["msg"=>"词典","data"=>$msg]);
if ($return!=null){
$url = "https://api.iyk0.com/gzs/?msg=".urlencode($return);
$data = file_get_contents($url);
$data = json_decode($data,true);
$sum = $data["sum"];
for ($i=0;$i<$sum;$i++){

$list = ($i+1).".".$data["data"][$i]["title"]."\r\n";
file_put_contents($qq."word.txt",$list,FILE_APPEND);
}
$text = file_get_contents($qq."word.txt","r");
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
$img = file_get_contents("./images/".$qq.".jpg");
file_put_contents("../gocq/data/images/".$qq.".jpg", $img);
$Api_data = array(
"qun"=>$qun,
"qq"=>$qq,
"msg"=>"[CQ:image,file=".$qq.".jpg]",
"S_type"=>$msg_type,
"msg_id"=>$msg_id
);
$data=PHProbot\Api::send($Api_data);
Swoole\Timer::after(10000, function() use($qq){
if (file_exists($qq."word.txt")==true){
unlink($qq."word.txt");
}
});
}
?>
