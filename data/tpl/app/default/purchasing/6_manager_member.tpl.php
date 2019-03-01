<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('header', TEMPLATE_INCLUDEPATH)) : (include template('header', TEMPLATE_INCLUDEPATH));?>
<script type="text/javascript" src="../addons/purchasing/static/js/cashback.js"></script>
<style type="text/css" media="screen">
	table tr td input[type=text]{width: 50px;height: 18px;font-size: 16px;}
	.table>tbody>tr>td{padding: 2px 2px;}
</style>
<div class="col-xs-12" style="padding: 0;margin-bottom: 10px;">
	<button type="button" class="btn btn-success btn-lg" onclick="odds_post()">提交</button>
</div>
<table class="table table-bordered">
	<tr style="border-top: 5px solid #eee; ">
		<td>账号</td>
		<td><?php  echo $member['account'];?></td>
		<?php  if($_SESSION['level'] <= 4) { ?>
		<td>密码</td>
		<td><input type="text" name="password" class="input1" placeholder="请输入密码" style="width: 100%;"></td>
		<?php  } ?>
	</tr>
	<tr>
		<td>昵称</td>
		<td><input type="text" name="nickname" class="input1" value="<?php  echo $member['nickname'];?>" style="width: 100%;"></td>
		<?php  if($_SESSION['level'] <= 4) { ?>
		<td>确认密码</td>
		<td><input type="text" name="repassword" class="input1" placeholder="请再次输入密码" style="width: 100%;"></td>
		<?php  } ?>
	</tr>
	<tr>
		<td>手机号码</td>
		<td>
			<input type="text" name="mobile" value="<?php  echo $member['mobile'];?>" onkeyup="value=value.replace(/[^\d]/g,'')" style="width: 100%;">
		</td>
		<td>状态</td>
		<td colspan="3">
			<select name="status">
				<option value="0" <?php  if($member['status'] == 0) { ?>selected<?php  } ?>>活跃</option>
				<option value="2" <?php  if($member['status'] == 2) { ?>selected<?php  } ?>>试用</option>
				<option value="1" <?php  if($member['status'] == 1) { ?>selected<?php  } ?>>禁用</option>
			</select>
		</td>
	</tr>
</table>
<table class="table table-bordered">
	<tr>
		<td colspan="5">
			上线积分：<?php  echo $parent['credit1'];?>
		</td>
		<td colspan="5">
			当前积分：(母分：<?php  echo $member['credit1'];?>)(子分：<?php  echo $member['credit2'];?>)
		</td>
	</tr>
	<tr>
		<td>充/减值：</td>
		<td colspan="2">
			<input type="text" onkeyup="check_num(this);" name="recharge" style="width: 100px;" <?php  if($member['auto_recharge'] == 1) { ?>disabled<?php  } ?>> X = <input type="text" name="give" maxlength="2" value="<?php  echo $member['give'];?>" onkeyup="value=value.replace(/[^\d]/g,'')" <?php  if($member['auto_recharge'] == 1) { ?>disabled<?php  } ?>>%
		</td>
		<td colspan="7">
			自动回值： <input type="checkbox" name="auto_recharge" value="1" id="auto_recharge" <?php  if($member['auto_recharge'] == 1) { ?>checked<?php  } ?>>
			&nbsp;&nbsp;&nbsp;
			回值额度： <input type="text" name="auto_value" onkeyup="value=value.replace(/[^\d]/g,'')" <?php  if($member['auto_recharge'] == 0) { ?>disabled<?php  } else { ?>value="<?php  echo $member['auto_value'];?>"<?php  } ?>>
		</td>
	</tr>
	<tr>
		<td>总额控制(控制一张单的投注总额)</td>
		<td><input type="text" name="limit" id="limit" value="<?php  echo $member['pay_limit'];?>" onkeyup="value=value.replace(/[^\d]/g,'')" style="width: 100px;"></td>
	</tr>
	<tr>
		<td>控制红字</td>
		<td>
			(4D)
		</td>
		<td>
			B<input type="text" name="red" value="<?php  echo $red_info['B'];?>" placeholder="B" onkeyup="value=value.replace(/[^\d]/g,'')">
		</td>
		<td>
			S<input type="text" name="red" value="<?php  echo $red_info['S'];?>" placeholder="S" onkeyup="value=value.replace(/[^\d]/g,'')">
		</td>
		<td>
			4A<input type="text" name="red" value="<?php  echo $red_info['4A'];?>" placeholder="4A" onkeyup="value=value.replace(/[^\d]/g,'')">
		</td>
		<td>
			4B<input type="text" name="red" value="<?php  echo $red_info['4B'];?>" placeholder="4B" onkeyup="value=value.replace(/[^\d]/g,'')">
		</td>
		<td>
			4C<input type="text" name="red" value="<?php  echo $red_info['4C'];?>" placeholder="4C" onkeyup="value=value.replace(/[^\d]/g,'')">
		</td>
		<td>
			4D<input type="text" name="red" value="<?php  echo $red_info['4D'];?>" placeholder="4D" onkeyup="value=value.replace(/[^\d]/g,'')">
		</td>
		<td>
			4E<input type="text" name="red" value="<?php  echo $red_info['4E'];?>" placeholder="4E" onkeyup="value=value.replace(/[^\d]/g,'')">
		</td>
		<td>
			4ABC<input type="text" name="red" value="<?php  echo $red_info['4ABC'];?>" placeholder="4ABC" onkeyup="value=value.replace(/[^\d]/g,'')">
		</td>
		<td>
			EA<input type="text" name="red" value="<?php  echo $red_info['EA'];?>" placeholder="EA" onkeyup="value=value.replace(/[^\d]/g,'')">
		</td>
	</tr>
	<tr>
		<td></td>
		<td>
			(3D)
		</td>
		<td>
			A<input type="text" name="red" value="<?php  echo $red_info['A'];?>" placeholder="A" onkeyup="value=value.replace(/[^\d]/g,'')">
		</td>
		<td>
			C2<input type="text" name="red" value="<?php  echo $red_info['C2'];?>" placeholder="C2" onkeyup="value=value.replace(/[^\d]/g,'')">
		</td>
		<td>
			C3<input type="text" name="red" value="<?php  echo $red_info['C3'];?>" placeholder="C3" onkeyup="value=value.replace(/[^\d]/g,'')">
		</td>
		<td>
			C4<input type="text" name="red" value="<?php  echo $red_info['C4'];?>" placeholder="C4" onkeyup="value=value.replace(/[^\d]/g,'')">
		</td>
		<td>
			C5<input type="text" name="red" value="<?php  echo $red_info['C5'];?>" placeholder="C5" onkeyup="value=value.replace(/[^\d]/g,'')">
		</td>
		<td>
			3ABC<input type="text" name="red" value="<?php  echo $red_info['3ABC'];?>" placeholder="3ABC" onkeyup="value=value.replace(/[^\d]/g,'')">
		</td>
		<td>
			EC<input type="text" name="red" value="<?php  echo $red_info['EC'];?>" placeholder="EC" onkeyup="value=value.replace(/[^\d]/g,'')">
		</td>
	</tr>
	<tr>
		<td>控制红字</td>
		<td>
			(2D)
		</td>
		<td>
			2A<input type="text" name="red" value="<?php  echo $red_info['2A'];?>" placeholder="2A" onkeyup="value=value.replace(/[^\d]/g,'')">
		</td>
		<td>
			2B<input type="text" name="red" value="<?php  echo $red_info['2B'];?>" placeholder="2B" onkeyup="value=value.replace(/[^\d]/g,'')">
		</td>
		<td>
			2C<input type="text" name="red" value="<?php  echo $red_info['2C'];?>" placeholder="2C" onkeyup="value=value.replace(/[^\d]/g,'')">
		</td>
		<td>
			2D<input type="text" name="red" value="<?php  echo $red_info['2D'];?>" placeholder="2D" onkeyup="value=value.replace(/[^\d]/g,'')">
		</td>
		<td>
			2E<input type="text" name="red" value="<?php  echo $red_info['2E'];?>" placeholder="2E" onkeyup="value=value.replace(/[^\d]/g,'')">
		</td>
		<td>
			2ABC<input type="text" name="red" value="<?php  echo $red_info['2ABC'];?>" placeholder="2ABC" onkeyup="value=value.replace(/[^\d]/g,'')">
		</td>
		<td>
			EX<input type="text" name="red" value="<?php  echo $red_info['EX'];?>" placeholder="EX" onkeyup="value=value.replace(/[^\d]/g,'')">
		</td>
	</tr>
	<tr>
		<td></td>
		<td></td>
		<td>
			5D<input type="text" name="red" value="<?php  echo $red_info['5D'];?>" placeholder="5D" onkeyup="value=value.replace(/[^\d]/g,'')">
		</td>
	</tr>
	<tr>
		<td></td>
		<td></td>
		<td>
			6D<input type="text" name="red" value="<?php  echo $red_info['6D'];?>" placeholder="6D" onkeyup="value=value.replace(/[^\d]/g,'')">
		</td>
	</tr>
