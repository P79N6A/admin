<?php 
global $_W,$_GPC;

$user_id = $_GPC['user_id'];
$token = $_GPC['token'];
$page = $_GPC['page']>0?$_GPC['page']:1;
$psize = 20;

$check_login =  appLogin($user_id,$token);
if ($check_login !=1) {
    $data = array(
        'status' => 403,
        'info'   => '已在另外的设备上登录',
    );
    echo json_encode($data);
    exit();
}

$list = pdo_fetchall('select r.periods,o.4E,o.4S,o.4A,o.3ABC,o.3A,Box,IBox,A1,order_amount,number,o.createtime from '.tablename('manji_order').' o left join '.tablename('manji_run_setting').' r on r.id=o.period_id where user_id=:user order by o.createtime desc limit '.($page-1)*$psize.','.$psize,array(':user'=>$user_id));
$totalRows = pdo_fetchcolumn('select count(o.id) from '.tablename('manji_order').' o left join '.tablename('manji_run_setting').' r on r.id=o.period_id where user_id=:user   ' ,array(':user'=>$user_id));

$data = array(
	'status' => 200,
	'list' => $list,
    'total_rows'=>intval($totalRows)
);

echo json_encode($data);
exit;






 ?>