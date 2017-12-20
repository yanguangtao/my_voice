<?php

namespace app\index\controller;

use think\Controller;
use QCloud_WeApp_SDK\Conf as waferConfig;
require_once __DIR__."/../ConstansValue.php";
class Base extends Controller
{
    public function _initialize()
    {

        waferConfig::setup(array(
            'appId'          => \ConstansValue::APPID,
            'appSecret'      => \ConstansValue::APP_SECRET,
            'useQcloudLogin' => false,
            'serverHost'         => 'vox-api.kavil.com.cn',
            'AuthServerUrl' => 'https://vox-apj.kavil.com.cn/session/',
            'tunnelServerUrl'    => 'https://tunnul.ws.qcloud.la',
            'tunnelSignatureKey' => 'vox-',
        ));
        /**
         * --------------------------------------------------------------------
         * 设置 SDK 日志输出配置（主要是方便调试）
         * --------------------------------------------------------------------
         */

        // 开启日志输出功能
        waferConfig::setEnableOutputLog(TRUE);

        // 指定 SDK 日志输出目录（注意尾斜杠不能省略）
        waferConfig::setLogPath('/waferLogs/');

        // 设置日志输出级别
        // 1 => ERROR, 2 => DEBUG, 3 => INFO, 4 => ALL
        waferConfig::setLogThresholdArray(array(2)); // output debug log only

    }
}
