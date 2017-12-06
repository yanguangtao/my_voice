<?php

namespace app\index\controller;

//use think\Controller;
use QCloud_WeApp_SDK\Auth\LoginService as LoginService;
use app\index\model\ProviderModel;

class Provider extends Base
{
    public function index()
    {
        if (request()->isPost()) {
            $result = LoginService::check();

            if ($result['code'] !== 0) { // check failed
                return json($result);
            }

            // 接收参数
            $param = input('param.');

            $provider = new ProviderModel();
            $flag = $provider->insert($param);

            return json(msg($flag['code'], $flag['data'], $flag['msg']));









        }
    }
}
