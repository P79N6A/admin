<?php 
global $_W,$_GPC;

$mid = $_SESSION['mid'];
$op = $_GPC['op']?$_GPC['op']:'display';

if (empty($mid)) {
	message('请先登录',$this->createMobileUrl('login'),'error');
	exit;
}
$manager = pdo_fetch('select * from '.tablename('agent_member').' where id=:id',array(':id'=>$_SESSION['mid']));
$disc_name = pdo_fetchcolumn('select area_name from '.tablename('manji_area').' where id=:id',array(':id'=>$_SESSION['cid']));
$open_time = pdo_fetchall('select p.endtime,c.nickname from '.tablename('manji_preinstall_time').' p left join '.tablename('manji_company').' c on c.id=p.cid where aid=0');

$page = $_GPC['page']>0?$_GPC['page']:1;
$psize = 25;

if ($op == 'main') {
	$area = pdo_fetchall('select id,area_name from '.tablename('manji_area').' order by id asc');
	$notice = pdo_fetch('select id,content from '.tablename('manji_notice').' order by createtime desc');
	include $this->template('main');
	exit;
}

if ($op == 'manager_eat') {
	$account = $_GPC['account'];
	$condition = ' where level>=:level and level<5 and level <>1';
	$fields[':level'] = $_SESSION['level'];
	if (!empty($account)) {
		$condition .= ' and account=:account ';
		$fields[':account'] = $account;
	}
	if (!empty($_SESSION['cid'])) {
		$condition .= ' and cid=:cid ';
		$fields[':cid'] = $_SESSION['cid'];
	}
	$list = pdo_fetchall('select * from '.tablename('agent_member').$condition.' order by id asc',$fields);
	include $this->template('manager_eat');
	exit;
}

if ($op == 'setting') {
	$setting = pdo_fetchcolumn('select toplimit from '.tablename('agent_toplimit').' where agent_id=:mid',array(':mid'=>$mid));
	include $this->template('setting');
	exit;
}

if ($op == 'display') {
	$keyword = $_GPC['keyword'];
	$agent_id = $_GPC['agent_id'];
	if ($_SESSION['level'] >= 4 && empty($agent_id)) {
		$agent_id = $mid;
	}
	$condition = '';
	$can = 1;
	if (!empty($agent_id)) {
		$parents_id = getParent($agent_id);
		$agent_info = pdo_fetch('select account,nickname,parent_agent from '.tablename('agent_member').' where id=:id',array(':id'=>$agent_id));
		$can = pdo_fetchcolumn('select parent_control from '.tablename('agent_member').' where id=:id',array(':id'=>$agent_id));
	}
	if ($_SESSION['level'] == 5 && empty($agent_id)) {
		$agent_info = pdo_fetch('select account,nickname,parent_agent from '.tablename('agent_member').' where id=:id',array(':id'=>$mid));
	}
	if ($_SESSION['level'] <= 3) {
		$childs = get_children(0);
	}
	else{
		$childs = get_children($mid);
	}
	$account = '';
	if (count($parents_id)>0) {
		$parents_fields = implode(',',$parents_id);
		$parents = pdo_fetchall('select account,nickname,id from '.tablename('agent_member').' where id in ('.$parents_fields.') order by id asc');
		foreach ($parents as $key => $value) {
			if ($key == 0) {
				if (in_array($value['id'], $childs) || $value['id'] == $mid) {
					$account .= '<a href="'.$this->createMobileUrl('manager',array('op'=>'display','agent_id'=>$value['id'])).'">'.$value['account'].'</a>';
				}
				else{
					$account .= $value['account'];
				}
			}
			else{
				if (in_array($value['id'],$childs) || $value['id'] == $mid) {
					$account .= '><a href="'.$this->createMobileUrl('manager',array('op'=>'display','agent_id'=>$value['id'])).'">'.$value['account'].'</a>';
				}
				else{
					$account .= '>'.$value['account'];
				}
			}
		}
	}
	if ($account != '') {
		$account .= '>'.$agent_info['account'];
	}
	else{
		$account .= $agent_info['account'];
	}
	if ($_SESSION['cid'] > 0) {
		$condition .= ' and cid='.$_SESSION['cid'].' ';
	}
    if (!empty($keyword)) {
        $condition .= "  and  account like :keyword ";
        $fields[':keyword'] = '%'.$keyword.'%';
        $childs[] = $mid;
        $childs_fields = implode(',',$childs);
        $condition .= ' and parent_agent in ('.$childs_fields.') ';
    }
    else{
    	if (!empty($agent_id)) {
	    	$condition .= ' and parent_agent=:agent ';
	    	$fields[':agent'] = $agent_id;
	    }
	    else{
	    	if ($_SESSION['level'] >= 4) {
				$condition .= ' and parent_agent=:agent ';
				$fields[':agent'] = $mid;
			}
			elseif ($_SESSION['level'] > 1) {
				$manager3 = pdo_fetchColumnValue('select id from '.tablename('agent_member').' where cid=:cid and level=4',array(':cid'=>$_SESSION['cid']),'id');
				$condition .= ' and parent_agent in ('.implode(',', $manager3).')';
			}
			else{
				$manager3 = pdo_fetchColumnValue('select id from '.tablename('agent_member').' where level=4',array(),'id');
				$condition .= ' and parent_agent in ('.implode(',', $manager3).')';
			}
	    	
	    }
    }

    $list = pdo_fetchall('select * from '.tablename('agent_member')." where level>4 {$condition} order by id asc ",$fields);
	
	foreach($list as &$agent){
		$agent_data = pdo_fetch('select * from '.tablename('agent_member')." where id=". $agent['parent_agent']);
		if( empty($agent_data) ){
			$agent['parent_name'] = "总代";
		}
		else{
			$agent['parent_name'] = $agent_data['account'];
		}
		$agent['user_type'] = 1;
	}

	$member = pdo_fetchall('select * from '.tablename('member_system_member')." where 1 {$condition} order by id asc ",$fields);
	foreach ($member as &$mem) {
		$agent_data = pdo_fetch('select * from '.tablename('agent_member')." where id=". $mem['parent_agent']);
		if( empty($agent_data) ){
			$mem['parent_name'] = "总代";
		}
		else{
			$mem['parent_name'] = $agent_data['account'];
		}
		$mem['user_type'] = 2;
	}

	$list = array_merge($list,$member);
    $total = count($list);
    $list = array_slice($list,($page-1)*$psize,$psize);
    foreach ($list as $key => $value) {
		if ($value['user_type'] == 1) {
			$agent_num = pdo_fetchcolumn('select count(id) from '.tablename('agent_member').' where parent_agent=:agent',array(':agent'=>$value['id']));
			$member_num = pdo_fetchcolumn('select count(id) from '.tablename('member_system_member').' where parent_agent=:agent',array(':agent'=>$value['id']));
			$list[$key]['bonus'] = pdo_fetchcolumn('select bonus_percent from '.tablename('agent_percent').' where agent_id=:agent_id',array(':agent_id'=>$value['id']));
			$list[$key]['percent'] = pdo_fetchcolumn('select percent from '.tablename('agent_eat').' where agent_id=:agent_id',array(':agent_id'=>$value['id']));
			$list[$key]['child_num'] = $agent_num+$member_num;
		}
		else{
			$list[$key]['used_odds_c'] = pdo_fetch('select m.id,o.id as pid from '.tablename('manji_member_odds').' m left join '.tablename('agent_odds').' a on a.id=m.pid left join '.tablename('manji_odds').' o on o.id=a.pid where m.member_id=:id and m.cid>1',array(':id'=>$value['id']));
			$list[$key]['used_odds_j'] = pdo_fetch('select m.id,o.id as pid from '.tablename('manji_member_odds').' m left join '.tablename('agent_odds').' a on a.id=m.pid left join '.tablename('manji_odds').' o on o.id=a.pid where m.member_id=:id and m.cid=1',array(':id'=>$value['id']));
			$list[$key]['child_num'] = 0;
		}
		
	}
    $pager = pagination($total,$page,$psize);
}

if ($op == 'area') {
	$list = pdo_fetchall('select * from '.tablename('manji_area').' order by id asc limit '.($page-1)*$psize.','.$psize);
	foreach ($list as &$val) {
		$val['mac'] = pdo_fetchcolumn('select account from '.tablename('agent_member').' where cid=:cid and level=2',array(':cid'=>$val['id']));
		$val['moac'] = pdo_fetchcolumn('select account from '.tablename('agent_member').' where cid=:cid and level=3',array(':cid'=>$val['id']));
		$val['aac'] = pdo_fetchcolumn('select account from '.tablename('agent_member').' where cid=:cid and level=4',array(':cid'=>$val['id']));
	}
	$total = pdo_fetchcolumn('select count(id) from '.tablename('manji_area').' order by id asc');
	$pager = pagination($total,$page,$psize);
	include $this->template('area');
	exit;
}

if ($op == 'company') {
	$list = pdo_fetchall('select * from '.tablename('manji_company').'order by id asc limit '.($page-1)*$psize.','.$psize);
	$total = pdo_fetchcolumn('select count(*) from '.tablename('manji_company').' order by id asc ');
	$pager = pagination($total,$page,$psize);
	include $this->template('company');
	exit;
}

if ($op == 'rule') {
	$rules = pdo_fetchall('select * from '.tablename('manji_rules').' order by id asc');
	include $this->template('rules');
	exit;
}

