<?php 
global $_W,$_GPC;

session_destroy();

message('退出成功',$this->createMobileUrl('login'),'success');

 ?>