<?php

//协程容器
use Swoole\Coroutine;
use function Swoole\Coroutine\run;
//图文合成
use Hahadu\ImageFactory\Config\Config;
use Hahadu\ImageFactory\Kernel\Factory;
//自动文档
//use mumbaicat\makeapidoc\ApiDoc;
//生成消息JSON
use PHProbot\Api;
/*$doc = new ApiDoc(__DIR__.'/Netease_Cloud_Music.php');
echo $doc->make("./docs/");
*/

if (preg_match("/^语音点歌 ?(.*)\$/",$msg,$return)){
 if ($return[1]==null){
 $Api_data = array(
"qun"=>$qun,
"qq"=>$qq,
"msg"=>"点什么？名字呢？你吃了？",
"S_type"=>$msg_type,
"msg_id"=>$msg_id
);
$data=PHProbot\Api::send($Api_data);
$ws -> push($frame->fd, $data);
}else{
$ge=urlencode($return[1]);
$str="https://autumnfish.cn/search?keywords=".$ge;
$str=file_get_contents($str);
$str=json_decode($str,true);
$str=$str['result'];
$str=$str['songs'];//歌曲列表
$ge1=$str[0];
$id=$ga1['id'];
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



}
file_put_contents($qq."song_list.txt",$list."PS：10秒内有效",FILE_APPEND);
$list = file_get_contents($qq."song_list.txt","r");
$S_type = $msg_type;
$config = new Config();
$config->setSavePath="../gocq/data/images/";
Factory::setOptions($config);
$option=[
'background'=>'#ff3cc1',
'fill_color'=>'#fff',
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
$ws -> push($frame->fd, $data);
Swoole\Timer::after(10000, function() use($qq){
if (file_exists($qq."song_list.txt")==true){
unlink($qq."song_list.txt");
}
});
}
}
}

 

if (preg_match("/^点歌 ?(.*)\$/",$msg,$return)){ 
if ($return[1]==null){
 $Api_data = array(
"qun"=>$qun,
"qq"=>$qq,
"msg"=>"点什么？名字呢？你吃了？",
"S_type"=>$msg_type,
"msg_id"=>$msg_id
);
$data=PHProbot\Api::send($Api_data);
$ws -> push($frame->fd, $data);
}else{

$ge=urlencode($return[1]);

$str="https://autumnfish.cn/search?keywords=".$ge;

$str=file_get_contents($str);

$str=json_decode($str,true);

$str=$str['result'];

$str=$str['songs'];//歌曲列表

$ga1=$str[0];//选歌

$id=$ga1['id'];

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

file_put_contents($qq."song.txt","点歌#".$return[1]);

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
'background'=>'#ff3cc1',
'fill_color'=>'#fff',
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
$ws -> push($frame->fd, $data);
Swoole\Timer::after(10000, function() use($qq){
if (file_exists($qq."song_list.txt")==true){
unlink($qq."song_list.txt");
}
});
}

}

}

if (preg_match("/^[0-9]+$/u", $msg, $return_list)){

if (file_exists($qq."song_list.txt")==true){

$song=file_get_contents($qq."song.txt");
$data_one = explode("#",$song);
$data1 = $data_one[0];
if ($data1 == "语音"){
$data2 = $data_one[1];
$ge=urlencode($data2);

$str="https://autumnfish.cn/search?keywords=".$ge;

$str=file_get_contents($str);

$str=json_decode($str,true);

$str=$str['result'];

$str=$str['songs'];//歌曲列表

$ga1=$str[$return_list[0]-1];//选歌

$id = $ga1["id"];
file_put_contents("Netease_Cloud_Music.txt",$id);
go(function () {
$id=file_get_contents("Netease_Cloud_Music.txt");
$url = "http://music.163.com/song/media/outer/url?id=".$id.".mp3";
$url_data = file_get_contents($url);
file_put_contents("../gocq/data/voices/".$id.".mp3",$url_data);

echo "协程[".Coroutine::getcid()."]执行完毕\n";

//获取cid

    //Coroutine::getcid()

    //创建新协程

    //Coroutine::create

        //延时执行

//Coroutine::sleep(.2);

}
);
$Api_data = array(
"qun"=>$qun,
"qq"=>$qq,
"msg"=>"[CQ:record,file=".$id.".mp3]",
"S_type"=>$msg_type,
"msg_id"=>$msg_id
);
$data=PHProbot\Api::send($Api_data);
$ws -> push($frame->fd, $data);
unlink($qq."song_list.txt");
}else{
$song=file_get_contents($qq."song.txt");
$data_one = explode("#",$song);
$data1 = $data_one[0];
$data2 = $data_one[1];

$ge=urlencode($data2);

$str="https://autumnfish.cn/search?keywords=".$ge;

$str=file_get_contents($str);

$str=json_decode($str,true);

$str=$str['result'];

$str=$str['songs'];//歌曲列表

$ga1=$str[$return_list[0]-1];//选歌

$id = $ga1["id"];
$Api_data = array(
"qun"=>$qun,
"qq"=>$qq,
"msg"=>"[CQ:music,type=163,id=".$id."]",
"S_type"=>$msg_type,
"msg_id"=>$msg_id
);
$data=PHProbot\Api::send($Api_data);
$ws -> push($frame->fd, $data);

unlink($qq."song_list.txt");

unlink($qq."song.txt");

}
}

}

?>
