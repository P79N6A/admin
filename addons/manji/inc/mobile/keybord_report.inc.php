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

// DP3644 (06/11)
// =Summary=
// S:1168.00
// N:1072.04
// W:3260.00
// T:-2187.96
// TOTAL: -2187.96
// ===========
// #1929/MG/5th/E4
// 3287 $1.00
// =860.00
// #1929/MG/1st/A
// 952 $2.00
// =1800.00
// #1929/MG/1st/C
// 952 $2.00
// =600.00

// ************
// ************

// =QQ=
// DP3644 (06/11)
// =Summary=

// [REPORT]
// S:72.00
// N:66.24
// W:0.00
// T:66.24
// TOTAL: 66.24
// ===STRIKE===







 ?>