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

/***
 *
 *
 * 主要开启 redis 服务器  现在是在192.168.0.110
 * 主要开启 redis 服务器  现在是在192.168.0.110
 * 主要开启 redis 服务器  现在是在192.168.0.110
 *
 *
 *
 */

/*Route::get('think', function () {
    return 'hello,ThinkPHP6!';
});*/

//启动这个配置后。http://tp.yan/index/index/hello 无效，
//只能这样访问 http://tp.yan/index/hello
//一定要参数 http://tp.yan/index/hello/参数
//Route::get('hello/:name', 'index/hello');
//不一定带参数,而且传参只能 http://tp.yan/index/hello/name/参数
//Route::get('hello', 'index/hello');

//暂时无法设置为：
//api.yan ==> tp.yan/index.php/api
//暂时无法设置为：
Route::domain('api','api'); //无效

//api.yan/user/2  ==> api.yan/index.php/api/user/id/2
//访问：http://tp.yan/api/user/5
//Route::rule('user/:id','user/index');
Route::get('user/:id','user/index');
//post 方法的登录验证
/*
 * // 路由是否完全匹配  开完全匹配  这样访问 user/register 才不会 匹配到 user/ 先 不然 user => user/login 要放到最后
    'route_complete_match'  => true,
 */
Route::post('user','user/login');
//测试session
Route::get('code/setsession','code/setsession');
Route::get('code/getsession','code/getsession');
Route::get('code/delsession','code/delsession');
//GET 获取验证码
Route::get('code/:time/:token/:username/:is_exist','code/get_code');
//用户注册
Route::post('user/register','user/register');
//用户登录
Route::post('user/signin','user/signin');
//用户上传图像
Route::post('user/icon','user/upload_head_img');
//用户修改密码
Route::post('/user/change_pwd','/user/change_pwd');
//用户找回密码
Route::post('/user/find_pwd','/user/find_pwd');

