<?php 

function check_B($period_id, $winning_num, $number_type ){
	
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
        }
		
		pdo_run('UNLOCK TABLES;'); //解锁
		
		return $total_winner_money;
}

function check_4A($period_id,  $winning_num, $number_type ){
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
            $a4_odds =  $agent_adds['odds_4A'];
			//给他奖的钱
			$winner_money = $win1['pay_4A'] * $a4_odds;
			$total_winner_money+= $winner_money;
        }
		
		pdo_run('UNLOCK TABLES;'); //解锁
		
		return $total_winner_money;

}

function check_4B($period_id,  $winning_num, $number_type ){
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
            $a4_odds =  $agent_adds['odds_4B'];
			//给他奖的钱
			$winner_money = $win1['pay_4B'] * $a4_odds;
			$total_winner_money+= $winner_money;
        }
		
		pdo_run('UNLOCK TABLES;'); //解锁
		
		return $total_winner_money;

}

function check_4C($period_id,  $winning_num, $number_type ){
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
            $a4_odds =  $agent_adds['odds_4C'];
			//给他奖的钱
			$winner_money = $win1['pay_4C'] * $a4_odds;
			$total_winner_money+= $winner_money;
        }
		
		pdo_run('UNLOCK TABLES;'); //解锁
		
		return $total_winner_money;

}

function check_4D($period_id,  $winning_num, $number_type ){
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
            $a4_odds =  $agent_adds['odds_4D'];
			//给他奖的钱
			$winner_money = $win1['pay_4D'] * $a4_odds;
			$total_winner_money+= $winner_money;
        }
		
		pdo_run('UNLOCK TABLES;'); //解锁
		
		return $total_winner_money;

}

function check_4E($period_id,  $winning_num, $number_type ){
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
            $a4_odds =  $agent_adds['odds_4E'];
			//给他奖的钱
			$winner_money = $win1['pay_4E'] * $a4_odds;
			$total_winner_money+= $winner_money;
        }
		
		pdo_run('UNLOCK TABLES;'); //解锁
		
		return $total_winner_money;

}


function check_S($period_id,  $winning_num, $number_type ){
		//锁表
		$sql = "LOCK TABLE ".tablename('manji_order'). " WRITE,".tablename('member_system_member')." WRITE,".tablename('agent_member')." WRITE,"
            .tablename('manji_reward_log')." WRITE,".tablename('agent_odds')." WRITE;";
		pdo_run($sql);
	
		//找到这一期里的所有获胜方, B 他下注了
	   $winner1 = pdo_fetchall('select id, user_id,pay_s  from '.tablename('manji_order'). ' where period_id=:period_id and number=:number and pay_s>0',
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
        }
		
		pdo_run('UNLOCK TABLES;'); //解锁
		
		return $total_winner_money;

}

function check_3ABC($period_id,  $winning_num, $number_type){
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
        }
		
		pdo_run('UNLOCK TABLES;'); //解锁
		
		return $total_winner_money;

}

function check_2ABC($period_id,  $winning_num, $number_type){
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
            if($number_type==4){
                $abc4_odds = $odds_arr[3];
            }
            if($number_type==5){
                $abc4_odds = $odds_arr[4];
            }


            //给他奖的钱
			$winner_money = $win1['pay_2ABC'] * $abc4_odds;
			$total_winner_money+= $winner_money;
        }
		
		pdo_run('UNLOCK TABLES;'); //解锁
		
		return $total_winner_money;

}

function check_A($period_id,  $winning_num, $number_type){
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
			$a3_odds = $agent_adds['odds_A'];
			
			
			//给他奖的钱
			$winner_money = $win1['pay_A'] * $a3_odds;
			
			$total_winner_money+= $winner_money;
			
        }
		
		pdo_run('UNLOCK TABLES;'); //解锁
		
		return $total_winner_money;

}

function check_C2($period_id,  $winning_num, $number_type){
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
			$a3_odds = $agent_adds['odds_C2'];
			
			
			//给他奖的钱
			$winner_money = $win1['pay_C2'] * $a3_odds;
			
			$total_winner_money+= $winner_money;
			
        }
		
		pdo_run('UNLOCK TABLES;'); //解锁
		
		return $total_winner_money;

}

