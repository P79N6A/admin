<?php 
global $_W,$_GPC;

$mid = $_SESSION['mid'];
if (empty($mid)) {
	$result = array(
		'status' => 3,
		'info' => '请先登录'
	);
	echo json_encode($result);
	exit;
}

if ($_SESSION['level'] == 4) {
	$childs = get_children($mid);
	$childs[] = $mid;
	$child_fields = implode(',',$childs);
	$p_condition = ' where parent_agent in ('.$child_fields.') ';
	$user_ids = pdo_fetchColumnValue('select id from '.tablename('member_system_member').' where parent_agent in ('.$child_fields.')',array(),'id');
	if (!empty($user_ids)) {
		$user_fields = implode(',',$user_ids);
		$o_condition = ' and user_id in ('.$user_fields.') ';
		$s_condition = ' and o.user_id in ('.$user_fields.') ';
	}
}
if ($_SESSION['level'] < 4 && $_SESSION['level'] > 1) {
	$p_condition = ' where cid='.$_SESSION['cid'].' ';
}

$number = $_GPC['number'];
$agent_id = $_GPC['agent'];
$len = strlen($number);
$date = $_GPC['date']?$_GPC['date']:date('Y-m-d',time());
$company = $_GPC['company'];
$type = $_GPC['type'];
if (!empty($company)) {
	$a_condition = ' and id=:id';
	$c_fields[':id'] = $company;
}
if ($_SESSION['cid'] > 0) {
	$pr_condition = ' and aid='.$_SESSION['cid'];
}
$o_condition = '';
$period_id = pdo_fetchall('select id from '.tablename('manji_run_setting').' where date=:date '.$pr_condition,array(':date'=>$date));
if (!empty($period_id)) {
	foreach ($period_id as $p => $pp) {
		if ($p == 0) {
			$o_condition .= ' and (o.period_id like \'%('.$pp['id'].'%)\' ';
			$pt_condition .= ' and (o.period_id like \'%('.$pp['id'].'%)\' ';
		}
		else{
			$o_condition .= ' or o.period_id like \'%('.$pp['id'].')%\' ';
			$pt_condition .= ' or o.period_id like \'%('.$pp['id'].')%\' ';
		}
	}
	$o_condition .= ')';
	$pt_condition .= ')';
}
else{
	$o_condition = ' and o.period_id=(\'0\') ';
	$pt_condition = ' and o.period_id=(\'2\') ';
}
if (!empty($agent_id)) {
	if ($_SESSION >= 4) {
		$agent_parent = pdo_fetch('select parent_agent from '.tablename('agent_member').' where id=:id',array(':id'=>$agent_id));
		if ($agent_parent == $mid) {
			$childs = get_children($agent_id);
			$childs[] = $agent_id;
			$child_fields = implode(',',$childs);
			$p_condition = ' and parent_agent in ('.$child_fields.') ';
			$user_ids = pdo_fetchColumnValue('select id from '.tablename('member_system_member').' where parent_agent in ('.$child_fields.')',array(),'id');
			if (!empty($user_ids)) {
				$user_fields = implode(',',$user_ids);
				$o_condition = ' and user_id in ('.$user_fields.') ';
				$s_condition = ' and o.user_id in ('.$user_fields.') ';
			}
		}
		else{
			$o_condition = ' and user_id='.$agent_id;
		}
	}
	else{
		$childs = get_children($agent_id);
		$childs[] = $agent_id;
		$child_fields = implode(',',$childs);
		$p_condition = ' and parent_agent in ('.$child_fields.') ';
		$user_ids = pdo_fetchColumnValue('select id from '.tablename('member_system_member').' where parent_agent in ('.$child_fields.')',array(),'id');
		if (!empty($user_ids)) {
			$user_fields = implode(',',$user_ids);
			$o_condition = ' and user_id in ('.$user_fields.') ';
			$s_condition = ' and o.user_id in ('.$user_fields.') ';
		}
	}
}

