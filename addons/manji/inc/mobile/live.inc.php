<?php 
global $_W,$_GPC;
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

$live = array(
	 "rtmp://19909.liveplay.myqcloud.com/live/19909_c5b1e81a06f811e892905cb9018cf0d4",
    "rtmp://19909.liveplay.myqcloud.com/live/19909_b057eb93f75011e792905cb9018cf0d4",
    "rtmp://19909.liveplay.myqcloud.com/live/19909_2993fa62071e11e892905cb9018cf0d4",
    "rtmp://19909.liveplay.myqcloud.com/live/19909_3ab2fd07072011e892905cb9018cf0d4",
    "rtmp://19909.liveplay.myqcloud.com/live/19909_d453171f072011e892905cb9018cf0d4",
    "rtmp://19909.liveplay.myqcloud.com/live/19909_476cb257072111e892905cb9018cf0d4"
);

$data = array(
	'status' => 200,
	'live_url' => $live
);

echo json_encode($data);
exit;



 ?>