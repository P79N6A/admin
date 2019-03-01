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
$manager_account = $_GPC['manager_account'];
$manager_password = $_GPC['manager_password'];
$money_account = $_GPC['money_account'];
$money_password = $_GPC['money_password'];
$agent_account = $_GPC['agent_account'];
$agent_password = $_GPC['agent_password'];

if (empty($name)) {
	$data = array(
		'status' => 2,
		'info' => '请输入盘口名称'
	);
	echo json_encode($data);
	exit;
}

if (empty($id)) {
	if (empty($manager_account) || empty($manager_password)) {
		$data = array(
			'status' => 2,
			'info' => '请设置管理员'
		);
		echo json_encode($data);
		exit;
	}
	if (empty($money_account) || empty($money_password)) {
		$data = array(
			'status' => 2,
			'info' => '请设置财务员'
		);
		echo json_encode($data);
		exit;
	}
	if (empty($agent_account) || empty($agent_password)) {
		$data = array(
			'status' => 2,
			'info' => '请设置总代'
		);
		echo json_encode($data);
		exit;
	}

	$old = pdo_fetchcolumn('select count(id) from '.tablename('manji_area').' where area_name=:name',array(':name'=>$name));
	if ($old > 0) {
		$data = array(
			'status' => 2,
			'info' => '已有该盘口名称'
		);
		echo json_encode($data);
		exit;
	}

	$old_account = pdo_fetchcolumn('select count(id) from '.tablename('agent_member').' where account=:manager or account=:money or account=:agent',array(':manager'=>$manager_account,':money'=>$money_account,':agent'=>$agent_account));
	if ($old_account > 0) {
		$data = array(
			'status' => 2,
			'info' => '不能创建已有账号'
		);
		echo json_encode($data);
		exit;
	}

	$manager = array(
		'level' => 2,
		'nickname' => $manager_account,
		'account' => $manager_account,
		'password' => md5(md5($manager_password)),
		'createtime' => time(),
		'last_edit_time' => time()
	);
	$money = array(
		'level' => 3,
		'nickname' => $money_account,
		'account' => $money_account,
		'password' => md5(md5($money_password)),
		'createtime' => time(),
		'last_edit_time' => time()
	);
	$agent = array(
		'level' => 4,
		'nickname' => $agent_account,
		'account' => $agent_account,
		'password' => md5(md5($agent_password)),
		'createtime' => time(),
		'last_edit_time' => time()
	);
	$save = array(
		'area_name' => $name,
		'createtime' => time(),
		'edittime' => time()
	);
	$res = pdo_insert('manji_area',$save);
	if ($res) {
		$cid = pdo_insertid();
		$manager['cid'] = $cid;
		$money['cid'] = $cid;
		$agent['cid'] = $cid;
		pdo_insert('agent_member',$manager);
		pdo_insert('agent_member',$money);
		pdo_insert('agent_member',$agent);
	}
}
else{
	if (empty($manager_account)) {
		$data = array(
			'status' => 2,
			'info' => '请设置管理员'
		);
		echo json_encode($data);
		exit;
	}
	if (empty($money_account)) {
		$data = array(
			'status' => 2,
			'info' => '请设置财务员'
		);
		echo json_encode($data);
		exit;
	}
	if (empty($agent_account)) {
		$data = array(
			'status' => 2,
			'info' => '请设置总代'
		);
		echo json_encode($data);
		exit;
	}
	$manager = array(
		'nickname' => $manager_account,
		'account' => $manager_account,
		'last_edit_time' => time()
	);
	$money = array(
		'nickname' => $money_account,
		'account' => $money_account,
		'last_edit_time' => time()
	);
	$agent = array(
		'nickname' => $agent_account,
		'account' => $agent_account,
		'last_edit_time' => time()
	);
	$old_account = pdo_fetchcolumn('select count(id) from '.tablename('agent_member').' where (account=:manager or account=:agent or account=:money) and cid <> :id',array(':manager'=>$manager_account,':agent'=>$agent_account,':money'=>$money_account,':id'=>$id));
	if ($old_account > 0) {
		$data = array(
			'status' => 2,
			'info' => '不能改为其他已有的账号'
		);
		echo json_encode($data);
		exit;
	}
	if (!empty($manager_password)) {
		$manager['password'] = md5(md5($manager_password));
	}
	if (!empty($money_password)) {
		$money['password'] = md5(md5($money_password));
	}
	if (!empty($agent_password)) {
		$agent['password'] = md5(md5($agent_password));
	}
	$old_name = pdo_fetchcolumn('select count(id) from '.tablename('manji_area').' where id<>:id',array(':id'=>$id));
	$save = array(
		'area_name' => $name,
		'edittime' => time()
	);
	$res = pdo_update('manji_area',$save,array('id'=>$id));
	if ($res) {
		pdo_update('agent_member',$manager,array('cid'=>$id,'level'=>2));
		pdo_update('agent_member',$money,array('cid'=>$id,'level'=>3));
		pdo_update('agent_member',$agent,array('cid'=>$id,'level'=>4));
	}
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