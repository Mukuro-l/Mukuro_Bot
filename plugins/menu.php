<?php

$server_msg = new bot_msg_api();

if ($msg == "菜单"){

$bots_msg_type = $msg_type;

$url_qq="http://q.qlogo.cn/headimg_dl?dst_uin=".$qq."&spec=640&img_type=jpg";

$send_msg = "[CQ:image,file=".$url_qq."]-----[菜单]-----\r\n测试菜单";

$return_msg = $server_msg->send($host,$qun,$send_msg,$qq,$bots_msg_type,$msgid);echo 'bot发送消息：['.$send_msg.']\n';

$ws->push($frame->fd, $return_msg);

}

?>
