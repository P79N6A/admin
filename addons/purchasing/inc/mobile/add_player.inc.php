<?php 
global $_W,$_GPC;
$manager = $_SESSION['mid'];
if (empty($manager)) {
    message('请先登录',$this->createMobileUrl('login'),'unlog');
}
$manager_status = pdo_fetchcolumn('select status from '.tablename('agent_member').' where id=:id',array(':id'=>$manager));
if ($manager_status == 1) {
    message('您的账号已经被禁用无法创建会员',referer(),'error');
    exit;
}
$operator = pdo_fetchcolumn('select nickname from '.tablename('agent_member').' where id=:id',array(':id'=>$manager));
if (!empty($_GPC['agent_id'])) {
	$user_id = $_GPC['agent_id'];
}
else{
    $user_id = $manager;
}

$account = $_GPC['account']?$_GPC['account']:'';
$nickname = $_GPC['nickname']?$_GPC['nickname']:'';
$password = $_GPC['password']?$_GPC['password']:'';
$repassword = $_GPC['repassword']?$_GPC['repassword']:'';
$odds = $_GPC['odds']?$_GPC['odds']:'';
$commission = $_GPC['commission'];
$limit = $_GPC['limit'];
$bet = $_GPC['bet'];
$red = $_GPC['red'];
$recharge = $_GPC['recharge'];
$give = $_GPC['give'];
$auto_add = $_GPC['auto_add'];
$status = $_GPC['status'];
$show_amount = $_GPC['show_amount'];
$auto_recharge = $_GPC['auto_recharge'];
$auto_value = $_GPC['auto_value'];
$mobile = $_GPC['mobile'];
$has_false = $_GPC['has_false'];
$false_price = $_GPC['false_price'];

$cid = pdo_fetchcolumn('select cid from '.tablename('agent_member').' where id=:id',array(':id'=>$user_id));


if(!check_account($account)){
    message('账号格式错误',referer(),'error');
}
if(empty($password)){
    message('请填写密码',referer(),'error');
}
if(empty($repassword)){
    message('请填写确认密码',referer(),'error');
}
if($password!=$repassword){
    message('确认密码不一致',referer(),'error');
}
if(has_member_account($account)){
    message('该会员账号已存在',referer(),'error');
}

$data['nickname'] = $nickname;
$data['createtime'] = time();
$data['password'] = md5(md5($password));
$data['account'] = $account;
$data['pay_limit'] = $limit;
$data['bet_limit'] = $bet;
$data['mobile'] = $mobile;
if ($_SESSION['cid'] > 0) {
    $data['cid'] = $_SESSION['cid'];
}
else{
    $data['cid'] = $cid;
}
$data['parent_agent'] = $user_id;
$parent = pdo_fetch('select * from '.tablename('agent_member').' where id=:id',array(':id'=>$user_id));
if ($recharge > $parent['credit1'] || $auto_value > $parent['credit1']) {
    message('上线积分不足',referer(),'error');
}
if ($auto_recharge != 1) {
    $data['credit1'] = $recharge;
    $data['credit2'] = $recharge*$give/100;
    $parent_credit = $parent['credit1'] - $recharge;
}
else{
    $data['credit1'] = $auto_value;
    $parent_credit = $parent['credit1'] - $recharge;
}
$data['give'] = $give;
$data['auto_recharge'] = $auto_recharge;
$data['auto_value'] = $auto_recharge;
$data['auto_add'] = $auto_add;
$data['show_amount'] = $show_amount;
$data['has_false'] = $has_false;
$data['false_price'] = $false_price;

$res = pdo_insert('member_system_member',$data);


$member_id = pdo_insertId();

if($res!==false){
    foreach ($odds as $key => $value) {
        $odd = pdo_fetch('select o.* from '.tablename('agent_odds').' a left join '.tablename('manji_odds').' o on o.id=a.pid where a.id=:id',array(':id'=>$value));
        if (!empty($odd)) {
            foreach ($odd as $k => $v) {
                if (strpos($k,'odds_') !== false) {
                    $odds_save[$k] = $v;
                }
            }
            foreach ($commission as $com) {
                if ($com['id'] == $value) {
                    $odds_save['commission'] = json_encode($com['detail']);
                    $odds_save['my_cashback'] = json_encode($com['cashback']);
                }
            }
            $odds_save['member_id'] = $member_id;
            $odds_save['cid'] = $odd['cid'];
            $odds_save['pid'] = $value;
            pdo_insert('manji_member_odds',$odds_save);
        }
    }
    pdo_update('agent_member',array('credit1'=>$parent_credit),array('id'=>$parent['id']));
    foreach ($red as $rd) {
        $red_info[$rd['rule']] = $rd['value'];
    }
    $red_save = array(
        'user_id' => $member_id,
        'red_limit' => json_encode($red_info),
        'createtime' => time()
    );
    pdo_insert('manji_member_red',$red_save);
    $operation = array(
        'user_id' => $new_id,
        'user_type' => 2,
        'create_time' => time()
    );
    if (!empty($_GPC['agent_id'])) {
        $agent_name = pdo_fetchcolumn('select nickname from '.tablename('agent_member').' where id=:id',array(':id'=>$_GPC['agent_id']));
        $operation['operation'] = $operator.'替'.$agent_name.'创建了会员'.$nickname;
    }
    else{
        $operation['operation'] = $operator.'创建了会员'.$nickname;
    }
    pdo_insert('agent_operation',$operation);
    message('操作成功',referer(),'success');
}else{
     message('操作失败',referer(),'error');
}


 ?>