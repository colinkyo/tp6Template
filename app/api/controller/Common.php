<?php
/**
 * Created by PhpStorm.
 * User: 7.Yan
 * Date: 2020/7/21
 * Time: 15:52
 */

namespace app\api\controller;


use app\BaseController;
use think\App;
use think\facade\Cache;
use think\facade\Request;
use think\facade\Db;
//加载验证规则
use app\api\validate\ValidateData;
use think\facade\Session;
use think\facade\Validate;
use think\facade\Filesystem;
use think\Image;

class Common extends BaseController
{
    protected $request;
    protected $validate;
    protected $params;
    protected $rules = [
      'User' => [
        'login' => [
          'user_name' => 'require|chsDash|max:25',
          'user_pwd' => 'require|length:32',
          'age' => 'number|between:1,120',
          'email' => 'email'
        ],
        'msg' => [
          'user_name.require' => '名称必须',
          'user_name.max' => '名称最多不能超过25个字符',
          'user_pwd.require' => '密码必须',
          'user_pwd.length' => '密码必须为32个字符',
          'age.number' => '年龄必须是数字',
          'age.between' => '年龄只能在1-120之间',
          'email' => '邮箱格式错误'
        ],
        'register' => [
          'user_name' => 'require|chsDash|max:25',
          'user_pwd' => 'require|length:32',
          'code' => 'require|number|length:6'
        ],
        'signin' => [
          'user_name' => 'require|chsDash|max:25',
          'user_pwd' => 'require|length:32'
        ],
        'upload_head_img' => [
          'user_id' => 'require|number',
          'user_icon' => 'require|image|fileSize:2000000|fileExt:jpg,jpeg,png,bmp'
        ],
        'change_pwd' => [
          'user_name' => 'require|chsDash|max:25',
          'user_ini_pwd' => 'require|length:32',
          'user_pwd' => 'require|length:32'
        ],
        'find_pwd' => [
          'user_name' => 'require|chsDash|max:25',
          'user_pwd' => 'require|length:32',
          'code' => 'require|number|length:6'
        ]
      ],
      'Code' => [
        'setsession' => [],
        'getsession' => [],
        'delsession' => [],
        'get_code' => [
          'username' => 'require',
          'is_exist' => 'require|number|length:1'
        ],
        'msg' => [
          'username.require' => '名称必须',
          'is_exist.require' => 'is_exist必须',
          'is_exist.number' => 'is_exist必须为数字'
        ]
      ]
    ];

    /*public function __construct(Request $request)
    {
        $this->request = $request;
    }*/
    public function __construct()
    {
        $this->request = Request::instance();
        //$this->check_time($this->request->only(['time']));
        //$this->check_token($this->request->param());

        //这个获取不会获取到file文件上传参数，需要下面的获取参数方法
        //$this->params = $this->check_params($this->request->except(['time', 'token']));
        //这样才能获取file文件上传参数
        $files        = is_array(Request::file()) ? Request::file() : [];
        $this->params = $this->check_params(array_merge($this->request->except(['time', 'token']), $files));
    }

    /**
     * @param $arr
     */
    public function check_time($arr)
    {

        if (!isset($arr['time']) || intval($arr['time']) <= 1) {
            $this->return_msg(400, '时间戳不正确!');
        }
        if (time() - intval($arr['time']) > 60000) {
            $this->return_msg(400, '请求超时!');
        }
    }

    /**
     * @param $code
     * @param string $msg
     * @param array $data
     */
    public function return_msg($code, $msg = '', $data = [])
    {
        $return_data['code'] = $code;
        $return_data['msg']  = $msg;
        $return_data['data'] = $data;
        echo json_encode($return_data);
        die();
    }

    /**
     * @param $arr
     */
    public function check_token($arr)
    {
        if (!isset($arr['token']) || empty($arr['token'])) {
            $this->return_msg(400, 'token 不能为空!');
        }
        $app_token = $arr['token'];

        unset($arr['token']);

        //生成服务器token ，与app 传递的token比较，防止数据被修改
        $service_token = '';
        foreach ($arr as $key => $value) {
            $service_token .= md5($value);
        }

        $service_token = md5('api_' . $service_token . '_api');
        //echo $service_token;exit();

        if ($app_token !== $service_token) {
            $this->return_msg(400, 'token 不正确!');
        }
    }

    /**
     * @param $arr
     * @return mixed
     */
    public function check_params($arr = [])
    {
        //echo Request::controller();
        //echo  Request::action();
        //echo md5($arr['user_pwd'])."<br />";
        //$rule = $this->rules[Request::controller()][Request::action()];
        //固定参数验证
        $data = [
          'user_name' => 'thinkphp',
          'email' => 'thinkphp@qq.com',
        ];
        //提交的参数验证
        //$data = Request::post();
        //待验证参数
        $data = $arr;
        //静态类调用方式
        /*try {
            validate(UserValidate::class)->check($data);
            return $arr;
        } catch (ValidateException $e) {
            // 验证失败 输出错误信息
            $this->return_msg(400,$e->getError());
        }*/

        //实例化调用方式

        /*$rule =   [
            'user_name'  => 'require|chsDash|max:25',
            'user_pwd' => 'require|length:32',
            'age'   => 'number|between:1,120',
            'email' => 'email',
        ];

        $message  =   [
            'user_name.require' => '名称必须',
            'user_name.max'     => '名称最多不能超过25个字符',
            'user_pwd.require' => '密码必须',
            'user_pwd.length'     => '密码最多不能超过32个字符',
            'age.number'   => '年龄必须是数字',
            'age.between'  => '年龄只能在1-120之间',
            'email'        => '邮箱格式错误'
        ];*/
        /*echo Request::controller()."<br />";
        echo Request::action()."<br />";
        echo Request::rule()->getName()."<br />";
        echo Request::rule()->getRule()."<br />";
        exit;*/
        /***
         *
         * 传 http://api.yan/api/code/1/2/dsfdsadsfd@.com/0 有bug 获取不到 code 和 get_code 获取到了code 和 1
         * 暂时未知是route 问题还是其他问题,应该是路由配置问题多点
         *
         *
         */
        //传 http://api.yan/api/code/1/2/dsfdsadsfd@.com/0 有bug 获取不到 code 和 get_code 获取到了code 和 1
        $rule    = $rule = $this->rules[Request::controller()][Request::action()];
        $message = $this->rules[Request::controller()]["msg"];

        //这个可以，但是错误提示是默认的
        //$validate = new ValidateData($rule);

        $validate = new ValidateData($rule, $message);
        $result   = $validate->check($data);

        if (!$result) {
            $this->return_msg(400, $validate->getError());
        } else {
            return $arr;
        }
    }

