<?php

/* *name PHProbot_API
   *version v1.1.5 增加函数qun_host，Face_generation，omelette，express
   *date 2021.11.29
   *nick coldeggs
   *explain PHProbot的api模块
*/
   
//sha1()函数， "安全散列算法（SHA1）"
//算法加密
function create_unique() {
    //客户端+IP+时间戳+随机数组成的字符串
    $data = $_SERVER['HTTP_USER_AGENT'] . $_SERVER['REMOTE_ADDR'] .time() . rand();
    //使用sha1加密
    return sha1($data);
}

//token
function Tencent_json_token(){
$time = time();
$data = md5($time);
return $data;
}

//初始化
function qun_host($qhost){
if (file_exists('./bottp/'.$qhost.'.json')!=true){
  mkdir("bottp");
fopen('./bottp/'.$qhost.'.json',"w");
  file_put_contents('./bottp/'.$qhost.'.json',"yes");
}
}

function Face_generation($host,$qun,$send_msg,$qq,$bots_msg_type){
//随机生成一张头像
$url = "https://thispersondoesnotexist.com/";
$data = curl($url);
$data_img = file_get_contents($data,"r");
$rand = rand(4566799,8888888);
file_put_contents($rand.".jpg",$data_img);
$send_msg = "https://robot.coldeggs.top/bot/".$rand.".jpg";
$bots_msg_type = "群聊";
bot_send_img($host,$qun,$send_msg,$qq,$bots_msg_type);
}


//煎蛋爬虫
function omelette($host,$qun,$send_msg,$qq,$bots_msg_type){
$url = "http://i.jandan.net/pic";
$data=curl($url);
preg_match_all('/img src="(.*?)"/',$data,$v);
for ($i=0;$i<count($v[0]);$i++){
sleep(1);
$md1=str_replace('//', '', $v[1][$i]);
$send_msg="http://".$md1;
$bots_msg_type="群聊";
bot_send_img($host,$qun,$send_msg,$qq,$bots_msg_type);
}
}

//初始化
qun_host($qhost);

//bv转av号
function bv_toav($bv_id){
$url="https://api.bilibili.com/x/web-interface/view?bvid=".$bv_id;
$data=file_get_contents($url,"r");
$data=json_decode($data,true);
//bv号
$data["data"]["bvid"];
//av号
$data["data"]["aid"];
//tname主题
$data["data"]["tname"];
//封面
$data["data"]["pic"];
//标题
$data["data"]["title"];
//简介
$data["data"]["desc"];
//弹幕
$data["data"]["duration"];
//up主
//print_r($data["data"]["owner"]);
return "[CQ:image,file=".$data["data"]["pic"]."]\r\n标题：👉".$data["data"]["title"]."👈\r\n bv号：👉".$data["data"]["bvid"]."👈\r\n av号：👉".$data["data"]["aid"]."👈\r\n主题：👉".$data["data"]["tname"]."👈\r\n简介：👉".$data["data"]["desc"]."👈\r\n弹幕：👉".$data["data"]["duration"]."👈\r\n up主：👉".$data["data"]["owner"]["name"]."👈\r\n up主uid：👉".$data["data"]["owner"]["mid"]."👈\r\n up主头像：👉[CQ:image,file=".$data["data"]["owner"]["face"]."]👈";

}

//获取快递信息
function express($express_id,$express_postid){
$ex_id = array(
         "申通"=>"shentong",
         "EMS"=>"ems",
         "顺丰"=>"shunfeng",
         "圆通"=>"yuantong",
         "中通"=>"zhongtong",
         "韵达"=>"yunda",
         "天天"=>"tiantian",
         "汇通"=>"huitongkuaidi",
         "全峰"=>"quanfengkuaidi",
         "德邦"=>"debangwuliu",
         "宅急送"=>"zhaijisong"
);
$url = "http://www.kuaidi100.com/query?type=".$ex_id[$express_id]."&postid=".$express_postid;
$data = curl($url);
$data = json_decode($data,true);

}