if ($op == 'odds') {
	$tab = $_GPC['tab']?$_GPC['tab']:'display';
	if ($tab == 'display') {
		$cid = $_GPC['cid']?$_GPC['cid']:1;
		$list = pdo_fetchall('select * from '.tablename('manji_odds_group').' order by id asc');
		foreach ($list as $key => $value) {
			$odds = pdo_fetchall('select * from '.tablename('manji_odds').' where gid=:gid and cid=:cid',array(':gid'=>$value['id'],':cid'=>$cid));
			foreach ($odds as $k => $v) {
				foreach ($v as $ky => $val) {
					if ($ky == 'odds_B' || $ky == 'odds_S' || $ky == 'odds_3ABC' || $ky == 'odds_4ABC' || $ky == 'odds_2ABC' || $ky == 'odds_5D' || $ky == 'odds_6D') {
						$odds[$k][$ky] = explode('|',$val);
					}
				}
				$odds[$k]['commission'] = json_decode($v['commission'],true);
				$odds[$k]['cashback'] = array(
					'B' => get_cashback_only($odds[$k]['odds_B'],'B',$odds[$k]['commission']['B']),
					'S' => get_cashback_only($odds[$k]['odds_S'],'S',$odds[$k]['commission']['S']),
					'A' => get_cashback_only(array($v['odds_A'],$v['odds_C2'],$v['odds_C3'],$v['odds_C4'],$v['odds_C5'],$v['odds_EC']),'A',$odds[$k]['commission']['A']),
					'3ABC' => get_cashback_only($odds[$k]['odds_3ABC'],'3ABC',$odds[$k]['commission']['3ABC']),
					'4A' => get_cashback_only(array($v['odds_4A'],$v['odds_4B'],$v['odds_4C'],$v['odds_4D'],$v['odds_4E'],$v['odds_EA']),'4A',$odds[$k]['commission']['4A']),
					'4ABC' => get_cashback_only($odds[$k]['odds_4ABC'],'4ABC',$odds[$k]['commission']['4ABC']),
					'2A' => get_cashback_only(array($v['odds_2A'],$v['odds_2B'],$v['odds_2C'],$v['odds_2D'],$v['odds_2E'],$v['odds_EX']),'2A',$odds[$k]['commission']['2A']),
					'2ABC' => get_cashback_only($odds[$k]['odds_2ABC'],'2ABC',$odds[$k]['commission']['2ABC']),
					'5D' => get_cashback_only($odds[$k]['odds_5D'],'5D',$odds[$k]['commission']['5D']),
					'6D' => get_cashback_only($odds[$k]['odds_6D'],'6D',$odds[$k]['commission']['6D']),
				);
			}
			$list[$key]['odds'] = $odds;
		}
		if ($_SESSION['level'] != 1) {
			$condition = ' where cid ='.$_SESSION['cid'].' ';
		}
		$group = pdo_fetchall('select * from '.tablename('manji_odds_group').' order by id asc');
		$total = pdo_fetchcolumn('select count(id) from '.tablename('manji_odds_group').'  order by id asc');
		$area = pdo_fetchall('select * from '.tablename('manji_area').' where id=1 or id=:cid order by id asc',array(':cid'=>$cid));
	}
	include $this->template('odds');
	exit;
}

if ($op == 'odds_group') {
	$list = pdo_fetchall('select * from '.tablename('manji_odds_group').' order by id asc limit '.($page-1)*$psize.','.$psize);
	$total = pdo_fetchcolumn('select count(id) from '.tablename('manji_odds_group').' order by id asc');
	$pager = pagination($total,$page,$psize);
	include $this->template('odds_group');
	exit;
}

if ($op == 'limit') {
	$tab = $_GPC['tab']?$_GPC['tab']:'display';
	$cid = $_SESSION['cid'];
	if ($tab == 'display') {
		if ($cid > 0) {
			$condition = ' where cid='.$cid;
		}
		$list = pdo_fetchall('select * from '.tablename('manji_limit').$condition.' order by createtime desc');
		foreach ($list as $key => $value) {
			$list[$key]['area_name'] = pdo_fetchcolumn('select area_name from '.tablename('manji_area').' where id=:id',array(':id'=>$value['cid']));
		}
	}
	if ($tab == 'detail' || $tab == 'edit') {
		$id = $_GPC['id'];
		$area = pdo_fetchall('select id,area_name from '.tablename('manji_area').' order by id asc');
		$limit = pdo_fetch('select * from '.tablename('manji_limit').' where id=:id',array(':id'=>$id));
		if ($_SESSION['level'] > 1) {
			$condition = ' where id<>1 ';
		}
		else{
			$condition = ' where id=1 ';
		}
		$company = pdo_fetchall('select id,nickname from '.tablename('manji_company').$condition.' order by id asc');
		$detail = json_decode($limit['limit'],true);
		$beto = array('B','S','A','C2','C3','C4','C5','EC','3ABC','4A','4B','4C','4D','4E','EA','4ABC','2A','2B','2C','2D','2E','EX','2ABC','5D','6D');
		foreach ($company as &$com) {
			foreach ($beto as $bet) {
				foreach ($detail as $k => $v) {
					if ($com['id'] == $k) {
						$com[$bet] = $v[$bet];
					}
				}
			}
		}
	}
	if ($tab == 'create') {
		$area = pdo_fetchall('select id,area_name from '.tablename('manji_area').' order by id asc');
		if ($_SESSION['level'] > 1) {
			$condition = ' where id<>1 ';
		}
		else{
			$condition = ' where id=1 ';
		}
		$company = pdo_fetchall('select id,nickname from '.tablename('manji_company').$condition.' order by id asc');
		$beto = array('B','S','A','C2','C3','C4','C5','EC','3ABC','4A','4B','4C','4D','4E','EA','4ABC','2A','2B','2C','2D','2E','EX','2ABC','5D','6D');
		foreach ($company as &$com) {
			foreach ($beto as $bet) {
				$com[$bet] = '';
			}
		}
	}
	if ($tab == 'time') {
		if ($cid > 0) {
			$condition = ' where cid='.$cid;
			$condition1 = ' where cid=0 or cid='.$cid;
		}
		$area = pdo_fetchall('select id,area_name from '.tablename('manji_area').' order by id asc');
		$list = pdo_fetchall('select * from '.tablename('manji_limit_time').$condition.' order by id asc');
		$limit = pdo_fetchall('select id,title from '.tablename('manji_limit').$condition.' order by createtime asc');
	}
	if ($tab == 'red') {
		if ($cid > 0) {
			$condition = ' and cid='.$cid;
		}
		$total = pdo_fetchall('select id,number,createtime,mode from '.tablename('manji_red_number').' where type=2 '.$condition);
	}
	if ($tab == 'red_detail' || $tab == 'red_edit') {
		$type = $_GPC['type'];
		if ($cid > 0) {
			$condition = ' and cid='.$cid;
		}
		$list = pdo_fetchall('select * from '.tablename('manji_red_number').' where type=:type '.$condition,array(':type'=>$type));
		if ($_SESSION['level'] > 1) {
			$c_condition = ' where id <> 1';
		}
		$company = pdo_fetchall('select id,nickname from '.tablename('manji_company').$c_condition);
		foreach ($company as $key => $value) {
			$com[$value['id']] = $value['nickname'];
		}
		foreach ($list as &$value) {
			$value['area_name'] = pdo_fetchcolumn('select area_name from '.tablename('manji_area').' where id=:id',array(':id'=>$value['cid']));
			$value['bet_limit'] = json_decode($value['bet_limit'],true);
		}
	}
	if ($tab == 'red_create') {
		$area = pdo_fetchall('select id,area_name from '.tablename('manji_area').' order by id asc');
		if ($_SESSION['level'] > 1) {
			$c_condition = ' where id <> 1';
		}
		else{
			$c_condition = ' where id=1';
		}
		$company = pdo_fetchall('select id,nickname from '.tablename('manji_company').$c_condition.' order by id asc');
		$beto = array('B','S','A','C2','C3','C4','C5','EC','3ABC','4A','4B','4C','4D','4E','EA','4ABC','2A','2B','2C','2D','2E','EX','2ABC','5D','6D');
		foreach ($company as &$com) {
			foreach ($beto as $bet) {
				$com[$bet] = '';
			}
		}
	}
	include $this->template('limit');
	exit;
}

