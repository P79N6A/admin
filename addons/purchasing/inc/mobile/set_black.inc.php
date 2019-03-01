<?php 
global $_W,$_GPC;

$user_id = $_SESSION['uid'];
$manager = $_SESSION['mid'];

if (empty($user_id) && empty($manager)) {
    $data = array(
        'status' => 3,
        'info' => '请先登录'
    );
    echo json_encode($data);
    exit;
}
$id = $_GPC['id']?$_GPC['id']:0;
$type = $_GPC['type']?$_GPC['type']:1;
if (!$id) {
    if ($type == 1) {
        $data = array(
            'status' => 2,
            'info'   => '请选择需要限制的账号',
        );
    }
    else{
        $data = array(
            'status' => 2,
            'info'   => '请选择解除限制的账号',
        );
    }
    echo json_encode($data);
    exit();
}
$status = pdo_fetchcolumn('select status from '.tablename('member_system_member').' where id=:id',array(':id'=>$member_id));
if ($status == 1) {
    $data = array(
        'status' => 2,
        'info' => '该用户已禁用，无法操作'
    );
    echo json_encode($data);
    exit;
}
$agent = pdo_fetch('select is_black from '.tablename('member_system_member').' where id=:id',array(':id'=>$id));
if(empty($agent)){
    if ($type == 1) {
        $data = array(
            'status' => 2,
            'info'   => '请选择需要限制的账号',
        );
    }
    else{
        $data = array(
            'status' => 2,
            'info'   => '请选择解除限制的账号',
        );
    }
    echo json_encode($data);
    exit();
}
$parent_id = pdo_fetchcolumn('select parent_agent from '.tablename('member_system_member').' where id=:id',array(':id'=>$id));
$nickname = pdo_fetchcolumn('select nickname from '.tablename('member_system_member').' where id=:id',array(':id'=>$id));
if (!empty($manager) && empty($user_id)) {
    $operator = '管理员';
}
elseif (!empty($manager) && $user_id != $parent_id) {
    $operator = '管理员';
}
else{
    $operator = pdo_fetchcolumn('select nickname from '.tablename('agent_member').' where id=:id',array(':id'=>$user_id));
}
if ($type == 1) {
    $res = pdo_update('member_system_member',array('is_black'=>1),array('id'=>$id));
}
else{
    $res = pdo_update('member_system_member',array('is_black'=>0),array('id'=>$id));
}
if($res!==false){
    $operation = array(
        'user_id' => $id,
        'user_type' => 2,
        'operation' => $operator.'对'.$nickname.'进行了限制投注设置',
        'create_time' => time()
    );
    pdo_insert('agent_operation',$operation);
    pdo_update('member_system_member',array('last_edit_time'=>time()),array('id'=>$id));
    $data['status'] = 1;
    $data['info'] = '操作成功';
}else{
    $data['status'] = 2;
    $data['info'] = '操作失败';

}

echo json_encode($data);

 ?>