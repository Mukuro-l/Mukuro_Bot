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
//创建WebSocket Server对象，监听0.0.0.0:9502端口
$ws = new Swoole\WebSocket\Server('0.0.0.0', 6700);

//监听WebSocket连接打开事件
$ws->on('Open', function ($ws, $request) {
    $ws->push($request->fd, "hello, welcome\n");
});

//监听WebSocket消息事件
$ws->on('Message', function ($ws, $frame) {
//fd为客户端标识, $ws调用push函数发送(第二个参数为消息内容)
//json转为PHP数组，必须转为PHP对象
@$data=json_decode($frame->data,true);

require_once './module/config.php';//机器人配置模块

require_once './module/curl.php';//curl封装

require_once './module/api.php';//机器人各类api模块

require_once './function/main.php';//机器人功能

});

//监听WebSocket连接关闭事件
$ws->on('Close', function ($ws, $fd) {
    echo "client-{$fd} is closed\n";
});

$ws->start();
?>
