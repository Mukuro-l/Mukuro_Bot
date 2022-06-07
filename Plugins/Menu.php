<?php
use PHProbot\Module\Api;

class Menu{
use Api;
function plugins_Menu(){
if ($this->msg == "菜单"){
return $this->send("测试版，有个鸡巴菜单。");
}
}
public function __destruct() {
	}
}