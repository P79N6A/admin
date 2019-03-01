<?php
global $_W,$_GPC;
/* *
 * 配置文件
 * 版本：3.4
 * 修改日期：2018-03-12
 * 说明：
 * 以下代码只是为了方便商户测试而提供的样例代码，商户可以根据自己网站的需要，按照技术文档编写,并非一定要使用该代码。
 * 该代码仅供学习和研究支付宝接口使用，只是提供一个参考。

 * 安全校验码查看时，输入支付密码后，页面呈灰色的现象，怎么办？
 * 解决方法：
 * 1、检查浏览器配置，不让浏览器做弹框屏蔽设置
 * 2、更换浏览器或电脑，重新登录查询。
 */

//↓↓↓↓↓↓↓↓↓↓请在这里配置您的基本信息↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓
//合作身份者ID，签约账号，以2088开头由16位纯数字组成的字符串，查看地址：https://b.alipay.com/order/pidAndKey.htm
$alipay_config['partner'] = '2088421423734853';
$alipay_config['appid']	= '2018011701923919';

//收款支付宝账号，以2088开头由16位纯数字组成的字符串，一般情况下收款账号就是签约账号
$alipay_config['seller_id']	= $alipay_config['partner'];

// MD5密钥，安全检验码，由数字和字母组成的32位字符串，查看地址：https://b.alipay.com/order/pidAndKey.htm
// $alipay_config['key']			= 'pun33ykbnrznzmhyr7xhnnzd8pid41ln';

$alipay_config['private_key'] = 'MIIEowIBAAKCAQEAvaTSvqFFkVbtJcnt/OQG17nqWw7NJx/OgsY9mNk6cXQBfJPiPzEwpuYAPH7e5wifM41tHiLZhEX1I6BByUTodNGHDqAebZXpVDA8YiWoYIbH3Rbuniw3Xs4AGhv+3AGrWefSdHCKZAiby6dwxenG6pFZ5rmb4hi3MqPhhMvJ41kQfB8inDP+eLTcSgBAITVDz27S+IK52pTeuk2IN6rV1/OPv3IPg2gp8N5z728s5U3WoL9hihCRqztcBUbazXbzpv+1uTyNoA6+IRMy5xVRiPy4lXSUccYmnnhA+amSecMiipJKfsG2gvsnT2g0w2mQXYETJ/Jd3QjDiLYYBcRqmwIDAQABAoIBAG1GQxULEm3726wxncthjTvS6eJMNhQ8NJ+QIUAos49aG90vzWdCLdmNoEc7h68yfaGT9XMu+41HTkiX+DBEX3monhzkUIQupIMZREH9lvb/0rxnkVlc+w7Kvq5MwV7+K0Ej3lWv315iw3rm4Yl4+mCBHn9fJh5yxWUNn04Iqy0vTfFcEng8X+yiTwiltBV4BmB34wKgXusqkPCdhYIRyN+j0AVBL0SPDLdjPw1k4DwDwT97WpwE30J6t/0kmFyQv1ry6wiTxcGHoPnrqVJ+dWlvtdAAWWVP/QcLZgqNJsdnIg4ZpR9+FQ2nk6zILNqySlREfLlIR2/A1OiDqJREhPkCgYEA+bIuxHQmWxCGqopXye6X4EE0Arx66qxa6gdRjd6rqrWoFiNwgePXIeir8dLQsCK0QDTwdcfr2RYoxIFwV4EmQFAluxmGSPuoZ9mATIh2PZNiRyuRxhvGvE50kP5RTR8GjwWHYEZbX22A4R/66jzSlaos47h6bb6XWT3lv14MX70CgYEAwm6D/bpm6xNmL3NqQGQBukxCo9rZZU6wNcw/OB1wr260VjjQA76V7I2jRqXUOlwBOZtHRSN5jZY0c01GjgdDKcXIfupDaD58kbHi8HguH/dG436hBMnDHpUviMIWR9vkn8uMK8KLF8aEVQdzkjBPlpNrtzdNr4N/YertFRaQTTcCgYA2x7qu6vSHQgbpX1SHPssfLe7lMsict5dyhIyF3XY4C4aG5NuIA55tGAixExkpq1N0Sqj+jg/WHqBvDB7Dc9gaf/rnI2BsnpmBvxwArmeSdsU26/4dQnbFVUkJjmHz03yy3/mlS4o8U1/VBBkeTp28rAsRIqXpccjukT/YTh/U2QKBgDy5L1frA4GfiWaAcUqy8Scx8g4ip4rQTJBAve3UpADmXkQfcjf5KfG7Oqcx21puqaNIL7YUIj5qDu+DzulEs2E0eC3LFEpWWalXGT1pC17IZ8ddIQTRzrKafUIE+9htgLW3aIuyMqa2RVYZAatCk1i/qgCKsSSDuSDnsivH5EF5AoGBAJkYCur5O/T6bQtTSGt6I7jFQ6sHY3hpnPjY4qQBrYTSbEaIQUWLeTKXbF+5A8LMeDIg6DcVFFidigCa8tKS306Mmnc6bR2tdQ6tru9WNA+TVQn5DPpcPOJmTfNVr09VN0hvyfaCVg/bzN3797xzuJxWwZ9BKktBWx1eF+w5LF1p';

