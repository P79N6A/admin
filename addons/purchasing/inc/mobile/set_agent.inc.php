<?php 
global $_W,$_GPC;
$manager = $_SESSION['mid'];
if (empty($manager)) {
    message('请先登录',$this->createMobileUrl('login'),'unlog');
}
$manager_status = pdo_fetchcolumn('select status from '.tablename('agent_member').' where id=:id',array(':id'=>$manager));
if ($manager_status == 1) {
    message('您的账号已经被禁用无法对会员进行修改',referer(),'error');
    exit;
}

$operator = pdo_fetchcolumn('select nickname from '.tablename('agent_member').' where id=:id',array(':id'=>$manager));


$agent_id = $_GPC['agent_id'];
$nickname = $_GPC['nickname'];
$password = $_GPC['password'];
$repassword = $_GPC['repassword'];
$bonus = $_GPC['percent']?$_GPC['percent']:0;
$recharge = $_GPC['recharge']?$_GPC['recharge']:0;
$odds = $_GPC['odds']?$_GPC['odds']:array();
$eat = $_GPC['eat'];
$limit = $_GPC['limit'];
$bet = $_GPC['bet'];
$commission = $_GPC['commission'];
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

$member = pdo_fetch('select * from '.tablename('agent_member').' where id=:id',array(':id'=>$agent_id));
$parent = pdo_fetch('select * from '.tablename('agent_member').' where id=:id',array(':id'=>$member['parent_agent']));
if ($manager != $member['parent_agent'] && $_SESSION['cid'] >= 5) {
    message('权限不足，无法更改',referer(),'error');
    exit;
}

if(empty($nickname)){
    message('请填写昵称',referer(),'error');
    exit;
}

$old_bonus = pdo_fetchcolumn('select bonus_percent from '.tablename('agent_percent').' where agent_id=:id',array(':id'=>$member['parent_agent']));

if ($jb_percent > $old_bonus && $parent['level'] >=5) {
    message('花红比不能比上线大',referer(),'error');
    exit;
}

$percent = array(
    'bonus_percent' => $jb_percent
);

