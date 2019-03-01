<?php 
function cal_4A($period_id, $period_number, $winning_num, $winner_number_type,$number_type ){
		//锁表
		$sql = "LOCK TABLE ".tablename('manji_order'). " WRITE,".tablename('member_system_member')." WRITE,".tablename('agent_member')." WRITE,"
            .tablename('manji_reward_log')." WRITE,".tablename('agent_odds')." WRITE;";
		pdo_run($sql);
	
		//找到这一期里的所有获胜方, B 他下注了
	   $winner1 = pdo_fetchall('select id, user_id,pay_4A  from '.tablename('manji_order').
           ' where period_id=:period_id and number=:number and pay_4A>0',array(':period_id'=>$period_id,':number'=>$winning_num));
 
 		$total_winner_money = 0;  //总共赔的钱
 		//给他加钱了
        foreach ($winner1 as $win1){
			//找到这个人的代理人，获取代理人的陪率
			$member = pdo_fetch("select id, nickname,parent_agent,credit1  from ".tablename('member_system_member'). '  where id='. $win1['user_id']   );
			if( empty($member) ){
				continue;  //没有代理，数据 出错
			}
			
			//代理人
			$agent = pdo_fetch("select * from ".tablename('agent_member'). '  where id='. $member['parent_agent']   );
			if( empty($agent) ){
				continue;  //没有代理，数据 出错
			}
			
			$agent_adds = pdo_fetch("select * from ".tablename('agent_odds'). '  where agent_id='. $member['parent_agent']   );
			if( empty($agent_adds) ){
				continue; //没有代理，数据 出错
			}
			

            //获取当前赔率
            $4A_odds =  $agent_adds['odds_4A'];
			//给他奖的钱
			$winner_money = $win1['pay_4A'] * $4A_odds;
			$total_winner_money+= $winner_money;
			//保存单条记录
			$res = pdo_query('update ims_manji_order  set result_4A = result_4A + :money where id=:id',array(':money'=>$winner_money,':id'=>$win1['id']));
			
			//保存
		//	$res = pdo_update('member_system_member',array('credit1'=>$member['credit1'] + $winner_money ),array('id'=>$win1['user_id'] ));
			$res = pdo_query('update ims_member_system_member  set credit1 = credit1 + :money where id=:id',array(':money'=>$winner_money,':id'=>$member['id']));
	
			//保存个人记录
			$member_new_money = ((int)($member['credit1'] * 10  + $winner_money *10)) / 10 ;
			winning_log($period_id, $period_number,$member['id'], $member['nickname'], $member['credit1'], $member_new_money,
                $winning_num, $win1['pay_4A'], $winner_number_type, $winner_money, $4A_odds, '4A', $member['parent_agent'],  $agent['nickname'],$number_type );
			
			
              //pdo_insert('manji_winner',array('type'=>1,'user_id'=>$win1['user_id'],'lottery_number'=>$first_no,'period_id'=>$period_id));
        }
		
		pdo_run('UNLOCK TABLES;'); //解锁
		
		return $total_winner_money;

}

function cal_4B($period_id, $period_number, $winning_num, $winner_number_type,$number_type ){
		//锁表
		$sql = "LOCK TABLE ".tablename('manji_order'). " WRITE,".tablename('member_system_member')." WRITE,".tablename('agent_member')." WRITE,"
            .tablename('manji_reward_log')." WRITE,".tablename('agent_odds')." WRITE;";
		pdo_run($sql);
	
		//找到这一期里的所有获胜方, B 他下注了
	   $winner1 = pdo_fetchall('select id, user_id,pay_4B  from '.tablename('manji_order').
           ' where period_id=:period_id and number=:number and pay_4B>0',array(':period_id'=>$period_id,':number'=>$winning_num));
 
 		$total_winner_money = 0;  //总共赔的钱
 		//给他加钱了
        foreach ($winner1 as $win1){
			//找到这个人的代理人，获取代理人的陪率
			$member = pdo_fetch("select id, nickname,parent_agent,credit1  from ".tablename('member_system_member'). '  where id='. $win1['user_id']   );
			if( empty($member) ){
				continue;  //没有代理，数据 出错
			}
			
			//代理人
			$agent = pdo_fetch("select * from ".tablename('agent_member'). '  where id='. $member['parent_agent']   );
			if( empty($agent) ){
				continue;  //没有代理，数据 出错
			}
			
			$agent_adds = pdo_fetch("select * from ".tablename('agent_odds'). '  where agent_id='. $member['parent_agent']   );
			if( empty($agent_adds) ){
				continue; //没有代理，数据 出错
			}
			

            //获取当前赔率
            $4B_odds =  $agent_adds['odds_4B'];
			//给他奖的钱
			$winner_money = $win1['pay_4B'] * $4B_odds;
			$total_winner_money+= $winner_money;
			//保存单条记录
			$res = pdo_query('update ims_manji_order  set result_4B = result_4B + :money where id=:id',array(':money'=>$winner_money,':id'=>$win1['id']));
			
			//保存
		//	$res = pdo_update('member_system_member',array('credit1'=>$member['credit1'] + $winner_money ),array('id'=>$win1['user_id'] ));
			$res = pdo_query('update ims_member_system_member  set credit1 = credit1 + :money where id=:id',array(':money'=>$winner_money,':id'=>$member['id']));
	
			//保存个人记录
			$member_new_money = ((int)($member['credit1'] * 10  + $winner_money *10)) / 10 ;
			winning_log($period_id, $period_number,$member['id'], $member['nickname'], $member['credit1'], $member_new_money,
                $winning_num, $win1['pay_4B'], $winner_number_type, $winner_money, $4B_odds, '4B', $member['parent_agent'],  $agent['nickname'],$number_type );
			
			
              //pdo_insert('manji_winner',array('type'=>1,'user_id'=>$win1['user_id'],'lottery_number'=>$first_no,'period_id'=>$period_id));
        }
		
		pdo_run('UNLOCK TABLES;'); //解锁
		
		return $total_winner_money;

}

function cal_4C($period_id, $period_number, $winning_num, $winner_number_type,$number_type ){
		//锁表
		$sql = "LOCK TABLE ".tablename('manji_order'). " WRITE,".tablename('member_system_member')." WRITE,".tablename('agent_member')." WRITE,"
            .tablename('manji_reward_log')." WRITE,".tablename('agent_odds')." WRITE;";
		pdo_run($sql);
	
		//找到这一期里的所有获胜方, B 他下注了
	   $winner1 = pdo_fetchall('select id, user_id,pay_4C  from '.tablename('manji_order').
           ' where period_id=:period_id and number=:number and pay_4C>0',array(':period_id'=>$period_id,':number'=>$winning_num));
 
 		$total_winner_money = 0;  //总共赔的钱
 		//给他加钱了
        foreach ($winner1 as $win1){
			//找到这个人的代理人，获取代理人的陪率
			$member = pdo_fetch("select id, nickname,parent_agent,credit1  from ".tablename('member_system_member'). '  where id='. $win1['user_id']   );
			if( empty($member) ){
				continue;  //没有代理，数据 出错
			}
			
			//代理人
			$agent = pdo_fetch("select * from ".tablename('agent_member'). '  where id='. $member['parent_agent']   );
			if( empty($agent) ){
				continue;  //没有代理，数据 出错
			}
			
			$agent_adds = pdo_fetch("select * from ".tablename('agent_odds'). '  where agent_id='. $member['parent_agent']   );
			if( empty($agent_adds) ){
				continue; //没有代理，数据 出错
			}
			

            //获取当前赔率
            $4C_odds =  $agent_adds['odds_4C'];
			//给他奖的钱
			$winner_money = $win1['pay_4C'] * $4C_odds;
			$total_winner_money+= $winner_money;
			//保存单条记录
			$res = pdo_query('update ims_manji_order  set result_4C = result_4C + :money where id=:id',array(':money'=>$winner_money,':id'=>$win1['id']));
			
			//保存
		//	$res = pdo_update('member_system_member',array('credit1'=>$member['credit1'] + $winner_money ),array('id'=>$win1['user_id'] ));
			$res = pdo_query('update ims_member_system_member  set credit1 = credit1 + :money where id=:id',array(':money'=>$winner_money,':id'=>$member['id']));
	
			//保存个人记录
			$member_new_money = ((int)($member['credit1'] * 10  + $winner_money *10)) / 10 ;
			winning_log($period_id, $period_number,$member['id'], $member['nickname'], $member['credit1'], $member_new_money,
                $winning_num, $win1['pay_4C'], $winner_number_type, $winner_money, $4C_odds, '4C', $member['parent_agent'],  $agent['nickname'],$number_type );
			
			
              //pdo_insert('manji_winner',array('type'=>1,'user_id'=>$win1['user_id'],'lottery_number'=>$first_no,'period_id'=>$period_id));
        }
		
		pdo_run('UNLOCK TABLES;'); //解锁
		
		return $total_winner_money;

}

