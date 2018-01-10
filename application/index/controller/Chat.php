<?php
/**
 * Created by PhpStorm.
 * User: tgy
 * Date: 2018/1/8
 * Time: 21:11
 */
namespace app\index\controller;
use think\Db;
use think\Log;
use think\Request;
use think\Exception;
use app\index\model\User;
use app\index\model\Chat as ChatModel;
require_once __DIR__.'/../gateway_client/Gateway.php';
class Chat extends Base{
    public function bind(){
        $param = Request::instance()->param();
//        $uid = '1234';
        $uid =  User::getUserId();
        $client_id = $param['client_id'];
        Log::error(\Gateway::bindUid($client_id, $uid));
        $message = '绑定成功';
        \Gateway::sendToUid($uid, 'haha');
        Log::error(\Gateway::getClientIdByUid($uid));
        Log::error(\Gateway::isUidOnline($uid));
        return msg("", 0, $message);
    }
    public function chat(){
        $param = Request::instance()->param();
        $user_id = User::getUserId();
        $data["from_id"] = $user_id;
        $to_id = $param["to_id"];
        $chatModel = new ChatModel();
        $chatModel->allowField(true)->save($param);
        $data = ["url"=>"chat"];
        $data["data"] = $param;
        \Gateway::sendToUid($to_id, json_encode($data));
        return msg();
    }

    public function history($user_id){
        $u_id = User::getUserId();
        if(!$u_id){
            return msg("", 2, "登录过期");
        }
        $chatModel = new ChatModel();
        $where = "(from_id=$u_id and to_id=$user_id) or (from_id=$user_id and to_id=$u_id)";
        $data = $chatModel->getByWhere($where);
        return msg($data);

    }

}