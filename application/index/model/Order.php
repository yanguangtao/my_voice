<?php
/**
 * Created by PhpStorm.
 * User: tgy
 * Date: 2017/12/9
 * Time: 17:43
 */
namespace app\index\model;
use app\index\RedisTool;
use think\Exception;
use app\index\model\Comment as CommentModel;
use think\Log as log;
class Order extends BaseModel{
    protected $pk = 'id';
    public function getUserStar($user_id){
        $data = array("order_num"=>0, "star"=>0);
        $key = getUserOrder($user_id);
        $redis = new RedisTool();
        $result = $redis->handler()->hgetall($key);
        $data['order_num'] =$this->where('service_id', $user_id)->count('*');
        log::error( $data['order_num']);
        if($result){
            return $result;
        }
        $data['order_num'] =$this->where('service_id', $user_id)->count('id');
        $data['star'] = (new CommentModel())->where('user_id', $user_id)->avg('star');
        $redis->handler()->hmset($key, $data);
        return $data;
    }
    public function comment(){
        return $this->hasOne('Comment', 'user_id')->field('content, star');
    }
}