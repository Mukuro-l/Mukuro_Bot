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
	function plugins_Netease_cloud() {
		$return = $this->MsgS(["msg" => "点歌", "data" => $this->msg]);
		if ($return != null) {
			$url = "http://43.154.119.191/api/key.php?keywords=" . urlencode($return);
			$song_data = json_decode(file_get_contents($url), true);
			$result = $song_data['result'];
			$song_list = $result['songs']; //歌曲列表
			$list_data = $song_list[0]; //选歌
			$song_id = $list_data["id"];
			if ($song_id == null) {
				return $this->send("获取失败");
			} else {
				file_put_contents("./Data/Text/".$this->qq . "song.txt", "点歌#" . $return);
				for ($i = 0;$i < 20;$i++) {
					$list = ($i + 1) . ".<" . $song_list[$i]['name'] . ">--" . $song_list[$i]['artists'][0]['name'] . "\r\n";
					file_put_contents("./Data/Text/".$this->qq . "song_list.txt", $list, FILE_APPEND);
				}
				file_put_contents("./Data/Text/".$this->qq . "song_list.txt", $list . "PS：10秒内有效", FILE_APPEND);
			
				$qq = $this->qq;
				Swoole\Timer::after(10000, function () use ($qq) {
					if (file_exists("./Data/Text/".$qq . "song_list.txt") == true) {
						unlink("./Data/Text/".$qq . "song_list.txt");
					}
				});
				Text_Images("./Data/Text/".$this->qq . "song_list.txt", $qq);
				return $this->send("[CQ:image,file=" . $this->qq . ".jpg]");
			}
		}
	}
}
?>