//ocr图片识别，封装
function bot_ocr($img_id,$get_imgocr_api,$host){
$myqun_bot_api=array(
    "域名"=>$host,
    "群号"=>$qun,
    "信息"=>$img_id
    );
        $qun_msg_sen=$myqun_bot_api["域名"].$get_imgocr_api."?image=".$myqun_bot_api["信息"];
        $url=$qun_msg_sen;
        $data=curl($url);
        $data=json_decode($data,true);
        $img_texts=$data["data"]["texts"];//返回结果字段
        $img_text=$img_texts["text"];
        return $img_text;
}

function Secondary_directory($directory){
if ($directory == ""){
$directory = '/';
}else{
$directory = '/'.$directory.'/';
}

return $directory;

}


//QQ头像
function send_qqimg_api($qq){
$url="http://q.qlogo.cn/headimg_dl?dst_uin=".$qq."&spec=640&img_type=jpg";
return "[CQ:image,file=".$url."]";
}

//二次元图文
function send_img_api2($msg,$qun,$send_msg,$qq,$bots_msg_type){
$send_msg=urlencode($send_msg);
$src = "http://robot.coldeggs.top/bot/acg.php";  
//2.获取图片信息  
$info = getimagesize($src);  
//3.通过编号获取图像类型  
$type = image_type_to_extension($info[2],false);  
//4.在内存中创建和图像类型一样的图像  
$fun = "imagecreatefrom".$type;  
//5.图片复制到内存  
$image = $fun($src);  
/*操作图片*/  
//1.设置字体的路径  
$font = "1.ttf";
//2.填写水印内容  
$txt=str_replace("[换行]", "\n", $send_msg);
$txt1 = str_replace('%', '％', $txt);
$Copyright = "\n『".$_SERVER['HTTP_HOST']."』提供技术支持";
//3.设置字体颜色和透明度  
$color = imagecolorallocatealpha($image, rand(0,255), rand(0,255), rand(0,255), 0);  
//4.写入文字 (图片资源，字体大小，旋转角度，坐标x，坐标y，颜色，字体文件，内容) 
imagettftext($image, 27, 0, 40, 40, $color, $font, $txt1.$Copyright);  
/*输出图片*/  
//浏览器输出  
header("Content-type:".$info['mime']);  
$fun = "image".$type;  
$fun($image); 
//保存图片 
$cod=rand(100000,48976948);
$fun($image,$cod.'.'.$type);
$dir=Secondary_directory($directory);
$data='http://'.$_SERVER['HTTP_HOST'].$dir.$cod.'.'.$type;
$send_msg='[CQ:image,file='.$data.']';
$bots_msg_type='群聊';
bot_api($host,$qun,$send_msg,$qq,$bots_msg_type,$msgid);
$folderpath = $_SERVER["DOCUMENT_ROOT"] . $dir;//要操作的目录
$deltype = array($type);
foreach ($deltype as $file_type) {
    clearn_file($folderpath, $file_type);
    }
}

//发送视频
function bot_send_video($host,$url,$qun,$bots_msg_type){
    $bot_msg_type=array(
        "群聊"=>"send_group_msg",
        "私聊"=>"send_private_msg",
        );
$myqun_bot_api=array(
    "域名"=>$host,
    "群号"=>$qun,
    "信息"=>"[CQ:video,file=".$url."]"
    );
    if ($bots_msg_type=="群聊"){
        $host_type_qun=$myqun_bot_api["域名"].$bot_msg_type["群聊"]."?";
        $qun_msg_sen="group_id=".$myqun_bot_api["群号"]."&message=".$myqun_bot_api["信息"]."&auto_escape=false";
        $url=$host_type_qun.$qun_msg_sen;
        curl($url);

    }
    if ($bots_msg_type=="私聊"){
        $host_type_qun=$myqun_bot_api["域名"].$bot_msg_type["私聊"]."?";
        $qun_msg_sen="group_id=".$myqun_bot_api["群号"]."&user_id=".$qq."&message=".$myqun_bot_api["信息"]."&auto_escape=false";
        $url=$host_type_qun.$qun_msg_sen;
        curl($url);
        
    }

    if ($bots_msg_type=="主聊"){
        $host_type_qun=$myqun_bot_api["域名"].$bot_msg_type["私聊"]."?";
        $qun_msg_sen="group_id=".$myqun_bot_api["群号"]."&user_id=1940826077&message=".$myqun_bot_api["信息"]."&auto_escape=false";
        $url=$host_type_qun.$qun_msg_sen;
        curl($url);
        
    }
    }
    
