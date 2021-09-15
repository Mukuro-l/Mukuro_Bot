<?php
//设置编码
header("Content-type:text/html;charset=utf-8");

/*
作者QQ1940826077
*/
//启动计算脚本运行时间
$start_time = microtime(true);

//开关机函数
function Switchmachine($msg,$qq,$qun,$qhost,$robot){
$qqion='±img=http://q2.qlogo.cn/headimg_dl?dst_uin='.$qq.'&spec=5±';
$file1=$qun.'/robot.conf';
$n=file_get_contents($file1);
if ($qq==$qhost&&$n!=$msg){
file_put_contents($file1,$msg);
$n=file_get_contents('robot.conf');
global $n;
echo $qqion.'\r'.$msg."成功";
echo '$改 '.$qun.' '.$robot.' PHProbot'.$msg.'中$';
}else if($qq==$qhost&&$n==$msg){
echo $qqion."已经".$msg;
}else if($qq!=$qhost){
echo $qqion."无权限";
}
}

//判断开关机
function Robotswitch($qun){
$file1=$qun.'/robot.conf';
$n=file_get_contents($file1);
if ($n=="开机"){
print "开机";
}else{
print "关机";
}
}


/*
功能模块*/
//Redis消息队列处理
function queuemsg($qq,$qun){
$redis = new Redis();
$redis->connect('127.0.0.1',6379);
try{
$redis->LPUSH($qq,$msg);
}catch(Exception $e){
echo $e->getMessage();
}
}

function queuemsgc($qq){
$redis = new Redis();
$redis->pconnect('127.0.0.1',6379);
while(true){
try{
$v = $redis->LPOP($qq);
if(!$v){
break;
}
//var_dump($value)."\n";
echo $v;
/*
* 利用$value进行逻辑和数据处理
*/
}catch(Exception $e){
echo $e->getMessage();
}
}
}

//菜单
function menu($petname,$msg,$qun,$qq){
$qqion='±img=http://q2.qlogo.cn/headimg_dl?dst_uin='.$qq.'&spec=5±';
$file1=$qun.'/robot.conf';
$n=file_get_contents($file1);
if ($n=="开机"&&$msg=="菜单"){
echo $qqion.'══PHP机器人══\r开/关机\r点歌歌名😁我的信息\r舔狗日记😁时间\r翻译内容😁查看日志\r版本信息😁搜图内容\r昵称:'.$petname.'\r努力开发中。\r作者1940826077';
}else if ($msg=="菜单"&&$n=="关机"){
echo $qqion."没有开机";
}
}

//判断时间
date_default_timezone_set('PRC'); //设置中国时区
//
function GetDateTime($msg,$qun,$qq){
$qqion='±img=http://q2.qlogo.cn/headimg_dl?dst_uin='.$qq.'&spec=5±';
$file1=$qun.'/robot.conf';
$n=file_get_contents($file1);
if ($n=="开机"&&$msg=="时间"){
$Datetime = date('H');
$text = "";
if($Datetime >= 0 && $Datetime < 7){
$text = "天还没亮，夜猫子，要注意身体哦！ ";
echo $qqion;
echo $text;
echo '\r';
echo str_replace(array('AM','PM'),array('上午','下午'),date("Y-m-d A H:i:s"));
}else if($Datetime>=7 && $Datetime<12){
$text = "上午好！今天天气真不错……哈哈哈，不去玩吗？";
echo $qqion;
echo $text;
echo '\r';
echo str_replace(array('AM','PM'),array('上午','下午'),date("Y-m-d A H:i:s"));
}else if($Datetime >= 12 && $Datetime < 14){
$text = "中午好！午休时间哦，朋友一定是不习惯午睡的吧？！";
echo $qqion;
echo $text;
echo '\r';
echo str_replace(array('AM','PM'),array('上午','下午'),date("Y-m-d A H:i:s"));
}else if($Datetime >= 14 && $Datetime < 18){
$text = "下午茶的时间到了，休息一下吧！ ";
echo $qqion;
echo $text;
echo '\r';
echo str_replace(array('AM','PM'),array('上午','下午'),date("Y-m-d A H:i:s"));
}else if($Datetime >= 18 && $Datetime < 22){
$text = "晚上了宝贝，注意吃饭奥。 ";
echo $qqion;
echo $text;
echo '\r';
echo str_replace(array('AM','PM'),array('上午','下午'),date("Y-m-d A H:i:s"));
}else if($Datetime >= 22 && $Datetime < 24){
$text = "很晚了哦，注意休息呀！(。-ω-)zzz";
echo $qqion;
echo $text;
echo '\r';
echo str_replace(array('AM','PM'),array('上午','下午'),date("Y-m-d A H:i:s"));
}else{
echo "没有开机，大傻逼！";
}
}
}

