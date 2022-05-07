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

function send(){
$S_type = $GLOBALS["S_type"];
$ws = $GLOBALS["ws"];
$frame = $GLOBALS["frame"];

    if ($S_type == "group"){

    $url = array(

    "action"=>"send_group_msg",

    "params"=>array(

    "group_id"=>$GLOBALS["qun"],

    "message"=>$GLOBALS['_msg']

    ));

    

    $url =json_encode($url,JSON_UNESCAPED_UNICODE);

   $ws -> push($frame->fd, $url);
   echo "bot发送消息：[".$GLOBALS['_msg']."]\n";
    }

    if ($S_type == "private"){

    $url = array(

    "action"=>"send_private_msg",

    "params"=>array(

    "user_id"=>$GLOBALS["qq"],

    "message"=>$GLOBALS["_msg"]

    ));

    

    $url =json_encode($url,JSON_UNESCAPED_UNICODE);

    $ws -> push($frame->fd, $url);
    echo "bot发送消息：[".$GLOBALS['_msg']."]\n";
    }
//指定发送方式
    if ($S_type == "私聊"){
 $url = array(

    "action"=>"send_private_msg",

    "params"=>array(

    "user_id"=>$GLOBALS["qq"],

    "message"=>$GLOBALS["_msg"]

    ));
    $url =json_encode($url,JSON_UNESCAPED_UNICODE);
    $ws -> push($frame->fd, $url);
    echo "bot发送消息：[".$GLOBALS['_msg']."]\n";
    }
    if ($S_type == "群聊"){
       $url = array(
    "action"=>"send_group_msg",
    "params"=>array(
    "group_id"=>$GLOBALS["qun"],
    "message"=>$GLOBALS["_msg"]

    ));
    $url =json_encode($url,JSON_UNESCAPED_UNICODE);
    $ws -> push($frame->fd, $url);
    echo "bot发送消息：[".$GLOBALS['_msg']."]\n";
    }

    

}

}

?>
