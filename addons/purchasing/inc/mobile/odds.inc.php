<?php 
global $_W,$_GPC;

$op = $_GPC['op'];

$manager = $_SESSION['mid'];

if (empty($manager)) {
	$data = array(
		'status' => 3,
		'info' => '请先登录'
	);
	echo json_encode($data);
	exit;
}
$open_time = pdo_fetchall('select p.endtime,c.nickname from '.tablename('manji_preinstall_time').' p left join '.tablename('manji_company').' c on c.id=p.cid where aid=0');

if ($op == 'detail') {
	$id = $_GPC['id'];
	$odds = pdo_fetch('select * from '.tablename('manji_odds').' where id=:id',array(':id'=>$id));
	if ($odds) {
		foreach ($odds as $key => $value) {
			if ($key == 'odds_B' || $key == 'odds_S' || $key == 'odds_3ABC' || $key == 'odds_4ABC' || $key == 'odds_2ABC' || $key == 'odds_5D' || $key == 'odds_6D') {
				$odds[$key] = explode('|',$value);
			}
			if ($key == 'cid') {
				$area_info = explode(',',$value);
				foreach ($area_info as &$val) {
					$val = str_replace('(','',$val);
					$val = str_replace(')','',$val);
				}
				$odds[$key] = $area_info;
			}
		}
		$odds['commission'] = json_decode($odds['commission'],true);
	}

	$data = array(
		'status' => 1,
		'list' => $odds
	);
	echo json_encode($data);
	exit;
}

if ($op == 'post') {
	$id = $_GPC['odds_id'];
	$odds = $_GPC['odds'];
	$cid = $_GPC['area_id']?$_GPC['area_id']:$_SESSION['cid'];
	$title = $_GPC['title'];
	$commission = $_GPC['commission'];
	$gid = $_GPC['gid'];

	$oddsData = array(
		'cid' => $cid,
		'title' => $title,
		'gid' => $gid,
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
		'odds_EX' => $odds['2A'][5],
		'commission' => json_encode($commission)
	);

	foreach ($odds as $k => $odd){
	    if ($k == 'B' || $k == 'S' || $k == '3ABC' || $k == '4ABC' || $k == '2ABC' || $k == '5D' || $k == '6D') {
	    	$odd = implode('|',$odd);
	    	$oddsData["odds_{$k}"] = $odd;
	    }
	}
	if (empty($id)) {
		$res = pdo_insert('manji_odds',$oddsData);
	}
	else{
		pdo_update('manji_odds',$oddsData,array('id'=>$id));
	}
	$data = array(
		'status' => 1,
		'info' => '保存成功'
	);
	echo json_encode($data);
	exit;
}

if ($op == 'del') {
	$id = $_GPC['id'];

	if (empty($id)) {
		$data = array(
			'status' => 2,
			'info' => '请选择要删除的配套'
		);
		echo json_encode($data);
		exit;
	}

	$agent = pdo_fetchcolumn('select count(id) from '.tablename('agent_odds').' where pid=:id',array(':id'=>$id));
	if ($agent > 0) {
		$data = array(
			'status' => 2,
			'info' => '有人在使用该配套，无法删除'
		);
		echo json_encode($data);
		exit;
	}

	$res = pdo_delete('manji_odds',array('id'=>$id));
	if ($res) {
		$data = array(
			'status' => 1,
			'info' => '删除成功'
		);
	}
	else{
		$data = array(
			'status' =>2,
			'info' => '删除失败'
		);
	}
	echo json_encode($data);
	exit;
}

if ($op == 'freeze') {
	$id= $_GPC['id'];
	$status = $_GPC['status'];
	if (empty($id)) {
		$data = array(
			'status' => 2,
			'info' => '请选择要操作的配套'
		);
		echo json_encode($data);
		exit;
	}
	if ($status == 1) {
		$res = pdo_update('manji_odds',array('status'=>2),array('id'=>$id));
	}
	else{
		$res = pdo_update('manji_odds',array('status'=>1),array('id'=>$id));

	}
	if ($res) {
		if ($status == 1) {
			pdo_update('agent_odds',array('status'=>2),array('pid'=>$id));
		}
		else{
			pdo_update('agent_odds',array('status'=>1),array('pid'=>$id));
		}
		$data = array(
			'status' => 1,
			'info' => '操作成功'
		);
	}
	else{
		$data = array(
			'status' =>2,
			'info' => '操作失败'
		);
	}
	echo json_encode($data);
	exit;
}

if ($op == 'new_post') {
	$id = $_GPC['id'];
	$company = $_GPC['company'];
	$first = $_GPC['first'];
	$secound = $_GPC['secound'];
	$third = $_GPC['third'];
	$fourth = $_GPC['fourth'];
	$fifth = $_GPC['fifth'];
	$sixth = $_GPC['sixth'];
	if (!empty($company)) {
		foreach ($company as &$value) {
			$value = '('.$value.')';
		}
		$save['cid'] = implode(',',$company);
	}
	if (!empty($first)) {
		$save['first'] = $first;
	}
	if (!empty($secound)) {
		$save['secound'] = $secound;
	}
	if (!empty($third)) {
		$save['third'] = $third;
	}
	if (!empty($fourth)) {
		$save['fourth'] = $fourth;
	}
	if (!empty($fifth)) {
		$save['fifth'] = $fifth;
	}
	if (!empty($sixth)) {
		$save['sixth'] = $sixth;
	}
	if (!empty($save)) {
		pdo_update('manji_new_odds',$save,array('id'=>$id));
	}
	$result = array(
		'status' => 1,
		'info' => '保存成功'
	);
	echo json_encode($result);
	exit;
}