//群禁言
function qun_jinyan($host,$qun,$qqjin,$time){

$bot_msg_type=array(
        "群聊"=>"send_group_msg",
        "私聊"=>"send_private_msg",
        "禁言"=>"set_group_ban"
        );
        $myqun_bot_api=array(
            "域名"=>$host,
            "群号"=>$qun,
            "信息"=>'[CQ:image,file='.$send_img.']'
            );
$host_type_qun=$myqun_bot_api["域名"].$bot_msg_type["禁言"]."?";
                $qun_msg_sen="group_id=".$myqun_bot_api["群号"]."&user_id=".$qqjin."&duration=".$time."&auto_escape=false";
                $url=$host_type_qun.$qun_msg_sen;
                curl($url);
}

//删除临时文件函数
function clearn_file($path, $file_type = 'bak')
{
    //判断要清除的文件类型是否合格
    if (!preg_match('/^[a-zA-Z]{2,}$/', $file_type)) {
        return false;
    }
    //当前路径是否为文件夹或可读的文件
    if (!is_dir($path) || !is_readable($path)) {
        return false;
    }
    //遍历当前目录下所有文件
    $all_files = scandir($path);
    foreach ($all_files as $filename) {
        //跳过当前目录和上一级目录
        if (in_array($filename, array(".", ".."))) {
            continue;
        }
        //进入到$filename文件夹下
        $full_name = $path . '/' . $filename;
        //判断当前路径是否是一个文件夹，是则递归调用函数
        //否则判断文件类型，匹配则删除
        if (is_dir($full_name)) {
            clearn_file($full_name, $file_type);
        } else {
            preg_match("/(.*)\.$file_type/", $filename, $match);
            if (!empty($match[0][0])) {
                echo $full_name;
                echo '<br>';
                unlink($full_name);
            }
        }
    }
}

