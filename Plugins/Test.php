<?php
use Mukuro\Module\Api;

/**
*@name 测试
*@doc Mukuro测试插件
*@comment 测试
*@return text
*/
class Test
{
    use Api;
    public function plugins_Test()
    {
        if ($this->msg == "测试") {
            $this->send("测试成功");
            Co::sleep(2);
            $this->send("欢迎使用本框架", $this->super_user);
        }
    }
}