function cal_4D($period_id, $period_number, $winning_num, $winner_number_type,$number_type ){
		//锁表
		$sql = "LOCK TABLE ".tablename('manji_order'). " WRITE,".tablename('member_system_member')." WRITE,".tablename('agent_member')." WRITE,"
            .tablename('manji_reward_log')." WRITE,".tablename('agent_odds')." WRITE;";
		pdo_run($sql);
	
		//找到这一期里的所有获胜方, B 他下注了
	   $winner1 = pdo_fetchall('select id, user_id,pay_4D  from '.tablename('manji_order').
           ' where period_id=:period_id and number=:number and pay_4D>0',array(':period_id'=>$period_id,':number'=>$winning_num));
 
 		$total_winner_money = 0;  //总共赔的钱
 		//给他加钱了
        foreach ($winner1 as $win1){
			//找到这个人的代理人，获取代理人的陪率
			$member = pdo_fetch("select id, nickname,parent_agent,credit1  from ".tablename('member_system_member'). '  where id='. $win1['user_id']   );
			if( empty($member) ){
				continue;  //没有代理，数据 出错
			}
			
			//代理人
			$agent = pdo_fetch("select * from ".tablename('agent_member'). '  where id='. $member['parent_agent']   );
			if( empty($agent) ){
				continue;  //没有代理，数据 出错
			}
			
			$agent_adds = pdo_fetch("select * from ".tablename('agent_odds'). '  where agent_id='. $member['parent_agent']   );
			if( empty($agent_adds) ){
				continue; //没有代理，数据 出错
			}
			

            //获取当前赔率
            $4D_odds =  $agent_adds['odds_4D'];
			//给他奖的钱
			$winner_money = $win1['pay_4D'] * $4D_odds;
			$total_winner_money+= $winner_money;
			//保存单条记录
			$res = pdo_query('update ims_manji_order  set result_4D = result_4D + :money where id=:id',array(':money'=>$winner_money,':id'=>$win1['id']));
			
			//保存
		//	$res = pdo_update('member_system_member',array('credit1'=>$member['credit1'] + $winner_money ),array('id'=>$win1['user_id'] ));
			$res = pdo_query('update ims_member_system_member  set credit1 = credit1 + :money where id=:id',array(':money'=>$winner_money,':id'=>$member['id']));
	
			//保存个人记录
			$member_new_money = ((int)($member['credit1'] * 10  + $winner_money *10)) / 10 ;
			winning_log($period_id, $period_number,$member['id'], $member['nickname'], $member['credit1'], $member_new_money,
                $winning_num, $win1['pay_4D'], $winner_number_type, $winner_money, $4D_odds, '4D', $member['parent_agent'],  $agent['nickname'],$number_type );
			
			
              //pdo_insert('manji_winner',array('type'=>1,'user_id'=>$win1['user_id'],'lottery_number'=>$first_no,'period_id'=>$period_id));
        }
		
		pdo_run('UNLOCK TABLES;'); //解锁
		
		return $total_winner_money;

}

function cal_4E($period_id, $period_number, $winning_num, $winner_number_type,$number_type ){
		//锁表
		$sql = "LOCK TABLE ".tablename('manji_order'). " WRITE,".tablename('member_system_member')." WRITE,".tablename('agent_member')." WRITE,"
            .tablename('manji_reward_log')." WRITE,".tablename('agent_odds')." WRITE;";
		pdo_run($sql);
	
		//找到这一期里的所有获胜方, B 他下注了
	   $winner1 = pdo_fetchall('select id, user_id,pay_4E  from '.tablename('manji_order').
           ' where period_id=:period_id and number=:number and pay_4E>0',array(':period_id'=>$period_id,':number'=>$winning_num));
 
 		$total_winner_money = 0;  //总共赔的钱
 		//给他加钱了
        foreach ($winner1 as $win1){
			//找到这个人的代理人，获取代理人的陪率
			$member = pdo_fetch("select id, nickname,parent_agent,credit1  from ".tablename('member_system_member'). '  where id='. $win1['user_id']   );
			if( empty($member) ){
				continue;  //没有代理，数据 出错
			}
			
			//代理人
			$agent = pdo_fetch("select * from ".tablename('agent_member'). '  where id='. $member['parent_agent']   );
			if( empty($agent) ){
				continue;  //没有代理，数据 出错
			}
			
			$agent_adds = pdo_fetch("select * from ".tablename('agent_odds'). '  where agent_id='. $member['parent_agent']   );
			if( empty($agent_adds) ){
				continue; //没有代理，数据 出错
			}
			

            //获取当前赔率
            $4E_odds =  $agent_adds['odds_4E'];
			//给他奖的钱
			$winner_money = $win1['pay_4E'] * $4E_odds;
			$total_winner_money+= $winner_money;
			//保存单条记录
			$res = pdo_query('update ims_manji_order  set result_4E = result_4E + :money where id=:id',array(':money'=>$winner_money,':id'=>$win1['id']));
			
			//保存
		//	$res = pdo_update('member_system_member',array('credit1'=>$member['credit1'] + $winner_money ),array('id'=>$win1['user_id'] ));
			$res = pdo_query('update ims_member_system_member  set credit1 = credit1 + :money where id=:id',array(':money'=>$winner_money,':id'=>$member['id']));
	
			//保存个人记录
			$member_new_money = ((int)($member['credit1'] * 10  + $winner_money *10)) / 10 ;
			winning_log($period_id, $period_number,$member['id'], $member['nickname'], $member['credit1'], $member_new_money,
                $winning_num, $win1['pay_4E'], $winner_number_type, $winner_money, $4E_odds, '4E', $member['parent_agent'],  $agent['nickname'],$number_type );
			
			
              //pdo_insert('manji_winner',array('type'=>1,'user_id'=>$win1['user_id'],'lottery_number'=>$first_no,'period_id'=>$period_id));
        }
		
		pdo_run('UNLOCK TABLES;'); //解锁
		
		return $total_winner_money;

}

function cal_B($period_id, $period_number, $winning_num, $winner_number_type,$number_type ){
	
		//锁表
		$sql = "LOCK TABLE ".tablename('manji_order'). " WRITE,".tablename('member_system_member')
            ." WRITE,".tablename('agent_member')." WRITE,".tablename('manji_reward_log')." WRITE,".tablename('agent_odds')." WRITE;";
		pdo_run($sql);
	
		//找到这一期里的所有获胜方, B 他下注了
	   $winner1 = pdo_fetchall('select id, user_id,pay_B  from '.tablename('manji_order').
           ' where period_id=:period_id and number=:number and pay_B>0',array(':period_id'=>$period_id,':number'=>$winning_num));
 
 		$total_winner_money = 0;  //总共赔的钱
 		//给他加钱了
        foreach ($winner1 as $win1){
			//找到这个人的代理人，获取代理人的陪率
			$member = pdo_fetch("select id, nickname,parent_agent,credit1  from ".tablename('member_system_member'). '  where id='. $win1['user_id']   );
			if( empty($member) ){
				continue;  //没有代理，数据 出错
			}
			
			//代理人
			$agent = pdo_fetch("select * from ".tablename('agent_member'). '  where id='. $member['parent_agent']   );
			if( empty($agent) ){
				continue;  //没有代理，数据 出错
			}
			
			$agent_adds = pdo_fetch("select * from ".tablename('agent_odds'). '  where agent_id='. $member['parent_agent']   );
			if( empty($agent_adds) ){
				continue; //没有代理，数据 出错
			}
            //获取当前赔率
			$odds_arr = explode('|',$agent_adds['odds_B']);
			if($number_type==1){
                $b4_odds = $odds_arr[0];
            }
            if($number_type==2){
                $b4_odds = $odds_arr[1];
            }
            if($number_type==3){
                $b4_odds = $odds_arr[2];
            }
            if($number_type==4){
                $b4_odds = $odds_arr[3];
            }
            if($number_type==5){
                $b4_odds = $odds_arr[4];
            }



			//给他奖的钱
			$winner_money = $win1['pay_B'] * $b4_odds;
			$total_winner_money+= $winner_money;
			
		
			//保存单条记录
			$res = pdo_query('update ims_manji_order  set result_B = result_B + :money where id=:id',array(':money'=>$winner_money,':id'=>$win1['id']));
	
		//保存
		//	$res = pdo_update('member_system_member',array('credit1'=>$member['credit1'] + $winner_money ),array('id'=>$win1['user_id'] ));
			$res = pdo_query('update ims_member_system_member  set credit1 = credit1 + :money where id=:id',array(':money'=>$winner_money,':id'=>$member['id']));
	
			//保存个人记录
			$member_new_money = ((int)($member['credit1'] * 10  + $winner_money *10)) / 10 ;
			winning_log($period_id, $period_number,$member['id'], $member['nickname'], $member['credit1'], $member_new_money,
                $winning_num, $win1['pay_B'],$winner_number_type, $winner_money, $b4_odds, 'B', $member['parent_agent'],  $agent['nickname'],$number_type );
			
              //pdo_insert('manji_winner',array('type'=>1,'user_id'=>$win1['user_id'],'lottery_number'=>$first_no,'period_id'=>$period_id));
        }
		
		pdo_run('UNLOCK TABLES;'); //解锁
		
		return $total_winner_money;
}

