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

$page = $_GPC['page']?$_GPC['page']:1;
$user_type = $_GPC['user_type']?$_GPC['user_type']:1;
$score_type = $_GPC['score_type']?$_GPC['score_type']:1;
$psize  = 20;
$where = array(':agent'=>$user_id,':score_type'=>$score_type);
$totalRows = 0;
//agent
if($user_type==1){
    $list = pdo_fetchall('select r.score,r.create_time,m.id,m.nickname from '.tablename('agent_recharge')
        . ' r left join '.tablename('agent_member').' m on r.to_user = m.id where r.from_user=:agent and r.user_type=1 and r.score_type =:score_type order by r.id desc limit '.($page-1)*$psize.",{$psize}",$where);
    $totalRows = pdo_fetchcolumn('select count(r.id) from '.tablename('agent_recharge')
        . ' r left join '.tablename('agent_member').' m on r.to_user = m.id where r.from_user=:agent and r.user_type=1 and r.score_type =:score_type ' ,$where);

}

//member
if($user_type==2){
    $list = pdo_fetchall('select r.score,r.create_time,m.id,m.nickname from '.tablename('agent_recharge')
        . ' r left join '.tablename('member_system_member').' m on r.to_user = m.id where r.from_user=:agent and r.user_type=2 and r.score_type =:score_type order by r.id desc limit '.($page-1)*$psize.",{$psize}", $where);
    $totalRows = pdo_fetchcolumn('select count(r.id) from '.tablename('agent_recharge')
        . ' r left join '.tablename('member_system_member').' m on r.to_user = m.id where r.from_user=:agent and r.user_type=2 and r.score_type =:score_type  ' , $where);

}



$data['list'] = empty($list)?array():$list;
$data['status'] = 200;
$data['info'] = '';
$data['score_type'] = $score_type;
$data['total_rows'] = intval($totalRows);
echo json_encode($data);

 ?>