</table>
<table class="table table-bordered">
	<tr>
		<td>
			<button class="btn btn-primary" onclick="$('#peitao1').show();$('#peitao2').hide();">JUBAO配套</button>
			<button class="btn btn-warning" onclick="$('#peitao1').hide();$('#peitao2').show();">Other配套</button>
		</td>
	</tr>
	<tr id="peitao1" style="background-color: #70ffe261;">
		<td>
			<div class="col-xs-12">
				指定配套：
				<select id="odds1_id">
					<option value="0">不指定配套</option>
					<?php  if(is_array($odds1)) { foreach($odds1 as $odd1) { ?>
					<option value="<?php  echo $odd1['id'];?>" <?php  if($odd1['used'] == 1) { ?>selected<?php  } ?>>ID：<?php  echo $odd1['pid'];?></option>
					<?php  } } ?>
				</select>
			</div>
			<?php  if(is_array($list1)) { foreach($list1 as $gp1) { ?>
			<table class="table table-bordered" style="margin-bottom: 5px;background-color: #70ffe261;">
				<tr>
					<td colspan="4" style="text-align: center;">
						group:<?php  echo $gp1['group_name'];?>
					</td>
				</tr>
				<tr>
					<td></td>
					<td>ID</td>
					<td>BSAC4A2A</td>
					<td>水钱</td>
				</tr>
				<?php  if(is_array($gp1['odds'])) { foreach($gp1['odds'] as $item1) { ?>
				<tr>
					<td><a href="javascript:void(0)" data-toggle="collapse" data-target="#detail_<?php  echo $item1['id'];?>"><span>详细</span></a></td>
					<td><?php  echo $item1['id'];?></td>
					<td><?php  echo $item1['odds_B']['0'];?>/<?php  echo $item1['odds_S']['0'];?>/<?php  echo $item1['odds_A'];?>/<?php  echo $item1['odds_3ABC']['0'];?>/<?php  echo $item1['odds_4A'];?>/<?php  echo $item1['odds_2A'];?></td>
					<td><?php  echo $item1['my_cashback']['B'];?>-<?php  echo $item1['my_cashback']['S'];?>-<?php  echo $item1['my_cashback']['A'];?>-<?php  echo $item1['my_cashback']['3ABC'];?>-<?php  echo $item1['my_cashback']['4A'];?>-<?php  echo $item1['my_cashback']['2A'];?></td>
				</tr>
				<tr id="detail_<?php  echo $item1['id'];?>" class="collapse">
					<td colspan="4" style="padding: 0;border: 0;background-color: #70ffe261;">
						<table class="table table-bordered" style="background-color: #70ffe261;">
							<tr>
								<td>
									<input type="hidden" class="agent_cashback_<?php  echo $item1['id'];?>" value="<?php  echo $item1['commission']['B'];?>">
									<input type="hidden" class="agent_cashback_<?php  echo $item1['id'];?>" value="<?php  echo $item1['commission']['S'];?>">
									<input type="hidden" class="agent_cashback_<?php  echo $item1['id'];?>" value="<?php  echo $item1['commission']['A'];?>">
									<input type="hidden" class="agent_cashback_<?php  echo $item1['id'];?>" value="<?php  echo $item1['commission']['3ABC'];?>">
									<input type="hidden" class="agent_cashback_<?php  echo $item1['id'];?>" value="<?php  echo $item1['commission']['4A'];?>">
									<input type="hidden" class="agent_cashback_<?php  echo $item1['id'];?>" value="<?php  echo $item1['commission']['4ABC'];?>">
									<input type="hidden" class="agent_cashback_<?php  echo $item1['id'];?>" value="<?php  echo $item1['commission']['2A'];?>">
									<input type="hidden" class="agent_cashback_<?php  echo $item1['id'];?>" value="<?php  echo $item1['commission']['2ABC'];?>">
									<input type="hidden" class="agent_cashback_<?php  echo $item1['id'];?>" value="<?php  echo $item1['commission']['5D'];?>">
									<input type="hidden" class="agent_cashback_<?php  echo $item1['id'];?>" value="<?php  echo $item1['commission']['6D'];?>">
								</td>
							</tr>
							<tr>
								<td>上线</td>
								<td></td>
								<td><span><?php  echo $item1['my_cashback']['B'];?></span></td>
								<td></td>
								<td><span><?php  echo $item1['my_cashback']['S'];?></span></td>
								<td></td>
								<td><span><?php  echo $item1['my_cashback']['A'];?></span></td>
								<td></td>
								<td><span><?php  echo $item1['my_cashback']['3ABC'];?></span></td>
								<td></td>
								<td><span><?php  echo $item1['my_cashback']['4A'];?></span></td>
								<td></td>
								<td><span><?php  echo $item1['my_cashback']['4ABC'];?></span></td>
								<td></td>
								<td><span><?php  echo $item1['my_cashback']['2A'];?></span></td>
								<td></td>
								<td><span><?php  echo $item1['my_cashback']['2ABC'];?></span></td>
								<td></td>
								<td><span><?php  echo $item1['my_cashback']['5D'];?></span></td>
								<td></td>
								<td><span><?php  echo $item1['my_cashback']['6D'];?></span></td>
							</tr>
							<tr>
								<td style="width: 3vw;">抽佣</td>
								<td>B</td>
								<td><input type="text" class="commission_<?php  echo $item1['id'];?>" value="0" onkeyup="cal_cashback(<?php  echo $item1['id'];?>,'b')"></td>
								<td>S</td>
								<td><input type="text" class="commission_<?php  echo $item1['id'];?>" value="0" onkeyup="cal_cashback(<?php  echo $item1['id'];?>,'s')"></td>
								<td>A~EC</td>
								<td><input type="text" class="commission_<?php  echo $item1['id'];?>" value="0" onkeyup="cal_cashback(<?php  echo $item1['id'];?>,'a')"></td>
								<td>3ABC</td>
								<td><input type="text" class="commission_<?php  echo $item1['id'];?>" value="0" onkeyup="cal_cashback(<?php  echo $item1['id'];?>,'3abc')"></td>
								<td>4A~EA</td>
								<td><input type="text" class="commission_<?php  echo $item1['id'];?>" value="0" onkeyup="cal_cashback(<?php  echo $item1['id'];?>,'4a')"></td>
								<td>4AC</td>
								<td><input type="text" class="commission_<?php  echo $item1['id'];?>" value="0" onkeyup="cal_cashback(<?php  echo $item1['id'];?>,'4abc')"></td>
								<td>2A~EX</td>
								<td><input type="text" class="commission_<?php  echo $item1['id'];?>" value="0" onkeyup="cal_cashback(<?php  echo $item1['id'];?>,'2a')"></td>
								<td>2ABC</td>
								<td><input type="text" class="commission_<?php  echo $item1['id'];?>" value="0" onkeyup="cal_cashback(<?php  echo $item1['id'];?>,'2abc')"></td>
								<td>5D</td>
								<td><input type="text" class="commission_<?php  echo $item1['id'];?>" value="0" onkeyup="cal_cashback(<?php  echo $item1['id'];?>,'5d')"></td>
								<td>6D</td>
								<td><input type="text" class="commission_<?php  echo $item1['id'];?>" value="0" onkeyup="cal_cashback(<?php  echo $item1['id'];?>,'6d')"></td>
							</tr>
							<tr>
								<td>水钱</td>
								<td></td>
								<td><span id="cashback_money_b_<?php  echo $item1['id'];?>"><?php  echo $item1['cashback']['B'];?></span></td>
								<td></td>
								<td><span id="cashback_money_s_<?php  echo $item1['id'];?>"><?php  echo $item1['cashback']['S'];?></span></td>
								<td></td>
								<td><span id="cashback_money_a_<?php  echo $item1['id'];?>"><?php  echo $item1['cashback']['A'];?></span></td>
								<td></td>
								<td><span id="cashback_money_3abc_<?php  echo $item1['id'];?>"><?php  echo $item1['cashback']['3ABC'];?></span></td>
								<td></td>
								<td><span id="cashback_money_4a_<?php  echo $item1['id'];?>"><?php  echo $item1['cashback']['4A'];?></span></td>
								<td></td>
								<td><span id="cashback_money_4abc_<?php  echo $item1['id'];?>"><?php  echo $item1['cashback']['4ABC'];?></span></td>
								<td></td>
								<td><span id="cashback_money_2a_<?php  echo $item1['id'];?>"><?php  echo $item1['cashback']['2A'];?></span></td>
								<td></td>
								<td><span id="cashback_money_2abc_<?php  echo $item1['id'];?>"><?php  echo $item1['cashback']['2ABC'];?></span></td>
								<td></td>
								<td><span id="cashback_money_5d_<?php  echo $item1['id'];?>"><?php  echo $item1['cashback']['5D'];?></span></td>
								<td></td>
								<td><span id="cashback_money_6d_<?php  echo $item1['id'];?>"><?php  echo $item1['cashback']['6D'];?></span></td>
							</tr>
							<tr>
								<td>头奖</td>
								<td>B</td>
								<td><input type="text" class="odds_b_<?php  echo $item1['id'];?>" readonly value="<?php  echo $item1['odds_B']['0'];?>"></td>
								<td>S</td>
								<td><input type="text" class="odds_s_<?php  echo $item1['id'];?>" readonly value="<?php  echo $item1['odds_S']['0'];?>"></td>
								<td>A</td>
								<td><input type="text" class="odds_a_<?php  echo $item1['id'];?>" readonly value="<?php  echo $item1['odds_A'];?>"></td>
								<td>3ABC</td>
								<td><input type="text" class="odds_3abc_<?php  echo $item1['id'];?>" readonly value="<?php  echo $item1['odds_3ABC']['0'];?>"></td>
								<td>4A</td>
								<td><input type="text" class="odds_4a_<?php  echo $item1['id'];?>" readonly value="<?php  echo $item1['odds_4A'];?>"></td>
								<td>4AC</td>
								<td><input type="text" class="odds_4abc_<?php  echo $item1['id'];?>" readonly value="<?php  echo $item1['odds_4ABC']['0'];?>"></td>
								<td>2A</td>
								<td><input type="text" class="odds_2a_<?php  echo $item1['id'];?>" readonly value="<?php  echo $item1['odds_2A'];?>"></td>
								<td>2ABC</td>
								<td><input type="text" class="odds_2abc_<?php  echo $item1['id'];?>" readonly value="<?php  echo $item1['odds_2ABC']['0'];?>"></td>
								<td>5D/1st</td>
								<td><input type="text" class="odds_5d_<?php  echo $item1['id'];?>" readonly value="<?php  echo $item1['odds_5D']['0'];?>"></td>
								<td>6D/1st</td>
								<td><input type="text" class="odds_6d_<?php  echo $item1['id'];?>" readonly value="<?php  echo $item1['odds_6D']['0'];?>"></td>
							</tr>
							<tr>
								<td>二奖</td>
								<td>B</td>
								<td><input type="text" class="odds_b_<?php  echo $item1['id'];?>" readonly value="<?php  echo $item1['odds_B']['1'];?>"></td>
								<td>S</td>
								<td><input type="text" class="odds_s_<?php  echo $item1['id'];?>" readonly value="<?php  echo $item1['odds_S']['1'];?>"></td>
								<td>C2</td>
								<td><input type="text" class="odds_a_<?php  echo $item1['id'];?>" readonly value="<?php  echo $item1['odds_C2'];?>"></td>
								<td>3ABC</td>
								<td><input type="text" class="odds_3abc_<?php  echo $item1['id'];?>" readonly value="<?php  echo $item1['odds_3ABC']['1'];?>"></td>
								<td>4B</td>
								<td><input type="text" class="odds_4a_<?php  echo $item1['id'];?>" readonly value="<?php  echo $item1['odds_4B'];?>"></td>
								<td>4AC</td>
								<td><input type="text" class="odds_4abc_<?php  echo $item1['id'];?>" readonly value="<?php  echo $item1['odds_4ABC']['1'];?>"></td>
								<td>2B</td>
								<td><input type="text" class="odds_2a_<?php  echo $item1['id'];?>" readonly value="<?php  echo $item1['odds_2B'];?>"></td>
								<td>2ABC</td>
								<td><input type="text" class="odds_2abc_<?php  echo $item1['id'];?>" readonly value="<?php  echo $item1['odds_2ABC']['1'];?>"></td>
								<td>5D/2nd</td>
								<td><input type="text" class="odds_5d_<?php  echo $item1['id'];?>" readonly value="<?php  echo $item1['odds_5D']['1'];?>"></td>
								<td>6D/2nd</td>
								<td><input type="text" class="odds_6d_<?php  echo $item1['id'];?>" readonly value="<?php  echo $item1['odds_6D']['1'];?>"></td>
							</tr>
							<tr>
								<td>三奖</td>
								<td>B</td>
								<td><input type="text" class="odds_b_<?php  echo $item1['id'];?>" readonly value="<?php  echo $item1['odds_B']['2'];?>"></td>
								<td>S</td>
								<td><input type="text" class="odds_s_<?php  echo $item1['id'];?>" readonly value="<?php  echo $item1['odds_S']['2'];?>"></td>
								<td>C3</td>
								<td><input type="text" class="odds_a_<?php  echo $item1['id'];?>" readonly value="<?php  echo $item1['odds_C3'];?>"></td>
								<td>3ABC</td>
								<td><input type="text" class="odds_3abc_<?php  echo $item1['id'];?>" readonly value="<?php  echo $item1['odds_3ABC']['2'];?>"></td>
								<td>4C</td>
								<td><input type="text" class="odds_4a_<?php  echo $item1['id'];?>" readonly value="<?php  echo $item1['odds_4C'];?>"></td>
								<td>4AC</td>
								<td><input type="text" class="odds_4abc_<?php  echo $item1['id'];?>" readonly value="<?php  echo $item1['odds_4ABC']['2'];?>"></td>
								<td>2C</td>
								<td><input type="text" class="odds_2a_<?php  echo $item1['id'];?>" readonly value="<?php  echo $item1['odds_2C'];?>"></td>
								<td>2ABC</td>
								<td><input type="text" class="odds_2abc_<?php  echo $item1['id'];?>" readonly value="<?php  echo $item1['odds_2ABC']['2'];?>"></td>
								<td>5D/3rd</td>
								<td><input type="text" class="odds_5d_<?php  echo $item1['id'];?>" readonly value="<?php  echo $item1['odds_5D']['2'];?>"></td>
								<td>6D/3rd</td>
								<td><input type="text" class="odds_6d_<?php  echo $item1['id'];?>" readonly value="<?php  echo $item1['odds_6D']['2'];?>"></td>
							</tr>
							<tr>
								<td>特别奖</td>
								<td>B</td>
								<td><input type="text" class="odds_b_<?php  echo $item1['id'];?>" readonly value="<?php  echo $item1['odds_B']['3'];?>"></td>
								<td></td>
								<td></td>
								<td>C4</td>
								<td><input type="text" class="odds_a_<?php  echo $item1['id'];?>" readonly value="<?php  echo $item1['odds_C4'];?>"></td>
								<td></td>
								<td></td>
								<td>4D</td>
								<td><input type="text" class="odds_4a_<?php  echo $item1['id'];?>" readonly value="<?php  echo $item1['odds_4D'];?>"></td>
								<td></td>
								<td></td>
								<td>2D</td>
								<td><input type="text" class="odds_2a_<?php  echo $item1['id'];?>" readonly value="<?php  echo $item1['odds_2D'];?>"></td>
								<td></td>
								<td></td>
								<td>5D/4th</td>
								<td><input type="text" class="odds_5d_<?php  echo $item1['id'];?>" readonly value="<?php  echo $item1['odds_5D']['3'];?>"></td>
								<td>6D/4th</td>
								<td><input type="text" class="odds_6d_<?php  echo $item1['id'];?>" readonly value="<?php  echo $item1['odds_6D']['3'];?>"></td>
							</tr>
							<tr>
								<td>安慰奖</td>
								<td>B</td>
								<td><input type="text" class="odds_b_<?php  echo $item1['id'];?>" readonly value="<?php  echo $item1['odds_B']['4'];?>"></td>
								<td></td>
								<td></td>
								<td>C5</td>
								<td><input type="text" class="odds_a_<?php  echo $item1['id'];?>" readonly value="<?php  echo $item1['odds_C5'];?>"></td>
								<td></td>
								<td></td>
								<td>4E</td>
								<td><input type="text" class="odds_4a_<?php  echo $item1['id'];?>" readonly value="<?php  echo $item1['odds_4E'];?>"></td>
								<td></td>
								<td></td>
								<td>2E</td>
								<td><input type="text" class="odds_2a_<?php  echo $item1['id'];?>" readonly value="<?php  echo $item1['odds_2E'];?>"></td>
								<td></td>
								<td></td>
								<td>5D/5th</td>
								<td><input type="text" class="odds_5d_<?php  echo $item1['id'];?>" readonly value="<?php  echo $item1['odds_5D']['4'];?>"></td>
								<td>6D/5th</td>
								<td><input type="text" class="odds_6d_<?php  echo $item1['id'];?>" readonly value="<?php  echo $item1['odds_6D']['4'];?>"></td>
							</tr>
							<tr>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
								<td>EC</td>
								<td><input type="text" class="odds_a_<?php  echo $item1['id'];?>" readonly value="<?php  echo $item1['odds_EC'];?>"></td>
								<td></td>
								<td></td>
								<td>EA</td>
								<td><input type="text" class="odds_4a_<?php  echo $item1['id'];?>" readonly value="<?php  echo $item1['odds_EA'];?>"></td>
								<td></td>
								<td></td>
								<td>EX</td>
								<td><input type="text" class="odds_2a_<?php  echo $item1['id'];?>" readonly value="<?php  echo $item1['odds_EX'];?>"></td>
								<td></td>
								<td></td>
								<td>5D/6th</td>
								<td><input type="text" class="odds_5d_<?php  echo $item1['id'];?>" readonly value="<?php  echo $item1['odds_5D']['5'];?>"></td>
								<td></td>
								<td></td>
							</tr>
						</table>
					</td>
				</tr>
				<?php  } } ?>
			</table>
			<?php  } } ?>
		</td>
	</tr>
	<tr id="peitao2" style="display: none;background-color: #ffce887a;">
		<td>
			<div class="col-xs-12">
				指定配套：
				<select id="odds2_id">
					<option value="0">不指定配套</option>
					<?php  if(is_array($odds2)) { foreach($odds2 as $odd2) { ?>
					<option value="<?php  echo $odd2['id'];?>" <?php  if($odd2['used'] == 1) { ?>selected<?php  } ?>>ID：<?php  echo $odd2['pid'];?></option>
					<?php  } } ?>
				</select>
			</div>
			<?php  if(is_array($list2)) { foreach($list2 as $gp2) { ?>
			<table class="table table-bordered" style="margin-bottom: 5px;background-color: #ffce887a;">
				<tr>
					<td colspan="4" style="text-align: center;">
						group:<?php  echo $gp2['group_name'];?>
					</td>
				</tr>
				<tr>
					<td></td>
					<td>ID</td>
					<td>BSAC4A2A</td>
					<td>水钱</td>
				</tr>
				<?php  if(is_array($gp2['odds'])) { foreach($gp2['odds'] as $item2) { ?>
				<tr>
					<td><a href="javascript:void(0)" data-toggle="collapse" data-target="#detail_<?php  echo $item2['id'];?>"><span>详细</span></a></td>
					<td><?php  echo $item2['id'];?></td>
					<td><?php  echo $item2['odds_B']['0'];?>/<?php  echo $item2['odds_S']['0'];?>/<?php  echo $item2['odds_A'];?>/<?php  echo $item2['odds_3ABC']['0'];?>/<?php  echo $item2['odds_4A'];?>/<?php  echo $item2['odds_2A'];?></td>
					<td><?php  echo $item2['my_cashback']['B'];?>-<?php  echo $item2['my_cashback']['S'];?>-<?php  echo $item2['my_cashback']['A'];?>-<?php  echo $item2['my_cashback']['3ABC'];?>-<?php  echo $item2['my_cashback']['4A'];?>-<?php  echo $item2['my_cashback']['2A'];?></td>
				</tr>
				<tr id="detail_<?php  echo $item2['id'];?>" class="collapse">
					<td colspan="4" style="padding: 0;border: 0;">
						<table class="table table-bordered" style="background-color: #ffce887a;">
							<tr>
								<td>
									<input type="hidden" class="agent_cashback_<?php  echo $item2['id'];?>" value="<?php  echo $item2['commission']['B'];?>">
									<input type="hidden" class="agent_cashback_<?php  echo $item2['id'];?>" value="<?php  echo $item2['commission']['S'];?>">
									<input type="hidden" class="agent_cashback_<?php  echo $item2['id'];?>" value="<?php  echo $item2['commission']['A'];?>">
									<input type="hidden" class="agent_cashback_<?php  echo $item2['id'];?>" value="<?php  echo $item2['commission']['3ABC'];?>">
									<input type="hidden" class="agent_cashback_<?php  echo $item2['id'];?>" value="<?php  echo $item2['commission']['4A'];?>">
									<input type="hidden" class="agent_cashback_<?php  echo $item2['id'];?>" value="<?php  echo $item2['commission']['4ABC'];?>">
									<input type="hidden" class="agent_cashback_<?php  echo $item2['id'];?>" value="<?php  echo $item2['commission']['2A'];?>">
									<input type="hidden" class="agent_cashback_<?php  echo $item2['id'];?>" value="<?php  echo $item2['commission']['2ABC'];?>">
									<input type="hidden" class="agent_cashback_<?php  echo $item2['id'];?>" value="<?php  echo $item2['commission']['5D'];?>">
									<input type="hidden" class="agent_cashback_<?php  echo $item2['id'];?>" value="<?php  echo $item2['commission']['6D'];?>">
								</td>
							</tr>
							<tr>
								<td>上线</td>
								<td></td>
								<td><span><?php  echo $item2['my_cashback']['B'];?></span></td>
								<td></td>
								<td><span><?php  echo $item2['my_cashback']['S'];?></span></td>
								<td></td>
								<td><span><?php  echo $item2['my_cashback']['A'];?></span></td>
								<td></td>
								<td><span><?php  echo $item2['my_cashback']['3ABC'];?></span></td>
								<td></td>
								<td><span><?php  echo $item2['my_cashback']['4A'];?></span></td>
								<td></td>
								<td><span><?php  echo $item2['my_cashback']['4ABC'];?></span></td>
								<td></td>
								<td><span><?php  echo $item2['my_cashback']['2A'];?></span></td>
								<td></td>
								<td><span><?php  echo $item2['my_cashback']['2ABC'];?></span></td>
								<td></td>
								<td><span><?php  echo $item2['my_cashback']['5D'];?></span></td>
								<td></td>
								<td><span><?php  echo $item2['my_cashback']['6D'];?></span></td>
							</tr>
							<tr>
								<td style="width: 3vw;">抽佣</td>
								<td>B</td>
								<td><input type="text" class="commission_<?php  echo $item2['id'];?>" value="0" onchange="cal_cashback(<?php  echo $item2['id'];?>,'b')"></td>
								<td>S</td>
								<td><input type="text" class="commission_<?php  echo $item2['id'];?>" value="0" onchange="cal_cashback(<?php  echo $item2['id'];?>,'s')"></td>
								<td>A~EC</td>
								<td><input type="text" class="commission_<?php  echo $item2['id'];?>" value="0" onchange="cal_cashback(<?php  echo $item2['id'];?>,'a')"></td>
								<td>3ABC</td>
								<td><input type="text" class="commission_<?php  echo $item2['id'];?>" value="0" onchange="cal_cashback(<?php  echo $item2['id'];?>,'3abc')"></td>
								<td>4A~EA</td>
								<td><input type="text" class="commission_<?php  echo $item2['id'];?>" value="0" onchange="cal_cashback(<?php  echo $item2['id'];?>,'4a')"></td>
								<td>4AC</td>
								<td><input type="text" class="commission_<?php  echo $item2['id'];?>" value="0" onchange="cal_cashback(<?php  echo $item2['id'];?>,'4abc')"></td>
								<td>2A~EX</td>
								<td><input type="text" class="commission_<?php  echo $item2['id'];?>" value="0" onchange="cal_cashback(<?php  echo $item2['id'];?>,'2a')"></td>
								<td>2ABC</td>
								<td><input type="text" class="commission_<?php  echo $item2['id'];?>" value="0" onchange="cal_cashback(<?php  echo $item2['id'];?>,'2abc')"></td>
								<td>5D</td>
								<td><input type="text" class="commission_<?php  echo $item2['id'];?>" value="0" onchange="cal_cashback(<?php  echo $item2['id'];?>,'5d')"></td>
								<td>6D</td>
								<td><input type="text" class="commission_<?php  echo $item2['id'];?>" value="0" onchange="cal_cashback(<?php  echo $item2['id'];?>,'6d')"></td>
							</tr>
							<tr>
								<td>水钱</td>
								<td></td>
								<td><span id="cashback_money_b_<?php  echo $item2['id'];?>"><?php  echo $item2['cashback']['B'];?></span></td>
								<td></td>
								<td><span id="cashback_money_s_<?php  echo $item2['id'];?>"><?php  echo $item2['cashback']['S'];?></span></td>
								<td></td>
								<td><span id="cashback_money_a_<?php  echo $item2['id'];?>"><?php  echo $item2['cashback']['A'];?></span></td>
								<td></td>
								<td><span id="cashback_money_3abc_<?php  echo $item2['id'];?>"><?php  echo $item2['cashback']['3ABC'];?></span></td>
								<td></td>
								<td><span id="cashback_money_4a_<?php  echo $item2['id'];?>"><?php  echo $item2['cashback']['4A'];?></span></td>
								<td></td>
								<td><span id="cashback_money_4abc_<?php  echo $item2['id'];?>"><?php  echo $item2['cashback']['4ABC'];?></span></td>
								<td></td>
								<td><span id="cashback_money_2a_<?php  echo $item2['id'];?>"><?php  echo $item2['cashback']['2A'];?></span></td>
								<td></td>
								<td><span id="cashback_money_2abc_<?php  echo $item2['id'];?>"><?php  echo $item2['cashback']['2ABC'];?></span></td>
								<td></td>
								<td><span id="cashback_money_5d_<?php  echo $item2['id'];?>"><?php  echo $item2['cashback']['5D'];?></span></td>
								<td></td>
								<td><span id="cashback_money_6d_<?php  echo $item2['id'];?>"><?php  echo $item2['cashback']['6D'];?></span></td>
							</tr>
							<tr>
								<td>头奖</td>
								<td>B</td>
								<td><input type="text" class="odds_b_<?php  echo $item2['id'];?>" readonly value="<?php  echo $item2['odds_B']['0'];?>"></td>
								<td>S</td>
								<td><input type="text" class="odds_s_<?php  echo $item2['id'];?>" readonly value="<?php  echo $item2['odds_S']['0'];?>"></td>
								<td>A</td>
								<td><input type="text" class="odds_a_<?php  echo $item2['id'];?>" readonly value="<?php  echo $item2['odds_A'];?>"></td>
								<td>3ABC</td>
								<td><input type="text" class="odds_3abc_<?php  echo $item2['id'];?>" readonly value="<?php  echo $item2['odds_3ABC']['0'];?>"></td>
								<td>4A</td>
								<td><input type="text" class="odds_4a_<?php  echo $item2['id'];?>" readonly value="<?php  echo $item2['odds_4A'];?>"></td>
								<td>4AC</td>
								<td><input type="text" class="odds_4abc_<?php  echo $item2['id'];?>" readonly value="<?php  echo $item2['odds_4ABC']['0'];?>"></td>
								<td>2A</td>
								<td><input type="text" class="odds_2a_<?php  echo $item2['id'];?>" readonly value="<?php  echo $item2['odds_2A'];?>"></td>
								<td>2ABC</td>
								<td><input type="text" class="odds_2abc_<?php  echo $item2['id'];?>" readonly value="<?php  echo $item2['odds_2ABC']['0'];?>"></td>
								<td>5D/1st</td>
								<td><input type="text" class="odds_5d_<?php  echo $item2['id'];?>" readonly value="<?php  echo $item2['odds_5D']['0'];?>"></td>
								<td>6D/1st</td>
								<td><input type="text" class="odds_6d_<?php  echo $item2['id'];?>" readonly value="<?php  echo $item2['odds_6D']['0'];?>"></td>
							</tr>
							<tr>
								<td>二奖</td>
								<td>B</td>
								<td><input type="text" class="odds_b_<?php  echo $item2['id'];?>" readonly value="<?php  echo $item2['odds_B']['1'];?>"></td>
								<td>S</td>
								<td><input type="text" class="odds_s_<?php  echo $item2['id'];?>" readonly value="<?php  echo $item2['odds_S']['1'];?>"></td>
								<td>C2</td>
								<td><input type="text" class="odds_a_<?php  echo $item2['id'];?>" readonly value="<?php  echo $item2['odds_C2'];?>"></td>
								<td>3ABC</td>
								<td><input type="text" class="odds_3abc_<?php  echo $item2['id'];?>" readonly value="<?php  echo $item2['odds_3ABC']['1'];?>"></td>
								<td>4B</td>
								<td><input type="text" class="odds_4a_<?php  echo $item2['id'];?>" readonly value="<?php  echo $item2['odds_4B'];?>"></td>
								<td>4AC</td>
								<td><input type="text" class="odds_4abc_<?php  echo $item2['id'];?>" readonly value="<?php  echo $item2['odds_4ABC']['1'];?>"></td>
								<td>2B</td>
								<td><input type="text" class="odds_2a_<?php  echo $item2['id'];?>" readonly value="<?php  echo $item2['odds_2B'];?>"></td>
								<td>2ABC</td>
								<td><input type="text" class="odds_2abc_<?php  echo $item2['id'];?>" readonly value="<?php  echo $item2['odds_2ABC']['1'];?>"></td>
								<td>5D/2nd</td>
								<td><input type="text" class="odds_5d_<?php  echo $item2['id'];?>" readonly value="<?php  echo $item2['odds_5D']['1'];?>"></td>
								<td>6D/2nd</td>
								<td><input type="text" class="odds_6d_<?php  echo $item2['id'];?>" readonly value="<?php  echo $item2['odds_6D']['1'];?>"></td>
							</tr>
							<tr>
								<td>三奖</td>
								<td>B</td>
								<td><input type="text" class="odds_b_<?php  echo $item2['id'];?>" readonly value="<?php  echo $item2['odds_B']['2'];?>"></td>
								<td>S</td>
								<td><input type="text" class="odds_s_<?php  echo $item2['id'];?>" readonly value="<?php  echo $item2['odds_S']['2'];?>"></td>
								<td>C3</td>
								<td><input type="text" class="odds_a_<?php  echo $item2['id'];?>" readonly value="<?php  echo $item2['odds_C3'];?>"></td>
								<td>3ABC</td>
								<td><input type="text" class="odds_3abc_<?php  echo $item2['id'];?>" readonly value="<?php  echo $item2['odds_3ABC']['2'];?>"></td>
								<td>4C</td>
								<td><input type="text" class="odds_4a_<?php  echo $item2['id'];?>" readonly value="<?php  echo $item2['odds_4C'];?>"></td>
								<td>4AC</td>
								<td><input type="text" class="odds_4abc_<?php  echo $item2['id'];?>" readonly value="<?php  echo $item2['odds_4ABC']['2'];?>"></td>
								<td>2C</td>
								<td><input type="text" class="odds_2a_<?php  echo $item2['id'];?>" readonly value="<?php  echo $item2['odds_2C'];?>"></td>
								<td>2ABC</td>
								<td><input type="text" class="odds_2abc_<?php  echo $item2['id'];?>" readonly value="<?php  echo $item2['odds_2ABC']['2'];?>"></td>
								<td>5D/3rd</td>
								<td><input type="text" class="odds_5d_<?php  echo $item2['id'];?>" readonly value="<?php  echo $item2['odds_5D']['2'];?>"></td>
								<td>6D/3rd</td>
								<td><input type="text" class="odds_6d_<?php  echo $item2['id'];?>" readonly value="<?php  echo $item2['odds_6D']['2'];?>"></td>
							</tr>
							<tr>
								<td>特别奖</td>
								<td>B</td>
								<td><input type="text" class="odds_b_<?php  echo $item2['id'];?>" readonly value="<?php  echo $item2['odds_B']['3'];?>"></td>
								<td></td>
								<td></td>
								<td>C4</td>
								<td><input type="text" class="odds_a_<?php  echo $item2['id'];?>" readonly value="<?php  echo $item2['odds_C4'];?>"></td>
								<td></td>
								<td></td>
								<td>4D</td>
								<td><input type="text" class="odds_4a_<?php  echo $item2['id'];?>" readonly value="<?php  echo $item2['odds_4D'];?>"></td>
								<td></td>
								<td></td>
								<td>2D</td>
								<td><input type="text" class="odds_2a_<?php  echo $item2['id'];?>" readonly value="<?php  echo $item2['odds_2D'];?>"></td>
								<td></td>
								<td></td>
								<td>5D/4th</td>
								<td><input type="text" class="odds_5d_<?php  echo $item2['id'];?>" readonly value="<?php  echo $item2['odds_5D']['3'];?>"></td>
								<td>6D/4th</td>
								<td><input type="text" class="odds_6d_<?php  echo $item2['id'];?>" readonly value="<?php  echo $item2['odds_6D']['3'];?>"></td>
							</tr>
							<tr>
								<td>安慰奖</td>
								<td>B</td>
								<td><input type="text" class="odds_b_<?php  echo $item2['id'];?>" readonly value="<?php  echo $item2['odds_B']['4'];?>"></td>
								<td></td>
								<td></td>
								<td>C5</td>
								<td><input type="text" class="odds_a_<?php  echo $item2['id'];?>" readonly value="<?php  echo $item2['odds_C5'];?>"></td>
								<td></td>
								<td></td>
								<td>4E</td>
								<td><input type="text" class="odds_4a_<?php  echo $item2['id'];?>" readonly value="<?php  echo $item2['odds_4E'];?>"></td>
								<td></td>
								<td></td>
								<td>2E</td>
								<td><input type="text" class="odds_2a_<?php  echo $item2['id'];?>" readonly value="<?php  echo $item2['odds_2E'];?>"></td>
								<td></td>
								<td></td>
								<td>5D/5th</td>
								<td><input type="text" class="odds_5d_<?php  echo $item2['id'];?>" readonly value="<?php  echo $item2['odds_5D']['4'];?>"></td>
								<td>6D/5th</td>
								<td><input type="text" class="odds_6d_<?php  echo $item2['id'];?>" readonly value="<?php  echo $item2['odds_6D']['4'];?>"></td>
							</tr>
							<tr>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
								<td>EC</td>
								<td><input type="text" class="odds_a_<?php  echo $item2['id'];?>" readonly value="<?php  echo $item2['odds_EC'];?>"></td>
								<td></td>
								<td></td>
								<td>EA</td>
								<td><input type="text" class="odds_4a_<?php  echo $item2['id'];?>" readonly value="<?php  echo $item2['odds_EA'];?>"></td>
								<td></td>
								<td></td>
								<td>EX</td>
								<td><input type="text" class="odds_2a_<?php  echo $item2['id'];?>" readonly value="<?php  echo $item2['odds_EX'];?>"></td>
								<td></td>
								<td></td>
								<td>5D/6th</td>
								<td><input type="text" class="odds_5d_<?php  echo $item2['id'];?>" readonly value="<?php  echo $item2['odds_5D']['5'];?>"></td>
								<td></td>
								<td></td>
							</tr>
						</table>
					</td>
				</tr>
				<?php  } } ?>
			</table>
			<?php  } } ?>
		</td>
	</tr>
