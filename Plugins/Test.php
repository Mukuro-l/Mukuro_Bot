<?php
use Mukuro\Module\Api;

/**
*@name 测试
*@doc Mukuro测试插件
*@comment 测试
*@return text
*/
class Test {
	use Api;
public	function plugins_Test() {
		if ($this->msg == "测试") {
			return $this->send("测试成功");
		}
	}
	public function __destruct() {
	}
}
?>
