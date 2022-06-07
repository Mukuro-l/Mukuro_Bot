<?php
use PHProbot\Module\Api;

/**
*@comment 点歌
*@return image
*/
class Netease_cloud{
use Api;
function plugins_Netease_cloud(){
$return=$this->MsgS(["msg"=>"点歌","data"=>$this->msg]);
if ($return!=null){
var_dump($return);

$str="http://43.154.119.191:3000/search?keywords=$return";

$str=$this->Curl($str);

$str=json_decode($str,true);

$str=$str['result'];

$str=$str['songs'];//歌曲列表

$ga1=$str[0];//选歌

$id=$ga1['id'];

if ($id==null){
return $this->send("获取失败");

}else{

file_put_contents($this->qq."song.txt","点歌#".$return);

for ($i=0;$i<20;$i++){

$list = ($i+1).".<".$str[$i]['name'].">--".$str[$i]['artists'][0]['name']."\r\n";

file_put_contents($this->qq."song_list.txt",$list,FILE_APPEND);

}
file_put_contents($this->qq."song_list.txt",$list."PS：10秒内有效",FILE_APPEND);
$text = file_get_contents($this->qq."song_list.txt","r");
$qq=$this->qq;
Swoole\Timer::after(10000, function() use($qq){
if (file_exists($qq."song_list.txt")==true){
unlink($qq."song_list.txt");
}
});
Text_Images($text, $qq);
return $this->send("[CQ:image,file=".$this->qq.".jpg]");
}


}
}
}
?>
