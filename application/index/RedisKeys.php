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
function getFollowCountKey($user_id){
    return "user.{$user_id}.follow";
}

function getFollowedCountKey($user_id){
    return "user.{$user_id}.followed";
}
