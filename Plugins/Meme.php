<?php
use Mukuro\Module\Api;

/**
*@name 头像表情包生成
*@doc 生成QQ头像有趣表情包，现在支持：一分钟
*@comment 一分钟
*@return image
*/
class Meme{
use Api;
  function plugins_Meme(){
    if ($data=$this->MsgS(["msg"=>"一分钟", "data"=>$this->msg])!= null){
      if ($data=="自己"){
    return $this->send(HeiHei("一分钟", $this->qq));
        }else{
        $data = trim($data);
        $data = explode("[CQ:at,qq=", $data);
        $data = explode("]", $data[1]);
        return $this->send(HeiHei("一分钟", $data[0]));
      }
    }
    }
}
?>
