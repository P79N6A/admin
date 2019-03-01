<?php 
global $_W,$_GPC;

$member_id = $_GPC['member_id'];
$date = $_GPC['date']?$_GPC['date']:date('Y-m-d',time());
$user_type = $_GPC['user_type'];
$open_time = pdo_fetchall('select p.endtime,c.nickname from '.tablename('manji_preinstall_time').' p left join '.tablename('manji_company').' c on c.id=p.cid where aid=0');

if ($user_type == 2) {
	$list = pdo_fetchall('select id,cid,pid,number,play_type,status,mode,createtime from '.tablename('manji_order').' where user_id=:user_id and pid>0 and createtime between :start and :end order by createtime desc',array(':user_id'=>$member_id,':start'=>strtotime($date.' 00:00:00'),':end'=>strtotime($date.' 23:59:59')));
	foreach ($list as $key => $value) {
		$amount = array();
		$list[$key]['uordersn'] = pdo_fetchcolumn('select uordersn from '.tablename('manji_order').' where id=:id',array(':id'=>$value['pid']));
		if (strlen($value['number']) == 5) {
			$rules = array('5D');
		}
		elseif (strlen($value['number']) == 6) {
			$rules = array('6D');
		}
		else{
			$rule = pdo_fetch('select * from '.tablename('manji_rules').' where id=:id',array(':id'=>$value['play_type']));
			$rules = explode(',', $rule['content']);
		}
		foreach ($rules as $k => $v) {
			$oa = pdo_fetchcolumn('select (pay_'.$v.'*(100+false_price)/100) from '.tablename('manji_order').' where id=:id',array(':id'=>$value['id']));
			$amount[] = round($oa,2);
		}
		$company = str_replace('(','',$value['cid']);
		$company = str_replace(')','',$company);
		$com = pdo_fetchColumnValue('select nickname from '.tablename('manji_company').' where id in ('.$company.')',array(),'nickname');
		$list[$key]['company'] = implode('',$com);
		$list[$key]['rule'] = implode(',',$rules);
		$list[$key]['amount'] = implode('-',$amount);
	}
}

include $this->template('user_order_detail');

 ?>