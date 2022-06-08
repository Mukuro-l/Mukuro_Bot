<?php
use PHProbot\Module\Api;

class Menu{
use Api;
function plugins_Menu(){
if ($this->msg == "菜单"){
$qq=$this->qq;
Text_Images("情不知所起，一往而深，生者可以死，死者可以生。生而不可与死，死而不可复生者，皆非情之至也 ——汤显祖《牡丹亭》", $qq);
return $this->send("[CQ:image,file=".$qq.".jpg]");
}
}
public function __destruct() {
	}
}