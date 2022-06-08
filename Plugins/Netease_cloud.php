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

$url="http://43.154.119.191/api/key.php?keywords=".urlencode($return);

$song_data=json_decode(file_get_contents($url),true);
$result=$song_data['result'];
$song_list=$result['songs'];//歌曲列表
$list_data=$song_list[$return_list[0]-1];//选歌
$song_id = $list_data["id"];

if ($song_id==null){
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
if (preg_match("/^[0-9]+$/u", $this->msg, $return_list)){

if (is_file($qq."song_list.txt")==true){

$song=file_get_contents($qq."song.txt");
$data_one = explode("#",$song);
$data1 = $data_one[0];
if ($data1 == "语音"){
$data2 = $data_one[1];
$url="http://43.154.119.191/api/key.php?keywords=".urlencode($data2);
$song_data=json_decode(file_get_contents($url),true);
$result=$song_data['result'];
$song_list=$result['songs'];//歌曲列表
$list_data=$song_list[$return_list[0]-1];//选歌
$song_id = $list_data["id"];
$url = "http://music.163.com/song/media/outer/url?id=".$song_id.".mp3";
$url_data = file_get_contents($url);
file_put_contents("../gocq/data/voices/".$song_id.".mp3",$url_data);

$this->send("[CQ:record,file=".$song_id.".mp3]");
unlink($qq."song_list.txt");
}else{
$song=file_get_contents($qq."song.txt");
$data_one = explode("#",$song);
$data1 = $data_one[0];
$data2 = $data_one[1];

$url="http://43.154.119.191/api/key.php?keywords=".urlencode($data2);
$song_data=json_decode(file_get_contents($url),true);
$result=$song_data['result'];
$song_list=$result['songs'];//歌曲列表
$list_data=$song_list[$return_list[0]-1];//选歌
$song_id = $list_data["id"];
$this->send("[CQ:music,type=163,id=".$song_id."]");

unlink($qq."song_list.txt");

unlink($qq."song.txt");

}
}

}

}
}
?>
