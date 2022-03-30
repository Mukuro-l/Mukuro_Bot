<?php



//计算开始运行
$start_time = microtime(true);


//═════════功能区域═══════
function Welcome_mail($qq,$qun){
$mail_bt="欢迎入群";
$send_mail='<h1>你好'.$qq.'<h1/><hr>我是来自coldeggs的CP·Bot机器人，<br/>欢迎你加入'.$qun.'这个大家庭，<br/>我的功能请在群内发送菜单查看哦<hr>coldeggs运营联系方式：QQ 1940826077<br/>邮箱：coldeggsblog@coldeggs.top<br/>官方群：193181320<br/>官方网站：https://www.coldeggs.top/<hr>此致<br/>CP·Bot管理团队';
bot_mail($qq,$send_mail,$mail_bt);
}

//调用记录词库函数
$word_stock_data = word_stock($msg);

//判断是否存在词条
if ($word_stock_data != "true"){
$img_code=str_replace('[', '', $word_stock_data);
$img_code=str_replace('?term=3,subType=0]','',$img_code);
//判断是否为图片
if (preg_match("/^CQ:image,file= ?(.*)\$/",$img_code,$return)){
$send_msg = $word_stock_data;
$bots_msg_type = "群聊";
bot_api($host,$qun,$send_msg,$qq,$bots_msg_type,$msgid);
}else{
$send_msg = $word_stock_data;
$bots_msg_type = "回复";
bot_api($host,$qun,$send_msg,$qq,$bots_msg_type,$msgid);
}
}else{
$send_msg = "真寻已经记录啦ε(*･ω･)_/ﾟ:･☆";
$bots_msg_type = "回复";
bot_api($host,$qun,$send_msg,$qq,$bots_msg_type,$msgid);
}

if ($msg=="测试"){
$tts_msg = "你好";
$bots_msg_type = "群聊";
$url = baidu_tts($tts_msg,$directory);
bot_vio_api($host,$qun,$url,$qq,$bots_msg_type);
}

if(preg_match('/[\x{4e00}-\x{9fa5}]/u', $msg)>0){//是否包含中文
if (preg_match('/https:\/\/v.kuaishouapp.com.*\/\w+/', $msg, $url)){
$kuai_url=$url[0];
$send_msg=kuai_shou($kuai_url);
$bots_msg_type="私聊";
bot_api($host,$qun,$send_msg,$qq,$bots_msg_type,$msgid);
}
}

if (preg_match("/^公告 ?(.*)\$/",$msg,$return)){
if ($qhost!=$qq){
exit;
}
$send_msg = $return[1];
up_group_notes($up_group_notes,$host,$qun,$send_msg);
}

if ($msg=="菜单"){
$miui=file_get_contents($dir_qun,"r");
$miui=json_decode($miui,true);
if ($miui[$qhost]!="开机"){
$bots_msg_type="回复";
$send_msg="没有开机";
bot_api($host,$qun,$send_msg,$qq,$bots_msg_type,$msgid);
}else{
$Happy_new_year ="距离新年还剩：".(24-date("H"))."小时".(60-date("i"))."分";
$send_msg=send_qqimg_api($qq).'点歌.*'."\r\n".'搜图.*'."\r\n".'我说.*'."\r\n".'舔狗日记'."\r\n"."生成密码"."\r\n"."抖音"."\r\n"."哔哩哔哩分区(维护中)"."\r\n"."群管/开/关"."\r\n"."官网"."\r\n"."要饭"."\r\n"."60s"."\r\n"."抽奖"."\r\n".'堆糖.*'."\r\n".'二维码.*'."\r\n"."公告[".file_get_contents("gonggao.txt","r")."]\r\n".date("Y/m/d H:i");
$bots_msg_type="回复";
    bot_api($host,$qun,$send_msg,$qq,$bots_msg_type,$msgid);
    //$send_msg="点歌.*搜图.*我说.*舔狗日记生成密码";
    //$json_type="菜单";
    //$token=Tencent_json_token();
    //bot_msg_json($send_json,$json_type,$host,$bots_msg_type,$qq,$qun);
    }
    }

//———————事件监控———

if ($get_qun_eve=="group_recall"&&$qq!=$robot){
    $bots_msg_type="主聊";
    $send_msg=$qq."这个人在".date("H:i:s")."撤回了一条消息如下\r\n".eve_qun_msg($host,$msgid);
   bot_api($host,$qun,$send_msg,$qq,$bots_msg_type,$msgid);
   
    
}

if ($get_qun_eve=="notify"&&$get_tishi_api=="poke"&&$chuo_userid==$robot){
$miui=file_get_contents($dir_qun,"r");
$miui=json_decode($miui,true);
if ($miui[$qhost]!="开机"){
$bots_msg_type="回复";
$send_msg="没有开机";
bot_api($host,$qun,$send_msg,$qq,$bots_msg_type,$msgid);
}else{
    $bots_msg_type="回复";
    $text_array = array(
    "你是没有见过黑手是吧",
    "你再戳一个试试",
    "给你脸了是吧",
    "林子大了，什么都有"
    );
    $send_msg="[CQ:tts,text=".$text_array[rand(0,count($text_array))]."]";
    bot_api($host,$qun,$send_msg,$qq,$bots_msg_type,$msgid);
    
}
}

