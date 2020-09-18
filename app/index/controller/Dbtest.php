<?php
/**
 * Created by PhpStorm.
 * User: 7.Yan
 * Date: 2020/7/14
 * Time: 14:05
 */

namespace app\index\controller;

use app\BaseController;
use think\facade\Db;
class Dbtest extends BaseController
{
    //http://tp.yan/index/dbtest/demo1
    //原生SQL语句，查找
    public function demo1(){
        //return '我是 demo 1';
        $sql = "select user_id,name,age from user where age > :age limit :num";
        $map = ['age' => 25,'num'=>2];
        $res = Db::query($sql,$map);
        dump($res);
    }
    //原生SQL语句，添加修改删除
    public function demo2()
    {
        $sql = "update user set psw = now() where user_id = :user_id";
        $map = ['user_id'=>2];
        $res = Db::execute($sql,$map);
        return "成功更新了".$res."条";
    }
    //构造器生成 table field find select
    public function demo3()
    {
        //返回第一条记录
        $res = Db::table('user')
            ->field("user_id,name,age")
            //->fetchSql(true)
            ->find(1);//主键作为条件
        dump($res);
    }
    public function demo4()
    {
        //返回第一条记录
        $res = Db::table('user')
            ->field("user_id,name,age")
            ->select([1,3]);//主键作为条件
            //->fetchSql(true)
            //->select();
        dump($res);
    }
    //where 查询条件。1：字符串，2：表达式 3：数组
    public function demo5()
    {
        // 1：字符串
        $res = Db::table('user')
            ->field("user_id,name,age")
            ->where("age > 30")
            ->select();
        dump($res);

        // 2：表达式 推荐
        $res = Db::table('user')
            ->field("user_id,name,age")
            ->where("age", ">", "30")
            ->select();
        dump($res);

        //3：数组
        $res = Db::table('user')
            ->field("user_id,name,age")
            ->where(["age"=>30,"user_id"=>"2"])
            ->select();
        dump($res);


        //3：数组
        $res = Db::table('user')
            ->field("user_id,name,age")
            ->where([
                ["age", ">", "30"]
            ])
            ->select();
        dump($res);

    }
    public function demo6()
    {
        $res = Db::table('user')
            ->field("user_id,name,age")
            ->order("age desc")
            ->order("name","asc")
            ->order(["name" => "asc", "age" => "desc"])
            ->limit(2)
            ->select();
        dump($res);
    }
}
