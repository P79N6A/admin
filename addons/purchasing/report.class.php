<?php 
/**
 * 聚宝报告
 */
class Report
{
	
	public $orders;
	public $order_detail;
	public $agents;
	public $members;
	public $agent_odds;
	public $member_odds;
	public $odds;
	public $bet_total;
	public $pay_award;
	public $member_award;
	public $period;
	public $jackpot;

	public function __construct($period_id)
	{
		$cid = pdo_fetchcolumn('select aid from '.tablename('manji_run_setting').' where id=:id',array(':id'=>$period_id));
		//初始化期数ID
		$this->period = $period_id; 
		//初始化订单附单
		$this->order_detail = pdo_fetchall('select sum(d.pay_B*(100+o.false_price)/100) as B,sum(d.pay_S*(100+o.false_price)/100) as S,sum(d.pay_3ABC*(100+o.false_price)/100) as 3ABC,sum(d.pay_4ABC*(100+o.false_price)/100) as 4ABC,sum(d.pay_2ABC*(100+o.false_price)/100) as 2ABC,sum((d.pay_A+d.pay_C2+d.pay_C3+d.pay_C4+d.pay_C5+d.pay_EC)*(100+o.false_price)/100) as A,sum((d.pay_4A+d.pay_4B+d.pay_4C+d.pay_4D+d.pay_4E+d.pay_EA)*(100+o.false_price)/100) as 4A,sum((d.pay_2A+d.pay_2B+d.pay_2C+d.pay_2D+d.pay_2E+d.pay_EX)*(100+o.false_price)/100) as 2A,sum(d.pay_5D*(100+o.false_price)/100) as 5D,sum(d.pay_6D*(100+o.false_price)/100) as 6D,order_id from '.tablename('manji_order_detail').' d left join '.tablename('manji_order').' o on o.id=d.order_id where d.period_id like \'%('.$period_id.')%\' and o.status=1 group by order_id ');
		//初始化总投注额
		$this->bet_total = pdo_fetchcolumn('select sum((d.pay_B+d.pay_S+d.pay_3ABC+d.pay_4ABC+d.pay_2ABC+d.pay_A+d.pay_C2+d.pay_C3+d.pay_C4+d.pay_C5+d.pay_EC+d.pay_4A+d.pay_4B+d.pay_4C+d.pay_4D+d.pay_4E+d.pay_EA+d.pay_2A+d.pay_2B+d.pay_2C+d.pay_2D+d.pay_2E+d.pay_EX+d.pay_5D+d.pay_6D)*(100+o.false_price)/100) from '.tablename('manji_order_detail').' d left join '.tablename('manji_order').' o on o.id=d.order_id where d.period_id like \'%('.$period_id.')%\' and o.status=1');
		//初始化订单
		$this->orders = pdo_fetchall('select * from '.tablename('manji_order').' where period_id like \'%('.$period_id.')%\' and status=1 and pid>0');
		//初始化代理
		$this->agents = pdo_fetchall('select a.*,p.bonus_percent from '.tablename('agent_member').' a left join '.tablename('agent_percent').' p on a.id=p.agent_id where a.cid=:cid and a.level>=4',array(':cid'=>$cid));
		//初始化会员
		$this->members = pdo_fetchall('select * from '.tablename('member_system_member').' where cid=:cid',array(':cid'=>$cid));
		//初始化代理配套
		$this->agent_odds = pdo_fetchall('select a.* from '.tablename('agent_odds').' a left join '.tablename('manji_odds').' o on o.id=a.pid where o.cid=1');
		//初始化会员配套
		$this->member_odds = pdo_fetchall('select * from '.tablename('manji_member_odds').' where cid=1');
		//初始化总中奖
		$this->pay_award = pdo_fetchcolumn('select sum(winner_money) from '.tablename('manji_reward_log').' where period_id=:period_id',array(':period_id'=>$period_id));
		//初始化系统配套
		$this->odds = pdo_fetchall('select * from '.tablename('manji_odds').' where cid=1');
		//初始化会员中奖
		$this->member_award = pdo_fetchall('select sum(winner_money) as earn,member_id from '.tablename('manji_reward_log').' where period_id=:period_id group by member_id',array(':period_id'=>$period_id));
		//初始化彩金
		$this->jackpot = pdo_fetchall('select win_money as jackpot,user_id from '.tablename('manji_jackpot_log').' where period_id=:period',array(':period'=>$period_id));
	}

