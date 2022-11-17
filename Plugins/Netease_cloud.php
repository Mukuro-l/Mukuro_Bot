<?php
use Mukuro\Module\Api;

/**
 *@name 网易云点歌
 *@doc 一个网易云点歌插件
 *@comment 点歌
 *@return image
 */
class Netease_cloud
{
    use Api;
    public function Netease_cloud_Api($return,$song_Msg)
    {
        $url = "http://cloud-music.pl-fe.cn/search?keywords=" . urlencode($return);
        $song_data = json_decode(file_get_contents($url), true);
        $result = $song_data['result'];
        $song_list = $result['songs']; //歌曲列表
            $list_data = $song_list[0]; //选歌
            $song_id = $list_data["id"];
        if ($song_id == null) {
            $this->send("获取失败");
        } else {
            for ($i = 0;$i < 20;$i++) {
                $list .= ($i + 1) . ".<" . $song_list[$i]['name'] . ">--" . $song_list[$i]['artists'][0]['name'] . '\r\n';
                
            }
            Text_Images($list, $this->qq);
            $this->send("[CQ:image,file=" . $this->qq . ".jpg]");
            
            $this->Rsend("请直接发送序号来选择");
            $return_data=$this->context($song_Msg,$this->qun,$this->qq);
            if (preg_match("/^[0-9]+\$/",$return_data[2],$song_int)){
                $list_data = $song_list[$song_int[0]-1];
                $this->send("[CQ:music,type=163,id=" . $list_data["id"] . "]");
}
        }
    }
    public function plugins_Netease_cloud()
    {
        $return = $this->MsgS(["msg" => "点歌", "data" => $this->msg]);
        if ($return != null) {
            $this->Netease_cloud_Api($return,$this->msg);
        } elseif ($this -> msg == "点歌") {
            $this->Rsend("请输入你要搜索的歌曲");
            $return_data = $this->context("点歌", $this->qun, $this->qq);
            $this->Netease_cloud_Api($return_data[2],$this->msg);
        }
    }
}
