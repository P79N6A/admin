<?php 
global $_W,$_GPC;

$op = $_GPC['op'];

if ($op == 'get_number') {
	$number = $_GPC['number'];
	$time = $_GPC['time']?$_GPC['time']:date('Y-m-d',time());
	$start = strtotime($time.' 00:00:00');
	$end = strtotime($time.' 23:59:59');
	$company = $_GPC['company'];
	$list = pdo_fetch('select sum(d.pay_B) as B,sum(d.pay_S) as S,sum(d.pay_A) as A,sum(d.pay_C2) as C2,sum(d.pay_C3) as C3,sum(d.pay_C4) as C4,sum(d.pay_C5) as C5,sum(d.pay_EC) as EC,sum(d.pay_3ABC) as 3ABC,sum(d.pay_4A) as 4A,sum(d.pay_4B) as 4B,sum(d.pay_4C) as 4C,sum(d.pay_4D) as 4D,sum(d.pay_4E) as 4E,sum(d.pay_EA) as EA,sum(d.pay_4ABC) as 4ABC,sum(d.pay_2A) as 2A,sum(d.pay_2B) as 2B,sum(d.pay_2C) as 2C,sum(d.pay_2D) as 2D,sum(d.pay_2E) as 2E,sum(d.pay_EX) as EX,sum(d.pay_2ABC) as 2ABC from '.tablename('manji_order_detail').' d left join '.tablename('manji_order').' o on o.id=d.order_id where d.number=:number and o.createtime between :start and :end and cid like \'%('.$company.')%\'',array(':number'=>$number,':start'=>$start,':end'=>$end));
	foreach ($list as $key => $value) {
		$numberlist[] = array(
			'key' => $key,
			'number' => $value
		);
	}

	$data = array(
		'status' => 1,
		'list' => $numberlist,
		'number' => $number,
		'company' => $company
	);
	echo json_encode($data);
	exit;
}

if ($op == 'get_order') {
	$number = $_GPC['number'];
	$time = $_GPC['time']?$_GPC['time']:date('Y-m-d',time());
	$pay = $_GPC['pay'];
	$start = strtotime($time.' 00:00:00');
	$end = strtotime($time.' 23:59:59');
	$company = $_GPC['company'];
	$list = pdo_fetchall('select m.nickname as username,o.id,sum(d.pay_'.$pay.') as money from '.tablename('manji_order_detail').' d left join '.tablename('manji_order').' o on o.id=d.order_id left join '.tablename('member_system_member').' m on m.id=o.user_id where d.number=:number and o.createtime between :start and :end and o.cid like \'%('.$company.')%\' group by o.user_id',array(':number'=>$number,':start'=>$start,':end'=>$end));

	$data = array(
		'status' => 1,
		'list' => $list
	);
	echo json_encode($data);
	exit;
}

if ($op == 'get_detail') {
	$uid = $_GPC['id'];
	$id = pdo_fetchcolumn('select pid from '.tablename('manji_order').' where id=:id',array(':id'=>$uid));
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