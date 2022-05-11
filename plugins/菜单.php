<?php
use PHProbot\api;
$url_qq="http://q.qlogo.cn/headimg_dl?dst_uin=".$qq."&spec=640&img_type=jpg";
if (PHProbot\Api::MC($option=["菜单","手册","帮助"],$msg)==true){
$Api_data = array(
"qun"=>$qun,
"qq"=>$qq,
"msg"=>"[CQ:image,file=".$url_qq."]-----[菜单]-----\r\n点歌+歌名🌻语音点歌+歌名\r\n词典+词🐻色图\r\n小公告：".file_get_contents(".../root/sd/gg.txt"),
"S_type"=>$msg_type,
"msg_id"=>$msg_id
);
$data=PHProbot\Api::send($Api_data);
$ws -> push($frame->fd, $data);

}
?>