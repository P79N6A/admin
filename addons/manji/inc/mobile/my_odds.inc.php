<?php
global $_W,$_GPC;
header('content-type: application/json; charset=utf-8');
header("access-control-allow-origin: *");
$weid = $_W['uniacid'];
$user_id = $_GPC['user_id'];
$token = $_GPC['token'];

$check_login =  appLogin($user_id,$token);
if ($check_login !=1) {
    $data = array(
        'status' => 403,
        'info'   => '已在另外的设备上登录',
    );
    echo json_encode($data);
    exit();
}

$data['status'] = 200;
$data['info'] = '';
$data['odds_4e'] = 0;
$data['odds_4s'] = 0;
$data['odds_4a'] = 0;
$data['odds_3abc'] = 0;
$data['odds_3a'] = 0;
$data['odds_sd'] = 0;
$data['odds_se'] = 0;
$data['odds_a1'] = 0;
$memInfo = pdo_fetch("select  parent_agent from ".tablename('member_system_member')." where id=:id ",array(':id'=>$user_id));

$data1 = pdo_fetch('select odds1 as odds_4e,odds2 as odds_4s,odds3 as odds_4a,odds4 as odds_3abc,odds5 as odds_3a,
odds6 as odds_sd,odds7 as odds_se,odds8 as odds_a1 from '.tablename('agent_odds').' where agent_id=:agent_id',
    array(':agent_id'=>$memInfo['parent_agent']));
if(!empty($data1)){
    $data = array_merge($data,$data1);
}
 
echo json_encode($data);

?>