	/*获取系统配套抽佣*/
	private function Commission($odds_id,$rule)
	{
		$odd = $this->odds;
		$percent = 0;
		foreach ($odd as $k => $v) {
			if ($v['id'] == $odds_id) {
				$commission = $v['commission'];
			}
		}
		if (!empty($commission)) {
			$com = json_decode($commission,true);
			$percent += floatval($com[$rule]);
		}
		return $percent;
	}

	/*获取所有上级代理*/
	private function GetParent($agent_id)
	{
		$agent = $this->agents;
		$parents = array();
		foreach ($agent as $k => $v) {
			if ($v['id'] == $agent_id) {
				$parent = $v['parent_agent'];
			}
		}
		if ($parent > 0) {
			$parents[] = $parent;
			$next = $this->GetParent($parent);
			$parents = array_merge($parents,$next);
		}
		return $parents;
	}

	/*获取所有下级代理*/
	private function GetChildAgent($agent_id)
	{
		$agents = $this->agents;
		$agent = array();
		foreach ($agents as $k => $v) {
			if ($v['parent_agent'] == $agent_id) {
				$child[] = $v['id'];
			}
		}
		if (count($child) > 0) {
			foreach ($child as $key => $value) {
				$new = $this->GetChildAgent($value);
				$agent = array_merge($agent,$new);
			}
			$agent = array_merge($agent,$child);
		}
		return $agent;
	}

	/*获取该代理下所有会员*/
	private function GetMember($agent_id)
	{
		$member = $this->members;
		foreach ($member as $k => $v) {
			if ($v['parent_agent'] == $agent_id) {
				$result[] = $v;
			}
		}
		return $result;
	}

	/*获取会员本期订单*/
	private function GetOrder($member_id)
	{
		$order = $this->orders;
		foreach ($order as $k => $v) {
			if ($v['user_id'] == $member_id) {
				$result[] = $v;
			}
		}
		return $result;
	}

	/*获取该订单所有附单*/
	private function GetDetail($order_id)
	{
		$detail = $this->order_detail;
		foreach ($detail as $k => $v) {
			if ($v['order_id'] == $order_id) {
				$result = $v;
			}
		}
		return $result;
	}

	/*获取会员彩金*/
	private function GetJackpot($member_id)
	{
		$jackpot = $this->jackpot;
		$result = 0;
		foreach ($jackpot as $k => $v) {
			if ($v['user_id'] == $member_id) {
				$result += $v['jackpot'];
			}
		}
		return $result;
	}

	/*获取会员正在使用的配套*/
	private function GetUsedOdd($member_id)
	{
		$odd = $this->member_odds;
		foreach ($odd as $k => $v) {
			if ($v['member_id'] == $member_id) {
				$odds = $v;
			}
		}
		return $odds;
	}

	/*获取当前代理分配给会员的配套*/
	private function GetAgentOdd($odds_id)
	{
		$agent_odd = $this->agent_odds;
		foreach ($agent_odd as $k => $v) {
			if ($v['id'] == $odds_id) {
				$odd = $v;
			}
		}
		return $odd;
	}

