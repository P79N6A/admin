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

$op = $_GPC['op'];

if ($op == 'rebuy') {
	include '../addons/purchasing/include_order.php';
	$starttime = microtime(true);
	$id = $_GPC['id'];
	$porder = pdo_fetch('select user_id,order_amount,days,`write` from '.tablename('manji_order').' where id=:id',array(':id'=>$id));
	$ordersn = pdo_fetchcolumn('select ordersn from '.tablename('manji_order').' where id=:id',array(':id'=>$id));
	$member = pdo_fetch('select * from '.tablename('member_system_member').' where id=:id',array(':id'=>$porder['user_id']));
	$rule = pdo_fetchall('select * from '.tablename('manji_rules').' order by id asc');
	$uorder = pdo_fetchall('select * from '.tablename('manji_order').' where pid=:id',array(':id'=>$id));
	$order_number = pdo_fetchcolumn('select count(id) from '.tablename('manji_order').' where pid=0');
	$uorder_number = pdo_fetchcolumn('select count(id) from '.tablename('manji_order').' where user_id=:id and pid=0',array(':id'=>$porder['user_id']));
	$bet_limit = pdo_fetchcolumn('select red_limit from '.tablename('manji_member_red').' where user_id=:user_id',array(':user_id'=>$member_id));
	$parents = getParent($member['parent_agent']);
	$parents[] = $member['parent_agent'];
	$limit = pdo_fetchColumnValue('select red_limit from '.tablename('agent_red').' where agent_id in ('.implode(',', $parents).')',array(),'red_limit');
	$limit[] = $bet_limit;
	$porder['ordersn'] = $order_number+1;
	$porder['uordersn'] = $uorder_number+1;
	$porder['createtime'] = time();
	$porder['create_agent'] = $_SESSION['mid'];
	$porder['old_id'] = $ordersn;
	$porder['soucre'] = $_SERVER['HTTP_USER_AGENT'];
	if ($member['credit1'] < $porder['order_amount']) {
		$result = array(
			'status' => 2,
			'info' => '账号积分不足'
		);
		echo json_encode($result);
		exit;
	}
	pdo_begin();
	pdo_insert('manji_order',$porder);
	$pid = pdo_insertid();
	$company_array = array();
	foreach ($uorder as $key => $value) {
		$company = str_replace('(', '', $value['cid']);
		$company = str_replace(')','',$company);
		$companys = explode(',', $company);
		$company_array = array_merge($company_array,$companys);
	}
	$day = $porder['days'];
	if ($day == 0) {
		$days_type = 1;
		$day_count = 1;
	}
	else{
		$day_count = $day;
	}
	foreach ($rule as $key => $value) {
		$r[$value['id']] = $value['content'];
	}
	$company_array = array_unique($company_array);
	if (in_array(1,$company_array)) {
		$no_edit = 1;
	}
	$com_count = count($company_array);
	$periods = pdo_fetchall('select id,stoptime,endtime,cid from '.tablename('manji_run_setting').' where aid=:aid and status=1 and cid in ('.implode(',',$company_array).') order by endtime asc limit 0,'.($day_count*$com_count),array(':aid'=>$member['cid']));
	$end = getCompanyDate($company_array,$periods,$member['cid'],$day_count);
	if (is_array($end) == true) {
		foreach ($end as &$en) {
			$en = implode(',',$en);
		}
	}
	else{
		$result = array(
			'status' => 2,
			'info' => $end
		);
		echo json_encode($result);
		exit;
	}
	foreach ($uorder as $key => $value) {
		$company = str_replace('(', '', $value['cid']);
		$company = str_replace(')','',$company);
		$ruler = explode(',', $r[$value['play_type']]);
		$comp = array();
		$periods = '';
		$area = array();
		$uamount = 0;
		$sale_out = array();
		$number_detail = array();
		$out = array();
		$spay = array();
		$periods = str_replace('(', '', $value['period_id']);
		$periods = str_replace(')', '', $periods);
		foreach ($value as $k => $v) {
			if (strpos($k,'pay_') !== false && $v>0) {
				$pay[str_replace('pay_','',$k)] = $v;
				$spay[] = $v;
			}
		}
		$companys = explode(',', $company);
		$comps = pdo_fetchColumnValue('select nickname from '.tablename('manji_company').' where id in ('.$company.')',array(),'nickname');
		$periods_id = pdo_fetchall('select * from '.tablename('manji_run_setting').' where id in ('. $periods.')');
		$save = array(
			'pid' => $pid,
			'user_id' => $value['user_id'],
			'cid' => $value['cid'],
			'number' => $value['number'],
			'goods_amount' => $value['goods_amount'],
			'mode' => $value['mode'],
			'days' => $value['days'],
			'play_type' => $value['play_type'],
			'partner_number' => $value['partner_number'],
			'jackpot_number' => $value['jackpot_number'],
			'array_id'=>$value['array_id'],
			'createtime' => time()
		);
		$period_ids = array();
		foreach ($companys as $ky => $com) {
			$area_id = pdo_fetchcolumn('select area_id from '.tablename('manji_company').' where id=:id',array(':id'=>$com));
			$comp[] = pdo_fetchcolumn('select nickname from '.tablename('manji_company').' where id=:id',array(':id'=>$com));
			$periods_id = pdo_fetchall('select id,date,cid from '.tablename('manji_run_setting').' where stoptime>:time and cid=:cid and aid=:aid and status=1 order by stoptime asc limit 0,'.$day_count,array(':time'=>time(),':cid'=>$com,':aid'=>$member['cid']));
			if ($com == 1) {
				$com_limit = pdo_fetchall('select * from '.tablename('manji_red_number').' where cid=0');
			}
			else{
				$com_limit = pdo_fetchall('select * from '.tablename('manji_red_number').' where cid=:cid',array(':cid'=>$member['cid']));
			}
			foreach ($com_limit as $cl) {
				$system_red_limit[$cl['number']] = $cl['bet_limit'];
			}
			$time_limit = pdo_fetchall('select * from '.tablename('manji_limit_time').' where cid=:cid order by time desc limit 0,1',array(':cid'=>$_SESSION['cid']));
			$tlimit = 0;
			foreach ($time_limit as $tl) {
				if (strtotime($period_id[0]['date'].$tl['time']) < time()) {
					$tlimit = $tl['limit'];
				}
			}
			if (strlen($value['number']) == 5) {
				$ruler = array('5D');
			}
			if (strlen($value['number']) == 6) {
				$ruler = array('6D');
			}
			foreach ($ruler as $ky => $val) {
				$number_array = set_number_array($value['number'],$value['mode']);
				$number_count = count($number_array);
				if ($value['mode'] == 2) {
					$bet_money = $pay[$val]/$number_count;
				}
				else{
					$bet_money = $pay[$val];
				}
				foreach ($number_array as $num) {
					if (!empty($system_red_limit[$num])) {
						$sample_red = compare_user_red($limit,$val,$bet_money);
						$system_red = compare_system_red($num,$com,$system_red_limit[$num],$val,$bet_money,$number_extra[$com][$num][$val],$periods_id[0]['id']);
					}
					else{
						$sample_red = $bet_money;
						$system_red = $bet_money;
					}
					if (!empty($tlimit)) {
						$system_limit = compare_system($tlimit,$val,$com,$bet_money,$user_extra[$com][$val]);
					}
					else{
						$system_limit = $bet_money;
					}
					$number_limit = min($sample_red,$system_red,$system_limit,$bet_money);
					foreach ($periods_id as $per) {
						if ($per['cid'] > 1) {
							// number_eat($com,$num,$bet_money,$member['parent_agent'],$val,0,$per['date'],$member['id']);
							$number_eat[] = array(
								'com' => $com,
								'num' => $num,
								'bet_money' => $bet_money,
								'agent' => $member['parent_agent'],
								'rule' => $val,
								'minus' => 0,
								'date' => $per['date'],
								'member' => $member['id']
							);
						}
					}
					$number_extra[$com][$num][$val] += $number_limit;
					$user_extra[$com][$val] = $number_limit;
					$save['pay_'.$val] = $number_limit;
					$uamount += $number_limit;
					if ($bet_money != $number_limit) {
						if ($sample_red == $number_limit || $system_red == $number_limit) {
							$out[$num]['is_red'] = 1;
						}
						$out[$num][$val] = $bet_money;
						$can[$num][$val] = $number_limit;
					}
					$number_detail[$num]['pay_'.$val] = $number_limit;
				}
			}
			if (count($out)>0) {
				foreach ($out as $o => $t) {
					foreach ($t as $n => $m) {
						if ($n != 'is_red') {
							$red[$n] = $m;
						}
					}
					$sale_out[] = array(
						'number' => $o,
						'pay' => json_encode($red),
						'can_pay' => json_encode($can[$o]),
						'is_red' => $t['is_red']
					);
				}
				$has_sale_out = 1;
			}
			foreach ($periods_id as $per) {
				$period_ids[] = '('.$per['id'].')';
			}
			$area[] = $com;
			$com = '('.$com.')';
		}
		if ($uamount == 0 && count($sale_out) == 0) {
			continue;
		}
		if (strlen($value['number']) > 2) {
			saveJackpot($area,$uamount);
		}
		$save['period_id'] = implode(',', $period_ids);
		$new_amount += $uamount;
		$save['order_amount'] = $uamount;
		if ($member['has_false'] == 1) {
			$save['false_price'] = $member['false_price'];
		}
		$uo = array(
			'type' => $value['mode'],
			'number' => $value['number'],
			'pay' => $spay,
			'rule' => $value['play_type'],
			'partner' => $value['partner_number'],
			'jackpot_number' => $value['jackpot_number'],
			'false_price' => $value['false_price']
		);
		$uo['sale_out'] = $sale_out?$sale_out:array();
		foreach ($uo['sale_out'] as &$vale) {
			$vale['can_pay'] = json_decode($vale['can_pay'],true);
		}
		$uo['company'] = implode('',$comps);
		$neworder[] = $uo;
		$res = pdo_insert('manji_order',$save);
		if (!$res) {
			pdo_rollback();
		}
		else{
			$uoid = pdo_insertid();
			foreach ($number_detail as $n => $vn) {
				$vn['order_id'] = $uoid;
				$vn['number'] = $n;
				$vn['period_id'] = $save['period_id'];
				$vn['source'] = $_SERVER['HTTP_USER_AGENT'];
				pdo_insert('manji_order_detail',$vn);
			}
			if (count($sale_out) > 0) {
				foreach ($sale_out as $value) {
					$value['order_id'] = $uoid;
					pdo_insert('manji_sale_out',$value);
				}
				$has_sale_out = 1;
			}
		}
	}
	if ($member['has_false'] == 1) {
		$real_price = $new_amount*(100+$member['false_price'])/100;
	}
	else{
		$real_price = $new_amount;
	}
	if ($real_price > $member['pay_limit']) {
		$result = array(
			'status' => 2,
			'info' => '超出一张单的可投注额'
		);
		echo json_encode($result);
		exit;
	}
	if ($has_sale_out > 0) {
		$sale_out_total = array(
			'order_id' => $pid,
			'amount' => $amount
		);
		pdo_insert('manji_sale_out',$sale_out_total);
		pdo_update('member_system_member',array('credit1'=>$member['credit1']-$real_price),array('id'=>$member['id']));
	}
	else{
		$new_amount2 = $real_price*$member['give']/100;
		$surplus = $real_price - $new_amount2;
		if ($surplus > $member['credit1']) {
			$result = array(
				'status' => 2,
				'info' => '账号积分不足'
			);
			echo json_encode($result);
			exit;
		}
		if ($new_amount2 > $member['credit2']) {
			$credit1_surplus = $new_amount2 - $member['credit2'];
			if ($credit1_surplus+$surplus > $member['credit1']) {
				$result = array(
					'status' => 2,
					'info' => '账号积分不足'
				);
				echo json_encode($result);
				exit;
			}
			pdo_update('member_system_member',array('credit1'=>$member['credit1']-$surplus-$credit1_surplus,'credit2'=>0),array('id'=>$member['id']));
		}
		else{
			pdo_update('member_system_member',array('credit1'=>$member['credit1']-$surplus,'credit2'=>$member['credit2']-$new_amount2),array('id'=>$member['id']));
		}
	}
	if ($member['show_amount'] > 0) {
		$show_amount = $new_amount*(100-$member['show_amount'])/100;
	}
	$count_number = count($neworder);
	foreach ($neworder as $u) {
		$newuorder[$u['company']][] = $u;
	}
	$endtime = microtime(true);
	pdo_update('manji_order',array('calculating_time'=>$endtime-$starttime,'order_amount'=>$new_amount),array('id'=>$pid));
	pdo_commit();
	$result = array(
		'status' => 1,
		'info' => '下注成功',
		'pid' => $porder['ordersn'],
		'order_id' => $pid,
		'ordertime' => date('d/m/Y H:i',time()),
		'account' => $member['account'],
		'sn' => $porder['uordersn'],
		'type' => $days_type,
		'end' => $end,
		'amount' => $new_amount>0?$new_amount:$porder['order_amount'],
		'show_amount' => $show_amount,
		'counts' => $count_number,
		'no_edit' => $no_edit,
		'uorder' => $newuorder,
		'sale_out' => $sale_out,
		'time' => $endtime - $starttime
	);
	echo json_encode($result);
	exit;
}