//消息处理函数类
class atqq{
public $msg;
public $res;
public $res1;
public $n;
public $atqq;
public $qun;
public function __construct($msg,$qq,$qun){
$file1=$qun.'/robot.conf';
$n=file_get_contents($file1);
if ($n=="开机"){
$e=array("早"=>"早啊","早上好"=>"早上好呀","中午好"=>"中午好啊","晚上好"=>"晚上好啊","呜呜呜"=>"不哭不哭，摸摸头，嘿嘿嘿","你是谁"=>"我是PHP机器人，一条指令就有很多功能！","晚安"=>"晚安啦臭宝","欢迎"=>"欢迎欢迎热烈欢迎，快快交保护费","在吗"=>"我在呢","睡觉"=>"晚安啦么么哒","下午好"=>"你们下午好啊");
$qqion='±img=http://q2.qlogo.cn/headimg_dl?dst_uin='.$qq.'&spec=5±';
$this->res=strpos($msg,"机器人");
if ($e[$msg]==true){
$this->res1=strpos($msg,$e[$msg]);
}
if ($this->res>0){
echo $qqion."是在说我吗？给你来一拳🐴";
}else if ($atqq==1722423665){
echo "艾特我干嘛？";
}else if ($this->res1>0){
echo $qqion.$e[$msg];
}else{
echo $e[$msg];
}
}
}
}

//点歌函数
function wygeds($msg,$qq,$qun){
$file1=$qun.'/robot.conf';
$n=file_get_contents($file1);
$qqion='±img=http://q2.qlogo.cn/headimg_dl?dst_uin='.$qq.'&spec=5±';
if ($n=="关机"&&strpos($msg,"歌")>0){
echo $qqion."没有开机哦";
die;
}
if (preg_match('/^[0-9]+$/u',$msg,$matches)==true){
$qqwen="./".$qun."/".$qq.".txt";
$songname=file_get_contents($qqwen);
$w="https://www.coldeggs.top/test/".$qun."/wydg.php?msg=".$songname."&qun=".$qun."&qq=".$qq."&b=".$msg;
$d=curl_init();
curl_setopt($d,CURLOPT_URL,$w);
curl_setopt($d,CURLOPT_RETURNTRANSFER,1);
$data=curl_exec($d);
echo $data;
}
if ($msg=="点歌"){
echo $qqion."请带上歌名哦";
die;
}else if (strpos($msg,"歌")==0||strpos($msg,"点歌")>0){
die;
}else if (file_exists($qq.".txt")){
$qqwen="./".$qun."/".$qq.".txt";
$strl=mb_strlen($msg,'utf-8');
$songname=mb_substr($msg,2,$strl,'utf-8');
$w="https://www.coldeggs.top/test/".$qun."/wydg.php?msg=".$songname."&qun=".$qun."&qq=".$qq;
$d=curl_init();
curl_setopt($d,CURLOPT_URL,$w);
curl_setopt($d,CURLOPT_RETURNTRANSFER,1);
$data=curl_exec($d);
echo $data;
file_put_contents($qqwen,$songname);
echo '\r请选择，发序号';
}else{
$qqwen="./".$qun."/".$qq.".txt";
fopen($qqwen,"w");
chmod($qqwen,0777);
$strl=mb_strlen($msg,'utf-8');
$songname=mb_substr($msg,2,$strl,'utf-8');
file_put_contents($qqwen,$songname);
$w="https://www.coldeggs.top/test/".$qun."/wydg.php?msg=".$songname."&qun=".$qun."&qq=".$qq;
$d=curl_init();
curl_setopt($d,CURLOPT_URL,$w);
curl_setopt($d,CURLOPT_RETURNTRANSFER,1);
$data=curl_exec($d);
echo $data;
echo '\r请选择，发序号';
}
}

