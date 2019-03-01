<?php 
global $_W,$_GPC;

$op = $_GPC['op'];
session_start();

if ($op == 'password') {
	$id = $_SESSION['mid'];
	$password = $_GPC['password'];

	if (empty($password)) {
		$data = array(
			'status' => 2,
			'info' => '请填写密码'
		);
		echo json_encode($data);
		exit;
	}

	$res = pdo_update('agent_member',array('password'=>md5(md5($password))),array('id'=>$id));
	if ($res) {
		$data = array(
			'status' => 1,
			'info' => '修改成功'
		);
	}
	else{
		$data = array(
			'status' => 2,
			'info' => '修改失败'
		);
	}
	echo json_encode($data);
	exit;
}

if ($op == 'area') {
	$area_id = $_SESSION['area'];
	$id = $_GPC['id'];
	if ($area_id != $id && !empty($id)) {
		$_SESSION['area'] = $id;
	}
	else{
		$_SESSION['area'] = 0;
	}

	echo $_SESSION['area'];
	exit;
}

if ($op == 'notice') {
	$content = $_GPC['notice'];
	$save = array(
		'content' => $content,
		'createtime' => time()
	);
	$res = pdo_insert('manji_notice',$save);
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
}






 ?>