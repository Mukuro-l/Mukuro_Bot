<?php
use PHProbot\Api;
/*
*OCR图片识别插件
*/
$return=PHProbot\Api::MsgS($MsgS_Data=["msg"=>"看图","data"=>$real_msg]);
if ($return!=null){
$data=PHProbot\Api::OCR($return);
$Api_data = array(
"qun"=>$qun,
"qq"=>$qq,
"msg"=>$data,
"S_type"=>$msg_type,
"msg_id"=>$msg_id
);
$data=PHProbot\Api::send($Api_data);
$ws -> push($frame->fd, $data);
}
?>