function cal_S($period_id, $period_number, $winning_num, $winner_number_type ,$number_type ){
		//锁表
		$sql = "LOCK TABLE ".tablename('manji_order'). " WRITE,".tablename('member_system_member')." WRITE,".tablename('agent_member')." WRITE,"
            .tablename('manji_reward_log')." WRITE,".tablename('agent_odds')." WRITE;";
		pdo_run($sql);
	
		//找到这一期里的所有获胜方, B 他下注了
	   $winner1 = pdo_fetchall('select id, user_id,pay_S  from '.tablename('manji_order'). ' where period_id=:period_id and number=:number and pay_S>0',
           array(':period_id'=>$period_id,':number'=>$winning_num));
 
 		$total_winner_money = 0;  //总共赔的钱
 		//给他加钱了
        foreach ($winner1 as $win1){
			//找到这个人的代理人，获取代理人的陪率
			$member = pdo_fetch("select id, nickname,parent_agent,credit1  from ".tablename('member_system_member'). '  where id='. $win1['user_id']   );
			if( empty($member) ){
				continue;  //没有代理，数据 出错
			}
			
			//代理人
			$agent = pdo_fetch("select * from ".tablename('agent_member'). '  where id='. $member['parent_agent']   );
			if( empty($agent) ){
				continue;  //没有代理，数据 出错
			}
			
			$agent_adds = pdo_fetch("select * from ".tablename('agent_odds'). '  where agent_id='. $member['parent_agent']   );
			if( empty($agent_adds) ){
				continue; //没有代理，数据 出错
			}
			

            //获取当前赔率
            $odds_arr = explode('|',$agent_adds['odds_S']);
            if($number_type==1){
                $s4_odds = $odds_arr[0];
            }
            if($number_type==2){
                $s4_odds = $odds_arr[1];
            }
            if($number_type==3){
                $s4_odds = $odds_arr[2];
            }

			
			
			//给他奖的钱
			$winner_money = $win1['pay_S'] * $s4_odds;
			
			$total_winner_money+= $winner_money;
			
			//保存
			$res = pdo_query('update ims_member_system_member  set credit1 = credit1 + :money where id=:id',array(':money'=>$winner_money,':id'=>$member['id']));
	
			//保存单条记录
			$res = pdo_query('update ims_manji_order  set result_S = result_S + :money where id=:id',array(':money'=>$winner_money,':id'=>$win1['id']));
	
		
			//保存个人记录
			$member_new_money = ((int)($member['credit1'] * 10  + $winner_money *10)) / 10 ;
			winning_log($period_id, $period_number,$member['id'], $member['nickname'], $member['credit1'], $member_new_money,$winning_num,
                $win1['pay_S'], $winner_number_type, $winner_money, $s4_odds, 'S', $member['parent_agent'],  $agent['nickname'],$number_type );
			
			
              //pdo_insert('manji_winner',array('type'=>1,'user_id'=>$win1['user_id'],'lottery_number'=>$first_no,'period_id'=>$period_id));
        }
		
		pdo_run('UNLOCK TABLES;'); //解锁
		
		return $total_winner_money;

}

function cal_A($period_id, $period_number, $winning_num, $winner_number_type ,$number_type){
		//锁表
		$sql = "LOCK TABLE ".tablename('manji_order'). " WRITE,".tablename('member_system_member')." WRITE,".
            tablename('agent_member')." WRITE,".tablename('manji_reward_log')." WRITE,".tablename('agent_odds')." WRITE;";
		pdo_run($sql);
	
		//找到这一期里的所有获胜方, B 他下注了
	   $winner1 = pdo_fetchall('select id, user_id,pay_A  from '.tablename('manji_order').
           ' where period_id=:period_id and substr(number,length(number)-2,3)=:number and pay_A>0',array(':period_id'=>$period_id,':number'=> substr($winning_num,-3) ));
 
 		$total_winner_money = 0;  //总共赔的钱
 		//给他加钱了
        foreach ($winner1 as $win1){
			//找到这个人的代理人，获取代理人的陪率
			$member = pdo_fetch("select id, nickname,parent_agent,credit1  from ".tablename('member_system_member'). '  where id='. $win1['user_id']   );
			if( empty($member) ){
				continue;  //没有代理，数据 出错
			}
			
			//代理人
			$agent = pdo_fetch("select * from ".tablename('agent_member'). '  where id='. $member['parent_agent']   );
			if( empty($agent) ){
				continue;  //没有代理，数据 出错
			}
			
			
			$agent_adds = pdo_fetch("select * from ".tablename('agent_odds'). '  where agent_id='. $member['parent_agent']   );
			if( empty($agent_adds) ){
				continue; //没有代理，数据 出错
			}
			
			//获取当前赔率
			$A_odds = $agent_adds['odds_A'];
			
			
			//给他奖的钱
			$winner_money = $win1['pay_A'] * $A_odds;
			
			$total_winner_money+= $winner_money;
			
			//保存
			$res = pdo_query('update ims_member_system_member  set credit1 = credit1 + :money where id=:id',array(':money'=>$winner_money,':id'=>$member['id']));
	
			//保存单条记录
			$res = pdo_query('update ims_manji_order  set result_A = result_A + :money where id=:id',array(':money'=>$winner_money,':id'=>$win1['id']));
	

			//保存个人记录
			$member_new_money = ((int)($member['credit1'] * 10  + $winner_money *10)) / 10 ;
			winning_log($period_id, $period_number,$member['id'], $member['nickname'], $member['credit1'], $member_new_money,$winning_num, $win1['pay_A'],
                $winner_number_type, $winner_money, $A_odds, 'A', $member['parent_agent'],  $agent['nickname'] ,$number_type);
			
              //pdo_insert('manji_winner',array('type'=>1,'user_id'=>$win1['user_id'],'lottery_number'=>$first_no,'period_id'=>$period_id));
        }
		
		pdo_run('UNLOCK TABLES;'); //解锁
		
		return $total_winner_money;

}

