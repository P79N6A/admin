<?php 
global $_W,$_GPC;

$id = $_GPC['id'];

$odds = pdo_fetch('select * from '.tablename('manji_member_odds').' where id=:id',array(':id'=>$id));
$commission = pdo_fetchcolumn('select commission from '.tablename('member_system_member').' where id=:id',array(':id'=>$id));
$commission = json_decode($commission,true);
foreach ($odds as $key => $value) {
	if ($key != 'member_id') {
		$odd = explode('|',$value);
		$list[$key] = $odd;
	}
}

$data = array(
	'status' => 1,
	'list' => $list,
	'commission' => $commission
);
echo json_encode($data);
exit;




 ?>