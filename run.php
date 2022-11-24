#!/usr/bin/php
<?php
/**
 *@version v1.1.7
 *@date 2022.11.10
 *@author Mukuro-l
 *@copyright 2021-2022 Mukuro-l.AllRightsReserved
 *@start/begin with/in 2021.08.21
 */

use Swoole\Coroutine\Barrier;
use Swoole\Coroutine\System;
use Swoole\Coroutine;
use Swoole\Coroutine\Channel;
use function Swoole\Coroutine\run;
use Mukuro\Module\Passive;

//运行环境检测，现只支持Linux系统，且不支持多php版本环境
if (!extension_loaded("swoole")) {
    exit("未检测到Swoole扩展，请参考wiki.swoole.com \n");
}
if (!extension_loaded("zip")) {
    echo "未检测到php-zip扩展，正在尝试安装\n";
    system("sudo apt install -y php-zip");
}

if (!extension_loaded("gd")) {
    echo "未检测到gd处理库，正在尝试安装\n";
    system("sudo apt install -y php-gd");
}
if (!extension_loaded("imagick")) {
    echo "未检测到imagick处理库，正在尝试安装\n";
    system("sudo apt install -y php-imagick");
}
if (!extension_loaded("redis")) {
    echo "未检测到redis扩展，请确保系统有Redis数据库，正在尝试安装扩展\n";
    system("sudo apt install -y php-redis");
}
if (!is_file("../gocq/go-cqhttp")) {
    echo "将会在5秒后下载对应版本的go-cqhttp\n取消请Ctrl + c\n";
    Swoole\Timer::after(5000, function () {
        function download()
        {
            $Version = exec("uname -m");
            if ($Version == "aarch64") {
                $Version = "arm64";
            } elseif ($Version == "x86_64") {
                $Version = "amd64";
            }
            if (empty($Version)) {
                exit("错误！未获取到系统指令集版本，现只支持Linux系统。\n");
            } else {
                $go_cq = file_get_contents("https://github.com/Mrs4s/go-cqhttp/releases/download/v1.0.0-rc3/go-cqhttp_linux_".$Version.".tar.gz");
                if (empty($go_cq)) {
                    echo "国内GitHub CDN加速下载失败，正在切换到GitHub官方下载\n";
                    $go_cq = file_get_contents("https://github.com/Mrs4s/go-cqhttp/releases/download/v1.0.0-rc3/go-cqhttp_linux_".$Version.".tar.gz");
                    file_put_contents("../gocq/gocq.tar.gz", $go_cq);
                    system("sudo tar -xzf ../gocq/gocq.tar.gz");
                    system("sudo rm ../gocq/gocq.tar.gz");
                    echo "成功\n";
                } else {
                    file_put_contents("../gocq/gocq.tar.gz", $go_cq);
                    system("sudo tar -xzf ../gocq/gocq.tar.gz");
                    system("sudo rm ../gocq/gocq.tar.gz");
                    echo "成功\n";
                }
            }
        }

        if (!is_dir("../gocq/")) {
            mkdir("../gocq/");
            download();
        } else {
            download();
        }
    });
}


//每次启动都会初始化
if (is_file("./Doc/Mukuro_Menu_Doc/Menu.txt")) {
    unlink("./Doc/Mukuro_Menu_Doc/Menu.txt");
}
if (!is_dir("vendor")) {
    //解压zip操作
    $zip = new ZipArchive();
    $openRes = $zip->open("vendor.zip");
    if ($openRes === true) {
        //会解压到当前文件夹
        $zip->extractTo(dirname(__FILE__));
        $zip->close();
    }
}


//外部文件载入
include './Module/Config.php';
include './vendor/autoload.php';
include_once './Module/Api.php';
include_once 'initialization.php';
//error_reporting($BOT_Config["Error_level"]);

