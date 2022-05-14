<?php

//协程容器
use Swoole\Timer;
//图文合成
use Hahadu\ImageFactory\Config\Config;
use Hahadu\ImageFactory\Kernel\Factory;
use PHProbot\Api;
$return=PHProbot\Api::MsgS($MsgS_Data=["msg"=>"语音点歌","data"=>$msg]);

if ($return !=null){
$ge=urlencode($return);
$str="https://autumnfish.cn/search?keywords=".$ge;
$str=file_get_contents($str);
$str=json_decode($str,true);
$str=$str['result'];
$str=$str['songs'];//歌曲列表
$ge1=$str[0];
$id=$ge1['id'];
if ($id==null){
$Api_data = array(
"qun"=>$qun,
"qq"=>$qq,
"msg"=>"获取失败",
"S_type"=>$msg_type,
"msg_id"=>$msg_id
);
$data=PHProbot\Api::send($Api_data);
$ws -> push($frame->fd, $data);
}else{
file_put_contents($qq."song.txt","语音#".$return[1]);

for ($i=0;$i<20;$i++){

$list = ($i+1).".<".$str[$i]['name'].">--".$str[$i]['artists'][0]['name']."\r\n";

file_put_contents($qq."song_list.txt",$list,FILE_APPEND);

}
file_put_contents($qq."song_list.txt",$list."PS：10秒内有效",FILE_APPEND);
$text = file_get_contents($qq."song_list.txt","r");
$config = new Config();
$config->setSavePath="../gocq/data/images/";
Factory::setOptions($config);
$option=[
'background'=>'#f5f5dc',
'fill_color'=>'#000000',
'font_size'=>'30',
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
$ws -> push($frame->fd, $data);
Swoole\Timer::after(15000, function() use($qq){
if (file_exists($qq."song_list.txt")==true){
unlink($qq."song_list.txt");
}
});
}
}
?>
