<?php
/**
 *@version v1.1.6 beta
 *@date 2022.6.5
 *@author coldeggs
 *@copyright 2021-2022 coldeggs.AllRightsReserved
 *coldeggs机器人2021.08.21
 */
define("Mukuro", "版权归coldeggs所有2021-2022。");
define("E_mail", "phprobot@sina.com");

if (is_dir("vendor")){
include "./vendor/autoload.php";
}else{
echo "缺少必要的库，请阅读README.md文件\n";
exit;
}

include './Module/Config.php';
/*
屏蔽错误
Masking error
*/
//error_reporting($BOT_Config["Error_level"]);
//ws正向服务器
//创建WebSocket Server对象，监听端口
$ws = new Swoole\WebSocket\Server('0.0.0.0', $BOT_Config["port"]);
//定时器
use Swoole\Timer;
//协程容器
use Swoole\Coroutine\Barrier;
use Swoole\Coroutine\System;
use function Swoole\Coroutine\run;
use Swoole\Coroutine;

echo "Mukuro WebSocket服务器已启动，正在等待go-cqhttp连接……\n";
//监听WebSocket连接打开事件
$ws->on('Open', function ($ws, $request) {
	include './Module/Config.php';
	echo "go-cqhttp已连接\n";
	$Welcome_to_use = "Mukuro已成功启动\n欢迎使用Mukuro\n当前版本：" . $BOT_Config["SDK"] . "\n项目地址：https://github.com/2744602949/Mukuro_Bot\nQQ邮箱：coldeggs@qq.com\nOutlook邮箱：g2744602949@outlook.com\n";
	echo $Welcome_to_use;
	unlink("./Doc/Mukuro_Menu_Doc/Menu.doc");
});

