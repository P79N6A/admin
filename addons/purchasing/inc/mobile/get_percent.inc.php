<?php 
global $_W,$_GPC;

$user_id = $_SESSION['uid'];

if (empty($user_id)) {
	$data = array(
		'status' => 3,
		'info' => '请先登录'
	);
	echo json_encode($data);
	exit;
}

$agent_id = $_GPC['agent_id'];
if (empty($agent_id)) {
	$data = array(
		'status' => 2,
		'info' => '请先选择下线'
	);
	echo json_encode($data);
	exit;
}

$percent = pdo_fetch('select * from '.tablename('agent_percent').' where agent_id=:agent',array(':agent'=>$agent_id));

$percent['cashback_percent'] = json_decode($percent['cashback_percent'],true);

$data = array(
	'status' => 1,
	'list' => $percent
);
echo json_encode($data);
exit;



 ?>