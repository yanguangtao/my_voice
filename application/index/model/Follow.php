<?php
/**
 * Created by PhpStorm.
 * User: tgy
 * Date: 2017/12/11
 * Time: 23:29
 */

namespace app\index\model;


use app\index\RedisTool;

class Follow extends BaseModel{
    protected $pk = 'id';
    function deleteByWhere($where){
        return $this->where($where)->delete();
    }
    function getFollowCount($user_id){
        $redis = new RedisTool();
        $key = getFollowCountKey($user_id);
        $count = $redis->get($key, 0);
        if($count){
            return $count;
        }
        $count = $this->getCount(array("user_id"=>$user_id));
        $redis->set($key, $count);
        return $count;
    }
    function getFollowedCount($user_id){
        $redis = new RedisTool();
        $key = getFollowedCountKey($user_id);
        $count = $redis->get($key, 0);
        if($count){
            return $count;
        }
        $count = $this->getCount(array("follow_id"=>$user_id));
        $redis->set($key, $count);
        return $count;
    }
}