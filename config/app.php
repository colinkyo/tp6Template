<?php
// +----------------------------------------------------------------------
// | 应用设置
// +----------------------------------------------------------------------

return [
    // 应用地址
    'app_host'         => env('app.host', ''),
    // 应用的命名空间
    'app_namespace'    => '',
    // 是否启用路由
    'with_route'       => true,
    // 默认应用目录
    'default_app'      => 'index',
    // 默认时区
    'default_timezone' => 'Asia/Shanghai',

    // 应用映射（自动多应用模式有效）
    'app_map'          => [
        //把admin 映射为 7yan
        //不能访问http://tp.yan/admin
        //可以访问http://tp.yan/7yan
        //但同时设置'admin' => 'admin' 可以同时支持两种访问
        //'7yan'  => 'admin',
        //'admin' => 'admin',
        //应用映射支持泛解析,什么字符都可以除了index,不要随便设置
        //'*'     =>  'index'
        //可以http://tp.yan/dsfdas 随便访问 http://tp.yan/index
        //'index' =>  'index',
    ],
    // 域名绑定（自动多应用模式有效）
    'domain_bind'      => [
        //"api.yan" => "api",//二级域名完整绑定
        //http://tp.yan/hello 但是访问不了admin应用
        //'tp.yan' =>  'index',  //  完整域名绑定
    ],
    // 禁止URL访问的应用列表（自动多应用模式有效）
    'deny_app_list'    => [],

    // 异常页面的模板文件
    'exception_tmpl'   => app()->getThinkPath() . 'tpl/think_exception.tpl',

    // 错误显示信息,非调试模式有效
    'error_message'    => '页面错误！请稍后再试～',
    // 显示错误信息
    'show_error_msg'   => false,
];
