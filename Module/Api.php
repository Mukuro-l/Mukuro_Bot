<?php
namespace Mukuro\Module;

if (!class_exists("Api")) {
	trait Api {
		public $qq;
		public $qun;
		public $msg;
		public $msg_id;
		public $msg_type;
		public $real_msg;
		public $request_type;
		public $notice_type;
		public $post_type;
		public $sub_type;
		
		
		
		public function __construct($Data,$database,$BOT_Config) {
			if (is_array($Data)) {
				if (@$Data['meta_event_type'] != 'heartbeat') {
					 
					$this->msg = $Data['message'];
					@$this->real_msg = $Data['raw_message'] ? : $_GET['real_msg']; //真实消息
					//@$qqinformation=$Data['sender'];
					//@$qqnick=$qqinformation['nickname']?:$_GET['qqnick'];//昵称
					@$this->qun = $Data['group_id'] ? : $_GET['qun']; //群号
					@$this->qq = $Data['user_id'] ? : $_GET['qq']; //qq号
					//@$qqadmin_get=$qqinformation['role']?:$_GET['qqadmin_get'];//群职位：admin/member
					//@$get_qqsex=$qqinformation['sex']?:$_GET['get_qqsex'];///male为男，female为女，unknown未知
					//api字段//
					//事件监控字段//
					@$this->notice_type = $Data['notice_type'] ? : $_GET['notice_type']; //事件
					@$this->post_type = $Data['post_type'] ? : $_GET['post_type']; //获取上报类型
					@$this->sub_type = $Data['sub_type'] ? : $_GET['sub_type']; //获取提示类型
					@$this->request_type = $Data['request_type'] ? : $_GET['request_type']; //获取请求类型
					//@$get_yanz_qun=$Data['comment']?:$_GET['get_yanz_qun'];//获取群验证消息
					//@$get_cao_qun=$Data['operator_id']?:$_GET['get_cao_qun'];//获取操作者qq
					//@$qunry=$Data['honor_type']?:$_GET['qunry'];//获取荣耀类型
					//@$cheqq=$Data['operator_id']?:$_GET['cheqq'];//撤回操作qq
					@$this->msg_id = $Data['message_id'] ? : $_GET['msgid']; //消息id
					//@$real_msgid=$Data['real_id']?:$_GET['real_msgid'];//获取真实信息id
					@$this->msg_type = $Data['message_type'] ? : $_GET['msg_type']; //消息类型
					//@$chuo_userid=$Data['target_id']?:$_GET['chuo_userid'];//被戳qq
					if (isset($msg)) {
						$database->set($this->qq, ["Data" => $msg]);
						//$database->set($this->qun, 
					}
				}
			}
		}
		
		
		
		public function send(string|array $set_msg="Mukuro要告诉官人，官人没有让六儿发送任何消息哦•᷄ࡇ•᷅" ) {
		    if ($this->msg_type == "group") {
		$url = ["action" => "send_group_msg", "params" => ["group_id" => $this->qun, "message" => $set_msg]];
						$submit_data = json_encode($url, JSON_UNESCAPED_UNICODE);
						echo "bot发送消息：[" . $set_msg . "]\n";
					  return $submit_data;
		}
		if ($this->msg_type == "private") {
		$url = ["action" => "send_private_msg", "params" => ["user_id" => $this->qq, "message" => $set_msg]];
						$url = json_encode($url, JSON_UNESCAPED_UNICODE);
						echo "bot发送消息：[" . $set_msg . "]\n";
						return $url;
		}
		
				if (is_array($set_msg) == true) {
					if ($set_msg["S_type"] == "group") {
						$url = array("action" => "send_group_msg", "params" => array("group_id" => $set_msg["qun"], "message" => $set_msg["msg"]));
						$url = json_encode($url, JSON_UNESCAPED_UNICODE);
						echo "bot发送消息：[" . $set_msg["msg"] . "]\n";
						return $url;
					}
					if ($set_msg["S_type"] == "private") {
						$url = array("action" => "send_private_msg", "params" => array("user_id" => $set_msg["qq"], "message" => $set_msg["msg"]));
						$url = json_encode($url, JSON_UNESCAPED_UNICODE);
						echo "bot发送消息：[" . $set_msg["msg"] . "]\n";
						return $url;
					}
					//指定发送方式
					if ($set_msg["S_type"] == "私聊") {
						$url = array("action" => "send_private_msg", "params" => array("user_id" => $set_msg["qq"], "message" => $set_msg["msg"]));
						$url = json_encode($url, JSON_UNESCAPED_UNICODE);
						echo "bot发送消息：[" . $set_msg["msg"] . "]\n";
						return $url;
					}
					if ($set_msg["S_type"] == "群聊") {
						$url = array("action" => "send_group_msg", "params" => array("group_id" => $set_msg["qun"], "message" => $set_msg["msg"]));
						$url = json_encode($url, JSON_UNESCAPED_UNICODE);
						echo "bot发送消息：[" . $set_msg["msg"] . "]\n";
						return $url;
					}
					if ($set_msg["S_type"] == "转发") {
						$url = array("action" => "send_group_forward_msg", "params" => array("group_id" => $set_msg["qun"], "message" => $set_msg["msg"]));
						$url = json_encode($url, JSON_UNESCAPED_UNICODE);
						echo "bot转发消息：[" . $set_msg["msg"] . "]\n";
						return $url;
					}
			}
		}
		public function MC(array $option, string $msg):bool {
				
					$quantity = count($option);
					for ($i = 0;$i < $quantity;$i++) {
						if ($msg == $option[$i]) {
							return true;
						}
					}
			
		}
		//即为Message search
		public function MsgS(array $MsgS_Data):string | bool {
					$msg = $MsgS_Data["msg"];
					if (strstr($MsgS_Data["data"], $msg) == true) {
						if (preg_match("/^$msg ?(.*)\$/", $MsgS_Data["data"], $return)) {
							return $return[1];
						} else {
							return null;
						}
					} else {
						return false;
					}
				
			
		}
		//光学字符识别OCR 直接传入CQ码即可
		public function OCR(string $return):string {
				$file = explode("[CQ:image,file=", $return);
				if (strstr($file[1], "subType") == true) {
					$data = explode(',', $file[1]);
				} else {
					$data = explode("]", $file[1]);
				}
				$BOT_Config = json_decode(file_get_contents("config.json"), true);
				$url = "http://127.0.0.1:" . $BOT_Config["http_port"] . "/ocr_image?image=" . $data[0];
				echo $data[0] . "\n";
				$Data = json_decode(file_get_contents($url), true);
				$time = rand(576588, 16050800);
				for ($i = 0;$i < count($Data["data"]["texts"]);$i++) {
					$list = $Data["data"]["texts"][$i]["text"] . "\r\n";
					file_put_contents("./Ocr/" . $time . "ocr.txt", $list, FILE_APPEND);
				}
				return file_get_contents("./Ocr/" . $time . "ocr.txt");
			
		}
		//即为Get friends
		public function GF():string {
			$BOT_Config = json_decode(file_get_contents("config.json"), true);
			$url = "http://127.0.0.1:" . $BOT_Config["http_port"] . "/get_friend_list";
			$Data = json_decode(file_get_contents($url), true);
			for ($i = 0;$i < count($Data["data"]);$i++) {
				$list = "ID：" . $i . "\r\nQQ：" . $Data["data"][$i]["user_id"] . "\r\n昵称：" . $Data["data"][$i]["nickname"] . "\r\n备注：" . $Data["data"][$i]["remark"] . "\r\n\r\n";
				file_put_contents("GF.txt", $list, FILE_APPEND);
			}
			return file_get_contents("GF.txt");
		}
		
		public function DF($user_id) {
			$BOT_Config = json_decode(file_get_contents("config.json"), true);
			$url = "http://127.0.0.1:" . $BOT_Config["http_port"] . "/delete_friend?friend_id=" . $user_id;
			file_get_contents($url);
			return "已删除好友" . $user_id;
		}
		public function real_ip($type = 0) {
			$ip = $_SERVER['REMOTE_ADDR'];
			if ($type <= 0 && isset($_SERVER['HTTP_X_FORWARDED_FOR']) && preg_match_all('#\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}#s', $_SERVER['HTTP_X_FORWARDED_FOR'], $matches)) {
				foreach ($matches[0] as $xip) {
					if (filter_var($xip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4 | FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE)) {
						$ip = $xip;
						break;
					}
				}
			} elseif ($type <= 0 && isset($_SERVER['HTTP_CLIENT_IP']) && filter_var($_SERVER['HTTP_CLIENT_IP'], FILTER_VALIDATE_IP, FILTER_FLAG_IPV4 | FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE)) {
				$ip = $_SERVER['HTTP_CLIENT_IP'];
			} elseif ($type <= 1 && isset($_SERVER['HTTP_CF_CONNECTING_IP']) && filter_var($_SERVER['HTTP_CF_CONNECTING_IP'], FILTER_VALIDATE_IP, FILTER_FLAG_IPV4 | FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE)) {
				$ip = $_SERVER['HTTP_CF_CONNECTING_IP'];
			} elseif ($type <= 1 && isset($_SERVER['HTTP_X_REAL_IP']) && filter_var($_SERVER['HTTP_X_REAL_IP'], FILTER_VALIDATE_IP, FILTER_FLAG_IPV4 | FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE)) {
				$ip = $_SERVER['HTTP_X_REAL_IP'];
			}
			return $ip;
		}
		//curl
		public function Curl($url, $paras = []) {
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
			curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
			//curl_setopt($curl, CURLOPT_HTTPHEADER, array('X-FORWARDED-FOR:'.real_ip(), 'CLIENT-IP:'.real_ip()));
			if (isset($paras['Header'])) {
				$Header = $paras['Header'];
			} else {
				$Header[] = "Accept:*/*";
				$Header[] = "Accept-Encoding:gzip,deflate,sdch";
				$Header[] = "Accept-Language:zh-CN,zh;q=0.8";
				$Header[] = "Connection:close";
				$Header[] = "X-FORWARDED-FOR:" . $this->real_ip();
			}
			curl_setopt($ch, CURLOPT_HTTPHEADER, $Header);
			if (isset($paras['ctime'])) { // 连接超时
				curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $paras['ctime']);
			} else {
				curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
			}
			if (isset($paras['rtime'])) { // 读取超时
				curl_setopt($ch, CURLOPT_TIMEOUT, $paras['rtime']);
			}
			if (isset($paras['post'])) {
				curl_setopt($ch, CURLOPT_POST, 1);
				curl_setopt($ch, CURLOPT_POSTFIELDS, $paras['post']);
			}
			if (isset($paras['header'])) {
				curl_setopt($ch, CURLOPT_HEADER, true);
			}
			if (isset($paras['cookie'])) {
				curl_setopt($ch, CURLOPT_COOKIE, $paras['cookie']);
			}
			if (isset($paras['refer'])) {
				if ($paras['refer'] == 1) {
					curl_setopt($ch, CURLOPT_REFERER, 'http://m.qzone.com/infocenter?g_f=');
				} else {
					curl_setopt($ch, CURLOPT_REFERER, $paras['refer']);
				}
			}
			if (isset($paras['ua'])) {
				curl_setopt($ch, CURLOPT_USERAGENT, $paras['ua']);
			} else {
				curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/65.0.3325.181 Safari/537.36");
			}
			if (isset($paras['nobody'])) {
				curl_setopt($ch, CURLOPT_NOBODY, 1);
			}
			//curl_setopt($ch, CURLOPT_ENCODING, "gzip");
			curl_setopt($ch, CURLOPT_ENCODING, 'gzip,deflate');
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			if (isset($paras['GetCookie'])) {
				curl_setopt($ch, CURLOPT_HEADER, 1);
				$result = curl_exec($ch);
				preg_match_all("/Set-Cookie: (.*?);/m", $result, $matches);
				$headerSize = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
				$header = substr($result, 0, $headerSize); //状态码
				$body = substr($result, $headerSize);
				$ret = array("cookie" => $matches, "body" => $body, "Header" => $header, 'code' => curl_getinfo($ch, CURLINFO_HTTP_CODE),);
				curl_close($ch);
				return $ret;
			}
			$ret = curl_exec($ch);
			if (isset($paras['loadurl'])) {
				$Headers = curl_getinfo($ch);
				if (isset($Headers['redirect_url'])) {
					$ret = $Headers['redirect_url'];
				} else {
					$ret = false;
				}
			}
			curl_close($ch);
			return $ret;
		}
		//Super user group
	    public function ban($qq,$time=600,$array=[]) {
	    if (isset($qq)) {
	    $url = array("action" => "set_group_ban", "params" => array("group_id" => $this->qun, "user_id" => $qq, "duration" => $time));
	    $url = json_encode($url, JSON_UNESCAPED_UNICODE);
	    return $url;
	    }
		if (isset($array) == true) {
			if (is_array($array) == true) {
				$BOT_Config = json_decode(file_get_contents("config.json"), true);
				if ($BOT_Config["qhost"] == $array["qq"]) {
					$url = "http://127.0.0.1:" . $BOT_Config["http_port"] . "/set_group_ban?group_id=" . $array["qun"] . "&user_id=" . $array["ban_user"] . "&duration=" . $array["time"];
					file_get_contents($url);
					return "OK";
				}
			}
		}
	}
	
	    public function UD(){
	    
	    
	    }
		public function __destruct() {
		}
	}
}

if (!class_exists("Redis_set")) {

trait Redis_{
public function Redis_set(array $array,bool $GET=false){
if (isset($array)) {

	if (!empty($array)) {
		if (is_array($array)) {
		if ($GET == false) {
			$redis = new Redis();
			$redis->connect('127.0.0.1', 6379);
			echo "已连接Redis数据库\n";
			//删除
			//$redis->del("test");
			
			/*$redis_data=[
			//设置key
			"name"=>"数据",
			//设置数据
			"data"=>123456,
			//QQ
			"qq"=>
			];
			*/
			$array2 = ["data", "qq"];
			//设置数组
			$redis->hmset($redis_data["name"], $redis_data);
			return true;
		}
	  }
	}
	if ($GET == true) {
	$redis = new Redis();
    $redis->connect('127.0.0.1', 6379);
    $array2 = ["data", "qq"];
    return $redis->hmget($array["name"], $array2);
	}
}
}

}
}

?>
