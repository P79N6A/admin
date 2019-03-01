<?php 
global $_W,$_GPC;

$mid = $_SESSION['mid'];
if (empty($mid)) {
	message('请先登录',$this->createMobileUrl('login'),'error');
}

$op = $_GPC['op'];

if ($op == 'post') {
	$id = $_GPC['id'];
	$limit = $_GPC['limit'];
	$title = $_GPC['title'];
	$same = $_GPC['same'];
	if ($_SESSION['level'] > 1) {
		$condition = ' where id<>1';
	}

	if (!empty($same)) {
		$first = pdo_fetchcolumn('select min(id) from '.tablename('manji_company').$condition);
		foreach ($limit as $key => $value) {
			$limit[$key] = $limit[$first];
		}
	}

	$save = array(
		'title' => $title,
		'limit' => json_encode($limit),
		'edittime' => time()
	);

	if (empty($id)) {
		$save['cid'] = $_SESSION['cid'];
		$save['createtime'] = time();
		pdo_insert('manji_limit',$save);
	}
	else{
		pdo_update('manji_limit',$save,array('id'=>$id));
	}

	message('保存成功',$this->createMobileUrl('manager',array('op'=>'limit')),'success');
	exit;
}

if ($op == 'del') {
	$id = $_GPC['id'];

	$system_used = pdo_fetchcolumn('select count(id) from '.tablename('manji_limit_time').' where `limit`=:id',array(':id'=>$id));
	$user_used = pdo_fetchcolumn('select count(id) from '.tablename('member_system_member').' where bet_limit=:id',array(':id'=>$id));
	$agent_used = pdo_fetchcolumn('select count(id) from '.tablename('agent_member').' where child_limit=:id',array(':id'=>$id));
	if ($system_used > 0 || $user_used > 0 || $agent_used > 0) {
		message('该控制配套仍在使用，无法删除',referer(),'error');
	}

	pdo_delete('manji_limit',array('id'=>$id));

	message('删除成功',$this->createMobileUrl('manager',array('op'=>'limit')),'success');
}

if ($op == 'time_post') {
	$limit = $_GPC['limit'];
	if ($_SESSION['cid'] > 0) {
		pdo_delete('manji_limit_time',array('cid'=>$_SESSION['cid']));
		foreach ($limit as $key => $value) {
			$save = array(
				'time' => $value['time'],
				'limit' => $value['limit'],
				'cid' => $_SESSION['cid']
			);
			pdo_insert('manji_limit_time',$save);
		}
	}
	else{
		pdo_delete('manji_limit_time');
		foreach ($limit as $key => $value) {
			$save = array(
				'time' => $value['time'],
				'limit' => $value['limit'],
				'cid' => $value['cid']
			);
			pdo_insert('manji_limit_time',$save);
		}
	}
	

	message('保存成功',referer(),'success');
}

if ($op == 'red_post') {
	$number = explode(',',$_GPC['number']);
	$same = $_GPC['same'];
	$limit = $_GPC['limit'];
	$mode = $_GPC['mode'];
	$type = $_GPC['type'];
	$cid = $_SESSION['cid']>0?$_SESSION['cid']:0;
	$for = array();
	foreach ($number as $k => $v) {
		$num = array();
		if ($mode == 0) {
			$num[] = $v;
		}
		if ($mode == 1 || $mode == 2) {
			$num = sort_number($v);
		}
		if ($mode == 3) {
			for ($i=0; $i < 10; $i++) { 
				$num[] = $i.substr($v,1);
			}
		}
		if ($mode == 4) {
			for ($i=0; $i < 10; $i++) { 
				$num[] = substr($v,0,strlen($v)-1).$i;
			}
		}
		$for = array_merge($for,$num);
	}
	pdo_begin();
	if ($_SESSION['level'] > 1) {
		$condition = ' where id<>1 ';
	}
	foreach ($for as $ky => $val) {
		if (!empty($same)) {
			$first = pdo_fetchcolumn('select min(id) from '.tablename('manji_company').$condition);
			foreach ($limit as $key => $value) {
				$limit[$key] = $limit[$first];
			}
		}
		$has = pdo_fetchcolumn('select count(id) from '.tablename('manji_red_number').' where number=:number and type=:type and cid=:cid',array(':type'=>$type,':number'=>$val,':cid'=>$cid));
		if ($has > 0) {
			pdo_rollback();
			message($val.'已添加',referer(),'error');
			exit;
		}
		else{
			$save = array(
				'number' => $val,
				'cid' => $cid,
				'bet_limit' => json_encode($limit),
				'mode' => $mode,
				'type' => $type,
				'createtime' => time()
			);
			pdo_insert('manji_red_number',$save);
		}
	}
	pdo_commit();
	message('保存成功',$this->createMobileUrl('manager',array('op'=>'limit','tab'=>'red')),'success');
}

if ($op == 'red_del') {
	$id = $_GPC['id'];
	pdo_delete('manji_red_number',array('id'=>$id));
	message('删除成功',referer(),'success');
}

if ($op == 'red_array_del') {
	$id = $_GPC['id'];
	$ids = implode(',', $id);
	pdo_query('delete from '.tablename('manji_red_number').' where id in ('.$ids.')');
	message('删除成功',referer(),'success');
}

if ($op == 'get_limit') {
	if ($_SESSION['cid'] > 0) {
		$condition = ' where cid='.$_SESSION['cid'];
	}
	$area = pdo_fetchall('select id,area_name from '.tablename('manji_area').' order by id asc');
	$list = pdo_fetchall('select id,title from '.tablename('manji_limit').$condition.' order by createtime desc');
	$result = array(
		'area' => $area,
		'list' => $list
	);
	echo json_encode($result);
	exit;
}


 ?>