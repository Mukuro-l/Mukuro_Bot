<?php

/* *name PHProbot_API

   *version v1.2

   *date 2022.4.15

   *nick coldeggs

   *explain PHProbot的api模块

*/

/*

{   //action为api

    "action": "send_private_msg",

    //params为参数

    "params": {

        "user_id": 10001000,

        "message": "你好"

    },

    "echo": "123"

}

*/

//发送消息

class bot_msg_api{

public $send_msg;

function send($Data,$send_type){

global $send_msg;

$data=json_decode($Data,true);

$msgid=$data['message_id'];//消息id

$qun=$data['group_id'];//群号

$qq=$data['user_id'];//qq号

    if ($send_type == "group"){

    $url = array(

    "action"=>"send_group_msg",

    "params"=>array(

    "group_id"=>$qun,

    "message"=>$send_msg

    ));

    

    $url =json_encode($url,JSON_UNESCAPED_UNICODE);

   return $url;

    }

    if ($send_type == "private"){

    $url = array(

    "action"=>"send_private_msg",

    "params"=>array(

    "user_id"=>$qq,

    "message"=>$send_msg

    ));

    

    $url =json_encode($url,JSON_UNESCAPED_UNICODE);

    return $url;

    }

    if ($send_type == "私聊"){

    $url = array(

    "action"=>"send_private_msg",

    "params"=>array(

    "user_id"=>$qq,

    "message"=>$send_msg

    ));

    

    $url =json_encode($url,JSON_UNESCAPED_UNICODE);

    return $url;

    }

    if ($send_type == "群聊"){

    $url = array(

    "action"=>"send_group_msg",

    "params"=>array(

    "group_id"=>$qun,

    "message"=>$send_msg

    ));

    

    $url =json_encode($url,JSON_UNESCAPED_UNICODE);

   return $url;

    }

}

}

?>
