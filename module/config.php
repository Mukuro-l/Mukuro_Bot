<?php

//请根据需要修改端口
$port = "3366";
//机器人QQ号
$robot = "";
//主人QQ，管理机器人
$qhost = "";

//二级目录，直接填写文件夹名称
$directory = "";

$Welcome_to_use = array(
"action"=>"send_private_msg",
"params"=>array(
"user_id"=>$qhost,
"message"=>"PHProbot已成功启动\r\n欢迎使用PHProbot\r\n项目地址：https://github.com/2744602949/PHProbot\r\nQQ邮箱：coldeggs@qq.com\r\nOutlook邮箱：g2744602949@outlook.com"
)
);



//api终结点

$shi_msg_api="send_private_msg";//私聊api

$qun_msg_api="send_group_msg";//群聊api

$che_botmsg_api="delete_msg";//撤回消息

$get_bot_info_api="get_login_info";//获取登录账号信息

$get_msg_api="get_msg";//获取消息api

$get_imgocr_api="ocr_image";//识别图片文字

$set_bot_qun="set_group_ban";//群组单人禁言

$get_zhuangtai="get_status";//获取状态

$up_laod_api="upload_group_file";//上传群文件
