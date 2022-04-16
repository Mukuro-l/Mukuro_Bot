<?php

//第一阶段实验

$server_msg = new bot_msg_api();

if ($msg == "你好"){

$bots_msg_type = $msg_type;

$send_msg = "你也好";

$return_msg=$server_msg->send($host,$qun,$send_msg,$qq,$bots_msg_type,$msgid);echo 'bot发送消息：['.$send_msg.']\n';

$ws->push($frame->fd, $return_msg);                                       

}

?>
