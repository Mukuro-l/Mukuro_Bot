<?php
use PHProbot\Api;
if (!empty($get_qun_eve)){
$url_qq="[CQ:image,url=http://q.qlogo.cn/headimg_dl?dst_uin=".$qq."&spec=640&img_type=jpg]";
if ($get_qun_eve=="group_decrease"&&$get_tishi_api=="leave"){
    $send_msg=$url_qq."这个人：".$qq."，主动离开了本群！\r\n时间：".date("Y/m/d H:i");
}
if ($get_qun_eve=="group_increase"&&$qq!=$robot){
$send_msg="[CQ:at,qq=".$qq."]".$url_qq."欢迎入群！";
}
if ($get_qun_eve == "group_upload"){
$send_msg=$url_qq."上传者：".$qq."\r\n文件ID：[".$Data['file']['id']."]\r\n文件名：".$Data['file']['name']."\r\n文件大小：".$Data['file']['size'];
}
$Api_data = array(
"qun"=>$qun,
"qq"=>$qq,
"msg"=>$send_msg,
"S_type"=>"群聊",
"msg_id"=>$msg_id
);
$data=PHProbot\Api::send($Api_data);
$ws -> push($frame->fd, $data);
}
?>
