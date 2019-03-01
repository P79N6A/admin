<?php 
global $_W,$_GPC;

$mid = $_SESSION['mid'];

if (empty($mid)) {
	$data = array(
		'status' => 3,
		'info' => '请先登录'
	);
	echo json_encode($data);
	exit;
}

$id = $_GPC['id'];
$name = $_GPC['name'];
$nickname = $_GPC['nickname'];
$has_5d = $_GPC['has_5d'];
$has_6d = $_GPC['has_6d'];

if (empty($name)) {
	$data = array(
		'status' => 2,
		'info' => '请输入公司名称'
	);
	echo json_encode($data);
	exit;
}
if (empty($nickname)) {
	$data = array(
		'status' => 2,
		'info' => '请输入公司简称'
	);
	echo json_encode($data);
	exit;
}

if (empty($id)) {
	$save = array(
		'name' => $name,
		'nickname' => $nickname,
		'has_5D' => $has_5d,
		'has_6D' => $has_6d,
		'createtime' => time(),
		'edittime' => time()
	);
	$res = pdo_insert('manji_company',$save);
}
else{
	$old = pdo_fetch('select name,area_id,nickname,has_5D,has_6D from '.tablename('manji_company').' where id=:id',array(':id'=>$id));
	$save['edittime'] = time();
	if ($old['name'] != $name) {
		$save['name'] = $name;
	}
	if ($old['nickname'] != $nickname) {
		$save['nickname'] = $nickname;
	}
	if ($old['has_5D'] != $has_5d) {
		$save['has_5D'] = $has_5d;
	}
	if ($old['has_6D'] != $has_6d) {
		$save['has_6D'] = $has_6d;
	}

	$res = pdo_update('manji_company',$save,array('id'=>$id));
}

if ($res) {
	$data = array(
		'status' => 1,
		'info' => '保存成功'
	);
}
else{
	$data = array(
		'status' => 2,
		'info' => '保存失败'
	);
}

echo json_encode($data);
exit;




 ?>