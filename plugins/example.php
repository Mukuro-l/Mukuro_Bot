<?php

//该文件为PHProbot插件开发示例

//创建一个消息类，115版本以前不支持命名空间
use PHProbot\Api;

//开始识别消息内容

if (PHProbot\Api::MC($option=["你好","测试"],$msg)==true){

//设置消息发送类型，114版本可设置[群聊、私聊]

$Api_data = array(
"qun"=>$qun,
"qq"=>$qq,
//msg为设置发送消息
"msg"=>"hello, world",
//发送消息类型
"S_type"=>$msg_type,
"msg_id"=>$msg_id
);

//调用消息类 send函数，在115版本以前不支持

$data=PHProbot\Api::send($Api_data);
$ws -> push($frame->fd, $data);
}

?>
