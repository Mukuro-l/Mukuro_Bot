<?php

/**
   *@version v1.1.5

   *@date 2022.5.7

   *@author coldeggs
   
   *@copyright 2021-2022 coldeggs.AllRightsReserved
   *coldeggs机器人2021.08.21

*/

define("PHP_robot","版权归coldeggs所有2021-2022。");

define("E_mail","phprobot@sina.com");
/*
机器人配置模块
Robot configuration module
*/
//判断运行模式
if (PHP_SAPI != 'cli'){
echo "请在cli模式下运行本程序";
exit;
}

if (is_dir("vendor")){
include "./vendor/autoload.php";
}else{
echo "缺少必要的库，请阅读README.md文件\n";
exit;
}

include './module/config.php';

/*
屏蔽错误
Masking error
*/
//error_reporting($BOT_Config["Error_level"]);

//ws正向服务器

//创建WebSocket Server对象，监听端口

$ws = new Swoole\WebSocket\Server('0.0.0.0', $BOT_Config["port"]);
include_once './module/api.php';
//定时器
use Swoole\Timer;
//协程容器
use Swoole\Coroutine\Barrier;
use Swoole\Coroutine\System;
use function Swoole\Coroutine\run;
use Swoole\Coroutine;
use PHProbot\Api;
use Hahadu\ImageFactory\Config\Config;
use Hahadu\ImageFactory\Kernel\Factory;

echo "PHProbot WebSocket服务器已启动，正在等待go-cqhttp连接……\n";

//监听WebSocket连接打开事件

$ws->on('Open', function ($ws, $request) {
include './module/config.php';
echo "go-cqhttp已连接\n";
$Welcome_to_use = "PHProbot已成功启动\n欢迎使用PHProbot\n当前版本：".$BOT_Config["SDK"]."\n项目地址：https://github.com/2744602949/PHProbot\nQQ邮箱：coldeggs@qq.com\nOutlook邮箱：g2744602949@outlook.com\n";
echo $Welcome_to_use;

});


//监听WebSocket消息事件

