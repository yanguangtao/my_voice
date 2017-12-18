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
        $config = [
            'host'       => 'localhost',
            'port'       => 6379,
            'password'   => '',
            'select'     => 1,
            'timeout'    => 10,
            'expire'     => 0,
            'persistent' => false,
            'prefix'     => '',
        ];
        parent::__construct($config);
    }
    
}