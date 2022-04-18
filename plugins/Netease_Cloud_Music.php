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

$ga1=$str[0];//选歌

$id=$ga1['id'];

 if ($id==""){

 $_msg="获取失败";

$S_type = $msg_type;

$return_msg = $server_msg->send($qun,$_msg,$qq,$S_type,$msgid);  

echo "bot发送消息：[".$_msg."]\n";

$ws->push($frame->fd, $return_msg);

}else{

run(function ($id,$qq) {

$url = "http://music.163.com/song/media/outer/url?id=".$id.".mp3";

$url_data = file_get_contents($url);

file_put_contents($qq."-music.mp3",$url_data);

//获取cid

    //Coroutine::getcid()

    //创建新协程

    //Coroutine::create

        //延时执行

        //Coroutine::sleep(.2);

}

echo "协程[".Coroutine::getcid()."]执行完毕\n";

);

 $S_type = $msg_type;

 $_msg = "[CQ:record,file=".dirname(__FILE__)."/".$qq."-music.mp3]";

 $return_msg=$server_msg->send($qun,$_msg,$qq,$S_type,$msgid);

 echo "bot发送消息：[".$_msg."]\n";

  $ws->push($frame->fd, $return_msg);

 }

 }

 }

 

 if (preg_match("/^点歌 ?(.*)\$/",$msg,$return)){ if ($return[1]==""){

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

$S_type=$msg_type;

$_msg="[CQ:music,type=163,id=".$id."]";$return_msg = $server_msg->send($qun,$_msg,$qq,$S_type,$msgid);

echo "bot发送消息：[".$send_msg."]\n";

$ws->push($frame->fd, $return_msg);

}

}

}

?>
