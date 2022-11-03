<?php
use Mukuro\Module\Api;

/**
*@name 重启服务
*@doc 重启Mukuro_Bot的插件，只对超级用户有效
*@comment !/重启
*@return text
*/
class restart_Bot
{
    use Api;
    public function plugins_restart_Bot()
    {
        if ($this->msg=="!/重启") {
            if ($this->qq !==$this->super_user) {
                $this->Rsend("六儿，只听官人的话");
            } else {
                $this->Restart();
            }
        }
    }
}
