<?php 
global $_W,$_GPC;

$manager = $_SESSION['mid'];

if (empty($manager)) {
	$data = array(
		'status' => 3,
		'info' => '请先登录'
	);
	echo json_encode($data);
	exit;
}
$member_id = $_GPC['member_id'];
$parent_id = pdo_fetchcolumn('select parent_agent from '.tablename('member_system_member').' where id=:id',array(':id'=>$member_id));
$status = pdo_fetchcolumn('select status from '.tablename('member_system_member').' where id=:id',array(':id'=>$member_id));
$odds = $_GPC['odds'];
$nickname = pdo_fetchcolumn('select nickname from '.tablename('member_system_member').' where id=:id',array(':id'=>$member_id));
if ($status == 1) {
	$data = array(
		'status' => 2,
		'info' => '该用户已禁用，无法操作'
	);
	echo json_encode($data);
	exit;
}
if ($_SESSION['level'] == 1) {
    $operator = '管理员';
}
else{
    $operator = pdo_fetchcolumn('select nickname from '.tablename('agent_member').' where id=:id',array(':id'=>$manager));
}

$used_odds = $_GPC['used_odds'];


pdo_delete('manji_member_odds',array('member_id'=>$member_id));
foreach ($odds as $key => $value) {
	$oddsData = $value['odds'];

	foreach ($value['odds'] as $k => $odd){
	    if ($k == 'odds_B' || $k == 'odds_S' || $k == 'odds_3ABC' || $k == 'odds_4ABC' || $k == 'odds_2ABC' || $k == 'odds_5D' || $k == 'odds_6D') {
	    	$odd = implode('|',$odd);
	    	$oddsData[$k] = $odd;
	    }
	    elseif ($k == 'commission') {
	    	$odd = json_encode($odd);
	    	$oddsData[$k] = $odd;
	    }
	    elseif (is_array($odd)) {
	    	$oddsData[$k] = $odd[0];
	    }
	    else{
	    	$oddsData[$k] = $odd;
	    }
	}
	$oddsData['member_id'] = $member_id;
	$oddsData['cid'] = $value['cid'];
	$oddsData['pid'] = $value['id'];
	$res = pdo_insert('manji_member_odds',$oddsData);
}

if ($res) {
	pdo_update('member_system_member',array('commission'=>json_encode($save_com),'used_odds'=>implode(',', $used_odds)),array('id'=>$member_id));
	$operation = array(
        'user_id' => $member_id,
        'user_type' => 2,
        'operation' => $operator.'对'.$nickname.'进行了赔率设置',
        'create_time' => time()
    );
    pdo_insert('agent_operation',$operation);
    pdo_update('member_system_member',array('last_edit_time'=>time()),array('id'=>$member_id));
}
$data = array(
	'status' => 1,
	'info' => '保存成功'
);
echo json_encode($data);
exit;





 ?>