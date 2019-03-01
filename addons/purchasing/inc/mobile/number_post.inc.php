<?php 
global $_W,$_GPC;
$mid = $_SESSION['mid'];

if (empty($mid)) {
	message('请先登录',$this->createMobileUrl('login'),'unlog');
}
$manager = pdo_fetch('select * from '.tablename('agent_member').' where id=:id',array(':id'=>$mid));
$open_time = pdo_fetchall('select p.endtime,c.nickname from '.tablename('manji_preinstall_time').' p left join '.tablename('manji_company').' c on c.id=p.cid where aid=0');

$op = $_GPC['op']?$_GPC['op']:'display';
$page = $_GPC['page']>0?$_GPC['page']:1;
$psize = 30;

if ($op == 'display') {
	$date = $_GPC['date'];
	if (!empty($date)) {
		$periods = pdo_fetchColumnValue('select id from '.tablename('manji_run_setting').' where date=:date and aid=:aid',array(':date'=>$date,':aid'=>$_SESSION['cid']),'id');
	}
	else{
		$endtime = pdo_fetchcolumn('select endtime from '.tablename('manji_run_setting').' where aid=:aid and stoptime>:time',array(':aid'=>$_SESSION['cid'],':time'=>time()));
		$periods = pdo_fetchColumnValue('select id from '.tablename('manji_run_setting').' where endtime=:endtime and aid=:aid',array(':endtime'=>$endtime,':aid'=>$_SESSION['cid']),'id');
		$date = pdo_fetchcolumn('select date from '.tablename('manji_run_setting').' where endtime>:time',array(':time'=>time()));
	}
	$house = array(
		'6D' => 0,
		'5D' => 0,
		'4D' => 0,
		'3D' => 0,
		'2D' => 0
	);
	$unpost_total = 0;
	$posted_total = 0;
	$house_total = 0;
	foreach ($periods as $period) {
		$hou = pdo_fetch('select sum(pay_6D) as 6D,sum(pay_5D) as 5D,sum(pay_B+pay_S+pay_4A+pay_4B+pay_4C+pay_4D+pay_4E+pay_EA+pay_4ABC) as 4D,sum(pay_a+pay_C2+pay_C3+pay_C4+pay_C5+pay_EC+pay_3ABC) as 3D,sum(pay_2A+pay_2B+pay_2C+pay_2D+pay_2E+pay_EX+pay_2ABC) as 2D from '.tablename('manji_order').' where period_id like \'%('.$period.')%\'');
		$house['6D'] += $hou['6D'];
		$house['5D'] += $hou['5D'];
		$house['4D'] += $hou['4D'];
		$house['3D'] += $hou['3D'];
		$house['2D'] += $hou['2D'];
	}
	foreach ($house as $hou) {
		$house_total += $hou;
	}
	$unpost = pdo_fetch('select sum(pay_6D) as 6D,sum(pay_5D) as 5D,sum(pay_B+pay_S+pay_4A+pay_4B+pay_4C+pay_4D+pay_4E+pay_EA+pay_4ABC) as 4D,sum(pay_a+pay_C2+pay_C3+pay_C4+pay_C5+pay_EC+pay_3ABC) as 3D,sum(pay_2A+pay_2B+pay_2C+pay_2D+pay_2E+pay_EX+pay_2ABC) as 2D from '.tablename('agent_unpost').' where date=:date and area_id=:area_id',array(':date'=>$date,':area_id'=>$_SESSION['cid']));
	foreach ($unpost as $unp) {
		$unpost_total += $unp;
	}
	$posted = pdo_fetch('select sum(pay_6D) as 6D,sum(pay_5D) as 5D,sum(pay_B+pay_S+pay_4A+pay_4B+pay_4C+pay_4D+pay_4E+pay_EA+pay_4ABC) as 4D,sum(pay_a+pay_C2+pay_C3+pay_C4+pay_C5+pay_EC+pay_3ABC) as 3D,sum(pay_2A+pay_2B+pay_2C+pay_2D+pay_2E+pay_EX+pay_2ABC) as 2D from '.tablename('agent_posted').' where date=:date and area_id=:area_id',array(':date'=>$date,':area_id'=>$_SESSION['cid']));
	foreach ($posted as $pst) {
		$posted_total += $pst;
	}
}