function cal_C2($period_id, $period_number, $winning_num, $winner_number_type ,$number_type){
		//锁表
		$sql = "LOCK TABLE ".tablename('manji_order'). " WRITE,".tablename('member_system_member')." WRITE,".
            tablename('agent_member')." WRITE,".tablename('manji_reward_log')." WRITE,".tablename('agent_odds')." WRITE;";
		pdo_run($sql);
	
		//找到这一期里的所有获胜方, B 他下注了
	   $winner1 = pdo_fetchall('select id, user_id,pay_C2  from '.tablename('manji_order').
           ' where period_id=:period_id and substr(number,length(number)-2,3)=:number and pay_C2>0',array(':period_id'=>$period_id,':number'=> substr($winning_num,-3) ));
 
 		$total_winner_money = 0;  //总共赔的钱
 		//给他加钱了
        foreach ($winner1 as $win1){
			//找到这个人的代理人，获取代理人的陪率
			$member = pdo_fetch("select id, nickname,parent_agent,credit1  from ".tablename('member_system_member'). '  where id='. $win1['user_id']   );
			if( empty($member) ){
				continue;  //没有代理，数据 出错
			}
			
			//代理人
			$agent = pdo_fetch("select * from ".tablename('agent_member'). '  where id='. $member['parent_agent']   );
			if( empty($agent) ){
				continue;  //没有代理，数据 出错
			}
			
			
			$agent_adds = pdo_fetch("select * from ".tablename('agent_odds'). '  where agent_id='. $member['parent_agent']   );
			if( empty($agent_adds) ){
				continue; //没有代理，数据 出错
			}
			
			//获取当前赔率
			$A_odds = $agent_adds['odds_C2'];
			
			
			//给他奖的钱
			$winner_money = $win1['pay_C2'] * $A_odds;
			
			$total_winner_money+= $winner_money;
			
			//保存
			$res = pdo_query('update ims_member_system_member  set credit1 = credit1 + :money where id=:id',array(':money'=>$winner_money,':id'=>$member['id']));
	
			//保存单条记录
			$res = pdo_query('update ims_manji_order  set result_C2 = result_C2 + :money where id=:id',array(':money'=>$winner_money,':id'=>$win1['id']));
	

			//保存个人记录
			$member_new_money = ((int)($member['credit1'] * 10  + $winner_money *10)) / 10 ;
			winning_log($period_id, $period_number,$member['id'], $member['nickname'], $member['credit1'], $member_new_money,$winning_num, $win1['pay_C2'],
                $winner_number_type, $winner_money, $A_odds, 'C2', $member['parent_agent'],  $agent['nickname'] ,$number_type);
			
              //pdo_insert('manji_winner',array('type'=>1,'user_id'=>$win1['user_id'],'lottery_number'=>$first_no,'period_id'=>$period_id));
        }
		
		pdo_run('UNLOCK TABLES;'); //解锁
		
		return $total_winner_money;

}

function cal_C3($period_id, $period_number, $winning_num, $winner_number_type ,$number_type){
		//锁表
		$sql = "LOCK TABLE ".tablename('manji_order'). " WRITE,".tablename('member_system_member')." WRITE,".
            tablename('agent_member')." WRITE,".tablename('manji_reward_log')." WRITE,".tablename('agent_odds')." WRITE;";
		pdo_run($sql);
	
		//找到这一期里的所有获胜方, B 他下注了
	   $winner1 = pdo_fetchall('select id, user_id,pay_C3  from '.tablename('manji_order').
           ' where period_id=:period_id and substr(number,length(number)-2,3)=:number and pay_C3>0',array(':period_id'=>$period_id,':number'=> substr($winning_num,-3) ));
 
 		$total_winner_money = 0;  //总共赔的钱
 		//给他加钱了
        foreach ($winner1 as $win1){
			//找到这个人的代理人，获取代理人的陪率
			$member = pdo_fetch("select id, nickname,parent_agent,credit1  from ".tablename('member_system_member'). '  where id='. $win1['user_id']   );
			if( empty($member) ){
				continue;  //没有代理，数据 出错
			}
			
			//代理人
			$agent = pdo_fetch("select * from ".tablename('agent_member'). '  where id='. $member['parent_agent']   );
			if( empty($agent) ){
				continue;  //没有代理，数据 出错
			}
			
			
			$agent_adds = pdo_fetch("select * from ".tablename('agent_odds'). '  where agent_id='. $member['parent_agent']   );
			if( empty($agent_adds) ){
				continue; //没有代理，数据 出错
			}
			
			//获取当前赔率
			$A_odds = $agent_adds['odds_C3'];
			
			
			//给他奖的钱
			$winner_money = $win1['pay_C3'] * $A_odds;
			
			$total_winner_money+= $winner_money;
			
			//保存
			$res = pdo_query('update ims_member_system_member  set credit1 = credit1 + :money where id=:id',array(':money'=>$winner_money,':id'=>$member['id']));
	
			//保存单条记录
			$res = pdo_query('update ims_manji_order  set result_C3 = result_C3 + :money where id=:id',array(':money'=>$winner_money,':id'=>$win1['id']));
	

			//保存个人记录
			$member_new_money = ((int)($member['credit1'] * 10  + $winner_money *10)) / 10 ;
			winning_log($period_id, $period_number,$member['id'], $member['nickname'], $member['credit1'], $member_new_money,$winning_num, $win1['pay_C3'],
                $winner_number_type, $winner_money, $A_odds, 'C3', $member['parent_agent'],  $agent['nickname'] ,$number_type);
			
              //pdo_insert('manji_winner',array('type'=>1,'user_id'=>$win1['user_id'],'lottery_number'=>$first_no,'period_id'=>$period_id));
        }
		
		pdo_run('UNLOCK TABLES;'); //解锁
		
		return $total_winner_money;

}

function cal_C4($period_id, $period_number, $winning_num, $winner_number_type ,$number_type){
		//锁表
		$sql = "LOCK TABLE ".tablename('manji_order'). " WRITE,".tablename('member_system_member')." WRITE,".
            tablename('agent_member')." WRITE,".tablename('manji_reward_log')." WRITE,".tablename('agent_odds')." WRITE;";
		pdo_run($sql);
	
		//找到这一期里的所有获胜方, B 他下注了
	   $winner1 = pdo_fetchall('select id, user_id,pay_C4  from '.tablename('manji_order').
           ' where period_id=:period_id and substr(number,length(number)-2,3)=:number and pay_C4>0',array(':period_id'=>$period_id,':number'=> substr($winning_num,-3) ));
 
 		$total_winner_money = 0;  //总共赔的钱
 		//给他加钱了
        foreach ($winner1 as $win1){
			//找到这个人的代理人，获取代理人的陪率
			$member = pdo_fetch("select id, nickname,parent_agent,credit1  from ".tablename('member_system_member'). '  where id='. $win1['user_id']   );
			if( empty($member) ){
				continue;  //没有代理，数据 出错
			}
			
			//代理人
			$agent = pdo_fetch("select * from ".tablename('agent_member'). '  where id='. $member['parent_agent']   );
			if( empty($agent) ){
				continue;  //没有代理，数据 出错
			}
			
			
			$agent_adds = pdo_fetch("select * from ".tablename('agent_odds'). '  where agent_id='. $member['parent_agent']   );
			if( empty($agent_adds) ){
				continue; //没有代理，数据 出错
			}
			
			//获取当前赔率
			$A_odds = $agent_adds['odds_C4'];
			
			
			//给他奖的钱
			$winner_money = $win1['pay_C4'] * $A_odds;
			
			$total_winner_money+= $winner_money;
			
			//保存
			$res = pdo_query('update ims_member_system_member  set credit1 = credit1 + :money where id=:id',array(':money'=>$winner_money,':id'=>$member['id']));
	
			//保存单条记录
			$res = pdo_query('update ims_manji_order  set result_C4 = result_C4 + :money where id=:id',array(':money'=>$winner_money,':id'=>$win1['id']));
	

			//保存个人记录
			$member_new_money = ((int)($member['credit1'] * 10  + $winner_money *10)) / 10 ;
			winning_log($period_id, $period_number,$member['id'], $member['nickname'], $member['credit1'], $member_new_money,$winning_num, $win1['pay_C4'],
                $winner_number_type, $winner_money, $A_odds, 'C4', $member['parent_agent'],  $agent['nickname'] ,$number_type);
			
              //pdo_insert('manji_winner',array('type'=>1,'user_id'=>$win1['user_id'],'lottery_number'=>$first_no,'period_id'=>$period_id));
        }
		
		pdo_run('UNLOCK TABLES;'); //解锁
		
		return $total_winner_money;

}


