<?php



/*机器人配置*/

//服务地址，请根据需要修改端口
$host = "http://127.0.0.1:3366/";
//机器人QQ号
$robot = "";
//主人QQ，管理机器人
$qhost = "";
//二级目录，直接填写文件夹名称
$directory = "";




/*══════api终结点══════*/

$shi_msg_api="send_private_msg";//私聊api

$qun_msg_api="send_group_msg";//群聊api

$che_botmsg_api="delete_msg";//撤回消息

$get_bot_info_api="get_login_info";//获取登录账号信息

$get_msg_api="get_msg";//获取消息api

$get_imgocr_api="ocr_image";//识别图片文字

$set_bot_qun="set_group_ban";//群组单人禁言

$get_zhuangtai="get_status";//获取状态

$up_laod_api="upload_group_file";//上传群文件

/*══════api终结点══════*/

//机器人配置文件
$dir_qun="./group/".$qun."/robot.json";
//群聊数据
$dir="./group/".$qun."/".$qun.".json";
//个人数据
$dir_qq="./group/".$qun."/".$qq.".json";
$file="./group/".$qun."/functions.php";

