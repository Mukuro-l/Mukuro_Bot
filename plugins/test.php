<?php

//第一阶段实验

$server_msg = new bot_msg_api();

if ($msg == "你好"){

$S_type = $msg_type;

$_msg = "你也好";

$return_msg=$server_msg->send($qun,$_msg,$qq,$S_type,$msgid);

echo "bot发送消息：[".$_msg."]\n";

$ws->push($frame->fd, $return_msg);                                       

}

?>
