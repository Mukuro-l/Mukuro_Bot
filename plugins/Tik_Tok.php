<?php

$server_msg = new bot_msg_api();

if ($msg=="抖音"){

$video_url=file_get_contents("http://api-bumblebee.1sapp.com:80/bumblebee/ring/list");

$s = preg_match_all('/"ring_id":(.*?),"member_id":(.*?),"title":"(.*?)","content":"(.*?)","cover_pic":"(.*?)","origin_category":"(.*?)","pay_reward_num":(.*?),"pay_reward_coins":(.*?),"free_reward_num":(.*?),"free_reward_coins":(.*?),"view_cnt":(.*?),"like_cnt":(.*?),"favorite_cnt":(.*?),"origin_like_cnt":(.*?),"extra":(.*?),"status":(.*?),"video_url":"(.*?)","audio_url":"(.*?)","video_duration":(.*?),"video_size":(.*?),"category_id":(.*?),"gid":(.*?),"updated_at":"(.*?)","created_at":"(.*?)","avatar":"(.*?)","nickname":"(.*?)"/',$video_url,$v);

if($s== 0){

$_msg="短视频刷新中！";

$S_type=$msg_type;

$return_msg = $server_msg -> send($qun,$_msg,$qq,$S_type,$msgid);

 $ws -> push($frame->fd, $return_msg);

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

$bots_msg_type=$msg_type;

$return_msg = $server_msg -> send($qun,$_msg,$qq,$S_type,$msgid);

 $ws -> push($frame->fd, $return_msg);

$url=$sp;

$bots_msg_type=$msg_type;

$send_msg = "[CQ:video,file=".$url."]";

$return_msg = $server_msg -> send($qun,$_msg,$qq,$S_type,$msgid);

 $ws -> push($frame->fd, $return_msg);

}

}

?>
