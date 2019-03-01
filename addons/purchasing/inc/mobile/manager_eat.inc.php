<?php 
global $_W,$_GPC;

$mid = $_SESSION['mid'];
if (empty($mid)) {
	message('请先登录',$this->createMobileUrl('login'),'unlog');
	exit;
}
$open_time = pdo_fetchall('select p.endtime,c.nickname from '.tablename('manji_preinstall_time').' p left join '.tablename('manji_company').' c on c.id=p.cid where aid=0');
if ($_SESSION['level'] >= 5) {
	message('没有权限',$this->createMobileUrl('login','unlog'));
}
$manager = pdo_fetch('select * from '.tablename('agent_member').' where id=:id',array(':id'=>$mid));

$op = $_GPC['op'];

if ($op == 'edit') {
	$agent = $_GPC['agent_id'];
	if (empty($agent) && $_SESSION['level'] >= 2) {
		$agent = $mid;
	}
	$member = pdo_fetch('select * from '.tablename('agent_member').' where id=:id',array(':id'=>$agent));
	$company = pdo_fetchall('select * from '.tablename('manji_company').' where id<>1 order by id asc');
	$bet_4D = array('B','S','4A','4ABC','4B','4C','4D','4E','EA');
	$bet_3D = array('A','3ABC','C2','C3','C4','C5','EC','2A','2B','2C','2D','2E','EX','2ABC','5D','6D');
	$eat = pdo_fetch('select * from '.tablename('agent_manager_eat').' where agent_id=:agent',array(':agent'=>$agent));
	if ($eat['type_4d'] == 2) {
		$ordby = explode(',',$eat['ordby_4d']);
		if (count($ordby) == 4) {
			$bet_4D = array('mutiple','4B','4C','4D','4E','EA');
		}
		if (count($ordby) == 3) {
			$bet_4D = array('mutiple','ot','4B','4C','4D','4E','EA');
		}
	}
	if ($eat['type_3d'] == 2) {
		$ordby_3d = explode(',', $eat['ordby_3d']);
		$bet_3D = array('mutiple','C2','C3','C4','C5','EC','2A','2B','2C','2D','2E','EX','2ABC','5D','6D');
	}
	$mating_4D = json_decode($eat['mating_4D'],true);
	$mating_3D = json_decode($eat['mating_3D'],true);
}

if ($op == 'edit_post') {
	$agent = $_GPC['agent_id'];
	$percent = $_GPC['percent'];
	$type_4d = $_GPC['type_4d'];
	$type_3d = $_GPC['type_3d'];
	$no_eat = $_GPC['no_eat'];
	$mating = $_GPC['mating'];
	$ordby = $_GPC['ordby'];
	$ordby_3d = $_GPC['ordby_3d'];
	$is_filter = $_GPC['is_filter'];
	$member = pdo_fetch('select * from '.tablename('agent_member').' where id=:id',array(':id'=>$agent));
	if ($member['level'] < 4) {
		$is_filter = 1;
	}
	$old = pdo_fetchcolumn('select count(id) from '.tablename('agent_manager_eat').' where agent_id=:agent',array(':agent'=>$agent));
	$save = array(
		'percent' => $percent,
		'type_4d' => $type_4d,
		'type_3d' => $type_3d,
		'no_eat' => $no_eat,
		'is_filter' => $is_filter,
	);
	foreach ($mating as $key => $value) {
		if ($key == '4D') {
			$save['mating_4D'] = json_encode($value);
		}
		if ($key == '3D') {
			$save['mating_3D'] = json_encode($value);
		}
	}
	if (count($ordby) != count(array_unique($ordby)) || count($ordby_3d) != count(array_unique($ordby_3d))) {
		message('优先吃字项不能重复',referer(),'error');
		exit;
	}
	if (!empty($ordby)) {
		$save['ordby_4d'] = implode(',',$ordby);
	}
	if (!empty($ordby_3d)) {
		$save['ordby_3d'] = implode(',',$ordby_3d);
	}
	if (!empty($old)) {
		pdo_update('agent_manager_eat',$save,array('agent_id'=>$agent));
	}
	else{
		$save['agent_id'] = $agent;
		pdo_insert('agent_manager_eat',$save);
	}
	message('保存成功',$this->createMobileUrl('manager',array('op'=>'manager_eat')),'success');
}




include $this->template('manager_eat');

 ?>