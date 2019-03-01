<?php 
global $_W,$_GPC;

$order = pdo_fetchall('select id,pay_B as B,pay_S as S,pay_A as A,pay_C2 as C2,pay_C3 as C3,pay_C4 as C4,pay_C5 as C5,pay_EC as EC,pay_4A as 4A,pay_4B as 4B,pay_4C as 4C,pay_4D as 4D,pay_4E as 4E,pay_EA as EA,pay_2A as 2A,pay_2B as 2B,pay_2C as 2C,pay_2D as 2D,pay_2E as 2E,pay_EX as EX,pay_5D as 5D,pay_6D as 6D from '.tablename('manji_order').' where status=1');
$allodds = pdo_fetchall('select m.*,o.id,a.agent_id as oid from '.tablename('manji_member_odds').' m left join '.tablename('agent_odds').' a on a.id=m.pid left join '.tablename('manji_odds').' o on a.pid=o.id where o.cid=1');
foreach ($allodds as $key => $value) {
	$odds[$value['member_id']] = $value;
}

foreach ($order as $k => $v) {
	$cashback_percent = gettotalCash($odds[$v['user_id']]['agent_id'],$odds[$v['user_id']]['pid']);
	$cashback = 0;
	foreach ($v as $index => $item) {
		if ($index == 'B') {
	        $odd = explode('|',$odds[$v['user_id']]['odds_'.$index]);
	        $odd_total = get_total_odds($odd);
	        $percent = ($odd_total)/100;
	    }
	    if ($index == 'A') {
	        $odd = array($odds[$v['user_id']]['odds_A'],$odds[$v['user_id']]['odds_C2'],$odds[$v['user_id']]['odds_C3'],$odds[$v['user_id']]['odds_C4'],$odds[$v['user_id']]['odds_C5'],$odds[$v['user_id']]['odds_EC']);
	        $odd_total = get_max($odd);
	        $percent = ($odd_total)/10;
	    }
	    if ($index == 'S') {
	        $odd = explode('|',$odds[$v['user_id']]['odds_'.$index]);
	        $odd_total = get_total_odds($odd);
	        $percent = ($odd_total)/100;
	    }
	    if ($index == '3ABC') {
	        $odd = explode('|',$odds[$v['user_id']]['odds_'.$index]);
	        $odd_total = get_total_odds($odd);
	        $percent = ($odd_total)/10;
	    }
	    if ($index == '4ABC') {
	        $odd = explode('|',$odds[$v['user_id']]['odds_'.$index]);
	        $odd_total = get_total_odds($odd);
	        $percent = ($odd_total)/100;
	    }
	    if ($index == '4A') {
	        $odd = array($odds[$v['user_id']]['odds_4A'],$odds[$v['user_id']]['odds_4B'],$odds[$v['user_id']]['odds_4C'],$odds[$v['user_id']]['odds_4D'],$odds[$v['user_id']]['odds_4E'],$odds[$v['user_id']]['odds_EA']);
	        $odd_total = get_max($odd);
	        $percent = ($odd_total)/100;
	    }
	    if ($index == '2ABC') {
	        $odd = explode('|',$odds[$v['user_id']]['odds_'.$index]);
	        $odd_total = get_total_odds($odd);
	        $percent = ($odd_total);
	    }
	    if ($index == '2A') {
	        $odd = array($odds[$v['user_id']]['odds_2A'],$odds[$v['user_id']]['odds_2B'],$odds[$v['user_id']]['odds_2C'],$odds[$v['user_id']]['odds_2D'],$odds[$v['user_id']]['odds_2E'],$odds[$v['user_id']]['odds_EX']);
	        $odd_total = get_max($odd);
	        $percent = ($odd_total);
	    }
	    if ($index == '5D') {
	      $odd = explode('|', $odds[$v['user_id']]['odds_'.$index]);
	      $percent = get_5d_odd($odd);
	    }
	    if ($index == '6D') {
	      $odd = explode('|', $odds[$v['user_id']]['odds_'.$index]);
	      $percent = get_6d_odd($odd);
	    }
	    $cashback += floatval($item)*(100-floatval($cashback_percent[$index])-floatval($percent))/100;
	}
    $ordercash[$v['id']] = $cashback;
}

echo json_encode($ordercash);
exit;


 ?>