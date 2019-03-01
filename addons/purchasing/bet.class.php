<?php 
/**
 * 投注
 */
class Bet
{
	public $member;
	public $parent_limit;
	public $red_limit;
	public $time_limit;
	public $odds;
	public $company;
	public $order;

	
	function __construct($member_id,$cid,$date,$parent)
	{
		$this->member = pdo_fetch('select * from '.tablename('member_system_member').' where id=:id',array(':id'=>$member_id));
		$this->red_limit = pdo_fetchcolumn('select red_limit from '.tablename('manji_member_red').' where user_id=:user_id',array(':user_id'=>$member_id));
		$this->time_limit = pdo_fetchcolumn('select * from '.tablename('manji_limit_time').' where cid=:cid or cid=0',array(':cid'=>$cid));
		$this->parent_limit = pdo_fetchColumnValue('select red_limit from '.tablename('agent_red').' where agent_id in ('.implode(',', $parents).')',array(),'red_limit');
		$this->odds = pdo_fetchall('select * from '.tablename('manji_member_odds').' where member_id=:member_id',array(':member_id'=>$member_id));
		$this->company = pdo_fetchall('select * from '.tablename('manji_company'));
		$this->order = pdo_fetchall('select * from '.tablename('manji_order').' where date=:date',array(':date'=>$date));
	}

	private function GetPorder()
	{
		$member = $this->member;
		$order_count = pdo_fetchcolumn('select count(id) from '.tablename('manji_order').' where pid=0');
		$user_count = pdo_fetchcolumn('select count(id) from '.tablename('manji_order').' where user_id=:user_id',array(':user_id'=>$member['id']));
		$save = array(
			'ordersn' => $order_count+1,
			'uordersn' => $user_count+1,
			'createtime' => time()
		);
		pdo_insert('manji_order',$save);
		$order_id = pdo_insertid();

		return $order_id;
	}

	public function CheckTime($company,$day)
	{
		foreach ($company as $com) {
			$periods = pdo_fetchall('select * from '.tablename('manji_run_setting').' where status=1 and show=1 order by endtime asc limit 0,'.$day);
			if (time()>$periods[0]['stop_time']) {
				$status = 2;
				break;
			}
			if (count($periods) < $day) {
				$status = 3;
				break;
			}
			
		}

		return $status;
	}

}










 ?>