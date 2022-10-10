<?php
//注意：如果配置错误可能会出现Mukuro_Bot无法启动，Mukuro_Bot_Api错误。
$Config_data = [
//请根据需要修改端口
"port" => 6700,
//gocq的http服务器端口，注意：与Mukuro_Bot配置无关
"http_port" => 3366,
//主人QQ，管理机器人
"qhost" => null,
//版本号
"SDK" => 116,
//是否输出完整data
"Return_Data" => false,
//报告错误等级 8为屏蔽通知，0为不上报错误
"Error_level" => 8
];
//创建配置
if (file_exists("config.json") != true) {
	$Config_data = json_encode($Config_data, JSON_UNESCAPED_UNICODE);
	file_put_contents("config.json", $Config_data);
	echo "[notification]：已生成config.json配置文件\n请配置config.json\n若您未查看config.php文件来正确配置，请后续修改config.json\n";
	exit;
} else {
	if (count(json_decode(file_get_contents("config.json"), true)) > count($Config_data) || count(json_decode(file_get_contents("config.json"), true)) < count($Config_data)) {
		$Config_data = json_encode($Config_data, JSON_UNESCAPED_UNICODE);
		file_put_contents("config.json", $Config_data);
		echo "[notification]：Mukuro_Bot检测到配置更改已重新生成配置文件\n";
	}
}
$database = new Swoole\Table(4096);
$database->column("Data", Swoole\Table::TYPE_STRING, 1024);
$database->column("Group_message", Swoole\Table::TYPE_STRING, 1024);
$database->create();
$BOT_Config = json_decode(file_get_contents("config.json"), true);
//检查配置
if ($BOT_Config["qhost"] == null) {
	echo "[notification]：config.json未设置，启动失败。\n";
	exit;
}
?>
