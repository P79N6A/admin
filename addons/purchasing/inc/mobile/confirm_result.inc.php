<?php 
global $_W,$_GPC;
include '../addons/purchasing/report.class.php';
$mid = $_SESSION['mid'];
if (empty($mid)) {
	$result = array(
		'status' => 3,
		'info' => '请先登录'
	);
	echo json_encode($result);
	exit;
}

$first = $_GPC['first'];
$secound = $_GPC['secound'];
$third = $_GPC['third'];
$special = $_GPC['special'];
$consolation = $_GPC['consolation'];
$periods = pdo_fetchall('select * from '.tablename('manji_run_setting').' where cid=1 and date=:date',array(':date'=>date('Y-m-d',time())));
foreach ($special as $key => $value) {
	if ($value == '----') {
		unset($special[$key]);
	}
}
if (!preg_match('/[0-9]{4,4}/',$first) || strlen($first) != 4) {
	$result = array(
		'status' => 2,
		'info' => '头等奖号码格式不正确'
	);
	echo json_encode($result);
	exit;
}

if (!preg_match('/[0-9]{4,4}/',$secound) || strlen($secound) != 4) {
	$result = array(
		'status' => 2,
		'info' => '二等奖号码格式不正确'
	);
	echo json_encode($result);
	exit;
}

if (!preg_match('/[0-9]{4,4}/',$third) || strlen($third) != 4) {
	$result = array(
		'status' => 2,
		'info' => '三等奖号码格式不正确'
	);
	echo json_encode($result);
	exit;
}

foreach ($special as $sp) {
	if (!preg_match('/[0-9]{4,4}/',$sp) || strlen($sp) != 4) {
		$result = array(
			'status' => 2,
			'info' => '特别奖号码格式不正确'
		);
		echo json_encode($result);
		exit;
	}
}

foreach ($consolation as $con) {
	if (!preg_match('/[0-9]{4,4}/',$con) || strlen($con) != 4) {
		$result = array(
			'status' => 2,
			'info' => '安慰奖号码格式不正确'
		);
		echo json_encode($result);
		exit;
	}
}


