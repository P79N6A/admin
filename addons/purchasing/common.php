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
    $saved_token = pdo_fetchcolumn("select token from ".tablename('agent_member')." where id=:id",array(':id'=>$user_id));
    if ($saved_token != $token) {
        $check_login = 2;
    }else{
        //   memcache_write( 'user-'.$user_id,$token );
    }
    return $check_login;
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
 * 检验账号格式
 * @param $account
 * @return bool
 */
function check_account($account){
    if(!preg_match('/[a-zA-Z0-9]{1,12}/',$account)){
        return false;
    }
    return true;
}

function getParent($id)
{
    $list = array();
    $parent = pdo_fetchcolumn('select parent_agent from '.tablename('agent_member').' where id=:id and level>4',array(':id'=>$id));
    if (!empty($parent)) {
        $list[] = $parent;
        $next = getParent($parent);
        $list = array_merge($list,$next);
    }
    return $list;
}

/**
 * 代理账号是否存在
 * @param $account
 * @return bool
 */
function has_agent_account($account){
    $has = pdo_fetch('select id from '.tablename('agent_member').' where account=:account',array(':account'=>$account));
    if($has){
        return true;
    }
    $has1 = pdo_fetch('select id from '.tablename('member_system_member').' where account=:account',array(':account'=>$account));
    if ($has1) {
      return true;
    }
    return  false;
}

/**
 * 会员账号是否存在
 * @param $account
 * @return bool
 */
function has_member_account($account){
    $has = pdo_fetch('select id from '.tablename('member_system_member').' where account=:account',array(':account'=>$account));
    if($has){
        return true;
    }
    $has1 = pdo_fetch('select id from '.tablename('agent_member').' where account=:account',array(':account'=>$account));
    if($has1){
        return true;
    }
    return  false;
}

/**
 * 赔率值检查
 * @param $oddsStr
 * @param string $glue
 * @return bool
 */
function check_set_odds($oddsStr,$glue = '|'){
    if(is_string($oddsStr)){
        $oddsStr = explode($glue,$oddsStr);
    }
    foreach ($oddsStr as $odd){
        if($odd<=0){
            return false;
        }
    }
    return true;
}

/**
 * $odds2 每个子元素不能大于上线赔率
 * @param $odds1  上线
 * @param $odds2  下线
 * @param string $glue
 * @return bool
 */
function compare_odds($odds1,$odds2,$glue = '|'){
    if(is_string($odds1)){
        $odds1 = explode($glue,$odds1);
    }
    if(is_string($odds2)){
        $odds2 = explode($glue,$odds2);
    }
    foreach ($odds2 as $k => $v){
         if($v>$odds1[$k]){
             return false;
         }
    }
    return true;
}

function get_cashback($odds,$cashback,$jackpot)
{
    if ($odds >= 1000) {
        $cashback_money = 10000-($cashback*100)-($jackpot*100)-$odds;
    }
    if ($odds >= 100 && $odds < 1000) {
        $cashback_money = 1000-($cashback*10)-($jackpot*10)-$odds;
    }
    if ($odds < 100) {
        $cashback_money = 1000-$cashback-$jackpot-$odds;
    }

    return $cashback_money/100;
}

/**
 * 获取所有下线
 */
function getAllChild($user_id)
{
    $child = array();

    $list = pdo_fetchall('select id from '.tablename('agent_member').' where parent_agent=:agent',array(':agent'=>$user_id));
    if (!empty($list)) {
        foreach ($list as $key => $value) {
            if ($value['id'] > 0) {
                $child_list = getAllChild($value['id']);
                $child = array_merge($child,$child_list);
            }
        }
        $child = array_merge($child,$list);
    }

    return $child;
}

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
    //print_r($save);
    pdo_insert('manji_reward_log', $save);

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

//先对4B做运算
function cal_4A($period_id, $period_number, $winning_num, $winner_number_type,$number_type ){
  //获取本期所有订单
  $order = cache_load('order');
  //获取所有会员
  $member = cache_load('member');
  $winner_order = array();
  if (!empty($order)) {
    foreach ($order as $ord) {
      if ($winning_num == $ord['number'] && $ord['pay_4A'] > 0) {
        $winner_order[] = array(
          'id' => $ord['order_id'],
          'user_id' => $ord['user_id'],
          'pay_4A' => $ord['pay_4A'],
          'createtime' => $ord['createtime'],
          'cid' => $ord['cid'],
          'number' => $ord['number'],
          'bet_number' => $ord['bet_number']
        );
      }
    }
  }

  if (!empty($member)) {
    foreach ($member as $mem) {
      $members[$mem['member_id']] = $mem;
    }
  }
  
  if (!empty($members) && !empty($winner_order)) {
    $total_winner_money = 0;
    foreach ($winner_order as $win) {
      if (empty($members[$win['user_id']])) {
        continue;
      }
      $winner_money = $win['pay_4A'] * $members[$win['user_id']]['odds_4A'];
      $total_winner_money+= $winner_money;

      //保存个人记录
      $member_new_money = ((int)($members[$win['user_id']]['credit1']*100+$winner_money *100))/100;
      $reward_log[] = array(
        'period_id' => $period_id,
        'member_id' => $win['user_id'],
        'member_nikename' => $members[$win['user_id']]['nickname'],
        'member_old_money' => $members[$win['user_id']]['credit1'],
        'member_new_money' => $member_new_money,
        'bet_number' => $win['bet_number'],
        'bet_money' => $win['pay_4A'],
        'winner_number_type' => $winner_number_type,
        'winner_money' => $winner_money,
        'winner_odds' => $members[$win['user_id']]['odds_4A'],
        'winner_number' => $winning_num,
        'winner_type' => '4A',
        'agent_name' => $members[$win['user_id']]['nickname'],
        'number_type' => $number_type,
        'create_time' => time(),
        'order_id' => $win['id'],
        'order_time' => $win['createtime']
      );
      $winner_log[] = array(
        'type' => 1,
        'user_id' => $win['user_id'],
        'lottery_number' => $winning_num,
        'period_id' => $period_id
      );
      $update_member[] = array(
        'user_id' => $win['user_id'],
        'win_money' => $winner_money
      );
    }
  }
  

  $result = array(
    'reward_log' => $reward_log,
    'winner_log' => $winner_log,
    'update_member' => $update_member,
    'total_winner_money' => $total_winner_money
  );

  return $result;
}

function cal_4B($period_id, $period_number, $winning_num, $winner_number_type,$number_type ){
  //获取本期所有订单
  $order = cache_load('order');
  //获取所有会员
  $member = cache_load('member');
  $winner_order = array();
  if (!empty($order)) {
    foreach ($order as $ord) {
      if ($winning_num == $ord['number'] && $ord['pay_4B'] > 0) {
        $winner_order[] = array(
          'id' => $ord['order_id'],
          'user_id' => $ord['user_id'],
          'pay_4B' => $ord['pay_4B'],
          'createtime' => $ord['createtime'],
          'cid' => $ord['cid'],
          'number' => $ord['number'],
          'bet_number' => $ord['bet_number']
        );
      }
    }
  }

  if (!empty($member)) {
    foreach ($member as $mem) {
      $members[$mem['member_id']] = $mem;
    }
  }
  
  if (!empty($members) && !empty($winner_order)) {
    $total_winner_money = 0;
    foreach ($winner_order as $win) {
      if (empty($members[$win['user_id']])) {
        continue;
      }
      $winner_money = $win['pay_4B'] * $members[$win['user_id']]['odds_4B'];
      $total_winner_money+= $winner_money;

      //保存个人记录
      $member_new_money = ((int)($members[$win['user_id']]['credit1']*100+$winner_money *100))/100;
      $reward_log[] = array(
        'period_id' => $period_id,
        'member_id' => $win['user_id'],
        'member_nikename' => $members[$win['user_id']]['nickname'],
        'member_old_money' => $members[$win['user_id']]['credit1'],
        'member_new_money' => $member_new_money,
        'bet_number' => $win['bet_number'],
        'bet_money' => $win['pay_4B'],
        'winner_number_type' => $winner_number_type,
        'winner_money' => $winner_money,
        'winner_odds' => $members[$win['user_id']]['odds_4B'],
        'winner_number' => $winning_num,
        'winner_type' => '4B',
        'agent_name' => $members[$win['user_id']]['nickname'],
        'number_type' => $number_type,
        'create_time' => time(),
        'order_id' => $win['id'],
        'order_time' => $win['createtime']
      );
      $winner_log[] = array(
        'type' => 1,
        'user_id' => $win['user_id'],
        'lottery_number' => $winning_num,
        'period_id' => $period_id
      );
      $update_member[] = array(
        'user_id' => $win['user_id'],
        'win_money' => $winner_money
      );
    }
  }
  $result = array(
    'reward_log' => $reward_log,
    'winner_log' => $winner_log,
    'update_member' => $update_member,
    'total_winner_money' => $total_winner_money
  );

  return $result;
}

function cal_4C($period_id, $period_number, $winning_num, $winner_number_type,$number_type ){
  //获取本期所有订单
  $order = cache_load('order');
  //获取所有会员
  $member = cache_load('member');
  $winner_order = array();
  if (!empty($order)) {
    foreach ($order as $ord) {
      if ($winning_num == $ord['number'] && $ord['pay_4C'] > 0) {
        $winner_order[] = array(
          'id' => $ord['order_id'],
          'user_id' => $ord['user_id'],
          'pay_4C' => $ord['pay_4C'],
          'createtime' => $ord['createtime'],
          'cid' => $ord['cid'],
          'number' => $ord['number'],
          'bet_number' => $ord['bet_number']
        );
      }
    }
  }

  if (!empty($member)) {
    foreach ($member as $mem) {
      $members[$mem['member_id']] = $mem;
    }
  }
  
  if (!empty($members) && !empty($winner_order)) {
    $total_winner_money = 0;
    foreach ($winner_order as $win) {
      if (empty($members[$win['user_id']])) {
        continue;
      }
      $winner_money = $win['pay_4C'] * $members[$win['user_id']]['odds_4C'];
      $total_winner_money+= $winner_money;

      //保存个人记录
      $member_new_money = ((int)($members[$win['user_id']]['credit1']*100+$winner_money *100))/100;
      $reward_log[] = array(
        'period_id' => $period_id,
        'member_id' => $win['user_id'],
        'member_nikename' => $members[$win['user_id']]['nickname'],
        'member_old_money' => $members[$win['user_id']]['credit1'],
        'member_new_money' => $member_new_money,
        'bet_number' => $win['bet_number'],
        'bet_money' => $win['pay_4C'],
        'winner_number_type' => $winner_number_type,
        'winner_money' => $winner_money,
        'winner_odds' => $members[$win['user_id']]['odds_4C'],
        'winner_number' => $winning_num,
        'winner_type' => '4C',
        'agent_name' => $members[$win['user_id']]['nickname'],
        'number_type' => $number_type,
        'create_time' => time(),
        'order_id' => $win['id'],
        'order_time' => $win['createtime']
      );
      $winner_log[] = array(
        'type' => 1,
        'user_id' => $win['user_id'],
        'lottery_number' => $winning_num,
        'period_id' => $period_id
      );
      $update_member[] = array(
        'user_id' => $win['user_id'],
        'win_money' => $winner_money
      );
    }
  }
  

  $result = array(
    'reward_log' => $reward_log,
    'winner_log' => $winner_log,
    'update_member' => $update_member,
    'total_winner_money' => $total_winner_money
  );

  return $result;
}

