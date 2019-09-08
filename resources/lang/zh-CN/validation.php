<?php

use App\Enums\SettingKeyEnum;

return [

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | as the size rules. Feel free to tweak each of these messages here.
    |
    */

    'accepted'             => ':attribute是必填的。',
    'active_url'           => ':attribute不是有效的URL。',
    'after'                => ':attribute不是在:date之后。',
    'after_or_equal'       => ':attribute必须是或等于:date。',
    'alpha'                => ':attribute可能只包含字母。',
    'alpha_dash'           => ':attribute可能只包含字母、数字和破折号。',
    'alpha_num'            => ':attribute可能只包含字母和数字。',
    'array'                => ':attribute必须是数组。',
    'before'               => ':attribute必须是日期:date之前的日期。',
    'before_or_equal'      => ':attribute必须是或等于:date。',
    'between'              => [
        'numeric' => ':attribute必须介于:min到:max之间。',
        'file'    => ':attribute必须介于:min到:maxKB之间。',
        'string'  => ':attribute必须介于:min到:max个字符。',
        'array'   => ':attribute必须介于:min到:max项目。',
    ],
    'boolean'              => ':attribute必须为真或假。',
    'confirmed'            => ':attribute确认不匹配。',
    'date'                 => ':attribute不是有效日期。',
    'date_format'          => ':attribute不匹配格式:format。',
    'different'            => ':attribute和:other必须不一样',
    'digits'               => ':attribute一定是:digits。',
    'digits_between'       => ':attribute一定是:min或者:max数字。',
    'dimensions'           => ':attribute图像维数无效。',
    'distinct'             => ':attribute具有重复值。',
    'email'                => ':attribute必须是有效的电子邮件地址。',
    'exists'               => ':attribute不存在。',
    'file'                 => ':attribute必须是文件。',
    'filled'               => ':attribute必须有值。',
    'image'                => ':attribute必须是图像。',
    'in'                   => ':attribute的值无效',
    'in_array'             => ':attribute不存在于:other。',
    'integer'              => ':attribute必须是整数。',
    'ip'                   => ':attribute必须是有效的IP地址。',
    'ipv4'                 => ':attribute必须是有效的IPv 4地址。',
    'ipv6'                 => ':attribute必须是有效的IPv 6地址。',
    'json'                 => ':attribute必须是有效的JSON字符串。',
    'max'                  => [
        'numeric' => ':attribute不得大于:max。',
        'file'    => ':attribute不得大于:max kb。',
        'string'  => ':attribute不得大于:max字符。',
        'array'   => ':attribute不得大于:max条。',
    ],
    'mimes'                => ':attribute必须是一个类型为：:values。',
    'mimetypes'            => ':attribute必须是一个类型为：:values。',
    'min'                  => [
        'numeric' => ':attribute最小要等于:min。',
        'file'    => ':attribute最小要等于:min kb。',
        'string'  => ':attribute最小要等于:min字符。',
        'array'   => ':attribute最小要等于:min条。',
    ],
    'not_in'               => ':attribute的值无效。',
    'numeric'              => ':attribute必须是个数字。',
    'present'              => ':attribute必须在场。',
    'regex'                => ':attribute格式无效。',
    'required'             => ':attribute必须存在',
    'required_if'          => ':attribute当:other是:value。',
    'required_unless'      => ':attribute当:other是:values。',
    'required_with'        => ':attribute当:values是存在的。',
    'required_with_all'    => ':attribute当:values是存在的。',
    'required_without'     => ':attribute当:values是存在的。',
    'required_without_all' => ':attribute当不在:values都在。',
    'same'                 => ':attribute和:other不匹配。',
    'size'                 => [
        'numeric' => ':attribute必须是:size。',
        'file'    => ':attribute必须是:size kb。',
        'string'  => ':attribute必须是:size 字符。',
        'array'   => ':attribute必须包含:size条。',
    ],
    'string'               => ':attribute必须是字符擦混。',
    'timezone'             => ':attribute必须是有效区域。',
    'unique'               => ':attribute已经存在。',
    'uploaded'             => ':attribute上传失败。',
    'url'                  => ':attribute格式无效。',

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "attribute.rule" to name the lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
    */

    'custom' => [
        'attribute-name' => [
            'rule-name' => 'custom-message',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap attribute place-holders
    | with something more reader friendly such as E-Mail Address instead
    | of "email". This simply helps us make messages a little cleaner.
    |
    */

    'attributes' => [
        'email' => '邮箱',
        'amount'     => '',
        'receipt_no' => '',
        'receipt_date' => '',
        'name' => '名字',
        'bigtitle'=>'大标题',
        'title'=>'标题',
        'singlem'=>'价格标记',
        'referenceprice'=>'参考价',
        'oprice'=>'预定价',
        'displayorder'=>'排序',
        'picurl'=>'图片',
        'headimg'=>'头图',
        'introduction'=>'简介',
        'price'=>'价格',
        'mobile'=>'手机号',
        'account'=>'余额',
        'point'=>'积分',
        'birthday'=>'出生日期',
        'password'=>'密码',
        'column_id' => '栏目',
        'body' => '内容',
        'phone' => '手机',
        'json_address' => '地址',
        'json_name' => '名字',
        'json_description' => '描述',
        'json_body' => '详情',
        'json_room_around' => '酒店周边',
        'json_required_reading' => '阅读指南',
        'score' => '评分',
        'thumb' => '图片',
        'address' => '地址',
        'code' => '代号',
        'gst' => '汇率',
        'min_score' => '阶梯分',
        'level' => '等级',
        'picture_id' => '图片',
        'city_id' => '城市',
        'country_id' => '国家',
        'address_id' => '地址',
        'category_id' => '分类',
        'product_id' => '商品',
        'username' => '用户名',
        SettingKeyEnum::USER_INIT_PASSWORD => '会员初始密码',
        SettingKeyEnum::IS_OPEN_SECKILL => '是否开启秒杀',
        SettingKeyEnum::POST_AMOUNT => '邮费',
        SettingKeyEnum::UN_PAY_CANCEL_TIME => '订单自动取消时间',
    ],

];
