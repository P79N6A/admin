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

$time = time();
$date  =  date('Ymd');
//找到开奖的最接近当前时间的开奖时间
$memInfo = pdo_fetch("select  parent_agent from ".tablename('member_system_member')." where id=:id ",array(':id'=>$user_id));
$odds = pdo_fetch('select * from '.tablename('agent_odds').' where agent_id=:agent_id',array(':agent_id'=>$memInfo['parent_agent']));
unset($odds['agent_id']);

//第一步，找到当前时间内的
$period_info = pdo_fetch('select * from '.tablename('manji_run_setting').' where  starttime<:time  and  endtime>:time  order by id asc limit 1',array(':time'=>$time));

if(empty($period_info)){
    $data = array(
        'status' => 300,
        'info'   => '暂无投注活动',
    );
    if(!empty($odds)){
        $data = array_merge($data,$odds);
    }
    echo json_encode($data);
    exit();
}

$data  = array('status'=>200,'info'=>'',);
if( !empty($period_info) ){
	$data = array_merge($data,$period_info);
}
if(!empty($odds)){
    $data = array_merge($data,$odds);
}
echo json_encode($data);

 ?>