</table>
<table class="table table-bordered">
	<tr>
		<td colspan="3">
			投注设置
		</td>
	</tr>
	<tr>
		<td>
			自动加水：
		</td>
		<td>
			+
		</td>
		<td>
			<input type="text" name="auto_add" maxlength="2" onkeyup="value=value.replace(/[^\d]/g,'')" value="<?php  echo $member['auto_add'];?>" <?php  if($member['has_false'] == 1) { ?>disabled<?php  } ?>>%
		</td>
	</tr>
	<tr>
		<td>
			显示数额：
		</td>
		<td>
			/
		</td>
		<td>
			<input type="text" name="show_amount" maxlength="2" onkeyup="value=value.replace(/[^\d]/g,'')" value="<?php  echo $member['show_amount'];?>" <?php  if($member['has_false'] == 1) { ?>disabled<?php  } ?>>%
		</td>
	</tr>
	<tr>
		<td>虚伪价格：<input type="checkbox" name="has_false" value="1" <?php  if($member['has_false'] == 1) { ?>checked<?php  } ?>></td>
		<td>
			<input type="text" name="false_price" maxlength="2" value="<?php  echo $member['false_price'];?>" onkeyup="value=value.replace(/[^\d]/g,'')" <?php  if($member['has_false'] != 1) { ?>disabled<?php  } ?>>%
		</td>
	</tr>
