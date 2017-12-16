<?php
/**
 * Created by PhpStorm.
 * User: tgy
 * Date: 2017/12/16
 * Time: 17:10
 */
namespace app\index\model;
class VoiceType extends \app\index\model\BaseModel{
    protected $pk = "id";
    protected function base($query){
        $query->where("status", "DELETED");
    }
}