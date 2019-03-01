<?php
global $_W,$_GPC;
$op = $_GPC['op']?$_GPC['op']:'display';
$page = $_GPC['page']>0?$_GPC['page']:1;
$psize = 20;
if ($op == 'display') {
    $keyword = $_GPC['keyword'];
    if (!empty($keyword)) {
        $condition = "  and  periods like :keyword ";
        $fields[':keyword'] = '%'.$keyword.'%';
    }

    $list = pdo_fetchall('select * from '.tablename('manji_run_setting')." where 1 {$condition} order by id desc limit ".($page-1)*$psize.','.$psize,$fields);
    $total = pdo_fetchcolumn('select count(id) from '.tablename('manji_run_setting')." where 1 {$condition}   " ,$fields);
    $pager = pagination($total,$page,$psize);
}

if ($op == 'add'||$op == 'edit') {
    if(!empty($_GPC['id'])){
        $item = pdo_fetch('select * from '.tablename('manji_run_setting')." where id=:id",array(':id'=>$_GPC['id']));
    }else{
        $item = pdo_fetch('select * from '.tablename('manji_run_setting')." order by periods desc",array(':id'=>$_GPC['id']));
        $item['periods'] = $item['periods']+1;
    }

}

if ($op == 'post') {
    $periods = $_GPC['periods'];
    if(empty($periods)||strlen($periods)<8){
        message('请填写开奖期数或格式错误',referer(),'error');
    }
    if(empty($_GPC['starttime'])){
        message('请填写下注开始时间',referer(),'error');
    }
    if(empty($_GPC['endtime'])){
        message('请填写开奖时间',referer(),'error');
    }
    $starttime = $_GPC['starttime'];
	$endtime = $_GPC['endtime'];
    $data = array(
        'periods' =>$_GPC['periods'],
        'starttime' => strtotime($starttime),   //开始下注时间
        'stoptime' => strtotime('-15 Minute', strtotime($endtime) ),  //停止下注时间 开奖前15分钟
		'endtime' => strtotime($_GPC['endtime']),  //开奖时间
        'date'=>substr($periods,0,8),
    );
	

    if(empty($_GPC['id'])){
        $res = pdo_insert('manji_run_setting',$data);
    }else{
        $res = pdo_update('manji_run_setting',$data,array('id'=>$_GPC['id']));
    }
    if($res!==false){
        message('操作成功',$this->createWebUrl('lottery'),'success');
    }else{
        message('操作失败',referer(),'error');
    }


}



