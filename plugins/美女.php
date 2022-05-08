<?php
use PHProbot\Api;

if (PHProbot\Api::MC($option=["色图","美女","看色图"],$msg)==true){
$url = "https://api.iyk0.com/mtyh?return=json";
$data = file_get_contents($url);
$data = json_decode($data,true);
$img = file_get_contents($data["imgurl"]);
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
?>