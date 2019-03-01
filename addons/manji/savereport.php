<?php 
ignore_user_abort (true);
set_time_limit (30);
file_put_contents('robotlog.txt','进来了',FILE_APPEND);
require '../../framework/bootstrap.inc.php';
include 'common.php';
$post = $_POST['date'];

$periods = pdo_fetchColumnValue('select id from '.tablename('manji_run_setting').' where cid=1 and date=:date',array(':date'=>$post));

foreach ($periods as $value) {
	saveDownline($value);
}





 ?>