//监听WebSocket消息事件
$ws->on('Message', function ($ws, $frame) use ($database,$BOT_Config) {

	//fd为客户端标识, $ws调用push函数发送(第二个参数为消息内容)
	$Data = $frame->data;
	//json转为PHP数组，必须转为PHP对象
	$Data = json_decode($Data, true);
	//输出data
	if ($BOT_Config["Return_Data"] == true) {
		if (@$Data['meta_event_type'] != 'heartbeat') {
			print_r($Data);
		}
	}
	if (@$Data['meta_event_type'] !== 'heartbeat'||@$Data['meta_event_type'] !=='lifecycle') {
	if (@$Data['status']===null){
$Barrier = Barrier::make();
go(function () use($Data,$ws,$frame,$database,$BOT_Config){
	include_once './Module/Api.php';
	include_once './Module/Function.php';
	//这里会载入Plugins文件夹下的所有插件 115版本增加是否载入
	$list = glob('./Plugins/*.php');
	if (is_file("Plugins_switch.json") == false) {
		$Plugins_array = array();
		for ($i = 0;$i < count($list);$i++) {
			$file = explode('/', $list[$i]) [2];
			$Plugins_array[] = array("插件名" => $file, "状态" => "开");
		}
		$Plugins_list = json_encode($Plugins_array, JSON_UNESCAPED_UNICODE);
		file_put_contents("Plugins_switch.json", $Plugins_list);
	} else {
		$file_array = json_decode(file_get_contents("Plugins_switch.json"), true);
		//判断是否增加
		if (count($list) > count($file_array)) {
			for ($i = 0;$i < count($list);$i++) {
				$file = explode('/', $list[$i]) [2];
				if ($file_array[$i]["插件名"] != $file) {
					unlink("Plugins_switch.json");
				}
			}
		}
		if (count($list) < count($file_array)) {
			for ($i = 0;$i < count($list);$i++) {
				$file = explode('/', $list[$i]) [2];
				if ($file_array[$i]["插件名"] != $file) {
					unlink("Plugins_switch.json");
				}
			}
		}
		for ($i=0;$i<count($list);$i++){

$file=$file_array[$i]["插件名"];

if ($file_array[$i]["状态"]=="开"){
				$Plugins_name = explode('.', $file);
				$Plugins_name = $Plugins_name[0];
				@include_once './Plugins/' . $file;
				if (!is_dir("./Doc/".$Plugins_name)){
				mkdir("./Doc/".$Plugins_name);
				$Doc = new ReflectionClass($Plugins_name);
                $Doc=$Doc->getDocComment();
                $Doc_doc_ = explode("*",$Doc);
                //名字会出现在菜单上
                $Doc_name = explode("@name",$Doc_doc_[3]);
                $Doc_doc = explode("@doc",$Doc_doc_[4]);
                $Doc_comment = explode("@comment",$Doc_doc_[5]);
                $Doc_return = explode("@return",$Doc_doc_[6]);
                $Doc_data ="    Mukuro  --".$Plugins_name."插件帮助\r\n名字：[".$Doc_name[1]."]\r\n详情：[".$Doc_doc[1]."]\r\n指令：[".$Doc_comment[1]."]\r\n返回：[".$Doc_return[1]."]";
                file_put_contents("./Doc/".$Plugins_name."/".$Plugins_name.".doc",$Doc_data);
				}
				if (!is_file("./Doc/Mukuro_Menu_Doc/Menu.doc")){
for ($i=0;$i<count($list);$i++){

$Menu_doc=explode('.',$file_array[$i]["插件名"])[0];
$doc_data=file_get_contents("./Doc/".$Menu_doc.$Menu_doc.".doc");
$doc_name = explode("[",$doc_data);
$doc_name = explode("]",$doc_name[1]);

file_put_contents("./Doc/Mukuro_Menu_Doc/Menu.doc",($i+1).$doc_name[0]."\r\n",FILE_APPEND);
}

				}
					$Plugins_name_function = "plugins_" . $Plugins_name;
					$Plugins_test = new $Plugins_name($Data,$database,$BOT_Config);
					$Plugins_return =  $Plugins_test->$Plugins_name_function();
					//$Plugins_test -> __destruct();
if (isset($Plugins_return)){
					$ws->push($frame->fd, $Plugins_return);
					}
					
					}
				}
			
		}
	
});
Barrier::wait($Barrier);

}
}	
	

	//定时器逻辑
	if ($BOT_Config["_tick"] == true) {
		if (file_exists("tick_config.json") == true) {
			//该变量返回值为定时器ID
			@$the_tick = Swoole\Timer::tick(2000, function () {
				$tick_data = json_decode(file_get_contents("tick_config.json"), true);
				if (count($tick_data[date("H:i:s") ]) > 0) {
					$Barrier = Barrier::make();
					for ($i = 0;$i < count($tick_data[date("H:i:s") ]);$i++) {
						if ($tick_data[date("H:i:s") ] != null) {
							$time = date("H:i:s");
							if ($tick_data[$time][$i]["tick"] != 0) {
								file_get_contents("http://127.0.0.1:" . $tick_data[$time][$i]["http_port"] . "/send_group_msg?group_id=" . $tick_data[$time][$i]["qun"] . "&message=[" . urlencode($tick_data[$time][$i]["msg"]) . "]");
								$tick_data[$time][$i]["tick"] = $tick_data[$time][$i]["tick"] - 1;
								$tick_data[$time][$i]["First_time"] = $tick_data[$time][$i]["First_time"] + 1;
								$data = json_encode($tick_data, JSON_UNESCAPED_UNICODE);
								file_put_contents("tick_config.json", $data);
							}
						}
					}
					Coroutine::create(function () use ($time) {
						$tick_data = json_decode(file_get_contents("tick_config.json"), true);
						for ($i = 0;$i < count($tick_data[$time]);$i++) {
							if ($tick_data[$time][$i]["First_time"] < 1) {
								if ($tick_data[$time] != null) {
									if ($tick_data[$time][$i]["tick"] != 0) {
										file_get_contents("http://127.0.0.1:" . $tick_data[$time][$i]["http_port"] . "/send_group_msg?group_id=" . $tick_data[$time][$i]["qun"] . "&message=[" . urlencode($tick_data[$time][$i]["msg"]) . "]");
										$tick_data[$time][$i]["tick"] = $tick_data[$time][$i]["tick"] - 1;
										$tick_data[$time][$i]["First_time"] = $tick_data[$time][$i]["First_time"] + 1;
										$data = json_encode($tick_data, JSON_UNESCAPED_UNICODE);
										file_put_contents("tick_config.json", $data);
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
@$ws->on('Close', function ($ws, $fd) use ($the_tick) {
	echo "go-cqhttp客户端：-{$fd} 已关闭\n";
	@Swoole\Timer::clear($the_tick);
	echo "清除定时器\n";
});
$ws->start();
?>