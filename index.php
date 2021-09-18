<?php
$qun=$_POST['qun'];
$msg=$_POST['msg'];
$qq=$_POST['qq'];
$petname=$_POST['petname'];
$atqq=$_POST['atqq'];
$qhost=$_POST['qhost'];
$robot=$_POST['robot'];
//定义接口

/* *@$qun 获取群QQ
   *@$msg 获取消息
   *@$qq 获取发送者QQ
   *@$petname 获取发送者昵称
   *@$atqq 获取艾特QQ
   *@$qhost 获取主人QQ
   *@$robot 获取机器人QQ
   *@QQ1940826077
   *coldeggsblog@coldeggs.top
*/


//判断是否初始化
$dir="./".$qun;
if(file_exists($dir) && is_dir($dir)){
}else if (file_exists('robot.log')!=true){
fopen('robot.log',"w");
chmod('robot.log',0777);
}else{
mkdir ($dir,0777);
$dirc="./".$qun."/robot.conf";
$dirc1="./".$qun."/functions.php";
$dirc2="./".$qun."/wydg.php";
$dirc3="./".$qun."/tg.txt";
$dirc4="./".$qun."/Deeplearning.txt";
copy("robot.conf",$dirc);
copy("functions.php",$dirc1);
copy("wydg.php",$dirc2);
copy("tg.txt",$dirc3);
copy("Deeplearning.txt",$dirc4);
echo "自动初始化成功";
}
$start_time = microtime(true);
$file="./".$qun."/functions.php";

//载入必须函数
include $file;

//Redis缓存器消息队列处理
/*$redis = new Redis();
$redis->connect('127.0.0.1',6379);
try{
$redis->LPUSH($qq,$qun);
}catch(Exception $e){
echo $e->getMessage();
}

$redis = new Redis();
$redis->pconnect('127.0.0.1',6379);
while(true){
try{
$v = $redis->LPOP($qq);
if(!$v){
break;
}
//var_dump($value)."\n";
$qun=$v;
//利用$value进行逻辑和数据处理
}catch(Exception $e){
echo $e->getMessage();
}
}
*/

//判断必须数据
if ($qq==""||$petname==""){
echo "程序没有所需数据无法运行！请参考使用文档！";
echo '<br/>';
$answer=<<<aaa
<h1>本机器人需要的数据如下<h1>
<br/>
<h2>仅支持POST<h2/>
<br/>
<a>qun——群号<a/>
<br/>
<a>msg——消息<a/>
<br/>
<a>qq——QQ号<a/>
<br/>
<a>petname——发送者昵称<a/>
<br/>
<a>atqq——被艾特qq<a/>
<br/>
<a>qhost——主人qq<a/>
<br/>
<a>robot——机器人qq<a/>
<br/>
<h3>调用示例（x6）post<h3/>
<p>.*<p/>
<br/>
<p>$ p o s t(大写不要空格) https://www.coldeggs.top/robot/index.php petname=%昵称%&qq=%QQ%&msg=%参数-1%&qun=%群号%&atqq=%AT0%&robot=%robot%&qhost=%主人%$<p/>
<footer>
<centre>
<a>property in copyright coldeggs<a/>
<br/>
<a>鄂ICP备2021004141号-1<a/>
</centre>
</footer>
aaa;
echo $answer;
die;
}

//判断关键词
if ($msg=="开机"||$msg=="关机"){
Switchmachine($msg,$qq,$qun,$qhost,$robot);
}
//$json=file('msg.json');

//$msg=queuemsgc($qq);

//设置编码
header("Content-type:text/html;charset=utf-8");

//记录日志
$frequency=0;
$data1="[群]".$qun."[QQ]".$qq.PHP_EOL."[text]:".$msg."[date]:".date('Y-m-d h:i:s',time());
$logex=file_get_contents('logex.txt');
if ($logex==100){
file_put_contents('robot.log',$data1);
$logex=($logex-100);
file_put_contents('logex.txt',$logex);
}else{
$log=file_get_contents('robot.log');
$data="[群]".$qun."[QQ]".$qq.PHP_EOL."[text]:".$msg."[date]:".date('Y-m-d h:i:s',time());
file_put_contents('robot.log',PHP_EOL."┉┉┉".$data.PHP_EOL."┉┉┉",FILE_APPEND);
$logex++;
file_put_contents('logex.txt',$logex);
}

//菜单函数
menu($petname,$msg,$qun,$qq);

//版本信息
Versioninformation($msg,$qun,$execution_time);

//获取信息函数
getcpustatus($msg,$qun,$qq,$petname);

//消息处理函数
new atqq($msg,$qq,$qun);

//翻译
fanyi($msg,$qun);


journal($msg,$qun);

//搜图
soutu($msg,$qun);

//深度学习
Deeplearning($msg,$qun);

//深度学习
Deeplearning_open($msg,$qun,$qq);

//舔狗日记函数
meinvtu($msg,$qun);

//获取时间函数
GetDateTime($msg,$qun,$qq);

//我是谁函数
whoisyou($msg,$qun,$qq);

//点歌处理函数
wygeds($msg,$qq,$qun);