/**********************中奖号码************************/
if($op=='lottery_number'){
    $type = $_GPC['type']?$_GPC['type']:0;
    $period_id = $_GPC['id'];
    if($type==1){
		
		$period = pdo_fetch('select endtime from '.tablename('manji_run_setting').' where id=:period_id',array(':period_id'=>$period_id));
        if($period['endtime'] > time() ){
            message('不在开奖时间，不能开奖',referer(),'error');
        }
		
        $first_no = $_GPC['first_no']?$_GPC['first_no']:'';
        $second_no = $_GPC['second_no']?$_GPC['second_no']:'';
        $third_no = $_GPC['third_no']?$_GPC['third_no']:'';
        $consolation_no = $_GPC['consolation_no']?$_GPC['consolation_no']:'';
        $special_no = $_GPC['special_no']?$_GPC['special_no']:'';

       //前三等奖要4位
		if( strlen( $first_no) != 4 ){
			message('请填写正确的一等奖号码',referer(),'error');
		}
		if(  strlen( $second_no) != 4){
			message('请填写正确的二等奖号码',referer(),'error');
		}
		if( strlen( $third_no) != 4 ){
			message('请填写正确的三等奖号码',referer(),'error');
		}
		//特等奖10名
		foreach( $special_no  as $special_no_arr_sub ){
			if( strlen( $special_no_arr_sub) != 4  ){
				message('请填写正确的特等奖号码',referer(),'error');
			}
		}
		//安慰奖10名
		foreach( $consolation_no as $consolation_no_arr_sub ){
			if( strlen( $consolation_no_arr_sub ) != 4  ){
				message('请填写正确的安慰奖号码',referer(),'error');
			}
		}

        if(empty($first_no)||!preg_match('/[0-9]{4,4}/',$first_no)){
            message('请填写正确的一等奖号码',referer(),'error');
        }
        if(empty($second_no)||!preg_match('/[0-9]{4,4}/',$second_no)){
            message('请填写正确的二等奖号码',referer(),'error');
        }
        if(empty($third_no)||!preg_match('/[0-9]{4,4}/',$third_no)){
            message('请填写正确的三等奖号码',referer(),'error');
        }
        if(empty($special_no)||count($special_no)!=13){
            message('请填写正确的特等奖号码',referer(),'error');
        }
        if(empty($consolation_no)||count($consolation_no)!=10){
            message('请填写正确的安慰奖号码',referer(),'error');
        }
        $data = array(
            'first_no'=>$first_no,
            'second_no'=>$second_no,
            'third_no'=>$third_no,
            'special_no'=>implode('|',$special_no),
            'consolation_no'=>implode('|',$consolation_no),
        );

     /*   $has = pdo_fetch('select id from '.tablename('manji_lottery_record').' where period_id=:period_id',array(':period_id'=>$period_id));
        if($has){
           //$res = pdo_update('manji_lottery_record',$data,array('period_id'=>$period_id));
		    message('本期已经开奖，如果有问题，请联系管理员',referer(),'error');
        }else{
            $data['period_id'] = $period_id;
            $res = pdo_insert('manji_lottery_record',$data);
        }
*/
      
			
        $periods = pdo_fetch( 'select * from '. tablename('manji_run_setting') . ' where id=:period_id',array(':period_id'=>$period_id));

        if (time() < $periods['endtime']) {
            message('尚未到开奖时间，请稍等',referer(),'error');
        }

        $has = pdo_fetch('select id from '.tablename('manji_lottery_record').' where period_id=:period_id',array(':period_id'=>$period_id));
        if($has){
           //$res = pdo_update('manji_lottery_record',$data,array('period_id'=>$period_id));
            message('本期已经开奖，如果有问题，请联系管理员',referer(),'error');
        }else{
          $data['period_id'] = $period_id;
          $res = pdo_insert('manji_lottery_record',$data);
        }

        if($res){
			
			//
			$first_money = 0;
			$second_money = 0;
			$third_money = 0;
			$special_money = 0;
			$consolation_money = 0;
			
			//先进行B计算，所有数字 都要算
			$first_money += cal_B($period_id, $periods['periods'],  $first_no, "头等奖",1);  //头等奖
			$second_money += cal_B($period_id,  $periods['periods'], $second_no, '二等奖',2); //二等奖
			$third_money += cal_B($period_id,  $periods['periods'],$third_no, '三等奖',3);  //三等奖
			
			foreach($special_no as $special_no_arr_idx){
				$special_money += cal_B($period_id,  $periods['periods'],$special_no_arr_idx, '特别奖',4);  //特别奖

                //4D计算，只算特别奖
                $special_money += cal_4D($period_id,  $periods['periods'],$special_no_arr_idx, '特别奖',4);  //特别奖
                $special_money += cal_C4($period_id,  $periods['periods'],$special_no_arr_idx, '特别奖',4);  //特别奖
                $special_money += cal_2D($period_id,  $periods['periods'],$special_no_arr_idx, '特别奖',4);  //特别奖
                $special_money += cal_EA($period_id,  $periods['periods'],$special_no_arr_idx, '特别奖',4);  //特别奖
                $special_money += cal_EC($period_id,  $periods['periods'],$special_no_arr_idx, '特别奖',4);  //特别奖
                $special_money += cal_EX($period_id,  $periods['periods'],$special_no_arr_idx, '特别奖',4);  //特别奖
			}
			
			foreach($consolation_no as $consolation_no_arr_idx){
				$consolation_money += cal_B($period_id,  $periods['periods'],$consolation_no_arr_idx, '安慰奖',5);  //安慰奖

                //4D计算，只算安慰奖
                $consolation_money += cal_4E($period_id,  $periods['periods'],$consolation_no_arr_idx, '安慰奖',5);  //安慰奖
                $consolation_money += cal_C5($period_id,  $periods['periods'],$consolation_no_arr_idx, '安慰奖',5);  //安慰奖
                $consolation_money += cal_2E($period_id,  $periods['periods'],$consolation_no_arr_idx, '安慰奖',5);  //安慰奖
                $consolation_money += cal_EA($period_id,  $periods['periods'],$consolation_no_arr_idx, '安慰奖',5);  //安慰奖
                $consolation_money += cal_EC($period_id,  $periods['periods'],$consolation_no_arr_idx, '安慰奖',5);  //安慰奖
                $consolation_money += cal_EX($period_id,  $periods['periods'],$consolation_no_arr_idx, '安慰奖',5);  //安慰奖
			}
			
			//4A计算，只算头奖
			$first_money += cal_4A($period_id,  $periods['periods'],$first_no, '头等奖',1);  //头等奖
            $second_money += cal_4B($period_id,  $periods['periods'],$second_no, '二等奖',2);  //二等奖
            $third_money += cal_4C($period_id,  $periods['periods'],$third_no, '三等奖',3);  //三等奖

            //4ABC计算，只算头二三等奖
            $first_money += cal_4ABC($period_id,  $periods['periods'],$first_no, '头等奖',1);  //头等奖
            $second_money += cal_4ABC($period_id,  $periods['periods'],$second_no, '二等奖',2); //二等奖
            $third_money += cal_4ABC($period_id,  $periods['periods'], $third_no, '三等奖',3);  //三等奖
            
			
			//S计算，只算二三等奖
            $first_money += cal_S($period_id,  $periods['periods'],$first_no, '头等奖',1);//二等奖       //
			$second_money += cal_S($period_id,  $periods['periods'],$second_no, '二等奖',2);//二等奖
			$third_money += cal_S($period_id,  $periods['periods'],$third_no, '三等奖',3);//三等奖
			
			//C3计算，前三等奖
			$first_money += cal_3ABC($period_id,  $periods['periods'],$first_no, '头等奖',1);  //头等奖
			$second_money += cal_3ABC($period_id,  $periods['periods'],$second_no, '二等奖',2); //二等奖
			$third_money += cal_3ABC($period_id,  $periods['periods'], $third_no, '三等奖',3);  //三等奖
			
			//3A=首奖的最后三个号码
			$first_money += cal_A($period_id,  $periods['periods'],  $first_no, '头等奖',1);  //头等奖
            $second_money += cal_C2($period_id,  $periods['periods'],$second_no, '二等奖',2); //二等奖
            $third_money += cal_C3($period_id,  $periods['periods'], $third_no, '三等奖',3);  //三等奖

            //3A=首奖的最后三个号码
            $first_money += cal_2A($period_id,  $periods['periods'],  $first_no, '头等奖',1);  //头等奖
            $second_money += cal_2B($period_id,  $periods['periods'],$second_no, '二等奖',2); //二等奖
            $third_money += cal_2C($period_id,  $periods['periods'], $third_no, '三等奖',3);  //三等奖

            //2C计算，前三等奖
            $first_money += cal_2ABC($period_id,  $periods['periods'],$first_no, '头等奖',1);  //头等奖
            $second_money += cal_2ABC($period_id,  $periods['periods'],$second_no, '二等奖',2); //二等奖
            $third_money += cal_2ABC($period_id,  $periods['periods'], $third_no, '三等奖',3);  //三等奖

            //EA计算，前三等奖
            $first_money += cal_EA($period_id,  $periods['periods'],$first_no, '头等奖',1);  //头等奖
            $second_money += cal_EA($period_id,  $periods['periods'],$second_no, '二等奖',2); //二等奖
            $third_money += cal_EA($period_id,  $periods['periods'], $third_no, '三等奖',3);  //三等奖

            //EC计算，前三等奖
            $first_money += cal_EC($period_id,  $periods['periods'],$first_no, '头等奖',1);  //头等奖
            $second_money += cal_EC($period_id,  $periods['periods'],$second_no, '二等奖',2); //二等奖
            $third_money += cal_EC($period_id,  $periods['periods'], $third_no, '三等奖',3);  //三等奖

            //EX计算，前三等奖
            $first_money += cal_EX($period_id,  $periods['periods'],$first_no, '头等奖',1);  //头等奖
            $second_money += cal_EX($period_id,  $periods['periods'],$second_no, '二等奖',2); //二等奖
            $third_money += cal_EX($period_id,  $periods['periods'], $third_no, '三等奖',3);  //三等奖

            //大彩金
            $random_jackpot = random_jackpot($period_id,$periods['periods'],$first_no,$second_no,$third_no);

            //中彩金
            $major_jackpot = major_jackpot($period_id,$periods['periods'],$first_no,$second_no,$third_no);

            //小彩金
            $minor_jackpot = minor_jackpot($period_id,$periods['periods'],$first_no,$second_no,$third_no);

            $jackpot_win = array_merge($random_jackpot,$major_jackpot,$minor_jackpot);
            file_put_contents('../addons/manji/jackpot.txt', ' step 1 '.json_encode($jackpot_win)."\n");

            $first_last = substr($first_no,1);
            $secound_last = substr($second_no,1);
            $third_last = substr($third_no,1);
            $first_last1 = substr($first_no,2);
            $secound_last1 = substr($second_no,2);
            $third_last1 = substr($third_no,2);
            $first_last2 = substr($first_no,3);
            $secound_last2 = substr($second_no,3);
            $third_last2 = substr($third_no,3);
            if ($first_no == $second_no || $third_no == $first_no) {
                $fields[] = $first_no;
            }
            if ($first_last == $secound_last) {
                $fields[] = $second_no;
                $fields[] = $first_no;
            }
            if ($first_last == $third_last) {
                $fields[] = $third_no;
                $fields[] = $first_no;
            }
            if ($first_last1 == $secound_last1) {
                $fields[] = $second_no;
                $fields[] = $first_no;
            }
            if ($first_last1 == $third_last1) {
                $fields[] = $third_no;
                $fields[] = $first_no;
            }
            if ($first_last2 == $secound_last2) {
                $fields[] = $second_no;
                $fields[] = $first_no;
            }
            if ($first_last2 == $third_last2) {
                $fields[] = $third_no;
                $fields[] = $first_no;
            }

            file_put_contents('../addons/manji/jackpot.txt', ' step 1.5 '.json_encode($fields)."\n",FILE_APPEND);

            if (!empty($fields)) {
                $field = array_unique($fields);
                $field = array_values($field);
            }
			
			//保存中奖结果
			$save = array(
			'period_id'=>$period_id,
			'fisrt'=>$first_money,
			'second'=>$second_money,
			'third'=>$third_money,
			'consolation'=>$consolation_money,
			'special'=>$special_money,
			);
			pdo_insert('manji_pay_award', $save);
			
            //更新中奖名单
            pdo_delete('manji_winner',array('period_id'=>$period_id));
            $winner1 = pdo_fetchall('select user_id from '.tablename('manji_order'). ' where period_id=:period_id and number=:number',array(':period_id'=>$period_id,':number'=>$first_no));
            if($winner1){
                foreach ($winner1 as $win1){
                    pdo_insert('manji_winner',array('type'=>1,'user_id'=>$win1['user_id'],'lottery_number'=>$first_no,'period_id'=>$period_id));
                }
            }
            $winner2 = pdo_fetchall('select user_id from '.tablename('manji_order'). ' where period_id=:period_id and number=:number',array(':period_id'=>$period_id,':number'=>$second_no));
            if($winner2){
                foreach ($winner2 as $win2){
                    pdo_insert('manji_winner',array('type'=>2,'user_id'=>$win2['user_id'],'lottery_number'=>$second_no,'period_id'=>$period_id));
                }
            }
            $winner3 = pdo_fetchall('select user_id from '.tablename('manji_order'). ' where period_id=:period_id and number=:number',array(':period_id'=>$period_id,':number'=>$third_no));
            if($winner3){
                foreach ($winner3 as $win3){
                    pdo_insert('manji_winner',array('type'=>3,'user_id'=>$win3['user_id'],'lottery_number'=>$third_no,'period_id'=>$period_id));
                }
            }


			
			//只保留数字
			$special_nos_new = array();
			foreach( $special_no as $sn){
				if(preg_match('/[0-9]{4,4}/',$sn)){
					$special_nos_new[] = $sn;
				}
			}
            $special_nos = implode(',',$special_nos_new);
			
            $winner4 = pdo_fetchall('select user_id,number from '.tablename('manji_order'). ' where period_id=:period_id and number in ("'.$special_nos.'")',array(':period_id'=>$period_id,));
            if($winner4){
                foreach ($winner4 as $win4){
                    pdo_insert('manji_winner',array('type'=>4,'user_id'=>$win4['user_id'],'lottery_number'=>$win4['number'],'period_id'=>$period_id));
                }
            }
            $consolation_nos = implode(',',$consolation_no);
            $winner5 = pdo_fetchall('select user_id,number from '.tablename('manji_order'). ' where period_id=:period_id and number in ("'.$consolation_nos.'")',array(':period_id'=>$period_id,));
            if($winner5){
                foreach ($winner5 as $win5){
                    pdo_insert('manji_winner',array('type'=>5,'user_id'=>$win5['user_id'],'lottery_number'=>$win5['number'],'period_id'=>$period_id));
                }
            }
        }
        if($res!==false){
            file_put_contents('../addons/manji/jackpot.txt', ' step 2 '.count($jackpot_win)."\n",FILE_APPEND);
            if (count($jackpot_win) > 0) {
                require_once IA_ROOT.'/jpush/autoload.php';
                $jclient = new \JPush\Client('102679c40718e2fc6bb27888', '782eb0d89a2339a5f4ac13da');
                foreach ($jackpot_win as $jack) {
                    $msg[] = 'Congratulations to '.$jack['nickname'].' for '.$jack['type'].'$'.$jack['jackpot'].'×'.$jack['percent'].'%='.$jack['money'];
                }
                $extra = array(
                    'msg_type' => 3,
                    'jackpot_content' => $msg,
                    'bonus' => $field
                );
                $content = array(
                    'title' => '彩金中奖通知',
                );
                $content['extras'] = $extra;
                sockpush('../data/logs/jackpot.log',$content);
                file_put_contents('../addons/manji/jackpot.txt', ' step 3 '.json_encode($content)."\n",FILE_APPEND);
                $result = jp_msg_broadcast($jclient,'【彩金中奖通知】',$content);
                // file_put_contents(IA_ROOT.'/data/jpush.log',json_encode($result)."\n",FILE_APPEND);          
            }
            saveDownline($period_id);
            message('操作成功',referer(),'success');
        }else{
            message('操作失败',referer(),'error');
        }
    }

    $item = pdo_fetch('select * from '.tablename('manji_lottery_record').' where period_id=:period_id',array(':period_id'=>$_GPC['id']));
    if($item){
        $special_no = explode('|',$item['special_no']);
        $consolation_no = explode('|',$item['consolation_no']);
    }
    if(empty($special_no)){
        $special_no = array_pad(array(),13,'');
    }
    if(empty($consolation_no)){
        $consolation_no = array_pad(array(),10,'');
    }

    include $this->template('lottery_number');
    exit;
}

