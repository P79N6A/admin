<?php 
global $_W,$_GPC;

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

$jackpot = pdo_fetch('select * from '.tablename('manji_jackpot'));
$jackpot['status'] = 200;
echo json_encode($jackpot);
exit;






 ?>