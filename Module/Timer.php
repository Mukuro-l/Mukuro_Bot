<?php
	//定时器逻辑
	if ($BOT_Config["_tick"] == true) {
		if (file_exists("tick_config.json") == true) {
			//该变量返回值为定时器ID
			@$the_tick = Swoole\Timer::tick(1000, function () {

				$tick_data = json_decode(file_get_contents("tick_config.json"), true);
				if (@count($tick_data[date("His")]) > 0) {
					for ($i = 0;$i < @count($tick_data[date("His")]);$i++) {
						if (@$tick_data[date("His")] != null) {
							$time = date("His");
							Coroutine::create(function () use ($time) {
							$time = $time - 5;
						$tick_data = json_decode(file_get_contents("tick_config.json"), true);
						for ($i = 0;$i < count($tick_data[$time]);$i++) {
							if ($tick_data[$time][$i]["First_time"] < 1) {
								if ($tick_data[$time] != null) {
									if ($tick_data[$time][$i]["tick"] != 0) {
										file_get_contents("http://127.0.0.1:" . $tick_data[$time][$i]["http_port"] . "/send_group_msg?group_id=" . $tick_data[$time][$i]["qun"] . "&message=[" . urlencode($tick_data[$time][$i]["msg"]) . "]");
										$tick_data[$time][$i]["tick"] = $tick_data[$time][$i]["tick"] - 1;
										$tick_data[$time][$i]["First_time"] = $tick_data[$time][$i]["First_time"] + 1;
										$data = json_encode($tick_data, JSON_UNESCAPED_UNICODE);
										file_put_contents("tick_config.json", $data);
									}
								}
							}
						}
					});
				}
			}
		}
	});
	}
	}
?>