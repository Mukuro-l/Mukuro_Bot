<?php
use Mukuro\Module\Api;



/**
*@name 定时任务
*@doc 配置Mukuro定时任务的插件
*@comment 添加定时任务#080010#QQ号#群号#你好#次数（数字）
*@return text
*/
class Tick{
use Api;
function plugins_Tick(){

if (preg_match("/^添加定时任务# ?([0-9]+.*)# ?([0-9]+.*)# ?([0-9]+.*)# ?(.*)# ?([0-9]+.*)\$/", $this->msg, $return)) {
$BOT_Config =json_decode(file_get_contents("config.json"),true);
//判断是否有配置文件
if (file_exists("tick_config.json")!=true){
//写入第一次的定时任务
$tick_array[$tickdata[1]][] = [
"qq"=>$return[2],
"qun"=>$return[3],
"time"=>$return[1],
"tick"=>$return[5],
"msg"=>$return[4],
"http_port"=>$BOT_Config["http_port"]
];
$data =json_encode($tick_array,JSON_UNESCAPED_UNICODE);
file_put_contents("tick_config.json",$data);
return $this->send("设置成功");
}else{
$tick_array = json_decode(file_get_contents("tick_config.json"),true);
if ($tick_array[$tickdata[1]]!=null){
$tick_array[$tickdata[1]][count($tick_array[$tickdata[1]])] = [
"qq"=>$return[2],
"qun"=>$return[3],
"time"=>$return[1],
"tick"=>$return[5],
"msg"=>$return[4],
"http_port"=>$BOT_Config["http_port"]
];
$data =json_encode($tick_array,JSON_UNESCAPED_UNICODE);
file_put_contents("tick_config.json",$data);
return $this->send("设置成功");
}else{
$tick_array[$tickdata[1]][] = [
"qq"=>$return[2],
"qun"=>$return[3],
"time"=>$return[1],
"tick"=>$return[5],
"msg"=>$return[4],
"http_port"=>$BOT_Config["http_port"]
];
$data =json_encode($tick_array,JSON_UNESCAPED_UNICODE);
file_put_contents("tick_config.json",$data);
return $this->send("设置成功");
}
}

}else if (strstr("添加定时任务#",$this->msg)){
return $this->send("请按照要求设置！\r\n格式为[添加定时任务#080010#QQ号#群号#你好#次数（数字）]").$this->send("Σ(ŎдŎ|||)ﾉﾉ");
}

}
}
?>