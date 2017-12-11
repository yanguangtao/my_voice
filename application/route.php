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
    'login'=> 'Login/index',
    'user' => 'User/getUsers',
    'user/:id$' => ['User/getUser',[],['id'=>'\d+']],
    'order' => 'Order/get',
    'order/:order_sn' => ['Order/getOrder',[],['order_sn'=>'\d+']],
]);
Route::post([
   'order' => 'Order/post',
    'order/test' => 'Order/unifiedOrder'
]);
Route::put([
    'user' => 'User/put',
    'order/:order_sn' => ['Order/action',[],['order_sn'=>'\d+']],
]);

