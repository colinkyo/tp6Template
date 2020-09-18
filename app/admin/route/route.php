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

//好像叫route.php 和 app.php 都可以 只要在route文件夹下
use think\facade\Route;

/*Route::get('think', function () {
    return 'hello,ThinkPHP6!';
});*/

//启动这个配置后。http://tp.yan/index/admin/index 无效，
//只能这样访问 http://tp.yan/admin/index

//Route::rule('路由表达式', '路由地址', '请求类型');
/**
 *
 *  类型	 GET POST PUT DELETE PATCH * 任何请求类型
 *
 *
 */

Route::rule('backend', 'index/backend');
Route::rule('txtjson', 'index/txtjson');
Route::rule('autoroute', 'index/autoroute');

//测试redis
Route::get('index/testredis','index/testredis');
//快捷路由注册方式
/*
Route::get('new/<id>','News/read'); // 定义GET请求路由规则
Route::post('new/<id>','News/update'); // 定义POST请求路由规则
Route::put('new/:id','News/update'); // 定义PUT请求路由规则
Route::delete('new/:id','News/delete'); // 定义DELETE请求路由规则
Route::any('new/:id','News/read'); // 所有请求都支持的路由规则

Route::rule('/', 'index'); // 首页访问路由
Route::rule('my', 'Member/myinfo'); // 静态地址路由
Route::rule('blog/:id', 'Blog/read'); // 静态地址和动态地址结合
Route::rule('new/:year/:month/:day', 'News/read'); // 静态地址和动态地址结合
Route::rule(':user/:blog_id', 'Blog/read'); // 全动态地址

Route::get('blog/:year/[:month]','Blog/archive');
// 或者
Route::get('blog/<year>/<month?>','Blog/archive');
http://serverName/index.php/blog/2015
http://serverName/index.php/blog/2015/12

// 定义动态路由 可以把路由规则中的变量传入路由地址中，就可以实现一个动态路由
Route::get('hello/:name', 'index/:name/hello');

//路由到类的方法
\完整类名@方法名
\完整类名::方法名
Route::get('blog/:id','\app\index\service\Blog@read');
执行的是 \app\index\service\Blog类的read方法。
Route::get('blog/:id','\app\index\service\Blog::read');

//重定向路由
Route::redirect('blog/:id', 'http://blog.thinkphp.cn/read/:id', 302);

//路由到模板
Route::view('hello/:name', 'index/hello');
Route::view('hello/:name', 'index/hello', ['city'=>'shanghai']);
表示该路由会渲染当前应用下面的view/index/hello.html模板文件输出。 在模板中可以输出name和city两个变量。

*/
