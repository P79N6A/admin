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
$memInfo = pdo_fetch("select id,nickname,credit1 as score from ".tablename('member_system_member')." where id=:id  ",
    array(':id'=>$user_id ));


$memInfo['status'] = 200;
$memInfo['info'] = '';
echo json_encode($memInfo);

 ?>