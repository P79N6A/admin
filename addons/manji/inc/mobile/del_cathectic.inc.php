<?php 
global $_W,$_GPC;
header('content-type: application/json; charset=utf-8');
header("access-control-allow-origin: *");
$weid = $_W['uniacid'];
$user_id = $_GPC['user_id'];
$token = $_GPC['token'];
$check_login =  appLogin($user_id,$token);
if ($check_login !=1) {
    $data = array(
        'status' => 403,
        'info'   => '已在另外的设备上登录',
    );
    echo json_encode($data);
    exit();
}

$cid =  $_GPC['cid']?$_GPC['cid']:0;
$res = pdo_update('manji_order',array('status'=>2),array('user_id'=>$user_id,'id'=>$cid));
if($res!==false){
    $data['info'] = '操作成功' ;
}else{
    $data  = array('status'=>300,'info'=>'操作失败');
}
echo json_encode($data);

 ?>