<?php
/**
  *并发获取微信公众号摸鱼人日历
  *author coldeggs
  *QQ 1940826077
  *对图片变化做了优化
*/
use Swoole\Coroutine\Barrier;
use Swoole\Coroutine\System;
use function Swoole\Coroutine\run;
use Swoole\Coroutine;
use Swoole\Timer;
use Swoole\Coroutine\Channel;
use PHProbot\Api;


if ($msg=="摸鱼日历"){
//如果需要使用Timer 请注意run和Timer都属于协程
$rand=rand(1,10000);
run(function()use($rand){
$data=Barrier::make();
//创建协程通道
$channel = new Channel(1);
Coroutine::create(function()use($channel){
//摸鱼日历合集列表
$url = "https://mp.weixin.qq.com/mp/appmsgalbum?__biz=MzAxOTYyMzczNA==&action=getalbum&album_id=2190548434338807809&subscene=159&subscene=&scenenote=https%3A%2F%2Fmp.weixin.qq.com%2Fs%2FpeqArTr5iynB92hOiYXtiw&nolastread=1#wechat_redirect";
$time = file_get_contents($url);
$array=explode("data-link=",$time);
//第一个链接
$array=explode('"',$array[1]);
//向通道写入数据
$channel->push($array);
}
);


Coroutine::create(function()use($channel,$rand){
//读取数据
$array=$channel->pop();
$data=file_get_contents($array[1]);
$array = explode('data-src="',$data);
$array=explode('"',$array[2+(count($array)-5)]);
$data=file_get_contents($array[0]);
file_put_contents("./images/摸鱼.jpg",$data);
file_put_contents("../gocq/data/images/摸鱼.jpg",file_get_contents("./images/摸鱼.jpg"));
}


);
//挂起
Barrier::wait($data);
});

$Api_data = array(
"qun"=>$qun,
"qq"=>$qq,
"msg"=>"[CQ:image,file=摸鱼.jpg]",
"S_type"=>$msg_type,
"msg_id"=>$msg_id
);
$data=PHProbot\Api::send($Api_data);
$ws -> push($frame->fd, $data);
}
?>