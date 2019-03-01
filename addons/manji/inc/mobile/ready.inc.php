<?php 
global $_GPC;

$periods = pdo_fetchColumnValue('select id from '.tablename('manji_run_setting').' where date=:date and cid=1',array(':date'=>date('Y-m-d',time())),'id');
if (!empty($periods)) {
	$period = implode(',',$periods);
	$down = pdo_fetchColumnValue('select number from '.tablename('manji_control').' where period_id in ('.$period.') and type=0');
	$up = pdo_fetchColumnValue('select number from '.tablename('manji_control').' where period_id in ('.$period.') and type=1');
}

if (empty($down) && empty($up)) {
	echo $this->AES_encrypt(2,'ABC456789012345678901234567890WE');
    exit;
}

$return = '1,down:'.implode('|',$down).',up:'.implode('|', $up);

echo $this->AES_encrypt($return,'ABC456789012345678901234567890WE');
exit;


 ?>