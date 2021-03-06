<?php
//注意：如果配置错误可能会出现PHProbot无法启动，PHProbotApi错误。
$Config_data = [
//请根据需要修改端口
"port" => 6700,
//gocq的http服务器端口，注意：与PHProbot配置无关
"http_port" => 3366,
//主人QQ，管理机器人
"qhost" => 1940826077,
//go-cqhttp的目录，直接填写文件夹名称。gocq需与PHProbot在同一父目录
"directory" => "gocq",
//版本号
"SDK" => 116,
//是否输出完整data
"Return_Data" => true,
//是否为termux平台（手机）。该配置项可开启一些框架功能（115版本仍在测试）
"Mobile" => false,
//报告错误等级 8为屏蔽通知，0为不上报错误
"Error_level" => 8,
//定时器开关
"_tick" => true,
//是否报时，需tick_config.json配置文件
"_time" => true];
//创建配置
if (file_exists("config.json") != true) {
	$Config_data = json_encode($Config_data, JSON_UNESCAPED_UNICODE);
	file_put_contents("config.json", $Config_data);
	echo "已生成config.json配置文件\n请配置config.json\n若您未查看config.php文件来正确配置，请后续修改config.json\n";
	exit;
} else {
	if (count(json_decode(file_get_contents("config.json"), true)) > count($Config_data) || count(json_decode(file_get_contents("config.json"), true)) < count($Config_data)) {
		$Config_data = json_encode($Config_data, JSON_UNESCAPED_UNICODE);
		file_put_contents("config.json", $Config_data);
		echo "[notification]：PHProbot检测到配置更改已重新生成配置文件\n";
	}
}
$database = new Swoole\Table(4096);
$database->column("Data", Swoole\Table::TYPE_STRING, 1024);
$database->column("Group_message", Swoole\Table::TYPE_STRING, 1024);
$database->create();
$BOT_Config = json_decode(file_get_contents("config.json"), true);
//检查配置
if ($BOT_Config["qhost"] == null) {
	echo "config.json未设置，启动失败。";
	exit;
}
//检测更新
	//新版本
	$new_SDK = file_get_contents("http://43.154.119.191/api/update.php");
	if ($BOT_Config["SDK"] < $new_SDK) {
		echo "PHProbot检测到更新\n当前版本：" . $BOT_Config["SDK"] . "\n最新版：" . $new_SDK . "\n";
	
	}
?>
