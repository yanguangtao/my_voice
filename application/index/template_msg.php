<?php
/**
 * Created by PhpStorm.
 * User: tgy
 * Date: 2017/12/20
 * Time: 23:58
 */


require_once __DIR__."/access_token.php";
function send_post() {
    $data_arr = array(
        'keyword1' => array( "value" => '测试一下' ),
        'keyword2' => array( "value" => '珠光村'),
        //这里根据你的模板对应的关键字建立数组，color 属性是可选项目，用来改变对应字段的颜色
    );
    $post_data = array (
        "touser"           => "obeUX0Rxu-oHk46zMJya6mrcBKlI",
        //用户的 openID，可用过 wx.getUserInfo 获取
        "template_id"      => "eLA3g8ud3p3PxRhdciTtCW-kiIrJ8JsxyJdoIlP9W_s",
        //小程序后台申请到的模板编号
//    "page"             => "/pages/check/result?orderID=".$orderID,
        //点击模板消息后跳转到的页面，可以传递参数
        "form_id"          => "1iTNiA0159ge30",
        //第一步里获取到的 formID
        "data"             => $data_arr,
        "emphasis_keyword" => "keyword2.DATA"
        //需要强调的关键字，会加大居中显示
    );
    $url = "https://api.weixin.qq.com/cgi-bin/message/wxopen/template/send?access_token=".getAccessToken();
    $post_data = json_encode($post_data, true);
    $options = array(
        'http' => array(
            'method'  => 'POST',
            'header'  => 'Content-type:application/json',
            //header 需要设置为 JSON
            'content' => $post_data,
            'timeout' => 60
            //超时时间
        )
    );

    $context = stream_context_create( $options );
    $result = file_get_contents( $url, false, $context );

    return $result;
}
