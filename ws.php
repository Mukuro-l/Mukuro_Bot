<?php
namespace Mukuro;
//为解决某些问题，将不会采用异步服务器


use Swoole\Process\Manager;
use Swoole\Process\Pool;
use Swoole\Http\Request;
use Swoole\Http\Response;
use Swoole\WebSocket\CloseFrame;
use Swoole\Coroutine\Http\Server;
use function Swoole\Coroutine\run;

run(function () {
    
    $server = new Server('127.0.0.1', 6700, false);
    $server->handle('/websocket', function (Request $request, Response $ws) {
    $pm = new Manager();
    include_once "初始化.php";
    //握手成功
        $ws->upgrade();
        include_once "链接打开.php";
        while (true) {
        //循环接受数据
            $frame = $ws->recv();
            //如果为空则关闭链接
            if ($frame === '') {
                $ws->close();
                break;
                //如果链接失败
            } else if ($frame === false) {
                echo 'errorCode: ' . swoole_last_error() . "\n";
                $ws->close();
                break;
            } else {
            //如果是错误连接
                if ($frame->data == 'close' || get_class($frame) === CloseFrame::class) {
                    $ws->close();
                    break;
                }
                
                include "消息事件.php";
                
                //$ws->push("你好！ {$frame->data}!");
                //$ws->push("你怎么样 {$frame->data}?");
            }
        }
    });

    $server->handle('/', function (Request $request, Response $response) {
        $response->end(<<<HTML
    <h1>Swoole WebSocket Server</h1>
    <script>
var wsServer = 'ws://127.0.0.1:6700/websocket';
var websocket = new WebSocket(wsServer);
websocket.onopen = function (evt) {
    console.log("已连接 WebSocket 服务器");
    websocket.send('欢迎');
};

websocket.onclose = function (evt) {
    console.log("中断");
};

websocket.onmessage = function (evt) {
    console.log('从服务器检索数据：' + evt.data);
};

websocket.onerror = function (evt, e) {
    console.log('出现错误：' + evt.data);
};
</script>
HTML
        );
    });

    $server->start();
});

?>