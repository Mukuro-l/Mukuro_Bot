<?php
/*机器人开发范例
 *在开发之前你必须完成./module/config.php文件
 *1.如何发送消息
 *2.开关机应用
 *持续更新中
 *date 2021.11.28
 */
 
 /* $msg
 *我们为开发者对接了消息接口
 *$msg即为程序收到的消息
 *如果php运行报错了，只要能跑起来就不要管它
 */
 
//判断$msg内容
if ($msg=="你好"){
$bots_msg_type="群聊";//设置发送的消息为群聊消息，其他类型有：主聊，私聊，回复私聊，回复

$send_msg="hello, world";//设置发送的消息内容

bot_api($host,$qun,$send_msg,$qq,$bots_msg_type,$msgid);//调用发送消息的api，参数说明：$host即为你的服务地址，$qun即为QQ群号，$qq即为QQ号，$send_msg即为发送的消息内容，$bots_msg_type即为发送消息类型，$msgid即为消息id

}

/*
 *为开发者准备了内置的机器人配置函数的使用方法
 *是否存在权限问题？不会。
*/

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

//基本的状态判断
/*
//读取配置文件
$miui=file_get_contents($dir_qun,"r");
//转为数组
$miui=json_decode($miui,true);
//判断状态
if ($miui[$qq]==$msg){
$send_msg="本来就是".$msg."状态";
//调用api
bot_api($host,$qun,$send_msg,$qq,$bots_msg_type,$msgid);
}

*关于更多请自行查看json文件
*/