	/*获取会员赔率百分比*/
	private function GetMemberPercent($odd=array(),$rule)
	{
		// switch ($rule) {
		// 	case 'B':
		// 		$odds_B = explode('|',$odd['odds_B']);
		// 		foreach ($odds_B as $k => $v) {
		// 			if ($k > 2) {
		// 				$odds_B[$k] = $v*10;
		// 			}
		// 		}
		// 		$odds_total = array_sum($odds_B);
		// 		$percent = floatval($odds_total)/100;
		// 		break;
		// 	case 'S':
		// 		$odds_S = explode('|',$odd['odds_S']);
		// 		$odds_total = array_sum($odds_S);
		// 		$percent = floatval($odds_total)/100;
		// 		break;
		// 	case 'A':
		// 		$percent = $odd['odds_A']/10;
		// 		break;
		// 	case '3ABC':
		// 		$odds_3ABC = explode('|',$odd['odds_3ABC']);
		// 		$odds_total = array_sum($odds_3ABC);
		// 		$percent = floatval($odds_total)/10;
		// 		break;
		// 	case '4A':
		// 		$percent = $odd['odds_4A']/100;
		// 		break;
		// 	case '4ABC':
		// 		$odds_4ABC = explode('|',$odd['odds_4ABC']);
		// 		$odds_total = array_sum($odds_4ABC);
		// 		$percent = floatval($odds_total)/100;
		// 		break;
		// 	case '2A':
		// 		$percent = $odd['odds_2A'];
		// 		break;
		// 	case '2ABC':
		// 		$odds_2ABC = explode('|',$odd['odds_2ABC']);
		// 		$odds_total = array_sum($odds_2ABC);
		// 		$percent = floatval($odds_total);
		// 		break;
		// 	case '5D':
		// 		$odds_5D = explode('|',$odd['odds_5D']);
		// 		$total_odds = 0;
		// 		for ($i=0; $i < 6; $i++) { 
		// 		    if ($i == 3) {
		// 		    	$total_odds = $total_odds+($odds_5D[$i]*10);
		// 		    }
		// 		    elseif ($i == 4) {
		// 		    	$total_odds = $total_odds+($odds_5D[$i]*100);
		// 		    }
		// 		    elseif ($i == 5) {
		// 		    	$total_odds = $total_odds+($odds_5D[$i]*1000);
		// 		    }
		// 		    else{
		// 		    	$total_odds = $total_odds+$odds_5D[$i];
		// 		    }
		// 		}
		// 		$percent = $total_odds/1000;
		// 		break;
		// 	case '6D':
		// 		$odds_6D = explode('|',$odd['odds_6D']);
		// 		$total_odds = 0;
		// 		 for ($i=0; $i < 5; $i++) { 
		// 		    if ($i == 1) {
		// 		    	$total_odds = $total_odds+$odds_6D[$i]*10*2;
		// 		    }
		// 		    elseif ($i == 2) {
		// 		    	$total_odds = $total_odds+$odds_6D[$i]*100*2;
		// 		    }
		// 		    elseif ($i == 3) {
		// 		    	$total_odds = $total_odds+$odds_6D[$i]*1000*2;
		// 		    }
		// 		    elseif ($i == 4) {
		// 		    	$total_odds = $total_odds+$odds_6D[$i]*10000*2;
		// 		    }
		// 		    else{
		// 		    	$total_odds = $total_odds+$odds_6D[$i];
		// 		    }
		// 		}
		// 		$percent = $total_odds/10000;
		// 		break;
		// }
		$cashback = json_decode($odd['my_cashback'],true);
		$percent = $cashback[$rule];
		return $percent;
	}

