<?php
//支付回调
use aop\AopClient;
global $_W,$_GPC;

include 'aop/AopClient.php'; 
include '../../../framework/bootstrap.inc.php';

$aop = new AopClient();

//$public_path = $_W['siteroot']. 'addons/db_play/alipay_sdk/rsa_public_key.pem';//公钥路径
$aop->alipayrsaPublicKey = 'MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAoLz//qcgRNV/CdlXUpyInTl3lEsER4cvL6AoiD0YcJcdJ7AQdLbPWCR6J++KZrhn4hAd13EcPRKBLZkqtdWfOg4YlEgRrX9TwSmsghMy+GvpqXL2q4MgVP17DS2x44qcgbMlWcZKlxABIG0G2mJQ+v1vQuKQ0pajVz832PM87iIF44lFIQbON59HAOcGnVo6YixaUxKTwD2cwslJH+0ymvrpPs89O+2tPeKMjVYasmd11R0xoklCPHnt3vhgqjLcGojbDT4RFy5M2bboeG54tRBqn1KKMf6aEld0wK8TpfDY4Jo90Hq31UeieGF8m0SY5SOCSozwD6Zyx0nbIfpOVQIDAQAB';//支付宝公钥

//此处验签方式必须与下单时的签名方式一致
$flag = $aop->rsaCheckV1($_POST, null, "RSA2");

//验签通过后再实现业务逻辑，比如修改订单表中的支付状态。
/**
*  ①验签通过后核实如下参数out_trade_no、total_amount、seller_id
*  ②修改订单表
**/
//打印success，应答支付宝。必须保证本界面无错误。只打印了success，否则支付宝将重复请求回调地址。
if($flag) {//验证成功
	
$seller_id = '2088421423734853';
//请在这里加上商户的业务逻辑程序代
//商户订单号
$out_trade_no = substr($_POST['out_trade_no'], 3);
 // file_put_contents('./info2.txt',$out_trade_no."\r\n",FILE_APPEND);
$log_info = pdo_fetch('SELECT * FROM ' . tablename('db_play_paylog') . ' WHERE id = :id',array(':id' => intval($out_trade_no)));

$uniacid = $log_info['uniacid'] ? $log_info['uniacid'] : intval($_POST['body']);
$setting = uni_setting($uniacid, array('payment', 'recharge'));
$alipay = $setting['payment']['alipay'];
	
//——请根据您的业务逻辑来编写程序（以下代码仅作参考）——
	
//获取支付宝的通知返回参数，可参考技术文档中服务器异步通知参数列表

//支付宝交易号
$trade_no = $_POST['trade_no'];
//交易状态
$trade_status = $_POST['trade_status'];
    
$pay_money = $_POST['total_amount'];

if($pay_money != $log_info['order_amount'] || $_POST['seller_id'] != $seller_id){
    logResult('订单:'.$out_trade_no.'付款失败!');
    exit();
}

if($_POST['trade_status'] == 'TRADE_FINISHED') {
//判断该笔订单是否在商户网站中已经做过处理
	//如果没有做过处理，根据订单号（out_trade_no）在商户网站的订单系统中查到该笔订单的详细，并执行商户的业务程序
	//请务必判断请求时的total_fee、seller_id与通知时获取的total_fee、seller_id为一致的
	//如果有做过处理，不执行商户的业务程序
    payResult($log_info,$pay_money,$trade_no);
//注意：
	//退款日期超过可退款期限后（如三个月可退款），支付宝系统发送该交易状态通知

    //调试用，写文本函数记录程序运行情况是否正常
        //logResult("这里写入想要调试的代码变量值，或其他运行的结果记录");
} else if ($_POST['trade_status'] == 'TRADE_SUCCESS') {
    payResult($log_info,$pay_money,$trade_no);
	//判断该笔订单是否在商户网站中已经做过处理
		//如果没有做过处理，根据订单号（out_trade_no）在商户网站的订单系统中查到该笔订单的详细，并执行商户的业务程序
		//请务必判断请求时的total_fee、seller_id与通知时获取的total_fee、seller_id为一致的
		//如果有做过处理，不执行商户的业务程序
				
	//注意：
	//付款完成后，支付宝系统发送该交易状态通知

    //调试用，写文本函数记录程序运行情况是否正常
    //logResult("这里写入想要调试的代码变量值，或其他运行的结果记录");
}

//——请根据您的业务逻辑来编写程序（以上代码仅作参考）——
        
echo "success";		//请不要修改或删除
	
} else {
    //验证失败
    echo "fail";

    //调试用，写文本函数记录程序运行情况是否正常
    //logResult("这里写入想要调试的代码变量值，或其他运行的结果记录");
}

