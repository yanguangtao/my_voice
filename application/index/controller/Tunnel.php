<?php

namespace app\index\controller;

use QCloud_WeApp_SDK\Tunnel\TunnelService as TunnelService;
use QCloud_WeApp_SDK\Auth\LoginService as LoginService;
use app\index\model\ChatModel;


class Tunnel extends Base
{
    public function index()
    {
         if (request()->isGet()) {
             $result = LoginService::check();

             $handler = new ChatModel($result['userinfo']);
             $connectUrl = TunnelService::handle($handler, array('checkLogin' => TRUE));
             return json([
                 'statusCode' => 200,
                 'data' => [
                     'data' => ['connectUrl' => $connectUrl],
                 ]
             ]);

         }
    }
}
