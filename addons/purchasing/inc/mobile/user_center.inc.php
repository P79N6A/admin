<?php 
global $_W,$_GPC;
header('content-type: application/json; charset=utf-8');
header("access-control-allow-origin: *");
$weid = $_W['uniacid'];
$user_id = $_GPC['user_id'];
$token = $_GPC['token'];
$agent_id =  $_GPC['agent_id']? $_GPC['agent_id']:0;
$check_login =  appLogin($user_id,$token);
if ($check_login !=1) {
    $data = array(
        'status' => 403,
        'info'   => '已在另外的设备上登录',
    );
    echo json_encode($data);
    exit();
}
$user_score = 0;
$agent_num = 0;
$member_num = 0;
if($agent_id){
	$user_score = pdo_fetchcolumn('select credit1 from '.tablename('agent_member').' where id=:id',array(':id'=>$agent_id));  //帐号余额
    $agent_num = pdo_fetchcolumn('select count(id) from '.tablename('agent_member')
        . ' where parent_agent=:agent',array(':agent'=>$agent_id));
    $member_num = pdo_fetchcolumn('select count(id) from '.tablename('member_system_member')
        . ' where parent_agent=:agent',array(':agent'=>$agent_id));
    $odds = pdo_fetch('select odds1,odds2,odds3,odds4,odds5,odds6,odds7,odds8 from '.tablename('agent_odds').' where agent_id=:agent_id',array(':agent_id'=>$agent_id));
    $percent = pdo_fetch('select cashback_percent,bonus_percent,jackpot_percent from '.tablename('agent_percent').' where agent_id=:agent_id',array(':agent_id'=>$agent_id));
    if (!empty($odds)) {
        foreach ($odds as $key => $value) {
            $precent[] = $value;
        }
    }
}
else{
    $user_score = pdo_fetchcolumn('select credit1 from '.tablename('agent_member').' where id=:id',array(':id'=>$user_id));  //帐号余额
    $agent_num = pdo_fetchcolumn('select count(id) from '.tablename('agent_member')
        . ' where parent_agent=:agent',array(':agent'=>$user_id));
    $member_num = pdo_fetchcolumn('select count(id) from '.tablename('member_system_member')
        . ' where parent_agent=:agent',array(':agent'=>$user_id));
    $odds = pdo_fetch('select odds1,odds2,odds3,odds4,odds5,odds6,odds7,odds8 from '.tablename('agent_odds').' where agent_id=:agent_id',array(':agent_id'=>$user_id));
    $percent = pdo_fetch('select cashback_percent,bonus_percent,jackpot_percent from '.tablename('agent_percent').' where agent_id=:agent_id',array(':agent_id'=>$user_id));
    if (!empty($odds)) {
        foreach ($odds as $key => $value) {
            $precent[] = $value;
        }
    }
}




//TODO
//
$recharge = 0;
$income = 0;

$recharge = pdo_fetchcolumn('select sum(score) from '.tablename('agent_recharge').' where to_user=:id',array(':id'=>$agent_id));


$data['agent_num'] = $agent_num?$agent_num:0;
$data['member_num'] = $member_num?$member_num:0;
$data['recharge'] = $recharge?$recharge:0;
$data['income'] = $income;
$data['status'] = 200;
$data['info'] = '';
$data['odds'] = !empty($precent)?$precent:array();
$data['percent'] = $percent?$percent:array();
$data['score'] = $user_score;
echo json_encode($data);

 ?>