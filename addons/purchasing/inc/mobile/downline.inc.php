<?php 
global $_W,$_GPC;
$user_id = $_SESSION['uid'];
$agent_id = $_GPC['agent_id'];
$period_id = $_GPC['period_id'];
$page = $_GPC['page']>0?$_GPC['page']:1;
$psize = 10;
if (!empty($agent_id)) {
	if ($agent_id != $user_id) {
		$condition = ' where a.id = :id ';
		$fields[':id'] = $agent_id;
	}
	else{
		$condition = ' where a.parent_agent = :id ';
		$fields[':id'] = $agent_id;
	}
}
else{
	$condition = ' where a.parent_agent = :id ';
	$fields[':id'] = $user_id;
}

$list = pdo_fetchall('select a.id,a.nickname,p.cashback_percent,p.bonus_percent from '.tablename('agent_member').' a left join '.tablename('agent_percent').' p on a.id=p.agent_id '.$condition.' limit '.($page-1)*$psize.','.$psize,$fields);
foreach ($list as $key => $value) {
		$junior = pdo_fetchall('select id from '.tablename('member_system_member').' where parent_agent=:id',array(':id'=>$value['id']));
		$upline = pdo_fetch('select p.cashback_percent,p.bonus_percent from '.tablename('agent_member').' a left join '.tablename('agent_percent').' p on a.parent_agent=p.agent_id where a.id=:id',array(':id'=>$value['id']));
		$cashback = 0;
		$bonus = 0;
		$profit = 0;
		$order = array();
		$upline_cashback = 0;
		$upline_bonus = 0;
		$upline_profit = 0;
		$jackpot_profit = 0;
    	if (!empty($junior)) {
    		foreach ($junior as $k => $v) {
	    		if ($k == 0) {
	    			$field = $v['id'];
	    		}
	    		else{
	    			$field .= ','.$v['id'];
	    		}
	    	}
	    	$order = pdo_fetch('select sum(order_amount) bet,sum(`result_B`+`result_S`+`result_A`+`result_C2`+`result_C3`+`result_C4`+`result_C5`+`result_EC`+`result_3ABC`+`result_4A`+`result_4B`+`result_4C`+`result_4D`+`result_4E`+`result_EA`+`result_4ABC`+`result_2A`+`result_2B`+`result_2C`+`result_2D`+`result_2E`+`result_2E`+`result_EX`+`result_2ABC`) as pay_award from '.tablename('manji_order').' where user_id in ('.$field.') and period_id=:id',array(':id'=>$period_id));
	    	$bet_list = pdo_fetch('select sum(pay_B) as B,sum(pay_S) as S,sum(pay_A+pay_C2+pay_C3+pay_C4+pay_C5+pay_EC) as A,sum(pay_3ABC) as 3ABC,sum(pay_4A+pay_4B+pay_4C+pay_4D+pay_4E+pay_EA) as 4A,sum(pay_4ABC) as 4ABC,sum(pay_2A+pay_2B+pay_2C+pay_2D+pay_2E+pay_EX) as 2A,sum(pay_2ABC) as 2ABC from '.tablename('manji_order').' where user_id in ('.$field.') and period_id=:id',array(':id'=>$period_id));
	    	if (!empty($bet_list)) {
	    		$cashback_percent = json_decode($value['cashback_percent'],true);
	    		$upline_cashback_percent = json_decode($upline['cashback_percent'],true);
	    		foreach ($bet_list as $index => $item) {
	    			$cashback += floatval($item)*floatval($cashback_percent[$index])/100;
	    			$upline_cashback += floatval($item)*floatval($upline_cashback_percent[$index])/100;
	    		}
	    	}
	    	$bonus = (floatval($order['bet'])-$cashback)*$vlaue['bonus_percent']/100;
	    	$profit = floatval($order['bet'])-($cashback+floatval($order['pay_award']));
	    	$upline_bonus = (floatval($order['bet'])-$upline_cashback)*$upline['bonus_percent']/100;
	    	$upline_profit = floatval($order['bet'])-($upline_cashback+floatval($order['pay_award']));
	    	$jackpot_profit = floatval($order['bet'])*0.02;
    	}
    	$list[$key]['cashback'] = $cashback?$cashback:0;
    	$list[$key]['bonus'] = $bonus?$bonus:0;
    	$list[$key]['sum_bet'] = $order['bet']?$order['bet']:0;
    	$list[$key]['pay_award'] = $order['pay_award']?$order['pay_award']:0;
    	$list[$key]['profit'] = $profit?$profit:0;
    	$list[$key]['net'] = $list[$key]['profit'] - $list[$key]['bonus'];
    	$list[$key]['upline_cashback'] = $upline_cashback?$upline_cashback:0;
    	$list[$key]['upline_bonus'] = $upline_bonus?$upline_bonus:0;
    	$list[$key]['upline_profit'] = $upline_profit?$upline_profit:0;
    	$list[$key]['upline_net'] = $list[$key]['upline_profit'] - $list[$key]['upline_bonus'];
    	$list[$key]['jackpot_profit'] = $jackpot_profit?$jackpot_profit:0;
	}

$total = pdo_fetchcolumn('select count(a.id) from '.tablename('agent_member').' a left join '.tablename('agent_percent').' p on a.id=p.agent_id '.$condition,$fields);

$periods = pdo_fetchcolumn('select periods from '.tablename('manji_run_setting').' where id=:id',array(':id'=>$period_id));

include $this->template('xiaxianbaobiao');






 ?>