if ($op == 'member') {
	$agent_id = $_GPC['agent_id'];
	$member_id = $_GPC['member_id'];
	$tab = $_GPC['tab']?$_GPC['tab']:'display';
	$area = $_SESSION['cid'];
	if (!empty($member_id)) {
		$status = pdo_fetchcolumn('select is_black from '.tablename('member_system_member').' where id=:id',array(':id'=>$_GPC['member_id']));
		$member = pdo_fetch('select * from '.tablename('member_system_member').' where id=:id',array(':id'=>$_GPC['member_id']));
		$parent = pdo_fetch('select * from '.tablename('agent_member').' where id=:id',array(':id'=>$member['parent_agent']));
		$red = pdo_fetch('select * from '.tablename('manji_member_red').' where user_id=:id',array(':id'=>$member_id));
		// var_dump($red);exit;
		$red_info = json_decode($red['red_limit'],true);
		$list1 = $list2 = pdo_fetchall('select * from '.tablename('manji_odds_group').' order by id asc');
		foreach ($list1 as $key => $value) {
			$odds = pdo_fetchall('select o.*,ao.id as pid from '.tablename('agent_odds').' ao left join '.tablename('manji_odds').' o on o.id=ao.pid where o.gid=:gid and ao.agent_id=:mid and o.cid=1',array(':gid'=>$value['id'],':mid'=>$member['parent_agent']));
			foreach ($odds as $k => $v) {
				$member_odd = pdo_fetch('select * from '.tablename('manji_member_odds').' where pid=:id and member_id=:member',array(':id'=>$v['pid'],':member'=>$member_id));
				foreach ($v as $ky => $val) {
					if ($ky == 'odds_B' || $ky == 'odds_S' || $ky == 'odds_3ABC' || $ky == 'odds_4ABC' || $ky == 'odds_2ABC' || $ky == 'odds_5D' || $ky == 'odds_6D') {
						$odds[$k][$ky] = explode('|',$val);
					}
				}
				if (!empty($member)) {
					$cashback = gettotalCash($parent['id'],$v['id']);
				}
				else{
					$cashback = json_decode($v['commission'],true);
				}
				if (empty($member_odd)) {
					$commission = pdo_fetchcolumn('select commission from '.tablename('agent_odds').' where pid=:id and agent_id=:agent',array(':id'=>$v['id'],':agent'=>$agent_id));
					$my_cashback = pdo_fetchcolumn('select cashback from '.tablename('agent_odds').' where pid=:id and agent_id=:agent',array(':id'=>$v['id'],':agent'=>$agent_id));
					$odds[$k]['commission'] = $cashback;
					$odds[$k]['my_cashback'] = json_decode($my_cashback,true);
					$odds[$k]['my_commission'] = json_decode($commission,true);
					$odds[$k]['cashback'] = array(
						'B' => get_cashback_only($odds[$k]['odds_B'],'B',$odds[$k]['commission']['B'],$odds[$k]['my_commission']['B']),
						'S' => get_cashback_only($odds[$k]['odds_S'],'S',$odds[$k]['commission']['S'],$odds[$k]['my_commission']['S']),
						'A' => get_cashback_only(array($v['odds_A'],$v['odds_C2'],$v['odds_C3'],$v['odds_C4'],$v['odds_C5'],$v['odds_EC']),'A',$odds[$k]['commission']['A'],$odds[$k]['my_commission']['A']),
						'3ABC' => get_cashback_only($odds[$k]['odds_3ABC'],'3ABC',$odds[$k]['commission']['3ABC'],$odds[$k]['my_commission']['3ABC']),
						'4A' => get_cashback_only(array($v['odds_4A'],$v['odds_4B'],$v['odds_4C'],$v['odds_4D'],$v['odds_4E'],$v['odds_EA']),'4A',$odds[$k]['commission']['4A'],$odds[$k]['my_commission']['4A']),
						'4ABC' => get_cashback_only($odds[$k]['odds_4ABC'],'4ABC',$odds[$k]['commission']['4ABC'],$odds[$k]['my_commission']['4ABC']),
						'2A' => get_cashback_only(array($v['odds_2A'],$v['odds_2B'],$v['odds_2C'],$v['odds_2D'],$v['odds_2E'],$v['odds_EX']),'2A',$odds[$k]['commission']['2A'],$odds[$k]['my_commission']['2A']),
						'2ABC' => get_cashback_only($odds[$k]['odds_2ABC'],'2ABC',$odds[$k]['commission']['2ABC'],$odds[$k]['my_commission']['2ABC']),
						'5D' => get_cashback_only($odds[$k]['odds_5D'],'5D',$odds[$k]['commission']['5D'],$odds[$k]['my_commission']['5D']),
						'6D' => get_cashback_only($odds[$k]['odds_6D'],'6D',$odds[$k]['commission']['6D'],$odds[$k]['my_commission']['6D']),
					);
				}
				else{
					$commission = $member_odd['commission'];
					$my_cashback = pdo_fetchcolumn('select cashback from '.tablename('agent_odds').' where pid=:id and agent_id=:agent',array(':id'=>$v['id'],':agent'=>$agent_id));
					$odds[$k]['commission'] = $cashback;
					$odds[$k]['my_cashback'] = json_decode($my_cashback,true);
					$odds[$k]['my_commission'] = json_decode($commission,true);
					$odds[$k]['cashback'] = json_decode($member_odd['my_cashback'],true);
				}
			}
			$list1[$key]['odds'] = $odds;
		}
		foreach ($list2 as $ke => $vall) {
			$odds = pdo_fetchall('select o.*,ao.id as pid from '.tablename('agent_odds').' ao left join '.tablename('manji_odds').' o on o.id=ao.pid where o.gid=:gid and ao.agent_id=:mid and o.cid<>1',array(':gid'=>$value['id'],':mid'=>$member['parent_agent']));
			foreach ($odds as $k => $v) {
				$member_odd = pdo_fetch('select * from '.tablename('manji_member_odds').' where pid=:id and member_id=:member',array(':id'=>$v['pid'],':member'=>$member_id));
				foreach ($v as $ky => $val) {
					if ($ky == 'odds_B' || $ky == 'odds_S' || $ky == 'odds_3ABC' || $ky == 'odds_4ABC' || $ky == 'odds_2ABC' || $ky == 'odds_5D' || $ky == 'odds_6D') {
						$odds[$k][$ky] = explode('|',$val);
					}
				}
				if (!empty($member)) {
					$cashback = gettotalCash($parent['id'],$v['id']);
				}
				else{
					$cashback = json_decode($v['commission'],true);
				}
				if (empty($member_odd)) {
					$commission = pdo_fetchcolumn('select commission from '.tablename('agent_odds').' where pid=:id and agent_id=:agent',array(':id'=>$v['id'],':agent'=>$agent_id));
					$my_cashback = pdo_fetchcolumn('select cashback from '.tablename('agent_odds').' where pid=:id and agent_id=:agent',array(':id'=>$v['id'],':agent'=>$agent_id));
					$odds[$k]['commission'] = $cashback;
					$odds[$k]['my_cashback'] = json_decode($my_cashback,true);
					$odds[$k]['my_commission'] = json_decode($commission,true);
					$odds[$k]['cashback'] = array(
						'B' => get_cashback_only($odds[$k]['odds_B'],'B',$odds[$k]['commission']['B']),
						'S' => get_cashback_only($odds[$k]['odds_S'],'S',$odds[$k]['commission']['S']),
						'A' => get_cashback_only(array($v['odds_A'],$v['odds_C2'],$v['odds_C3'],$v['odds_C4'],$v['odds_C5'],$v['odds_EC']),'A',$odds[$k]['commission']['A']),
						'3ABC' => get_cashback_only($odds[$k]['odds_3ABC'],'3ABC',$odds[$k]['commission']['3ABC']),
						'4A' => get_cashback_only(array($v['odds_4A'],$v['odds_4B'],$v['odds_4C'],$v['odds_4D'],$v['odds_4E'],$v['odds_EA']),'4A',$odds[$k]['commission']['4A']),
						'4ABC' => get_cashback_only($odds[$k]['odds_4ABC'],'4ABC',$odds[$k]['commission']['4ABC']),
						'2A' => get_cashback_only(array($v['odds_2A'],$v['odds_2B'],$v['odds_2C'],$v['odds_2D'],$v['odds_2E'],$v['odds_EX']),'2A',$odds[$k]['commission']['2A']),
						'2ABC' => get_cashback_only($odds[$k]['odds_2ABC'],'2ABC',$odds[$k]['commission']['2ABC']),
						'5D' => get_cashback_only($odds[$k]['odds_5D'],'5D',$odds[$k]['commission']['5D']),
						'6D' => get_cashback_only($odds[$k]['odds_6D'],'6D',$odds[$k]['commission']['6D']),
					);
				}
				else{
					$commission = $member_odd['commission'];
					$my_cashback = pdo_fetchcolumn('select cashback from '.tablename('agent_odds').' where pid=:id and agent_id=:agent',array(':id'=>$v['id'],':agent'=>$agent_id));
					$odds[$k]['commission'] = $cashback;
					$odds[$k]['my_cashback'] = json_decode($my_cashback,true);
					$odds[$k]['my_commission'] = json_decode($commission,true);
					$odds[$k]['cashback'] = json_decode($member_odd['my_cashback'],true);
				}
			}
			$list2[$ke]['odds'] = $odds;
		}
		$agent_id = $_GPC['agent_id'];
		if ($_SESSION['level'] == 5 && empty($agent_id)) {
			$agent_id = $mid;
		}
		$cashback = pdo_fetchcolumn('select cashback_percent from '.tablename('agent_percent').' where agent_id=:id',array(':id'=>$agent_id));
		$odds1 = pdo_fetchall('select a.id,o.id as pid from '.tablename('agent_odds').' a left join '.tablename('manji_odds').' o on o.id=a.pid where agent_id=:id and cid=1',array(':id'=>$agent_id));
		foreach ($odds1 as $k => $odd1) {
			$used = pdo_fetchcolumn('select count(id) from '.tablename('manji_member_odds').' where pid=:id and member_id=:member',array(':id'=>$odd1['id'],':member'=>$member_id));
			if ($used > 0) {
				$odds1[$k]['used'] = 1;
			}
			else{
				$odds1[$k]['used'] = 0;
			}
		}
		$odds2 = pdo_fetchall('select a.id,o.id as pid from '.tablename('agent_odds').' a left join '.tablename('manji_odds').' o on o.id=a.pid where agent_id=:id and cid<>1',array(':id'=>$agent_id));
		foreach ($odds2 as $k => $odd2) {
			$used = pdo_fetchcolumn('select count(id) from '.tablename('manji_member_odds').' where pid=:id and member_id=:member',array(':id'=>$odd2['id'],':member'=>$member_id));
			if ($used > 0) {
				$odds2[$k]['used'] = 1;
			}
			else{
				$odds2[$k]['used'] = 0;
			}
		}
		$limit = pdo_fetchall('select id,title from '.tablename('manji_limit').' order by id desc');
		include $this->template('manager_member');
		exit;
	}
	else{
		if ($_SESSION['level'] == 5 && empty($agent_id)) {
			$agent_id = $mid;
		}
		$member = pdo_fetch('select * from '.tablename('agent_member').' where id=:id',array(':id'=>$agent_id));
		$parent = pdo_fetch('select * from '.tablename('agent_member').' where id=:id',array(':id'=>$member['parent_agent']));
		$agent_id = $_GPC['agent_id'];
		$percent = pdo_fetch('select * from '.tablename('agent_percent').' where agent_id=:agent',array(':agent'=>$agent_id));
		$bonus = $percent['bonus_percent'];
		$has_odds = pdo_fetchColumnValue('select pid from '.tablename('agent_odds').' where agent_id=:agent',array(':agent'=>$agent_id),'pid');
		$red = pdo_fetch('select * from '.tablename('agent_red').' where agent_id=:id',array(':id'=>$agent_id));
		$red_info = json_decode($red['red_limit'],true);
		$list1 = $list2 = pdo_fetchall('select * from '.tablename('manji_odds_group').' order by id asc');
		foreach ($list1 as $key => $value) {
			if (!empty($parent) && $parent['level'] == 5) {
				$odds = pdo_fetchall('select o.*,a.cashback from '.tablename('agent_odds').' a left join '.tablename('manji_odds').' o on o.id=a.pid where o.cid=1 and o.gid=:gid and a.agent_id=:agent order by id asc',array(':gid'=>$value['id'],':agent'=>$parent['id']));
			}
			else{
				$odds = pdo_fetchall('select * from '.tablename('manji_odds').' where cid=1 and gid=:gid',array(':gid'=>$value['id']));
			}
			foreach ($odds as $k => $v) {
				$cashback = array();
				foreach ($v as $ky => $val) {
					if ($ky == 'odds_B' || $ky == 'odds_S' || $ky == 'odds_3ABC' || $ky == 'odds_4ABC' || $ky == 'odds_2ABC' || $ky == 'odds_5D' || $ky == 'odds_6D') {
						$odds[$k][$ky] = explode('|',$val);
					}
				}
				if (!empty($parent) && $parent['level'] == 5) {
					$cashback = gettotalCash($parent['id'],$v['id']);
				}
				else{
					$cashback = json_decode($v['commission'],true);
				}
				$commission = pdo_fetchcolumn('select commission from '.tablename('agent_odds').' where pid=:id and agent_id=:agent',array(':id'=>$v['id'],':agent'=>$agent_id));
				$my_cashback = pdo_fetchcolumn('select cashback from '.tablename('agent_odds').' where pid=:id and agent_id=:agent',array(':id'=>$v['id'],':agent'=>$agent_id));
				$odds[$k]['has'] = pdo_fetchcolumn('select count(id) from '.tablename('agent_odds').' where pid=:id and agent_id=:agent',array(':id'=>$v['id'],':agent'=>$agent_id));
				$odds[$k]['commission'] = $cashback;
				$odds[$k]['my_commission'] = json_decode($commission,true);
				if (!empty($v['cashback'])) {
					$odds[$k]['my_cashback'] = json_decode($v['cashback'],true);
				}
				else{
					$odds[$k]['my_cashback'] = array(
						'B' => get_cashback_only($odds[$k]['odds_B'],'B',$odds[$k]['commission']['B']),
						'S' => get_cashback_only($odds[$k]['odds_S'],'S',$odds[$k]['commission']['S']),
						'A' => get_cashback_only(array($v['odds_A'],$v['odds_C2'],$v['odds_C3'],$v['odds_C4'],$v['odds_C5'],$v['odds_EC']),'A',$odds[$k]['commission']['A']),
						'3ABC' => get_cashback_only($odds[$k]['odds_3ABC'],'3ABC',$odds[$k]['commission']['3ABC']),
						'4A' => get_cashback_only(array($v['odds_4A'],$v['odds_4B'],$v['odds_4C'],$v['odds_4D'],$v['odds_4E'],$v['odds_EA']),'4A',$odds[$k]['commission']['4A']),
						'4ABC' => get_cashback_only($odds[$k]['odds_4ABC'],'4ABC',$odds[$k]['commission']['4ABC']),
						'2A' => get_cashback_only(array($v['odds_2A'],$v['odds_2B'],$v['odds_2C'],$v['odds_2D'],$v['odds_2E'],$v['odds_EX']),'2A',$odds[$k]['commission']['2A']),
						'2ABC' => get_cashback_only($odds[$k]['odds_2ABC'],'2ABC',$odds[$k]['commission']['2ABC']),
						'5D' => get_cashback_only($odds[$k]['odds_5D'],'5D',$odds[$k]['commission']['5D']),
						'6D' => get_cashback_only($odds[$k]['odds_6D'],'6D',$odds[$k]['commission']['6D']),
					);
				}
				$odds[$k]['cashback'] = json_decode($my_cashback,true)?json_decode($my_cashback,true):array('B'=>0,'S'=>0,'A'=>0,'3ABC'=>0,'4ABC'=>0,'2A'=>0,'2ABC'=>0,'5D'=>0,'6D'=>0);
			}
			$list1[$key]['odds'] = $odds;
		}
		foreach ($list2 as $ke => $vall) {
			if (!empty($parent) && $parent['level'] == 5) {
				$odds = pdo_fetchall('select o.*,a.cashback from '.tablename('agent_odds').' a left join '.tablename('manji_odds').' o on o.id=a.pid where o.cid=:cid and o.gid=:gid and a.agent_id=:agent order by id asc',array(':gid'=>$vall['id'],':cid'=>$member['cid'],':agent'=>$parent['id']));
			}
			else{
				$odds = pdo_fetchall('select * from '.tablename('manji_odds').' where cid=:cid and gid=:gid',array(':cid'=>$member['cid'],':gid'=>$vall['id']));
			}
			foreach ($odds as $k => $v) {
				$cashback = array();
				foreach ($v as $ky => $val) {
					if ($ky == 'odds_B' || $ky == 'odds_S' || $ky == 'odds_3ABC' || $ky == 'odds_4ABC' || $ky == 'odds_2ABC' || $ky == 'odds_5D' || $ky == 'odds_6D') {
						$odds[$k][$ky] = explode('|',$val);
					}
				}
				if (!empty($parent) && $parent['level'] == 5) {
					$cashback = gettotalCash($parent['id'],$v['id']);
				}
				else{
					$cashback = json_decode($v['commission'],true);
				}
				$commission = pdo_fetchcolumn('select commission from '.tablename('agent_odds').' where pid=:id and agent_id=:agent',array(':id'=>$v['id'],':agent'=>$agent_id));
				$my_cashback = pdo_fetchcolumn('select cashback from '.tablename('agent_odds').' where pid=:id and agent_id=:agent',array(':id'=>$v['id'],':agent'=>$agent_id));
				$odds[$k]['has'] = pdo_fetchcolumn('select count(id) from '.tablename('agent_odds').' where pid=:id and agent_id=:agent',array(':id'=>$v['id'],':agent'=>$agent_id));
				$odds[$k]['commission'] = $cashback;
				$odds[$k]['my_commission'] = json_decode($commission,true);
				if (!empty($v['cashback'])) {
					$odds[$k]['my_cashback'] = json_decode($v['cashback'],true);
				}
				else{
					$odds[$k]['my_cashback'] = array(
						'B' => get_cashback_only($odds[$k]['odds_B'],'B',$odds[$k]['commission']['B'],$odds[$k]['my_commission']['B']),
						'S' => get_cashback_only($odds[$k]['odds_S'],'S',$odds[$k]['commission']['S'],$odds[$k]['my_commission']['S']),
						'A' => get_cashback_only(array($v['odds_A'],$v['odds_C2'],$v['odds_C3'],$v['odds_C4'],$v['odds_C5'],$v['odds_EC']),'A',$odds[$k]['commission']['A'],$odds[$k]['my_commission']['A']),
						'3ABC' => get_cashback_only($odds[$k]['odds_3ABC'],'3ABC',$odds[$k]['commission']['3ABC'],$odds[$k]['my_commission']['3ABC']),
						'4A' => get_cashback_only(array($v['odds_4A'],$v['odds_4B'],$v['odds_4C'],$v['odds_4D'],$v['odds_4E'],$v['odds_EA']),'4A',$odds[$k]['commission']['4A'],$odds[$k]['my_commission']['4A']),
						'4ABC' => get_cashback_only($odds[$k]['odds_4ABC'],'4ABC',$odds[$k]['commission']['4ABC'],$odds[$k]['my_commission']['4ABC']),
						'2A' => get_cashback_only(array($v['odds_2A'],$v['odds_2B'],$v['odds_2C'],$v['odds_2D'],$v['odds_2E'],$v['odds_EX']),'2A',$odds[$k]['commission']['2A'],$odds[$k]['my_commission']['2A']),
						'2ABC' => get_cashback_only($odds[$k]['odds_2ABC'],'2ABC',$odds[$k]['commission']['2ABC'],$odds[$k]['my_commission']['2ABC']),
						'5D' => get_cashback_only($odds[$k]['odds_5D'],'5D',$odds[$k]['commission']['5D'],$odds[$k]['my_commission']['5D']),
						'6D' => get_cashback_only($odds[$k]['odds_6D'],'6D',$odds[$k]['commission']['6D'],$odds[$k]['my_commission']['6D']),
					);
				}
				$odds[$k]['cashback'] = json_decode($my_cashback,true)?json_decode($my_cashback,true):array('B'=>0,'S'=>0,'A'=>0,'3ABC'=>0,'4ABC'=>0,'2A'=>0,'2ABC'=>0,'5D'=>0,'6D'=>0);
			}
			$list2[$ke]['odds'] = $odds;
		}
		$limit = pdo_fetchall('select id,title from '.tablename('manji_limit').' order by id desc');
		$company = pdo_fetchall('select id,nickname,has_5D,has_6D from '.tablename('manji_company').' where id<>1 order by id asc');
		$eat_info = pdo_fetch('select * from '.tablename('agent_eat').' where agent_id=:id',array(':id'=>$agent_id));
		$beto = array('B','S','A','C2','C3','C4','C5','EC','3ABC','4A','4B','4C','4D','4E','EA','4ABC','2A','2B','2C','2D','2E','EX','2ABC','5D','6D');
		$eat = json_decode($eat_info['eat'],true);
		foreach ($company as &$com) {
			$eat_com = $eat[$com['id']];
			foreach ($beto as $bet) {
				if (is_array($eat_com)) {
					$com[$bet] = $eat_com[$bet];
				}
				else{
					$com[$bet] = '';
				}
			}
		}
		include $this->template('manager_agent');
		exit;
	}
	
    $total = pdo_fetchcolumn('select count(id) from '.tablename('agent_member')." where 1 {$condition}   " ,$fields);
    $pager = pagination($total,$page,$psize);
}

