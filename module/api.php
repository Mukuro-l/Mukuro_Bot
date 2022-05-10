<?php

/* *name PHProbot_API

   *version v1.2

   *date 2022.4.15

   *nick coldeggs

   *explain PHProbot的api模块

*/

/*
该json来自onebot官方文档
{

    "action": "send_private_msg",

    "params": {

        "user_id": 10001000,

        "message": "你好"

    },

    "echo": "123"

}

*/
namespace PHProbot;




//发送消息
class Api{

function send($Api_data){
if (isset($Api_data)==true){
if (is_array($Api_data)==true){
    if ($Api_data["S_type"] == "group"){
    $url = array(
    "action"=>"send_group_msg",
    "params"=>array(
    "group_id"=>$Api_data["qun"],
    "message"=>$Api_data["msg"]
    ));
    $url =json_encode($url,JSON_UNESCAPED_UNICODE);
  return $url;
   echo "bot发送消息：[".$Api_data["msg"]."]\n";
    }

    if ($Api_data["S_type"] == "private"){
    $url = array(
    "action"=>"send_private_msg",
    "params"=>array(
    "user_id"=>$Api_data["qq"],
    "message"=>$Api_data["msg"]
    ));
    $url =json_encode($url,JSON_UNESCAPED_UNICODE);
   return $url;
    echo "bot发送消息：[".$Api_data["msg"]."]\n";
    }
//指定发送方式
    if ($Api_data["S_type"] == "私聊"){
 $url = array(
    "action"=>"send_private_msg",
    "params"=>array(
    "user_id"=>$Api_data["qq"],
    "message"=>$Api_data["msg"]
    ));
    $url =json_encode($url,JSON_UNESCAPED_UNICODE);
    return $url;
    echo "bot发送消息：[".$Api_data["msg"]."]\n";
    }
    if ($Api_data["S_type"] == "群聊"){
       $url = array(
    "action"=>"send_group_msg",
    "params"=>array(
    "group_id"=>$Api_data["qun"],
    "message"=>$Api_data["msg"]
    ));
    $url =json_encode($url,JSON_UNESCAPED_UNICODE);
    return $url;
    echo "bot发送消息：[".$Api_data["msg"]."]\n";
    }
    }
    }

}

function MC($option=[],$msg){
if (isset($option)==true){
if (is_array($option) == true){
$quantity = count($option);
for ($i=0;$i<$quantity;$i++){
if ($msg == $option[$i]){
return true;
}
}
}
}

}

}

?>