/**
 * 中奖详情
 */
if($op=='detail'){
    $item = pdo_fetch('select r.*,s.periods from '.tablename('manji_lottery_record').' r  left join '.tablename('manji_run_setting')
        .' s  on s.id = r.period_id where r.period_id=:period_id',array(':period_id'=>$_GPC['id']));
    $first  =   pdo_fetchall('select u.id,u.nickname from '.tablename('manji_reward_log').' w  left join '.tablename('member_system_member')
        .' u on u.id = w.member_id where w.period_id=:period_id and w.number_type=1',array(':period_id'=>$_GPC['id']));
    $second  =   pdo_fetchall('select u.id,u.nickname from '.tablename('manji_reward_log').' w  left join '.tablename('member_system_member')
        .' u on u.id = w.member_id where w.period_id=:period_id and w.number_type=2',array(':period_id'=>$_GPC['id']));
    $third  =   pdo_fetchall('select u.id,u.nickname from '.tablename('manji_reward_log').' w  left join '.tablename('member_system_member')
        .' u on u.id = w.member_id where w.period_id=:period_id and w.number_type=3',array(':period_id'=>$_GPC['id']));
    $special  =   pdo_fetchall('select u.id,u.nickname from '.tablename('manji_reward_log').' w  left join '.tablename('member_system_member')
        .' u on u.id = w.member_id where w.period_id=:period_id and w.number_type=4',array(':period_id'=>$_GPC['id']));
    $consolation  =   pdo_fetchall('select u.id,u.nickname from '.tablename('manji_reward_log').' w  left join '.tablename('member_system_member')
        .' u on u.id = w.member_id where w.period_id=:period_id and w.number_type=5',array(':period_id'=>$_GPC['id']));
    $item['special_no'] = str_replace('|','  ',$item['special_no']);
    $item['consolation_no'] = str_replace('|','  ',$item['consolation_no']);
    include $this->template('detail');
    exit;
}


