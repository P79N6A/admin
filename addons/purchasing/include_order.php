<?php 

function cal_order_amount($data = array(),$day,$member)
{
	$amount = 0;
	foreach ($data as $k => $v) {
		if (is_array($v['rule'])) {
			$ruler = $v['rule'];
		}
		else{
			$ruler = explode(',', $r[$v['rule']]);
		}
		$company = $v['company'];
		$count = count($v['company']);
		foreach ($company as &$com) {
			$area_id = pdo_fetchcolumn('select area_id from '.tablename('manji_company').' where id=:id',array(':id'=>$com));
			$comp[] = pdo_fetchcolumn('select nickname from '.tablename('manji_company').' where id=:id',array(':id'=>$com));
			$periods_id = pdo_fetchall('select id,date,cid from '.tablename('manji_run_setting').' where stoptime>:time and cid=:cid and aid=:aid order by stoptime asc limit 0,'.$day,array(':time'=>time(),':cid'=>$com,':aid'=>$member['cid']));
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
				foreach ($number_array as $num) {
					$sample_red = compare_sample_number($num,$com,$val,$bet_money);
					$system_red = compare_system_number($num,$com,$val,$bet_money,$number_extra[$com][$num][$val]);
					$user_limit = compare_user($member_id,$com,$val,$bet_money,$user_extra[$com][$val]);
					$agent_limit = compare_agent($member['parent_agent'],$com,$val,$bet_money,$user_extra[$com][$val]);
					$system_limit = compare_system($val,$com,$bet_money,$user_extra[$com][$val]);
					$number_limit = min($sample_red,$system_red,$user_limit,$agent_limit,$system_limit,$bet_money);
					$amount += $number_limit;
				}
			}
		}
	}
	return $amount;
}

function set_number_array($number,$type)
{
	switch ($type) {
		case 1:
			$number_array = sort_number($number);
			break;
		case 2:
			$number_array = sort_number($number);
			break;
		case 3:
			$last_number = substr($number,1);
			for ($i=0; $i < 10; $i++) { 
				$number_array[] = $i.$last_number;
			}
			break;
		case 4:
			$first_number = substr($number,0,strlen($number)-1);
			for ($i=0; $i < 10; $i++) { 
				$number_array[] = $first_number.$i;
			}
			break;
		
		default:
			$number_array = array($number);
			break;
	}
	return $number_array;
}

function get_partner_number($number)
{
	for ($i=0; $i < count($number); $i++) { 
		if (!empty($number[$i*2])) {
			$number_team[] = array($number[$i*2],$number[$i*2+1]);
		}
	}
	// return $number_team;
	foreach ($number_team as $key => $team) {
		if ($team[0]['type'] != 0 && $team[1]['type'] != 0) {
			$partner[$team[0]['number']]['number'] = random_number();
			if (strlen($team[0]['number']) == 3) {
				$partner[$team[0]['number']]['jackpot'] = substr(random_number(),0,1);
			}
			$partner[$team[1]['number']]['number'] = random_number();
			if (strlen($team[1]['number']) == 3) {
				$partner[$team[1]['number']]['jackpot'] = substr(random_number(),0,1);
			}
			
		}
		elseif ($team[0]['type'] == 0 && $team[1]['type'] != 0) {
			if (strlen($team[0]['number']) == 3) {
				$partner[$team[1]['number']]['number'] = substr($team[1]['number'],0,1).$team[0]['number'];
				$partner[$team[0]['number']]['jackpot'] = substr($team[1]['number'],0,1);
			}
			else{
				$partner[$team[1]['number']]['number'] = $team[0]['number'];
			}
			if (strlen($team[1]['number']) == 3) {
				$partner[$team[1]['number']]['jackpot'] = substr(random_number(),0,1);
			}
		}
		else{
			if (strlen($team[1]['number']) == 3) {
				$partner[$team[0]['number']]['number'] = substr($team[0]['number'],0,1).$team[1]['number'];
				$partner[$team[1]['number']]['jackpot'] = substr($team[0]['number'],0,1);
			}
			else{
				$partner[$team[0]['number']]['number'] = $team[1]['number'];
			}
			if (strlen($team[0]['number']) == 3) {
				$partner[$team[0]['number']]['jackpot'] = substr(random_number(),0,1);
			}
		}
		if (empty($team[1]['number'])) {
			$partner[$team[0]['number']]['number'] = random_number();
			if (strlen($team[0]['number']) == 3) {
				$partner[$team[0]['number']]['jackpot'] = substr(random_number(),0,1);
			}
		}
		$partner[$team[1]['number']]['array_id'] = $key;
		$partner[$team[0]['number']]['array_id'] = $key;
	}
	return $partner;
}

