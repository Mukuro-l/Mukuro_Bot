<?php

/* *@qun 获取群QQ

   *@msg 获取消息

   *@qq 获取发送者QQ

   *@petname 获取发送者昵称

   *@atqq 获取艾特QQ

   *@qhost 获取主人QQ

   *@robot 获取机器人QQ

   *@version v1.1.5

   *@date 2022.5.7

   *@Nick coldeggs

   *coldeggs机器人2021.08.21
   
   *版权申明
   Copyright2021-2022 coldeggs.AllRightsReserved

*/

define("PHP_robot","版权归coldeggs所有2021-2022。");

define("E_mail","g2744602949@outlook.com");
/*
机器人配置模块
Robot configuration module
*/
//判断运行模式
if (PHP_SAPI != 'cli'){
echo "请在cli模式下运行本程序";
exit;
}

include './module/config.php';

/*
屏蔽错误
Masking error
*/
error_reporting($BOT_Config["Error_level"]);

//ws正向服务器

//创建WebSocket Server对象，监听端口

$ws = new Swoole\WebSocket\Server('0.0.0.0', $BOT_Config["port"]);
//定时器
use Swoole\Timer;

//监听WebSocket连接打开事件

$ws->on('Open', function ($ws, $request) {
include './module/config.php';
echo "go-cqhttp已连接\n";
$Welcome_to_use = "PHProbot已成功启动\n欢迎使用PHProbot\n当前版本：".$BOT_Config["SDK"]."\n项目地址：https://github.com/2744602949/PHProbot\nQQ邮箱：coldeggs@qq.com\nOutlook邮箱：g2744602949@outlook.com\n";
echo $Welcome_to_use;

});

//监听WebSocket消息事件

$ws->on('Message', function ($ws, $frame) {
include './module/config.php';

//fd为客户端标识, $ws调用push函数发送(第二个参数为消息内容)

$Data = $frame->data;

//json转为PHP数组，必须转为PHP对象
$Data = json_decode($Data,true);

//输出data
if ($BOT_Config["Return_Data"] == true){
if ($Data['meta_event_type'] != 'heartbeat'){
print_r($Data);
}
}



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

	

//判断类型并存入对应日志目录//

if (!empty($Data['group_id'])){

@file_put_contents('./Data/Log/Group/'.date('Y-m-d',time()).'/'.$Data['group_id'].'.txt',$Data, FILE_APPEND);

}elseif(!empty($Data['user_id'])){

@file_put_contents('./Data/Log/User/'.date('Y-m-d',time()).'/'.$Data['user_id'].'.txt',$Data, FILE_APPEND);

}else if(@$Data['meta_event_type'] !== 'heartbeat'){

	//排除心跳事件
@file_put_contents('./Data/Log/Other/'.date('Y-m-d',time()).'.txt',$Data, FILE_APPEND);

}

//api字段们//

//下方字段仅消息上报的字段

@$msg=$Data['message']?:$_GET['msg'];//消息

@$real_msg=$Data['raw_message']?:$_GET['real_msg'];//真实消息

@$qqinformation=$Data['sender'];

@$qqnick=$qqinformation['nickname']?:$_GET['qqnick'];//昵称

@$qun=$Data['group_id']?:$_GET['qun'];//群号

@$qq=$Data['user_id']?:$_GET['qq'];//qq号

@$qqadmin_get=$qqinformation['role']?:$_GET['qqadmin_get'];//群职位：admin/member

@$get_qqsex=$qqinformation['sex']?:$_GET['get_qqsex'];///male为男，female为女，unknown未知

//api字段//

//事件监控字段//

@$get_qun_eve=$Data['notice_type']?:$_GET['get_qun_eve'];//事件

@$get_post_type=$Data['post_type']?:$_GET['get_post_type'];//获取上报类型

@$get_tishi_api=$Data['sub_type']?:$_GET['get_tishi_api'];//获取提示类型

@$get_qing_api=$Data['request_type']?:$_GET['get_qing_api'];//获取请求类型

@$get_yanz_qun=$Data['comment']?:$_GET['get_yanz_qun'];//获取群验证消息

@$get_cao_qun=$Data['operator_id']?:$_GET['get_cao_qun'];//获取操作者qq

@$qunry=$Data['honor_type']?:$_GET['qunry'];//获取荣耀类型

@$cheqq=$Data['operator_id']?:$_GET['cheqq'];//撤回操作qq

@$msgid=$Data['message_id']?:$_GET['msgid'];//消息id

@$real_msgid=$Data['real_id']?:$_GET['real_msgid'];//获取真实信息id

@$msg_type=$Data['message_type']?:$_GET['msg_type'];//消息类型

@$chuo_userid=$Data['target_id']?:$_GET['chuo_userid'];//被戳qq

//事件监控字段//

include_once './module/api.php';//机器人各类api模块
include './module/config.php';//配置
//载入
if (is_dir("vendor")){
@include_once "./vendor/autoload.php";
}else{
echo "缺少必要的库，请阅读README.md文件\n";
exit;
}
//这里会载入plugins文件夹下的所有插件
$list = glob('./plugins/*.php');
foreach($list as $file){
$file=explode('/',$file)['2'];
include './plugins/'.$file;
}

//定时器逻辑
if ($BOT_Config["_tick"] == true){
if (file_exists("tick_config.json")==true){
//该变量返回值为定时器ID
$the_tick=Swoole\Timer::tick(1000, function(){
$tick_data=json_decode(file_get_contents("tick_config.json"),true);
for ($i=0;$i<count($tick_data);$i++){
if ($tick_data[$i]["time"]===date("H:i:s")){
file_get_contents("http://127.0.0.1:".$tick_data[$i]["http_port"]."/send_group_msg?group_id=".$tick_data[$i]["qun"]."&message=[CQ:at,qq=".$tick_data[$i]["qq"]."]".urlencode($tick_data[$i]["msg"]));

Swoole\Timer::clear($the_tick);
}
}
});
}
}

});


//监听WebSocket连接关闭事件

$ws->on('Close', function ($ws, $fd) use($the_tick) {

    echo "go-cqhttp客户端：-{$fd} 已关闭\n";
Swoole\Timer::clear($the_tick);
});

$ws->start();

?>