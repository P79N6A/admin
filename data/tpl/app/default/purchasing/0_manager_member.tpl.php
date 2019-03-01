<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('header', TEMPLATE_INCLUDEPATH)) : (include template('header', TEMPLATE_INCLUDEPATH));?>
<style type="text/css">
	.btn{border: 1px solid #3e3e3e;background-color: #3e3e3e;border-radius: 20px;color: #fff;padding: 3px 7px;}
	.btn:hover{background: #fff;color: #333}
	a:hover{text-indent: none;}
	a{color: #333;}
</style>
<div class="col-xs-12">
	<div class="col-xs-12" style="padding: 10px 0;">
		<a href="<?php  echo $this->createMobileUrl('manager',array('op'=>'member','tab'=>'display','member_id'=>$_GPC['member_id'],'agent_id'=>$_GPC['agent_id']))?>" class="btn" <?php  if($tab == 'display') { ?>style="background:#fff;color: #333;"<?php  } ?>>赔率</a>
		<a href="<?php  echo $this->createMobileUrl('manager',array('op'=>'member','tab'=>'charge','member_id'=>$_GPC['member_id'],'agent_id'=>$_GPC['agent_id']))?>" class="btn" <?php  if($tab == 'charge') { ?>style="background:#fff;color: #333;"<?php  } ?>>积分</a>
		<!-- <a href="<?php  echo $this->createMobileUrl('manager',array('op'=>'member','tab'=>'minus','member_id'=>$_GPC['member_id']))?>" class="btn" <?php  if($tab == 'minus') { ?>style="background:#fff;color: #333;"<?php  } ?>>减值</a> -->
		<a href="<?php  echo $this->createMobileUrl('manager',array('op'=>'member','tab'=>'password','member_id'=>$_GPC['member_id'],'agent_id'=>$_GPC['agent_id']))?>" class="btn" <?php  if($tab == 'password') { ?>style="background:#fff;color: #333;"<?php  } ?>>名称密码</a>
		<?php  if($status == 0) { ?>
		<a href="javascript:void(0);" class="btn" onclick="limit_bet(<?php  echo $_GPC['member_id'];?>,1)">限制投注</a>
		<?php  } else { ?>
		<a href="javascript:void(0);" class="btn" onclick="limit_bet(<?php  echo $_GPC['member_id'];?>,2)" style="background: #fff;color: #333;">开放投注</a>
		<?php  } ?>
	</div>
	<div class="col-xs-12" style="border: 1px solid #eee;">
		<a href="<?php  echo $this->createMobileUrl('manager',array('op'=>'display','agent_id'=>$member['parent_agent']))?>" style="margin-right: 10px">返回</a>账号信息：<?php  echo $member['account'];?>(积分：<?php  echo $member['credit1'];?>)
	</div>
	<script type="text/javascript">
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
						location.href = "<?php  echo $this->createMobileUrl('manager',array('op'=>'display','agent_id'=>$member['parent_agent']))?>";
					}
					if (result.status == 3) {
						location.href="./index.php?i=6&c=entry&m=purchasing&do=login";
					}
				},'JSON');
			}
		}
	</script>
	<?php  if($tab == 'display') { ?>
	<style type="text/css" media="screen">
		table tr td input{width: 100%;}
		.save-area{width: 100%;height: 100%;background: rgba(0,0,0,0.4);top: 0;left: 0;position: fixed;display: none;}
		.save-div{width: 30%;background: #fff;margin: 15% auto;}
		.get-area{width: 100%;height: 100%;background: rgba(0,0,0,0.4);top: 0;left: 0;position: fixed;display: none;}
		.get-div{width: 30%;background: #fff;margin: 15% auto;}
		.save-title{height: 2vw;line-height: 2vw;text-align: center;background: #333;}
		.save-title p{font-size: 18px;color: #FFF;padding: 0 8px;}
		.save-body{padding: 8px;}
		.save-bottom{height: 1.5vw;width: 100%;border-top: 1px solid #ccc;}
		.save-btn{width: 50%;float: left;line-height: 1.5vw;height: 100%;text-align: center;}
		.save-btn a{color: #333;}
		.odds-table{width: 100%;text-align: center;}
		.odds-table tr td{padding: 4px 0;border-top: 1px solid #ccc;}
		#odds-title{width: 50%;margin: 0 auto;display: block;}
		.pack{background: #fff;color: #333;}
		.check_icon{width: 1vw;vertical-align: middle;}
		.btn{margin-right: 5px;}
		.has_used{font-size: 5vh;min-width: 4vw;}
	</style>
	<table class="table table-bordered">
		<tr>
			<td>盘口</td>
			<td colspan="16">
				<?php  if(is_array($area)) { foreach($area as $a) { ?>
				<button id="area<?php  echo $a['id'];?>" class="btn area_detail" type="button" onclick="get_odds(<?php  echo $a['id'];?>,<?php  echo $_GPC['agent_id'];?>);"><?php  echo $a['area_name'];?></button>
				<?php  } } ?>
			</td>
		</tr>
		<tr>
			<td>配套</td>
			<td colspan="16" id="odds_list">
				
			</td>
		</tr>
		<tr>
			<td>指定配套</td>
			<td colspan="16" id="odd_used">
				<?php  if(is_array($used_odds)) { foreach($used_odds as $ud) { ?>
				<button class="btn pack has_used"><?php  echo $ud['title'];?></button>
				<?php  } } ?>
			</td>
		</tr>
		<tr style="display: none">
			<td>上线反水</td>
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
			<td>抽佣</td>
			<td></td>
			<td><input type="text" class="commission" value="<?php  echo $commission['B'];?>" ></td>
			<td></td>
			<td><input type="text" class="commission" value="<?php  echo $commission['S'];?>" ></td>
			<td></td>
			<td><input type="text" class="commission" value="<?php  echo $commission['A'];?>" ></td>
			<td></td>
			<td><input type="text" class="commission" value="<?php  echo $commission['3ABC'];?>" ></td>
			<td></td>
			<td><input type="text" class="commission" value="<?php  echo $commission['4A'];?>" ></td>
			<td></td>
			<td><input type="text" class="commission" value="<?php  echo $commission['4ABC'];?>" ></td>
			<td></td>
			<td><input type="text" class="commission" value="<?php  echo $commission['2A'];?>" ></td>
			<td></td>
			<td><input type="text" class="commission" value="<?php  echo $commission['2ABC'];?>" ></td>
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
			<td>头奖</td>
			<td>B</td>
			<td><input type="text" value="0" class="odds_b" name="odds[B][]" data-value="odds_b_0" onkeyup="keyupcheck(this)"></td>
			<td>S</td>
			<td><input type="text" value="0" class="odds_s" name="odds[S][]" data-value="odds_s_0" onkeyup="keyupcheck(this)"></td>
			<td>A</td>
			<td><input type="text" value="0" class="odds_a" name="odds[A][]" data-value="odds_a" onkeyup="keyupcheck(this)"></td>
			<td>3ABC</td>
			<td><input type="text" value="0" class="odds_3abc" name="odds[3ABC][]" data-value="odds_3abc_0" onkeyup="keyupcheck(this)"></td>
			<td>4A</td>
			<td><input type="text" value="0" class="odds_4a" name="odds[4A][]" data-value="odds_4a" onkeyup="keyupcheck(this)"></td>
			<td>4AC</td>
			<td><input type="text" value="0" class="odds_4abc" name="odds[4ABC][]" data-value="odds_4abc_0" onkeyup="keyupcheck(this)"></td>
			<td>2A</td>
			<td><input type="text" value="0" class="odds_2a" name="odds[2A][]" data-value="odds_2a" onkeyup="keyupcheck(this)"></td>
			<td>2ABC</td>
			<td><input type="text" value="0" class="odds_2abc" name="odds[2ABC][]" data-value="odds_2abc_0" onkeyup="keyupcheck(this)"></td>
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
			<td colspan="6">
				<input type="hidden" name="id" id="member_id" value="<?php  echo $_GPC['member_id'];?>">
				<input type="hidden" name="used_odds" id="used_odds" value="">
				<input type="hidden" name="area_id" id="area_id" value="0">
				<a href="javascript:void(0);" class="btn" onclick="odds_post()">提交</a>
			</td>
		</tr>
	</table>
	<script type="text/javascript">
		var odds = [];
		var odds_ids = [];
		$(function() {
			get_odds("<?php  echo $used_odds[0]['cid'];?>","<?php  echo $_GPC['agent_id'];?>");
			use_odds("<?php  echo $used_odds[0]['pid'];?>",0);
		})
		function get_odds(id,agent_id) {
			$('.area_detail').removeClass('pack');
			$('#area'+id).addClass('pack');
			$('#area_id').val(id);
			var member_id = $('#member_id').val();
			$.post("<?php  echo $this->createMobileUrl('odds',array('op'=>'get_odds'))?>",{id:id,agent_id:agent_id,member_id:member_id},function(result) {
				var txt = '';
				for (var i = 0 in result) {
					if ($.inArray(result[i].id,odds_ids)>=0) {
						txt += '<button id="odd'+result[i].id+'" type="button" class="btn odds_btn pack" onclick="var has = $(this).hasClass(\'pack\');use_odds('+result[i].id+',has);"><img src="../addons/purchasing/static/images/icon_pre.png" class="check_icon" id="check'+result[i].id+'">'+result[i].title+'</button>';
						var used_txt = '<button type="button" class="btn pack has_used">'+result[i].title+'</button>';
					}
					else{
						if (result[i].used == 1) {
							txt += '<button id="odd'+result[i].id+'" type="button" class="btn odds_btn pack" onclick="var has = $(this).hasClass(\'pack\');use_odds('+result[i].id+',has);"><img src="../addons/purchasing/static/images/icon_pre.png" class="check_icon" id="check'+result[i].id+'">'+result[i].title+'</button>';
							var used_txt = '<button type="button" class="btn pack has_used">'+result[i].title+'</button>';
							var list = result[i].odds;
							console.log(result[i]);
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
							odds.push({id:list.pid,odds:list,cid:list.cid});
							odds_ids.push(list.pid);
						}
						else{
							txt += '<button id="odd'+result[i].id+'" type="button" class="btn odds_btn" onclick="var has = $(this).hasClass(\'pack\');use_odds('+result[i].id+',has);"><img src="../addons/purchasing/static/images/icon_nor.png" class="check_icon" id="check'+result[i].id+'">'+result[i].title+'</button>';
						}
						
					}
				}
				$('#odd_used').html(used_txt);
				$('#odds_list').html(txt);
			},'JSON');
		}
		function odds_post() {
			var member_id = $('#member_id').val();
			var commission = [];

			$('.commission').each(function() {
				commission.push(parseFloat($(this).val()));
			});

			var used_odds = odds_ids;
			$.post("<?php  echo $this->createMobileUrl('save_member_odds')?>",{odds:odds,member_id:member_id,commission:commission,used_odds:used_odds},function(result) {
				alert(result.info);
				if (result.status == 3) {
					location.href="./index.php?i=6&c=entry&m=purchasing&do=login";
				}
				if (result.status == 1) {
					location.href = "<?php  echo $this->createMobileUrl('manager',array('op'=>'display','agent_id'=>$member['parent_agent']))?>";
				}
			},'JSON');
		}
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
		function cal_cashback() {
			var odds_b = [];
			var odds_s = [];
			var odds_a = [];
			var odds_3abc = [];
			var odds_4a = [];
			var odds_4abc = [];
			var odds_2a = [];
			var odds_2abc = [];
			var my_cashback = [];
			var commission = [];
			var used_odds = $('#used_odds').val();

			$('.my_cashback').each(function() {
				my_cashback.push(parseFloat($(this).val()));
			});
			$('.commission').each(function() {
				commission.push(parseFloat($(this).val()));
			});

			$('.odds_b').each(function () {
				odds_b.push(parseFloat($(this).val()));
			});
			var odds_b_total = getTotal(odds_b);
			var cashback_money_b = cal_shuiqia(odds_b_total,(my_cashback[0]+commission[0]),0,1);
			

			$('.odds_s').each(function () {
				odds_s.push(parseFloat($(this).val()));
			});
			var odds_s_total = getTotal(odds_s);
			var cashback_money_s = cal_shuiqia(odds_s_total,(my_cashback[1]+commission[1]),0,1);

			$('.odds_3abc').each(function () {
				odds_3abc.push(parseFloat($(this).val()));
			});
			setallodds(odds_3abc[0],'odds_3abc');
			odds_3abc = [];
			$('.odds_3abc').each(function () {
				odds_3abc.push(parseFloat($(this).val()));
			});
			var odds_3abc_total = getTotal(odds_3abc);
			var cashback_money_3abc = cal_shuiqia(odds_3abc_total,(my_cashback[3]+commission[3]),0,2);

			$('.odds_4abc').each(function () {
				odds_4abc.push(parseFloat($(this).val()));
			});
			setallodds(odds_4abc[0],'odds_4abc');
			odds_4abc = [];
			$('.odds_4abc').each(function () {
				odds_4abc.push(parseFloat($(this).val()));
			});
			var odds_4abc_total = getTotal(odds_4abc);
			var cashback_money_4abc = cal_shuiqia(odds_4abc_total,(my_cashback[5]+commission[5]),0,1);

			$('.odds_2abc').each(function () {
				odds_2abc.push(parseFloat($(this).val()));
			});
			setallodds(odds_2abc[0],'odds_2abc');
			odds_2abc = [];
			$('.odds_2abc').each(function () {
				odds_2abc.push(parseFloat($(this).val()));
			});
			var odds_2abc_total = getTotal(odds_2abc);
			var cashback_money_2abc = cal_shuiqia(odds_2abc_total,(my_cashback[7]+commission[7]),0,3);

			$('.odds_2a').each(function () {
				odds_2a.push(parseFloat($(this).val()));
			});
			var odds_2a_max = get_max(odds_2a);
			var cashback_money_2a = cal_shuiqia(odds_2a_max,(my_cashback[6]+commission[6]),0,3);
			setallodds(odds_2a_max,'odds_2a');

			$('.odds_4a').each(function () {
				odds_4a.push(parseFloat($(this).val()));
			});
			var odds_4a_max = get_max(odds_4a);
			var cashback_money_4a = cal_shuiqia(odds_4a_max,(my_cashback[4]+commission[4]),0,1);
			setallodds(odds_4a_max,'odds_4a');

			$('.odds_a').each(function () {
				odds_a.push(parseFloat($(this).val()));
			});
			var odds_a_max = get_max(odds_a);
			var cashback_money_a = cal_shuiqia(odds_a_max,(my_cashback[2]+commission[2]),0,2);
			setallodds(odds_a_max,'odds_a');

			for (var i = 0 in odds) {
				if (odds[i].id == used_odds) {
					odds[i].odds = {odds_B:odds_b,odds_S:odds_s,odds_A:odds_a[0],odds_C2:odds_a[1],odds_C3:odds_a[2],odds_C4:odds_a[3],odds_C5:odds_a[4],odds_EC:odds_a[5],odds_3ABC:odds_3abc,odds_4A:odds_4a[0],odds_4B:odds_4a[1],odds_4C:odds_4a[2],odds_4D:odds_4a[3],odds_4E:odds_4a[4],odds_EA:odds_4a[5],odds_4ABC:odds_4abc,odds_2A:odds_2a[0],odds_2B:odds_2a[1],odds_2C:odds_2a[2],odds_2D:odds_2a[3],odds_2E:odds_2a[4],odds_EX:odds_2a[5],odds_2ABC:odds_2abc};
				}
			}
			console.log(odds);
			$('#cashback_money_b').text(Math.round(cashback_money_b));
			$('#cashback_money_s').text(Math.round(cashback_money_s));
			$('#cashback_money_a').text(Math.round(cashback_money_a));
			$('#cashback_money_3abc').text(Math.round(cashback_money_3abc));
			$('#cashback_money_4a').text(Math.round(cashback_money_4a));
			$('#cashback_money_4abc').text(Math.round(cashback_money_4abc));
			$('#cashback_money_2a').text(Math.round(cashback_money_2a));
			$('#cashback_money_2abc').text(Math.round(cashback_money_2abc));
		}
		$('input').blur(function () {
			cal_cashback();
		});
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
			if (cl == 'odds_s' || cl == 'odds_3abc' || cl == 'odds_4abc' || cl == 'odds_2abc') {
				$('.'+cl).val(odds);
			}
		}
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
		function save_odds(url) {
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
			var title = $('#odds-title').val();

			var odds = {'B':odds_b,'S':odds_s,'A':odds_a,'3ABC':odds_3abc,'4ABC':odds_4abc,'2ABC':odds_2abc,'2A':odds_2a,'4A':odds_4a};
			$.post(url,{odds:odds,title,title},function(result) {
				alert(result.info);
				if (result.status == 3) {
					location.href="./index.php?i=6&c=entry&m=purchasing&do=login";
				}
				if (result.status == 1) {
					window.location.reload();
				}
			},'JSON');
		}

		function use_odds(id,has) {
			$('.check_icon').attr('src','../addons/purchasing/static/images/icon_nor.png');
			var title = $('#odd'+id).text();
			if (has == true) {
				$('#used_odds').val(0);
				$('#odd'+id).removeClass('pack');
				$('.odds_b').val(0);
				$('.odds_s').val(0);
				$('.odds_3abc').val(0);
				$('.odds_4abc').val(0);
				$('.odds_2abc').val(0);
				$('.odds_2a').val(0);
				$('.odds_4a').val(0);
				$('.odds_a').val(0);
				for (var i = 0 in odds) {
					if (odds[i].id == id) {
						odds.splice(i,1);
					}
				}
				for (var k = 0 in odds_ids) {
					if (odds_ids[k] == id) {
						odds_ids.splice(k,1);
					}
				}
				cal_cashback();
			}
			else{
				$('.odds_btn').removeClass('pack');
				$('#odd'+id).addClass('pack');
				$('#used_odds').val(id);
				$('#check'+id).attr('src','../addons/purchasing/static/images/icon_pre.png');
				txt = '<button type="button" class="btn pack has_used" >'+title+'</button>';
				$('#odd_used').html(txt);
				$.post("<?php  echo $this->createMobileUrl('get_odds')?>",{id:id},function(result) {
					if (result.status == 3) {
						alert(result.info);
						location.href="./index.php?i=6&c=entry&m=purchasing&do=login";
					}else{
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
						$('.odds_btn').each(function() {
							var id = $(this).attr('id');
							id = id.replace(/odd/g,'');
							for (var i = 0 in odds) {
								if (odds[i].id == id) {
									odds.splice(i,1);
								}
							}
							for (var k = 0 in odds_ids) {
								if (odds_ids[k] == id) {
									odds_ids.splice(k,1);
								}
							}
						})
						odds.push({id:result.id,odds:list,cid:$('#area_id').val()});
						odds_ids.push(result.id);
						console.log(odds_ids);
						cal_cashback();
					}
					$('.get-area').hide();
				},'JSON');
			}
		}
	</script>
	<?php  } else if($tab == 'charge') { ?>
	<table class="table">
		<tr>
			<td style="width: 5vw;text-align: right;">金额：</td>
			<td><input type="text" name="money" id="money"></td>
		</tr>
		<tr>
			<td colspan="2">
				<input type="hidden" name="id" id="user_id" value="<?php  echo $_GPC['member_id'];?>" onkeyup="check_num(this);">
				<a href="javascript:void(0);" class="btn" onclick="recharge_post()">提交</a>
			</td>
		</tr>
	</table>
	<script type="text/javascript">
		function recharge_post() {
			var score = $('#money').val();
			var user_id = $('#user_id').val();
			if (score.indexOf('-') == 0) {
				var type = 2;
				score = score.replace(/\-/g,"");
			}
			else{
				var type = 1;
			}
			var user_type = 2;
			var agent_id = $('#agent_id').val();
			if (!score) {
				alert('请填写充值分数');
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
					location.href = "<?php  echo $this->createMobileUrl('manager',array('op'=>'display','agent_id'=>$member['parent_agent']))?>";
				}
			},'JSON')
		}
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
	</script>
	<?php  } else if($tab == 'minus') { ?>
	<table class="table">
		<tr>
			<td style="width: 5vw;text-align: right;">减值金额：</td>
			<td><input type="text" name="money" id="money"></td>
		</tr>
		<tr>
			<td colspan="2">
				<input type="hidden" name="id" id="user_id" value="<?php  echo $_GPC['member_id'];?>">
				<a href="javascript:void(0);" class="btn" onclick="recharge_post()">提交</a>
			</td>
		</tr>
	</table>
	<script type="text/javascript">
		function recharge_post() {
			var score = $('#money').val();
			var user_id = $('#user_id').val();
			var type = 2;
			var user_type = 2;
			var agent_id = $('#agent_id').val();
			if (!score) {
				alert('请填写减值分数');
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
					location.href = "<?php  echo $this->createMobileUrl('manager',array('op'=>'display','agent_id'=>$member['parent_agent']))?>";
				}
			},'JSON')
		}
	</script>
	<?php  } else if($tab == 'password') { ?>
	<table class="table">
		<tr>
			<td style="width: 4vw;text-align: right;">名称：</td>
			<td>
				<input type="text" name="nickname" id="nickname" value="<?php  echo $member['nickname'];?>">
			</td>
		</tr>
		<tr>
			<td style="width: 4vw;text-align: right;">密码：</td>
			<td><input type="text" name="password" id="password"></td>
		</tr>
		<tr>
			<td colspan="2">
				<input type="hidden" name="id" id="puser_id" value="<?php  echo $_GPC['member_id'];?>">
				<input type="hidden" name="user_type" id="puser_type" value="2">
				<a href="javascript:void(0);" class="btn" onclick="password_post()">提交</a>
			</td>
		</tr>
	</table>
	<script type="text/javascript">
		function password_post() {
			var user_id = $('#puser_id').val();
			var user_type = $('#puser_type').val();
			var password = $('#password').val();
			var nickname = $('#nickname').val();
			$.post("<?php  echo $this->createMobileUrl('set_password')?>",{user_id:user_id,user_type:user_type,password:password,nickname:nickname},function(result) {
				if (result.status == 405) {
					alert(result.info);
					location.href = "<?php  echo $this->createMobileUrl('login')?>";
				}
				if (result.status == 300) {
					alert(result.info);
				}
				if (result.status == 200) {
					alert(result.info);
					location.href = "<?php  echo $this->createMobileUrl('manager',array('op'=>'display','agent_id'=>$member['parent_agent']))?>";
				}
			},'JSON')
		}
	</script>
	<?php  } ?>
</div>