function cal_C5($period_id, $period_number, $winning_num, $winner_number_type ,$number_type){
		//锁表
		$sql = "LOCK TABLE ".tablename('manji_order'). " WRITE,".tablename('member_system_member')." WRITE,".
            tablename('agent_member')." WRITE,".tablename('manji_reward_log')." WRITE,".tablename('agent_odds')." WRITE;";
		pdo_run($sql);
	
		//找到这一期里的所有获胜方, B 他下注了
	   $winner1 = pdo_fetchall('select id, user_id,pay_C5  from '.tablename('manji_order').
           ' where period_id=:period_id and substr(number,length(number)-2,3)=:number and pay_C5>0',array(':period_id'=>$period_id,':number'=> substr($winning_num,-3) ));
 
 		$total_winner_money = 0;  //总共赔的钱
 		//给他加钱了
        foreach ($winner1 as $win1){
			//找到这个人的代理人，获取代理人的陪率
			$member = pdo_fetch("select id, nickname,parent_agent,credit1  from ".tablename('member_system_member'). '  where id='. $win1['user_id']   );
			if( empty($member) ){
				continue;  //没有代理，数据 出错
			}
			
			//代理人
			$agent = pdo_fetch("select * from ".tablename('agent_member'). '  where id='. $member['parent_agent']   );
			if( empty($agent) ){
				continue;  //没有代理，数据 出错
			}
			
			
			$agent_adds = pdo_fetch("select * from ".tablename('agent_odds'). '  where agent_id='. $member['parent_agent']   );
			if( empty($agent_adds) ){
				continue; //没有代理，数据 出错
			}
			
			//获取当前赔率
			$A_odds = $agent_adds['odds_C5'];
			
			
			//给他奖的钱
			$winner_money = $win1['pay_C5'] * $A_odds;
			
			$total_winner_money+= $winner_money;
			
			//保存
			$res = pdo_query('update ims_member_system_member  set credit1 = credit1 + :money where id=:id',array(':money'=>$winner_money,':id'=>$member['id']));
	
			//保存单条记录
			$res = pdo_query('update ims_manji_order  set result_C5 = result_C5 + :money where id=:id',array(':money'=>$winner_money,':id'=>$win1['id']));
	

			//保存个人记录
			$member_new_money = ((int)($member['credit1'] * 10  + $winner_money *10)) / 10 ;
			winning_log($period_id, $period_number,$member['id'], $member['nickname'], $member['credit1'], $member_new_money,$winning_num, $win1['pay_C5'],
                $winner_number_type, $winner_money, $A_odds, 'C5', $member['parent_agent'],  $agent['nickname'] ,$number_type);
			
              //pdo_insert('manji_winner',array('type'=>1,'user_id'=>$win1['user_id'],'lottery_number'=>$first_no,'period_id'=>$period_id));
        }
		
		pdo_run('UNLOCK TABLES;'); //解锁
		
		return $total_winner_money;

}

function cal_2A($period_id, $period_number, $winning_num, $winner_number_type ,$number_type){
		//锁表
		$sql = "LOCK TABLE ".tablename('manji_order'). " WRITE,".tablename('member_system_member')." WRITE,".
            tablename('agent_member')." WRITE,".tablename('manji_reward_log')." WRITE,".tablename('agent_odds')." WRITE;";
		pdo_run($sql);
	
		//找到这一期里的所有获胜方, B 他下注了
	   $winner1 = pdo_fetchall('select id, user_id,pay_2A  from '.tablename('manji_order').
           ' where period_id=:period_id and substr(number,length(number)-1,2)=:number and pay_2A>0',array(':period_id'=>$period_id,':number'=> substr($winning_num,-2) ));
 
 		$total_winner_money = 0;  //总共赔的钱
 		//给他加钱了
        foreach ($winner1 as $win1){
			//找到这个人的代理人，获取代理人的陪率
			$member = pdo_fetch("select id, nickname,parent_agent,credit1  from ".tablename('member_system_member'). '  where id='. $win1['user_id']   );
			if( empty($member) ){
				continue;  //没有代理，数据 出错
			}
			
			//代理人
			$agent = pdo_fetch("select * from ".tablename('agent_member'). '  where id='. $member['parent_agent']   );
			if( empty($agent) ){
				continue;  //没有代理，数据 出错
			}
			
			
			$agent_adds = pdo_fetch("select * from ".tablename('agent_odds'). '  where agent_id='. $member['parent_agent']   );
			if( empty($agent_adds) ){
				continue; //没有代理，数据 出错
			}
			
			//获取当前赔率
			$A2_odds = $agent_adds['odds_2A'];
			
			
			//给他奖的钱
			$winner_money = $win1['pay_2A'] * $A2_odds;
			
			$total_winner_money+= $winner_money;
			
			//保存
			$res = pdo_query('update ims_member_system_member  set credit1 = credit1 + :money where id=:id',array(':money'=>$winner_money,':id'=>$member['id']));
	
			//保存单条记录
			$res = pdo_query('update ims_manji_order  set result_2A = result_2A + :money where id=:id',array(':money'=>$winner_money,':id'=>$win1['id']));
	

			//保存个人记录
			$member_new_money = ((int)($member['credit1'] * 10  + $winner_money *10)) / 10 ;
			winning_log($period_id, $period_number,$member['id'], $member['nickname'], $member['credit1'], $member_new_money,$winning_num, $win1['pay_2A'],
                $winner_number_type, $winner_money, $A2_odds, '2A', $member['parent_agent'],  $agent['nickname'] ,$number_type);
			
              //pdo_insert('manji_winner',array('type'=>1,'user_id'=>$win1['user_id'],'lottery_number'=>$first_no,'period_id'=>$period_id));
        }
		
		pdo_run('UNLOCK TABLES;'); //解锁
		
		return $total_winner_money;

}

function cal_2B($period_id, $period_number, $winning_num, $winner_number_type ,$number_type){
		//锁表
		$sql = "LOCK TABLE ".tablename('manji_order'). " WRITE,".tablename('member_system_member')." WRITE,".
            tablename('agent_member')." WRITE,".tablename('manji_reward_log')." WRITE,".tablename('agent_odds')." WRITE;";
		pdo_run($sql);
	
		//找到这一期里的所有获胜方, B 他下注了
	   $winner1 = pdo_fetchall('select id, user_id,pay_2B  from '.tablename('manji_order').
           ' where period_id=:period_id and substr(number,length(number)-1,2)=:number and pay_2B>0',array(':period_id'=>$period_id,':number'=> substr($winning_num,-2) ));
 
 		$total_winner_money = 0;  //总共赔的钱
 		//给他加钱了
        foreach ($winner1 as $win1){
			//找到这个人的代理人，获取代理人的陪率
			$member = pdo_fetch("select id, nickname,parent_agent,credit1  from ".tablename('member_system_member'). '  where id='. $win1['user_id']   );
			if( empty($member) ){
				continue;  //没有代理，数据 出错
			}
			
			//代理人
			$agent = pdo_fetch("select * from ".tablename('agent_member'). '  where id='. $member['parent_agent']   );
			if( empty($agent) ){
				continue;  //没有代理，数据 出错
			}
			
			
			$agent_adds = pdo_fetch("select * from ".tablename('agent_odds'). '  where agent_id='. $member['parent_agent']   );
			if( empty($agent_adds) ){
				continue; //没有代理，数据 出错
			}
			
			//获取当前赔率
			$A2_odds = $agent_adds['odds_2B'];
			
			
			//给他奖的钱
			$winner_money = $win1['pay_2B'] * $A2_odds;
			
			$total_winner_money+= $winner_money;
			
			//保存
			$res = pdo_query('update ims_member_system_member  set credit1 = credit1 + :money where id=:id',array(':money'=>$winner_money,':id'=>$member['id']));
	
			//保存单条记录
			$res = pdo_query('update ims_manji_order  set result_2B = result_2B + :money where id=:id',array(':money'=>$winner_money,':id'=>$win1['id']));
	

			//保存个人记录
			$member_new_money = ((int)($member['credit1'] * 10  + $winner_money *10)) / 10 ;
			winning_log($period_id, $period_number,$member['id'], $member['nickname'], $member['credit1'], $member_new_money,$winning_num, $win1['pay_2B'],
                $winner_number_type, $winner_money, $A2_odds, '2B', $member['parent_agent'],  $agent['nickname'] ,$number_type);
			
              //pdo_insert('manji_winner',array('type'=>1,'user_id'=>$win1['user_id'],'lottery_number'=>$first_no,'period_id'=>$period_id));
        }
		
		pdo_run('UNLOCK TABLES;'); //解锁
		
		return $total_winner_money;

}