</table>
<div class="col-xs-12" style="padding: 0;margin-top: 10px;">
	<input type="hidden" name="member_id" value="<?php  echo $_GPC['member_id'];?>">
	<input type="hidden" name="area_id" id="area_id" value="0">
	<a href="javascript:void(0);" class="btn btn-success btn-lg" onclick="odds_post()">提交</a>
</div>
<script type="text/javascript">
	var has_post = 0;
	function odds_post() {
		if (has_post == 1) {
			alert('提交中，请等待');
			return false;
		}
		var member_id = $('input[name=member_id]').val();
		var nickname = $('input[name=nickname]').val();
		var password = $('input[name=password]').val();
		var repassword = $('input[name=repassword]').val();
		var odds1 = $('#odds1_id').val();
		var odds2 = $('#odds2_id').val();
			odds1 = $('option[value='+odds1+']').text();
			odds2 = $('option[value='+odds2+']').text();
			odds1 = odds1.replace(/ID：/g,'');
			odds2 = odds2.replace(/ID：/g,'');
		var commission = [];
		var com1 = [];
		var com2 = [];
		var odds = [];
		var red = [];
		var credit = $('input[name=credit]').val();
		var limit = $('#limit').val();
		var bet = $('#bet').val();
		var recharge = $('input[name=recharge]').val();
		var give = $('input[name=give]').val();
		var auto_add = $('input[name=auto_add]').val();
		var show_amount = $('input[name=show_amount]').val();
		var status = $('select[name=status]').val();
		var mobile = $('input[name=mobile]').val();
		var auto_recharge = $('input[name=auto_recharge]:checked').val();
		var auto_value = $('input[name=auto_value]').val();
		var has_false = $('input[name=has_false]:checked').val()
		var false_price = $('input[name=false_price]').val();
		odds.push($('#odds1_id').val());
		odds.push($('#odds2_id').val());
		$('.commission_'+odds1).each(function() {
			com1.push($(this).val());
		})
		$('input[name=red]').each(function() {
			var rule = $(this).attr('placeholder');
			var rule_val = $(this).val();
			red.push({rule:rule,value:rule_val});
		});
		commission.push({"id":$('#odds1_id').val(),"detail":{"B":com1[0],"S":com1[1],"A":com1[2],"3ABC":com1[3],"4A":com1[4],"4ABC":com1[5],"2A":com1[6],"2ABC":com1[6],"5D":com1[7],"6D":com1[9]},"cashback":{"B":$('#cashback_money_b_'+odds1).text(),"S":$('#cashback_money_s_'+odds1).text(),"A":$('#cashback_money_a_'+odds1).text(),"3ABC":$('#cashback_money_3abc_'+odds1).text(),"4A":$('#cashback_money_4a_'+odds1).text(),"4ABC":$('#cashback_money_4abc_'+odds1).text(),"2A":$('#cashback_money_2a_'+odds1).text(),"2ABC":$('#cashback_money_2abc_'+odds1).text(),"5D":$('#cashback_money_5d_'+odds1).text(),"6D":$('#cashback_money_6d_'+odds1).text()}});
		$('.commission_'+odds2).each(function() {
			com2.push($(this).val());
		})
		commission.push({"id":$('#odds2_id').val(),"detail":{"B":com2[0],"S":com2[1],"A":com2[2],"3ABC":com2[3],"4A":com2[4],"4ABC":com2[5],"2A":com2[6],"2ABC":com2[6],"5D":com2[7],"6D":com2[9]},"cashback":{"B":$('#cashback_money_b_'+odds2).text(),"S":$('#cashback_money_s_'+odds2).text(),"A":$('#cashback_money_a_'+odds2).text(),"3ABC":$('#cashback_money_3abc_'+odds2).text(),"4A":$('#cashback_money_4a_'+odds2).text(),"4ABC":$('#cashback_money_4abc_'+odds2).text(),"2A":$('#cashback_money_2a_'+odds2).text(),"2ABC":$('#cashback_money_2abc_'+odds2).text(),"5D":$('#cashback_money_5d_'+odds2).text(),"6D":$('#cashback_money_6d_'+odds2).text()}});
		has_post = 1;
		$.post("<?php  echo $this->createMobileUrl('set_member')?>",{member_id:member_id,odds:odds,commission:commission,nickname:nickname,password:password,repassword:repassword,limit:limit,credit:credit,bet:bet,recharge:recharge,give:give,auto_add:auto_add,show_amount:show_amount,auto_recharge:auto_recharge,auto_value:auto_value,red:red,mobile:mobile,has_false:has_false,false_price:false_price},function(result) {
			if (result.type == 'unlog') {
				location.href="./index.php?i=6&c=entry&m=purchasing&do=login";
			}
			if (result.type == 'success') {
				location.href = "<?php  echo $this->createMobileUrl('manager',array('op'=>'display','agent_id'=>$member['parent_agent']))?>";
			}
			if (result.type == 'error') {
				alert(result.message);
				window.location.reload();
			}
		},'JSON');
	}

	$('input[name=has_false]').on('click',function() {
		var checked = $(this).is(':checked');
		if (checked == true) {
			$('input[name=auto_add]').prop('disabled',true);
			$('input[name=auto_add]').val(0);
			$('input[name=show_amount]').prop('disabled',true);
			$('input[name=show_amount]').val(0);
			$('input[name=false_price]').prop('disabled',false);
		}
		else{
			$('input[name=auto_add]').prop('disabled',false);
			$('input[name=show_amount]').prop('disabled',false);
			$('input[name=false_price]').prop('disabled',true);
			$('input[name=false_price]').val(0);
		}
	})

	$('#auto_recharge').click(function() {
		console.log('点击了');
		var checked = $(this).is(':checked');
		if (checked == true) {
			console.log('自动');
			$('input[name=recharge]').prop('disabled',true);
			$('input[name=give]').prop('disabled',true);
			$('input[name=auto_value]').prop('disabled',false);
		}
		else{
			console.log('不自动');
			$('input[name=auto_value]').prop('disabled',true);
			$('input[name=recharge]').prop('disabled',false);
			$('input[name=give]').prop('disabled',false);
		}
	})

</script>
<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('footer', TEMPLATE_INCLUDEPATH)) : (include template('footer', TEMPLATE_INCLUDEPATH));?>