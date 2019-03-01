<?php 
global $_W,$_GPC;
header('content-type: application/json; charset=utf-8');
header("access-control-allow-origin: *");
$weid = $_W['uniacid'];
$user_id = $_GPC['user_id'];
$token = $_GPC['token'];
$check_login =  appLogin($user_id,$token);
if ($check_login !=1) {
    $data = array(
        'status' => 403,
        'info'   => '已在另外的设备上登录',
    );
    echo json_encode($data);
    exit();
}
$period_id =  $_GPC['period_id']?$_GPC['period_id']:0;
$cathectic=  $_GPC['cathectic']?$_GPC['cathectic']:'';
$cathecticArr = explode(';',$cathectic);
if(empty($cathectic)||empty($cathecticArr)){
    $data = array(
        'status' => 300,
        'info'   => '请投注',
    );
    echo json_encode($data);
    exit();
}

//校验输入的值 

$cathecticArrBac = array();
foreach($cathecticArr as $cathectic_arr_sub){
	if( empty($cathectic_arr_sub) ) {
			continue;
	}
	
	$cathecticArrBac[] = $cathectic_arr_sub;
    $cathectic_arr_sub_sub  = explode(',',$cathectic_arr_sub);
	if(strlen($cathectic_arr_sub_sub[0]) != 4 ){
		$data = array(
			'status' => 300,
			'info'   => '请输入正确的数字',
		);
		echo json_encode($data);
		exit();
	}
}

$cathecticArr = $cathecticArrBac;

pdo_begin();
$sql = "LOCK TABLE ".tablename('manji_order'). " WRITE,".tablename('member_system_member')." WRITE,".tablename('agent_odds')." WRITE,". tablename('manji_run_setting')." WRITE,".tablename('manji_lottery_record')." WRITE,".tablename('core_sessions')." WRITE,".tablename('manji_jackpot')." WRITE,".tablename('agent_percent')." WRITE;"  ;
pdo_run($sql);

$time = time();
$user_info = pdo_fetch('select credit1,parent_agent from '.tablename('member_system_member').' where id=:id',array(':id'=>$user_id));
$date  =  date('Ymd');
//$period_info = pdo_fetch('select * from '.tablename('manji_run_setting').' where date=:date and stoptime>:time order by stoptime asc limit 1',array(':date'=>$date,':time'=>$time));
$period_info = pdo_fetch('select * from '.tablename('manji_run_setting').' where id=:id',array(':id'=>$period_id));

$reward = pdo_fetch('select * from '.tablename('manji_lottery_record').' where period_id=:id',array(':id'=>$period_id));

$odds =  pdo_fetch('select * from '.tablename('agent_odds').' where agent_id=:agent_id  ',array(':agent_id'=>$user_info['parent_agent']));

$prev = intval($period_id) - 1;

$prev_set = pdo_fetchcolumn('select count(id) from '.tablename('manji_run_setting').' where id=:id',array(':id'=>$prev));

$has_reward = pdo_fetch('select * from '.tablename('manji_lottery_record').' where period_id=:id',array(':id'=>$prev));

//没到下注时间不能下注
if( $time < $period_info['starttime'] || $time > $period_info['stoptime'] ){
   $data = array(
        'status' => 300,
        'info'   => '还没到下注时间',
    );
    echo json_encode($data);
    exit();
}

if(empty($period_info)){
    $data = array(
        'status' => 300,
        'info'   => '该期无效',
    );
    echo json_encode($data);
    exit();
}

if (!empty($reward)) {
    $data = array(
        'status' => 300,
        'info'   => '该期已开奖，无法投注',
    );
    echo json_encode($data);
    exit();
}

if (empty($has_reward) && $prev_set>0) {
    $data = array(
        'status' => 300,
        'info' => '上期尚未开奖，请等待开奖结束'
    );
    echo json_encode($data);
    exit;
}


//$has_one = pdo_fetchcolumn('select count(id) from '.tablename('manji_order').' where user_id=:user_id and period_id=:period_id',
//    array(':user_id'=>$user_id,':period_id'=>$period_id));
//if($has_one){
//    $data = array(
//        'status' => 300,
//        'info' => '该期已投注，请勿重复投注'
//    );
//    echo json_encode($data);
//    exit;
//}

/*
if($time >$period_info['stoptime']){
    $data = array(
        'status' => 300,
        'info'   => '该期投注时间已截止',
    );
    echo json_encode($data);
    exit();
}*/
$money = 0 ;
$money_err_num = 0;
$number_err_num = 0;

