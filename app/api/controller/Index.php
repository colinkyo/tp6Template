<?php
namespace app\api\controller;
use think\facade\Env;
use think\facade\Config;
use think\annotation\Route;
use think\Validate;
use think\facade\Request;
use think\exception\ValidateException;

use app\BaseController;
use app\api\validate\ValidateData;

class Index extends BaseController
{
    /**
     * @return mixed
     *
     * http://tp.yan/admin
     * http://tp.yan/admin/index
     * api 测试地址 http://tp.yan/admin?name=121&add=22
     */
    public function index()
    {
        //return '<style type="text/css">*{ padding: 0; margin: 0; } div{ padding: 4px 48px;} a{color:#2E5CD5;cursor: pointer;text-decoration: none} a:hover{text-decoration:underline; } body{ background: #fff; font-family: "Century Gothic","Microsoft yahei"; color: #333;font-size:18px;} h1{ font-size: 100px; font-weight: normal; margin-bottom: 12px; } p{ line-height: 1.6em; font-size: 42px }</style><div style="padding: 24px 48px;"> <h1>:) </h1><p> ThinkPHP V' . \think\facade\App::version() . '<br/><span style="font-size:30px;">14载初心不改 - 你值得信赖的PHP框架</span></p><span style="font-size:25px;">[ V6.0 版本由 <a href="https://www.yisu.com/" target="yisu">亿速云</a> 独家赞助发布 ]</span></div><script type="text/javascript" src="https://tajs.qq.com/stats?sId=64890268" charset="UTF-8"></script><script type="text/javascript" src="https://e.topthink.com/Public/static/client.js"></script><think id="ee9b1aa918103c4fc"></think>';
        //获取 .env 配置文件的参数 1:use think\facade\Env;  2: 获取return Env::get("database.type");
        $request = Request::instance();
        dump('请求方法 '.Request::method());
        dump('访问地址 '.$request->ip());
        dump('请求参数 '.Request::method());
        dump('请求参数包含name ');
        dump(Request::only(["name"]));
        dump('请求参数不包含name ');
        dump(Request::except(["name"]));

        if(Request::isGet())
        {
            echo 'isGet method';
        }

        if(Request::isPost())
        {
            echo 'isPost method';
        }

        if(Request::isPut())
        {
            echo 'isPut method';
        }

        if(Request::isPatch())
        {
            echo 'isPatch method';
        }
        if(Request::isDelete())
        {
            echo 'isDelete method';
        }


        dump("我是后台admin，我是后台admin，");
        dump(Config::get('app'));
        dump(Config::get('app.default_timezone'));
        return Env::get("database.type");
    }
    public function testapi()
    {
        $rule = [
            'name' => 'require|max:5',
            'age' => 'number|between:1,120',
            'email' => 'email'
        ];
        $msg = [
            'name.require' => '名称必须',
            'name.max' => '名称最多5个字符',
            'age.number'=> '年龄必须是数字',
            'age.between' => '年龄只能在1-120之间',
            'email' => '邮箱格式错误'
        ];
        $field = [
            'name'  => '名称',
            'email' => '邮箱',
        ];
        $data = Request::post();
        print_r($data);
        $validate = new Validate($rule,$msg,$field);
        $res = $validate->check($data);
        if(!$res){
            echo  $validate->getError();
        }
        //return "Yan test";
    }
    public function tp6test(){
        //访问http://tp.yan/admin/index/tp6test post get
        //固定参数验证
        $data = [
            'user_name'  => 'thinkphp',
            'email' => 'thinkphp@qq.com',
        ];
        //提交的参数验证
        $data = Request::post();
        try {
            validate(ValidateData::class)->check($data);
        } catch (ValidateException $e) {
            // 验证失败 输出错误信息
            echo ($e->getError());
        }
    }
    /**
     * @param string $name
     * @return string
     *
     *
     * http://tp.yan/admin/backend
     * 需要创建 route/app.php 里面配置
     * Route::get('backend', 'index/backend');
     *
     */

    public function backend($name = 'ThinkPHP6')
    {
        return '我是后台：backend,' . $name;
    }

    public function txtjson()
    {
        $data = ['name' => 'thinkphp', 'status' => '1'];
        return json($data)->code(200);;
    }
    //自动配置路由 https://www.kancloud.cn/manual/thinkphp6_0/1037502
    //1:composer require topthink/think-annotation
    //2:引入 use think\annotation\Route;
    /**
     * @param string $name
     * @return string
     */
    public function autoroute($name ="test")
    {
        return "this is autoroute" . $name;
    }
}
