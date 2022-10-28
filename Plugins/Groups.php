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
      if ($this->msg == "广播"){
      if ($this->super_user == $this->qq){
      $this->Rsend("请发送需要广播的消息");
      //内容是$msg_data[2]
      $msg_data = $this->context("广播",$this->qun,$this->qq,0);
      
      $group_list = File_retrieval("./Group/",true);
      Group_Send($group_list,$msg_data[2]);
      
      }
      
      }
      }
}