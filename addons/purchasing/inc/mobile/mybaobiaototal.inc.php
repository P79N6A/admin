<?php 
global $_W,$_GPC;

$user_id = $_SESSION['uid'];

if (empty($user_id)) {
	message('请先登录',$this->createMobileUrl('login'),'error');
}

$list =  pdo_fetchall('select id,periods,date from '.tablename('manji_run_setting') .' order by date desc ');

include $this->template('mytotalnum');







 ?>