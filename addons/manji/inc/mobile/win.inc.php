<?php 
global $_W,$_GPC;
$member_id = $_COOKIE['uid'];

if (empty($member_id)) {
	header('Location:'.$this->createMobileUrl('login'));
	exit;
}
$member = pdo_fetch('select * from '.tablename('member_system_member').' where id=:id',array(':id'=>$member_id));
$date = $_GPC['date']?$_GPC['date']:date('Y-m-d',time());

$periods = pdo_fetchColumnValue('select id from '.tablename('manji_run_setting').' where date=:date and aid=:aid',array(':date'=>$date,':aid'=>$member['cid']),'id');
if (!empty($periods)) {
	$win = pdo_fetchall('select * from '.tablename('manji_reward_log').' where period_id in ('.implode(',', $periods).') and member_id=:member_id and winner_money>0 order by number_type asc',array(':member_id'=>$member_id));
	$jackpot = pdo_fetchall('select * from '.tablename('manji_jackpot_log').' where period_id in ('.implode(',', $periods).') and user_id=:user_id',array(':user_id'=>$member_id));
	foreach ($jackpot as &$v) {
		$order = pdo_fetch('select ordersn,uordersn from '.tablename('manji_order').' where id=:id',array(':id'=>$v['order_id']));
		$v['ordersn'] = $order['ordersn'];
		$v['uordersn']= $order['uordersn'];
	}
}



include $this->template('win');

 ?>