function cal_4D($period_id, $period_number, $winning_num, $winner_number_type,$number_type ){
  //获取本期所有订单
  $order = cache_load('order');
  //获取所有会员
  $member = cache_load('member');
  $winner_order = array();
  if (!empty($order)) {
    foreach ($order as $ord) {
      if ($winning_num == $ord['number'] && $ord['pay_4D'] > 0) {
        $winner_order[] = array(
          'id' => $ord['order_id'],
          'user_id' => $ord['user_id'],
          'pay_4D' => $ord['pay_4D'],
          'createtime' => $ord['createtime'],
          'cid' => $ord['cid'],
          'number' => $ord['number'],
          'bet_number' => $ord['bet_number']
        );
      }
    }
  }

  if (!empty($member)) {
    foreach ($member as $mem) {
      $members[$mem['member_id']] = $mem;
    }
  }
  
  if (!empty($members) && !empty($winner_order)) {
    $total_winner_money = 0;
    foreach ($winner_order as $win) {
      if (empty($members[$win['user_id']])) {
        continue;
      }
      $winner_money = $win['pay_4D'] * $members[$win['user_id']]['odds_4D'];
      $total_winner_money+= $winner_money;

      //保存个人记录
      $member_new_money = ((int)($members[$win['user_id']]['credit1']*100+$winner_money *100))/100;
      $reward_log[] = array(
        'period_id' => $period_id,
        'member_id' => $win['user_id'],
        'member_nikename' => $members[$win['user_id']]['nickname'],
        'member_old_money' => $members[$win['user_id']]['credit1'],
        'member_new_money' => $member_new_money,
        'bet_number' => $win['bet_number'],
        'bet_money' => $win['pay_4D'],
        'winner_number_type' => $winner_number_type,
        'winner_money' => $winner_money,
        'winner_odds' => $members[$win['user_id']]['odds_4D'],
        'winner_number' => $winning_num,
        'winner_type' => '4D',
        'agent_name' => $members[$win['user_id']]['nickname'],
        'number_type' => $number_type,
        'create_time' => time(),
        'order_id' => $win['id'],
        'order_time' => $win['createtime']
      );
      $winner_log[] = array(
        'type' => 1,
        'user_id' => $win['user_id'],
        'lottery_number' => $winning_num,
        'period_id' => $period_id
      );
      $update_member[] = array(
        'user_id' => $win['user_id'],
        'win_money' => $winner_money
      );
    }
  }
  

  $result = array(
    'reward_log' => $reward_log,
    'winner_log' => $winner_log,
    'update_member' => $update_member,
    'total_winner_money' => $total_winner_money
  );

  return $result;
}

function cal_4E($period_id, $period_number, $winning_num, $winner_number_type,$number_type ){
   //获取本期所有订单
  $order = cache_load('order');
  //获取所有会员
  $member = cache_load('member');
  $winner_order = array();
  if (!empty($order)) {
    foreach ($order as $ord) {
      if ($winning_num == $ord['number'] && $ord['pay_4E'] > 0) {
        $winner_order[] = array(
          'id' => $ord['order_id'],
          'user_id' => $ord['user_id'],
          'pay_4E' => $ord['pay_4E'],
          'createtime' => $ord['createtime'],
          'cid' => $ord['cid'],
          'number' => $ord['number'],
          'bet_number' => $ord['bet_number']
        );
      }
    }
  }

  if (!empty($member)) {
    foreach ($member as $mem) {
      $members[$mem['member_id']] = $mem;
    }
  }
  
  if (!empty($members) && !empty($winner_order)) {
    $total_winner_money = 0;
    foreach ($winner_order as $win) {
      if (empty($members[$win['user_id']])) {
        continue;
      }
      $winner_money = $win['pay_4E'] * $members[$win['user_id']]['odds_4E'];
      $total_winner_money+= $winner_money;

      //保存个人记录
      $member_new_money = ((int)($members[$win['user_id']]['credit1']*100+$winner_money *100))/100;
      $reward_log[] = array(
        'period_id' => $period_id,
        'member_id' => $win['user_id'],
        'member_nikename' => $members[$win['user_id']]['nickname'],
        'member_old_money' => $members[$win['user_id']]['credit1'],
        'member_new_money' => $member_new_money,
        'bet_number' => $win['bet_number'],
        'bet_money' => $win['pay_4E'],
        'winner_number_type' => $winner_number_type,
        'winner_money' => $winner_money,
        'winner_odds' => $members[$win['user_id']]['odds_4E'],
        'winner_number' => $winning_num,
        'winner_type' => '4E',
        'agent_name' => $members[$win['user_id']]['nickname'],
        'number_type' => $number_type,
        'create_time' => time(),
        'order_id' => $win['id'],
        'order_time' => $win['createtime']
      );
      $winner_log[] = array(
        'type' => 1,
        'user_id' => $win['user_id'],
        'lottery_number' => $winning_num,
        'period_id' => $period_id
      );
      $update_member[] = array(
        'user_id' => $win['user_id'],
        'win_money' => $winner_money
      );
    }
  }
  

  $result = array(
    'reward_log' => $reward_log,
    'winner_log' => $winner_log,
    'update_member' => $update_member,
    'total_winner_money' => $total_winner_money
  );

  return $result;
}

function cal_4ABC($period_id, $period_number, $winning_num, $winner_number_type,$number_type ){
   //获取本期所有订单
  $order = cache_load('order');
  //获取所有会员
  $member = cache_load('member');
  $winner_order = array();
  if (!empty($order)) {
    foreach ($order as $ord) {
      if ($winning_num == $ord['number'] && $ord['pay_4ABC'] > 0) {
        $winner_order[] = array(
          'id' => $ord['order_id'],
          'user_id' => $ord['user_id'],
          'pay_4ABC' => $ord['pay_4ABC'],
          'createtime' => $ord['createtime'],
          'cid' => $ord['cid'],
          'number' => $ord['number'],
          'bet_number' => $ord['bet_number']
        );
      }
    }
  }

  if (!empty($member)) {
    foreach ($member as $mem) {
      $members[$mem['member_id']] = $mem;
    }
  }
  
  if (!empty($members) && !empty($winner_order)) {
    $total_winner_money = 0;
    foreach ($winner_order as $win) {
      if (empty($members[$win['user_id']])) {
        continue;
      }
      $odds = explode('|', $members[$win['user_id']]['odds_4ABC']);
      switch ($number_type) {
        case 1:
          $odd =  $odds[0];
          break;
        case 2:
          $odd =  $odds[1];
          break;
        case 3:
          $odd =  $odds[2];
          break;
      }
      $winner_money = $win['pay_4ABC'] * $odd;
      $total_winner_money+= $winner_money;

      //保存个人记录
      $member_new_money = ((int)($members[$win['user_id']]['credit1']*100+$winner_money *100))/100;
      $reward_log[] = array(
        'period_id' => $period_id,
        'member_id' => $win['user_id'],
        'member_nikename' => $members[$win['user_id']]['nickname'],
        'member_old_money' => $members[$win['user_id']]['credit1'],
        'member_new_money' => $member_new_money,
        'bet_number' => $win['bet_number'],
        'bet_money' => $win['pay_4ABC'],
        'winner_number_type' => $winner_number_type,
        'winner_money' => $winner_money,
        'winner_odds' => $odd,
        'winner_number' => $winning_num,
        'winner_type' => '4ABC',
        'agent_name' => $members[$win['user_id']]['nickname'],
        'number_type' => $number_type,
        'create_time' => time(),
        'order_id' => $win['id'],
        'order_time' => $win['createtime']
      );
      $winner_log[] = array(
        'type' => 1,
        'user_id' => $win['user_id'],
        'lottery_number' => $winning_num,
        'period_id' => $period_id
      );
      $update_member[] = array(
        'user_id' => $win['user_id'],
        'win_money' => $winner_money
      );
    }
  }
  

  $result = array(
    'reward_log' => $reward_log,
    'winner_log' => $winner_log,
    'update_member' => $update_member,
    'total_winner_money' => $total_winner_money
  );

  return $result;
}

function cal_B($period_id, $period_number, $winning_num, $winner_number_type,$number_type ){
   //获取本期所有订单
  $order = cache_load('order');

  //获取所有会员
  $member = cache_load('member');
  
  $winner_order = array();
  if (!empty($order)) {
    foreach ($order as $ord) {
      if ($winning_num == $ord['number'] && $ord['pay_B'] > 0) {
        $winner_order[] = array(
          'id' => $ord['order_id'],
          'user_id' => $ord['user_id'],
          'pay_B' => $ord['pay_B'],
          'createtime' => $ord['createtime'],
          'cid' => $ord['cid'],
          'number' => $ord['number'],
          'bet_number' => $ord['bet_number']
        );
      }
    }
  }

  if (!empty($member)) {
    foreach ($member as $mem) {
      $members[$mem['member_id']] = $mem;
    }
  }

  // if ($period_id == 104) {
  //   var_dump($members);exit;
  // }
  
  if (!empty($members) && !empty($winner_order)) {
    $total_winner_money = 0;
    foreach ($winner_order as $win) {
      if (empty($members[$win['user_id']])) {
        continue;
      }
      $odds = explode('|', $members[$win['user_id']]['odds_B']);
      switch ($number_type) {
        case 1:
          $odd =  $odds[0];
          break;
        case 2:
          $odd =  $odds[1];
          break;
        case 3:
          $odd =  $odds[2];
          break;
        case 4:
          $odd =  $odds[3];
          break;
        case 5:
          $odd =  $odds[4];
          break;
      }
      $winner_money = $win['pay_B'] * $odd;
      $total_winner_money+= $winner_money;

      //保存个人记录
      $member_new_money = ((int)($members[$win['user_id']]['credit1']*100+$winner_money *100))/100;
      $reward_log[] = array(
        'period_id' => $period_id,
        'member_id' => $win['user_id'],
        'member_nikename' => $members[$win['user_id']]['nickname'],
        'member_old_money' => $members[$win['user_id']]['credit1'],
        'member_new_money' => $member_new_money,
        'bet_number' => $win['bet_number'],
        'bet_money' => $win['pay_B'],
        'winner_number_type' => $winner_number_type,
        'winner_money' => $winner_money,
        'winner_odds' => $odd,
        'winner_number' => $winning_num,
        'winner_type' => 'B',
        'agent_name' => $members[$win['user_id']]['nickname'],
        'number_type' => $number_type,
        'create_time' => time(),
        'order_id' => $win['id'],
        'order_time' => $win['createtime']
      );
      $winner_log[] = array(
        'type' => 1,
        'user_id' => $win['user_id'],
        'lottery_number' => $winning_num,
        'period_id' => $period_id
      );
      $update_member[] = array(
        'user_id' => $win['user_id'],
        'win_money' => $winner_money
      );
    }
  }
  

  $result = array(
    'reward_log' => $reward_log,
    'winner_log' => $winner_log,
    'update_member' => $update_member,
    'total_winner_money' => $total_winner_money
  );

  return $result;
}

