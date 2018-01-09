<?php
namespace app\index\model;
class Chat extends BaseModel{
    protected $pk = 'id';

    public function saveMessage($message){
        $message["create_time"] = date("Y-m-d H:i:s");
        $this->allowField(true)->save($message);
    }

}
