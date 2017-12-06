<?php

namespace app\index\validate;

use think\Validate;

class ProviderValidate extends Validate
{
    protected $rule = [
        ['gender', 'require', '请选择性别'],
        ['record_url', 'require', '需要一段录音'],
        ['avatar_url', 'require', '需要头像'],
    ];

}