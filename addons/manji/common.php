<?php
/**
 * Created by PhpStorm.
 * User: leong
 * Date: 2018/1/18
 * Time: 11:25
 */

function appLogin($user_id,$token)
{
    global $_W,$_GPC;
    $check_login = 1;

    if (empty($user_id) || empty($token)) {
        return 0;
    }

    //app token 在数据库中
    $saved_token = pdo_fetchcolumn("select token from ".tablename('member_system_member')." where id=:id",array(':id'=>$user_id));
    if ($saved_token != $token) {
        $check_login = 2;
    }else{
        //   memcache_write( 'user-'.$user_id,$token );
    }
    return $check_login;
}

function get_area($ip)
{
  $url = "http://ip.taobao.com/service/getIpInfo.php?ip={$ip}";
  $ret = https_request($url);
  $arr = json_decode($ret,true);
  return $arr;
}

function https_request($url,$data = null){
  $curl = curl_init();
  curl_setopt($curl,CURLOPT_URL,$url);
  curl_setopt($curl,CURLOPT_SSL_VERIFYPEER,false);
  curl_setopt($curl,CURLOPT_SSL_VERIFYHOST,false);
  if(!empty($data)){
    curl_setopt($curl,CURLOPT_POST,1);
    curl_setopt($curl,CURLOPT_POSTFIELDS,$data);
  }
  curl_setopt($curl,CURLOPT_RETURNTRANSFER,1);
  $output = curl_exec($curl);
  curl_close($curl);

  return $output;
}

/**
 * 获取明文md5密码
 * @param $password
 * @return string
 */
function decrypt_password($password){
    $str = explode('-', $password);
    $num = count($str);
    $pass = '';
    foreach ($str as $k => $v) {
        if ($k < $num-1) {
            $pass .= $v.'-';
        }
    }
    $length = strlen($pass);
    $newpass = '';
    for ($i=0; $i < $length-1; $i++) {
        $stri[$i] = substr($pass,$i,1);
        $newstr[$i] = chr(ord($stri[$i]) + 3);
        $newpass .= $newstr[$i];
    }

    return $newpass;
}

/**
 * 获取账号权限等级
 * @param $user_id
 * @return mixed
 */
function get_role_level($user_id){
    $role_level = pdo_fetchcolumn("select role_level  from ".tablename('lazy_saler')." where id=:id  ",array(':id'=>$user_id));
    return $role_level;
}

/**
 * 检测开奖号码位数
 * @param $number
 * @return bool
 */
function lottery_number($number){
    if(!preg_match('/[0-9]{4}/',$number)){
        return false;
    }
    return true;
}


/*
  `id` bigint(22) NOT NULL AUTO_INCREMENT,
  `period_id` int(11) NOT NULL DEFAULT '0',
  `period_num` varchar(60) NOT NULL COMMENT '编号',
  `member_id` int(11) NOT NULL,
  `member_nikename` varchar(60) NOT NULL,
  `member_old_money` int(11) NOT NULL COMMENT '原金额',
  `member_new_money` int(11) NOT NULL DEFAULT '0' COMMENT '中奖后金额',
  `winner_number` int(11) NOT NULL COMMENT '中奖号码',
  `winner_money` decimal(11,1) NOT NULL COMMENT '中奖金额',
  `winner_odds` int(11) NOT NULL COMMENT '赔率',
  `winner_type` varchar(60) NOT NULL DEFAULT '' COMMENT '中奖类型',
  `member_id` int(11) NOT NULL DEFAULT '0' COMMENT '代理人ID',
  `agent_name` varchar(60) NOT NULL DEFAULT '' COMMENT '代理人名',
  `create_time` int(11) NOT NULL DEFAULT '0',
  `number_type` tinyint(11) NOT NULL DEFAULT '0',  //中奖号码类型
  */
function winning_log($period_id, $period_num, $member_id, $member_nikename, $member_old_money, $member_new_money, $winner_number,
                     $bet_money,$winner_number_type,$winner_money,$winner_odds,$winner_type, $member_id, $agent_name,$number_type,$order_id,$order_time,$bet_number){
    
     $save['period_id'] = $period_id;
     $save['period_num']= $period_num; 
     $save['member_id'] = $member_id; 
     $save['member_nikename'] = $member_nikename; 
     $save['member_old_money'] = $member_old_money;
     $save['member_new_money'] = $member_new_money;
     $save['winner_number'] = $winner_number;
     $save['bet_money'] = $bet_money;
     $save['bet_number'] = $bet_number;
     $save['winner_number_type'] = $winner_number_type;
     $save['winner_money'] = $winner_money;
     $save['winner_odds'] = $winner_odds;
     $save['winner_type'] = $winner_type;
     $save['member_id'] = $member_id;
     $save['agent_name'] = $agent_name;
     $save['create_time'] = time();
     $save['number_type'] = $number_type;
     $save['order_id'] = $order_id;
     $save['order_time'] = $order_time;
    // print_r($save);
    $res = pdo_insert('manji_reward_log', $save);
    // echo $res;

}

function topic_winning_log($period_id, $period_num, $member_id, $member_nikename, $member_old_money, $member_new_money, $winner_number,
                     $bet_money,$winner_number_type,$winner_money,$winner_odds,  $winner_type, $member_id, $agent_name,$number_type,$order_id,$order_time)
{
	$save['period_id'] = $period_id;
	$save['period_num']= $period_num; 
	$save['member_id'] = $member_id; 
	$save['member_nikename'] = $member_nikename; 
	$save['member_old_money'] = $member_old_money;
	$save['member_new_money'] = $member_new_money;
	$save['winner_number'] = $winner_number;
	$save['bet_money'] = $bet_money;
	$save['winner_number_type'] = $winner_number_type;
	$save['winner_money'] = $winner_money;
	$save['winner_odds'] = $winner_odds;
	$save['winner_type'] = $winner_type;
	$save['member_id'] = $member_id;
	$save['agent_name'] = $agent_name;
	$save['create_time'] = time();
  $save['number_type'] = $number_type;
  $save['order_id'] = $order_id;
  $save['order_time'] = $order_time;
	//print_r($save);
	pdo_insert('manji_topic_reward_log', $save);
}

function cal_first($period_id,$number,$period_sn,$order,$member)
{
  # code...
}

//先对4B做运算
function cal_4A($period_id, $period_number, $winning_num, $winner_number_type,$number_type ){
        //找到这一期里的所有获胜方, B 他下注了
        $area_id = pdo_fetchcolumn('select aid from '.tablename('manji_run_setting').' where id=:id',array(':id'=>$period_id));
        $company_id = pdo_fetchcolumn('select cid from '.tablename('manji_run_setting').' where id=:id',array(':id'=>$period_id));

        $number_array = sort_number($winning_num);
        $number_fields = implode(',', $number_array);
        $first_number = substr($winning_num, 3);
        $last_number = substr($winning_num, -3);
        for ($i=0; $i < 10; $i++) { 
          $first_array[] = $i.$last_number;
          $last_array[] = $first_number.$i;
        }
        $first_number_fields = implode(',',$first_array);
        $last_number_fields = implode(',',$last_array);

        $winner1 = pdo_fetchall('select id, user_id,pay_4A,createtime,cid,mode,number  from '.tablename('manji_order').
           ' where ((mode=0 and number=:number) or ((mode=1 or mode=2) and number in ('.$number_fields.')) or (mode=3 and number in ('.$first_number_fields.')) or (mode=4 and number in ('.$last_number_fields.'))) and pay_4A>0 and cid like \'%('.$company_id.')%\' and status=1 and period_id like \'%('.$period_id.')%\'',array(':number'=>$winning_num));
        if (!empty($winner1)) {
          $total_winner_money = 0;  //总共赔的钱
          //给他加钱了
          foreach ($winner1 as $val) {
            $users[] = $val['user_id'];
          }
          $users = array_unique($users);
          $users = implode(',', $users);
          $winners = pdo_fetchall('select m.*,o.odds_4A from '.tablename('member_system_member').' m left join '.tablename('manji_member_odds').' o on o.member_id=m.id where m.id in ('.$users.') and o.cid=:cid',array(':cid'=>$area_id));
          foreach ($winners as $odd) {
            $odds[$odd['id']] = $odd['odds_4A'];
            $winner[$odd['id']] = $odd;
          }
          foreach ($winner1 as $win1) {
            if (empty($odds[$win1['user_id']])) {
              continue;
            }
            $odd =  $odds[$win1['user_id']];
              //给他奖的钱
            $winner_money = $win1['pay_4A'] * $odd;
            if ($win1['mode'] == 2) {
              $winner_money = $winner_money/count(sort_number($win1['number']));
            }
            $total_winner_money+= $winner_money;
    
            //保存个人记录
            $member_new_money = ((int)($winner[$win1['user_id']]['credit1'] * 10  + $winner_money *10)) / 10 ;
            winning_log($period_id, $period_number,$winner[$win1['user_id']]['id'], $winner[$win1['user_id']]['nickname'], $winner[$win1['user_id']]['credit1'], $member_new_money,
                $winning_num, $win1['pay_4A'], $winner_number_type, $winner_money, $odd, '4A', $winner[$win1['user_id']]['id'],  $winner[$win1['user_id']]['nickname'],$number_type,$win1['id'],$win1['createtime'],$win1['number'] );
            pdo_insert('manji_winner',array('type'=>1,'user_id'=>$win1['user_id'],'lottery_number'=>$winning_num,'period_id'=>$period_id));
          }
        }
        
        return $total_winner_money;
}

function cal_4B($period_id, $period_number, $winning_num, $winner_number_type,$number_type ){
        //锁表
  
        

        $area_id = pdo_fetchcolumn('select aid from '.tablename('manji_run_setting').' where id=:id',array(':id'=>$period_id));
        $company_id = pdo_fetchcolumn('select cid from '.tablename('manji_run_setting').' where id=:id',array(':id'=>$period_id));

        $number_array = sort_number($winning_num);
        $number_fields = implode(',', $number_array);
        $first_number = substr($winning_num, 3);
        $last_number = substr($winning_num, -3);
        for ($i=0; $i < 10; $i++) { 
          $first_array[] = $i.$last_number;
          $last_array[] = $first_number.$i;
        }
        $first_number_fields = implode(',',$first_array);
        $last_number_fields = implode(',',$last_array);
    
        //找到这一期里的所有获胜方, B 他下注了
       $winner1 = pdo_fetchall('select id, user_id,pay_4B,createtime,cid,mode,number  from '.tablename('manji_order').
           ' where ((mode=0 and number=:number) or ((mode=1 or mode=2) and number in ('.$number_fields.')) or (mode=3 and number in ('.$first_number_fields.')) or (mode=4 and number in ('.$last_number_fields.'))) and pay_4B>0 and cid like \'%('.$company_id.')%\' and status=1 and period_id like \'%('.$period_id.')%\'',array(':number'=>$winning_num));
       if (!empty($winner1)) {
          $total_winner_money = 0;  //总共赔的钱
          //给他加钱了
          foreach ($winner1 as $val) {
            $users[] = $val['user_id'];
          }
          $users = array_unique($users);
          $users = implode(',', $users);
          $winners = pdo_fetchall('select m.*,o.odds_4B from '.tablename('member_system_member').' m left join '.tablename('manji_member_odds').' o on o.member_id=m.id where m.id in ('.$users.') and o.cid=:cid',array(':cid'=>$area_id));
          foreach ($winners as $odd) {
            $odds[$odd['id']] = $odd['odds_4B'];
            $winner[$odd['id']] = $odd;
          }
          foreach ($winner1 as $win1) {
            if (empty($odds[$win1['user_id']])) {
              continue;
            }
            $odd =  $odds[$win1['user_id']];
              //给他奖的钱
            $winner_money = $win1['pay_4B'] * $odd;
            if ($win1['mode'] == 2) {
              $winner_money = $winner_money/count(sort_number($win1['number']));
            }
            $total_winner_money+= $winner_money;
    
            //保存个人记录
            $member_new_money = ((int)($winner[$win1['user_id']]['credit1'] * 10  + $winner_money *10)) / 10 ;
            winning_log($period_id, $period_number,$winner[$win1['user_id']]['id'], $winner[$win1['user_id']]['nickname'], $winner[$win1['user_id']]['credit1'], $member_new_money,
                $winning_num, $win1['pay_4B'], $winner_number_type, $winner_money, $odd, '4B', $winner[$win1['user_id']]['id'],  $winner[$win1['user_id']]['nickname'],$number_type,$win1['id'],$win1['createtime'],$win1['number'] );
            pdo_insert('manji_winner',array('type'=>1,'user_id'=>$win1['user_id'],'lottery_number'=>$winning_num,'period_id'=>$period_id));
          }
        }
        
        
        return $total_winner_money;

}

function cal_4C($period_id, $period_number, $winning_num, $winner_number_type,$number_type ){
        //锁表
  
        

        $area_id = pdo_fetchcolumn('select aid from '.tablename('manji_run_setting').' where id=:id',array(':id'=>$period_id));
        $company_id = pdo_fetchcolumn('select cid from '.tablename('manji_run_setting').' where id=:id',array(':id'=>$period_id));

        $number_array = sort_number($winning_num);
        $number_fields = implode(',', $number_array);
        $first_number = substr($winning_num, 3);
        $last_number = substr($winning_num, -3);
        for ($i=0; $i < 10; $i++) { 
          $first_array[] = $i.$last_number;
          $last_array[] = $first_number.$i;
        }
        $first_number_fields = implode(',',$first_array);
        $last_number_fields = implode(',',$last_array);
    
        //找到这一期里的所有获胜方, B 他下注了
       $winner1 = pdo_fetchall('select id, user_id,pay_4C,createtime,cid,mode,number  from '.tablename('manji_order').
           ' where ((mode=0 and number=:number) or ((mode=1 or mode=2) and number in ('.$number_fields.')) or (mode=3 and number in ('.$first_number_fields.')) or (mode=4 and number in ('.$last_number_fields.'))) and pay_4C>0 and cid like \'%('.$company_id.')%\' and status=1 and period_id like \'%('.$period_id.')%\'',array(':number'=>$winning_num));
       if (!empty($winner1)) {
          $total_winner_money = 0;  //总共赔的钱
          //给他加钱了
          foreach ($winner1 as $val) {
            $users[] = $val['user_id'];
          }
          $users = array_unique($users);
          $users = implode(',', $users);
          $winners = pdo_fetchall('select m.*,o.odds_4C from '.tablename('member_system_member').' m left join '.tablename('manji_member_odds').' o on o.member_id=m.id where m.id in ('.$users.') and o.cid=:cid',array(':cid'=>$area_id));
          foreach ($winners as $odd) {
            $odds[$odd['id']] = $odd['odds_4C'];
            $winner[$odd['id']] = $odd;
          }
          foreach ($winner1 as $win1) {
            if (empty($odds[$win1['user_id']])) {
              continue;
            }
            $odd =  $odds[$win1['user_id']];
              //给他奖的钱
            $winner_money = $win1['pay_4C'] * $odd;
            if ($win1['mode'] == 2) {
              $winner_money = $winner_money/count(sort_number($win1['number']));
            }
            $total_winner_money+= $winner_money;
    
            //保存个人记录
            $member_new_money = ((int)($winner[$win1['user_id']]['credit1'] * 10  + $winner_money *10)) / 10 ;
            winning_log($period_id, $period_number,$winner[$win1['user_id']]['id'], $winner[$win1['user_id']]['nickname'], $winner[$win1['user_id']]['credit1'], $member_new_money,
                $winning_num, $win1['pay_4C'], $winner_number_type, $winner_money, $odd, '4C', $winner[$win1['user_id']]['id'],  $winner[$win1['user_id']]['nickname'],$number_type,$win1['id'],$win1['createtime'],$win1['number'] );
            pdo_insert('manji_winner',array('type'=>1,'user_id'=>$win1['user_id'],'lottery_number'=>$winning_num,'period_id'=>$period_id));
          }
        }
        
        
        return $total_winner_money;

}

function cal_4D($period_id, $period_number, $winning_num, $winner_number_type,$number_type ){
        //锁表
  
        

        $area_id = pdo_fetchcolumn('select aid from '.tablename('manji_run_setting').' where id=:id',array(':id'=>$period_id));
        $company_id = pdo_fetchcolumn('select cid from '.tablename('manji_run_setting').' where id=:id',array(':id'=>$period_id));

        $number_array = sort_number($winning_num);
        $number_fields = implode(',', $number_array);
        $first_number = substr($winning_num, 3);
        $last_number = substr($winning_num, -3);
        for ($i=0; $i < 10; $i++) { 
          $first_array[] = $i.$last_number;
          $last_array[] = $first_number.$i;
        }
        $first_number_fields = implode(',',$first_array);
        $last_number_fields = implode(',',$last_array);
    
        //找到这一期里的所有获胜方, B 他下注了
       $winner1 = pdo_fetchall('select id, user_id,pay_4D,createtime,cid,mode,number  from '.tablename('manji_order').
           ' where ((mode=0 and number=:number) or ((mode=1 or mode=2) and number in ('.$number_fields.')) or (mode=3 and number in ('.$first_number_fields.')) or (mode=4 and number in ('.$last_number_fields.'))) and pay_4D>0 and cid like \'%('.$company_id.')%\' and status=1 and period_id like \'%('.$period_id.')%\'',array(':number'=>$winning_num));
       if (!empty($winner1)) {
          $total_winner_money = 0;  //总共赔的钱
          //给他加钱了
          foreach ($winner1 as $val) {
            $users[] = $val['user_id'];
          }
          $users = array_unique($users);
          $users = implode(',', $users);
          $winners = pdo_fetchall('select m.*,o.odds_4D from '.tablename('member_system_member').' m left join '.tablename('manji_member_odds').' o on o.member_id=m.id where m.id in ('.$users.') and o.cid=:cid',array(':cid'=>$area_id));
          foreach ($winners as $odd) {
            $odds[$odd['id']] = $odd['odds_4D'];
            $winner[$odd['id']] = $odd;
          }
          foreach ($winner1 as $win1) {
            if (empty($odds[$win1['user_id']])) {
              continue;
            }
            $odd =  $odds[$win1['user_id']];
              //给他奖的钱
            $winner_money = $win1['pay_4D'] * $odd;
            if ($win1['mode'] == 2) {
              $winner_money = $winner_money/count(sort_number($win1['number']));
            }
            $total_winner_money+= $winner_money;
    
            //保存个人记录
            $member_new_money = ((int)($winner[$win1['user_id']]['credit1'] * 10  + $winner_money *10)) / 10 ;
            winning_log($period_id, $period_number,$winner[$win1['user_id']]['id'], $winner[$win1['user_id']]['nickname'], $winner[$win1['user_id']]['credit1'], $member_new_money,
                $winning_num, $win1['pay_4D'], $winner_number_type, $winner_money, $odd, '4D', $winner[$win1['user_id']]['id'],  $winner[$win1['user_id']]['nickname'],$number_type,$win1['id'],$win1['createtime'],$win1['number'] );
            pdo_insert('manji_winner',array('type'=>1,'user_id'=>$win1['user_id'],'lottery_number'=>$winning_num,'period_id'=>$period_id));
          }
        }
        
        
        return $total_winner_money;

}

function cal_4E($period_id, $period_number, $winning_num, $winner_number_type,$number_type ){
        //锁表
  
        

        $area_id = pdo_fetchcolumn('select aid from '.tablename('manji_run_setting').' where id=:id',array(':id'=>$period_id));
        $company_id = pdo_fetchcolumn('select cid from '.tablename('manji_run_setting').' where id=:id',array(':id'=>$period_id));

        $number_array = sort_number($winning_num);
        $number_fields = implode(',', $number_array);
        $first_number = substr($winning_num, 3);
        $last_number = substr($winning_num, -3);
        for ($i=0; $i < 10; $i++) { 
          $first_array[] = $i.$last_number;
          $last_array[] = $first_number.$i;
        }
        $first_number_fields = implode(',',$first_array);
        $last_number_fields = implode(',',$last_array);
    
        //找到这一期里的所有获胜方, B 他下注了
       $winner1 = pdo_fetchall('select id, user_id,pay_4E,createtime,cid,mode,number  from '.tablename('manji_order').
           ' where ((mode=0 and number=:number) or ((mode=1 or mode=2) and number in ('.$number_fields.')) or (mode=3 and number in ('.$first_number_fields.')) or (mode=4 and number in ('.$last_number_fields.'))) and pay_4E>0 and cid like \'%('.$company_id.')%\' and status=1 and period_id like \'%('.$period_id.')%\'',array(':number'=>$winning_num));
       if (!empty($winner1)) {
          $total_winner_money = 0;  //总共赔的钱
          //给他加钱了
          foreach ($winner1 as $val) {
            $users[] = $val['user_id'];
          }
          $users = array_unique($users);
          $users = implode(',', $users);
          $winners = pdo_fetchall('select m.*,o.odds_4E from '.tablename('member_system_member').' m left join '.tablename('manji_member_odds').' o on o.member_id=m.id where m.id in ('.$users.') and o.cid=:cid',array(':cid'=>$area_id));
          foreach ($winners as $odd) {
            $odds[$odd['id']] = $odd['odds_4E'];
            $winner[$odd['id']] = $odd;
          }
          foreach ($winner1 as $win1) {
            if (empty($odds[$win1['user_id']])) {
              continue;
            }
            $odd =  $odds[$win1['user_id']];
              //给他奖的钱
            $winner_money = $win1['pay_4E'] * $odd;
            if ($win1['mode'] == 2) {
              $winner_money = $winner_money/count(sort_number($win1['number']));
            }
            $total_winner_money+= $winner_money;
    
            //保存个人记录
            $member_new_money = ((int)($winner[$win1['user_id']]['credit1'] * 10  + $winner_money *10)) / 10 ;
            winning_log($period_id, $period_number,$winner[$win1['user_id']]['id'], $winner[$win1['user_id']]['nickname'], $winner[$win1['user_id']]['credit1'], $member_new_money,
                $winning_num, $win1['pay_4E'], $winner_number_type, $winner_money, $odd, '4E', $winner[$win1['user_id']]['id'],  $winner[$win1['user_id']]['nickname'],$number_type,$win1['id'],$win1['createtime'],$win1['number'] );
            pdo_insert('manji_winner',array('type'=>1,'user_id'=>$win1['user_id'],'lottery_number'=>$winning_num,'period_id'=>$period_id));
          }
        }
        
        
        return $total_winner_money;

}

function cal_4ABC($period_id, $period_number, $winning_num, $winner_number_type,$number_type ){
        //锁表
  
        

        $area_id = pdo_fetchcolumn('select aid from '.tablename('manji_run_setting').' where id=:id',array(':id'=>$period_id));
        $company_id = pdo_fetchcolumn('select cid from '.tablename('manji_run_setting').' where id=:id',array(':id'=>$period_id));

        $number_array = sort_number($winning_num);
        $number_fields = implode(',', $number_array);
        $first_number = substr($winning_num, 3);
        $last_number = substr($winning_num, -3);
        for ($i=0; $i < 10; $i++) { 
          $first_array[] = $i.$last_number;
          $last_array[] = $first_number.$i;
        }
        $first_number_fields = implode(',',$first_array);
        $last_number_fields = implode(',',$last_array);
    
        //找到这一期里的所有获胜方, B 他下注了
       $winner1 = pdo_fetchall('select id, user_id,pay_4ABC,createtime,cid,mode,number  from '.tablename('manji_order').
           ' where ((mode=0 and number=:number) or ((mode=1 or mode=2) and number in ('.$number_fields.')) or (mode=3 and number in ('.$first_number_fields.')) or (mode=4 and number in ('.$last_number_fields.'))) and pay_4ABC>0 and cid like \'%('.$company_id.')%\' and status=1 and period_id like \'%('.$period_id.')%\'',array(':number'=>$winning_num));
        if (!empty($winner1)) {
          $total_winner_money = 0;  //总共赔的钱
          //给他加钱了
          foreach ($winner1 as $val) {
            $users[] = $val['user_id'];
          }
          $users = array_unique($users);
          $users = implode(',', $users);
          $winners = pdo_fetchall('select m.*,o.odds_4ABC from '.tablename('member_system_member').' m left join '.tablename('manji_member_odds').' o on o.member_id=m.id where m.id in ('.$users.') and o.cid=:cid',array(':cid'=>$area_id));
          foreach ($winners as $odd) {
            $odds[$odd['id']] = explode('|', $odd['odds_4ABC']);
            $winner[$odd['id']] = $odd;
          }
          foreach ($winner1 as $win1) {
            if (empty($odds[$win1['user_id']])) {
              continue;
            }
            switch ($number_type) {
              case 1:
                $odd =  $odds[$win1['user_id']][0];
                break;
              case 2:
                $odd =  $odds[$win1['user_id']][1];
                break;
              case 3:
                $odd =  $odds[$win1['user_id']][2];
                break;
              case 4:
                $odd =  $odds[$win1['user_id']][3];
                break;
              case 5:
                $odd =  $odds[$win1['user_id']][4];
                break;
            }
            
              //给他奖的钱
            $winner_money = $win1['pay_4ABC'] * $odd;
            if ($win1['mode'] == 2) {
              $winner_money = $winner_money/count(sort_number($win1['number']));
            }
            $total_winner_money+= $winner_money;
    
            //保存个人记录
            $member_new_money = ((int)($winner[$win1['user_id']]['credit1'] * 10  + $winner_money *10)) / 10 ;
            winning_log($period_id, $period_number,$winner[$win1['user_id']]['id'], $winner[$win1['user_id']]['nickname'], $winner[$win1['user_id']]['credit1'], $member_new_money,
                $winning_num, $win1['pay_4ABC'], $winner_number_type, $winner_money, $odd, '4ABC', $winner[$win1['user_id']]['id'],  $winner[$win1['user_id']]['nickname'],$number_type,$win1['id'],$win1['createtime'],$win1['number'] );
            pdo_insert('manji_winner',array('type'=>1,'user_id'=>$win1['user_id'],'lottery_number'=>$winning_num,'period_id'=>$period_id));
          }
        }
        
        
        return $total_winner_money;

}

function cal_B($period_id, $period_number, $winning_num, $winner_number_type,$number_type ){
    
        //锁表
        $sql = "LOCK TABLE ".tablename('manji_order'). " WRITE,".tablename('member_system_member')
            ." WRITE,".tablename('agent_member')." WRITE,".tablename('manji_reward_log')." WRITE,".tablename('manji_member_odds')." WRITE,".tablename('manji_run_setting')." WRITE,".tablename('manji_company')." WRITE,".tablename('agent_odds')." WRITE,".tablename('manji_odds')." WRITE;";
        

        $area_id = pdo_fetchcolumn('select aid from '.tablename('manji_run_setting').' where id=:id',array(':id'=>$period_id));
        $company_id = pdo_fetchcolumn('select cid from '.tablename('manji_run_setting').' where id=:id',array(':id'=>$period_id));

        $number_array = sort_number($winning_num);
        $number_fields = implode(',', $number_array);
        $first_number = substr($winning_num, 3);
        $last_number = substr($winning_num, -3);
        for ($i=0; $i < 10; $i++) { 
          $first_array[] = $i.$last_number;
          $last_array[] = $first_number.$i;
        }
        $first_number_fields = implode(',',$first_array);
        $last_number_fields = implode(',',$last_array);
    
        //找到这一期里的所有获胜方, B 他下注了
       $winner1 = pdo_fetchall('select id, user_id,pay_B,createtime,cid,mode,number  from '.tablename('manji_order').
           ' where ((mode=0 and number=:number) or ((mode=1 or mode=2) and number in ('.$number_fields.')) or (mode=3 and number in ('.$first_number_fields.')) or (mode=4 and number in ('.$last_number_fields.'))) and pay_B>0 and cid like \'%('.$company_id.')%\' and status=1 and period_id like \'%('.$period_id.')%\'',array(':number'=>$winning_num));
       if (!empty($winner1)) {
          $total_winner_money = 0;  //总共赔的钱
          //给他加钱了
          foreach ($winner1 as $val) {
            $users[] = $val['user_id'];
          }
          $users = array_unique($users);
          $users = implode(',', $users);
          $winners = pdo_fetchall('select m.*,o.odds_B from '.tablename('member_system_member').' m left join '.tablename('manji_member_odds').' o on o.member_id=m.id where m.id in ('.$users.') and o.cid=:cid',array(':cid'=>$area_id));
          foreach ($winners as $odd) {
            $odds[$odd['id']] = explode('|', $odd['odds_B']);
            $winner[$odd['id']] = $odd;
          }
          foreach ($winner1 as $win1) {
            if (empty($odds[$win1['user_id']])) {
              continue;
            }
            switch ($number_type) {
              case 1:
                $odd =  $odds[$win1['user_id']][0];
                break;
              case 2:
                $odd =  $odds[$win1['user_id']][1];
                break;
              case 3:
                $odd =  $odds[$win1['user_id']][2];
                break;
              case 4:
                $odd =  $odds[$win1['user_id']][3];
                break;
              case 5:
                $odd =  $odds[$win1['user_id']][4];
                break;
            }
            
              //给他奖的钱
            $winner_money = $win1['pay_B'] * $odd;
            if ($win1['mode'] == 2) {
              $winner_money = $winner_money/count(sort_number($win1['number']));
            }
            $total_winner_money+= $winner_money;
    
            //保存个人记录
            $member_new_money = ((int)($winner[$win1['user_id']]['credit1'] * 10  + $winner_money *10)) / 10 ;
            winning_log($period_id, $period_number,$winner[$win1['user_id']]['id'], $winner[$win1['user_id']]['nickname'], $winner[$win1['user_id']]['credit1'], $member_new_money,
                $winning_num, $win1['pay_B'], $winner_number_type, $winner_money, $odd, 'B', $winner[$win1['user_id']]['id'],  $winner[$win1['user_id']]['nickname'],$number_type,$win1['id'],$win1['createtime'],$win1['number'] );
            pdo_insert('manji_winner',array('type'=>1,'user_id'=>$win1['user_id'],'lottery_number'=>$winning_num,'period_id'=>$period_id));
          }
        }
        
        
        return $total_winner_money;
}

