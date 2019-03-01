<?php 
global $_W,$_GPC;
header('content-type: application/json; charset=utf-8');
header("access-control-allow-origin: *");
$weid = $_W['uniacid'];
$user_id = $_GPC['user_id'];
$token = $_GPC['token'];
$id = $_GPC['id']?$_GPC['id']:0;
$page = $_GPC['page']?$_GPC['page']:1;
$check_login =  appLogin($user_id,$token);
if ($check_login !=1) {
    $data = array(
        'status' => 403,
        'info'   => '已在另外的设备上登录',
    );
    echo json_encode($data);
    exit();
}
$psize = 20;

$list = pdo_fetchall('select * from '.tablename('manji_run_setting')
    .'  order by id desc limit '.($page-1)*$psize.",{$psize}");
$totalRows = pdo_fetchcolumn('select count(id) from '.tablename('manji_run_setting'));
$data['status'] = 200;
$data['info'] = '';
$data['list'] = empty($list)?array():$list;
$data['total_rows'] = intval($totalRows);

echo json_encode($data);

 ?>