<?php
use Mukuro\Module\Api;
/**
* @name 跨群聊天
* @doc 通过机器人来在不同群聊聊天
* @comment 跨群聊天
* @return text
*/
class Chat{
      use Api;
      function join_group(int $group_id,int $source){
      $this->Rsend("你可以在15秒内发送[取消]来退出\r\n或者在建立任务之后发送[取消]\r\n若15秒之内无任何响应，程序将会退出进程");
      $begin = $this->context($group_id,$source);
      if ($begin[2]=="取消"){
      return;
      }else if (!empty($begin[2])){
      $this->send(["send_group_msg",$source,"已建立任务，并将消息发送对应群聊"]);
      $this->send(["send_group_msg",$group_id,"来自群聊[$source]的[$this->qq]说：[\r\n".$begin[2]."]\r\nPS：你可以通过跨群聊天功能来回复"]);
      /*$begin = $this->context($begin[2]);
      if ($begin[2]=="取消"){
      return;
      }else{
      
      $this->send(["send_group_msg",$group_id,$begin[2]]);
      }*/
      
      }
      }
      function plugins_Chat(){
      if ($this->msg == "跨群聊天"){
      $this->Rsend("15秒之内输入目标群号");
      $begin = $this->context("跨群聊天");
      if (preg_match("/^[0-9]+$/u",$begin[2],$return)){
      $this->join_group($begin[2],$this->qun);
      
      }
      
      }
      }
}