function cal_S($period_id, $period_number, $winning_num, $winner_number_type ,$number_type ){
        //锁表
  
        

        $area_id = pdo_fetchcolumn('select aid from '.tablename('manji_run_setting').' where id=:id',array(':id'=>$period_id));
        $company_id = pdo_fetchcolumn('select cid from '.tablename('manji_run_setting').' where id=:id',array(':id'=>$period_id));

        $number_array = sort_number($winning_num);
        $number_fields = implode(',', $number_array);
        $first_number = substr($winning_num, 3);
        $last_number = substr($winning_num, -3);
        for ($i=0; $i < 10; $i++) { 
          $first_array[] = $i.$last_number;
          $last_array[] = $first_number.$i;
        }
        $first_number_fields = implode(',',$first_array);
        $last_number_fields = implode(',',$last_array);
    
        //找到这一期里的所有获胜方, B 他下注了
       $winner1 = pdo_fetchall('select id, user_id,pay_S,createtime,cid,mode,number  from '.tablename('manji_order'). ' where ((mode=0 and number=:number) or ((mode=1 or mode=2) and number in ('.$number_fields.')) or (mode=3 and number in ('.$first_number_fields.')) or (mode=4 and number in ('.$last_number_fields.'))) and pay_S>0 and cid like \'%('.$company_id.')%\' and status=1 and period_id like \'%('.$period_id.')%\'',
           array(':number'=>$winning_num));
       if (!empty($winner1)) {
          $total_winner_money = 0;  //总共赔的钱
          //给他加钱了
          foreach ($winner1 as $val) {
            $users[] = $val['user_id'];
          }
          $users = array_unique($users);
          $users = implode(',', $users);
          $winners = pdo_fetchall('select m.*,o.odds_S from '.tablename('member_system_member').' m left join '.tablename('manji_member_odds').' o on o.member_id=m.id where m.id in ('.$users.') and o.cid=:cid',array(':cid'=>$area_id));
          foreach ($winners as $odd) {
            $odds[$odd['id']] = explode('|', $odd['odds_S']);
            $winner[$odd['id']] = $odd;
          }
          foreach ($winner1 as $win1) {
            if (empty($odds[$win1['user_id']])) {
              continue;
            }
            switch ($number_type) {
              case 1:
                $odd =  $odds[$win1['user_id']][0];
                break;
              case 2:
                $odd =  $odds[$win1['user_id']][1];
                break;
              case 3:
                $odd =  $odds[$win1['user_id']][2];
                break;
              case 4:
                $odd =  $odds[$win1['user_id']][3];
                break;
              case 5:
                $odd =  $odds[$win1['user_id']][4];
                break;
            }
            
              //给他奖的钱
            $winner_money = $win1['pay_S'] * $odd;
            if ($win1['mode'] == 2) {
              $winner_money = $winner_money/count(sort_number($win1['number']));
            }
            $total_winner_money+= $winner_money;
    
            //保存个人记录
            $member_new_money = ((int)($winner[$win1['user_id']]['credit1'] * 10  + $winner_money *10)) / 10 ;
            winning_log($period_id, $period_number,$winner[$win1['user_id']]['id'], $winner[$win1['user_id']]['nickname'], $winner[$win1['user_id']]['credit1'], $member_new_money,
                $winning_num, $win1['pay_S'], $winner_number_type, $winner_money, $odd, 'S', $winner[$win1['user_id']]['id'],  $winner[$win1['user_id']]['nickname'],$number_type,$win1['id'],$win1['createtime'],$win1['number'] );
            pdo_insert('manji_winner',array('type'=>1,'user_id'=>$win1['user_id'],'lottery_number'=>$winning_num,'period_id'=>$period_id));
          }
        }
        
        
        return $total_winner_money;

}

function cal_A($period_id, $period_number, $winning_num, $winner_number_type ,$number_type){
        //锁表
        $sql = "LOCK TABLE ".tablename('manji_order'). " WRITE,".tablename('member_system_member')." WRITE,".
            tablename('agent_member')." WRITE,".tablename('manji_reward_log')." WRITE,".tablename('manji_member_odds')." WRITE,".tablename('manji_run_setting')." WRITE,".tablename('manji_company')." WRITE,".tablename('agent_odds')." WRITE,".tablename('manji_odds')." WRITE;";
        

        $area_id = pdo_fetchcolumn('select aid from '.tablename('manji_run_setting').' where id=:id',array(':id'=>$period_id));
        $company_id = pdo_fetchcolumn('select cid from '.tablename('manji_run_setting').' where id=:id',array(':id'=>$period_id));

        $number_array = sort_number($winning_num);
        $new_number = substr($winning_num, -3);
        foreach ($number_array as &$num) {
          $num = substr($num,-3);
        }
        $number_array = array_unique($number_array);
        $number_fields = implode(',',$number_array);
        $first_number = substr($new_number,2);
        $last_number = substr($new_number,-2);
        for ($i=0; $i < 10; $i++) { 
          $first_array[] = $i.$last_number;
          $last_array[] = $first_number.$i;
        }
        $first_number_fields = implode(',',$first_array);
        $last_number_fields = implode(',',$last_array);
    
        //找到这一期里的所有获胜方, B 他下注了
       $winner1 = pdo_fetchall('select id, user_id,pay_A,createtime,cid,mode,number  from '.tablename('manji_order').
           ' where ((mode=0 and (number=:number or SUBSTRING(number,1,3)='.$new_number.')) or ((mode=1 or mode=2) and (number in ('.$number_fields.') or SUBSTRING(number,1) in ('.$number_fields.'))) or (mode=3 and (number in ('.$first_number_fields.') or SUBSTRING(number,1) in ('.$first_number_fields.'))) or (mode=4 and (number in ('.$last_number_fields.') or SUBSTRING(number,1) in ('.$first_number_fields.')))) and pay_A>0 and cid like \'%('.$company_id.')%\' and status=1 and period_id like \'%('.$period_id.')%\'',array(':number'=> substr($winning_num,-3) ));
       if (!empty($winner1)) {
          $total_winner_money = 0;  //总共赔的钱
          //给他加钱了
          foreach ($winner1 as $val) {
            $users[] = $val['user_id'];
          }
          $users = array_unique($users);
          $users = implode(',', $users);
          $winners = pdo_fetchall('select m.*,o.odds_A from '.tablename('member_system_member').' m left join '.tablename('manji_member_odds').' o on o.member_id=m.id where m.id in ('.$users.') and o.cid=:cid',array(':cid'=>$area_id));
          foreach ($winners as $odd) {
            $odds[$odd['id']] = $odd['odds_A'];
            $winner[$odd['id']] = $odd;
          }
          foreach ($winner1 as $win1) {
            if (empty($odds[$win1['user_id']])) {
              continue;
            }
            $odd =  $odds[$win1['user_id']];
              //给他奖的钱
            $winner_money = $win1['pay_A'] * $odd;
            if ($win1['mode'] == 2) {
              $winner_money = $winner_money/count(sort_number($win1['number']));
            }
            $total_winner_money+= $winner_money;
    
            //保存个人记录
            $member_new_money = ((int)($winner[$win1['user_id']]['credit1'] * 10  + $winner_money *10)) / 10 ;
            winning_log($period_id, $period_number,$winner[$win1['user_id']]['id'], $winner[$win1['user_id']]['nickname'], $winner[$win1['user_id']]['credit1'], $member_new_money,
                $winning_num, $win1['pay_A'], $winner_number_type, $winner_money, $odd, 'A', $winner[$win1['user_id']]['id'],  $winner[$win1['user_id']]['nickname'],$number_type,$win1['id'],$win1['createtime'],$win1['number'] );
            pdo_insert('manji_winner',array('type'=>1,'user_id'=>$win1['user_id'],'lottery_number'=>$winning_num,'period_id'=>$period_id));
          }
        }
        
        
        return $total_winner_money;

}

function cal_C2($period_id, $period_number, $winning_num, $winner_number_type ,$number_type){
        //锁表
        $sql = "LOCK TABLE ".tablename('manji_order'). " WRITE,".tablename('member_system_member')." WRITE,".
            tablename('agent_member')." WRITE,".tablename('manji_reward_log')." WRITE,".tablename('manji_member_odds')." WRITE,".tablename('manji_run_setting')." WRITE,".tablename('manji_company')." WRITE,".tablename('agent_odds')." WRITE,".tablename('manji_odds')." WRITE;";
        

        $area_id = pdo_fetchcolumn('select aid from '.tablename('manji_run_setting').' where id=:id',array(':id'=>$period_id));
        $company_id = pdo_fetchcolumn('select cid from '.tablename('manji_run_setting').' where id=:id',array(':id'=>$period_id));

        $number_array = sort_number($winning_num);
        $new_number = substr($winning_num, -3);
        foreach ($number_array as &$num) {
          $num = substr($num,-3);
        }
        $number_array = array_unique($number_array);
        $number_fields = implode(',',$number_array);
        $first_number = substr($new_number,2);
        $last_number = substr($new_number,-2);
        for ($i=0; $i < 10; $i++) { 
          $first_array[] = $i.$last_number;
          $last_array[] = $first_number.$i;
        }
        $first_number_fields = implode(',',$first_array);
        $last_number_fields = implode(',',$last_array);
    
        //找到这一期里的所有获胜方, B 他下注了
       $winner1 = pdo_fetchall('select id, user_id,pay_C2,createtime,cid,mode,number  from '.tablename('manji_order').
           ' where ((mode=0 and (number=:number or SUBSTRING(number,1,3)='.$new_number.')) or ((mode=1 or mode=2) and (number in ('.$number_fields.') or SUBSTRING(number,1) in ('.$number_fields.'))) or (mode=3 and (number in ('.$first_number_fields.') or SUBSTRING(number,1) in ('.$first_number_fields.'))) or (mode=4 and (number in ('.$last_number_fields.') or SUBSTRING(number,1) in ('.$first_number_fields.')))) and pay_C2>0 and cid like \'%('.$company_id.')%\' and status=1 and period_id like \'%('.$period_id.')%\'',array(':number'=> substr($winning_num,-3) ));
       if (!empty($winner1)) {
          $total_winner_money = 0;  //总共赔的钱
          //给他加钱了
          foreach ($winner1 as $val) {
            $users[] = $val['user_id'];
          }
          $users = array_unique($users);
          $users = implode(',', $users);
          $winners = pdo_fetchall('select m.*,o.odds_C2 from '.tablename('member_system_member').' m left join '.tablename('manji_member_odds').' o on o.member_id=m.id where m.id in ('.$users.') and o.cid=:cid',array(':cid'=>$area_id));
          foreach ($winners as $odd) {
            $odds[$odd['id']] = $odd['odds_C2'];
            $winner[$odd['id']] = $odd;
          }
          foreach ($winner1 as $win1) {
            if (empty($odds[$win1['user_id']])) {
              continue;
            }
            $odd =  $odds[$win1['user_id']];
              //给他奖的钱
            $winner_money = $win1['pay_C2'] * $odd;
            if ($win1['mode'] == 2) {
              $winner_money = $winner_money/count(sort_number($win1['number']));
            }
            $total_winner_money+= $winner_money;
    
            //保存个人记录
            $member_new_money = ((int)($winner[$win1['user_id']]['credit1'] * 10  + $winner_money *10)) / 10 ;
            winning_log($period_id, $period_number,$winner[$win1['user_id']]['id'], $winner[$win1['user_id']]['nickname'], $winner[$win1['user_id']]['credit1'], $member_new_money,
                $winning_num, $win1['pay_C2'], $winner_number_type, $winner_money, $odd, 'C2', $winner[$win1['user_id']]['id'],  $winner[$win1['user_id']]['nickname'],$number_type,$win1['id'],$win1['createtime'],$win1['number'] );
            pdo_insert('manji_winner',array('type'=>1,'user_id'=>$win1['user_id'],'lottery_number'=>$winning_num,'period_id'=>$period_id));
          }
        }
        
        
        return $total_winner_money;

}

function cal_C3($period_id, $period_number, $winning_num, $winner_number_type ,$number_type){
        //锁表
        $sql = "LOCK TABLE ".tablename('manji_order'). " WRITE,".tablename('member_system_member')." WRITE,".
            tablename('agent_member')." WRITE,".tablename('manji_reward_log')." WRITE,".tablename('manji_member_odds')." WRITE,".tablename('manji_run_setting')." WRITE,".tablename('manji_company')." WRITE,".tablename('agent_odds')." WRITE,".tablename('manji_odds')." WRITE;";
        

        $area_id = pdo_fetchcolumn('select aid from '.tablename('manji_run_setting').' where id=:id',array(':id'=>$period_id));
        $company_id = pdo_fetchcolumn('select cid from '.tablename('manji_run_setting').' where id=:id',array(':id'=>$period_id));

        $number_array = sort_number($winning_num);
        $new_number = substr($winning_num, -3);
        foreach ($number_array as &$num) {
          $num = substr($num,-3);
        }
        $number_array = array_unique($number_array);
        $number_fields = implode(',',$number_array);
        $first_number = substr($new_number,2);
        $last_number = substr($new_number,-2);
        for ($i=0; $i < 10; $i++) { 
          $first_array[] = $i.$last_number;
          $last_array[] = $first_number.$i;
        }
        $first_number_fields = implode(',',$first_array);
        $last_number_fields = implode(',',$last_array);
    
        //找到这一期里的所有获胜方, B 他下注了
       $winner1 = pdo_fetchall('select id, user_id,pay_C3,createtime,cid,mode,number  from '.tablename('manji_order').
           ' where ((mode=0 and (number=:number or SUBSTRING(number,1,3)='.$new_number.')) or ((mode=1 or mode=2) and (number in ('.$number_fields.') or SUBSTRING(number,1) in ('.$number_fields.'))) or (mode=3 and (number in ('.$first_number_fields.') or SUBSTRING(number,1) in ('.$first_number_fields.'))) or (mode=4 and (number in ('.$last_number_fields.') or SUBSTRING(number,1) in ('.$first_number_fields.')))) and pay_C3>0 and cid like \'%('.$company_id.')%\' and status=1 and period_id like \'%('.$period_id.')%\'',array(':number'=> substr($winning_num,-3) ));
       if (!empty($winner1)) {
          $total_winner_money = 0;  //总共赔的钱
          //给他加钱了
          foreach ($winner1 as $val) {
            $users[] = $val['user_id'];
          }
          $users = array_unique($users);
          $users = implode(',', $users);
          $winners = pdo_fetchall('select m.*,o.odds_C3 from '.tablename('member_system_member').' m left join '.tablename('manji_member_odds').' o on o.member_id=m.id where m.id in ('.$users.') and o.cid=:cid',array(':cid'=>$area_id));
          foreach ($winners as $odd) {
            $odds[$odd['id']] = $odd['odds_C3'];
            $winner[$odd['id']] = $odd;
          }
          foreach ($winner1 as $win1) {
            if (empty($odds[$win1['user_id']])) {
              continue;
            }
            $odd =  $odds[$win1['user_id']];
              //给他奖的钱
            $winner_money = $win1['pay_C3'] * $odd;
            if ($win1['mode'] == 2) {
              $winner_money = $winner_money/count(sort_number($win1['number']));
            }
            $total_winner_money+= $winner_money;
    
            //保存个人记录
            $member_new_money = ((int)($winner[$win1['user_id']]['credit1'] * 10  + $winner_money *10)) / 10 ;
            winning_log($period_id, $period_number,$winner[$win1['user_id']]['id'], $winner[$win1['user_id']]['nickname'], $winner[$win1['user_id']]['credit1'], $member_new_money,
                $winning_num, $win1['pay_C3'], $winner_number_type, $winner_money, $odd, 'C3', $winner[$win1['user_id']]['id'],  $winner[$win1['user_id']]['nickname'],$number_type,$win1['id'],$win1['createtime'],$win1['number'] );
            pdo_insert('manji_winner',array('type'=>1,'user_id'=>$win1['user_id'],'lottery_number'=>$winning_num,'period_id'=>$period_id));
          }
        }
        
        
        return $total_winner_money;

}

function cal_C4($period_id, $period_number, $winning_num, $winner_number_type ,$number_type){
        //锁表
        $sql = "LOCK TABLE ".tablename('manji_order'). " WRITE,".tablename('member_system_member')." WRITE,".
            tablename('agent_member')." WRITE,".tablename('manji_reward_log')." WRITE,".tablename('manji_member_odds')." WRITE,".tablename('manji_run_setting')." WRITE,".tablename('manji_company')." WRITE,".tablename('agent_odds')." WRITE,".tablename('manji_odds')." WRITE;";
        

        $area_id = pdo_fetchcolumn('select aid from '.tablename('manji_run_setting').' where id=:id',array(':id'=>$period_id));
        $company_id = pdo_fetchcolumn('select cid from '.tablename('manji_run_setting').' where id=:id',array(':id'=>$period_id));

        $number_array = sort_number($winning_num);
        $new_number = substr($winning_num, -3);
        foreach ($number_array as &$num) {
          $num = substr($num,-3);
        }
        $number_array = array_unique($number_array);
        $number_fields = implode(',',$number_array);
        $first_number = substr($new_number,2);
        $last_number = substr($new_number,-2);
        for ($i=0; $i < 10; $i++) { 
          $first_array[] = $i.$last_number;
          $last_array[] = $first_number.$i;
        }
        $first_number_fields = implode(',',$first_array);
        $last_number_fields = implode(',',$last_array);
    
        //找到这一期里的所有获胜方, B 他下注了
       $winner1 = pdo_fetchall('select id, user_id,pay_C4,createtime,cid,mode,number  from '.tablename('manji_order').
           ' where ((mode=0 and (number=:number or SUBSTRING(number,1)='.$new_number.')) or ((mode=1 or mode=2) and (number in ('.$number_fields.') or SUBSTRING(number,1) in ('.$number_fields.'))) or (mode=3 and (number in ('.$first_number_fields.') or SUBSTRING(number,1) in ('.$first_number_fields.'))) or (mode=4 and (number in ('.$last_number_fields.') or SUBSTRING(number,1) in ('.$first_number_fields.')))) and pay_C4>0 and cid like \'%('.$company_id.')%\' and status=1 and period_id like \'%('.$period_id.')%\'',array(':number'=> substr($winning_num,-3) ));
       if (!empty($winner1)) {
          $total_winner_money = 0;  //总共赔的钱
          //给他加钱了
          foreach ($winner1 as $val) {
            $users[] = $val['user_id'];
          }
          $users = array_unique($users);
          $users = implode(',', $users);
          $winners = pdo_fetchall('select m.*,o.odds_C4 from '.tablename('member_system_member').' m left join '.tablename('manji_member_odds').' o on o.member_id=m.id where m.id in ('.$users.') and o.cid=:cid',array(':cid'=>$area_id));
          foreach ($winners as $odd) {
            $odds[$odd['id']] = $odd['odds_C4'];
            $winner[$odd['id']] = $odd;
          }
          foreach ($winner1 as $win1) {
            if (empty($odds[$win1['user_id']])) {
              continue;
            }
            $odd =  $odds[$win1['user_id']];
              //给他奖的钱
            $winner_money = $win1['pay_C4'] * $odd;
            if ($win1['mode'] == 2) {
              $winner_money = $winner_money/count(sort_number($win1['number']));
            }
            $total_winner_money+= $winner_money;
    
            //保存个人记录
            $member_new_money = ((int)($winner[$win1['user_id']]['credit1'] * 10  + $winner_money *10)) / 10 ;
            winning_log($period_id, $period_number,$winner[$win1['user_id']]['id'], $winner[$win1['user_id']]['nickname'], $winner[$win1['user_id']]['credit1'], $member_new_money,
                $winning_num, $win1['pay_C4'], $winner_number_type, $winner_money, $odd, 'C4', $winner[$win1['user_id']]['id'],  $winner[$win1['user_id']]['nickname'],$number_type,$win1['id'],$win1['createtime'],$win1['number'] );
            pdo_insert('manji_winner',array('type'=>1,'user_id'=>$win1['user_id'],'lottery_number'=>$winning_num,'period_id'=>$period_id));
          }
        }
        
        
        return $total_winner_money;

}


function cal_C5($period_id, $period_number, $winning_num, $winner_number_type ,$number_type){
        //锁表
        $sql = "LOCK TABLE ".tablename('manji_order'). " WRITE,".tablename('member_system_member')." WRITE,".
            tablename('agent_member')." WRITE,".tablename('manji_reward_log')." WRITE,".tablename('manji_member_odds')." WRITE,".tablename('manji_run_setting')." WRITE,".tablename('manji_company')." WRITE,".tablename('agent_odds')." WRITE,".tablename('manji_odds')." WRITE;";
        

        $area_id = pdo_fetchcolumn('select aid from '.tablename('manji_run_setting').' where id=:id',array(':id'=>$period_id));
        $company_id = pdo_fetchcolumn('select cid from '.tablename('manji_run_setting').' where id=:id',array(':id'=>$period_id));

        $number_array = sort_number($winning_num);
        $new_number = substr($winning_num, -3);
        foreach ($number_array as &$num) {
          $num = substr($num,-3);
        }
        $number_array = array_unique($number_array);
        $number_fields = implode(',',$number_array);
        $first_number = substr($new_number,2);
        $last_number = substr($new_number,-2);
        for ($i=0; $i < 10; $i++) { 
          $first_array[] = $i.$last_number;
          $last_array[] = $first_number.$i;
        }
        $first_number_fields = implode(',',$first_array);
        $last_number_fields = implode(',',$last_array);
    
        //找到这一期里的所有获胜方, B 他下注了
       $winner1 = pdo_fetchall('select id, user_id,pay_C5,createtime,cid,mode,number  from '.tablename('manji_order').
           ' where ((mode=0 and (number=:number or SUBSTRING(number,1,3)='.$new_number.')) or ((mode=1 or mode=2) and (number in ('.$number_fields.') or SUBSTRING(number,1,3) in ('.$number_fields.'))) or (mode=3 and (number in ('.$first_number_fields.') or SUBSTRING(number,1,3) in ('.$first_number_fields.'))) or (mode=4 and (number in ('.$last_number_fields.') or SUBSTRING(number,1,3) in ('.$first_number_fields.')))) and pay_C5>0 and cid like \'%('.$company_id.')%\' and status=1 and period_id like \'%('.$period_id.')%\'',array(':number'=> substr($winning_num,-3) ));
       if (!empty($winner1)) {
          $total_winner_money = 0;  //总共赔的钱
          //给他加钱了
          foreach ($winner1 as $val) {
            $users[] = $val['user_id'];
          }
          $users = array_unique($users);
          $users = implode(',', $users);
          $winners = pdo_fetchall('select m.*,o.odds_C5 from '.tablename('member_system_member').' m left join '.tablename('manji_member_odds').' o on o.member_id=m.id where m.id in ('.$users.') and o.cid=:cid',array(':cid'=>$area_id));
          foreach ($winners as $odd) {
            $odds[$odd['id']] = $odd['odds_C5'];
            $winner[$odd['id']] = $odd;
          }
          foreach ($winner1 as $win1) {
            if (empty($odds[$win1['user_id']]['odds_C5'])) {
              continue;
            }
            $odd =  $odds[$win1['user_id']]['odds_C5'];
              //给他奖的钱
            $winner_money = $win1['pay_C5'] * $odd;
            if ($win1['mode'] == 2) {
              $winner_money = $winner_money/count(sort_number($win1['number']));
            }
            $total_winner_money+= $winner_money;
    
            //保存个人记录
            $member_new_money = ((int)($winner[$win1['user_id']]['credit1'] * 10  + $winner_money *10)) / 10 ;
            winning_log($period_id, $period_number,$winner[$win1['user_id']]['id'], $winner[$win1['user_id']]['nickname'], $winner[$win1['user_id']]['credit1'], $member_new_money,
                $winning_num, $win1['pay_C5'], $winner_number_type, $winner_money, $odd, 'C5', $winner[$win1['user_id']]['id'],  $winner[$win1['user_id']]['nickname'],$number_type,$win1['id'],$win1['createtime'],$win1['number'] );
            pdo_insert('manji_winner',array('type'=>1,'user_id'=>$win1['user_id'],'lottery_number'=>$winning_num,'period_id'=>$period_id));
          }
        }
        
        
        return $total_winner_money;

}

function cal_2A($period_id, $period_number, $winning_num, $winner_number_type ,$number_type){
        //锁表
        $sql = "LOCK TABLE ".tablename('manji_order'). " WRITE,".tablename('member_system_member')." WRITE,".
            tablename('agent_member')." WRITE,".tablename('manji_reward_log')." WRITE,".tablename('manji_member_odds')." WRITE,".tablename('manji_run_setting')." WRITE,".tablename('manji_company')." WRITE,".tablename('agent_odds')." WRITE,".tablename('manji_odds')." WRITE;";
        

        $area_id = pdo_fetchcolumn('select aid from '.tablename('manji_run_setting').' where id=:id',array(':id'=>$period_id));
        $company_id = pdo_fetchcolumn('select cid from '.tablename('manji_run_setting').' where id=:id',array(':id'=>$period_id));

        $number_array = sort_number($winning_num);
        $new_number = substr($winning_num, -2);
        foreach ($number_array as &$num) {
          $num = substr($num,-2);
        }
        $number_array = array_unique($number_array);
        $number_fields = implode(',',$number_array);
        $first_number = substr($new_number,1);
        $last_number = substr($new_number,-1);
        for ($i=0; $i < 10; $i++) { 
          $first_array[] = $i.$last_number;
          $last_array[] = $first_number.$i;
        }
        $first_number_fields = implode(',',$first_array);
        $last_number_fields = implode(',',$last_array);
    
        //找到这一期里的所有获胜方, B 他下注了
       $winner1 = pdo_fetchall('select id, user_id,pay_2A,createtime,cid,mode,number  from '.tablename('manji_order').
           ' where ((mode=0 and (number=:number or SUBSTRING(number,2,2)='.$new_number.')) or ((mode=1 or mode=2) and (number in ('.$number_fields.') or SUBSTRING(number,2,2) in ('.$number_fields.'))) or (mode=3 and (number in ('.$first_number_fields.') or SUBSTRING(number,2,2) in ('.$first_number_fields.'))) or (mode=4 and (number in ('.$last_number_fields.') or SUBSTRING(number,2,2) in ('.$first_number_fields.')))) and pay_2A>0 and cid like \'%('.$company_id.')%\' and status=1 and period_id like \'%('.$period_id.')%\'',array(':number'=> substr($winning_num,-2) ));
       if (!empty($winner1)) {
          $total_winner_money = 0;  //总共赔的钱
          //给他加钱了
          foreach ($winner1 as $val) {
            $users[] = $val['user_id'];
          }
          $users = array_unique($users);
          $users = implode(',', $users);
          $winners = pdo_fetchall('select m.*,o.odds_2A from '.tablename('member_system_member').' m left join '.tablename('manji_member_odds').' o on o.member_id=m.id where m.id in ('.$users.') and o.cid=:cid',array(':cid'=>$area_id));
          foreach ($winners as $odd) {
            $odds[$odd['id']] = $odd['odds_2A'];
            $winner[$odd['id']] = $odd;
          }
          foreach ($winner1 as $win1) {
            if (empty($odds[$win1['user_id']])) {
              continue;
            }
            $odd =  $odds[$win1['user_id']];
              //给他奖的钱
            $winner_money = $win1['pay_2A'] * $odd;
            if ($win1['mode'] == 2) {
              $winner_money = $winner_money/count(sort_number($win1['number']));
            }
            $total_winner_money+= $winner_money;
    
            //保存个人记录
            $member_new_money = ((int)($winner[$win1['user_id']]['credit1'] * 10  + $winner_money *10)) / 10 ;
            winning_log($period_id, $period_number,$winner[$win1['user_id']]['id'], $winner[$win1['user_id']]['nickname'], $winner[$win1['user_id']]['credit1'], $member_new_money,
                $winning_num, $win1['pay_2A'], $winner_number_type, $winner_money, $odd, '2A', $winner[$win1['user_id']]['id'],  $winner[$win1['user_id']]['nickname'],$number_type,$win1['id'],$win1['createtime'],$win1['number'] );
            pdo_insert('manji_winner',array('type'=>1,'user_id'=>$win1['user_id'],'lottery_number'=>$winning_num,'period_id'=>$period_id));
          }
        }
        
        
        return $total_winner_money;

}