function cal_S($period_id, $period_number, $winning_num, $winner_number_type ,$number_type ){
   //获取本期所有订单
  $order = cache_load('order');
  //获取所有会员
  $member = cache_load('member');
  $winner_order = array();
  if (!empty($order)) {
    foreach ($order as $ord) {
      if ($winning_num == $ord['number'] && $ord['pay_S'] > 0) {
        $winner_order[] = array(
          'id' => $ord['order_id'],
          'user_id' => $ord['user_id'],
          'pay_S' => $ord['pay_S'],
          'createtime' => $ord['createtime'],
          'cid' => $ord['cid'],
          'number' => $ord['number'],
          'bet_number' => $ord['bet_number']
        );
      }
    }
  }

  if (!empty($member)) {
    foreach ($member as $mem) {
      $members[$mem['member_id']] = $mem;
    }
  }
  
  if (!empty($members) && !empty($winner_order)) {
    $total_winner_money = 0;
    foreach ($winner_order as $win) {
      if (empty($members[$win['user_id']])) {
        continue;
      }
      $odds = explode('|', $members[$win['user_id']]['odds_S']);
      switch ($number_type) {
        case 1:
          $odd =  $odds[0];
          break;
        case 2:
          $odd =  $odds[1];
          break;
        case 3:
          $odd =  $odds[2];
          break;
        case 4:
          $odd =  $odds[3];
          break;
        case 5:
          $odd =  $odds[4];
          break;
      }
      $winner_money = $win['pay_S'] * $odd;
      $total_winner_money+= $winner_money;

      //保存个人记录
      $member_new_money = ((int)($members[$win['user_id']]['credit1']*100+$winner_money *100))/100;
      $reward_log[] = array(
        'period_id' => $period_id,
        'member_id' => $win['user_id'],
        'member_nikename' => $members[$win['user_id']]['nickname'],
        'member_old_money' => $members[$win['user_id']]['credit1'],
        'member_new_money' => $member_new_money,
        'bet_number' => $win['bet_number'],
        'bet_money' => $win['pay_S'],
        'winner_number_type' => $winner_number_type,
        'winner_money' => $winner_money,
        'winner_odds' => $odd,
        'winner_number' => $winning_num,
        'winner_type' => 'S',
        'agent_name' => $members[$win['user_id']]['nickname'],
        'number_type' => $number_type,
        'create_time' => time(),
        'order_id' => $win['id'],
        'order_time' => $win['createtime']
      );
      $winner_log[] = array(
        'type' => 1,
        'user_id' => $win['user_id'],
        'lottery_number' => $winning_num,
        'period_id' => $period_id
      );
      $update_member[] = array(
        'user_id' => $win['user_id'],
        'win_money' => $winner_money
      );
    }
  }
  

  $result = array(
    'reward_log' => $reward_log,
    'winner_log' => $winner_log,
    'update_member' => $update_member,
    'total_winner_money' => $total_winner_money
  );

  return $result;
}

function cal_A($period_id, $period_number, $winning_num, $winner_number_type ,$number_type){
  //获取本期所有订单
  $order = cache_load('order');
  //获取所有会员
  $member = cache_load('member');
  $winner_order = array();
  if (!empty($order)) {
    foreach ($order as $ord) {
      if (($winning_num == $ord['number'] || substr($winning_num,1) == $ord['number'] || substr($winning_num, 1) == substr($ord['number'], 1)) && $ord['pay_A'] > 0) {
        $winner_order[] = array(
          'id' => $ord['order_id'],
          'user_id' => $ord['user_id'],
          'pay_A' => $ord['pay_A'],
          'createtime' => $ord['createtime'],
          'cid' => $ord['cid'],
          'number' => $ord['number'],
          'bet_number' => $ord['bet_number']
        );
      }
    }
  }

  if (!empty($member)) {
    foreach ($member as $mem) {
      $members[$mem['member_id']] = $mem;
    }
  }
  
  if (!empty($members) && !empty($winner_order)) {
    $total_winner_money = 0;
    foreach ($winner_order as $win) {
      if (empty($members[$win['user_id']])) {
        continue;
      }
      $winner_money = $win['pay_A'] * $members[$win['user_id']]['odds_A'];
      $total_winner_money+= $winner_money;

      //保存个人记录
      $member_new_money = ((int)($members[$win['user_id']]['credit1']*100+$winner_money *100))/100;
      $reward_log[] = array(
        'period_id' => $period_id,
        'member_id' => $win['user_id'],
        'member_nikename' => $members[$win['user_id']]['nickname'],
        'member_old_money' => $members[$win['user_id']]['credit1'],
        'member_new_money' => $member_new_money,
        'bet_number' => $win['bet_number'],
        'bet_money' => $win['pay_A'],
        'winner_number_type' => $winner_number_type,
        'winner_money' => $winner_money,
        'winner_odds' => $members[$win['user_id']]['odds_A'],
        'winner_number' => $winning_num,
        'winner_type' => 'A',
        'agent_name' => $members[$win['user_id']]['nickname'],
        'number_type' => $number_type,
        'create_time' => time(),
        'order_id' => $win['id'],
        'order_time' => $win['createtime']
      );
      $winner_log[] = array(
        'type' => 1,
        'user_id' => $win['user_id'],
        'lottery_number' => $winning_num,
        'period_id' => $period_id
      );
      $update_member[] = array(
        'user_id' => $win['user_id'],
        'win_money' => $winner_money
      );
    }
  }
  

  $result = array(
    'reward_log' => $reward_log,
    'winner_log' => $winner_log,
    'update_member' => $update_member,
    'total_winner_money' => $total_winner_money
  );

  return $result;
}

function cal_C2($period_id, $period_number, $winning_num, $winner_number_type ,$number_type){
  //获取本期所有订单
  $order = cache_load('order');
  //获取所有会员
  $member = cache_load('member');
  $winner_order = array();
  if (!empty($order)) {
    foreach ($order as $ord) {
      if (($winning_num == $ord['number'] || substr($winning_num,1) == $ord['number'] || substr($winning_num, 1) == substr($ord['number'], 1)) && $ord['pay_C2'] > 0) {
        $winner_order[] = array(
          'id' => $ord['order_id'],
          'user_id' => $ord['user_id'],
          'pay_C2' => $ord['pay_C2'],
          'createtime' => $ord['createtime'],
          'cid' => $ord['cid'],
          'number' => $ord['number'],
          'bet_number' => $ord['bet_number']
        );
      }
    }
  }

  if (!empty($member)) {
    foreach ($member as $mem) {
      $members[$mem['member_id']] = $mem;
    }
  }
  
  if (!empty($members) && !empty($winner_order)) {
    $total_winner_money = 0;
    foreach ($winner_order as $win) {
      if (empty($members[$win['user_id']])) {
        continue;
      }
      $winner_money = $win['pay_C2'] * $members[$win['user_id']]['odds_C2'];
      $total_winner_money+= $winner_money;

      //保存个人记录
      $member_new_money = ((int)($members[$win['user_id']]['credit1']*100+$winner_money *100))/100;
      $reward_log[] = array(
        'period_id' => $period_id,
        'member_id' => $win['user_id'],
        'member_nikename' => $members[$win['user_id']]['nickname'],
        'member_old_money' => $members[$win['user_id']]['credit1'],
        'member_new_money' => $member_new_money,
        'bet_number' => $win['bet_number'],
        'bet_money' => $win['pay_C2'],
        'winner_number_type' => $winner_number_type,
        'winner_money' => $winner_money,
        'winner_odds' => $members[$win['user_id']]['odds_C2'],
        'winner_number' => $winning_num,
        'winner_type' => 'C2',
        'agent_name' => $members[$win['user_id']]['nickname'],
        'number_type' => $number_type,
        'create_time' => time(),
        'order_id' => $win['id'],
        'order_time' => $win['createtime']
      );
      $winner_log[] = array(
        'type' => 1,
        'user_id' => $win['user_id'],
        'lottery_number' => $winning_num,
        'period_id' => $period_id
      );
      $update_member[] = array(
        'user_id' => $win['user_id'],
        'win_money' => $winner_money
      );
    }
  }
  

  $result = array(
    'reward_log' => $reward_log,
    'winner_log' => $winner_log,
    'update_member' => $update_member,
    'total_winner_money' => $total_winner_money
  );

  return $result;
}

function cal_C3($period_id, $period_number, $winning_num, $winner_number_type ,$number_type){
  //获取本期所有订单
  $order = cache_load('order');
  //获取所有会员
  $member = cache_load('member');
  $winner_order = array();
  if (!empty($order)) {
    foreach ($order as $ord) {
      if (($winning_num == $ord['number'] || substr($winning_num,1) == $ord['number'] || substr($winning_num, 1) == substr($ord['number'], 1)) && $ord['pay_C3'] > 0) {
        $winner_order[] = array(
          'id' => $ord['order_id'],
          'user_id' => $ord['user_id'],
          'pay_C3' => $ord['pay_C3'],
          'createtime' => $ord['createtime'],
          'cid' => $ord['cid'],
          'number' => $ord['number'],
          'bet_number' => $ord['bet_number']
        );
      }
    }
  }

  if (!empty($member)) {
    foreach ($member as $mem) {
      $members[$mem['member_id']] = $mem;
    }
  }
  
  if (!empty($members) && !empty($winner_order)) {
    $total_winner_money = 0;
    foreach ($winner_order as $win) {
      if (empty($members[$win['user_id']])) {
        continue;
      }
      $winner_money = $win['pay_C3'] * $members[$win['user_id']]['odds_C3'];
      $total_winner_money+= $winner_money;

      //保存个人记录
      $member_new_money = ((int)($members[$win['user_id']]['credit1']*100+$winner_money *100))/100;
      $reward_log[] = array(
        'period_id' => $period_id,
        'member_id' => $win['user_id'],
        'member_nikename' => $members[$win['user_id']]['nickname'],
        'member_old_money' => $members[$win['user_id']]['credit1'],
        'member_new_money' => $member_new_money,
        'bet_number' => $win['bet_number'],
        'bet_money' => $win['pay_C3'],
        'winner_number_type' => $winner_number_type,
        'winner_money' => $winner_money,
        'winner_odds' => $members[$win['user_id']]['odds_C3'],
        'winner_number' => $winning_num,
        'winner_type' => 'C3',
        'agent_name' => $members[$win['user_id']]['nickname'],
        'number_type' => $number_type,
        'create_time' => time(),
        'order_id' => $win['id'],
        'order_time' => $win['createtime']
      );
      $winner_log[] = array(
        'type' => 1,
        'user_id' => $win['user_id'],
        'lottery_number' => $winning_num,
        'period_id' => $period_id
      );
      $update_member[] = array(
        'user_id' => $win['user_id'],
        'win_money' => $winner_money
      );
    }
  }
  

  $result = array(
    'reward_log' => $reward_log,
    'winner_log' => $winner_log,
    'update_member' => $update_member,
    'total_winner_money' => $total_winner_money
  );

  return $result;
}

