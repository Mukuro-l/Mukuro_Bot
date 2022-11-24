<?php
include_once './vendor/autoload.php';
include_once './Module/Config.php';
include_once './Module/Api.php';

//应该在启动之前开启一个进程进行初始化
if (!is_dir("Group")) {
    mkdir("Group");
} else {
    if (!is_dir('./Data/Text/')) {
        mkdir('./Data/Text/');
    }
}
if (!is_dir("Doc")) {
    mkdir("Doc");
}

$file_array = json_decode(file_get_contents("Plugins_switch.json"), true);

$list = glob('./Plugins/*.php');
                if (is_file("Plugins_switch.json") == false) {
                    $Plugins_array = array();
                    for ($i = 0;$i < count($list);$i++) {
                        $file = explode('/', $list[$i]) [2];
                        $Plugins_array[] = array("插件名" => $file, "状态" => "开");
                    }
                    $Plugins_list = json_encode($Plugins_array, JSON_UNESCAPED_UNICODE);
                    file_put_contents("Plugins_switch.json", $Plugins_list);
                }
                $i = -1;
                foreach ($list as $file) {
                    $i++;
                    $file = explode('/', $list[$i]) [2];
                    $Plugins_name = explode('.', $file);
                    $Plugins_name = $Plugins_name[0];
                    include_once './Plugins/' . $file;
                    if (!is_dir("./Doc/" . $Plugins_name)) {
                        $Doc = new ReflectionClass($Plugins_name);
                        $Doc = $Doc->getDocComment();
                        try {
                            $Doc_doc_ = explode("*", $Doc);
                            if (empty($Doc_doc_[3])) {
                                throw new Exception("官人！Mukuro检测到插件".$Plugins_name."出现异常！异常为：未获取到类的注释\r\nMukuro已自动关闭此异常插件\r\n");
                                file_put_contents("Error","官人！Mukuro检测到插件".$Plugins_name."出现异常！异常为：未获取到类的注释\r\nMukuro已自动关闭此异常插件\r\n");
                            } else {
                                //名字会出现在菜单上
                                $Doc_name = explode("@name", $Doc_doc_[3]);
                                $Doc_doc = explode("@doc", $Doc_doc_[4]);
                                $Doc_comment = explode("@comment", $Doc_doc_[5]);
                                $Doc_return = explode("@return", $Doc_doc_[6]);
                                $Doc_data = "    Mukuro --" . $Plugins_name . "插件帮助\r\n名字：" . trim($Doc_name[1]) . "\r\n详情：" . trim($Doc_doc[1]) . "\r\n指令：" . trim($Doc_comment[1]) . "\r\n返回：" . trim($Doc_return[1]);
                                mkdir("./Doc/" . $Plugins_name);
                                file_put_contents("./Doc/" . $Plugins_name . "/" . $Plugins_name . ".txt", $Doc_data);
                            }
                        } catch (Exception $e) {
                            echo $e->getMessage();
                            //处理异常
                            for ($i=0;$i<count($file_array);$i++) {
                                if ($file_array[$i]["插件名"] === $Plugins_name) {
                                    $file_array[$i]["状态"]="关";
                                    $Plugins_list = json_encode($Plugins_array, JSON_UNESCAPED_UNICODE);
                                    file_put_contents("Plugins_switch.json", $Plugins_list);
                                }
                            }
                        }
                    }
                }
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
