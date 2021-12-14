<?php
//判断json类型
if (@$json_type=="菜单"){
@$send_json='{"app":"com.tencent.miniapp"&#44;"desc":""&#44;"view":"all"&#44;"ver":"1.0.0.89"&#44;"prompt":"岚嘉"&#44;"appID":""&#44;"sourceName":""&#44;"actionData":""&#44;"actionData_A":""&#44;"sourceUrl":""&#44;"meta":{"all":{"buttons":&#91;{"action":"http:\/\/www.qq.com"&#44;"name":"—————岚嘉————"}&#93;&#44;"jumpUrl":""&#44;"preview":""&#44;"summary":"'.$send_msg.'"&#44;"title":"岚嘉"}}&#44;"config":{"forward":true}&#44;"text":""&#44;"extraApps":&#91;&#93;&#44;"sourceAd":""&#44;"extra":""&#44;token:"'.$token.'"}';
//url转码
$send_json=urlencode($send_json);
//,  &#44;
//& &amp;
//[ &#91;
//] &#93;
}
?>