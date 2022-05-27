<?php
$Api= new PHProbot\Api;
if (!function_exists("Emoji_pack")){
function Emoji_pack($msg=null,$qq=null){
$dir=__FILE__;
$dir=explode("/",$dir);
$A_result=false;
$testCommand = ["丢","仰望大佬","打拳","打","摸头","摸鱼","摸","敲","赞","旋转","吃","吞","咬","快逃","色色","舔","拍","爬","推","踢","捂脸","踩","脆弱"];
$QQ=explode("[CQ:at,qq=",$msg);
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
$return=explode(", ",$data);
$return=explode("Meme-with-QQavatar/result/",$return[0]);
$return=explode("'",$return[1]);
$array[]=$return[0];

$link="../Meme-with-QQavatar/result/".$array[0];
file_put_contents("../gocq/data/images/".$qq.".jpg",file_get_contents($link));
return "[CQ:image,file=".$qq.".jpg]";
}
}
}
}
if ($msg!=null&&$qq!=null){
$Api_data = array(
"qun"=>$qun,
"qq"=>$qq,
"msg"=>Emoji_pack($msg,$qq),
"S_type"=>$msg_type,
"msg_id"=>$msg_id
);
if ($Api_data["msg"]!=null){
$Return_data=$Api->send($Api_data);
}
}
?>