function cal_2B($period_id, $period_number, $winning_num, $winner_number_type ,$number_type){
        //锁表
        $sql = "LOCK TABLE ".tablename('manji_order'). " WRITE,".tablename('member_system_member')." WRITE,".
            tablename('agent_member')." WRITE,".tablename('manji_reward_log')." WRITE,".tablename('manji_member_odds')." WRITE,".tablename('manji_run_setting')." WRITE,".tablename('manji_company')." WRITE,".tablename('agent_odds')." WRITE,".tablename('manji_odds')." WRITE;";
        

        $area_id = pdo_fetchcolumn('select aid from '.tablename('manji_run_setting').' where id=:id',array(':id'=>$period_id));
        $company_id = pdo_fetchcolumn('select cid from '.tablename('manji_run_setting').' where id=:id',array(':id'=>$period_id));

        $number_array = sort_number($winning_num);
        $new_number = substr($winning_num, -2);
        foreach ($number_array as &$num) {
          $num = substr($num,-2);
        }
        $number_array = array_unique($number_array);
        $number_fields = implode(',',$number_array);
        $first_number = substr($new_number,1);
        $last_number = substr($new_number,-1);
        for ($i=0; $i < 10; $i++) { 
          $first_array[] = $i.$last_number;
          $last_array[] = $first_number.$i;
        }
        $first_number_fields = implode(',',$first_array);
        $last_number_fields = implode(',',$last_array);
    
        //找到这一期里的所有获胜方, B 他下注了
       $winner1 = pdo_fetchall('select id, user_id,pay_2B,createtime,cid,mode,number  from '.tablename('manji_order').
           ' where ((mode=0 and (number=:number or SUBSTRING(number,2,2)='.$new_number.')) or ((mode=1 or mode=2) and (number in ('.$number_fields.') or SUBSTRING(number,2,2) in ('.$number_fields.'))) or (mode=3 and (number in ('.$first_number_fields.') or SUBSTRING(number,2,2) in ('.$first_number_fields.'))) or (mode=4 and (number in ('.$last_number_fields.') or SUBSTRING(number,2,2) in ('.$first_number_fields.')))) and pay_2B>0 and cid like \'%('.$company_id.')%\' and status=1 and period_id like \'%('.$period_id.')%\'',array(':number'=> substr($winning_num,-2) ));
       if (!empty($winner1)) {
          $total_winner_money = 0;  //总共赔的钱
          //给他加钱了
          foreach ($winner1 as $val) {
            $users[] = $val['user_id'];
          }
          $users = array_unique($users);
          $users = implode(',', $users);
          $winners = pdo_fetchall('select m.*,o.odds_2B from '.tablename('member_system_member').' m left join '.tablename('manji_member_odds').' o on o.member_id=m.id where m.id in ('.$users.') and o.cid=:cid',array(':cid'=>$area_id));
          foreach ($winners as $odd) {
            $odds[$odd['id']] = $odd['odds_2B'];
            $winner[$odd['id']] = $odd;
          }
          foreach ($winner1 as $win1) {
            if (empty($odds[$win1['user_id']])) {
              continue;
            }
            $odd =  $odds[$win1['user_id']];
              //给他奖的钱
            $winner_money = $win1['pay_2B'] * $odd;
            if ($win1['mode'] == 2) {
              $winner_money = $winner_money/count(sort_number($win1['number']));
            }
            $total_winner_money+= $winner_money;
    
            //保存个人记录
            $member_new_money = ((int)($winner[$win1['user_id']]['credit1'] * 10  + $winner_money *10)) / 10 ;
            winning_log($period_id, $period_number,$winner[$win1['user_id']]['id'], $winner[$win1['user_id']]['nickname'], $winner[$win1['user_id']]['credit1'], $member_new_money,
                $winning_num, $win1['pay_2B'], $winner_number_type, $winner_money, $odd, '2B', $winner[$win1['user_id']]['id'],  $winner[$win1['user_id']]['nickname'],$number_type,$win1['id'],$win1['createtime'],$win1['number'] );
            pdo_insert('manji_winner',array('type'=>1,'user_id'=>$win1['user_id'],'lottery_number'=>$winning_num,'period_id'=>$period_id));
          }
        }
        
        
        return $total_winner_money;

}

function cal_2C($period_id, $period_number, $winning_num, $winner_number_type ,$number_type){
        //锁表
        $sql = "LOCK TABLE ".tablename('manji_order'). " WRITE,".tablename('member_system_member')." WRITE,".
            tablename('agent_member')." WRITE,".tablename('manji_reward_log')." WRITE,".tablename('manji_member_odds')." WRITE,".tablename('manji_run_setting')." WRITE,".tablename('manji_company')." WRITE,".tablename('agent_odds')." WRITE,".tablename('manji_odds')." WRITE;";
        

        $area_id = pdo_fetchcolumn('select aid from '.tablename('manji_run_setting').' where id=:id',array(':id'=>$period_id));
        $company_id = pdo_fetchcolumn('select cid from '.tablename('manji_run_setting').' where id=:id',array(':id'=>$period_id));

        $number_array = sort_number($winning_num);
        $new_number = substr($winning_num, -2);
        foreach ($number_array as &$num) {
          $num = substr($num,-2);
        }
        $number_array = array_unique($number_array);
        $number_fields = implode(',',$number_array);
        $first_number = substr($new_number,1);
        $last_number = substr($new_number,-1);
        for ($i=0; $i < 10; $i++) { 
          $first_array[] = $i.$last_number;
          $last_array[] = $first_number.$i;
        }
        $first_number_fields = implode(',',$first_array);
        $last_number_fields = implode(',',$last_array);
    
        //找到这一期里的所有获胜方, B 他下注了
       $winner1 = pdo_fetchall('select id, user_id,pay_2C,createtime,cid,mode,number  from '.tablename('manji_order').
           ' where ((mode=0 and (number=:number or SUBSTRING(number,2,2)='.$new_number.')) or ((mode=1 or mode=2) and (number in ('.$number_fields.') or SUBSTRING(number,2,2) in ('.$number_fields.'))) or (mode=3 and (number in ('.$first_number_fields.') or SUBSTRING(number,2,2) in ('.$first_number_fields.'))) or (mode=4 and (number in ('.$last_number_fields.') or SUBSTRING(number,2,2) in ('.$first_number_fields.')))) and pay_2C>0 and cid like \'%('.$company_id.')%\' and status=1 and period_id like \'%('.$period_id.')%\'',array(':number'=> substr($winning_num,-2) ));
       if (!empty($winner1)) {
          $total_winner_money = 0;  //总共赔的钱
          //给他加钱了
          foreach ($winner1 as $val) {
            $users[] = $val['user_id'];
          }
          $users = array_unique($users);
          $users = implode(',', $users);
          $winners = pdo_fetchall('select m.*,o.odds_2C from '.tablename('member_system_member').' m left join '.tablename('manji_member_odds').' o on o.member_id=m.id where m.id in ('.$users.') and o.cid=:cid',array(':cid'=>$area_id));
          foreach ($winners as $odd) {
            $odds[$odd['id']] = $odd['odds_2C'];
            $winner[$odd['id']] = $odd;
          }
          foreach ($winner1 as $win1) {
            if (empty($odds[$win1['user_id']])) {
              continue;
            }
            $odd =  $odds[$win1['user_id']];
              //给他奖的钱
            $winner_money = $win1['pay_2C'] * $odd;
            if ($win1['mode'] == 2) {
              $winner_money = $winner_money/count(sort_number($win1['number']));
            }
            $total_winner_money+= $winner_money;
    
            //保存个人记录
            $member_new_money = ((int)($winner[$win1['user_id']]['credit1'] * 10  + $winner_money *10)) / 10 ;
            winning_log($period_id, $period_number,$winner[$win1['user_id']]['id'], $winner[$win1['user_id']]['nickname'], $winner[$win1['user_id']]['credit1'], $member_new_money,
                $winning_num, $win1['pay_2C'], $winner_number_type, $winner_money, $odd, '2C', $winner[$win1['user_id']]['id'],  $winner[$win1['user_id']]['nickname'],$number_type,$win1['id'],$win1['createtime'],$win1['number'] );
            pdo_insert('manji_winner',array('type'=>1,'user_id'=>$win1['user_id'],'lottery_number'=>$winning_num,'period_id'=>$period_id));
          }
        }
        
        
        return $total_winner_money;

}

function cal_2D($period_id, $period_number, $winning_num, $winner_number_type ,$number_type){
        //锁表
        $sql = "LOCK TABLE ".tablename('manji_order'). " WRITE,".tablename('member_system_member')." WRITE,".
            tablename('agent_member')." WRITE,".tablename('manji_reward_log')." WRITE,".tablename('manji_member_odds')." WRITE,".tablename('manji_run_setting')." WRITE,".tablename('manji_company')." WRITE,".tablename('agent_odds')." WRITE,".tablename('manji_odds')." WRITE;";
        

        $area_id = pdo_fetchcolumn('select aid from '.tablename('manji_run_setting').' where id=:id',array(':id'=>$period_id));
        $company_id = pdo_fetchcolumn('select cid from '.tablename('manji_run_setting').' where id=:id',array(':id'=>$period_id));

        $number_array = sort_number($winning_num);
        $new_number = substr($winning_num, -2);
        foreach ($number_array as &$num) {
          $num = substr($num,-2);
        }
        $number_array = array_unique($number_array);
        $number_fields = implode(',',$number_array);
        $first_number = substr($new_number,1);
        $last_number = substr($new_number,-1);
        for ($i=0; $i < 10; $i++) { 
          $first_array[] = $i.$last_number;
          $last_array[] = $first_number.$i;
        }
        $first_number_fields = implode(',',$first_array);
        $last_number_fields = implode(',',$last_array);
    
        //找到这一期里的所有获胜方, B 他下注了
       $winner1 = pdo_fetchall('select id, user_id,pay_2D,createtime,cid,mode,number  from '.tablename('manji_order').
           ' where ((mode=0 and (number=:number or SUBSTRING(number,2,2)='.$new_number.')) or ((mode=1 or mode=2) and (number in ('.$number_fields.') or SUBSTRING(number,2,2) in ('.$number_fields.'))) or (mode=3 and (number in ('.$first_number_fields.') or SUBSTRING(number,2,2) in ('.$first_number_fields.'))) or (mode=4 and (number in ('.$last_number_fields.') or SUBSTRING(number,2,2) in ('.$first_number_fields.')))) and pay_2D>0 and cid like \'%('.$company_id.')%\' and status=1 and period_id like \'%('.$period_id.')%\'',array(':number'=> substr($winning_num,-2) ));
       if (!empty($winner1)) {
          $total_winner_money = 0;  //总共赔的钱
          //给他加钱了
          foreach ($winner1 as $val) {
            $users[] = $val['user_id'];
          }
          $users = array_unique($users);
          $users = implode(',', $users);
          $winners = pdo_fetchall('select m.*,o.odds_2D from '.tablename('member_system_member').' m left join '.tablename('manji_member_odds').' o on o.member_id=m.id where m.id in ('.$users.') and o.cid=:cid',array(':cid'=>$area_id));
          foreach ($winners as $odd) {
            $odds[$odd['id']] = $odd['odds_2D'];
            $winner[$odd['id']] = $odd;
          }
          foreach ($winner1 as $win1) {
            if (empty($odds[$win1['user_id']])) {
              continue;
            }
            $odd =  $odds[$win1['user_id']];
              //给他奖的钱
            $winner_money = $win1['pay_2D'] * $odd;
            if ($win1['mode'] == 2) {
              $winner_money = $winner_money/count(sort_number($win1['number']));
            }
            $total_winner_money+= $winner_money;
    
            //保存个人记录
            $member_new_money = ((int)($winner[$win1['user_id']]['credit1'] * 10  + $winner_money *10)) / 10 ;
            winning_log($period_id, $period_number,$winner[$win1['user_id']]['id'], $winner[$win1['user_id']]['nickname'], $winner[$win1['user_id']]['credit1'], $member_new_money,
                $winning_num, $win1['pay_2D'], $winner_number_type, $winner_money, $odd, '2D', $winner[$win1['user_id']]['id'],  $winner[$win1['user_id']]['nickname'],$number_type,$win1['id'],$win1['createtime'],$win1['number'] );
            pdo_insert('manji_winner',array('type'=>1,'user_id'=>$win1['user_id'],'lottery_number'=>$winning_num,'period_id'=>$period_id));
          }
        }
        
        
        return $total_winner_money;

}

function cal_2E($period_id, $period_number, $winning_num, $winner_number_type ,$number_type){
        //锁表
        $sql = "LOCK TABLE ".tablename('manji_order'). " WRITE,".tablename('member_system_member')." WRITE,".
            tablename('agent_member')." WRITE,".tablename('manji_reward_log')." WRITE,".tablename('manji_member_odds')." WRITE,".tablename('manji_run_setting')." WRITE,".tablename('manji_company')." WRITE,".tablename('agent_odds')." WRITE,".tablename('manji_odds')." WRITE;";
        

        $area_id = pdo_fetchcolumn('select aid from '.tablename('manji_run_setting').' where id=:id',array(':id'=>$period_id));
        $company_id = pdo_fetchcolumn('select cid from '.tablename('manji_run_setting').' where id=:id',array(':id'=>$period_id));

        $number_array = sort_number($winning_num);
        $new_number = substr($winning_num, -2);
        foreach ($number_array as &$num) {
          $num = substr($num,-2);
        }
        $number_array = array_unique($number_array);
        $number_fields = implode(',',$number_array);
        $first_number = substr($new_number,1);
        $last_number = substr($new_number,-1);
        for ($i=0; $i < 10; $i++) { 
          $first_array[] = $i.$last_number;
          $last_array[] = $first_number.$i;
        }
        $first_number_fields = implode(',',$first_array);
        $last_number_fields = implode(',',$last_array);
    
        //找到这一期里的所有获胜方, B 他下注了
       $winner1 = pdo_fetchall('select id, user_id,pay_2E,createtime,cid,mode,number  from '.tablename('manji_order').
           ' where ((mode=0 and (number=:number or SUBSTRING(number,2,2)='.$new_number.')) or ((mode=1 or mode=2) and (number in ('.$number_fields.') or SUBSTRING(number,2,2) in ('.$number_fields.'))) or (mode=3 and (number in ('.$first_number_fields.') or SUBSTRING(number,2,2) in ('.$first_number_fields.'))) or (mode=4 and (number in ('.$last_number_fields.') or SUBSTRING(number,2,2) in ('.$first_number_fields.')))) and pay_2E>0 and cid like \'%('.$company_id.')%\' and status=1 and period_id like \'%('.$period_id.')%\'',array(':number'=> substr($winning_num,-2) ));
       if (!empty($winner1)) {
          $total_winner_money = 0;  //总共赔的钱
          //给他加钱了
          foreach ($winner1 as $val) {
            $users[] = $val['user_id'];
          }
          $users = array_unique($users);
          $users = implode(',', $users);
          $winners = pdo_fetchall('select m.*,o.odds_2E from '.tablename('member_system_member').' m left join '.tablename('manji_member_odds').' o on o.member_id=m.id where m.id in ('.$users.') and o.cid=:cid',array(':cid'=>$area_id));
          foreach ($winners as $odd) {
            $odds[$odd['id']] = $odd['odds_2E'];
            $winner[$odd['id']] = $odd;
          }
          foreach ($winner1 as $win1) {
            if (empty($odds[$win1['user_id']])) {
              continue;
            }
            $odd =  $odds[$win1['user_id']];
              //给他奖的钱
            $winner_money = $win1['pay_2E'] * $odd;
            if ($win1['mode'] == 2) {
              $winner_money = $winner_money/count(sort_number($win1['number']));
            }
            $total_winner_money+= $winner_money;
    
            //保存个人记录
            $member_new_money = ((int)($winner[$win1['user_id']]['credit1'] * 10  + $winner_money *10)) / 10 ;
            winning_log($period_id, $period_number,$winner[$win1['user_id']]['id'], $winner[$win1['user_id']]['nickname'], $winner[$win1['user_id']]['credit1'], $member_new_money,
                $winning_num, $win1['pay_2E'], $winner_number_type, $winner_money, $odd, '2E', $winner[$win1['user_id']]['id'],  $winner[$win1['user_id']]['nickname'],$number_type,$win1['id'],$win1['createtime'],$win1['number'] );
            pdo_insert('manji_winner',array('type'=>1,'user_id'=>$win1['user_id'],'lottery_number'=>$winning_num,'period_id'=>$period_id));
          }
        }
        
        
        return $total_winner_money;

}

function cal_2ABC($period_id, $period_number, $winning_num, $winner_number_type ,$number_type){
        //锁表
        
        

        $area_id = pdo_fetchcolumn('select aid from '.tablename('manji_run_setting').' where id=:id',array(':id'=>$period_id));
        $company_id = pdo_fetchcolumn('select cid from '.tablename('manji_run_setting').' where id=:id',array(':id'=>$period_id));

        $number_array = sort_number($winning_num);
        $new_number = substr($winning_num, -2);
        foreach ($number_array as &$num) {
          $num = substr($num,-2);
        }
        $number_array = array_unique($number_array);
        $number_fields = implode(',',$number_array);
        $first_number = substr($new_number,1);
        $last_number = substr($new_number,-1);
        for ($i=0; $i < 10; $i++) { 
          $first_array[] = $i.$last_number;
          $last_array[] = $first_number.$i;
        }
        $first_number_fields = implode(',',$first_array);
        $last_number_fields = implode(',',$last_array);
    
        //找到这一期里的所有获胜方, B 他下注了
       $winner1 = pdo_fetchall('select id, user_id,pay_2ABC,createtime,cid,mode,number  from '.tablename('manji_order').
           ' where ((mode=0 and (number=:number or SUBSTRING(number,2,2)='.$new_number.')) or ((mode=1 or mode=2) and (number in ('.$number_fields.') or SUBSTRING(number,2,2) in ('.$number_fields.'))) or (mode=3 and (number in ('.$first_number_fields.') or SUBSTRING(number,2,2) in ('.$first_number_fields.'))) or (mode=4 and (number in ('.$last_number_fields.') or SUBSTRING(number,2,2) in ('.$first_number_fields.')))) and pay_2ABC>0 and cid like \'%('.$company_id.')%\' and status=1 and period_id like \'%('.$period_id.')%\'',
           array(':number'=> substr($winning_num,-2) ));
       if (!empty($winner1)) {
          $total_winner_money = 0;  //总共赔的钱
          //给他加钱了
          foreach ($winner1 as $val) {
            $users[] = $val['user_id'];
          }
          $users = array_unique($users);
          $users = implode(',', $users);
          $winners = pdo_fetchall('select m.*,o.odds_2ABC from '.tablename('member_system_member').' m left join '.tablename('manji_member_odds').' o on o.member_id=m.id where m.id in ('.$users.') and o.cid=:cid',array(':cid'=>$area_id));
          foreach ($winners as $odd) {
            $odds[$odd['id']] = explode('|', $odd['odds_2ABC']);
            $winner[$odd['id']] = $odd;
          }
          foreach ($winner1 as $win1) {
            if (empty($odds[$win1['user_id']])) {
              continue;
            }
            switch ($number_type) {
              case 1:
                $odd =  $odds[$win1['user_id']][0];
                break;
              case 2:
                $odd =  $odds[$win1['user_id']][1];
                break;
              case 3:
                $odd =  $odds[$win1['user_id']][2];
                break;
              case 4:
                $odd =  $odds[$win1['user_id']][3];
                break;
              case 5:
                $odd =  $odds[$win1['user_id']][4];
                break;
            }
            
              //给他奖的钱
            $winner_money = $win1['pay_2ABC'] * $odd;
            if ($win1['mode'] == 2) {
              $winner_money = $winner_money/count(sort_number($win1['number']));
            }
            $total_winner_money+= $winner_money;
    
            //保存个人记录
            $member_new_money = ((int)($winner[$win1['user_id']]['credit1'] * 10  + $winner_money *10)) / 10 ;
            winning_log($period_id, $period_number,$winner[$win1['user_id']]['id'], $winner[$win1['user_id']]['nickname'], $winner[$win1['user_id']]['credit1'], $member_new_money,
                $winning_num, $win1['pay_2ABC'], $winner_number_type, $winner_money, $odd, '2ABC', $winner[$win1['user_id']]['id'],  $winner[$win1['user_id']]['nickname'],$number_type,$win1['id'],$win1['createtime'],$win1['number'] );
            pdo_insert('manji_winner',array('type'=>1,'user_id'=>$win1['user_id'],'lottery_number'=>$winning_num,'period_id'=>$period_id));
          }
        }
        
        
        return $total_winner_money;

}

function cal_3ABC($period_id, $period_number, $winning_num, $winner_number_type ,$number_type){
        //锁表
        
        

        $area_id = pdo_fetchcolumn('select aid from '.tablename('manji_run_setting').' where id=:id',array(':id'=>$period_id));
        $company_id = pdo_fetchcolumn('select cid from '.tablename('manji_run_setting').' where id=:id',array(':id'=>$period_id));

        $number_array = sort_number($winning_num);
        $new_number = substr($winning_num, -3);
        foreach ($number_array as &$num) {
          $num = substr($num,-3);
        }
        $number_array = array_unique($number_array);
        $number_fields = implode(',',$number_array);
        $first_number = substr($new_number,2);
        $last_number = substr($new_number,-2);
        for ($i=0; $i < 10; $i++) { 
          $first_array[] = $i.$last_number;
          $last_array[] = $first_number.$i;
        }
        $first_number_fields = implode(',',$first_array);
        $last_number_fields = implode(',',$last_array);
    
        //找到这一期里的所有获胜方, B 他下注了
       $winner1 = pdo_fetchall('select id, user_id,pay_3ABC,createtime,cid,mode,number  from '.tablename('manji_order').
           ' where ((mode=0 and (number=:number or SUBSTRING(number,1,3)='.$new_number.')) or ((mode=1 or mode=2) and (number in ('.$number_fields.') or SUBSTRING(number,1,3) in ('.$number_fields.'))) or (mode=3 and (number in ('.$first_number_fields.') or SUBSTRING(number,1,3) in ('.$first_number_fields.'))) or (mode=4 and (number in ('.$last_number_fields.') or SUBSTRING(number,1,3) in ('.$first_number_fields.')))) and pay_3ABC>0 and cid like \'%('.$company_id.')%\' and status=1 and period_id like \'%('.$period_id.')%\'',
           array(':number'=> substr($winning_num,-3) ));
       if (!empty($winner1)) {
          $total_winner_money = 0;  //总共赔的钱
          //给他加钱了
          foreach ($winner1 as $val) {
            $users[] = $val['user_id'];
          }
          $users = array_unique($users);
          $users = implode(',', $users);
          $winners = pdo_fetchall('select m.*,o.odds_3ABC from '.tablename('member_system_member').' m left join '.tablename('manji_member_odds').' o on o.member_id=m.id where m.id in ('.$users.') and o.cid=:cid',array(':cid'=>$area_id));
          foreach ($winners as $odd) {
            $odds[$odd['id']] = explode('|', $odd['odds_3ABC']);
            $winner[$odd['id']] = $odd;
          }
          foreach ($winner1 as $win1) {
            if (empty($odds[$win1['user_id']])) {
              continue;
            }
            switch ($number_type) {
              case 1:
                $odd =  $odds[$win1['user_id']][0];
                break;
              case 2:
                $odd =  $odds[$win1['user_id']][1];
                break;
              case 3:
                $odd =  $odds[$win1['user_id']][2];
                break;
              case 4:
                $odd =  $odds[$win1['user_id']][3];
                break;
              case 5:
                $odd =  $odds[$win1['user_id']][4];
                break;
            }
            
              //给他奖的钱
            $winner_money = $win1['pay_3ABC'] * $odd;
            if ($win1['mode'] == 2) {
              $winner_money = $winner_money/count(sort_number($win1['number']));
            }
            $total_winner_money+= $winner_money;
    
            //保存个人记录
            $member_new_money = ((int)($winner[$win1['user_id']]['credit1'] * 10  + $winner_money *10)) / 10 ;
            winning_log($period_id, $period_number,$winner[$win1['user_id']]['id'], $winner[$win1['user_id']]['nickname'], $winner[$win1['user_id']]['credit1'], $member_new_money,
                $winning_num, $win1['pay_3ABC'], $winner_number_type, $winner_money, $odd, '3ABC', $winner[$win1['user_id']]['id'],  $winner[$win1['user_id']]['nickname'],$number_type,$win1['id'],$win1['createtime'],$win1['number'] );
            pdo_insert('manji_winner',array('type'=>1,'user_id'=>$win1['user_id'],'lottery_number'=>$winning_num,'period_id'=>$period_id));
          }
        }
        
        
        return $total_winner_money;

}

function cal_EA($period_id, $period_number, $winning_num, $winner_number_type,$number_type ){
    
        //锁表
        $sql = "LOCK TABLE ".tablename('manji_order'). " WRITE,".tablename('member_system_member')
            ." WRITE,".tablename('agent_member')." WRITE,".tablename('manji_reward_log')." WRITE,".tablename('manji_member_odds')." WRITE,".tablename('manji_run_setting')." WRITE,".tablename('manji_company')." WRITE,".tablename('agent_odds')." WRITE,".tablename('manji_odds')." WRITE;";
        

        $area_id = pdo_fetchcolumn('select aid from '.tablename('manji_run_setting').' where id=:id',array(':id'=>$period_id));
        $company_id = pdo_fetchcolumn('select cid from '.tablename('manji_run_setting').' where id=:id',array(':id'=>$period_id));
        $number_array = sort_number($winning_num);
        $number_fields = implode(',', $number_array);
        $first_number = substr($winning_num, 3);
        $last_number = substr($winning_num, -3);
        for ($i=0; $i < 10; $i++) { 
          $first_array[] = $i.$last_number;
          $last_array[] = $first_number.$i;
        }
        $first_number_fields = implode(',',$first_array);
        $last_number_fields = implode(',',$last_array);
    
        //找到这一期里的所有获胜方, B 他下注了
       $winner1 = pdo_fetchall('select id, user_id,pay_EA,createtime,cid,mode,number  from '.tablename('manji_order').
           ' where ((mode=0 and number=:number) or ((mode=1 or mode=2) and number in ('.$number_fields.')) or (mode=3 and number in ('.$first_number_fields.')) or (mode=4 and number in ('.$last_number_fields.'))) and pay_EA>0 and cid like \'%('.$company_id.')%\' and status=1 and period_id like \'%('.$period_id.')%\'',array(':number'=>$winning_num));
       if (!empty($winner1)) {
          $total_winner_money = 0;  //总共赔的钱
          //给他加钱了
          foreach ($winner1 as $val) {
            $users[] = $val['user_id'];
          }
          $users = array_unique($users);
          $users = implode(',', $users);
          $winners = pdo_fetchall('select m.*,o.odds_EA from '.tablename('member_system_member').' m left join '.tablename('manji_member_odds').' o on o.member_id=m.id where m.id in ('.$users.') and o.cid=:cid',array(':cid'=>$area_id));
          foreach ($winners as $odd) {
            $odds[$odd['id']] = $odd['odds_EA'];
            $winner[$odd['id']] = $odd;
          }
          foreach ($winner1 as $win1) {
            if (empty($odds[$win1['user_id']])) {
              continue;
            }
            $odd =  $odds[$win1['user_id']];
              //给他奖的钱
            $winner_money = $win1['pay_EA'] * $odd;
            if ($win1['mode'] == 2) {
              $winner_money = $winner_money/count(sort_number($win1['number']));
            }
            $total_winner_money+= $winner_money;
    
            //保存个人记录
            $member_new_money = ((int)($winner[$win1['user_id']]['credit1'] * 10  + $winner_money *10)) / 10 ;
            winning_log($period_id, $period_number,$winner[$win1['user_id']]['id'], $winner[$win1['user_id']]['nickname'], $winner[$win1['user_id']]['credit1'], $member_new_money,
                $winning_num, $win1['pay_EA'], $winner_number_type, $winner_money, $odd, 'EA', $winner[$win1['user_id']]['id'],  $winner[$win1['user_id']]['nickname'],$number_type,$win1['id'],$win1['createtime'],$win1['number'] );
            pdo_insert('manji_winner',array('type'=>1,'user_id'=>$win1['user_id'],'lottery_number'=>$winning_num,'period_id'=>$period_id));
          }
        }
        
        
        return $total_winner_money;
}

