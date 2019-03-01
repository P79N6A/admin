<?php 
global $_W,$_GPC;

$member_id = $_COOKIE['uid'];
if (empty($member_id)) {
	header('Location:'.$this->createMobileUrl('login'));
}
$member = pdo_fetch('select * from '.tablename('member_system_member').' where id=:id',array(':id'=>$member_id));
$date = $_GPC['date']?$_GPC['date']:date('Y-m-d',time());
$list = pdo_fetchall('select c.nickname,r.first_no,r.second_no,r.third_no,r.consolation_no,r.special_no,s.id,s.cid,r.result_5D,r.result_6D from '.tablename('manji_run_setting').' s left join '.tablename('manji_company').' c on c.id=s.cid left join '.tablename('manji_lottery_record').' r on r.period_id=s.id where s.date=:date and s.aid=:cid',array(':date'=>$date,':cid'=>$member['cid']));
foreach ($list as $key => $value) {
	$D5 = pdo_fetch('select * from '.tablename('manji_new_odds').' where type=1 and cid like \'%('.$value['cid'].')%\'');
	if (!empty($D5)) {
		$list[$key]['5D'] = $value['result_5D']?explode('|',$value['result_5D']):array('','','','','','');
	}
	$D6 = pdo_fetch('select * from '.tablename('manji_new_odds').' where type=2 and cid like \'%('.$value['cid'].')%\'');
	if (!empty($D6)) {
		$list[$key]['has_6D'] = 1;
		$list[$key]['6D'] = $value['result_6D'];
	}
	$list[$key]['consolation_no'] = $value['consolation_no']?explode('|',$value['consolation_no']):array('','','','','','','','','','');
	$list[$key]['special_no'] = $value['special_no']?explode('|',$value['special_no']):array('','','','','','','','','','');
}



include $this->template('reward');


 ?>