if ($op == 'restore') {
	$id = $_GPC['id'];
	$pout = pdo_fetchcolumn('select amount from '.tablename('manji_sale_out').' where order_id=:id',array(':id'=>$id));
	$porder = pdo_fetch('select user_id,order_amount from '.tablename('manji_order').' where id=:id',array(':id'=>$id));
	$member = pdo_fetch('select * from '.tablename('member_system_member').' where id=:id',array(':id'=>$porder['user_id']));
	$uorder = pdo_fetchColumnValue('select id from '.tablename('manji_order').' where pid=:pid',array(':pid'=>$id),'id');
	$uorder = implode(',',$uorder);
	$uout = pdo_fetchall('select order_id,pay from '.tablename('manji_sale_out').' where order_id in ('.$uorder.')');
	pdo_begin();
	foreach ($uout as $key => $value) {
		$pay = json_decode($value['pay']);
		foreach ($pay as $k => $v) {
			$save['pay_'.$k] = $v;
			$save['order_amount'] += $v;
		}
		$res = pdo_update('manji_order',$save,array('id'=>$value['order_id']));
		if (!$res) {
			pdo_rollback();
			$result = array(
				'status' => 2,
				'info' => '还原失败'
			);
			echo json_encode($result);
			exit;
		}
		pdo_delete('manji_sale_out',array('order_id'=>$value['order_id']));
	}
	$res = pdo_update('manji_order',array('order_amount'=>$pout),array('id'=>$id));
	if ($res) {
		$amount = $pout - $porder['order_amount'];
		pdo_update('member_system_member',array('credit1'=>$member['credit1']-$amount),array('id'=>$porder['user_id']));
		pdo_commit();
		$result = array(
			'status' => 1,
			'info' => '还原成功'
		);
	}
	else{
		pdo_rollback();
		$result = array(
			'status' => 2,
			'info' => '还原失败'
		);
	}
	echo json_encode($result);
	exit;
}

