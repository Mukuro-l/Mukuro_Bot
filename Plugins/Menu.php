<?php
use Mukuro\Module\Api;

/**
*@name 菜单
*@doc Mukuro 的菜单插件
*@comment 菜单
*@return image
*/
class Menu
{
    use Api;
    public function plugins_Menu()
    {
        if ($this->msg == "菜单") {
            $qq=$this->qq;
            Auto_doc($qq);
            return $this->send("[CQ:image,file=".$qq.".jpg]");
        }
    }
    public function __destruct()
    {
    }
}
