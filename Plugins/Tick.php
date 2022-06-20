<?php
use Mukuro\Module\Api;



/**
*@name 定时任务
*@doc 配置Mukuro定时任务的插件
*@comment 添加定时任务#08:00:10#QQ号#群号#你好#次数（数字）
*@return text
*/
class Tick{
use Api;
function plugins_Tick(){
$return=$this->MsgS($MsgS_Data=["msg"=>"添加定时任务","data"=>$this->msg]);
if ($return!=null){
$tickdata = explode("#",$return);
if (count($tickdata)!=6){
return $this->send("请按照要求设置！\r\n格式为[添加定时任务#080010#QQ号#群号#你好#次数（数字）]");

}else{
//判断是否有配置文件
if (file_exists("tick_config.json")!=true){
//写入第一次的定时任务
$tick_array[$tickdata[1]][] = [
"qq"=>$tickdata[2],
"qun"=>$tickdata[3],
"time"=>$tickdata[1],
"tick"=>$tickdata[5],
"msg"=>$tickdata[4],
"http_port"=>$BOT_Config["http_port"]
];
$data =json_encode($tick_array,JSON_UNESCAPED_UNICODE);
file_put_contents("tick_config.json",$data);
return $this->send("设置成功");
}else{
$tick_array = json_decode(file_get_contents("tick_config.json"),true);
if ($tick_array[$tickdata[1]]!=null){
$tick_array[$tickdata[1]][count($tick_array[$tickdata[1]])] = [
"qq"=>$tickdata[2],
"qun"=>$tickdata[3],
"time"=>$tickdata[1],
"tick"=>$tickdata[5],
"msg"=>$tickdata[4],
"http_port"=>$BOT_Config["http_port"]
];
$data =json_encode($tick_array,JSON_UNESCAPED_UNICODE);
file_put_contents("tick_config.json",$data);
return $this->send("设置成功");
}else{
$tick_array[$tickdata[1]][] = [
"qq"=>$tickdata[2],
"qun"=>$tickdata[3],
"time"=>$tickdata[1],
"tick"=>$tickdata[5],
"msg"=>$tickdata[4],
"http_port"=>$BOT_Config["http_port"]
];
$data =json_encode($tick_array,JSON_UNESCAPED_UNICODE);
file_put_contents("tick_config.json",$data);
return $this->send("设置成功");
}
}
}
}
}
}
?>