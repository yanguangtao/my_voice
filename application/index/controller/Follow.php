<?php
/**
 * Created by PhpStorm.
 * User: tgy
 * Date: 2017/12/11
 * Time: 23:30
 */

namespace app\index\controller;
use app\index\model\User;
use QCloud_WeApp_SDK\Constants;
use think\Db;
use think\Exception;
use think\Request;
use think\Log as log;
use \app\index\model\Follow as FollowModel;
use think\session\driver\Redis;

class Follow extends Base{
    public function get(){
        $user_id = User::getUserId();
        if(!$user_id){
            return msg("", 2, "登录过期");
        }
        $param = Request::instance()->param();
        $type = isset($param["type"]) ? $param["type"] : "1";
        $model = new FollowModel();
        $where = array("user_id"=>$user_id);
        if($type == "0"){
            $where = array("follow_id"=>$user_id);
        }
        $follow = $model->getByWhere($where);
        $follow = objToArray($follow);
        $userModel = new User();
        $result = [];
        foreach($follow["list"] as &$item){
            $id = $type == "0" ? $item["user_id"] : $item["follow_id"];
            $user = $userModel->getUserSampleInfo($id);
            $item = array_merge($user, $item);
            $result[] = $item;
        }
        $follow["list"] = $result;
        return msg($follow);
    }

    public function action(){
        $user_id = User::getUserId();
        if(!$user_id){
            return msg("", 2, "登录过期");
        }
        $param = Request::instance()->param();
        log::error($param);
        if(!isset($param["follow_id"])){
            return msg("", 1, "参数不正确");
        }
        $model = new FollowModel();
        $follow = $model->getOneByWhere(array("user_id"=>$user_id, "follow_id"=>$param["follow_id"]));
        switch($param["action"]){
            case "0": //取消关注
                if(!$follow){
                    return msg("", 1, "未关注该用户");
                }
               $follow->delete();
                break;
            case "1": //关注
                if($follow){
                    return msg("", 1, "已关注");
                }
                $param["create_time"] = date("Y-m-d H:i:s");
                $param["user_id"] = $user_id;
                $model->allowField(true)->save($param);
                break;
            default:
                return msg("", 1, "参数不正确");
        }
        return msg("");
    }
}