if ($op == 'edit_order') {
	$order_id = $_GPC['order_id'];
	$company = $_GPC['com'];
	$type = $_GPC['type'];
	$rule = $_GPC['rule'];
	$number = $_GPC['number'];
	$pay = $_GPC['pay'];
	$amount = 0;
	$status = pdo_fetchcolumn('select status from '.tablename('manji_order').' where id=:id',array(':id'=>$order_id));
	if ($status == 2) {
		$result = array(
			'status' => 2,
			'info' => '本单已删除，无法更改'
		);
		echo json_encode($result);
		exit;
	}
	$ruler = pdo_fetchcolumn('select content from '.tablename('manji_rules').' where id=:id',array(':id'=>$rule));
	$ruler = explode(',',$ruler);
	$out = pdo_fetchall('select id,can_pay,pay from '.tablename('manji_sale_out').' where order_id=:id',array(':id'=>$order_id));
	foreach ($company as &$com) {
		$com = '('.$com.')';
	}
	if (!empty($out)) {
		foreach ($out as $key => $value) {
			$can_pay = json_decode($value['can_pay'],true);
			$will_pay = json_decode($value['pay'],true);
			if (!empty($can_pay)) {
				foreach ($ruler as $k => $v) {
					if ($pay[$k] == $will_pay[$v]) {
						$restore = 1;
					}
					else{
						$can_pay[$v] = $pay[$k];
					}
				}
				pdo_update('manji_sale_out',array('can_pay'=>$can_pay),array('id'=>$value['id']));
			}
		}
		if ($restore == 1) {
			pdo_delete('manji_sale_out',array('order_id'=>$order_id));
		}
	}
	$save = array(
		'cid' => implode(',',$company),
		'mode' => $type,
		'play_type' => $rule,
		'number' => $number
	);
	foreach ($ruler as $k => $r) {
		$save['pay_'.$r] = $pay[$k];
		$detail['pay_'.$r] = $pay[$k];
		$amount += $pay[$k];
	}
	$save['goods_amount'] = $amount;
	$save['order_amount'] = $amount;
	pdo_update('manji_order',$save,array('id'=>$order_id));
	pdo_update('manji_order_detail',$detail,array('order_id'=>$order_id));
	$result = array(
		'status' => 1,
		'info' => '保存成功'
	);
	echo json_encode($result);
	exit;
}