    /**
     * @param $username
     * @return string
     */
    public function check_username($username)
    {
        $is_email = Validate::is($username, 'email') ? 1 : 0;
        $is_phone = preg_match('/^1[34578]\d{9}$/', $username) ? 4 : 2;
        $flag     = $is_email + $is_phone;
        switch ($flag) {
            case 2://not email and not phone
                $this->return_msg(400, '邮箱或手机号码不正确');
                break;
            case 3:
                return 'email';
                break;
            case 4:
                return 'phone';
                break;
        }
    }

    public function check_exist($username, $type, $exist)
    {
        //$exist == 0 为注册，1为修改
        $type_num = $type == 'phone' ? 2 : 4;
        $flag     = $type_num + $exist;

        $phone_res = Db::table('api_user')->where('user_phone', $username)->find();
        $email_res = Db::table('api_user')->where('user_email', $username)->find();

        switch ($flag) {
            // 2+0  phone need no exist
            case 2:
                if ($phone_res) {
                    $this->return_msg(400, "此手机号已经被占用");
                }
                break;
            // 2+1 phone need exist
            case 3:
                if (!$phone_res) {
                    $this->return_msg(400, "此手机号不存在");
                }
                break;
            case 4:
                // 4+0  email need no exist
                if ($email_res) {
                    $this->return_msg(400, "此邮箱已经被占用");
                }
                break;
            case 5:
                // 5+1 phone need exist
                if (!$email_res) {
                    $this->return_msg(400, "此邮箱不存在");
                }
                break;
        }
    }

    /**
     * @param $user_name
     * @param $code
     */
    public function check_code($user_name, $code)
    {
        /**
         *
         * 以下操作需要开启 redis 服务器和配置config/cache.php
         *
         */
        $redis = Cache::store('redis');
        $last_time = $redis->get($user_name . '_last_send_time',0);

        if (time() - $last_time > 60) {
            $this->return_msg(400, '验证码超时，请在1分钟内验证');
        }

        if ($redis->pull($user_name . '_code') !== md5($user_name . '-' . md5($code))) {
            $this->return_msg(400, '验证码不正确');
        }

        return;
        /**********session方式 检查验证码是否超时*****/
        $last_time = Session::get($user_name . '_last_send_time',0);
        if (time() - $last_time > 60) {
            $this->return_msg(400, '验证码超时，请在1分钟内验证');
        }

        /********** 检查验证码是否正确
         * 有bug 无法删除session 【E:\App\tp6\runtime\session\sess_60ef8e11fc94dd8da5173d7d3acf2e2e】
         * 这是由于 $this->return_msg  使用了 exit 或者 die 导致的
         *****/
        if (Session::pull($user_name . '_code') !== md5($user_name . '-' . md5($code))) {
            $this->return_msg(400, '验证码不正确');
        }

        /********** 清空验证码 *****/
        //Session::delete($user_name . '_last_send_time');
        Session::set($user_name . '_code',null);
        Session::delete($user_name . '_code');

    }

    public function upload_file($file, $type)
    {
        // 上传到本地服务器

        //上传的文件是可以直接访问或者下载的话 上传到这里 E:\App\tp6\public\storage\topic\20200723
        //$savename = Filesystem::disk('public')->putFile('topic', $file);

        //上传到这里 E:\App\tp6\runtime\storage\topic\20200723
        //$savename = Filesystem::putFile('topic', $file);


        //自定配置了 userconfig/filesystem.php
        $savename = Filesystem::disk('user')->putFile($type, $file, function () {
            return date("YmdHis", time());
        });

        if ($savename) {
            //显示的路径
            $path = Filesystem::getDiskConfig('user')['url'] . $savename;
            if ($type) {
                $this->image_edit($savename, $type);
            }
            return str_replace('\\', '/', $path);
        } else {
            $this->return_msg(400, '上传失败');
        }
    }

    public function image_edit($name, $type)
    {
        //磁盘的路径
        $imagepath = Filesystem::getDiskConfig('user')['root'] . $name;
        $image     = Image::open($imagepath);
        switch ($type) {
            case 'head_img':
                /**
                 * 1:需要加载库：composer require topthink/think-image
                 * 2：引入: use think\Image;
                 */
                $image->thumb(200, 200, Image::THUMB_CENTER)->save($imagepath);
                break;
        }
    }
}
