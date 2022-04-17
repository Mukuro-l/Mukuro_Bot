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

$SDK = "1.1.4";

//是否输出完整data

$Return_Data = false;

if ($robot == null&&$qhost == null){

echo "config.php未设置，启动失败。";

exit;

}

?>
