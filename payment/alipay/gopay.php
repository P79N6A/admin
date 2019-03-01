<?php
defined('IN_IA') or exit('Access Denied');
use aop\AopClient;
//返回支付url
function alipay($content){
    global $_W,$_GPC;	
    include  'aop/AopClient.php';
    include  'app_notify_url.php';
    $aop = new AopClient ();
    $aop->gatewayUrl = 'https://openapi.alipay.com/gateway.do';
    $aop->appId = $alipay_config['appid'];
    $aop->rsaPrivateKey = $alipay_config['private_key'];

    $aop->alipayrsaPublicKey=$alipay_config['public_key'];

    $aop->apiVersion = '1.0';
    $aop->signType = $alipay_config['sign_type'];
    $aop->postCharset='utf-8';
    $aop->format='json';
    $private_path = 'rsa_private_key.pem';//私钥路径
    //构造业务请求参数的集合(订单信息)
    // $content = array();
    /*$content['subject'] = "商品的标题";
    $content['out_trade_no'] = "12345678910";
    $content['timeout_express'] = "30m";
    $content['total_amount'] = "10";*/
    // $content['product_code'] = "QUICK_MSECURITY_PAY";//销售产品码,固定值
    $con = json_encode($content$content是biz_content的值,//将之转化成json字符串
    $param['app_id'] = $alipay_config['appid'];
    $param['method'] = 'alipay.trade.app.pay';//接口名称，固定值
    $param['charset'] = 'utf-8';//请求使用的编码格式
    $param['sign_type'] = $alipay_config['sign_type'];//商户生成签名字符串所使用的签名算法类型
    $param['timestamp'] = date("Y-m-d H:i:s",time());//发送请求的时间
    $param['version'] = '1.0';//调用的接口版本，固定为：1.0
    // $a = $_W['siteroot']. 'addons/db_play/alipay_sdk/app_notify_url.php';
    // $a = IA_ROOT. '/addons/db_play/alipay_sdk/app_notify_url.php';
    $param['notify_url'] = $alipay_config['notify_url'];
    // file_put_contents('./site.txt','1:'.$param['notify_url']."\n\r",FILE_APPEND);
    $param['biz_content'] = $con;//业务请求参数的集合,长度不限,json格式，即前面一步得到的
    $paramStr = $aop->getSignContent($param);//组装请求签名参数

    $sign = $aop->alonersaSign($paramStr, $private_path, 'RSA2', true);//生成签名
    $param['sign'] = $sign;
    $param['biz_content']=$con;
    $str = $aop->getSignContentUrlencode($param);//最终请求参数
    //返回支付地址
    return $str;
}