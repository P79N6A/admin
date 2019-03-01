<?php 
global $_W,$_GPC;
include '../addons/purchasing/report.class.php';
$op = $_GPC['op'];
if (!empty($_GPC['data'])) {
	$data = $this->AES_decrypt('ABC456789012345678901234567890WE',base64_decode($_GPC['data']));
}
if ($op == 'openresult') {
	$period_id = pdo_fetchcolumn('select id from '.tablename('manji_run_setting').' where date=:time and aid=1 and cid=1',array(':time'=>date('Y-m-d',time())));
	$period = pdo_fetch('select endtime from '.tablename('manji_run_setting').' where id=:period_id',array(':period_id'=>$period_id));
    if($period['endtime'] > time() ){
    	echo $this->AES_encrypt(2,'ABC456789012345678901234567890WE');
        exit;
    }
	if (file_exists('../addons/manji/result.txt')) {
		$result_no = file_get_contents('../addons/manji/result.txt');
	}
	if (!empty($result_no)) {
		$result = json_decode($result_no,true);
	}
	else{
		$result = array('0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0');
	}
	$count = 0;
	$pay_award = 0;
	foreach ($result as $v) {
		if ($v > 0) {
			$count++;
		}
	}
	array_multisort($sort,SORT_DESC,$list);
	$value = explode(',',$data);
	if (!empty($value[1]) && intval($value[1])>0) {
		$result[$value[0]] = $value[1];
		file_put_contents('../addons/manji/result.txt',json_encode($result));
		if ($count >= 23) {
			echo $this->AES_encrypt($list[0]['number'].','.$list[1]['number'],'ABC456789012345678901234567890WE');
		}
		else{
			echo $this->AES_encrypt(1,'ABC456789012345678901234567890WE');
		}
		exit;
	}
	else{
		echo $this->AES_encrypt(2,'ABC456789012345678901234567890WE');
		exit;
	}

}
if ($op == 'specialresult') {
	if (file_exists('../addons/manji/open_result.txt')) {
		$result_no = file_get_contents('../addons/manji/open_result.txt');
	}
	if (!empty($result_no)) {
		$result = json_decode($result_no,true);
		$special = $result['special'];
	}
	else{
		$result = array(
			'first' => '0',
			'secound' => '0',
			'third' => '0',
			'special' => array('0','0','0','0','0','0','0','0','0','0','0','0','0'),
			'consolation' => array('0','0','0','0','0','0','0','0','0','0'),
		);
		$special = array('0','0','0','0','0','0','0','0','0','0','0','0','0');
	}
	$value = explode(',',$data);
	if (!empty($value[1]) && intval($value[1])>0) {
		$special[$value[0]] = $value[1];
		$result['special'] = $special;
		file_put_contents('../addons/manji/open_result.txt',json_encode($result));

		$period_id = pdo_fetchcolumn('select max(id) from '.tablename('manji_run_setting').' where endtime<=:time',array(':time'=>time()));
		$record = pdo_fetchcolumn('select count(id) from '.tablename('manji_lottery_record').' where period_id=:id',array(':id'=>$period_id));
		$period = pdo_fetch('select endtime from '.tablename('manji_run_setting').' where id=:period_id',array(':period_id'=>$period_id));
	    if($period['endtime'] > time() ){
	    	echo $this->AES_encrypt(2,'ABC456789012345678901234567890WE');
	        exit;
	    }


		// do {
		// 	$record = 0;
		// 	$period_id = pdo_fetchcolumn('select min(id) from '.tablename('manji_run_setting').' where id>:id',array(':id'=>$period_id));
		// 	$record = pdo_fetchcolumn('select count(id) from '.tablename('manji_lottery_record').' where period_id=:id',array(':id'=>$period_id));
		// } while ($record > 0);

		// echo $record;exit;

		$msg = array(
           'msg_type' => 2,
		   'period_id' => $period_id,  //当前期数
           'first_no' =>  $result['first'],
		   'second_no' =>  $result['secound'],
		   'third_no' =>  $result['third'],
		   'special_no' =>  $result['special'],
		   'consolation_no' =>  $result['consolation'],
           'create_time'=>time(),
	    );

	    $content = array(
	        'title' => "开奖通知",
	    );

	    $content['extras'] = $msg;
	    sockpush('../data/logs/lottery.log',$content);
	    require_once IA_ROOT.'/jpush/autoload.php';
        $jclient = new \JPush\Client('102679c40718e2fc6bb27888', '782eb0d89a2339a5f4ac13da');
	    jp_msg_broadcast($jclient,'【开奖通知】',$content);
		echo $this->AES_encrypt(1,'ABC456789012345678901234567890WE');
		exit;
	}
	else{
		echo $this->AES_encrypt(2,'ABC456789012345678901234567890WE');
		exit;
	}
	
}
if ($op == 'comfortresult') {
	if (file_exists('../addons/manji/open_result.txt')) {
		$result_no = file_get_contents('../addons/manji/open_result.txt');
	}
	if (!empty($result_no)) {
		$result = json_decode($result_no,true);
		$consolation = $result['consolation'];
	}
	else{
		$result = array(
			'first' => '0',
			'secound' => '0',
			'third' => '0',
			'special' => array('0','0','0','0','0','0','0','0','0','0','0','0','0'),
			'consolation' => array('0','0','0','0','0','0','0','0','0','0'),
		);
		$consolation = array('0','0','0','0','0','0','0','0','0','0');
	}
	$value = explode(',',$data);
	if (!empty($value[1]) && intval($value[1])>0) {
		$consolation[$value[0]] = $value[1];
		$result['consolation'] = $consolation;
		file_put_contents('../addons/manji/open_result.txt',json_encode($result));

		$period_id = pdo_fetchcolumn('select max(id) from '.tablename('manji_run_setting').' where endtime<=:time',array(':time'=>time()));
		$record = pdo_fetchcolumn('select count(id) from '.tablename('manji_lottery_record').' where period_id=:id',array(':id'=>$period_id));
		$period = pdo_fetch('select endtime from '.tablename('manji_run_setting').' where id=:period_id',array(':period_id'=>$period_id));
	    if($period['endtime'] > time() ){
	    	echo $this->AES_encrypt(2,'ABC456789012345678901234567890WE');
	        exit;
	    }

		$msg = array(
           'msg_type' => 2,
		   'period_id' => $period_id,  //当前期数
           'first_no' =>  $result['first'],
		   'second_no' =>  $result['secound'],
		   'third_no' =>  $result['third'],
		   'special_no' =>  $result['special'],
		   'consolation_no' =>  $result['consolation'],
           'create_time'=>time(),
	    );

	    $content = array(
	        'title' => "开奖通知",
	    );

	    $content['extras'] = $msg;
	    sockpush('../data/logs/lottery.log',$content);
	    require_once IA_ROOT.'/jpush/autoload.php';
        $jclient = new \JPush\Client('102679c40718e2fc6bb27888', '782eb0d89a2339a5f4ac13da');
	    jp_msg_broadcast($jclient,'【开奖通知】',$content);
		echo $this->AES_encrypt(1,'ABC456789012345678901234567890WE');
		exit;
	}
	else{
		echo $this->AES_encrypt(2,'ABC456789012345678901234567890WE');
		exit;
	}
	
}
if ($op == 'bigresult') {
	if (file_exists('../addons/manji/open_result.txt')) {
		$result_no = file_get_contents('../addons/manji/open_result.txt');
	}
	if (!empty($result_no)) {
		$result = json_decode($result_no,true);
		$special = $result['special'];
	}
	else{
		$result = array(
			'first' => '0',
			'secound' => '0',
			'third' => '0',
			'special' => array('0','0','0','0','0','0','0','0','0','0','0','0','0'),
			'consolation' => array('0','0','0','0','0','0','0','0','0','0'),
		);
	}
	$value = explode(',',$data);
	if (!empty($value[1]) && intval($value[1])>0) {
		if ($value[0] == 0) {
			$result['first'] = $value[1];
		}
		if ($value[0] == 1) {
			$result['secound'] = $value[1];
		}
		if ($value[0] == 2) {
			$result['third'] = $value[1];
		}
		$has = 0;
		foreach ($result as &$val) {
			if (is_array($val)) {
				foreach ($val as &$v) {
					if ($v == $value[1] && $has == 0) {
						$v = '----';
						$has = 1;
					}
				}
			}
		}
		if ($result['first'] > 0) {
			$num++;
		}
		if ($result['secound'] > 0) {
			$num++;
		}
		if ($result['third'] > 0) {
			$num++;
		}

		file_put_contents('../addons/manji/open_result.txt',json_encode($result));

		$period_id = pdo_fetchcolumn('select max(id) from '.tablename('manji_run_setting').' where endtime<=:time',array(':time'=>time()));
		$record = pdo_fetchcolumn('select count(id) from '.tablename('manji_lottery_record').' where period_id=:id',array(':id'=>$period_id));
		$period = pdo_fetch('select endtime from '.tablename('manji_run_setting').' where id=:period_id',array(':period_id'=>$period_id));
	    if($period['endtime'] > time() ){
	    	echo $this->AES_encrypt(2,'ABC456789012345678901234567890WE');
	        exit;
	    }
	}
	else{
		echo $this->AES_encrypt(2,'ABC456789012345678901234567890WE');
		exit;
	}
	
}

