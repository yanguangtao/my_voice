<?php

namespace app\index\controller;
use think\Request;
use \app\index\model\User as UserModel;
use QCloud_WeApp_SDK\Auth\LoginService as LoginService;
use think\Log as log;

class User extends Base
{
    public function index(){
         $result = LoginService::check();
         if($result['loginState'] === 1) {
             return json([
                 'code' => 0,
                 'data' => $result['userinfo'],
             ]);

         }else{
             return json([
                 'code' => -1,
                 'data' => '',
                 'msg' => '不要瞎搞'
             ]);
         }
    }
    public function get(){
        $user = model('User');
        $result = LoginService::check();
        $data = $user->where("openId", $result["userinfo"]["openId"])->find();
        if ($data){
            return msg($data);
        }else{
            return msg(new \ArrayObject(), 1, "用户不存在");
        }
    }
    public function getUser($id){
        $user = model('User');
        $data = $user->where("id", $id)->find();
        if ($data){
            return msg($data);
        }else{
            return msg(array(), 1, "用户不存在");
        }
    }
    public function put(){
        $param = Request::instance()->param();
        $user = new UserModel();
        $result = $user->updateOrInsert($param);
        return $result ? msg() : msg(array(), 1, "更新失败");
    }
}
