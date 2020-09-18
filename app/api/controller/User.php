<?php
/**
 * Created by PhpStorm.
 * User: 7.Yan
 * Date: 2020/7/21
 * Time: 14:26
 */

namespace app\api\controller;

use think\db\Where;
use think\facade\Db;


class User extends Common
{
    //http://tp.yan/api/user/index/id/4 == http://api.yan/api/user/index/id/4
    //要设置为 http://api.yan/api/user/2 ==> //http://tp.yan/api/user/index/id/4 需要配置api/route.php
    public function index($id = 1)
    {
        echo "User index {$id}";
    }

    public function login()
    {
        //echo "this is login";
        $data = $this->params;
        print_r($data);
    }

    public function register()
    {
        //echo "user register";
        /**** 接收参数 *****/
        $data = $this->params;

        /**** 检查验证码 *****/
        $this->check_code($data['user_name'], $data['code']);

        /**** 检查用户名 *****/
        $user_name_type = $this->check_username($data['user_name']);
        switch ($user_name_type) {
            case 'phone':
                $this->check_exist($data['user_name'], $user_name_type, 0);
                $data['user_phone'] = $data['user_name'];
                break;
            case 'email':
                $this->check_exist($data['user_name'], $user_name_type, 0);
                $data['user_email'] = $data['user_name'];
                break;
        }

        /**** 写入数据库 *****/
        unset($data['user_name']);
        $data['user_rtime'] = time();
        $res                = Db::table('api_user')->insert($data);
        if (!$res) {
            $this->return_msg(400, '用户注册失败!');
        } else {
            $this->return_msg(200, '用户注册成功!');
        }

    }

    public function signin()
    {
        //echo "---signin---";
        /**** 接收参数 *****/
        $data = $this->params;

        /**** 检查用户名 *****/
        $user_name_type = $this->check_username($data['user_name']);
        switch ($user_name_type) {
            case 'phone':
                $this->check_exist($data['user_name'], $user_name_type, 1);//1必须存在
                $db_res = Db::table('api_user')
                  ->field('*')
                  ->where('user_phone', $data['user_name'])
                  ->find();
                break;
            case 'email':
                $this->check_exist($data['user_name'], $user_name_type, 1);//1必须存在
                $db_res = Db::table('api_user')
                  ->field('*')
                  ->where('user_email', $data['user_name'])
                  ->find();
                break;
        }

        if ($db_res['user_pwd'] !== $data['user_pwd']) {
            $this->return_msg(400, '用户名或者密码不正确.');
        } else {
            //密码永不返回
            unset($db_res['user_pwd']);
            $this->return_msg(200, '用户名或者密码不正确.', $db_res);
        }
    }

    public function upload_head_img()
    {
        //echo "----upload_head_img-----";
        /**** 接收参数 *****/
        $data = $this->params;

        /**** 上传文件，获取路径 *****/
        $head_img_path = $this->upload_file($data['user_icon'], 'head_img');

        /**** 写入数据库 *****/
        $res = Db::table('api_user')->where('user_id', $data['user_id'])->update(['user_icon' => $head_img_path]);
        if ($res) {
            $this->return_msg(200, '上传图片成功!', $head_img_path);
        } else {
            $this->return_msg(400, '上传图片失败!');
        }

    }

    public function change_pwd()
    {
        //echo "----123456 change_pwd 789456----";
        /**** 接收参数 *****/
        $data = $this->params;

        /**** 检查用户名 *****/
        $user_name_type = $this->check_username($data['user_name']);

        switch ($user_name_type) {
            case 'phone':
                $this->check_exist($data['user_name'], 'phone', 1);
                $where['user_phone'] = $data['user_name'];
                break;
            case 'email':
                $this->check_exist($data['user_name'], 'email', 1);
                $where['user_email'] = $data['user_name'];
                break;
        }
        /**** 取出旧密码 *****/
        $db_ini_pwd = Db::table('api_user')->where($where)->value('user_pwd');
        if ($db_ini_pwd !== $data['user_ini_pwd']) {
            $this->return_msg(400, '用户原密码不正确');
        }

        /**** 修改密码 *****/
        $res = Db::table("api_user")->where($where)->update(['user_pwd'=>$data['user_pwd']]);
        if ($res !== false) {
            $this->return_msg(200, '修改密码成功');
        } else {
            $this->return_msg(400, '修改密码失败');
        }
    }
    public function find_pwd(){
        //echo "---- find_pwd ---";
        /**** 接收参数 *****/
        $data = $this->params;

        /**** 检查用验证码 *****/
        $this->check_code($data['user_name'],$data['code']);

        /**** 检查用户名 *****/
        $user_name_type = $this->check_username($data['user_name']);
        switch ($user_name_type) {
            case 'phone':
                $this->check_exist($data['user_name'], 'phone', 1);
                $where['user_phone'] = $data['user_name'];
                break;
            case 'email':
                $this->check_exist($data['user_name'], 'email', 1);
                $where['user_email'] = $data['user_name'];
                break;
        }

        /**** 修改密码 *****/
        $res = Db::table("api_user")->where($where)->update(['user_pwd'=>$data['user_pwd']]);
        if ($res !== false) {
            $this->return_msg(200, '修改密码成功');
        } else {
            $this->return_msg(400, '修改密码失败');
        }
    }
}
