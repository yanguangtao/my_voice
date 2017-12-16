<?php

/**
 * 统一返回信息
 * @param $code
 * @param $data
 * @param $msg
 * @return result
 */
function msg( $data=array(), $code=0, $msg=""){
    if($data == ""){
        $data = new ArrayObject();
    }else{
        $data = objToArray($data);
    }
    return json(compact('code', 'data', 'msg'));
}

/**
 * 对象转换成数组
 * @param $obj
 * @return array
 */
function objToArray($obj)
{
    return json_decode(json_encode($obj), JSON_PRETTY_PRINT);
}

function is_json($string) {
    json_decode($string);
    return (json_last_error() == JSON_ERROR_NONE);
}

function getOrderSN() {
    $a = mt_rand();
    return date('YmdHis') . substr('000000000000000'.$a, -2);
}

function isFollow($user_id, $follow_id){
    $model = new \app\index\model\Follow();
    return $model->isFollow($user_id, $follow_id);
}




