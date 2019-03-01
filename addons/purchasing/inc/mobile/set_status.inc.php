<?php 
global $_W,$_GPC;

$id = $_GPC['id'];
$status = $_GPC['status'];
$type = $_GPC['type'];

if ($status == 0) {
	$save['status'] = 1;
}
if ($status == 1) {
	$save['status'] = 2;
}
if ($status == 2) {
	$save['status'] = 0;
}

if ($type == 1) {
	if (!empty($save)) {
		$res = pdo_update('agent_member',$save,array('id'=>$id));
	}
}
if ($type == 2) {
	if (!empty($save)) {
		$res = pdo_update('member_system_member',$save,array('id'=>$id));
	}
}

if ($res) {
	$data = array(
		'status' => 1
	);
}
else{
	$data = array(
		'status' => 2
	);
}

echo json_encode($data);
exit;

 ?>