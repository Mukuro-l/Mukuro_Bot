<?php
//图文合成库
//use Hahadu\ImageFactory\Config\Config;
use Hahadu\ImageFactory\Kernel\Factory;
use PHProbot\Api;
if ($msg == "插件列表"){
$plugins_data = json_decode(file_get_contents("plugins_switch.json"),true);
for ($i=0;$i<count($plugins_data);$i++){
//插件名
$plugins_data[$i]["插件名"];
$plugins_data[$i]["状态"];
$plugins_list="插件：".$plugins_data[$i]["插件名"]." 状态：".$plugins_data[$i]["状态"]."\r\n";
file_put_contents("plugins_list.txt",$plugins_list,FILE_APPEND);
}
file_put_contents("plugins_list.txt","PS：开启|关闭+插件名 即可管理插件",FILE_APPEND);
$text=file_get_contents("plugins_list.txt");
//$config->setSavePath="../gocq/data/images/";
//Factory::setOptions($config);
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
unlink("plugins_list.txt");
}


if (strstr($msg,"关闭")==true){
$return=PHProbot\Api::MsgS($MsgS_Data=["msg"=>"关闭","data"=>$msg]);
if ($return!=null){
$BOT_Config =json_decode(file_get_contents("config.json"),true);
if ($BOT_Config["qhost"]==$qq){
$plugins_data = json_decode(file_get_contents("plugins_switch.json"),true);
do{
for ($i=0;$i<count($plugins_data);$i++){
if ($plugins_data[$i]["插件名"]==$return){
$plugins_data[$i]["状态"]="关";
file_put_contents("plugins_switch.json",json_encode($plugins_data,JSON_UNESCAPED_UNICODE));
}
}
}while($plugins_data[$i]["状态"]=="开");

$Api_data = array(
"qun"=>$qun,
"qq"=>$qq,
"msg"=>"已关闭".$return,
"S_type"=>$msg_type,
"msg_id"=>$msg_id
);
$data=PHProbot\Api::send($Api_data);
}
}

}

if (strstr($msg,"开启")==true){
$return=PHProbot\Api::MsgS($MsgS_Data=["msg"=>"开启","data"=>$msg]);
if ($return!=null){
$BOT_Config =json_decode(file_get_contents("config.json"),true);
if ($BOT_Config["qhost"]==$qq){
$plugins_data = json_decode(file_get_contents("plugins_switch.json"),true);
do{
for ($i=0;$i<count($plugins_data);$i++){
if ($plugins_data[$i]["插件名"]==$return){
$plugins_data[$i]["状态"]="开";
file_put_contents("plugins_switch.json",json_encode($plugins_data,JSON_UNESCAPED_UNICODE));
}
}
}while($plugins_data[$i]["状态"]=="关");

$Api_data = array(
"qun"=>$qun,
"qq"=>$qq,
"msg"=>"已开启".$return,
"S_type"=>$msg_type,
"msg_id"=>$msg_id
);
$data=PHProbot\Api::send($Api_data);
}
}
}
?>
