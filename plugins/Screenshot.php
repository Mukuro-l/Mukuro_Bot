<?php

$server_msg = new bot_msg_api();

//认证token

$Token = "625afe28b318e";

//宽度 默认1280单位像素

$width = 1280;

//高度

$height = 800;

//截屏之前需要等待多少毫秒

$delay = 200;

//输出格式，默认image，可选json

$output = "image";

//质量(2k)选项，默认null，可传1

$retina = null;

//长截图选项，传1则长截图

$full_page = 0;

//使用设备 pc电脑 mobile手机 table平板

$device = "table";

//cookies

$cookies = "";

//区域线路  hk

$zone = "";

if (preg_match("/^截屏 ?(.*)\$/",$msg,$return)){

if ($return[1] == null){

$S_type = $msg_type;

$_msg = "请输入需要截屏的网址";

$return_msg = $server_msg -> send($qun,$_msg,$qq,$S_type,$msgid);

$ws -> push($frame->fd, $return_msg);

echo "bot发送消息：[".$_msg."]\n";

}else{

if (preg_match('/https:\/\/.*\/\w+/', $return[1], $url)){

$img = file_get_contents("https://www.screenshotmaster.com/api/v1/screenshot?url=".$url[0]."&token=".$Token."&width=".$width."&height=".$height."&delay=".$delay."&output=".$output."&retina=".$retina."&full_page=".$full_page."&device=".$device."&cookies=".$cookies."&zone=".$zone,"r");

//fopen(date("H:i:s").".jpg","w");

file_put_contents($qq.".png",$img);

$_msg = "[CQ:image,file=".dirname(__FILE__)."/".$qq.".png]";

$S_type = $msg_type;

$return_msg = $server_msg -> send($qun,$_msg,$qq,$S_type,$msgid);

$ws -> push($frame->fd, $return_msg);

echo "bot发送消息：[".$_msg."]\n";

}

}

}

?>
