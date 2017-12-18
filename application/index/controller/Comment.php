<?php
/**
 * Created by PhpStorm.
 * User: tgy
 * Date: 2017/12/18
 * Time: 22:23
 */
namespace app\index\controller;
use app\index\model\Order as OrderModel;
use app\index\model\User as UserModel;
use app\index\model\Comment as CommentModel;
use QCloud_WeApp_SDK\Constants;
use think\Db;
use think\Exception;
use think\Request;
use think\Log as log;
use \app\index\model\Follow as FollowModel;
use think\session\driver\Redis;

class Comment extends Base{
    public function post($order_id){
        $param = Request::instance()->param();
        $user = new UserModel;
        $user_id = $user->getUserId();
        $order = new OrderModel();
        $order = $order->getOne($order_id);
        if(!$order or $order->consignee_id != intval($user_id)){
            return msg("", 1, "订单不存在或不属于该用户");
        }
        $param['order_id'] = $order_id;
        $param['user_id'] = $user_id;
        $comment = new CommentModel();
        $result = $comment->where('order_id', $order_id)->find();
        if($result){
            return msg("", 1 , "该订单已评价");
        }
        $comment->allowField(true)->save($param);
        return msg("");

    }
}