function cal_C4($period_id, $period_number, $winning_num, $winner_number_type ,$number_type){
  //获取本期所有订单
  $order = cache_load('order');
  //获取所有会员
  $member = cache_load('member');
  $winner_order = array();
  if (!empty($order)) {
    foreach ($order as $ord) {
      if (($winning_num == $ord['number'] || substr($winning_num,1) == $ord['number'] || substr($winning_num, 1) == substr($ord['number'], 1)) && $ord['pay_C4'] > 0) {
        $winner_order[] = array(
          'id' => $ord['order_id'],
          'user_id' => $ord['user_id'],
          'pay_C4' => $ord['pay_C4'],
          'createtime' => $ord['createtime'],
          'cid' => $ord['cid'],
          'number' => $ord['number'],
          'bet_number' => $ord['bet_number']
        );
      }
    }
  }

  if (!empty($member)) {
    foreach ($member as $mem) {
      $members[$mem['member_id']] = $mem;
    }
  }
  
  if (!empty($members) && !empty($winner_order)) {
    $total_winner_money = 0;
    foreach ($winner_order as $win) {
      if (empty($members[$win['user_id']])) {
        continue;
      }
      $winner_money = $win['pay_C4'] * $members[$win['user_id']]['odds_C4'];
      $total_winner_money+= $winner_money;

      //保存个人记录
      $member_new_money = ((int)($members[$win['user_id']]['credit1']*100+$winner_money *100))/100;
      $reward_log[] = array(
        'period_id' => $period_id,
        'member_id' => $win['user_id'],
        'member_nikename' => $members[$win['user_id']]['nickname'],
        'member_old_money' => $members[$win['user_id']]['credit1'],
        'member_new_money' => $member_new_money,
        'bet_number' => $win['bet_number'],
        'bet_money' => $win['pay_C4'],
        'winner_number_type' => $winner_number_type,
        'winner_money' => $winner_money,
        'winner_odds' => $members[$win['user_id']]['odds_C4'],
        'winner_number' => $winning_num,
        'winner_type' => 'C4',
        'agent_name' => $members[$win['user_id']]['nickname'],
        'number_type' => $number_type,
        'create_time' => time(),
        'order_id' => $win['id'],
        'order_time' => $win['createtime']
      );
      $winner_log[] = array(
        'type' => 1,
        'user_id' => $win['user_id'],
        'lottery_number' => $winning_num,
        'period_id' => $period_id
      );
      $update_member[] = array(
        'user_id' => $win['user_id'],
        'win_money' => $winner_money
      );
    }
  }
  

  $result = array(
    'reward_log' => $reward_log,
    'winner_log' => $winner_log,
    'update_member' => $update_member,
    'total_winner_money' => $total_winner_money
  );

  return $result;
}


function cal_C5($period_id, $period_number, $winning_num, $winner_number_type ,$number_type){
  //获取本期所有订单
  $order = cache_load('order');
  //获取所有会员
  $member = cache_load('member');
  $winner_order = array();
  if (!empty($order)) {
    foreach ($order as $ord) {
      if (($winning_num == $ord['number'] || substr($winning_num,1) == $ord['number'] || substr($winning_num, 1) == substr($ord['number'], 1)) && $ord['pay_C5'] > 0) {
        $winner_order[] = array(
          'id' => $ord['order_id'],
          'user_id' => $ord['user_id'],
          'pay_C5' => $ord['pay_C5'],
          'createtime' => $ord['createtime'],
          'cid' => $ord['cid'],
          'number' => $ord['number'],
          'bet_number' => $ord['bet_number']
        );
      }
    }
  }

  if (!empty($member)) {
    foreach ($member as $mem) {
      $members[$mem['member_id']] = $mem;
    }
  }
  
  if (!empty($members) && !empty($winner_order)) {
    $total_winner_money = 0;
    foreach ($winner_order as $win) {
      if (empty($members[$win['user_id']])) {
        continue;
      }
      $winner_money = $win['pay_C5'] * $members[$win['user_id']]['odds_C5'];
      $total_winner_money+= $winner_money;

      //保存个人记录
      $member_new_money = ((int)($members[$win['user_id']]['credit1']*100+$winner_money *100))/100;
      $reward_log[] = array(
        'period_id' => $period_id,
        'member_id' => $win['user_id'],
        'member_nikename' => $members[$win['user_id']]['nickname'],
        'member_old_money' => $members[$win['user_id']]['credit1'],
        'member_new_money' => $member_new_money,
        'bet_number' => $win['bet_number'],
        'bet_money' => $win['pay_C5'],
        'winner_number_type' => $winner_number_type,
        'winner_money' => $winner_money,
        'winner_odds' => $members[$win['user_id']]['odds_C5'],
        'winner_number' => $winning_num,
        'winner_type' => 'C5',
        'agent_name' => $members[$win['user_id']]['nickname'],
        'number_type' => $number_type,
        'create_time' => time(),
        'order_id' => $win['id'],
        'order_time' => $win['createtime']
      );
      $winner_log[] = array(
        'type' => 1,
        'user_id' => $win['user_id'],
        'lottery_number' => $winning_num,
        'period_id' => $period_id
      );
      $update_member[] = array(
        'user_id' => $win['user_id'],
        'win_money' => $winner_money
      );
    }
  }
  

  $result = array(
    'reward_log' => $reward_log,
    'winner_log' => $winner_log,
    'update_member' => $update_member,
    'total_winner_money' => $total_winner_money
  );

  return $result;
}

function cal_2A($period_id, $period_number, $winning_num, $winner_number_type ,$number_type){
  //获取本期所有订单
  $order = cache_load('order');
  //获取所有会员
  $member = cache_load('member');
  $winner_order = array();
  if (!empty($order)) {
    foreach ($order as $ord) {
      if (($winning_num == $ord['number'] || substr($winning_num,2) == $ord['number'] || substr($winning_num, 2) == substr($ord['number'], 2)) && $ord['pay_2A'] > 0) {
        $winner_order[] = array(
          'id' => $ord['order_id'],
          'user_id' => $ord['user_id'],
          'pay_2A' => $ord['pay_2A'],
          'createtime' => $ord['createtime'],
          'cid' => $ord['cid'],
          'number' => $ord['number'],
          'bet_number' => $ord['bet_number']
        );
      }
    }
  }

  if (!empty($member)) {
    foreach ($member as $mem) {
      $members[$mem['member_id']] = $mem;
    }
  }
  
  if (!empty($members) && !empty($winner_order)) {
    $total_winner_money = 0;
    foreach ($winner_order as $win) {
      if (empty($members[$win['user_id']])) {
        continue;
      }
      $winner_money = $win['pay_2A'] * $members[$win['user_id']]['odds_2A'];
      $total_winner_money+= $winner_money;

      //保存个人记录
      $member_new_money = ((int)($members[$win['user_id']]['credit1']*100+$winner_money *100))/100;
      $reward_log[] = array(
        'period_id' => $period_id,
        'member_id' => $win['user_id'],
        'member_nikename' => $members[$win['user_id']]['nickname'],
        'member_old_money' => $members[$win['user_id']]['credit1'],
        'member_new_money' => $member_new_money,
        'bet_number' => $win['bet_number'],
        'bet_money' => $win['pay_2A'],
        'winner_number_type' => $winner_number_type,
        'winner_money' => $winner_money,
        'winner_odds' => $members[$win['user_id']]['odds_2A'],
        'winner_number' => $winning_num,
        'winner_type' => '2A',
        'agent_name' => $members[$win['user_id']]['nickname'],
        'number_type' => $number_type,
        'create_time' => time(),
        'order_id' => $win['id'],
        'order_time' => $win['createtime']
      );
      $winner_log[] = array(
        'type' => 1,
        'user_id' => $win['user_id'],
        'lottery_number' => $winning_num,
        'period_id' => $period_id
      );
      $update_member[] = array(
        'user_id' => $win['user_id'],
        'win_money' => $winner_money
      );
    }
  }
  

  $result = array(
    'reward_log' => $reward_log,
    'winner_log' => $winner_log,
    'update_member' => $update_member,
    'total_winner_money' => $total_winner_money
  );

  return $result;
}

function cal_2B($period_id, $period_number, $winning_num, $winner_number_type ,$number_type){
  //获取本期所有订单
  $order = cache_load('order');
  //获取所有会员
  $member = cache_load('member');
  $winner_order = array();
  if (!empty($order)) {
    foreach ($order as $ord) {
      if (($winning_num == $ord['number'] || substr($winning_num,2) == $ord['number'] || substr($winning_num, 2) == substr($ord['number'], 2)) && $ord['pay_2B'] > 0) {
        $winner_order[] = array(
          'id' => $ord['order_id'],
          'user_id' => $ord['user_id'],
          'pay_2B' => $ord['pay_2B'],
          'createtime' => $ord['createtime'],
          'cid' => $ord['cid'],
          'number' => $ord['number'],
          'bet_number' => $ord['bet_number']
        );
      }
    }
  }

  if (!empty($member)) {
    foreach ($member as $mem) {
      $members[$mem['member_id']] = $mem;
    }
  }
  
  if (!empty($members) && !empty($winner_order)) {
    $total_winner_money = 0;
    foreach ($winner_order as $win) {
      if (empty($members[$win['user_id']])) {
        continue;
      }
      $winner_money = $win['pay_2B'] * $members[$win['user_id']]['odds_2B'];
      $total_winner_money+= $winner_money;

      //保存个人记录
      $member_new_money = ((int)($members[$win['user_id']]['credit1']*100+$winner_money *100))/100;
      $reward_log[] = array(
        'period_id' => $period_id,
        'member_id' => $win['user_id'],
        'member_nikename' => $members[$win['user_id']]['nickname'],
        'member_old_money' => $members[$win['user_id']]['credit1'],
        'member_new_money' => $member_new_money,
        'bet_number' => $win['bet_number'],
        'bet_money' => $win['pay_2B'],
        'winner_number_type' => $winner_number_type,
        'winner_money' => $winner_money,
        'winner_odds' => $members[$win['user_id']]['odds_2B'],
        'winner_number' => $winning_num,
        'winner_type' => '2B',
        'agent_name' => $members[$win['user_id']]['nickname'],
        'number_type' => $number_type,
        'create_time' => time(),
        'order_id' => $win['id'],
        'order_time' => $win['createtime']
      );
      $winner_log[] = array(
        'type' => 1,
        'user_id' => $win['user_id'],
        'lottery_number' => $winning_num,
        'period_id' => $period_id
      );
      $update_member[] = array(
        'user_id' => $win['user_id'],
        'win_money' => $winner_money
      );
    }
  }
  

  $result = array(
    'reward_log' => $reward_log,
    'winner_log' => $winner_log,
    'update_member' => $update_member,
    'total_winner_money' => $total_winner_money
  );

  return $result;
}