if ($get_qun_eve=="notify"&&$get_tishi_api=="honor"&&$qunry=="talkative"){
$miui=file_get_contents($dir_qun,"r");
$miui=json_decode($miui,true);
if ($miui[$qhost]!="开机"){
$bots_msg_type="回复";
$send_msg="没有开机";
bot_api($host,$qun,$send_msg,$qq,$bots_msg_type,$msgid);
}else{
    $send_msg="[CQ:at,qq=".$qq."]成为龙王，芜湖！";
    $bots_msg_type="群聊";
    bot_api($host,$qun,$send_msg,$qq,$bots_msg_type,$msgid);
    
}
}
if ($get_qun_eve=="notify"&&$get_tishi_api=="honor"&&$qunry=="performer"){
$miui=file_get_contents($dir_qun,"r");
$miui=json_decode($miui,true);
if ($miui[$qhost]!="开机"){
$bots_msg_type="回复";
$send_msg="没有开机";
bot_api($host,$qun,$send_msg,$qq,$bots_msg_type,$msgid);
}else{
    $send_msg="[CQ:at,qq=".$qq."]获得群聊之火";
    $bots_msg_type="群聊";
    bot_api($host,$qun,$send_msg,$qq,$bots_msg_type,$msgid);
}
}

if ($get_qun_eve=="notify"&&$get_tishi_api=="honor"&&$qunry=="emotion"){
$miui=file_get_contents($dir_qun,"r");
$miui=json_decode($miui,true);
if ($miui[$qhost]!="开机"){
$send_msg="没有开机";
die;
bot_api($host,$qun,$send_msg,$qq,$bots_msg_type,$msgid);
}
    $send_msg="[CQ:at,qq=".$qq."]获得快乐源泉";
    $bots_msg_type="群聊";
    bot_api($host,$qun,$send_msg,$qq,$bots_msg_type,$msgid);
    
}
if ($get_tishi_api=="add"&&$get_qing_api=="group"){
$miui=file_get_contents($dir_qun,"r");
$miui=json_decode($miui,true);
if ($miui[$qhost]!="开机"){
$send_msg="没有开机";
die;
bot_api($host,$qun,$send_msg,$qq,$bots_msg_type,$msgid);
}
    $send_msg="有人申请加群:".$qun."\r\n他的QQ：".$qq."\r\n他的验证消息为：".$get_yanz_qun;
    $bots_msg_type="群聊";
    bot_api($host,$qun,$send_msg,$qq,$bots_msg_type,$msgid);
    
}
if ($get_qing_api=="friend"){
$miui=file_get_contents($dir_qun,"r");
$miui=json_decode($miui,true);
if ($miui[$qhost]!="开机"){
$send_msg="没有开机";
die;
bot_api($host,$qun,$send_msg,$qq,$bots_msg_type,$msgid);
}
    $send_msg="有人申请加我taQQ为：".$qq."\r\n他的验证消息为：".$get_yanz_qun;
    $bots_msg_type="主聊";
    bot_api($host,$qun,$send_msg,$qq,$bots_msg_type,$msgid);
    
}
if ($get_qun_eve=="group_decrease"&&$get_tishi_api=="leave"){
$miui=file_get_contents($dir_qun,"r");
$miui=json_decode($miui,true);
if ($miui[$qhost]!="开机"){
$send_msg="没有开机";
die;
bot_api($host,$qun,$send_msg,$qq,$bots_msg_type,$msgid);
}
    $send_msg=send_qqimg_api($qq)."这个人：".$qq."，主动离开了本群！\r\n时间：".date("Y/m/d H:i");
    $bots_msg_type="群聊";
    bot_api($host,$qun,$send_msg,$qq,$bots_msg_type,$msgid);
}
if ($get_qun_eve=="group_decrease"&&$get_tishi_api=="kick"){
$miui=file_get_contents($dir_qun,"r");
$miui=json_decode($miui,true);
if ($miui[$qhost]!="开机"){
$send_msg="没有开机";
die;
bot_api($host,$qun,$send_msg,$qq,$bots_msg_type,$msgid);
}
    $send_msg=send_qqimg_api($qq)."这个B：".$qq."，被踢了，笑死我了。\r\n时间：".date("Y/m/d");
    $bots_msg_type="群聊";
    bot_api($host,$qun,$send_msg,$qq,$bots_msg_type,$msgid);
}
if ($get_qun_eve=="group_decrease"&&$get_tishi_api=="kick_me"){
    $send_msg="主人，我被踢了，".$qun;
    $bots_msg_type="主聊";
    bot_api($host,$qun,$send_msg,$qq,$bots_msg_type,$msgid);
}
if ($get_qun_eve=="group_admin"&&$get_tishi_api=="set"){
$miui=file_get_contents($dir_qun,"r");
$miui=json_decode($miui,true);
if ($miui[$qhost]!="开机"){
$send_msg="没有开机";
die;
bot_api($host,$qun,$send_msg,$qq,$bots_msg_type,$msgid);
}
$send_msg="[CQ:at,qq=".$qq."]"."我知道你成为了管理，那我能和你py交易嘛(*^ω^*)";
$bots_msg_type="群聊";
bot_api($host,$qun,$send_msg,$qq,$bots_msg_type,$msgid);
}
if ($get_qun_eve=="group_admin"&&$get_tishi_api=="unset"){
$miui=file_get_contents($dir_qun,"r");
$miui=json_decode($miui,true);
if ($miui[$qhost]!="开机"){
$send_msg="没有开机";
die;

bot_api($host,$qun,$send_msg,$qq,$bots_msg_type,$msgid);
}
$send_msg="[CQ:at,qq=".$qq."]"."哎呀这个刁毛被下了管理，谁知道他偷哪位女群员了(≖͞_≖̥)";
$bots_msg_type="群聊";
bot_api($host,$qun,$send_msg,$qq,$bots_msg_type,$msgid);
}
//进群事件
if ($get_qun_eve=="group_increase"&&$qq!=$robot){
$miui=file_get_contents($dir_qun,"r");
$miui=json_decode($miui,true);
if ($miui[$qhost]!="开机"){
$send_msg="没有开机";
die;
bot_api($host,$qun,$send_msg,$qq,$bots_msg_type,$msgid);
}
    $send_msg="[CQ:at,qq=".$qq."][CQ:image,file=https://www.coldeggs.top/emo/qunhuanying.gif]欢迎入群！";
    $bots_msg_type="群聊";
    bot_api($host,$qun,$send_msg,$qq,$bots_msg_type,$msgid);
    
    
$miui=file_get_contents($dir_qun,"r");
$miui=json_decode($miui,true);
if ($miui["群管"]=="开"){
$Verification_Code=rand(1888,4589);
$Verification_Codeary=array(
"qun"=>$qun,
"code"=>$Verification_Code,
"ci"=>0
);
fopen('./bottp/'.$qq.'.json',"w");
chmod('./bottp/'.$qq.'.json',0777);
$Verification_Codeary=json_encode($Verification_Codeary,JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
file_put_contents('./bottp/'.$qq.'.json',$Verification_Codeary);
    $time=60*10;
    $qqjin=$qq;
    qun_jinyan($host,$qun,$qqjin,$time);
    $send_msg="请私聊输入验证码：".$Verification_Code;
    $bots_msg_type="群聊";
    bot_api($host,$qun,$send_msg,$qq,$bots_msg_type,$msgid);
    sleep(1);
    $send_msg="你一共有5次机会，请输入验证码：".$Verification_Code;
    $bots_msg_type="私聊";
    bot_api($host,$qun,$send_msg,$qq,$bots_msg_type,$msgid);
}
}
//————————事件监控——————

//————————功能区域——————

//滑稽表情回复
if ($msg=="[CQ:face,id=178]"){
$miui=file_get_contents($dir_qun,"r");
$miui=json_decode($miui,true);
if ($miui[$qhost]!="开机"){
$bots_msg_type="回复";
$send_msg="没有开机";
bot_api($host,$qun,$send_msg,$qq,$bots_msg_type,$msgid);
}else{
    $send_emo=array(
        1=>"年少不知少妇好，错把少女当成宝",
        2=>"你滑稽我也滑稽",
        3=>"我没事就喜欢这样",
        4=>"你猜我在想什么",
        5=>"我突然出现吓死你"
        );
        $send_emo_id=rand(0,6);
        $send_msg="[CQ:face,id=178]".$send_emo[$send_emo_id];
        $bots_msg_type="回复";
        bot_api($host,$qun,$send_msg,$qq,$bots_msg_type,$msgid);
    
}
}

//复读语音//过滤
/*if (strpos($msg,'record')>0){
    $miui=file_get_contents($dir_qun,"r");
$miui=json_decode($miui,true);
if ($miui[$qhost]!="开机"){
$send_msg="没有开机";
die;
bot_api($host,$qun,$send_msg,$qq,$bots_msg_type,$msgid);
}
    $md1=str_replace('[', '', $real_msg);
$md1=str_replace('CQ', '', $md1);
$md1=str_replace(':', '', $md1);
$md1=str_replace('record', '', $md1);
$md1=str_replace(',', '', $md1);
$md1=str_replace('file', '', $md1);
$md1=str_replace('=', '', $md1);
$md1=str_replace(']', '', $md1);
$url=trim($md1);
sleep(1);
    $bots_msg_type="群聊";
    bot_vio_api($host,$qun,$url,$qq,$bots_msg_type);
    
}
*/
//转语音
if (preg_match("/^我说 ?(.*)\$/",$msg,$return)){
$miui=file_get_contents($dir_qun,"r");
$miui=json_decode($miui,true);
if ($miui[$qhost]!="开机"){
$bots_msg_type="回复";
$send_msg="没有开机";
bot_api($host,$qun,$send_msg,$qq,$bots_msg_type,$msgid);
}else{
    $send_msg="[CQ:tts,text=".$return[1]."]";
    $bots_msg_type="群聊";
    bot_api($host,$qun,$send_msg,$qq,$bots_msg_type,$msgid);
    
}
}




//$atqq=str_replace(' ', '', $atqq);
if (bot_atqq($msg) == $robot){
$bots_msg_type="回复";
$send_msg="你好";
bot_api($host,$qun,$send_msg,$qq,$bots_msg_type,$msgid);
}

if (preg_match("/^😄 ?(.*)\$/",$msg,$return)){
$bots_msg_type="回复";
$send_msg="😅";
bot_api($host,$qun,$send_msg,$qq,$bots_msg_type,$msgid);
}

if (preg_match("/^BV ?(.*)\$/",$msg,$return)){
$miui=file_get_contents($dir_qun,"r");
$miui=json_decode($miui,true);
if ($miui[$qhost]!="开机"){
$bots_msg_type="回复";
$send_msg="没有开机";
bot_api($host,$qun,$send_msg,$qq,$bots_msg_type,$msgid);
}else{
$bili_id=$return[0];
$bilibili = new bilibili();
$send_msg=$bilibili->bili_details($bili_id);
$bots_msg_type="群聊";
bot_api($host,$qun,$send_msg,$qq,$bots_msg_type,$msgid);
}
}
//私聊消息
if ($msg_type=="private"){
if (file_exists('./bottp/'.$qq.'.json')==true){
$pan_qq=file_get_contents('./bottp/'.$qq.'.json',"r");
if ($pan_qq!="yes"){
$x_code=file_get_contents('./bottp/'.$qq.'.json',"r");
$x_code=json_decode($x_code,true);
$xqun_code=$x_code["qun"];
$xqq_code=$x_code["code"];
$x_ci=$x_code["ci"];
if ($msg==$xqq_code){
$send_msg="验证成功";
$qun=$xqun_code;
$bots_msg_type="私聊";
bot_api($host,$qun,$send_msg,$qq,$bots_msg_type,$msgid);
file_put_contents('./bottp/'.$qq.'.json',"yes");
$time=0;
$qqjin=$qq;
qun_jinyan($host,$qun,$qqjin,$time);

Welcome_mail($qq,$qun);

}else{
$x_code=file_get_contents('./bottp/'.$qq.'.json',"r");
$x_code=json_decode($x_code,true);
$xqun_code=$x_code["qun"];
$xqq_code=$x_code["code"];
$x_ci=$x_code["ci"];
if ($x_ci==5){
$x_code=file_get_contents('./bottp/'.$qq.'.json',"r");
$x_code=json_decode($x_code,true);
$xqun_code=$x_code["qun"];
$qun=$xqun_code;
$bots_msg_type="踢人";
$send_msg="验证失败";
bot_api($host,$qun,$send_msg,$qq,$bots_msg_type,$msgid);
}else{

$x_code=file_get_contents('./bottp/'.$qq.'.json',"r");
$x_code=json_decode($x_code,true);
$xqun_code=$x_code["qun"];
$xqq_code=$x_code["code"];
$x_ci=$x_code["ci"];
$Verification_Codeary=array(
"qun"=>$xqun_code,
"code"=>$xqq_code,
"ci"=>$x_ci+1
);
$Verification_Codeary=json_encode($Verification_Codeary,JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
file_put_contents('./bottp/'.$qq.'.json',$Verification_Codeary);
$bots_msg_type="私聊";
$send_msg="验证失败";
bot_api($host,$qun,$send_msg,$qq,$bots_msg_type,$msgid);
}
}
}
}
if (preg_match("/^BV ?(.*)\$/",$msg,$return)){
$bv_id=$return[0];
$send_msg=bv_toav($bv_id);
$bots_msg_type="私聊";
bot_api($host,$qun,$send_msg,$qq,$bots_msg_type,$msgid);
}else if(preg_match('/[\x{4e00}-\x{9fa5}]/u', $msg)>0){//是否包含中文
if (preg_match('/https:\/\/v.kuaishouapp.com.*\/\w+/', $msg, $url)){
$kuai_url=$url[0];
$send_msg=kuai_shou($kuai_url);
$bots_msg_type="私聊";
bot_api($host,$qun,$send_msg,$qq,$bots_msg_type,$msgid);
}
}else{
$roboter="http://api.qingyunke.com/api.php?key=free&appid=0&msg=".$msg;
$send_msg=file_get_contents($roboter,"r");
$send_msg=json_decode($send_msg,true);
$send_msg=$send_msg['content'];
$bots_msg_type="私聊";
bot_api($host,$qun,$send_msg,$qq,$bots_msg_type,$msgid);
}
}

//搜图
if (preg_match("/^搜图 ?(.*)\$/",$msg,$return)){
$miui=file_get_contents($dir_qun,"r");
$miui=json_decode($miui,true);
if ($miui[$qhost]!="开机"){
$bots_msg_type="回复";
$send_msg="没有开机";
bot_api($host,$qun,$send_msg,$qq,$bots_msg_type,$msgid);
}else{
    $url = 'http://image.so.com/i?q='.$return[1];
    $content = file_get_contents($url);
    preg_match_all('/"thumb":"[^,]*,/', $content, $result);
    $rep = array('"thumb":"','",','\\');
    $str = rand(0,count($result[0])-1);
    $str = str_replace($rep, '', $result[0][$str]);
    $bots_msg_type="群聊";
    $send_msg=$str;
    bot_send_img($host,$qun,$send_msg,$qq,$bots_msg_type);
    
}
}


//识别图片
$img_code=str_replace('[', '', $msg);
$img_code=str_replace(']','',$img_code);
if (preg_match("/^CQ:image,file= ?(.*)\$/",$img_code,$return)){
$miui=file_get_contents($dir_qun,"r");
$miui=json_decode($miui,true);
if ($miui["识图"]!="开"){
die;
}
if (preg_match('/https:\/\/.*\/\w+/', $img_code, $url)){
$bots_msg_type="回复";
$img_id=$url[0];
//$url[0]链接
$send_msg=$img_id;//bot_ocr($img_id,$host,$get_imgocr_api);
bot_api($host,$qun,$send_msg,$qq,$bots_msg_type,$msgid);
}
}

if (preg_match("/^禁言 ?(.*)\$/",$msg,$return)){
$miui=file_get_contents($dir_qun,"r");
$miui=json_decode($miui,true);
if ($miui[$qhost]!="开机"){
$bots_msg_type="回复";
$send_msg="没有开机";
bot_api($host,$qun,$send_msg,$qq,$bots_msg_type,$msgid);
}else{
if ($qq==$qhost){
    $qqjin=$return[1];
    $qqjin=str_replace(']', '', $qqjin);
    $qqjin=str_replace('[CQ:at,qq=', '', $qqjin);
    $qqjin=str_replace(' ', '', $qqjin);
    $time=60*60;//秒
    qun_jinyan($host,$qun,$qqjin,$time);
    $bots_msg_type="回复";
    $send_msg="禁言成功";
bot_api($host,$qun,$send_msg,$qq,$bots_msg_type,$msgid);
    }else{
    $bots_msg_type="回复";
    $send_msg="你没有权限，你禁言nm";
bot_api($host,$qun,$send_msg,$qq,$bots_msg_type,$msgid);
}
}
}

if (preg_match("/^解禁?(.*)\$/",$msg,$return)){
$miui=file_get_contents($dir_qun,"r");
$miui=json_decode($miui,true);
if ($miui[$qhost]!="开机"){
$bots_msg_type="回复";
$send_msg="没有开机";
bot_api($host,$qun,$send_msg,$qq,$bots_msg_type,$msgid);
}else{
if ($qq==$qhost){
    $qqjin=$return[1];
    $qqjin=str_replace(']', '', $qqjin);
    $qqjin=str_replace('[CQ:at,qq=', '', $qqjin);
    $qqjin=str_replace(' ', '', $qqjin);
    $time=0;
    qun_jinyan($host,$qun,$qqjin,$time);
    $bots_msg_type="回复";
    $send_msg="解禁成功";
    bot_api($host,$qun,$send_msg,$qq,$bots_msg_type,$msgid);
}else{
    $send_msg="你没有权限，你解禁nm";
bot_api($host,$qun,$send_msg,$qq,$bots_msg_type,$msgid);
}
}
}

  if ($msg=="舔狗日记"){
  $miui=file_get_contents($dir_qun,"r");
$miui=json_decode($miui,true);
if ($miui[$qhost]!="开机"){
$bots_msg_type="回复";
$send_msg="没有开机";
bot_api($host,$qun,$send_msg,$qq,$bots_msg_type,$msgid);
}else{
  $arr=file('tg.txt');
    $n=rand(0,count($arr));
    $send_msg="舔狗日记
    ".date("Y年m月d日")." 晴
    ".$arr[$n];
    $bots_msg_type="群聊";
  bot_msg_img($host,$send_msg,$qun,$qq,$bots_msg_type,$directory);
  }
  }
  


if ($msg=="状态"){
$miui=file_get_contents($dir_qun,"r");
$miui=json_decode($miui,true);
if ($miui[$qhost]!="开机"){
$bots_msg_type="回复";
$send_msg="没有开机";
bot_api($host,$qun,$send_msg,$qq,$bots_msg_type,$msgid);
}else{
$bots_getmsg_type="状态";
bot_get_more_ion($host,$msg,$qun,$send_msg,$qqnick,$qq,$bots_msg_type,$bots_getmsg_type);
opendir($qun);
$dir_qqun="./group/".$qun."/robotconf.json";
$send_mssg=file_get_contents($dir_qqun,"r");
$send_mssg=json_decode($send_mssg,true);
$url=send_qqimg_api($qq);
$send_msg='昵称：'.$qqnick."\r\n丢失数据[".$send_mssg["丢失的数据"]."]"."\r\n接受消息[".$send_mssg["接受的消息"]."]"."\r\n发送消息[".$send_mssg["发送的消息"]."]"."\r\n断连次数[".$send_mssg["断连次数"]."]"."\r\n掉线次数[".$send_mssg["掉线次数"]."]"."\r\n发送的数据包[".$send_mssg["发送的数据"]."]"."\r\n收到的数据包[".$send_mssg["收到的数据"]."]";
$bots_msg_type="回复";
bot_api($host,$qun,$send_msg,$qq,$bots_msg_type,$msgid);
}
}
          

if ($msg=="抽奖"){
$miui=file_get_contents($dir_qun,"r");
$miui=json_decode($miui,true);
if ($miui[$qhost]!="开机"){
$bots_msg_type="回复";
$send_msg="没有开机";
bot_api($host,$qun,$send_msg,$qq,$bots_msg_type,$msgid);
}else{
$timerand=array(
60,
120,
360,
1800
);
$random=rand(0,4);
$time=$timerand[$random];
$qqjin=$qq;
qun_jinyan($host,$qun,$qqjin,$time);
}
}

if ($msg=="生成密码"){
$miui=file_get_contents($dir_qun,"r");
$miui=json_decode($miui,true);
if ($miui[$qhost]!="开机"){
$bots_msg_type="回复";
$send_msg="没有开机";
bot_api($host,$qun,$send_msg,$qq,$bots_msg_type,$msgid);
}else{
$miyao=create_unique();
$send_msg=$miyao;
$bots_msg_type="回复";
bot_api($host,$qun,$send_msg,$qq,$bots_msg_type,$msgid);
}
}

//开关机
//判断关键词
if ($msg=="开机"||$msg=="关机"){
$bots_msg_type="回复";
//读取配置文件
$miui=file_get_contents($dir_qun,"r");
//转为数组
$miui=json_decode($miui,true);
//判断状态
if ($miui[$qq]==$msg){
$send_msg="本来就是".$msg."状态";
//调用api
bot_api($host,$qun,$send_msg,$qq,$bots_msg_type,$msgid);
}else{
$bots_msg_type="回复";
//识别动作类型
$bb_type="开关机";
//调用函数Switch_machine，该函数内置了部分开关控制
$send_msg=Switch_machine($msg,$qq,$qun,$qhost,$bb_type);
bot_api($host,$qun,$send_msg,$qq,$bots_msg_type,$msgid);
}
}

if (preg_match("/^识图 ?(.*)\$/",$msg,$return)){
if ($return[1]!=="开"&&$return[1]!=="关"){
die;
}
$bots_msg_type="回复";
$bb_type="识图";
$msg=$return[1];
$send_msg=Switch_machine($msg,$qq,$qun,$qhost,$bb_type);
$miui=file_get_contents($dir_qun,"r");
$miui=json_decode($miui,true);
if ($miui["识图"]==$return[1]){
$msg=$return[1];
$send_msg=Switch_machine($msg,$qq,$qun,$qhost,$bb_type);
bot_api($host,$qun,$send_msg,$qq,$bots_msg_type,$msgid);
}
}

if ($msg=="抖音"){
    $miui=file_get_contents($dir_qun,"r");
$miui=json_decode($miui,true);
if ($miui[$qhost]!="开机"){
$bots_msg_type="回复";
$send_msg="没有开机";
bot_api($host,$qun,$send_msg,$qq,$bots_msg_type,$msgid);
}else{
$video_url=file_get_contents("http://api-bumblebee.1sapp.com:80/bumblebee/ring/list");
$s = preg_match_all('/"ring_id":(.*?),"member_id":(.*?),"title":"(.*?)","content":"(.*?)","cover_pic":"(.*?)","origin_category":"(.*?)","pay_reward_num":(.*?),"pay_reward_coins":(.*?),"free_reward_num":(.*?),"free_reward_coins":(.*?),"view_cnt":(.*?),"like_cnt":(.*?),"favorite_cnt":(.*?),"origin_like_cnt":(.*?),"extra":(.*?),"status":(.*?),"video_url":"(.*?)","audio_url":"(.*?)","video_duration":(.*?),"video_size":(.*?),"category_id":(.*?),"gid":(.*?),"updated_at":"(.*?)","created_at":"(.*?)","avatar":"(.*?)","nickname":"(.*?)"/',$video_url,$v);
if($s== 0){
$send_msg="短视频刷新中！";
$bots_msg_type="回复";
bot_api($host,$qun,$send_msg,$qq,$bots_msg_type,$msgid);
}else{
$id=$v[2][0];//获取id
$bt=$v[3][0];//获取标题
$fm=$v[5][0];//获取封面
$sp=$v[17][0];//获取视频
$yy=$v[18][0];//获取语音
$sj=$v[23][0];//获取时间
$tx=$v[25][0];//获取头像
$yh=$v[26][0];//获取昵称
$send_msg="昵称：".$yh."\r\n标题：".$bt."[CQ:image,file=".$fm."]"."\r\n时长：".$sj;
$bots_msg_type="回复";
bot_api($host,$qun,$send_msg,$qq,$bots_msg_type,$msgid);
$url=$sp;
$bots_msg_type="群聊";
bot_send_video($host,$url,$qun,$bots_msg_type);
}
}
}



//歌曲目录，测试阶段
/*if (preg_match("/^点歌 ?(.*)\$/",$msg,$return)){
if($str== 0){
    $send_msg="网易云音乐"."\r\n"."━━━━━"."\r\n"."搜索不到与".$return[1]."的相关歌曲，请稍后重试或换个关键词试试。";
    $bots_msg_type="回复";
        bot_api($host,$qun,$send_msg,$qq,$bots_msg_type,$msgid);
}else{
        $str="http://music.163.com/api/search/pc?s=".$return[1]."&limit=5&type=1";
    $str=file_get_contents($str,'r');
    $str=json_decode($str,true);
   //echo "网易云音乐━━━━━搜索不到与的相关歌曲，请稍后重试或换个关键词试试。";
   //print_r($str);
   
       $str=$str['result'];
    $str=$str['songs'];//歌曲列表
    $ga1=$str[0];//选歌
    $str1=$str['artists'];//艺术家
    $str1=$str1['name'];//艺术家名字
    $ga1name1=$ga1['name'];//名字
    $gb1=$ga1['id'];//id
    
        $ga2=$str[1];//选歌
    $str2=$ga2['artists'];//艺术家
    $str2=$str2['name'];//艺术家名字
    $ga1name2=$ga2['name'];//名字
    $gb2=$ga2['id'];//id
    
    $ga3=$str[2];//选歌
    $str3=$ga3['artists'];//艺术家
    $str3=$str3['name'];//艺术家名字
    $ga1name3=$ga3['name'];//名字
    $gb3=$ga3['id'];//id
    
    $ga4=$str[3];//选歌
    $str4=$ga4['artists'];//艺术家
    $str4=$str4['name'];//艺术家名字
    $ga1name4=$ga4['name'];//名字
    $gb4=$ga4['id'];//id
    
    $ga5=$str[4];//选歌
    $str5=$ga5['artists'];//艺术家
    $str5=$str5['name'];//艺术家名字
    $ga1name5=$ga5['name'];//名字
    $gb5=$ga5['id'];//id
    $wym=$return[1];
    $Record=array(
$qq=>array(
"bilibilifq"=>$fq,
"qq"=>$qq,
$qq=>$qqnick,
"qun"=>$qun,
"性别"=>$get_qqsex,
"网易"=>$wym
),
$qun=>array(
"qun"=>$qun,
"qq"=>$qq,
"信息"=>$msg
)
);
    $dir="./".$qun;
    opendir($dir);
    fopen($qq.'.json',"w");
    chmod($qq.'.json',0777);
    $Record=json_encode($Record);
file_put_contents($dir_qq,$Record);
$send_msg=$ga1name1."---".$gb1."[换行]".$ga1name2."---".$gb2."[换行]".$ga1name3."---".$gb3."[换行]".$ga1name4."---".$gb4."[换行]".$ga1name5."---".$gb5;
send_img_api2($msg,$qun,$send_msg,$qqnick,$qq,$bots_msg_type);
}
*/


if (preg_match("/^点歌 ?(.*)\$/",$msg,$return)){
$miui=file_get_contents($dir_qun,"r");
$miui=json_decode($miui,true);
if ($miui[$qhost]!="开机"){
$bots_msg_type="回复";
$send_msg="没有开机";
bot_api($host,$qun,$send_msg,$qq,$bots_msg_type,$msgid);
}else if ($return[1]==""){
$send_msg="没有歌名你点nm！";
$bots_msg_type="回复";
bot_api($host,$qun,$send_msg,$qq,$bots_msg_type,$msgid);
}else{
$ge=urlencode($return[1]);
$str="https://autumnfish.cn/search?keywords=".$ge;
    $str=file_get_contents($str);
    $str=json_decode($str,true);
    $str=$str['result'];
    $str=$str['songs'];//歌曲列表
    $ga1=$str[0];//选歌
    $id=$ga1['id'];
    if ($id==""){
    $send_msg="获取失败";
    $bots_msg_type="回复";
    bot_api($host,$qun,$send_msg,$qq,$bots_msg_type,$msgid);
    }else{
        $url= "http://music.163.com/song/media/outer/url?id=".$id.".mp3";
        $bots_msg_type="群聊";
                $send_msg="[CQ:music,type=163,id=".$id."]";
        bot_api($host,$qun,$send_msg,$qq,$bots_msg_type,$msgid);
sleep(1);
$send_msg=wyy_hot($id);
$bots_msg_type="回复";
bot_api($host,$qun,$send_msg,$qq,$bots_msg_type,$msgid);
        }
        }

}

if (preg_match("/^语音点歌 ?(.*)\$/",$msg,$return)){
$miui=file_get_contents($dir_qun,"r");
$miui=json_decode($miui,true);
if ($miui[$qhost]!="开机"){
$bots_msg_type="回复";
$send_msg="没有开机";
bot_api($host,$qun,$send_msg,$qq,$bots_msg_type,$msgid);
}else if ($return[1]==""){
$send_msg="没有歌名你点nm！";
$bots_msg_type="回复";
bot_api($host,$qun,$send_msg,$qq,$bots_msg_type,$msgid);
}else{
$ge=urlencode($return[1]);
$str="https://autumnfish.cn/search?keywords=".$ge;
    $str=file_get_contents($str);
    $str=json_decode($str,true);
    $str=$str['result'];
    $str=$str['songs'];//歌曲列表
    $ga1=$str[0];//选歌
    $id=$ga1['id'];
    if ($id==""){
    $send_msg="获取失败";
    $bots_msg_type="回复";
    bot_api($host,$qun,$send_msg,$qq,$bots_msg_type,$msgid);
    }else{
        $url= "http://music.163.com/song/media/outer/url?id=".$id.".mp3";
        $bots_msg_type="群聊";
        bot_vio_api($host,$qun,$url,$qq,$bots_msg_type);
$i=file_get_contents("dei.txt");
$i++;
file_put_contents("dei.txt",$i);
        }
        }

}





if ($msg=="60s"){
$miui=file_get_contents($dir_qun,"r");
$miui=json_decode($miui,true);
if ($miui[$qhost]!="开机"){
$bots_msg_type="回复";
$send_msg="没有开机";
bot_api($host,$qun,$send_msg,$qq,$bots_msg_type,$msgid);
}else{
$img_60s=file_get_contents("http://api.03c3.cn/zb/api.php","r");
$img_60s=json_decode($img_60s,true);
$img_60s=$img_60s['imageUrl'];
$bots_msg_type="回复";
$send_msg="[CQ:image,file=".$img_60s."]";
bot_api($host,$qun,$send_msg,$qq,$bots_msg_type,$msgid);
}
}

if ($msg=="老婆"&&$qq==$qhost){
$send_msg="亲爱的，我在！";
$bots_msg_type="回复";
bot_api($host,$qun,$send_msg,$qq,$bots_msg_type,$msgid);
}

if (preg_match("/^岚嘉 ?(.*)\$/",$msg,$return)){
    $roboter="http://api.qingyunke.com/api.php?key=free&appid=0&msg=".$return[1];
$send_msg=file_get_contents($roboter,"r");
$send_msg=json_decode($send_msg,true);
$send_msg=$send_msg['content'];
$bots_msg_type="回复";
bot_api($host,$qun,$send_msg,$qq,$bots_msg_type,$msgid);
}

if ($msg=="官网"){
$send_msg="本程序官网：www.coldeggs.top";
$bots_msg_type="私聊";
bot_api($host,$qun,$send_msg,$qq,$bots_msg_type,$msgid);
}

if (preg_match("/^群管 ?(.*)\$/",$msg,$return)){
if ($return[1]!="开"&&$return[1]!="关"){
die;
}
if ($return[1]==""){
}else if ($qq==$qhost){
$bb_type="群管";
$msg=$return[1];
$send_msg=Switch_machine($msg,$qq,$qun,$qhost,$bb_type);
$bots_msg_type="回复";
bot_api($host,$qun,$send_msg,$qq,$bots_msg_type,$msgid);
}
}

if ($msg=="要饭"){
$send_msg="开发者饿饿，拜托🙏🏻了[CQ:image,file=https://www.coldeggs.top/pim/Alipay.jpg]";
$bots_msg_type="回复";
bot_api($host,$qun,$send_msg,$qq,$bots_msg_type,$msgid);
}

//测试循环输出
if (preg_match("/^翻 ?(.*)\$/",$msg,$return)){
for ($numeb=1;$numeb<5;$numeb++){
$send_msg=$return[1]*$numeb;
$bots_msg_type="回复";
bot_api($host,$qun,$send_msg,$qq,$bots_msg_type,$msgid);
}

}

if (preg_match("/^二维码 ?(.*)\$/",$msg,$return)){
$QR_content = $return[1];
$bots_msg_type = "群聊";
QR_code($QR_content,$bots_msg_type);
}

if (preg_match("/^伪音 ?(.*)\$/",$msg,$return)){
$mins=rand(0,18576);
$send_msg='▷︎|ııı|ıı|||ııı|ıı|||ı|ı|ıı|'.$mins."\"";
$bots_msg_type="回复";
bot_api($host,$qun,$send_msg,$qq,$bots_msg_type,$msgid);
}

if ($msg=="打卡"){
$send_msg="打卡成功啦";
$bots_msg_type="回复";
bot_api($host,$qun,$send_msg,$qq,$bots_msg_type,$msgid);

}

if (preg_match("/^笔记 ?(.*)\$/",$msg,$return)){
$notes_array=array(
$qq=>array(
"notes"=>$return[1]
)
);
file_put_contents("notes.json",ret_json($notes_array));
$send_msg="[CQ:at,qq=".$qq."]记录成功啦";
$bots_msg_type="回复";
bot_api($host,$qun,$send_msg,$qq,$bots_msg_type,$msgid);
}

if (preg_match("/^堆糖 ?(.*)\$/",$msg,$return)){
$miui=file_get_contents($dir_qun,"r");
$miui=json_decode($miui,true);
if ($miui[$qhost]!="开机"){
$bots_msg_type="回复";
$send_msg="没有开机";
bot_api($host,$qun,$send_msg,$qq,$bots_msg_type,$msgid);
}else if ($return[1]==""){
$send_msg="没有名字你搜nm！";
$bots_msg_type="回复";
bot_api($host,$qun,$send_msg,$qq,$bots_msg_type,$msgid);
}else{
if (json_decode(file_get_contents("./api_data/".$qq.".json","r"),true)['msg']==$return[1]){
$xu=json_decode(file_get_contents("./api_data/".$qq.".json","r"),true)['xu'];
$data_api=array(
"api"=>"堆糖",
"msg"=>$return[1],
"xu"=>$xu+1
);
$data_api=json_encode($data_api,JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
file_put_contents("./api_data/".$qq.".json",$data_api);
$xu=json_decode(file_get_contents("./api_data/".$qq.".json","r"),true)['xu'];
$data=file_get_contents("http://www.coldeggs.top/api/duitang.php?msg=".$return[1],"r");
$data=json_decode($data,true);
$url=$data['data'][$xu]['链接'];
$bots_msg_type="群聊";
$send_msg=$url;
bot_send_img($host,$qun,$send_msg,$qq,$bots_msg_type);
die;
}
$data_api=array(
"api"=>"堆糖",
"msg"=>$return[1],
"xu"=>"0"
);
$data_api=json_encode($data_api,JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
fopen("./api_data/".$qq.".json","w");
file_put_contents("./api_data/".$qq.".json",$data_api);
$data=file_get_contents("http://www.coldeggs.top/api/duitang.php?msg=".$return[1],"r");
$data=json_decode($data,true);
$url=$data['data'][0]['链接'];
if ($url==""||$url==null){
$bots_msg_type="回复";
$send_msg="获取失败，可能是没有哦";
bot_api($host,$qun,$send_msg,$qq,$bots_msg_type,$msgid);
}else{
$bots_msg_type="群聊";
$send_msg=$url;
bot_send_img($host,$qun,$send_msg,$qq,$bots_msg_type);
}

}
}

if ($msg == "检查"&& $qq == $qhost){
$bots_msg_type = "回复";
$send_msg = Auto_check($qun,$qhost);
bot_api($host,$qun,$send_msg,$qq,$bots_msg_type,$msgid);
}


//解析短视频
/*if(preg_match('/[\x{4e00}-\x{9fa5}]/u', $msg)>0){//是否包含中文
if (preg_match('/https:\/\/.*\/\w+/', $msg, $urll)) {//匹配网址
$urrl=$urll[0];//获取全部数组
//该api为coldeggs提供
$urrrl=file_get_contents("http://110.42.204.109/kuaishou.php?url=".$urrl,"r");//解析
$bots_msg_type="回复";
//$url=$urrrl;
$send_msg="快手视频已解析在辅助服务器：".$urrrl;//链接
bot_api($host,$qun,$send_msg,$qq,$bots_msg_type,$msgid);//发送
}
}
*/

/*爬网页
//匹配https协议网址
if (preg_match('/https:\/\/.*\/\w+/', $msg, $url)){
//如果为null(空)
if ($url[0]==null){
//匹配http协议网址
preg_match('/http:\/\/.*\/\w+/', $url[0], $url);
//如果为空
if ($url[0]==null){
//在此程序中，错误依然会执行完成，必须die
die;
}
$url_data=file_get_contents($url[0],"r");
file_put_contents("./rep/url_data.html",$url_data);
$send_msg="OK";
$bots_msg_type="回复";
bot_api($host,$qun,$send_msg,$qq,$bots_msg_type,$msgid);
}else{
$url_data=file_get_contents($url[0],"r");
file_put_contents("./rep/url_data.html",$url_data);
$send_msg="OK";
$bots_msg_type="回复";
bot_api($host,$qun,$send_msg,$qq,$bots_msg_type,$msgid);
}
}
*/


///避免错误的数据被记录
//数据记录
if ($get_qun_eve=="group_increase"&&$msg==null){
die;
}else{
if ($msg_type=="private"){
die;
}
@Record_information_qq($qq,$qun,$msg,$qqnick,$get_qqsex,$dir_qq,$fq,$wym,$qhost,$host);
}