if ($op == 'get_odds') {
	$id = $_GPC['id'];
	$agent_id = $_GPC['agent_id'];
	$member_id = $_GPC['member_id'];
	$member = pdo_fetch('select * from '.tablename('member_system_member').' where id=:id',array(':id'=>$member_id));
	if (empty($agent_id)) {
		$agent_id = $member['parent_agent'];
	}
	if ($_SESSION['cid']>0) {
		$id = $_SESSION['cid'];
	}

	$list = pdo_fetchall('select a.id,o.title,a.pid from '.tablename('agent_odds').' a left join '.tablename('manji_odds').' o on o.id=a.pid where o.cid = :id and a.agent_id=:agent',array(':id'=>$id,':agent'=>$agent_id));
	$member_odds = pdo_fetchall('select * from '.tablename('manji_member_odds').' where member_id=:member_id',array(':member_id'=>$member_id));
	foreach ($list as $key => $value) {
		foreach ($member_odds as $k => $v) {
			if ($value['id'] == $v['pid']) {
				$list[$key]['used'] = 1;
				foreach ($v as $ky => $val) {
					if ($ky != 'id' && $ky != 'member_id' && $ky != 'cid' && $ky != 'pid') {
						$list[$key]['odds'][$ky] = explode('|',$val);
					}
					else{
						$list[$key]['odds'][$ky] = $val;
					}
				}
				$list[$key]['odds']['commission'] = json_decode($v['commission']);
			}
		}
	}

	echo json_encode($list);
	exit;
}

if ($op == 'group_post') {
	$id = $_GPC['id'];
	$name = $_GPC['name'];
	if (empty($name)) {
		$result = array(
			'status' => 2,
			'info' => '请填写分组名'
		);
		echo json_encode($result);
		exit;
	}
	$old = pdo_fetchcolumn('select group_name from '.tablename('manji_odds_group').' where group_name=:name',array(':name'=>$name));
	if (!empty($old)) {
		$result = array(
			'status' => 2,
			'info' => '已有该分组名'
		);
		echo json_encode($result);
		exit;
	}
	if (empty($id)) {
		$save = array(
			'group_name' => $name,
			'createtime' => time()
		);
		pdo_insert('manji_odds_group',$save);
	}
	else{
		pdo_update('manji_odds_group',array('group_name'=>$name),array('id'=>$id));
	}
	$result = array(
		'status' => 1,
		'info' => '保存成功'
	);
	echo json_encode($result);
	exit;
}

if ($op == 'group_del') {
	$id = $_GPC['id'];
	$old = pdo_fetchcolumn('select count(id) from '.tablename('manji_odds_group').' where id=:id',array(':id'=>$id));
	if (empty($old)) {
		$result = array(
			'status' => 2,
			'info' => '未找到分组'
		);
		echo json_encode($result);
		exit;
	}
	$res = pdo_delete('manji_odds_group',array('id'=>$id));
	if ($res) {
		pdo_update('manji_odds',array('gid'=>0),array('gid'=>$id));
		$result = array(
			'status' => 1,
			'info' => '删除成功'
		);
	}
	else{
		$result = array(
			'status' => 2,
			'info' => '删除失败'
		);
	}
	echo json_encode($result);
	exit;
}

if ($op == 'get_agent_odds') {
	$agent_id = $_GPC['agent_id'];
	$id = $_GPC['id'];
	$odds = pdo_fetch('select * from '.tablename('manji_odds').' where id=:id',array(':id'=>$id));
	foreach ($odds as $key => $value) {
		if ($key != 'id' && $key != 'member_id' && $key != 'cid' && $key != 'pid') {
			$odds[$key] = explode('|',$value);
		}
		else{
			$odds[$key] = $value;
		}
	}
	$commission = pdo_fetchcolumn('select commission from '.tablename('agent_odds').' where pid=:id and agent_id=:agent',array(':id'=>$id,':agent'=>$agent_id));
	$commission = json_decode($commission,true);
	$result = array(
		'status' => 1,
		'odds' => $odds,
		'commission' => $commission,
		'id' => $id
	);
	echo json_encode($result);
	exit;
}

if ($op == 'get_used_odds') {
	$member_id = $_GPC['member_id'];
	$list = pdo_fetchall('select * from '.tablename('manji_member_odds').' where member_id=:id',array(':id'=>$member_id));
	foreach ($list as $key => $value) {
		$result[$key]['id'] = $value['pid'];
		$result[$key]['cid'] = $value['cid'];
		foreach ($value as $ky => $val) {
			if ($ky != 'id' && $ky != 'member_id' && $ky != 'cid' && $ky != 'pid') {
				$result[$key]['odds'][$ky] = explode('|',$val);
			}
		}
	}

	echo json_encode($result);
	exit;
}





 ?>