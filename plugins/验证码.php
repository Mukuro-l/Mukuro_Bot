<?php
use PHProbot\Api;
use Hahadu\ImageFactory\Config\Config;
use Hahadu\ImageFactory\Kernel\Factory;
use Swoole\Coroutine;
use function Swoole\Coroutine\run;

if ($msg == "生成"){
$config->setSavePath="../gocq/data/images/";
Factory::setOptions($config);
$option=[
'background'=>'#f5f5dc',
'fill_color'=>'#000000',
'font_size'=>'20',
'filename'=>$qq,
'format'=>'jpg',
];
$_SESSION["qq"]=$qq;
$add1=rand(1,100);
$add2=rand(20,100);
$time = date("His");
$result=($add1+$add2);
$data_array = array();
$data_array[] = array(
"qq"=>$qq,
"qun"=>$qun,
"result"=>$result,
"time"=>$time
);
file_put_contents("V_group.json",json_encode($data_array));

$text = $add1.'+'.$add2.'=？';

$_SESSION["result"]=$result;
$text_mark_url = Factory::text_to_image()->text_create_image($text,$option);
$img = file_get_contents("./images/".$qq.".jpg");
file_put_contents("../gocq/data/images/".$qq.".jpg", $img);
$Api_data = array(
"qun"=>$qun,
"qq"=>$qq,
"msg"=>"[CQ:image,file=".$qq.".jpg]",
"S_type"=>$msg_type,
"msg_id"=>$msg_id
);
$data=PHProbot\Api::send($Api_data);
$ws -> push($frame->fd, $data);
}
if (preg_match("/^[0-9]+$/u", $msg, $return)){

go(function()use($msg,$qq){
$BOT_Config =json_decode(file_get_contents("config.json"),true);
$data_array = json_decode(file_get_contents("V_group.json"),true);
for ($i=0;$i<count($data_array);$i++){
if ($msg==$data_array[$i]["result"]&&$data_array[$i]["qq"]==$qq){
$data_array = json_decode(file_get_contents("V_group.json"),true);
$data ="验证成功";
$url = "http://127.0.0.1:".$BOT_Config["http_port"]."/send_group_msg?group_id=".$data_array[$i]["qun"]."&message=".$data;
file_get_contents($url);
$data_array[$i]["time"]=0;
file_put_contents("V_group.json",json_encode($data_array));
}
}
echo "协程执行完毕\n";
}
);
Swoole\Timer::after(30000, function() use($qq){
$BOT_Config =json_decode(file_get_contents("config.json"),true);
$data_array = json_decode(file_get_contents("V_group.json"),true);
for ($i=0;$i<count($data_array);$i++){
if ($data_array[$i]["time"]!=0&&$data_array[$i]["qq"]==$qq){
$data_array = json_decode(file_get_contents("V_group.json"),true);
$data ="验证超时";
$url = "http://127.0.0.1:".$BOT_Config["http_port"]."/send_group_msg?group_id=".$data_array[$i]["qun"]."&message=".$data;
file_get_contents($url);
echo "执行完成\n";
}
echo "执行完成\n";
}
});

}