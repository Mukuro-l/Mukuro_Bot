<?php
use Mukuro\Module\Api;

/**
 *@name Mukuro事件
 *@doc 事件插件完全被动
 *@comment 无
 *@return text/image
 */
class Event
{
    use Api;
    public function plugins_Event()
    {
        //需要开启入群验证的群，需要管理员权限
        $group = [654816907];
        //管理员变动
        if ($this->notice_type == "group_admin") {
            if ($this->sub_type == "set") {
                $this->send($this->qq."成为管理员啦");
            } elseif ($this->sub_type == "unset") {
                $this->send($this->qq."失去管理员了⌓‿⌓");
            }
        }
        //群成员减少
        if ($this->notice_type == "group_decrease") {
            if ($this->sub_type == "leave") {
                $this->send($this->qq."永别了这位主动退群的小鸡仔");
            } elseif ($this->sub_type == "kick") {
                $this->send($this->qq."小黑子漏出鸡脚啦！（被踢）");
            }
        }
        //群成员增加
        if ($this->notice_type == "group_increase") {
            if ($this->sub_type == "approve") {
                $this->send("hi！".$this->qq."管理员刚刚同意你入群，还不来打个招呼");
                $group_List = $this->File_retrieval("./Group/",false);
                foreach ($group as $x) {
                if (in_array($x,$group_List)){
                   $this->send("[CQ:at,qq=".$this->qq."] 请在2分钟之内发送2次[验证]，超时则禁言");
                   if ($msg_data=$this->context("验证",$x,$this->qq,120)){
                      if ($msg_data[2]=="验证"){
                         $this->send("[CQ:at,qq=".$this->qq."] 验证成功");
}else{
                         $this->ban($this->qq,2592000);
}
}
}
}

            } elseif ($this->sub_type == "invite") {
                $this->send("被邀请入群？".$this->qq."是不是小黑子！");
            }
        }
        //戳一戳
        if ($this->post_type == "notice") {
            if ($this->notice_type == "notify") {
                if ($this->sub_type == "poke"&&$this->target_id == $this->self_id) {
                    $this->send('官人，你这是想干嘛呢？');
                    $this->send("[CQ:poke,qq=".$this->qq."]");
                }
            }
        }
    }
}
