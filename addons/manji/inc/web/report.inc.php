<?php
/**
 * Author: KL
 * Date: 2016/9/13 0013
 */

global $_W,$_GPC;
$weid = $_W['uniacid'];
$op = $_GPC['op']?$_GPC['op']:'display';
$page = $_GPC['page']>0?$_GPC['page']:1;
$psize = 25;
if($op == 'display'){
    $cdtime = mktime(23,59,59,date('m'),date('d'),date('Y'));
	$stime = $_GPC['stime']?strtotime($_GPC['stime']."00:00:00"): $cdtime-60*60*24*7;
	$etime = $_GPC['stime']?strtotime($_GPC['stime']."23:59:59")+7*3600*24: $cdtime;

	$list = pdo_fetchall('select id,periods,date from '.tablename('manji_run_setting').' where starttime>=:stime and starttime<=:etime order by date desc',array(':stime'=>$stime,':etime'=>$etime));

	foreach ($list as $key => $value) {
		$list[$key]['date'] = date('Y-m-d',strtotime($value['date']));
		$list[$key]['sum_bet'] = pdo_fetchcolumn('select sum(order_amount) from '.tablename('manji_order').' where period_id=:id',array(':id'=>$value['id']));
		$list[$key]['sum_bet_num'] = pdo_fetchcolumn('select count(id) from '.tablename('manji_order').' where period_id=:id',array(':id'=>$value['id']));
		$list[$key]['winner_num'] = pdo_fetchcolumn('select count(id) from '.tablename('manji_winner').' where period_id=:id',array(':id'=>$value['id']));
		$pay_award = pdo_fetch('select fisrt,second,third,consolation,special from '.tablename('manji_pay_award').' where period_id=:id',array(':id'=>$value['id']));
		$list[$key]['pay_award'] = $pay_award['fisrt']+$pay_award['second']+$pay_award['third']+$pay_award['consolation']+$pay_award['special'];
		$list[$key]['profit'] = $list[$key]['sum_bet'] - $list[$key]['pay_award'];
	}

   // $pager = pagination($num,$page,$psize);

}elseif($op == 'detail'){
    $id = $_GPC['id'];
    $purchasing_id = $_GPC['purchasing_id']>0?$_GPC['purchasing_id']:0;
    $periods = pdo_fetchcolumn('select periods from '.tablename('manji_run_setting').' where id=:id',array(':id'=>$id));
    $list = pdo_fetchall('select id,nickname from '.tablename('agent_member').' where parent_agent=:purchasing_id order by parent_agent asc limit '.($page-1)*$psize.','.$psize,array(':purchasing_id'=>$purchasing_id));
    foreach ($list as $key => $value) {
    	$list[$key]['profit'] = $this->findAgentIncome($value['id'],$id);
    	$junior = pdo_fetchall('select id from '.tablename('member_system_member').' where parent_agent=:id',array(':id'=>$value['id']));
    	if (!empty($junior)) {
    		foreach ($junior as $k => $v) {
	    		if ($k == 0) {
	    			$field = $v['id'];
	    		}
	    		else{
	    			$field .= ','.$v['id'];
	    		}
	    	}
	    	$order = pdo_fetch('select sum(order_amount) bet,sum(`result_B`+`result_S`+`result_A`+`result_C2`+`result_C3`+`result_C4`+`result_C5`+`result_EC`+`result_3ABC`+`result_4A`+`result_4B`+`result_4C`+`result_4D`+`result_4E`+`result_EA`+`result_4ABC`+`result_2A`+`result_2B`+`result_2C`+`result_2D`+`result_2E`+`result_EX`+`result_2ABC`) pay_award from '.tablename('manji_order').' where user_id in ('.$field.') and period_id=:id',array(':id'=>$id));
    	}
    	$list[$key]['sum_bet'] = $order['bet']?$order['bet']:0;
    	$list[$key]['pay_award'] = $order['pay_award']?$order['pay_award']:0;
    }
    $bet = pdo_fetchcolumn('select sum(order_amount) from '.tablename('manji_order').' where period_id=:id',array(':id'=>$id));
    $pay_award = pdo_fetchcolumn('select (`fisrt`+`second`+`third`+`consolation`+`special`) from '.tablename('manji_pay_award').' where period_id=:id',array(':id'=>$id));
    $profit = $bet - $pay_award;
    $total = pdo_fetchcolumn('select count(id) from '.tablename('agent_member').' where parent_agent=:purchasing_id order by parent_agent asc',array(':purchasing_id'=>$purchasing_id));

    $pager = pagination($total,$page,$psize);
}
elseif ($op == 'member') {
	$id = $_GPC['id'];
	$agent_id = $_GPC['agent_id'];
	$periods = pdo_fetchcolumn('select periods from '.tablename('manji_run_setting').' where id=:id',array(':id'=>$id));
	$list = pdo_fetchall('select id,nickname from '.tablename('member_system_member').' where parent_agent=:agent limit '.($page-1)*$psize.','.$psize,array(':agent'=>$agent_id));
	foreach ($list as $key => $value) {
		$order = pdo_fetch('select sum(order_amount) bet,sum(`4E_result`+`4S_result`+`4A_result`+`3ABC_result`+`3A_result`+`Box_result`+`IBOX_result`+`A1_result`) pay_award from '.tablename('manji_order').' where user_id=:user_id and period_id=:id',array(':user_id'=>$value['id'],':id'=>$id));
		$list[$key]['bet'] = $order['bet'];
		$list[$key]['pay_award'] = $order['pay_award'];
		$list[$key]['profit'] = $order['pay_award'] - $order['bet'];
		$list[$key]['balance'] = pdo_fetchcolumn('select member_old_money from '.tablename('manji_reward_log').' where period_id=:id and member_id=:member',array(':id'=>$id,':member'=>$value['id']));
	}

	$total = pdo_fetchcolumn('select count(id) from '.tablename('member_system_member').' where parent_agent=:agent',array(':agent'=>$agent_id));
	$pager = pagination($total,$page,$psize);
}
elseif ($op == 'cathectic') {
	$periods = $_GPC['periods'];
	$member = $_GPC['member'];
	$cdtime = mktime(23,59,59,date('m'),date('d'),date('Y'));

	$condition = ' where 1 ';

	if (!empty($periods)) {
		$condition .= ' and r.periods=:periods ';
		$fields[':periods'] = $periods;
	}
	if (!empty($member)) {
		$condition .= ' and m.nikcname like :member';
		$fields[':member'] = '%'.$member.'%';
	}

	$list = pdo_fetchall('select m.nickname,r.periods,o.* from '.tablename('manji_order').' o left join '.tablename('manji_run_setting').' r on r.id=o.period_id left join '.tablename('member_system_member').' m on m.id=o.user_id '.$condition.' order by o.createtime desc limit '.($page-1)*$psize.','.$psize,$fields);

	$total = pdo_fetchcolumn('select count(*) from '.tablename('manji_order').' o left join '.tablename('manji_run_setting').' r on r.id=o.period_id left join '.tablename('member_system_member').' m on m.id=o.user_id '.$condition.' order by o.createtime desc',$fields);

	$pager = pagination($total,$page,$psize);
}

elseif ($op == 'reward') {
	$periods = $_GPC['periods'];
	$member = $_GPC['member'];
	$cdtime = mktime(23,59,59,date('m'),date('d'),date('Y'));

	$condition = ' where 1 ';

	if (!empty($periods)) {
		$condition .= ' and period_num=:periods ';
		$fields[':periods'] = $periods;
	}
	if (!empty($member)) {
		$condition .= ' and member_nikename like :member';
		$fields[':member'] = '%'.$member.'%';
	}

	$list = pdo_fetchall('select * from '.tablename('manji_reward_log').$condition.' order by create_time desc limit '.($page-1)*$psize.','.$psize,$fields);

	$total = pdo_fetchcolumn('select count(id) from '.tablename('manji_reward_log').$condition.' order by create_time desc',$fields);

	$pager = pagination($total,$page,$psize);
}

elseif ($op == 'downline') {
	$line_id = $_GPC['id'];
	$period_id = $_GPC['period_id'];
	if (!empty($line_id)) {
		$condition = ' where a.parent_agent = :id ';
		$fields[':id'] = $line_id;
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

	$pager = pagination($total,$page,$psize);
}

include $this->template('report');