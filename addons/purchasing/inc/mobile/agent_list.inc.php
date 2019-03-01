<?php 
global $_W,$_GPC;
$mid = $_SESSION['mid'];
$op = $_GPC['op'];

if (empty($mid)) {
    message('请先登录',$this->createMobileUrl('login'),'error');
    exit;
}
$open_time = pdo_fetchall('select p.endtime,c.nickname from '.tablename('manji_preinstall_time').' p left join '.tablename('manji_company').' c on c.id=p.cid where aid=:aid',array(':aid'=>$_SESSION['cid']));
$manager = pdo_fetch('select * from '.tablename('agent_member').' where id=:id',array(':id'=>$_SESSION['mid']));
$disc_name = pdo_fetchcolumn('select area_name from '.tablename('manji_area').' where id=:id',array(':id'=>$_SESSION['cid']));

$page = $_GPC['page']>0?$_GPC['page']:1;
$psize = 25;
if ($op == 'addMember') {
    $commission = array(
        'B' => 0,
        'S' => 0,
        'A' => 0,
        '3ABC' => 0,
        '4A' => 0,
        '4ABC' => 0,
        '2A' => 0,
        '2ABC' => 0
    );
    $agent_id = $_GPC['agent_id'];
    if ($_SESSION['level'] == 5 && empty($agent_id)) {
        $agent_id = $mid;
    }
    $odds1 = pdo_fetchall('select a.* from '.tablename('agent_odds').' a left join '.tablename('manji_odds').' o on o.id=a.pid where o.cid=:cid and a.agent_id=:agent',array(':cid'=>1,':agent'=>$agent_id));
    $odds2 = pdo_fetchall('select a.* from '.tablename('agent_odds').' a left join '.tablename('manji_odds').' o on o.id=a.pid where o.cid=:cid and a.agent_id=:agent',array(':cid'=>$_SESSION['cid'],':agent'=>$agent_id));
    $list1 = $list2 = pdo_fetchall('select * from '.tablename('manji_odds_group').' order by id asc');
    foreach ($list1 as $key => $value) {
        $odds = pdo_fetchall('select o.* from '.tablename('agent_odds').' a left join '.tablename('manji_odds').' o on o.id=a.pid where o.cid=1 and o.gid=:gid and a.agent_id=:agent order by id asc',array(':gid'=>$value['id'],':agent'=>$agent_id));
        foreach ($odds as $k => $v) {
            foreach ($v as $ky => $val) {
                if ($ky == 'odds_B' || $ky == 'odds_S' || $ky == 'odds_3ABC' || $ky == 'odds_4ABC' || $ky == 'odds_2ABC' || $ky == 'odds_5D' || $ky == 'odds_6D') {
                    $odds[$k][$ky] = explode('|',$val);
                }
            }
            if (!empty($member)) {
                $cashback = gettotalCash($agent_id,$v['id']);
            }
            else{
                $cashback = json_decode($v['commission'],true);
            }
            $odds[$k]['commission'] = $cashback;
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
        $list1[$key]['odds'] = $odds;
    }
    foreach ($list2 as $ke => $vall) {
        $odds = pdo_fetchall('select o.* from '.tablename('agent_odds').' a left join '.tablename('manji_odds').' o on o.id=a.pid where o.cid=:cid and o.gid=:gid and a.agent_id=:agent order by id asc',array(':gid'=>$vall['id'],':cid'=>$_SESSION['cid'],':agent'=>$agent_id));
        foreach ($odds as $k => $v) {
            foreach ($v as $ky => $val) {
                if ($ky == 'odds_B' || $ky == 'odds_S' || $ky == 'odds_3ABC' || $ky == 'odds_4ABC' || $ky == 'odds_2ABC' || $ky == 'odds_5D' || $ky == 'odds_6D') {
                    $odds[$k][$ky] = explode('|',$val);
                }
            }
            if (!empty($member)) {
                $cashback = gettotalCash($agent_id,$v['id']);
            }
            else{
                $cashback = json_decode($v['commission'],true);
            }
            $odds[$k]['commission'] = $cashback;
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
        $list2[$ke]['odds'] = $odds;
    }
}

if ($op == 'addAgent') {
    $agent_id = $_GPC['agent_id'];
    if ($_SESSION['level'] == 5 && empty($agent_id)) {
        $agent_id = $mid;
    }
    $member = pdo_fetch('select * from '.tablename('agent_member').' where id=:id',array(':id'=>$agent_id));
    $list1 = $list2 = pdo_fetchall('select * from '.tablename('manji_odds_group').' order by id asc');
    foreach ($list1 as $key => $value) {
        if (!empty($member)) {
            $odds = pdo_fetchall('select o.* from '.tablename('agent_odds').' a left join '.tablename('manji_odds').' o on o.id=a.pid where o.cid=1 and o.gid=:gid and a.agent_id=:agent order by id asc',array(':gid'=>$value['id'],':agent'=>$agent_id));
        }
        else{
            $odds = pdo_fetchall('select * from '.tablename('manji_odds').' where cid=1 and gid=:gid',array(':gid'=>$value['id']));
        }
        foreach ($odds as $k => $v) {
            foreach ($v as $ky => $val) {
                if ($ky == 'odds_B' || $ky == 'odds_S' || $ky == 'odds_3ABC' || $ky == 'odds_4ABC' || $ky == 'odds_2ABC' || $ky == 'odds_5D' || $ky == 'odds_6D') {
                    $odds[$k][$ky] = explode('|',$val);
                }
            }
            if (!empty($member)) {
                $cashback = gettotalCash($agent_id,$v['id']);
            }
            else{
                $cashback = json_decode($v['commission'],true);
            }
            $odds[$k]['commission'] = $cashback;
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
        $list1[$key]['odds'] = $odds;
    }
    foreach ($list2 as $ke => $vall) {
        if (!empty($member)) {
            $odds = pdo_fetchall('select o.* from '.tablename('agent_odds').' a left join '.tablename('manji_odds').' o on o.id=a.pid where o.cid=:cid and o.gid=:gid and a.agent_id=:agent order by id asc',array(':gid'=>$vall['id'],':cid'=>$_SESSION['cid'],':agent'=>$agent_id));
        }
        else{
            $odds = pdo_fetchall('select * from '.tablename('manji_odds').' where cid=:cid and gid=:gid',array(':cid'=>$_SESSION['cid'],':gid'=>$vall['id']));
        }
        foreach ($odds as $k => $v) {
            foreach ($v as $ky => $val) {
                if ($ky == 'odds_B' || $ky == 'odds_S' || $ky == 'odds_3ABC' || $ky == 'odds_4ABC' || $ky == 'odds_2ABC' || $ky == 'odds_5D' || $ky == 'odds_6D') {
                    $odds[$k][$ky] = explode('|',$val);
                }
            }
            if (!empty($member)) {
                $cashback = gettotalCash($agent_id,$v['id']);
            }
            else{
                $cashback = json_decode($v['commission'],true);
            }
            $odds[$k]['commission'] = $cashback;
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
        $list2[$ke]['odds'] = $odds;
    }
    $company = pdo_fetchall('select id,nickname,has_5D,has_6D from '.tablename('manji_company').' where id<>1 order by id asc');
    $beto = array('B','S','A','C2','C3','C4','C5','EC','3ABC','4A','4B','4C','4D','4E','EA','4ABC','2A','2B','2C','2D','2E','EX','2ABC','5D','6D');
    $eat = json_decode($eat,true);
}
include $this->template('agent_list');
exit;
 ?>