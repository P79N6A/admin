<?php 

global $_W,$_GPC;

$user_id = $_SESSION['uid'];
$agent_id = $_GPC['agent_id'];
$start = $_GPC['stime']?strtotime($_GPC['stime'].' 00:00:00'):strtotime(date('Y-m-d 00:00:00',(time()-24*3600)));
$end = $_GPC['etime']?strtotime($_GPC['etime'].' 23:59:59'):strtotime(date('Y-m-d 23:59:59',(time()-24*3600)));
$page = $_GPC['page']>0?$_GPC['page']:1;

$psize = 20;

$manager = pdo_fetch('select * from '.tablename('agent_member').' where id=:id',array(':id'=>$user_id));

if (!empty($agent_id)) {
	$user_id = $agent_id;
}
$parents_id = getParent($user_id);
$agent_info = pdo_fetch('select account,nickname from '.tablename('agent_member').' where id=:id',array(':id'=>$user_id));
$account = '';
if (count($parents_id)>0) {
	$parents_fields = implode(',',$parents_id);
	$parents = pdo_fetchall('select account,nickname,id from '.tablename('agent_member').' where id in ('.$parents_fields.') order by id asc');
	foreach ($parents as $key => $value) {
		if ($key == 0) {
			$account .= '<a href="'.$this->createMobileUrl('mybaobiao',array('agent_id'=>$value['id'])).'">'.$value['account'].'</a>';
		}
		else{
			$account .= '><a href="'.$this->createMobileUrl('mybaobiao',array('agent_id'=>$value['id'])).'">'.$value['account'].'</a>';
		}
	}
}
if ($account != '') {
	$account .= '>'.$agent_info['account'];
}
else{
	$account .= $agent_info['account'];
}
$start = $_GPC['stime']?strtotime($_GPC['stime'].' 00:00:00'):strtotime(date('Y-m-d 00:00:00',(time())));
$end = $_GPC['etime']?strtotime($_GPC['etime'].' 23:59:59'):strtotime(date('Y-m-d 23:59:59',(time())));


// $total = pdo_fetchcolumn('select count(a.id) from '.tablename('agent_member').' a left join '.tablename('agent_percent').' p on a.id=p.agent_id '.$condition,$fields);

$list = pdo_fetchall('select id,periods from '.tablename('manji_run_setting').' where endtime between :start and :end ',array(':start'=>$start,':end'=>$end));

foreach ($list as &$v) {
	$item_list = pdo_fetchall('select * from '.tablename('manji_downline_report').' where parent_agent=:agent and periods_id=:periods order by id asc ',array(':agent'=>$user_id,':periods'=>$v['id']));
	foreach ($item_list as &$val) {
		if ($val['agent_id']>0) {
			$member = pdo_fetch('select account,nickname from '.tablename('agent_member').' where id=:id',array(':id'=>$val['agent_id']));
			$val['user_type'] = 1;
		}
		else{
			$member = pdo_fetch('select account,nickname from '.tablename('member_system_member').' where id=:id',array(':id'=>$val['member_id']));
			$val['user_type'] = 2;
		}
		$val['nickname'] = $member['nickname'];
		$val['account'] = $member['account'];
	}
	$v['list'] = $item_list;
	$v['total'] = pdo_fetch('select id,agent_id,member_id,sum(sum_bet) as sum_bet,sum(cashback) as cashback,sum(pay_award) as pay_award,sum(profit) as profit,sum(bonus) as bonus,sum(net) as net,sum(upline_cashback) as upline_cashback,sum(upline_bonus) as upline_bonus,sum(upline_profit) as upline_profit,sum(upline_net) as upline_net,sum(commission) as commission,create_time,parent_agent,periods_id from '.tablename('manji_downline_report').' where parent_agent=:agent and periods_id=:periods ',array(':agent'=>$user_id,':periods'=>$v['id']));
	$v['all_total'] = pdo_fetch('select id,agent_id,member_id,sum(sum_bet) as sum_bet,sum(cashback) as cashback,sum(pay_award) as pay_award,sum(profit) as profit,sum(bonus) as bonus,sum(net) as net,sum(upline_cashback) as upline_cashback,sum(upline_bonus) as upline_bonus,sum(upline_profit) as upline_profit,sum(upline_net) as upline_net,sum(commission) as commission,create_time,parent_agent,periods_id from '.tablename('manji_downline_report').' where parent_agent=:agent and create_time between :start and :end',array(':agent'=>$user_id,':start'=>$start,':end'=>$end));
}

$total_list = pdo_fetchall('select id,agent_id,member_id,sum(sum_bet) as sum_bet,sum(cashback) as cashback,sum(pay_award) as pay_award,sum(profit) as profit,sum(bonus) as bonus,sum(net) as net,sum(upline_cashback) as upline_cashback,sum(upline_bonus) as upline_bonus,sum(upline_profit) as upline_profit,sum(upline_net) as upline_net,sum(commission) as commission,create_time,parent_agent,periods_id from '.tablename('manji_downline_report').' where parent_agent=:agent and create_time between :start and :end group by agent_id order by id asc ',array(':agent'=>$_SESSION['uid'],':start'=>$start,':end'=>$end));

foreach ($total_list as &$value) {
	if ($value['agent_id']>0) {
		$member = pdo_fetch('select account,nickname from '.tablename('agent_member').' where id=:id',array(':id'=>$value['agent_id']));
		$value['user_type'] = 1;
	}
	else{
		$member = pdo_fetch('select account,nickname from '.tablename('member_system_member').' where id=:id',array(':id'=>$value['member_id']));
		$value['user_type'] = 2;
	}
	$value['nickname'] = $member['nickname'];
	$value['account'] = $member['account'];
}

$all_total = pdo_fetch('select id,agent_id,member_id,sum(sum_bet) as sum_bet,sum(cashback) as cashback,sum(pay_award) as pay_award,sum(profit) as profit,sum(bonus) as bonus,sum(net) as net,sum(upline_cashback) as upline_cashback,sum(upline_bonus) as upline_bonus,sum(upline_profit) as upline_profit,sum(upline_net) as upline_net,sum(commission) as commission,create_time,parent_agent,periods_id from '.tablename('manji_downline_report').' where parent_agent=:agent and create_time between :start and :end ',array(':agent'=>0,':start'=>$start,':end'=>$end));

$pager = pagination($total,$page,$psize);

include $this->template('mybaobiao');



 ?>