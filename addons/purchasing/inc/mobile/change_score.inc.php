<?php 
global $_W,$_GPC;

$user_id = $_SESSION['uid'];
$manager = $_SESSION['mid'];
if (empty($user_id) && empty($manager)) {
    $data = array(
        'status' => 3,
        'info'   => '请先登录',
    );
    echo json_encode($data);
    exit();
}

$score = is_numeric($_GPC['score'])?$_GPC['score']:0;
$score_type = $_GPC['score_type']?$_GPC['score_type']:1;
$user_type = $_GPC['user_type']?$_GPC['user_type']:1;
$agent_id = $_GPC['agent_id']?$_GPC['agent_id']:0;
if (!empty($_GPC['user_id'])) {
    $user_id = $_GPC['user_id'];
}


if(empty($agent_id)){
    $data = array(
        'status' => 300,
        'info'   => '请选择下级人员',
    );
    echo json_encode($data);
    exit();
}


//先将输入的值 转到小数点后1位

if(empty($score)||$score<=0){
    $data = array(
        'status' => 300,
        'info'   => '请填写正确的积分',
    );
    echo json_encode($data);
    exit();
}

if( $score > 1000000 ){
	 $data = array(
        'status' => 300,
        'info'   => '你充值的积分太多了',
    );
    echo json_encode($data);
    exit();
}


$sql = "LOCK TABLE ".tablename('agent_member'). " WRITE,"
        .tablename('member_system_member')." WRITE,"
        .tablename('agent_recharge')." WRITE,"
        .tablename('agent_operation')." WRITE,"
        .tablename('core_sessions')." WRITE";
$res = pdo_run($sql);




if($user_type==1){
    $hasInfo  = pdo_fetch('select id,credit1,parent_agent  from '.tablename('agent_member')
        . ' where id=:id  ' ,array(':id'=>$agent_id));
    $nickname = pdo_fetchcolumn('select nickname from '.tablename('agent_member').' where id=:id',array(':id'=>$agent_id));
}
if($user_type==2){
    $hasInfo  = pdo_fetch('select id,credit1,parent_agent,status  from '.tablename('member_system_member')
        . ' where id=:id  ' ,array(':id'=>$agent_id));
    $nickname = pdo_fetchcolumn('select nickname from '.tablename('member_system_member').' where id=:id',array(':id'=>$agent_id));
}

if(empty($hasInfo)){
	pdo_run('UNLOCK TABLES;');
	
    $data = array(
        'status' => 300,
        'info'   => '该人员不存在',
    );
    echo json_encode($data);
    exit();

}

if ($hasInfo['status'] == 1) {
    pdo_run('UNLOCK TABLES;');
    
    $data = array(
        'status' => 300,
        'info'   => '用户已禁用，无法充值/减值',
    );
    echo json_encode($data);
    exit();
}

$parent_id = $hasInfo['parent_agent'];

$agent_parent = pdo_fetchcolumn('select parent_agent from '.tablename('agent_member').' where id=:id',array(':id'=>$parent_id));

if ($hasInfo['parent_agent'] != $user_id && empty($manager) && $agent_parent != $user_id) {
    $data = array(
        'status' => 300,
        'info' => '您没有权限对该人员充值/减值'
    );
    echo json_encode($data);
    exit;
}


//pdo_begin();
//$sql = "LOCK TABLE ".tablename('agent_member'). " WRITE,".tablename('member_system_member')." WRITE,".tablename('agent_recharge')." WRITE;" ;
//pdo_run($sql);

