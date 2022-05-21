<?php

use PHProbot\Api;

$return=PHProbot\Api::MsgS($MsgS_Data=["msg"=>"添加定时任务","data"=>$msg]);
if ($return!=null){
$tickdata = explode("#",$return);
if (count($tickdata)!=6){
$Api_data = array(
"qun"=>$qun,
"qq"=>$qq,
"msg"=>"请按照要求设置！\r\n格式为[添加定时任务#08:00:00#QQ号#群号#你好#次数（数字）]",
"S_type"=>$msg_type,
"msg_id"=>$msg_id
);
$data=PHProbot\Api::send($Api_data);
$ws -> push($frame->fd, $data);
}else{
//判断是否有配置文件
if (file_exists("tick_config.json")!=true){
//写入第一次的定时任务
$tick_array[$tickdata[1]][] = [
"qq"=>$tickdata[2],
"qun"=>$tickdata[3],
"time"=>$tickdata[1],
"tick"=>$tickdata[5],
"msg"=>$tickdata[4],
"http_port"=>$BOT_Config["http_port"]
];
$data =json_encode($tick_array,JSON_UNESCAPED_UNICODE);
file_put_contents("tick_config.json",$data);
print_r($tick_array);
$Api_data = array(
"qun"=>$qun,
"qq"=>$qq,
"msg"=>"设置成功",
"S_type"=>$msg_type,
"msg_id"=>$msg_id
);
$data=PHProbot\Api::send($Api_data);
$ws -> push($frame->fd, $data);
}else{
$tick_array = json_decode(file_get_contents("tick_config.json"),true);
if ($tick_array[$tickdata[1]]!=null){
$tick_array[$tickdata[1]][count($tick_array[$tickdata[1]])] = [
"qq"=>$tickdata[2],
"qun"=>$tickdata[3],
"time"=>$tickdata[1],
"tick"=>$tickdata[5],
"msg"=>$tickdata[4],
"http_port"=>$BOT_Config["port"]
];
$data =json_encode($tick_array,JSON_UNESCAPED_UNICODE);
file_put_contents("tick_config.json",$data);
print_r($tick_array);
$Api_data = array(
"qun"=>$qun,
"qq"=>$qq,
"msg"=>"设置成功",
"S_type"=>$msg_type,
"msg_id"=>$msg_id
);
$data=PHProbot\Api::send($Api_data);
$ws -> push($frame->fd, $data);
}else{
$tick_array[$tickdata[1]][] = [
"qq"=>$tickdata[2],
"qun"=>$tickdata[3],
"time"=>$tickdata[1],
"tick"=>$tickdata[5],
"msg"=>$tickdata[4],
"http_port"=>$BOT_Config["port"]
];
$data =json_encode($tick_array,JSON_UNESCAPED_UNICODE);
file_put_contents("tick_config.json",$data);
print_r($tick_array);
$Api_data = array(
"qun"=>$qun,
"qq"=>$qq,
"msg"=>"设置成功",
"S_type"=>$msg_type,
"msg_id"=>$msg_id
);
$data=PHProbot\Api::send($Api_data);
$ws -> push($frame->fd, $data);
}
}
}
}
?>