if ($op == 'setting') {
	$parent = pdo_fetchcolumn('select id from '.tablename('agent_member').' where cid=:cid and level=3',array(':cid'=>$_SESSION['cid']));
	$list = pdo_fetchall('select id,account,nickname from '.tablename('member_system_member').' where parent_agent=:parent order by createtime limit '.($page-1)*$psize.','.$psize,array(':parent'=>$parent));
	$total = pdo_fetchcolumn('select count(id) from '.tablename('agent_member').' where parent_agent=:parent order by createtime',array(':parent'=>$parent));
}
if ($op == 'set_account') {
	$id = $_GPC['id'];
	if (!empty($id)) {
		$member = pdo_fetch('select * from '.tablename('member_system_member').' where id=:id',array(':id'=>$id));
		$odds = pdo_fetch('select * from '.tablename('manji_member_odds').' where member_id=:id',array(':id'=>$id));
		foreach ($odds as $k => $v) {
			if ($k == 'odds_B' || $k == 'odds_S' || $k == 'odds_4ABC' || $k == 'odds_3ABC' || $k == 'odds_2ABC' || $k == 'odds_5D' || $k == 'odds_6D') {
				$odds[$k] = explode('|',$v);
			}
		}
		$commission = json_decode($odds['commission'],true);
		$eat = pdo_fetch('select * from '.tablename('manji_special_eat').' where member_id=:id',array(':id'=>$id));
		$eat = json_decode($eat['eat'],true);
	}
	$company = pdo_fetchall('select * from '.tablename('manji_company').' where id>1');
	$area = pdo_fetchall('select * from '.tablename('manji_area').' where id>1 and id<>:id',array(':id'=>$_SESSION['cid']));
}

if ($op == 'account_post') {
	$id = $_GPC['id'];
	$account = $_GPC['account'];
	$nickname = $_GPC['nickname'];
	$port_id = $_GPC['port_id'];
	$eat = $_GPC['eat'];
	$odds = $_GPC['odds'];
	$commission = $_GPC['commission'];
	$parent = pdo_fetchcolumn('select id from '.tablename('agent_member').' where level=3 and cid=:cid',array(':cid'=>$_SESSION['cid']));
	if (!empty($id)) {
		$old = pdo_fetch('select * from '.tablename('member_system_member').' where id=:id',array(':id'=>$id));
		$save = array(
			'account' => $account,
			'nickname' => $nickname,
			'port_id' => $port_id
		);
		pdo_update('member_system_member',$save,array('id'=>$id));
	}
	else{
		$save = array(
			'account' => $account,
			'nickname' => $nickname,
			'port_id' => $port_id,
			'parent_agent' => $parent
		);
		pdo_insert('member_system_member',$save);
		$id = pdo_insertid();
	}
	$eat_save = array(
		'member_id' => $id,
		'eat' => json_encode($eat)
	);
	$odds_save = array(
		'member_id' => $id,
		'cid' => $_SESSION['cid'],
		'commission' => json_encode($commission)
	);
	foreach ($odds as $key => $value) {
		if ($key == 'B' || $key == 'S' || $key == '3ABC' || $key == '4ABC' || $key == '2ABC' || $key == '5D' || $key == '6D') {
			$odds_save['odds_'.$key] = implode('|',$value);
		}
		else{
			$odds_save['odds_'.$key] = $value;
		}
	}
	pdo_delete('manji_special_eat',array('member_id'=>$id));
	pdo_insert('manji_special_eat',$eat_save);
	pdo_delete('manji_member_odds',array('member_id'=>$id));
	pdo_insert('manji_member_odds',$odds_save);
	message('保存成功',$this->createMobileUrl('number_post',array('op'=>'setting')),'success');
	exit;
}

