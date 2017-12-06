<?php

namespace app\index\controller;
use app\index\model\User;
use QCloud_WeApp_SDK\Auth\LoginService as LoginService;
use QCloud_WeApp_SDK\Constants as Constants;
use think\Log as log;
class Login extends Base
{
    public function index(){
        $result = LoginService::login();
        if ($result['loginState'] === Constants::S_AUTH) {
            log::error($result["userinfo"]);


            $info = json_encode($result["userinfo"]["userinfo"]);
            $model = new User();
            $user = $model->where("openId", $info["openId"])->find();
            if(!$user) {
                $user->allowField(true)->save($info);
            }
            return json([
                'code' => 0,
                'data' => $result['userinfo'],

            ]);
        } else {
            return msg(array(), 1, $result['error']);
        }
    }
}
