<?php 
global $_W,$_GPC;

$user_id = $_SESSION['uid'];

if (empty($user_id)) {
    message('请先登录',$this->createMobileUrl('login'),'error');
}

$user = pdo_fetch('select * from '.tablename('agent_member').' where id=:id',array(':id'=>$user_id));
$agent_num = pdo_fetchcolumn('select count(id) from '.tablename('agent_member')
    . ' where parent_agent=:agent',array(':agent'=>$user_id));
$member_num = pdo_fetchcolumn('select count(id) from '.tablename('member_system_member')
    . ' where parent_agent=:agent',array(':agent'=>$user_id));
$percent = pdo_fetch('select * from '.tablename('agent_percent').' where agent_id=:agent_id',array(':agent_id'=>$user_id));

$cashback = json_decode($percent['cashback_percent'],true);


$array_a = array($odds['odds_A'],$odds['odds_C2'],$odds['odds_C3'],$odds['odds_C4'],$odds['odds_C5'],$odds['odds_EC']);
$max_a = max($array_a);
$array_4a = array($odds['odds_4A'],$odds['odds_4B'],$odds['odds_4C'],$odds['odds_4D'],$odds['odds_4E'],$odds['odds_EA']);
$max_4a = max($array_4a);
$array_2a = array($odds['odds_2A'],$odds['odds_2B'],$odds['odds_2C'],$odds['odds_2D'],$odds['odds_2E'],$odds['odds_EX']);
$max_2a = max($array_2a);

$cashback_money = array(
    'money_b' => get_cashback($plus['odds_B'],$cashback['B'],$percent['jackpot']),
    'money_s' => get_cashback($plus['odds_S'],$cashback['S'],$percent['jackpot']),
    'money_a' => get_cashback($max_a[0],$cashback['A'],$percent['jackpot']),
    'money_3abc' => get_cashback($plus['odds_3ABC'],$cashback['3ABC'],$percent['jackpot']),
    'money_4a' => get_cashback($max_4a[0],$cashback['4A'],$percent['jackpot']),
    'money_4ABC' => get_cashback($plus['odds_4ABC'],$cashback['4ABC'],$percent['jackpot']),
    'money_2a' => get_cashback($max_2a[0],$cashback['2A'],$percent['jackpot']),
    'money_2abc' => get_cashback($plus['odds_2ABC'],$cashback['2ABC'],$percent['jackpot']),
);


include $this->template('mine');


 ?>