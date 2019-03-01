<?php 
global $_W,$_GPC;
// $uid = $_GPC['user_id'];
// $token = $_GPC['token'];
// $member = $this->login_check($uid,$token);
// if (empty($member)) {
// 	$return = array(
// 		'status' => 403,
// 		'info' => '登录异常'
// 	);
// 	echo json_encode($return);
// 	exit;
// }

$bet_data = $_GPC['data'];
$data = explode(';', $bet_data);
$t = 0;
foreach ($data as $key => $value) {
	if ($key == 0) {
		$day = str_replace('D#','',$value);
		if ($day == '*') {
			$day = 0;
			$day_type = 1;
		}
		if (empty($day)) {
			$day = 1;
		}
	}
	else{
		if (strpos($value,'#') == false) {
			$company_array = str_split($value);
		}
		else{
			$bet_detail = explode('#', $value);
			$number_detail = explode('**', $bet_detail[0]);
			$count = count($number_detail);
			switch ($count) {
				case 1:
					$number = $number_detail[0];
					$mode = 0;
					break;
				case 2:
					if (empty($number_detail[0])) {
						$number = $number_detail[1];
						$mode = 2;
					}
					else{
						$number_details = explode('*', $number_detail[0]);
						if (count($number_details) > 1) {
							$number = $number_details[1];
							if ($number_details[0] == 2) {
								$mode = 3;
							}
							elseif ($number_details[0] == 3) {
								$mode = 4;
							}
							else{
								$mode = 1;
							}
						}
						else{
							$number = $number_detail[0];
							$mode = 0;
						}
					}
					break;
				case 3:
					$number = $number_detail[1];
					$mode = 2;
					break;
			}
			switch (strlen($number)) {
				case 2:
					if (strpos($value,'**#') == true) {
						$rule = array('2A','2B','2C','2D','2E','2ABC','EX');
					}
					else{
						$rule = array('2A','2ABC','2D','2E');
					}
					break;
				case 3:
					if (strpos($value,'**#') == true) {
						$rule = array('A','C2','C3','C4','C5','3ABC','EC');
					}
					else{
						$rule = array('A','3ABC','C4','C5');
					}
					break;
				case 4:
					if (strpos($value,'**#') == true) {
						$rule = array('4A','4B','4C','4D','4E','4ABC','EA');
					}
					else{
						$rule = array('B','S','A','3ABC');
					}
					break;
				case 5:
					$rule = array('5D');
					break;
				case 6:
					$rule = array('6D');
					break;

			}
			$pay = array();
			foreach ($bet_detail as $key => $value) {
				if ($key > 0) {
					$pay[] = $value;
				}
			}
			$order[$t] = array(
				'number' => $number,
				'type' => $mode,
				'pay' => $pay,
				'rule' => $rule,
				'cid' => $company_array
			);
			$t++;
		}
	}
}
var_dump($order);exit;






 ?>