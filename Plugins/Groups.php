<?php
use Mukuro\Module\Api;

/**
*@name 群聊广播
*@doc 测试广播可用性
*@comment 广播
*@return text
*/
class Groups
{
    use Api;
    public function plugins_Groups()
    {
        if (preg_match("/^广播?(.*)\$/", $this->msg, $return)) {
            if ($this->super_user == $this->qq) {
                $group_list = $this->File_retrieval("./Group/", true);
                $this->Group_Send($group_list, $return[1]);
            }
        }
    }
}
