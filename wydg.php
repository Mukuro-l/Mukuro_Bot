<?php
$msg=$_GET['msg'];
$qun=$_GET['qun'];
$qq=$_GET['qq'];
$b=$_GET['b'];
$qqwen=$qq.".txt";
$songname=file_get_contents($qqwen);

$x="xml";
$str = 'http://s.music.163.com/search/get/?src=lofter&type=1&filterDj=true&limit=30&offset=0&s='.$songname.''; 
$str=file_get_contents($str);
$stre = '/{"id":(.*?),"name":"(.*?)","artists":\[{"id":(.*?),"name":"(.*?)","picUrl":(.*?)}\],"album":{"id":(.*?),"name":"(.*?)","artist":{"id":(.*?),"name":"(.*?)","picUrl":(.*?)},"picUrl":"(.*?)"},"audio/'; 
$result = preg_match_all($stre,$str,$trstr);
if($result== 0){
echo "搜索不到与".$songname."的相关歌曲，请稍后重试或换个关键词试试。\r━━━━━━━━━";
}else{
if($b== null){
for( $i = 0 ; $i < $result && $i < 5 ; $i ++ ){
$ga=$trstr[2][$i];//获取歌名
$gb=$trstr[4][$i];//获取歌手
echo ($i+1)."：".$ga."--".$gb."\n";
}
}else{
$i=($b-1);
$id=$trstr[1][$i];//id
$ga=$trstr[2][$i];//获取歌名
$t=$trstr[11][$i];//图
$gb=$trstr[4][$i];//获取歌手
if(!$id == ' '){die ('\r━━━━\n列表中暂无序号为『'.$b.'』的歌曲。');}
if($x=="json"){
echo "json:";
echo '{"app":"com.tencent.structmsg","desc":"音乐","view":"music","ver":"0.0.0.1","prompt":"'.$ga.'","appID":"100495085","sourceName":"","actionData":"","actionData_A":"","sourceUrl":"","meta":{"music":{"action":"","android_pkg_name":"","app_type":1,"appid":100497308,"desc":"'.$gb.'","jumpUrl":"https:\/\/y.music.163.com\/m\/song?id='.$id.'&userid=339843336","musicUrl":"http://music.163.com/song/media/outer/url?id='.$id.'","preview":"'.$t.'","sourceMsgId":"0","source_icon":"","source_url":"","tag":"网易云音乐","title":"'.$ga.'"}},"config":{"autosize":true,"ctime":1629704861,"forward":true,"token":"5773defa9bc33d28a4c235c1324be091","type":"normal"},"text":"","sourceAd":"","extra":"{\"app_type\":1,\"appid\":100497308,\"msg_seq\":6999529082107556302,\"uin\":1940826077}"}';
exit;}
if($x=="xml"){
echo 'card:1<?xml version=\'1.0\' encoding=\'UTF-8\' standalone=\'yes\' ?><msg serviceID="2" templateID="1" action="web" brief="[分享]网易云音乐" sourceMsgId="0" url="http://music.163.com/song/media/outer/url?id='.$id.'" flag="0" adverSign="0" multiMsgFlag="0"><item layout="2"><audio cover="'.$t.'" src="http://music.163.com/song/media/outer/url?id='.$id.'" /><title>'.$ga.'</title><summary>'.$gb.'</summary></item><source name="" icon="" action="app" a_actionData="com.netease.cloudmusic" i_actionData="tencent100495085://" appid="100495085" /></msg>';
exit;}
echo "━━━━\n±img=".$t."±\n歌名：".$ga."\n歌手：".$gb."\n播放链接：http://music.163.com/song/media/outer/url?id=".$id;
}}
?>