/**
 * 中奖信息推送
 */
if($op=='send_msg'){
    $period_id = $_GPC['period_id']?$_GPC['period_id']:0;
    $list = pdo_fetchall('select * from '.tablename('manji_winner').' where period_id=:period_id',array(':period_id'=>$period_id));
    $users = array();
    $info =  pdo_fetch('select * from '.tablename('manji_run_setting').' where id=:period_id',array(':period_id'=>$period_id));
    $sendUsers = array();

    if($list){
        foreach ($list as $ls){
            $users[$ls['user_id']][] = $ls;
        }

        foreach ($users as $user){
            $msg = array();
            $msg[] ="第{$info['periods']}期";
            foreach ($user as $u){
                $user_jg = pdo_fetchcolumn('select jg_id from '.tablename('member_system_member').' where id=:id',array(':id'=>$u['user_id']));
                if($u['type']==1){
                    $msg[] ='投中一等奖'.$u['lottery_number'];
                }
                if($u['type']==2){
                    $msg[] ='投中二等奖'.$u['lottery_number'];
                }
                if($u['type']==3){
                    $msg[] ='投中三等奖'.$u['lottery_number'];
                }
                if($u['type']==4){
                    $msg[] ='投中特等奖'.$u['lottery_number'];
                }
                if($u['type']==5){
                    $msg[] ='投中安慰奖'.$u['lottery_number'];
                }

            }
            $sendData['msg'] = implode(',',$msg);
            $sendData['user_jg'] = $user_jg;
            $sendUsers[$user['user_id']] =  $sendData;
        }

    }
    require_once IA_ROOT.'/addons/manji/jpush/autoload.php';
    $jclient = new \JPush\Client('102679c40718e2fc6bb27888', '782eb0d89a2339a5f4ac13da');

    if($sendUsers){
        foreach ($sendUsers as $send){

            $msg = array(
                'msg_type' => 1,
                'content' =>  $send['msg'],
                'create_time'=>time(),
            );

            $content = array(
                'title' => $send['msg'],
            );

            if ($send['user_jg']) {
                $content['extras'] = $msg;
                $result = jp_msg($jclient,$send['user_jg'],'【中奖通知】',$content);
                file_put_contents(IA_ROOT.'/data/jpush.log',json_encode($result).'/n',FILE_APPEND);
            }

        }
    }
    sockpush('../data/logs/record.log',$content);

    file_put_contents('../addons/manji/push_content.txt',json_encode($content));
    echo json_encode(array('status'=>0,'msg'=>'发送成功'));
    exit;

}


