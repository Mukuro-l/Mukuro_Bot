<?php
//require_once '../share.php';
require_once '../module/curl.php';

function bot_api($send_msg,$bots_msg_type){
    $bot_msg_type=array(
        "群聊"=>"send_group_msg",
        "私聊"=>"send_private_msg",
        "获取账号信息"=>"get_login_info",
        "获取消息"=>"get_msg",
        "获取状态"=>"get_status",
        "踢人"=>"set_group_kick"
        );      
$host="http://127.0.0.1:3366/";
$myqun_bot_api=array(
    "域名"=>$host,
    "信息"=>$send_msg
    );
    $qun_array=array(
    "0",
    "654816907",
    "193181320",
    "953393720",
    "808909428",
    "398512337",
    "693988723"
    );
    if ($bots_msg_type=="群聊"){
    $num=0;
    for($hj=0;$hj<count($qun_array,1);$hj++){
    $num=$num+1;
        $host_type_qun=$myqun_bot_api["域名"].$bot_msg_type["群聊"]."?";
        $qun_msg_sen="group_id=".$qun_array[$num]."&message=".$myqun_bot_api["信息"]."&auto_escape=false";
        $url=$host_type_qun.$qun_msg_sen;
        curl($url);
                
    }
    }
    if ($bots_msg_type=="私聊"){
        $host_type_qun=$myqun_bot_api["域名"].$bot_msg_type["私聊"]."?";
        $qun_msg_sen="group_id=".$myqun_bot_api["群号"]."&user_id=".$qq."&message=".$myqun_bot_api["信息"]."&auto_escape=false";
        $url=$host_type_qun.$qun_msg_sen;
        curl($url);
        
    }

    if ($bots_msg_type=="主聊"){
        $host_type_qun=$myqun_bot_api["域名"].$bot_msg_type["私聊"]."?";
        $qun_msg_sen="group_id=".$myqun_bot_api["群号"]."&user_id=1940826077&message=".$myqun_bot_api["信息"]."&auto_escape=false";
        $url=$host_type_qun.$qun_msg_sen;
        curl($url);
        
    }
    if ($bots_msg_type=="回复私聊"){
        $host_type_qun=$myqun_bot_api["域名"].$bot_msg_type["私聊"]."?";
        $qun_msg_sen="group_id=".$myqun_bot_api["群号"]."&user_id=".$qq."&message=".$myqun_bot_api["信息"]."&auto_escape=false";
        $url=$host_type_qun.$qun_msg_sen;
        curl($url);
        
    }
    
    
}
if (@$_GET['type']==null){
die;
}
if (@$_GET['type']=="晚"){
$bots_msg_type="群聊";
$send_msg="该睡觉了，兄弟们";
bot_api($send_msg,$bots_msg_type);
}
if (@$_GET['type']=="早"){
$img_60s=file_get_contents("http://api.03c3.cn/zb/api.php","r");
$img_60s=json_decode($img_60s,true);
$img_60s=$img_60s['imageUrl'];
$bots_msg_type="群聊";
$send_msg="大家早上好，这是每日早报[CQ:image,file=".$img_60s."]";
bot_api($send_msg,$bots_msg_type);
}
if ($_GET['type']=="gg"){
$send_msg="全网公告：".file_get_contents("http://robot.coldeggs.top/bot/gonggao.txt","r");
$bots_msg_type="群聊";
bot_api($send_msg,$bots_msg_type);
}
if ($_GET['type']=="fx"){
$send_msg=share();
$bots_msg_type="群聊";
bot_api($send_msg,$bots_msg_type);
}
?>