function cal_2C($period_id, $period_number, $winning_num, $winner_number_type ,$number_type){
		//锁表
		$sql = "LOCK TABLE ".tablename('manji_order'). " WRITE,".tablename('member_system_member')." WRITE,".
            tablename('agent_member')." WRITE,".tablename('manji_reward_log')." WRITE,".tablename('agent_odds')." WRITE;";
		pdo_run($sql);
	
		//找到这一期里的所有获胜方, B 他下注了
	   $winner1 = pdo_fetchall('select id, user_id,pay_2C  from '.tablename('manji_order').
           ' where period_id=:period_id and substr(number,length(number)-1,2)=:number and pay_2C>0',array(':period_id'=>$period_id,':number'=> substr($winning_num,-2) ));
 
 		$total_winner_money = 0;  //总共赔的钱
 		//给他加钱了
        foreach ($winner1 as $win1){
			//找到这个人的代理人，获取代理人的陪率
			$member = pdo_fetch("select id, nickname,parent_agent,credit1  from ".tablename('member_system_member'). '  where id='. $win1['user_id']   );
			if( empty($member) ){
				continue;  //没有代理，数据 出错
			}
			
			//代理人
			$agent = pdo_fetch("select * from ".tablename('agent_member'). '  where id='. $member['parent_agent']   );
			if( empty($agent) ){
				continue;  //没有代理，数据 出错
			}
			
			
			$agent_adds = pdo_fetch("select * from ".tablename('agent_odds'). '  where agent_id='. $member['parent_agent']   );
			if( empty($agent_adds) ){
				continue; //没有代理，数据 出错
			}
			
			//获取当前赔率
			$A2_odds = $agent_adds['odds_2C'];
			
			
			//给他奖的钱
			$winner_money = $win1['pay_2C'] * $A2_odds;
			
			$total_winner_money+= $winner_money;
			
			//保存
			$res = pdo_query('update ims_member_system_member  set credit1 = credit1 + :money where id=:id',array(':money'=>$winner_money,':id'=>$member['id']));
	
			//保存单条记录
			$res = pdo_query('update ims_manji_order  set result_2C = result_2C + :money where id=:id',array(':money'=>$winner_money,':id'=>$win1['id']));
	

			//保存个人记录
			$member_new_money = ((int)($member['credit1'] * 10  + $winner_money *10)) / 10 ;
			winning_log($period_id, $period_number,$member['id'], $member['nickname'], $member['credit1'], $member_new_money,$winning_num, $win1['pay_2C'],
                $winner_number_type, $winner_money, $A2_odds, '2C', $member['parent_agent'],  $agent['nickname'] ,$number_type);
			
              //pdo_insert('manji_winner',array('type'=>1,'user_id'=>$win1['user_id'],'lottery_number'=>$first_no,'period_id'=>$period_id));
        }
		
		pdo_run('UNLOCK TABLES;'); //解锁
		
		return $total_winner_money;

}

function cal_2B($period_id, $period_number, $winning_num, $winner_number_type ,$number_type){
		//锁表
		$sql = "LOCK TABLE ".tablename('manji_order'). " WRITE,".tablename('member_system_member')." WRITE,".
            tablename('agent_member')." WRITE,".tablename('manji_reward_log')." WRITE,".tablename('agent_odds')." WRITE;";
		pdo_run($sql);
	
		//找到这一期里的所有获胜方, B 他下注了
	   $winner1 = pdo_fetchall('select id, user_id,pay_2B  from '.tablename('manji_order').
           ' where period_id=:period_id and substr(number,length(number)-1,2)=:number and pay_2B>0',array(':period_id'=>$period_id,':number'=> substr($winning_num,-2) ));
 
 		$total_winner_money = 0;  //总共赔的钱
 		//给他加钱了
        foreach ($winner1 as $win1){
			//找到这个人的代理人，获取代理人的陪率
			$member = pdo_fetch("select id, nickname,parent_agent,credit1  from ".tablename('member_system_member'). '  where id='. $win1['user_id']   );
			if( empty($member) ){
				continue;  //没有代理，数据 出错
			}
			
			//代理人
			$agent = pdo_fetch("select * from ".tablename('agent_member'). '  where id='. $member['parent_agent']   );
			if( empty($agent) ){
				continue;  //没有代理，数据 出错
			}
			
			
			$agent_adds = pdo_fetch("select * from ".tablename('agent_odds'). '  where agent_id='. $member['parent_agent']   );
			if( empty($agent_adds) ){
				continue; //没有代理，数据 出错
			}
			
			//获取当前赔率
			$A2_odds = $agent_adds['odds_2B'];
			
			
			//给他奖的钱
			$winner_money = $win1['pay_2B'] * $A2_odds;
			
			$total_winner_money+= $winner_money;
			
			//保存
			$res = pdo_query('update ims_member_system_member  set credit1 = credit1 + :money where id=:id',array(':money'=>$winner_money,':id'=>$member['id']));
	
			//保存单条记录
			$res = pdo_query('update ims_manji_order  set result_2B = result_2B + :money where id=:id',array(':money'=>$winner_money,':id'=>$win1['id']));
	

			//保存个人记录
			$member_new_money = ((int)($member['credit1'] * 10  + $winner_money *10)) / 10 ;
			winning_log($period_id, $period_number,$member['id'], $member['nickname'], $member['credit1'], $member_new_money,$winning_num, $win1['pay_2B'],
                $winner_number_type, $winner_money, $A2_odds, '2B', $member['parent_agent'],  $agent['nickname'] ,$number_type);
			
              //pdo_insert('manji_winner',array('type'=>1,'user_id'=>$win1['user_id'],'lottery_number'=>$first_no,'period_id'=>$period_id));
        }
		
		pdo_run('UNLOCK TABLES;'); //解锁
		
		return $total_winner_money;

}

function cal_2D($period_id, $period_number, $winning_num, $winner_number_type ,$number_type){
		//锁表
		$sql = "LOCK TABLE ".tablename('manji_order'). " WRITE,".tablename('member_system_member')." WRITE,".
            tablename('agent_member')." WRITE,".tablename('manji_reward_log')." WRITE,".tablename('agent_odds')." WRITE;";
		pdo_run($sql);
	
		//找到这一期里的所有获胜方, B 他下注了
	   $winner1 = pdo_fetchall('select id, user_id,pay_2D  from '.tablename('manji_order').
           ' where period_id=:period_id and substr(number,length(number)-1,2)=:number and pay_2D>0',array(':period_id'=>$period_id,':number'=> substr($winning_num,-2) ));
 
 		$total_winner_money = 0;  //总共赔的钱
 		//给他加钱了
        foreach ($winner1 as $win1){
			//找到这个人的代理人，获取代理人的陪率
			$member = pdo_fetch("select id, nickname,parent_agent,credit1  from ".tablename('member_system_member'). '  where id='. $win1['user_id']   );
			if( empty($member) ){
				continue;  //没有代理，数据 出错
			}
			
			//代理人
			$agent = pdo_fetch("select * from ".tablename('agent_member'). '  where id='. $member['parent_agent']   );
			if( empty($agent) ){
				continue;  //没有代理，数据 出错
			}
			
			
			$agent_adds = pdo_fetch("select * from ".tablename('agent_odds'). '  where agent_id='. $member['parent_agent']   );
			if( empty($agent_adds) ){
				continue; //没有代理，数据 出错
			}
			
			//获取当前赔率
			$A2_odds = $agent_adds['odds_2D'];
			
			
			//给他奖的钱
			$winner_money = $win1['pay_2D'] * $A2_odds;
			
			$total_winner_money+= $winner_money;
			
			//保存
			$res = pdo_query('update ims_member_system_member  set credit1 = credit1 + :money where id=:id',array(':money'=>$winner_money,':id'=>$member['id']));
	
			//保存单条记录
			$res = pdo_query('update ims_manji_order  set result_2D = result_2D + :money where id=:id',array(':money'=>$winner_money,':id'=>$win1['id']));
	

			//保存个人记录
			$member_new_money = ((int)($member['credit1'] * 10  + $winner_money *10)) / 10 ;
			winning_log($period_id, $period_number,$member['id'], $member['nickname'], $member['credit1'], $member_new_money,$winning_num, $win1['pay_2D'],
                $winner_number_type, $winner_money, $A2_odds, '2D', $member['parent_agent'],  $agent['nickname'] ,$number_type);
			
              //pdo_insert('manji_winner',array('type'=>1,'user_id'=>$win1['user_id'],'lottery_number'=>$first_no,'period_id'=>$period_id));
        }
		
		pdo_run('UNLOCK TABLES;'); //解锁
		
		return $total_winner_money;

}