//文字转图片并发送
function bot_msg_img($host,$send_msg,$qun,$qq,$bots_msg_type,$directory){
$rand=rand(100000,99999999);
//字体大小
$size = 50;
//字体类型，本例为宋体
$font = "./4.ttf";
//显示的文字
$text = $send_msg;
$text = break_string($text, 25);
$width = 1920;
$height = 1080;
$img = imagecreate($width, $height);
//给图片分配颜色
imagecolorallocate($img, 0xff, 0xff, 0xff);
 
$a = imagettfbbox($size, 0, $font, $text);   //得到字符串虚拟方框四个点的坐标
$len = $a[2] - $a[0];
$x = ($width - $len) / 2;
$y = $height /12+ ($a[3] - $a[5]) /2;
 
//设置字体颜色
$black = imagecolorallocate($img, 255, 0, 0);
//将ttf文字写到图片中
imagettftext($img, $size, 0, $x, $y, $black, $font, $text);
//发送头信息
header('Content-Type: image/png');
//输出图片
$tu=$rand.".png";
imagepng($img, $tu);
$dir=Secondary_directory($directory);
$send_img='http://'.$_SERVER['HTTP_HOST'].$dir.$tu;
//basename(dirname(__FILE__))
$folderpath = $_SERVER["DOCUMENT_ROOT"] . $dir;//要操作的目录
$deltype = array('png');
$bot_msg_type=array(
        "群聊"=>"send_group_msg",
        "私聊"=>"send_private_msg"
        );
        $myqun_bot_api=array(
            "域名"=>$host,
            "群号"=>$qun,
            "信息"=>'[CQ:image,file='.$send_img.']'
            );
            if ($bots_msg_type=="群聊"){
                $host_type_qun=$myqun_bot_api["域名"].$bot_msg_type["群聊"]."?";
                $qun_msg_sen="group_id=".$myqun_bot_api["群号"]."&message=".$myqun_bot_api["信息"]."&auto_escape=false";
                $url=$host_type_qun.$qun_msg_sen;
                curl($url);
                //延时1秒执行
                sleep(1);
       //循环删除
                foreach ($deltype as $file_type) {
    clearn_file($folderpath, $file_type);
}
                
            }
            
            if ($bots_msg_type=="私聊"){
            $host_type_qun=$myqun_bot_api["域名"].$bot_msg_type["私聊"]."?";
                $qun_msg_sen="group_id=".$myqun_bot_api["群号"]."&message=".$myqun_bot_api["信息"]."&user_id=".$qq."&auto_escape=false";
                $url=$host_type_qun.$qun_msg_sen;
                curl($url);
                //延时1秒执行
              sleep(1);
              //循环删除
                foreach ($deltype as $file_type) {
    clearn_file($folderpath, $file_type);
}
                }
}

/**
 * 自动给文字增加换行
 * @param int $str 字符串
 * @param int $num 字数 一个汉字算1位，2个字母或者数字为1位
 * @param string $line_break 换行符号 \n
 * @return string 返回字符串
 */
function break_string($str, $num)
{
    preg_match_all("/./u", $str, $arr);//将所有字符转成单个数组
    print_r($arr);
    $strstr = '';
    $width = 0;
    $arr = $arr[0];
    foreach ($arr as $key => $string) {
        $strlen = strlen($string);//计算当前字符的长度，一个字母的长度为1，一个汉字的长度为3
        //echo $strlen;
        if ($strlen == 3) {
            $width += 1;
        } else {
            $width += 0.5;
        }
        $strstr .= $string;
        //计算当前字符的下一个
        if (array_key_exists($key + 1, $arr)) {
            $_strlen = strlen($arr[$key + 1]);
            if ($_strlen == 3) {
                $_width = 1;
            } else {
                $_width = 0.5;
            }
            if ($width + $_width > $num) {
                $width = 0;
                $strstr .= "\n";
            }
        }
    }
    return $strstr;
}

function autowrap($fontsize, $angle, $fontface, $string, $width) {
    // 参数分别是 字体大小, 角度, 字体名称, 字符串, 预设宽度
    $content = "";
    // 将字符串拆分成一个个单字 保存到数组 letter 中
    preg_match_all("/./u", $string, $arr);
    $letter = $arr[0];
    foreach($letter as $l) {
        $teststr = $content.$l;
        $testbox = imagettfbbox($fontsize, $angle, $fontface, $teststr);
        if (($testbox[2] > $width) && ($content !== "")) {
            $content .= PHP_EOL;
        }
        $content .= $l;
    }
    return $content;
}

//发送语音函数
function bot_vio_api($host,$qun,$url,$qq,$bots_msg_type){
    $bot_msg_type=array(
        "群聊"=>"send_group_msg",
        "私聊"=>"send_private_msg"
        );
$myqun_bot_api=array(
    "域名"=>$host,
    "群号"=>$qun,
    "信息"=>"[CQ:record,file=".$url."]"
    );
    if ($bots_msg_type=="群聊"){
        $host_type_qun=$myqun_bot_api["域名"].$bot_msg_type["群聊"]."?";
        $qun_msg_sen="group_id=".$myqun_bot_api["群号"]."&message=".$myqun_bot_api["信息"]."&auto_escape=false";
        $url=$host_type_qun.$qun_msg_sen;
        curl($url);
        
    }
    if ($bots_msg_type=="私聊"){
        $host_type_qun=$myqun_bot_api["域名"].$bot_msg_type["私聊"]."?";
        $qun_msg_sen="group_id=".$myqun_bot_api["群号"]."&user_id=".$qq."&message=".$myqun_bot_api["信息"]."&auto_escape=false";
        $url=$host_type_qun.$qun_msg_sen;
        curl($url);
        
    }
    }