function check_C3($period_id,  $winning_num, $number_type){
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
			$a3_odds = $agent_adds['odds_C3'];
			
			
			//给他奖的钱
			$winner_money = $win1['pay_C3'] * $a3_odds;
			
			$total_winner_money+= $winner_money;
			
        }
		
		pdo_run('UNLOCK TABLES;'); //解锁
		
		return $total_winner_money;

}

function check_C4($period_id,  $winning_num, $number_type){
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
			$a3_odds = $agent_adds['odds_C4'];
			
			
			//给他奖的钱
			$winner_money = $win1['pay_C4'] * $a3_odds;
			
			$total_winner_money+= $winner_money;
			
        }
		
		pdo_run('UNLOCK TABLES;'); //解锁
		
		return $total_winner_money;

}

function check_C5($period_id,  $winning_num, $number_type){
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
			$a3_odds = $agent_adds['odds_C5'];
			
			
			//给他奖的钱
			$winner_money = $win1['pay_C5'] * $a3_odds;
			
			$total_winner_money+= $winner_money;
			
        }
		
		pdo_run('UNLOCK TABLES;'); //解锁
		
		return $total_winner_money;

}

function check_2A($period_id,  $winning_num, $number_type){
		//锁表
		$sql = "LOCK TABLE ".tablename('manji_order'). " WRITE,".tablename('member_system_member')." WRITE,".
            tablename('agent_member')." WRITE,".tablename('manji_reward_log')." WRITE,".tablename('agent_odds')." WRITE;";
		pdo_run($sql);
	
		//找到这一期里的所有获胜方, B 他下注了
	   $winner1 = pdo_fetchall('select id, user_id,pay_2A  from '.tablename('manji_order').
           ' where period_id=:period_id and substr(number,length(number)-1,2)=:number and pay_2A>0',array(':period_id'=>$period_id,':number'=> substr($winning_num,-3) ));
 
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
        }
		
		pdo_run('UNLOCK TABLES;'); //解锁
		
		return $total_winner_money;

}

function check_2B($period_id,  $winning_num, $number_type){
		//锁表
		$sql = "LOCK TABLE ".tablename('manji_order'). " WRITE,".tablename('member_system_member')." WRITE,".
            tablename('agent_member')." WRITE,".tablename('manji_reward_log')." WRITE,".tablename('agent_odds')." WRITE;";
		pdo_run($sql);
	
		//找到这一期里的所有获胜方, B 他下注了
	   $winner1 = pdo_fetchall('select id, user_id,pay_2B  from '.tablename('manji_order').
           ' where period_id=:period_id and substr(number,length(number)-1,2)=:number and pay_2B>0',array(':period_id'=>$period_id,':number'=> substr($winning_num,-3) ));
 
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
        }
		
		pdo_run('UNLOCK TABLES;'); //解锁
		
		return $total_winner_money;

}

function check_2C($period_id,  $winning_num, $number_type){
		//锁表
		$sql = "LOCK TABLE ".tablename('manji_order'). " WRITE,".tablename('member_system_member')." WRITE,".
            tablename('agent_member')." WRITE,".tablename('manji_reward_log')." WRITE,".tablename('agent_odds')." WRITE;";
		pdo_run($sql);
	
		//找到这一期里的所有获胜方, B 他下注了
	   $winner1 = pdo_fetchall('select id, user_id,pay_2C  from '.tablename('manji_order').
           ' where period_id=:period_id and substr(number,length(number)-1,2)=:number and pay_2C>0',array(':period_id'=>$period_id,':number'=> substr($winning_num,-3) ));
 
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
        }
		
		pdo_run('UNLOCK TABLES;'); //解锁
		
		return $total_winner_money;

}

function check_2D($period_id,  $winning_num, $number_type){
		//锁表
		$sql = "LOCK TABLE ".tablename('manji_order'). " WRITE,".tablename('member_system_member')." WRITE,".
            tablename('agent_member')." WRITE,".tablename('manji_reward_log')." WRITE,".tablename('agent_odds')." WRITE;";
		pdo_run($sql);
	
		//找到这一期里的所有获胜方, B 他下注了
	   $winner1 = pdo_fetchall('select id, user_id,pay_2D  from '.tablename('manji_order').
           ' where period_id=:period_id and substr(number,length(number)-1,2)=:number and pay_2D>0',array(':period_id'=>$period_id,':number'=> substr($winning_num,-3) ));
 
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
        }
		
		pdo_run('UNLOCK TABLES;'); //解锁
		
		return $total_winner_money;

}