function get_rule($cid)
{
	$rule = pdo_fetchall('select * from '.tablename('manji_rules').' where cid=:cid or cid=1',array(':cid'=>$cid));
	foreach ($rule as $r) {
		$result[$r['id']] = explode(',',$r['content']);
	}

	return $result;
}

function get_company()
{
	$company = pdo_fetchall('select * from '.tablename('manji_company').' order by id asc');
	foreach ($company as $com) {
		$result[$com['id']] = $com;
	}
	return $result;
}

function get_day($day,$type)
{
	if ($type == 1) {
		$result = 0;
	}
	elseif ($day > 0) {
		$result = $day;
	}
	else{
		$result = 1;
	}
	return $result;
}

function pay_rule($pay,$rule)
{
	foreach ($rule as $k => $v) {
		$result[$v] = $pay[$k];
	}
	return $result;
}

function get_period($cid,$company,$day)
{
	$day = $day>0?$day:1;
	$count = count($company);
	$result = array();
	for ($i=1; $i <= $count; $i++) { 
		$period = pdo_fetchall('select * from '.tablename('manji_run_setting').' where endtime>=:time and cid=:cid and aid=:aid order by endtime limit 0,'.$day,array(':time'=>time(),':cid'=>$i,':aid'=>$cid));
		if (!empty($period)) {
			$result[$i] = $period;
		}
	}
	return $result;
}

function getCompanyDate($company,$periods,$cid,$days)
{
	
	foreach ($periods as $period) {
		$new_per[$period['cid']][] = $period;
	}

	foreach ($company as $com) {
		$next = $new_per[$com];
		$comp = pdo_fetch('select * from '.tablename('manji_company').' where id=:id',array(':id'=>$com));
		$prev = pdo_fetch('select endtime from '.tablename('manji_run_setting').' where aid=:aid and status=2 and cid=:cid order by endtime desc limit 0,1',array(':aid'=>$cid,':cid'=>$com));
		if ($prev['endtime'] >= time()-1800) {
			$end = '新期投注未开始';
			break;
		}
		if ($next[0]['stoptime'] <= time() || empty($next)) {
			$end = $comp['nickname'].'公司投注已停止';
			break;
		}
		if (count($next) != $days) {
			$end = $comp['nickname'].'公司投注还有未开盘期，请联系管理员';
			break;
		}
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
		$end[$date_str][] = $comp['nickname'];
	}
	return $end;
}

function getBetDate($company,$periods,$cid,$days)
{
	foreach ($periods as $period) {
		$new_per[$period['cid']][] = $period;
	}

	foreach ($company as $com) {
		$next = $new_per[$com];
		$comp = pdo_fetch('select * from '.tablename('manji_company').' where id=:id',array(':id'=>$com));
		$prev = pdo_fetch('select endtime from '.tablename('manji_run_setting').' where aid=:aid and status=2 and cid=:cid order by endtime desc limit 0,1',array(':aid'=>$cid,':cid'=>$com));
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
		$end[$date_str][] = $comp['nickname'];
	}
	return $end;
}

function getWriting($data,$day,$rule)
{
	$write = '';
	if ($day == 0) {
		$write .= '<tr><td>D# AUTO</td></tr>';
	}
	elseif ($day == 1) {
		$write .= '<tr><td>D#</td></tr>';
	}
	else{
		$write .= '<tr><td>D# '.$day.'</td></tr>';
	}
	foreach ($data as $val) {
		$nickname = pdo_fetchColumnValue('select nickname from '.tablename('manji_company').' where id in ('.implode(',',$val['company']).')',array(),'nickname');
		$write .= '<tr><td>'.implode(',',$nickname).'</td></tr>';
		switch ($val['type']) {
			case 1:
				$write .= '<tr><td>{'.$val['number'].'}&nbsp;&nbsp;';
				break;
			case 2:
				$write .= '<tr><td>{'.$val['number'].'}&nbsp;&nbsp;';
				break;
			case 3:
				$write .= '<tr><td>{0~9}'.substr($val['number'],1).'&nbsp;&nbsp;';
				break;
			case 4:
				$write .= '<tr><td>'.substr($val['number'],0,strlen($val['number'])-1).'{0~9}&nbsp;&nbsp;';
				break;
			default:
				$write .= '<tr><td>'.$val['number'].'&nbsp;&nbsp;';
				break;
		}
		$ruler = explode(',', $rule[$val['rule']]);
		foreach ($ruler as $k => $v) {
			$write .= $v.':'.$val['pay'][$k].'&nbsp;&nbsp;';
		}
		$write .= '</td></tr>';
	}

	return $write;
}

