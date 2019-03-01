<?php 
global $_W,$_GPC;

// $ip = getip();
// $area = get_area($ip);
// if ($area['data']['country'] == '中国') {
//     $result = array(
//     	'status' => 300,
//     	'info' => '该地区无法访问'
//     );
//     echo json_encode($result);
//     exit;
// }

// $time = pdo_fetchcolumn('select endtime from '.tablename('manji_run_setting').' where cid=1 and date=:date',array(':date'=>date('Y-m-d',time())));

// if ($time > time()) {
// 	$result = array(
// 		'status' => 200,
// 		'info' => ''
// 	);
// }
// else{
// 	$result = array(
// 		'status' => 300,
// 		'info' => '未到开彩时间'
// 	);
// }

echo json_encode($result);
exit;


 ?>