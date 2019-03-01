<?php 
global $_W,$_GPC;

$user_id = $_SESSION['uid'];
$period_id = $_GPC['period_id'];
$agent_id = $user_id;
$periods = pdo_fetchcolumn('select periods from '.tablename('manji_run_setting').' where id=:id',array(':id'=>$period_id));
$list = pdo_fetchall('select id,nickname from '.tablename('member_system_member').' where parent_agent=:agent',array(':agent'=>$agent_id));
foreach ($list as $key => $value) {
    $order = pdo_fetch('select sum(order_amount) bet,sum(`result_B`+`result_S`+`result_A`+`result_C2`+`result_C3`+`result_C4`+`result_C5`+`result_EC`+`result_3ABC`+`result_4A`+`result_4B`+`result_4C`+`result_4D`+`result_4E`+`result_EA`+`result_4ABC`+`result_2A`+`result_2B`+`result_2C`+`result_2D`+`result_2E`+`result_EX`+`result_2ABC`) pay_award from '
        .tablename('manji_order').' where user_id=:user_id and period_id=:id',array(':user_id'=>$value['id'],':id'=>$period_id));
    $list[$key]['sum_bet'] = $order['bet']?$order['bet']:0;
    $list[$key]['pay_award'] = $order['pay_award']?$order['pay_award']:0;
    $list[$key]['profit'] = ($order['pay_award'] - $order['bet'])?$order['pay_award'] - $order['bet']:0;
    $balance = pdo_fetchcolumn('select member_old_money from '.tablename('manji_reward_log').' where period_id=:id and member_id=:member',
        array(':id'=>$period_id,':member'=>$value['id']));
    $list[$key]['balance'] = $balance?$balance:0;
    $mine['profit'] += floatval($list[$key]['profit']);
    $mine['sum_bet'] += floatval($order['bet']);
    $mine['pay_award'] += floatval($order['pay_award']);
    $mine['balance'] += floatval($balance);
}

include $this->template('huiyuanzhangmu');


 ?>