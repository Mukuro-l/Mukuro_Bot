<?php
use Mukuro\Module\Api;

/**
 *@name 网易云点歌
 *@doc 一个网易云点歌插件
 *@comment 点歌
 *@return image
 */
class Netease_cloud {
	use Api;
	public function Netease_cloud_Api($return){
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
					$list = ($i + 1) . ".<" . $song_list[$i]['name'] . ">--" . $song_list[$i]['artists'][0]['name'] . "\r\n";
					file_put_contents("./Data/Text/".$this->qq . "song_list.txt", $list, FILE_APPEND);
				}
				Text_Images("./Data/Text/".$this->qq . "song_list.txt", $this->qq);
				$this->send("[CQ:image,file=" . $this->qq . ".jpg]");
				unlink("./Data/Text/".$this->qq . "song_list.txt");
				}
	}
	function plugins_Netease_cloud() {
		$return = $this->MsgS(["msg" => "点歌", "data" => $this->msg]);
		if ($return != null) {
		$this->Netease_cloud_Api($return);
		}else if ($this -> msg == "点歌") {
		$this->Rsend("请输入你要搜索的歌曲");
		$return_data = $this->context("点歌");
		$this->Netease_cloud_Api($return_data[2]);
		
		}
		
	}
}
?>
