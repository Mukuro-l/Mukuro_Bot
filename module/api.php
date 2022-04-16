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

public static function send(){

global $qun;

global $send_msg;

global $qq;

global $bots_msg_type;

global $msgid;

    if ($bots_msg_type == "group"){

    $url = array(

    "action"=>"send_group_msg",

    "params"=>array(

    "group_id"=>$qun,

    "message"=>$send_msg

    ));

    

    $url =json_encode($url,JSON_UNESCAPED_UNICODE);

   return $url;

    }

    if ($bots_msg_type == "private"){

    $url = array(

    "action"=>"send_private_msg",

    "params"=>array(

    "user_id"=>$qq,

    "message"=>$send_msg

    ));

    

    $url =json_encode($url,JSON_UNESCAPED_UNICODE);

    return $url;

    }

    if ($bots_msg_type == "私聊"){

    $url = array(

    "action"=>"send_private_msg",

    "params"=>array(

    "user_id"=>$qq,

    "message"=>$send_msg

    ));

    

    $url =json_encode($url,JSON_UNESCAPED_UNICODE);

    return $url;

    }

    if ($bots_msg_type == "群聊"){

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
