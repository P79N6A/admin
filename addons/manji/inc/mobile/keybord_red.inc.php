<?php 
global $_W,$_GPC;
$uid = $_GPC['user_id'];
$token = $_GPC['token'];
$member = $this->login_check($uid,$token);
if (empty($member)) {
	$return = array(
		'status' => 403,
		'info' => '登录异常'
	);
	echo json_encode($return);
	exit;
}

$red = pdo_fetchall('select number from '.tablename('manji_red_number').' where cid=:cid',array(':cid'=>$member['cid']));

if (empty($red)) {
	$red = array();
}

$return = array(
	'status' => 200,
	'number' => $red
);
echo json_encode($return);
exit;





 ?>