function cal_EC($period_id, $period_number, $winning_num, $winner_number_type ,$number_type){
        //锁表
        
        

        $area_id = pdo_fetchcolumn('select aid from '.tablename('manji_run_setting').' where id=:id',array(':id'=>$period_id));
        $company_id = pdo_fetchcolumn('select cid from '.tablename('manji_run_setting').' where id=:id',array(':id'=>$period_id));

        $number_array = sort_number($winning_num);
        $new_number = substr($winning_num, -3);
        foreach ($number_array as &$num) {
          $num = substr($num,-3);
        }
        $number_array = array_unique($number_array);
        $number_fields = implode(',',$number_array);
        $first_number = substr($new_number,2);
        $last_number = substr($new_number,-2);
        for ($i=0; $i < 10; $i++) { 
          $first_array[] = $i.$last_number;
          $last_array[] = $first_number.$i;
        }
        $first_number_fields = implode(',',$first_array);
        $last_number_fields = implode(',',$last_array);
    
        //找到这一期里的所有获胜方, B 他下注了
       $winner1 = pdo_fetchall('select id, user_id,pay_EC,createtime,cid,mode,number  from '.tablename('manji_order').
           ' where ((mode=0 and (number=:number or SUBSTRING(number,1,3)='.$new_number.')) or ((mode=1 or mode=2) and (number in ('.$number_fields.') or SUBSTRING(number,1,3) in ('.$number_fields.'))) or (mode=3 and (number in ('.$first_number_fields.') or SUBSTRING(number,1,3) in ('.$first_number_fields.'))) or (mode=4 and (number in ('.$last_number_fields.') or SUBSTRING(number,1,3) in ('.$first_number_fields.')))) and pay_EC>0 and cid like \'%('.$company_id.')%\' and status=1 and period_id like \'%('.$period_id.')%\'',
           array(':number'=> substr($winning_num,-3) ));
       if (!empty($winner1)) {
          $total_winner_money = 0;  //总共赔的钱
          //给他加钱了
          foreach ($winner1 as $val) {
            $users[] = $val['user_id'];
          }
          $users = array_unique($users);
          $users = implode(',', $users);
          $winners = pdo_fetchall('select m.*,o.odds_EC from '.tablename('member_system_member').' m left join '.tablename('manji_member_odds').' o on o.member_id=m.id where m.id in ('.$users.') and o.cid=:cid',array(':cid'=>$area_id));
          foreach ($winners as $odd) {
            $odds[$odd['id']] = $odd['odds_EC'];
            $winner[$odd['id']] = $odd;
          }
          foreach ($winner1 as $win1) {
            if (empty($odds[$win1['user_id']])) {
              continue;
            }
            $odd =  $odds[$win1['user_id']];
              //给他奖的钱
            $winner_money = $win1['pay_EC'] * $odd;
            if ($win1['mode'] == 2) {
              $winner_money = $winner_money/count(sort_number($win1['number']));
            }
            $total_winner_money+= $winner_money;
    
            //保存个人记录
            $member_new_money = ((int)($winner[$win1['user_id']]['credit1'] * 10  + $winner_money *10)) / 10 ;
            winning_log($period_id, $period_number,$winner[$win1['user_id']]['id'], $winner[$win1['user_id']]['nickname'], $winner[$win1['user_id']]['credit1'], $member_new_money,
                $winning_num, $win1['pay_EC'], $winner_number_type, $winner_money, $odd, 'EC', $winner[$win1['user_id']]['id'],  $winner[$win1['user_id']]['nickname'],$number_type,$win1['id'],$win1['createtime'],$win1['number'] );
            pdo_insert('manji_winner',array('type'=>1,'user_id'=>$win1['user_id'],'lottery_number'=>$winning_num,'period_id'=>$period_id));
          }
        }
        
        
        return $total_winner_money;

}

function cal_EX($period_id, $period_number, $winning_num, $winner_number_type ,$number_type){
        //锁表
        
        

        $area_id = pdo_fetchcolumn('select aid from '.tablename('manji_run_setting').' where id=:id',array(':id'=>$period_id));
        $company_id = pdo_fetchcolumn('select cid from '.tablename('manji_run_setting').' where id=:id',array(':id'=>$period_id));

        $number_array = sort_number($winning_num);
        $new_number = substr($winning_num, -2);
        foreach ($number_array as &$num) {
          $num = substr($num,-2);
        }
        $number_array = array_unique($number_array);
        $number_fields = implode(',',$number_array);
        $first_number = substr($new_number,1);
        $last_number = substr($new_number,-1);
        for ($i=0; $i < 10; $i++) { 
          $first_array[] = $i.$last_number;
          $last_array[] = $first_number.$i;
        }
        $first_number_fields = implode(',',$first_array);
        $last_number_fields = implode(',',$last_array);
    
        //找到这一期里的所有获胜方, B 他下注了
       $winner1 = pdo_fetchall('select id, user_id,pay_EX,createtime,cid,mode,number  from '.tablename('manji_order').
           ' where ((mode=0 and (number=:number or SUBSTRING(number,2,2)='.$new_number.')) or ((mode=1 or mode=2) and (number in ('.$number_fields.') or SUBSTRING(number,2,2) in ('.$number_fields.'))) or (mode=3 and (number in ('.$first_number_fields.') or SUBSTRING(number,2,2) in ('.$first_number_fields.'))) or (mode=4 and (number in ('.$last_number_fields.') or SUBSTRING(number,2,2) in ('.$first_number_fields.')))) and pay_EX>0 and cid like \'%('.$company_id.')%\' and status=1 and period_id like \'%('.$period_id.')%\'',
           array(':number'=> substr($winning_num,-2) ));
       if (!empty($winner1)) {
          $total_winner_money = 0;  //总共赔的钱
          //给他加钱了
          foreach ($winner1 as $val) {
            $users[] = $val['user_id'];
          }
          $users = array_unique($users);
          $users = implode(',', $users);
          $winners = pdo_fetchall('select m.*,o.odds_EX from '.tablename('member_system_member').' m left join '.tablename('manji_member_odds').' o on o.member_id=m.id where m.id in ('.$users.') and o.cid=:cid',array(':cid'=>$area_id));
          foreach ($winners as $odd) {
            $odds[$odd['id']] = $odd['odds_EX'];
            $winner[$odd['id']] = $odd;
          }
          foreach ($winner1 as $win1) {
            if (empty($odds[$win1['user_id']])) {
              continue;
            }
            $odd =  $odds[$win1['user_id']];
              //给他奖的钱
            $winner_money = $win1['pay_EX'] * $odd;
            if ($win1['mode'] == 2) {
              $winner_money = $winner_money/count(sort_number($win1['number']));
            }
            $total_winner_money+= $winner_money;
    
            //保存个人记录
            $member_new_money = ((int)($winner[$win1['user_id']]['credit1'] * 10  + $winner_money *10)) / 10 ;
            winning_log($period_id, $period_number,$winner[$win1['user_id']]['id'], $winner[$win1['user_id']]['nickname'], $winner[$win1['user_id']]['credit1'], $member_new_money,
                $winning_num, $win1['pay_EX'], $winner_number_type, $winner_money, $odd, 'EX', $winner[$win1['user_id']]['id'],  $winner[$win1['user_id']]['nickname'],$number_type,$win1['id'],$win1['createtime'],$win1['number'] );
            pdo_insert('manji_winner',array('type'=>1,'user_id'=>$win1['user_id'],'lottery_number'=>$winning_num,'period_id'=>$period_id));
          }
        }
        
        
        return $total_winner_money;

}

function cal_5D1($period_id, $period_number, $winning_num, $winner_number_type,$number_type ){
    
        //锁表
        $sql = "LOCK TABLE ".tablename('manji_order'). " WRITE,".tablename('member_system_member')
            ." WRITE,".tablename('manji_reward_log')." WRITE,".tablename('manji_new_odds')." WRITE,".tablename('manji_run_setting')." WRITE,".tablename('manji_company')." WRITE,".tablename('agent_odds')." WRITE,".tablename('manji_odds')." WRITE;";
        

        $area_id = pdo_fetchcolumn('select aid from '.tablename('manji_run_setting').' where id=:id',array(':id'=>$period_id));
        $company_id = pdo_fetchcolumn('select cid from '.tablename('manji_run_setting').' where id=:id',array(':id'=>$period_id));

        $number_array = sort_number($winning_num);
        $number_fields = implode(',', $number_array);
        $first_number = substr($winning_num, 4);
        $last_number = substr($winning_num, -4);
        for ($i=0; $i < 10; $i++) { 
          $first_array[] = $i.$last_number;
          $last_array[] = $first_number.$i;
        }
        $first_number_fields = implode(',',$first_array);
        $last_number_fields = implode(',',$last_array);
    
        //找到这一期里的所有获胜方, B 他下注了
       $winner1 = pdo_fetchall('select id, user_id,pay_5D,createtime,cid,mode,number  from '.tablename('manji_order').
           ' where ((mode=0 and number=:number) or ((mode=1 or mode=2) and number in ('.$number_fields.')) or (mode=3 and number in ('.$first_number_fields.')) or (mode=4 and number in ('.$last_number_fields.'))) and pay_5D>0 and cid like \'%('.$company_id.')%\' and status=1 and period_id like \'%('.$period_id.')%\'',array(':number'=>$winning_num));
       if (!empty($winner1)) {
          $total_winner_money = 0;  //总共赔的钱
          //给他加钱了
          foreach ($winner1 as $win1){
              //找到这个人的代理人，获取代理人的陪率
              $member = pdo_fetch("select id, nickname,parent_agent,credit1,used_odds  from ".tablename('member_system_member'). '  where id='. $win1['user_id'].' and status=0');
              
              if( empty($member) ){
                  continue;  //没有代理，数据 出错
              }
              
              $agent_adds = pdo_fetchcolumn("select odds_5D from ".tablename('manji_member_odds'). '  where member_id='.$win1['user_id']);
              $agent_adds = explode('|', $agent_adds);
              file_put_contents('../addons/manji/member.log', json_encode($agent).' step2',FILE_APPEND);
              if( empty($agent_adds) ){
                  continue; //没有代理，数据 出错
              }
              //获取当前赔率
              $b4_odds = $agent_adds[0];

              //给他奖的钱
              $winner_money = $win1['pay_5D'] * $b4_odds;
              if ($win1['mode'] == 2) {
                $winner_money = $winner_money/count(sort_number($win1['number']));
              }
              $total_winner_money+= $winner_money;
              
          
              //保存单条记录
      
          //保存
          //  $res = pdo_update('member_system_member',array('credit1'=>$member['credit1'] + $winner_money ),array('id'=>$win1['user_id'] ));
              $res = pdo_query('update ims_member_system_member  set credit1 = credit1 + :money where id=:id',array(':money'=>$winner_money,':id'=>$member['id']));
      
              //保存个人记录
              $member_new_money = ((int)($member['credit1'] * 10  + $winner_money *10)) / 10 ;
              file_put_contents('../addons/manji/member.log', $total_winner_money.' step3',FILE_APPEND);
              winning_log($period_id, $period_number,$member['id'], $member['nickname'], $member['credit1'], $member_new_money,
                  $winning_num, $win1['pay_5D'],$winner_number_type, $winner_money, $b4_odds, '5D', $member['id'],  $agent['nickname'],$number_type,$win1['id'],$win1['createtime'],$win1['number'] );
          }
        }
 
        
        
        
        
        return $total_winner_money;
}

function cal_5D2($period_id, $period_number, $winning_num, $winner_number_type,$number_type ){
    
        //锁表
        $sql = "LOCK TABLE ".tablename('manji_order'). " WRITE,".tablename('member_system_member')
            ." WRITE,".tablename('manji_reward_log')." WRITE,".tablename('manji_new_odds')." WRITE,".tablename('manji_run_setting')." WRITE,".tablename('manji_company')." WRITE,".tablename('agent_odds')." WRITE,".tablename('manji_odds')." WRITE;";
        

        $area_id = pdo_fetchcolumn('select aid from '.tablename('manji_run_setting').' where id=:id',array(':id'=>$period_id));
        $company_id = pdo_fetchcolumn('select cid from '.tablename('manji_run_setting').' where id=:id',array(':id'=>$period_id));

        $number_array = sort_number($winning_num);
        $number_fields = implode(',', $number_array);
        $first_number = substr($winning_num, 4);
        $last_number = substr($winning_num, -4);
        for ($i=0; $i < 10; $i++) { 
          $first_array[] = $i.$last_number;
          $last_array[] = $first_number.$i;
        }
        $first_number_fields = implode(',',$first_array);
        $last_number_fields = implode(',',$last_array);
    
        //找到这一期里的所有获胜方, B 他下注了
       $winner1 = pdo_fetchall('select id, user_id,pay_5D,createtime,cid,mode,number  from '.tablename('manji_order').
           ' where ((mode=0 and number=:number) or ((mode=1 or mode=2) and number in ('.$number_fields.')) or (mode=3 and number in ('.$first_number_fields.')) or (mode=4 and number in ('.$last_number_fields.'))) and pay_5D>0 and cid like \'%('.$company_id.')%\' and status=1 and period_id like \'%('.$period_id.')%\'',array(':number'=>$winning_num));
       if (!empty($winner1)) {
          $total_winner_money = 0;  //总共赔的钱
          //给他加钱了
          foreach ($winner1 as $win1){
              //找到这个人的代理人，获取代理人的陪率
              $member = pdo_fetch("select id, nickname,parent_agent,credit1,used_odds  from ".tablename('member_system_member'). '  where id='. $win1['user_id'].' and status=0');
              
              if( empty($member) ){
                  continue;  //没有代理，数据 出错
              }
              
              $agent_adds = pdo_fetchcolumn("select odds_5D from ".tablename('manji_member_odds'). '  where member_id='.$win1['user_id']);
              $agent_adds = explode('|', $agent_adds);
              file_put_contents('../addons/manji/member.log', json_encode($agent).' step2',FILE_APPEND);
              if( empty($agent_adds) ){
                  continue; //没有代理，数据 出错
              }
              //获取当前赔率
              $b4_odds = $agent_adds[1];

              //给他奖的钱
              $winner_money = $win1['pay_5D'] * $b4_odds;
              if ($win1['mode'] == 2) {
                $winner_money = $winner_money/count(sort_number($win1['number']));
              }
              $total_winner_money+= $winner_money;
              
          
              //保存单条记录
      
          //保存
          //  $res = pdo_update('member_system_member',array('credit1'=>$member['credit1'] + $winner_money ),array('id'=>$win1['user_id'] ));
              $res = pdo_query('update ims_member_system_member  set credit1 = credit1 + :money where id=:id',array(':money'=>$winner_money,':id'=>$member['id']));
      
              //保存个人记录
              $member_new_money = ((int)($member['credit1'] * 10  + $winner_money *10)) / 10 ;
              file_put_contents('../addons/manji/member.log', $total_winner_money.' step3',FILE_APPEND);
              winning_log($period_id, $period_number,$member['id'], $member['nickname'], $member['credit1'], $member_new_money,
                  $winning_num, $win1['pay_5D'],$winner_number_type, $winner_money, $b4_odds, '5D', $member['id'],  $agent['nickname'],$number_type,$win1['id'],$win1['createtime'],$win1['number'] );
          }
        }
 
        
        
        
        
        return $total_winner_money;
}

function cal_5D3($period_id, $period_number, $winning_num, $winner_number_type,$number_type ){
    
        //锁表
        $sql = "LOCK TABLE ".tablename('manji_order'). " WRITE,".tablename('member_system_member')
            ." WRITE,".tablename('manji_reward_log')." WRITE,".tablename('manji_new_odds')." WRITE,".tablename('manji_run_setting')." WRITE,".tablename('manji_company')." WRITE,".tablename('agent_odds')." WRITE,".tablename('manji_odds')." WRITE;";
        

        $area_id = pdo_fetchcolumn('select aid from '.tablename('manji_run_setting').' where id=:id',array(':id'=>$period_id));
        $company_id = pdo_fetchcolumn('select cid from '.tablename('manji_run_setting').' where id=:id',array(':id'=>$period_id));
        $number_array = sort_number($winning_num);
        $number_fields = implode(',', $number_array);
        $first_number = substr($winning_num, 4);
        $last_number = substr($winning_num, -4);
        for ($i=0; $i < 10; $i++) { 
          $first_array[] = $i.$last_number;
          $last_array[] = $first_number.$i;
        }
        $first_number_fields = implode(',',$first_array);
        $last_number_fields = implode(',',$last_array);
    
        //找到这一期里的所有获胜方, B 他下注了
       $winner1 = pdo_fetchall('select id, user_id,pay_5D,createtime,cid,mode,number  from '.tablename('manji_order').
           ' where ((mode=0 and number=:number) or ((mode=1 or mode=2) and number in ('.$number_fields.')) or (mode=3 and number in ('.$first_number_fields.')) or (mode=4 and number in ('.$last_number_fields.'))) and pay_5D>0 and cid like \'%('.$company_id.')%\' and status=1 and period_id like \'%('.$period_id.')%\'',array(':number'=>$winning_num));
       if (!empty($winner1)) {
          $total_winner_money = 0;  //总共赔的钱
          //给他加钱了
          foreach ($winner1 as $win1){
              //找到这个人的代理人，获取代理人的陪率
              $member = pdo_fetch("select id, nickname,parent_agent,credit1,used_odds  from ".tablename('member_system_member'). '  where id='. $win1['user_id'].' and status=0');
              
              if( empty($member) ){
                  continue;  //没有代理，数据 出错
              }
              
              $agent_adds = pdo_fetchcolumn("select odds_5D from ".tablename('manji_member_odds'). '  where member_id='.$win1['user_id']);
              $agent_adds = explode('|', $agent_adds);
              file_put_contents('../addons/manji/member.log', json_encode($agent).' step2',FILE_APPEND);
              if( empty($agent_adds) ){
                  continue; //没有代理，数据 出错
              }
              //获取当前赔率
              $b4_odds = $agent_adds[2];

              //给他奖的钱
              $winner_money = $win1['pay_5D'] * $b4_odds;
              if ($win1['mode'] == 2) {
                $winner_money = $winner_money/count(sort_number($win1['number']));
              }
              $total_winner_money+= $winner_money;
              
          
              //保存单条记录
      
          //保存
          //  $res = pdo_update('member_system_member',array('credit1'=>$member['credit1'] + $winner_money ),array('id'=>$win1['user_id'] ));
              $res = pdo_query('update ims_member_system_member  set credit1 = credit1 + :money where id=:id',array(':money'=>$winner_money,':id'=>$member['id']));
      
              //保存个人记录
              $member_new_money = ((int)($member['credit1'] * 10  + $winner_money *10)) / 10 ;
              file_put_contents('../addons/manji/member.log', $total_winner_money.' step3',FILE_APPEND);
              winning_log($period_id, $period_number,$member['id'], $member['nickname'], $member['credit1'], $member_new_money,
                  $winning_num, $win1['pay_5D'],$winner_number_type, $winner_money, $b4_odds, '5D', $member['id'],  $agent['nickname'],$number_type,$win1['id'],$win1['createtime'],$win1['number'] );
          }
        }
 
        
        
        
        
        return $total_winner_money;
}

function cal_5D4($period_id, $period_number, $winning_num, $winner_number_type,$number_type ){
    
        //锁表
        $sql = "LOCK TABLE ".tablename('manji_order'). " WRITE,".tablename('member_system_member')
            ." WRITE,".tablename('manji_reward_log')." WRITE,".tablename('manji_new_odds')." WRITE,".tablename('manji_run_setting')." WRITE,".tablename('manji_company')." WRITE,".tablename('agent_odds')." WRITE,".tablename('manji_odds')." WRITE;";
        

        $area_id = pdo_fetchcolumn('select aid from '.tablename('manji_run_setting').' where id=:id',array(':id'=>$period_id));
        $company_id = pdo_fetchcolumn('select cid from '.tablename('manji_run_setting').' where id=:id',array(':id'=>$period_id));

        $number_array = sort_number($winning_num);
        $number_fields = implode(',', $number_array);
        $first_number = substr($winning_num, 3);
        $last_number = substr($winning_num, -3);
        for ($i=0; $i < 10; $i++) { 
          $first_array[] = $i.$last_number;
          $last_array[] = $first_number.$i;
        }
        $first_number_fields = implode(',',$first_array);
        $last_number_fields = implode(',',$last_array);
    
        //找到这一期里的所有获胜方, B 他下注了
       $winner1 = pdo_fetchall('select id, user_id,pay_5D,createtime,cid,mode,number  from '.tablename('manji_order').
           ' where ((mode=0 and number=:number) or ((mode=1 or mode=2) and SUBSTRING(number,2,4) in ('.$number_fields.')) or (mode=3 and SUBSTRING(number,1,4) in ('.$first_number_fields.')) or (mode=4 and SUBSTRING(number,2,4) in ('.$last_number_fields.'))) and pay_5D>0 and cid like \'%('.$company_id.')%\' and status=1 and period_id like \'%('.$period_id.')%\'',array(':number'=>$winning_num));
       if (!empty($winner1)) {
          $total_winner_money = 0;  //总共赔的钱
          //给他加钱了
          foreach ($winner1 as $win1){
              //找到这个人的代理人，获取代理人的陪率
              $member = pdo_fetch("select id, nickname,parent_agent,credit1,used_odds  from ".tablename('member_system_member'). '  where id='. $win1['user_id'].' and status=0');
              
              if( empty($member) ){
                  continue;  //没有代理，数据 出错
              }
              
              $agent_adds = pdo_fetchcolumn("select odds_5D from ".tablename('manji_member_odds'). '  where member_id='.$win1['user_id']);
              $agent_adds = explode('|', $agent_adds);
              file_put_contents('../addons/manji/member.log', json_encode($agent).' step2',FILE_APPEND);
              if( empty($agent_adds) ){
                  continue; //没有代理，数据 出错
              }
              //获取当前赔率
              $b4_odds = $agent_adds[0];

              //给他奖的钱
              $winner_money = $win1['pay_5D'] * $b4_odds;
              if ($win1['mode'] == 2) {
                $winner_money = $winner_money/count(sort_number($win1['number']));
              }
              $total_winner_money+= $winner_money;
              
          
              //保存单条记录
      
          //保存
          //  $res = pdo_update('member_system_member',array('credit1'=>$member['credit1'] + $winner_money ),array('id'=>$win1['user_id'] ));
              $res = pdo_query('update ims_member_system_member  set credit1 = credit1 + :money where id=:id',array(':money'=>$winner_money,':id'=>$member['id']));
      
              //保存个人记录
              $member_new_money = ((int)($member['credit1'] * 10  + $winner_money *10)) / 10 ;
              file_put_contents('../addons/manji/member.log', $total_winner_money.' step3',FILE_APPEND);
              winning_log($period_id, $period_number,$member['id'], $member['nickname'], $member['credit1'], $member_new_money,
                  $winning_num, $win1['pay_5D'],$winner_number_type, $winner_money, $b4_odds, '5D', $member['id'],  $agent['nickname'],$number_type,$win1['id'],$win1['createtime'],$win1['number'] );
          }
        }
 
        
        
        
        
        return $total_winner_money;
}

function cal_5D5($period_id, $period_number, $winning_num, $winner_number_type,$number_type ){
    
        //锁表
        $sql = "LOCK TABLE ".tablename('manji_order'). " WRITE,".tablename('member_system_member')
            ." WRITE,".tablename('manji_reward_log')." WRITE,".tablename('manji_new_odds')." WRITE,".tablename('manji_run_setting')." WRITE,".tablename('manji_company')." WRITE,".tablename('agent_odds')." WRITE,".tablename('manji_odds')." WRITE;";
        

        $area_id = pdo_fetchcolumn('select aid from '.tablename('manji_run_setting').' where id=:id',array(':id'=>$period_id));
        $company_id = pdo_fetchcolumn('select cid from '.tablename('manji_run_setting').' where id=:id',array(':id'=>$period_id));

        $number_array = sort_number($winning_num);
        $number_fields = implode(',', $number_array);
        $first_number = substr($winning_num, 2);
        $last_number = substr($winning_num, -2);
        for ($i=0; $i < 10; $i++) { 
          $first_array[] = $i.$last_number;
          $last_array[] = $first_number.$i;
        }
        $first_number_fields = implode(',',$first_array);
        $last_number_fields = implode(',',$last_array);
    
        //找到这一期里的所有获胜方, B 他下注了
       $winner1 = pdo_fetchall('select id, user_id,pay_5D,createtime,cid,mode,number  from '.tablename('manji_order').
           ' where ((mode=0 and number=:number) or ((mode=1 or mode=2) and SUBSTRING(number,3,3) in ('.$number_fields.')) or (mode=3 and SUBSTRING(number,3,3) in ('.$first_number_fields.')) or (mode=4 and SUBSTRING(number,3,3) in ('.$last_number_fields.'))) and pay_5D>0 and cid like \'%('.$company_id.')%\' and status=1 and period_id like \'%('.$period_id.')%\'',array(':number'=>$winning_num));
       if (!empty($winner1)) {
          $total_winner_money = 0;  //总共赔的钱
          //给他加钱了
          foreach ($winner1 as $win1){
              //找到这个人的代理人，获取代理人的陪率
              $member = pdo_fetch("select id, nickname,parent_agent,credit1,used_odds  from ".tablename('member_system_member'). '  where id='. $win1['user_id'].' and status=0');
              
              if( empty($member) ){
                  continue;  //没有代理，数据 出错
              }
              
              $agent_adds = pdo_fetchcolumn("select odds_5D from ".tablename('manji_member_odds'). '  where member_id='.$win1['user_id']);
              $agent_adds = explode('|', $agent_adds);
              file_put_contents('../addons/manji/member.log', json_encode($agent).' step2',FILE_APPEND);
              if( empty($agent_adds) ){
                  continue; //没有代理，数据 出错
              }
              //获取当前赔率
              $b4_odds = $agent_adds[0];

              //给他奖的钱
              $winner_money = $win1['pay_5D'] * $b4_odds;
              if ($win1['mode'] == 2) {
                $winner_money = $winner_money/count(sort_number($win1['number']));
              }
              $total_winner_money+= $winner_money;
              
          
              //保存单条记录
      
          //保存
          //  $res = pdo_update('member_system_member',array('credit1'=>$member['credit1'] + $winner_money ),array('id'=>$win1['user_id'] ));
              $res = pdo_query('update ims_member_system_member  set credit1 = credit1 + :money where id=:id',array(':money'=>$winner_money,':id'=>$member['id']));
      
              //保存个人记录
              $member_new_money = ((int)($member['credit1'] * 10  + $winner_money *10)) / 10 ;
              file_put_contents('../addons/manji/member.log', $total_winner_money.' step3',FILE_APPEND);
              winning_log($period_id, $period_number,$member['id'], $member['nickname'], $member['credit1'], $member_new_money,
                  $winning_num, $win1['pay_5D'],$winner_number_type, $winner_money, $b4_odds, '5D', $member['id'],  $agent['nickname'],$number_type,$win1['id'],$win1['createtime'],$win1['number'] );
          }
        }
 
        
        
        
        
        return $total_winner_money;
}

