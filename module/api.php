<?php

/* *name PHProbot_API

   *version v1.2

   *date 2022.4.15

   *nick coldeggs

   *explain PHProbot的api模块

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

//发送消息

class bot_msg_api{

public $qun;

public $_msg;

public $qq;

public $S_type;

public $msgid;

function send($qun,$_msg,$qq,$S_type,$msgid){

    if ($S_type == "group"){

    $url = array(

    "action"=>"send_group_msg",

    "params"=>array(

    "group_id"=>$qun,

    "message"=>$_msg

    ));

    

    $url =json_encode($url,JSON_UNESCAPED_UNICODE);

   return $url;

    }

    if ($S_type == "private"){

    $url = array(

    "action"=>"send_private_msg",

    "params"=>array(

    "user_id"=>$qq,

    "message"=>$_msg

    ));

    

    $url =json_encode($url,JSON_UNESCAPED_UNICODE);

    return $url;

    }

    

}

}

?>
