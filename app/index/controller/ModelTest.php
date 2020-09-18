<?php
/**
 * Created by PhpStorm.
 * User: 7.Yan
 * Date: 2020/7/14
 * Time: 16:12
 */

namespace app\index\controller;

use app\BaseController;
use app\index\model\User;

class ModelTest extends BaseController
{
    //模型对象
    public function demo1()
    {
        $user = new User();
        $res = $user->db()->find(1);
        dump($res);
        print_r($res);
        return $res->name;

    }
    //依赖注入对象
    public function demo2(User $user)
    {
        $res = $user->db()->select([1,2]);
        dump($res);
    }
    //http://tp.yan/index/modeltest/insert
    //新增
    public  function insert()
    {
        $data = ['name' => 'magicmoon','age' => 45,'email' => 'email@qq.com','psw' => md5('12332')];
        $user = User::create($data);
        return $user['user_id'];
    }
    //http://tp.yan/index/modeltest/select
    public function select(User $user)
    {
        //查询一条
        $res = $user->db()->find(1);
        dump($res);
        //查询全部
        $res = $user->db()->select();
        dump($res);
        //条件查询
        $res = $user->db()->where('age','=',45)->select();
        dump($res);
    }
    //update
    //http://tp.yan/index/modeltest/update
    public function update()
    {
        $user = User::update(['psw' => md5(time())],['user_id' => 3]);
        return $user['psw'];
    }
    //delete
    //http://tp.yan/index/modeltest/delete
    public function delete(){
        $res = User::destroy(['user_id' => 5]);
        $res = User::destroy(function ($query){
            $query->where('user_id',4);
        });
        return $res?'删除成功':'删除失败';
    }
}
