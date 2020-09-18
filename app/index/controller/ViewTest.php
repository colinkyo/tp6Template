<?php
/**
 * Created by PhpStorm.
 * User: 7.Yan
 * Date: 2020/7/15
 * Time: 14:03
 */

namespace app\index\controller;

use app\BaseController;
//use think\View; //这个用依赖注入方式，View $view  ===> return $view->fetch();
use think\facade\View; //这个用静态调用
use app\index\model\User;

/**
 *
 *使用模板报驱动错误Driver [Think] not supported.
 *原因：
 *tp6默认只能支持PHP原生模板，但配置文件config/view.php配置使用的却是Think
 *办法一：使用tp模板进行think-view安装
 *composer require topthink/think-view
 *办法二：使用原生模板
 *到配置文件config/view.php里把'type' => 'Think'修改为'type' => 'php'
 *办法三：使用原生模板
 *return View::engine('php')->fetch();
 *
 */

class ViewTest extends BaseController
{
    //方法与模版文件的对应 //对应demo1.html 【index/view/viewtest/demo1.html】
    public function demo1(View $view)
    {
        //默认的视图目录view 【index/view/viewtest】
        //return $view->fetch(); //use think\View
        // 模板变量赋值
        View::assign('name','ThinkPHP');
        View::assign('email','thinkphp@qq.com');
        // 或者批量赋值
        View::assign([
            'name1'  => 'ThinkPHP',
            'email1' => 'thinkphp@qq.com'
        ]);
        //数组
        $data = ["phone" => 'mi','color' => 'red', 'price' => 1200];
        View::assign('mobile',$data);
        //对象
        $obj = new \stdClass();
        $obj->subject = "php";
        $obj->num = 100;
        View::assign('stu',$obj);

        //预定义变量 $_GET $_POST $_SERVER
        return View::fetch();
    }

    //方法与模版文件的对应 /自定义名称 【index/view/viewtest/自定义名称.html】
    public function demo2()
    {
        //默认的视图目录view 【index/view/viewtest】
        //return $view->fetch('custome');//use think\View

        return View::fetch('custome');
    }
    //与数据库连接操作
    //1:引入 use app\index\model\User;
    public function demo3(User $user)
    {
        $res = $user->db()->select();
        View::assign('users',$res);
        return View::fetch();
    }
}
