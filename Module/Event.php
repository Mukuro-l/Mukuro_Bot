<?php
use Mukuro\Module\Api;

/**
 *@name Mukuro事件
 *@doc 事件插件完全被动
 *@comment 无
 *@return text/image
 */
class Event{
	use Api;
	function plugins_Event(){
				//管理员变动
				if ($this->notice_type == "group_admin"){
					if ($this->sub_type == "set"){
						$this->send($this->qq."成为管理员啦");
					}else if ($this->sub_type == "unset"){
						$this->send($this->qq."失去管理员了⌓‿⌓");
					}
				}
				//群成员减少
				if ($this->notice_type == "group_decrease"){
					if ($this->sub_type == "leave"){
						$this->send($this->qq."永别了这位主动退群的小鸡仔");
					}else if ($this->sub_type == "kick"){
						$this->send($this->qq."小黑子漏出鸡脚啦！（被踢）");
					}
				}
				//群成员增加
				if ($this->notice_type == "group_increase"){
					if ($this->sub_type == "approve"){
					$this->send("hi！".$this->qq."管理员刚刚同意你入群，还不来打个招呼");
					}else if ($this->sub_type == "invite"){
					$this->send("被邀请入群？".$this->qq."是不是小黑子！");
					}
				}
				//戳一戳
				if ($this->post_type == "notice"){
					if ($this->notice_type == "notify"){
						if ($this->sub_type == "poke"&&$this->target_id == $this->self_id){
							$this->send('官人，你这是想干嘛呢？');
							$this->send("[CQ:poke,qq=".$this->qq."]");
							}
							}
							}

	}
}
?>
