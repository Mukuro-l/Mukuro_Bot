<?php

/* *name PHProbot_API
   *version v1.1.6 增加函数word_stock Auto_check 修改qun_host初始化函数
   *date 2021.12.30
   *nick coldeggs
   *explain PHProbot的api模块
   祝大家新年快乐！
*/



/*class fake_msg{
function out_qun($qq){
$msg = "【".."(".$qq.")】悄悄地离开了群聊";
}
}
*/

function ret_json($json) {
    return stripslashes(json_encode($json, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
}



class bilibili{
public $bili_id;
public $select;
public $bili_msg;
//bv转av号
function bili_details($bili_id){
$url="https://api.bilibili.com/x/web-interface/view?bvid=".$bili_id;
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
function bili_ranking_list($bili_msg){
$url = "";
}

}

//解析快手视频
function kuai_shou($kuai_url){
$data=curl($kuai_url,['loadurl'=>1]);
$data=curl($data,$paras=[
'ua'=>'Mozilla/5.0 (Linux; Android 10; NEO-AL00; HMSCore 5.1.1.300; GMSCore 20.15.16) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/83.0.4103.106 HuaweiBrowser/11.0.4.371 Mobile Safari/537.36'
]);
preg_match('/type="video\/mp4" src="(.*?)" alt/',$data,$html);
if ($html[1]==null){
return "获取失败";
}else{
return $html[1];
}
}

//群公告
function up_group_note($up_group_notes,$host,$qun,$send_msg){
$send_msg=urlencode($send_msg);
$url = $host.$up_group_notes."?group_id=".$qun."&content=".$send_msg;
curl($url);
}


//获取网易云热评
function wyy_hot($id){
$url="https://autumnfish.cn/comment/hot?type=0&id=".$id;
$data=curl($url);
$data=json_decode($data,true);
$uid=$data['hotComments'][0]['user']['userId'];//用户id
$name=$data['hotComments'][0]['user']['nickname'];//用户名
$av_img=$data['hotComments'][0]['user']['avatarUrl'];//头像url
$good=$data['hotComments'][0]['likedCount'];//点赞
$pl=$data['hotComments'][0]['content'];//评论
$send_msg="[CQ:image,file=".$av_img."]评论：".$pl."\r\n昵称：".$name."\r\n点赞：".$good;
if ($pl==null){
return "热评获取失败";
}else{
return $send_msg;
}
}

function baidu_tts($tts_msg,$directory){
$tts_msg = urlencode($tts_msg);
if (is_dir("mp3")==true){
$url="http://tts.baidu.com/text2audio?lan=zh&ie=UTF-8&spd=4&text=".$tts_msg;
$data=curl($url);
$rand=rand(486519,10000000);
fopen("./mp3/".$rand.".mp3","w");
file_put_contents("./mp3/".$rand.".mp3",$data);
$tts_data= "http://".$_SERVER['HTTP_HOST'].Secondary_directory($directory)."mp3/".$rand.".mp3";
}else{
mkdir("mp3");
$url="http://tts.baidu.com/text2audio?lan=zh&ie=UTF-8&spd=4&text=".$tts_msg;
$data=file_get_contents($url,"r");
$rand=rand(486519,10000000);
fopen("./mp3/".$rand.".mp3","w");
file_put_contents("./mp3/".$rand.".mp3",$data);
$tts_data= "http://".$_SERVER['HTTP_HOST'].Secondary_directory($directory)."mp3/".$rand.".mp3";
}
return $tts_data;
}

//记录词库函数
function word_stock($msg){
//判断词库是否存在
if (file_exists('./word_stock/main.json')!=true){
//创建文件夹
mkdir("word_stock");
//创建文件
fopen('./word_stock/main.json',"w");
//写入初始内容
$data_array = array("你好"=>"你好啊，我是小冰");
$data = ret_json($data_array);
file_put_contents('./word_stock/main.json',$data);
}

//分割成数组
$data_one = explode("=>",$msg);
$data1 = $data_one[0];
$data2 = $data_one[1];
//读取
$json = file_get_contents('./word_stock/main.json',"r");
$json = json_decode($json,true);
$a = array($json);
//判断是否存在这条数据
if ($a[0][$msg] != null){
//输出
    return $a[0][$msg];
    }
if ($data2 == null){
print("data empty");
}else{
//循环添加数组
foreach ($a as &$item) {
        $item[$data1] = $data2;
        $data_json = ret_json($item);
        file_put_contents('./word_stock/main.json',$data_json);
        return "true";
    }
    
    }
    
}

function Download_file($host,$qun,$send_msg,$qq,$bots_msg_type){

    if ($send_msg == null){
    die;
    }else{
    if (is_dir("bot_data") == true){
        $bots_msg_type = "群聊";
        bot_send_img($host,$qun,$send_msg,$qq,$bots_msg_type);
            
        }else{
        mkdir("bot_data");
        $num=rand(10489,88888888);
     
        $data = file_get_contents($data_url,"r");
        //fopen('./bot_data/'.$num.'.jpg',"w");
        file_put_content('./bot_data/'.$num.'.jpg',$data);
        $return_msg = "文件已下载至：https://wen.coldeggs.top/bot_data/".$num.".jpg";
        }
        }
        return $return_msg;
}
   
function Auto_check($qun,$qhost){
if (file_exists('./bottp/'.$qhost.'.json')!=true){
$return_information = "––––[CP·BOT环境检查]––––\r\n condition：个人配置文件未成功生成，请检查文件权限！";
}
if (file_exists('./group/'.$qun.'/'.$qhost.'.json')!=true){
$return_information = "––––[CP·BOT环境检查]––––\r\n condition：QQ群配置文件未成功生成，请检查文件权限！";
}
if (file_exists('./bottp/'.$qhost.'.json')!=true&&file_exists('./group/'.$qun.'/'.$qhost.'.json')!=true){
$return_information = "––––[CP·BOT环境检查]––––\r\n condition：配置文件未成功生成，请检查文件权限！";
}
if (file_exists('./bottp/'.$qhost.'.json')==true&&file_exists('./group/'.$qun.'/'.$qhost.'.json')==true){
$return_information = "––––[CP·BOT环境检查]––––\r\n condition：CP·BOT已准备就绪。\r\n document：./group/".$qun."/".$qhost.".json";
}
return $return_information;
}

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

/*
//初始化   维护
function qun_host($qhost,$qun){
if (file_exists('bottp')!=true){
  mkdir("bottp");
  if (file_exists('./bottp/'.$qhost.'.json')!=true){
fopen('./bottp/'.$qhost.'.json',"w");
  file_put_contents('./bottp/'.$qhost.'.json',"yes");
  }
  }
  if (file_exists('group')!=true){
  mkdir("group");
  if (file_exists('./group/'.$qun)!=true){
  opendir('group');
  mkdir($qun);
  }
  if (file_exists('./group/'.$qun.'/'.$qhost.'.json')!=true){
opendir('./group/'.$qun.'/');
fopen($qhost.'.json',"w");
fopen('/robot.json',"w");
fopen('/robotconf.json',"w");
}
}
}

*/
//获取艾特的qq

function bot_atqq($msg){

$atqq=str_replace('[CQ:at,qq=', '', $msg);

$atqq=str_replace(']', '', $atqq);

$atqq=str_replace(' ', '', $atqq);

if ($atqq!=null){

return $atqq;

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
function omelette($host,$qun){
$url = "http://i.jandan.net/top";
$data=curl($url);
preg_match_all('/img src="(.*?)"/',$data,$v);
//count($v[0])
for ($i=0;$i<3;$i++){
$md1=str_replace('//', '', $v[1][$i]);
$data_url="http://".$md1;
$msg=Download_file($data_url,$host);

}
return $msg;
}

//初始化
//qun_host($qhost,$qun);



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

//二级目录输出
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
    "信息"=>'[CQ:json,data={"app":"com.tencent.weather"&#44"desc":"天气"&#44"view":"RichInfoView"&#44"ver":"0.0.0.1"&#44"prompt":"[应用]天气"&#44"appID":""&#44"sourceName":""&#44"actionData":""&#44"actionData_A":""&#44"sourceUrl":""&#44"meta":{"richinfo":{"adcode":""&#44"air":""&#44"city":"渠县"&#44"date":"01月07日 周5"&#44"max":"9"&#44"min":"7"&#44"ts":"1641537219"&#44"type":"203"&#44"wind":"0"}}&#44"text":""&#44"sourceAd":""&#44"extra":""}]'
    );
        if ($bots_msg_type=="群聊"){
        $host_type_qun=$myqun_bot_api["域名"].$bot_msg_type["群聊"]."?";
        $qun_msg_sen="group_id=".$myqun_bot_api["群号"]."&message=".$myqun_bot_api["信息"]."&auto_escape=false";
        $url=$host_type_qun.$qun_msg_sen;
        curl($url);
        }
}



//发送消息
class bot_msg_api{
public $host;
public $qun;
public $send_msg;
public $qq;
public $bots_msg_type;
public $msgid;
//send($host,$qun,$send_msg,$qq,$bots_msg_type,$msgid)
function send(){
//$send_msg=urlencode($send_msg);
    $bot_msg_type=array(
        "群聊"=>"send_group_msg",
        "私聊"=>"send_private_msg",
        "踢人"=>"set_group_kick"
        );
    if ($bots_msg_type=="群聊"){
    $url = array(
    $bot_msg_type["群聊"],
    "group_id"=>$qun,
    "message"=>$send_msg,
    "auto_escape"=>false
    );
    $url = ret_json($url);
    $ws->push($frame->fd, $url);
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
if ($qq==$qhost){
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
function eve_qun_msg($host,$msgid){
    $url = $host."get_msg?message_id=".$msgid;
    $data = curl($url);
    $data = json_decode($data,true);
    $msg = $data["data"]["message"];
    return $msg;
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

//生成二维码，第二个参数为发送方式
function QR_code($QR_content,$bots_msg_type){
require_once './phpqrcode/phpqrcode.php';  //引入phpqrcode类文件
$value = $QR_content; //二维码内容
$errorCorrectionLevel = 'Q';//容错级别
$matrixPointSize = 30;//生成图片大小
//生成二维码图片
QRcode::png($value, 'qrcode.png', $errorCorrectionLevel, $matrixPointSize, 2);
$logo='logo.png';//准备好的logo图片  需要加入到二维码中的logo
$QR='qrcode.png';//已经生成的原始二维码图
if ($logo!==FALSE){
$QR = imagecreatefromstring(file_get_contents($QR));
$logo = imagecreatefromstring(file_get_contents($logo));
$QR_width=imagesx($QR);//二维码图片宽度
$QR_height=imagesy($QR);//二维码图片高度
$logo_width=imagesx($logo);//logo图片宽度
$logo_height=imagesy($logo);//logo图片高度
$logo_qr_width=$QR_width / 5;
$scale=$logo_width/$logo_qr_width;
$logo_qr_height=$logo_height/$scale;
$from_width=($QR_width -$logo_qr_width) / 2;
//重新组合图片并调整大小

imagecopyresampled($QR, $logo, $from_width, $from_width, 0, 0, $logo_qr_width,$logo_qr_height, $logo_width, $logo_height);
}

//输出图片
$file_name=rand(1567616,437661646);
imagepng($QR, $file_name.'.png');
$send_msg="http://".$_SERVER['HTTP_HOST']."/".$file_name.".png";
return $send_msg;
}
