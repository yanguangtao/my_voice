<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------
use think\Route;
Route::get([
    'login$'=> 'Login/index',
    'user$' => 'User/getUsers',
    'user/info$' => 'User/getInfo',
    'user/:id$' => ['User/getUser',[],['order_sn'=>'\d+']],
    'user/voice_type$' => 'User/getVoiceType',
    'order$' => 'Order/get',
    'order/:order_sn' => ['Order/getOrder',[],['order_sn'=>'\d+']],
    'follow$' => 'Follow/get',
    'chat/history/:user_id$'=>'Chat/history'

]);
Route::post([
    'user/auth$' => 'User/auth',
    'order$' => 'Order/post',
    'order/test$' => 'Order/unifiedOrder',
    'order/:order_id/comment$' => 'Comment/post',
    'follow$' => 'Follow/action',
    'chat/chat$' => 'Chat/chat',
    'chat/bind$' => 'Chat/bind'
]);
Route::put([
    'user$' => 'User/put',
    'order/:order_sn$' => ['Order/action',[],['order_sn'=>'\d+']],
]);

