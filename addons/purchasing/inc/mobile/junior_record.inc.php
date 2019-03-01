<?php 
global $_W,$_GPC;

$user_id = $_SESSION['uid'];
$period_id = $_GPC['period_id'];

$purchasing_id = $user_id;
$periods = pdo_fetchcolumn('select periods from '.tablename('manji_run_setting').' where id=:id',array(':id'=>$period_id));
$list = pdo_fetchall('select id,nickname from '.tablename('agent_member').' where parent_agent=:purchasing_id order by id asc'
    ,array(':purchasing_id'=>$purchasing_id));
$mine = array(
    'profit' => 0,
    'sum_bet' => 0,
    'pay_award' => 0
);

foreach ($list as $key => $value) {
    $profit = $this->findAgentIncome($value['id'],$period_id);
    $list[$key]['profit'] = $profit?$profit:0;
    $junior = pdo_fetchall('select id from '.tablename('member_system_member').' where parent_agent=:id',array(':id'=>$value['id']));
    if (!empty($junior)) {
        $field = array_column($junior,'id');
        $field = implode(',',$field);
        $order = pdo_fetch('select sum(order_amount) bet,sum(`result_B`+`result_S`+`result_A`+`result_C2`+`result_C3`+`result_C4`+`result_C5`+`result_EC`+`result_3ABC`+`result_4A`+`result_4B`+`result_4C`+`result_4D`+`result_4E`+`result_EA`+`result_4ABC`+`result_2A`+`result_2B`+`result_2C`+`result_2D`+`result_2E`+`result_EX`+`result_2ABC`) pay_award from '
            .tablename('manji_order').' where user_id in ('.$field.') and period_id=:id',array(':id'=>$period_id));
    }
    $list[$key]['sum_bet'] = $order['bet']?$order['bet']:0;
    $list[$key]['pay_award'] = $order['pay_award']?$order['pay_award']:0;
    $mine['profit'] += floatval($profit);
    $mine['sum_bet'] += floatval($order['bet']);
    $mine['pay_award'] += floatval($order['pay_award']);
}


include $this->template('xiaxianzhangmu');



 ?>