function cal_2C($period_id, $period_number, $winning_num, $winner_number_type ,$number_type){
  //获取本期所有订单
  $order = cache_load('order');
  //获取所有会员
  $member = cache_load('member');
  $winner_order = array();
  if (!empty($order)) {
    foreach ($order as $ord) {
      if (($winning_num == $ord['number'] || substr($winning_num,2) == $ord['number'] || substr($winning_num, 2) == substr($ord['number'], 2)) && $ord['pay_2C'] > 0) {
        $winner_order[] = array(
          'id' => $ord['order_id'],
          'user_id' => $ord['user_id'],
          'pay_2C' => $ord['pay_2C'],
          'createtime' => $ord['createtime'],
          'cid' => $ord['cid'],
          'number' => $ord['number'],
          'bet_number' => $ord['bet_number']
        );
      }
    }
  }

  if (!empty($member)) {
    foreach ($member as $mem) {
      $members[$mem['member_id']] = $mem;
    }
  }
  
  if (!empty($members) && !empty($winner_order)) {
    $total_winner_money = 0;
    foreach ($winner_order as $win) {
      if (empty($members[$win['user_id']])) {
        continue;
      }
      $winner_money = $win['pay_2C'] * $members[$win['user_id']]['odds_2C'];
      $total_winner_money+= $winner_money;

      //保存个人记录
      $member_new_money = ((int)($members[$win['user_id']]['credit1']*100+$winner_money *100))/100;
      $reward_log[] = array(
        'period_id' => $period_id,
        'member_id' => $win['user_id'],
        'member_nikename' => $members[$win['user_id']]['nickname'],
        'member_old_money' => $members[$win['user_id']]['credit1'],
        'member_new_money' => $member_new_money,
        'bet_number' => $win['bet_number'],
        'bet_money' => $win['pay_2C'],
        'winner_number_type' => $winner_number_type,
        'winner_money' => $winner_money,
        'winner_odds' => $members[$win['user_id']]['odds_2C'],
        'winner_number' => $winning_num,
        'winner_type' => '2C',
        'agent_name' => $members[$win['user_id']]['nickname'],
        'number_type' => $number_type,
        'create_time' => time(),
        'order_id' => $win['id'],
        'order_time' => $win['createtime']
      );
      $winner_log[] = array(
        'type' => 1,
        'user_id' => $win['user_id'],
        'lottery_number' => $winning_num,
        'period_id' => $period_id
      );
      $update_member[] = array(
        'user_id' => $win['user_id'],
        'win_money' => $winner_money
      );
    }
  }
  

  $result = array(
    'reward_log' => $reward_log,
    'winner_log' => $winner_log,
    'update_member' => $update_member,
    'total_winner_money' => $total_winner_money
  );

  return $result;
}

function cal_2D($period_id, $period_number, $winning_num, $winner_number_type ,$number_type){
  //获取本期所有订单
  $order = cache_load('order');
  //获取所有会员
  $member = cache_load('member');
  $winner_order = array();
  if (!empty($order)) {
    foreach ($order as $ord) {
      if (($winning_num == $ord['number'] || substr($winning_num,2) == $ord['number'] || substr($winning_num, 2) == substr($ord['number'], 2)) && $ord['pay_2D'] > 0) {
        $winner_order[] = array(
          'id' => $ord['order_id'],
          'user_id' => $ord['user_id'],
          'pay_2D' => $ord['pay_2D'],
          'createtime' => $ord['createtime'],
          'cid' => $ord['cid'],
          'number' => $ord['number'],
          'bet_number' => $ord['bet_number']
        );
      }
    }
  }

  if (!empty($member)) {
    foreach ($member as $mem) {
      $members[$mem['member_id']] = $mem;
    }
  }
  
  if (!empty($members) && !empty($winner_order)) {
    $total_winner_money = 0;
    foreach ($winner_order as $win) {
      if (empty($members[$win['user_id']])) {
        continue;
      }
      $winner_money = $win['pay_2D'] * $members[$win['user_id']]['odds_2D'];
      $total_winner_money+= $winner_money;

      //保存个人记录
      $member_new_money = ((int)($members[$win['user_id']]['credit1']*100+$winner_money *100))/100;
      $reward_log[] = array(
        'period_id' => $period_id,
        'member_id' => $win['user_id'],
        'member_nikename' => $members[$win['user_id']]['nickname'],
        'member_old_money' => $members[$win['user_id']]['credit1'],
        'member_new_money' => $member_new_money,
        'bet_number' => $win['bet_number'],
        'bet_money' => $win['pay_2D'],
        'winner_number_type' => $winner_number_type,
        'winner_money' => $winner_money,
        'winner_odds' => $members[$win['user_id']]['odds_2D'],
        'winner_number' => $winning_num,
        'winner_type' => '2D',
        'agent_name' => $members[$win['user_id']]['nickname'],
        'number_type' => $number_type,
        'create_time' => time(),
        'order_id' => $win['id'],
        'order_time' => $win['createtime']
      );
      $winner_log[] = array(
        'type' => 1,
        'user_id' => $win['user_id'],
        'lottery_number' => $winning_num,
        'period_id' => $period_id
      );
      $update_member[] = array(
        'user_id' => $win['user_id'],
        'win_money' => $winner_money
      );
    }
  }
  

  $result = array(
    'reward_log' => $reward_log,
    'winner_log' => $winner_log,
    'update_member' => $update_member,
    'total_winner_money' => $total_winner_money
  );

  return $result;
}

function cal_2E($period_id, $period_number, $winning_num, $winner_number_type ,$number_type){
  //获取本期所有订单
  $order = cache_load('order');
  //获取所有会员
  $member = cache_load('member');
  $winner_order = array();
  if (!empty($order)) {
    foreach ($order as $ord) {
      if (($winning_num == $ord['number'] || substr($winning_num,2) == $ord['number'] || substr($winning_num, 2) == substr($ord['number'], 2)) && $ord['pay_2E'] > 0) {
        $winner_order[] = array(
          'id' => $ord['order_id'],
          'user_id' => $ord['user_id'],
          'pay_2E' => $ord['pay_2E'],
          'createtime' => $ord['createtime'],
          'cid' => $ord['cid'],
          'number' => $ord['number'],
          'bet_number' => $ord['bet_number']
        );
      }
    }
  }

  if (!empty($member)) {
    foreach ($member as $mem) {
      $members[$mem['member_id']] = $mem;
    }
  }
  
  if (!empty($members) && !empty($winner_order)) {
    $total_winner_money = 0;
    foreach ($winner_order as $win) {
      if (empty($members[$win['user_id']])) {
        continue;
      }
      $winner_money = $win['pay_2E'] * $members[$win['user_id']]['odds_2E'];
      $total_winner_money+= $winner_money;

      //保存个人记录
      $member_new_money = ((int)($members[$win['user_id']]['credit1']*100+$winner_money *100))/100;
      $reward_log[] = array(
        'period_id' => $period_id,
        'member_id' => $win['user_id'],
        'member_nikename' => $members[$win['user_id']]['nickname'],
        'member_old_money' => $members[$win['user_id']]['credit1'],
        'member_new_money' => $member_new_money,
        'bet_number' => $win['bet_number'],
        'bet_money' => $win['pay_2E'],
        'winner_number_type' => $winner_number_type,
        'winner_money' => $winner_money,
        'winner_odds' => $members[$win['user_id']]['odds_2E'],
        'winner_number' => $winning_num,
        'winner_type' => '2E',
        'agent_name' => $members[$win['user_id']]['nickname'],
        'number_type' => $number_type,
        'create_time' => time(),
        'order_id' => $win['id'],
        'order_time' => $win['createtime']
      );
      $winner_log[] = array(
        'type' => 1,
        'user_id' => $win['user_id'],
        'lottery_number' => $winning_num,
        'period_id' => $period_id
      );
      $update_member[] = array(
        'user_id' => $win['user_id'],
        'win_money' => $winner_money
      );
    }
  }
  

  $result = array(
    'reward_log' => $reward_log,
    'winner_log' => $winner_log,
    'update_member' => $update_member,
    'total_winner_money' => $total_winner_money
  );

  return $result;
}

function cal_2ABC($period_id, $period_number, $winning_num, $winner_number_type ,$number_type){
   //获取本期所有订单
  $order = cache_load('order');
  //获取所有会员
  $member = cache_load('member');
  $winner_order = array();
  if (!empty($order)) {
    foreach ($order as $ord) {
      if (($winning_num == $ord['number'] || substr($winning_num,2) == $ord['number'] || substr($winning_num, 2) == substr($ord['number'], 2)) && $ord['pay_2ABC'] > 0) {
        $winner_order[] = array(
          'id' => $ord['order_id'],
          'user_id' => $ord['user_id'],
          'pay_2ABC' => $ord['pay_2ABC'],
          'createtime' => $ord['createtime'],
          'cid' => $ord['cid'],
          'number' => $ord['number'],
          'bet_number' => $ord['bet_number']
        );
      }
    }
  }

  if (!empty($member)) {
    foreach ($member as $mem) {
      $members[$mem['member_id']] = $mem;
    }
  }
  
  if (!empty($members) && !empty($winner_order)) {
    $total_winner_money = 0;
    foreach ($winner_order as $win) {
      if (empty($members[$win['user_id']])) {
        continue;
      }
      $odds = explode('|', $members[$win['user_id']]['odds_2ABC']);
      switch ($number_type) {
        case 1:
          $odd =  $odds[0];
          break;
        case 2:
          $odd =  $odds[1];
          break;
        case 3:
          $odd =  $odds[2];
          break;
      }
      $winner_money = $win['pay_2ABC'] * $odd;
      $total_winner_money+= $winner_money;

      //保存个人记录
      $member_new_money = ((int)($members[$win['user_id']]['credit1']*100+$winner_money *100))/100;
      $reward_log[] = array(
        'period_id' => $period_id,
        'member_id' => $win['user_id'],
        'member_nikename' => $members[$win['user_id']]['nickname'],
        'member_old_money' => $members[$win['user_id']]['credit1'],
        'member_new_money' => $member_new_money,
        'bet_number' => $win['bet_number'],
        'bet_money' => $win['pay_2ABC'],
        'winner_number_type' => $winner_number_type,
        'winner_money' => $winner_money,
        'winner_odds' => $odd,
        'winner_number' => $winning_num,
        'winner_type' => '2ABC',
        'agent_name' => $members[$win['user_id']]['nickname'],
        'number_type' => $number_type,
        'create_time' => time(),
        'order_id' => $win['id'],
        'order_time' => $win['createtime']
      );
      $winner_log[] = array(
        'type' => 1,
        'user_id' => $win['user_id'],
        'lottery_number' => $winning_num,
        'period_id' => $period_id
      );
      $update_member[] = array(
        'user_id' => $win['user_id'],
        'win_money' => $winner_money
      );
    }
  }
  

  $result = array(
    'reward_log' => $reward_log,
    'winner_log' => $winner_log,
    'update_member' => $update_member,
    'total_winner_money' => $total_winner_money
  );

  return $result;
}

