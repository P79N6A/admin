<?php 
global $_W,$_GPC;
header('content-type: application/json; charset=utf-8');
header("access-control-allow-origin: *");
$weid = $_W['uniacid'];
$user_id = $_GPC['user_id'];
$token = $_GPC['token'];
$agent_id = $_GPC['agent_id']?$_GPC['agent_id']:0;
$type = $_GPC['type']?$_GPC['type']:1;
$check_login =  appLogin($user_id,$token);
if ($check_login !=1) {
    $data = array(
        'status' => 403,
        'info'   => '已在另外的设备上登录',
    );
    echo json_encode($data);
    exit();
}
if (!$agent_id) {
    if ($type == 1) {
        $data = array(
            'status' => 300,
            'info'   => '请选择冻结账号',
        );
    }
    else{
        $data = array(
            'status' => 300,
            'info'   => '请选择解冻账号',
        );
    }
    echo json_encode($data);
    exit();
}

$agent = pdo_fetch('select is_black from '.tablename('member_system_member').' where id=:id',array(':id'=>$agent_id));
if(empty($agent)){
    if ($type == 1) {
        $data = array(
            'status' => 300,
            'info'   => '请选择冻结账号',
        );
    }
    else{
        $data = array(
            'status' => 300,
            'info'   => '请选择解冻账号',
        );
    }
    echo json_encode($data);
    exit();
}
if ($type == 1) {
    $res = pdo_update('member_system_member',array('is_black'=>1),array('id'=>$agent_id));
}
else{
    $res = pdo_update('member_system_member',array('is_black'=>0),array('id'=>$agent_id));
}
if($res!==false){
    $data['status'] = 200;
    $data['info'] = '';
}else{
    $data['status'] = 300;
    $data['info'] = '操作失败';

}

echo json_encode($data);







 ?>