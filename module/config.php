<?php

$Config_data = array(
//请根据需要修改端口
"port" => 6700,

//机器人QQ号
"robot" => 111111,

//主人QQ，管理机器人
"qhost" => 11111,

//go-cqhttp的目录，直接填写文件夹名称
"directory" => "",

//版本号
"SDK" => 115,

//是否输出完整data
"Return_Data" => true,

//是否为termux平台（手机）。该配置项可开启一些框架功能
"Mobile" => false,

//报告错误等级  报告用户触发的错误：E_USER_ERROR；不报告：E_ALL。请自行参考php.ini进行设置
"Error_level" => "E_USER_ERROR",

//定时器开关
"_tick" => true
);

//创建配置
if (file_exists("config.json")!=true){
$Config_data = json_encode($Config_data,JSON_UNESCAPED_UNICODE);
file_put_contents("config.json",$Config_data);
echo "已生成config.json配置文件\n请配置config.json\n";
exit;
}

$BOT_Config =json_decode(file_get_contents("config.json"),true);

//检查配置
if ($BOT_Config["robot"] == null&&$BOT_Config["qhost"] == null){

echo "config.json未设置，启动失败。";

exit;

}

//检测更新

if (file_exists("botsdk.txt")!=true){

//新版本
$new_SDK = file_get_contents("http://www.mtapda.com");

if ($BOT_Config["SDK"] != $new_SDK){

echo "PHProbot检测到更新\n当前版本：".$BOT_Config["SDK"]."\n最新版：".$new_SDK."\n";

file_put_contents("botsdk.txt",$BOT_Config["SDK"]);

}

}

?>
