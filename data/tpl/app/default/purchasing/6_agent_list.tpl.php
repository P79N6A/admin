<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('header', TEMPLATE_INCLUDEPATH)) : (include template('header', TEMPLATE_INCLUDEPATH));?>
<script type="text/javascript" src="../addons/purchasing/static/js/cashback.js"></script>
<?php  if($op == 'addAgent') { ?>
<style type="text/css" media="screen">
	table tr td input[type=text]{width: 50px;height: 18px;font-size: 16px;}
	.table>tbody>tr>td{padding: 2px 2px;}
</style>
<div class="col-xs-12" style="padding: 0;margin-bottom: 10px;">
	<button type="button" class="btn btn-success btn-lg" onclick="cashback_post()">提交</button>
</div>
<table class="table table-bordered">
	<tr>
		<td>新账户</td>
		<td><input type="text" name="account" class="input1" placeholder="请输入账户名称" style="width: 100%;" onkeyup="value=value.replace(/[\W]/g,'')"></td>
		<td>密码</td>
		<td><input type="text" name="password" class="input1" placeholder="请输入密码" style="width: 100%;" onkeyup="value=value.replace(/[\W]/g,'')"></td>
	</tr>
	<tr>
		<td>昵称</td>
		<td><input type="text" name="nickname" class="input1" placeholder="请输入昵称" style="width: 100%;" onkeyup="value=value.replace(/[\W]/g,'')"></td>
		<td>确认密码</td>
		<td><input type="text" name="repassword" class="input1" placeholder="请再次输入密码" style="width: 100%;" onkeyup="value=value.replace(/[\W]/g,'')"></td>
	</tr>
	<tr>
		<td>状态</td>
		<td>
			<select name="status">
				<option value="0">活跃</option>
				<option value="2">试用</option>
				<option value="1">禁用</option>
			</select>
			<input type="checkbox" name="all_line" value="1">整线执行
		</td>
		<td>自动开户</td>
		<td>
			<input type="radio" name="auto_create" value="1">开
			<input type="radio" name="auto_create" value="0">关
		</td>
	</tr>
</table>
<table class="table table-bordered">
	<tr>
		<td colspan="5">
			上线积分：<?php  echo $member['credit1'];?>
		</td>
		<td colspan="5">
			当前积分：0
		</td>
	</tr>
	<tr>
		<td>充/减值：</td>
		<td colspan="2">
			<input type="text" onkeyup="value=value.replace(/[^\d]/g,'')" name="recharge" style="width: 100px;">
		</td>
		<td colspan="7">
			自动回值： <input type="checkbox" name="auto_recharge" value="1" id="auto_recharge">
			&nbsp;&nbsp;&nbsp;
			回值额度： <input type="text" name="auto_value" onkeyup="value=value.replace(/[^\d]/g,'')" disabled="disabled">
		</td>
	</tr>
	<tr>
		<td>控制红字</td>
		<td>
			(4D)
		</td>
		<td>
			<input type="text" name="red" value="" placeholder="B" onkeyup="value=value.replace(/[^\d]/g,'')">
		</td>
		<td>
			<input type="text" name="red" value="" placeholder="S" onkeyup="value=value.replace(/[^\d]/g,'')">
		</td>
		<td>
			<input type="text" name="red" value="" placeholder="4A" onkeyup="value=value.replace(/[^\d]/g,'')">
		</td>
		<td>
			<input type="text" name="red" value="" placeholder="4B" onkeyup="value=value.replace(/[^\d]/g,'')">
		</td>
		<td>
			<input type="text" name="red" value="" placeholder="4C" onkeyup="value=value.replace(/[^\d]/g,'')">
		</td>
		<td>
			<input type="text" name="red" value="" placeholder="4D" onkeyup="value=value.replace(/[^\d]/g,'')">
		</td>
		<td>
			<input type="text" name="red" value="" placeholder="4E" onkeyup="value=value.replace(/[^\d]/g,'')">
		</td>
		<td>
			<input type="text" name="red" value="" placeholder="4ABC" onkeyup="value=value.replace(/[^\d]/g,'')">
		</td>
		<td>
			<input type="text" name="red" value="" placeholder="EA" onkeyup="value=value.replace(/[^\d]/g,'')">
		</td>
	</tr>
	<tr>
		<td></td>
		<td>
			(3D)
		</td>
		<td>
			<input type="text" name="red" value="" placeholder="A" onkeyup="value=value.replace(/[^\d]/g,'')">
		</td>
		<td>
			<input type="text" name="red" value="" placeholder="C2" onkeyup="value=value.replace(/[^\d]/g,'')">
		</td>
		<td>
			<input type="text" name="red" value="" placeholder="C3" onkeyup="value=value.replace(/[^\d]/g,'')">
		</td>
		<td>
			<input type="text" name="red" value="" placeholder="C4" onkeyup="value=value.replace(/[^\d]/g,'')">
		</td>
		<td>
			<input type="text" name="red" value="" placeholder="C5" onkeyup="value=value.replace(/[^\d]/g,'')">
		</td>
		<td>
			<input type="text" name="red" value="" placeholder="3ABC" onkeyup="value=value.replace(/[^\d]/g,'')">
		</td>
		<td>
			<input type="text" name="red" value="" placeholder="EC" onkeyup="value=value.replace(/[^\d]/g,'')">
		</td>
	</tr>
	<tr>
		<td>控制红字</td>
		<td>
			(2D)
		</td>
		<td>
			<input type="text" name="red" value="" placeholder="2A" onkeyup="value=value.replace(/[^\d]/g,'')">
		</td>
		<td>
			<input type="text" name="red" value="" placeholder="2B" onkeyup="value=value.replace(/[^\d]/g,'')">
		</td>
		<td>
			<input type="text" name="red" value="" placeholder="2C" onkeyup="value=value.replace(/[^\d]/g,'')">
		</td>
		<td>
			<input type="text" name="red" value="" placeholder="2D" onkeyup="value=value.replace(/[^\d]/g,'')">
		</td>
		<td>
			<input type="text" name="red" value="" placeholder="2E" onkeyup="value=value.replace(/[^\d]/g,'')">
		</td>
		<td>
			<input type="text" name="red" value="" placeholder="2ABC" onkeyup="value=value.replace(/[^\d]/g,'')">
		</td>
		<td>
			<input type="text" name="red" value="" placeholder="EX" onkeyup="value=value.replace(/[^\d]/g,'')">
		</td>
	</tr>
	<tr>
		<td></td>
		<td></td>
		<td>
			<input type="text" name="red" value="" placeholder="5D" onkeyup="value=value.replace(/[^\d]/g,'')">
		</td>
	</tr>
	<tr>
		<td></td>
		<td></td>
		<td>
			<input type="text" name="red" value="" placeholder="6D" onkeyup="value=value.replace(/[^\d]/g,'')">
		</td>
	</tr>
</table>
<table class="table table-bordered">
	<tr>
		<td>
			吃字控制：
		</td>
		<td colspan="25">
			<label>
				<input type="checkbox" name="same" value="1">
				All same
			</label>
		</td>
	</tr>
	<tr>
		<td>
			吃法：
		</td>
		<td colspan="3">
			吃字 <input type="checkbox" name="has_eat" value="1">
			分红 <input type="checkbox" name="has_bonus" value="1">
			
		</td>
		<td colspan="22">
			JUBAO分红 <input type="checkbox" name="jb_bonus" value="1">
		</td>
	</tr>
	<tr>
		<td>
			百分比：
		</td>
		<td colspan="3">
			<input type="text" name="percent" value="" onkeyup="value=value.replace(/[^\d]/g,'')">%
		</td>
		<td colspan="2">JUBAO百分比：</td>
		<td colspan="20"><input type="text" name="jb_percent" value="" onkeyup="value=value.replace(/[^\d]/g,'')">%</td>
	</tr>
	<tr>
		<td>
			吃字配套：
		</td>
		<td colspan="25">
			
		</td>
	</tr>
	<tr>
		<td>
		</td>
		<?php  if(is_array($beto)) { foreach($beto as $bet) { ?>
		<td><?php  echo $bet;?></td>
		<?php  } } ?>
	</tr>
	<?php  if(is_array($company)) { foreach($company as $com) { ?>
	<tr>
		<td>
			<?php  echo $com['nickname'];?>
			<label style="width: 80px;">
				全部一样
				<input type="checkbox" name="line_same" value="1" id="same_<?php  echo $com['id'];?>">
			</label>
			<input type="hidden" class="company_id" value="<?php  echo $com['id'];?>">
		</td>
		<?php  if(is_array($beto)) { foreach($beto as $b) { ?>
		<?php  if(($b!='5D' || $com['has_5D'] == 1) && ($b!='6D' || $com['has_6D'] == 1)) { ?>
		<td><input type="text" id="eat_<?php  echo $com['id'];?>_<?php  echo $b;?>" value="<?php  echo $com[$b];?>" class="limit_<?php  echo $com['id'];?> limit" data-value="<?php  echo $com['id'];?>"></td>
		<?php  } ?>
		<?php  } } ?>
	</tr>
	<?php  } } ?>
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
			<?php  if(is_array($list1)) { foreach($list1 as $gp1) { ?>
			<table class="table table-bordered" style="margin-bottom: 5px;background-color: #70ffe261;">
				<tr>
					<td colspan="6" style="text-align: center;">
						group:<?php  echo $gp1['group_name'];?>
					</td>
				</tr>
				<tr>
					<td></td>
					<td></td>
					<td>ID</td>
					<td>BSAC4A2A</td>
					<td>水钱</td>
				</tr>
				<?php  if(is_array($gp1['odds'])) { foreach($gp1['odds'] as $item1) { ?>
				<tr>
					<td><input type="checkbox" name="odds_id" value="<?php  echo $item1['id'];?>"></td>
					<td><a href="javascript:void(0)" data-toggle="collapse" data-target="#detail_<?php  echo $item1['id'];?>"><span>详细</span></a></td>
					<td><?php  echo $item1['id'];?></td>
					<td><?php  echo $item1['odds_B']['0'];?>/<?php  echo $item1['odds_S']['0'];?>/<?php  echo $item1['odds_A'];?>/<?php  echo $item1['odds_3ABC']['0'];?>/<?php  echo $item1['odds_4A'];?>/<?php  echo $item1['odds_2A'];?></td>
					<td><?php  echo $item1['cashback']['B'];?>-<?php  echo $item1['cashback']['S'];?>-<?php  echo $item1['cashback']['A'];?>-<?php  echo $item1['cashback']['3ABC'];?>-<?php  echo $item1['cashback']['4A'];?>-<?php  echo $item1['cashback']['2A'];?></td>
				</tr>
				<tr id="detail_<?php  echo $item1['id'];?>" class="collapse">
					<td colspan="7" style="padding: 0;border: 0;">
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
								<td style="width: 3vw;">抽佣</td>
								<td>B</td>
								<td><input type="text" class="commission_<?php  echo $item1['id'];?>" value="0" onchange="cal_cashback(<?php  echo $item1['id'];?>,'b')"></td>
								<td>S</td>
								<td><input type="text" class="commission_<?php  echo $item1['id'];?>" value="0" onchange="cal_cashback(<?php  echo $item1['id'];?>,'s')"></td>
								<td>A~EC</td>
								<td><input type="text" class="commission_<?php  echo $item1['id'];?>" value="0" onchange="cal_cashback(<?php  echo $item1['id'];?>,'a')"></td>
								<td>3ABC</td>
								<td><input type="text" class="commission_<?php  echo $item1['id'];?>" value="0" onchange="cal_cashback(<?php  echo $item1['id'];?>,'3abc')"></td>
								<td>4A~EA</td>
								<td><input type="text" class="commission_<?php  echo $item1['id'];?>" value="0" onchange="cal_cashback(<?php  echo $item1['id'];?>,'4a')"></td>
								<td>4AC</td>
								<td><input type="text" class="commission_<?php  echo $item1['id'];?>" value="0" onchange="cal_cashback(<?php  echo $item1['id'];?>,'4abc')"></td>
								<td>2A~EX</td>
								<td><input type="text" class="commission_<?php  echo $item1['id'];?>" value="0" onchange="cal_cashback(<?php  echo $item1['id'];?>,'2a')"></td>
								<td>2ABC</td>
								<td><input type="text" class="commission_<?php  echo $item1['id'];?>" value="0" onchange="cal_cashback(<?php  echo $item1['id'];?>,'2abc')"></td>
								<td>5D</td>
								<td><input type="text" class="commission_<?php  echo $item1['id'];?>" value="0" onchange="cal_cashback(<?php  echo $item1['id'];?>,'5d')"></td>
								<td>6D</td>
								<td><input type="text" class="commission_<?php  echo $item1['id'];?>" value="0" onchange="cal_cashback(<?php  echo $item1['id'];?>,'6d')"></td>
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
								<td><input type="text" class="odds_2a_<?php  echo $item1['id'];?>" readonly value="<?php  echo $item1['odds_2A']['0'];?>"></td>
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
			<?php  if(is_array($list2)) { foreach($list2 as $gp2) { ?>
			<table class="table table-bordered" style="margin-bottom: 5px;background-color: #ffce887a;">
				<tr>
					<td colspan="6" style="text-align: center;">
						group:<?php  echo $gp2['group_name'];?>
					</td>
				</tr>
				<tr>
					<td></td>
					<td></td>
					<td>ID</td>
					<td>BSAC4A2A</td>
					<td>水钱</td>
				</tr>
				<?php  if(is_array($gp2['odds'])) { foreach($gp2['odds'] as $item2) { ?>
				<tr>
					<td><input type="checkbox" name="odds_id" value="<?php  echo $item2['id'];?>"></td>
					<td><a href="javascript:void(0)" data-toggle="collapse" data-target="#detail_<?php  echo $item2['id'];?>"><span>详细</span></a></td>
					<td><?php  echo $item2['id'];?></td>
					<td><?php  echo $item2['odds_B']['0'];?>/<?php  echo $item2['odds_S']['0'];?>/<?php  echo $item2['odds_A'];?>/<?php  echo $item2['odds_3ABC']['0'];?>/<?php  echo $item2['odds_4A'];?>/<?php  echo $item2['odds_2A'];?></td>
					<td><?php  echo $item2['cashback']['B'];?>-<?php  echo $item2['cashback']['S'];?>-<?php  echo $item2['cashback']['A'];?>-<?php  echo $item2['cashback']['3ABC'];?>-<?php  echo $item2['cashback']['4A'];?>-<?php  echo $item2['cashback']['2A'];?></td>
				</tr>
				<tr id="detail_<?php  echo $item2['id'];?>" class="collapse">
					<td colspan="7" style="padding: 0;border: 0;">
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
								<td><input type="text" class="odds_2a_<?php  echo $item2['id'];?>" readonly value="<?php  echo $item2['odds_2A']['0'];?>"></td>
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
<div class="col-xs-12" style="padding: 0;margin-bottom: 10px;">
	<input type="hidden" name="odd_id" value="">
	<input type="hidden" name="id" id="cuser_id" value="<?php echo $_GPC['agent_id']?$_GPC['agent_id']:$_SESSION['mid']?>">
	<a href="javascript:void(0);" class="btn btn-success btn-lg" onclick="cashback_post()">提交</a>
</div>
<script type="text/javascript">
	$('.limit').on('keyup',function() {
		var id = $(this).attr('data-value');
		var checked = $('#same_'+id).is(':checked');
		if (checked == true) {
			$('.limit_'+id).val($(this).val());
		}
	})
	function check_num(obj){
		obj.value = obj.value.replace(/[^\d.-]/g,""); //清除"数字"和"."以外的字符
		obj.value = obj.value.replace(/^\./g,""); //验证第一个字符是数字
		obj.value = obj.value.replace(/\.{2,}/g,"."); //只保留第一个, 清除多余的
		obj.value = obj.value.replace(/\-{2,}/g,"-"); //只保留第一个, 清除多余的
		obj.value = obj.value.replace(".","$#$").replace(/\./g,"").replace("$#$",".");
		obj.value = obj.value.replace("-","$#$").replace(/\-/g,"").replace("$#$","-");
		obj.value = obj.value.replace(/^(\-)*(\d+)\.(\d\d).*$/,'$1$2.$3'); //只能输入两个小数
		if (obj.value.indexOf('-') > 0) {
			obj.value = obj.value.replace(/\-/g,"");
		}
	}
	function cashback_post() {
		var id = $('#cuser_id').val();
		var odds = [];
		var commission = [];
		var cashback = [];
		var eat = [];
		var limit = $('#limit').val();
		var bet = $('#bet').val();
		var red = [];
		var all_line = $('input[name=all_line]:checked').val();
		var has_eat = $('input[name=has_eat]:checked').val();
		var has_bonus = $('input[name=has_bonus]:checked').val();
		var give = $('input[name=give]').val();
		var recharge = $('input[name=recharge]').val();
		var account = $('input[name=account]').val();
		var nickname = $('input[name=nickname]').val();
		var password = $('input[name=password]').val();
		var repassword = $('input[name=repassword]').val();
		var percent = $('input[name=percent]').val();
		var status = $('select[name=status]').val();
		var auto_create = $('input[name=auto_create]:checked').val();
		var jb_bonus = $('input[name=jb_bonus]:checked').val();
		var jb_percent = $('input[name=jb_percent]').val();
		var auto_recharge = $('input[name=auto_recharge]:checked').val();
		var auto_value = $('input[name=auto_value]').val();
		$('input[name=red]').each(function() {
			var rule = $(this).attr('placeholder');
			var rule_val = $(this).val();
			red.push({rule:rule,value:rule_val});
		});
		$('input[name=odds_id]:checked').each(function() {
			var odd_id = $(this).val();
			odds.push($(this).val());
			var comm = [];
			var cash = [];
			$('.commission_'+odd_id).each(function() {
				comm.push($(this).val());
			})
			commission.push({"id":odd_id,"detail":{"B":comm[0],"S":comm[1],"A":comm[2],"3ABC":comm[3],"4A":comm[4],"4ABC":comm[5],"2A":comm[6],"2ABC":comm[7],"5D":comm[8],"6D":comm[9]}});
			cashback.push({"id":odd_id,"detail":{"B":$('#cashback_money_b_'+odd_id).text(),"S":$('#cashback_money_s_'+odd_id).text(),"A":$('#cashback_money_a_'+odd_id).text(),"3ABC":$('#cashback_money_3abc_'+odd_id).text(),"4A":$('#cashback_money_4a_'+odd_id).text(),"4ABC":$('#cashback_money_4abc_'+odd_id).text(),"2A":$('#cashback_money_2a_'+odd_id).text(),"2ABC":$('#cashback_money_2abc_'+odd_id).text(),"5D":$('#cashback_money_5d_'+odd_id).text(),"6D":$('#cashback_money_6d_'+odd_id).text()}});
		});
		$('.company_id').each(function() {
			var company_id = $(this).val();
			eat.push({"id":company_id,'detail':{"B":$('#eat_'+company_id+'_B').val(),"S":$('#eat_'+company_id+'_S').val(),"A":$('#eat_'+company_id+'_A').val(),"C2":$('#eat_'+company_id+'_C2').val(),"C3":$('#eat_'+company_id+'_C3').val(),"C4":$('#eat_'+company_id+'_C4').val(),"C5":$('#eat_'+company_id+'_C5').val(),"EC":$('#eat_'+company_id+'_EC').val(),"3ABC":$('#eat_'+company_id+'_3ABC').val(),"4A":$('#eat_'+company_id+'_4A').val(),"4B":$('#eat_'+company_id+'_4B').val(),"4C":$('#eat_'+company_id+'_4C').val(),"4D":$('#eat_'+company_id+'_4D').val(),"4E":$('#eat_'+company_id+'_4E').val(),"EA":$('#eat_'+company_id+'_EA').val(),"4ABC":$('#eat_'+company_id+'_4ABC').val(),"2A":$('#eat_'+company_id+'_2A').val(),"2B":$('#eat_'+company_id+'_2B').val(),"2C":$('#eat_'+company_id+'_2C').val(),"2D":$('#eat_'+company_id+'_2D').val(),"2E":$('#eat_'+company_id+'_2E').val(),"EX":$('#eat_'+company_id+'_EX').val(),"2ABC":$('#eat_'+company_id+'_2ABC').val(),"5D":$('#eat_'+company_id+'_5D').val(),"6D":$('#eat_'+company_id+'_6D').val()}})
		});

		$.post("<?php  echo $this->createMobileUrl('add_account')?>",{agent_id:id,percent:percent,odds:odds,account:account,nickname:nickname,password:password,repassword:repassword,commission:commission,eat:eat,limit:limit,bet:bet,recharge:recharge,cashback:cashback,auto_create:auto_create,all_line:all_line,jb_bonus:jb_bonus,jb_percent:jb_percent,red:red,status:status,auto_recharge:auto_recharge,auto_value:auto_value},function(result) {
			alert(result.message);
			if (result.type == 'success') {
				location.href = "<?php  echo $this->createMobileUrl('manager',array('op'=>'display','agent_id'=>$_GPC['agent_id']))?>";
			}
			if (result.type == 'unlog') {
				location.href = "<?php  echo $this->createMobileUrl('login')?>";
			}
		},'JSON');
	}

	$('#auto_recharge').click(function() {
		console.log('点击了');
		var checked = $(this).is(':checked');
		if (checked == true) {
			console.log('自动');
			$('input[name=recharge]').prop('disabled',true);
			$('input[name=auto_value]').prop('disabled',false);
		}
		else{
			console.log('不自动');
			$('input[name=auto_value]').prop('disabled',true);
			$('input[name=recharge]').prop('disabled',false);
		}
	})
</script>
<?php  } else if($op == 'addMember') { ?>
<style type="text/css" media="screen">
	table tr td input[type=text]{width: 50px;height: 18px;font-size: 16px;}
	.table>tbody>tr>td{padding: 2px 2px;}
</style>
<div class="col-xs-12" style="padding: 0;margin-bottom: 10px;">
	<button type="button" class="btn btn-success btn-lg" onclick="odds_post()">提交</button>
</div>
<table class="table table-bordered">
	<tr style="border-top: 5px solid #eee; ">
		<td>新账户</td>
		<td><input type="text" name="account" class="input1" placeholder="请输入账户名称" style="width: 100%;"></td>
		<td>密码</td>
		<td><input type="text" name="password" class="input1" placeholder="请输入密码" style="width: 100%;"></td>
	</tr>
	<tr>
		<td>昵称</td>
		<td><input type="text" name="nickname" class="input1" placeholder="请输入昵称" style="width: 100%;"></td>
		<td>确认密码</td>
		<td><input type="text" name="repassword" class="input1" placeholder="请再次输入密码" style="width: 100%;"></td>
	</tr>
	<tr>
		<tr>
			<td>手机号码</td>
			<td>
				<input type="text" name="mobile" value="" onkeyup="value=value.replace(/[^\d]/g,'')" style="width: 100%;">
			</td>
		</tr>
		<td>状态</td>
		<td colspan="3">
			<select name="status">
				<option value="0">活跃</option>
				<option value="2">试用</option>
				<option value="1">禁用</option>
			</select>
		</td>
	</tr>
</table>
<table class="table table-bordered">
	<tr>
		<td colspan="5">
			上线积分：<?php  echo $member['credit1'];?>
		</td>
		<td colspan="5">
			当前积分：0
		</td>
	</tr>
	<tr>
		<td>充/减值：</td>
		<td colspan="2">
			<input type="text" onkeyup="value=value.replace(/[^\d]/g,'')" value="1000" name="recharge" style="width: 100px;"> X = <input type="text" name="give" value="" onkeyup="value=value.replace(/[^\d]/g,'')">%
		</td>
		<td colspan="7">
			自动回值： <input type="checkbox" name="auto_recharge" value="1" id="auto_recharge">
			&nbsp;&nbsp;&nbsp;
			回值额度： <input type="text" name="auto_value" onkeyup="value=value.replace(/[^\d]/g,'')" disabled="disabled">
		</td>
	</tr>
	<tr>
		<td>总额控制(控制一张单的投注总额)</td>
		<td><input type="text" name="limit" id="limit" value="1000" onkeyup="value=value.replace(/[^\d]/g,'')" style="width: 100px;"></td>
	</tr>
	<tr>
		<td>控制红字</td>
		<td>
			(4D)
		</td>
		<td>
			<input type="text" name="red" value="" placeholder="B" onkeyup="value=value.replace(/[^\d]/g,'')">
		</td>
		<td>
			<input type="text" name="red" value="" placeholder="S" onkeyup="value=value.replace(/[^\d]/g,'')">
		</td>
		<td>
			<input type="text" name="red" value="" placeholder="4A" onkeyup="value=value.replace(/[^\d]/g,'')">
		</td>
		<td>
			<input type="text" name="red" value="" placeholder="4B" onkeyup="value=value.replace(/[^\d]/g,'')">
		</td>
		<td>
			<input type="text" name="red" value="" placeholder="4C" onkeyup="value=value.replace(/[^\d]/g,'')">
		</td>
		<td>
			<input type="text" name="red" value="" placeholder="4D" onkeyup="value=value.replace(/[^\d]/g,'')">
		</td>
		<td>
			<input type="text" name="red" value="" placeholder="4E" onkeyup="value=value.replace(/[^\d]/g,'')">
		</td>
		<td>
			<input type="text" name="red" value="" placeholder="4ABC" onkeyup="value=value.replace(/[^\d]/g,'')">
		</td>
		<td>
			<input type="text" name="red" value="" placeholder="EA" onkeyup="value=value.replace(/[^\d]/g,'')">
		</td>
	</tr>
	<tr>
		<td></td>
		<td>
			(3D)
		</td>
		<td>
			<input type="text" name="red" value="" placeholder="A" onkeyup="value=value.replace(/[^\d]/g,'')">
		</td>
		<td>
			<input type="text" name="red" value="" placeholder="C2" onkeyup="value=value.replace(/[^\d]/g,'')">
		</td>
		<td>
			<input type="text" name="red" value="" placeholder="C3" onkeyup="value=value.replace(/[^\d]/g,'')">
		</td>
		<td>
			<input type="text" name="red" value="" placeholder="C4" onkeyup="value=value.replace(/[^\d]/g,'')">
		</td>
		<td>
			<input type="text" name="red" value="" placeholder="C5" onkeyup="value=value.replace(/[^\d]/g,'')">
		</td>
		<td>
			<input type="text" name="red" value="" placeholder="3ABC" onkeyup="value=value.replace(/[^\d]/g,'')">
		</td>
		<td>
			<input type="text" name="red" value="" placeholder="EC" onkeyup="value=value.replace(/[^\d]/g,'')">
		</td>
	</tr>
	<tr>
		<td>控制红字</td>
		<td>
			(2D)
		</td>
		<td>
			<input type="text" name="red" value="" placeholder="2A" onkeyup="value=value.replace(/[^\d]/g,'')">
		</td>
		<td>
			<input type="text" name="red" value="" placeholder="2B" onkeyup="value=value.replace(/[^\d]/g,'')">
		</td>
		<td>
			<input type="text" name="red" value="" placeholder="2C" onkeyup="value=value.replace(/[^\d]/g,'')">
		</td>
		<td>
			<input type="text" name="red" value="" placeholder="2D" onkeyup="value=value.replace(/[^\d]/g,'')">
		</td>
		<td>
			<input type="text" name="red" value="" placeholder="2E" onkeyup="value=value.replace(/[^\d]/g,'')">
		</td>
		<td>
			<input type="text" name="red" value="" placeholder="2ABC" onkeyup="value=value.replace(/[^\d]/g,'')">
		</td>
		<td>
			<input type="text" name="red" value="" placeholder="EX" onkeyup="value=value.replace(/[^\d]/g,'')">
		</td>
	</tr>
	<tr>
		<td></td>
		<td></td>
		<td>
			<input type="text" name="red" value="" placeholder="5D" onkeyup="value=value.replace(/[^\d]/g,'')">
		</td>
	</tr>
	<tr>
		<td></td>
		<td></td>
		<td>
			<input type="text" name="red" value="" placeholder="6D" onkeyup="value=value.replace(/[^\d]/g,'')">
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
					<option value="<?php  echo $odd1['id'];?>">ID：<?php  echo $odd1['pid'];?></option>
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
					<td><?php  echo $item1['cashback']['B'];?>-<?php  echo $item1['cashback']['S'];?>-<?php  echo $item1['cashback']['A'];?>-<?php  echo $item1['cashback']['3ABC'];?>-<?php  echo $item1['cashback']['4A'];?>-<?php  echo $item1['cashback']['2A'];?></td>
				</tr>
				<tr id="detail_<?php  echo $item1['id'];?>" class="collapse">
					<td colspan="4" style="padding: 0;border: 0;">
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
								<td style="width: 3vw;">抽佣</td>
								<td>B</td>
								<td><input type="text" class="commission_<?php  echo $item1['id'];?>" value="0" onchange="cal_cashback(<?php  echo $item1['id'];?>,'b')"></td>
								<td>S</td>
								<td><input type="text" class="commission_<?php  echo $item1['id'];?>" value="0" onchange="cal_cashback(<?php  echo $item1['id'];?>,'s')"></td>
								<td>A~EC</td>
								<td><input type="text" class="commission_<?php  echo $item1['id'];?>" value="0" onchange="cal_cashback(<?php  echo $item1['id'];?>,'a')"></td>
								<td>3ABC</td>
								<td><input type="text" class="commission_<?php  echo $item1['id'];?>" value="0" onchange="cal_cashback(<?php  echo $item1['id'];?>,'3abc')"></td>
								<td>4A~EA</td>
								<td><input type="text" class="commission_<?php  echo $item1['id'];?>" value="0" onchange="cal_cashback(<?php  echo $item1['id'];?>,'4a')"></td>
								<td>4AC</td>
								<td><input type="text" class="commission_<?php  echo $item1['id'];?>" value="0" onchange="cal_cashback(<?php  echo $item1['id'];?>,'4abc')"></td>
								<td>2A~EX</td>
								<td><input type="text" class="commission_<?php  echo $item1['id'];?>" value="0" onchange="cal_cashback(<?php  echo $item1['id'];?>,'2a')"></td>
								<td>2ABC</td>
								<td><input type="text" class="commission_<?php  echo $item1['id'];?>" value="0" onchange="cal_cashback(<?php  echo $item1['id'];?>,'2abc')"></td>
								<td>5D</td>
								<td><input type="text" class="commission_<?php  echo $item1['id'];?>" value="0" onchange="cal_cashback(<?php  echo $item1['id'];?>,'5d')"></td>
								<td>6D</td>
								<td><input type="text" class="commission_<?php  echo $item1['id'];?>" value="0" onchange="cal_cashback(<?php  echo $item1['id'];?>,'6d')"></td>
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
								<td><input type="text" class="odds_2a_<?php  echo $item1['id'];?>" readonly value="<?php  echo $item1['odds_2A']['0'];?>"></td>
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
					<option value="<?php  echo $odd2['id'];?>">ID：<?php  echo $odd2['pid'];?></option>
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
					<td><?php  echo $item2['cashback']['B'];?>-<?php  echo $item2['cashback']['S'];?>-<?php  echo $item2['cashback']['A'];?>-<?php  echo $item2['cashback']['3ABC'];?>-<?php  echo $item2['cashback']['4A'];?>-<?php  echo $item2['cashback']['2A'];?></td>
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
								<td><input type="text" class="odds_2a_<?php  echo $item2['id'];?>" readonly value="<?php  echo $item2['odds_2A']['0'];?>"></td>
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
			<input type="text" name="auto_add" maxlength="2" onkeyup="value=value.replace(/[^\d]/g,'')">%
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
			<input type="text" name="show_amount" maxlength="2" onkeyup="value=value.replace(/[^\d]/g,'')">%
		</td>
	</tr>
	<tr>
		<td>虚伪价格：<input type="checkbox" name="has_false" value="1"></td>
		<td>
			<input type="text" name="false_price" maxlength="2" onkeyup="value=value.replace(/[^\d]/g,'')" disabled>%
		</td>
	</tr>
</table>
<!-- <table class="table table-bordered">
	<tr>
		<td colspan="2">
			特别设置
		</td>
	</tr>
	<tr>
		<td>
			控制系统
		</td>
		<td>
			<select name="control">
				<option value="1">系统</option>
				<option value="0">不控制</option>
			</select>
		</td>
	</tr>
</table> -->
<div class="col-xs-12" style="padding: 0;margin-top: 10px;">
	<input type="hidden" name="agent_id" value="<?php echo $_GPC['agent_id']?$_GPC['agent_id']:$_SESSION['mid']?>">
	<input type="hidden" name="area_id" id="area_id" value="0">
	<a href="javascript:void(0);" class="btn btn-success btn-lg" onclick="odds_post()">提交</a>
</div>
<script type="text/javascript">
	function odds_post() {
		var agent_id = $('input[name=agent_id]').val();
		var account = $('input[name=account]').val();
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
		var auto_add = $('input[name=autor_add]').val();
		var show_amount = $('input[name=show_amount]').val();
		var status = $('select[name=status]').val();
		var auto_recharge = $('input[name=auto_recharge]:checked').val();
		var auto_value = $('input[name=auto_value]').val();
		var mobile = $('input[name=mobile]').val();
		var has_false = $('input[name=has_false]:checked').val()
		var false_price = $('input[name=false_price]').val();
		odds.push($('#odds1_id').val());
		odds.push($('#odds2_id').val());
		$('input[name=red]').each(function() {
			var rule = $(this).attr('placeholder');
			var rule_val = $(this).val();
			red.push({rule:rule,value:rule_val});
		});
		$('.commission_'+odds1).each(function() {
			com1.push($(this).val());
		})
		commission.push({"id":$('#odds1_id').val(),"detail":{"B":com1[0],"S":com1[1],"A":com1[2],"3ABC":com1[3],"4A":com1[4],"4ABC":com1[5],"2A":com1[6],"2ABC":com1[6],"5D":com1[7],"6D":com1[9]},"cashback":{"B":$('#cashback_money_b_'+odds1).text(),"S":$('#cashback_money_s_'+odds1).text(),"A":$('#cashback_money_a_'+odds1).text(),"3ABC":$('#cashback_money_3abc_'+odds1).text(),"4A":$('#cashback_money_4a_'+odds1).text(),"4ABC":$('#cashback_money_4abc_'+odds1).text(),"2A":$('#cashback_money_2a_'+odds1).text(),"2ABC":$('#cashback_money_2abc_'+odds1).text(),"5D":$('#cashback_money_5d_'+odds1).text(),"6D":$('#cashback_money_6d_'+odds1).text()}});
		$('.commission_'+odds2).each(function() {
			com2.push($(this).val());
		})
		commission.push({"id":$('#odds2_id').val(),"detail":{"B":com2[0],"S":com2[1],"A":com2[2],"3ABC":com2[3],"4A":com2[4],"4ABC":com2[5],"2A":com2[6],"2ABC":com2[6],"5D":com2[7],"6D":com2[9]},"cashback":{"B":$('#cashback_money_b_'+odds2).text(),"S":$('#cashback_money_s_'+odds2).text(),"A":$('#cashback_money_a_'+odds2).text(),"3ABC":$('#cashback_money_3abc_'+odds2).text(),"4A":$('#cashback_money_4a_'+odds2).text(),"4ABC":$('#cashback_money_4abc_'+odds2).text(),"2A":$('#cashback_money_2a_'+odds2).text(),"2ABC":$('#cashback_money_2abc_'+odds2).text(),"5D":$('#cashback_money_5d_'+odds2).text(),"6D":$('#cashback_money_6d_'+odds2).text()}});
		$.post("<?php  echo $this->createMobileUrl('add_player')?>",{agent_id:agent_id,odds:odds,commission:commission,account:account,nickname:nickname,password:password,repassword:repassword,limit:limit,credit:credit,bet:bet,recharge:recharge,give:give,auto_add:auto_add,show_amount:show_amount,auto_recharge:auto_recharge,auto_value:auto_value,red:red,mobile:mobile,has_false:has_false,false_price:false_price},function(result) {
			alert(result.message);
			if (result.type == 'unlog') {
				location.href="./index.php?i=6&c=entry&m=purchasing&do=login";
			}
			if (result.type == 'success') {
				location.href = "<?php  echo $this->createMobileUrl('manager',array('op'=>'display','agent_id'=>$_GPC['agent_id']))?>";
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
			$('input[name=give]').prop('disabled',false);
			$('input[name=recharge]').prop('disabled',false);
		}
	})


	function keyupcheck(obj) {
		obj.value = obj.value.replace(/[^\d.]/g,""); //清除"数字"和"."以外的字符
		obj.value = obj.value.replace(/^\./g,""); //验证第一个字符是数字
		obj.value = obj.value.replace(/\.{2,}/g,"."); //只保留第一个, 清除多余的
		obj.value = obj.value.replace(".","$#$").replace(/\./g,"").replace("$#$",".");
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
</script>
<?php  } ?>
<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('footer', TEMPLATE_INCLUDEPATH)) : (include template('footer', TEMPLATE_INCLUDEPATH));?>