if ($op == 'recharge') {
    $id = $_GPC['id'];
    $money = $_GPC['money']?intval($_GPC['money']):0;
    $sql = "LOCK TABLE ".tablename('agent_member')." WRITE";
    pdo_run($sql);
    $credit = pdo_fetchcolumn('select credit1 from '.tablename('agent_member').' where id=:id',array(':id'=>$id));
    $new_credit = $credit + $money;
    $res = pdo_update('agent_member',array('credit1'=>$new_credit),array('id'=>$id));
    if ($res) {
        $data = array(
            'status'=>1,
            'info' => '充值成功'
        );
    }
    else{
        $data = array(
            'status'=>0,
            'info' => '充值失败'
        );
    }
    echo json_encode($data);
    pdo_run("UNLOCK TABLES;");
    exit;
}

if ($op == 'get_agent') {

	$agent_id = $_GPC['agent_id'];
	if (empty($agent_id)) {
		$data = array(
			'status' => 2,
			'info' => '请先选择下线'
		);
		echo json_encode($data);
		exit;
	}

	$agent = pdo_fetch('select * from '.tablename('agent_member').' where id=:id',array(':id'=>$agent_id));
	$percent = pdo_fetch('select * from '.tablename('agent_percent').' where agent_id=:agent',array(':agent'=>$agent_id));

	$percent['cashback_percent'] = json_decode($percent['cashback_percent'],true);

	$data = array(
		'status' => 1,
		'agent' => $agent,
		'list' => $percent
	);
	echo json_encode($data);
	exit;
}
if ($op == 'agent_post') {
	$account = $_GPC['account']?$_GPC['account']:'';
    $nickname = $_GPC['nickname']?$_GPC['nickname']:'';
    $password = $_GPC['password']?$_GPC['password']:'';
    $cashback = $_GPC['cashback']?$_GPC['cashback']:array();
    $bonus = $_GPC['bonus']?$_GPC['bonus']:0;
    $jackpot = $_GPC['jackpot']?$_GPC['jackpot']:0;
    $parent_agent = $_GPC['parent_agent']?$_GPC['parent_agent']:0;
    if(empty($nickname)){
        message('请填写昵称',referer(),'error');
    }

    $percent = array(
        'cashback_percent' => json_encode($cashback),
        'bonus_percent' => $bonus,
        'jackpot_percent' => $jackpot
    );

    $data['nickname'] = $nickname;
    if(empty($_GPC['id'])){
        if(!check_account($account)){
            message('账号格式错误',referer(),'error');
        }
        if(empty($password)){
            message('请填写密码',referer(),'error');
        }
        if(has_agent_account($account)){
            message('该代理账号已注册',referer(),'error');
        }
        $data['createtime'] = time();
        $data['password'] = md5(md5($password));
        $data['account'] = $account;
        $data['parent_agent'] = $parent_agent;
        $res = pdo_insert('agent_member',$data);
        $new_id = pdo_insertId();
        if($item['parent_agent']==0){
            $percent['agent_id'] = $new_id;
            pdo_insert('agent_percent',$percent);
        }
    }else{
    	if (!empty($password)) {
    		$data['password'] = md5(md5($password));
    	}
        $res = pdo_update('agent_member',$data,array('id'=>$_GPC['id']));
        if($item['parent_agent']==0){
            $old_percent = pdo_fetchcolumn('select count(id) from '.tablename('agent_percent').' where agent_id=:agent_id',array(':agent_id'=>$_GPC['id']));
            $parent = pdo_fetch('select parent_agent from '.tablename('agent_member').' where id=:id',array(':id'=>$agent_id));
            $parent_percent = pdo_fetchcolumn('select bonus_percent from '.tablename('agent_percent').' where agent_id=:id',array(':id'=>$parent['parent_agent']));
            if ($percent['bonus_percent'] > $parent_percent) {
            	message('花红不能大于上线',referer(),'error');
            }
            if ($old_percent > 0) {
                pdo_update('agent_percent',$percent,array('agent_id'=>$_GPC['id']));
            }
            else{
                $percent['agent_id'] = $_GPC['id'];
                pdo_insert('agent_percent',$percent);
            }
        }
    }
    if($res!==false){
          message('操作成功',referer(),'success');
    }else{
         message('操作失败',referer(),'error');
    }
}

