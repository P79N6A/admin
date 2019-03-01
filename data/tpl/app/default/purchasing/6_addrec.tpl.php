<?php defined('IN_IA') or exit('Access Denied');?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
	<link href="../addons/purchasing/template/mobile/css/mui.min.css" rel="stylesheet" />
	<script type="text/javascript" src="../web/resource/js/lib/jquery-1.11.1.min.js"></script>
	<style>
		*{margin:0;padding:0;}
		.account-head{width: 100%;background-color: #fff;}
		.account{background-color:#eee; }
		.rec a{text-decoration: none;color: black;}
		.rec{background-color: #fff;display: table;}
		.downlinerec{width: 100%;}
		.usermes{width: 50%;height: 60%;display: table;text-align: center;float: left;border-top: 10px solid #eee;background-color: #fff; border-right: 1px solid #eee;}
		.usermes tr td ul li{margin: 0;padding: 5px 10px;}
		.useract{width: 50%;background-color: #fff;border-top: 10px solid #eee; float: left;border-right: 1px solid #eee;text-align: center;}
		.useract input{border-radius: 15px; margin: 0;}
		.downlinere td ,tr ,input{text-align: center;vertical-align:middle}
		.btn{border: 1px solid #3e3e3e;background-color: #3e3e3e;border-radius: 20px;color: #fff;padding: 3px 7px;}
		table td ul{list-style: none;}
		table td ul li{float: left;margin-left: 10px;}
		.recharge-area{position: fixed;width: 100%;height: 100%;top: 0;left: 0;background: rgba(0,0,0,0.4);display: none;}
		#agent_percent table{width: 100%;border: 1px solid #eee;}
		#agent_percent table tr td{padding: 4px 8px;border-bottom: 1px solid #eee;}
		.recharge-main{width: 30%;height: 200px;margin: 10% auto;background: #fff;}
		.recharge-head{width: 100%;text-align: center;border-bottom: 1px solid #aaa;}
		.recharge-head h4{line-height: 30px;}
		.recharge-body{width: 100%;padding: 25px 35px;}
		#odds-set div table tbody tr td{padding: 4px 8px;}
		#odds-set div table tbody tr td input{width: 80%;height: 20px;}
	</style>
</head>
<body>
	<div class="account-head ">
		<div style="width: 100%;" class="rec">
			<div style="background-color: white;float: left;text-align: center;width: 50%">
				<a href="<?php  echo $this->createMobileUrl('home')?>"class="mui-icon mui-icon-left-nav mui-pull-left" style="background-color: white;line-height: 3vw;float: left;padding-top: 1%;color: #007aff;"></a>
			<h2 id="dnlinerec" style="font-weight: normal;font-size: 3vw;line-height: 3vw;text-align: center;display: table-cell;float: left;width: 93%;">下线
			</h2>
		</div>
			<h2 id="memberrec" style="font-weight: normal;font-size: 3vw;line-height: 3vw;text-align: center;display: table-cell;width: 50%;display: block;float: left;">会员
			</h2>
		</div>
		<div class="downlinerec">
			<table class="usermes">
				<?php  if(is_array($list1)) { foreach($list1 as $item1) { ?>
				<tr>
					<td style="width: 20%">
						<p style="margin-bottom: 5px;">账号:<?php  echo $item1['account'];?>&nbsp;&nbsp;<?php  echo $item1['nickname'];?></p>
						<p style="margin: 0;">积分：<?php  echo $item1['score'];?></p>
						<p>下线/会员：(<?php  echo $item1['agent_num'];?>/<?php  echo $item1['member_num'];?>)</p>
					</td>
					<td style="padding: 4px 0;">
						<ul>
							<li>
								<a href="javascript:void(0);" class="btn" onclick="recharge(<?php  echo $item1['id'];?>,1,1,<?php echo $_GPC['agent_id']?$_GPC['agent_id']:0?>)">充值</a>
							</li>
							<li>
								<a href="javascript:void(0);" class="btn" onclick="recharge(<?php  echo $item1['id'];?>,2,1,<?php echo $_GPC['agent_id']?$_GPC['agent_id']:0?>)">减值</a>
							</li>
							<li>
								<a href="<?php  echo $this->createMobileUrl('baobiaototal',array('agent_id'=>$item['id']))?>" class="btn">报表</a>
							</li>
							<li>
								<a href="javascript:void(0);" class="btn" onclick="show_percent(<?php  echo $item1['id'];?>)">户口详情</a>
							</li>
							<li>
								<a href="javascript:void(0);" class="btn" onclick="set_limit(<?php  echo $item1['id'];?>)">设置限额</a>
								<input type="hidden" id="limit_<?php  echo $item1['id'];?>" value="<?php  echo $item1['pay_limit'];?>">
							</li>
							<li>
								<a href="javascript:void(0);" class="btn" onclick="set_cashback(<?php  echo $item1['id'];?>)">设置反水</a>
							</li>
							<li>
								<a href="<?php  echo $this->createMobileUrl('addrec',array('agent_id'=>$item1['id']))?>" class="btn">下线/会员</a>
							</li>
							<?php  if($item1['parent_agent'] == $_SESSION['uid'] && $item1['parent_control'] == 1) { ?>
							<li>
								<a href="<?php  echo $this->createMobileUrl('home',array('agent_id'=>$item1['id']))?>" class="btn">增加下线/会员</a>
							</li>
							<?php  } ?>
							<li>
								<a href="javascript:void(0)" class="btn" onclick="set_password(<?php  echo $item1['id'];?>,1)">修改密码</a>
							</li>
						</ul>
					</td>
				</tr>
				<?php  } } ?>
			</table>
			<table class="usermes">
				<?php  if(is_array($list2)) { foreach($list2 as $item2) { ?>
				<tr>
					<td style="width: 20%">
						<p style="margin-bottom: 5px;">账号:<?php  echo $item2['account'];?>&nbsp;&nbsp;<?php  echo $item2['nickname'];?></p>
						<p style="margin: 0;">积分：<?php  echo $item2['score'];?></p>
					</td>
					<td style="padding: 4px 0;">
						<ul>
							<li>
								<a href="javascript:void(0);" class="btn" onclick="recharge(<?php  echo $item2['id'];?>,1,2,<?php echo $_GPC['agent_id']?$_GPC['agent_id']:0?>)">充值</a>
							</li>
							<li>
								<a href="javascript:void(0);" class="btn" onclick="recharge(<?php  echo $item2['id'];?>,2,2,<?php echo $_GPC['agent_id']?$_GPC['agent_id']:0?>)">减值</a>
							</li>
							<li>
								<?php  if($item2['status'] == 0) { ?>
								<a href="javascript:void(0);" class="btn" onclick="limit_bet(<?php  echo $item2['id'];?>,1)">限制投注</a>
								<?php  } else { ?>
								<a href="javascript:void(0);" class="btn" onclick="limit_bet(<?php  echo $item2['id'];?>,2)">开放投注</a>
								<?php  } ?>
							</li>
							<li>
								<a href="javascript:void(0)" class="btn" onclick="set_password(<?php  echo $item2['id'];?>,2)">修改密码</a>
							</li>
							<li>
								<a href="javascript:void(0)" class="btn" onclick="set_odds(<?php  echo $item2['id'];?>)">修改赔率</a>
							</li>
						</ul>
					</td>
				</tr>
				<?php  } } ?>
			</table>
		</div>
	</div>
	<div id="recharge-div" class="recharge-area">
		<div class="recharge-main">
			<div class="recharge-head">
			
			</div>
			<div class="recharge-body">
				<table>
					<tr>
						<td>充值/减值金额：</td>
						<td><input type="text" name="money" id="money"></td>
					</tr>
					<tr>
						<td>
							<input type="hidden" name="id" id="user_id">
							<input type="hidden" name="type" id="type">
							<input type="hidden" name="user_type" id="user_type">
							<input type="hidden" name="agent_id" id="agent_id">
						</td>
						<td>
							<a href="javascript:void(0);" class="btn" onclick="recharge_post()">提交</a>
							<a href="javascript:void(0);" class="btn" onclick="$('#recharge-div').hide();">取消</a>
						</td>
					</tr>
				</table>
			</div>
		</div>
	</div>
	<div id="limit-div" class="recharge-area">
		<div class="recharge-main">
			<div class="recharge-head">
				设置限额
			</div>
			<div class="recharge-body">
				<table>
					<tr>
						<td>限额金额：</td>
						<td><input type="text" name="limit" id="limit"></td>
					</tr>
					<tr>
						<td>
							<input type="hidden" name="id" id="luser_id">
						</td>
						<td>
							<a href="javascript:void(0);" class="btn" onclick="limit_post()">提交</a>
							<a href="javascript:void(0);" class="btn" onclick="$('#limit-div').hide();">取消</a>
						</td>
					</tr>
				</table>
			</div>
		</div>
	</div>
	<div id="password-div" class="recharge-area">
		<div class="recharge-main">
			<div class="recharge-head">
			
			</div>
			<div class="recharge-body">
				<table>
					<tr>
						<td>密码：</td>
						<td><input type="text" name="password" id="password"></td>
					</tr>
					<tr>
						<td>
							<input type="hidden" name="id" id="puser_id">
							<input type="hidden" name="user_type" id="puser_type">
						</td>
						<td>
							<a href="javascript:void(0);" class="btn" onclick="password_post()">提交</a>
							<a href="javascript:void(0);" class="btn" onclick="$('#password-div').hide();">取消</a>
						</td>
					</tr>
				</table>
			</div>
		</div>
	</div>
	<div id="percent-div" class="recharge-area">
		<div class="recharge-main" style="height: 300px;">
			<div class="recharge-head">
				户口详情
			</div>
			<div class="recharge-body" id="agent_percent">
				
			</div>
			<a href="javascript:void(0);" class="btn" onclick="$('#percent-div').hide();" style="margin: 0 auto;display: block;width: 70px;height: 30px;line-height: 25px;text-align: center;">确定</a>
		</div>
	</div>
	<div id="cashback-area" class="recharge-area">
		<div class="recharge-main" style="height: 300px;">
			<div class="recharge-head">
				设置反水
			</div>
			<div class="recharge-body">
				<table>
					<tr id="cashback_setting">
						
					</tr>
					<tr>
						<td colspan="13">
							<input type="hidden" name="id" id="cuser_id">
							<a href="javascript:void(0);" class="btn" onclick="cashback_post()">提交</a>
							<a href="javascript:void(0);" class="btn" onclick="$('#cashback-area').hide();">取消</a>
						</td>
					</tr>
				</table>
			</div>
		</div>
	</div>
	<div id="odds-set" class="recharge-area">
		<div class="recharge-main" style="height: 30vw;width: 95%;overflow-y: auto;">
			<div class="recharge-head">
				设置赔率
			</div>
			<div class="recharge-body" style="padding: 10px 15px;">
				<table>
					<tr>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td>彩金</td>
						<td><input type="text" name="jackpot" value="<?php  echo $jackpot;?>" readonly="readonly"></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
					</tr>
					<tr>
						<td>我的反水</td>
						<td></td>
						<td><input type="text" class="my_cashback" value="<?php  echo $cash['B'];?>" readonly="readonly"></td>
						<td></td>
						<td><input type="text" class="my_cashback" value="<?php  echo $cash['S'];?>" readonly="readonly"></td>
						<td></td>
						<td><input type="text" class="my_cashback" value="<?php  echo $cash['A'];?>" readonly="readonly"></td>
						<td></td>
						<td><input type="text" class="my_cashback" value="<?php  echo $cash['3ABC'];?>" readonly="readonly"></td>
						<td></td>
						<td><input type="text" class="my_cashback" value="<?php  echo $cash['4A'];?>" readonly="readonly"></td>
						<td></td>
						<td><input type="text" class="my_cashback" value="<?php  echo $cash['4ABC'];?>" readonly="readonly"></td>
						<td></td>
						<td><input type="text" class="my_cashback" value="<?php  echo $cash['2A'];?>" readonly="readonly"></td>
						<td></td>
						<td><input type="text" class="my_cashback" value="<?php  echo $cash['2ABC'];?>" readonly="readonly"></td>
					</tr>
					<tr>
						<td>水钱</td>
						<td></td>
						<td><span id="cashback_money_b"></span></td>
						<td></td>
						<td><span id="cashback_money_s"></span></td>
						<td></td>
						<td><span id="cashback_money_a"></span></td>
						<td></td>
						<td><span id="cashback_money_3abc"></span></td>
						<td></td>
						<td><span id="cashback_money_4a"></span></td>
						<td></td>
						<td><span id="cashback_money_4abc"></span></td>
						<td></td>
						<td><span id="cashback_money_2a"></span></td>
						<td></td>
						<td><span id="cashback_money_2abc"></span></td>
					</tr>
					<tr>
						<td style="width: 70px;">头奖</td>
						<td style="width: 30px;">B</td>
						<td style="width: 100px;padding: 4px 0;"><input type="text" value="0" class="odds_b" name="odds[B][]" data-value="odds_b_0" onkeyup="keyupcheck(this)"></td>
						<td style="width: 30px;">S</td>
						<td style="width: 100px;padding: 4px 0;"><input type="text" value="0" class="odds_s" name="odds[S][]" data-value="odds_s_0" onkeyup="keyupcheck(this)"></td>
						<td style="width: 30px;">A</td>
						<td style="width: 100px;padding: 4px 0;"><input type="text" value="0" class="odds_a" name="odds[A][]" data-value="odds_a" onkeyup="keyupcheck(this)"></td>
						<td style="width: 70px;">3ABC</td>
						<td style="width: 100px;padding: 4px 0;"><input type="text" value="0" class="odds_3abc" name="odds[3ABC][]" data-value="odds_3abc_0" onkeyup="keyupcheck(this)"></td>
						<td style="width: 30px;">4A</td>
						<td style="width: 100px;padding: 4px 0;"><input type="text" value="0" class="odds_4a" name="odds[4A][]" data-value="odds_4a" onkeyup="keyupcheck(this)"></td>
						<td style="width: 60px;">4AC</td>
						<td style="width: 100px;padding: 4px 0;"><input type="text" value="0" class="odds_4abc" name="odds[4ABC][]" data-value="odds_4abc_0" onkeyup="keyupcheck(this)"></td>
						<td style="width: 30px;">2A</td>
						<td style="width: 100px;padding: 4px 0;"><input type="text" value="0" class="odds_2a" name="odds[2A][]" data-value="odds_2a" onkeyup="keyupcheck(this)"></td>
						<td style="width: 70px;">2ABC</td>
						<td style="width: 100px;padding: 4px 0;"><input type="text" value="0" class="odds_2abc" name="odds[2ABC][]" data-value="odds_2abc_0" onkeyup="keyupcheck(this)"></td>
					</tr>
					<tr>
						<td>二奖</td>
						<td>B</td>
						<td><input type="text" value="0" class="odds_b" name="odds[B][]" data-value="odds_b_1" onkeyup="keyupcheck(this)"></td>
						<td>S</td>
						<td><input type="text" value="0" class="odds_s" name="odds[S][]" data-value="odds_s_1" onkeyup="keyupcheck(this)"></td>
						<td>C2</td>
						<td><input type="text" value="0" class="odds_a" name="odds[C2][]" data-value="odds_c2" onkeyup="keyupcheck(this)"></td>
						<td>3ABC</td>
						<td><input type="text" value="0" class="odds_3abc" name="odds[3ABC][]" data-value="odds_3abc_1" onkeyup="keyupcheck(this)"></td>
						<td>4B</td>
						<td><input type="text" value="0" class="odds_4a" name="odds[4B][]" data-value="odds_4b" onkeyup="keyupcheck(this)"></td>
						<td>4AC</td>
						<td><input type="text" value="0" class="odds_4abc" name="odds[4ABC][]" data-value="odds_4abc_1" onkeyup="keyupcheck(this)"></td>
						<td>2B</td>
						<td><input type="text" value="0" class="odds_2a" name="odds[2B][]" data-value="odds_2b" onkeyup="keyupcheck(this)"></td>
						<td>2ABC</td>
						<td><input type="text" value="0" class="odds_2abc" name="odds[2ABC][]" data-value="odds_2abc_1" onkeyup="keyupcheck(this)"></td>
					</tr>
					<tr>
						<td>三奖</td>
						<td>B</td>
						<td><input type="text" value="0" class="odds_b" name="odds[B][]" data-value="odds_b_2" onkeyup="keyupcheck(this)"></td>
						<td>S</td>
						<td><input type="text" value="0" class="odds_s" name="odds[S][]" data-value="odds_s_2" onkeyup="keyupcheck(this)"></td>
						<td>C3</td>
						<td><input type="text" value="0" class="odds_a" name="odds[C3][]" data-value="odds_c3" onkeyup="keyupcheck(this)"></td>
						<td>3ABC</td>
						<td><input type="text" value="0" class="odds_3abc" name="odds[3ABC][]" data-value="odds_3abc_2" onkeyup="keyupcheck(this)"></td>
						<td>4C</td>
						<td><input type="text" value="0" class="odds_4a" name="odds[4C][]" data-value="odds_4c" onkeyup="keyupcheck(this)"></td>
						<td>4AC</td>
						<td><input type="text" value="0" class="odds_4abc" name="odds[4ABC][]" data-value="odds_4abc_2" onkeyup="keyupcheck(this)"></td>
						<td>2C</td>
						<td><input type="text" value="0" class="odds_2a" name="odds[2C][]" data-value="odds_2c" onkeyup="keyupcheck(this)"></td>
						<td>2ABC</td>
						<td><input type="text" value="0" class="odds_2abc" name="odds[2ABC][]" data-value="odds_2abc_2" onkeyup="keyupcheck(this)"></td>
					</tr>
					<tr>
						<td>特别奖</td>
						<td>B</td>
						<td><input type="text" value="0" class="odds_b" name="odds[B][]" data-value="odds_b_3" onkeyup="keyupcheck(this)"></td>
						<td></td>
						<td></td>
						<td>C4</td>
						<td><input type="text" value="0" class="odds_a" name="odds[C4][]" data-value="odds_c4" onkeyup="keyupcheck(this)"></td>
						<td></td>
						<td></td>
						<td>4D</td>
						<td><input type="text" value="0" class="odds_4a" name="odds[4D][]" data-value="odds_4d" onkeyup="keyupcheck(this)"></td>
						<td></td>
						<td></td>
						<td>2D</td>
						<td><input type="text" value="0" class="odds_2a" name="odds[2D][]" data-value="odds_2d" onkeyup="keyupcheck(this)"></td>
						<td></td>
						<td></td>
					</tr>
					<tr>
						<td>安慰奖</td>
						<td>B</td>
						<td><input type="text" value="0" class="odds_b" name="odds[B][]" data-value="odds_b_4" onkeyup="keyupcheck(this)"></td>
						<td></td>
						<td></td>
						<td>C5</td>
						<td><input type="text" value="0" class="odds_a" name="odds[C5][]" data-value="odds_c5" onkeyup="keyupcheck(this)"></td>
						<td></td>
						<td></td>
						<td>4E</td>
						<td><input type="text" value="0" class="odds_4a" name="odds[4E][]" data-value="odds_4e" onkeyup="keyupcheck(this)"></td>
						<td></td>
						<td></td>
						<td>2E</td>
						<td><input type="text" value="0" class="odds_2a" name="odds[2E][]" data-value="odds_2e" onkeyup="keyupcheck(this)"></td>
						<td></td>
						<td></td>
					</tr>
					<tr>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td>EC</td>
						<td><input type="text" value="0" class="odds_a" name="odds[EC][]" data-value="odds_ec" onkeyup="keyupcheck(this)"></td>
						<td></td>
						<td></td>
						<td>EA</td>
						<td><input type="text" value="0" class="odds_4a" name="odds[EA][]" data-value="odds_ea" onkeyup="keyupcheck(this)"></td>
						<td></td>
						<td></td>
						<td>EX</td>
						<td><input type="text" value="0" class="odds_2a" name="odds[EX][]" data-value="odds_ex" onkeyup="keyupcheck(this)"></td>
						<td></td>
						<td></td>
					</tr>
					<tr>
						<td colspan="17">
							<input type="hidden" name="id" id="member_id">
							<a href="javascript:void(0);" class="btn" onclick="odds_post()">提交</a>
							<a href="javascript:void(0);" class="btn" onclick="$('#odds-set').hide();">取消</a>
						</td>
					</tr>
				</table>
			</div>
		</div>
	</div>
	<script type="text/javascript">
		function recharge(id,type,user_type,agent_id) {
			if (type == 1) {
				var txt = '<h4>充值</h4>';
			}
			if (type == 2) {
				var txt = '<h4>减值</h4>';
			}
			$('.recharge-head').html(txt);
			$('#user_id').val(id);
			$('#type').val(type);
			$('#user_type').val(user_type);
			$('#agent_id').val(agent_id);
			$('#recharge-div').show();
		}
		function set_password(id,user_type) {
			$('#puser_id').val(id);
			$('#puser_type').val(user_type);
			$('#password-div').show();
		}

		function limit_bet(id,type) {
			if (type == 1) {
				var a = confirm('确定限制该用户投注吗？');
			}
			else{
				var a = confirm('确定开放该用户投注吗？');
			}
			if (a == true) {
				$.post("<?php  echo $this->createMobileUrl('set_black')?>",{id:id,type:type},function(result) {
					alert(result.info);
					if (result.status == 1) {
						window.location.reload();
					}
					if (result.status == 3) {
						location.href="./index.php?i=6&c=entry&m=purchasing&do=login";
					}
				},'JSON');
			}
		}

		function set_odds(id) {
			$('#member_id').val(id);
			$.post("<?php  echo $this->createMobileUrl('get_member_odds')?>",{id:id},function(result) {
				var list = result.list;
				var odds_b = list.odds_B;
				var odds_s = list.odds_S;
				var odds_3abc = list.odds_3ABC;
				var odds_4abc = list.odds_4ABC;
				var odds_2abc = list.odds_2ABC;
				for (var i = 0 in odds_b) {
					$('input[data-value=odds_b_'+i+']').val(odds_b[i]);
				}
				for (var j = 0 in odds_s) {
					$('input[data-value=odds_s_'+j+']').val(odds_s[j]);
				}
				for (var k = 0 in odds_3abc) {
					$('input[data-value=odds_3abc_'+k+']').val(odds_3abc[k]);
				}
				for (var l = 0 in odds_4abc) {
					$('input[data-value=odds_4abc_'+l+']').val(odds_4abc[l]);
				}
				for (var m = 0 in odds_2abc) {
					$('input[data-value=odds_2abc_'+m+']').val(odds_2abc[m]);
				}
				$('input[data-value=odds_a]').val(list.odds_A);
				$('input[data-value=odds_c2]').val(list.odds_C2);
				$('input[data-value=odds_c3]').val(list.odds_C3);
				$('input[data-value=odds_c4]').val(list.odds_C4);
				$('input[data-value=odds_c5]').val(list.odds_C5);
				$('input[data-value=odds_4a]').val(list.odds_4A);
				$('input[data-value=odds_4b]').val(list.odds_4B);
				$('input[data-value=odds_4c]').val(list.odds_4C);
				$('input[data-value=odds_4d]').val(list.odds_4D);
				$('input[data-value=odds_4e]').val(list.odds_4E);
				$('input[data-value=odds_2a]').val(list.odds_2A);
				$('input[data-value=odds_2b]').val(list.odds_2B);
				$('input[data-value=odds_2c]').val(list.odds_2C);
				$('input[data-value=odds_2d]').val(list.odds_2D);
				$('input[data-value=odds_2e]').val(list.odds_2E);
				$('input[data-value=odds_ec]').val(list.odds_EC);
				$('input[data-value=odds_ea]').val(list.odds_EA);
				$('input[data-value=odds_ex]').val(list.odds_EX);
				$('#odds-set').show();
			},'JSON');
		}
		function setallodds(odds,cl) {
			if (cl == 'odds_a') {
				$('input[data-value=odds_a]').val(odds);
				$('input[data-value=odds_c2]').val(odds);
				$('input[data-value=odds_c3]').val(odds);
				$('input[data-value=odds_c4]').val(odds/10);
				$('input[data-value=odds_c5]').val(odds/10);
				$('input[data-value=odds_ec]').val(odds/23);
			}
			if (cl == 'odds_2a') {
				$('input[data-value=odds_2a]').val(odds);
				$('input[data-value=odds_2b]').val(odds);
				$('input[data-value=odds_2c]').val(odds);
				$('input[data-value=odds_2d]').val(odds/10);
				$('input[data-value=odds_2e]').val(odds/10);
				$('input[data-value=odds_ex]').val(odds/23);
			}
			if (cl == 'odds_4a') {
				$('input[data-value=odds_4a]').val(odds);
				$('input[data-value=odds_4b]').val(odds);
				$('input[data-value=odds_4c]').val(odds);
				$('input[data-value=odds_4d]').val(odds/10);
				$('input[data-value=odds_4e]').val(odds/10);
				$('input[data-value=odds_ea]').val(odds/23);
			}
		}
		function odds_post() {
			var member_id = $('#member_id').val();
			var odds_b = [];
			var odds_s = [];
			var odds_a = [];
			var odds_3abc = [];
			var odds_4a = [];
			var odds_4abc = [];
			var odds_2a = [];
			var odds_2abc = [];
			$('.odds_b').each(function () {
				odds_b.push(parseFloat($(this).val()));
			});

			$('.odds_s').each(function () {
				odds_s.push(parseFloat($(this).val()));
			});

			$('.odds_3abc').each(function () {
				odds_3abc.push(parseFloat($(this).val()));
			});

			$('.odds_4abc').each(function () {
				odds_4abc.push(parseFloat($(this).val()));
			});

			$('.odds_2abc').each(function () {
				odds_2abc.push(parseFloat($(this).val()));
			});

			$('.odds_2a').each(function () {
				odds_2a.push(parseFloat($(this).val()));
			});

			$('.odds_4a').each(function () {
				odds_4a.push(parseFloat($(this).val()));
			});

			$('.odds_a').each(function () {
				odds_a.push(parseFloat($(this).val()));
			});

			var odds = {'B':odds_b,'S':odds_s,'A':odds_a,'3ABC':odds_3abc,'4ABC':odds_4abc,'2ABC':odds_2abc,'2A':odds_2a,'4A':odds_4a};
			$.post("<?php  echo $this->createMobileUrl('save_member_odds')?>",{odds:odds,member_id:member_id},function(result) {
				alert(result.info);
				if (result.status == 3) {
					location.href="./index.php?i=6&c=entry&m=purchasing&do=login";
				}
				if (result.status == 1) {
					window.location.reload();
				}
			},'JSON');
		}
		function recharge_post() {
			var score = $('#money').val();
			var user_id = $('#user_id').val();
			var type = $('#type').val();
			var user_type = $('#user_type').val();
			var agent_id = $('#agent_id').val();
			if (!score) {
				alert('请填写充值/减值分数');
				return false;
			}
			$.post("<?php  echo $this->createMobileUrl('change_score')?>",{score:score,agent_id:user_id,score_type:type,user_type:user_type,user_id:agent_id},function (result) {
				if (result.status == 405) {
					alert(result.info);
					location.href = "<?php  echo $this->createMobileUrl('login')?>";
				}
				if (result.status == 300) {
					alert(result.info);
				}
				if (result.status == 200) {
					alert(result.info);
					window.location.reload();
				}
			},'JSON')
		}
		function password_post() {
			var user_id = $('#puser_id').val();
			var user_type = $('#puser_type').val();
			var password = $('#password').val();
			if (!password || password == '') {
				alert('请输入密码');
				return false;
			}
			$.post("<?php  echo $this->createMobileUrl('set_password')?>",{user_id:user_id,user_type:user_type,password:password},function(result) {
				if (result.status == 405) {
					alert(result.info);
					location.href = "<?php  echo $this->createMobileUrl('login')?>";
				}
				if (result.status == 300) {
					alert(result.info);
				}
				if (result.status == 200) {
					alert(result.info);
					window.location.reload();
				}
			},'JSON')
		}
		function show_percent(id) {
			$.post("<?php  echo $this->createMobileUrl('get_percent')?>",{agent_id:id},function(result) {
				if (result.status == 3) {
					location.href="<?php  echo $this->createMobileUrl('login')?>";
				}
				else{
					var list = result.list;
					var txt = '<table>';
					txt += '<tr><td>彩金</td><td>'+list.jackpot_percent+'</td><td>分红</td><td>'+list.bonus_percent+'</td></tr>';
					var cashback = list.cashback_percent;
					txt += '<tr><td colspan="4">反水</td></tr>';
					txt += '<tr><td>B</td><td>'+cashback.B+'</td><td>S</td><td>'+cashback.S+'</td></tr>';
					txt += '<tr><td>A~EC</td><td>'+cashback.A+'</td><td>3ABC</td><td>'+cashback['3ABC']+'</td></tr>';
					txt += '<tr><td>4A~EA</td><td>'+cashback['4A']+'</td><td>4AC</td><td>'+cashback['4ABC']+'</td></tr>';
					txt += '<tr><td>2A~EX</td><td>'+cashback['2A']+'</td><td>2AC</td><td>'+cashback['2ABC']+'</td></tr>';
					txt += '</table>';
					$('#agent_percent').empty();
					$('#agent_percent').html(txt);
					$('#percent-div').show();
				}
			},'JSON');
		}
		function set_cashback(uid) {
			$.post("<?php  echo $this->createMobileUrl('get_percent')?>",{agent_id:uid},function(result) {
				if (result.status == 3) {
					location.href="<?php  echo $this->createMobileUrl('login')?>";
				}
				else{
					var list = result.list;
					var txt = '<td><table>';
					var cashback = list.cashback_percent;
					txt += '<tr><td>B</td><td><input type="text" name="cashback_b" value="'+cashback.B+'"></td><td>S</td><td><input type="text" name="cashback_s" value="'+cashback.S+'"></td></tr>';
					txt += '<tr><td>A~EC</td><td><input type="text" name="cashback_a" value="'+cashback.A+'"></td><td>3ABC</td><td><input type="text" name="cashback_3abc" value="'+cashback['3ABC']+'"></td></tr>';
					txt += '<tr><td>4A~EA</td><td><input type="text" name="cashback_4a" value="'+cashback['4A']+'"></td><td>4AC</td><td><input type="text" name="cashback_4abc" value="'+cashback['4ABC']+'"></td></tr>';
					txt += '<tr><td>2A~EX</td><td><input type="text" name="cashback_2a" value="'+cashback['2A']+'"></td><td>2AC</td><td><input type="text" name="cashback_2abc" value="'+cashback['2ABC']+'"></td></tr>';
					txt += '</td></table>';
					$('#cuser_id').val(list.agent_id);
					$('#cashback_setting').empty();
					$('#cashback_setting').html(txt);
					$('#cashback-area').show();
				}
			},'JSON')
		}
		function cashback_post() {
			var id = $('#cuser_id').val();
			var cashback_b = $('input[name=cashback_b]').val();
			var cashback_s = $('input[name=cashback_s]').val();
			var cashback_a = $('input[name=cashback_a]').val();
			var cashback_3abc = $('input[name=cashback_3abc]').val();
			var cashback_4a = $('input[name=cashback_4a]').val();
			var cashback_4abc = $('input[name=cashback_4abc]').val();
			var cashback_2a = $('input[name=cashback_2a]').val();
			var cashback_2abc = $('input[name=cashback_2abc]').val();
			var cashback = {"B":cashback_b,"S":cashback_s,"A":cashback_a,"3ABC":cashback_3abc,"4A":cashback_4a,"4ABC":cashback_4abc,"2A":cashback_2a,"2ABC":cashback_2abc};
			$.post("<?php  echo $this->createMobileUrl('set_percent')?>",{agent_id:id,cashback:cashback},function(result) {
				alert(result.info);
				if (result.status == 1) {
					window.location.reload();
				}
				if (result.status == 3) {
					location.href = "<?php  echo $this->createMobileUrl('login')?>";
				}
			},'JSON');
		}
		function set_limit(id) {
			var limit = $('#limit_'+id).val();
			$('#limit').val(limit);
			$('#luser_id').val(id);
			$('#limit-div').show();
		}
		function limit_post() {
			var limit = $('#limit').val();
			var id = $('#luser_id').val();
			$.post("<?php  echo $this->createMobileUrl('set_limit')?>",{id:id,limit:limit},function(result) {
				alert(result.info);
				if (result.status == 1) {
					window.location.reload();
				}
				if (result.status == 3) {
					location.href = "<?php  echo $this->createMobileUrl('login')?>";
				}
			},'JSON');
		}
		function keyupcheck(obj) {
			obj.value=obj.value.replace(/[^\d{1,}\.\d{1,}|\d{1,}]/g,'');
			var cl = $(obj).attr('class');
			if (cl == 'odds_b' || cl == 'odds_s' ||  cl == 'odds_4abc' || cl == 'odds_4a') {
				var odds = [];
				$('.'+cl).each(function () {
					odds.push(parseFloat($(this).val()));
				});
				if (cl == 'odds_4a') {
					var odds_check = get_max(odds);
				}
				else{
					var odds_check = getTotal(odds);
				}
				if (odds_check>10000) {
					$(obj).val('');
				}
			}
			if (cl == 'odds_3abc' || cl == 'odds_a') {
				var odds = [];
				$('.'+cl).each(function () {
					odds.push(parseFloat($(this).val()));
				});
				if (cl == 'odds_a') {
					var odds_check = get_max(odds);
				}
				else{
					var odds_check = getTotal(odds);
				}
				if (odds_check>1000) {
					$(obj).val('');
				}
			}
			if (cl == 'odds_2abc' || cl == 'odds_2a') {
				var odds = [];
				$('.'+cl).each(function () {
					odds.push(parseFloat($(this).val()));
				});
				if (cl == 'odds_2a') {
					var odds_check = get_max(odds);
				}
				else{
					var odds_check = getTotal(odds);
				}
				if (odds_check > 100) {
					$(obj).val('');
				}
			}
		}
		function cal_shuiqia(total_money, cashback_rate, jackpot_rate,number_type) {		
			var shui_qian_value =0;
			if (number_type == 3 ) {
				shui_qian_value = 100 - total_money - cashback_rate -  	jackpot_rate;
			}else if( number_type == 2 ){
				shui_qian_value = (1000 - total_money - cashback_rate*10 - jackpot_rate*10)/10;
			}else if( number_type == 1 ){
				shui_qian_value = (10000 - total_money - cashback_rate*100 - jackpot_rate*100)/100;
			}

			if (shui_qian_value < 0) {
				shui_qian_value = 0;
			}
			if ( shui_qian_value > 100 ) {
				shui_qian_value = 100;
			}
			return shui_qian_value;
		}
		$('input').blur(function () {

			var odds_b = [];
			var odds_s = [];
			var odds_a = [];
			var odds_3abc = [];
			var odds_4a = [];
			var odds_4abc = [];
			var odds_2a = [];
			var odds_2abc = [];
			var my_cashback = [];

			var jackpot = parseFloat($('input[name=jackpot]').val());

			$('.my_cashback').each(function() {
				my_cashback.push(parseFloat($(this).val()));
			});

			$('.odds_b').each(function () {
				odds_b.push(parseFloat($(this).val()));
			});
			var odds_b_total = getTotal(odds_b);
			var cashback_money_b = cal_shuiqia(odds_b_total,(my_cashback[0]),jackpot,1);
			

			$('.odds_s').each(function () {
				odds_s.push(parseFloat($(this).val()));
			});
			var odds_s_total = getTotal(odds_s);
			var cashback_money_s = cal_shuiqia(odds_s_total,(my_cashback[1]),jackpot,1);

			$('.odds_3abc').each(function () {
				odds_3abc.push(parseFloat($(this).val()));
			});
			var odds_3abc_total = getTotal(odds_3abc);
			var cashback_money_3abc = cal_shuiqia(odds_3abc_total,(my_cashback[3]),jackpot,2);

			$('.odds_4abc').each(function () {
				odds_4abc.push(parseFloat($(this).val()));
			});
			var odds_4abc_total = getTotal(odds_4abc);
			var cashback_money_4abc = cal_shuiqia(odds_4abc_total,(my_cashback[5]),jackpot,1);

			$('.odds_2abc').each(function () {
				odds_2abc.push(parseFloat($(this).val()));
			});
			var odds_2abc_total = getTotal(odds_2abc);
			var cashback_money_2abc = cal_shuiqia(odds_2abc_total,(my_cashback[7]),jackpot,3);

			$('.odds_2a').each(function () {
				odds_2a.push(parseFloat($(this).val()));
			});
			var odds_2a_max = get_max(odds_2a);
			var cashback_money_2a = cal_shuiqia(odds_2a_max,(my_cashback[6]),jackpot,3);
			setallodds(odds_2a_max,'odds_2a');

			$('.odds_4a').each(function () {
				odds_4a.push(parseFloat($(this).val()));
			});
			var odds_4a_max = get_max(odds_4a);
			var cashback_money_4a = cal_shuiqia(odds_4a_max,(my_cashback[4]),jackpot,1);
			setallodds(odds_4a_max,'odds_4a');

			$('.odds_a').each(function () {
				odds_a.push(parseFloat($(this).val()));
			});
			var odds_a_max = get_max(odds_a);
			var cashback_money_a = cal_shuiqia(odds_a_max,(my_cashback[2]),jackpot,2);
			setallodds(odds_a_max,'odds_a');
			console.log(cashback_money_a);

			$('#cashback_money_b').text(parseInt(cashback_money_b));
			$('#cashback_money_s').text(parseInt(cashback_money_s));
			$('#cashback_money_a').text(parseInt(cashback_money_a));
			$('#cashback_money_3abc').text(parseInt(cashback_money_3abc));
			$('#cashback_money_4a').text(parseInt(cashback_money_4a));
			$('#cashback_money_4abc').text(parseInt(cashback_money_4abc));
			$('#cashback_money_2a').text(parseInt(cashback_money_2a));
			$('#cashback_money_2abc').text(parseInt(cashback_money_2abc));
		});
		function get_max(obj) {
			var max = obj[0];
			var len = obj.length;
			for (var i = 1; i < len; i++){
				if (i >= 3) {
					obj[i] = obj[i]*10;
				}
				if (obj[i] > max) {
					max = obj[i];
				}
			}
			return max;
		}
		function getTotal(obj) {
			var len = obj.length;
			var total = 0;
			for (var i = 0; i < len; i++) {
				if (i>=3) {
					total = total + obj[i]*10;
				}
				else{
					total = total + obj[i];
				}
			}
			return total;
		}
	</script>
	<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('index', TEMPLATE_INCLUDEPATH)) : (include template('index', TEMPLATE_INCLUDEPATH));?>
</body>
</html>