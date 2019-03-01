<?php 
global $_W,$_GPC;

$user_id = $_SESSION['uid'];
if (empty($user_id)) {
	message('请先登录',$this->createMobileUrl('login'),'error');
}

$op = $_GPC['op'];
$page = $_GPC['page']>0?$_GPC['page']:1;
$psize = 25;

if ($op == 'cathectic') {
	$periods = $_GPC['periods'];
	$member = $_GPC['member'];
	$member_id = $_GPC['member_id'];
	$agent_id = $_GPC['agent_id'];
	$start = $_GPC['stime']?strtotime($_GPC['stime'].' 00:00:00'):strtotime(date('Y-m-d 00:00:00',(time())));
	$end = $_GPC['etime']?strtotime($_GPC['etime'].' 23:59:59'):strtotime(date('Y-m-d 23:59:59',(time())));

	$condition = ' where 1 ';

	if (!empty($periods)) {
		$condition .= ' and r.periods=:periods ';
		$fields[':periods'] = $periods;
	}
	if (!empty($member)) {
		$condition .= ' and m.nickname like :member';
		$fields[':member'] = '%'.$member.'%';
	}
	if (!empty($member_id)) {
		$condition .= ' and m.id=:id ';
		$fields[':id'] = $member_id;
	}

	if (!empty($agent_id)) {
		$agents = get_children($agent_id);
		$agents[] = $agent_id;
		$agent_fields = implode(',', $agents);
		$members = pdo_fetchColumnValue('select id from '.tablename('member_system_member').' where parent_agent in ('.$agent_fields.')',array(),'id');
		if (count($members)>0) {
			$member_fields = implode(',', $members);
		}
		else{
			$member_fields = 0;
		}
		$periods = pdo_fetchColumnValue('select id from '.tablename('manji_run_setting').' where starttime>=:start and endtime<=:end',array(':start'=>$start,':end'=>$end),'id');
		if (count($periods) > 0) {
			$period = implode(',', $periods);
		}
		else{
			$period = 0;
		}

		$condition .= ' and o.user_id in ('.$member_fields.') and o.period_id in ('.$period.') ';
	}

	$list = pdo_fetchall('select m.nickname,r.periods,o.* from '.tablename('manji_order').' o left join '.tablename('manji_run_setting').' r on r.id=o.period_id left join '.tablename('member_system_member').' m on m.id=o.user_id '.$condition.' order by o.createtime desc limit '.($page-1)*$psize.','.$psize,$fields);

	$total = pdo_fetchcolumn('select count(*) from '.tablename('manji_order').' o left join '.tablename('manji_run_setting').' r on r.id=o.period_id left join '.tablename('member_system_member').' m on m.id=o.user_id '.$condition.' order by o.createtime desc',$fields);

	$pager = pagination($total,$page,$psize);
}

if ($op == 'reward') {
	$periods = $_GPC['periods'];
	$member = $_GPC['member'];
	$member_id = $_GPC['member_id'];
	$agent_id = $_GPC['agent_id'];
	$start = $_GPC['stime']?strtotime($_GPC['stime'].' 00:00:00'):strtotime(date('Y-m-d 00:00:00',(time())));
	$end = $_GPC['etime']?strtotime($_GPC['etime'].' 23:59:59'):strtotime(date('Y-m-d 23:59:59',(time())));

	$condition = ' where 1 ';

	if (!empty($periods)) {
		$condition .= ' and period_num=:periods ';
		$fields[':periods'] = $periods;
	}
	if (!empty($member)) {
		$condition .= ' and member_nikename like :member';
		$fields[':member'] = '%'.$member.'%';
	}

	if (!empty($member_id)) {
		$condition .= ' and member_id=:id ';
		$fields[':id'] = $member_id;
	}

	if (!empty($agent_id)) {
		$agents = get_children($agent_id);
		$agents[] = $agent_id;
		$agent_fields = implode(',', $agents);
		$members = pdo_fetchColumnValue('select id from '.tablename('member_system_member').' where parent_agent in ('.$agent_fields.')',array(),'id');
		if (count($members)>0) {
			$member_fields = implode(',', $members);
		}
		else{
			$member_fields = 0;
		}
		$periods = pdo_fetchColumnValue('select id from '.tablename('manji_run_setting').' where starttime>=:start and endtime<=:end',array(':start'=>$start,':end'=>$end),'id');
		if (count($periods) > 0) {
			$period = implode(',', $periods);
		}
		else{
			$period = 0;
		}

		$condition .= ' and member_id in ('.$member_fields.') and period_id in ('.$period.') ';
	}

	$list = pdo_fetchall('select * from '.tablename('manji_reward_log').$condition.' order by create_time desc limit '.($page-1)*$psize.','.$psize,$fields);

	$total = pdo_fetchcolumn('select count(id) from '.tablename('manji_reward_log').$condition.' order by create_time desc',$fields);

	$pager = pagination($total,$page,$psize);
}






 ?>