<?php 
global $_W,$_GPC;
//header('content-type: application/json; charset=utf-8');
//header("access-control-allow-origin: *");
$weid = $_W['uniacid'];
$user_id = $_GPC['user_id'];
$token = $_GPC['token'];
$agent_id = $_GPC['agent_id']?$_GPC['agent_id']:0;
$odds['odds1'] = $_GPC['odds1']?$_GPC['odds1']:0;  //4e--
$odds['odds2'] = $_GPC['odds2']?$_GPC['odds2']:0;  //4s--
$odds['odds3'] = $_GPC['odds3']?$_GPC['odds3']:0;   //4a
$odds['odds4'] = $_GPC['odds4']?$_GPC['odds4']:0;    //3abc--
$odds['odds5'] = $_GPC['odds5']?$_GPC['odds5']:0;   //3a
$odds['odds6'] = $_GPC['odds6']?$_GPC['odds6']:0;
$odds['odds7'] = $_GPC['odds7']?$_GPC['odds7']:0;
//$odds['odds8'] = $_GPC['odds8']?$_GPC['odds8']:0;


$check_login =  appLogin($user_id,$token);
if ($check_login !=1) {
    $data = array(
        'status' => 403,
        'info'   => '已在另外的设备上登录',
    );
    echo json_encode($data);
    exit();
}
if (!$agent_id) {
    $data = array(
        'status' => 300,
        'info'   => '请选择下线代理',
    );
    echo json_encode($data);
    exit();
}
$has1 = pdo_fetch('select * from '.tablename('agent_member').' where id=:id',array(':id'=>$agent_id));

if (empty($has1)) {
    $data = array(
        'status' => 300,
        'info'   => '该下线代理不存在',
    );
    echo json_encode($data);
    exit();
}
$agent_odds = pdo_fetch('select * from '.tablename('agent_odds').' where agent_id=:id',array(':id'=>$user_id));

$has =   pdo_fetch('select * from '.tablename('agent_odds').' where agent_id=:agent_id',array(':agent_id'=>$agent_id));

// if(empty($agent_odds) ){
//     $data = array(
//         'status' => 300,
//         'info'   => '操作失败',
//     );
//     echo json_encode($data);
//     exit();
// }


foreach ($odds as $k=>&$odd){

    $odd = trim($odd);
    if(!check_set_odds($odd)){
        $data = array(
            'status' => 300,
            'info'   => '赔率不能为0',
            'ddd'=>$odds
        );
        echo json_encode($data);
        exit();
    }

    if(!compare_odds($agent_odds[$k],$odd)){
        $data = array(
            'status' => 300,
            'info'   => '赔率不能高于你的相应的赔率',
        );
        echo json_encode($data);
        exit();
    }

}

if($has){
    $res = pdo_update('agent_odds',$odds,array('agent_id'=>$has['agent_id']));

}else{
    $odds['agent_id'] = $agent_id;
    $res = pdo_insert('agent_odds',$odds);

}

if($res!==false){
    $data['status'] = 200;
    $data['info'] = '';
}else{
    $data['status'] = 300;
    $data['info'] = '操作失败';

}

echo json_encode($data);

 ?>