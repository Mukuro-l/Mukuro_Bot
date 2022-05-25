<?php
use PHProbot\Api;
use Swoole\Coroutine;
use function Swoole\Coroutine\run;

if (preg_match("/^[0-9]+$/u", $msg, $return_list)){

if (file_exists($qq."song_list.txt")==true){

$song=file_get_contents($qq."song.txt");
$data_one = explode("#",$song);
$data1 = $data_one[0];
if ($data1 == "语音"){
$data2 = $data_one[1];
$ge=urlencode($data2);

$str="https://autumnfish.cn/search?keywords=".$ge;

$str=file_get_contents($str);

$str=json_decode($str,true);

$str=$str['result'];

$str=$str['songs'];//歌曲列表

$ga1=$str[$return_list[0]-1];//选歌

$id = $ga1["id"];
file_put_contents("Netease_Cloud_Music.txt",$id);
go(function () {
$id=file_get_contents("Netease_Cloud_Music.txt");
$url = "http://music.163.com/song/media/outer/url?id=".$id.".mp3";
$url_data = file_get_contents($url);
file_put_contents("../gocq/data/voices/".$id.".mp3",$url_data);

echo "协程[".Coroutine::getcid()."]执行完毕\n";

//获取cid

    //Coroutine::getcid()

    //创建新协程

    //Coroutine::create

        //延时执行

//Coroutine::sleep(.2);

}
);
$Api_data = array(
"qun"=>$qun,
"qq"=>$qq,
"msg"=>"[CQ:record,file=".$id.".mp3]",
"S_type"=>$msg_type,
"msg_id"=>$msg_id
);
$data=PHProbot\Api::send($Api_data);
unlink($qq."song_list.txt");
}else{
$song=file_get_contents($qq."song.txt");
$data_one = explode("#",$song);
$data1 = $data_one[0];
$data2 = $data_one[1];

$ge=urlencode($data2);

$str="https://autumnfish.cn/search?keywords=".$ge;

$str=file_get_contents($str);

$str=json_decode($str,true);

$str=$str['result'];

$str=$str['songs'];//歌曲列表

$ga1=$str[$return_list[0]-1];//选歌

$id = $ga1["id"];
$Api_data = array(
"qun"=>$qun,
"qq"=>$qq,
"msg"=>"[CQ:music,type=163,id=".$id."]",
"S_type"=>$msg_type,
"msg_id"=>$msg_id
);
$data=PHProbot\Api::send($Api_data);

unlink($qq."song_list.txt");

unlink($qq."song.txt");

}
}

}
?>