function check_2D($period_id,  $winning_num, $number_type){
		//锁表
		$sql = "LOCK TABLE ".tablename('manji_order'). " WRITE,".tablename('member_system_member')." WRITE,".
            tablename('agent_member')." WRITE,".tablename('manji_reward_log')." WRITE,".tablename('agent_odds')." WRITE;";
		pdo_run($sql);
	
		//找到这一期里的所有获胜方, B 他下注了
	   $winner1 = pdo_fetchall('select id, user_id,pay_2D  from '.tablename('manji_order').
           ' where period_id=:period_id and substr(number,length(number)-1,2)=:number and pay_2D>0',array(':period_id'=>$period_id,':number'=> substr($winning_num,-3) ));
 
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
        }
		
		pdo_run('UNLOCK TABLES;'); //解锁
		
		return $total_winner_money;

}

function check_2E($period_id,  $winning_num, $number_type){
		//锁表
		$sql = "LOCK TABLE ".tablename('manji_order'). " WRITE,".tablename('member_system_member')." WRITE,".
            tablename('agent_member')." WRITE,".tablename('manji_reward_log')." WRITE,".tablename('agent_odds')." WRITE;";
		pdo_run($sql);
	
		//找到这一期里的所有获胜方, B 他下注了
	   $winner1 = pdo_fetchall('select id, user_id,pay_2E  from '.tablename('manji_order').
           ' where period_id=:period_id and substr(number,length(number)-1,2)=:number and pay_2E>0',array(':period_id'=>$period_id,':number'=> substr($winning_num,-3) ));
 
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
        }
		
		pdo_run('UNLOCK TABLES;'); //解锁
		
		return $total_winner_money;

}

function check_EX($period_id,  $winning_num, $number_type){
		//锁表
		$sql = "LOCK TABLE ".tablename('manji_order'). " WRITE,".tablename('member_system_member')." WRITE,".
            tablename('agent_member')." WRITE,".tablename('manji_reward_log')." WRITE,".tablename('agent_odds')." WRITE;";
		pdo_run($sql);
	
		//找到这一期里的所有获胜方, B 他下注了
	   $winner1 = pdo_fetchall('select id, user_id,pay_EX  from '.tablename('manji_order').
           ' where period_id=:period_id and substr(number,length(number)-1,2)=:number and pay_EX>0',array(':period_id'=>$period_id,':number'=> substr($winning_num,-3) ));
 
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
			$A2_odds = $agent_adds['odds_EX'];
			
			
			//给他奖的钱
			$winner_money = $win1['pay_EX'] * $A2_odds;
			
			$total_winner_money+= $winner_money;
        }
		
		pdo_run('UNLOCK TABLES;'); //解锁
		
		return $total_winner_money;

}

function check_EC($period_id,  $winning_num, $number_type){
		//锁表
		$sql = "LOCK TABLE ".tablename('manji_order'). " WRITE,".tablename('member_system_member')." WRITE,".
            tablename('agent_member')." WRITE,".tablename('manji_reward_log')." WRITE,".tablename('agent_odds')." WRITE;";
		pdo_run($sql);
	
		//找到这一期里的所有获胜方, B 他下注了
	   $winner1 = pdo_fetchall('select id, user_id,pay_EC  from '.tablename('manji_order').
           ' where period_id=:period_id and substr(number,length(number)-2,3)=:number and pay_EC>0',array(':period_id'=>$period_id,':number'=> substr($winning_num,-3) ));
 
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
			$a3_odds = $agent_adds['odds_EC'];
			
			
			//给他奖的钱
			$winner_money = $win1['pay_EC'] * $a3_odds;
			
			$total_winner_money+= $winner_money;
			
        }
		
		pdo_run('UNLOCK TABLES;'); //解锁
		
		return $total_winner_money;

}

function check_EA($period_id,  $winning_num, $number_type ){
		//锁表
		$sql = "LOCK TABLE ".tablename('manji_order'). " WRITE,".tablename('member_system_member')." WRITE,".tablename('agent_member')." WRITE,"
            .tablename('manji_reward_log')." WRITE,".tablename('agent_odds')." WRITE;";
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
            $a4_odds =  $agent_adds['odds_EA'];
			//给他奖的钱
			$winner_money = $win1['pay_EA'] * $a4_odds;
			$total_winner_money+= $winner_money;
        }
		
		pdo_run('UNLOCK TABLES;'); //解锁
		
		return $total_winner_money;

}



 ?>