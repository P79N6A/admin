<?php 
global $_W,$_GPC;
$op = $_GPC['op']?$_GPC['op']:'display';
$page = $_GPC['page']>0?$_GPC['page']:1;
$psize = 20;
if ($op == 'display') {
	$periods = pdo_fetch('select max(id) as id from '.tablename('manji_run_setting'));

	$list = pdo_fetchall('select distinct number from '.tablename('manji_order').' where period_id=:id',array(':id'=>$periods['id']));

	if (!empty($list)) {
		foreach ($list as $key => $value) {
			$list[$key]['bet_total'] = pdo_fetchcolumn('select sum(order_amount) from '.tablename('manji_order').' where number=:number and period_id=:id',array(':number'=>$value['number'],':id'=>$periods['id']));
			$list[$key]['bet_number'] = pdo_fetchcolumn('select count(id) from '.tablename('manji_order').' where number=:number and period_id=:id',array(':number'=>$value['number'],':id'=>$periods['id']));
			$pay_award += check_B($periods['id'], $value['number'], 1);  //头等奖
			$pay_award += check_B($periods['id'], $value['number'], 2);  //二等奖
			$pay_award += check_B($periods['id'], $value['number'], 3);  //三等奖
			$pay_award += check_B($periods['id'], $value['number'], 4);  //特别奖
			$pay_award += check_B($periods['id'], $value['number'], 5);  //安慰奖

			//4A计算，只算头奖
			$pay_award += check_4A($periods['id'], $value['number'], 1);  //头等奖
			$pay_award += check_4B($periods['id'], $value['number'], 2);  //二等奖
			$pay_award += check_4C($periods['id'], $value['number'], 3);  //三等奖
			$pay_award += check_4D($periods['id'], $value['number'], 4);  //特别奖
			$pay_award += check_4E($periods['id'], $value['number'], 5);  //安慰奖
			$pay_award += check_EA($periods['id'], $value['number'], 1);  //头等奖
			
			
			//4S计算，只算二三等奖
			$pay_award += check_S($periods['id'], $value['number'], 1);  //头等奖
			$pay_award += check_S($periods['id'], $value['number'], 2);  //二等奖
			$pay_award += check_S($periods['id'], $value['number'], 3);  //三等奖
			
			//ABC3计算，前三等奖
			$pay_award += check_3ABC($periods['id'], $value['number'], 1);  //头等奖
			$pay_award += check_3ABC($periods['id'], $value['number'], 2); //二等奖
			$pay_award += check_3ABC($periods['id'], $value['number'], 3);  //三等奖

			//ABC3计算，前三等奖
			$pay_award += check_2ABC($periods['id'], $value['number'], 1);  //头等奖
			$pay_award += check_2ABC($periods['id'], $value['number'], 2); //二等奖
			$pay_award += check_2ABC($periods['id'], $value['number'], 3);  //三等奖
			
			//3A=首奖的最后三个号码
			$pay_award += check_A($periods['id'], $value['number'], 1);  //头等奖
			$pay_award += check_C2($periods['id'], $value['number'], 2);  //二等奖
			$pay_award += check_C3($periods['id'], $value['number'], 3);  //三等奖
			$pay_award += check_C4($periods['id'], $value['number'], 4);  //特别奖
			$pay_award += check_C5($periods['id'], $value['number'], 5);  //安慰奖
			$pay_award += check_EC($periods['id'], $value['number'], 1);  //头等奖

			//3A=首奖的最后三个号码
			$pay_award += check_2A($periods['id'], $value['number'], 1);  //头等奖
			$pay_award += check_2B($periods['id'], $value['number'], 2);  //二等奖
			$pay_award += check_2C($periods['id'], $value['number'], 3);  //三等奖
			$pay_award += check_2D($periods['id'], $value['number'], 4);  //特别奖
			$pay_award += check_2E($periods['id'], $value['number'], 5);  //安慰奖
			$pay_award += check_EX($periods['id'], $value['number'], 1);  //头等奖

			$sort[] = $list[$key]['pay_award'] = $pay_award;
		}

		array_multisort($sort,SORT_DESC,$list);
	}

	$export = $_GPC['export'];
	if ($export) {
		$report = 'order';
        include 'export.php';
        exit;
	}

	$total = count($list);
	$pager = pagination($total,$page,$psize);
}

if ($op == 'history') {
	$keyword = $_GPC['keyword'];
    $fields  =array();
	if (!empty($keyword)) {
		$condition .= " and o.ordersn like :keyword ";
		$fields[':keyword'] = '%'.$keyword.'%';
	}

	$list = pdo_fetchall('select o.* ,s.periods,m.nickname from '
        .tablename('manji_order')." o left join ".tablename('manji_run_setting')
        ." s on s.id=o.period_id left join "
        .tablename('member_system_member')
        ." m on o.user_id = m.id where 1  {$condition} order by o.id desc limit "
        .($page-1)*$psize.','.$psize,$fields);

	$total = pdo_fetchcolumn('select count(o.id) from '.tablename('manji_order')
        ." o  where 1 {$condition}    ",$fields  );
	$pager = pagination($total,$page,$psize);
}




include $this->template('order');
?>