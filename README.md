# 请注意：main分支存在未发布的功能及特性，稳定性未知。建议使用发行版。  
# [PHProbot使用手册] by coldeggs  
## 引用hahadu/image-factory  
你好！  欢迎阅读本程序的使用文档  
运行环境：
- Linux （建议Ubuntu发行版）
- PHP8
- swoole4.8
- 国内IP的服务器
- 仅在Ubuntu20.4，PHP7.4环境通过测试  
- 通过amd\arm平台测试  
- 在termux proot容器开发|测试

已实现：
- [x] Swoole WebSocket Server  
- [x] Swoole Timer  
- [x] 图文合成  
- [x] 并发协程  

# 安装PHP  
- apt安装  
```apt install php```  
- 可能还需要其他软件：gcc、make、unzip、autoconf、、、  
# 安装swoole  
参考```wiki.swoole.com```  
# 获取gocq  
- wget方式获取  
- 根据自己平台选择  
```wget https://github.com/Mrs4s/go-cqhttp/releases/download/v1.0.0-rc2/go-cqhttp_linux_amd64.tar.gz```  
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
# 一键部署脚本  
- 正在路上……
## 开发  
```
<?php
use PHProbot\Module\Api;
//类名需与文件名一致
class Text{
//引用Api特性
use Api;
//方法名请遵从plugins_类名 的格式
function plugins_Text(){
if ($this->msg == "测试"){
//返回调用send函数结果，支持array
return $this->send("OK");
}
}
}
?>
```  

