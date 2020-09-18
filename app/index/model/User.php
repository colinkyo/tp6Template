<?php
/**
 * Created by PhpStorm.
 * User: 7.Yan
 * Date: 2020/7/14
 * Time: 16:09
 */

namespace app\index\model;

use think\Model;
class User extends Model
{
    //和数据表名对应
    protected $table = "user";
    //数据表的主键
    protected $pk ="user_id";
}
