<?php
use Mukuro\Module\Api;
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
