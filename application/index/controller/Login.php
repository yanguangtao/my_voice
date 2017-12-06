<?php

namespace app\index\controller;
use app\index\model\User;
use QCloud_WeApp_SDK\Auth\LoginService as LoginService;
use QCloud_WeApp_SDK\Constants as Constants;
class Login extends Base
{
    public function index(){
        $result = LoginService::login();
        if ($result['loginState'] === Constants::S_AUTH) {
            $info = $result["userinfo"];
            $model = new User();
            $user = $model->where("openId", $info["openId"])->find();
            if(!$user) {
                $user->allowField(true)->save($info);
            }
            return msg($user);
        } else {
            return msg(array(), 1, $result['error']);
        }
    }
}
