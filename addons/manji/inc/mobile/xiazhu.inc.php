<?php 
global $_W,$_GPC;

$member_id = $_COOKIE['uid']=17;
$op = $_GPC['op']?$_GPC['op']:'display';
header('Access-Control-Allow-Origin:*');
// 响应类型
header('Access-Control-Allow-Methods:POST');
// 响应头设置
header('Access-Control-Allow-Headers:x-requested-with,content-type');
if ($op == 'display') {
	if (empty($member_id)) {
		header('Location:'.$this->createMobileUrl('login'));
		exit;
	}
	$jackpot = pdo_fetch('select * from '.tablename('manji_jackpot'));
	foreach ($jackpot as $key => $value) {
		$jackpot[$key] = round($value/4,2);
	}
	$total_jackpot = pdo_fetch('select * from '.tablename('manji_total_jackpot'));
	foreach ($total_jackpot as $k => $val) {
		$total_jackpot[$k] = round($val/4,2);
	}
	$member = pdo_fetch('select * from '.tablename('member_system_member').' where id=:id',array(':id'=>$member_id));
}

if ($op == 'post') {
	include '../addons/purchasing/include_order.php';
	$data = $_GPC['data'];
	$days_type = $_GPC['days_type'];
	$days = $_GPC['days'];
	$starttime = microtime(true);
	$member = pdo_fetch('select * from '.tablename('member_system_member').' where id=:id',array(':id'=>$member_id));
	$rule = pdo_fetchall('select * from '.tablename('manji_rules').' order by id asc');
	$bet_limit = pdo_fetchcolumn('select red_limit from '.tablename('manji_member_red').' where user_id=:user_id',array(':user_id'=>$member_id));
	$parents = getParent($member['parent_agent']);
	$parents[] = $member['parent_agent'];
	$limit = pdo_fetchColumnValue('select red_limit from '.tablename('agent_red').' where agent_id in ('.implode(',', $parents).')',array(),'red_limit');
	$limit[] = $bet_limit;
	$amount = 0;
	$company_array = array();
	foreach ($rule as $key => $value) {
		$r[$value['id']] = $value['content'];
	}
	if ($days_type == 1) {
		$day = 0;
		$day_count = 1;
	}
	elseif ($days > 1) {
		$day = $days;
		$day_count = $days;
	}
	else{
		$day = 1;
		$day_count = 1;
	}
	foreach ($data as $k => $v) {
		$count = count($v['company']);
		if (strlen($v['number']) > 1) {
			if ($count > 0) {
				$company_array = array_merge($company_array,$v['company']);
			}
			else{
				$result = array(
					'status' => 2,
					'info' => '请选择要投注的公司'
				);
				echo json_encode($result);
				exit;
			}
			if (strlen($v['number'])>2 && strlen($v['number'])<5) {
				$choice_number[] = array('number'=>$v['number'],'type'=>$v['type']);
			}
		}
	}
	$writing = getWriting($data,$day,$r);
	$partner = get_partner_number($choice_number);
	$company_array = array_unique($company_array);
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
	$order_number = pdo_fetchcolumn('select count(id) from '.tablename('manji_order').' where pid=0');
	$uorder_number = pdo_fetchcolumn('select count(id) from '.tablename('manji_order').' where user_id=:id and pid=0',array(':id'=>$member_id));
	$order = array(
		'ordersn' => $order_number+1,
		'uordersn' => $uorder_number+1,
		'createtime' => time(),
		'user_id' => $member_id,
		'soucre' => $_SERVER['HTTP_USER_AGENT'],
		'days' => $day,
		'write' => $writing,
		'create_agent' => $_SESSION['mid']
	);
	if ($member['credit1'] < $amount) {
		$result = array(
			'status' => 2,
			'info' => '账号积分不足'
		);
		echo json_encode($result);
		exit;
	}
	pdo_begin();
	pdo_insert('manji_order',$order);
	$pid = pdo_insertid();
	$sql = '';
	foreach ($data as $k => $v) {
		if (strlen($v['number']) > 1) {
			$ruler = explode(',', $r[$v['rule']]);
			if (in_array(1,$v['company'])) {
				$no_edit = 1;
			}
			$count = count($v['company']);
			$company = $v['company'];
			$comp = array();
			$periods = array();
			$area = array();
			$uamount = 0;
			$sale_out = array();
			$number_detail = array();
			$save = array(
				'user_id' => $member_id,
				'pid' => $pid,
				'number' => $v['number'],
				'mode' => $v['type'],
				'days' => $day,
				'partner_number' => $partner[$v['number']]['number'],
				'array_id' => $partner[$v['number']]['array_id'],
				'createtime' => time()
			);
			foreach ($company as &$com) {
				$area_id = pdo_fetchcolumn('select area_id from '.tablename('manji_company').' where id=:id',array(':id'=>$com));
				$comp[] = pdo_fetchcolumn('select nickname from '.tablename('manji_company').' where id=:id',array(':id'=>$com));
				$periods_id = pdo_fetchall('select id,date,cid from '.tablename('manji_run_setting').' where stoptime>:time and cid=:cid and aid=:aid order by stoptime asc limit 0,'.$day,array(':time'=>time(),':cid'=>$com,':aid'=>$member['cid']));
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
				if (strlen($v['number']) == 5) {
					$ruler = array('5D');
				}
				if (strlen($v['number']) == 6) {
					$ruler = array('6D');
				}
				foreach ($ruler as $ky => $val) {
					$number_array = set_number_array($v['number'],$v['type']);
					$number_count = count($number_array);
					if ($v['type'] == 2) {
						$bet_money = $v['pay'][$ky]/$number_count;
					}
					else{
						$bet_money = $v['pay'][$ky];
					}
					$v['pay'][$ky] = $bet_money = $bet_money*(100+$member['auto_add'])/100;
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
						$save['play_type'] = $v['rule'];
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
					$periods[] = '('.$per['id'].')';
				}
				$area[] = $com;
				$com = '('.$com.')';
			}
			$save['period_id'] = implode(',', $periods);
			$save['cid'] = implode(',',$company);
			$new_o_c = implode(',', $company);
			$save['goods_amount'] = array_sum($v['pay']);
			if ($uamount == 0 && count($sale_out) == 0) {
				pdo_rollback();
				$result = array(
					'status' => 2,
					'info' => $v['number'].'未选择投注项'
				);
				echo json_encode($result);
				exit;
			}
			foreach ($area as $cm) {
				$mon = $uamount*0.01*0.6;
				$mon2 = $uamount*0.01*0.4;
				if ($cm == 1) {
					$jsave = array(
						'big_jackpot' => $mon*0.625,
						'middle_jackpot' => $mon*0.25,
						'small_jackpot' => $mon*0.125
					);
					$old = pdo_fetch('select * from '.tablename('manji_jackpot'));
					if (empty($old)) {
						pdo_insert('manji_jackpot',$jsave);
					}
					else{
						pdo_query('update '.tablename('manji_jackpot').' set big_jackpot=big_jackpot+'.($mon*0.625).',middle_jackpot=middle_jackpot+'.($mon*0.25).',small_jackpot=small_jackpot+'.($mon*0.125));
					}
					$big_old = pdo_fetch('select count(*) from '.tablename('manji_total_jackpot'));
					if (empty($big_old)) {
						$bjsave = array(
							'big_jackpot' => $mon2*0.625,
							'middle_jackpot' => $mon2*0.25,
							'small_jackpot' => $mon2*0.125
						);
						pdo_insert('manji_jb_surplus',$bjsave);
						pdo_insert('manji_total_jackpot',$bjsave);
					}
					else{
						pdo_query('update '.tablename('manji_total_jackpot').' set big_jackpot=big_jackpot+'.($mon2*0.625).',middle_jackpot=middle_jackpot+'.($mon2*0.25).',small_jackpot=small_jackpot+'.($mon2*0.125));
						pdo_query('update '.tablename('manji_jb_surplus').' set big_jackpot=big_jackpot+'.($mon2*0.625).',middle_jackpot=middle_jackpot+'.($mon2*0.25).',small_jackpot=small_jackpot+'.($mon2*0.125));
					}
				}
				elseif ($cm == 2) {
					$jb_surplus = pdo_fetch('select * from '.tablename('manji_jb_surplus'));
					if ($jb_surplus['big_jackpot'] > 0) {
						$mon3['big_jackpot'] = $mon2*0.625*0.5;
						if ($jb_surplus['big_jackpot'] > $mon3['big_jackpot']) {
							pdo_query('update '.tablename('manji_jb_surplus').' set big_jackpot=big_jackpot-'.$mon3['big_jackpot']);
						}
						else{
							pdo_update('manji_jb_surplus',array('big_jackpot'=>0));
						}
					}
					else{
						$mon3['big_jackpot'] = $mon2*0.625;
					}
					if ($jb_surplus['middle_jackpot'] > 0) {
						$mon3['middle_jackpot'] = $mon2*0.25*0.5;
						if ($jb_surplus['big_jackpot'] > $mon3['middle_jackpot']) {
							pdo_query('update '.tablename('manji_jb_surplus').' set middle_jackpot=middle_jackpot-'.$mon3['middle_jackpot']);
						}
						else{
							pdo_update('manji_jb_surplus',array('middle_jackpot'=>0));
						}
					}
					else{
						$mon3['middle_jackpot'] = $mon2*0.25;
					}
					if ($jb_surplus['small_jackpot'] > 0) {
						$mon3['small_jackpot'] = $mon2*0.125*0.5;
						if ($jb_surplus['small_jackpot'] > $mon3['small_jackpot']) {
							pdo_query('update '.tablename('manji_jb_surplus').' set small_jackpot=small_jackpot-'.$mon3['small_jackpot']);
						}
						else{
							pdo_update('manji_jb_surplus',array('small_jackpot'=>0));
						}
					}
					else{
						$mon3['small_jackpot'] = $mon2*0.125;
					}
					$old_jackpot = pdo_fetch('select * from '.tablename('manji_total_jackpot'));
					if (empty($old_jackpot)) {
						pdo_insert('manji_total_jackpot',$mon3);
					}
					else{
						pdo_query('update '.tablename('manji_total_jackpot').' set big_jackpot=big_jackpot+'.$mon3['big_jackpot'].',middle_jackpot=middle_jackpot+'.$mon3['middle_jackpot'].',small_jackpot=small_jackpot+'.$mon3['small_jackpot']);
					}
					$spare = pdo_fetch('select * from '.tablename('manji_spare_jackpot').' where cid=0');
					if (empty($spare)) {
						pdo_insert('manji_spare_jackpot',array('cid'=>0,'money'=>$mon,'level'=>0));
					}
					else{
						pdo_query('update '.tablename('manji_spare_jackpot').' set money=money+'.$mon);
					}
				}
				else{
					$jsave = array(
						'big_jackpot' => $mon2*0.625,
						'middle_jackpot' => $mon2*0.25,
						'small_jackpot' => $mon2*0.125
					);
					$old_jackpot = pdo_fetch('select * from '.tablename('manji_total_jackpot'));
					if (empty($old_jackpot)) {
						pdo_insert('manji_total_jackpot',$jsave);
					}
					else{
						pdo_query('update '.tablename('manji_total_jackpot').' set big_jackpot=big_jackpot+'.$jsave['big_jackpot'].',middle_jackpot=middle_jackpot+'.$jsave['middle_jackpot'].',small_jackpot=small_jackpot+'.$jsave['small_jackpot']);
					}
					$spare = pdo_fetch('select * from '.tablename('manji_spare_jackpot').' where cid=0');
					if (empty($spare)) {
						pdo_insert('manji_spare_jackpot',array('cid'=>0,'money'=>$mon,'level'=>0));
					}
					else{
						pdo_query('update '.tablename('manji_spare_jackpot').' set money=money+'.$mon);
					}
				}
			}
			$new_amount += $uamount;
			$save['order_amount'] = $uamount;
			foreach ($company as $com) {
				foreach ($periods as $per) {
					$new_save = $save;
					$new_save['cid'] = $com;
					$new_save['period_id'] = $per;
					$total_save[] = $new_save;
				}
			}
			$uo = $v;
			$uo['sale_out'] = $sale_out;
			$uo['has_sale_out'] = $has_sale_out;
			$uo['partner'] = $save['partner_number'];
			foreach ($uo['sale_out'] as &$vale) {
				$vale['can_pay'] = json_decode($vale['can_pay'],true);
			}
			$uo['company'] = implode('',$comp);
			$uorder[] = $uo;
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
	}
	$new_amount = $new_amount*$day_count;
	if ($member['has_false'] == 1) {
		$real_price = $new_amount*(100+$member['false_price'])/100;
	}
	else{
		$real_price = $new_amount;
	}
	if ($has_sale_out > 0) {
		$sale_out_total = array(
			'order_id' => $pid,
			'amount' => $amounad
		);
		pdo_insert('manji_sale_out',$sale_out_total);
		pdo_update('member_system_member',array('credit1'=>$member['credit1']-$real_price),array('id'=>$member_id));
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
		$show_amount = $new_amount/((100+$member['show_amount'])/100);
	}
	$count_number = count($uorder);
	foreach ($uorder as $u) {
		$newuorder[$u['company']][] = $u;
	}
	$past = array(
		'data' => $number_eat,
		);
	$url = $_W['siteroot'].'addons/purchasing/eat_number.php';
	$urlinfo = parse_url($url);  
	$host = $urlinfo['host'];  
	$path = $urlinfo['path'];  
	$query = isset($past)? http_build_query($past) : '';  
	$port = 80;  
	$errno = 0;  
	$errstr = '';  
	$timeout = 10;  
	$fp = fsockopen($host, $port, $errno, $errstr, $timeout);
	if (!$fp) {
	  	echo $errno;
	}
	stream_set_blocking($fp,0); //开启非阻塞模式
	stream_set_timeout($fp, $timeout); //设置超时时间（s）
	$out = "POST ".$path." HTTP/1.1\r\n";  
	$out .= "host:".$host."\r\n";  
	$out .= "content-length:".strlen($query)."\r\n";  
	$out .= "content-type:application/x-www-form-urlencoded\r\n";  
	$out .= "connection:close\r\n\r\n";  
	$out .= $query;
	fputs($fp, $out);  
	fclose($fp);
	$endtime = microtime(true);
	pdo_update('manji_order',array('calculating_time'=>$endtime-$starttime,'order_amount'=>$new_amount),array('id'=>$pid));
	pdo_commit();
	$result = array(
		'status' => 1,
		'pid' => $order['ordersn'],
		'order_id' => $pid,
		'ordertime' => date('d/m/Y H:i',$order['createtime']),
		'account' => $member['account'],
		'sn' => $order['uordersn'],
		'type' => $days_type,
		'end' => $end,
		'amount' => $new_amount>0?$new_amount:$amount,
		'counts' => $count_number,
		'uorder' => $newuorder,
		'no_edit' => $no_edit,
		'has_sale_out' => $has_sale_out,
		'time' => $endtime - $starttime
	);
	echo json_encode($result);
	exit;
}

if ($op == 'check_order') {
	$data = $_GPC['data'];
	$days_type = $_GPC['days_type'];
	$days = $_GPC['days'];
	$member = pdo_fetch('select * from '.tablename('member_system_member').' where id=:id',array(':id'=>$member_id));
	$rule = pdo_fetchall('select * from '.tablename('manji_rules').' order by id asc');
	if ($member['status'] == 1) {
		$result = array(
			'status' => 2,
			'info' => '该用户已被禁用，无法下注'
		);
		echo json_encode($result);
		exit;
	}
	foreach ($rule as $key => $value) {
		$r[$value['id']] = $value['content'];
	}
	if ($days_type == 1) {
		$day = 0;
	}
	elseif ($days > 1) {
		$day = $days;
	}
	else{
		$day = 1;
	}
	$old_count = 0;
	foreach ($data as $k => $v) {
		if (strlen($v['number'] <= 1)) {
			continue;
		}
		$ruler = explode(',', $r[$v['rule']]);
		$count = count($v['company']);
		$company = $v['company'];
		$comp = array();
		if ($count <= 0) {
			$result = array(
				'status' => 2,
				'info' => '请选择要投注的公司'
			);
			echo json_encode($result);
			exit;
		}
		$periods = array();
		foreach ($company as &$com) {
			$comp = pdo_fetch('select * from '.tablename('manji_company').' where id=:id',array(':id'=>$com));
			if ($com == 1) {
				$odds = pdo_fetch('select * from '.tablename('manji_member_odds').' where member_id=:member_id and cid=1',array(':member_id'=>$member_id));
			}
			else{
				$odds = pdo_fetch('select * from '.tablename('manji_member_odds').' where member_id=:member_id and cid=:cid',array(':member_id'=>$member_id,':cid'=>$member['cid']));
			}
			if (empty($odds)) {
				$result = array(
					'status' => 2,
					'info' => '您尚未配置'.$comp['nickname'].'公司配套，请联系代理'
				);
				echo json_encode($result);
				exit;
			}
			if (strlen($v['number']) == 5) {
				$odds = pdo_fetch('select has_5D from '.tablename('manji_company').' where id=:id',array(':id'=>$com));
				if (empty($odds)) {
					$result = array(
						'status' => 2,
						'info' => $comp['nickname'].'公司尚未配置5D配套，请联系代理'
					);
					echo json_encode($result);
					exit;
				}
			}
			if (strlen($v['number']) == 6) {
				$odds = pdo_fetch('select has_6D from '.tablename('manji_company').' where id=:id',array(':id'=>$com));
				if (empty($odds)) {
					$result = array(
						'status' => 2,
						'info' => $comp['nickname'].'尚未配置公司6D配套，请联系代理'
					);
					echo json_encode($result);
					exit;
				}
			}
			if ($days_type == 1) {
				$periods_id = pdo_fetchall('select id from '.tablename('manji_run_setting').' where stoptime>:time and cid=:cid and status=1 and aid=:aid order by stoptime asc limit 0,1',array(':time'=>time(),':cid'=>$com,':aid'=>$member['cid']));
			}
			else{
				$periods_id = pdo_fetchall('select id from '.tablename('manji_run_setting').' where stoptime>:time and cid=:cid and status=1 and aid=:aid order by stoptime asc limit 0,'.$day,array(':time'=>time(),':cid'=>$com,':aid'=>$member['cid']));
			}
			
			if (!$periods_id) {
				$result = array(
					'status' => 2,
					'info' => $comp['nickname'].'公司投注已停止'
				);
				echo json_encode($result);
				exit;
			}
			foreach ($periods_id as $per) {
				$periods[] = '('.$per['id'].')';
			}
			$com = '('.$com.')';
		}
		$save = array(
			'user_id' => $member_id,
			'cid' => implode(',',$company),
			'period_id' => implode(',',$periods),
			'number' => $v['number'],
			'mode' => $v['type'],
			'days' => $day
		);
		if (strlen($v['number']) == 5) {
			$save['pay_5D'] = $v['pay'][0];
		}
		elseif (strlen($v['number']) == 6) {
			$save['pay_6D'] = $v['pay'][0];
		}
		else{
			foreach ($ruler as $ky => $val) {
				$save['pay_'.$val] = $v['pay'][$ky];
			}
		}
		$condition = ' where 1 ';
		foreach ($save as $index => $item) {
			if ($index == 'cid' || $index == 'period_id') {
				$condition .= ' and '.$index.'=\''.$item.'\'';
			}
			elseif (strpos($index,'pay_') !== false) {
				$condition .= ' and '.$index.'='.($item*(100+$member['auto_add'])/100);
			}
			else{
				$condition .= ' and '.$index.'='.$item;
			}
		}
	
		$old_order = pdo_fetchcolumn('select count(id) from '.tablename('manji_order').$condition);
		if ($old_order > 0) {
			$old_count++;
		}
	}
	if ($old_count == count($data)) {
		$result = array(
			'status' => 4,
			'info' => ''
		);
	}
	else{
		// pdo_insert("manji_order",$save,true);
		$result = array(
			'status' => 1,
			'info' => '投注成功'
		);
	}
	echo json_encode($result);
	exit;
}

if ($op == 'order_detail') {
	include '../addons/purchasing/include_order.php';
	$id = $_GPC['id'];
	$keyword = $_GPC['keyword'];
	$rule = pdo_fetchall('select * from '.tablename('manji_rules'));
	foreach ($rule as $key => $value) {
		$r[$value['id']] = $value['content'];
	}
	if (!empty($keyword)) {
		$id = pdo_fetchcolumn('select id from '.tablename('manji_order').' where uordersn=:id and user_id=:user_id',array(':id'=>$keyword,':user_id'=>$member_id));
	}
	$company_array = array();
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
	}
	else{
		$result = array(
			'status' => 2,
			'info' => '没有订单'
		);
		echo json_encode($result);
		exit;
	}
	$company_array = array_unique($company_array);
	if ($porder['days'] > 0) {
		$day_count = $porder['days'];
	}
	else{
		$day_count = 1;
	}
	$com_count = count($company_array);
	$periods = pdo_fetchall('select id,stoptime,endtime,cid from '.tablename('manji_run_setting').' where aid=:aid and status=1 and cid in ('.implode(',',$company_array).') order by endtime asc limit 0,'.($day_count*$com_count),array(':aid'=>$member['cid']));
	$end = getBetDate($company_array,$periods,$member['cid'],$day_count);
	foreach ($end as &$val) {
		$val = implode(',',$val);
	}
	if ($member['show_amount'] > 0) {
		$show_amount = $porder['order_amount']/((100+$member['show_amount'])/100);
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
		'show_amount' => $show_amount,
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

if ($op == 'search_date') {
	$date = $_GPC['date'];
	$start = strtotime($date.' 00:00:00');
	$end = strtotime($date.' 23:59:59');
	$order = pdo_fetchall('select * from '.tablename('manji_order').' where pid=0 and createtime between :start and :end and user_id=:user_id',array(':start'=>$start,':end'=>$end,':user_id'=>$member_id));
	foreach ($order as $key => $value) {
		$order[$key]['time'] = date('d/m/Y H:i',$value['createtime']);
	}
	echo json_encode($order);
	exit;
}

if ($op == 'get_writing') {
	$id = $_GPC['id'];
	$write = pdo_fetchcolumn('select `write` from '.tablename('manji_order').' where id=:id',array(':id'=>$id));
	$result = array(
		'status' => 1,
		'write' => $write
	);
	echo json_encode($result);
	exit;
}

if ($op == 'get_company') {
	$company = pdo_fetchall('select * from '.tablename('manji_company').' order by id asc');
	echo json_encode($company);
	exit;
}

if ($op == 'get_rule') {
	$rule = pdo_fetchall('select * from '.tablename('manji_rules').' order by id asc');
	echo json_encode($rule);
	exit;
}


include $this->template('xiazhu');

 ?>