if ($op == 'search_order') {
	include $this->template('search_order');
	exit;
}

if ($op == 'lottery') {
	$tab = $_GPC['tab']?$_GPC['tab']:'list';
	$cid = $_SESSION['cid'];
	if ($tab == 'list') {
		if ($cid > 0) {
			$condition = ' and aid=:aid ';
			$fields[':aid'] = $cid;
		}
	    $list = pdo_fetchall('select date,periods,aid from '.tablename('manji_run_setting')." where status=1 {$condition} group by date order by id desc limit ".($page-1)*$psize.','.$psize,$fields);
	    $total = pdo_fetchcolumn('select count(id) from '.tablename('manji_run_setting')." where status=1 {$condition} group by date ",$fields);
	    foreach ($list as $key => $value) {
	    	$periods = pdo_fetchall('select c.nickname,a.area_name from '.tablename('manji_run_setting').' p left join '.tablename('manji_company').' c on c.id=p.cid left join '.tablename('manji_area').' a on a.id=p.aid where date=:date',array(':date'=>$value['date']));
	    	foreach ($periods as $k => $v) {
	    		$companys[] = $v['nickname'];
	    		$areas[] = $v['area_name'];
	    	}
	    	$companys = array_unique($companys);
	    	$areas = array_unique($areas);
	    	$list[$key]['area'] = implode(',',$areas);
	    	$list[$key]['company'] = implode(',',$companys);
	    }
	    $special = array('','','','','','','','','','');
	    $consolation = array('','','','','','','','','','');
	    $area = pdo_fetchall('select * from '.tablename('manji_area').' order by id asc');
	    if ($cid > 1) {
	    	$company = pdo_fetchall('select * from '.tablename('manji_company').' where id <> 1 order by id asc');
	    }
	    else{
	    	$company = pdo_fetchall('select * from '.tablename('manji_company').' order by id asc');
	    }
	    
	    $pager = pagination($total,$page,$psize);
	}
    if ($tab == 'detail') {
		$date = $_GPC['date']?$_GPC['date']:date('Y-m-d',time());
		if ($cid > 0) {
			$condition = ' and aid='.$cid;
		}
		else{
			$aid = $_GPC['aid']?$_GPC['aid']:1;
			$condition = ' and aid='.$aid;
		}
		$list = pdo_fetchall('select c.nickname,r.first_no,r.second_no,r.third_no,r.consolation_no,r.special_no,s.id,s.cid,r.result_5D,r.result_6D from '.tablename('manji_run_setting').' s left join '.tablename('manji_company').' c on c.id=s.cid left join '.tablename('manji_lottery_record').' r on r.period_id=s.id where s.date=:date '.$condition,array(':date'=>$date));
		foreach ($list as $key => $value) {
			$D5 = pdo_fetchcolumn('select has_5D from '.tablename('manji_company').' where id='.$value['cid']);
			if (!empty($D5)) {
				$list[$key]['5D'] = $value['result_5D']?explode('|',$value['result_5D']):array('','','','','','');
			}
			$D6 = pdo_fetchcolumn('select has_6D from '.tablename('manji_company').' where id='.$value['cid']);
			if (!empty($D6)) {
				$list[$key]['has_6D'] = 1;
				$list[$key]['6D'] = $value['result_6D']?$value['result_6D']:'';
			}
			$list[$key]['consolation_no'] = $value['consolation_no']?explode('|',$value['consolation_no']):array('','','','','','','','','','');
			$list[$key]['special_no'] = array();
			$special = $value['special_no']?explode('|',$value['special_no']):array('','','','','','','','','','');
			foreach ($special as &$v) {
				if ($v != '----') {
					$list[$key]['special_no'][] = $v;
				}
			}
			if ($value['cid'] == 1 && empty($value['first_no'])) {
				unset($list[$key]);
			}
		}
		$area = pdo_fetchall('select id,area_name from '.tablename('manji_area').' order by id asc');
	}
	if ($tab == 'preinstall') {
		$company = pdo_fetchall('select c.*,t.stoptime,t.endtime from '.tablename('manji_company').' c left join '.tablename('manji_preinstall_time').' t on t.cid=c.id where t.aid=:aid order by c.id asc',array(':aid'=>$cid));
		if (empty($company)) {
			$company = pdo_fetchall('select * from '.tablename('manji_company').' order by id asc');
		}
		if ($_W['ispost']) {
			$save = $_GPC['save'];
			foreach ($save as $v) {
				if ($_SESSION['level'] > 1) {
					$old = pdo_fetch('select * from '.tablename('manji_preinstall_time').' where cid=:id and aid=:aid',array(':id'=>$v['id'],':aid'=>$cid));
				}
				else{
					$old = pdo_fetch('select * from '.tablename('manji_preinstall_time').' where cid=:id and aid=1',array(':id'=>$v['id']));
				}
				if (!empty($old)) {
					if ($old['stoptime'] != strtotime('1970-1-1 '.$v['stoptime'])) {
						$data['stoptime'] = strtotime('1970-1-1 '.$v['stoptime']);
					}
					if ($old['endtime'] != strtotime('1970-1-1 '.$v['endtime'])) {
						$data['endtime'] = strtotime('1970-1-1 '.$v['endtime']);
					}
					if (!empty($data)) {
						pdo_update('manji_preinstall_time',$data,array('cid'=>$v['id'],'aid'=>$cid));
					}
				}
				else{
					$data = array(
						'cid' => $v['id'],
						'aid' => $cid,
						'stoptime' => strtotime('1970-1-1 '.$v['stoptime']),
						'endtime' => strtotime('1970-1-1 '.$v['endtime'])
					);
					pdo_insert('manji_preinstall_time',$data);
				}
			}
			$result = array(
				'status' => 1,
				'info' => '保存成功'
			);
			echo json_encode($result);
			exit;
		}
	}
	if ($tab == 'special') {
		if (file_exists('../addons/manji/special_number.txt')) {
			$number = file_get_contents('../addons/manji/special_number.txt');
			$number = explode(',', $number);
			$lot_limmit = file_get_contents('../addons/manji/limit_line.txt');
		}
		if ($_W['ispost']) {
			$special = $_GPC['special'];
			$dividing = $_GPC['dividing'];
			file_put_contents('../addons/manji/special_number.txt', implode(',', $special));
			file_put_contents('../addons/manji/limit_line.txt',$dividing);
			$result = array(
				'status' => 1,
				'info' => '保存成功'
			);
			echo json_encode($result);
			exit;
		}
	}
	if ($tab == 'confirm') {
		$period = pdo_fetchcolumn('select id from '.tablename('manji_run_setting').' where date=:date and cid=1 and aid=1',array(':date'=>'2018-12-31'));
		$record = pdo_fetch('select * from '.tablename('manji_lottery_record').' where period_id=:period_id',array(':period_id'=>$period));
		$record['special_no'] = explode('|', $record['special_no']);
		$record['consolation_no'] = explode('|', $record['consolation_no']);
		include $this->template('confirm_result');
		exit;
	}
	if ($tab == 'get_company') {
		$company = pdo_fetchall('select * from '.tablename('manji_company').$condition.' order by id asc',$fields);
		echo json_encode($company);
		exit;
	}
}

if ($op == 'lottery_post') {
	$periods = $_GPC['periods'];
    if(empty($periods)){
        message('请填写开奖期数',referer(),'error');
    }
    if(empty($_GPC['date'])){
        message('请选择开奖日期',referer(),'error');
    }
    $aid = $_SESSION['cid'];
    $cid = $_GPC['cid']?$_GPC['cid']:array();
    if (count($cid) >0) {
    	foreach ($cid as $v) {
	    	$install = pdo_fetch('select * from '.tablename('manji_preinstall_time').' where cid=:id and aid=:aid',array(':id'=>$v,':aid'=>$aid));
	    	$stoptime = $_GPC['date'].date('H:i',$install['stoptime']);
	    	$endtime = $_GPC['date'].date('H:i',$install['endtime']);
	    	if ($v == 1 && ($aid == 1 || $aid == 0)) {
	    		$area = pdo_fetchColumnValue('select id from '.tablename('manji_area'),array(),'id');
	    		foreach ($area as $key => $value) {
	    			$data = array(
				        'periods' =>$_GPC['periods'],
				        'aid' => $value,
				        'cid' => $v,
				        'stoptime' => strtotime($stoptime),   //开始下注时间
						'endtime' => strtotime($endtime),  //开奖时间
				        'date'=>$_GPC['date'],
				    );
				    $res = pdo_insert('manji_run_setting',$data);
	    		}
	    	}
	    	else{
	    		$data = array(
			        'periods' =>$_GPC['periods'],
			        'aid' => $aid,
			        'cid' => $v,
			        'stoptime' => strtotime($stoptime),   //开始下注时间
					'endtime' => strtotime($endtime),  //开奖时间
			        'date'=>$_GPC['date'],
			    );
			    $res = pdo_insert('manji_run_setting',$data);
	    	}
	    }
    }
    else{
    	$company = pdo_fetchcolumn('select cid from '.tablename('manji_run_setting').' where id=:id',array(':id'=>$_GPC['id']));
    	$install = pdo_fetch('select * from '.tablename('manji_preinstall_time').' where cid=:id',array(':id'=>$company));
    	$stoptime = $_GPC['date'].date('H:i',$install['stoptime']);
    	$endtime = $_GPC['date'].date('H:i',$install['endtime']);
    	$data = array(
	        'stoptime' => strtotime($stoptime),   //开始下注时间
			'endtime' => strtotime($endtime),  //开奖时间
	    );
    	$res = pdo_update('manji_run_setting',$data,array('id'=>$_GPC['id']));
    }
    
    if($res!==false){
        message('操作成功',$this->createWebUrl('lottery'),'success');
    }else{
        message('操作失败',referer(),'error');
    }
}

