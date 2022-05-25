<?php

//该文件为PHProbot插件开发示例

//创建一个消息类，115版本以前不支持命名空间
use PHProbot\Api;

/*开始识别消息内容
if ($msg == "test"){
}
*/

//多选
if (PHProbot\Api::MC($option=["你好","测试"],$msg)==true){
$text="你好";
//设置数据组
$Api_data = array(
//群号
"qun"=>$qun,
//QQ号
"qq"=>$qq,
//msg为设置发送消息
"msg"=>To_image($text,$qq),
//发送消息类型 $msg_type为消息类型，还可设置为[群聊，私聊]
"S_type"=>$msg_type,
//消息ID
"msg_id"=>$msg_id
);

//调用消息类 send函数，在115版本以前不支持
$data=PHProbot\Api::send($Api_data);
//提交给go-cqhttp
$ws -> push($frame->fd, $data);
}

?>