if (empty($periods)) {
	$result = array(
		'status' => 2,
		'info' => '今天没有开期'
	);
	echo json_encode($result);
	exit;
}
$has_confirm = 0;
foreach ($periods as $period) {
	if ($period['status'] == 2) {
		$has_confirm++;
		continue;
	}
	$period_id = $period['id'];
	$period_ids[] = $period['id'];
	$save = array(
		'cid' => 1,
		'period_id' => $period['id'],
		'first_no' => $first,
		'second_no' => $secound,
		'third_no' => $third,
		'special_no' => implode('|', $special),
		'consolation_no' => implode('|', $consolation)
	);
	pdo_delete('manji_lottery_record',array('period_id'=>$period['id']));
	$res = pdo_insert('manji_lottery_record',$save);
	if($res){
		$first_money = 0;
		$second_money = 0;
		$third_money = 0;
		$special_money = 0;
		$consolation_money = 0;
		$first_return = array();
		$secound_return = array();
		$third_return = array();
		$special_return = array();
		$consolation_return = array();
		$member = array();
		$member = pdo_fetchall('select m.credit1,m.account as nickname,o.* from '.tablename('member_system_member').' m left join '.tablename('manji_member_odds').' o on o.member_id=m.id where o.cid=1 and m.cid=:cid',array(':cid'=>$period['aid']));
		cache_write('member',$member);
		$order_number = 7000;
		$psize = 7000;
		$order = array();
		$number = 1;
		do {
			$order_list = pdo_fetchall('select d.*,o.user_id,o.createtime,o.cid,o.number as bet_number from '.tablename('manji_order_detail').' d left join '.tablename('manji_order').' o on o.id=d.order_id where cid like \'%(1)%\' and o.period_id like \'%('.$period_id.')%\' and o.status=1 order by d.id asc limit '.($number-1)*$psize.',7000');
			$order_number = count($order_list);
			$order = array_merge($order,$order_list);
			$number++;
		} while ($order_number == 7000);
		cache_write('order',$order);
		
		//先进行B计算，所有数字 都要算
		$first_return[] = cal_B($period_id, $period['periods'],  $first, "头等奖",1);  //头等奖
		$secound_return[] = cal_B($period_id,  $period['periods'], $secound, '二等奖',2); //二等奖
		$third_return[] = cal_B($period_id,  $period['periods'],$third, '三等奖',3);  //三等奖
		
		foreach($special as $special_no_arr_idx){
			if ($special_no_arr_idx != '----') {
				$special_return[] = cal_B($period_id,  $period['periods'],$special_no_arr_idx, '特别奖',4);  //特别奖
	            //4D计算，只算特别奖
	            $special_return[] = cal_4D($period_id,  $period['periods'],$special_no_arr_idx, '特别奖',4);  //特别奖
	            $special_return[] = cal_C4($period_id,  $period['periods'],$special_no_arr_idx, '特别奖',4);  //特别奖
	            $special_return[] = cal_2D($period_id,  $period['periods'],$special_no_arr_idx, '特别奖',4);  //特别奖
	            $special_return[] = cal_EA($period_id,  $period['periods'],$special_no_arr_idx, '特别奖',4);  //特别奖
	            $special_return[] = cal_EC($period_id,  $period['periods'],$special_no_arr_idx, '特别奖',4);  //特别奖
	            $special_return[] = cal_EX($period_id,  $period['periods'],$special_no_arr_idx, '特别奖',4);  //特别奖
			}
		}
		
		foreach($consolation as $consolation_no_arr_idx){
			if ($consolation_no_arr_idx != '----') {
				$consolation_return[] = cal_B($period_id,  $period['periods'],$consolation_no_arr_idx, '安慰奖',5);  //安慰奖
	            //4D计算，只算安慰奖
	            $consolation_return[] = cal_4E($period_id,  $period['periods'],$consolation_no_arr_idx, '安慰奖',5);  //安慰奖
	            $consolation_return[] = cal_C5($period_id,  $period['periods'],$consolation_no_arr_idx, '安慰奖',5);  //安慰奖
	            $consolation_return[] = cal_2E($period_id,  $period['periods'],$consolation_no_arr_idx, '安慰奖',5);  //安慰奖
	            $consolation_return[] = cal_EA($period_id,  $period['periods'],$consolation_no_arr_idx, '安慰奖',5);  //安慰奖
	            $consolation_return[] = cal_EC($period_id,  $period['periods'],$consolation_no_arr_idx, '安慰奖',5);  //安慰奖
	            $consolation_return[] = cal_EX($period_id,  $period['periods'],$consolation_no_arr_idx, '安慰奖',5);  //安慰奖
			}
		}
		
		//4A计算，只算头奖
		$first_return[] = cal_4A($period_id,  $period['periods'],$first, '头等奖',1);  //头等奖
	    $secound_return[] = cal_4B($period_id,  $period['periods'],$secound, '二等奖',2);  //二等奖
	    $third_return[] = cal_4C($period_id,  $period['periods'],$third, '三等奖',3);  //三等奖

	    //4ABC计算，只算头二三等奖
	    $first_return[] = cal_4ABC($period_id,  $period['periods'],$first, '头等奖',1);  //头等奖
	    $secound_return[] = cal_4ABC($period_id,  $period['periods'],$secound, '二等奖',2); //二等奖
	    $third_return[] = cal_4ABC($period_id,  $period['periods'], $third, '三等奖',3);  //三等奖
	    
		
		//S计算，只算二三等奖
	    $first_return[] = cal_S($period_id,  $period['periods'],$first, '头等奖',1);//二等奖       //
		$secound_return[] = cal_S($period_id,  $period['periods'],$secound, '二等奖',2);//二等奖
		$third_return[] = cal_S($period_id,  $period['periods'],$third, '三等奖',3);//三等奖
		
		//C3计算，前三等奖
		$first_return[] = cal_3ABC($period_id,  $period['periods'],$first, '头等奖',1);  //头等奖
		$secound_return[] = cal_3ABC($period_id,  $period['periods'],$secound, '二等奖',2); //二等奖
		$third_return[] = cal_3ABC($period_id,  $period['periods'], $third, '三等奖',3);  //三等奖
		
		//3A=首奖的最后三个号码
		$first_return[] = cal_A($period_id,  $period['periods'],  $first, '头等奖',1);  //头等奖
	    $secound_return[] = cal_C2($period_id,  $period['periods'],$secound, '二等奖',2); //二等奖
	    $third_return[] = cal_C3($period_id,  $period['periods'], $third, '三等奖',3);  //三等奖

	    //3A=首奖的最后三个号码
	    $first_return[] = cal_2A($period_id,  $period['periods'],  $first, '头等奖',1);  //头等奖
	    $secound_return[] = cal_2B($period_id,  $period['periods'],$secound, '二等奖',2); //二等奖
	    $third_return[] = cal_2C($period_id,  $period['periods'], $third, '三等奖',3);  //三等奖

	    //2C计算，前三等奖
	    $first_return[] = cal_2ABC($period_id,  $period['periods'],$first, '头等奖',1);  //头等奖
	    $secound_return[] = cal_2ABC($period_id,  $period['periods'],$secound, '二等奖',2); //二等奖
	    $third_return[] = cal_2ABC($period_id,  $period['periods'], $third, '三等奖',3);  //三等奖

	    //EA计算，前三等奖
	    $first_return[] = cal_EA($period_id,  $period['periods'],$first, '头等奖',1);  //头等奖
	    $secound_return[] = cal_EA($period_id,  $period['periods'],$secound, '二等奖',2); //二等奖
	    $third_return[] = cal_EA($period_id,  $period['periods'], $third, '三等奖',3);  //三等奖

	    //EC计算，前三等奖
	    $first_return[] = cal_EC($period_id,  $period['periods'],$first, '头等奖',1);  //头等奖
	    $secound_return[] = cal_EC($period_id,  $period['periods'],$secound, '二等奖',2); //二等奖
	    $third_return[] = cal_EC($period_id,  $period['periods'], $third, '三等奖',3);  //三等奖

	    //EX计算，前三等奖
	    $first_return[] = cal_EX($period_id,  $period['periods'],$first, '头等奖',1);  //头等奖
	    $secound_return[] = cal_EX($period_id,  $period['periods'],$secound, '二等奖',2); //二等奖
	    $third_return[] = cal_EX($period_id,  $period['periods'], $third, '三等奖',3);  //三等奖

	    foreach ($first_return as $fr) {
	    	$first_money+=$fr['total_winner_money'];
	    	$return[] = $fr;
	    }

	    foreach ($secound_return as $sr) {
	    	$second_money+=$sr['total_winner_money'];
	    	$return[] = $sr;
	    }

	    foreach ($third_return as $tr) {
	    	$third_money+=$tr['total_winner_money'];
	    	$return[] = $tr;
	    }

	    foreach ($special_return as $pr) {
	    	$special_money+=$pr['total_winner_money'];
	    	$return[] = $pr;
	    }

	    foreach ($consolation_return as $cr) {
	    	$consolation_money+=$cr['total_winner_money'];
	    	$return[] = $cr;
	    }
		
		//保存中奖结果
		$save = array(
		'period_id'=>$period_id,
		'fisrt'=>$first_money,
		'second'=>$second_money,
		'third'=>$third_money,
		'consolation'=>$consolation_money,
		'special'=>$special_money,
		);
		pdo_insert('manji_pay_award', $save);
		pdo_update('manji_run_setting',array('status'=>2),array('id'=>$period_id));
	}
	cache_clean();
}