if ($op == 'agent_earn') {
	$time = $_GPC['time']?$_GPC['time']:date('Y-m-d',time());
	$length = $_GPC['tab'];
	$psize = 500;
	$company = pdo_fetchall('select id,nickname,has_5D,has_6D from '.tablename('manji_company').' where id<>1');
	if ($length == '4D') {
		$filed_list = array('B','S','4A','4B','4C','4D','4E','EA','4ABC');
	}
	elseif ($length == '3D') {
		$filed_list = array('A','C2','C3','C4','C5','EC','3ABC');
	}
	else{
		$filed_list = array('2A','2B','2C','2D','2E','EX','2ABC');
	}
	

	foreach ($company as $k => $v) {
		$list = array();
		foreach ($filed_list as $key => $value) {
			$list[$value] = pdo_fetchall('select number,sum(pay_'.$value.') as '.$value.' from '.tablename('agent_earn').' where date=:date and company_id=:cid and agent_id=:agent group by number order by sum(pay_'.$value.') desc limit '.($page-1)*$psize.','.$psize,array(':date'=>$time,':agent'=>$_SESSION['mid'],':cid'=>$v['id']));
		}
		if ($v['has_5D'] == 1) {
			$list['5D'] = pdo_fetchall('select number,sum(pay_5D) as 5D from '.tablename('agent_earn').' where date=:date and company_id=:cid and agent_id=:agent group by number order by sum(pay_5D) desc limit '.($page-1)*$psize.','.$psize,array(':date'=>$time,':agent'=>$_SESSION['mid'],':cid'=>$v['id']));
		}
		if ($v['has_6D'] == 1) {
			$list['6D'] = pdo_fetchall('select number,sum(pay_6D) as 6D from '.tablename('agent_earn').' where date=:date and company_id=:cid and agent_id=:agent group by number order by sum(pay_6D) desc limit '.($page-1)*$psize.','.$psize,array(':date'=>$time,':agent'=>$_SESSION['mid'],':cid'=>$v['id']));
		}
		$company[$k]['list'] = $list;	
	}
	
	$count = count($filed_list);

}

if ($op == 'search_number') {
	$company = pdo_fetchall('select id,name from '.tablename('manji_company').' order by id asc');
	$type = array('B','S','4A','4B','4C','4D','4E','EA','4ABC','A','C2','C3','C4','C5','EC','3ABC','2A','2B','2C','2D','2E','EX','2ABC');
	if ($_SESSION['level'] >= 4) {
		$agent = pdo_fetchall('select id,account from '.tablename('agent_member').' where parent_agent=:agent',array(':agent'=>$_SESSION['mid']));
		$member = pdo_fetchall('select id,account from '.tablename('member_system_member').' where parent_agent=:agent',array(':agent'=>$_SESSION['mid']));
		$agent = array_merge($agent,$member);
	}
	elseif ($_SESSION['level'] == 2) {
		$agent = pdo_fetchall('select id,account from '.tablename('agent_member').' where cid=:cid and level=4',array(':cid'=>$_SESSION['cid']));
	}
	else{
		$agent = pdo_fetchall('select id,account from '.tablename('agent_member').' where level=4');
	}
	include $this->template('search_number');
	exit;
}

