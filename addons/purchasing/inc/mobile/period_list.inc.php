<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/3/23
 * Time: 16:52
 */
global $_W,$_GPC;
header('content-type: application/json; charset=utf-8');
header("access-control-allow-origin: *");
$weid = $_W['uniacid'];
$user_id = $_GPC['user_id'];
$token = $_GPC['token'];
$page = $_GPC['page']>0?$_GPC['page']:1;
$psize =20; 


$date = $_GPC['date']?$_GPC['date']:'';
if($date){

    $date = "%".date('Ymd',strtotime($date))."%";
    $total =  pdo_fetchcolumn('select count(id) from '.tablename('manji_run_setting').' where date like :date   ',array(':date'=>$date));
    $list =  pdo_fetchall('select id,periods from '.tablename('manji_run_setting').' where date like :date order by date desc limit '.($page-1)*$psize.",{$psize}",array(':date'=>$date));
}else{
	$total =  pdo_fetchcolumn('select count(id) from '.tablename('manji_run_setting'));
    $list =  pdo_fetchall('select id,periods from '.tablename('manji_run_setting') .' order by date desc limit '.($page-1)*$psize.",{$psize}");
}


$list = empty($list)?array():$list;
$data = array(
    'status' => 200,
    'info'=>'',
    'list'=>$list,
    'total_rows'=>$total,
);
echo json_encode($data);
exit();