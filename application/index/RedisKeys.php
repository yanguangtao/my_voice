<?php
/**
 * Created by PhpStorm.
 * User: tgy
 * Date: 2017/12/13
 * Time: 23:28
 */

/**
 * @param $user_id
 * @return string
 */
function getUserIdKeyByOpenId($openId){
    return "user.openId.{$openId}";
}
function getUserKey($user_id){
    return "user.{$user_id}";
}
function getUserOrder($user_id){
    return "user.{$user_id}.order";
}
function getFollowCountKey($user_id){
    return "user.{$user_id}.follow";
}

function getFollowedCountKey($user_id){
    return "user.{$user_id}.followed";
}

function getAccessTokenKey(){
    return "voice_app.access_token";
}
