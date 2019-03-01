<?php 
global $_W,$_GPC;

session_destroy();
setcookie('uid',0);

$result = array(
    'status' => 1,
    'info' => '登出成功'
);
echo json_encode($result);
exit;

 ?>