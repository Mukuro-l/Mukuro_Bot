<?php
use Mukuro\Module\Api;
class test {
	use Api;
public	function plugins_test() {
		if ($this->msg == "测试") {
			return $this->send("测试成功");
		}
	}
	public function __destruct() {
	}
}
?>