if ($has_confirm == count($periods)) {
	$result = array(
		'status' => 2,
		'info' => '结果进行计算，无法重复计算'
	);
	echo json_encode($result);
	exit;
}

foreach ($return as $ret) {
	if (count($ret['reward_log']) > 0) {
		foreach ($ret['reward_log'] as $rew) {
			pdo_insert('manji_reward_log',$rew);
		}
	}
	if (count($ret['winner_log']) > 0) {
		foreach ($ret['winner_log'] as $win) {
			pdo_insert('manji_winner',$win);
		}
	}
	if (count($ret['update_member']) > 0) {
		foreach ($ret['update_member'] as $upa) {
			pdo_query('update '.tablename('member_system_member').' set credit1=credit1+:money where id=:id',array(':money'=>$upa['win_money'],':id'=>$upa['user_id']));
		}
	}
}

//大彩金
$random_jackpot = big_jackpot(date('Y-m-d',time()));

//中彩金
$major_jackpot = middle_jackpot(date('Y-m-d',time()));

//小彩金
$minor_jackpot = small_jackpot(date('Y-m-d',time()));
sleep(2);
$sum_bet = 0;
$total_cashback = 0;
$total_pay = 0;
$sum_array = array();
$report_save = array();
foreach ($periods as $per) {
	$report = new Report($per['id']);
	$save_list = $report->GetReport();
	if (!empty($save_list)) {
		$report_save = array_merge($report_save,$save_list);
	}
	$sum_array[$per['aid']] = $report->GetTotal();
	$sum_array[$per['aid']]['cid'] = $per['aid'];
	$sum_array[$per['aid']]['period_id'] = $per['id'];
	$sum_array[$per['aid']]['createtime'] = time();
}

check_jackpot();

if (count($report_save) > 0) {
	foreach ($report_save as $save_item) {
		if ($save_item['parent_agent'] == 0) {
			$sum_bet += $save_item['sum_bet'];
		}
		pdo_insert('manji_downline_report',$save_item);
	}
}
foreach ($sum_array as $sum) {
	if ($sum_bet > 0) {
		$sum['bonus'] = ($sum['sum_bet']/$sum_bet)*($sum['profit']*0.98)*0.88;
	}
	pdo_insert('manji_total_report',$sum);
}

$result = array(
	'status' => 1,
	'info' => '开奖计算完成'
);
echo json_encode($result);
exit;


 ?>