if ($op == 'saveResult') {
	$reseive = $this->AES_decrypt('ABC456789012345678901234567890WE',base64_decode($_GPC['result']));

	$reseive = explode(';',$reseive);
	foreach ($reseive as $key => $value) {
		$data = explode(':',$value);
		$new_key = str_replace("\"",'',$data[0]);
		$result[$new_key] = $data[1];
	}

	foreach ($result as $k => $v) {
		if ($k == 'special' || $k == 'consolation' || $k == 'result') {
			$new = str_replace('{','',$v);
			$new = str_replace('}','',$new);
			$result[$k] = explode(',',$new);
		}
	}
	if (count($result['result'])>=23 && (empty($result['first']) || empty($result['secound']) || empty($result['third']))) {
		echo $this->AES_encrypt('0','ABC456789012345678901234567890WE');
		exit;
	}
	// $result = json_decode($GLOBALS['HTTP_RAW_POST_DATA'],true);
	$period = pdo_fetchall('select * from '.tablename('manji_run_setting').' where date=:date and cid=1 order by endtime desc ',array(':date'=>date('Y-m-d',time())));
	$report_save = array();
	$return = array();
	pdo_begin();
	foreach ($period as $key => $value) {
		$period_id = $value['id'];
	    $first_no = $result['first']?$result['first']:'';
	    $second_no = $result['secound']?$result['secound']:'';
	    $third_no = $result['third']?$result['third']:'';
	    $consolation_no = $result['consolation']?$result['consolation']:'';
	    $special_no = $result['special']?$result['special']:'';

	   //前三等奖要4位
		if( strlen( $first_no) != 4 ){
			file_put_contents('../addons/manji/pc_lottery.log', 'step 2');
			echo $this->AES_encrypt(0,'ABC456789012345678901234567890WE');
	        exit;
		}
		if(  strlen( $second_no) != 4){
			file_put_contents('../addons/manji/pc_lottery.log', 'step 3');
			echo $this->AES_encrypt(0,'ABC456789012345678901234567890WE');
	        exit;
		}
		if( strlen( $third_no) != 4 ){
			file_put_contents('../addons/manji/pc_lottery.log', 'step 4');
			echo $this->AES_encrypt(0,'ABC456789012345678901234567890WE');
	        exit;
		}
		//特等奖10名
		foreach( $special_no  as &$special_no_arr_sub ){
			if( strlen( $special_no_arr_sub) != 4 && !empty($special_no_arr_sub) ){
				file_put_contents('../addons/manji/pc_lottery.log', 'step 5');
				echo $this->AES_encrypt(0,'ABC456789012345678901234567890WE');
	        exit;
			}
			if (empty($special_no_arr_sub)) {
				$special_no_arr_sub = '----';
			}
		}
		//安慰奖10名
		foreach( $consolation_no as $consolation_no_arr_sub ){
			if( strlen( $consolation_no_arr_sub ) != 4  ){
			file_put_contents('../addons/manji/pc_lottery.log', 'step 6');
			echo $this->AES_encrypt(0,'ABC456789012345678901234567890WE');
	        exit;
			}
		}

	    if(empty($first_no)||!preg_match('/[0-9]{4,4}/',$first_no)){
	        file_put_contents('../addons/manji/pc_lottery.log', 'step 7');
	        echo $this->AES_encrypt(0,'ABC456789012345678901234567890WE');
	        exit;
	    }
	    if(empty($second_no)||!preg_match('/[0-9]{4,4}/',$second_no)){
	        file_put_contents('../addons/manji/pc_lottery.log', 'step 8');
	        echo $this->AES_encrypt(0,'ABC456789012345678901234567890WE');
	        exit;
	    }
	    if(empty($third_no)||!preg_match('/[0-9]{4,4}/',$third_no)){
	        file_put_contents('../addons/manji/pc_lottery.log', 'step 9');
	        echo $this->AES_encrypt(0,'ABC456789012345678901234567890WE');
	        exit;
	    }
	    if(empty($special_no)||count($special_no)<10){
	        file_put_contents('../addons/manji/pc_lottery.log', 'step 10');
	        echo $this->AES_encrypt(0,'ABC456789012345678901234567890WE');
	        exit;
	    }
	    if(empty($consolation_no)||count($consolation_no)!=10){
	        file_put_contents('../addons/manji/pc_lottery.log', 'step 11');
	        echo $this->AES_encrypt(0,'ABC456789012345678901234567890WE');
	        exit;
	    }
	    $data = array(
	        'first_no'=>$first_no,
	        'second_no'=>$second_no,
	        'third_no'=>$third_no,
	        'special_no'=>implode('|',$special_no),
	        'consolation_no'=>implode('|',$consolation_no),
	    );
			
	    $periods = pdo_fetch( 'select * from '. tablename('manji_run_setting') . ' where id=:period_id',array(':period_id'=>$period_id));
	    // if (time() < $periods['endtime']) {
	    //     file_put_contents('../addons/manji/pc_lottery.log', 'step 12');
	    //     echo $this->AES_encrypt(0,'ABC456789012345678901234567890WE');
	    //     exit;
	    // }

	    $has = pdo_fetch('select id from '.tablename('manji_lottery_record').' where period_id=:period_id',array(':period_id'=>$period_id));
	    if($has){
	       file_put_contents('../addons/manji/pc_lottery.log', 'step 13');
	       echo $this->AES_encrypt(0,'ABC456789012345678901234567890WE');
	        exit;
	    }else{
	      $data['period_id'] = $period_id;
	      $res = pdo_insert('manji_lottery_record',$data);
	    }

	    if($res!==false){
	        file_put_contents('../addons/manji/pc_lottery.log', 'step 14');
	    }else{
	        file_put_contents('../addons/manji/pc_lottery.log', 'step 15');
	    }
	}
	
	pdo_commit();
    $result = array(
		'first' => '0',
		'secound' => '0',
		'third' => '0',
		'special' => array('0','0','0','0','0','0','0','0','0','0','0','0','0'),
		'consolation' => array('0','0','0','0','0','0','0','0','0','0'),
	);
	file_put_contents('../addons/manji/open_result.txt',json_encode($result));

	echo $this->AES_encrypt(1,'ABC456789012345678901234567890WE');
	exit;
}

