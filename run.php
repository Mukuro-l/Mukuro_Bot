#!/usr/bin/php
<?php
/**
 *@version v1.1.6
 *@date 2022.9.3
 *@author Mukuro-l
 *@copyright 2021-2022 Mukuro-l.AllRightsReserved
 *@start/begin with/in 2021.08.21
 */

use Swoole\Coroutine\Barrier;
use Swoole\Coroutine\System;
use Swoole\Coroutine;

//外部文件载入
include './Module/Config.php';
error_reporting($BOT_Config["Error_level"]);
include './vendor/autoload.php';
include_once './Module/Api.php';


$ws = new Swoole\WebSocket\Server('0.0.0.0', $BOT_Config["port"]);



//监听WebSocket连接打开事件
$ws->on('Open', function ($ws, $request) {
	include_once "链接打开.php";
});
//监听WebSocket消息事件
$ws->on('Message', function ($ws, $frame) use ($database, $BOT_Config) {
if (!is_file("service_id")){
file_put_contents("service_id",$frame->fd);
}


//载入函数库
include_once './Module/Function.php';

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
	if (@$Data['meta_event_type'] !== 'heartbeat' && @$Data['meta_event_type'] !== 'lifecycle') {
		if (@$Data['status'] === null &&@$Data["post_type"] === "message") {
		//这里进行载入为了避免不必要的数据
		
			
			    $list = glob('./Plugins/*.php');
			    $file_array = json_decode(file_get_contents("Plugins_switch.json"), true);
				
				//这里会载入Plugins文件夹下的所有插件 115版本增加是否载入
					if (!is_file("./Group/".$Data['group_id']."/config.json")&&!empty($Data['group_id'])){
					mkdir("./Group/".$Data['group_id']);
					$Group_data = ["status"=>"关"];
					file_put_contents("./Group/".$Data['group_id']."/config.json",json_encode($Group_data, JSON_UNESCAPED_UNICODE));
					
					}
					
					//封解主的动作
					if (preg_match("/^封解主· ?(.*)\$/", $Data['message'], $Jiezhu)) {
					if ($BOT_Config["qhost"] === $Data['user_id']){
					if ($Jiezhu[1] === "开" || $Jiezhu[1] === "闭" ){
					if ($Jiezhu[1] === "开"){
					$instruction = "打开了哟";
					}else{
					$instruction = "关闭了哟";
					}
					$Jiezhu_data=json_decode(file_get_contents("./Group/".$Data['group_id']."/config.json"),true);
					$Jiezhu_data["status"]=$Jiezhu[1];
					file_put_contents("./Group/".$Data['group_id']."/config.json",json_encode($Jiezhu_data, JSON_UNESCAPED_UNICODE));
					
					$url = ["action" => "send_group_msg", "params" => ["group_id" => $Data['group_id'], "message" =>"官人～六儿把群[".$Data['group_id']."]".$instruction."｜д•´)!!" ]];
				$submit_data = json_encode($url, JSON_UNESCAPED_UNICODE);
				$ws->push($frame->fd,$submit_data);
				}
				if ($Jiezhu[1] != "开" && $Jiezhu[1] != "闭" ){
				for ($i=0;$i<count($file_array);$i++){
				$Jiezhu_Plugins=explode('.',$file_array[$i]["插件名"]);
				if (is_file("./Doc/".$Jiezhu_Plugins[0]."/".$Jiezhu_Plugins[0].".doc")){
				$menu_data=file_get_contents("./Doc/".$Jiezhu_Plugins[0]."/".$Jiezhu_Plugins[0].".doc");
				$doc_name = explode("]", $menu_data);
				$doc_name = explode("[", $doc_name[0]);
			
				if (trim($doc_name[1])==$Jiezhu[1]){
				$menu_data_code=Text_Images("./Doc/".$Jiezhu_Plugins[0]."/".$Jiezhu_Plugins[0].".doc",$Data['user_id']);
				if ($Data['message_type']==="group"){
				$url = ["action" => "send_group_msg", "params" => ["group_id" => $Data['group_id'], "message" =>$menu_data_code ]];
				}
				if ($Data['message_type']==="private"){
				$url = ["action" => "send_private_msg", "params" => ["group_id" => $Data['group_id'],"user_id"=> $Data['user_id'] ,"message" =>$menu_data_code ]];
				
				}
				$submit_data = json_encode($url, JSON_UNESCAPED_UNICODE);
				$ws->push($frame->fd,$submit_data);
				}
				}
				
				//获取帮助
				
				}
				}
				}else{
				if ($Jiezhu[1] != "开" && $Jiezhu[1] != "闭" ){
				for ($i=0;$i<count($file_array);$i++){
				
				$Jiezhu_Plugins=explode('.',$file_array[$i]["插件名"]);
				if (is_file("./Doc/".$Jiezhu_Plugins[0]."/".$Jiezhu_Plugins[0].".doc")){
				$menu_data=file_get_contents("./Doc/".$Jiezhu_Plugins[0]."/".$Jiezhu_Plugins[0].".doc");
				$doc_name = explode("]", $menu_data);
				$doc_name = explode("[", $doc_name[0]);
			
				if (trim($doc_name[1])==$Jiezhu[1]){
				$menu_data_code=Text_Images("./Doc/".$Jiezhu_Plugins[0]."/".$Jiezhu_Plugins[0].".doc",$Data['user_id']);
				if ($Data['message_type']==="group"){
				$url = ["action" => "send_group_msg", "params" => ["group_id" => $Data['group_id'], "message" =>$menu_data_code ]];
				}
				if ($Data['message_type']==="private"){
				$url = ["action" => "send_private_msg", "params" => ["group_id" => $Data['group_id'],"user_id"=> $Data['user_id'] ,"message" =>$menu_data_code ]];
				
				}
				$submit_data = json_encode($url, JSON_UNESCAPED_UNICODE);
				$ws->push($frame->fd, $submit_data);
				}
				continue;
				}else{
				if ($Data['message_type']==="group"){
				$url = ["action" => "send_group_msg", "params" => ["group_id" => $Data['group_id'], "message" =>"六儿提示官人你这个大笨蛋！没有这个插件（噗）啦" ]];
				}
				if ($Data['message_type']==="private"){
				$url = ["action" => "send_private_msg", "params" => ["group_id" => $Data['group_id'],"user_id"=> $Data['user_id'] ,"message" =>"六儿提示官人你这个大笨蛋！没有这个插件（噗）啦"]];
				
				}
				$submit_data = json_encode($url, JSON_UNESCAPED_UNICODE);
				$ws->push($frame->fd,$submit_data);
				}
				}
				}
				}
				}
					//这里会对群的全局状态做出判断，但如果插件状态为关，也不会载入
					if (json_decode(file_get_contents("./Group/".$Data['group_id']."/config.json"),true)["status"] === "开" || $Data['message_type'] === 'private'){
					$file_array = json_decode(file_get_contents("Plugins_switch.json"), true);
						for ($i = 0;$i < count($list);$i++) {
					//创建协程
					
						$file = $file_array[$i]["插件名"];
						$barrier = Barrier::make();
						//插件状态判断
						if ($file_array[$i]["状态"] == "开") {
				
Coroutine::create(function () use ($barrier,$list,$file,$Plugins_name,$file_array,$Data, $database, $BOT_Config,$ws,$service_id){
						include_once './Module/Api.php';
						
						include_once "./Plugins/".$file;
							$Plugins_name = explode('.', $file);
							$Plugins_name = $Plugins_name[0];
							$Plugins_name_function = "plugins_" . $Plugins_name;
		
							$Plugins_test = new $Plugins_name($Data, $database, $BOT_Config,$ws,$service_id);
							$Plugins_return = $Plugins_test->$Plugins_name_function();
							//$pm ->add($Plugins_test->$Plugins_name_function(),true);
							//$Plugins_test -> __destruct();
							if (isset($Plugins_return)) {
								$ws->push($frame->fd,$Plugins_return);
							}
							

							
						
						});
						Barrier::wait($barrier);
						}
						if (!is_file("./Doc/Mukuro_Menu_Doc/Menu.doc")) {
								for ($i = 0;$i < count($list);$i++) {
									$Menu_doc = explode('.', $file_array[$i]["插件名"]);
									$doc_data = file_get_contents("./Doc/" . $Menu_doc[0] . "/" . $Menu_doc[0] . ".doc");
									$doc_name = explode("]", $doc_data);
									$doc_name = explode("[", $doc_name[0]);
									file_put_contents("./Doc/Mukuro_Menu_Doc/Menu.doc", ($i + 1) . $doc_name[1] . "\r\n", FILE_APPEND);
								}
							}
					}
					
				  }
				  
	
		}
		//Event控制
		if (@$Data["post_type"] === "notice"){
	//载入模块
	include_once "./Module/Event.php";
	$Event = new Event($Data, $database, $BOT_Config,$ws,$service_id);
	$Event->plugins_Event();
	
	}
	}

});
//监听WebSocket连接关闭事件
@$ws->on('Close', function ($ws, $fd) use ($the_tick) {
	echo "go-cqhttp客户端：-{$fd} 已关闭\n";
	Swoole\Timer::clear($the_tick);
	unlink("service_id");
	echo "清除定时器\n";
});

$ws->start();


?>