$alipay_config['public_key'] = 'MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAvaTSvqFFkVbtJcnt/OQG17nqWw7NJx/OgsY9mNk6cXQBfJPiPzEwpuYAPH7e5wifM41tHiLZhEX1I6BByUTodNGHDqAebZXpVDA8YiWoYIbH3Rbuniw3Xs4AGhv+3AGrWefSdHCKZAiby6dwxenG6pFZ5rmb4hi3MqPhhMvJ41kQfB8inDP+eLTcSgBAITVDz27S+IK52pTeuk2IN6rV1/OPv3IPg2gp8N5z728s5U3WoL9hihCRqztcBUbazXbzpv+1uTyNoA6+IRMy5xVRiPy4lXSUccYmnnhA+amSecMiipJKfsG2gvsnT2g0w2mQXYETJ/Jd3QjDiLYYBcRqmwIDAQAB';

// 服务器异步通知页面路径  需http://格式的完整路径，不能加?id=123这类自定义参数，必须外网可以正常访问
$alipay_config['notify_url'] = $_W['siteroot'] . 'addons/db_play/alipay_sdk/app_notify_url.php';

// 页面跳转同步通知页面路径 需http://格式的完整路径，不能加?id=123这类自定义参数，必须外网可以正常访问
$alipay_config['return_url'] = "http://商户网址/create_direct_pay_by_user-PHP-UTF-8/return_url.php";

//签名方式
// $alipay_config['sign_type']    = strtoupper('MD5');
$alipay_config['sign_type'] = 'RSA2';

//字符编码格式 目前支持 gbk 或 utf-8
$alipay_config['input_charset']= strtolower('utf-8');

//ca证书路径地址，用于curl中ssl校验
//请保证cacert.pem文件在当前文件夹目录中
$alipay_config['cacert'] = getcwd().'\\cacert.pem';

//访问模式,根据自己的服务器是否支持ssl访问，若支持请选择https；若不支持请选择http
$alipay_config['transport'] = 'http';

// 支付类型 ，无需修改
$alipay_config['payment_type'] = "1";
		
// 产品类型，无需修改
$alipay_config['service'] = "create_direct_pay_by_user";

//↑↑↑↑↑↑↑↑↑↑请在这里配置您的基本信息↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑

//↓↓↓↓↓↓↓↓↓↓ 请在这里配置防钓鱼信息，如果没开通防钓鱼功能，为空即可 ↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓
	
// 防钓鱼时间戳  若要使用请调用类文件submit中的query_timestamp函数
$alipay_config['anti_phishing_key'] = "";
	
// 客户端的IP地址 非局域网的外网IP地址，如：221.0.0.1
$alipay_config['exter_invoke_ip'] = "";
		
//↑↑↑↑↑↑↑↑↑↑请在这里配置防钓鱼信息，如果没开通防钓鱼功能，为空即可 ↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑

?>