function cal_2E($period_id, $period_number, $winning_num, $winner_number_type ,$number_type){
		//锁表
		$sql = "LOCK TABLE ".tablename('manji_order'). " WRITE,".tablename('member_system_member')." WRITE,".
            tablename('agent_member')." WRITE,".tablename('manji_reward_log')." WRITE,".tablename('agent_odds')." WRITE;";
		pdo_run($sql);
	
		//找到这一期里的所有获胜方, B 他下注了
	   $winner1 = pdo_fetchall('select id, user_id,pay_2E  from '.tablename('manji_order').
           ' where period_id=:period_id and substr(number,length(number)-1,2)=:number and pay_2E>0',array(':period_id'=>$period_id,':number'=> substr($winning_num,-2) ));
 
 		$total_winner_money = 0;  //总共赔的钱
 		//给他加钱了
        foreach ($winner1 as $win1){
			//找到这个人的代理人，获取代理人的陪率
			$member = pdo_fetch("select id, nickname,parent_agent,credit1  from ".tablename('member_system_member'). '  where id='. $win1['user_id']   );
			if( empty($member) ){
				continue;  //没有代理，数据 出错
			}
			
			//代理人
			$agent = pdo_fetch("select * from ".tablename('agent_member'). '  where id='. $member['parent_agent']   );
			if( empty($agent) ){
				continue;  //没有代理，数据 出错
			}
			
			
			$agent_adds = pdo_fetch("select * from ".tablename('agent_odds'). '  where agent_id='. $member['parent_agent']   );
			if( empty($agent_adds) ){
				continue; //没有代理，数据 出错
			}
			
			//获取当前赔率
			$A2_odds = $agent_adds['odds_2E'];
			
			
			//给他奖的钱
			$winner_money = $win1['pay_2E'] * $A2_odds;
			
			$total_winner_money+= $winner_money;
			
			//保存
			$res = pdo_query('update ims_member_system_member  set credit1 = credit1 + :money where id=:id',array(':money'=>$winner_money,':id'=>$member['id']));
	
			//保存单条记录
			$res = pdo_query('update ims_manji_order  set result_2E = result_2E + :money where id=:id',array(':money'=>$winner_money,':id'=>$win1['id']));
	

			//保存个人记录
			$member_new_money = ((int)($member['credit1'] * 10  + $winner_money *10)) / 10 ;
			winning_log($period_id, $period_number,$member['id'], $member['nickname'], $member['credit1'], $member_new_money,$winning_num, $win1['pay_2E'],
                $winner_number_type, $winner_money, $A2_odds, '2E', $member['parent_agent'],  $agent['nickname'] ,$number_type);
			
              //pdo_insert('manji_winner',array('type'=>1,'user_id'=>$win1['user_id'],'lottery_number'=>$first_no,'period_id'=>$period_id));
        }
		
		pdo_run('UNLOCK TABLES;'); //解锁
		
		return $total_winner_money;

}

function cal_2ABC($period_id, $period_number, $winning_num, $winner_number_type ,$number_type){
		//锁表
		$sql = "LOCK TABLE ".tablename('manji_order'). " WRITE,".tablename('member_system_member')." WRITE,
		".tablename('agent_member')." WRITE,".tablename('manji_reward_log')." WRITE,".tablename('agent_odds')." WRITE;";
		pdo_run($sql);
	
		//找到这一期里的所有获胜方, B 他下注了
	   $winner1 = pdo_fetchall('select id, user_id,pay_2ABC  from '.tablename('manji_order').
           ' where period_id=:period_id and substr(number,length(number)-1,2)=:number and pay_2ABC>0',
           array(':period_id'=>$period_id,':number'=> substr($winning_num,-2) ));
 
 		$total_winner_money = 0;  //总共赔的钱
 		//给他加钱了
        foreach ($winner1 as $win1){
			//找到这个人的代理人，获取代理人的陪率
			$member = pdo_fetch("select id, nickname,parent_agent,credit1  from ".tablename('member_system_member'). '  where id='. $win1['user_id']   );
			if( empty($member) ){
				continue;  //没有代理，数据 出错
			}
			
			//代理人
			$agent = pdo_fetch("select * from ".tablename('agent_member'). '  where id='. $member['parent_agent']   );
			if( empty($agent) ){
				continue;  //没有代理，数据 出错
			}
			
			
			$agent_adds = pdo_fetch("select * from ".tablename('agent_odds'). '  where agent_id='. $member['parent_agent']   );
			if( empty($agent_adds) ){
				continue; //没有代理，数据 出错
			}
			
			//获取当前赔率

            $odds_arr = explode('|',$agent_adds['odds_2ABC']);
            if($number_type==1){
                $abc4_odds = $odds_arr[0];
            }
            if($number_type==2){
                $abc4_odds = $odds_arr[1];
            }
            if($number_type==3){
                $abc4_odds = $odds_arr[2];
            }


            //给他奖的钱
			$winner_money = $win1['pay_2ABC'] * $abc4_odds;
			$total_winner_money+= $winner_money;
			//保存
			$res = pdo_query('update ims_member_system_member  set credit1 = credit1 + :money where id=:id',array(':money'=>$winner_money,':id'=>$member['id']));
	
			//保存单条记录
			$res = pdo_query('update ims_manji_order  set result_2ABC = result_2ABC + :money where id=:id',array(':money'=>$winner_money,':id'=>$win1['id']));
	
			//保存个人记录
			$member_new_money = ((int)($member['credit1'] * 10  + $winner_money *10)) / 10 ;
			winning_log($period_id, $period_number,$member['id'], $member['nickname'], $member['credit1'], $member_new_money,$winning_num,$win1['pay_2ABC'] ,
                $winner_number_type, $winner_money, $abc4_odds, '2ABC', $member['parent_agent'],  $agent['nickname'],$number_type );
		
              //pdo_insert('manji_winner',array('type'=>1,'user_id'=>$win1['user_id'],'lottery_number'=>$first_no,'period_id'=>$period_id));
        }
		
		pdo_run('UNLOCK TABLES;'); //解锁
		
		return $total_winner_money;

}

function cal_3ABC($period_id, $period_number, $winning_num, $winner_number_type ,$number_type){
		//锁表
		$sql = "LOCK TABLE ".tablename('manji_order'). " WRITE,".tablename('member_system_member')." WRITE,
		".tablename('agent_member')." WRITE,".tablename('manji_reward_log')." WRITE,".tablename('agent_odds')." WRITE;";
		pdo_run($sql);
	
		//找到这一期里的所有获胜方, B 他下注了
	   $winner1 = pdo_fetchall('select id, user_id,pay_3ABC  from '.tablename('manji_order').
           ' where period_id=:period_id and substr(number,length(number)-2,3)=:number and pay_3ABC>0',
           array(':period_id'=>$period_id,':number'=> substr($winning_num,-3) ));
 
 		$total_winner_money = 0;  //总共赔的钱
 		//给他加钱了
        foreach ($winner1 as $win1){
			//找到这个人的代理人，获取代理人的陪率
			$member = pdo_fetch("select id, nickname,parent_agent,credit1  from ".tablename('member_system_member'). '  where id='. $win1['user_id']   );
			if( empty($member) ){
				continue;  //没有代理，数据 出错
			}
			
			//代理人
			$agent = pdo_fetch("select * from ".tablename('agent_member'). '  where id='. $member['parent_agent']   );
			if( empty($agent) ){
				continue;  //没有代理，数据 出错
			}
			
			
			$agent_adds = pdo_fetch("select * from ".tablename('agent_odds'). '  where agent_id='. $member['parent_agent']   );
			if( empty($agent_adds) ){
				continue; //没有代理，数据 出错
			}
			
			//获取当前赔率

            $odds_arr = explode('|',$agent_adds['odds_3ABC']);
            if($number_type==1){
                $abc4_odds = $odds_arr[0];
            }
            if($number_type==2){
                $abc4_odds = $odds_arr[1];
            }
            if($number_type==3){
                $abc4_odds = $odds_arr[2];
            }


            //给他奖的钱
			$winner_money = $win1['pay_3ABC'] * $abc4_odds;
			$total_winner_money+= $winner_money;
			//保存
			$res = pdo_query('update ims_member_system_member  set credit1 = credit1 + :money where id=:id',array(':money'=>$winner_money,':id'=>$member['id']));
	
			//保存单条记录
			$res = pdo_query('update ims_manji_order  set result_3ABC = result_3ABC + :money where id=:id',array(':money'=>$winner_money,':id'=>$win1['id']));
	
			//保存个人记录
			$member_new_money = ((int)($member['credit1'] * 10  + $winner_money *10)) / 10 ;
			winning_log($period_id, $period_number,$member['id'], $member['nickname'], $member['credit1'], $member_new_money,$winning_num,$win1['pay_3ABC'] ,
                $winner_number_type, $winner_money, $abc4_odds, '3ABC', $member['parent_agent'],  $agent['nickname'],$number_type );
		
              //pdo_insert('manji_winner',array('type'=>1,'user_id'=>$win1['user_id'],'lottery_number'=>$first_no,'period_id'=>$period_id));
        }
		
		pdo_run('UNLOCK TABLES;'); //解锁
		
		return $total_winner_money;

}

