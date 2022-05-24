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

public static function send($Api_data){
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
    echo "bot发送消息：[".$Api_data["msg"]."]\n";
  return $url;
    }

    if ($Api_data["S_type"] == "private"){
    $url = array(
    "action"=>"send_private_msg",
    "params"=>array(
    "user_id"=>$Api_data["qq"],
    "message"=>$Api_data["msg"]
    ));
    $url =json_encode($url,JSON_UNESCAPED_UNICODE);
    echo "bot发送消息：[".$Api_data["msg"]."]\n";
   return $url;
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
    echo "bot发送消息：[".$Api_data["msg"]."]\n";
    return $url;
    }
    if ($Api_data["S_type"] == "群聊"){
       $url = array(
    "action"=>"send_group_msg",
    "params"=>array(
    "group_id"=>$Api_data["qun"],
    "message"=>$Api_data["msg"]
    ));
    $url =json_encode($url,JSON_UNESCAPED_UNICODE);
    echo "bot发送消息：[".$Api_data["msg"]."]\n";
    return $url;
    }
    if ($Api_data["S_type"] == "转发"){
       $url = array(
    "action"=>"send_group_forward_msg",
    "params"=>array(
    "group_id"=>$Api_data["qun"],
    "message"=>$Api_data["msg"]
    ));
    $url =json_encode($url,JSON_UNESCAPED_UNICODE);
    echo "bot转发消息：[".$Api_data["msg"]."]\n";
    return $url;
    
    }
    }

}
}

