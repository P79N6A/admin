<?php 
global $_W,$_GPC;

$user_id = $_SESSION['uid'];

if (empty($user_id)) {
	$data = array(
		'status' => 5,
		'info' => '请先登录'
	);
	echo json_encode($data);
	exit;
}

$status = pdo_fetchcolumn('select parent_control from '.tablename('agent_member').' where id=:id',array(':id'=>$user_id));

if ($status == 1) {
	$save['parent_control'] = 0;
}
if ($status == 0) {
	$save['parent_control'] = 1;
}


$res = pdo_update('agent_member',$save,array('id'=>$user_id));

if ($res) {
	$data = array(
		'status' => 1,
		'info' => '设置成功'
	);
}
else{
	$data = array(
		'status' => 2,
		'info' => '设置失败'
	);
}

echo json_encode($data);
exit;




 ?>