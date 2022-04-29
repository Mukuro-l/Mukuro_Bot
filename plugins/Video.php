<?php 
header('Access-Control-Allow-Origin:*');
ini_set('display_errors','off');
error_reporting(E_ALL || ~E_NOTICE);
require './src/images_spider.php';
if(preg_match('/[\x{4e00}-\x{9fa5}]/u', $msg)>0){//是否包含中文
if (preg_match('/https:\/\/.*\/\w+/', $msg, $url)){
$url = $url[0];
}
if (preg_match('/http:\/\/.*\/\w+/', $msg, $url)){
$url = $url[0];
}
}
use Images_spider\Images;
$server_msg = new bot_msg_api();
$api = new Images;
if (strpos($url,'weibo') !== false){
    $arr = $api->weibo($url);
} elseif (strpos($url, 'kuaishou') !== false){
    $arr = $api->kuaishou($url);
} elseif (strpos($url, 'pipix') !== false){
    $arr = $api->pipixia($url);
} elseif (strpos($url, 'izuiyou') !== false){
    $arr = $api->zuiyou($url);
} elseif (strpos($url, 'xhslink') !== false){
    $arr = $api->xhs($url);
} else {
    $arr = array(
        'code'  => 201,
        'msg' => '不支持您输入的链接'
    );
}
if (!empty($arr)){
print_r($arr);
foreach ($arr as $data){
file_put_contents($qq."img_list.txt",$data."\r\n",FILE_APPEND);
}
$_msg = file_get_contents($qq."img_list.txt");
$S_type = $msg_type;
$return_msg = $server_msg -> send($qun,$_msg,$qq,$S_type,$msgid);
 $ws -> push($frame->fd, $return_msg);
}
else{
    $arr = array(
        'code' => 201,
        'msg' => '解析失败',
    );
    echo json_encode($arr, JSON_NUMERIC_CHECK | JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
}
?>