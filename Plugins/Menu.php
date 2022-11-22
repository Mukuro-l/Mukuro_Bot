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
        if ($this->msg == "菜单"){
            $this->send(Auto_doc($this->qq));
        }
    }
    public function __destruct()
    {
    }
}
