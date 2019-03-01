<?php 
global $_W,$_GPC;
$manager = $_SESSION['mid'];
if (empty($manager)) {
	$result = array(
		'status' => 3,
		'info' => '请先登录'
	);
	echo json_encode($result);
	exit;
}

$data = $_GPC['data'];
$member_id = $_GPC['member_id'];
$days_type = $_GPC['days_type'];
$days = $_GPC['days'];







 ?>