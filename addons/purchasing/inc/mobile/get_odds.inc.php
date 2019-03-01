<?php 
global $_W,$_GPC;

$user_id = $_SESSION['mid'];

$id = $_GPC['id'];
$oid = $_GPC['oid'];
$member_id = $_GPC['member_id'];
$agent_id = $_GPC['agent_id'];

if (empty($user_id)) {
	$data = array(
		'status' => 3,
		'info' => '请先登录'
	);
	echo json_encode($data);
	exit;
}

if (!empty($oid)) {
	$odds = pdo_fetch('select * from '.tablename('manji_odds').' where id=:id',array(':id'=>$oid));
}
else{
	$odds = pdo_fetch('select o.*,a.id as pid from '.tablename('agent_odds').' a left join '.tablename('manji_odds').' o on o.id=a.pid where a.id=:id',array(':id'=>$id));
}
if (!empty($member_id)) {
	$commission = pdo_fetchcolumn('select commission from '.tablename('manji_member_odds').' where member_id=:member and pid=:pid',array(':member'=>$member_id,':pid'=>$odds['pid']));
	$commission = json_decode($commission,true);
}
if (!empty($agent_id)) {
	$cashback = gettotalCash($agent_id,$odds['id']);
}
else{
	$cashback = json_decode($odds['commission'],true);
}
foreach ($odds as $key => $value) {
	if ($key != 'agent_id' && $key != 'id' && $key != 'title') {
		$odd = explode('|',$value);
		$list[$key] = $odd;
	}
}

$data = array(
	'status' => 1,
	'list' => $list,
	'commission' => $commission,
	'cashback' => $cashback,
	'id' => $id
);
echo json_encode($data);
exit;



 ?>