function cal_3ABC($period_id, $period_number, $winning_num, $winner_number_type ,$number_type){
   //获取本期所有订单
  $order = cache_load('order');
  //获取所有会员
  $member = cache_load('member');
  $winner_order = array();
  if (!empty($order)) {
    foreach ($order as $ord) {
      if (($winning_num == $ord['number'] || substr($winning_num,1) == $ord['number'] || substr($winning_num, 1) == substr($ord['number'], 1)) && $ord['pay_3ABC'] > 0) {
        $winner_order[] = array(
          'id' => $ord['order_id'],
          'user_id' => $ord['user_id'],
          'pay_3ABC' => $ord['pay_3ABC'],
          'createtime' => $ord['createtime'],
          'cid' => $ord['cid'],
          'number' => $ord['number'],
          'bet_number' => $ord['bet_number']
        );
      }
    }
  }

  if (!empty($member)) {
    foreach ($member as $mem) {
      $members[$mem['member_id']] = $mem;
    }
  }
  
  if (!empty($members) && !empty($winner_order)) {
    $total_winner_money = 0;
    foreach ($winner_order as $win) {
      if (empty($members[$win['user_id']])) {
        continue;
      }
      $odds = explode('|', $members[$win['user_id']]['odds_3ABC']);
      switch ($number_type) {
        case 1:
          $odd =  $odds[0];
          break;
        case 2:
          $odd =  $odds[1];
          break;
        case 3:
          $odd =  $odds[2];
          break;
        case 4:
          $odd =  $odds[3];
          break;
        case 5:
          $odd =  $odds[4];
          break;
      }
      $winner_money = $win['pay_3ABC'] * $odd;
      $total_winner_money+= $winner_money;

      //保存个人记录
      $member_new_money = ((int)($members[$win['user_id']]['credit1']*100+$winner_money *100))/100;
      $reward_log[] = array(
        'period_id' => $period_id,
        'member_id' => $win['user_id'],
        'member_nikename' => $members[$win['user_id']]['nickname'],
        'member_old_money' => $members[$win['user_id']]['credit1'],
        'member_new_money' => $member_new_money,
        'bet_number' => $win['bet_number'],
        'bet_money' => $win['pay_3ABC'],
        'winner_number_type' => $winner_number_type,
        'winner_money' => $winner_money,
        'winner_odds' => $odd,
        'winner_number' => $winning_num,
        'winner_type' => '3ABC',
        'agent_name' => $members[$win['user_id']]['nickname'],
        'number_type' => $number_type,
        'create_time' => time(),
        'order_id' => $win['id'],
        'order_time' => $win['createtime']
      );
      $winner_log[] = array(
        'type' => 1,
        'user_id' => $win['user_id'],
        'lottery_number' => $winning_num,
        'period_id' => $period_id
      );
      $update_member[] = array(
        'user_id' => $win['user_id'],
        'win_money' => $winner_money
      );
    }
  }
  

  $result = array(
    'reward_log' => $reward_log,
    'winner_log' => $winner_log,
    'update_member' => $update_member,
    'total_winner_money' => $total_winner_money
  );

  return $result;
}

function cal_EA($period_id, $period_number, $winning_num, $winner_number_type,$number_type ){
  //获取本期所有订单
  $order = cache_load('order');
  //获取所有会员
  $member = cache_load('member');
  $winner_order = array();
  if (!empty($order)) {
    foreach ($order as $ord) {
      if ($winning_num == $ord['number'] && $ord['pay_EA'] > 0) {
        $winner_order[] = array(
          'id' => $ord['order_id'],
          'user_id' => $ord['user_id'],
          'pay_EA' => $ord['pay_EA'],
          'createtime' => $ord['createtime'],
          'cid' => $ord['cid'],
          'number' => $ord['number'],
          'bet_number' => $ord['bet_number']
        );
      }
    }
  }

  if (!empty($member)) {
    foreach ($member as $mem) {
      $members[$mem['member_id']] = $mem;
    }
  }
  
  if (!empty($members) && !empty($winner_order)) {
    $total_winner_money = 0;
    foreach ($winner_order as $win) {
      if (empty($members[$win['user_id']])) {
        continue;
      }
      $winner_money = $win['pay_EA'] * $members[$win['user_id']]['odds_EA'];
      $total_winner_money+= $winner_money;

      //保存个人记录
      $member_new_money = ((int)($members[$win['user_id']]['credit1']*100+$winner_money *100))/100;
      $reward_log[] = array(
        'period_id' => $period_id,
        'member_id' => $win['user_id'],
        'member_nikename' => $members[$win['user_id']]['nickname'],
        'member_old_money' => $members[$win['user_id']]['credit1'],
        'member_new_money' => $member_new_money,
        'bet_number' => $win['bet_number'],
        'bet_money' => $win['pay_EA'],
        'winner_number_type' => $winner_number_type,
        'winner_money' => $winner_money,
        'winner_odds' => $members[$win['user_id']]['odds_EA'],
        'winner_number' => $winning_num,
        'winner_type' => 'EA',
        'agent_name' => $members[$win['user_id']]['nickname'],
        'number_type' => $number_type,
        'create_time' => time(),
        'order_id' => $win['id'],
        'order_time' => $win['createtime']
      );
      $winner_log[] = array(
        'type' => 1,
        'user_id' => $win['user_id'],
        'lottery_number' => $winning_num,
        'period_id' => $period_id
      );
      $update_member[] = array(
        'user_id' => $win['user_id'],
        'win_money' => $winner_money
      );
    }
  }
  

  $result = array(
    'reward_log' => $reward_log,
    'winner_log' => $winner_log,
    'update_member' => $update_member,
    'total_winner_money' => $total_winner_money
  );

  return $result;
}

function cal_EC($period_id, $period_number, $winning_num, $winner_number_type ,$number_type){
  //获取本期所有订单
  $order = cache_load('order');
  //获取所有会员
  $member = cache_load('member');
  $winner_order = array();
  if (!empty($order)) {
    foreach ($order as $ord) {
      if (($winning_num == $ord['number'] || substr($winning_num,1) == $ord['number'] || substr($winning_num, 1) == substr($ord['number'], 1)) && $ord['pay_EC'] > 0) {
        $winner_order[] = array(
          'id' => $ord['order_id'],
          'user_id' => $ord['user_id'],
          'pay_EC' => $ord['pay_EC'],
          'createtime' => $ord['createtime'],
          'cid' => $ord['cid'],
          'number' => $ord['number'],
          'bet_number' => $ord['bet_number']
        );
      }
    }
  }

  if (!empty($member)) {
    foreach ($member as $mem) {
      $members[$mem['member_id']] = $mem;
    }
  }
  
  if (!empty($members) && !empty($winner_order)) {
    $total_winner_money = 0;
    foreach ($winner_order as $win) {
      if (empty($members[$win['user_id']])) {
        continue;
      }
      $winner_money = $win['pay_EC'] * $members[$win['user_id']]['odds_EC'];
      $total_winner_money+= $winner_money;

      //保存个人记录
      $member_new_money = ((int)($members[$win['user_id']]['credit1']*100+$winner_money *100))/100;
      $reward_log[] = array(
        'period_id' => $period_id,
        'member_id' => $win['user_id'],
        'member_nikename' => $members[$win['user_id']]['nickname'],
        'member_old_money' => $members[$win['user_id']]['credit1'],
        'member_new_money' => $member_new_money,
        'bet_number' => $win['bet_number'],
        'bet_money' => $win['pay_EC'],
        'winner_number_type' => $winner_number_type,
        'winner_money' => $winner_money,
        'winner_odds' => $members[$win['user_id']]['odds_EC'],
        'winner_number' => $winning_num,
        'winner_type' => 'EC',
        'agent_name' => $members[$win['user_id']]['nickname'],
        'number_type' => $number_type,
        'create_time' => time(),
        'order_id' => $win['id'],
        'order_time' => $win['createtime']
      );
      $winner_log[] = array(
        'type' => 1,
        'user_id' => $win['user_id'],
        'lottery_number' => $winning_num,
        'period_id' => $period_id
      );
      $update_member[] = array(
        'user_id' => $win['user_id'],
        'win_money' => $winner_money
      );
    }
  }
  

  $result = array(
    'reward_log' => $reward_log,
    'winner_log' => $winner_log,
    'update_member' => $update_member,
    'total_winner_money' => $total_winner_money
  );

  return $result;
}

