<?php 
global $_W,$_GPC;

$op = $_GPC['op']?$_GPC['op']:'display';
$user_id = $_SESSION['uid'];
$agent_id = $_GPC['agent_id'];
if (empty($user_id)) {
    message('请先登录',$this->createMobileUrl('login'),'error');
}

$manager = pdo_fetch('select * from '.tablename('agent_member').' where id=:id',array(':id'=>$user_id));


if ($op == 'display') {

	if (!empty($agent_id)) {
		$user_id = $agent_id;
		$parents_id = getParent($agent_id);
		$agent_info = pdo_fetch('select account,nickname from '.tablename('agent_member').' where id=:id',array(':id'=>$agent_id));
		$can = 1;
		if (!empty($agent_id)) {
			$can = pdo_fetchcolumn('select parent_control from '.tablename('agent_member').' where id=:id',array(':id'=>$agent_id));
		}
	}
	else{
		$parents_id = getParent($user_id);
		$agent_info = pdo_fetch('select account,nickname from '.tablename('agent_member').' where id=:id',array(':id'=>$user_id));
		$can = 1;
		if (!empty($agent_id)) {
			$can = pdo_fetchcolumn('select parent_control from '.tablename('agent_member').' where id=:id',array(':id'=>$user_id));
		}
	}
	
	$account = '';

	$condition = '';
	$keyword = $_GPC['keyword'];
	if (!empty($keyword)) {
		$condition .= ' and account like :keyword ';
		$fields[':keyword'] = '%'.$keyword.'%';
	}
	else{
		$condition .= ' and parent_agent=:agent ';
		$fields[':agent'] = $user_id;
	}

	$control = pdo_fetchcolumn('select parent_control from '.tablename('agent_member').' where id=:id',array(':id'=>$user_id));

	//agent
	$list1 = pdo_fetchall('select id,nickname,createtime as create_time,credit1 as score,is_black as status,parent_agent,parent_control,password_control,pay_limit,account,last_login_time as login_time,parent_agent from '.tablename('agent_member')
	    . ' where 1 '.$condition.' order by id desc ',$fields);
	foreach ($list1 as &$val) {
		$val['user_type'] = 1;
	}
	//member
	$list2 = pdo_fetchall('select id,nickname,createtime as create_time,credit1 as score,is_black as status,password_control,account,last_login_time as login_time,parent_agent from '.tablename('member_system_member')
	    . ' where 1 '.$condition.' order by id desc ',$fields);
	foreach ($list2 as &$v) {
		$v['user_type'] = 2;
	}

	$list = array_merge($list1,$list2);

	foreach ($list as $key => $value) {
		if ($value['user_type'] == 1) {
			$agent_num = pdo_fetchcolumn('select count(id) from '.tablename('agent_member').' where parent_agent=:agent',array(':agent'=>$value['id']));
			$member_num = pdo_fetchcolumn('select count(id) from '.tablename('member_system_member').' where parent_agent=:agent',array(':agent'=>$value['id']));
			$list[$key]['bonus'] = pdo_fetchcolumn('select bonus_percent from '.tablename('agent_percent').' where agent_id=:agent_id',array(':agent_id'=>$value['id']));
			$list[$key]['child_num'] = $agent_num+$member_num;
		}
		else{
			$list[$key]['child_num'] = 0;
		}
		if (!empty($keyword)) {
			$parents_id = getParent($value['parent_agent']);
			$agent_info = pdo_fetch('select account,nickname from '.tablename('agent_member').' where id=:id',array(':id'=>$value['parent_agent']));
		}
		
		
	}
	if (count($parents_id)>0) {
		$parents_fields = implode(',',$parents_id);
		$parents = pdo_fetchall('select account,nickname,id from '.tablename('agent_member').' where id in ('.$parents_fields.') order by id asc');
		foreach ($parents as $key => $value) {
			if ($key == 0) {
				$account .= '<a href="'.$this->createMobileUrl('home',array('op'=>'display','agent_id'=>$value['id'])).'">'.$value['account'].'</a>';
			}
			else{
				$account .= '><a href="'.$this->createMobileUrl('home',array('op'=>'display','agent_id'=>$value['id'])).'">'.$value['account'].'</a>';
			}
		}
	}
	if ($account != '') {
		$account .= '>'.$agent_info['account'];
	}
	else{
		$account .= $agent_info['account'];
	}
}

if ($op == 'detail') {
	$tab = $_GPC['tab']?$_GPC['tab']:'display';
	$member = pdo_fetch('select * from '.tablename('agent_member').' where id=:id',array(':id'=>$_GPC['agent_id']));
	if ($tab == 'display') {
		$agent_id = $_GPC['agent_id'];
		$parents_id = getParent($agent_id);
		$power = pdo_fetchcolumn('select parent_agent from '.tablename('agent_member').' where id=:agent',array(':agent'=>$agent_id));
		if (!in_array($user_id, $parents_id)) {
			message('没有权限',referer(),'error');
		}
		$percent = pdo_fetch('select * from '.tablename('agent_percent').' where agent_id=:agent',array(':agent'=>$agent_id));
		$jackpot = $percent['jackpot_percent'];
		$bonus = $percent['bonus_percent'];
		$cash = json_decode($percent['cashback_percent'],true);
	}
}

if ($op == 'addAgent' || $op == 'addMember') {
	if (!empty($agent_id)) {
		$user_id = $agent_id;
	}
	$cashback = pdo_fetchcolumn('select cashback_percent from '.tablename('agent_percent').' where agent_id=:id',array(':id'=>$user_id));
	$jackpot = pdo_fetchcolumn('select jackpot_percent from '.tablename('agent_percent').' where agent_id=:id',array(':id'=>$user_id));
	$bonus = pdo_fetchcolumn('select bonus_percent from '.tablename('agent_percent').' where agent_id=:id',array(':id'=>$user_id));
	$cash = gettotalCash($user_id);
	$odds = pdo_fetchall('select id,title from '.tablename('agent_odds').' where agent_id=:id',array(':id'=>$_SESSION['uid']));
}

include $this->template('agent_list');


 ?>