<?php

/* *@qun 获取群QQ

   *@msg 获取消息

   *@qq 获取发送者QQ

   *@petname 获取发送者昵称(适配中)

   *@atqq 获取艾特QQ

   *@qhost 获取主人QQ

   *@robot 获取机器人QQ

   *@version v1.2.0

   *@date 2022.4.15

   *@Nick coldeggs

   *@QQ1940826077

   *coldeggs机器人2021.08.21

*/

//设置编码为UTF-8

header("Content-type:text/html;charset=utf-8");

//ws正向服务器

//创建WebSocket Server对象，监听0.0.0.0:6700端口

$ws = new Swoole\WebSocket\Server('0.0.0.0', 6700);

//监听WebSocket连接打开事件

$ws->on('Open', function ($ws, $request) {

    $ws->push($request->fd, "hello, welcome\n");

});

//监听WebSocket消息事件

$ws->on('Message', function ($ws, $frame) {

//fd为客户端标识, $ws调用push函数发送(第二个参数为消息内容)

$data = $frame->data;

echo $data;

//json转为PHP数组，必须转为PHP对象

@$data = json_decode($data,true);

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

include_once './module/config.php';//机器人配置模块

//require './module/curl.php';//curl封装

include_once './module/api.php';//机器人各类api模块

include_once './function/main.php';//机器人功能

});

//监听WebSocket连接关闭事件

$ws->on('Close', function ($ws, $fd) {

    echo "进程-{$fd} 已关闭\n";

});

$ws->start();

?>
