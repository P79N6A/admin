<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/3/23
 * Time: 16:52
 */
global $_W,$_GPC;
$user_id = $_SESSION['uid'];



$type = $_GPC['type']?$_GPC['type']:1;
$period_id = $_GPC['period_id']?$_GPC['period_id']:0;
$page = $_GPC['page']>0?$_GPC['page']:1;

$psize = 20;
$total = 0;
if($type ==1){
    //下线查账
    $purchasing_id = $user_id;
    $periods = pdo_fetchcolumn('select periods from '.tablename('manji_run_setting').' where id=:id',array(':id'=>$period_id));
    $list = pdo_fetchall('select id,nickname from '.tablename('agent_member').' where parent_agent=:purchasing_id order by id asc limit '
        .($page-1)*$psize.','.$psize,array(':purchasing_id'=>$purchasing_id));
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
            $order = pdo_fetch('select sum(order_amount) bet,sum(`4E_result`+`4S_result`+`4A_result`+`3ABC_result`+`3A_result`+`Box_result`+`IBOX_result`+`A1_result`) pay_award from '
                .tablename('manji_order').' where user_id in ('.$field.') and period_id=:id',array(':id'=>$period_id));
        }
        $list[$key]['sum_bet'] = $order['bet']?$order['bet']:0;
        $list[$key]['pay_award'] = $order['pay_award']?$order['pay_award']:0;
        $mine['profit'] += floatval($profit);
        $mine['sum_bet'] += floatval($order['bet']);
        $mine['pay_award'] += floatval($order['pay_award']);
    }

    $total = pdo_fetchcolumn('select count(id) from '.tablename('agent_member').' where parent_agent=:purchasing_id order by id asc',
        array(':purchasing_id'=>$purchasing_id));

}

//会员查账
elseif ($type == 2) {

    $agent_id = $user_id;
    $periods = pdo_fetchcolumn('select periods from '.tablename('manji_run_setting').' where id=:id',array(':id'=>$period_id));
    $list = pdo_fetchall('select id,nickname from '.tablename('member_system_member').' where parent_agent=:agent limit '
        .($page-1)*$psize.','.$psize,array(':agent'=>$agent_id));
    foreach ($list as $key => $value) {
        $order = pdo_fetch('select sum(order_amount) bet,sum(`4E_result`+`4S_result`+`4A_result`+`3ABC_result`+`3A_result`+`Box_result`+`IBOX_result`+`A1_result`) pay_award from '
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

    $total = pdo_fetchcolumn('select count(id) from '.tablename('member_system_member').' where parent_agent=:agent',array(':agent'=>$agent_id));

}

$list = empty($list)?array():$list;


include $this->template('xiaxianzhangmu');