	private function GetManagerPercent($commission,$odd,$rule)
	{
		switch ($rule) {
			case 'B':
				$odds_B = explode('|',$odd['odds_B']);
				foreach ($odds_B as $k => $v) {
					if ($k > 2) {
						$odds_B[$k] = $v*10;
					}
				}
				$odds_total = array_sum($odds_B);
				$member_percent = floatval($odds_total)/100;
				break;
			case 'S':
				$odds_S = explode('|',$odd['odds_S']);
				$odds_total = array_sum($odds_S);
				$member_percent = floatval($odds_total)/100;
				break;
			case 'A':
				$member_percent = $odd['odds_A']/10;
				break;
			case '3ABC':
				$odds_3ABC = explode('|',$odd['odds_3ABC']);
				$odds_total = array_sum($odds_3ABC);
				$member_percent = floatval($odds_total)/10;
				break;
			case '4A':
				$member_percent = $odd['odds_4A']/100;
				break;
			case '4ABC':
				$odds_4ABC = explode('|',$odd['odds_4ABC']);
				$odds_total = array_sum($odds_4ABC);
				$member_percent = floatval($odds_total)/100;
				break;
			case '2A':
				$member_percent = $odd['odds_2A'];
				break;
			case '2ABC':
				$odds_2ABC = explode('|',$odd['odds_2ABC']);
				$odds_total = array_sum($odds_2ABC);
				$member_percent = floatval($odds_total);
				break;
			case '5D':
				$odds_5D = explode('|',$odd['odds_5D']);
				$total_odds = 0;
				for ($i=0; $i < 6; $i++) { 
				    if ($i == 3) {
				    	$total_odds = $total_odds+($odds_5D[$i]*10);
				    }
				    elseif ($i == 4) {
				    	$total_odds = $total_odds+($odds_5D[$i]*100);
				    }
				    elseif ($i == 5) {
				    	$total_odds = $total_odds+($odds_5D[$i]*1000);
				    }
				    else{
				    	$total_odds = $total_odds+$odds_5D[$i];
				    }
				}
				$member_percent = $total_odds/1000;
				break;
			case '6D':
				$odds_6D = explode('|',$odd['odds_6D']);
				$total_odds = 0;
				 for ($i=0; $i < 5; $i++) { 
				    if ($i == 1) {
				    	$total_odds = $total_odds+$odds_6D[$i]*10*2;
				    }
				    elseif ($i == 2) {
				    	$total_odds = $total_odds+$odds_6D[$i]*100*2;
				    }
				    elseif ($i == 3) {
				    	$total_odds = $total_odds+$odds_6D[$i]*1000*2;
				    }
				    elseif ($i == 4) {
				    	$total_odds = $total_odds+$odds_6D[$i]*10000*2;
				    }
				    else{
				    	$total_odds = $total_odds+$odds_6D[$i];
				    }
				}
				$member_percent = $total_odds/10000;
				break;
		}
		$percent = 100 - $member_percent - $commission;
		return $percent>0?$percent:0;

	}

	/*获取会员所有上级会员的抽佣总和*/
	private function GetAgentPercent($agent_id,$odds_id,$rule)
	{
		$agent_odd = $this->agent_odds;
		$agents = $this->agents;
		$percent = 0;
		$agent = 0;
		foreach ($agents as $ag => $a) {
			if ($a['id'] == $agent_id) {
				$agent = $a['parent_agent'];
			}
		}
		foreach ($agent_odd as $k => $v) {
			if ($v['pid'] == $odds_id && $v['agent_id'] == $agent_id) {
				$agent_commission = $v['cashback'];
				$pid = $v['pid'];
			}
		}
		if (!empty($agent_commission)) {
			$commission = json_decode($agent_commission,true);
			$percent+=$commission[$rule];
		}
		// if ($agent>0) {
		// 	$percent+=$this->GetAgentPercent($agent,$pid,$rule);
		// }
		return $percent;
	}

	/*获取会员的中奖总和*/
	private function GetMemberPay($member_id)
	{
		$member_pay  = $this->member_award;
		foreach ($member_pay as $k => $v) {
			if ($v['member_id'] == $member_id) {
				$pay_award = $v;
			}
		}
		return $pay_award;
	}

