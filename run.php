<?php

/* *@qun 获取群QQ

   *@msg 获取消息

   *@qq 获取发送者QQ

   *@petname 获取发送者昵称

   *@atqq 获取艾特QQ

   *@qhost 获取主人QQ

   *@robot 获取机器人QQ

   *@version v1.2.0

   *@date 2022.4.15

   *@Nick coldeggs

   *@QQ1940826077

   *coldeggs机器人2021.08.21

*/

error_reporting(0);

include_once './module/config.php';//机器人配置模块

//ws正向服务器

//创建WebSocket Server对象，监听0.0.0.0:6700端口

$ws = new Swoole\WebSocket\Server('0.0.0.0', $port);

//监听WebSocket连接打开事件

$ws->on('Open', function ($ws, $request) {

include_once './module/config.php';

$Welcome_to_use = json_encode($Welcome_to_use,JSON_UNESCAPED_UNICODE);

 $ws->push($request->fd, $Welcome_to_use);

});

//监听WebSocket消息事件

$ws->on('Message', function ($ws, $frame) {

//fd为客户端标识, $ws调用push函数发送(第二个参数为消息内容)

$Data = $frame->data;

//载入配置

include_once './module/config.php';

//json转为PHP数组，必须转为PHP对象

@$Data = json_decode($Data,true);

//该代码借鉴于https://github.com/hanximeng/BOT_API/blob/main/index.php

//创建日志文件夹用来存放群组及私聊消息

if (is_dir("Data")!=true){

mkdir('./Data');

mkdir('./Data/Log');

mkdir('./Data/Cron/');

mkdir('./Data/Log/User');

mkdir('./Data/Log/Other');

mkdir('./Data/Log/Group');

mkdir('./Data/Log/User/'.date('Y-m-d',time()));

mkdir('./Data/Log/Group/'.date('Y-m-d',time()));

}

//判断类型并存入对应日志目录

if(!empty($Data['group_id'])){

	file_put_contents('./Data/Log/Group/'.date('Y-m-d',time()).'/'.$Data['group_id'].'.txt',$content, FILE_APPEND);}elseif(!empty($Data['user_id'])){

	file_put_contents('./Data/Log/User/'.date('Y-m-d',time()).'/'.$Data['user_id'].'.txt',$content, FILE_APPEND);

}elseif($Data['meta_event_type'] !== 'heartbeat'){

	//排除心跳事件

	file_put_contents('./Data/Log/Other/'.date('Y-m-d',time()).'.txt',$content, FILE_APPEND);

}

//══════api字段们═════/

//下方字段仅消息上报的字段

@$msg=$Data['message'];//消息

@$real_msg=$Data['raw_message'];//真实消息

@$qqinformation=$Data['sender'];

@$qqnick=$qqinformation['nickname'];//昵称

$GLOBALS["qun"]=$Data['group_id'];//群号

$GLOBALS["qq"]=$Data['user_id'];//qq号

@$qqadmin_get=$qqinformation['role'];//群职位：admin/member

@$get_qqsex=$qqinformation['sex'];///male为男，female为女，unknown未知

//══════api字段们═════＊/

//══════事件监控字段们═════＊/

@$get_qun_eve=$Data['notice_type'];//事件

@$get_post_type=$Data['post_type'];//获取上报类型

@$get_tishi_api=$Data['sub_type'];//获取提示类型

@$get_qing_api=$Data['request_type'];//获取请求类型

@$get_yanz_qun=$Data['comment'];//获取群验证消息

@$get_cao_qun=$Data['operator_id'];//获取操作者qq

@$qunry=$Data['honor_type'];//获取荣耀类型

@$cheqq=$Data['operator_id'];//撤回操作qq

$GLOBALS["msgid"]=$Data['message_id'];//消息id

@$real_msgid=$Data['real_id'];//获取真实信息id

@$msg_type=$Data['message_type'];//消息类型

@$chuo_userid=$Data['target_id'];//被戳qq

//══════事件监控字段们═════＊/

@include_once './module/api.php';//机器人各类api模块
$GLOBALS["bots_msg_type"]=$msg_type;

//循环载入插件

$list = glob('./plugins/*.php');

foreach($list as $file){

	$file=explode('/',$file)['2'];

	include './plugins/'.$file;

}

});

//监听WebSocket连接关闭事件

$ws->on('Close', function ($ws, $fd) {

    echo "进程-{$fd} 已关闭\n";

});

$ws->start();

?>
