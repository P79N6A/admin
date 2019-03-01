<?php 
global $_W,$_GPC;

$manager = $_SESSION['mid'];
if (empty($manager)) {
    $data = array(
        'status' => 3,
        'info'   => '请先登录',
    );
    echo json_encode($data);
    exit();
}

$agent_id = $_GPC['id'];
$limit = $_GPC['limit'];
$bet = $_GPC['bet'];

$agent = pdo_fetchcolumn('select count(id) from '.tablename('member_system_member').' where id=:id',array(':id'=>$agent_id));
if ($agent <= 0) {
	$data = array(
        'status' => 2,
        'info'   => '该下线代理不存在',
    );
    echo json_encode($data);
    exit();
}
$nickname = pdo_fetchcolumn('select nickname from '.tablename('member_system_member').' where id=:id',array(':id'=>$agent_id));
if ($_SESSION['level'] == 1) {
    $operator = '管理员';
}
else{
    $operator = pdo_fetchcolumn('select nickname from '.tablename('agent_member').' where id=:id',array(':id'=>$manager));
}

$res = pdo_update('member_system_member',array('pay_limit'=>$limit,'bet_limit'=>$bet),array('id'=>$agent_id));

$operation = array(
    'user_id' => $id,
    'user_type' => 1,
    'operation' => $operator.'对'.$nickname.'设置了投注限额',
    'create_time' => time()
);
pdo_insert('agent_operation',$operation);
pdo_update('member_system_member',array('last_edit_time'=>time()),array('id'=>$agent_id));

$data = array(
	'status' => 1,
	'info' => '操作成功'
);
echo json_encode($data);
exit;




 ?>