public static function MC($option=[],$msg){
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
public static function MsgS($MsgS_Data){
if (isset($MsgS_Data)==true){
if (is_array($MsgS_Data) == true){
$msg=$MsgS_Data["msg"];
if (strstr($MsgS_Data["data"],$msg)==true){
if (preg_match("/^$msg ?(.*)\$/",$MsgS_Data["data"],$return)){
return trim($return[1]," ");
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
public static function OCR($return){
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
//即为Get friends
public static function GF(){
$BOT_Config =json_decode(file_get_contents("config.json"),true);
$url = "http://127.0.0.1:".$BOT_Config["http_port"]."/get_friend_list";
$Data = json_decode(file_get_contents($url),true);
for ($i=0;$i<count($Data["data"]);$i++){
$list="ID：".$i."\r\nQQ：".$Data["data"][$i]["user_id"]."\r\n昵称：".$Data["data"][$i]["nickname"]."\r\n备注：".$Data["data"][$i]["remark"]."\r\n\r\n";
file_put_contents("GF.txt",$list,FILE_APPEND);
}
return file_get_contents("GF.txt");

}
public static function DF($user_id){
$BOT_Config =json_decode(file_get_contents("config.json"),true);
$url = "http://127.0.0.1:".$BOT_Config["http_port"]."/delete_friend?friend_id=".$user_id;
file_get_contents($url);
return "已删除好友".$user_id;

}

public function real_ip($type = 0) {
    $ip = $_SERVER['REMOTE_ADDR'];
    if ($type <= 0 && isset($_SERVER['HTTP_X_FORWARDED_FOR']) && preg_match_all('#\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}#s', $_SERVER['HTTP_X_FORWARDED_FOR'], $matches)) {
        foreach ($matches[0] as $xip) {
            if (filter_var($xip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4 | FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE)) {
                $ip = $xip;
                break;
            }
        }
    } elseif ($type <= 0 && isset($_SERVER['HTTP_CLIENT_IP']) && filter_var($_SERVER['HTTP_CLIENT_IP'], FILTER_VALIDATE_IP, FILTER_FLAG_IPV4 | FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE)) {
        $ip = $_SERVER['HTTP_CLIENT_IP'];
    } elseif ($type <= 1 && isset($_SERVER['HTTP_CF_CONNECTING_IP']) && filter_var($_SERVER['HTTP_CF_CONNECTING_IP'], FILTER_VALIDATE_IP, FILTER_FLAG_IPV4 | FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE)) {
        $ip = $_SERVER['HTTP_CF_CONNECTING_IP'];
    } elseif ($type <= 1 && isset($_SERVER['HTTP_X_REAL_IP']) && filter_var($_SERVER['HTTP_X_REAL_IP'], FILTER_VALIDATE_IP, FILTER_FLAG_IPV4 | FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE)) {
        $ip = $_SERVER['HTTP_X_REAL_IP'];
    }
    return $ip;
}
//curl
public function Curl($url, $paras = []) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    //curl_setopt($curl, CURLOPT_HTTPHEADER, array('X-FORWARDED-FOR:'.real_ip(), 'CLIENT-IP:'.real_ip()));
    if (isset($paras['Header'])) {
        $Header = $paras['Header'];
    } else {
        $Header[] = "Accept:*/*";
        $Header[] = "Accept-Encoding:gzip,deflate,sdch";
        $Header[] = "Accept-Language:zh-CN,zh;q=0.8";
        $Header[] = "Connection:close";
        $Header[] = "X-FORWARDED-FOR:" . real_ip();
    }
    curl_setopt($ch, CURLOPT_HTTPHEADER, $Header);
    if (isset($paras['ctime'])) { // 连接超时
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $paras['ctime']);
    } else {
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
    }
    if (isset($paras['rtime'])) { // 读取超时
        curl_setopt($ch, CURLOPT_TIMEOUT, $paras['rtime']);
    }
    if (isset($paras['post'])) {
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $paras['post']);
    }
    if (isset($paras['header'])) {
        curl_setopt($ch, CURLOPT_HEADER, true);
    }
    if (isset($paras['cookie'])) {
        curl_setopt($ch, CURLOPT_COOKIE, $paras['cookie']);
    }
    if (isset($paras['refer'])) {
        if ($paras['refer'] == 1) {
            curl_setopt($ch, CURLOPT_REFERER, 'http://m.qzone.com/infocenter?g_f=');
        } else {
            curl_setopt($ch, CURLOPT_REFERER, $paras['refer']);
        }
    }
    if (isset($paras['ua'])) {
        curl_setopt($ch, CURLOPT_USERAGENT, $paras['ua']);
    } else {
        curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/65.0.3325.181 Safari/537.36");
    }
    if (isset($paras['nobody'])) {
        curl_setopt($ch, CURLOPT_NOBODY, 1);
    }
    //curl_setopt($ch, CURLOPT_ENCODING, "gzip");
    curl_setopt($ch, CURLOPT_ENCODING, 'gzip,deflate');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    if (isset($paras['GetCookie'])) {
        curl_setopt($ch, CURLOPT_HEADER, 1);
        $result = curl_exec($ch);
        preg_match_all("/Set-Cookie: (.*?);/m", $result, $matches);
        $headerSize = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
        $header = substr($result, 0, $headerSize); //状态码
        $body = substr($result, $headerSize);
        $ret = array("cookie" => $matches, "body" => $body, "Header" => $header, 'code' => curl_getinfo($ch, CURLINFO_HTTP_CODE),);
        curl_close($ch);
        return $ret;
    }
    $ret = curl_exec($ch);
    if (isset($paras['loadurl'])) {
        $Headers = curl_getinfo($ch);
        if (isset($Headers['redirect_url'])) {
            $ret = $Headers['redirect_url'];
        } else {
            $ret = false;
        }
    }
    curl_close($ch);
    return $ret;
}


}

//即为Group tube 群管
class GT{
//Super user group
public static function ban($set_array){
if (isset($set_array)==true){
if (is_array($set_array)==true){
$BOT_Config =json_decode(file_get_contents("config.json"),true);
if ($BOT_Config["qhost"]==$set_array["qq"]){
$url = "http://127.0.0.1:".$BOT_Config["http_port"]."/set_group_ban?group_id=".$set_array["qun"]."&user_id=".$set_array["ban_user"]."&duration=".$set_array["time"];
file_get_contents($url);
return "OK";
}
}
}
}

}

?>