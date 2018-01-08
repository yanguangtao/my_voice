<?php
/**
 * This file is part of workerman.
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the MIT-LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @author walkor<walkor@workerman.net>
 * @copyright walkor<walkor@workerman.net>
 * @link http://www.workerman.net/
 * @license http://www.opensource.org/licenses/mit-license.php MIT License
 */

/**
 * 用于检测业务代码死循环或者长时间阻塞等问题
 * 如果发现业务卡死，可以将下面declare打开（去掉//注释），并执行php start.php reload
 * 然后观察一段时间workerman.log看是否有process_timeout异常
 */
//declare(ticks=1);

use \GatewayWorker\Lib\Gateway;
require_once __DIR__."/../model/Chat.php";

/**
 * 主逻辑
 * 主要是处理 onConnect onMessage onClose 三个方法
 * onConnect 和 onClose 如果不需要可以不用实现并删除
 */
class Events
{
    /**
     * 当客户端连接时触发
     * 如果业务不需此回调可以删除onConnect
     * 
     * @param int $client_id 连接id
     */
    public static function onConnect($client_id)
    {
        // 向当前client_id发送数据 
        Gateway::sendToClient($client_id, "Hello $client_id\r\n");
    }
    
   /**
    * 当客户端发来消息时触发
    * @param int $client_id 连接id
    * @param mixed $message 具体消息
    */
   public static function onMessage($client_id, $message)
   {
       try{
           $message = json_decode($message, true);
           $from_id = $message["data"]["from_id"];
           $type = $message["type"];
       }catch (Exception $e){
            return "";
       }
       switch ($type){
           case "login":
               Gateway::bindUid($client_id, $from_id);
               $_SESSION["user_id"] = $from_id;
               $message["data"]["msg"] = "login success $from_id";
               Gateway::sendToClient($client_id, json_encode($message));
               break;
           case "start":
               break;
           case "sure":

           case "chat":
//               if(!isset($_SESSION["user_id"])){
//                   self::error($client_id);
//                   return "";
//               }
               self::chat($message['data']['to_id'], $message);
               break;
           case "room":
               break;
           default:
               return "";
       }
   }
   
   /**
    * 当用户断开连接时触发
    * @param int $client_id 连接id
    */
   public static function onClose($client_id)
   {
       // 向所有人发送 
       GateWay::sendToAll("$client_id logout\r\n");
   }

    public static function error($client){
        $message= ["type"=> "error", "data"=>["msg"=> "not login"]];
        Gateway::sendToClient($client, json_encode($message));
        Gateway::closeClient($client);
    }
    public static function chat($to_id, $msg){
        Gateway::sendToAll(json_encode($msg));
        Gateway::sendToUid($to_id, json_encode($msg));
        $chatModel = new \app\index\model\Chat();
        $data = $msg['data'];
        $chatModel->save($data);
        \think\Log::error($chatModel);
        
    }
}