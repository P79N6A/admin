<?php
require '../../../framework/bootstrap.inc.php';
/**
* 
*/
class profit
{
	
	static public $res=0;

	public function getAgent($agentId,$periodId)
	{
		$junior = pdo_fetchall('select id from '.tablename('member_system_member').' where parent_agent=:id',array(':id'=>$agentId));
    	foreach ($junior as $k => $v) {
    		if ($k == 0) {
    			$field = $v['id'];
    		}
    		else{
    			$field .= ','.$v['id'];
    		}
    	}
    	$order = pdo_fetch('select sum(order_amount) bet,sum(`4E_result`+`4S_result`+`4A_result`+`3ABC_result`+`3A_result`+`Box_result`+`IBOX_result`+`A1_result`) pay_award from '.tablename('manji_order').' where user_id in (:field) and period_id=:id',array(':field'=>$field,':id'=>$periodId));
    	$profit = floatval($order['bet']) - floatval($order['pay_award']);
    	$parent_profit = $profit*0.1;
		self::$res+$parent_profit;
		if ($result['pid'] > 0) {
				$this->getRegion($result['pid']);
		}
		return self::$res;
	}
}






 ?>