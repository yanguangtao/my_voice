<?php
/**
 * Created by PhpStorm.
 * User: tgy
 * Date: 2017/12/18
 * Time: 22:21
 */
namespace app\index\model;
use app\index\RedisTool;
require_once __DIR__."/../RedisKeys.php";

class Comment extends BaseModel{
    protected $pk = 'id';
    
    
}