<?php
/*
* GitHub中国表情包库搜索
*/
use PHProbot\Api;
use Hahadu\ImageFactory\Config\Config;
use Hahadu\ImageFactory\Kernel\Factory;


$return=PHProbot\Api::MsgS($MsgS_Data=["msg"=>"表情包","data"=>$msg]);
if ($return!=null){
if (file_exists("bqb.json")==true){
$data = json_decode(file_get_contents("bqb.json"),true);

$sum=count($data["data"]);
$Emoji_package_array=[];
for ($i=0;$i<$sum;$i++){
$text=$data["data"][$i]["name"];
if (strstr($text,$return)==true){
$list="名称：".$text."\r\n链接：https://www.v2fy.com/asset/0i/ChineseBQB/".urlencode($data["data"][$i]["category"])."/".urlencode($text)."\r\n";
$Emoji_package_array[]=$list;

file_put_contents($qq."bqb_list.json",json_encode($Emoji_package_array,JSON_UNESCAPED_UNICODE));
}
}
if (file_exists($qq."bqb_list.json")==true){
$Emoji_package_array=json_decode(file_get_contents($qq."bqb_list.json"),true);
for ($i=0;$i<count($Emoji_package_array);$i++){
$Expression_data=($i+1).".".$Emoji_package_array[$i];
file_put_contents($qq."bqb_list.txt",$Expression_data,FILE_APPEND);
}
$config->setSavePath="../gocq/data/images/";
Factory::setOptions($config);
$option=[
'background'=>'#f5f5dc',
'fill_color'=>'#000000',
'font_size'=>'20',
'filename'=>$qq,
'format'=>'jpg',
];
$text = file_get_contents($qq."bqb_list.txt");
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
$Return_data=PHProbot\Api::send($Api_data);



}else{
$Api_data = array(
"qun"=>$qun,
"qq"=>$qq,
"msg"=>"抱歉，并没有你想要的资源",
"S_type"=>$msg_type,
"msg_id"=>$msg_id
);
$Return_data=PHProbot\Api::send($Api_data);
}
}else{

go(function(){

$bqb_data = file_get_contents("https://raw.githubusercontent.com/zhaoolee/ChineseBQB/master/chinesebqb_github.json");
file_put_contents("bqb.json",$bqb_data);
echo "GitHub中国表情包下载完毕";
}
);
$Api_data = array(
"qun"=>$qun,
"qq"=>$qq,
"msg"=>"已下载中国表情包数据",
"S_type"=>$msg_type,
"msg_id"=>$msg_id
);
$Return_data=PHProbot\Api::send($Api_data);
}
}


$return1=preg_match("/^[0-9]+$/u", $msg, $return);
if ($return1==true){
if (file_exists($qq."bqb_list.json")==true){
$Emoji_package_array=json_decode(file_get_contents($qq."bqb_list.json"),true);
$Api_data = array(
"qun"=>$qun,
"qq"=>$qq,
"msg"=>$Emoji_package_array[$return[0]-1],
"S_type"=>$msg_type,
"msg_id"=>$msg_id
);
$Return_data=PHProbot\Api::send($Api_data);
unlink($qq."bqb_list.txt");
unlink($qq."bqb_list.json");
}
}

?>