if ($op == 'unpost') {
	$type = $_GPC['type'];
	$date = $_GPC['date'];
	$number = $_GPC['number'];
	$company = pdo_fetchall('select * from '.tablename('manji_company').' where id<>1');
	$periods = pdo_fetchcolumn('select date from '.tablename('manji_run_setting').' where stoptime>:time',array(':time'=>time()));
	switch ($type) {
		case '3D':
			$list = array('3D'=>array());
			break;
		case '4D':
			$list = array('4D'=>array());
			break;
		case '5D':
			$list = array('5D'=>array());
			break;
		case '6D':
			$list = array('6D'=>array());
			break;
		default:
			$list = array(
				'3D' => array(),
				'4D' => array(),
				'5D' => array(),
				'6D' => array()
			);
			break;
	}
	$condition .= ' and date=:date ';
	$fields[':date'] = $date?$date:$periods;
	if (!empty($number)) {
		$condition .= ' and number=:number ';
		$fields[':number'] = $number;
	}

	$fields[':cid'] = $_SESSION['cid'];

	foreach ($list as $key => $value) {
		foreach ($company as $com) {
			$fields[':company'] = $com['id'];
			switch ($key) {
				case '3D':
					$unpost = array('A','C2','C3','C4','C5','EC','3ABC');
					$number['list'] = pdo_fetchall('select number,sum(pay_A) as A,sum(pay_C2) as C2,sum(pay_C3) as C3,sum(pay_C4) as C4,sum(pay_C5) as C5,sum(pay_EC) as EC,sum(pay_3ABC) as 3ABC from '.tablename('agent_unpost').' where area_id=:cid and company_id=:company '.$condition.' having (sum(pay_A)>0 or sum(pay_C2)>0 or sum(pay_C3)>0 or sum(pay_C4)>0 or sum(pay_C5)>0 or sum(pay_EC)>0 or sum(pay_3ABC)>0)',$fields);
					if (!empty($number['list'])) {
						$number['name'] = $com['name'];
						$number['post_key'] = $unpost;
						$list[$key][$com['id']] = $number;
					}
					break;
				case '4D':
					$unpost = array('B','S','4A','4B','4C','4D','4E','EA','4ABC');
					$number['list'] = pdo_fetchall('select number,sum(pay_B) as B,sum(pay_S) as S,sum(pay_4A) as 4A,sum(pay_4B) as 4B,sum(pay_4C) as 4C,sum(pay_4D) as 4D,sum(pay_4E) as 4E,sum(pay_EA) as EA,sum(pay_4ABC) as 4ABC from '.tablename('agent_unpost').' where area_id=:cid and company_id=:company '.$condition.' having (sum(pay_B)>0 or sum(pay_S)>0 or sum(pay_4A)>0 or sum(pay_4B)>0 or sum(pay_4C)>0 or sum(pay_4D)>0 or sum(pay_4E)>0 or sum(pay_EA)>0 or sum(pay_4ABC)>0)',$fields);
					if (!empty($number['list'])) {
						$number['name'] = $com['name'];
						$number['post_key'] = $unpost;
						$list[$key][$com['id']] = $number;
					}
					break;
				case '5D':
					$unpost = array('5D');
					if ($com['has_5D'] == 1) {
						$number['list'] = pdo_fetchall('select number,sum(pay_5D) as 5D from '.tablename('agent_unpost').' where area_id=:cid and company_id=:company '.$condition.' having sum(pay_5D)>0',$fields);
						if (!empty($number['list'])) {
							$number['name'] = $com['name'];
							$number['post_key'] = $unpost;
							$list[$key][$com['id']] = $number;
						}
					}
					break;
				case '6D':
					$unpost = array('6D');
					if ($com['has_6D'] == 1) {
						$number['list'] = pdo_fetchall('select number,sum(pay_6D) as 6D from '.tablename('agent_unpost').' where area_id=:cid and company_id=:company '.$condition.' having sum(pay_6D)>0',$fields);
						if (!empty($number['list'])) {
							$number['name'] = $com['name'];
							$number['post_key'] = $unpost;
							$list[$key][$com['id']] = $number;
						}
					}
					break;
				
				default:
					# code...
					break;
			}
		}
	}
}