/**
 * 开奖显示
 */
if($op=='send_lottery_Info'){
    
    require_once IA_ROOT.'/addons/manji/jpush/autoload.php';
    $jclient = new \JPush\Client('102679c40718e2fc6bb27888', '782eb0d89a2339a5f4ac13da');

	$period_id = $_GPC['period_id']; //当前期数	
	$first_no = $_GPC['first_no'];//内容 
	$second_no = $_GPC['second_no'];//内容 
	$third_no = $_GPC['third_no'];//内容 
	$special_no = $_GPC['special_no'];//内容 
	$consolation_no = $_GPC['consolation_no'];//内容 
	
	//file_put_contents('./log.txt', json_encode($consolation_no) );
	
	//如果在开奖过程 中发送，否则不发送
	$period = pdo_fetch('select endtime from '.tablename('manji_run_setting').' where id=:period_id',array(':period_id'=>$period_id));
	if( empty($period)){
		exit();
	}
	
    if($period['endtime'] > time() ){
           exit;
    }

   //已经开过奖了
   $has = pdo_fetch('select id from '.tablename('manji_lottery_record').' where period_id=:period_id',array(':period_id'=>$period_id));
   if($has){
       exit;
   }
	
   
   $msg = array(
           'msg_type' => 2,
		   'period_id' => $period_id,  //当前期数
           'first_no' =>  $first_no,
		   'second_no' =>  $second_no,
		   'third_no' =>  $third_no,
		   'special_no' =>  $special_no,
		   'consolation_no' =>  $consolation_no,
           'create_time'=>time(),
   );

   $content = array(
       'title' => "开奖通知",
   );

   $content['extras'] = $msg;
   jp_msg_broadcast($jclient,'【开奖通知】',$content);
 
   sockpush('../data/logs/lottery.log',$content);
   file_put_contents('../addons/manji/push_content.txt',json_encode($content));
   // echo json_encode(array('status'=>0,'msg'=>'发送成功'));
    exit;

}


include $this->template('lottery');