//发送JSON
function bot_msg_json($send_json,$json_type,$host,$bots_msg_type,$qq,$qun){
$bot_msg_type=array(
        "群聊"=>"send_group_msg",
        "私聊"=>"send_private_msg",
        );
        $myqun_bot_api=array(
    "域名"=>$host,
    "群号"=>$qun,
    "信息"=>'[CQ:json,data='.$send_json.']'
    );
        if ($bots_msg_type=="群聊"){
        $host_type_qun=$myqun_bot_api["域名"].$bot_msg_type["群聊"]."?";
        $qun_msg_sen="group_id=".$myqun_bot_api["群号"]."&message=".$myqun_bot_api["信息"]."&auto_escape=false";
        $url=$host_type_qun.$qun_msg_sen;
        curl($url);
        }
}



//发送消息函数
function bot_api($host,$qun,$send_msg,$qq,$bots_msg_type,$msgid){
$send_msg=urlencode($send_msg);
    $bot_msg_type=array(
        "群聊"=>"send_group_msg",
        "私聊"=>"send_private_msg",
        "踢人"=>"set_group_kick"
        );
$myqun_bot_api=array(
    "域名"=>$host,
    "群号"=>$qun,
    "信息"=>$send_msg,
    "回复"=>"[CQ:reply,id=".$msgid."]".$send_msg
    );
    if ($bots_msg_type=="群聊"){
        $host_type_qun=$myqun_bot_api["域名"].$bot_msg_type["群聊"]."?";
        $qun_msg_sen="group_id=".$myqun_bot_api["群号"]."&message=".$myqun_bot_api["信息"]."&auto_escape=false";
        $url=$host_type_qun.$qun_msg_sen;
        curl($url);
        
    }
    if ($bots_msg_type=="私聊"){
        $host_type_qun=$myqun_bot_api["域名"].$bot_msg_type["私聊"]."?";
        $qun_msg_sen="group_id=".$myqun_bot_api["群号"]."&user_id=".$qq."&message=".$myqun_bot_api["信息"]."&auto_escape=false";
        $url=$host_type_qun.$qun_msg_sen;
        curl($url);
        
    }

    if ($bots_msg_type=="主聊"){
        $host_type_qun=$myqun_bot_api["域名"].$bot_msg_type["私聊"]."?";
        $qun_msg_sen="group_id=".$myqun_bot_api["群号"]."&user_id=1940826077&message=".$myqun_bot_api["信息"]."&auto_escape=false";
        $url=$host_type_qun.$qun_msg_sen;
        curl($url);
        
    }
    if ($bots_msg_type=="回复私聊"){
        $host_type_qun=$myqun_bot_api["域名"].$bot_msg_type["私聊"]."?";
        $qun_msg_sen="group_id=".$myqun_bot_api["群号"]."&user_id=".$qq."&message=".$myqun_bot_api["信息"]."&auto_escape=false";
        $url=$host_type_qun.$qun_msg_sen;
        curl($url);
        
    }
    if ($bots_msg_type=="踢人"){
        $host_type_qun=$myqun_bot_api["域名"].$bot_msg_type["踢人"]."?";
        $qun_msg_sen="group_id=".$myqun_bot_api["群号"]."&user_id=".$qq."&reject_add_request=false";
        $url=$host_type_qun.$qun_msg_sen;
        curl($url);
    }
    if ($bots_msg_type=="回复"){
        $host_type_qun=$myqun_bot_api["域名"].$bot_msg_type["群聊"]."?";
        $qun_msg_sen="group_id=".$myqun_bot_api["群号"]."&message=".$myqun_bot_api["回复"]."&auto_escape=false";
        $url=$host_type_qun.$qun_msg_sen;
        curl($url);
        
    }
    
}

