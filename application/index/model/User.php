<?php
/**
 * Created by PhpStorm.
 * User: tgy
 * Date: 2017/11/30
 * Time: 22:43
 */
namespace app\index\model;
use app\index\RedisTool;
use think\Model;
use think\Log as log;


class User extends BaseModel{
    protected $pk = 'id';
    public  $test = "";
    protected $readonly = ['openId','id'];
    function updateOrInsert($data){
        $model =model('User');
        $user = $model->where("id", $data["user_id"])->find();
        if($user){
            $allow_field = ["nickName", "img_url", "wechat", "phone", "city", "price","time_start","time_end"];
            $model->allowField($allow_field)->save($data, ["id"=>$data["user_id"]]);
            return $user;
        }else{
            $user = new User($data);
            $result = $user->allowField(true)->save();
            return $result;
        }
    }

    function getUserId($openId=''){
        return 2;
        $redis = new RedisTool();
        $key = getUserIdKeyByOpenId($openId);
        $user_id = $redis->get($key, 0);
        if($user_id){
            return $user_id;
        }
        $user = $this->where("openId", $openId)->find();
        if($user){
            $user_id = $user->id;
            $redis->set($key, $user_id);
        }
        return $user_id;
    }
    
}