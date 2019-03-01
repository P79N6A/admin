<?php 
ignore_user_abort (true);
set_time_limit (30);
file_put_contents('robotlog.txt','进来了',FILE_APPEND);
require '../../framework/bootstrap.inc.php';
include 'common.php';
$post = $_POST['post'];

foreach ($post as $value) {
	number_eat($value['com'],$value['num'],$value['bet_money'],$value['agent'],$value['rule'],$value['minus'],$value['date'],$value['member']);
}







 ?>