<?php 
global $_W,$_GPC;

$user_id = $_SESSION['uid'];
$agent_id = $_GPC['agent_id'];
if (!empty($agent_id)) {
	$user_id = $agent_id;
}

if (empty($user_id)) {
	message('请先登录',$this->createMobileUrl('login'),'error');
}

$cashback = pdo_fetchcolumn('select cashback_percent from '.tablename('agent_percent').' where agent_id=:id',array(':id'=>$user_id));
$jackpot = pdo_fetchcolumn('select jackpot_percent from '.tablename('agent_percent').' where agent_id=:id',array(':id'=>$user_id));
$bonus = pdo_fetchcolumn('select bonus_percent from '.tablename('agent_percent').' where agent_id=:id',array(':id'=>$user_id));
$cash = json_decode($cashback,true);

$can = 1;
if (!empty($agent_id)) {
	$can = pdo_fetchcolumn('select parent_control from '.tablename('agent_member').' where id=:id',array(':id'=>$user_id));
}

$odds = pdo_fetchall('select id,title from '.tablename('agent_odds').' where agent_id=:id',array(':id'=>$_SESSION['uid']));


include $this->template('addrec');



 ?>