if ($op == 'return') {
	if (file_exists('../addons/manji/result.txt')) {
		$result_no = file_get_contents('../addons/manji/result.txt');
	}
	if (!empty($result_no)) {
		$result = json_decode($result_no,true);
	}

	$period_id = pdo_fetchcolumn('select max(id) from '.tablename('manji_run_setting').' where endtime<=:time',array(':time'=>time()));
	$record = pdo_fetchcolumn('select count(id) from '.tablename('manji_lottery_record').' where period_id=:id',array(':id'=>$period_id));

	do {
		$record = 0;
		$period_id = pdo_fetchcolumn('select min(id) from '.tablename('manji_run_setting').' where id>:id',array(':id'=>$period_id));
		$record = pdo_fetchcolumn('select count(id) from '.tablename('manji_lottery_record').' where period_id=:id',array(':id'=>$period_id));
	} while ($record>0);

	if (!empty($result) && is_array($result)) {
		foreach ($result as $key => $value) {
			$pay_award += check_B($period_id, $value, 1);  //头等奖
			$pay_award += check_B($period_id, $value, 2);  //二等奖
			$pay_award += check_B($period_id, $value, 3);  //三等奖
			$pay_award += check_B($period_id, $value, 4);  //特别奖
			$pay_award += check_B($period_id, $value, 5);  //安慰奖

			//4A计算，只算头奖
			$pay_award += check_4A($period_id, $value, 1);  //头等奖
			$pay_award += check_4B($period_id, $value, 2);  //二等奖
			$pay_award += check_4C($period_id, $value, 3);  //三等奖
			$pay_award += check_4D($period_id, $value, 4);  //特别奖
			$pay_award += check_4E($period_id, $value, 5);  //安慰奖
			$pay_award += check_EA($period_id, $value, 1);  //头等奖
			
			
			//4S计算，只算二三等奖
			$pay_award += check_S($period_id, $value, 1);  //头等奖
			$pay_award += check_S($period_id, $value, 2);  //二等奖
			$pay_award += check_S($period_id, $value, 3);  //三等奖
			
			//ABC3计算，前三等奖
			$pay_award += check_3ABC($period_id, $value, 1);  //头等奖
			$pay_award += check_3ABC($period_id, $value, 2); //二等奖
			$pay_award += check_3ABC($period_id, $value, 3);  //三等奖

			//ABC3计算，前三等奖
			$pay_award += check_2ABC($period_id, $value, 1);  //头等奖
			$pay_award += check_2ABC($period_id, $value, 2); //二等奖
			$pay_award += check_2ABC($period_id, $value, 3);  //三等奖
			
			//3A=首奖的最后三个号码
			$pay_award += check_A($period_id, $value, 1);  //头等奖
			$pay_award += check_C2($period_id, $value, 2);  //二等奖
			$pay_award += check_C3($period_id, $value, 3);  //三等奖
			$pay_award += check_C4($period_id, $value, 4);  //特别奖
			$pay_award += check_C5($period_id, $value, 5);  //安慰奖
			$pay_award += check_EC($period_id, $value, 1);  //头等奖

			//3A=首奖的最后三个号码
			$pay_award += check_2A($period_id, $value, 1);  //头等奖
			$pay_award += check_2B($period_id, $value, 2);  //二等奖
			$pay_award += check_2C($period_id, $value, 3);  //三等奖
			$pay_award += check_2D($period_id, $value, 4);  //特别奖
			$pay_award += check_2E($period_id, $value, 5);  //安慰奖
			$pay_award += check_EX($period_id, $value, 1);  //头等奖

			$list[$key]['number'] = $value;

			$sort[] = $list[$key]['pay_award'] = $pay_award;
		}
		array_multisort($sort,SORT_DESC,$list);

		for ($i=0; $i < 3; $i++) { 
			$number[] = $list[$i]['number'];
		}
		$num = implode(',',$number);
		$return = array(
			'status' => 1,
			'data' => $num
		);
	}
	else{
		$return = array(
			'status' => 2,
			'data' => ''
		);
	}
	
	echo $this->AES_encrypt(json_encode($return),'ABC456789012345678901234567890WE');
	exit;
}
if ($op == 'jackpot') {
	$jackpot = pdo_fetch('select * from '.tablename('manji_jackpot'));
	$total_jackpot = pdo_fetch('select * from '.tablename('manji_total_jackpot'));
	$periods = pdo_fetchcolumn('select periods from '.tablename('manji_run_setting').' where date=:date',array(':date'=>date('Y-m-d',time())));
	$return = '1,jb_jackpot:'.round($jackpot['big_jackpot']/4,2).'|'.round($jackpot['middle_jackpot']/4,2).'|'.round($jackpot['small_jackpot']/4,2).',total_jackpot:'.round($total_jackpot['big_jackpot']/4,2).'|'.round($total_jackpot['middle_jackpot']/4,2).'|'.round($total_jackpot['small_jackpot']/4,2).',periods:'.$periods;
	echo $this->AES_encrypt($return,'ABC456789012345678901234567890WE');
	exit;
}



 ?>