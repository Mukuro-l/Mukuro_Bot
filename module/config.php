<?php



/*机器人配置*/

//服务地址，请根据需要修改端口
$host = "http://127.0.0.1:3366/";
//机器人QQ号
$robot = "";
//主人QQ，管理机器人
$qhost = "";
//json_decode(file_get_contents("qhost.json","r"),true);

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

//(♡ ὅ ◡ ὅ )ʃ♡

//══════api字段们═════/
//下方字段仅消息上报的字段
@$msg=$data['message']?:$_GET['msg'];//消息

@$real_msg=$data['raw_message']?:$_GET['real_msg'];//真实消息

@$qqinformation=$data['sender'];
@$qqnick=$qqinformation['nickname']?:$_GET['qqnick'];//昵称

@$qun=$data['group_id']?:$_GET['qun'];//群号

@$qq=$data['user_id']?:$_GET['qq'];//qq号

@$qqadmin_get=$qqinformation['role']?:$_GET['qqadmin_get'];//群职位：admin/member

@$get_qqsex=$qqinformation['sex']?:$_GET['get_qqsex'];///male为男，female为女，unknown未知

//══════api字段们═════＊/


//══════事件监控字段们═════＊/

@$get_qun_eve=$data['notice_type']?:$_GET['get_qun_eve'];//事件

@$get_post_type=$data['post_type']?:$_GET['get_post_type'];//获取上报类型

@$get_tishi_api=$data['sub_type']?:$_GET['get_tishi_api'];//获取提示类型

@$get_qing_api=$data['request_type']?:$_GET['get_qing_api'];//获取请求类型

@$get_yanz_qun=$data['comment']?:$_GET['get_yanz_qun'];//获取群验证消息

@$get_cao_qun=$data['operator_id']?:$_GET['get_cao_qun'];//获取操作者qq

@$qunry=$data['honor_type']?:$_GET['qunry'];//获取荣耀类型

@$cheqq=$data['operator_id']?:$_GET['cheqq'];//撤回操作qq

@$msgid=$data['message_id']?:$_GET['msgid'];//消息id

@$real_msgid=$data['real_id']?:$_GET['real_msgid'];//获取真实信息id

@$msg_type=$data['message_type']?:$_GET['msg_type'];//消息类型

@$chuo_userid=$data['target_id']?:$_GET['chuo_userid'];//被戳qq

//══════事件监控字段们═════＊/

//机器人配置文件
$dir_qun="./group/".$qun."/robot.json";
//群聊数据
$dir="./group/".$qun."/".$qun.".json";
//个人数据
$dir_qq="./group/".$qun."/".$qq.".json";
$file="./group/".$qun."/functions.php";

