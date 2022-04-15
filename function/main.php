<?php

//第一阶段实验
if ($msg == "你好"){
$bots_msg_type = "群聊";
$send_msg = "你也好";
$server_msg = new bot_msg_api();
$server_msg->send($host,$qun,$send_msg,$qq,$bots_msg_type,$msgid);

}

?>
