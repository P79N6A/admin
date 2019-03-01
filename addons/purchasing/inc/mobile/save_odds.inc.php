<?php 
global $_W,$_GPC;

$op = $_GPC['op'];
$user_id = $_SESSION['uid'];

if ($op == 'manager') {
	$user_id = $_SESSION['mid'];
}

if (empty($user_id)) {
	$data = array(
		'status' => 3,
		'info' => '请先登录'
	);
	echo json_encode($data);
	exit;
}

$odds = $_GPC['odds'];
$title = $_GPC['title'];
if (empty($title)) {
	$data = array(
		'status' => 2,
		'info' => '请填写配置名称'
	);
	echo json_encode($data);
	exit;
}

$oddsData = array(
	'title' => $title,
	'agent_id' => $user_id,
	'odds_A' => $odds['A'][0],
	'odds_C2' => $odds['A'][1],
	'odds_C3' => $odds['A'][2],
	'odds_C4' => $odds['A'][3],
	'odds_C5' => $odds['A'][4],
	'odds_EC' => $odds['A'][5],
	'odds_4A' => $odds['4A'][0],
	'odds_4B' => $odds['4A'][1],
	'odds_4C' => $odds['4A'][2],
	'odds_4D' => $odds['4A'][3],
	'odds_4E' => $odds['4A'][4],
	'odds_EA' => $odds['4A'][5],
	'odds_2A' => $odds['2A'][0],
	'odds_2B' => $odds['2A'][1],
	'odds_2C' => $odds['2A'][2],
	'odds_2D' => $odds['2A'][3],
	'odds_2E' => $odds['2A'][4],
	'odds_EX' => $odds['2A'][5]
);

foreach ($odds as $k => $odd){
    if ($k == 'B' || $k == 'S' || $k == '3ABC' || $k == '4ABC' || $k == '2ABC') {
    	$odd = implode('|',$odd);
    	$oddsData["odds_{$k}"] = $odd;
    }
}

$res = pdo_insert('agent_odds',$oddsData);
$data = array(
	'status' => 1,
	'info' => '保存成功'
);
echo json_encode($data);
exit;






 ?>