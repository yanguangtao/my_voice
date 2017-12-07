<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------
// $Id$
return [
    'url_route_on' => true,
    'trace' => [
        'type' => 'html', // 支持 socket trace file
    ],
    //各模块公用配置
    'extra_config_list' => ['database', 'route', 'validate'],
    //临时关闭日志写入

    'log'   => [
        // 日志记录方式，支持 file socket
        'type' => 'File',
        //日志保存目录
        'path' => APP_PATH.'logs/',
        //单个日志文件的大小限制，超过后会自动记录到第二个文件
        'file_size'     =>2097152,
        //日志的时间格式，默认是` c `
        'time_format'   =>'c'
    ],

    'app_debug' => true,
    'show_error_msg' =>  true,

    'default_filter' => ['strip_tags', 'htmlspecialchars'],

    // +----------------------------------------------------------------------
    // | 缓存设置
    // +----------------------------------------------------------------------
    'cache' => [
        // 驱动方式
        'type' => 'file',
        // 缓存保存目录
        'path' => CACHE_PATH,
        // 缓存前缀
        'prefix' => 'wyy',
        // 缓存有效期 0表示永久缓存
        'expire' => 0,
        'host' => '127.0.0.1',
        'port' => 11211,
    ],

    //加密串
    'salt' => 'wZPb~yxvA!ir38&Z',

    //备份数据地址
    'back_path' => APP_PATH .'../back/',
    'datetime_format' => false,
    'timestamp' => true, //mysql timestamp解析冲突

];