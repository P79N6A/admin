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

$password = $_GPC['new_password']?$_GPC['new_password']:'';
if(empty($password)){
    $data = array(
        'status' => 303,
        'info'   => '请输入新密码',
    );
    echo json_encode($data);
    exit();
}

$password = decrypt_password($password);
$password = md5($password);

    $res = pdo_update('member_system_member',array('password'=>$password, ), array('id'=>$user_id));
    if($res!==false){
        $data = array(
            'status' => 200,
            'info'   => '修改成功',
        );
    }else{
        $data = array(
            'status' => 402,
            'info'   => '修改失败',
        );
    }


echo json_encode($data);

?>