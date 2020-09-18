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

/*Route::get('think', function () {
    return 'hello,ThinkPHP6!';
});*/

//启动这个配置后。http://tp.yan/index/index/hello 无效，
//只能这样访问 http://tp.yan/index/hello
//一定要参数 http://tp.yan/index/hello/参数
//Route::get('hello/:name', 'index/hello');
//不一定带参数,而且传参只能 http://tp.yan/index/hello/name/参数
Route::get('hello', 'index/hello');
