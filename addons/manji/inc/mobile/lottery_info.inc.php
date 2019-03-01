<?php 
global $_W,$_GPC;
header('content-type: application/json; charset=utf-8');
header("access-control-allow-origin: *");
$weid = $_W['uniacid'];
$user_id = $_GPC['user_id'];
$token = $_GPC['token'];
$date = $_GPC['date']?$_GPC['date']:'';
$check_login =  appLogin($user_id,$token);
if ($check_login !=1) {
    $data = array(
        'status' => 403,
        'info'   => '已在另外的设备上登录',
    );
    echo json_encode($data);
    exit();
}
if(empty($date)){
    $date = pdo_fetchcolumn('select date from '.tablename('manji_run_setting') .' order by date desc limit 1 ');
    $date = empty($date)?date('Ymd'):$date;
}
$list = pdo_fetchall('select r.*,s.periods from '.tablename('manji_lottery_record')
    .' r left join '.tablename('manji_run_setting').' s on s.id=r.period_id where s.date=:date  order by s.periods asc '
    ,array(':date'=>$date));


$data['status'] = 200;
$data['info'] = '';

foreach ($list as &$item){
    $first_balance = 0;
    $second_balance = 0;
    $third_balance = 0;
    $consolation_balance = 0;
    $special_balance = 0;
    $item['first_no'] = $item['first_no']?$item['first_no']:'';
    $item['second_no'] = $item['second_no']?$item['second_no']:'';
    $item['third_no'] = $item['third_no']?$item['third_no']:'';
    $item['consolation_no'] = $item['consolation_no']?explode('|',$item['consolation_no']):'';
    $item['special_no'] = $item['special_no']?explode('|',$item['special_no']):'';
    $item['periods'] = $item['periods']?$item['periods']:'';

    $balance_list =   pdo_fetchall('select   number_type, sum(winner_money) as money from '.tablename('manji_reward_log')
        .'    where  period_id = :period_id  and member_id=:user_id  group by number_type '
        ,array(':period_id'=>$item['period_id'],':user_id'=>$user_id));

    foreach ($balance_list as $ban){
         if($ban['number_type']==1){
             $first_balance +=$ban['money'];
         }
         if($ban['number_type']==2){
             $second_balance +=$ban['money'];
         }
         if($ban['number_type']==3){
             $third_balance +=$ban['money'];
         }
         if($ban['number_type']==4){
             $special_balance +=$ban['money'];
         }
         if($ban['number_type']==5){
             $consolation_balance +=$ban['money'];
         }
    }
    foreach ($item['consolation_no'] as $key => $value) {
        $consolation_win = pdo_fetchcolumn('select winner_money from '.tablename('manji_reward_log').' where number_type=5 and member_id=:user_id and period_id=:period_id and winner_number=:win_number',array(':period_id'=>$item['period_id'],':user_id'=>$user_id,':win_number'=>$value));
        $item['consolation_balance'][] = $consolation_win?floatval($consolation_win):0;
    }
    foreach ($item['special_no'] as $key => $value) {
        $special_win = pdo_fetchcolumn('select winner_money from '.tablename('manji_reward_log').' where number_type=4 and member_id=:user_id and period_id=:period_id and winner_number=:win_number',array(':period_id'=>$item['period_id'],':user_id'=>$user_id,':win_number'=>$value));
        $item['special_balance'][] = $special_win?floatval($special_win):0;
    }
   // $item['ban'] = $balance_list;

    $item['first_balance'] = $first_balance;
    $item['second_balance'] = $second_balance;
    $item['third_balance'] = $third_balance;
//    $item['consolation_balance'] = $consolation_balance;
//    $item['special_balance'] = $special_balance;
}
$data['list'] = $list;

echo json_encode($data);

 ?>