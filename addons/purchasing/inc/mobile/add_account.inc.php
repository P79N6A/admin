<?php 
global $_W,$_GPC;
$manager = $_SESSION['mid'];
if (empty($user_id) && empty($manager)) {
    message('请先登录',$this->createMobileUrl('login'),'unlog');
}
$manager_status = pdo_fetchcolumn('select status from '.tablename('agent_member').' where id=:id',array(':id'=>$manager));
if ($manager_status == 1) {
    message('您的账号已经被禁用无法创建代理',referer(),'error');
    exit;
}
$operator = pdo_fetchcolumn('select nickname from '.tablename('agent_member').' where id=:id',array(':id'=>$manager));

$user_id = $_GPC['agent_id'];
$account = $_GPC['account']?$_GPC['account']:'';
$nickname = $_GPC['nickname']?$_GPC['nickname']:'';
$password = $_GPC['password']?$_GPC['password']:'';
$repassword = $_GPC['repassword']?$_GPC['repassword']:'';
$commission = $_GPC['commission'];
$bonus = $_GPC['percent']?$_GPC['percent']:0;
$recharge = $_GPC['recharge']?$_GPC['recharge']:0;
$bet = $_GPC['bet'];
$limit = $_GPC['limit']?$_GPC['limit']:0;
$eat = $_GPC['eat'];
$odds = $_GPC['odds'];
$cashback = $_GPC['cashback'];
$status = $_GPC['status'];
$red = $_GPC['red'];
$auto_create = $_GPC['auto_create'];
$all_line = $_GPC['all_line'];
$has_eat = $_GPC['has_eat'];
$has_bonus = $_GPC['has_bonus'];
$jb_bonus = $_GPC['jb_bonus'];
$jb_percent = $_GPC['jb_percent'];
$auto_recharge = $_GPC['auto_recharge'];
$auto_value = $_GPC['auto_value'];
if (empty($user_id) && $_SESSION['level'] >=4) {
    $user_id = $manager;
}
if(empty($nickname)){
    message('请填写昵称',referer(),'error');
    exit;
}

if (!empty($user_id) && $_SESSION['level'] == 5) {
    $parent = pdo_fetch('select * from '.tablename('agent_member').' where id=:id',array(':id'=>$user_id));
    $old_bonus = pdo_fetchcolumn('select bonus_percent from '.tablename('agent_percent').' where agent_id=:id',array(':id'=>$user_id));

    if ($jb_percent > $old_bonus) {
        message('花红比不能比自身大',referer(),'error');
        exit;
    }
    if ($recharge > $parent['credit1'] || $auto_value > $parent['credit1']) {
        message('上线没有足够的积分充值');
        exit;
    }
}


$percent = array(
    'cashback_percent' => json_encode($cashback),
    'bonus_percent' => $jb_percent
);

$data['nickname'] = $nickname;
if(!check_account($account)){
    message('账号格式错误',referer(),'error');
    exit;
}
if(empty($password)){
    message('请填写密码',referer(),'error');
    exit;
}
if(empty($repassword)){
    message('请填写确认密码',referer(),'error');
    exit;
}
if($password!=$repassword){
    message('确认密码不一致',referer(),'error');
    exit;
}
if(has_agent_account($account)){
    message('该代理账号已注册',referer(),'error');
    exit;
}
if (empty($eat)) {
    message('请填写吃字控制',referer(),'error');
    exit;
}

$data['pay_limit'] = $limit;
$data['child_limit'] = $bet;
$data['createtime'] = time();
$data['password'] = md5(md5($password));
$data['account'] = $account;
$data['level'] = 5;
$data['cid'] = $_SESSION['cid'];
$data['parent_agent'] = $user_id;
$data['jb_bonus'] = $jb_bonus;
$data['status'] = $status;
$data['all_line'] = $all_line;
if ($auto_recharge != 1) {
    $data['credit1'] = $recharge;
}
else{
    $data['credit1'] = $auto_value;
}
$data['auto_recharge'] = $auto_recharge;
$data['auto_value'] = $auto_recharge;
pdo_begin();
$res = pdo_insert('agent_member',$data);
$new_id = pdo_insertId();
$percent['agent_id'] = $new_id;
pdo_insert('agent_percent',$percent);
if($res!==false){
    if (!empty($parent)) {
        if ($auto_recharge != 1) {
            pdo_query('update '.tablename('agent_member').' set credit1=credit1-:recharge where id=:id',array(':id'=>$user_id,':recharge'=>$recharge));
        }
        else{
            pdo_query('update '.tablename('agent_member').' set credit1=credit1-:recharge where id=:id',array(':id'=>$user_id,':recharge'=>$auto_value));
        }
    }
    foreach ($odds as $key => $value) {
        $odd_save = array(
            'pid' => $value,
            'agent_id' => $new_id
        );
        foreach ($commission as $k => $v) {
            if ($value == $v['id']) {
                $odd_save['commission'] = json_encode($v['detail']);
            }
        }
        foreach ($cashback as$cash) {
            if ($value == $cash['id']) {
                $odd_save['cashback'] = json_encode($cash['detail']);
            }
        }
        pdo_insert('agent_odds',$odd_save);
    }
    foreach ($eat as $ky => $val) {
        $eat_new[$val['id']] = $val['detail'];
    }
    $eat_save = array(
        'agent_id' => $new_id,
        'percent' => $bonus,
        'eat' => json_encode($eat_new),
        'has_eat' => $has_eat,
        'has_bonus' => $has_bonus
    );
    pdo_insert('agent_eat',$eat_save);
    foreach ($red as $key => $value) {
        $new_red[$value['rule']] = $value['value'];
    }
    $red_save = array(
        'agent_id' => $new_id,
        'red_limit' => json_encode($new_red),
        'createtime' => time()
    );
    pdo_insert('agent_red',$red_save);
    $operation = array(
        'user_id' => $new_id,
        'user_type' => 1,
        'create_time' => time()
    );
    if (!empty($_GPC['agent_id'])) {
        $agent_name = pdo_fetchcolumn('select nickname from '.tablename('agent_member').' where id=:id',array(':id'=>$_GPC['agent_id']));
        $operation['operation'] = $operator.'替'.$agent_name.'创建了下线'.$nickname;
    }
    else{
        $operation['operation'] = $operator.'创建了下线'.$nickname;
    }
    pdo_insert('agent_operation',$operation);
    pdo_commit();
    message('操作成功',referer(),'success');
}else{
    pdo_rollback();
     message('操作失败',referer(),'error');
}

exit();

 ?>