<?php
/* *@qun 获取群QQ
   *@msg 获取消息
   *@qq 获取发送者QQ
   *@petname 获取发送者昵称(适配中)
   *@atqq 获取艾特QQ(适配中)
   *@qhost 获取主人QQ
   *@robot 获取机器人QQ
   *@version v1.1.1
   *@date 2021.11.11
   *@Nick ツバキの花
   *@QQ1940826077
   *coldeggs机器人2021.08.21
   *沐袅网络科技有限公司版权所有
   *联系邮箱coldeggsblog@coldeggs.top
*/

//设置编码为UTF-8
header("Content-type:text/html;charset=utf-8");
//PHP的post数据流，启动反向http post服务器时需post到此文件，PHP数据流才能接受到数据
$con=file_get_contents("php://input","r");
//json转为PHP数组，必须转为PHP对象
@$data=json_decode($con,true);

//══════开始运行══════＊/

//════════════════════
//外部文件载入区
//如果没有请注释掉
require_once '../vendor/autoload.php';

require_once './module/config.php';//机器人配置模块

require_once './module/api.php';//机器人各类api模块

require_once './module/curl.php';//网络通讯模块

require_once './module/json.php';//json数据处理模块

require_once './function/main.php';//机器人功能

//════════════════════

//用来检测你的代码是否有bug
echo "程序准备OK";
?>