function saveJackpot($area,$uamount)
{
	foreach ($area as $com) {
		$jackpot = $uamount*0.01;
		if ($com == 1) {
			$sql = 'update '.tablename('manji_jackpot').' set big_jackpot=big_jackpot+'.($jackpot*0.6*0.65).',middle_jackpot=middle_jackpot+'.($jackpot*0.6*0.25).',small_jackpot=small_jackpot+'.($jackpot*0.6*0.125).';';
			$sql .= 'update '.tablename('manji_total_jackpot').' set big_jackpot=big_jackpot+'.($jackpot*0.4*0.65).',middle_jackpot=middle_jackpot+'.($jackpot*0.4*0.25).',small_jackpot=small_jackpot+'.($jackpot*0.4*0.125).';';
			$sql .= 'update '.tablename('manji_jb_surplus').' set big_jackpot=big_jackpot+'.($jackpot*0.4*0.65).',middle_jackpot=middle_jackpot+'.($jackpot*0.4*0.25).',small_jackpot=small_jackpot+'.($jackpot*0.4*0.125).';';
		}
		elseif ($com == 2) {
			$surplus = pdo_fetch('select * from '.tablename('manji_jb_surplus'));
			$sql = '';
			if ($surplus['big_jackpot'] > 0) {
				$sql .= 'update '.tablename('manji_jackpot').' set big_jackpot=big_jackpot+'.($jackpot*0.5*0.65).';';
				$sql .= 'update '.tablename('manji_total_jackpot').' set big_jackpot=big_jackpot+'.($jackpot*0.5*0.65).';';
				$sql .= 'update '.tablename('manji_jb_surplus').' set big_jackpot=big_jackpot-'.($jackpot*0.5*0.65).';';
			}
			else{
				$sql .= 'update '.tablename('manji_total_jackpot').' set big_jackpot=big_jackpot+'.($jackpot*0.6*0.65).';';
				$sql .= 'update '.tablename('manji_spare_jackpot').' set money=money+'.($jackpot*0.4*0.65).';';
			}
			if ($surplus['middle_jackpot'] > 0) {
				$sql .= 'update '.tablename('manji_jackpot').' set middle_jackpot=middle_jackpot+'.($jackpot*0.5*0.25).';';
				$sql .= 'update '.tablename('manji_total_jackpot').' set middle_jackpot=middle_jackpot+'.($jackpot*0.5*0.25).';';
				$sql .= 'update '.tablename('manji_jb_surplus').' set middle_jackpot=middle_jackpot-'.($jackpot*0.5*0.25).';';
			}
			else{
				$sql .= 'update '.tablename('manji_total_jackpot').' set middle_jackpot=middle_jackpot+'.($jackpot*0.6*0.25).';';
				$sql .= 'update '.tablename('manji_spare_jackpot').' set money=money+'.($jackpot*0.4*0.25).';';
			}
			if ($surplus['small_jackpot'] > 0) {
				$sql .= 'update '.tablename('manji_jackpot').' set small_jackpot=small_jackpot+'.($jackpot*0.5*0.125).';';
				$sql .= 'update '.tablename('manji_total_jackpot').' set small_jackpot=small_jackpot+'.($jackpot*0.5*0.125).';';
				$sql .= 'update '.tablename('manji_jb_surplus').' set small_jackpot=small_jackpot-'.($jackpot*0.5*0.125).';';
			}
			else{
				$sql .= 'update '.tablename('manji_total_jackpot').' set small_jackpot=small_jackpot+'.($jackpot*0.6*0.125).';';
				$sql .= 'update '.tablename('manji_spare_jackpot').' set money=money+'.($jackpot*0.4*0.125).';';
			}
		}
		else{
			$sql = 'update '.tablename('manji_total_jackpot').' set big_jackpot=big_jackpot+'.($jackpot*0.6*0.65).',middle_jackpot=middle_jackpot+'.($jackpot*0.6*0.25).',small_jackpot=small_jackpot+'.($jackpot*0.6*0.125).';';
			$sql .= 'update '.tablename('manji_spare_jackpot').' set money=money+'.($jackpot*0.4).';';
		}
		pdo_query($sql);
	}
}



 ?>