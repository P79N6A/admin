<?php 
ignore_user_abort (true);
set_time_limit (30);
require '../../framework/bootstrap.inc.php';
$period = pdo_fetchall('select id from '.tablename('manji_run_setting').' where date=:date and cid=1',array(':date'=>date('Y-m-d',time())));
$condition = '';
foreach ($period as $key => $value) {
	if ($key == 0) {
		$condition .= ' where period_id like \'%('.$value['id'].')%\' ';
	}
	$condition .= ' or period_id like \'%('.$value['id'].')%\' ';
}
$number_bet = pdo_fetchall('select sum(pay_B+pay_S+pay_A+pay_C2+pay_C3+pay_C4+pay_C5+pay_3ABC+pay_EC+pay_4A+pay_4B+pay_4C+pay_4D+pay_4E+pay_4ABC+pay_EA+pay_2A+pay_2B+pay_2C+pay_2D+pay_2E+pay_2ABC+pay_EX) as amount,number from '.tablename('manji_order_detail').$condition.' group by number');

$line = file_get_contents('limit_line.txt');
$sql = '';

foreach ($number_bet as $val) {
	if ($val['amount'] > floatval($line)) {
		$sql .= 'insert '.tablename('manji_control').' set number='.$val['number'].',type=0,date=\''.date('Y-m-d',time()).'\';';
	}
	else{
		$sql .= 'insert '.tablename('manji_control').' set number='.$val['number'].',type=1,date=\''.date('Y-m-d',time()).'\';';
	}
}
if (!empty($sql)) {
	pdo_query($sql);
}



 ?>