if ($op == 'posting') {
	$type = $_GPC['type'];
	$number = $_GPC['number'];
	$company = pdo_fetchall('select * from '.tablename('manji_company').' where id<>1');
	$date = pdo_fetchcolumn('select date from '.tablename('manji_run_setting').' where stoptime>:time',array(':time'=>time()));
	switch ($type) {
		case '3D':
			$list = array('3D'=>array());
			break;
		case '4D':
			$list = array('4D'=>array());
			break;
		case '5D':
			$list = array('5D'=>array());
			break;
		case '6D':
			$list = array('6D'=>array());
			break;
		default:
			$list = array(
				'3D' => array(),
				'4D' => array(),
				'5D' => array(),
				'6D' => array()
			);
			break;
	}
	$number = pdo_fetchall('select id,number from '.tablename('agent_unpost').' where date=:date and area_id=:cid group by number',array(':date'=>$date,':cid'=>$_SESSION['cid']));

	foreach ($list as $key => $value) {
		switch ($key) {
			case '3D':
				$unpost = array('A','C2','C3','C4','C5','EC','3ABC');
				foreach ($number as $num) {
					foreach ($company as $com) {
						$pays = pdo_fetch('select sum(pay_A) as A,sum(pay_C2) as C2,sum(pay_C3) as C3,sum(pay_C4) as C4,sum(pay_C5) as C5,sum(pay_EC) as EC,sum(pay_3ABC) as 3ABC from '.tablename('agent_unpost').' where number=:number and company_id=:company and date=:date having (sum(pay_A)>0 or sum(pay_C2)>0 or sum(pay_C3)>0 or sum(pay_C4)>0 or sum(pay_C5)>0 or sum(pay_EC)>0 or sum(pay_3ABC)>0)',array(':number'=>$num['number'],':company'=>$com['id'],':date'=>$date));
						if (!empty($pays)) {
							$list[$key]['post_key'] = $unpost;
							$list[$key][$num['number']][$com['id']] = $pays;
						}
					}
				}
				break;
			case '4D':
				$unpost = array('B','S','4A','4B','4C','4D','4E','EA','4ABC');
				foreach ($number as $num) {
					foreach ($company as $com) {
						$pays = pdo_fetch('select sum(pay_B) as B,sum(pay_S) as S,sum(pay_4A) as 4A,sum(pay_4B) as 4B,sum(pay_4C) as 4C,sum(pay_4D) as 4D,sum(pay_4E) as 4E,sum(pay_EA) as EA,sum(pay_4ABC) as 4ABC from '.tablename('agent_unpost').' where number=:number and company_id=:company and date=:date having (sum(pay_B)>0 or sum(pay_S)>0 or sum(pay_4A)>0 or sum(pay_4B)>0 or sum(pay_4C)>0 or sum(pay_4D)>0 or sum(pay_4E)>0 or sum(pay_EA)>0 or sum(pay_4ABC)>0)',array(':number'=>$num['number'],':company'=>$com['id'],':date'=>$date));
						if (!empty($pays)) {
							$list[$key]['post_key'] = $unpost;
							$list[$key][$num['number']][$com['id']] = $pays;
						}
					}
				}
				break;
			case '5D':
				$unpost = array('5D');
				foreach ($number as $num) {
					foreach ($company as $com) {
						$pays = pdo_fetch('select sum(pay_5D) as 5D from '.tablename('agent_unpost').' where number=:number and company_id=:company and date=:date having sum(pay_5D)>0',array(':number'=>$num['number'],':company'=>$com['id'],':date'=>$date));
						if (!empty($pays)) {
							$list[$key]['post_key'] = $unpost;
							$list[$key][$num['number']][$com['id']] = $pays;
						}
					}
				}
				break;
			case '6D':
				$unpost = array('6D');
				foreach ($number as $num) {
					foreach ($company as $com) {
						$pays = pdo_fetch('select sum(pay_6D) as 6D from '.tablename('agent_unpost').' where number=:number and company_id=:company and date=:date having sum(pay_6D)>0',array(':number'=>$num['number'],':company'=>$com['id'],':date'=>$date));
						if (!empty($pays)) {
							$list[$key]['post_key'] = $unpost;
							$list[$key][$num['number']][$com['id']] = $pays;
						}
					}
				}
				break;
			
			default:
				# code...
				break;
		}
	}
	$partner = pdo_fetchall('select * from '.tablename('member_system_member').' where cid=:cid and port_id>0',array(':cid'=>$_SESSION['cid']));
	foreach ($partner as &$value) {
		$id = pdo_fetchcolumn('select id from '.tablename('member_system_member').' where cid=:cid and port_id=:port_id',array(':cid'=>$value['port_id'],':port_id'=>$_SESSION['cid']));
		$rec = pdo_fetchcolumn('select sum(pay_B+pay_S+pay_A+pay_C2+pay_C3+pay_C4+pay_C5+pay_EC+pay_3ABC+pay_4A+pay_4B+pay_4C+pay_4D+pay_4E+pay_EA+pay_4ABC+pay_2A+pay_2B+pay_2C+pay_2D+pay_2E+pay_EX+pay_2ABC+pay_5D+pay_6D) from '.tablename('agent_posted').' where to_who=:id and area_id=:cid',array(':id'=>$_SESSION['cid'],':cid'=>$value['port_id']));
		$posted = pdo_fetchcolumn('select sum(pay_B+pay_S+pay_A+pay_C2+pay_C3+pay_C4+pay_C5+pay_EC+pay_3ABC+pay_4A+pay_4B+pay_4C+pay_4D+pay_4E+pay_EA+pay_4ABC+pay_2A+pay_2B+pay_2C+pay_2D+pay_2E+pay_EX+pay_2ABC+pay_5D+pay_6D) from '.tablename('agent_posted').' where area_id=:id and to_who=:to',array(':id'=>$_SESSION['cid'],':to'=>$value['port_id']));
		$return = pdo_fetchcolumn('select sum(pay_B+pay_S+pay_A+pay_C2+pay_C3+pay_C4+pay_C5+pay_EC+pay_3ABC+pay_4A+pay_4B+pay_4C+pay_4D+pay_4E+pay_EA+pay_4ABC+pay_2A+pay_2B+pay_2C+pay_2D+pay_2E+pay_EX+pay_2ABC+pay_5D+pay_6D) from '.tablename('agent_return').' where area_id=:id and from_who=:from',array(':id'=>$_SESSION['cid'],':from'=>$value['port_id']));
		$value['rec'] = $rec?$rec:0;
		$value['post'] = $posted?$posted:0;
		$value['return'] = $return?$return:0;
	}
}

