<?php

//该文件为PHProbot插件开发示例

//创建一个消息类，115版本以前不支持命名空间
use PHProbot\Api;

//开始识别消息内容

if ($msg == "测试"){

//设置消息发送类型，114版本可设置[群聊、私聊]

//$msg_type 为自动识别的消息来源[群聊、私聊]

$S_type = $msg_type;

//设置发送消息内容

$_msg = "Hello, World";

//调用消息类 send函数，在115版本以前不支持

PHProbot\Api::send();

}

?>
