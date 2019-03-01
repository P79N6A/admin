<?php 
global $_W,$_GPC;
$manager = $_SESSION['mid'];
if (empty($manager)) {
    message('请先登录',$this->createMobileUrl('login'),'unlog');
}
$manager_status = pdo_fetchcolumn('select status from '.tablename('agent_member').' where id=:id',array(':id'=>$manager));
if ($manager_status == 1) {
    message('您的账号已经被禁用无法对下线进行修改',referer(),'error');
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
$recharge = $_GPC['recharge'];
$bet = $_GPC['bet'];
$red = $_GPC['red'];
$member_id = $_GPC['member_id'];
$give = $_GPC['give'];
$auto_add = $_GPC['auto_add'];
$status = $_GPC['status'];
$show_amount = $_GPC['show_amount'];
$auto_recharge = $_GPC['auto_recharge'];
$auto_value = $_GPC['auto_value'];
$mobile = $_GPC['mobile'];
$has_false = $_GPC['has_false'];
$false_price = $_GPC['false_price'];

$member = pdo_fetch('select * from '.tablename('member_system_member').' where id=:id',array(':id'=>$member_id));
$minus_all = 0;

if($password!=$repassword){
    message('确认密码不一致',referer(),'error');
}

$parent = pdo_fetch('select * from '.tablename('agent_member').' where id=:id',array(':id'=>$member['parent_agent']));
if ($recharge > $parent['credit1']) {
    message('上线积分不足',referer(),'error');
}
if (strpos($recharge,'-') !== false) {
    if (str_replace('-','',$recharge) > $member['credit1']) {
        message('扣分大于现有积分',referer(),'error');
        exit;
    }
    $save['credit1'] = $member['credit1']-str_replace('-','',$recharge)>0?$member['credit1']-str_replace('-','',$recharge):0;
    $surplus = $member['credit1']-str_replace('-','',$recharge);
    $child_standard = $member['credit2']/($_GPC['give']/100);
    if ($surplus <= $child_standard && (int)$surplus >= 0) {
        $child_cerdit = $member['credit2']-($child_standard-$surplus)*($_GPC['give']/100);
        $save['credit2'] = $child_cerdit>0?$child_cerdit:0;
    }
    else{
        $save['credit2'] = 0;
        $minus_all = 1;
    }
}
else{
    $save['credit1'] = $member['credit1']+$recharge;
    $save['credit2'] = $member['credit2']+$recharge*$give/100;   
}

if ($member['nickname'] != $nickname) {
	$save['nickname'] = $nickname;
}

if ($member['pay_limit'] != $limit) {
	$save['pay_limit'] = $limit;
}

if ($member['bet_limit'] != $bet) {
	$save['bet_limit'] = $bet;
}

if ($member['auto_recharge'] != $auto_recharge) {
    $save['auto_recharge'] = $auto_recharge;
}

if ($member['auto_value'] != $auto_value) {
    $save['auto_value'] = $auto_value;
}

if ($member['give'] != $give) {
    $save['give'] = $give;
}

if ($member['show_amount'] != $show_amount) {
    $save['show_amount'] = $show_amount;
}

if ($member['mobile'] != $mobile) {
    $save['mobile'] = $mobile;
}

if ($member['auto_add'] != $auto_add) {
    $save['auto_add'] = $auto_add;
}

if ($member['has_false'] != $has_false) {
    $save['has_false'] = $has_false;
}

if ($member['false_price'] != $false_price) {
    $save['false_price'] = $false_price;
}

if (!empty($password)) {
	$save['password'] = md5(md5(($password)));
}

if (!empty($save)) {
	pdo_update('member_system_member',$save,array('id'=>$member_id));
}

if ($minus_all == 1) {
    pdo_update('agent_member',array('credit1'=>$parent['credit1']+$member['credit1']),array('id'=>$parent['id']));
}
else{
    pdo_update('agent_member',array('credit1'=>$parent['credit1']-$recharge),array('id'=>$parent['id']));
}

foreach ($red as $rd) {
    $new_red[$rd['rule']] = $rd['value'];
}

$has_red = pdo_fetchcolumn('select count(*) from '.tablename('manji_member_red').' where user_id=:member',array(':member'=>$member_id));
if (!empty($has_red)) {
    pdo_update('manji_member_red',array('red_limit'=>json_encode($new_red)),array('user_id'=>$member_id));
}
else{
    pdo_insert('manji_member_red',array('user_id'=>$member_id,'red_limit'=>json_encode($new_red)));
}

pdo_delete('manji_member_odds',array('member_id'=>$member_id));
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
$operation = array(
    'user_id' => $new_id,
    'user_type' => 2,
    'create_time' => time(),
    'operation' => $operator.'修改了会员'.$nickname
);

pdo_insert('agent_operation',$operation);
message('操作成功',referer(),'success');


 ?>