if ($op == 'post') {
	$post_id = $_GPC['post_id'];
	$company = $_GPC['company'];
	$post_to = $_GPC['post_to'];
	$percent = $_GPC['percent'];
	$type = $_GPC['type'];
	switch ($type) {
		case '4D':
			$rules = array('B','S','4A','4B','4C','4D','4E','EA','4ABC');
			break;
		case '5D':
			$rules = array('5D');
			break;
		case '6D':
			$rules = array('6D');
			break;
		case '3D':
			$rules = array('A','C2','C3','C4','C5','EC','3ABC');
			break;

		default:
			$rules = array('B','S','A','C2','C3','C4','C5','EC','3ABC','4A','4B','4C','4D','4E','EA','4ABC','2A','2B','2C','2D','2E','EX','2ABC','5D','6D');
			break;
	}
	foreach ($rules as $value) {
		$ruler[] = 'pay_'.$value;
	}
	$post = pdo_fetchall('select id,area_id,company_id,number,date,'.implode(',',$ruler).' from '.tablename('agent_unpost').' where number in ('.implode(',',$post_id).') and company_id in ('.implode(',',$company).') and area_id=:cid',array(':cid'=>$_SESSION['cid']));
	$member = pdo_fetch('select * from '.tablename('member_system_member').' where cid=:cid and port_id=:port',array(':cid'=>$post_to,':port'=>$_SESSION['cid']));
	$eat = pdo_fetchcolumn('select eat from '.tablename('manji_special_eat').' where member_id=:member',array(':member'=>$member['id']));
	$eat = json_decode($eat,true);
	foreach ($post as $key => $value) {
		foreach ($rules as $rule) {
			if ($rule == 'B' || $rule == 'S' || $rule == '4A' || $rule == '4ABC') {
				# code...
			}
			elseif ($rule == 'A' || $rule == '3ABC') {
				# code...
			}
			else{
				
			}
		}
	}
}









include $this->template('number_post');

 ?>