$res = false;
//inc 增加积分
if($score_type==1){

    //首先要判定上一级代理的钱够不够，才能给自己的下线充值 
    if (!empty($manager) && empty($user_id)) {
        if ($parent_id > 0) {
            $user_score = pdo_fetchcolumn('select credit1 from '.tablename('agent_member').' where id=:id',array(':id'=>$parent_id));
            if($user_score<$score){
                pdo_run('UNLOCK TABLES;');
                $data['status'] = 300;
                $data['info'] = '当前代理积分不足，无法帮其他人充值，请尽快联系你的负责人充值 ';
                echo json_encode($data);
                exit;
            }
        }
    }
    else{
        $user_score = pdo_fetchcolumn('select credit1 from '.tablename('agent_member').' where id=:id',array(':id'=>$user_id));
        if($user_score<$score){
            pdo_run('UNLOCK TABLES;');
            $data['status'] = 300;
            $data['info'] = '您当前积分不足，无法帮其他人充值，请尽快联系你的负责人充值 ';
            echo json_encode($data);
            exit;
        }
    }

    if (!empty($manager) && empty($user_id)) {
        $operator = '管理员';
    }
    elseif (!empty($manager) && $user_id != $parent_id) {
        $operator = '管理员';
    }
    else{
        $operator = pdo_fetchcolumn('select nickname from '.tablename('agent_member').' where id=:id',array(':id'=>$user_id));
    }
    
  
    $credit = $hasInfo['credit1'] + $score;
    $user_credit = $user_score - $score;  //自己的积分要减掉
    if (!empty($manager) && empty($user_id)) {
        if ($parent_id > 0) {
            $res = pdo_update('agent_member',array('credit1'=>$user_credit),array('id'=>$parent_id));
        }
    }
    else{
       $res = pdo_update('agent_member',array('credit1'=>$user_credit),array('id'=>$user_id)); 
    }
	
	
	//给用户或者 下线加积分
    if($user_type==1){
        $nickname = pdo_fetchcolumn('select nickname from '.tablename('agent_member').' where id=:id',array(':id'=>$agent_id));
        $res = pdo_update('agent_member',array('credit1'=>$credit),array('id'=>$agent_id));
        $operation = array(
            'user_id' => $agent_id,
            'user_type' => 1,
            'operation' => $operator.'对'.$nickname.'充值了'.$score.'额度',
            'create_time' => time()
        );
        pdo_insert('agent_operation',$operation);
        pdo_update('agent_member',array('last_edit_time'=>time()),array('id'=>$agent_id));
    }
    if($user_type==2){
        $nickname = pdo_fetchcolumn('select nickname from '.tablename('member_system_member').' where id=:id',array(':id'=>$agent_id));
        $res = pdo_update('member_system_member',array('credit1'=>$credit),array('id'=>$agent_id));
        $operation = array(
            'user_id' => $agent_id,
            'user_type' => 2,
            'operation' => $operator.'对'.$nickname.'充值了'.$score.'积分',
            'create_time' => time()
        );
        pdo_insert('agent_operation',$operation);
        pdo_update('agent_member',array('last_edit_time'=>time()),array('id'=>$agent_id));
    }
}


//dec
if($score_type==2){
    if($hasInfo['credit1']<$score){
		pdo_run('UNLOCK TABLES;');
		
        $data['status'] = 300;
        $data['info'] = '对方积分不足，无法进行些操作';
        echo json_encode($data);
        exit;
    }
	//自己的积分要加上
	$user_credit = $user_score + $score;  
	$res = pdo_update('agent_member',array('credit1'=>$user_credit),array('id'=>$user_id));
	
	//给用户或者 下线减积分
    $credit = $hasInfo['credit1'] - $score;
    if (!empty($manager) && empty($user_id)) {
        $operator = '管理员';
    }
    elseif (!empty($manager) && $user_id != $parent_id) {
        $operator = '管理员';
    }
    else{
        $operator = pdo_fetchcolumn('select nickname from '.tablename('agent_member').' where id=:id',array(':id'=>$user_id));
    }
    if($user_type==1){
        $res = pdo_update('agent_member',array('credit1'=>$credit),array('id'=>$agent_id));
        $operation = array(
            'user_id' => $agent_id,
            'user_type' => 1,
            'operation' => $operator.'对'.$nickname.'减值了'.$score.'额度',
            'create_time' => time()
        );
        pdo_insert('agent_operation',$operation);
        pdo_update('agent_member',array('last_edit_time'=>time()),array('id'=>$agent_id));
    }
    if($user_type==2){
        $res = pdo_update('member_system_member',array('credit1'=>$credit),array('id'=>$agent_id));
        $operation = array(
            'user_id' => $agent_id,
            'user_type' => 2,
            'operation' => $operator.'对'.$nickname.'减值了'.$score.'积分',
            'create_time' => time()
        );
        pdo_insert('agent_operation',$operation);
        pdo_update('agent_member',array('last_edit_time'=>time()),array('id'=>$agent_id));
    }
}

if($res!==false){

    pdo_insert('agent_recharge',array('from_user'=>$user_id,'to_user'=>$agent_id,
            'create_time'=>time(),'score'=>$score,'user_type'=>$user_type,'score_type'=>$score_type));

    $data['status'] = 200;
    $data['info'] = '操作成功';
}else{
    $data['status'] = 300;
    $data['info'] = '操作失败';
}

pdo_run('UNLOCK TABLES;');

echo json_encode($data);

 ?>