switch ($len) {
	case 2:
		$check = 'sum(d.pay_2A*(100+false_price)/100) as 2A,sum(d.pay_2B*(100+false_price)/100) as 2B,sum(d.pay_2C*(100+false_price)/100) as 2C,sum(d.pay_2D*(100+false_price)/100) as 2D,sum(d.pay_2E*(100+false_price)/100) as 2E,sum(d.pay_EX*(100+false_price)/100) as EX,sum(d.pay_2ABC*(100+false_price)/100) as 2ABC ';
		break;

	case 3:
		$check = 'sum(d.pay_A*(100+false_price)/100) as A,sum(d.pay_C2*(100+false_price)/100) as C2,sum(d.pay_C3*(100+false_price)/100) as C3,sum(d.pay_C4*(100+false_price)/100) as C4,sum(d.pay_C5*(100+false_price)/100) as C5,sum(d.pay_EC*(100+false_price)/100) as EC,sum(d.pay_3ABC*(100+false_price)/100) as 3ABC ';
		break;

	case 4:
		$check = 'sum(d.pay_B*(100+false_price)/100) as B,sum(d.pay_S*(100+false_price)/100) as S,sum(d.pay_4A*(100+false_price)/100) as 4A,sum(d.pay_4B*(100+false_price)/100) as 4B,sum(d.pay_4C*(100+false_price)/100) as 4C,sum(d.pay_4D*(100+false_price)/100) as 4D,sum(d.pay_4E*(100+false_price)/100) as 4E,sum(d.pay_EA*(100+false_price)/100) as EA,sum(d.pay_4ABC*(100+false_price)/100) as 4ABC ';
		break;

	case 5:
		$check = 'sum(d.pay_5D*(100+false_price)/100) as 5D ';
		break;

	case 6:
		$check = 'sum(d.pay_6D*(100+false_price)/100) as 6D ';
		break;
	
	default:
		# code...
		break;
}



$companys = pdo_fetchall('select id,nickname from '.tablename('manji_company').' where 1 '.$a_condition.' order by id asc',$c_fields);

foreach ($companys as $key => $value) {
	$summary = pdo_fetch('select '.$check.' from '.tablename('manji_order_detail').' d left join '.tablename('manji_order').' o on o.id=d.order_id where o.cid like \'%('.$value['id'].')%\' and (d.number=:number or SUBSTRING(d.number,-3)=:number or SUBSTRING(d.number,-2)=:number) and o.status=1'.$o_condition,array(':number'=>$number));
	if (!empty($summary)) {
		foreach ($summary as $k => $v) {
			if (!empty($type)) {
				if ($k == $type) {
					$summary[$k] = $v;
				}
				else{
					unset($summary);
				}
			}
		}
		$companys[$key]['detail'] = $summary;
	}
	else{
		unset($companys[$key]);
	}
}

$companys = array_values($companys);

$user = pdo_fetchall('select id,nickname,account,parent_agent from '.tablename('member_system_member').$p_condition.' order by parent_agent asc ',$p_fields);