//获取信息
function getcpustatus($msg,$qun,$qq,$petname){
$file1=$qun.'/robot.conf';
$n=file_get_contents($file1);
$qqion='±img=http://q2.qlogo.cn/headimg_dl?dst_uin='.$qq.'&spec=5±';
$file1=$qun.'/robot.conf';
$n=file_get_contents($file1);
if ($n=="开机"&&$msg=="我的信息"){
$arr=array("头像"=>$qqion,"昵称："=>$petname,"性别："=>"外星人","QQ："=>$qq);
foreach ($arr as $key=>$value){
echo $key.$value.PHP_EOL;
}
}else if($n=="关机"&&$msg=="我的信息"){
echo "没有开机";
}
}
 
//舔狗日记
function meinvtu($msg,$qun){
$file1=$qun.'/robot.conf';
$n=file_get_contents($file1);
if ($n=="开机"&&$msg=="舔狗日记"){
    $arr=file('tg.txt');
    $n=rand(0,count($arr));
    echo "舔狗日记
    ".date("Y年m月d日")." 晴
    ".$arr[$n];
}else if($n=="关机"&&$msg=="舔狗日记"){
echo "没有开机";
}
}

//我是谁
function whoisyou($msg,$qun,$qq){
$file1=$qun.'/robot.conf';
$n=file_get_contents($file1);
if ($n=="开机"&&$msg=="我是谁"){
if ($qq==1940826077){
echo "你是我的爸爸！";
}else{
echo "你谁？问我干嘛？";}
}else if($n=="关机"&&$msg=="我是谁"){
echo "没有开机";
}
}

function Versioninformation($msg,$qun,$execution_time){
$file1=$qun.'/robot.conf';
$n=file_get_contents($file1);
if ($n=="开机"&&$msg=="版本信息"){
echo '═══PHP机器人═══\r一款由PHP语言开发的机器人，完全运行在服务器端，只需客户端访问即可使用。\r作者QQ1940826077\r调用地址https://www.coldeggs.top/test/index.php\r持续更新中。\r本次运行用时:'.$execution_time;
}else if($n=="关机"&&$msg=="版本信息"){
echo "没有开机";
}
}

function Deeplearning($msg,$qun){
$file1=$qun.'/robot.conf';
$file2=$qun.'/Deeplearning.txt';
$n=file_get_contents($file1);
$n1=file_get_contents($file2);
if ($n=="开机"&&$msg=="开启深度学习"){
file_put_contents($file2,"开启");
echo "开启成功，将会自动记录对话，目前处于开发阶段。";
}else if ($n=="开机"&&$msg=="关闭深度学习"){
file_put_contents($file2,"关闭");
echo "关闭成功";
}
}

//深度学习
function Deeplearning_open($msg,$qun,$qq){
$file1=$qun.'/robot.conf';//配置文件载入
$file2=$qun.'/Deeplearning.txt';//功能配置载入
$n=file_get_contents($file1);
$n1=file_get_contents($file2);

if ($n=="开机"&&$n1=="开启"){
$g=$qun.'/'.$qun.".txt";
if(file_exists($msg)==true||file_exists($g)==true){//判断消息文件及群信息
$g=$qun.'/'.$qun.".txt";
$f=$qun.'/'.$qq.'answer.txt';//消息文件
fopen($g,'w');//创建
file_put_contents($g,$qq);//写入消息qq
if (file_get_contents($f)!=$msg&&file_get_contents($g)==$qq){
$f=$qun.'/'.$qq.'answer.txt';
$g=$qun.'/'.$qun.".txt";
$file = fopen($f, 'w');
fopen($g,'w');
file_put_contents($g,$qq);
$qqhui=file_get_contents($f);
$hui=array(0=>$qqhui);
$hua=array(0=>$msg);
$d=$qun.'/'.$qq.'lins.txt';
$qqlog=file_get_contents($d);
$n=0;
foreach ($hua as $k=>$v) {
$hua2="\r\n".$v."\r\n".$hua[$n];
$hua1=$v."\r\n";
$hua3=$v;
file_put_contents($qqlog, $hua1);
file_put_contents($f,$msg);
echo "ok第一部分";
}
}else{
echo "错误第一部分";
die;
}
}else{
$g=$qun.'/'.$qun.".txt";
$f=$qun.'/'.$qq.'answer.txt';
fopen($qun.'/'.$msg,'w');
fopen($g,'w');
fopen($f,'w');
fopen($qun.'/'.$qq."lins.txt",'w');
file_put_contents($g,$qq);
if (file_get_contents($f)==$msg&&file_get_contents($g)==$qq){
echo "错误第二部分";
die;
}else{
//创建QQ消息文件
$f=$qun.'/'.$qq.'answer.txt';
$g=$qun.'/'.$qun.".txt";
fopen($qun.'/'.$msg,'w');
fopen($qun.'/'.$qq."lins.txt",'w');
$file = fopen($f, 'w');
fopen($g,'w');
file_put_contents($g,$qq);
$qqhui=file_get_contents($f);
$hui=array(0=>$qqhui);
$hua=array(0=>$msg);
$d=$qun.'/'.$qq.'lins.txt';
$n=0;
file_put_contents($d,$msg);
foreach ($hua as $k=>$v) {
$hua2="\r\n".$v."\r\n";
$hua1=$v."\r\n";
$hua3=$v;
file_put_contents($f, $hua3);
file_put_contents($msg,$hua1);
echo "ok第二部分";
}
}
}
}
}

