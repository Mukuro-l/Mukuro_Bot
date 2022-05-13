<?php

/* *name PHProbot_API

   *version v1.2

   *date 2022.5.11

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
    if ($Api_data["S_type"] == "转发"){
       $url = array(
    "action"=>"send_group_forward_msg",
    "params"=>array(
    "group_id"=>$Api_data["qun"],
    "message"=>$Api_data["msg"]
    ));
    $url =json_encode($url,JSON_UNESCAPED_UNICODE);
    return $url;
    echo "bot转发消息：[".$Api_data["msg"]."]\n";
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
//即为Message search
function MsgS($MsgS_Data){
if (isset($MsgS_Data)==true){
if (is_array($MsgS_Data) == true){
$msg=$MsgS_Data["msg"];
if (strstr($MsgS_Data["data"],$msg)==true){
if (preg_match("/^$msg ?(.*)\$/",$MsgS_Data["data"],$return)){
return $return[1];
}else{
return null;
}
}else{
return false;
}
}
}

}

//光学字符识别OCR 直接传入CQ码即可
function OCR($return){
if ($return!=null){
$file=explode("[CQ:image,file=",$return);
if (strstr($file[1],"subType")==true){
$data=explode(',',$file[1]);
}else{
$data=explode("]",$file[1]);
}
$BOT_Config =json_decode(file_get_contents("config.json"),true);
$url = "http://127.0.0.1:".$BOT_Config["http_port"]."/ocr_image?image=".$data[0];
echo $data[0]."\n";
$Data = json_decode(file_get_contents($url),true);

$time = rand(576588,16050800);
for ($i=0;$i<count($Data["data"]["texts"]);$i++){
$list = $Data["data"]["texts"][$i]["text"]."\r\n";
file_put_contents("./Ocr/".$time."ocr.txt",$list,FILE_APPEND);
}
return file_get_contents("./Ocr/".$time."ocr.txt");
}

}
}
?>