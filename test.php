<?php
/**
 * Created by PhpStorm.
 * User: tgy
 * Date: 2017/12/26
 * Time: 22:35
 */
use Workerman\Worker;
require_once './application/index/webim/Server.php';
require_once __DIR__ . '/workerman/Autoloader.php';

// 创建一个Worker监听2345端口，使用http协议通讯




$ws_worker = new Worker("websocket://0.0.0.0:2000");

// 启动4个进程对外提供服务
$ws_worker->count = 4;

// 当收到客户端发来的数据后返回hello $data给客户端
$ws_worker->onMessage = function($connection, $data)
{
    $resMsg = array(
        'cmd' => 'login',
        'fd' => $connection->id,
        'name' => 'test',
        'avatar' => 'test',
    );
    print_r($resMsg);
    $connection->send(json_encode($resMsg));
//    (new \WebIM\Server($connection))->cmd_login($connection, $connection->id, 'haha');
};

// 运行worker
Worker::runAll();