$ws = new Swoole\WebSocket\Server('0.0.0.0', $BOT_Config["port"]);
echo "Mukuro_Bot服务器已启动，正在等待客户端连接......\n免责通知：当你使用本软件起，即代表着同意本软件的开源协议证书。\n如违反本开源证书，开发者将会以法律程序向违反开源协议的个人或组织提起上诉\n开源证书：Apache-2.0 license\n";

$ws->set([
    'task_worker_num' => 8,
    'task_enable_coroutine' => true
]);


//监听WebSocket连接打开事件
$ws->on('Open', function ($ws, $request) use ($BOT_Config) {
    include_once './Module/Function.php';
    //连接打开
    include_once "connection_opens.php";
});

//监听WebSocket消息事件
$ws->on('Message', function ($ws, $frame) use ($database, $BOT_Config) {


//避免一些错误
    include_once 'initialization.php';

    //载入函数库
    include_once './Module/Function.php';

    //控制类
    include_once './Module/Api.php';

    
    //fd为客户端标识, $ws调用push函数发送(第二个参数为消息内容)
    $Data = $frame->data;
    //json转为PHP数组，必须转为PHP对象
    $Data = json_decode($Data, true);
    $service_id = $frame->fd;
    $Data[]=["service_id"=>$service_id];
    //输出data
    if ($BOT_Config["Return_Data"] == true) {
        if (@$Data['meta_event_type'] != 'heartbeat') {
            print_r($Data);
        }
    }
    $database->set('data',['Data'=>Json($Data)]);
    
    if (is_file("Restart")||is_file("Error")) {
        $Passive = new Passive($Data, $database, $BOT_Config, $ws);
        if (is_file("Restart")) {
            unlink("Restart");
            $url = ["send_private_msg",$BOT_Config["qhost"],"[notification]:Mukuro_Bot已重启"];
            $Passive->To_Passive($url);
        } elseif (is_file("Error")) {
            $Error_msg = file_get_contents("Error");
            unlink("Error");
            $url = ["send_private_msg",$BOT_Config["qhost"],$Error_msg];
            $Passive->To_Passive($url);
        }
    }
    if (@$Data["status"]!==null&&!is_array(@$Data["status"])){
    if (@$Data["status"]!=="ok"&&$BOT_Config["qhost"]!==0) {
        $Passive = new Passive($Data, $database, $BOT_Config, $ws);
        $url = ["send_private_msg",$BOT_Config["qhost"],"调用API时产生错误\r\n报错：".$Data["msg"]."\r\n详情：".$Data["wording"]."\r\n请检查客户端输出\r\n".date("Y-m-d H:i:s")];
        $Passive->To_Passive($url);
        file_put_contents("Error", "调用API时产生错误\r\n报错：".$Data["msg"]."\r\n详情：".$Data["wording"]."\r\n请检查客户端输出\r\n".date("Y-m-d H:i:s"));
    }
        }
        
    
    if (@$Data['meta_event_type'] !== 'heartbeat' && @$Data['meta_event_type'] !== 'lifecycle') {
        if (@$Data['status'] === null &&@$Data["post_type"] === "message"||@$Data["post_type"] === "notice") {
            if ($Data['message_type']==="private"&&$Data["user_id"]==$BOT_Config["qhost"]) {
                if ($Data['message'] === "!/终止") {
                    $Swoole_pid=exec("netstat -tunlp|grep ".$BOT_Config["port"]);
                    $Swoole_arr=trim($Swoole_pid);
                    $Swoole_arr=explode("LISTEN", $Swoole_arr);
                    $Swoole_arr=trim($Swoole_arr[1]);
                    $Swoole_arr=explode("/", $Swoole_arr);
                    system("kill -9 ".$Swoole_arr[0]);
                    exit;
                }
            }
            if ($BOT_Config["qhost"] === 0&&$Data['message_type']==="private") {
                $Passive = new Passive($Data, $database, $BOT_Config, $ws);
                if ($Data['message'] === "!/Mukuro") {
                    $bothost = $Data['user_id'];
                    $BOT_Config["qhost"]=$Data['user_id'];
                    $Config_data = json_encode($BOT_Config, JSON_UNESCAPED_UNICODE);
                    file_put_contents("config.json", $Config_data);
                    $Detailed_description="version:v1.1.7\r\n欢迎使用Mukuro_Bot开发框架\r\n现已认证主人[$bothost]\r\n[M-开]在一个群聊中发送这条指令即可开启群聊\r\n[M-闭]来关闭群聊\r\n[M-插件名]来合成插件的注释并发送，可在[Doc]文件夹编辑\r\n将在5秒后重启Mukuro_Bot服务，请留意go-cqhttp控制台输出";
                    $Passive->do_Passive("send", $Detailed_description);
        
                    system("chmod +x restart.sh");
                    exec("nohup ./restart.sh &> /dev/null & echo $! > pidfile.txt");
                }
                $Passive->do_Passive("send", "现在是无主模式，请查看控制台输出");
                echo "[notification]：目前无主人状态，现私聊发送[!/Mukuro]即可完成认证\n";
            }
            //这里进行载入为了避免不必要的数据
            $list = glob('./Plugins/*.php');
            $file_array = json_decode(file_get_contents("Plugins_switch.json"), true);
                
            //这里会载入Plugins文件夹下的所有插件 115版本增加是否载入
            if (!is_file("./Group/".@$Data['group_id']."/config.json")&&!empty($Data['group_id'])) {
                mkdir("./Group/".$Data['group_id']);
                $Group_data = ["status"=>"关"];
                file_put_contents("./Group/".$Data['group_id']."/config.json", Json($Group_data));
            }
                    
            //封解主的动作
            if (preg_match("/^M- ?(.*)\$/", $Data['message'], $Jiezhu)) {
                $Passive = new Passive($Data, $database, $BOT_Config, $ws);
                if ($BOT_Config["qhost"] === $Data['user_id']) {
                    if ($Jiezhu[1] === "开" || $Jiezhu[1] === "闭") {
                        if ($Jiezhu[1] === "开") {
                            $instruction = "开启";
                        } else {
                            $instruction = "关闭";
                        }
                        $Jiezhu_data=json_decode(file_get_contents("./Group/".$Data['group_id']."/config.json"), true);
                        $Jiezhu_data["status"]=$Jiezhu[1];
                        file_put_contents("./Group/".$Data['group_id']."/config.json", Json($Jiezhu_data));
                        $Passive->do_Passive("send", "已成功".$instruction."此群聊");
                    }
                    if ($Jiezhu[1] != "开" && $Jiezhu[1] != "闭") {
$menu_Array = [];
                        for ($i=0;$i<count($file_array);$i++) {
                            $Jiezhu_Plugins=explode('.', $file_array[$i]["插件名"]);
                            if (is_file("./Doc/".$Jiezhu_Plugins[0]."/".$Jiezhu_Plugins[0].".txt")) {
                                $menu_data=file_get_contents("./Doc/".$Jiezhu_Plugins[0]."/".$Jiezhu_Plugins[0].".txt");
                                if (preg_match("/^Mukuro ?(.*)
名字：?(.*)
详情：?(.*)
指令：?(.*)
返回：?(.*)\$/m",trim($menu_data),$return)){

}
$menu_Array[]=$return[2];
                                if (trim($return[2])==$Jiezhu[1]) {
                                    $menu_data_code=Text_Images("./Doc/".$Jiezhu_Plugins[0]."/".$Jiezhu_Plugins[0].".txt", $Data['user_id']);
                                    $Passive->do_Passive("send", $menu_data_code);
                                }
                            }
                
                            //获取帮助
                        }
                    }
                } else {
                    if ($Jiezhu[1] != "开" && $Jiezhu[1] != "闭") {
                        $Passive = new Passive($Data, $database, $BOT_Config, $ws);
                        $menu_Array = [];
                        for ($i=0;$i<count($file_array);$i++) {
                            $Jiezhu_Plugins=explode('.', $file_array[$i]["插件名"]);
                            if (is_file("./Doc/".$Jiezhu_Plugins[0]."/".$Jiezhu_Plugins[0].".txt")) {
                                $menu_data=file_get_contents("./Doc/".$Jiezhu_Plugins[0]."/".$Jiezhu_Plugins[0].".txt");
                                if (preg_match("/^Mukuro ?(.*)
名字：?(.*)
详情：?(.*)
指令：?(.*)
返回：?(.*)\$/m",trim($menu_data),$return)){
}
                                $menu_Array[]=$return[2];
                                if (trim($return[2])==$Jiezhu[1]) {
                                    $menu_data_code=Text_Images("./Doc/".$Jiezhu_Plugins[0]."/".$Jiezhu_Plugins[0].".txt", $Data['user_id']);
                                    $Passive->do_Passive("send", $menu_data_code);
                               } else if (!in_array($return[2],$menu_Array)){

                                $Passive->do_Passive("send", "暂无此插件");
                                break;
                                }
                            }
                        }
                    }
                }
            }
            //这里会对群的全局状态做出判断，但如果插件状态为关，也不会载入
            if (!empty($Data['group_id'])){
            if (json_decode(file_get_contents("./Group/".$Data['group_id']."/config.json"), true)["status"] === "开" || $Data['message_type'] === 'private') {
                $file_array = json_decode(file_get_contents("Plugins_switch.json"), true);
                for ($i = 0;$i < count($list);$i++) {
                    $file = $file_array[$i]["插件名"];
                        
                    if (!is_file("./Doc/Mukuro_Menu_Doc/Menu.txt")) {
                        for ($i = 0;$i < count($list);$i++) {
                            $Menu_doc = explode('.', $file_array[$i]["插件名"]);
                            $doc_data = file_get_contents("./Doc/" . $Menu_doc[0] . "/" . $Menu_doc[0] . ".txt");
                            if (preg_match("/^Mukuro ?(.*)
名字：?(.*)
详情：?(.*)
指令：?(.*)
返回：?(.*)\$/m",trim($doc_data),$return)){

file_put_contents("./Doc/Mukuro_Menu_Doc/Menu.txt", $return[2] , FILE_APPEND);
}
                            
                        }
                    }
                }
                $task_id = $ws->task($Data);
                if (is_file("./Module/Repeat.php")) {
                    include_once "./Module/Repeat.php";
                    $Event = new Repeat($Data, $database, $BOT_Config, $ws);
                    $Event->plugins_Repeat();
                }
            }
}
        }
        
    }
});

//异步回调
$ws->on('Task', function ($ws,$task) use ($database, $BOT_Config) {
    $Data=$database->get('data');
    include './vendor/autoload.php';
    include_once './Module/Function.php';
    include_once './Module/Api.php';
    $Data=de_Json($Data['Data']);
    $list = glob('./Plugins/*.php');
    $file_array = json_decode(file_get_contents("Plugins_switch.json"), true);
    for ($i = 0;$i < count($list);$i++) {
        $file = $file_array[$i]["插件名"];
        //插件状态判断
        if ($file_array[$i]["状态"] == "开") {
            include_once "./Plugins/".$file;
            $Plugins_name = explode('.', $file);
            $Plugins_name = $Plugins_name[0];
            $Plugins_name_function = "plugins_" . $Plugins_name;
            $Plugins_test = new $Plugins_name($Data, $database, $BOT_Config, $ws);
            $Plugins_return = $Plugins_test->$Plugins_name_function();
            if (isset($Plugins_return)) {
                $ws->push($frame->fd, $Plugins_return);
            }
        }
    }
if (@$Data["post_type"] === "notice") {
            //载入模块
            include_once "./Module/Event.php";
            $Event = new Event($Data, $database, $BOT_Config, $ws);
            $Event->plugins_Event();
        }
    //返回任务执行的结果
    print("异步任务[".date("Y-m-d H:i:s")."] -> OK\n");
});

//监听WebSocket连接关闭事件
@$ws->on('Close', function ($ws, $fd) {
    echo "go-cqhttp客户端：-{$fd} 已关闭\n";
});




$ws->start();


?>