	/*获取该代理的总佣金*/
	private function GetAgentCash($agent_id)
	{
		$member = $this->GetMember($agent_id)?$this->GetMember($agent_id):array();
		$agents = $this->agents;
		foreach ($agents as $ag => $a) {
			if ($a['id'] == $agent_id) {
				$agent = $a;
			}
		}
		foreach ($agents as $ag => $a) {
			if ($a['id'] == $agent['parent_agent']) {
				$parent = $a;
			}
		}
		$child = $this->GetChildAgent($agent_id);
		foreach ($child as $key => $value) {
			$child_member = $this->GetMember($value)?$this->GetMember($value):array();
			$member = array_merge($member,$child_member);
		}
		$cashback = 0;
		foreach ($member as $k => $v) {
			$used_odds = $this->GetUsedOdd($v['id']);
			$commission = json_decode($used_odds['commission'],true);
			$agent_odds = $this->GetAgentOdd($used_odds['pid']);
			$order = $this->GetOrder($v['id'])?$this->GetOrder($v['id']):array();
			foreach ($order as $key => $ord) {
				$detail = $this->GetDetail($ord['id'])?$this->GetDetail($ord['id']):array();
				foreach ($detail as $index => $item) {
					if ($index != 'order_id' && $item>0) {
						$member_percent = $this->GetMemberPercent($used_odds,$index);  //获取用户反水百分比
						$system_commission = $this->Commission($agent_odds['pid'],$index);  //获取系统抽佣
						if ($agent['parent_agent'] == 0) {
							$agent_percent = $this->GetManagerPercent($system_commission,$used_odds,$index);  //获取所有上级代理的抽佣
							$upline_percent = $this->GetManagerPercent($system_commission,$used_odds,$index);  //获取会员上级的所有上级代理的抽佣
						}
						else{
							$agent_percent = $this->GetAgentPercent($agent_id,$agent_odds['pid'],$index);  //获取所有上级代理的抽佣
							$upline_percent = $this->GetAgentPercent($parent['id'],$agent_odds['pid'],$index);  //获取会员上级的所有上级代理的抽佣
						}
						$my_commission = $commission[$index]; //获取配套抽佣
						$bet += $item;
						//计算下级佣金 投注额 X (100 - 用户赔率百分比 - 上级抽佣 - 系统抽佣 - 会员使用配套抽佣)%
						$cashback += floatval($item)*floatval($agent_percent)/100;
					}
				}
			}
		}
		$cashback = $cashback>0?$cashback:0;

		return $cashback>0?$cashback:0;

	}