function cal_5D6($period_id, $period_number, $winning_num, $winner_number_type,$number_type ){
    
        //锁表
        $sql = "LOCK TABLE ".tablename('manji_order'). " WRITE,".tablename('member_system_member')
            ." WRITE,".tablename('manji_reward_log')." WRITE,".tablename('manji_new_odds')." WRITE,".tablename('manji_run_setting')." WRITE,".tablename('manji_company')." WRITE,".tablename('agent_odds')." WRITE,".tablename('manji_odds')." WRITE;";
        

        $area_id = pdo_fetchcolumn('select aid from '.tablename('manji_run_setting').' where id=:id',array(':id'=>$period_id));
        $company_id = pdo_fetchcolumn('select cid from '.tablename('manji_run_setting').' where id=:id',array(':id'=>$period_id));

        $number_array = sort_number($winning_num);
        $number_fields = implode(',', $number_array);
        $first_number = substr($winning_num, 1);
        $last_number = substr($winning_num, -1);
        for ($i=0; $i < 10; $i++) { 
          $first_array[] = $i.$last_number;
          $last_array[] = $first_number.$i;
        }
        $first_number_fields = implode(',',$first_array);
        $last_number_fields = implode(',',$last_array);
    
        //找到这一期里的所有获胜方, B 他下注了
       $winner1 = pdo_fetchall('select id, user_id,pay_5D,createtime,cid,mode,number  from '.tablename('manji_order').
           ' where ((mode=0 and number=:number) or ((mode=1 or mode=2) and SUBSTRING(number,4,2) in ('.$number_fields.')) or (mode=3 and SUBSTRING(number,1,2) in ('.$first_number_fields.')) or (mode=4 and SUBSTRING(number,4,2) in ('.$last_number_fields.'))) and pay_5D>0 and cid like \'%('.$company_id.')%\' and status=1 and period_id like \'%('.$period_id.')%\'',array(':number'=>$winning_num));
       if (!empty($winner1)) {
          $total_winner_money = 0;  //总共赔的钱
          //给他加钱了
          foreach ($winner1 as $win1){
              //找到这个人的代理人，获取代理人的陪率
              $member = pdo_fetch("select id, nickname,parent_agent,credit1,used_odds  from ".tablename('member_system_member'). '  where id='. $win1['user_id'].' and status=0');
              
              if( empty($member) ){
                  continue;  //没有代理，数据 出错
              }
              
              $agent_adds = pdo_fetchcolumn("select odds_5D from ".tablename('manji_member_odds'). '  where member_id='.$win1['user_id']);
              $agent_adds = explode('|', $agent_adds);
              file_put_contents('../addons/manji/member.log', json_encode($agent).' step2',FILE_APPEND);
              if( empty($agent_adds) ){
                  continue; //没有代理，数据 出错
              }
              //获取当前赔率
              $b4_odds = $agent_adds[0];

              //给他奖的钱
              $winner_money = $win1['pay_5D'] * $b4_odds;
              if ($win1['mode'] == 2) {
                $winner_money = $winner_money/count(sort_number($win1['number']));
              }
              $total_winner_money+= $winner_money;
              
          
              //保存单条记录
      
          //保存
          //  $res = pdo_update('member_system_member',array('credit1'=>$member['credit1'] + $winner_money ),array('id'=>$win1['user_id'] ));
              $res = pdo_query('update ims_member_system_member  set credit1 = credit1 + :money where id=:id',array(':money'=>$winner_money,':id'=>$member['id']));
      
              //保存个人记录
              $member_new_money = ((int)($member['credit1'] * 10  + $winner_money *10)) / 10 ;
              file_put_contents('../addons/manji/member.log', $total_winner_money.' step3',FILE_APPEND);
              winning_log($period_id, $period_number,$member['id'], $member['nickname'], $member['credit1'], $member_new_money,
                  $winning_num, $win1['pay_5D'],$winner_number_type, $winner_money, $b4_odds, '5D', $member['id'],  $agent['nickname'],$number_type,$win1['id'],$win1['createtime'],$win1['number'] );
          }
        }
 
        
        
        
        
        return $total_winner_money;
}

function cal_6D1($period_id, $period_number, $winning_num, $winner_number_type,$number_type ){
    
        //锁表
        $sql = "LOCK TABLE ".tablename('manji_order'). " WRITE,".tablename('member_system_member')
            ." WRITE,".tablename('manji_reward_log')." WRITE,".tablename('manji_new_odds')." WRITE,".tablename('manji_run_setting')." WRITE,".tablename('manji_company')." WRITE,".tablename('agent_odds')." WRITE,".tablename('manji_odds')." WRITE;";
        

        $area_id = pdo_fetchcolumn('select aid from '.tablename('manji_run_setting').' where id=:id',array(':id'=>$period_id));
        $company_id = pdo_fetchcolumn('select cid from '.tablename('manji_run_setting').' where id=:id',array(':id'=>$period_id));

        $number_array = sort_number($winning_num);
        $number_fields = implode(',', $number_array);
        $first_number = substr($winning_num, 5);
        $last_number = substr($winning_num, -5);
        for ($i=0; $i < 10; $i++) { 
          $first_array[] = $i.$last_number;
          $last_array[] = $first_number.$i;
        }
        $first_number_fields = implode(',',$first_array);
        $last_number_fields = implode(',',$last_array);
    
        //找到这一期里的所有获胜方, B 他下注了
       $winner1 = pdo_fetchall('select id, user_id,pay_6D,createtime,cid,mode,number  from '.tablename('manji_order').
           ' where ((mode=0 and number=:number) or ((mode=1 or mode=2) and number in ('.$number_fields.')) or (mode=3 and number in ('.$first_number_fields.')) or (mode=4 and number in ('.$last_number_fields.'))) and pay_6D>0 and cid like \'%('.$company_id.')%\' and status=1 and period_id like \'%('.$period_id.')%\'',array(':number'=>$winning_num));
       if (!empty($winner1)) {
          $total_winner_money = 0;  //总共赔的钱
          //给他加钱了
          foreach ($winner1 as $win1){
              //找到这个人的代理人，获取代理人的陪率
              $member = pdo_fetch("select id, nickname,parent_agent,credit1,used_odds  from ".tablename('member_system_member'). '  where id='. $win1['user_id'].' and status=0');
              
              if( empty($member) ){
                  continue;  //没有代理，数据 出错
              }
              
              $agent_adds = pdo_fetch("select * from ".tablename('manji_new_odds'). '  where cid like \'%('.$company_id.')%\' and type=2');
              file_put_contents('../addons/manji/member.log', json_encode($agent).' step2',FILE_APPEND);
              if( empty($agent_adds) ){
                  continue; //没有代理，数据 出错
              }
              //获取当前赔率
              $b4_odds = $agent_adds['first'];



              //给他奖的钱
              $winner_money = $win1['pay_6D'] * $b4_odds;
              if ($win1['mode'] == 2) {
                $winner_money = $winner_money/count(sort_number($win1['number']));
              }
              $total_winner_money+= $winner_money;
              
          
              //保存单条记录
      
          //保存
          //  $res = pdo_update('member_system_member',array('credit1'=>$member['credit1'] + $winner_money ),array('id'=>$win1['user_id'] ));
              $res = pdo_query('update ims_member_system_member  set credit1 = credit1 + :money where id=:id',array(':money'=>$winner_money,':id'=>$member['id']));
      
              //保存个人记录
              $member_new_money = ((int)($member['credit1'] * 10  + $winner_money *10)) / 10 ;
              file_put_contents('../addons/manji/member.log', $total_winner_money.' step3',FILE_APPEND);
              winning_log($period_id, $period_number,$member['id'], $member['nickname'], $member['credit1'], $member_new_money,
                  $winning_num, $win1['pay_6D'],$winner_number_type, $winner_money, $b4_odds, '6D', $member['id'],  $agent['nickname'],$number_type,$win1['id'],$win1['createtime'],$win1['number'] );
          }
        }
 
        
        
        
        
        return $total_winner_money;
}

function cal_6D2($period_id, $period_number, $winning_num, $winner_number_type,$number_type ){
    
        //锁表
        $sql = "LOCK TABLE ".tablename('manji_order'). " WRITE,".tablename('member_system_member')
            ." WRITE,".tablename('manji_reward_log')." WRITE,".tablename('manji_new_odds')." WRITE,".tablename('manji_run_setting')." WRITE,".tablename('manji_company')." WRITE,".tablename('agent_odds')." WRITE,".tablename('manji_odds')." WRITE;";
        

        $area_id = pdo_fetchcolumn('select aid from '.tablename('manji_run_setting').' where id=:id',array(':id'=>$period_id));
        $company_id = pdo_fetchcolumn('select cid from '.tablename('manji_run_setting').' where id=:id',array(':id'=>$period_id));

        $number_array = sort_number($winning_num);
        $new_number = substr($winning_num,1);
        $new_number2 = substr($winning_num,0,5);
        foreach ($number_array as &$num) {
          $num = substr($num,1);
          $number_array2[] = substr($num,0,5);
        }
        $number_fields = implode(',', $number_array);
        $number_fields2 = implode(',', $number_array2);
        $first_number = substr($winning_num,0,5);
        $last_number = substr($winning_num,1);
        for ($i=0; $i < 10; $i++) { 
          $first_array[] = substr($i.$last_number,0,5);
          $last_array[] = substr($first_number.$i,1);
        }
        $first_number_fields = implode(',',$first_array);
        $last_number_fields = implode(',',$last_array);
    
        //找到这一期里的所有获胜方, B 他下注了
       $winner1 = pdo_fetchall('select id, user_id,pay_6D,createtime,cid,mode,number  from '.tablename('manji_order').
           ' where cid like \'%('.$company_id.')%\' and status=1 and period_id like \'%('.$period_id.')%\' and pay_6D>0 and mode=0 and SUBSTRING(number,1)='.$new_number.' or SUBSTRING(number,0,5)='.$new_number2);
       $winner2 = pdo_fetchall('select id, user_id,pay_6D,createtime,cid,mode,number  from '.tablename('manji_order').
           ' where cid like \'%('.$company_id.')%\' and status=1 and period_id like \'%('.$period_id.')%\' and pay_6D>0 and mode=1 and SUBSTRING(number,1) in ('.$number_fields.') or SUBSTRING(number,0,5) in ('.$number_fields2.')');
       $winner1 = array_merge($winner1,$winner2);
       $winner3 = pdo_fetchall('select id, user_id,pay_6D,createtime,cid,mode,number  from '.tablename('manji_order').
           ' where cid like \'%('.$company_id.')%\' and status=1 and period_id like \'%('.$period_id.')%\' and pay_6D>0 and mode=2 and SUBSTRING(number,1) in ('.$number_fields.') or SUBSTRING(number,0,5) in ('.$number_fields2.')');
       $winner1 = array_merge($winner1,$winner3);
       $winner4 = pdo_fetchall('select id, user_id,pay_6D,createtime,cid,mode,number  from '.tablename('manji_order').
           ' where cid like \'%('.$company_id.')%\' and status=1 and period_id like \'%('.$period_id.')%\' and pay_6D>0 and mode=3 and SUBSTRING(number,1)='.$new_number.' or SUBSTRING(number,0,5) in ('.$first_number_fields.')');
       $winner1 = array_merge($winner1,$winner4);
       $winner5 = pdo_fetchall('select id, user_id,pay_6D,createtime,cid,mode,number  from '.tablename('manji_order').
           ' where cid like \'%('.$company_id.')%\' and status=1 and period_id like \'%('.$period_id.')%\' and pay_6D>0 and mode=4 and SUBSTRING(number,0,5)='.$new_number.' or SUBSTRING(number,1) in ('.$last_number_fields.')');
       $winner1 = array_merge($winner1,$winner5);
       if (!empty($winner1)) {
          $total_winner_money = 0;  //总共赔的钱
          //给他加钱了
          foreach ($winner1 as $win1){
              //找到这个人的代理人，获取代理人的陪率
              $member = pdo_fetch("select id, nickname,parent_agent,credit1,used_odds  from ".tablename('member_system_member'). '  where id='. $win1['user_id'].' and status=0');

              $has_reward = pdo_fetch('select * from '.tablename('manji_reward_log').' where number_type<=2 and winner_type=\'6D\' and bet_number=:number',array(':number'=>$win1['number']));

              if (!empty($has_reward)) {
                continue;
              }
              
              if( empty($member) ){
                  continue;  //没有代理，数据 出错
              }
              
              $agent_adds = pdo_fetch("select * from ".tablename('manji_new_odds'). '  where cid like \'%('.$company_id.')%\' and type=2');
              file_put_contents('../addons/manji/member.log', json_encode($agent).' step2',FILE_APPEND);
              if( empty($agent_adds) ){
                  continue; //没有代理，数据 出错
              }
              //获取当前赔率
              $b4_odds = $agent_adds['secound'];



              //给他奖的钱
              $winner_money = $win1['pay_6D'] * $b4_odds;
              if ($win1['mode'] == 2) {
                $winner_money = $winner_money/count(sort_number($win1['number']));
              }
              $total_winner_money+= $winner_money;
              
          
              //保存单条记录
      
          //保存
          //  $res = pdo_update('member_system_member',array('credit1'=>$member['credit1'] + $winner_money ),array('id'=>$win1['user_id'] ));
              $res = pdo_query('update ims_member_system_member  set credit1 = credit1 + :money where id=:id',array(':money'=>$winner_money,':id'=>$member['id']));
      
              //保存个人记录
              $member_new_money = ((int)($member['credit1'] * 10  + $winner_money *10)) / 10 ;
              file_put_contents('../addons/manji/member.log', $total_winner_money.' step3',FILE_APPEND);
              winning_log($period_id, $period_number,$member['id'], $member['nickname'], $member['credit1'], $member_new_money,
                  $winning_num, $win1['pay_6D'],$winner_number_type, $winner_money, $b4_odds, '6D', $member['id'],  $agent['nickname'],$number_type,$win1['id'],$win1['createtime'],$win1['number'] );
          }
        }
 
        
        
        
        
        return $total_winner_money;
}

function cal_6D3($period_id, $period_number, $winning_num, $winner_number_type,$number_type ){
    
        //锁表
        $sql = "LOCK TABLE ".tablename('manji_order'). " WRITE,".tablename('member_system_member')
            ." WRITE,".tablename('manji_reward_log')." WRITE,".tablename('manji_new_odds')." WRITE,".tablename('manji_run_setting')." WRITE,".tablename('manji_company')." WRITE,".tablename('agent_odds')." WRITE,".tablename('manji_odds')." WRITE;";
        

        $area_id = pdo_fetchcolumn('select aid from '.tablename('manji_run_setting').' where id=:id',array(':id'=>$period_id));
        $company_id = pdo_fetchcolumn('select cid from '.tablename('manji_run_setting').' where id=:id',array(':id'=>$period_id));

        $number_array = sort_number($winning_num);
        $new_number = substr($winning_num,2);
        $new_number2 = substr($winning_num,0,4);
        foreach ($number_array as &$num) {
          $num = substr($num,2);
          $number_array2[] = substr($num,0,4);
        }
        $number_fields = implode(',', $number_array);
        $number_fields2 = implode(',', $number_array2);
        $first_number = substr($winning_num,0,5);
        $last_number = substr($winning_num,1);
        for ($i=0; $i < 10; $i++) { 
          $first_array[] = substr($i.$last_number,0,4);
          $last_array[] = substr($first_number.$i,2);
        }
        $first_number_fields = implode(',',$first_array);
        $last_number_fields = implode(',',$last_array);
    
        //找到这一期里的所有获胜方, B 他下注了
       $winner1 = pdo_fetchall('select id, user_id,pay_6D,createtime,cid,mode,number  from '.tablename('manji_order').
           ' where cid like \'%('.$company_id.')%\' and status=1 and period_id like \'%('.$period_id.')%\' and pay_6D>0 and mode=0 and SUBSTRING(number,2)='.$new_number.' or SUBSTRING(number,0,4)='.$new_number2);
       $winner2 = pdo_fetchall('select id, user_id,pay_6D,createtime,cid,mode,number  from '.tablename('manji_order').
           ' where cid like \'%('.$company_id.')%\' and status=1 and period_id like \'%('.$period_id.')%\' and pay_6D>0 and mode=1 and SUBSTRING(number,2) in ('.$number_fields.') or SUBSTRING(number,0,4) in ('.$number_fields2.')');
       $winner1 = array_merge($winner1,$winner2);
       $winner3 = pdo_fetchall('select id, user_id,pay_6D,createtime,cid,mode,number  from '.tablename('manji_order').
           ' where cid like \'%('.$company_id.')%\' and status=1 and period_id like \'%('.$period_id.')%\' and pay_6D>0 and mode=2 and SUBSTRING(number,2) in ('.$number_fields.') or SUBSTRING(number,0,4) in ('.$number_fields2.')');
       $winner1 = array_merge($winner1,$winner3);
       $winner4 = pdo_fetchall('select id, user_id,pay_6D,createtime,cid,mode,number  from '.tablename('manji_order').
           ' where cid like \'%('.$company_id.')%\' and status=1 and period_id like \'%('.$period_id.')%\' and pay_6D>0 and mode=3 and SUBSTRING(number,2)='.$new_number.' or SUBSTRING(number,0,4) in ('.$first_number_fields.')');
       $winner1 = array_merge($winner1,$winner4);
       $winner5 = pdo_fetchall('select id, user_id,pay_6D,createtime,cid,mode,number  from '.tablename('manji_order').
           ' where cid like \'%('.$company_id.')%\' and status=1 and period_id like \'%('.$period_id.')%\' and pay_6D>0 and mode=4 and SUBSTRING(number,0,4)='.$new_number.' or SUBSTRING(number,2) in ('.$last_number_fields.')');
       $winner1 = array_merge($winner1,$winner5);
       if (!empty($winner1)) {
          $total_winner_money = 0;  //总共赔的钱
          //给他加钱了
          foreach ($winner1 as $win1){
              //找到这个人的代理人，获取代理人的陪率
              $member = pdo_fetch("select id, nickname,parent_agent,credit1,used_odds  from ".tablename('member_system_member'). '  where id='. $win1['user_id'].' and status=0');

              $has_reward = pdo_fetch('select * from '.tablename('manji_reward_log').' where number_type<=3 and winner_type=\'6D\' and bet_number=:number',array(':number'=>$win1['number']));

              if (!empty($has_reward)) {
                continue;
              }
              
              if( empty($member) ){
                  continue;  //没有代理，数据 出错
              }
              
              $agent_adds = pdo_fetch("select * from ".tablename('manji_new_odds'). '  where cid like \'%('.$company_id.')%\' and type=2');
              file_put_contents('../addons/manji/member.log', json_encode($agent).' step2',FILE_APPEND);
              if( empty($agent_adds) ){
                  continue; //没有代理，数据 出错
              }
              //获取当前赔率
              $b4_odds = $agent_adds['third'];



              //给他奖的钱
              $winner_money = $win1['pay_6D'] * $b4_odds;
              if ($win1['mode'] == 2) {
                $winner_money = $winner_money/count(sort_number($win1['number']));
              }
              $total_winner_money+= $winner_money;
              
          
              //保存单条记录
      
          //保存
          //  $res = pdo_update('member_system_member',array('credit1'=>$member['credit1'] + $winner_money ),array('id'=>$win1['user_id'] ));
              $res = pdo_query('update ims_member_system_member  set credit1 = credit1 + :money where id=:id',array(':money'=>$winner_money,':id'=>$member['id']));
      
              //保存个人记录
              $member_new_money = ((int)($member['credit1'] * 10  + $winner_money *10)) / 10 ;
              file_put_contents('../addons/manji/member.log', $total_winner_money.' step3',FILE_APPEND);
              winning_log($period_id, $period_number,$member['id'], $member['nickname'], $member['credit1'], $member_new_money,
                  $winning_num, $win1['pay_6D'],$winner_number_type, $winner_money, $b4_odds, '6D', $member['id'],  $agent['nickname'],$number_type,$win1['id'],$win1['createtime'],$win1['number'] );
          }
        }
 
        
        
        
        
        return $total_winner_money;
}

function cal_6D4($period_id, $period_number, $winning_num, $winner_number_type,$number_type ){
    
        //锁表
        $sql = "LOCK TABLE ".tablename('manji_order'). " WRITE,".tablename('member_system_member')
            ." WRITE,".tablename('manji_reward_log')." WRITE,".tablename('manji_new_odds')." WRITE,".tablename('manji_run_setting')." WRITE,".tablename('manji_company')." WRITE,".tablename('agent_odds')." WRITE,".tablename('manji_odds')." WRITE;";
        

        $area_id = pdo_fetchcolumn('select aid from '.tablename('manji_run_setting').' where id=:id',array(':id'=>$period_id));
        $company_id = pdo_fetchcolumn('select cid from '.tablename('manji_run_setting').' where id=:id',array(':id'=>$period_id));

        $number_array = sort_number($winning_num);
        $new_number = substr($winning_num,3);
        $new_number2 = substr($winning_num,0,3);
        foreach ($number_array as &$num) {
          $num = substr($num,3);
          $number_array2[] = substr($num,0,3);
        }
        $number_fields = implode(',', $number_array);
        $number_fields2 = implode(',', $number_array2);
        $first_number = substr($winning_num,0,5);
        $last_number = substr($winning_num,1);
        for ($i=0; $i < 10; $i++) { 
          $first_array[] = substr($i.$last_number,0,3);
          $last_array[] = substr($first_number.$i,3);
        }
        $first_number_fields = implode(',',$first_array);
        $last_number_fields = implode(',',$last_array);
    
        //找到这一期里的所有获胜方, B 他下注了
       $winner1 = pdo_fetchall('select id, user_id,pay_6D,createtime,cid,mode,number  from '.tablename('manji_order').
           ' where cid like \'%('.$company_id.')%\' and status=1 and period_id like \'%('.$period_id.')%\' and pay_6D>0 and mode=0 and SUBSTRING(number,3)='.$new_number.' or SUBSTRING(number,0,3)='.$new_number2);
       $winner2 = pdo_fetchall('select id, user_id,pay_6D,createtime,cid,mode,number  from '.tablename('manji_order').
           ' where cid like \'%('.$company_id.')%\' and status=1 and period_id like \'%('.$period_id.')%\' and pay_6D>0 and mode=1 and SUBSTRING(number,3) in ('.$number_fields.') or SUBSTRING(number,0,3) in ('.$number_fields2.')');
       $winner1 = array_merge($winner1,$winner2);
       $winner3 = pdo_fetchall('select id, user_id,pay_6D,createtime,cid,mode,number  from '.tablename('manji_order').
           ' where cid like \'%('.$company_id.')%\' and status=1 and period_id like \'%('.$period_id.')%\' and pay_6D>0 and mode=2 and SUBSTRING(number,3) in ('.$number_fields.') or SUBSTRING(number,0,3) in ('.$number_fields2.')');
       $winner1 = array_merge($winner1,$winner3);
       $winner4 = pdo_fetchall('select id, user_id,pay_6D,createtime,cid,mode,number  from '.tablename('manji_order').
           ' where cid like \'%('.$company_id.')%\' and status=1 and period_id like \'%('.$period_id.')%\' and pay_6D>0 and mode=3 and SUBSTRING(number,3)='.$new_number.' or SUBSTRING(number,0,3) in ('.$first_number_fields.')');
       $winner1 = array_merge($winner1,$winner4);
       $winner5 = pdo_fetchall('select id, user_id,pay_6D,createtime,cid,mode,number  from '.tablename('manji_order').
           ' where cid like \'%('.$company_id.')%\' and status=1 and period_id like \'%('.$period_id.')%\' and pay_6D>0 and mode=4 and SUBSTRING(number,0,3)='.$new_number.' or SUBSTRING(number,3) in ('.$last_number_fields.')');
       $winner1 = array_merge($winner1,$winner5);
       if (!empty($winner1)) {
          $total_winner_money = 0;  //总共赔的钱
          //给他加钱了
          foreach ($winner1 as $win1){
              //找到这个人的代理人，获取代理人的陪率
              $member = pdo_fetch("select id, nickname,parent_agent,credit1,used_odds  from ".tablename('member_system_member'). '  where id='. $win1['user_id'].' and status=0');

              $has_reward = pdo_fetch('select * from '.tablename('manji_reward_log').' where number_type<=4 and winner_type=\'6D\' and bet_number=:number',array(':number'=>$win1['number']));

              if (!empty($has_reward)) {
                continue;
              }
              
              if( empty($member) ){
                  continue;  //没有代理，数据 出错
              }
              
              $agent_adds = pdo_fetch("select * from ".tablename('manji_new_odds'). '  where cid like \'%('.$company_id.')%\' and type=2');
              file_put_contents('../addons/manji/member.log', json_encode($agent).' step2',FILE_APPEND);
              if( empty($agent_adds) ){
                  continue; //没有代理，数据 出错
              }
              //获取当前赔率
              $b4_odds = $agent_adds['fourth'];



              //给他奖的钱
              $winner_money = $win1['pay_6D'] * $b4_odds;
              if ($win1['mode'] == 2) {
                $winner_money = $winner_money/count(sort_number($win1['number']));
              }
              $total_winner_money+= $winner_money;
              
          
              //保存单条记录
      
          //保存
          //  $res = pdo_update('member_system_member',array('credit1'=>$member['credit1'] + $winner_money ),array('id'=>$win1['user_id'] ));
              $res = pdo_query('update ims_member_system_member  set credit1 = credit1 + :money where id=:id',array(':money'=>$winner_money,':id'=>$member['id']));
      
              //保存个人记录
              $member_new_money = ((int)($member['credit1'] * 10  + $winner_money *10)) / 10 ;
              file_put_contents('../addons/manji/member.log', $total_winner_money.' step3',FILE_APPEND);
              winning_log($period_id, $period_number,$member['id'], $member['nickname'], $member['credit1'], $member_new_money,
                  $winning_num, $win1['pay_6D'],$winner_number_type, $winner_money, $b4_odds, '6D', $member['id'],  $agent['nickname'],$number_type,$win1['id'],$win1['createtime'],$win1['number'] );
          }
        }
 
        
        
        
        
        return $total_winner_money;
}

function cal_6D5($period_id, $period_number, $winning_num, $winner_number_type,$number_type ){
    
        //锁表
        $sql = "LOCK TABLE ".tablename('manji_order'). " WRITE,".tablename('member_system_member')
            ." WRITE,".tablename('manji_reward_log')." WRITE,".tablename('manji_new_odds')." WRITE,".tablename('manji_run_setting')." WRITE,".tablename('manji_company')." WRITE,".tablename('agent_odds')." WRITE,".tablename('manji_odds')." WRITE;";
        

        $area_id = pdo_fetchcolumn('select aid from '.tablename('manji_run_setting').' where id=:id',array(':id'=>$period_id));
        $company_id = pdo_fetchcolumn('select cid from '.tablename('manji_run_setting').' where id=:id',array(':id'=>$period_id));

        $number_array = sort_number($winning_num);
        $new_number = substr($winning_num,4);
        $new_number2 = substr($winning_num,0,2);
        foreach ($number_array as &$num) {
          $num = substr($num,4);
          $number_array2[] = substr($num,0,2);
        }
        $number_fields = implode(',', $number_array);
        $number_fields2 = implode(',', $number_array2);
        $first_number = substr($winning_num,0,5);
        $last_number = substr($winning_num,1);
        for ($i=0; $i < 10; $i++) { 
          $first_array[] = substr($i.$last_number,0,2);
          $last_array[] = substr($first_number.$i,4);
        }
        $first_number_fields = implode(',',$first_array);
        $last_number_fields = implode(',',$last_array);
    
        //找到这一期里的所有获胜方, B 他下注了
       $winner1 = pdo_fetchall('select id, user_id,pay_6D,createtime,cid,mode,number  from '.tablename('manji_order').
           ' where cid like \'%('.$company_id.')%\' and status=1 and period_id like \'%('.$period_id.')%\' and pay_6D>0 and mode=0 and SUBSTRING(number,4)='.$new_number.' or SUBSTRING(number,0,2)='.$new_number2);
       $winner2 = pdo_fetchall('select id, user_id,pay_6D,createtime,cid,mode,number  from '.tablename('manji_order').
           ' where cid like \'%('.$company_id.')%\' and status=1 and period_id like \'%('.$period_id.')%\' and pay_6D>0 and mode=1 and SUBSTRING(number,4) in ('.$number_fields.') or SUBSTRING(number,0,2) in ('.$number_fields2.')');
       $winner1 = array_merge($winner1,$winner2);
       $winner3 = pdo_fetchall('select id, user_id,pay_6D,createtime,cid,mode,number  from '.tablename('manji_order').
           ' where cid like \'%('.$company_id.')%\' and status=1 and period_id like \'%('.$period_id.')%\' and pay_6D>0 and mode=2 and SUBSTRING(number,4) in ('.$number_fields.') or SUBSTRING(number,0,2) in ('.$number_fields2.')');
       $winner1 = array_merge($winner1,$winner3);
       $winner4 = pdo_fetchall('select id, user_id,pay_6D,createtime,cid,mode,number  from '.tablename('manji_order').
           ' where cid like \'%('.$company_id.')%\' and status=1 and period_id like \'%('.$period_id.')%\' and pay_6D>0 and mode=3 and SUBSTRING(number,4)='.$new_number.' or SUBSTRING(number,0,2) in ('.$first_number_fields.')');
       $winner1 = array_merge($winner1,$winner4);
       $winner5 = pdo_fetchall('select id, user_id,pay_6D,createtime,cid,mode,number  from '.tablename('manji_order').
           ' where cid like \'%('.$company_id.')%\' and status=1 and period_id like \'%('.$period_id.')%\' and pay_6D>0 and mode=4 and SUBSTRING(number,0,2)='.$new_number.' or SUBSTRING(number,4) in ('.$last_number_fields.')');
       $winner1 = array_merge($winner1,$winner5);
       if (!empty($winner1)) {
          $total_winner_money = 0;  //总共赔的钱
          //给他加钱了
          foreach ($winner1 as $win1){
              //找到这个人的代理人，获取代理人的陪率
              $member = pdo_fetch("select id, nickname,parent_agent,credit1,used_odds  from ".tablename('member_system_member'). '  where id='. $win1['user_id'].' and status=0');


              $has_reward = pdo_fetch('select * from '.tablename('manji_reward_log').' where number_type<=5 and winner_type=\'6D\' and bet_number=:number',array(':number'=>$win1['number']));

              if (!empty($has_reward)) {
                continue;
              }
              
              if( empty($member) ){
                  continue;  //没有代理，数据 出错
              }
              
              $agent_adds = pdo_fetch("select * from ".tablename('manji_new_odds'). '  where cid like \'%('.$company_id.')%\' and type=2');
              file_put_contents('../addons/manji/member.log', json_encode($agent).' step2',FILE_APPEND);
              if( empty($agent_adds) ){
                  continue; //没有代理，数据 出错
              }
              //获取当前赔率
              $b4_odds = $agent_adds['fifth'];



              //给他奖的钱
              $winner_money = $win1['pay_6D'] * $b4_odds;
              if ($win1['mode'] == 2) {
                $winner_money = $winner_money/count(sort_number($win1['number']));
              }
              $total_winner_money+= $winner_money;
              
          
              //保存单条记录
      
          //保存
          //  $res = pdo_update('member_system_member',array('credit1'=>$member['credit1'] + $winner_money ),array('id'=>$win1['user_id'] ));
              $res = pdo_query('update ims_member_system_member  set credit1 = credit1 + :money where id=:id',array(':money'=>$winner_money,':id'=>$member['id']));
      
              //保存个人记录
              $member_new_money = ((int)($member['credit1'] * 10  + $winner_money *10)) / 10 ;
              file_put_contents('../addons/manji/member.log', $total_winner_money.' step3',FILE_APPEND);
              winning_log($period_id, $period_number,$member['id'], $member['nickname'], $member['credit1'], $member_new_money,
                  $winning_num, $win1['pay_6D'],$winner_number_type, $winner_money, $b4_odds, '6D', $member['id'],  $agent['nickname'],$number_type,$win1['id'],$win1['createtime'],$win1['number'] );
          }
        }
 
        
        
        
        
        return $total_winner_money;
}

