<?php
/**
 * Created by PhpStorm.
 * User: 7.Yan
 * Date: 2020/7/22
 * Time: 15:49
 */

namespace app\api\controller;
use think\facade\Cache;
use think\facade\Session;

class Code extends Common
{
    public function get_code(){
        //echo "___get_code__";
        $username = $this->params['username'];
        $exist = $this->params['is_exist'];
        $username_type = $this->check_username($username);
        $this->get_code_by_username($username,$username_type,$exist);
    }
    public function get_code_by_username($username,$type,$exist)
    {
        if($type == "email"){
            $type_name = "邮箱";
        }else{
            $type_name = "手机";
        }
        //检测手机号是否存在
        $this->check_exist($username,$type,$exist);

        //生成验证码
        $code = $this->make_code(6);
        $md5_code = md5($username.'-'.md5($code));

        /**
         *
         * 以下操作session 保存验证码
         *
         */
        //检查验证码请求频率
        if(Session::has($username.'_last_send_time')){
            if(time() - Session::get($username.'_last_send_time') < 30){
                $this->return_msg(400,"{$type_name}验证码，30秒一次");
            }
        }

        //保存验证码
        Session::set($username.'_code',$md5_code);

        //保存最后发送时间
        Session::set($username.'_last_send_time',time());
        //发送

        /**
         *
         * 以下操作需要开启 redis 服务器和配置config/cache.php
         *
         */
        $redis = Cache::store('redis');
        if($redis->get($username.'_last_send_time')){
            if(time() - $redis->get($username.'_last_send_time') <30){
                $this->return_msg(400,"{$type_name}验证码，30秒一次");
            }
        }

        //保存验证码
        $redis->set($username.'_code',$md5_code);

        //保存最后发送时间
        $redis->set($username.'_last_send_time',time());


        if($type == 'phone'){
            $this->send_code_to_phone($username,$code);
        }else{
            $this->send_code_to_email($username,$code);
        }
    }
    public function make_code($num)
    {
        $max = pow(10,$num) -1;
        $min = pow(10,$num-1);
        return rand($min,$max);
    }
    public function send_code_to_phone($username,$code){
        $last_time = session($username.'_last_send_time');
        echo "send_code_to_phone：{$username}=>{$code}=>{$last_time}";
    }
    public function send_code_to_email($username,$code){
        echo "send_code_to_email：{$username}=>{$code}=>{session($username.'_last_send_time')}";
    }
    public function setsession(){
        Session::set("test",'1234');
    }
    public function getsession(){
        echo Session::get("test");
    }
    public function delsession(){
        echo Session::delete("test");
        echo Session::delete("13800138000_code");
    }
}