	/*获取代理需要写入报告的数据*/
	private function GetAgentReport($agent_id,$bet_total,$total_profit=0)
	{
		$member = $this->GetMember($agent_id)?$this->GetMember($agent_id):array();
		$agents = $this->agents;
		foreach ($agents as $ag => $a) {
			if ($a['id'] == $agent_id) {
				$agent = $a;
			}
		}
		foreach ($agents as $ag => $a) {
			if ($a['id'] == $agent['parent_agent']) {
				$parent = $a;
			}
		}
		$child = $this->GetChildAgent($agent_id);
		foreach ($child as $key => $value) {
			$child_member = $this->GetMember($value)?$this->GetMember($value):array();
			$member = array_merge($member,$child_member);
		}
		$cashback = 0;
		$upline_cashback = 0;
		$bet = 0;
		$member_earn = 0;
		$jackpot = 0;
		foreach ($member as $k => $v) {
			$used_odds = $this->GetUsedOdd($v['id']);
			$commission = json_decode($used_odds['commission'],true);
			$agent_odds = $this->GetAgentOdd($used_odds['pid']);
			$order = $this->GetOrder($v['id'])?$this->GetOrder($v['id']):array();
			foreach ($order as $key => $ord) {
				$detail = $this->GetDetail($ord['id'])?$this->GetDetail($ord['id']):array();
				foreach ($detail as $index => $item) {
					if ($index != 'order_id' && $item>0) {
						$member_percent = $this->GetMemberPercent($used_odds,$index);  //获取用户反水百分比
						$system_commission = $this->Commission($agent_odds['pid'],$index);  //获取系统抽佣
						if ($agent['parent_agent'] == 0) {
							$agent_percent = $this->GetManagerPercent($system_commission,$used_odds,$index);  //获取所有上级代理的抽佣
						}
						else{
							$agent_percent = $this->GetAgentPercent($agent_id,$agent_odds['pid'],$index);  //获取所有上级代理的抽佣
						}
						$upline_percent = $this->GetAgentPercent($parent['id'],$agent_odds['pid'],$index);  //获取会员上级的所有上级代理的抽佣
						$my_commission = $commission[$index]; //获取配套抽佣
						$bet += $item;
						//计算下级佣金 投注额 X (100 - 用户赔率百分比 - 上级抽佣 - 系统抽佣 - 会员使用配套抽佣)%
						$cashback += floatval($item)*floatval($agent_percent)/100;
						//计算上线佣金 投注额 X (100 - 用户赔率百分比 - 上级抽佣 - 系统抽佣 - 会员使用配套抽佣)%
						$upline_cashback += floatval($item)*floatval($upline_percent)/100;
					}
				}
			}
			$member_pay_award = $this->GetMemberPay($v['id']);
			$jackpot += $this->GetJackpot($v['id']);
			$member_earn += $member_pay_award['earn'];
		}
		// var_dump($member_earn);
		$cashback = $cashback>0?$cashback:0;
		$upline_cashback = $upline_cashback>0?$upline_cashback:0;
		if ($bet_total > 0) {
			$bonus = floatval($bet/$bet_total)*floatval($total_profit)*floatval($agent['bonus_percent'])/100;
			$upline_bonus = floatval($bet/$bet_total)*floatval($total_profit)*floatval($parent['bonus_percent'])/100;
			$profit = $bet-$member_earn-$cashback;
			$upline_profit = $bet-$member_earn-$upline_cashback;
			//计算分红  (当前投注额÷盘口总投注)×公司总输赢(总投注-总中奖-总佣金)×代理分红百分比
			// $bonus = $profit*floatval($agent['bonus_percent'])/100;
			//计算上线分红  (当前投注额÷盘口总投注)×公司总输赢(总投注-总中奖-总佣金)×上线代理分红百分比
			// $upline_bonus = $upline_profit*floatval($parent['bonus_percent'])/100;
		}
		if ($bet > 0) {
			$result = array(
				'agent_id' => $agent_id,
				'sum_bet' => $bet?$bet:0,
				'cashback' => $cashback?$cashback:0,
				'bonus' => $bonus?$bonus:0,
				'pay_award' => $member_earn?$member_earn:0,
				'profit' => $profit?$profit:0,
				'net' => $profit-$bonus,
				'upline_sum_bet' => $bet?$bet:0,
				'upline_pay_award' => $member_earn?$member_earn:0,
				'upline_cashback' => $upline_cashback?$upline_cashback:0,
				'upline_bonus' => $upline_bonus?$upline_bonus:0,
				'upline_profit' => $upline_profit?$upline_profit:0,
				'upline_net' => $upline_profit-$upline_bonus,
				'commission' => $upline_cashback-$cashback,
				'bonus_earn' => $member_earn -$member_earn,
				'cid' => $agent['cid'],
				'company' => 1,
				'periods_id' => $this->period,
				'create_time' => time(),
				'parent_agent' => $agent['parent_agent'],
				'jackpot' => $jackpot
			);
		}
		return $result;

	}

