<?php 
global $_W,$_GPC;

$manager = $_SESSION['mid'];
if (empty($manager)) {
    $data = array(
        'status' => 3,
        'info'   => '请先登录',
    );
    echo json_encode($data);
    exit();
}

$user_id = $_GPC['user_id'];
$agent_id = $_GPC['agent_id'];
$cashback = $_GPC['cashback'];
$bonus = $_GPC['bonus'];
if (!empty($manager)) {
    $jackpot = $_GPC['jackpot'];
}
$commission = $_GPC['commission'];
$odds = $_GPC['odds']?$_GPC['odds']:array();


$parent = pdo_fetch('select parent_agent from '.tablename('agent_member').' where id=:id',array(':id'=>$agent_id));
$has_one = pdo_fetch('select * from '.tablename('agent_percent').' where agent_id=:id',array(':id'=>$agent_id));
$agent = pdo_fetchcolumn('select count(id) from '.tablename('agent_member').' where id=:id',array(':id'=>$agent_id));
$parent_percent = pdo_fetchcolumn('select bonus_percent from '.tablename('agent_percent').' where agent_id=:id',array(':id'=>$parent['parent_agent']));
$parent = pdo_fetch('select * from '.tablename('agent_member').' where id=:id',array(':id'=>$parent['parent_agent']));

if ($agent == 0) {
	$data = array(
        'status' => 2,
        'info'   => '该下线代理不存在',
    );
    echo json_encode($data);
    exit();
}

if (!empty($has_one)) {
	if ($has_one['cashback_percent'] != json_encode($cashback)) {
		$save['cashback_percent'] = json_encode($cashback);
	}
    $save['bonus_percent'] = $bonus;
    if ($bonus > $parent_percent && $parent['level'] == 5) {
        $data = array(
            'status' => 2,
            'info' => '花红不能大于上线'
        );
        echo json_encode($data);
        exit;
    }
    if (!empty($manager)) {
        $save['jackpot_percent'] = $jackpot;
        
    }
	$res = pdo_update('agent_percent',$save,array('agent_id'=>$agent_id));
}
else{
	$save = array(
		'agent_id' => $agent_id,
		'cashback_percent' => json_encode($cashback),
	);
    $save['bonus_percent'] = $bonus;
    if (!empty($manager)) {
        $save['jackpot_percent'] = $jackpot;
        
    }

	$res = pdo_insert('agent_percent',$save);
}
$parent_id = pdo_fetchcolumn('select parent_agent from '.tablename('agent_member').' where id=:id',array(':id'=>$agent_id));
$nickname = pdo_fetchcolumn('select nickname from '.tablename('agent_member').' where id=:id',array(':id'=>$agent_id));
if($_SESSION['level'] == 1) {
    $operator = '管理员';
}
else{
    $operator = pdo_fetchcolumn('select nickname from '.tablename('agent_member').' where id=:id',array(':id'=>$manager));
}

if($res!==false){
    $operation = array(
        'user_id' => $agent_id,
        'user_type' => 1,
        'operation' => $operator.'对'.$nickname.'进行了百分比设置',
        'create_time' => time()
    );
    if (count($odds) > 0) {
        $odds_fields = implode(',',$odds);
        $odds_ids = pdo_fetchColumnValue('select pid from '.tablename('agent_odds').' where pid in ('.$odds_fields.') and agent_id=:agent_id',array(':agent_id'=>$agent_id),'pid');
    }
    else{
        $odds_ids = array();
    }
    $old_odds = pdo_fetchColumnValue('select pid from '.tablename('agent_odds').' where agent_id=:id',array(':id'=>$agent_id),'pid');
    $same = array_intersect($old_odds, $odds);
    $diff = array_diff($old_odds,$odds);
    if (!empty($same)) {
        foreach ($same as $key => $value) {
            foreach ($commission as $k => $v) {
                if ($value == $v['id']) {
                    pdo_update('agent_odds',array('commission'=>json_encode($v['detail'])),array('pid'=>$value,'agent_id'=>$agent_id));
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
            pdo_insert('agent_odds',$odd_save);
        }
    }
    pdo_insert('agent_operation',$operation);
    pdo_update('agent_member',array('last_edit_time'=>time()),array('id'=>$agent_id));
    $data['status'] = 1;
    $data['info'] = '操作成功';
    $data['res'] = $res1;
}else{
    $data['status'] = 2;
    $data['info'] = '操作失败';

}

echo json_encode($data);






 ?>