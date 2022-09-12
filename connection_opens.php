<?php
include './Module/Config.php';
	echo "go-cqhttp已连接\n";
	$Welcome_to_use = "Mukuro已成功启动\n欢迎使用Mukuro\n当前版本：" . $BOT_Config["SDK"] . "\n项目地址：https://github.com/Mukuro-l/Mukuro_Bot\nQQ邮箱：coldeggs@qq.com\nOutlook邮箱：g2744602949@outlook.com\n";
	echo $Welcome_to_use;
		$file_array = json_decode(file_get_contents("Plugins_switch.json"), true);
		$list = glob('./Plugins/*.php');
					//判断是否增加
					if (count($list) > count($file_array)) {
						for ($i = 0;$i < count($list);$i++) {
							$file = explode('/', $list[$i]) [2];
							if ($file_array[$i]["插件名"] != $file) {
								unlink("Plugins_switch.json");
							}
						}
					}
					//如果少于
					if (count($list) < count($file_array)) {
						for ($i = 0;$i < count($list);$i++) {
							$file = explode('/', $list[$i]) [2];
							if ($file_array[$i]["插件名"] != $file) {
								unlink("Plugins_switch.json");
							}
						}
					}
?>