function cal_EA($period_id, $period_number, $winning_num, $winner_number_type,$number_type ){
	
		//锁表
		$sql = "LOCK TABLE ".tablename('manji_order'). " WRITE,".tablename('member_system_member')
            ." WRITE,".tablename('agent_member')." WRITE,".tablename('manji_reward_log')." WRITE,".tablename('agent_odds')." WRITE;";
		pdo_run($sql);
	
		//找到这一期里的所有获胜方, B 他下注了
	   $winner1 = pdo_fetchall('select id, user_id,pay_EA  from '.tablename('manji_order').
           ' where period_id=:period_id and number=:number and pay_EA>0',array(':period_id'=>$period_id,':number'=>$winning_num));
 
 		$total_winner_money = 0;  //总共赔的钱
 		//给他加钱了
        foreach ($winner1 as $win1){
			//找到这个人的代理人，获取代理人的陪率
			$member = pdo_fetch("select id, nickname,parent_agent,credit1  from ".tablename('member_system_member'). '  where id='. $win1['user_id']   );
			if( empty($member) ){
				continue;  //没有代理，数据 出错
			}
			
			//代理人
			$agent = pdo_fetch("select * from ".tablename('agent_member'). '  where id='. $member['parent_agent']   );
			if( empty($agent) ){
				continue;  //没有代理，数据 出错
			}
			
			$agent_adds = pdo_fetch("select * from ".tablename('agent_odds'). '  where agent_id='. $member['parent_agent']   );
			if( empty($agent_adds) ){
				continue; //没有代理，数据 出错
			}
            //获取当前赔率
			$b4_odds = $agent_adds['odds_EA'];
			//给他奖的钱
			$winner_money = $win1['pay_EA'] * $b4_odds;
			$total_winner_money+= $winner_money;
			
		
			//保存单条记录
			$res = pdo_query('update ims_manji_order  set result_EA = result_EA + :money where id=:id',array(':money'=>$winner_money,':id'=>$win1['id']));
	
		//保存
		//	$res = pdo_update('member_system_member',array('credit1'=>$member['credit1'] + $winner_money ),array('id'=>$win1['user_id'] ));
			$res = pdo_query('update ims_member_system_member  set credit1 = credit1 + :money where id=:id',array(':money'=>$winner_money,':id'=>$member['id']));
	
			//保存个人记录
			$member_new_money = ((int)($member['credit1'] * 10  + $winner_money *10)) / 10 ;
			winning_log($period_id, $period_number,$member['id'], $member['nickname'], $member['credit1'], $member_new_money,
                $winning_num, $win1['pay_EA'],$winner_number_type, $winner_money, $b4_odds, 'EA', $member['parent_agent'],  $agent['nickname'],$number_type );
			
              //pdo_insert('manji_winner',array('type'=>1,'user_id'=>$win1['user_id'],'lottery_number'=>$first_no,'period_id'=>$period_id));
        }
		
		pdo_run('UNLOCK TABLES;'); //解锁
		
		return $total_winner_money;
}

function cal_EC($period_id, $period_number, $winning_num, $winner_number_type ,$number_type){
		//锁表
		$sql = "LOCK TABLE ".tablename('manji_order'). " WRITE,".tablename('member_system_member')." WRITE,
		".tablename('agent_member')." WRITE,".tablename('manji_reward_log')." WRITE,".tablename('agent_odds')." WRITE;";
		pdo_run($sql);
	
		//找到这一期里的所有获胜方, B 他下注了
	   $winner1 = pdo_fetchall('select id, user_id,pay_EC  from '.tablename('manji_order').
           ' where period_id=:period_id and substr(number,length(number)-2,3)=:number and pay_EC>0',
           array(':period_id'=>$period_id,':number'=> substr($winning_num,-3) ));
 
 		$total_winner_money = 0;  //总共赔的钱
 		//给他加钱了
        foreach ($winner1 as $win1){
			//找到这个人的代理人，获取代理人的陪率
			$member = pdo_fetch("select id, nickname,parent_agent,credit1  from ".tablename('member_system_member'). '  where id='. $win1['user_id']   );
			if( empty($member) ){
				continue;  //没有代理，数据 出错
			}
			
			//代理人
			$agent = pdo_fetch("select * from ".tablename('agent_member'). '  where id='. $member['parent_agent']   );
			if( empty($agent) ){
				continue;  //没有代理，数据 出错
			}
			
			
			$agent_adds = pdo_fetch("select * from ".tablename('agent_odds'). '  where agent_id='. $member['parent_agent']   );
			if( empty($agent_adds) ){
				continue; //没有代理，数据 出错
			}
			
			//获取当前赔率

            $abc4_odds = $agent_adds['odds_EC'];

            //给他奖的钱
			$winner_money = $win1['pay_EC'] * $abc4_odds;
			$total_winner_money+= $winner_money;
			//保存
			$res = pdo_query('update ims_member_system_member  set credit1 = credit1 + :money where id=:id',array(':money'=>$winner_money,':id'=>$member['id']));
	
			//保存单条记录
			$res = pdo_query('update ims_manji_order  set result_EC = result_EC + :money where id=:id',array(':money'=>$winner_money,':id'=>$win1['id']));
	
			//保存个人记录
			$member_new_money = ((int)($member['credit1'] * 10  + $winner_money *10)) / 10 ;
			winning_log($period_id, $period_number,$member['id'], $member['nickname'], $member['credit1'], $member_new_money,$winning_num,$win1['pay_EC'] ,
                $winner_number_type, $winner_money, $abc4_odds, 'EC', $member['parent_agent'],  $agent['nickname'],$number_type );
		
              //pdo_insert('manji_winner',array('type'=>1,'user_id'=>$win1['user_id'],'lottery_number'=>$first_no,'period_id'=>$period_id));
        }
		
		pdo_run('UNLOCK TABLES;'); //解锁
		
		return $total_winner_money;

}

function cal_EX($period_id, $period_number, $winning_num, $winner_number_type ,$number_type){
		//锁表
		$sql = "LOCK TABLE ".tablename('manji_order'). " WRITE,".tablename('member_system_member')." WRITE,
		".tablename('agent_member')." WRITE,".tablename('manji_reward_log')." WRITE,".tablename('agent_odds')." WRITE;";
		pdo_run($sql);
	
		//找到这一期里的所有获胜方, B 他下注了
	   $winner1 = pdo_fetchall('select id, user_id,pay_EX  from '.tablename('manji_order').
           ' where period_id=:period_id and substr(number,length(number)-1,2)=:number and pay_EX>0',
           array(':period_id'=>$period_id,':number'=> substr($winning_num,-2) ));
 
 		$total_winner_money = 0;  //总共赔的钱
 		//给他加钱了
        foreach ($winner1 as $win1){
			//找到这个人的代理人，获取代理人的陪率
			$member = pdo_fetch("select id, nickname,parent_agent,credit1  from ".tablename('member_system_member'). '  where id='. $win1['user_id']   );
			if( empty($member) ){
				continue;  //没有代理，数据 出错
			}
			
			//代理人
			$agent = pdo_fetch("select * from ".tablename('agent_member'). '  where id='. $member['parent_agent']   );
			if( empty($agent) ){
				continue;  //没有代理，数据 出错
			}
			
			
			$agent_adds = pdo_fetch("select * from ".tablename('agent_odds'). '  where agent_id='. $member['parent_agent']   );
			if( empty($agent_adds) ){
				continue; //没有代理，数据 出错
			}
			
			//获取当前赔率

            $odds_arr = $agent_adds['odds_EX'];

            //给他奖的钱
			$winner_money = $win1['pay_EX'] * $abc4_odds;
			$total_winner_money+= $winner_money;
			//保存
			$res = pdo_query('update ims_member_system_member  set credit1 = credit1 + :money where id=:id',array(':money'=>$winner_money,':id'=>$member['id']));
	
			//保存单条记录
			$res = pdo_query('update ims_manji_order  set result_EX = result_EX + :money where id=:id',array(':money'=>$winner_money,':id'=>$win1['id']));
	
			//保存个人记录
			$member_new_money = ((int)($member['credit1'] * 10  + $winner_money *10)) / 10 ;
			winning_log($period_id, $period_number,$member['id'], $member['nickname'], $member['credit1'], $member_new_money,$winning_num,$win1['pay_EX'] ,
                $winner_number_type, $winner_money, $abc4_odds, 'EX', $member['parent_agent'],  $agent['nickname'],$number_type );
		
              //pdo_insert('manji_winner',array('type'=>1,'user_id'=>$win1['user_id'],'lottery_number'=>$first_no,'period_id'=>$period_id));
        }
		
		pdo_run('UNLOCK TABLES;'); //解锁
		
		return $total_winner_money;

}

 ?>