function big_jackpot($date)
{
  $has_win = 0;
  $cal_money = 0;
  $total_amount = 0;
  $periods = pdo_fetchColumnValue('select id from '.tablename('manji_run_setting').' where date=:date and cid=1',array(':date'=>$date),'id');
  $period = implode(',', $periods);
  $jackpot = pdo_fetchcolumn('select big_jackpot from '.tablename('manji_jackpot'));
  $condition = '';
  foreach ($periods as $p => $per) {
    if ($p == 0) {
      $condition .= ' and (period_id like \'%('.$per.')%\' ';
    }
    else{
      $condition .= ' or period_id like \'%('.$per.')%\' ';
    }
  }
  $condition .= ') ';
  $win_number = pdo_fetch('select first_no,second_no,third_no from '.tablename('manji_lottery_record').' where  cid=1 and period_id in ('.$period.')');
  foreach ($win_number as $key => $value) {
    $win_num[] = $value;
  }
  $bet_number = pdo_fetchColumnValue('select bet_number from '.tablename('manji_reward_log').' where period_id in ('.$period.') and number_type<=3',array(),'bet_number');
  $num = implode(',', $win_num);
  $order = pdo_fetchall('select number,user_id,pid,period_id,partner_number,goods_amount,array_id,mode from '.tablename('manji_order').' where partner_number in ('.$num.') and status=1 '.$condition);
  $partner = pdo_fetchall('select number,user_id,pid,period_id,goods_amount,array_id from '.tablename('manji_order').' where number in ('.$num.') and status=1 '.$condition);
  foreach ($order as $k => $o) {
    $number_count = count(sort_number($o['number']));
    $pay_amount = 0;
    foreach ($partner as $ke => $p) {
      if ($o['partner_number'] == $p['number'] && $p['array_id'] == $o['array_id'] && $p['pid'] == $o['pid']) {
        switch ($o['mode']) {
          case 1:
            $pay_amount = $o['goods_amount'] + $p['goods_amount']/$number_count; 
            break;
          case 2:
            $pay_amount = $o['goods_amount']/$number_count + $p['goods_amount']/$number_count; 
            break;
          case 3:
            $pay_amount = $o['goods_amount'] + $p['goods_amount']/10; 
            break;
          case 4:
            $pay_amount = $o['goods_amount'] + $p['goods_amount']/10; 
            break;
          default:
            $pay_amount = $o['goods_amount'] + $p['goods_amount']; 
            break;
        }
      }
      else{
        $pay_amount = $o['goods_amount'];
      }
    }
    $periodss = str_replace('(', '', $o['period_id']);
    $periodss = str_replace(')', '', $periodss);
    $periodss = explode(',', $periodss);
    foreach ($periodss as $pes) {
      if (in_array($pes,$periods)) {
        $period_id = $pes;
      }
    }
    if (in_array($o['number'], $bet_number)) {
      $total_amount += $pay_amount;
      $win_order[] = array(
        'number_team' => $o['number'].'-'.$o['partner_number'],
        'period_id' => $period_id,
        'user_id' => $o['user_id'],
        'bet_money' => $pay_amount,
        'win_type' => '大彩金',
        'order_id' => $o['pid'],
        'createtime' => time()
      );
    }
  }
  if ($total_amount < 200) {
    $total_amount = 200;
  }
  pdo_query('delete from '.tablename('manji_jackpot_log').' where period_id in ('.$period.') and win_type=\'大彩金\'');
  if (!empty($win_order)) {
    foreach ($win_order as $val) {
      $win_money = ($val['bet_money']/$total_amount)*$jackpot;
      $cal_money += $val['win_money'] = $win_money;
      pdo_insert('manji_jackpot_log',$val);
    }
  }
  if ($cal_money > 0) {
    pdo_query('update '.tablename('manji_jackpot').' set big_jackpot=big_jackpot-'.$cal_money);
  }
}

function middle_jackpot($date)
{
  $has_win = 0;
  $cal_money = 0;
  $total_amount = 0;
  $periods = pdo_fetchColumnValue('select id from '.tablename('manji_run_setting').' where date=:date and cid=1',array(':date'=>$date),'id');
  $period = implode(',', $periods);
  $condition = '';
  foreach ($periods as $p => $per) {
    if ($p == 0) {
      $condition .= ' and (period_id like \'%('.$per.')%\' ';
    }
    else{
      $condition .= ' or period_id like \'%('.$per.')%\' ';
    }
  }
  $condition .= ') ';
  $win_number1 = pdo_fetch('select first_no,second_no,third_no from '.tablename('manji_lottery_record').' where cid=1 and period_id in ('.$period.')');
  $win_number2 = pdo_fetch('select special_no from '.tablename('manji_lottery_record').' where  cid=1 and period_id in ('.$period.')');
  foreach ($win_number1 as $key => $value) {
    $win_num1[] = $value;
  }
  $jackpot = pdo_fetchcolumn('select middle_jackpot from '.tablename('manji_jackpot'));
  $win_num2 = explode('|', $win_number2['special_no']);
  $bet_number1 = pdo_fetchColumnValue('select bet_number from '.tablename('manji_reward_log').' where period_id in ('.$period.') and number_type<=3',array(),'bet_number');
  $bet_number2 = pdo_fetchColumnValue('select bet_number from '.tablename('manji_reward_log').' where period_id in ('.$period.') and number_type=4',array(),'bet_number');
  $num1 = implode(',', $win_num1);
  $num2 = implode(',', $win_num2);
  $order1 = pdo_fetchall('select number,user_id,pid,period_id,partner_number,goods_amount from '.tablename('manji_order').' where partner_number in ('.$num1.')'.$condition);
  $order2 = pdo_fetchall('select number,user_id,pid,period_id,partner_number,goods_amount from '.tablename('manji_order').' where partner_number in ('.$num2.')'.$condition);
  $partner1 = pdo_fetchall('select number,user_id,pid,period_id,goods_amount,array_id from '.tablename('manji_order').' where number in ('.$num1.') and status=1 '.$condition);
  $partner2 = pdo_fetchall('select number,user_id,pid,period_id,goods_amount,array_id from '.tablename('manji_order').' where number in ('.$num2.') and status=1 '.$condition);
  foreach ($order1 as $k1 => $o1) {
    $number_count1 = count(sort_number($o1['number']));
    $pay_amount1 = 0;
    foreach ($partner1 as $ke1 => $p1) {
      if ($o1['partner_number'] == $p1['number'] && $p1['array_id'] == $o1['array_id'] && $p1['pid'] == $o1['pid']) {
        switch ($o1['mode']) {
          case 1:
            $pay_amount1 = $o1['goods_amount'] + $p1['goods_amount']/$number_count1; 
            break;
          case 2:
            $pay_amount1 = $o1['goods_amount']/$number_count1 + $p1['goods_amount']/$number_count1; 
            break;
          case 3:
            $pay_amount1 = $o1['goods_amount'] + $p1['goods_amount']/10; 
            break;
          case 4:
            $pay_amount1 = $o1['goods_amount'] + $p1['goods_amount']/10; 
            break;
          default:
            $pay_amount1 = $o1['goods_amount'] + $p1['goods_amount']; 
            break;
        }
      }
      else{
        $pay_amount1 = $o1['goods_amount'];
      }
    }
    $periodss = str_replace('(', '', $o1['period_id']);
    $periodss = str_replace(')', '', $periodss);
    $periodss = explode(',', $periodss);
    foreach ($periodss as $pes) {
      if (in_array($pes,$periods)) {
        $period_id = $pes;
      }
    }
    if (in_array($o1['number'], $bet_number2)) {
      $total_amount += $pay_amount1;
      $win_order[] = array(
        'number_team' => $o1['number'].'-'.$o1['partner_number'],
        'period_id' => $period_id,
        'user_id' => $o1['user_id'],
        'bet_money' => $o1['goods_amount'],
        'win_type' => '中彩金',
        'order_id' => $o1['pid'],
        'createtime' => time()
      );
    }
  }
  foreach ($order2 as $k2 => $o2) {
    $number_count2 = count(sort_number($o2['number']));
    $pay_amount2 = 0;
    foreach ($partner2 as $ke2 => $p2) {
      if ($o2['partner_number'] == $p2['number'] && $p2['array_id'] == $o2['array_id'] && $p2['pid'] == $o2['pid']) {
        switch ($o2['mode']) {
          case 1:
            $pay_amount2 = $o2['goods_amount'] + $p2['goods_amount']/$number_count2; 
            break;
          case 2:
            $pay_amount2 = $o2['goods_amount']/$number_count2 + $p2['goods_amount']/$number_count2; 
            break;
          case 3:
            $pay_amount2 = $o2['goods_amount'] + $p2['goods_amount']/10; 
            break;
          case 3:
            $pay_amount2 = $o2['goods_amount'] + $p2['goods_amount']/10; 
            break;
          default:
            $pay_amount2 = $o2['goods_amount'] + $p2['goods_amount']; 
            break;
        }
      }
      else{
        $pay_amount2 = $o2['goods_amount'];
      }
    }
    $periodss = str_replace('(', '', $o2['period_id']);
    $periodss = str_replace(')', '', $periodss);
    $periodss = explode(',', $periodss);
    foreach ($periodss as $pes) {
      if (in_array($pes,$periods)) {
        $period_id = $pes;
      }
    }
    if (in_array($o2['number'], $bet_number1)) {
      $total_amount += $pay_amount2;
      $win_order[] = array(
        'number_team' => $o2['number'].'-'.$o2['partner_number'],
        'period_id' => $period_id,
        'user_id' => $o2['user_id'],
        'bet_money' => $o2['goods_amount'],
        'win_type' => '中彩金',
        'order_id' => $o2['pid'],
        'createtime' => time()
      );
    }
  }
  if ($total_amount < 200) {
    $total_amount = 200;
  }
  pdo_query('delete from '.tablename('manji_jackpot_log').' where period_id in ('.$period.') and win_type=\'中彩金\'');
  if (!empty($win_order)) {
    foreach ($win_order as $val) {
      $win_money = ($val['bet_money']/$total_amount)*$jackpot;
      $cal_money += $val['win_money'] = $win_money;
      pdo_insert('manji_jackpot_log',$val);
    }
  }
  if ($cal_money > 0) {
    pdo_query('update '.tablename('manji_jackpot').' set middle_jackpot=middle_jackpot-'.$cal_money);
  }
}

function small_jackpot($date)
{
  $has_win = 0;
  $cal_money = 0;
  $total_amount = 0;
  $periods = pdo_fetchColumnValue('select id from '.tablename('manji_run_setting').' where date=:date and cid=1',array(':date'=>$date),'id');
  $period = implode(',', $periods);
  $condition = '';
  foreach ($periods as $p => $per) {
    if ($p == 0) {
      $condition .= ' and (period_id like \'%('.$per.')%\' ';
    }
    else{
      $condition .= ' or period_id like \'%('.$per.')%\' ';
    }
  }
  $condition .= ') ';
  $win_number = pdo_fetch('select consolation_no,special_no from '.tablename('manji_lottery_record').' where  cid=1 and period_id in ('.$period.')');
  $consolation = explode('|', $win_number['consolation_no']);
  $special = explode('|', $win_number['special_no']);
  $win_num = array_merge($consolation,$special);
  $bet_number = pdo_fetchColumnValue('select bet_number from '.tablename('manji_reward_log').' where period_id in ('.$period.') and number_type>=4',array(),'bet_number');
  $num = implode(',', $win_num);
  $jackpot = pdo_fetchcolumn('select small_jackpot from '.tablename('manji_jackpot'));
  $order = pdo_fetchall('select number,user_id,pid,period_id,partner_number,goods_amount,array_id,mode from '.tablename('manji_order').' where partner_number in ('.$num.')'.$condition);
  $partner = pdo_fetchall('select number,user_id,pid,period_id,goods_amount,array_id from '.tablename('manji_order').' where number in ('.$num.') and status=1 '.$condition);
  foreach ($order as $k => $o) {
    $number_count = count(sort_number($o['number']));
    $pay_amount = 0;
    foreach ($partner as $ke => $p) {
      if ($o['partner_number'] == $p['number'] && $p['array_id'] == $o['array_id'] && $p['pid'] == $o['pid']) {
        switch ($o['mode']) {
          case 1:
            $pay_amount = $o['goods_amount'] + $p['goods_amount']/$number_count; 
            break;
          case 2:
            $pay_amount = $o['goods_amount']/$number_count + $p['goods_amount']/$number_count; 
            break;
          case 3:
            $pay_amount = $o['goods_amount'] + $p['goods_amount']/10; 
            break;
          case 4:
            $pay_amount = $o['goods_amount'] + $p['goods_amount']/10; 
            break;
          default:
            $pay_amount = $o['goods_amount'] + $p['goods_amount']; 
            break;
        }
      }
      else{
        $pay_amount = $o['goods_amount'];
      }
    }
    $periodss = str_replace('(', '', $o['period_id']);
    $periodss = str_replace(')', '', $periodss);
    $periodss = explode(',', $periodss);
    foreach ($periodss as $pes) {
      if (in_array($pes,$periods)) {
        $period_id = $pes;
      }
    }
    if (in_array($o['number'], $bet_number)) {
      $total_amount += $pay_amount;
      $win_order[] = array(
        'number_team' => $o['number'].'-'.$o['partner_number'],
        'period_id' => $period_id,
        'user_id' => $o['user_id'],
        'bet_money' => $o['goods_amount'],
        'win_type' => '小彩金',
        'order_id' => $o['pid'],
        'createtime' => time()
      );
    }
  }
  if ($total_amount < 200) {
    $total_amount = 200;
  }
  pdo_query('delete from '.tablename('manji_jackpot_log').' where period_id in ('.$period.') and win_type=\'小彩金\'');
  if (!empty($win_order)) {
    foreach ($win_order as $val) {
      $win_money = ($val['bet_money']/$total_amount)*$jackpot;
      $cal_money += $val['win_money'] = $win_money;
      pdo_insert('manji_jackpot_log',$val);
    }
  }
  if ($cal_money > 0) {
    pdo_query('update '.tablename('manji_jackpot').' set small_jackpot=small_jackpot-'.$cal_money);
  }
}


function sort_number($number /*字符串类型*/){
	
	$number_array = str_split($number,1); 
	
	$result_array = array();
	if( count($number_array) <= 1 ){
		$result_array[] = $number;
	}
	else{
		foreach($number_array as $key=>$number_arr_idx){
			//找到要排序的数，不能包含本身
			$number_remove_self = $number_array;
			unset($number_remove_self[$key]);
			
	
			//获取 字符串
			$result_sort_arr = sort_number( implode('',$number_remove_self) );
			//连接起来
			foreach($result_sort_arr as $ra){
				$result_array[] = $number_arr_idx . $ra;
			}
		}
	}
	
	//删除掉重复的
	return array_unique($result_array);
	
}

function box_bets($number,$bets)
{
	if (!empty($number) && !empty($bets)) {
		$order = array(
			'number' => $number,
			'pay_B' => $bets[0],
			'pay_S' => $bets[1],
			'pay_4A' => $bets[2],
			'pay_3ABC' => $bets[3],
			'pay_A' => $bets[4],
			'pay_C2' => $bets[5],
			'pay_C3' => $bets[6],
			'pay_C4' => $bets[7],
			'pay_C5' => $bets[8],
			'pay_EC' => $bets[9],
			'pay_4B' => $bets[10],
			'pay_4C' => $bets[11],
			'pay_4D' => $bets[12],
			'pay_4E' => $bets[13],
			'pay_EA' => $bets[14],
			'pay_4ABC' => $bets[15],
			'pay_2A' => $bets[16],
			'pay_2B' => $bets[17],
			'pay_2C' => $bets[18],
			'pay_2D' => $bets[19],
			'pay_2E' => $bets[20],
			'pay_EX' => $bets[21],
			'pay_2ABC' => $bets[22] 
		);
	}

	return $order;
}

function ibox_bets($number,$bets,$count)
{
	if (!empty($number) && !empty($bets)) {
		$order = array(
			'number' => $number,
			'pay_B' => (intval($bets[0])/intval($count)),
			'pay_S' => (intval($bets[1])/intval($count)),
			'pay_4A' => (intval($bets[2])/intval($count)),
			'pay_3ABC' => (intval($bets[3])/intval($count)),
			'pay_A' => (intval($bets[4])/intval($count)),
			'pay_C2' => (intval($bets[5])/intval($count)),
			'pay_C3' => (intval($bets[6])/intval($count)),
			'pay_C4' => (intval($bets[7])/intval($count)),
			'pay_C5' => (intval($bets[8])/intval($count)),
			'pay_EC' => (intval($bets[9])/intval($count)),
			'pay_4B' => (intval($bets[10])/intval($count)),
			'pay_4C' => (intval($bets[11])/intval($count)),
			'pay_4D' => (intval($bets[12])/intval($count)),
			'pay_4E' => (intval($bets[13])/intval($count)),
			'pay_EA' => (intval($bets[14])/intval($count)),
			'pay_4ABC' => (intval($bets[15])/intval($count)),
			'pay_2A' => (intval($bets[16])/intval($count)),
			'pay_2B' => (intval($bets[17])/intval($count)),
			'pay_2C' => (intval($bets[18])/intval($count)),
			'pay_2D' => (intval($bets[19])/intval($count)),
			'pay_2E' => (intval($bets[20])/intval($count)),
			'pay_EX' => (intval($bets[21])/intval($count)),
			'pay_2ABC' => (intval($bets[22])/intval($count)) 
		);
	}

	return $order;
}


/**
 * 普通推送
 * @param $jclient
 * @param $id
 * @param $content
 * @param $extras
 * @return mixed
 */
function jp_push($jclient,$id,$content,$extras){
    $pusher = $jclient->push()
        ->setPlatform(array('ios', 'android'))
        ->addRegistrationId($id)
        ->iosNotification($content,array('extras'=>$extras))
        ->androidNotification($content,array('extras'=>$extras))
        ->options(array('apns_production'=>false))
        ->send();
    return $pusher;
}

function jp_broadcast($jclient,$content,$extras){
    $pusher = $jclient->push()
        ->setPlatform(array('ios', 'android'))
        ->addAllAudience()
        ->iosNotification($content,array('extras'=>$extras))
        ->androidNotification($content,array('extras'=>$extras))
        ->options(array('apns_production'=>false))
        ->send();
    return $pusher;
}

/**
 * 自定义推送
 * @param $jclient
 * @param $id
 * @param $content
 * @param $msg_content
 * @return mixed
 */
function jp_msg($jclient,$id,$content,$msg_content){
    $pusher = $jclient->push()
        ->setPlatform(array('ios', 'android'))
        ->addRegistrationId($id)
        ->message($content,$msg_content)
        ->send();
    return $pusher;
}
/**
 * 自定义推送广播
 * @param $jclient
 * @param $content
 * @param $msg_content
 */
function jp_msg_broadcast($jclient,$content,$msg_content){
    $pusher = $jclient->push()
        ->setPlatform(array('ios', 'android'))
        ->addAllAudience()
        ->message($content,$msg_content)
        ->send();
    return $pusher;
}

function pc_trans($string)
{
	$str_arr = explode('/', $string);
	$array = array(
		'order' => $str_arr[2],
		'data' => $str_arr[3]
	);

	return $array;
}

function sockpush($url,$content)
{
	if (!file_exists($url)) {
        file_put_contents($url,json_encode($content));
    }
    else{
        $file = fopen($url,'w+');
        if (flock($file,LOCK_EX)) {
            fwrite($file, json_encode($content));
            flock($file, LOCK_UN);
        }
        fclose($file);
    }
}

function pdo_fetchColumnValue( $sql, $params = array(),$field){
    if($params){
        $result = pdo_fetchall($sql,$params);
    }else{
        $result = pdo_fetchall($sql);
    }

    $res = array();
    if($result){
        foreach ($result as $row){
            $res[] = $row[$field];
        }
    }
    return $res;
}

function get_children($id)
{
    $return = array();
    $list = pdo_fetchColumnValue('select id from '.tablename('agent_member').' where parent_agent=:agent and is_black=0',array(':agent'=>$id),'id');
    if (!empty($list)) {
        foreach ($list as $key => $value) {
            $children = get_children($value);
            $return = array_merge($return,$children);
        }
        $return = array_merge($return,$list);
    }

    return $return;
}

function get_max($array)
{
    $data = 0;
    foreach ($array as $key => $value) {
        if ($key>=3 && $key <5) {
            $value = $value*10;
        }
        if ($key>=5) {
            $value = $value*23;
        }
        if ($value > $data) {
            $data = $value;
        }
    }

    return $data;
}

function get_total_odds($array)
{
    $data = 0;
    foreach ($array as $key => $value) {
        if ($key>=3 && $key <5) {
            $value = $value*10;
        }
        if ($key>=5) {
            $value = $value*23;
        }
        $data += $value;
    }

    return $data;
}

function getParent($id)
{
    $list = array();
    $parent = pdo_fetchcolumn('select parent_agent from '.tablename('agent_member').' where id=:id',array(':id'=>$id));
    if (!empty($parent)) {
        $list[] = $parent;
        $next = getParent($parent);
        $list = array_merge($list,$next);
    }
    return $list;
}

function gettotalCash($id,$odd_id)
{
    $parents = getParent($id);
    $parents[] = $id;
    $id_fields = implode(',', $parents);
    $cashback = pdo_fetchall('select commission from '.tablename('agent_odds').' where agent_id in ('.$id_fields.') and pid=:id',array(':id'=>$odd_id));
    $commission = pdo_fetchcolumn('select commission from '.tablename('manji_odds').' where id=:id',array(':id'=>$odd_id));
    $commission = json_decode($commission,true);
    $data = array(
        'B' => 0,
        'A' => 0,
        'S' => 0,
        '3ABC' => 0,
        '4A' => 0,
        '4ABC' => 0,
        '2A' => 0,
        '2ABC' => 0,
        '5D' => 0,
        '6D' => 0
    );
    
    foreach ($cashback as $value) {
      $cash = json_decode($value['commission'],true);
      if (!empty($cash)) {
        foreach ($cash as $k => $v) {
            $data[$k] += $v;
        }
      }
    }
    if (!empty($commission)) {
      foreach ($commission as $r => $val) {
        $data[$r] += $val;
      }
    }

    return $data;
}

function getAllCashback($periods_id)
{
    $period = $periods_id;
    $cashback_total = 0;
    $cid = pdo_fetchcolumn('select aid from '.tablename('manji_run_setting').' where id=:id',array(':id'=>$periods_id));
    $list = pdo_fetchall('select a.id,a.account,p.cashback_percent,p.bonus_percent,p.jackpot_percent from '.tablename('agent_member').' a left join '.tablename('agent_percent').' p on a.id=p.agent_id where parent_agent=0 order by id asc ');

    foreach ($list as $key => $value) {
        $children = get_children($value['id']);
        $children[] = $value['id'];
        $children_fields = implode(',',$children);
        $junior = pdo_fetchall('select id from '.tablename('member_system_member').' where parent_agent in ('.$children_fields.')');
        $jackpot_percent = $value['jackpot_percent']?$value['jackpot_percent']:0;
        $cashback = 0;
        if (!empty($junior)) {
            foreach ($junior as $k => $v) {
                $bet_list = pdo_fetch('select sum(pay_B) as B,sum(pay_S) as S,sum(pay_A+pay_C2+pay_C3+pay_C4+pay_C5+pay_EC) as A,sum(pay_3ABC) as 3ABC,sum(pay_4A+pay_4B+pay_4C+pay_4D+pay_4E+pay_EA) as 4A,sum(pay_4ABC) as 4ABC,sum(pay_2A+pay_2B+pay_2C+pay_2D+pay_2E+pay_EX) as 2A,sum(pay_2ABC) as 2ABC from '.tablename('manji_order').' where user_id = :user_id and period_id like \'%('.$period.')%\'',array(':user_id'=>$v['id']));
                $odds = pdo_fetch('select * from '.tablename('manji_member_odds').' where member_id=:member_id and cid=:cid',array(':member_id'=>$v['id'],':cid'=>$cid));
                $odds_id = pdo_fetchcolumn('select pid from '.tablename('agent_odds').' where id=:id',array(':id'=>$odds['pid']));
                if (!empty($bet_list)) {
                    $cashback_percent = gettotalCash($value['id'],$odds_id);
                    foreach ($bet_list as $index => $item) {
                        if ($index == 'B') {
                            $odd = explode('|',$odds['odds_'.$index]);
                            $odd_total = get_total_odds($odd);
                            $odds_percent = ($odd_total)/100;
                        }
                        if ($index == 'A') {
                            $odd = array($odds['odds_A'],$odds['odds_C2'],$odds['odds_C3'],$odds['odds_C4'],$odds['odds_C5'],$odds['odds_EC']);
                            $odd_total = get_max($odd);
                            $odds_percent = ($odd_total)/10;
                        }
                        if ($index == 'S') {
                            $odd = explode('|',$odds['odds_'.$index]);
                            $odd_total = get_total_odds($odd);
                            $odds_percent = ($odd_total)/100;
                        }
                        if ($index == '3ABC') {
                            $odd = explode('|',$odds['odds_'.$index]);
                            $odd_total = get_total_odds($odd);
                            $odds_percent = ($odd_total)/10;
                        }
                        if ($index == '4ABC') {
                            $odd = explode('|',$odds['odds_'.$index]);
                            $odd_total = get_total_odds($odd);
                            $odds_percent = ($odd_total)/100;
                        }
                        if ($index == '4A') {
                            $odd = array($odds['odds_4A'],$odds['odds_4B'],$odds['odds_4C'],$odds['odds_4D'],$odds['odds_4E'],$odds['odds_EA']);
                            $odd_total = get_max($odd);
                            $odds_percent = ($odd_total)/100;
                        }
                        if ($index == '2ABC') {
                            $odd = explode('|',$odds['odds_'.$index]);
                            $odd_total = get_total_odds($odd);
                            $odds_percent = ($odd_total);
                        }
                        if ($index == '2A') {
                            $odd = array($odds['odds_2A'],$odds['odds_2B'],$odds['odds_2C'],$odds['odds_2D'],$odds['odds_2E'],$odds['odds_EX']);
                            $odd_total = get_max($odd);
                            $odds_percent = ($odd_total);
                        }
                        if ($index == '5D') {
                          $odd = explode('|', $odds['odds_'.$index]);
                          $odds_percent = get_5d_odd($odd);
                        }
                        if ($index == '6D') {
                          $odd = explode('|', $odds['odds_'.$index]);
                          $odds_percent = get_6d_odd($odd);
                        }
                        $cashback += floatval($item)*(100-floatval($cashback_percent[$index])-floatval($odds_percent)-floatval($jackpot_percent))/100;
                    }
                }
            }
            
        }
        $cashback_total += $cashback;
        
    }
    return $cashback_total;
}