foreach ($user as $k => $v) {
	if (!empty($company)) {
		$co_condition = ' and cid like \'%('.$company.')%\' ';
	}
	if (!empty($type)) {
		$t_condition = 'and pay_'.$type.'>0 ';
	}
	$order = pdo_fetchall('select o.cid from '.tablename('manji_order_detail').' d left join '.tablename('manji_order').' o on o.id=d.order_id where (d.number=:number or SUBSTRING(d.number,-3)=:number or SUBSTRING(d.number,-2)=:number) and o.user_id=:user_id and o.status=1'.$co_condition.$t_condition.$pt_condition,array(':number'=>$number,':user_id'=>$v['id']));
	if (count($order) > 0) {
		$new_com = array();
		foreach ($order as $key => $value) {
			$com = explode(',', $value['cid']);
			foreach ($com as &$c) {
				$c = str_replace('(','',$c);
				$c = str_replace(')','',$c);
			}
			$new_com = array_merge($new_com,$com);
		}
		$new_com = array_unique($new_com);
		if (count($new_com) > 0) {
			$new_com_fields = implode(',',$new_com);
			$new_company = pdo_fetchall('select id,nickname from '.tablename('manji_company').' where id in ('.$new_com_fields.') order by id asc');
			foreach ($new_company as $key => $value) {
				$sum = pdo_fetch('select '.$check.' from '.tablename('manji_order_detail').' d left join '.tablename('manji_order').' o on o.id=d.order_id where o.cid like \'%('.$value['id'].')%\' and (d.number=:number or SUBSTRING(d.number,-3)=:number or SUBSTRING(d.number,-2)=:number) and user_id=:user_id and status=1 '.$pt_condition,array(':number'=>$number,':user_id'=>$v['id']));
				foreach ($sum as $a => $b) {
					if (floatval($b) > 0) {
						if (!empty($type)) {
							if ($a == $type) {
								$detail[$a]['value'] = $b;
								$ord = pdo_fetchColumnValue('select pid from '.tablename('manji_order_detail').' d left join '.tablename('manji_order').' o on o.id=d.order_id where d.pay_'.$a.'>0 and o.user_id=:user_id and (d.number=:number or SUBSTRING(d.number,-3)=:number or SUBSTRING(d.number,-2)=:number) and o.status=1 and o.cid like \'%('.$value['id'].')%\' '.$pt_condition,array(':user_id'=>$v['id'],':number'=>$number),'pid');
								$ord = array_unique($ord);
								$pid_fields = implode(',',$ord);
								if (!empty($pid_fields)) {
									$real_order = pdo_fetchall('select id,ordersn from '.tablename('manji_order').' where id in ('.$pid_fields.') order by ordersn asc');
								}
								$detail[$a]['order'] = $real_order?$real_order:array();
							}
						}
						else{
							$detail[$a]['value'] = $b;
							$ord = pdo_fetchColumnValue('select pid from '.tablename('manji_order_detail').' d left join '.tablename('manji_order').' o on o.id=d.order_id where d.pay_'.$a.'>0 and o.user_id=:user_id and (d.number=:number or SUBSTRING(d.number,-3)=:number or SUBSTRING(d.number,-2)=:number) and o.status=1 and o.cid like \'%('.$value['id'].')%\' '.$pt_condition,array(':user_id'=>$v['id'],':number'=>$number),'pid');
							$ord = array_unique($ord);
							$pid_fields = implode(',',$ord);
							if (!empty($pid_fields)) {
								$real_order = pdo_fetchall('select id,ordersn from '.tablename('manji_order').' where id in ('.$pid_fields.') order by ordersn asc');
							}
							$detail[$a]['order'] = $real_order?$real_order:array();
						}
						
					}
				}
				if (!empty($detail)) {
					$new_company[$key]['detail'] = $detail;
					$has_detail++;
				}
			}
			if (empty($has_detail)) {
				unset($user[$k]);
			}
			else{
				$user[$k]['company'] = $new_company;
				$account = '';
				$agent = getParent($v['parent_agent']);
				if (count($agent) > 0) {
					$agent_info = pdo_fetch('select account,nickname,parent_agent from '.tablename('agent_member').' where id=:id',array(':id'=>$v['parent_agent']));
					$parents_fields = implode(',',$agent);
					$parents = pdo_fetchall('select account,nickname,id from '.tablename('agent_member').' where id in ('.$parents_fields.') order by id asc');
					foreach ($parents as $key => $value) {
						if ($key == 0) {
							$account .= $value['account'];
						}
						else{
							$account .= '>'.$value['account'];
						}
					}
				}
				if ($account != '') {
					$account .= '>'.$agent_info['account'];
				}
				else{
					$account .= $agent_info['account'];
				}
				$user[$k]['agent'] = $account;
			}
		}
		else{
			unset($user[$k]);
		}
	}
	else{
		unset($user[$k]);
	}
}
$user = array_values($user);

$result = array(
	'status' => 1,
	'companys' => $companys,
	'user' => $user
);
echo json_encode($result);
exit;



 