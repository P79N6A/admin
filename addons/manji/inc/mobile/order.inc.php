<?php 
global $_W,$_GPC;

$op = $_GPC['op']?$_GPC['op']:'display';
$member_id = $_COOKIE['uid'];
$my_info = pdo_fetch('select * from '.tablename('member_system_member').' where id=:id',array(':id'=>$member_id));

if ($op == 'display') {
	if (empty($member_id)) {
		header('Location:'.$this->createMobileUrl('login'));
	}
}

if ($op == 'search_order') {
	if (empty($member_id)) {
		header('Location:'.$this->createMobileUrl('login'));
	}

	$psize = $_GPC['size']?$_GPC['size']:50;
	$orders = pdo_fetchall('select id,uordersn from '.tablename('manji_order').' where user_id=:user and pid=0 order by id desc limit 0,'.$psize,array(':user'=>$member_id));
	$sn = $orders[0]['uordersn'];
	$first_id = $orders[0]['id'];
}

if ($op == 'get_order') {
	include '../addons/purchasing/include_order.php';
	$start = $_GPC['stime']?strtotime($_GPC['stime'].' 00:00:00'):strtotime(date('Y-m-d 00:00:00',(time())));
	$endtime = $_GPC['etime']?strtotime($_GPC['etime'].' 23:59:59'):strtotime(date('Y-m-d 23:59:59',(time())));
	$porder = pdo_fetchall('select * from '.tablename('manji_order').' where createtime between :start and :end and user_id=:id and pid=0',array(':start'=>$start,':end'=>$endtime,':id'=>$member_id));
	foreach ($porder as $ord) {
		$uorder = pdo_fetchall('select * from '.tablename('manji_order').' where pid=:id',array(':id'=>$ord['id']));
		$member = pdo_fetch('select * from '.tablename('member_system_member').' where id=:id',array(':id'=>$ord['user_id']));
		$company_array = array();
		$new_uorder = array();
		foreach ($uorder as &$value) {
			$company = explode(',',$value['cid']);
			foreach ($company as &$com) {
				$com = str_replace('(','',$com);
				$com = str_replace(')','',$com);
				$company_array[] = $com;
				$com = pdo_fetchcolumn('select nickname from '.tablename('manji_company').' where id=:id',array(':id'=>$com));
			}
			if (in_array(1,$company_array)) {
				$no_edit = 1;
			}
			$nickname = implode('',$company);
			$value['time'] = date('d/m/Y H:i',$value['createtime']);
			$value['company'] = $nickname;
			$ruler = $r[$value['play_type']];
			foreach ($value as $ky => $val) {
				if (strpos($ky,'pay_') !== false && $val > 0) {
					$value['pay'][] = floatval($val);
				}
			}
			$value['type'] = intval($value['mode']);
			$value['rule'] = intval($value['play_type']);
			$sale_out = pdo_fetchall('select * from '.tablename('manji_sale_out').' where order_id=:id',array(':id'=>$value['id']));
			if (count($sale_out) > 0) {
				foreach ($sale_out as &$sale) {
					$sale['can_pay'] = json_decode($sale['can_pay'],true);
				}
				$has_sale_out = 1;
			}
			$value['sale_out'] = $sale_out?$sale_out:array();
			$value['partner'] = $value['partner_number'];
			$new_uorder[$nickname][] = $value;
		}
		$company_array = array_unique($company_array);
		$end = array();
		if ($porder['days'] > 0) {
			$day_count = $porder['days'];
		}
		else{
			$day_count = 1;
		}
		$com_count = count($company_array);
		$periods = pdo_fetchall('select id,stoptime,endtime,cid from '.tablename('manji_run_setting').' where aid=:aid and status=1 and cid in ('.implode(',',$company_array).') order by endtime asc limit 0,'.($day_count*$com_count),array(':aid'=>$member['cid']));
		$end = getBetDate($company_array,$periods,$member['cid'],$day_count);
		foreach ($end as $e => $n) {
			$end[$e] = implode(',',$n);
		}
		$order = array(
			'status' => 1,
			'pid' => $ord['ordersn'],
			'order_status' => $ord['status'],
			'order_id' => $id,
			'ordertime' => date('d/m/Y H:i',$ord['createtime']),
			'cancel_time' => date('Y-m-d H:i',$ord['cancel_time']),
			'account' => $member['account'],
			'sn' => $ord['uordersn'],
			'end' => $end,
			'amount' => $ord['order_amount'],
			'show_amount' => $show_amount,
			'counts' => count($uorder),
			'uorder' => $new_uorder,
			'no_edit' => $no_edit,
			'sale_out' => $has_sale_out,
			'has_sale_out' => $has_sale_out
		);
		if ($ord['days'] == 0) {
			$order['type'] = 1;
		}
		$result[] = $order;
	}
	$data = array(
		'list' => $result,
		'count' => count($result)
	);
	echo json_encode($data);
	exit;
}



include $this->template('order');

 ?>