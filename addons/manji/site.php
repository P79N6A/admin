<?php
/**
 * 微商城模块微站定义
 *
 *  http://www.efwww.com 易福源码网
 * @url
 */
defined('IN_IA') or exit('Access Denied');

session_start();

//load()->func('cache_memcache2');
//load()->func('logging');
//load()->func('communication');
require_once  'common.php';
class ManjiModuleSite extends WeModuleSite {

	public $settings;

	public function __construct() {
		global $_W,$_GPC;
	}


	//获取当前代理下级的所有代理
	public function findNextAgent($agentId){
		$agents = pdo_fetchall('select id from '.tablename('agent_member').' where parent_agent=:agent_id',array(':agent_id'=>$agentId));
		return $agents;
	}

	//获取当前代理的所有会员
	public function findNextMember($agentId){
		$members = pdo_fetchall('select id from '.tablename('member_system_member').' where parent_agent=:agent_id',array(':agent_id'=>$agentId));
		return $members;
	}
	
	//获取当前代理的所有会员
	public function findMemberIncomeByPeriodId($memberId, $periodId){
		$money = pdo_fetch('select sum(order_amount) bet,sum(`result_B`+`result_S`+`result_A`+`result_C2`+`result_C3`+`result_C4`+`result_C5`+`result_EC`+`result_3ABC`+`result_4A`+`result_4B`+`result_4C`+`result_4D`+`result_4E`+`result_EA`+`result_4ABC`+`result_2A`+`result_2B`+`result_2C`+`result_2D`+`result_2E`+`result_EX`+`result_2ABC`) pay_award from '.tablename('manji_order').' where user_id=:member_id and period_id=:period_id',array(':member_id'=>$memberId,':period_id'=>$periodId));
		$income = floatval($money['bet']) - floatval($money['pay_award']);
		return $income;
	}
	
	//当前代理下会员本期收益 
	//periodId  期数
	public function findAgentIncome($agentId, $periodId){
		
		//获取当前代理的直线会员
		$members = $this->findNextMember( $agentId );
		
		$memberIncomes = array();
		
		//获取所有会员当前期数的收益 
		if (!empty($members)) {
			foreach($members as $member){
				$memberIncome = $this->findMemberIncomeByPeriodId( $member['id'], $periodId);
				if( !empty($memberIncome) ){
					$memberIncomes[] = $memberIncome;
				}
			}
		}
		
		//获取当前代理下的会员
		if (!empty($agents)) {
			$agents = $this->findNextAgent($agentId);
			foreach($agents as $agent){
				$agentMemberIncomes = $this->findAgentIncome($agent['id']);
				if( !empty($agentMemberIncomes) ){
					array_combine($memberIncomes, $agentMemberIncomes*0.01 );
				}
			}
		}

		$memberIncomes = array_sum($memberIncomes);
	
		return $memberIncomes;	
	}

	public function AES_decrypt($encryptKey,$encryptStr) {
		$iv = '0987654321FEDCBA';
	    $module = mcrypt_module_open(MCRYPT_RIJNDAEL_128, '', MCRYPT_MODE_CBC, $iv);
	    mcrypt_generic_init($module, $encryptKey, $iv);
		$encryptedData = mdecrypt_generic($module, $encryptStr);
		$dec_s = strlen($encryptedData); 
	    $padding = ord($encryptedData[$dec_s-1]); 
	    $encryptedData = substr($encryptedData, 0, -$padding);
	    return $encryptedData;
	}
	public function AES_encrypt($data,$sign,$iv='0987654321FEDCBA')
	{
		$result = mcrypt_encrypt(MCRYPT_RIJNDAEL_128, $sign, pkcs5_pad($data,16), MCRYPT_MODE_CBC,$iv);
		$result = base64_encode($result);
		return $result;
	}

	public function login_check($user_id,$token)
	{
		$member = pdo_fetch('select * from '.tablename('member_system_member').' where id=:id and token=:token',array(':id'=>$user_id,':token'=>$token));
		return $member;
	}

}


function pkcs5_pad($text, $blocksize)
{
    $pad = $blocksize - (strlen($text) % $blocksize);
    return $text . str_repeat(chr($pad), $pad);
}