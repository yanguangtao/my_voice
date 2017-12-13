<?php

namespace app\index\controller;
use app\index\model\Follow;
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

    /**获取自己资料
     * @return \think\response\Json
     */
    public function getInfo(){
        $user = model('User');
        $result = LoginService::check();
        if($result){
            $data = $user->where("openId", $result["userinfo"]["openId"])->find();
            if ($data){
                $data = objToArray($data);
                $this->getUserOtherInfo($data);
                return msg($data);
            }else{
                return msg(new \ArrayObject(), 1, "用户不存在");
            }
        }else{
            return msg($result['error']);
        }

    }

    /**查看个人资料
     * @param $id
     * @return \think\response\Json
     */
    public function getUser($id){
        $user = model('User');
        $data = $user->where("id", $id)->find();
        if ($data){
            $data = objToArray($data);
            $this->getUserOtherInfo($data);
            return msg($data);
        }else{
            return msg("", 1, "用户不存在");
        }
    }

    /**获取用户列表
     * @return \think\response\Json
     */
    public function getUsers(){
        $param = Request::instance()->param();
        $page = isset($param["page"]) ? $param["page"] : 1;
        $limit = isset($param["limit"]) ? $param["limit"] : 10;
        $model = new UserModel();
        $data = $model->getByWhere('', $page, $limit);
        $data["list"] = objToArray($data["list"]);
        foreach ($data["list"] as &$item){
           $this->getUserOtherInfo($item);
        }
        return msg($data);
    }
    function getUserOtherInfo(&$item){
        $follow = new Follow();
        $item["tag"] = "魅力妖娆";
        $item["follow"] = $follow->getFollowCount($item["id"]);
        $item["followed"] = $follow->getFollowedCount($item["id"]);
        $item["star"] = 4.9;
        $item["order_num"] = 1000;
    }

    public function put(){
        $param = Request::instance()->param();
        $user = new UserModel();
        $result = $user->updateOrInsert($param);
        return $result ? msg() : msg("", 1, "更新失败");
    }
}