function getTopic($id)
{
    $parent = pdo_fetchcolumn('select parent_agent from '.tablename('agent_member').' where id=:id',array(':id'=>$id));
    if (!empty($parent)) {
        $parent = getTopic($parent);
    }
    else{
        $parent = $id;
    }

    return $parent;
}

function saveDownline($periods_id)
{
    $cid = pdo_fetchcolumn('select aid from '.tablename('manji_run_setting').' where id=:id',array(':id'=>$periods_id));
    $company = pdo_fetchcolumn('select cid from '.tablename('manji_run_setting').' where id=:id',array(':id'=>$periods_id));
    $list = pdo_fetchall('select a.id,a.nickname,a.account,p.cashback_percent,p.bonus_percent,p.jackpot_percent,a.parent_agent from '.tablename('agent_member').' a left join '.tablename('agent_percent').' p on a.id=p.agent_id where a.cid=:cid  order by id asc ',array(':cid'=>$cid));
    $time = pdo_fetchcolumn('select endtime from '.tablename('manji_run_setting').' where id=:id',array(':id'=>$periods_id));
    $bet_total = pdo_fetchcolumn('select sum(order_amount) from '.tablename('manji_order').' where period_id like \'%('.$periods_id.')%\'');
    $reward_array = pdo_fetch('select sum(fisrt) as first,sum(second) as second, sum(third) as third,sum(consolation) as consolation,sum(special) as special,sum(D5_result) as 5D,sum(D6_result) as 6D from '.tablename('manji_pay_award').' where period_id ='.$periods_id);
    $cashback_total = getAllCashback($periods_id);
    $profit_total = $bet_total-$reward_array['first']-$reward_array['second']-$reward_array['third']-$reward_array['consolation']-$reward_array['special']-$reward_array['5D']-$reward_array['6D']-$cashback_total;

    foreach ($list as $key => $value) {
        $children = get_children($value['id']);
        $children[] = $value['id'];
        $children_fields = implode(',',$children);
        $junior = pdo_fetchall('select id from '.tablename('member_system_member').' where parent_agent in ('.$children_fields.')');
        $upline = pdo_fetch('select p.cashback_percent,p.bonus_percent,p.jackpot_percent from '.tablename('agent_member').' a left join '.tablename('agent_percent').' p on a.parent_agent=p.agent_id where a.id=:id',array(':id'=>$value['id']));
        $jackpot_percent = $value['jackpot_percent']?$value['jackpot_percent']:0;
        $cashback = 0;
        $bonus = 0;
        $profit = 0;
        $order = array();
        $upline_cashback = 0;
        $upline_bonus = 0;
        $upline_profit = 0;
        $jackpot_profit = 0;
        $cashback_only = 0;
        $pay_award = 0;
        $bet_all = 0;
        $topic_pay_award = 0;
        if (!empty($junior)) {
            foreach ($junior as $k => $v) {
                $order = pdo_fetch('select sum(order_amount) bet from '.tablename('manji_order').' where user_id = :user_id and period_id like \'%('.$periods_id.')%\'',array(':user_id'=>$v['id']));
                $order['pay_award'] = pdo_fetchcolumn('select sum(winner_money) from '.tablename('manji_reward_log').' where member_id=:member_id and period_id in ('.$periods_id.') and number_type<6',array(':member_id'=>$v['id']));
                $bet_list = pdo_fetch('select sum(pay_B) as B,sum(pay_S) as S,sum(pay_A+pay_C2+pay_C3+pay_C4+pay_C5+pay_EC) as A,sum(pay_3ABC) as 3ABC,sum(pay_4A+pay_4B+pay_4C+pay_4D+pay_4E+pay_EA) as 4A,sum(pay_4ABC) as 4ABC,sum(pay_2A+pay_2B+pay_2C+pay_2D+pay_2E+pay_EX) as 2A,sum(pay_2ABC) as 2ABC,sum(pay_5D) as 5D,sum(pay_6D) as 6D from '.tablename('manji_order').' where user_id = :user_id and period_id like \'%('.$periods_id.')%\' and status=1',array(':user_id'=>$v['id']));
                $topic_award = pdo_fetchcolumn('select sum(winner_money) from '.tablename('manji_reward_log').' where member_id=:member_id and period_id in ('.$periods_id.')',array(':member_id'=>$v['id']));
                $topic_pay_award += $topic_award;
                $odds = pdo_fetch('select * from '.tablename('manji_member_odds').' where member_id=:member_id and cid=:cid',array(':member_id'=>$v['id'],':cid'=>$cid));
                $odds_id = pdo_fetchcolumn('select pid from '.tablename('agent_odds').' where id=:id',array(':id'=>$odds['pid']));
                if (!empty($bet_list)) {
                    $cashback_percent = gettotalCash($value['id'],$odds_id);
                    if ($value['parent_agent'] > 0) {
                      $upline_cashback_percent = gettotalCash($value['parent_agent'],$odds_id);
                    }
                    else{
                      $upline_cashback_percent = 0;
                    }
                    foreach ($bet_list as $index => $item) {
                        if ($index == 'B') {
                            $odd = explode('|',$odds['odds_'.$index]);
                            $odd_total = get_total_odds($odd);
                            $odds_percent = ($odd_total)/100;
                        }
                        if ($index == 'A') {
                            $odd = array($odds['odds_A'],$odds['odds_C2'],$odds['odds_C3'],$odds['odds_C4'],$odds['odds_C5'],$odds['odds_EC']);
                            $odd_total = get_max($odd);
                            $odds_percent = ($odd_total)/10;
                        }
                        if ($index == 'S') {
                            $odd = explode('|',$odds['odds_'.$index]);
                            $odd_total = get_total_odds($odd);
                            $odds_percent = ($odd_total)/100;
                        }
                        if ($index == '3ABC') {
                            $odd = explode('|',$odds['odds_'.$index]);
                            $odd_total = get_total_odds($odd);
                            $odds_percent = ($odd_total)/10;
                        }
                        if ($index == '4ABC') {
                            $odd = explode('|',$odds['odds_'.$index]);
                            $odd_total = get_total_odds($odd);
                            $odds_percent = ($odd_total)/100;
                        }
                        if ($index == '4A') {
                            $odd = array($odds['odds_4A'],$odds['odds_4B'],$odds['odds_4C'],$odds['odds_4D'],$odds['odds_4E'],$odds['odds_EA']);
                            $odd_total = get_max($odd);
                            $odds_percent = ($odd_total)/100;
                        }
                        if ($index == '2ABC') {
                            $odd = explode('|',$odds['odds_'.$index]);
                            $odd_total = get_total_odds($odd);
                            $odds_percent = ($odd_total);
                        }
                        if ($index == '2A') {
                            $odd = array($odds['odds_2A'],$odds['odds_2B'],$odds['odds_2C'],$odds['odds_2D'],$odds['odds_2E'],$odds['odds_EX']);
                            $odd_total = get_max($odd);
                            $odds_percent = ($odd_total);
                        }
                        if ($index == '5D') {
                          $odd = explode('|', $odds['odds_'.$index]);
                          $odds_percent = get_5d_odd($odd);
                        }
                        if ($index == '6D') {
                          $odd = explode('|', $odds['odds_'.$index]);
                          $odds_percent = get_6d_odd($odd);
                        }
                        $cashback += floatval($item)*(100-floatval($cashback_percent[$index])-floatval($odds_percent)-floatval($jackpot_percent))/100;
                        $upline_cashback += floatval($item)*(100-floatval($upline_cashback_percent[$index])-floatval($odds_percent)-floatval($jackpot_percent))/100;
                    }
                    $bet_all += $order['bet'];
                    $jackpot_profit += floatval($order['bet'])*$jackpot_percent/100;
                    $pay_award += $order['pay_award'];
                    $profit += floatval($order['bet'])-($cashback+floatval($order['pay_award']));
                    $upline_profit += floatval($order['bet'])-($upline_cashback+floatval($order['pay_award']));
                }
                if ($bet_total == 0) {
                    $bet_per = 0;
                }
                else{
                    $bet_per = floatval($order['bet'])/floatval($bet_total);
                }
                $bonus += $bet_per*$profit_total*$value['bonus_percent']/100;
                $upline_bonus += $bet_per*$profit_total*$upline['bonus_percent']/100;
            }
            
        }
        $list[$key]['cashback'] = $cashback?$cashback:0;
        $list[$key]['cashback_only'] = $cashback_only?$cashback_only:0;
        $list[$key]['bonus'] = $bonus?$bonus:0;
        $list[$key]['sum_bet'] = $bet_all?$bet_all:0;
        $list[$key]['pay_award'] = $pay_award?$pay_award:0;
        $list[$key]['profit'] = ($bet_all-$pay_award-$cashback);
        $list[$key]['net'] = $list[$key]['profit'] - $list[$key]['bonus'];
        $list[$key]['upline_sum_bet'] = $bet_all?$bet_all:0;
        $list[$key]['upline_pay_award'] = $topic_pay_award?$topic_pay_award:0;
        $list[$key]['upline_cashback'] = $upline_cashback?$upline_cashback:0;
        $list[$key]['upline_bonus'] = $upline_bonus?$upline_bonus:0;
        $list[$key]['upline_profit'] = ($bet_all-$pay_award-$upline_cashback);
        $list[$key]['upline_net'] = $list[$key]['upline_profit'] - $list[$key]['upline_bonus'];
        $list[$key]['commission'] = $list[$key]['upline_cashback'] - $list[$key]['cashback'];
        $list[$key]['bonus_earn'] = $list[$key]['upline_pay_award'] - $list[$key]['pay_award'];
        $list[$key]['jackpot_profit'] = $jackpot_profit?$jackpot_profit:0;
        $list[$key]['user_type'] = 1;
    }

    $member = pdo_fetchall('select a.id,a.nickname,a.account,p.cashback_percent,p.bonus_percent,p.jackpot_percent,a.parent_agent,commission from '.tablename('member_system_member').' a left join '.tablename('agent_percent').' p on a.parent_agent=p.agent_id where a.cid=:cid order by id asc ',array(':cid'=>$cid));
    foreach ($member as $ky => $val) {
        $cashback = 0;
        $bonus = 0;
        $profit = 0;
        $order = array();
        $upline_cashback = 0;
        $upline_bonus = 0;
        $upline_profit = 0;
        $jackpot_profit = 0;
        $cashback_only = 0;
        $pay_award = 0;
        $bet_all = 0;
        $jackpot_percent = $val['jackpot_percent']?$val['jackpot_percent']:0;
        $topic_award = pdo_fetchcolumn('select sum(winner_money) from '.tablename('manji_reward_log').' where member_id=:member_id and period_id in ('.$periods_id.')',array(':member_id'=>$val['id']));
        $order = pdo_fetch('select sum(order_amount) bet from '.tablename('manji_order').' where user_id = :user_id and period_id like \'%('.$periods_id.')%\'',array(':user_id'=>$val['id']));
        $order['pay_award'] = pdo_fetchcolumn('select sum(winner_money) from '.tablename('manji_reward_log').' where member_id=:member_id and period_id in ('.$periods_id.') and number_type<=6',array(':member_id'=>$val['id']));
        $bet_list = pdo_fetch('select sum(pay_B) as B,sum(pay_S) as S,sum(pay_A+pay_C2+pay_C3+pay_C4+pay_C5+pay_EC) as A,sum(pay_3ABC) as 3ABC,sum(pay_4A+pay_4B+pay_4C+pay_4D+pay_4E+pay_EA) as 4A,sum(pay_4ABC) as 4ABC,sum(pay_2A+pay_2B+pay_2C+pay_2D+pay_2E+pay_EX) as 2A,sum(pay_2ABC) as 2ABC from '.tablename('manji_order').' where user_id = :user_id and period_id like \'%('.$periods_id.')%\' and status=1',array(':user_id'=>$val['id']));
        $odds = pdo_fetch('select * from '.tablename('manji_member_odds').' where member_id=:member_id and cid=:cid',array(':member_id'=>$val['id'],':cid'=>$cid));
        $odds_id = pdo_fetchcolumn('select pid from '.tablename('agent_odds').' where id=:id',array(':id'=>$odds['pid']));
        if (!empty($bet_list)) {
            $cashback_percent = gettotalCash($val['parent_agent'],$odds_id);
            $upline_cashback_percent = gettotalCash($val['parent_agent'],$odds_id);
            $commission = json_decode($val['commission'],true);
            foreach ($bet_list as $index => $item) {
                if ($index == 'B') {
                    $odd = explode('|',$odds['odds_'.$index]);
                    $odd_total = get_total_odds($odd);
                    $odds_percent = ($odd_total)/100;
                }
                if ($index == 'A') {
                    $odd = array($odds['odds_A'],$odds['odds_C2'],$odds['odds_C3'],$odds['odds_C4'],$odds['odds_C5'],$odds['odds_EC']);
                    $odd_total = get_max($odd);
                    $odds_percent = ($odd_total)/10;
                }
                if ($index == 'S') {
                    $odd = explode('|',$odds['odds_'.$index]);
                    $odd_total = get_total_odds($odd);
                    $odds_percent = ($odd_total)/100;
                }
                if ($index == '3ABC') {
                    $odd = explode('|',$odds['odds_'.$index]);
                    $odd_total = get_total_odds($odd);
                    $odds_percent = ($odd_total)/10;
                }
                if ($index == '4ABC') {
                    $odd = explode('|',$odds['odds_'.$index]);
                    $odd_total = get_total_odds($odd);
                    $odds_percent = ($odd_total)/100;
                }
                if ($index == '4A') {
                    $odd = array($odds['odds_4A'],$odds['odds_4B'],$odds['odds_4C'],$odds['odds_4D'],$odds['odds_4E'],$odds['odds_EA']);
                    $odd_total = get_max($odd);
                    $odds_percent = ($odd_total)/100;
                }
                if ($index == '2ABC') {
                    $odd = explode('|',$odds['odds_'.$index]);
                    $odd_total = get_total_odds($odd);
                    $odds_percent = ($odd_total);
                }
                if ($index == '2A') {
                    $odd = array($odds['odds_2A'],$odds['odds_2B'],$odds['odds_2C'],$odds['odds_2D'],$odds['odds_2E'],$odds['odds_EX']);
                    $odd_total = get_max($odd);
                    $odds_percent = ($odd_total);
                }
                if ($index == '5D') {
                  $odd = explode('|', $odds['odds_'.$index]);
                  $odds_percent = get_5d_odd($odd);
                }
                if ($index == '6D') {
                  $odd = explode('|', $odds['odds_'.$index]);
                  $odds_percent = get_6d_odd($odd);
                }
                $cashback += floatval($item)*(100-floatval($cashback_percent[$index])-floatval($odds_percent)-floatval($jackpot_percent)-floatval($commission[$index]))/100;
                $upline_cashback += floatval($item)*(100-floatval($cashback_percent[$index])-floatval($odds_percent)-floatval($jackpot_percent))/100;
                $cashback_only += floatval($item)*floatval($cashback_percent[$index])/100;
            }
            $bet_all = $order['bet'];
            $jackpot_profit = floatval($order['bet'])*$jackpot_percent/100;
            $pay_award = $order['pay_award'];
            $profit = floatval($order['bet'])-($cashback+floatval($order['pay_award']));
            if ($bet_total == 0) {
                $bet_per = 0;
            }
            else{
                $bet_per = floatval($order['bet'])/floatval($bet_total);
            }
            $upline_bonus = $bet_per*$profit_total*$val['bonus_percent']/100;
        }
        $member[$ky]['cashback'] = $cashback?$cashback:0;
        $member[$ky]['cashback_only'] = $cashback_only?$cashback_only:0;
        $member[$ky]['bonus'] = $bonus?$bonus:0;
        $member[$ky]['sum_bet'] = $bet_all?$bet_all:0;
        $member[$ky]['pay_award'] = $pay_award?$pay_award:0;
        $member[$ky]['profit'] = ($bet_all-$pay_award-$cashback);
        $member[$ky]['net'] = $member[$ky]['profit'] - $member[$ky]['bonus'];
        $member[$ky]['upline_sum_bet'] = $bet_all?$bet_all:0;
        $member[$ky]['upline_pay_award'] = $topic_award?$topic_award:0;
        $member[$ky]['upline_cashback'] = $upline_cashback?$upline_cashback:0;
        $member[$ky]['upline_bonus'] = $upline_bonus?$upline_bonus:0;
        $member[$ky]['upline_profit'] = ($bet_all-$pay_award-$upline_cashback);
        $member[$ky]['upline_net'] = $member[$ky]['upline_profit'] - $member[$ky]['upline_bonus'];
        $member[$ky]['commission'] = $member[$ky]['upline_cashback'] - $member[$ky]['cashback'];
        $member[$ky]['bonus_earn'] = $member[$ky]['upline_pay_award'] - $member[$ky]['pay_award'];
        $member[$ky]['jackpot_profit'] = $jackpot_profit?$jackpot_profit:0;
        $member[$ky]['user_type'] = 2;
    }

    $list = array_merge($list,$member);

    foreach ($list as $option) {
        if ($option['sum_bet'] > 0) {
            if ($option['user_type'] == 1) {
                $save = array(
                    'cid' => $cid,
                    'agent_id' => $option['id'],
                    'parent_agent' => $option['parent_agent'],
                    'sum_bet' => $option['sum_bet'],
                    'cashback' => $option['cashback'],
                    'pay_award' => $option['pay_award'],
                    'profit' => $option['profit'],
                    'bonus' => $option['bonus'],
                    'net' => $option['net'],
                    'upline_sum_bet' => $option['upline_sum_bet'],
                    'upline_pay_award' => $option['upline_pay_award'],
                    'upline_cashback' => $option['upline_cashback'],
                    'upline_profit' => $option['upline_profit'],
                    'upline_bonus' => $option['upline_bonus'],
                    'upline_net' => $option['upline_net'],
                    'commission' => $option['commission'],
                    'bonus_earn' => $option['bonus_earn'],
                    'create_time' => $time,
                    'periods_id' => $periods_id,
                    'company' => $company
                );
                pdo_insert('manji_downline_report',$save);
            }
            else{
                $save = array(
                    'cid' => $cid,
                    'member_id' => $option['id'],
                    'parent_agent' => $option['parent_agent'],
                    'sum_bet' => $option['sum_bet'],
                    'cashback' => $option['cashback'],
                    'pay_award' => $option['pay_award'],
                    'profit' => $option['profit'],
                    'bonus' => $option['bonus'],
                    'net' => $option['net'],
                    'upline_sum_bet' => $option['upline_sum_bet'],
                    'upline_pay_award' => $option['upline_pay_award'],
                    'upline_cashback' => $option['upline_cashback'],
                    'upline_profit' => $option['upline_profit'],
                    'upline_bonus' => $option['upline_bonus'],
                    'upline_net' => $option['upline_net'],
                    'commission' => $option['commission'],
                    'bonus_earn' => $option['bonus_earn'],
                    'create_time' => $time,
                    'periods_id' => $periods_id,
                    'company' => $company
                );
                pdo_insert('manji_downline_report',$save);
            }
        }
    }
    file_put_contents('../addons/purchasing/downline.log',json_encode($save));
}

