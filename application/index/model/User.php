<?php
/**
 * Created by PhpStorm.
 * User: tgy
 * Date: 2017/11/30
 * Time: 22:43
 */
namespace app\index\model;
use think\Model;
use think\Log as log;

class User extends Model{
    protected $pk = 'id';
    function updateOrInsert($data){
        $model =model('User');
        $user = $model->where("id", $data["openId"]);
        if($user){
            $allow_field = array(["nickName", "voice_url", "img_url", "wechat", "phone", "city"]);
            $result = $user->allowField($allow_field)->update($data);
            return $user;
        }else{
            $user = new User($data);
            $result = $user->allowField(true)->save();
            return $result;
        }
    }
    
}