<?php

/* *name PHProbot_API

   *version v1.1.6 增加函数word_stock Auto_check 修改qun_host初始化函数

   *date 2021.12.30

   *nick coldeggs

   *explain PHProbot的api模块

   祝大家新年快乐！

*/

/*

{

    "action": "send_private_msg",

    "params": {

        "user_id": 10001000,

        "message": "你好"

    },

    "echo": "123"

}

*/

/*class fake_msg{

function out_qun($qq){

$msg = "【".."(".$qq.")】悄悄地离开了群聊";

}

}

*/

//发送消息

class bot_msg_api{

public $host;

public $qun;

public $send_msg;

public $qq;

public $bots_msg_type;

public $msgid;

function send($host,$qun,$send_msg,$qq,$bots_msg_type,$msgid){

    $bot_msg_type=array(

        "群聊"=>"send_group_msg",

        "私聊"=>"send_private_msg",

        "踢人"=>"set_group_kick"

        );

    if ($bots_msg_type=="群聊"){

    $url = array(

    "action"=>$bot_msg_type["群聊"],

    "params"=>array(

    "group_id"=>$qun,

    "message"=>$send_msg,

    "auto_escape"=>false

    ));

    

    $url =json_encode($url,JSON_UNESCAPED_UNICODE);

    $ws->push($frame->fd, $url);

    }

}

}

?>
