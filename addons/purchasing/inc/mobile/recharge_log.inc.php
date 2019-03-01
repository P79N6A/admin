<?php 
global $_W,$_GPC;
$user_id = $_SESSION['uid'];

$page = $_GPC['page']>0?$_GPC['page']:1;
$psize = 30;
$stime = $_GPC['stime']?$_GPC['stime']:'1970-01-01 00:00:00';
$etime = $_GPC['etime']?$_GPC['etime']:date('Y-m-d 23:59:59',time());
$keyword = $_GPC['keyword'];
$op = $_GPC['op']?$_GPC['op']:'display';
$where = array(':agent'=>$user_id);

$manager = pdo_fetch('select * from '.tablename('agent_member').' where id=:id',array(':id'=>$user_id));

if (!empty($keyword)) {
	$condition = ' and (m.nickname like :keyword or m.account like :key) ';
	$where[':keyword'] = '%'.$keyword.'%';
	$where[':key'] = '%'.$keyword.'%';
}

if (!empty($stime) || !empty($etime)) {
	$time_condition = ' and r.create_time>=:start and r.create_time<=:end ';
	$where[':start'] = strtotime($stime);
	$where[':end'] = strtotime($etime);
}

if ($op == 'display') {
	$list = pdo_fetchall('select r.*,m.id,m.nickname,m.account from '.tablename('agent_recharge'). ' r left join '.tablename('agent_member').' m on r.to_user = m.id where r.from_user=:agent and r.user_type=1 '.$condition.$time_condition.' order by r.create_time desc limit '.($page-1)*$psize.",{$psize}",$where);
}
if ($op == 'member') {
	$list = pdo_fetchall('select r.*,m.id,m.nickname,m.account from '.tablename('agent_recharge'). ' r left join '.tablename('member_system_member').' m on r.to_user = m.id where r.from_user=:agent and r.user_type=1 '.$condition.$time_condition.' order by r.create_time desc limit '.($page-1)*$psize.",{$psize}",$where);
}
if (!empty($list)) {
	foreach ($list as &$value) {
		$value['create_time'] = date('Y-m-d H:i:s',$value['create_time']);
	}
}



include $this->template('recharge_log');


 ?>