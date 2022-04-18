<?php

//请根据需要修改端口

$port = "6700";

//机器人QQ号

$robot = "";

//主人QQ，管理机器人

$qhost = "";

//二级目录，直接填写文件夹名称

$directory = "";

//版本号

$SDK = 114;

//是否输出完整data

$Return_Data = false;

//报告错误等级  报告用户触发的错误：E_USER_ERROR；不报告：E_ALL。请自行参考php.ini进行设置

$Error_level = "E_USER_ERROR";

//检查配置
if ($robot == null&&$qhost == null){

echo "config.php未设置，启动失败。";

exit;

}

//检测更新

if (file_exists("botsdk.txt")!=true){

//新版本

$new_SDK = file_get_contents("http://www.mtapda.com");

if ($SDK != $new_SDK){

echo "PHProbot检测到更新\n当前版本：".$SDK."\n最新版：".$new_SDK."\n";

file_put_contents("botsdk.txt",$SDK);

}

}

?>
