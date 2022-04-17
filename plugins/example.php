<?php

//该文件为PHProbot插件开发示例

//创建一个消息类

$Server_msg = new bot_msg_api();

//开始识别消息内容

if ($msg == "测试"){

//设置消息发送类型

//$msg_type 为自动识别的消息来源[群聊、私聊]

$S_type = $msg_type;

//设置发送消息内容

$_msg = "Hello, World";

//调用消息类 send函数

$return_msg = $Server_msg -> send($qun,$_msg,$qq,$S_type,$msgid);

//调用swoole提交

$ws -> push($frame->fd, $return_msg);

//返回

 echo "bot发送消息：[".$_msg."]\n";

}

?>
