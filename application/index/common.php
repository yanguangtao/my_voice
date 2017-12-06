<?php

/**
 * 统一返回信息
 * @param $code
 * @param $data
 * @param $msg
 */
function msg( $data=array(), $code=0, $msg=""){
    if(empty($data)){

        $data = new ArrayObject();
    }else{
        $data = objToArray($data);
    }
    return json(compact('code', 'data', 'msg'));
}

/**
 * 对象转换成数组
 * @param $obj
 */
function objToArray($obj)
{
    return json_decode(json_encode($obj), JSON_PRETTY_PRINT);
}

function is_json($string) {
    json_decode($string);
    return (json_last_error() == JSON_ERROR_NONE);
}




