<?php
/**
 * Created by PhpStorm.
 * User: 7.Yan
 * Date: 2020/7/21
 * Time: 11:22
 */

namespace app\api\validate;

use think\Validate;

class ValidateData extends Validate
{
    protected $rule;
    protected $message;
    public function __construct($rule  = [], $message = [])
    {
        parent::__construct();
        $this->rule = $rule;
        $this->message =$message;
    }

    /*public $rule =   [
        'user_name'  => 'require|chsDash|max:25',
        'user_pwd' => 'require|length:32',
        'age'   => 'number|between:1,120',
        'email' => 'email',
    ];

    public $message  =   [
        'user_name.require' => '名称必须',
        'user_name.max'     => '名称最多不能超过25个字符',
        'user_pwd.require' => '密码必须',
        'user_pwd.length'     => '密码最多不能超过32个字符',
        'age.number'   => '年龄必须是数字',
        'age.between'  => '年龄只能在1-120之间',
        'email'        => '邮箱格式错误',
    ];*/

}