function payResult($pay_log,$money,$out_no) {
    $order_id = $pay_log['id'];

    $save['is_paid'] = 1;
    $save['pay_money'] = $money;
    $save['pay_time'] = time();
    $save['out_trade_no'] = $out_no;

    if($pay_log['order_type'] == 1){
        /*充值订单*/
        $order_info = pdo_fetch('SELECT * FROM ' . tablename('db_play_recharge_log') . ' WHERE id = :id',array(':id' => $pay_log['order_id']));

        if($order_info['status'] == 0){
            pdo_begin();
            //保存paylog状态
            pdo_update('db_play_paylog',$save,array('id'=>$order_id));

            //更新用户余额
            $queryy=pdo_query('UPDATE ' . tablename('db_play_member').
                ' SET credit1 = credit1 + :money WHERE id = :id',
                array(':money' => $order_info['money'],':id' => $order_info['user_id'])
            );
            //记录日志
            pdo_insert('db_play_order_op_log',
                    array('user_id' => $order_info['user_id'],
                        'operation' => 'alipay',
                        'money' => $money,
                        'order_id' => $pay_log['order_id'],
                        'operate_time' => date('Y-m-d H:i:s',time()),
                        'note' => '用户支付宝充值'
                    )
            );
            //保存充值订单的状态
            $order_save['status'] = 1;
            pdo_update('db_play_recharge_log',$order_save,array('id' => $pay_log['order_id']));

            pdo_commit();

            //发送消息
            $jg_id = pdo_fetchcolumn('SELECT `jg_id` FROM ' . tablename('db_play_member') . ' WHERE id = :id',array(':id' => $order_info['charge_id']));
            $msg = array(
                'type' => 2,
                'content' => '您已成功充值账户'.($order_info['money']) . '金币',
                'user_id' => $order_info['charge_id'],
                'createtime' => time(),
                'title' => '充值提醒',
                );
            $extras = array(
                'msg_type' => '2',
                'user_id' => $order_info['charge_id'],
                );
            pdo_insert('db_play_msg',$msg);

            if ($jg_id) {

                require_once '../jpush/autoload.php';
                $client = new \JPush\Client('f13388e6c00b870625d3f266', '2b6a99097a0d4cad8dfebdb8');
                $pusher = $client->push()->setPlatform(array('ios', 'android'))->addRegistrationId($jg_id)->iosNotification($msg['content'],array('extras' => $extras))->androidNotification('【充值提醒】' . $msg['content'],array('extras' => $extras))->options(array('apns_production' => true))->send();
            }

        }

//

    }elseif($pay_log['order_type'] == 2){
        /*服务订单*/
        $order_info = pdo_fetch("select m.jg_id,o.seller_id,ordertype,o.user_id,o.status,o.record_id,o.room_id from ".tablename('db_play_order')." o left join ".tablename('db_play_member')." m on o.seller_id=m.id where o.id=".$pay_log['order_id']);
        if ($order_info['status'] == 0) {
            if ($order_info['ordertype'] == 1) {//技能订单
                pdo_begin();
                //保存paylog状态
                pdo_update('db_play_paylog',$save,array('id'=>$order_id));
                $order['status'] = 1;
                $order['paytype'] = 1;
                $order['price'] = $money;
                pdo_update('db_play_order',$order,array('id'=>$pay_log['order_id']));
                pdo_insert('db_play_order_op_log',
                        array('user_id'=>$order_info['user_id'],
                            'operation'=>'alipay',
                            'money'=>$money,
                            'order_id'=>$pay_log['order_id'],
                            'operate_time'=>date('Y-m-d H:i:s',time()),
                            'note'=>'用户支付宝付款' 
                        )
                );
                pdo_commit();

                $mobile = $order_info['mobile'];
                $msg = array(
                    'type' => 3,
                    'content' => '您有一笔新的订单，快去服务吧',
                    'user_id' => $order_info['seller_id'],
                    'createtime' => time(),
                    'order_id' => $pay_log['order_id'],
                    );
                $extras = array(
                    'msg_type' => '3',
                    'order_id' => $pay_log['order_id'],
                    'user_type' => '2',
                    'user_id' => $order_info['seller_id'],
                    );
                pdo_insert('db_play_msg',$msg);
                if ($order_info['jg_id']) {
                    require_once '../jpush/autoload.php';
                    $client = new \JPush\Client('f13388e6c00b870625d3f266', '2b6a99097a0d4cad8dfebdb8');
                    $pusher = $client->push()->setPlatform(array('ios', 'android'))->addRegistrationId($order_info['jg_id'])->iosNotification($msg['content'],array('extras'=>$extras))->androidNotification($msg['content'],array('extras'=>$extras))->options(array('apns_production'=>true))->send();
                }
                $rmsg = array(
                    'content' => '已收到订单，将尽快确认',
                    );
                $rmsg = json_encode($rmsg);
                include '../rongcloud/rongcloud.php';
                $appKey = 'pwe86ga5picj6';
                $appSecret = 'yRmqobKChoDG';
                $jsonPath = "jsonsource/";
                $RongCloud = new RongCloud($appKey,$appSecret);
                $result = $RongCloud->message()->publishPrivate($order_info['seller_id'],$order_info['user_id'],'RC:TxtMsg',$rmsg);
                include ('../plugs/lib/Ucpaas.class.php');
                $options['accountsid']='bfb6cbd0ea3fad98d6619995376a11f8';//C('SMS.accountsid'); //填写自己的
                $options['token']='f7c3edaf4612a1668788fddc31d4243d';//C('SMS.token'); //填写自己的
    //初始化 $options必填
                $appId = 'd6af4b19e01545b4b61b476df75533bf';//C('SMS.appid');  //填写自己的
    
                //初始化 $options必填

                $ucpass = new Ucpaas($options);
 
                $phone = trim(htmlspecialchars($mobile));

                $templateId = '228607';//C('SMS.templateId');//填写自己的?
                $param=$msg['content'];

            //短信验证码（模板短信）,默认以65个汉字（同65个英文）为一条（可容纳字数受您应用名称占用字符影响），超过长度短信平台将会自动分割为多条发送。分割后的多条短信将按照具体占用条数计费。
                $arr=$ucpass->templateSMS($appId,$phone,$templateId,$param);
                //  log_resultN('SMS',json_encode($arr));
                $res =  json_decode($arr,true);

                if( $res['resp']['respCode'] == "000000") {
                    $code = array(
                        'sms_time' => time(),
                        'smscodes' => $param,
                        'reset_user_name' => $phone,
                        );
                    file_put_contents('logn1.txt',$res);
                }else{
                    //如果不成功
                    $_SESSION['sms_time']=null;
                    file_put_contents('logn.txt',$res);
                }
            } else {//打赏
                pdo_begin();

                //保存paylog状态
                pdo_update('db_play_paylog',$save,array('id'=>$order_id));

                $order['status'] = 3;//支付之后状态变为3
                $order['paytype'] = 1;
                $order['paytime'] = time();
                $order['finishtime'] = time();
                $order['price'] = $money;
                pdo_update('db_play_order',$order,array('id'=>$pay_log['order_id']));
                pdo_query('update ims_db_play_member set credit2 = credit2 + :money where id=:id',array(':money'=>$money,':id'=>$order_info['seller_id']));
                // logging_run($order_info['user_id'].'支付了'.$money,'error','order_log');
                // logging_run($order_info['seller_id'].'收入了'.$money,'error','order_log');
                // $order_save['status'] = 3;
                // pdo_update('db_play_order',$order_save,array('id'=>$pay_log['order_id']));
                //记录日志
                pdo_insert('db_play_order_op_log',
                        array('user_id'=>$order_info['user_id'],
                            'operation'=>'alipay',
                            'money'=>$money,
                            'order_id'=>$pay_log['order_id'],
                            'operate_time'=>date('Y-m-d H:i:s',time()),
                            'note'=>'用户支付宝打赏' 
                        )
                );

                pdo_commit();
                if (!empty($order_info['record_id'])) {
                    // $tips = pdo_fetchcolumn("select tips_number from ".tablename('db_play_interaction_record')." where record_id=".$order_info['record_id']);
                    // pdo_update("db_play_interaction_record",array('tips_number'=>intval($tips)+1),array('record_id'=>$order_info['record_id']));
                    pdo_query('update ims_db_play_interaction_record set tips_number=tips_number+1 where record_id=:record_id',
                        array(':record_id'=>$order_info['record_id']));
                    $msg = array(
                        'type' => 2,
                        'content' => $money,
                        'sender' => $order_info['user_id'],
                        'resiver' => $order_info['seller_id'],
                        'record_id' => $order_info['record_id'],
                        'createtime' => time(),
                        );
                    pdo_insert('db_play_record_msg',$msg);
                    $no_read = pdo_fetchcolumn("select count(*) from ".tablename('db_play_record_msg')." where is_read=0 and resiver=".$order_info['seller_id']);
                    $msginfo = pdo_fetch("select u.nickname,u.avatar,m.content,m.sender,m.resiver,m.record_id,m.createtime,p.photo_url thumb,m.type from ".tablename('db_play_record_msg')." m left join ".tablename('db_play_member')." u on u.id=m.sender left join ".tablename('db_play_interaction_photo')." p on p.record_id=m.record_id where m.resiver=".$order_info['seller_id']." and m.sender=".$order_info['user_id']." and m.createtime=".$msg['createtime']);
                    $extras = array(
                        'msg_type' => 5,
                        'no_read' => $no_read,
                        'msg_info' => $msginfo,
                        'user_id' => $order_info['seller_id'],
                        );
                    $msg_content = array(
                        'title' => '打赏',
                        'content' => 'text',
                        'extras' => $extras,
                        );
                    if ($order_info['jg_id']) {
                        require_once '../jpush/autoload.php';
                        $client = new \JPush\Client('039f19fed38474319370bd39', '77498da77979412a61b7e73b');
                        $pusher = $client->push()->setPlatform(array('ios', 'android'))->addRegistrationId($order_info['jg_id'])->message($msg['content'],$msg_content)->send();
                    }
                    
                }
                if (!empty($order_info['room_id'])) {
                    $room_id = pdo_fetchcolumn("select text_room from ".tablename('db_play_room')." where id=".$order_info['room_id']);
                    $user = pdo_fetch("select id,nickname from ".tablename('db_play_member')." where id=".$order_info['user_id']);
                    $seller = pdo_fetch("select id,nickname from ".tablename('db_play_member')." where id=".$order_info['seller_id']);
                    $ext = array(
                        'operation' => 21,
                        'money' => $money,
                        'user' => $user,
                        'seller' => $seller, 
                        );
                    $ect = json_encode($ext);
                    include '../vcloud/ServerAPI.php';
                    $appkey = '5866bf21a4678dff891f5545cba57214';
                    $appsecret = '332050069dba';
                    // $appkey = '6ab1e717520a0f86fd6037b94a644c23';
                    // $appsecret = '3e29cc0575e3';
                    $url = 'https://api.netease.im/nimserver/chatroom/sendMsg.action';
                    $data = array(
                        'roomid' => $room_id,
                        'msgId' => $room_id.time(),
                        'fromAccid' => $order_info['user_id'],
                        'msgType' => 100,
                        'ext' => $ect,
                        );
                    $vc = new ServerAPI($appkey,$appsecret,'curl');
                    $result = $vc-> postDataCurl($url,$data);
                }
            }
        }
    }

}
?>