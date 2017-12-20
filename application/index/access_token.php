<?php
/**
 * Created by PhpStorm.
 * User: tgy
 * Date: 2017/12/20
 * Time: 23:21
 */

use app\index\RedisTool;
require_once __DIR__.'/ConstansValue.php';
require_once __DIR__.'/RedisKeys.php';
function getAccessToken () {
    $key = getAccessTokenKey();
    $redis = new RedisTool();
    $access_token = $redis->get($key);
    if($access_token){
        return $access_token;
    }
    $appid = ConstansValue::APPID;
    $appsecret = ConstansValue::APP_SECRET;
    $url='https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid='.$appid.'&secret='.$appsecret;
    $html = file_get_contents($url);
    $output = json_decode($html, true);
    $access_token = $output['access_token'];
    $redis->set($key, $access_token, ConstansValue::ACCESS_TOKEN_EXP);
    return $access_token;
}

