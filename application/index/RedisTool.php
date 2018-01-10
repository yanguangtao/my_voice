<?php
/**
 * Created by PhpStorm.
 * User: tgy
 * Date: 2017/12/12
 * Time: 21:26
 */
namespace app\index;
use \think\cache\driver\Redis;


class RedisTool extends Redis{

    function __construct(){
        $config = require __DIR__."/../redis_config.php";
        parent::__construct($config);
    }
    
}