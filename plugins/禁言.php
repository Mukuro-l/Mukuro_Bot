<?php
use PHProbot\Api;
use PHProbot\GT;

$return=PHProbot\Api::MsgS($MsgS_Data=["msg"=>"禁言","data"=>$msg]);
//禁言#群号#QQ号#时间
if ($return!=null){
echo "测试";
$return_data=explode("#",$return);
if (count($return_data)==4){
echo "测试";
$set_array = [
"qun"=>$return_data[1],
//执行人
"qq"=>$qq,
//被禁言的QQ号
"ban_user"=>$return_data[2],
//禁言时间
"time"=>$return_data[3]
];
if (PHProbot\GT::ban($set_array)=="OK"){
$Api_data = array(
"qun"=>$qun,
"qq"=>$qq,
"msg"=>"禁言成功",
"S_type"=>$msg_type,
"msg_id"=>$msg_id
);
$data=PHProbot\Api::send($Api_data);
$ws -> push($frame->fd, $data);
}
}
if (count($return_data)==3){
echo "测试";
$set_array = [
"qun"=>$qun,
//执行人
"qq"=>$qq,
//被禁言的QQ号
"ban_user"=>$return_data[1],
//禁言时间
"time"=>$return_data[2]
];
if (PHProbot\GT::ban($set_array)=="OK"){
$Api_data = array(
"qun"=>$qun,
"qq"=>$qq,
"msg"=>"禁言成功",
"S_type"=>$msg_type,
"msg_id"=>$msg_id
);
$data=PHProbot\Api::send($Api_data);
$ws -> push($frame->fd, $data);
}
}

$return_data=explode(",qq=",$return);
$return_data1=explode("]",$return_data[1]);
if (count($return_data1)==2){
$set_array = [
"qun"=>$qun,
//执行人
"qq"=>$qq,
//被禁言的QQ号
"ban_user"=>$return_data1[0],
//禁言时间
"time"=>$return_data1[1]
];
if (PHProbot\GT::ban($set_array)=="OK"){
$Api_data = array(
"qun"=>$qun,
"qq"=>$qq,
"msg"=>"禁言成功",
"S_type"=>$msg_type,
"msg_id"=>$msg_id
);
$data=PHProbot\Api::send($Api_data);
$ws -> push($frame->fd, $data);
}
}
}