if ($op == 'report') {
	$tab = $_GPC['tab']?$_GPC['tab']:'downline';
	if ($tab == 'reward') {
		$cid = $_SESSION['cid'];
		$agent_id = $_GPC['agent_id'];
		$member_id = $_GPC['member_id'];
		$start = $_GPC['start']?$_GPC['start']:date('Y-m-d',time());
		$end = $_GPC['end']?$_GPC['end']:date('Y-m-d',time());
		$condition = ' where 1 ';
		$range = getDateRound($start,$end);
		$range_str = implode(',', $range);
		if ($_SESSION['cid'] > 0) {
	    	$p_condition = ' and aid='.$_SESSION['cid'];
	    }
		$period_id = pdo_fetchColumnValue('select id from '.tablename('manji_run_setting').' where date in ('.$range_str.')'.$p_condition,array(),'id');
		if (!empty($period_id)) {
			$dates = implode(',',$period_id);
			$condition .= ' and period_id in ('.$dates.')';
		}
		if (!empty($agent_id)) {
			$child = get_children($agent_id);
			$members = pdo_fetchColumnValue('select id from '.tablename('member_system_member').' where parent_agent in ('.implode(',',$child).')',array(),'id');
			if (!empty($child)) {
				$condition .= ' and member_id in ('.implode(',',$members).') ';
			}
		}
		if (!empty($member_id)) {
			$condition .= ' and member_id=:member ';
			$fields[':member'] = $member_id;
		}
		$list = pdo_fetchall('select * from '.tablename('manji_reward_log').$condition.' order by order_time desc limit '.($page-1)*$psize.','.$psize,$fields);
		foreach ($list as $key => $value) {
			$pid = pdo_fetchcolumn('select pid from '.tablename('manji_order').' where id=:id',array(':id'=>$value['order_id']));
			$list[$key]['ordersn'] = pdo_fetchcolumn('select ordersn from '.tablename('manji_order').' where id=:pid',array(':pid'=>$pid));
			$list[$key]['uordersn'] = pdo_fetchcolumn('select uordersn from '.tablename('manji_order').' where id=:pid',array(':pid'=>$pid));
		}

		$total = pdo_fetchcolumn('select count(id) from '.tablename('manji_reward_log').$condition.' order by create_time desc',$fields);

		$pager = pagination($total,$page,$psize);
	}
	if ($tab == 'sum_bet') {
		$agent_id = $_GPC['agent_id'];
		$member_id = $_GPC['member_id'];
		$start = $_GPC['start']?$_GPC['start']:date('Y-m-d',time());
		$end = $_GPC['end']?$_GPC['end']:date('Y-m-d',time());
		$condition = '';
		$range = getDateRound($start,$end);
		$range_str = implode(',', $range);
		$company = pdo_fetchall('select * from '.tablename('manji_company'));
		if ($_SESSION['cid'] > 0) {
	    	$p_condition = ' and aid='.$_SESSION['cid'];
	    }
		$period_id = pdo_fetchColumnValue('select id from '.tablename('manji_run_setting').' where date in ('.$range_str.')'.$p_condition,array(),'id');
		if (!empty($period_id)) {
			foreach ($period_id as $p => $pp) {
				if ($p == 0) {
					$condition .= ' and (o.period_id like \'%('.$pp.')%\' ';
				}
				else{
					$condition .= ' or o.period_id like \'%('.$pp.')%\' ';
				}
			}
			$condition .= ')';
		}
		if (!empty($agent_id)) {
			$child = get_children($agent_id);
			$members = pdo_fetchColumnValue('select id from '.tablename('member_system_member').' where parent_agent in ('.implode(',',$child).')',array(),'id');
			if (!empty($child)) {
				$condition .= ' and o.user_id in ('.implode(',',$members).') ';
			}
		}
		if (!empty($member_id)) {
			$condition .= ' and o.user_id=:member ';
			$fields[':member'] = $member_id;
		}
		$odds = array('B','S','4A','4B','4C','4D','4E','EA','4ABC','A','C2','C3','C4','C5','EC','3ABC','2A','2B','2C','2D','2E','EX','2ABC');
		$filed_list = array('sum(d.pay_B*(100+false_price)/100) as B','sum(d.pay_S*(100+false_price)/100) as S','sum(d.pay_4A*(100+false_price)/100) as 4A','sum(d.pay_4B*(100+false_price)/100) as 4B','sum(d.pay_4C*(100+false_price)/100) as 4C','sum(d.pay_4D*(100+false_price)/100) as 4D','sum(d.pay_4E*(100+false_price)/100) as 4E','sum(d.pay_EA*(100+false_price)/100) as EA','sum(d.pay_4ABC*(100+false_price)/100) as 4ABC','sum(d.pay_A*(100+false_price)/100) as A','sum(d.pay_C2*(100+false_price)/100) as C2','sum(d.pay_C3*(100+false_price)/100) as C3','sum(d.pay_C4*(100+false_price)/100) as C4','sum(d.pay_C5*(100+false_price)/100) as C5','sum(d.pay_EC*(100+false_price)/100) as EC','sum(d.pay_3ABC*(100+false_price)/100) as 3ABC','sum(d.pay_2A*(100+false_price)/100) as 2A','sum(d.pay_2B*(100+false_price)/100) as 2B','sum(d.pay_2C*(100+false_price)/100) as 2C','sum(d.pay_2D*(100+false_price)/100) as 2D','sum(d.pay_2E*(100+false_price)/100) as 2E','sum(d.pay_EX*(100+false_price)/100) as EX','sum(d.pay_2ABC*(100+false_price)/100) as 2ABC');
		foreach ($company as $k => $v) {
			$number_list = array();
			$list = pdo_fetchall('select d.number,'.implode(',',$filed_list).' from '.tablename('manji_order_detail').' d left join '.tablename('manji_order').' o on d.order_id=o.id where o.status=1 and o.cid like \'%('.$v['id'].')%\' '.$condition.' group by d.number ',$fields);
			if (!empty($list)) {
				foreach ($odds as $val) {
					$total[$val] = 0;
					foreach ($list as $value) {
						if ($value[$val] > 0) {
							$number_list[$val][] = array(
								'number' => $value['number'],
								'money' => $value[$val]
							);
							$total[$val] += $value[$val];
						}
					}
				}
			}
			$company[$k]['list'] = $number_list;
			$company[$k]['total'] = $total;
		}

		include $this->template('sum_bet');
		exit;
	}
	if ($tab == 'jackpot') {
		$cid = $_SESSION['cid'];
		$agent_id = $_GPC['agent_id'];
		$member_id = $_GPC['member_id'];
		$start = $_GPC['start']?$_GPC['start']:date('Y-m-d',time());
		$end = $_GPC['end']?$_GPC['end']:date('Y-m-d',time());
		$condition = ' where 1 ';
		$range = getDateRound($start,$end);
		$range_str = implode(',', $range);
		if ($_SESSION['cid'] > 0) {
	    	$p_condition = ' and aid='.$_SESSION['cid'];
	    }
		$period_id = pdo_fetchColumnValue('select id from '.tablename('manji_run_setting').' where date in ('.$range_str.')'.$p_condition,array(),'id');
		if (!empty($period_id)) {
			$dates = implode(',',$period_id);
			$condition .= ' and j.period_id in ('.$dates.')';
		}
		if (!empty($agent_id)) {
			$child = get_children($agent_id);
			$members = pdo_fetchColumnValue('select id from '.tablename('member_system_member').' where parent_agent in ('.implode(',',$child).')',array(),'id');
			if (!empty($child)) {
				$condition .= ' and j.user_id in ('.implode(',',$members).') ';
			}
		}
		if (!empty($member_id)) {
			$condition .= ' and j.user_id=:member ';
			$fields[':member'] = $member_id;
		}
		$list = pdo_fetchall('select j.*,o.ordersn,o.uordersn from '.tablename('manji_jackpot_log').' j left join '.tablename('manji_order').' o on o.id=j.order_id '.$condition.' order by order_id asc limit '.($page-1)*$psize.','.$psize,$fields);
		$total = pdo_fetchcolumn('select count(1) from '.tablename('manji_jackpot_log').' j left join '.tablename('manji_order').' o on o.id=j.order_id '.$condition.' order by order_id asc ',$fields);
		$pager = pagination($total,$page,$psize);
		include $this->template('jackpot');
		exit;
	}
	if ($tab == 'downline') {
		$line_id = $_GPC['id']?$_GPC['id']:0;
		if ($_SESSION['level'] == 5 && $line_id == 0) {
			$line_id = $_SESSION['mid'];
		}
		$parents_id = getParent($line_id);
		$agent_info = pdo_fetch('select account,nickname from '.tablename('agent_member').' where id=:id',array(':id'=>$line_id));
		$account = '';
		$area = $_SESSION['cid'];
		if (count($parents_id)>0) {
			$parents_fields = implode(',',$parents_id);
			$parents = pdo_fetchall('select account,nickname,id from '.tablename('agent_member').' where id in ('.$parents_fields.') order by id asc');
			foreach ($parents as $key => $value) {
				if ($key == 0) {
					$account .= '<a href="'.$this->createMobileUrl('manager',array('op'=>'report','tab'=>'downline','id'=>$value['id'])).'">'.$value['account'].'</a>';
				}
				else{
					$account .= '><a href="'.$this->createMobileUrl('manager',array('op'=>'report','tab'=>'downline','id'=>$value['id'])).'">'.$value['account'].'</a>';
				}
			}
		}
		if ($account != '') {
			$account .= '>'.$agent_info['account'];
		}
		else{
			$account .= $agent_info['account'];
		}
		$stime = $_GPC['stime']?$_GPC['stime']:date('Y-m-d',time());
		$etime = $_GPC['etime']?$_GPC['etime']:date('Y-m-d',time());
		if ($_SESSION['cid'] > 0) {
	    	$p_condition = ' and aid='.$_SESSION['cid'];
	    }
		$range = getDateRound($stime,$etime);
		$range_str = implode(',', $range);
		$period_id = pdo_fetchColumnValue('select id from '.tablename('manji_run_setting').' where date in ('.$range_str.')'.$p_condition,array(),'id');
		if (!empty($period_id)) {
			$condition .= ' and periods_id in ('.implode(',', $period_id).')';
			$t_condition .= ' and period_id in ('.implode(',', $period_id).')';
		}
		else{
			$condition .= ' and periods_id = 0 ';
			$t_condition .= ' and period_id = 0 ';
		}
		$report_area = $_GPC['area'];
		if ($_SESSION['level'] > 1) {
			$condition .= ' and cid='.$_SESSION['cid'];
		}
		if ($report_area == 'JB') {
			$list3 = pdo_fetchall('select agent_id,sum(sum_bet) as sum_bet,sum(eat) as eat,sum(eat_surplus) as eat_surplus,sum(cashback) as cashback,sum(pay_award) as pay_award,sum(profit) as profit,sum(bonus) as bonus,sum(net) as net,sum(eat_own) as eat_own,sum(cashback_own) as cashback_own,sum(pay_award_own) as pay_award_own,sum(profit_own) as profit_own,sum(upline_sum_bet) as upline_sum_bet,sum(upline_pay_award) as upline_pay_award,sum(upline_cashback) as upline_cashback,sum(upline_profit) as upline_profit,sum(upline_bonus) as upline_bonus,sum(upline_net) as upline_net,sum(commission) as commission,sum(bonus_earn) as bonus_earn,sum(jackpot) as jackpot from '.tablename('manji_downline_report').' where  company=1 and agent_id>0 and parent_agent=:agent '.$condition.' group by agent_id',array(':agent'=>$line_id));
			$list4 = pdo_fetchall('select member_id,sum(sum_bet) as sum_bet,sum(eat) as eat,sum(eat_surplus) as eat_surplus,sum(cashback) as cashback,sum(pay_award) as pay_award,sum(profit) as profit,sum(bonus) as bonus,sum(net) as net,sum(eat_own) as eat_own,sum(cashback_own) as cashback_own,sum(pay_award_own) as pay_award_own,sum(profit_own) as profit_own,sum(upline_sum_bet) as upline_sum_bet,sum(upline_pay_award) as upline_pay_award,sum(upline_cashback) as upline_cashback,sum(upline_profit) as upline_profit,sum(upline_bonus) as upline_bonus,sum(upline_net) as upline_net,sum(commission) as commission,sum(bonus_earn) as bonus_earn,sum(jackpot) as jackpot from '.tablename('manji_downline_report').' where company=1 and member_id>0 and parent_agent=:agent '.$condition.' group by member_id',array(':agent'=>$line_id));
			$list_jb_total = pdo_fetch('select sum(sum_bet) as sum_bet,sum(cashback) as cashback,sum(bonus) as bonus,sum(pay_award) as pay_award,sum(profit) as profit from '.tablename('manji_total_report').' where 1'.$t_condition,array());
			$list_jb = array_merge($list3,$list4);
			$list_total = array(
				'sum_bet' => 0,
				'cashback' => 0,
				'bonus_percent' => 0,
				'profit' => 0,
				'bonus' => 0,
				'upline_sum_bet' => 0,
				'upline_cashback' => 0,
				'upline_pay_award' => 0,
				'upline_profit' => 0,
				'upline_bonus_percent' => 0,
				'upline_bonus' => 0,
				'commission' => 0,
				'bonus_earn' => 0
			);
			foreach ($list_jb as &$jb) {
				if ($jb['agent_id'] > 0) {
					$agent = pdo_fetch('select * from '.tablename('agent_member').' where id=:id',array(':id'=>$jb['agent_id']));
					$jb['bonus_percent'] = pdo_fetchcolumn('select bonus_percent from '.tablename('agent_percent').' where agent_id=:id',array(':id'=>$agent['id']));
					$jb['upline_bonus_percent'] = pdo_fetchcolumn('select bonus_percent from '.tablename('agent_percent').' where agent_id=:id',array(':id'=>$agent['parent_agent']));
					$jb['account'] = $agent['account'];
					$jb['nickname'] = $agent['nickname'];
					$jb['user_type'] = 1;
				}
				else{
					$member = pdo_fetch('select * from '.tablename('member_system_member').' where id=:id',array(':id'=>$jb['member_id']));
					$jb['upline_bonus_percent'] = pdo_fetchcolumn('select bonus_percent from '.tablename('agent_percent').' where agent_id=:id',array(':id'=>$member['parent_agent']));
					$jb['account'] = $member['account'];
					$jb['nickname'] = $member['nickname'];
					$jb['user_type'] = 2;
				}
				$list_total['sum_bet'] += $jb['sum_bet'];
				$list_total['cashback'] += $jb['cashback'];
				$list_total['pay_award'] += $jb['pay_award'];
				$list_total['jackpot'] += $jb['jackpot'];
				$list_total['profit'] += $jb['profit'];
				$list_total['bonus'] += $jb['bonus'];
				$list_total['upline_sum_bet'] += $jb['upline_sum_bet'];
				$list_total['upline_cashback'] += $jb['upline_cashback'];
				$list_total['upline_pay_award'] += $jb['upline_pay_award'];
				$list_total['upline_profit'] += $jb['upline_profit'];
				$list_total['upline_bonus'] += $jb['upline_bonus'];
				$list_total['commission'] += $jb['commission'];
				$list_total['bonus_earn'] += $jb['bonus_earn'];
			}
			include $this->template('report');
			exit;
		}
		if ($report_area == 'OT') {
			$list1 = pdo_fetchall('select agent_id,sum(sum_bet) as sum_bet,sum(eat) as eat,sum(eat_surplus) as eat_surplus,sum(cashback) as cashback,sum(pay_award) as pay_award,sum(profit) as profit,sum(bonus) as bonus,sum(net) as net,sum(eat_own) as eat_own,sum(cashback_own) as cashback_own,sum(pay_award_own) as pay_award_own,sum(profit_own) as profit_own,sum(upline_sum_bet) as upline_sum_bet,sum(upline_pay_award) as upline_pay_award,sum(upline_cashback) as upline_cashback,sum(upline_profit) as upline_profit,sum(upline_bonus) as upline_bonus,sum(upline_net) as upline_net,sum(commission) as commission,sum(bonus_earn) as bonus_earn,sum(jackpot) as jackpot from '.tablename('manji_downline_report').' where company<>1 and agent_id>0 and parent_agent=:agent '.$condition.' group by agent_id',array(':agent'=>$line_id));
			$list2 = pdo_fetchall('select member_id,sum(sum_bet) as sum_bet,sum(eat) as eat,sum(eat_surplus) as eat_surplus,sum(cashback) as cashback,sum(pay_award) as pay_award,sum(profit) as profit,sum(bonus) as bonus,sum(net) as net,sum(eat_own) as eat_own,sum(cashback_own) as cashback_own,sum(pay_award_own) as pay_award_own,sum(profit_own) as profit_own,sum(upline_sum_bet) as upline_sum_bet,sum(upline_pay_award) as upline_pay_award,sum(upline_cashback) as upline_cashback,sum(upline_profit) as upline_profit,sum(upline_bonus) as upline_bonus,sum(upline_net) as upline_net,sum(commission) as commission,sum(bonus_earn) as bonus_earn,sum(jackpot) as jackpot from '.tablename('manji_downline_report').' where company<>1 and member_id>0 and parent_agent=:agent '.$condition.' group by member_id',array(':agent'=>$line_id));
			$list_other = array_merge($list1,$list2);
			$list_total = array(
				'sum_bet' => 0,
				'cashback' => 0,
				'bonus_percent' => 0,
				'profit' => 0,
				'bonus' => 0,
				'upline_sum_bet' => 0,
				'upline_cashback' => 0,
				'upline_pay_award' => 0,
				'upline_profit' => 0,
				'upline_bonus_percent' => 0,
				'upline_bonus' => 0,
				'commission' => 0,
				'bonus_earn' => 0
			);
			foreach ($list_other as &$ot) {
				if ($ot['agent_id'] > 0) {
					$agent = pdo_fetch('select * from '.tablename('agent_member').' where id=:id',array(':id'=>$ot['agent_id']));
					$ot['bonus_percent'] = pdo_fetchcolumn('select bonus_percent from '.tablename('agent_percent').' where agent_id=:id',array(':id'=>$agent['id']));
					$ot['upline_bonus_percent'] = pdo_fetchcolumn('select bonus_percent from '.tablename('agent_percent').' where agent_id=:id',array(':id'=>$agent['parent_agent']));
					$ot['account'] = $agent['account'];
					$ot['nickname'] = $agent['nickname'];
					$ot['user_type'] = 1;
				}
				else{
					$agent = pdo_fetch('select * from '.tablename('member_system_member').' where id=:id',array(':id'=>$ot['member_id']));
					$ot['account'] = $agent['account'];
					$ot['nickname'] = $agent['nickname'];
					$ot['user_type'] = 2;
				}
				$list_total['sum_bet'] += $ot['sum_bet'];
				$list_total['cashback'] += $ot['cashback'];
				$list_total['profit'] += $ot['profit'];
				$list_total['jackpot'] += $ot['jackpot'];
				$list_total['bonus'] += $ot['bonus'];
				$list_total['upline_sum_bet'] += $ot['upline_sum_bet'];
				$list_total['upline_cashback'] += $ot['upline_cashback'];
				$list_total['upline_pay_award'] += $ot['upline_pay_award'];
				$list_total['upline_bonus'] += $ot['upline_bonus'];
				$list_total['commission'] += $ot['commission'];
				$list_total['bonus_earn'] += $ot['bonus_earn'];
			}
			include $this->template('report');
			exit;
		}
		
		// print_r($list_jb);exit;
	}
}

