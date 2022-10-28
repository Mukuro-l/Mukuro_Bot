<?php
use Mukuro\Module\Api;
/**
*@name 群聊广播
*@doc 测试广播可用性
*@comment 广播
*@return text
*/
class Groups{
      use Api;
      function plugins_Groups(){
      if (preg_match("/^广播?(.*)\$/",$this->msg,$return)){
      if ($this->super_user == $this->qq){
      $group_list = $this->File_retrieval("./Group/",true);
      print_r($group_list);
      Group_Send($group_list,$return[1]);
      
      }
      
      }
      }
}