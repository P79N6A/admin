<?php 
global $_W,$_GPC;

$user_id = $_SESSION['uid'];



if ($_W['isajax']) {
	$page = $_GPC['page']>0?$_GPC['page']:1;
	$psize = 30;
	$score_type = $_GPC['score_type'];
	$where = array(':agent'=>$user_id,':score_type'=>$score_type);

	$list = pdo_fetchall('select r.score,r.create_time,m.id,m.nickname from '.tablename('agent_recharge')
	        . ' r left join '.tablename('member_system_member').' m on r.to_user = m.id where r.from_user=:agent and r.user_type=2 and r.score_type =:score_type order by r.id desc limit '.($page-1)*$psize.",{$psize}",$where);
	foreach ($list as &$value) {
		$value['create_time'] = date('Y-m-d H:i:s',$value['create_time']);
	}
	if (!empty($list)) {
		$data = array(
			'status' => 1,
			'list' => $list,
			'type' => $score_type
		);
	}
	else{
		$data = array(
			'status' => 2,
			'info' => '没有更多数据'
		);
	}
	echo json_encode($data);
	exit;
	
}




include $this->template('huiyuanrec');


 ?>