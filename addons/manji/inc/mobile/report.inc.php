<?php 
global $_W,$_GPC;
$member_id = $_COOKIE['uid'];

if (empty($member_id)) {
	header('Location:'.$this->createMobileUrl('login'));
	exit;
}
$member = pdo_fetch('select * from '.tablename('member_system_member').' where id=:id',array(':id'=>$member_id));

$start = $_GPC['stime']?$_GPC['stime']:date('Y-m-d',time());
$end = $_GPC['etime']?$_GPC['etime']:date('Y-m-d',time());
$total = 0;
$range = getDateRound($start,$end);
$range_str = implode(',', $range);
$period_id = pdo_fetchColumnValue('select id from '.tablename('manji_run_setting').' where date in ('.$range_str.')',array(),'id');

$reports = pdo_fetchall('select d.sum_bet,d.cashback,d.pay_award,r.date,d.periods_id,jackpot from '.tablename('manji_downline_report').' d left join '.tablename('manji_run_setting').' r on r.id=d.periods_id where member_id=:user and periods_id in ('.implode(',',$period_id).')',array(':user'=>$member_id));
foreach ($reports as &$v) {
	$win = pdo_fetchall('select * from '.tablename('manji_reward_log').' where period_id=:period and member_id=:member',array(':member'=>$member_id,':period'=>$v['periods_id']));
	foreach ($win as &$val) {
		$val['uordersn'] = pdo_fetchcolumn('select p.uordersn from '.tablename('manji_order').' o left join '.tablename('manji_order').' p on o.pid=p.id where o.id=:id',array(':id'=>$val['order_id']));
	}
	$v['win'] = $win;
	$v['cnickname'] = pdo_fetchcolumn('select nickname from '.tablename('manji_company').' c left join '.tablename('manji_run_setting').' p on p.cid=c.id where p.id=:id',array(':id'=>$v['periods_id']));
	$v['date'] = date('d/m',strtotime($v['date']));
	$v['net'] = $v['sum_bet'] - $v['cashback'];
	$v['total'] = $v['net']-$v['pay_award']-$v['jackpot'];
	$total += $v['total'];
}







include $this->template('report');

 ?>