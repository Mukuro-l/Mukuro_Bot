<?php

//请根据需要修改端口

$port = "6700";

//机器人QQ号

$robot = "275566";

//主人QQ，管理机器人

$qhost = "865366";

//二级目录，直接填写文件夹名称

$directory = "";

if ($robot == null&&$qhost == null){

echo "config.php未设置，启动失败。";

exit;

}

$Welcome_to_use = array(

"action"=>"send_private_msg",

"params"=>array(

"user_id"=>$qhost,

"message"=>"PHProbot已成功启动\r\n欢迎使用PHProbot\r\n项目地址：https://github.com/2744602949/PHProbot\r\nQQ邮箱：coldeggs@qq.com\r\nOutlook邮箱：g2744602949@outlook.com"

)
);
?>
