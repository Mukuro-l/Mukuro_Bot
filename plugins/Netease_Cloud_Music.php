<?php

//协程容器

use Swoole\Coroutine;

use function Swoole\Coroutine\run;

$server_msg = new bot_msg_api();

if (preg_match("/^语音点歌 ?(.*)\$/",$msg,$return)){
 if ($return[1]==""){
 $_msg="没有歌名你点nm！";
 $S_type = $msg_type;
 $return_msg = $server_msg -> send($qun,$_msg,$qq,$S_type,$msgid);
 $ws -> push($frame->fd, $return_msg);
}else{
$ge=urlencode($return[1]);
$str="https://autumnfish.cn/search?keywords=".$ge;
$str=file_get_contents($str);
$str=json_decode($str,true);
$str=$str['result'];
$str=$str['songs'];//歌曲列表
$ge1=$str[0];
$id=$ga1['id'];
 if ($id==""){
 $_msg="获取失败";
$S_type = $msg_type;
$return_msg = $server_msg->send($qun,$_msg,$qq,$S_type,$msgid);  
echo "bot发送消息：[".$_msg."]\n";
$ws->push($frame->fd, $return_msg);
}else{
for ($i=0;$i<20;$i++){
$list = "1.".$str[$i]."\r\n";
file_put_contents($qq."song_list.txt",$list,FILE_APPEND);
}

$list = file_get_contents($qq."song_list.txt","r");

$S_type = $msg_type;

 $_msg = $list;

 $return_msg=$server_msg->send($qun,$_msg,$qq,$S_type,$msgid);

 echo "bot发送消息：[".$_msg."]\n";

$ws->push($frame->fd, $return_msg);

if (preg_match("/^[0-9]+$/u", $msg, $return)){

if (file_exists($qq."song_list.txt")==true){

$ga1=$str[$return[0]];//选歌

$id = $ge1["id"];

$data_array=array(

                 "qq"=>$qq,

                 "id"=>$id

         );

         $data_array=json_encode($data_array);

         file_put_contents("Netease_Cloud_Music.json",$data_array

);

go(function () {

        $data=file_get_contents("Netease_Cloud_Music.json");

 $data=json_decode($data,true);

 $qq=$data["qq"];

 $id=$data["id"];

$url = "http://music.163.com/song/media/outer/url?id=".$id.".mp3"

;

$url_data = file_get_contents($url);

file_put_contents("../gocq/data/voices/".$qq."-music.mp3",$url_data);

echo "协程[".Coroutine::getcid()."]执行完毕\n";

//获取cid

    //Coroutine::getcid()

    //创建新协程

    //Coroutine::create

        //延时执行

//Coroutine::sleep(.2);

}                                                                );

 $S_type = $msg_type;

 $_msg = "[CQ:record,file=".$qq."-music.mp3]";

 $return_msg=$server_msg->send($qun,$_msg,$qq,$S_type,$msgid);

 echo "bot发送消息：[".$_msg."]\n";

  $ws->push($frame->fd, $return_msg);

  unlink($qq."song_list.txt");

 }

 }

 }

 }

 }

 

 if (preg_match("/^点歌 ?(.*)\$/",$msg,$return)){ 

 if ($return[1]==""){

 $_msg="没有歌名你点nm！";

 $S_type = $msg_type;

 

 $return_msg = $server_msg -> send($qun,$_msg,$qq,$S_type,$msgid);

 $ws -> push($frame->fd, $return_msg);

}else{

$ge=urlencode($return[1]);

$str="https://autumnfish.cn/search?keywords=".$ge;

$str=file_get_contents($str);

$str=json_decode($str,true);

$str=$str['result'];

$str=$str['songs'];//歌曲列表

$ga1=$str[0];//选歌

$id=$ga1['id'];

 if ($id==""){

 $_msg="获取失败";

$S_type = $msg_type;

$return_msg = $server_msg->send($qun,$_msg,$qq,$S_type,$msgid);  

echo "bot发送消息：[".$_msg."]\n";

$ws->push($frame->fd, $return_msg);

}else{

file_put_contents($qq."song.txt",$return[1]);

for ($i=0;$i<20;$i++){

$list = ($i+1).".<".$str[$i]['name'].">--".$str[$i]['artists'][0]['name']."\r\n";

file_put_contents($qq."song_list.txt",$list,FILE_APPEND);

}

$list = file_get_contents($qq."song_list.txt","r");

$S_type = $msg_type;

 $_msg = $list;

 $return_msg=$server_msg->send($qun,$_msg,$qq,$S_type,$msgid);

 echo "bot发送消息：[".$_msg."]\n";

$ws->push($frame->fd, $return_msg);

}

}

}

if (preg_match("/^[0-9]+$/u", $msg, $return_list)){

if (file_exists($qq."song_list.txt")==true){

$song=file_get_contents($qq."song.txt");

$ge=urlencode($song);

$str="https://autumnfish.cn/search?keywords=".$ge;

$str=file_get_contents($str);

$str=json_decode($str,true);

$str=$str['result'];

$str=$str['songs'];//歌曲列表

$ga1=$str[$return_list[0]-1];//选歌

$id = $ga1["id"];

$S_type=$msg_type;

$_msg="[CQ:music,type=163,id=".$id."]";$return_msg = $server_msg->send($qun,$_msg,$qq,$S_type,$msgid);

echo "bot发送消息：[".$send_msg."]\n";

$ws->push($frame->fd, $return_msg);

unlink($qq."song_list.txt");

unlink($qq."song.txt");

}

}

?>