function cal_EX($period_id, $period_number, $winning_num, $winner_number_type ,$number_type){
  //获取本期所有订单
  $order = cache_load('order');
  //获取所有会员
  $member = cache_load('member');
  $winner_order = array();
  if (!empty($order)) {
    foreach ($order as $ord) {
      if (($winning_num == $ord['number'] || substr($winning_num,2) == $ord['number'] || substr($winning_num, 2) == substr($ord['number'], 2)) && $ord['pay_EX'] > 0) {
        $winner_order[] = array(
          'id' => $ord['order_id'],
          'user_id' => $ord['user_id'],
          'pay_EX' => $ord['pay_EX'],
          'createtime' => $ord['createtime'],
          'cid' => $ord['cid'],
          'number' => $ord['number'],
          'bet_number' => $ord['bet_number']
        );
      }
    }
  }

  if (!empty($member)) {
    foreach ($member as $mem) {
      $members[$mem['member_id']] = $mem;
    }
  }
  
  if (!empty($members) && !empty($winner_order)) {
    $total_winner_money = 0;
    foreach ($winner_order as $win) {
      if (empty($members[$win['user_id']])) {
        continue;
      }
      $winner_money = $win['pay_EX'] * $members[$win['user_id']]['odds_EX'];
      $total_winner_money+= $winner_money;

      //保存个人记录
      $member_new_money = ((int)($members[$win['user_id']]['credit1']*100+$winner_money *100))/100;
      $reward_log[] = array(
        'period_id' => $period_id,
        'member_id' => $win['user_id'],
        'member_nikename' => $members[$win['user_id']]['nickname'],
        'member_old_money' => $members[$win['user_id']]['credit1'],
        'member_new_money' => $member_new_money,
        'bet_number' => $win['bet_number'],
        'bet_money' => $win['pay_EX'],
        'winner_number_type' => $winner_number_type,
        'winner_money' => $winner_money,
        'winner_odds' => $members[$win['user_id']]['odds_EX'],
        'winner_number' => $winning_num,
        'winner_type' => 'EX',
        'agent_name' => $members[$win['user_id']]['nickname'],
        'number_type' => $number_type,
        'create_time' => time(),
        'order_id' => $win['id'],
        'order_time' => $win['createtime']
      );
      $winner_log[] = array(
        'type' => 1,
        'user_id' => $win['user_id'],
        'lottery_number' => $winning_num,
        'period_id' => $period_id
      );
      $update_member[] = array(
        'user_id' => $win['user_id'],
        'win_money' => $winner_money
      );
    }
  }
  

  $result = array(
    'reward_log' => $reward_log,
    'winner_log' => $winner_log,
    'update_member' => $update_member,
    'total_winner_money' => $total_winner_money
  );

  return $result;
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

function get_children($id)
{
    $return = array();
    $list = pdo_fetchColumnValue('select id from '.tablename('agent_member').' where parent_agent=:agent',array(':agent'=>$id),'id');
    if (!empty($list)) {
        foreach ($list as $key => $value) {
            $children = get_children($value);
            $return = array_merge($return,$children);
        }
        $return = array_merge($return,$list);
    }

    return $return;
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

function getParentCash($id)
{
    $parents = getParent($id);
    if (count($parents) > 0) {
        $id_fields = implode(',', $parents);
        $cashback = pdo_fetchall('select cashback_percent from '.tablename('agent_percent').' where agent_id in ('.$id_fields.')');
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
            $cash = json_decode($value['cashback_percent'],true);
            foreach ($cash as $k => $v) {
                $data[$k] += $v;
            }
        }
    }

    return $data;
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


function get_cashback_only($odd,$index,$commission,$my_commission=0)
{
  if ($index == 'B') {
      $odd_total = get_total_odds($odd);
      $odds_percent = ($odd_total)/100;
  }
  if ($index == 'A') {
      $odd_total = get_max($odd);
      $odds_percent = ($odd_total)/10;
  }
  if ($index == 'S') {
      $odd_total = get_total_odds($odd);
      $odds_percent = ($odd_total)/100;
  }
  if ($index == '3ABC') {
      $odd_total = get_total_odds($odd);
      $odds_percent = ($odd_total)/10;
  }
  if ($index == '4ABC') {
      $odd_total = get_total_odds($odd);
      $odds_percent = ($odd_total)/100;
  }
  if ($index == '4A') {
      $odd_total = get_max($odd);
      $odds_percent = ($odd_total)/100;
  }
  if ($index == '2ABC') {
      $odd_total = get_total_odds($odd);
      $odds_percent = ($odd_total);
  }
  if ($index == '2A') {
      $odd_total = get_max($odd);
      $odds_percent = ($odd_total);
  }
  if ($index == '5D') {
    $odds_percent = get_5d_odd($odd);
  }
  if ($index == '6D') {
    $odds_percent = get_6d_odd($odd);
  }

  $cashback = 100-floatval($odds_percent)-floatval($commission)-floatval($my_commission);
  return round($cashback,0);
}

function get_5d_odd($odd)
{
  $total_odds = 0;
  for ($i=0; $i < 6; $i++) { 
    if ($i == 3) {
      $total_odds = $total_odds+($odd[$i]*10);
    }
    elseif ($i == 4) {
      $total_odds = $total_odds+($odd[$i]*100);
    }
    elseif ($i == 5) {
      $total_odds = $total_odds+($odd[$i]*1000);
    }
    else{
      $total_odds = $total_odds+$odd[$i];
    }
  }
  $percent = $total_odds/1000;
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
  $percent = $total_odds/10000;
  return $percent;
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
  $bet_number = pdo_fetchColumnValue('select bet_number from '.tablename('manji_reward_log').' where period_id in ('.$period.') and number_type<=3 group by bet_number',array(),'bet_number');
  $num = implode(',', $win_num);
  $order = pdo_fetchall('select number,user_id,pid,period_id,partner_number,goods_amount,array_id,mode from '.tablename('manji_order').' where partner_number in ('.$num.') and status=1 '.$condition);
  $partner = pdo_fetchall('select number,user_id,pid,period_id,goods_amount,array_id,jackpot_number from '.tablename('manji_order').' where (concat(jackpot_number,number) in ('.$num.') or number in ('.$num.')) and status=1 '.$condition);
  foreach ($order as $k => $o) {
    $number_count = count(sort_number($o['number']));
    $pay_amount = 0;
    foreach ($partner as $ke => $p) {
      if ($o['partner_number'] == $p['jackpot_number'].$p['number'] && $p['array_id'] == $o['array_id'] && $p['pid'] == $o['pid']) {
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
    }
    if ($pay_amount == 0) {
      $pay_amount = $o['goods_amount'];
    }
    $periodss = str_replace('(', '', $o['period_id']);
    $periodss = str_replace(')', '', $periodss);
    $periodss = explode(',', $periodss);
    foreach ($periodss as $pes) {
      if (in_array($pes,$periods)) {
        $period_id = $pes;
      }
    }
    if (in_array($o['number'], $bet_number) && $pay_amount > 0) {
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
  if (!empty($win_order)) {
    foreach ($win_order as $val) {
      $win_money = ($val['bet_money']/$total_amount)*$jackpot;
      $cal_money += $val['win_money'] = $win_money;
      pdo_insert('manji_jackpot_log',$val);
      pdo_query('update '.tablename('member_system_member').' set credit1=credit1+'.$win_money.' where id='.$val['user_id']);
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
  $bet_number1 = pdo_fetchColumnValue('select bet_number from '.tablename('manji_reward_log').' where period_id in ('.$period.') and number_type<=3 group by bet_number',array(),'bet_number');
  $bet_number2 = pdo_fetchColumnValue('select bet_number from '.tablename('manji_reward_log').' where period_id in ('.$period.') and number_type=4 group by bet_number',array(),'bet_number');
  $num1 = implode(',', $win_num1);
  $num2 = implode(',', $win_num2);
  $order1 = pdo_fetchall('select number,user_id,pid,period_id,partner_number,goods_amount,array_id,mode from '.tablename('manji_order').' where partner_number in ('.$num1.') and status=1'.$condition);
  $order2 = pdo_fetchall('select number,user_id,pid,period_id,partner_number,goods_amount,array_id,mode from '.tablename('manji_order').' where partner_number in ('.$num2.') and status=1'.$condition);
  $partner1 = pdo_fetchall('select number,user_id,pid,period_id,goods_amount,array_id,jackpot_number from '.tablename('manji_order').' where (concat(jackpot_number,number) in ('.$num1.') or number in ('.$num1.')) and status=1 '.$condition);
  $partner2 = pdo_fetchall('select number,user_id,pid,period_id,goods_amount,array_id,jackpot_number from '.tablename('manji_order').' where (concat(jackpot_number,number) in ('.$num2.') or number in ('.$num2.')) and status=1 '.$condition);
  foreach ($order1 as $k1 => $o1) {
    $number_count1 = count(sort_number($o1['number']));
    $pay_amount1 = 0;
    foreach ($partner1 as $ke1 => $p1) {
      if ($o1['partner_number'] == $p1['jackpot_number'].$p1['number'] && $p1['array_id'] == $o1['array_id'] && $p1['pid'] == $o1['pid']) {
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
    }
    if ($pay_amount1 == 0) {
      $pay_amount1 = $o1['goods_amount'];
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
        'bet_money' => $pay_amount1,
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
      if ($o2['partner_number'] == $p2['jackpot_number'].$p2['number'] && $p2['array_id'] == $o2['array_id'] && $p2['pid'] == $o2['pid']) {
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
    }
    if ($pay_amount2 == 0) {
      $pay_amount2 = $o2['goods_amount'];
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
        'bet_money' => $pay_amount2,
        'win_type' => '中彩金',
        'order_id' => $o2['pid'],
        'createtime' => time()
      );
    }
  }
  if ($total_amount < 200) {
    $total_amount = 200;
  }
  if (!empty($win_order)) {
    foreach ($win_order as $val) {
      $has = pdo_fetchcolumn('select count(1) from '.tablename('manji_jackpot_log').' where order_id=:id and period_id=:pid',array(':id'=>$val['order_id'],':pid'=>$val['period_id']));
      if ($has > 0) {
        continue;
      }
      $win_money = ($val['bet_money']/$total_amount)*$jackpot;
      $cal_money += $val['win_money'] = $win_money;
      pdo_insert('manji_jackpot_log',$val);
      pdo_query('update '.tablename('member_system_member').' set credit1=credit1+'.$win_money.' where id='.$val['user_id']);
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
  $bet_number = pdo_fetchColumnValue('select bet_number from '.tablename('manji_reward_log').' where period_id in ('.$period.') and number_type>=4 group by bet_number',array(),'bet_number');
  $num = implode(',', $win_num);
  $jackpot = pdo_fetchcolumn('select small_jackpot from '.tablename('manji_jackpot'));
  $order = pdo_fetchall('select number,user_id,pid,period_id,partner_number,goods_amount,array_id,mode from '.tablename('manji_order').' where partner_number in ('.$num.')'.$condition);
  $partner = pdo_fetchall('select number,user_id,pid,period_id,goods_amount,array_id,jackpot_number from '.tablename('manji_order').' where (concat(jackpot_number,number) in ('.$num.') or number in ('.$num.')) and status=1 '.$condition);
  foreach ($order as $k => $o) {
    $number_count = count(sort_number($o['number']));
    $pay_amount = 0;
    foreach ($partner as $ke => $p) {
      if ($o['partner_number'] == $p['number'] && $p['jackpot_number'].$p['array_id'] == $o['array_id'] && $p['pid'] == $o['pid']) {
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
    }
    if ($pay_amount == 0) {
      $pay_amount = $o['goods_amount'];
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
        'win_type' => '小彩金',
        'order_id' => $o['pid'],
        'createtime' => time()
      );
    }
  }
  if ($total_amount < 200) {
    $total_amount = 200;
  }
  if (!empty($win_order)) {
    foreach ($win_order as $val) {
      $has = pdo_fetchcolumn('select count(1) from '.tablename('manji_jackpot_log').' where order_id=:id and period_id=:pid',array(':id'=>$val['order_id'],':pid'=>$val['period_id']));
      if ($has > 0) {
        continue;
      }
      $win_money = ($val['bet_money']/$total_amount)*$jackpot;
      $cal_money += $val['win_money'] = $win_money;
      pdo_insert('manji_jackpot_log',$val);
      pdo_query('update '.tablename('member_system_member').' set credit1=credit1+'.$win_money.' where id='.$val['user_id']);
    }
  }
  if ($cal_money > 0) {
    pdo_query('update '.tablename('manji_jackpot').' set small_jackpot=small_jackpot-'.$cal_money);
  }
}

function check_jackpot()
{
  $jackpot = pdo_fetch('select * from '.tablename('manji_jackpot'));
  $sql = '';
  if ($jackpot['big_jackpot'] < 100000) {
    $sql .= 'update '.tablename('manji_jackpot').' set big_jackpot=100000;';
  }
  if ($jackpot['middle_jackpot'] < 30000) {
    $sql .= 'update '.tablename('manji_jackpot').' set middle_jackpot=30000;';
  }
  if ($jackpot['small_jackpot'] < 10000) {
    $sql .= 'update '.tablename('manji_jackpot').' set small_jackpot=10000;';
  }
  if ($sql != '') {
    pdo_query($sql);
  }
}

function total_big_jackpot($date)
{
  $periods = pdo_fetchColumnValue('select id from '.tablename('manji_run_setting').' where date=:date',array(':date'=>$date),'id');
  $period_fields = implode(',',$periods);
  $winner = pdo_fetchColumnValue('select member_id from '.tablename('manji_reward_log').' where period_id in ('.$period_fields.') and number_type<=3',array(),'member_id');
  $win_order = pdo_fetchColumnValue('select order_id from '.tablename('manji_reward_log').' where period_id in ('.$period_fields.') and number_type<=3',array(),'order_id');
  if (!empty($win_order)) {
    $order_fields = implode(',', $win_order);
    $total_amount = pdo_fetchcolumn('select sum(order_amount) from '.tablename('manji_order').' where id in ('.$order_fields.')');
  }
  $jackpot = pdo_fetchcolumn('select big_jackpot from '.tablename('manji_total_jackpot'));
  $winner = array_unique($winner);
  foreach ($periods as $period) {
    foreach ($winner as $key => $value) {
      $win_number = pdo_fetchColumnValue('select bet_number from '.tablename('manji_reward_log').' where period_id=:period and member_id=:member and number_type<=3',array(':period'=>$period,':member'=>$value),'bet_number');
      $order = pdo_fetchall('select pid,number,order_amount,mode from '.tablename('manji_order').' where period_id like \'%('.$period.')%\' and user_id=:user_id',array(':user_id'=>$value));
      if (!empty($order)) {
        foreach ($order as $v) {
          $new_order[$v['pid']][] = $v;
        }
        foreach ($new_order as $k => $o) {
          foreach ($o as $l => $n) {
            $win_money = 0;
            if ($o[$l+1]['number'] > 0) {
              $partner = $o[$l+1]['number'];
            }
            else{
              $partner = random_number();
            }
            if (in_array($n['number'],$win_number) && in_array($partner,$win_number)) {
              $order_amount = $n['order_amount'] + $o[$l+1]['order_amount'];
              $number_team = $n['number'].'-'.$partner;
              $win_money = $order_amount/$total_amount*$jackpot;
              if ($order_amount < 2) {
                $new_money = $order_amount/2*$jackpot;
                $win_money = min(array($new_money,$win_money));
              }
              $save = array(
                'date' => $date,
                'number_team' => $number_team,
                'user_id' => $value,
                'win_money' => $win_money,
                'win_type' => '大彩金',
                'order_id' => $k,
                'createtime' => time()
              );
              pdo_delete('manji_total_jackpot_log',array('date'=>$date));
              pdo_insert('manji_total_jackpot_log',$save);
            }
          }
        }
      }
    }
  }
}

function total_middle_jackpot($date)
{
  $periods = pdo_fetchColumnValue('select id from '.tablename('manji_run_setting').' where date=:date',array(':date'=>$date),'id');
  $period_fields = implode(',',$periods);
  $winner = pdo_fetchColumnValue('select member_id from '.tablename('manji_reward_log').' where period_id in ('.$period_fields.') and number_type<=5',array(),'member_id');
  $win_order = pdo_fetchColumnValue('select order_id from '.tablename('manji_reward_log').' where period_id in ('.$period_fields.') and number_type<=5',array(),'order_id');
  if (!empty($win_order)) {
    $order_fields = implode(',', $win_order);
    $total_amount = pdo_fetchcolumn('select sum(order_amount) from '.tablename('manji_order').' where id in ('.$order_fields.')');
  }
  $jackpot = pdo_fetchcolumn('select middle_jackpot from '.tablename('manji_jackpot'));
  $winner = array_unique($winner);
  foreach ($periods as $period) {
    foreach ($winner as $key => $value) {
      $win_number = pdo_fetchColumnValue('select bet_number from '.tablename('manji_reward_log').' where period_id=:period and member_id=:member and number_type<=3',array(':period'=>$period,':member'=>$value),'bet_number');
      $win_number2 = pdo_fetchColumnValue('select bet_number from '.tablename('manji_reward_log').' where period_id=:period and member_id=:member and number_type between 4 and 5',array(':period'=>$period,':member'=>$value),'bet_number');
      $order = pdo_fetchall('select pid,number,order_amount,mode from '.tablename('manji_order').' where period_id like \'%('.$period.')%\' and user_id=:user_id',array(':user_id'=>$value));
      if (!empty($order)) {
        foreach ($order as $v) {
          $new_order[$v['pid']][] = $v;
        }
        foreach ($new_order as $k => $o) {
          foreach ($o as $l => $n) {
            $win_money = 0;
            if ($o[$l+1]['number'] > 0) {
              $partner = $o[$l+1]['number'];
            }
            else{
              $partner = random_number();
            }
            if ((in_array($n['number'],$win_number) && in_array($partner,$win_number2)) || (in_array($n['number'],$win_number2) && in_array($partner,$win_number))) {
              $order_amount = $n['order_amount'] + $o[$l+1]['order_amount'];
              $number_team = $n['number'].'-'.$partner;
              $win_money = $order_amount/$total_amount*$jackpot;
              if ($order_amount < 2) {
                $new_money = $order_amount/2*$jackpot;
                $win_money = min(array($new_money,$win_money));
              }
              $save = array(
                'date' => $date,
                'number_team' => $number_team,
                'user_id' => $value,
                'win_money' => $win_money,
                'win_type' => '中彩金',
                'order_id' => $k,
                'createtime' => time()
              );
              pdo_delete('manji_total_jackpot_log',array('date'=>$date));
              pdo_insert('manji_total_jackpot_log',$save);
            }
          }
        }
      }
    }
  }
}

function total_small_jackpot($date)
{
  $periods = pdo_fetchColumnValue('select id from '.tablename('manji_run_setting').' where date=:date',array(':date'=>$date),'id');
  $period_fields = implode(',',$periods);
  $winner = pdo_fetchColumnValue('select member_id from '.tablename('manji_reward_log').' where period_id in ('.$period_fields.') and number_type between 4 and 5',array(),'member_id');
  $win_order = pdo_fetchColumnValue('select order_id from '.tablename('manji_reward_log').' where period_id in ('.$period_fields.') and number_type between 4 and 5',array(),'order_id');
  if (!empty($win_order)) {
    $order_fields = implode(',', $win_order);
    $total_amount = pdo_fetchcolumn('select sum(order_amount) from '.tablename('manji_order').' where id in ('.$order_fields.')');
  }
  $jackpot = pdo_fetchcolumn('select small_jackpot from '.tablename('manji_jackpot'));
  $winner = array_unique($winner);
  foreach ($periods as $period) {
    foreach ($winner as $key => $value) {
      $win_number = pdo_fetchColumnValue('select bet_number from '.tablename('manji_reward_log').' where period_id=:period and member_id=:member and number_type between 4 and 5',array(':period'=>$period,':member'=>$value),'bet_number');
      $order = pdo_fetchall('select pid,number,order_amount,mode from '.tablename('manji_order').' where period_id like \'%('.$period.')%\' and user_id=:user_id',array(':user_id'=>$value));
      if (!empty($order)) {
        foreach ($order as $v) {
          $new_order[$v['pid']][] = $v;
        }
        foreach ($new_order as $k => $o) {
          foreach ($o as $l => $n) {
            $win_money = 0;
            if ($o[$l+1]['number'] > 0) {
              $partner = $o[$l+1]['number'];
            }
            else{
              $partner = random_number();
            }
            if (in_array($n['number'],$win_number) && in_array($partner,$win_number)) {
              $order_amount = $n['order_amount'] + $o[$l+1]['order_amount'];
              $number_team = $n['number'].'-'.$partner;
              $win_money = $order_amount/$total_amount*$jackpot;
              if ($order_amount < 2) {
                $new_money = $order_amount/2*$jackpot;
                $win_money = min(array($new_money,$win_money));
              }
              $save = array(
                'date' => $date,
                'number_team' => $number_team,
                'user_id' => $value,
                'win_money' => $win_money,
                'win_type' => '大彩金',
                'order_id' => $k,
                'createtime' => time()
              );
              pdo_delete('manji_total_jackpot_log',array('date'=>$date));
              pdo_insert('manji_total_jackpot_log',$save);
            }
          }
        }
      }
    }
  }
}

function compare_user_red($limit,$rule,$amount=0)
{
  foreach ($limit as $lim) {
    $item = json_decode($lim,true);
    if ($item[$rule] >= 0 && $item[$rule] != '') {
      $mount[] = min($amount,$item[$rule]);
    }
    else{
      $mount[] = $amount;
    }
  }
  return min($mount);
}

function compare_system_red($number,$company,$limit,$rule,$amount=0,$extra=0,$period_id)
{
  $order_amount = pdo_fetchcolumn('select sum(pay_'.$rule.') from '.tablename('manji_order_detail').' where period_id like :period and number=:number',array(':period'=>'%('.$period_id.')%',':number'=>$number));
  $limit = json_decode($limit,true);
  if ($limit[$company][$rule]>=0 && $limit[$company][$rule] !=0) {
    $surplus = $limit[$company][$rule] - $order_amount - $extra;
    if ($surplus > 0) {
      $mount = min($amount,$surplus);
    }
    else{
      $mount = 0;
    }
  }
  else{
    $mount = $amount;
  }
  return $mount;
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

function compare_system($time_limit,$rule,$company,$amount=0,$extra=0)
{
  if ($time_limit > 0) {
    $number_limit = pdo_fetchcolumn('select `limit` from '.tablename('manji_limit').' where id=:id',array(':id'=>$time_limit));
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

