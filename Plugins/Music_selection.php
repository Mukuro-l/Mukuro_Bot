<?php
use Mukuro\Module\Api;

/**
 *@name 选歌
 *@doc 一个选歌插件，发送数字选歌
 *@comment 数字
 *@return image
 */
class Music_selection {
	use Api;
	function plugins_Music_selection() {
		if (preg_match("/^[0-9]+$/u", $this->msg, $return_list)) {
                    $data = $this->context('点歌');
                    if (strpos("点歌",$data[0])!==false){
					$url = "http://cloud-music.pl-fe.cn/search?keywords=" . urlencode($data[1]);
					$song_data = json_decode(file_get_contents($url), true);
					$result = $song_data['result'];
					$song_list = $result['songs']; //歌曲列表
					$list_data = $song_list[$return_list[0] - 1]; //选歌
					$song_id = $list_data["id"];
					$this->send("[CQ:music,type=163,id=" . $song_id . "]");
					$data = $this->context('语音');
					if ($data[0]=="语音"){
					$this->send("正在转换语音……");
					$this->send("[CQ:record,file=https://music.163.com/song/media/outer/url?id=".$song_id.".mp3]");
					
				}
				}
				}
			}
		}
?>