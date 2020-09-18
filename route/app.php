<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2018 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------
use think\facade\Route;

//全局路由 找不到think 应用时，返回'hello,ThinkPHP6!';
Route::get('think', function () {
    return 'hello,ThinkPHP6!';
});

Route::get('hello/:name', 'index/hello');
//Route::domain('api','api');