$ws->on('Message', function ($ws, $frame){

include './module/config.php';
include_once './module/api.php';


//fd为客户端标识, $ws调用push函数发送(第二个参数为消息内容)

$Data = $frame->data;

//json转为PHP数组，必须转为PHP对象
$Data = json_decode($Data,true);

//输出data
if ($BOT_Config["Return_Data"] == true){
if (@$Data['meta_event_type'] != 'heartbeat'){
print_r($Data);
}
}



//=============预定义函数==========

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

@$msg_id=$Data['message_id']?:$_GET['msgid'];//消息id

@$real_msgid=$Data['real_id']?:$_GET['real_msgid'];//获取真实信息id

@$msg_type=$Data['message_type']?:$_GET['msg_type'];//消息类型

@$chuo_userid=$Data['target_id']?:$_GET['chuo_userid'];//被戳qq

//事件监控字段//



include './module/config.php';//配置
//载入

//这里会载入plugins文件夹下的所有插件 115版本增加是否载入
$list = glob('./plugins/*.php');
if (file_exists("plugins_switch.json")==false){
$plugins_array=array();
for ($i=0;$i<count($list);$i++){
$file=explode('/',$list[$i])[2];

$plugins_array[]=array(
"插件名"=>$file,
"状态"=>"开"
);
}
$plugins_list = json_encode($plugins_array,JSON_UNESCAPED_UNICODE);
file_put_contents("plugins_switch.json",$plugins_list);
}else{
$file_array = json_decode(file_get_contents("plugins_switch.json"),true);
//判断是否增加
if (count($list)>count($file_array)){
$add=(count($list)-count($file_array));
for ($i=0;$i<count($list);$i++){
$file=explode('/',$list[$i])[2];

if ($file_array[$i]["插件名"]!=$file){
$file_array[count($file_array)+$add]=[
"插件名"=>$file,
"状态"=>"关"
];
$plugins_list = json_encode($plugins_array,JSON_UNESCAPED_UNICODE);
file_put_contents("plugins_switch.json",$plugins_list);
}
}

}


//===============分割============

for ($i=0;$i<count($list);$i++){

$file=$file_array[$i]["插件名"];

//echo "+++++++++++\n插件名：".$file."\n状态：".$file_array[$i]["状态"]."\n";
//echo "以下为载入状态\n+++++++++++";
if ($file_array[$i]["状态"]=="开"){
//echo "\n".$file."成功载入\n";
include './plugins/'.$file;


}
}
}

if (isset($Api_data)==true){
if (is_array($Api_data)==true&&$Api_data["msg"]!=null){
if ($Api_data["image"]==true){
$config = new Config();
$config->setSavePath="images/";
Factory::setOptions($config);
$option=[
'background'=>'#f5f5dc',
'fill_color'=>'#000000',
'font_size'=>'20',
'filename'=>$qq,
'format'=>'jpg',
];
$text_mark_url = Factory::text_to_image()->text_create_image($text,$option);
$file="./images/".$qq.".jpg";

$image = $file;
$config->waterMarkText = 'PHProbot'; //设置水印文字，支持\n换行符
$config->TextStyle = [
'font_size' => 50, //字体大小
];
Factory::setOptions($config);
$text_water_mark = Factory::text_to_image()->text_water_mark($image,$x='right',$y='down',$option=[]);
rename($text_water_mark,$file);
copy($file,"../gocq/data/images/".$qq.".jpg");

}
$ws -> push($frame->fd, $data);
}
}

/*
$redis_data=[
//设置key
"data_name"=>"数据",
//设置数据
"data"=>123456,
//是否获取数据
"get"=>false
];
*/
if (!function_exists("bot_redis")){
function bot_redis($redis_data=[]){
if (!empty($redis_data)){
if (is_array($redis_data)){
$redis = new Redis();
$redis->connect('127.0.0.1', 6379);
echo "已连接Redis数据库\n";
//删除
//$redis->del("test");
/*
$redis_data=[
//设置key
"data_name"=>"数据",
//设置数据
"data"=>123456,
//QQ
"qq"=>$qq,
//是否获取数据
"get"=>false
];
*/
$array2=[
"data","qq"
];
/*for ($i=0;$i<count($array);$i++){
$redis->rpush("test",$array[$i]);
}
$redis->lset('test',1,'PHP');
*/
//设置数组
$redis->hmset($redis_data["data_name"],$redis_data);
//$return=$redis->lrange("test",0,-1);
//获取数组
$return=$redis->hmget($redis_data["data_name"],$array2);
print_r($return);
}
}
}
}

if (isset($redis_data)==true){
if (is_array($redis_data)){
if ($redis_data["data"]==null or $redis_data["get"]==null){
$redis_return=$redis->get($redis_data["data_name"]);
}else if(!empty($redis_data["data"]) and !empty($redis_data["data_name"])){
bot_redis($redis_data);

}
}
}

//定时器逻辑
if ($BOT_Config["_tick"] == true){
if (file_exists("tick_config.json")==true){

//该变量返回值为定时器ID
@$the_tick=Swoole\Timer::tick(2000, function(){
$tick_data=json_decode(file_get_contents("tick_config.json"),true);
if (count($tick_data[date("H:i:s")])>0){
$Barrier=Barrier::make();
for ($i=0;$i<count($tick_data[date("H:i:s")]);$i++){
if ($tick_data[date("H:i:s")]!=null){
$time=date("H:i:s");
if ($tick_data[$time][$i]["tick"]!=0){

file_get_contents("http://127.0.0.1:".$tick_data[$time][$i]["http_port"]."/send_group_msg?group_id=".$tick_data[$time][$i]["qun"]."&message=[".urlencode($tick_data[$time][$i]["msg"])."]");
$tick_data[$time][$i]["tick"]=$tick_data[$time][$i]["tick"]-1;
$tick_data[$time][$i]["First_time"]=$tick_data[$time][$i]["First_time"]+1;
$data =json_encode($tick_data,JSON_UNESCAPED_UNICODE);
file_put_contents("tick_config.json",$data);

}
}
}
Coroutine::create(function()use($time){
$tick_data=json_decode(file_get_contents("tick_config.json"),true);
for ($i=0;$i<count($tick_data[$time]);$i++){
if ($tick_data[$time][$i]["First_time"]<1){
if ($tick_data[$time]!=null){
if ($tick_data[$time][$i]["tick"]!=0){

file_get_contents("http://127.0.0.1:".$tick_data[$time][$i]["http_port"]."/send_group_msg?group_id=".$tick_data[$time][$i]["qun"]."&message=[".urlencode($tick_data[$time][$i]["msg"])."]");
$tick_data[$time][$i]["tick"]=$tick_data[$time][$i]["tick"]-1;
$tick_data[$time][$i]["First_time"]=$tick_data[$time][$i]["First_time"]+1;
$data =json_encode($tick_data,JSON_UNESCAPED_UNICODE);
file_put_contents("tick_config.json",$data);

}
}
}
}
});
Barrier::wait($Barrier);
}

});
}
}

});


//监听WebSocket连接关闭事件

@$ws->on('Close', function ($ws, $fd) use($the_tick) {

echo "go-cqhttp客户端：-{$fd} 已关闭\n";
@Swoole\Timer::clear($the_tick);
echo "清除定时器\n";
});

$ws->start();

?>