if ($op == 'del') {
	$id = $_GPC['id'];
	$porder = pdo_fetch('select * from '.tablename('manji_order').' where id=:id',array(':id'=>$id));
	$uorder = pdo_fetchall('select * from '.tablename('manji_order').' where pid=:pid',array(':pid'=>$id));
	if ($porder['status'] == 2) {
		$data = array(
			'status' => 2,
			'info' => '本单已被删除'
		);
		echo json_encode($data);
		exit;
	}
	pdo_begin();
	foreach ($uorder as $key => $value) {
		$period = str_replace('(','',$value['period_id']);
		$period = str_replace(')','',$period);
		$has_result = pdo_fetchcolumn('select count(*) from '.tablename('manji_lottery_record').' where period_id in ('.$period.')');
		if ($has_result > 0) {
			pdo_rollback();
			$data = array(
				'status' => 2,
				'info' => '本期已开，无法删除'
			);
			echo json_encode($data);
			exit;
		}
		$res = pdo_update('manji_order',array('order_amount'=>0,'status' => 2,'days'=>1,'cancel_time'=>time()),array('id'=>$value['id']));
		if (!$res) {
			pdo_rollback();
			$data = array(
				'status' => 2,
				'info' => '删除失败'
			);
			echo json_encode($data);
			exit;
		}
		pdo_delete('manji_sale_out',array('order_id'=>$value['id']));
		pdo_delete('manji_order_detail',array('order_id'=>$value['id']));
	}
	pdo_update('manji_order',array('status'=>2,'order_amount'=>0,'cancel_time'=>time()),array('id'=>$id));
	pdo_delete('manji_sale_out',array('order_id'=>$id));
	pdo_query('update '.tablename('member_system_member').' set credit1=credit1+:credit where id=:id',array(':credit'=>$porder['order_amount'],':id'=>$porder['user_id']));
	pdo_commit();
	$data = array(
		'status' => 1,
		'info' => '删除成功'
	);
	echo json_encode($data);
	exit;
}

if ($op == 'change_days') {
	$id = $_GPC['id'];
	$is_auto = $_GPC['is_auto'];

	if ($is_auto == 'true') {
		pdo_update('manji_order',array('days'=>0),array('id'=>$id));
	}
	if ($is_auto == 'false') {
		pdo_update('manji_order',array('days'=>1),array('id'=>$id));
	}

	$data = array(
		'status' => 1,
		'info' => '修改成功'
	);
	echo json_encode($data);
	exit;
}




 ?>