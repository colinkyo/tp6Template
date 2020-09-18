<?php
/**
 * Created by PhpStorm.
 * User: 7.Yan
 * Date: 2020/7/15
 * Time: 10:17
 */

namespace app\index\controller;

//https://blog.csdn.net/qq_33845254/article/details/82426084
//记得查看example的例子
class Pay
{
    public function demo1(){
        require_once 'E:/App/tp6/app/index/common/WxpayAPI/WxPay.Api.php';
        require_once 'E:/App/tp6/app/index/common/WxpayAPI/WxPay.Config.php';
        $input = new \WxPayUnifiedOrder();
        //设置商品
        $input->SetBody("测试商品");
        //订单号
        $input->SetOut_trade_no(date('YmdHis'));
        //金额 单位分
        $input->SetTotal_fee(0.01);
        //设置推送地址
        $input->SetNotify_url('https://demo.mpay.com.hk/return.jsp');
        //港币
        $input->SetFee_type("HKD");
        //
        $input->SetTrade_type('JSAPI');
        //
        $input->SetOpenid('ohG4F5mjgoAQJUJd9Da7l3d55sSk');
        //调用API
        $config = new \WxPayConfig();
        $order = \WxPayApi::unifiedOrder($config, $input);
        echo '<font color="#f00"><b>统一下单支付单信息</b></font><br/>';
        dump($order);

    }
}