	/*获取会员写入报告需要的数据*/
	private function GetMemberReport($member_id,$bet_total,$total_profit=0)
	{
		$members = $this->members;
		$agents = $this->agents;
		foreach ($members as $k => $v) {
			if ($v['id'] == $member_id) {
				$member = $v;
			}
		}
		foreach ($agents as $ag => $a) {
			if ($a['id'] == $member['parent_agent']) {
				$parent = $a;
			}
		}
		$cashback = 0;
		$upline_cashback = 0;
		$bet = 0;
		$member_earn = 0;
		$used_odds = $this->GetUsedOdd($member_id);
		$commission = json_decode($used_odds['commission'],true);
		$agent_odds = $this->GetAgentOdd($used_odds['pid']);
		$order = $this->GetOrder($member_id)?$this->GetOrder($member_id):array();
		foreach ($order as $key => $ord) {
			$detail = $this->GetDetail($ord['id'])?$this->GetDetail($ord['id']):array();
			foreach ($detail as $index => $item) {
				if ($index != 'order_id') {
					$member_percent = $this->GetMemberPercent($used_odds,$index);  //获取用户反水百分比
					$system_commission = $this->Commission($agent_odds['pid'],$index);  //获取系统抽佣
					if ($parent['parent_agent'] == 0) {
						$agent_percent = $this->GetManagerPercent($system_commission,$used_odds,$index);  //获取所有上级代理的抽佣
					}
					else{
						$agent_percent = $this->GetAgentPercent($member['parent_agent'],$agent_odds['pid'],$index);  //获取所有上级代理的抽佣
					}
					$my_commission = $commission[$index]; //获取配套抽佣
					$bet += $item;
					//计算下级佣金 投注额 X (100 - 用户赔率百分比 - 上级抽佣 - 系统抽佣 - 会员使用配套抽佣)%
					$cashback += floatval($item)*$member_percent/100;
					//计算上线佣金 投注额 X (100 - 用户赔率百分比 - 上级抽佣 - 系统抽佣 - 会员使用配套抽佣)%
					$upline_cashback += floatval($item)*floatval($agent_percent)/100;
				}
			}
		}
		$jackpot = $this->GetJackpot($member_id);
		$member_pay_award = $this->GetMemberPay($member_id);
		$member_earn += $member_pay_award['earn'];
		$cashback = $cashback>0?$cashback:0;
		$upline_cashback = $upline_cashback>0?$upline_cashback:0;
		if ($bet_total > 0) {
			//计算上线分红 同上
			$upline_bonus = floatval($bet/$bet_total)*floatval($total_profit)*floatval($parent['bonus_percent'])/100;
			$profit = $bet-$member_earn-$cashback;
			$upline_profit = $bet-$member_earn-$upline_cashback;
			// $upline_bonus = $upline_profit*floatval($parent['bonus_percent'])/100;
		}
		if ($bet > 0) {
			$result = array(
				'member_id' => $member_id,
				'sum_bet' => $bet?$bet:0,
				'cashback' => $cashback?$cashback:0,
				'bonus' => $bonus?$bonus:0,
				'pay_award' => $member_earn?$member_earn:0,
				'profit' => $profit?$profit:0,
				'net' => $profit-$bonus,
				'upline_sum_bet' => $bet?$bet:0,
				'upline_pay_award' => $member_earn?$member_earn:0,
				'upline_cashback' => $upline_cashback?$upline_cashback:0,
				'upline_bonus' => $upline_bonus?$upline_bonus:0,
				'upline_profit' => $upline_profit?$upline_profit:0,
				'upline_net' => $upline_profit-$upline_bonus,
				'commission' => $upline_cashback-$cashback,
				'bonus_earn' => $member_earn -$member_earn,
				'cid' => $member['cid'],
				'company' => 1,
				'periods_id' => $this->period,
				'create_time' => time(),
				'parent_agent' => $member['parent_agent'],
				'jackpot' => $jackpot
			);
		}
		return $result;
	}

	/*获取报告数据*/
	public function GetReport()
	{
		$agents = $this->agents;
		$members = $this->members;
		$bet_total = $this->bet_total;
		$pay_award = $this->pay_award;
		foreach ($agents as $v) {
			if ($v['level'] == 4) {
				$agent_id = $v['id'];
			}
		}
		$total_cash = $this->GetAgentCash($agent_id); //获取总佣金
		$total_profit = $bet_total-$pay_award-$total_cash;
		foreach ($agents as $agent) {
			$item = $this->GetAgentReport($agent['id'],$bet_total,$total_profit);
			if (!empty($item)) {
				$save[] = $item;
			}
			
		}
		foreach ($members as $member) {
			$item = $this->GetMemberReport($member['id'],$bet_total,$total_profit);
			if (!empty($item)) {
				$save[] = $item;
			}
			
		}
		return $save;
	}

	public function GetTotal()
	{
		$agents = $this->agents;
		$bet_total = $this->bet_total;
		$pay_award = $this->pay_award;
		foreach ($agents as $v) {
			if ($v['level'] == 4) {
				$agent_id = $v['id'];
			}
		}
		$total_cash = $this->GetAgentCash($agent_id); //获取总佣金
		$total_profit = $bet_total-$pay_award-$total_cash;
		$result = array(
			'sum_bet' => $bet_total,
			'pay_award' => $pay_award,
			'profit' => $total_profit,
			'cashback' => $total_cash
		);

		return $result;
	}
}











 ?>