<?php 
global $_W,$_GPC;

$mid = $_SESSION['mid'];
if (empty($mid)) {
	message('请先登录',$this->createMobileUrl('login'),'unlog');
	exit;
}
$op = $_GPC['op'];

if ($op == 'post') {
	$agent_id = $_GPC['agent_id'];
	$eat = $_GPC['eat'];
	$same = $_GPC['same'];
	if (!empty($same)) {
		$first = pdo_fetchcolumn('select min(id) from '.tablename('manji_company'));
		foreach ($eat as $key => $value) {
			$eat[$key] = $eat[$first];
		}
	}
	$old = pdo_fetch('select * from '.tablename('agent_eat').' where agent_id=:id',array(':id'=>$agent_id));

	$save['eat'] = json_encode($eat);

	if (!empty($old)) {
		pdo_update('agent_eat',$save,array('agent_id'=>$agent_id));
	}
	else{
		$save['agent_id'] = $agent_id;
		pdo_insert('agent_eat',$save);
	}

	message('保存成功',referer(),'success');
	exit;
}





 ?>