if ($op == 'search_all') {
	$cid = $_SESSION['cid'];
	$start = $_GPC['start']?$_GPC['start']:date('Y-m-d',time());
	$end = $_GPC['end']?$_GPC['end']:date('Y-m-d',time());
	$number = $_GPC['number'];
	$id = $_GPC['id'];
	$ordersn = $_GPC['ordersn'];
	$name = $_GPC['name'];
	$status = $_GPC['status'];
	$uordersn = $_GPC['uordersn'];
	$hard = $_GPC['hard'];
	$so = $_GPC['so'];
	$page = $_GPC['page']>0?$_GPC['page']:1;
	$psize = 50;
	$condition = ' where pid=0 ';
	if ($_SESSION['cid'] > 0) {
		$condition .= ' and m.cid=:cid ';
		$fields[':cid'] = $_SESSION['cid'];
		$p_condition = ' and aid='.$_SESSION['cid'].' ';
	}
	$range = getDateRound($start,$end);
	$range_str = implode(',', $range);
	$period_id = pdo_fetchall('select id from '.tablename('manji_run_setting').' where date in ('.$range_str.')'.$p_condition);
	if (!empty($period_id)) {
		foreach ($period_id as $p => $pp) {
			if ($p == 0) {
				$o_condition .= ' and (period_id like \'%('.$pp['id'].'%)\' ';
			}
			else{
				$o_condition .= ' or period_id like \'%('.$pp['id'].')%\' ';
			}
		}
		$o_condition .= ')';
		$orders = pdo_fetchColumnValue('select pid from '.tablename('manji_order').' where pid>0 '.$o_condition.' group by pid',array(),'pid');
		if (!empty($orders)) {
			$condition .= ' and o.id in ('.implode(',', $orders).') ';
			$d_condition .= ' and o.pid in ('.implode(',', $orders).') ';
		}
		else{
			$condition .= ' and o.id=0 ';
		}
	}
	else{
		$condition .= ' and o.id=0 ';
	}
	if (!empty($number)) {
		$order_ids = pdo_fetchColumnValue('select o.pid as pid from '.tablename('manji_order_detail').' d left join '.tablename('manji_order').' o on o.id=d.order_id where d.number=:number '.$d_condition,array(':number'=>$number),'pid');
		if (!empty($order_ids)) {
			$order_id = implode(',', $order_ids);
			$condition .= ' and o.id in ('.$order_id.') ';
		}
		else{
			$condition .= ' and o.id=0 ';
		}
	}
	if (!empty($id)) {
		$condition .= ' and m.account=:user_id ';
		$fields[':user_id'] = $id;
	}
	if (!empty($name)) {
		$condition .= ' and m.nickname like :name ';
		$fields[':name'] = '%'.$name.'%';
	}
	if (!empty($ordersn)) {
		$condition .= ' and ordersn=:ordersn ';
		$fields[':ordersn'] = $ordersn;
	}
	if (!empty($status)) {
		$condition .= ' and o.status=:status ';
		$fields[':status'] = $status;
	}
	if (!empty($uordersn)) {
		$condition .= ' and uordersn=:uordersn ';
		$fields[':uordersn'] = $uordersn;
	}
	if (!empty($hard)) {
		$order_ids = pdo_fetchColumnValue('select o.pid as pid from '.tablename('manji_order_detail').' d left join '.tablename('manji_order').' o on o.id=d.order_id where d.source like :source '.$d_condition,array(':source'=>'%'.$hard.'%'),'pid');
		if (!empty($order_ids)) {
			$order_id = implode(',', $order_ids);
			$condition .= ' and o.id in ('.$order_id.') ';
		}
		else{
			$condition .= ' and o.id=0 ';
		}
	}
	if ($so == 1) {
		$order_ids = pdo_fetchColumnValue('select o.pid as pid from '.tablename('manji_sale_out').' d left join '.tablename('manji_order').' o on o.id=d.order_id where 1 '.$d_condition,array(),'pid');
		if (!empty($order_ids)) {
			$order_id = implode(',', $order_ids);
			$condition .= ' and o.id in ('.$order_id.') ';
		}
		else{
			$condition .= ' and o.id=0 ';
		}
	}

	if ($so == 2) {
		$order_ids = pdo_fetchcolumn('select o.pid as pid from '.tablename('manji_sale_out').' d left join '.tablename('manji_order').' o on o.id=d.order_id where 1 '.$d_condition,array(),'pid');
		if (!empty($order_ids)) {
			$order_id = implode(',', $order_ids);
			$condition .= ' and o.id not in ('.$order_id.') ';
		}
	}

	$list = pdo_fetchall('select o.*,m.nickname,m.parent_agent,m.mobile,m.account from '.tablename('manji_order').' o left join '.tablename('member_system_member').' m on m.id=o.user_id '.$condition.' order by o.createtime desc limit '.($page-1)*$psize.','.$psize,$fields);
	foreach ($list as $key => $value) {
		$list[$key]['period_time'] = pdo_fetchcolumn('select endtime from '.tablename('manji_run_setting').' where id=:id',array(':id'=>$periods[0]));
		$list[$key]['has_sale_out'] = pdo_fetchcolumn('select count(*) from '.tablename('manji_sale_out').' s left join '.tablename('manji_order').' o on o.id=s.order_id where o.pid=:id',array(':id'=>$value['id']));
		$list[$key]['control_agent'] = pdo_fetchcolumn('select account from '.tablename('agent_member').' where id=:id',array(':id'=>$value['create_agent']));
		$periods = pdo_fetchColumnValue('select period_id from '.tablename('manji_order').' where pid=:pid',array(':pid'=>$value['id']),'period_id');
		$new_periods = array();
		foreach ($periods as $per) {
			if (!empty($per)) {
				$per = str_replace('(', '', $per);
				$per = str_replace(')', '', $per);
				$per = explode(',',$per);
				$new_periods = array_merge($new_periods,$per);
			}
		}
		$new_periods = array_unique($new_periods);

		if (count($new_periods) > 0) {
			$date = pdo_fetch('select date from '.tablename('manji_run_setting').' where id in ('.implode(',',$new_periods).') order by endtime asc limit 0,1');
			$list[$key]['period_time'] = strtotime($date['date']);
		}
		$account = '';
		$agent = getParent($value['parent_agent']);
		if (count($agent) > 0) {
			$agent_info = pdo_fetch('select account,nickname,parent_agent from '.tablename('agent_member').' where id=:id',array(':id'=>$value['parent_agent']));
			$parents_fields = implode(',',$agent);
			$parents = pdo_fetchall('select account,nickname,id from '.tablename('agent_member').' where id in ('.$parents_fields.') order by id asc');
			foreach ($parents as $k => $v) {
				if ($k == 0) {
					$account .= $v['account'];
				}
				else{
					$account .= '>'.$v['account'];
				}
			}
		}
		if ($account != '') {
			$account .= '>'.$agent_info['account'];
		}
		else{
			$account .= $agent_info['account'];
		}
		$list[$key]['agent'] = $account;
	}
	$total = pdo_fetchcolumn('select count(*) from '.tablename('manji_order').' o left join '.tablename('member_system_member').' m on m.id=o.user_id '.$condition.' order by o.createtime desc ',$fields);
	$pager = pagination($total,$page,$psize);
	include $this->template('search_all');
	exit;
}

if ($op == 'get_periods') {
	$item = pdo_fetch('select * from '.tablename('manji_run_setting')." where id=:id",array(':id'=>$_GPC['id']));
	if (!empty($item)) {
		$item['area'] = pdo_fetchcolumn('select area_id from '.tablename('manji_company').' where id=:id',array(':id'=>$item['cid']));
		$item['company'] = pdo_fetchcolumn('select name from '.tablename('manji_company').' where id=:id',array(':id'=>$item['cid']));
		$item['date'] = date('Y-m-d',$item['stoptime']);
		$data = array(
			'status' => 1,
			'periods' => $item
		);
		echo json_encode($data);
		exit;
	}
	else{
		$data = array(
			'status' => 2,
			'info' => '找不到该期'
		);
		echo json_encode($data);
		exit;
	}
}

if ($op == 'operation') {
	$keyword = $_GPC['keyword'];
	if (!empty($keyword)) {
		$condition = ' and operation like :keyword ';
		$fields[':keyword'] = '%'.$keyword.'%';
	}
	if (!empty($_GPC{'start'}) || !empty($_GPC['end'])) {
		$start = strtotime($_GPC['start'].' 00:00:00');
		$end = strtotime($_GPC['end'].' 23:59:59');
		$condition = ' and create_time between :start and :end ';
		$fields[':start'] = $start;
		$fields[':end'] = $end;
	}
	
	$list = pdo_fetchall('select * from '.tablename('agent_operation').' where 1 '.$condition.' order by create_time desc limit '.($page-1)*$psize.','.$psize,$fields);
	$total = pdo_fetchcolumn('select count(id) from '.tablename('agent_operation').' where 1 '.$condition.' order by create_time desc',$fields);
	$pager = pagination($total,$page,$psize);
}


include $this->template('manager');

 ?>