function saveEat($period_id)
{
  $cid = pdo_fetchcolumn('select aid from '.tablename('manji_run_setting').' where id=:id',array(':id'=>$period_id));
  $list = pdo_fetchall('select a.id,a.nickname,a.account,p.cashback_percent,p.bonus_percent,p.jackpot_percent,a.parent_agent from '.tablename('agent_member').' a left join '.tablename('agent_percent').' p on a.id=p.agent_id where cid=:cid  order by id asc ',array(':cid'=>$cid));
  $bet_total = pdo_fetchcolumn('select sum(order_amount) from '.tablename('manji_order').' where period_id like \'%('.$periods_id.')%\'');
  $reward_array = pdo_fetch('select sum(fisrt) as first,sum(second) as second, sum(third) as third,sum(consolation) as consolation,sum(special) as special,sum(D5_result) as 5D,sum(D6_result) as 6D from '.tablename('manji_pay_award').' where period_id ='.$periods_id);
  $cashback_total = getAllCashback($periods_id);
  $profit_total = $bet_total-$reward_array['first']-$reward_array['second']-$reward_array['third']-$reward_array['consolation']-$reward_array['special']-$reward_array['5D']-$reward_array['6D']-$cashback_total;
  $beto = array('B','S','A','C2','C3','C4','C5','EC','3ABC','4A','4B','4C','4D','4E','EA','4ABC','2A','2B','2C','2D','2E','EX','2ABC','5D','6D');
  foreach ($list as $key => $value) {
    $children = get_children($value['id']);
    $children[] = $value['id'];
    $children_fields = implode(',',$children);
    $junior = pdo_fetchall('select id from '.tablename('member_system_member').' where parent_agent in ('.$children_fields.')');
    $upline = pdo_fetch('select p.cashback_percent,p.bonus_percent,p.jackpot_percent from '.tablename('agent_member').' a left join '.tablename('agent_percent').' p on a.parent_agent=p.agent_id where a.id=:id',array(':id'=>$value['id']));
    $jackpot_percent = $value['jackpot_percent']?$value['jackpot_percent']:0;
    $cashback = 0;
    $bonus = 0;
    $profit = 0;
    $order = array();
    $upline_cashback = 0;
    $upline_bonus = 0;
    $upline_profit = 0;
    $jackpot_profit = 0;
    $cashback_only = 0;
    $pay_award = 0;
    $bet_all = 0;
    $topic_pay_award = 0;
    $eat = 0;
    foreach ($beto as $option) {
      $eat += getEat($value['id']);
    }
    if (!empty($junior)) {
      foreach ($junior as $k => $v) {
          $order = pdo_fetch('select sum(order_amount) bet from '.tablename('manji_order').' where user_id = :user_id and period_id like \'%('.$periods_id.')%\'',array(':user_id'=>$v['id']));
          $order['pay_award'] = pdo_fetchcolumn('select sum(winner_money) from '.tablename('manji_reward_log').' where member_id=:member_id and period_id in ('.$periods_id.') and number_type<6',array(':member_id'=>$v['id']));
          $bet_list = pdo_fetch('select sum(pay_B) as B,sum(pay_S) as S,sum(pay_A+pay_C2+pay_C3+pay_C4+pay_C5+pay_EC) as A,sum(pay_3ABC) as 3ABC,sum(pay_4A+pay_4B+pay_4C+pay_4D+pay_4E+pay_EA) as 4A,sum(pay_4ABC) as 4ABC,sum(pay_2A+pay_2B+pay_2C+pay_2D+pay_2E+pay_EX) as 2A,sum(pay_2ABC) as 2ABC,sum(pay_5D) as 5D,sum(pay_6D) as 6D from '.tablename('manji_order').' where user_id = :user_id and period_id like \'%('.$periods_id.')%\' and status=1',array(':user_id'=>$v['id']));
          $topic_award = pdo_fetchcolumn('select sum(winner_money) from '.tablename('manji_reward_log').' where member_id=:member_id and period_id in ('.$periods_id.')',array(':member_id'=>$v['id']));
          $topic_pay_award += $topic_award;
          $odds = pdo_fetch('select * from '.tablename('manji_member_odds').' where member_id=:member_id and cid=:cid',array(':member_id'=>$v['id']));
          if (!empty($bet_list)) {
              $cashback_percent = gettotalCash($value['id']);
              $upline_cashback_percent = gettotalCash($value['parent_agent']);
              foreach ($bet_list as $index => $item) {
                  if ($index == 'B') {
                      $odd = explode('|',$odds['odds_'.$index]);
                      $odd_total = get_total_odds($odd);
                      $odds_percent = ($odd_total)/100;
                  }
                  if ($index == 'A') {
                      $odd = array($odds['odds_A'],$odds['odds_C2'],$odds['odds_C3'],$odds['odds_C4'],$odds['odds_C5'],$odds['odds_EC']);
                      $odd_total = get_max($odd);
                      $odds_percent = ($odd_total)/10;
                  }
                  if ($index == 'S') {
                      $odd = explode('|',$odds['odds_'.$index]);
                      $odd_total = get_total_odds($odd);
                      $odds_percent = ($odd_total)/100;
                  }
                  if ($index == '3ABC') {
                      $odd = explode('|',$odds['odds_'.$index]);
                      $odd_total = get_total_odds($odd);
                      $odds_percent = ($odd_total)/10;
                  }
                  if ($index == '4ABC') {
                      $odd = explode('|',$odds['odds_'.$index]);
                      $odd_total = get_total_odds($odd);
                      $odds_percent = ($odd_total)/100;
                  }
                  if ($index == '4A') {
                      $odd = array($odds['odds_4A'],$odds['odds_4B'],$odds['odds_4C'],$odds['odds_4D'],$odds['odds_4E'],$odds['odds_EA']);
                      $odd_total = get_max($odd);
                      $odds_percent = ($odd_total)/100;
                  }
                  if ($index == '2ABC') {
                      $odd = explode('|',$odds['odds_'.$index]);
                      $odd_total = get_total_odds($odd);
                      $odds_percent = ($odd_total);
                  }
                  if ($index == '2A') {
                      $odd = array($odds['odds_2A'],$odds['odds_2B'],$odds['odds_2C'],$odds['odds_2D'],$odds['odds_2E'],$odds['odds_EX']);
                      $odd_total = get_max($odd);
                      $odds_percent = ($odd_total);
                  }
                  if ($index == '5D') {
                    $odd = explode('|', $odds['odds_'.$index]);
                    $odds_percent = get_5d_odd($odd);
                  }
                  if ($index == '6D') {
                    $odd = explode('|', $odds['odds_'.$index]);
                    $odds_percent = get_6d_odd($odd);
                  }
                  $cashback += floatval($item)*(100-floatval($cashback_percent[$index])-floatval($odds_percent)-floatval($jackpot_percent))/100;
                  $upline_cashback += floatval($item)*(100-floatval($upline_cashback_percent[$index])-floatval($odds_percent)-floatval($jackpot_percent))/100;
              }
              $bet_all += $order['bet'];
              $jackpot_profit += floatval($order['bet'])*$jackpot_percent/100;
              $pay_award += $order['pay_award'];
              $profit += floatval($order['bet'])-($cashback+floatval($order['pay_award']));
              $upline_profit += floatval($order['bet'])-($upline_cashback+floatval($order['pay_award']));
          }
      }
  }
  if ($bet_all == 0) {
    $company_percent = 0;
  }
  else{
    $company_percent = $eat/$bet_all*100;
  }
  $surplus_percent = ($company_percent-(100-$value['bonus_percent']))/100;
  if ($bet_total == 0) {
    $sample_percent = 0;
  }
  else{
    $sample_percent = $bet_all/$bet_total;
  }
  $bonus = $profit_total*$sample_percent*$surplus_percent;
  $list[$key]['cashback'] = $cashback?$cashback:0;
  $list[$key]['cashback_only'] = $cashback_only?$cashback_only:0;
  $list[$key]['bonus'] = $bonus?$bonus:0;
  $list[$key]['sum_bet'] = $bet_all?$bet_all:0;
  $list[$key]['eat'] = $bet_all-$eat;
  $list[$key]['eat_surplus'] = $eat;
  $list[$key]['pay_award'] = $pay_award?$pay_award:0;
  $list[$key]['profit'] = ($bet_all-$pay_award-$cashback);
  $list[$key]['net'] = $list[$key]['profit'] - $list[$key]['bonus'];
  $list[$key]['upline_pay_award'] = $topic_pay_award?$topic_pay_award:0;
  $list[$key]['upline_cashback'] = $upline_cashback?$upline_cashback:0;
  $list[$key]['upline_bonus'] = $upline_bonus?$upline_bonus:0;
  $list[$key]['upline_profit'] = ($bet_all-$pay_award-$upline_cashback);
  $list[$key]['upline_net'] = $list[$key]['upline_profit'] - $list[$key]['upline_bonus'];
  $list[$key]['commission'] = $list[$key]['upline_cashback'] - $list[$key]['cashback'];
  $list[$key]['bonus_earn'] = $list[$key]['upline_pay_award'] - $list[$key]['pay_award'];
  $list[$key]['jackpot_profit'] = $jackpot_profit?$jackpot_profit:0;
  $list[$key]['user_type'] = 1;
  }

  $member = pdo_fetchall('select a.id,a.nickname,a.account,p.cashback_percent,p.bonus_percent,p.jackpot_percent,a.parent_agent,commission from '.tablename('member_system_member').' a left join '.tablename('agent_percent').' p on a.parent_agent=p.agent_id order by id asc ');
  foreach ($member as $ky => $val) {
      $cashback = 0;
      $bonus = 0;
      $profit = 0;
      $order = array();
      $upline_cashback = 0;
      $upline_bonus = 0;
      $upline_profit = 0;
      $jackpot_profit = 0;
      $cashback_only = 0;
      $pay_award = 0;
      $bet_all = 0;
      $jackpot_percent = $val['jackpot_percent']?$val['jackpot_percent']:0;
      $topic_award = pdo_fetchcolumn('select sum(winner_money) from '.tablename('manji_reward_log').' where member_id=:member_id and period_id in ('.$periods_id.')',array(':member_id'=>$val['id']));
      $order = pdo_fetch('select sum(order_amount) bet from '.tablename('manji_order').' where user_id = :user_id and period_id like \'%('.$periods_id.')%\'',array(':user_id'=>$val['id']));
      $order['pay_award'] = pdo_fetchcolumn('select sum(winner_money) from '.tablename('manji_reward_log').' where member_id=:member_id and period_id in ('.$periods_id.') and number_type<=6',array(':member_id'=>$val['id']));
      $bet_list = pdo_fetch('select sum(pay_B) as B,sum(pay_S) as S,sum(pay_A+pay_C2+pay_C3+pay_C4+pay_C5+pay_EC) as A,sum(pay_3ABC) as 3ABC,sum(pay_4A+pay_4B+pay_4C+pay_4D+pay_4E+pay_EA) as 4A,sum(pay_4ABC) as 4ABC,sum(pay_2A+pay_2B+pay_2C+pay_2D+pay_2E+pay_EX) as 2A,sum(pay_2ABC) as 2ABC from '.tablename('manji_order').' where user_id = :user_id and period_id like \'%('.$periods_id.')%\' and status=1',array(':user_id'=>$val['id']));
      $odds = pdo_fetch('select * from '.tablename('manji_member_odds').' where member_id=:member_id and cid=:cid',array(':member_id'=>$val['id'],':cid'=>$area_id));
      if (!empty($bet_list)) {
          $cashback_percent = gettotalCash($val['parent_agent']);
          $upline_cashback_percent = gettotalCash($val['parent_agent']);
          $commission = json_decode($val['commission'],true);
          foreach ($bet_list as $index => $item) {
              if ($index == 'B') {
                  $odd = explode('|',$odds['odds_'.$index]);
                  $odd_total = get_total_odds($odd);
                  $odds_percent = ($odd_total)/100;
              }
              if ($index == 'A') {
                  $odd = array($odds['odds_A'],$odds['odds_C2'],$odds['odds_C3'],$odds['odds_C4'],$odds['odds_C5'],$odds['odds_EC']);
                  $odd_total = get_max($odd);
                  $odds_percent = ($odd_total)/10;
              }
              if ($index == 'S') {
                  $odd = explode('|',$odds['odds_'.$index]);
                  $odd_total = get_total_odds($odd);
                  $odds_percent = ($odd_total)/100;
              }
              if ($index == '3ABC') {
                  $odd = explode('|',$odds['odds_'.$index]);
                  $odd_total = get_total_odds($odd);
                  $odds_percent = ($odd_total)/10;
              }
              if ($index == '4ABC') {
                  $odd = explode('|',$odds['odds_'.$index]);
                  $odd_total = get_total_odds($odd);
                  $odds_percent = ($odd_total)/100;
              }
              if ($index == '4A') {
                  $odd = array($odds['odds_4A'],$odds['odds_4B'],$odds['odds_4C'],$odds['odds_4D'],$odds['odds_4E'],$odds['odds_EA']);
                  $odd_total = get_max($odd);
                  $odds_percent = ($odd_total)/100;
              }
              if ($index == '2ABC') {
                  $odd = explode('|',$odds['odds_'.$index]);
                  $odd_total = get_total_odds($odd);
                  $odds_percent = ($odd_total);
              }
              if ($index == '2A') {
                  $odd = array($odds['odds_2A'],$odds['odds_2B'],$odds['odds_2C'],$odds['odds_2D'],$odds['odds_2E'],$odds['odds_EX']);
                  $odd_total = get_max($odd);
                  $odds_percent = ($odd_total);
              }
              if ($index == '5D') {
                $odd = explode('|', $odds['odds_'.$index]);
                $odds_percent = get_5d_odd($odd);
              }
              if ($index == '6D') {
                $odd = explode('|', $odds['odds_'.$index]);
                $odds_percent = get_6d_odd($odd);
              }
              $cashback += floatval($item)*(100-floatval($cashback_percent[$index])-floatval($odds_percent)-floatval($jackpot_percent)-floatval($commission[$index]))/100;
              $upline_cashback += floatval($item)*(100-floatval($cashback_percent[$index])-floatval($odds_percent)-floatval($jackpot_percent))/100;
              $cashback_only += floatval($item)*floatval($cashback_percent[$index])/100;
          }
          $bet_all = $order['bet'];
          $jackpot_profit = floatval($order['bet'])*$jackpot_percent/100;
          $pay_award = $order['pay_award'];
          $profit = floatval($order['bet'])-($cashback+floatval($order['pay_award']));
          if ($bet_total == 0) {
              $bet_per = 0;
          }
          else{
              $bet_per = floatval($order['bet'])/floatval($bet_total);
          }
          $upline_bonus = $bet_per*$profit_total*$val['bonus_percent']/100;
      }
      $member[$ky]['cashback'] = $cashback?$cashback:0;
      $member[$ky]['cashback_only'] = $cashback_only?$cashback_only:0;
      $member[$ky]['bonus'] = $bonus?$bonus:0;
      $member[$ky]['sum_bet'] = $bet_all?$bet_all:0;
      $member[$ky]['pay_award'] = $pay_award?$pay_award:0;
      $member[$ky]['profit'] = ($bet_all-$pay_award-$cashback);
      $member[$ky]['net'] = $member[$ky]['profit'] - $member[$ky]['bonus'];
      $member[$ky]['upline_pay_award'] = $topic_award?$topic_award:0;
      $member[$ky]['upline_cashback'] = $upline_cashback?$upline_cashback:0;
      $member[$ky]['upline_bonus'] = $upline_bonus?$upline_bonus:0;
      $member[$ky]['upline_profit'] = ($bet_all-$pay_award-$upline_cashback);
      $member[$ky]['upline_net'] = $member[$ky]['upline_profit'] - $member[$ky]['upline_bonus'];
      $member[$ky]['commission'] = $member[$ky]['upline_cashback'] - $member[$ky]['cashback'];
      $member[$ky]['bonus_earn'] = $member[$ky]['upline_pay_award'] - $member[$ky]['pay_award'];
      $member[$ky]['jackpot_profit'] = $jackpot_profit?$jackpot_profit:0;
      $member[$ky]['user_type'] = 2;
  }

  $list = array_merge($list,$member);

  foreach ($list as $option) {
      if ($option['sum_bet'] > 0) {
          if ($option['user_type'] == 1) {
              $save = array(
                  'cid' => $area_id,
                  'agent_id' => $option['id'],
                  'parent_agent' => $option['parent_agent'],
                  'sum_bet' => $option['sum_bet'],
                  'cashback' => $option['cashback'],
                  'pay_award' => $option['pay_award'],
                  'profit' => $option['profit'],
                  'bonus' => $option['bonus'],
                  'net' => $option['net'],
                  'upline_pay_award' => $option['upline_pay_award'],
                  'upline_cashback' => $option['upline_cashback'],
                  'upline_profit' => $option['upline_profit'],
                  'upline_bonus' => $option['upline_bonus'],
                  'upline_net' => $option['upline_net'],
                  'commission' => $option['commission'],
                  'bonus_earn' => $option['bonus_earn'],
                  'create_time' => time(),
                  'periods_id' => $periods_id
              );
              pdo_insert('manji_downline_report',$save);
          }
          else{
              $save = array(
                  'cid' => $area_id,
                  'member_id' => $option['id'],
                  'parent_agent' => $option['parent_agent'],
                  'sum_bet' => $option['sum_bet'],
                  'cashback' => $option['cashback'],
                  'pay_award' => $option['pay_award'],
                  'profit' => $option['profit'],
                  'bonus' => $option['bonus'],
                  'net' => $option['net'],
                  'upline_pay_award' => $option['upline_pay_award'],
                  'upline_cashback' => $option['upline_cashback'],
                  'upline_profit' => $option['upline_profit'],
                  'upline_bonus' => $option['upline_bonus'],
                  'upline_net' => $option['upline_net'],
                  'commission' => $option['commission'],
                  'bonus_earn' => $option['bonus_earn'],
                  'create_time' => time(),
                  'periods_id' => $periods_id
              );
              pdo_insert('manji_downline_report',$save);
          }
      }
  }
}

function getEat($agent,$period_id,$rule)
{
  $cid = pdo_fetchcolumn('select cid from '.tablename('manji_run_setting').' where id=:id',array(':id'=>$period_id));
  $eat = pdo_fetchcolumn('select eat from '.tablename('agent_eat').' where agent_id=:id',array(':id'=>$agent));
  $eat = json_decode($eat,true);
  $eat = $eat[$cid][$rule];
  $users = pdo_fetchColumnValue('select id from '.tablename('member_system_member').' where parent_agent=:id',array(':id'=>$agent),'id');
  $user = implode(',', $users);
  $child = pdo_fetchall('select id from '.tablename('agent_member').' where parent_agent=:agent',array(':agent'=>$agent));
  $bonus = pdo_fetchcolumn('select bonus_percent from '.tablename('agent_percent').' where agent_id=:id',array(':id'=>$agent));
  $order_amount = pdo_fetchcolumn('select sum(pay_'.$rule.') from '.tablename('manji_order').' where period_id like \'%('.$period_id.')%\' and user_id in ('.$user.')');
  $downSurplus = 0;
  if (!empty($child)) {
    foreach ($child as $key => $value) {
      $downSurplus += getEat($value['id'],$period_id,$rule);
    }
  }
  $eat_amount = ($order_amount+$downSurplus)*$bonus/100;
  $amount = ($order_amount+$downSurplus)-$eat_amount;
  if ($eat < $eat_amount) {
    $surplus = ($eat_amount - $eat)+$amount;
  }
  else{
    $surplus = $amount;
  }
  return $surplus;
}

function get_5d_odd($odd)
{
  $total_odds = 0;
  for ($i=0; $i < 6; $i++) { 
    if ($i == 3) {
      $total_odds = $total_odds+$odd[$i]*10*2;
    }
    elseif ($i == 4) {
      $total_odds = $total_odds+$odd[$i]*100*2;
    }
    elseif ($i == 5) {
      $total_odds = $total_odds+$odd[$i]*1000*2;
    }
    else{
      $total_odds = $total_odds+$odd[$i];
    }
  }
  $percent = (100000-$total_odds)/1000;
  return $percent;
}

function get_6d_odd($odd)
{
  $total_odds = 0;
  for ($i=0; $i < 5; $i++) { 
    if ($i == 1) {
      $total_odds = $total_odds+$odd[$i]*10*2;
    }
    elseif ($i == 2) {
      $total_odds = $total_odds+$odd[$i]*100*2;
    }
    elseif ($i == 3) {
      $total_odds = $total_odds+$odd[$i]*1000*2;
    }
    elseif ($i == 4) {
      $total_odds = $total_odds+$odd[$i]*10000*2;
    }
    else{
      $total_odds = $total_odds+$odd[$i];
    }
  }
  $percent = (1000000-$total_odds)/10000;
  return $percent;
}

function compare_sample_number($number,$company,$rule,$amount=0)
{
  $number_limit = pdo_fetchcolumn('select bet_limit from '.tablename('manji_red_number').' where number=:number and type=1 and cid=:cid',array(':number'=>$number,':cid'=>$_SESSION['cid']));
  if (!empty($number_limit)) {
    $limit = json_decode($number_limit,true);
    $company_limit = $limit[$company];
    $limit_amount = $company_limit[$rule];
    if (!empty($limit_amount)) {
      return min($amount,$limit_amount);
    }
  }
  return $amount;
}

function compare_system_number($number,$company,$rule,$amount=0,$extra=0)
{
  $number_limit = pdo_fetchcolumn('select bet_limit from '.tablename('manji_red_number').' where number=:number and type=2 and cid=:cid',array(':number'=>$number,':cid'=>$_SESSION['cid']));
  $period = pdo_fetch('select id from '.tablename('manji_run_setting').' where stoptime>:time and aid=:aid order by endtime asc limit 0,1',array(':time'=>time(),':aid'=>$_SESSION['cid']));
  $period = $period['id'];
  if (!empty($number_limit)) {
    $order_amount = pdo_fetchcolumn('select sum(pay_'.$rule.') from '.tablename('manji_order').' where number=:number and period_id like \'%('.$period.')%\' and status=1',array(':number'=>$number));
    $limit = json_decode($number_limit,true);
    $company_limit = $limit[$company];
    $limit_amount = $company_limit[$rule];
    if (!empty($limit_amount)) {
      $remain = $limit_amount - $order_amount - $extra;
      if ($remain > 0) {
        return min($amount,$remain);
      }
      else{
        return 0;
      }
    }
  }
  return $amount;
}

function compare_user($user,$company,$rule,$amount=0,$extra=0)
{
  $user_limit = pdo_fetchcolumn('select bet_limit from '.tablename('member_system_member').' where id=:id',array(':id'=>$user));
  if ($user_limit > 0) {
    $number_limit = pdo_fetchcolumn('select `limit` from '.tablename('manji_limit').' where id=:id',array(':id'=>$user_limit));
    $period = pdo_fetch('select id from '.tablename('manji_run_setting').' where stoptime>:time order by endtime asc limit 0,1',array(':time'=>time()));
    $period = $period['id'];
    $order_amount = pdo_fetchcolumn('select sum(pay_'.$rule.') from '.tablename('manji_order').' where user_id=:user and period_id like \'%('.$period.')%\' and status=1',array(':user'=>$user));
    $limit = json_decode($number_limit,true);
    $company_limit = $limit[$company];
    $limit_amount = $company_limit[$rule];
    if (!empty($limit_amount)) {
      $remain = $limit_amount - $order_amount - $extra;
      if ($remain > 0) {
        return min($amount,$remain);
      }
      else{
        return 0;
      }
    }
  }
  return $amount;
}

function compare_agent($agent,$company,$rule,$amount=0,$extra=0)
{
  $user_limit = pdo_fetchcolumn('select child_limit from '.tablename('agent_member').' where id=:id',array(':id'=>$agent));
  if ($user_limit > 0) {
    $number_limit = pdo_fetchcolumn('select `limit` from '.tablename('manji_limit').' where id=:id',array(':id'=>$user_limit));
    $period = pdo_fetch('select id from '.tablename('manji_run_setting').' where stoptime>:time order by endtime asc limit 0,1',array(':time'=>time()));
    $period = $period['id'];
    $users = pdo_fetchColumnValue('select id from '.tablename('member_system_member').' where parent_agent=:agent',array(':agent'=>$agent),'id');
    $user = implode(',', $users);
    $order_amount = pdo_fetchcolumn('select sum(pay_'.$rule.') from '.tablename('manji_order').' where user_id in ('.$user.') and period_id like \'%('.$period.')%\' and status=1');
    $limit = json_decode($number_limit,true);
    $company_limit = $limit[$company];
    $limit_amount = $company_limit[$rule];
    if (!empty($limit_amount)) {
      $remain = $limit_amount - $order_amount - $extra;
      if ($remain > 0) {
        return min($amount,$remain);
      }
      else{
        return 0;
      }
    }
  }
  return $amount;
}

function compare_system($rule,$company,$amount=0,$extra=0)
{
  $time_limit = pdo_fetch('select `limit` from '.tablename('manji_limit_time').' where time>:time order by time desc limit 0,1',array(':time'=>strtotime('1970-1-1 '.date('H:i',time()))));
  if ($time_limit > 0) {
    $number_limit = pdo_fetchcolumn('select `limit` from '.tablename('manji_limit').' where id=:id',array(':id'=>$time_limit['limit']));
    $period = pdo_fetch('select id from '.tablename('manji_run_setting').' where stoptime>:time order by endtime asc limit 0,1',array(':time'=>time()));
    $period = $period['id'];
    $order_amount = pdo_fetchcolumn('select sum(pay_'.$rule.') from '.tablename('manji_order').' where period_id like \'%('.$period.')%\' and status=1');
    $limit = json_decode($number_limit,true);
    $company_limit = $limit[$company];
    $limit_amount = $company_limit[$rule];
    if (!empty($limit_amount)) {
      $remain = $limit_amount - $order_amount - $extra;
      if ($remain > 0) {
        return min($amount,$remain);
      }
      else{
        return 0;
      }
    }
  }
  return $amount;
}

function random_number()
{
  $ychar="1,2,3,4,5,6,7,8,9,0";
  $list=explode(",",$ychar);
  for($i=0;$i<4;$i++){
    $randnum=rand(0,9); // 10+26;
    $param.=$list[$randnum];
  }

  return $param;
}

function number_eat($company,$number,$money,$agent,$rule,$minus=0,$date,$member_id)
{
  $member = pdo_fetch('select * from '.tablename('agent_member').' where id=:id',array(':id'=>$agent));
  $odds = pdo_fetch('select odds_B,odds_S,odds_4A,odds_4ABC,odds_A,odds_3ABC from '.tablename('manji_member_odds').' where cid=:cid and member_id=:member',array(':cid'=>$member['cid'],':member'=>$member_id));
  if (empty($member)) {
    return false;
  }
  if ($member['level'] == 5) {
    //代理吃字
    $parent = pdo_fetch('select * from '.tablename('agent_member').' where id=:id',array(':id'=>$member['parent_agent']));
    $eat_rule = pdo_fetchcolumn('select eat from '.tablename('agent_eat').' where agent_id=:agent',array(':agent'=>$agent));
    $percent = pdo_fetchcolumn('select bonus_percent from '.tablename('agent_percent').' where agent_id=:agent',array(':agent'=>$agent));
    $eat_rule = json_decode($eat_rule,true);
    $eat_limit = $eat_rule[$company][$rule];
    $eated = pdo_fetch('select * from '.tablename('agent_earn').' where company_id=:company and number=:number and agent_id=:agent and date=:date',array(':company'=>$company,':number'=>$number,':agent'=>$agent,':date'=>$date));
    $eat_now = ($money*$percent)/100-$minus;
    $real_eat = $eat_limit-($eat_now+$eated['pay_'.$rule]);
    if ($real_eat >= 0) {
      $save['pay_'.$rule] = $eat_now+$eated['pay_'.$rule];
      $minused = $minus+$eat_now;
    }
    elseif ($eat_limit > $eated['pay_'.$rule]) {
      $limit_eat = $eat_limit-$eated['pay_'.$rule];
      $save['pay_'.$rule] = $limit_eat+$eated['pay_'.$rule];
      $minused = $minus+$limit_eat;
    }
    else{
      $save['pay_'.$rule] = $eated['pay_'.$rule];
      $minused = $minus;
    }
    if (!empty($eated)) {
      pdo_update('agent_earn',$save,array('company_id'=>$company,'number'=>$number,'agent_id'=>$agent,'date'=>$date));
    }
    else{
      $save['company_id'] = $company;
      $save['number'] = $number;
      $save['agent_id'] = $agent;
      $save['date'] = $date;
      pdo_insert('agent_earn',$save);
    }
  }
  else{
    //管理员吃字
    foreach ($odds as $key => $value) {
      if ($key == 'odds_B' || $key == 'odds_S' || $key == 'odds_4ABC' || $key == 'odds_3ABC') {
        $odds[$key] = explode('|', $value);
      }
      else{
        $odds[$key] = $value;
      }
    }
    $manager_eat = pdo_fetch('select * from '.tablename('agent_manager_eat').' where agent_id=:id',array(':id'=>$agent));
    $parent = pdo_fetch('select * from '.tablename('agent_member').' where cid=:cid and level=:level',array(':cid'=>$member['cid'],':level'=>$member['level']-1));
    $rule_type = 0;
    if ($rule == 'B' || $rule == 'S' || $rule == '4A' || $rule == '4ABC') {
      $rule_type = 1;
      $eat_rule = json_decode($manager_eat['mating_4D'],true);
      $mode = $manager_eat['type_4d'];
      $ordby_count = 3;
      $eated = pdo_fetch('select pay_B as B,pay_S as S,pay_4A as 4A,pay_4ABC as 4ABC from '.tablename('agent_earn').' where agent_id=:agent and number=:number and date=:date and company_id=:company',array(':number'=>$number,':agent'=>$agent,':date'=>$date,':company'=>$company));
      $ordby = explode(',', $manager_eat['ordby_4d']);
    }
    if ($rule == 'A' || $rule == '3ABC') {
      $eat_rule = json_decode($manager_eat['mating_3D'],true);
      $mode = $manager_eat['type_3d'];
      $rule_type = 1;
      $ordby_count = 1;
      $eated = pdo_fetch('select pay_A as A,pay_3ABC as 3ABC from '.tablename('agent_earn').' where agent_id=:agent and number=:number and date=:date and company_id=:company',array(':number'=>$number,':agent'=>$agent,':date'=>$date,':company'=>$company));
      $ordby = explode(',', $manager_eat['ordby_3d']);
    }
    if (!empty($ordby)) {
      foreach ($ordby as $key => $value) {
        if ($value == 'S' || $value == 'B' || $value == '4ABC' || $value == '3ABC') {
          $odds['odds_'.$value] = $odds['odds_'.$value][0];
        }
        if ($value == $rule) {
          $k = $key;
        }
      }
    }
    if ($member['level'] == 4) {
      $eat_now = ($money*$manager_eat['percent'])/100-$minus;
    }
    else{
      $eat_now = ($money-$minus)*$manager_eat['percent']/100;
    }
    if ($mode == 2 && $rule_type == 1) {
      if ($manager_eat['is_filter'] == 1 || $member['level'] < 4) {
        $mutiple = 0;
        if (!empty($eated)) {
          foreach ($eated as $ky => $v) {
            $mutiple += $v*$odds['odds_'.$ky];
          }
        }
        $eat_mutiple = $eat_now*$odds['odds_'.$rule];
        $surplus = $eat_rule[$company]['mutiple']-$mutiple-$eat_mutiple;
        if ($surplus >= 0) {
          $save['pay_'.$rule] = $eated[$rule]+$eat_now;
          $minused = $minus+$eat_now;
        }
        else{
          $surplus = 0-$surplus;
          for ($i=$ordby_count; $i > $k; $i--) {
            if ($surplus > 0) {
              $money1 = $surplus - $eated[$ordby[$i]]*$odds['odds_'.$ordby[$i]];
              if ($money1 == 0) {
                $save['pay_'.$ordby[$i]] = 0;
                $surplus = 0;
                number_eat($company,$number,$eated[$ordby[$i]],$parent['id'],$ordby[$i],0,$date,$member_id);
              }
              elseif ($money1 < 0) {
                $save['pay_'.$ordby[$i]] = ($eated[$ordby[$i]]*$odds['odds_'.$ordby[$i]]-$money1)/$odds['pay_'.$ordby[$i]];
                $surplus = 0;
                number_eat($company,$number,$eated[$ordby[$i]],$parent['id'],$ordby[$i],0,$date,$member_id);
              }
              else{
                $save['pay_'.$ordby[$i]] = 0;
                $surplus = $money1;
                number_eat($company,$number,$eated[$ordby[$i]],$parent['id'],$ordby[$i],0,$date,$member_id);
              }
            }
          }
          $save['pay_'.$rule] = $eated[$rule]+$eat_now-($surplus/$odds['odds_'.$rule]);
          if ($surplus >0) {
            $minused = $minus+$eat_now-$surplus/$odds['odds_'.$rule];
          }
          else{
            $minused = $minus+$eat_now;
          }
        }
      }
      else{
        $surplus = $eat_rule[$company]['mutiple']-$mutiple-$eat_mutiple;
        if ($surplus >= 0) {
          $save['pay_'.$rule] = $eated[$rule]+$eat_now;
          $minused = $minus+$eat_now;
        }
        else{
          $save['pay_'.$rule] = $eated[$rule]+$eat_now-($surplus/$odds['odds_'.$rule]);
          $minused = $minus+$eat_now-$surplus/$odds['odds_'.$rule];
        }
      }
      if (!empty($eated)) {
        pdo_update('agent_earn',$save,array('company_id'=>$company,'number'=>$number,'agent_id'=>$agent,'date'=>$date));
      }
      else{
        $bet_limit = $eat_rule[$company]['mutiple']/$odds['odds_'.$rule];
        if ($bet_limit > $eat_now) {
          $real_eat = $eat_now;
          $minused = $minus+$eat_now;
        }
        else{
          $real_eat = $bet_limit;
          $minused = $minus+$bet_limit;
        }
        $save = array(
          'company_id' => $company,
          'number' => $number,
          'agent_id' => $agent,
          'date' => $date,
          'pay_'.$rule => $real_eat
        );
        pdo_insert('agent_earn',$save);
      }
    }
    else{
      $rule_4d = array('B','S','4A','4B','4C','4D','4E','EA','4ABC');
      if (in_array($rule,$rule_4d)) {
        $eat_rule = json_decode($manager_eat['mating_4D'],true);
      }
      else{
        $eat_rule = json_decode($manager_eat['mating_3D'],true);
      }
      $eat_limit = $eat_rule[$company][$rule];
      $eated = pdo_fetch('select * from '.tablename('agent_earn').' where company_id=:company and number=:number and agent_id=:agent and date=:date',array(':company'=>$company,':number'=>$number,':agent'=>$agent,':date'=>$date));
      if ($member['level'] == 4) {
        $eat_now = ($money*$manager_eat['percent'])/100-$minus;
      }
      else{
        $eat_now = ($money-$minus)*$manager_eat['percent']/100;
      }
      $real_eat = $eat_limit-($eat_now+$eated['pay_'.$rule]);
      if ($real_eat >= 0) {
        $save['pay_'.$rule] = $eat_now+$eated['pay_'.$rule];
        $minused = $minus+$eat_now;
      }
      elseif ($eat_limit > $eated['pay_'.$rule]) {
        $limit_eat = $eat_limit-$eated['pay_'.$rule];
        $save['pay_'.$rule] = $limit_eat+$eated['pay_'.$rule];
        $minused = $minus+$limit_eat;
      }
      else{
        $save['pay_'.$rule] = $eated['pay_'.$rule];
        $minused = $minus;
      }
      if (!empty($eated)) {
        pdo_update('agent_earn',$save,array('company_id'=>$company,'number'=>$number,'agent_id'=>$agent,'date'=>$date));
      }
      else{
        $save['company_id'] = $company;
        $save['number'] = $number;
        $save['agent_id'] = $agent;
        $save['date'] = $date;
        pdo_insert('agent_earn',$save);
      }
    }
  }
  if ($member['level'] == 2) {
    $surplus1 = $money-$minused;
    if ($surplus1 > 0) {
      $old = pdo_fetch('select * from '.tablename('agent_unpost').' where number=:number and date=:date and area_id=:area_id and company_id=:company',array(':date'=>$date,':area_id'=>$member['cid'],':number'=>$number,':company'=>$company));
      if (!empty($old)) {
        pdo_update('agent_unpost',array('pay_'.$rule=>$old['pay_'.$rule]+$surplus1),array('id'=>$old['id']));
      }
      else{
        $unpost = array(
          'area_id' => $member['cid'],
          'company_id' => $company,
          'number' => $number,
          'pay_'.$rule => $surplus1,
          'date' => $date
        );
        pdo_insert('agent_unpost',$unpost);
      }
    }
  }
  else{
    number_eat($company,$number,$money,$parent['id'],$rule,$minused,$date,$member_id);
  }
}

function getDateRound($start,$end)
{
  $stime = strtotime($start);
  $etime = strtotime($end);
  $range = ($etime-$stime)/24/3600;
  $time_str = explode('-', $start);
  $date_range = array();
  for ($i=0; $i <= $range; $i++) { 
    $day = $time_str[2]+$i;
    if ($day < 10) {
      $day = '0'.$day;
    }
    $date_range[] = "'".$time_str[0].'-'.$time_str[1].'-'.$day."'";
  }

  return $date_range;

}