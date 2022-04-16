<?php

$server_msg = new bot_msg_api();

if (preg_match("/^语音点歌 ?(.*)\$/",$msg,$return)){                                  if ($return[1]==""){

 $send_msg="没有歌名你点nm！";

 $bots_msg_type = $msg_type;

 

 $return_msg = $server_msg -> send($host,$qun,$send_msg,$qq,$bots_msg_type,$msgid);

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

 $send_msg="获取失败";

$bots_msg_type = $msg_type;

$return_msg = $server_msg->send($host,$qun,$send_msg,$qq,$bots_msg_type,$msgid);  

echo 'bot发送消息：['.$send_msg.']\n';

$ws->push($frame->fd, $return_msg);

}else{

 $url= "http://music.163.com/song/media/outer/url?id=".$id.".mp3";

 $bots_msg_type = $msg_type;

 $send_msg = "[CQ:record,file=".$url."]";

 $return_msg=$server_msg->send($host,$qun,$send_msg,$qq,$bots_msg_type,$msgid);      echo 'bot发送消息：['.$send_msg.']\n';

  $ws->push($frame->fd, $return_msg);

 }

 }

 }

 

 if (preg_match("/^点歌 ?(.*)\$/",$msg,$return)){ if ($return[1]==""){

 $send_msg="没有歌名你点nm！";

 $bots_msg_type = $msg_type;

 

 $return_msg = $server_msg -> send($host,$qun,$send_msg,$qq,$bots_msg_type,$msgid);

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

 $send_msg="获取失败";

$bots_msg_type = $msg_type;

$return_msg = $server_msg->send($host,$qun,$send_msg,$qq,$bots_msg_type,$msgid);  

echo 'bot发送消息：['.$send_msg.']\n';

$ws->push($frame->fd, $return_msg);

}else{

$bots_msg_type=$msg_type;

$send_msg="[CQ:music,type=163,id=".$id."]";$return_msg = $server_msg->send($host,$qun,$send_msg,$qq,$bots_msg_type,$msgid);

echo 'bot发送消息：['.$send_msg.']\n';

$ws->push($frame->fd, $return_msg);

}

}

}

?>