//翻译函数
function fanyi($msg,$qun){
$file1=$qun.'/robot.conf';
$n=file_get_contents($file1);
if ($n=="开机"&&strpos($msg,"译")>0){
$strl=mb_strlen($msg,'utf-8');
$name=mb_substr($msg,2,$strl,'utf-8');
$name = urlencode($name);
$c = file_get_contents("compress.zlib://http://fanyi.youdao.com/openapi.do?keyfrom=yfhknnvt&key=457617074&type=data&doctype=json&version=1.1&q=".$name."");
$json = json_decode($c, true);
preg_match_all("/(.*?)basic\":{\"(.*?)\"(.*?)/",$c,$p);   
$p=$p[2][0];//判断
if($p=="explains"){
preg_match_all("/(.*?)translation\":\[\"(.*?)\"\](.*?)explains\":\[\"(.*?)\"(.*?)/",$c,$j);//翻译、读音和解释
$a = $j[2][0];//翻译
$d = $j[4][0];//解释
$c=$json["query"];//查询的内容
echo "翻译：$c\r结果：$a\r解释：$d";
}else{
preg_match_all("/(.*?)translation\":\[\"(.*?)\"\](.*?)phonetic\":\"(.*?)\"(.*?),\"explains\":\[\"(.*?)\"(.*?)/",$c,$j);//翻译、读音和解释
$a = $j[2][0];//翻译
$b = $j[4][0];//读音
$d = $j[6][0];//解释
$c=$json["query"];//查询的内容
echo "翻译：$c\r结果：$a\r读音：$b\r解释：$d";
}
}else if($n=="关机"&&strpos($msg,"译")>0){
echo "没有开机";
}
}

//查看日志函数
function journal($msg,$qun){
$file1=$qun.'/robot.conf';
$n=file_get_contents($file1);
if ($n=="开机"&&$msg=="查看日志"){
echo "全网本脚本的统计日志：https://www.coldeggs.top/test/dulog.php";
}else if($n=="关机"&&$msg=="查看日志"){
echo "没有开机";
}
}

//搜图函数
function soutu($msg,$qun){
$file1=$qun.'/robot.conf';
$n=file_get_contents($file1);
if ($n=="开机"&&strpos($msg,"图")>0){
$strl=mb_strlen($msg,'utf-8');
$msg=mb_substr($msg,2,$strl,'utf-8');
$url = 'http://image.so.com/i?q='.$msg;
$content = file_get_contents($url);
preg_match_all('/"thumb":"[^,]*,/', $content, $result);
$rep = array('"thumb":"','",','\\');
$str = rand(0,count($result[0])-1);
$str = str_replace($rep, '', $result[0][$str]);
echo "±img=".$str."±";
}else if ($n=="关机"&&strpos($msg,"图")>0){
echo "没有开机";
}
}

//结束计算脚本运行时间
$end_time = microtime(true);
$execution_time = ($end_time - $start_time);