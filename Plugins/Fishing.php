<?php
use Mukuro\Module\Api;

/**
*@name 摸鱼日历
*@doc 获取微信公众号摸鱼日历
*@comment 摸鱼日历
*@return image
*/
class Fishing{
use Api;
function plugins_Fishing(){
if ($this->msg == "摸鱼日历"){
$url = "https://mp.weixin.qq.com/mp/appmsgalbum?__biz=MzAxOTYyMzczNA==&action=getalbum&album_id=2190548434338807809&subscene=159&subscene=&scenenote=https%3A%2F%2Fmp.weixin.qq.com%2Fs%2FpeqArTr5iynB92hOiYXtiw&nolastread=1#wechat_redirect";
$time = file_get_contents($url);
$array=explode("data-link=",$time);
//第一个链接
$array=explode('"',$array[1]);
$data=file_get_contents($array[1]);
$array = explode('data-src="',$data);
$array=explode('"',$array[2+(count($array)-5)]);
$data=file_get_contents($array[0]);
file_put_contents("./images/".date("Y-m-d").".jpg",$data);
copy("./images/".date("Y-m-d").".jpg","../gocq/data/images/".date("Y-m-d").".jpg");
return $this->send("[CQ:image,file=".date("Y-m-d").".jpg]");
}
}
}