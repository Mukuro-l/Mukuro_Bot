<?php
use Mukuro\Module\Api;
/**
*@name 默默复读
*@doc Mukuro_Bot也会复读哦
*@comment 无
*@return mixed
*/
class Repeat{
      use Api;
      function plugins_Repeat(){
      if ($this->msg_type !== 'private'){
      $data = $this->context(0,0,0,1);
      if (!empty($data)){
      if ($data[0]==$data[1]){
      $this->send($data[1]);
      }
      }
      }
      }
}