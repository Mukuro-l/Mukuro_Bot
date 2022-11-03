# [Mukuro_Bot使用手册] by Mukuro-l  
## 引用Intervention\Image  
***
> 版本更新需知  
1. 在新版之后插件返回执行结果时
不再需要return，直接调用send方法。
且send方法支持循环调用（但没有延时）。
2. 新支持的context方法能够获取触发者的下一条聊天信息。  
3. 如果你的PHP没有安装所需的图像处理模块，请安装。
***

你好！  欢迎阅读本程序的使用文档  
运行环境：
- Linux （建议Ubuntu发行版）
- PHP8
- swoole4.8
- 国内IP的服务器
- 仅在Ubuntu22.04，PHP8.1环境通过测试  
- 通过amd\arm平台测试  
- 在termux proot容器开发|测试

<details>
<summary>已实现</summary>
<pre><code>  

- [x] Swoole WebSocket Server  
- [x] Swoole Timer  
- [x] 图文合成  
- [x] 并发协程  
- [x] 自动文档  
- [x] 自动生成菜单  

</code></pre>
</details>


TODO：
- [ ] 被动技能
- [ ] 群管理
***
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
# 克隆Mukuro_Bot  
```git clone https://github.com/Mukuro-l/Mukuro_Bot.git```  
# 配置Mukuro_Bot  
- 打开[Module]文件夹  
- 在Config.php文件内配置  
- ~~返回根目录，**在根目录执行：```unzip vendor.zip```**~~
# 启动  
- 需先配置完毕，直接在Mukuro_Bot根目录```php run.php```即可  
- ~~如果没有执行权限请```chmod 777 run```~~
# 一键部署脚本  
- 请在root目录执行
- ~~```bash <(curl -s -S -L http://43.154.119.191/shell/install.sh)```~~
***

## 开发  
```php
<?php
use Mukuro\Module\Api;
//类名需与文件名一致

/**
*@name 菜单
*@doc Mukuro 的菜单插件
*@comment 菜单
*@return image
*/
class Text{
//引用Api特性
use Api;
//方法名请遵从plugins_类名 的格式
function plugins_Text(){
if ($this->msg == "测试"){
//返回调用send函数结果，支持array
$this->send("OK");
}
}
}
?>
```  

