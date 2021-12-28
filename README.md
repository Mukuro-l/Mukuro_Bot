# [CP·Bot使用手册] by coldeggs  
## 引用phpmailer&phpqrcode  
你好！  欢迎阅读本程序的使用文档  
运行环境：
- Linux
- PHP 8.0
- GO
- 国内IP的服务器

***
1.首先你需要把本文件夹下的所有文件解压到服务器。  
2.第二步，在 [^module] 文件夹下找到 [^config.php] 文件。  
3.第三步，配置 [^config.php] 文件。  
4.第四步，查看 [^functions.php] 文件(邮件服务)来配置邮件（如果你需要的话）。  
5.第五步，查看 [^model.php] 文件来着手开发
***  
* 主要配置步骤  
1. 有关于本文件夹下的[^device.json]文件：[^ip_address]即为你的设备IP地址，[^sdk]即为你的系统sdk版本（目前我的为30），[^protocol]即为机型类型建议为0。  
- [^config.yml]文件，本文件是为了让你登录服务器而产生的配置文件，一定要好好配置，4、5、90、104行需要你自行设置否则无法运行。  
- 建议你的服务器控制面板为宝塔面板。  
- 如果你的服务器系统为纯净系统，则你还需要安装go，wget，PHP8.0(可通过宝塔面板一键安装)，nohup。其他指令请自行百度安装方法。  
2. 如果你已经安装了以上指令，请你在服务器ssh选择一个文件夹执行以下指令。   
```wget https://github.com/Mrs4s/go-cqhttp/releases/download/v1.0.0-beta8-fix2/go-cqhttp_linux_amd64.tar.gz```
 - 下载完成之后解压，并将[config.yml]和[device.json]文件(必须为你设置好的)移动至你所解压的位置。  
 3. 一切准备OK之后，试运行执行以下指令[^./go-cqhttp]  
 - 如果登录需要扫码，请扫码，建议关闭设备锁。  
 - 登录成功之后请关闭ssh，再打开执行以下指令  
 ```nohup ./go-cqhttp >bot.log 2>&1 &  ```
 - 补充如何终止程序，在执行完毕指令之后会给出一串数字，使用指令[kill 数字]即可终止  
 - GO语言安装：```https://www.runoob.com/go/go-environment.html```
 - 文件下载强烈建议使用wget指令。
 
 这样就大功告成了，如果出现不能发送消息的情况，很有可能你的账号被风控了，不过没关系一直在线一个星期就正常了。你的机器人日志在[^bot.log]
