<?php

$server_msg = new bot_msg_api();

if ($msg == "菜单"){

$S_type = $msg_type;

$url_qq="http://q.qlogo.cn/headimg_dl?dst_uin=".$qq."&spec=640&img_type=jpg";

$_msg = "[CQ:image,file=".$url_qq."]-----[菜单]-----\r\n点歌+歌名🌻语音点歌+歌名\r\n抖音🐻截图+网址(不要+)";

$return_msg = $server_msg->send($qun,$_msg,$qq,$S_type,$msgid);

echo "bot发送消息：[".$_msg."]\n";

$ws->push($frame->fd, $return_msg);

}

?>
