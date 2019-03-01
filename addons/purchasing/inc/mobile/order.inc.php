<?php 
global $_W,$_GPC;
$mid = $_SESSION['mid'];
$op = $_GPC['op']?$_GPC['op']:'display';

if (empty($mid)) {
	message('请先登录',$this->createMobileUrl('login'),'error');
	exit;
}
$open_time = pdo_fetchall('select p.endtime,c.nickname from '.tablename('manji_preinstall_time').' p left join '.tablename('manji_company').' c on c.id=p.cid where aid=0');
$manager = pdo_fetch('select * from '.tablename('agent_member').' where id=:id',array(':id'=>$_SESSION['mid']));
$disc_name = pdo_fetchcolumn('select area_name from '.tablename('manji_area').' where id=:id',array(':id'=>$_SESSION['cid']));

$page = $_GPC['page']>0?$_GPC['page']:1;
$psize = 25;


$tab = $_GPC['tab']?$_GPC['tab']:'display';
if ($tab == 'display') {
	$length = $_GPC['length']?$_GPC['length']:4;
	$number = $_GPC['number'];
	$time = $_GPC['time']?$_GPC['time']:date('Y-m-d',time());
	$area = $_SESSION['area'];
	$psize = 500;
	$company = pdo_fetchall('select * from '.tablename('manji_company'));
	if ($_SESSION['cid'] > 0) {
		$users = pdo_fetchColumnValue('select id from '.tablename('member_system_member').' where cid ='.$_SESSION['cid'],array(),'id');
		$user_fields = implode(',',$users);
		$condition = ' and o.user_id in ('.$user_fields.') ';
		$p_condition = ' and aid='.$_SESSION['cid'].' ';
	}

	if ($_SESSION['level'] >= 4) {
		$agents = get_children($mid);
		$agents[] = $mid;
		$agent_fields = implode(',',$agents);
		$users = pdo_fetchColumnValue('select id from '.tablename('member_system_member').' where parent_agent in ('.$agent_fields.')',array(),'id');
		$user_fields = implode(',',$users);
		$condition = ' and o.user_id in ('.$user_fields.') ';
	}

	if (!empty($number)) {
		$condition .= ' and d.number='.$number.' ';
	}
	$period_id = pdo_fetchall('select id from '.tablename('manji_run_setting').' where date=:date '.$p_condition,array(':date'=>$time));
	if (!empty($period_id)) {
		foreach ($period_id as $p => $pp) {
			if ($p == 0) {
				$condition .= ' and (o.period_id like \'%('.$pp['id'].')%\' ';
			}
			else{
				$condition .= ' or o.period_id like \'%('.$pp['id'].')%\' ';
			}
		}
		$condition .= ')';
	}
	else{
		$condition = ' and o.period_id=(0) ';
	}
	
	if ($length == 4) {
		$filed_list = array('B','S','4A','4B','4C','4D','4E','EA','4ABC');
	}
	elseif ($length == 3) {
		$filed_list = array('A','C2','C3','C4','C5','EC','3ABC');
	}
	elseif ($length == 2) {
		$filed_list = array('2A','2B','2C','2D','2E','EX','2ABC');
	}

	foreach ($company as $k => $v) {
		$total = 0;
		foreach ($filed_list as $key => $value) {
			$list[$value] = pdo_fetchall('select d.number,sum(d.pay_'.$value.'*(100+false_price)/100) as '.$value.' from '.tablename('manji_order_detail').' d left join '.tablename('manji_order').' o on d.order_id=o.id where o.status=1 and o.cid like \'%('.$v['id'].')%\' '.$condition.' group by d.number order by sum(d.pay_'.$value.') desc limit 0,500',array(':start'=>$start,':end'=>$end));
			$total += $amount[$value] = pdo_fetchcolumn('select sum(d.pay_'.$value.'*(100+false_price)/100) from '.tablename('manji_order_detail').' d left join '.tablename('manji_order').' o on d.order_id=o.id where o.status=1 and o.cid like \'%('.$v['id'].')%\' '.$condition,array());
			$order_count[$value] = pdo_fetchcolumn('select count(distinct d.number) from '.tablename('manji_order_detail').' d left join '.tablename('manji_order').' o on d.order_id=o.id where d.pay_'.$value.'>0 and o.status=1 and o.cid like \'%('.$v['id'].')%\' '.$condition,array());
		}
		$company[$k]['list'] = $list;
		$company[$k]['amount'] = $amount;
		$company[$k]['total'] = $total;
		$company[$k]['order_count'] = $order_count;
	}
	
	$count = count($filed_list);

	if (!empty($_GPC['excel'])) {
		foreach ($filed_list as $key => $value) {
			$list[$value] = pdo_fetchall('select o.number,o.pay_'.$value.' as order_amount,m.account from '.tablename('manji_order').' o left join '.tablename('member_system_member').' m on m.id=o.user_id where length(number)=:length and status=1 and '.$condition.' and pay_'.$value.'>0 group by o.number order by pay_'.$value.' desc',array(':length'=>$length));
		}
		$report = 'order';
		include 'export.php';
		exit;
	}
	include $this->template('order');
	exit;
}
if ($tab == 'users') {
	$agent_id = $_GPC['agent_id'];
	$date = $_GPC['date']?$_GPC['date']:date('Y-m-d',time());
	$start = strtotime($date.' 00:00:00');
	$end = strtotime($date.' 23:59:59');
	if ($_SESSION['level'] >=4 && empty($agent_id)) {
		$agent_id = $mid;
	}
	$condition = '';
	$can = 1;
	if (!empty($agent_id)) {
		$parents_id = getParent($agent_id);
		$agent_info = pdo_fetch('select account,nickname,parent_agent from '.tablename('agent_member').' where id=:id',array(':id'=>$agent_id));
		$can = pdo_fetchcolumn('select parent_control from '.tablename('agent_member').' where id=:id',array(':id'=>$agent_id));
	}
	if ($_SESSION['level'] == 5 && empty($agent_id)) {
		$agent_info = pdo_fetch('select account,nickname,parent_agent from '.tablename('agent_member').' where id=:id',array(':id'=>$mid));
	}
	if ($_SESSION['level'] <= 4) {
		$childs = get_children(0);
	}
	else{
		$childs = get_children($mid);
	}
	$account = '';
	if (count($parents_id)>0) {
		$parents_fields = implode(',',$parents_id);
		$parents = pdo_fetchall('select account,nickname,id from '.tablename('agent_member').' where id in ('.$parents_fields.') order by id asc');
		foreach ($parents as $key => $value) {
			if ($key == 0) {
				if (in_array($value['id'], $childs) || $value['id'] == $mid) {
					$account .= '<a href="'.$this->createMobileUrl('manager',array('op'=>'display','agent_id'=>$value['id'])).'">'.$value['account'].'</a>';
				}
				else{
					$account .= $value['account'];
				}
			}
			else{
				if (in_array($value['id'],$childs) || $value['id'] == $mid) {
					$account .= '><a href="'.$this->createMobileUrl('manager',array('op'=>'display','agent_id'=>$value['id'])).'">'.$value['account'].'</a>';
				}
				else{
					$account .= '>'.$value['account'];
				}
			}
		}
	}
	if ($account != '') {
		$account .= '>'.$agent_info['account'];
	}
	else{
		$account .= $agent_info['account'];
	}
    if (!empty($keyword)) {
        $condition .= "  and  account like :keyword ";
        $fields[':keyword'] = '%'.$keyword.'%';
        $childs[] = $mid;
        $childs_fields = implode(',',$childs);
        $condition .= ' and parent_agent in ('.$childs_fields.') ';
    }
    else{
    	if (!empty($agent_id)) {
	    	$condition .= ' and parent_agent=:agent ';
	    	$fields[':agent'] = $agent_id;
	    }
	    else{
	    	if ($_SESSION['level'] >=4) {
				$condition .= ' and parent_agent=:agent ';
				$fields[':agent'] = $mid;
			}
			else{
				$condition .= ' and parent_agent=0 ';
			}
	    	
	    }
    }

    if ($_SESSION['cid'] > 0) {
    	$condition .= ' and cid=:cid ';
    	$fields[':cid'] = $_SESSION['cid'];
    	$p_condition = ' and aid='.$_SESSION['cid'];
    }
    $o_condition = '';
    $period_id = pdo_fetchall('select id from '.tablename('manji_run_setting').' where date=:date '.$p_condition,array(':date'=>$date));
	if (!empty($period_id)) {
		foreach ($period_id as $p => $pp) {
			if ($p == 0) {
				$o_condition .= ' and (period_id like \'%('.$pp['id'].'%)\' ';
			}
			else{
				$o_condition .= ' or period_id like \'%('.$pp['id'].')%\' ';
			}
		}
		$o_condition .= ')';
	}
	else{
		$o_condition = ' and period_id=\'(0)\' ';
	}

    $list = pdo_fetchall('select * from '.tablename('agent_member')." where level>=4 {$condition} order by id asc ",$fields);
    // var_dump($list);exit;
	
	foreach($list as &$agent){
		$child = get_children($agent['id']);
		$child[] = $agent['id'];
		$child_fields = implode(',',$child);
		$child_member = pdo_fetchColumnValue('select id from '.tablename('member_system_member').' where parent_agent in ('.$child_fields.')',array(),'id');
		$amount = 0;
		if (!empty($child_member)) {
			$member_fields = implode(',',$child_member);
			$amount = pdo_fetchcolumn('select sum(order_amount*(100+false_price)/100) from '.tablename('manji_order').' where user_id in ('.$member_fields.') and pid>0  and status=1 '.$o_condition,array());
		}
		$agent['order_amount'] = $amount?$amount:0;
		$agent['user_type'] = 1;
	}

	$member = pdo_fetchall('select * from '.tablename('member_system_member')." where 1 {$condition} order by id asc ",$fields);
	foreach ($member as &$mem) {
		$amount = pdo_fetchcolumn('select sum(order_amount*(100+false_price)/100) from '.tablename('manji_order').' where user_id=:id and pid>0 and status=1 '.$o_condition,array(':id'=>$mem['id']));
		$mem['order_amount'] = $amount>0?$amount:0;
		$mem['user_type'] = 2;
	}

	$list = array_merge($list,$member);
    $total = count($list);
    $list = array_slice($list,($page-1)*$psize,$psize);
    foreach ($list as $key => $value) {
		if ($value['user_type'] == 1) {
			$agent_num = pdo_fetchcolumn('select count(id) from '.tablename('agent_member').' where parent_agent=:agent',array(':agent'=>$value['id']));
			$member_num = pdo_fetchcolumn('select count(id) from '.tablename('member_system_member').' where parent_agent=:agent',array(':agent'=>$value['id']));
			$list[$key]['bonus'] = pdo_fetchcolumn('select bonus_percent from '.tablename('agent_percent').' where agent_id=:agent_id',array(':agent_id'=>$value['id']));
			$list[$key]['child_num'] = $agent_num+$member_num;
		}
		else{
			$list[$key]['used_odds'] = pdo_fetchall('select m.id,o.title from '.tablename('manji_member_odds').' m left join '.tablename('agent_odds').' a on a.id=m.pid left join '.tablename('manji_odds').' o on o.id=a.pid where m.member_id=:id',array(':id'=>$value['id']));
			$list[$key]['child_num'] = 0;
		}
		
	}
    $pager = pagination($total,$page,$psize);
    include $this->template('user_order');
    exit;
}






 ?>