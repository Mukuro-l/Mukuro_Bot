<?php
use PHProbot\api;
$url_qq="http://q.qlogo.cn/headimg_dl?dst_uin=".$qq."&spec=640";
if (PHProbot\Api::MC($option=["菜单","手册","帮助"],$msg)==true){
$Api_data = array(
"qun"=>$qun,
"qq"=>$qq,
"msg"=>"-----[菜单]-----\r\n点歌+歌名|语音点歌+歌名\r\n词典+词|色图\r\n看图+图片|摸鱼日历\r\n表情包+名字",
"S_type"=>$msg_type,
"msg_id"=>$msg_id
);
$data=PHProbot\Api::send($Api_data);

}
?>
