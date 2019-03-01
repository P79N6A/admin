<?php 
global $_W,$_GPC;

$op = $_GPC['op']?$_GPC['op']:'display';
$status = pdo_fetchcolumn('select is_black from '.tablename('member_system_member').' where id=:id',array(':id'=>$_GPC['member_id']));
$member = pdo_fetch('select * from '.tablename('member_system_member').' where id=:id',array(':id'=>$_GPC['member_id']));
$commission = json_decode($member['commission'],true);
if (!empty($commission)) {
	foreach ($commission as &$value) {
		if ($value <= 0) {
			$value = 0;
		}
	}
}
else{
	$commission = array(
		'B' => 0,
		'S' => 0,
		'A' => 0,
		'3ABC' => 0,
		'4A' => 0,
		'4ABC' => 0,
		'2A' => 0,
		'2ABC' => 0
	);
}
if ($op == 'display') {
	$user_id = $_SESSION['uid'];
	$agent_id = $_GPC['agent_id'];
	if (!empty($agent_id)) {
		$user_id = $agent_id;
	}
	$cashback = pdo_fetchcolumn('select cashback_percent from '.tablename('agent_percent').' where agent_id=:id',array(':id'=>$user_id));
	$jackpot = pdo_fetchcolumn('select jackpot_percent from '.tablename('agent_percent').' where agent_id=:id',array(':id'=>$user_id));
	$bonus = pdo_fetchcolumn('select bonus_percent from '.tablename('agent_percent').' where agent_id=:id',array(':id'=>$user_id));
	$cash = gettotalCash($user_id);
	$odds = pdo_fetchall('select id,title from '.tablename('agent_odds').' where agent_id=:id',array(':id'=>$_SESSION['uid']));
}


include $this->template('member_detail');

 ?>