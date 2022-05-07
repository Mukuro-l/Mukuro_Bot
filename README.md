# [PHProbot使用手册] by coldeggs  
## 引用phpqrcode  
你好！  欢迎阅读本程序的使用文档  
交流QQ群：729473945  
运行环境：
- Linux （建议Ubuntu发行版）
- PHP7
- swoole4.8
- GO
- 国内IP的服务器
- 仅在Ubuntu20.3，PHP7.4环境通过测试  
- 通过amd\arm平台测试  

# 安装PHP7版本  
- apt安装  
```apt install php```  
- 可能还需要其他软件：gcc、make、unzip、autoconf、、、  
# 安装swoole  
参考```wiki.swoole.com```  
# 安装golang  
- apt方式安装  
```apt install golang```  
# 获取gocq  
- wget方式获取  
- 根据自己平台选择  
```wget https://github.com/Mrs4s/go-cqhttp/releases/download/v1.0.0-rc1/go-cqhttp_linux_amd64.tar.gz```  
# 解压gocq  
```tar -xzf go-cqhttp_linux_amd64.tar.gz```  
- 打开上级目录```cd -```  
# 克隆PHProbot  
```git clone https://github.com/2744602949/PHProbot.git```  
# 配置PHProbot  
- 打开[module]文件夹  
- 在config.php文件内配置  
# 启动  
- 需先配置完毕，直接在PHProbot根目录```php run.php```即可  
## 开发  
```
<?php

//该文件为PHProbot插件开发示例

//创建一个消息类，115版本以前不支持命名空间
use PHProbot\Api;

//开始识别消息内容

if ($msg == "测试"){

//设置消息发送类型，114版本可设置[群聊、私聊]

//$msg_type 为自动识别的消息来源[群聊、私聊]

$S_type = $msg_type;

//设置发送消息内容

$_msg = "Hello, World";

//调用消息类 send函数，在115版本以前不支持

PHProbot\Api::send();

}

?>
```  

