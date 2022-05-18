<?php
use PHProbot\Api;
if (!empty($get_post_type)){
$url_qq="[CQ:image,file=http://q.qlogo.cn/headimg_dl?dst_uin=".$qq."&spec=640&img_type=jpg]";
if ($get_post_type=="notice"){
if ($get_qun_eve=="group_decrease"&&$get_tishi_api=="leave"){
    $send_msg=$url_qq."这个人：".$qq."，主动离开了本群！\r\n时间：".date("Y/m/d H:i");
}
if ($get_qun_eve=="group_increase"&&$qq!=$robot){
$send_msg="[CQ:at,qq=".$qq."]".$url_qq."欢迎入群！";
}
if ($get_qun_eve == "group_upload"){
$send_msg=$url_qq."上传者：".$qq."\r\n文件ID：[".$Data['file']['id']."]\r\n文件名：".$Data['file']['name']."\r\n文件大小：".$Data['file']['size'];
}

if ($get_qun_eve == "group_admin"){
if ($get_tishi_api == "set"){
$send_msg="群管理员变动\r\n类型：增加\r\nQQ：".$qq."\r\n时间：".date("Y-m-d H:i:s");
}
if ($get_tishi_api == "unset"){
$send_msg="群管理员变动\r\n类型：减少\r\nQQ：".$qq."\r\n时间：".date("Y-m-d H:i:s");
}
}

if ($get_qun_eve == "group_ban"){
if ($get_tishi_api == "ban"){
$send_msg="群事件通知\r\n类型：禁言\r\n被执行人：".$qq."\r\n时间：".date("Y-m-d H:i:s");
}
if ($get_tishi_api == "lift_ban"){
$send_msg="群事件通知\r\n类型：解除禁言\r\n被执行人：".$qq."\r\n时间：".date("Y-m-d H:i:s");
}

}


}
}
$Api_data = array(
"qun"=>$qun,
"qq"=>$qq,
"msg"=>$send_msg,
"S_type"=>"群聊",
"msg_id"=>$msg_id
);
if (!empty($send_msg)){
$data=PHProbot\Api::send($Api_data);
$ws -> push($frame->fd, $data);
}
}
?>