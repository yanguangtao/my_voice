<?php

namespace app\index\controller;
use app\index\model\User;
use QCloud_WeApp_SDK\Auth\LoginService as LoginService;
use QCloud_WeApp_SDK\Constants as Constants;
use app\index\RedisTool as RedisTool;
use think\Log as log;
class Login extends Base
{
    public function index(){
        $result = LoginService::login();
        if ($result['loginState'] === Constants::S_AUTH) {
            log::info($result["userinfo"]);
            $info = objToArray($result["userinfo"]["userinfo"]);
            $info["create_time"] = date('Y-m-d H:i:s');
            $model = new User($info);
            $user = $model->where("openId", $info["openId"])->find();
            if(!$user) {
                $model->allowField(true)->save();
            }
            return json([
                'code' => 0,
                'data' => $result['userinfo'],
            ]);
        } else {
            return msg("", 1, $result['error']);
        }
    }
}