$data['nickname'] = $nickname;
if (empty($agent_id)) {
    if(!check_account($account)){
        message('账号格式错误',referer(),'error');
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
}


if (empty($eat)) {
    message('请填写吃字控制',referer(),'error');
    exit;
}

if (!empty($password)) {
	$save['password'] = md5(md5($password));
}
if ($nickname != $member['nickname']) {
	$save['nickname'] = $nickname;
}

if ($recharge > $parent['credit1'] && $parent['level'] >=5) {
	message('上线积分不足',referer(),'error');
	exit;
}
if (strpos($recharge,'-') == true) {
    $save['credit1'] = $member['credit1']-str_replace('-','',$recharge);
}
else{
    $save['credit1'] = $member['credit1']+$recharge;   
}

if ($auto_recharge != $member['auto_recharge']) {
    $save['auto_recharge'] = $auto_recharge;
}
if ($auto_value != $member['auto_value']) {
    $save['auto_value'] = $auto_value;
}

if ($limit != $member['pay_limit']) {
	$save['pay_limit'] = $limit;
}

if ($bet != $member['child_limit']) {
	$save['child_limit'] = $bet;
}

if ($jb_bonus != $member['jb_bonus']) {
    $save['jb_bonus'] = $jb_bonus;
}

if ($auto_create != $member['auto_create']) {
    $save['auto_create'] = $auto_create;
}

if ($all_line != $member['all_line']) {
    $save['all_line'] = $all_line;
}

if ($status != $member['status']) {
    $save['status'] = $status;
}

if (!empty($save)) {
	pdo_update('agent_member',$save,array('id'=>$agent_id));
}

if (!empty($recharge)) {
    if (strpos($recharge,'-') == true) {
        pdo_update('agent_member',array('credit1'=>$parent['credit1']+str_replace('-','',$recharge)),array('id'=>$member['parent_agent']));
    }
    else{
        pdo_update('agent_member',array('credit1'=>$parent['credit1']-$recharge),array('id'=>$member['parent_agent']));
    }
}

foreach ($red as $rd) {
    $new_red[$rd['rule']] = $rd['value'];
}

pdo_update('agent_red',array('red_limit'=>json_encode($new_red)),array('agent_id'=>$agent_id));

foreach ($eat as $ky => $val) {
    $eat_new[$val['id']] = $val['detail'];
}

pdo_update('agent_eat',array('eat'=>json_encode($eat_new),'percent'=>$bonus,'has_eat'=>$has_eat,'has_bonus'=>$has_bonus),array('agent_id'=>$agent_id));

if (count($odds) > 0) {
    $odds_fields = implode(',',$odds);
    $odds_ids = pdo_fetchColumnValue('select pid from '.tablename('agent_odds').' where pid in ('.$odds_fields.') and agent_id=:agent_id',array(':agent_id'=>$agent_id),'pid');
}
else{
    $odds_ids = array();
}
pdo_update('agent_percent',$percent,array('id'=>$agent_id));
$old_odds = pdo_fetchColumnValue('select pid from '.tablename('agent_odds').' where agent_id=:id',array(':id'=>$agent_id),'pid');
if (!empty($old_odds)) {
    $same = array_intersect($old_odds,$odds);
    $diff = array_diff($old_odds,$odds);
}
if (!empty($same)) {
    foreach ($same as $key => $value) {
        foreach ($commission as $k => $v) {
            if ($value == $v['id']) {
                pdo_update('agent_odds',array('commission'=>json_encode($v['detail'])),array('pid'=>$value,'agent_id'=>$agent_id));
            }
        }
        foreach ($cashback as $cash) {
            if ($value == $cash['id']) {
                pdo_update('agent_odds',array('cashback'=>json_encode($cash['detail'])),array('pid'=>$value,'agent_id'=>$agent_id));
            }
        }
    }
}
if (!empty($diff)) {
    $diff_fields = implode(',',$diff);
    $has = pdo_fetchcolumn('select count(*) from '.tablename('manji_member_odds').' m left join '.tablename('agent_odds').' a on a.id=m.pid where a.agent_id=:id and a.pid in ('.$diff_fields.')',array(':id'=>$agent_id));
    $agent_has = pdo_fetchcolumn('select count(a.id) from '.tablename('agent_odds').' a left join '.tablename('agent_member').' m on m.id=a.agent_id where m.parent_agent=:id and pid in ('.$diff_fields.')',array(':id'=>$agent_id));
    $count = $has+$agent_has;
    if ($count > 0) {
        $data = array(
            'status' => 2,
            'info' => '有人使用该配套，无法取消分享'
        );
        echo json_encode($data);
        exit;
    }

}
if (!empty($odds_fields)) {
    $condition = ' and pid not in ('.$odds_fields.')';
}

$res1 = pdo_query('delete from '.tablename('agent_odds').' where agent_id=:agent_id'.$condition,array(':agent_id'=>$agent_id));
foreach ($odds as $key => $value) {
    if (!in_array($value,$odds_ids)) {
        $odd_save = array(
            'pid' => $value,
            'agent_id' => $agent_id
        );
        foreach ($commission as $k => $v) {
            if ($value == $v['id']) {
                $odd_save['commission'] = json_encode($v['detail']);
            }
        }
        foreach ($cashback as $cash) {
            if ($value == $cash['id']) {
                $odd_save['cashback'] = json_encode($cash['detail']);
            }
        }
        pdo_insert('agent_odds',$odd_save);
    }
}

$operation = array(
    'user_id' => $new_id,
    'user_type' => 1,
    'operation' => $operator.'对'.$member['nickname'].'进行了修改',
    'create_time' => time()
);

pdo_insert('agent_operation',$operation);
pdo_update('agent_member',array('last_edit_time'=>time()),array('id'=>$agent_id));

message('保存成功',$this->createMobileUrl('manager',array('op'=>'display','agent_id'=>$member['parent_agent'])),'success');
exit;

 ?>