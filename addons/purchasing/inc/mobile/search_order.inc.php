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

if ($op == 'order') {
	$sn = $_GPC['ordersn'];
	$id = pdo_fetchcolumn('select id from '.tablename('manji_order').' where ordersn=:ordersn',array(':ordersn'=>$sn));
	if (!empty($id)) {
		$porder = pdo_fetch('select * from '.tablename('manji_order').' where id=:id',array(':id'=>$id));
		$uorder = pdo_fetchall('select * from '.tablename('manji_order').' where pid=:id',array(':id'=>$id));
		$member = pdo_fetch('select * from '.tablename('member_system_member').' where id=:id',array(':id'=>$porder['user_id']));
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
			$new_uorder[$nickname][] = $value;
		}
	}
	$company_array = array_unique($company_array);
	foreach ($company_array as $item) {
		if ($porder['days'] > 0) {
			$nickname = pdo_fetchcolumn('select nickname from '.tablename('manji_company').' where id=:id',array(':id'=>$item));
			$next = pdo_fetchall('select r.*,c.nickname from '.tablename('manji_run_setting').' r left join '.tablename('manji_company').' c on c.id=r.cid where c.id=:id and stoptime>:time order by endtime asc limit 0,'.$porder['days'],array(':id'=>$item,':time'=>$porder['createtime']));
			$date = array();
			foreach ($next as $d => $t) {
				$date[] = array(
					'day' => date('d',$t['endtime']),
					'month' => date('m',$t['endtime']),
					'year' => date('Y',$t['endtime'])
				);
				$time = date('H:i',$t['endtime']);
			}
			$date_str = '';
			for ($i=0; $i < count($date); $i++) { 
				if ($i == 0) {
					if ($date[$i]['month'] == $date[$i+1]['month']) {
						$date_str .= $date[$i]['day'];
					}
					elseif ($date[$i]['year'] == $data[$i+1]['year']) {
						$date_str .= $date[$i]['day'].'/'.$date[$i]['month'];
					}
					else{
						$date_str .= $date[$i]['day'].'/'.$date[$i]['month'].'/'.$date[$i]['year'];
					}
				}
				if ($i > 0 && $i != (count($date)-1)) {
					if ($date[$i]['month'] == $date[$i+1]['month'] || $date[$i+1]['month'] == 0) {
						$date_str .= ','.$date[$i]['day'];
					}
					elseif ($date[$i]['year'] == $data[$i+1]['year'] || $date[$i+1]['year'] == 0) {
						$date_str .= ','.$date[$i]['day'].'/'.$date[$i]['month'];
					}
					else{
						$date_str .= ','.$date[$i]['day'].'/'.$date[$i]['month'].'/'.$date[$i]['year'];
					}
				}
				if ($i == (count($date)-1) && $i != 0) {
					$date_str .= ','.$date[$i]['day'].'/'.$date[$i]['month'].'/'.$date[$i]['year'];
				}
				
			}
			$date_str .= ' '.$time;
		}
		else{
			$nickname = pdo_fetchcolumn('select nickname from '.tablename('manji_company').' where id=:id',array(':id'=>$item));
			$next = pdo_fetchall('select r.*,c.nickname from '.tablename('manji_run_setting').' r left join '.tablename('manji_company').' c on c.id=r.cid where c.id=:id and stoptime>:time order by endtime asc limit 0,1',array(':id'=>$item,':time'=>$porder['createtime']));
			$date = array();
			foreach ($next as $d => $t) {
				$date[] = array(
					'day' => date('d',$t['endtime']),
					'month' => date('m',$t['endtime']),
					'year' => date('Y',$t['endtime'])
				);
				$time = date('H:i',$t['endtime']);
			}
			$date_str = '';
			for ($i=0; $i < count($date); $i++) { 
				if ($i == 0) {
					if ($date[$i]['month'] == $date[$i+1]['month']) {
						$date_str .= $date[$i]['day'];
					}
					elseif ($date[$i]['year'] == $data[$i+1]['year']) {
						$date_str .= $date[$i]['day'].'/'.$date[$i]['month'];
					}
					else{
						$date_str .= $date[$i]['day'].'/'.$date[$i]['month'].'/'.$date[$i]['year'];
					}
				}
				if ($i > 0 && $i != (count($date)-1)) {
					if ($date[$i]['month'] == $date[$i+1]['month'] || $date[$i+1]['month'] == 0) {
						$date_str .= ','.$date[$i]['day'];
					}
					elseif ($date[$i]['year'] == $data[$i+1]['year'] || $date[$i+1]['year'] == 0) {
						$date_str .= ','.$date[$i]['day'].'/'.$date[$i]['month'];
					}
					else{
						$date_str .= ','.$date[$i]['day'].'/'.$date[$i]['month'].'/'.$date[$i]['year'];
					}
				}
				if ($i == (count($date)-1) && $i != 0) {
					$date_str .= ','.$date[$i]['day'].'/'.$date[$i]['month'].'/'.$date[$i]['year'];
				}
				
			}
			$date_str .= ' '.$time;
		}
		$end[$date_str][] = $nickname;
	}
	foreach ($end as &$val) {
		$val = implode(',',$val);
	}
	$result = array(
		'status' => 1,
		'pid' => $porder['ordersn'],
		'order_status' => $porder['status'],
		'order_id' => $id,
		'ordertime' => date('d/m/Y H:i',$porder['createtime']),
		'cancel_time' => date('Y-m-d H:i',$porder['cancel_time']),
		'account' => $member['account'],
		'sn' => $porder['uordersn'],
		'end' => $end,
		'amount' => $porder['order_amount'],
		'counts' => count($uorder),
		'uorder' => $new_uorder,
		'no_edit' => $no_edit,
		'sale_out' => $has_sale_out,
		'has_sale_out' => $has_sale_out
	);
	if ($porder['days'] == 0) {
		$result['type'] = 1;
	}
	echo json_encode($result);
	exit;
}








 ?>