//非常重要的函数，用来获取信息(不是服务器上报的信息)
function bot_get_more_ion($host,$msg,$qun,$send_msg,$qqnick,$qq,$bots_msg_type,$bots_getmsg_type){
$send_msg=urlencode($send_msg);
$dir_qqun="./group/".$qun."/robotconf.json";
if (file_exists($dir_qqun)!=true){
fopen($dir_qqun,"w");
}
    $bot_msg_type=array(
        "群聊"=>"send_group_msg",
        "私聊"=>"send_private_msg",
        "获取账号信息"=>"get_login_info",
        "获取状态"=>"get_status"
        );
$myqun_bot_api=array(
    "域名"=>$host,
    "群号"=>$qun
    );
if ($bots_getmsg_type=="状态"){
        $host_type_qun=$myqun_bot_api["域名"].$bot_msg_type["获取状态"];
        $url=$host_type_qun;
        $data=curl($url);
        $data=json_decode($data,true);
        $data=$data['data'];
        $data=$data['stat'];
        $Received_data=$data['packet_received'];//收到的数据
        $send_data=$data['packet_sent'];//发送的数据
        $lost_data=$data['packet_lost'];//丢失的数据
        $accept_msg=$data['message_received'];//接受的消息数
        $sent_msg=$data['message_sent'];//发送消息数
        $losts_times=$data['lost_times'];//掉线次数
        $dis_tcp=$data['disconnect_times'];//tcp断开次数
        $ion=array(
        "收到的数据"=>$Received_data,
        "发送的数据"=>$send_data,
        "丢失的数据"=>$lost_data,
        "接受的消息"=>$accept_msg,
        "发送的消息"=>$sent_msg,
        "断连次数"=>$dis_tcp,
        "掉线次数"=>$losts_times
        );
        $ion=json_encode($ion,JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
        file_put_contents($dir_qqun,$ion);
        }
}

//开关机函数
function Switch_machine($msg,$qq,$qun,$qhost,$bb_type){
$dir_qun="./group/".$qun."/robot.json";
//配置文件
//判断类型
if ($bb_type=="开关机"){
//判断是否存在
if (file_exists($dir_qun)!=true&&$qq==$qhost){
//读取
$df=file_get_contents($dir_qun,"r");
//转为数组
$df=json_decode($df,true);
//创建配置文件,w为只写
    fopen($dir_qun,"w");
    //设置权限0777
    chmod($dir_qun,0777);
    //数组
    $put=array(
    $qq=>$msg,
    "群管"=>$df["群管"],
    "识图"=>$df["识图"],
    "解析"=>$df["解析"]
    );
    //数组转为JSON
    $put=json_encode($put,JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
    //写入
    file_put_contents($dir_qun,$put);
    $send_msg=$msg."成功";
    //如果存在且QQ等于机器人主人
    }else if ($qq==$qhost){
    $df=file_get_contents($dir_qun,"r");
    $df=json_decode($df,true);
    $put=array(
    $qq=>$msg,
    "群管"=>$df["群管"],
    "识图"=>$df["识图"],
    "解析"=>$df["解析"]
    );
    $put=json_encode($put,JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
    file_put_contents($dir_qun,$put);
    $send_msg=$msg."成功";
    //如果不是主人
    }else{
    $send_msg="你不是主人。";
    }
    }
    if ($bb_type=="群管"){
    if (file_exists($dir_qun)!=true&&$qq==$qhost){
    fopen($dir_qun,"w");
    chmod($dir_qun,0777);
    $miui=file_get_contents($dir_qun,"r");
    $miui=json_decode($miui,true);
    $put=array(
    $qq=>$miui[$qhost],
    "群管"=>$msg,
    "识图"=>$miui["识图"],
    "解析"=>$miui["解析"]
    );
    $put=json_encode($put,JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
    file_put_contents($dir_qun,$put);
    $send_msg=$msg."成功";
    }else if ($qq==$qhost){
    $miui=file_get_contents($dir_qun,"r");
    $miui=json_decode($miui,true);
    $put=array(
    $qq=>$miui[$qhost],
    "群管"=>$msg,
    "识图"=>$miui["识图"],
    "解析"=>$miui["解析"]
    );
    $put=json_encode($put,JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
    file_put_contents($dir_qun,$put);
    $send_msg=$msg."成功";
    }
    }
    if ($bb_type=="识图"){
    if ($qq==$qhost){
    $miui=file_get_contents($dir_qun,"r");
    $miui=json_decode($miui,true);
    $put=array(
    $qq=>$miui[$qhost],
    "群管"=>$miui["群管"],
    "识图"=>$msg,
    "解析"=>$miui["解析"]
    );
    $put=json_encode($put,JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
    file_put_contents($dir_qun,$put);
    $send_msg=$msg."成功";
    }
    }
    return $send_msg;
    }

//获取撤回消息
function eve_qun_msg($qun,$send_msg,$host,$qun_msg_api,$chehuimsg){
    $send_msg=$chehuimsg;
    $bots_msg_type="群聊";
    bot_api($host,$qun,$send_msg,$qq,$bots_msg_type,$msgid);
}

//机器人发送图片函数
function bot_send_img($host,$qun,$send_msg,$qq,$bots_msg_type){
$send_msg=urlencode($send_msg);
    $bot_msg_type=array(
        "群聊"=>"send_group_msg",
        "私聊"=>"send_private_msg"
        );
        $myqun_bot_api=array(
            "域名"=>$host,
            "群号"=>$qun,
            "信息"=>'[CQ:image,file='.$send_msg.']'
            );
            if ($bots_msg_type=="群聊"){
                $host_type_qun=$myqun_bot_api["域名"].$bot_msg_type["群聊"]."?";
                $qun_msg_sen="group_id=".$myqun_bot_api["群号"]."&message=".$myqun_bot_api["信息"]."&auto_escape=false";
                $url1=$host_type_qun.$qun_msg_sen;
                curl($url1);
            }
            
            if ($bots_msg_type=="私聊"){
            $host_type_qun=$myqun_bot_api["域名"].$bot_msg_type["私聊"]."?";
                $qun_msg_sen="group_id=".$myqun_bot_api["群号"]."&message=".$myqun_bot_api["信息"]."&user_id=".$qq."&auto_escape=false";
                $url1=$host_type_qun.$qun_msg_sen;
                curl($url1);
                }
                
}


/*这个函数请不要动他！
*我也不知道咋回事，反正没bug了，不要动！
*不要动！不要动！
*动了死妈
*/

//数据记录
function Record_information_qq($qq,$qun,$msg,$qqnick,$get_qqsex,$dir_qq,$fq,$wym,$qhost,$host){
$time=60*10;
    $qqjin=$qq;
    
$dir_qun="./group/".$qun."/robot.json";
    
@$miui=file_get_contents($dir_qun,"r");

$miui=json_decode($miui,true);
if (@$miui["群管"]=="开"){
    if (file_exists('./bottp/'.$qq.'.json')){
    if (file_get_contents('./bottp/'.$qq.'.json',"r")!="yes"&&file_exists("./group/".$qun."/".$qq.'.json')!=true){
    $qqjin=$qq;
    $time=60*100;
    qun_jinyan($host,$qun,$qqjin,$time);
    $send_msg="未完成验证！";
    $bots_msg_type="群聊";
    bot_api($host,$qun,$send_msg,$qq,$bots_msg_type,$msgid);
    $Verification_Code=rand(1888,4589);
$Verification_Codeary=array(
"qun"=>$qun,
"code"=>$Verification_Code,
"ci"=>0
);
fopen('./bottp/'.$qq.'.json',"w");
$Verification_Codeary=json_encode($Verification_Codeary,JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
file_put_contents('./bottp/'.$qq.'.json',$Verification_Codeary);
$send_msg="请输入验证码：".$Verification_Code;
    sleep(2);
    $bots_msg_type="私聊";
    bot_api($host,$qun,$send_msg,$qq,$bots_msg_type,$msgid);
    }else{
    fopen("./group/".$qun."/".$qq.".json");
$ssdir=Secondary_directory();
$folderpath = $_SERVER["DOCUMENT_ROOT"] . $ssdir;//要操作的目录
$file_type ='json';
    clearn_file($folderpath, $file_type);
    }
    
    }
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
$qun_conf=array(
        $qhost=>"关机"
        );
$dir="./group/".$qun;
if (file_get_contents('./bottp/'.$qq.'.json',"r")!="yes"&&!file_exists("./group/".$qun."/".$qq.'.json')){
die;
}
if (is_dir($dir)==true){
    if (file_exists($dir_qq)==true){
$Record=json_encode($Record,JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
file_put_contents($dir_qq,$Record);
}else{
fopen($dir_qq,"w");
$Record=json_encode($Record,JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
file_put_contents($dir_qq,$Record);
}
}else {
if (file_get_contents('./bottp/'.$qq.'.json',"r")!="yes"&&file_exists("./group/".$qun."/".$qq.'.json')!=true){
die;
}
    $qun_conf=array(
        $qhost=>"关机"
        );
    mkdir($dir,0777);
    fopen($dir_qq,"w");
    fopen($dir_qun,"w");
    $qun_confing=json_encode($qun_conf,JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
    file_put_contents($dir_qun,$qun_confing);
    chmod($dir_qq,0777);
    $Record=json_encode($Record,JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
    file_put_contents($dir_qq,$Record);
}
    }else{
    
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
$qun_conf=array(
        $qhost=>"关机"
        );
$dir="./group/".$qun;
if (file_get_contents('./bottp/'.$qq.'.json',"r")!="yes"&&file_exists("./group/".$qun."/".$qq.'.json')!=true){
die;
}
if (is_dir($dir)==true){
    if (file_exists($dir_qq)==true){
$Record=json_encode($Record,JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
file_put_contents($dir_qq,$Record);
}else{
fopen($dir_qq,"w");
$Record=json_encode($Record,JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
file_put_contents($dir_qq,$Record);
}
}else {
if (file_get_contents('./bottp/'.$qq.'.json',"r")!="yes"&&file_exists("./group/".$qun."/".$qq.'.json')!=true){
die;
}
    $qun_conf=array(
        $qhost=>"关机"
        );
    mkdir($dir,0777);
    fopen($dir_qq,"w");
    fopen($dir_qun,"w");
    $qun_confing=json_encode($qun_conf,JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
    file_put_contents($dir_qun,$qun_confing);
    chmod($dir_qq,0777);
    $Record=json_encode($Record,JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
    file_put_contents($dir_qq,$Record);
}
}
}

//发送邮件
function bot_mail($qq,$send_mail,$mail_bt){
require_once("./functions.php");
$userName="CP·Bot";
$address=$qq."@qq.com";
$certno=$send_mail;
$datetime = date("Y-m-d h:i:s", time()); //时间
//接受邮件的邮箱地址
//$email='x001@qq.com';
//多邮件示例
$email=array($address);
//$subject为邮件标题
$subject = $mail_bt;
//$content为邮件内容
$content=$certno;
//执行发信
$flag = sendMail($email,$subject,$content);
}
