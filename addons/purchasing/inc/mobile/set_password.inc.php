<?php 
global $_W,$_GPC;

$user_id = $_SESSION['uid'];
$manager = $_SESSION['mid'];
$id = $_GPC['user_id'];
$type = $_GPC['user_type'];
$password = $_GPC['password'];
$nickname = $_GPC['nickname'];

if (empty($user_id) && empty($manager)) {
    $data = array(
        'status' => 405,
        'info' => '请先登录'
    );
    echo json_encode($data);
    exit;
}

switch ($type) {
	case '1':
		$table = tablename('agent_member');
		$nickname = pdo_fetchcolumn('select nickname from '.tablename('agent_member').' where id=:id',array(':id'=>$id));
		$parent_id = pdo_fetchcolumn('select parent_agent from '.tablename('agent_member').' where id=:id',array(':id'=>$agent_id));
		break;
	case '2':
		$table = tablename('member_system_member');
		$nickname = pdo_fetchcolumn('select nickname from '.tablename('member_system_member').' where id=:id',array(':id'=>$id));
		$parent_id = pdo_fetchcolumn('select parent_agent from '.tablename('member_system_member').' where id=:id',array(':id'=>$id));
	
	default:
		# code...
		break;
}

$member = pdo_fetch('select parent_agent,password_control,nickname,status from '.$table.' where id=:id',array(':id'=>$id));

if ($member['status'] == 1) {
	$data = array(
		'status' => 300,
		'info' => '该用户已禁用，无法操作'
	);
	echo json_encode($data);
	exit;
}

if ($member['parene_agent'] != $uid) {
	$data = array(
		'status' => 300,
		'info' => '您没有权限修改该用户的密码'
	);
	echo json_encode($data);
	exit;
}
if ($member['password_control'] != 1) {
	$data = array(
		'status' => 300,
		'info' => '该用户关闭了密码修改功能'
	);
	echo json_encode($data);
	exit;
}
if (!empty($manager) && empty($user_id)) {
    $operator = '管理员';
}
elseif (!empty($manager) && $user_id != $parent_id) {
    $operator = '管理员';
}
else{
    $operator = pdo_fetchcolumn('select nickname from '.tablename('agent_member').' where id=:id',array(':id'=>$user_id));
}

if (!empty($password)) {
	$save['password'] = md5(md5($password));
}

if ($nickname != $member['nickname']) {
	$save['nickname'] = $nickname;
}


if ($type == 1 && !empty($save)) {
	$res = pdo_update('agent_member',$save,array('id'=>$id));
	$operation = array(
        'user_id' => $id,
        'user_type' => 1,
        'operation' => $operator.'对'.$nickname.'进行了密码设置',
        'create_time' => time()
    );
    pdo_insert('agent_operation',$operation);
    pdo_update('agent_member',array('last_edit_time'=>time()),array('id'=>$id));
}
if ($type == 2 && !empty($save)) {
	$res = pdo_update('member_system_member',$save,array('id'=>$id));
	$operation = array(
        'user_id' => $id,
        'user_type' => 2,
        'operation' => $operator.'对'.$nickname.'进行了密码设置',
        'create_time' => time()
    );
    pdo_insert('agent_operation',$operation);
    pdo_update('member_system_member',array('last_edit_time'=>time()),array('id'=>$id));
}

if ($res) {
	$data = array(
		'status' => 200,
		'info' => '修改成功'
	);
}
else{
	$data = array(
		'status' => 300,
		'info' => '修改失败'
	);
}

echo json_encode($data);
exit;



 ?>