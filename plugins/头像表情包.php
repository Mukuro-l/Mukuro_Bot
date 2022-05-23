<?php
use PHProbot\Api;
$dir=__FILE__;
$dir=explode("/",$dir);

$testCommand = ["丢","仰望大佬","打拳","打","摸头","摸鱼","摸","敲","赞","旋转","吃","吞","咬","快逃","色色","舔","拍","爬","推","踢","捂脸","踩","脆弱"];
$QQ=explode(" [CQ:at,qq=",$msg);
if ($QQ!=null){
$Command=$QQ[0];
for ($i=0;$i<count($testCommand);$i++){
if ($Command==$testCommand[$i]){
$A_result=true;
}
}
if ($A_result==true){
$QQ=explode("]",$QQ[1]);
$QQ=$QQ[0];
$data = shell_exec("python3 /".$dir[1]."/Meme-with-QQavatar/tool.py ".$Command." ".$QQ);
$return=explode(", ",$data);
$array=[];
for ($i=0;$i<count($return);$i++){
$return=explode(", ",$data);
$return=explode("Meme-with-QQavatar/result/",$return[$i]);
$return=explode("'",$return[1]);
$array[]=$return[0];
}
for ($i=0;$i<count($array);$i++){
$link="../Meme-with-QQavatar/result/".$array[$i];
file_put_contents("../gocq/data/images/".$qq.".jpg",file_get_contents($link));
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
}
}