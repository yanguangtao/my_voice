<?php

namespace app\index\controller;
use app\index\model\Follow;
use app\index\model\Order;
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
        $userModel = new UserModel();
        $user_id = UserModel::getUserId();
        if(!$user_id) {
            return msg("", 2, "登录过期");
        }
        $data = $userModel->where("id",$user_id)->find();
        if ($data){
            $data = objToArray($data);
            $this->getUserOtherInfo($data);
            return msg($data);
        }else{
            return msg(new \ArrayObject(), 1, "用户不存在");
        }


    }

    /**查看个人资料
     * @param $id
     * @return \think\response\Json
     */
    public function getUser($id){
        $user = model('User');
        $user_id = $user->getUserId();
        $data = $user->where("id", $id)->find();
        if ($data){
            $data = objToArray($data);
            $this->getUserOtherInfo($data);
            $data["is_follow"] = isFollow($user_id, $id);
            return msg($data);
        }else{
            return msg("", 1, "用户不存在");
        }
    }

    /**获取用户列表
     * @return \think\response\Json
     */
    public function getUsers(){
        require_once __DIR__."/../template_msg.php";
        $param = Request::instance()->param();
        $page = isset($param["page"]) ? $param["page"] : 1;
        $limit = isset($param["limit"]) ? $param["limit"] : 10;
        $model = new UserModel();
        $service_type_list = ["sleep", "joke", "ape"];
        $where = "";
        if(isset($param["service_type"]) && in_array($param["service_type"], $service_type_list)){
            $where = "service_type='' or find_in_set('{$param["service_type"]}', service_type)";
        }
        $data = $model->getByWhere($where, $page, $limit);
        $data["list"] = objToArray($data["list"]);
        foreach ($data["list"] as &$item){
           $this->getUserOtherInfo($item);
        }
        return msg($data);
    }
    function getUserOtherInfo(&$item){
        $follow = new Follow();
        $order = new Order();
        $item["tag"] = "魅力妖娆";
        $item["follow"] = $follow->getFollowCount($item["id"]);
        $item["followed"] = $follow->getFollowedCount($item["id"]);
        $order = $order->getUserStar($item["id"]);
        $item["star"] = $order["star"];
        $item["order_num"] = $order["order_num"];
        if (!$item['time_start']){
            $item['time_start'] = '00';
        }
        if (!$item['time_end']){
            $item['time_end'] = '00';
        }
        $item['service_time'] = "{$item['time_start']}:00~{$item['time_end']}:00";
    }

    public function put(){
        $param = Request::instance()->param();
        $user = new UserModel();
        $param["user_id"] = UserModel::getUserId();
        if(!$param["user_id"]){
            return msg("", 2, "登录过期");
        }
        if (isset($param['service_time']) && is_array($param['service_time'])){
            $time = explode('~', $param['service_time'][0]);
            $param['time_start'] = explode(':', $time[0])[0];
            $param['time_end'] = explode(':', $time[1])[0];
        }
        $result = $user->updateOrInsert($param);
        return $result ? msg("") : msg("", 1, "更新失败");
    }
    public function auth(){
        $param =Request::instance()->param();
        if (!isset($param["voice_url"]) or !isset($param["voice_type"])){
            return msg("", 1, "参数错误");
        }
        $model = new UserModel();
        $user_id =UserModel::getUserId();
        if(!$user_id){
            return msg("", 2, "登录过期");
        }
        $user = $model->where("id", $user_id)->find();
        if($user->auth_status == 1){
            return msg("", 1, "正在认证中");
        }
        if (isset($param['service_time']) && is_array($param['service_time'])){
            $time = explode('~', $param['service_time'][0]);
            $param['time_start'] = explode(':', $time[0])[0];
            $param['time_end'] = explode(':', $time[1])[0];
        }
        $param["auth_status"] = 1;
        $allow_field = ["img_url", "wechat", "phone", "avatarUrl", "price", "service_type",
            "time_start","time_end", "voice_url", "voice_type","auth_status", "age"];
        $model->allowField($allow_field)->save($param, ["id"=>$user_id]);
        return msg("");
    }
    public function getVoiceType(){
        $param = Request::instance()->param();
        if(isset($param["gender"])){
           $where["gender"] = $param["gender"];
        }
        $model = model('VoiceType');
        $voice_type = $model->where($where)->select();
        return msg($voice_type);
    }
}