foreach ($cathecticArr as $item){
    if(empty($item)){
        continue;
    }
    $item  = explode(',',$item);
    $single_money = 0;  //每注金额
    if(empty($item[0])||!lottery_number($item[0])){
        $number_err_num ++;
    }
    if(!is_numeric($item[1])||$item[1]<0){
        $money_err_num ++;
    }
    $money += $item[1] ;
    $single_money += $item[1] ;

    if(!is_numeric($item[2])||$item[2]<0){
        $money_err_num ++;
    }
    $money += $item[2] ;
    $single_money += $item[2] ;

    if(!is_numeric($item[3])||$item[3]<0){
        $money_err_num ++;
    }
    $money += $item[3] ;
    $single_money += $item[3] ;

    if(!is_numeric($item[4])||$item[4]<0){
        $money_err_num ++;
    }
    $money += $item[4] ;
    $single_money += $item[4] ;

    if(!is_numeric($item[5])||$item[5]<0){
        $money_err_num ++;
    }
    $money += $item[5] ;
    $single_money += $item[5] ;

//    if(!is_numeric($item[6])||$item[6]<0){
//        $money_err_num ++;
//    }
//    $money += $item[6] ;
//    $single_money += $item[6] ;
//
//    if(!is_numeric($item[7])||$item[7]<0){
//        $money_err_num ++;
//    }
//    $money += $item[7] ;
//    $single_money += $item[7] ;
//
//    if(!is_numeric($item[8])||$item[8]<0){
//        $money_err_num ++;
//    }
//    $money += $item[8] ;
//    $single_money += $item[8] ;

    if(!$single_money){
        $data = array(
            'status' => 300,
            'info'   => '每注至少投注一笔金额',
        );
        echo json_encode($data);
        exit();
    }
    if($money_err_num){
        $data = array(
            'status' => 300,
            'info'   => '投注金额错误',
        );
        echo json_encode($data);
        exit();
    }
    if($number_err_num){
        $data = array(
            'status' => 300,
            'info'   => '投注号码错误',
        );
        echo json_encode($data);
        exit();
    }
}

if($user_info['credit1']<$money){
    $data = array(
        'status' => 300,
        'info'   => '积分不足，下单失败',
    );
    echo json_encode($data);
    exit();
}

$add['createtime'] = $time;
$add['period_id'] = $period_id;
$add['user_id'] = $user_id;

/*
$add['4E_result'] = $odds['odds1'];
$add['4S_result']  = $odds['odds2'];
$add['4A_result']  = $odds['odds3'];
$add['3ABC_result']  = $odds['odds4'];
$add['3A_result']  = $odds['odds5'];
$add['Box_result']  = $odds['odds6'];
$add['IBOX_result']  = $odds['odds7'];
$add['A1_result']  = $odds['odds8'];
*/

$total_money = 0;
foreach ($cathecticArr as $item){
	if(empty($item)){
		continue;
	}
	
     $item  = explode(',',$item);
     $strs = rand(100000,999999);
     $strs = str_shuffle($strs);
     $ordersn = date('YmdHis').$strs ;
     $add['number'] = $item[0];
     $add['4e'] = $item[1];
     $add['4s'] = $item[2];
     $add['4a'] = $item[3];
     $add['3abc'] = $item[4];
     $add['3a'] = $item[5];
//     $add['box'] = $item[6];
//     $add['ibox'] = $item[7];
//     $add['a1'] = $item[8];
     $add['ordersn'] = $ordersn;
//     $add['order_amount'] = $item[1]+$item[2]+$item[3]+$item[4]
//         +$item[5]+$item[6]+$item[7]+$item[8];
    $add['order_amount'] = $item[1]+$item[2]+$item[3]+$item[4] +$item[5] ;
     $res = pdo_insert('manji_order',$add);
     if(!$res){
         pdo_rollback();
         pdo_run('UNLOCK TABLES;');
         echo json_encode(array('status'=>300,'info'=>'下注失败'));
         exit;
     }
     $total_money += $add['order_amount'];
}

$balance = $user_info['credit1']-$total_money;

$percent = pdo_fetchcolumn('select jackpot_percent from '.tablename('agent_percent').' where agent_id=:agent_id',array(':agent_id'=>$user_info['parent_agent']));
$old_jackpot = pdo_fetch('select big_jackpot,middle_jackpot,small_jackpot from '.tablename('manji_jackpot'));

$big_jackpot = floatval($old_jackpot['big_jackpot'])+($total_money*intval($percent)*0.6/100);
$middle_jackpot = floatval($old_jackpot['middle_jackpot'])+($total_money*intval($percent)*0.3/100);
$small_jackpot = floatval($old_jackpot['small_jackpot'])+($total_money*intval($percent)*0.1/100);

$jackpot = array(
    'big_jackpot' => $big_jackpot,
    'middle_jackpot' => $middle_jackpot,
    'small_jackpot' => $small_jackpot
);

$ures = pdo_update('member_system_member',array('credit1'=>$balance),array('id'=>$user_id));
        pdo_update('manji_jackpot',$jackpot);
if($ures!==false){
    pdo_commit();
    pdo_run('UNLOCK TABLES;');
    $data['status'] = 200;
    $data['info'] = '下注成功' ;
    $data['money'] = $total_money;

}else{
    pdo_rollback();
    pdo_run('UNLOCK TABLES;');
    $data = array('status'=>300,'info'=>'下注失败');

}

echo json_encode($data);
 ?>