<?php
namespace Mukuro\Module;
use \Swoole\Timer;


	trait Api {
	    public $ws;
		public $database;
		public $qq;
		public $qun;
		public $msg;
		public $msg_id;
		public $msg_type;
		public $real_msg;
		public $real_id;
		public $msg_seq;
		public $request_type;
		public $notice_type;
		public $post_type;
		public $sub_type;
		public $nickname;
		public $role;
		public $honor_type;
		public $comment;
		public $operator_id;
		public $target_id;
		public $super_user;
		public $http_port;
		public $self_id;
		public function __construct($Data, $database, $BOT_Config,$ws) {
		$this -> ws = $ws;
		$this -> database = $database;
	
			if (is_array($Data)) {
				if (@$Data['meta_event_type'] != 'heartbeat') {
					@$this->msg = $Data['message'];
					@$this->real_msg = $Data['raw_message'];//真实消息
					@$this->msg_seq = $Data['message_seq'];//message_seq
					@$this->nickname=$Data['sender']['nickname'];//昵称
					@$this->qun = $Data['group_id'];//群号
					@$this->qq = $Data['user_id'];//qq号
					@$this->role=$Data['sender']['role'];//群职位：admin/member
					//api字段//
					//事件监控字段//
					@$this->notice_type = $Data['notice_type'];//事件
					@$this->post_type = $Data['post_type'];//获取上报类型
					@$this->sub_type = $Data['sub_type']; //获取提示类型
					@$this->request_type = $Data['request_type']; //获取请求类型
					@$this->comment = $Data['comment'];//获取群验证消息
					@$this->operator_id = $Data['operator_id'];//获取操作者qq
					@$this->honor_type = $Data['honor_type'];//获取荣耀类型
					@$this->msg_id = $Data['message_id'];//消息id
					@$this->real_id = $Data['real_id'];//获取真实信息id
					@$this->msg_type = $Data['message_type']; //消息类型
					@$this->target_id = $Data['target_id'];//被戳qq
					@$this->super_user = $BOT_Config['qhost'];//超级用户
					@$this->http_port = $BOT_Config['http_port'];//http服务器端口
					@$this->self_id = $Data['self_id'];//收到消息的机器人QQ
					if (isset($msg)) {
						$database->set($this->qq, ["Data" => $msg]);
						//$database->set($this->qun,
						
					}
				}
			}
		}
		public function send(string | array $set_msg = "Mukuro要告诉官人，官人没有让六儿发送任何消息哦•᷄ࡇ•᷅",int $Get_user=null)  {
			//如果类型为通知
            if ($this->post_type == "notice"){
                $url = ["action" => "send_group_msg", "params" => ["group_id" => $this->qun, "message" => $set_msg]];
                $submit_data = json_encode($url, JSON_UNESCAPED_UNICODE);
                echo "bot发送消息：[" . $set_msg . "]\n";
                $this->ws->push(intval(file_get_contents("service_id")),$submit_data);
            }
			//指定QQ号私聊
			if (!empty($Get_user)){
				$url = ["action" => "send_private_msg", "params" => ["user_id" => $Get_user, "message" => $set_msg]];
				$url = json_encode($url, JSON_UNESCAPED_UNICODE);
				echo "bot发送私聊消息：[" . $set_msg . "]\n";
				$this->ws->push(intval(file_get_contents("service_id")),$url);
			}
			//群聊
			if ($this->msg_type == "group" and empty($Get_user)) {
				$url = ["action" => "send_group_msg", "params" => ["group_id" => $this->qun, "message" => $set_msg]];
				$submit_data = json_encode($url, JSON_UNESCAPED_UNICODE);
				echo "bot发送消息：[" . $set_msg . "]\n";
				 $this->ws->push(intval(file_get_contents("service_id")),$submit_data);
			}
			//私聊
			if ($this->msg_type == "private" and empty($Get_user)) {
				$url = ["action" => "send_private_msg", "params" => ["user_id" => $this->qq, "message" => $set_msg]];
				$url = json_encode($url, JSON_UNESCAPED_UNICODE);
				echo "bot发送消息：[" . $set_msg . "]\n";
				$this->ws->push(intval(file_get_contents("service_id")),$url);
			}
			//自定义
			if (is_array($set_msg) == true) {
				if ($set_msg["S_type"] == "group") {
					$url = array("action" => "send_group_msg", "params" => array("group_id" => $set_msg["qun"], "message" => $set_msg["msg"]));
					$url = json_encode($url, JSON_UNESCAPED_UNICODE);
					echo "bot发送消息：[" . $set_msg["msg"] . "]\n";
					$this->ws->push(intval(file_get_contents("service_id")),$url);
				}
				if ($set_msg["S_type"] == "private") {
					$url = array("action" => "send_private_msg", "params" => array("user_id" => $set_msg["qq"], "message" => $set_msg["msg"]));
					$url = json_encode($url, JSON_UNESCAPED_UNICODE);
					echo "bot发送消息：[" . $set_msg["msg"] . "]\n";
					$this->ws->push(intval(file_get_contents("service_id")),$url);
				}
				//指定发送方式
				if ($set_msg["S_type"] == "私聊") {
					$url = array("action" => "send_private_msg", "params" => array("user_id" => $set_msg["qq"], "message" => $set_msg["msg"]));
					$url = json_encode($url, JSON_UNESCAPED_UNICODE);
					echo "bot发送消息：[" . $set_msg["msg"] . "]\n";
				$this->ws->push(intval(file_get_contents("service_id")),$url);
				}
				if ($set_msg["S_type"] == "群聊") {
					$url = array("action" => "send_group_msg", "params" => array("group_id" => $set_msg["qun"], "message" => $set_msg["msg"]));
					$url = json_encode($url, JSON_UNESCAPED_UNICODE);
					echo "bot发送消息：[" . $set_msg["msg"] . "]\n";
					$this->ws->push(intval(file_get_contents("service_id")),$url);
				}
			}
		}
        public function Rsend(int|string $Rmsg){
            $this->send('[CQ:reply,id=' .$this->msg_id.']'.$Rmsg);
        }
		public function MC(array $option, string $msg):
			bool {
				$quantity = count($option);
				for ($i = 0;$i < $quantity;$i++) {
					if ($msg == $option[$i]) {
						return true;
					}
				}
			}
			//无法实现，原因不明
			public function Repost_Msg(string $data="我是六儿"){
			$json = ["action" =>"send_group_forward_msg", 
			"params" =>["group_id" =>$this->qun,
			"message"=>[
			["type"=>"node",
			"data"=>["name"=>"Mukuro",
			"uin"=>$this->qq,
			"content"=>[["type"=>"text",
			"data"=>$data
			],
			],
			],
			]
			]
			]
			];
			$json = json_encode($json);
			$this->ws->push(intval(file_get_contents("service_id")),$json);
			echo "自定义转发消息\n";
			
			}
			
			//即为Message search
			public function MsgS(array $MsgS_Data) {
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
				public function OCR(string $return):
					string {
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
$this->send(file_get_contents("./Ocr/" . $time . "ocr.txt"));
				}
				//框架文件管理，当只给了文件名时将会尝试返回文件数据
				public function Mukuro_File(string|int $file_name,mixed $data=null){
				$file_path = "./Data/Cache/";
				
				if (!is_dir($file_path)){
				mkdir($file_path);
				}
				//获取文件名后缀
				$file_name_array=explode('.',$file_name);
				//预定的文件类型
				$Scheduled_type=["txt","jpg","png","jpeg","gif","mp3","mp4","amr","ma4"];
				/*foreach($Scheduled_type as $return){
				if (){
				
				}
				}
				if (empty($data)){
				if (!is_file()){
				echo "[notification]来自Mukuro_File的警告：未找到此文件，或者未给定任何数据。\n";
				$this->send("[notification]来自Mukuro_File的警告：未找到此文件，或者未给定任何数据。");
				}
				}
				*/
				
				
				
				
				}
				private function CQ_filt(string $CQ_code){
$str = trim($str);
$str = explode("[CQ:",$str);
$str_type1 = explode(',',$str[1]);
$str1 = explode(']',$str_type1[1]);
$str_type2 = explode(',',$str[2]);
$str2 = explode(']',$str_type2[1]);
if ($str1[0] == "image"){
echo "image类型\n";
}
if ($str2[0] == "at"){
echo "at类型\n";
}
print_r($str_type1);
print_r($str_type2);
				}
				    //上下文 $msg即为你想要定位的消息，函数会一直根据这条消息来获取上下文
				    public function context(string | int $msg,string | int $send_msg=null) {
						if (isset($send_msg)){
						$this -> Rsend($send_msg);
						}
						$url = "http://127.0.0.1:".$this -> http_port."/get_group_msg_history?message_seq=&group_id=".$this -> qun;
						//获取到的历史记录
						$json = json_decode(file_get_contents($url),true);
						//大概有19
						$sum = count($json["data"]["messages"]);
						//结果数组
						$result = [];
						//结果上下文
						$context = [];
                        //设置一个定时器，超时退出循环
                        $Timer = date("His");
						do {
							unset($result);
							unset($context);
                            
							$result = [];
							$context = [];
							$json = json_decode(file_get_contents($url),true);
						for ($i=0;$i<$sum;$i++){
							//当找到指定QQ号的聊天记录时
							if ($json["data"]["messages"][$i]["user_id"]==$this->qq){
								//填入
								$result[] = $json["data"]["messages"][$i]["message"];
								}
								}
								$sm = 0;
									foreach ($result as $data){
										//遍历结果数组
										$sm++;
										/*判断是否为需要定位的消息
										if (isset($this -> msg )){
											if ($data == $msg ){
												//跳出循环，则$sm-1即为消息所在位置
												continue;
												}
												}
												*/
												}
								
										$result_sum = count($result);
										//需要大于0，不然返回上文
										
													$context[] = $result[$sm-3];
													$context[] = $result[$sm-2];
													$context[] = $result[$sm-1];
													if ($context[2] !== $msg && $context[1] !== null){
													return $context;
													}
                            
            
                                                    if ((date("His")-$Timer)>15 ){
                                                        echo "超时\n";
                                                        $this->send("超时已退出");
                                                        return;
                                                    }
													}while ($context[2]==$msg);
										
	}
					//即为Get friends
					public function GF():string {
						if (is_file('./Data/Text/GF.txt')){
							unlink('./Data/Text/GF.txt');
						}
							$url = "http://127.0.0.1:" . $this->http_port . "/get_friend_list";
							$Data = json_decode(file_get_contents($url), true);
							for ($i = 0;$i < count($Data["data"]);$i++) {
								$list = "ID：" . $i . "\r\nQQ：" . $Data["data"][$i]["user_id"] . "\r\n昵称：" . $Data["data"][$i]["nickname"] . "\r\n备注：" . $Data["data"][$i]["remark"] . "\r\n\r\n";
								file_put_contents("./Data/Text/GF.txt", $list, FILE_APPEND);
							}
							return Text_Images("./Data/Text/GF.txt", $this->qq);
						}
						public function DF(int $user_id):string {
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
						public function ban(int $qq, int $time = 600, array $array = []) {
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
						public function UD() {
						}
						public function __destruct() {
						}
					}
				//}

//namespace Mukuro\Module\Run;
if (!class_exists("CQ")) {
	#[Attribute]
	trait CQ {
		
	}
        //获取指令通过Api判断，然后实例化插件交给Api处理
	function CQ_get(){
		
	}
	}
?>
