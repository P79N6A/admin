<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('header', TEMPLATE_INCLUDEPATH)) : (include template('header', TEMPLATE_INCLUDEPATH));?>
<style>
	.recharge-area{position: fixed;width: 100%;height: 100%;top: 0;left: 0;background: rgba(0,0,0,0.4);display: none;}
	.recharge-main{width: 50%;height: 10vw;margin: 5% auto;background: #fff;}
	.recharge-head{width: 100%;text-align: center;border-bottom: 1px solid #aaa;font-size: 20px;line-height: 30px;}
	.recharge-body{width: 100%;padding: 2vw 3vw;}
	.recharge-body table tbody tr td input[type=text]{width: 80%;border: 0;}
	.btn{border: 1px solid #3e3e3e;background-color: #3e3e3e;border-radius: 20px;color: #fff;padding: 3px 7px;}
	a:hover{text-indent: none;}
	.btn:hover{background: #fff;color: #333}
	#odds-set div table tbody tr td{padding: 4px 8px;}
	#odds-set div table tbody tr td input[type=text]{width: 80%;height: 20px;}
</style>
<div class="col-xs-12">
	<div class="col-xs-12" style="padding: 5px 0;">
		<button type="button" class="btn" onclick="set_odds();">增加配套</button>
	</div>
	<table class="table table-bordered">
		<tr>
			<td>名称</td>
			<td>所属盘口</td>
			<td>操作</td>
		</tr>
		<?php  if(is_array($list)) { foreach($list as $item) { ?>
		<tr>
			<td><?php  echo $item['title'];?></td>
			<td><?php  echo $item['area_name'];?></td>
			<td>
				<button type="button" class="btn" onclick="freeze_odds(<?php  echo $item['id'];?>,<?php  echo $item['status'];?>)"><?php  if($item['status'] == 1) { ?>冻结配套<?php  } else { ?>解冻配套<?php  } ?></button>
				<!-- <button type="button" class="btn" onclick="set_odds(<?php  echo $item['id'];?>)">修改</button> -->
				<button type="button" class="btn" onclick="del_odds(<?php  echo $item['id'];?>)">删除</button>
			</td>
		</tr>
		<?php  } } ?>
	</table>
	<?php  echo $pager;?>
</div>
<div id="odds-set" class="recharge-area">
	<div class="recharge-main" style="height: 25vw;width: 95%;overflow-y: auto;">
		<div class="recharge-head">
			设置配套
		</div>
		<div class="recharge-body" style="padding: 10px 15px;">
			<table class="table table-bordered">
				<tr>
					<td style="width: 70px;">名称</td>
					<td colspan="7">
						<input type="text" name="title" value="">
					</td>
					<td>盘口</td>
					<td colspan="8">
						<?php  if(is_array($area)) { foreach($area as $a) { ?>
						<label style="min-width: 50px;">
							<input type="checkbox" name="cid" value="<?php  echo $a['id'];?>"><?php  echo $a['area_name'];?>
						</label>
						<?php  } } ?>
					</td>
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
					<td style="width: 100px;"><input type="text" value="0" class="odds_b" name="odds[B][]" data-value="odds_b_0" onkeyup="keyupcheck(this)"></td>
					<td style="width: 30px;">S</td>
					<td style="width: 100px;"><input type="text" value="0" class="odds_s" name="odds[S][]" data-value="odds_s_0" onkeyup="keyupcheck(this)"></td>
					<td style="width: 30px;">A</td>
					<td style="width: 100px;"><input type="text" value="0" class="odds_a" name="odds[A][]" data-value="odds_a" onkeyup="keyupcheck(this)"></td>
					<td style="width: 70px;">3ABC</td>
					<td style="width: 100px;"><input type="text" value="0" class="odds_3abc" name="odds[3ABC][]" data-value="odds_3abc_0" onkeyup="keyupcheck(this)"></td>
					<td style="width: 30px;">4A</td>
					<td style="width: 100px;"><input type="text" value="0" class="odds_4a" name="odds[4A][]" data-value="odds_4a" onkeyup="keyupcheck(this)"></td>
					<td style="width: 60px;">4AC</td>
					<td style="width: 100px;"><input type="text" value="0" class="odds_4abc" name="odds[4ABC][]" data-value="odds_4abc_0" onkeyup="keyupcheck(this)"></td>
					<td style="width: 30px;">2A</td>
					<td style="width: 100px;"><input type="text" value="0" class="odds_2a" name="odds[2A][]" data-value="odds_2a" onkeyup="keyupcheck(this)"></td>
					<td style="width: 70px;">2ABC</td>
					<td style="width: 100px;"><input type="text" value="0" class="odds_2abc" name="odds[2ABC][]" data-value="odds_2abc_0" onkeyup="keyupcheck(this)"></td>
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
						<input type="hidden" name="id" id="odds_id">
						<a href="javascript:void(0);" class="btn" onclick="odds_post()">提交</a>
						<a href="javascript:void(0);" class="btn" onclick="$('#odds-set').hide();">取消</a>
					</td>
				</tr>
			</table>
		</div>
	</div>
</div>
<script type="text/javascript">
	function set_odds(id) {
		if (id > 0) {
			$('#odds_id').val(id);
			$.post("<?php  echo $this->createMobileUrl('odds',array('op'=>'detail'))?>",{id:id},function(result) {
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
				$('input[name=title]').val(list.title);
				var cid = list.cid;
				for (var i = 0 in cid) {
					$('input[value='+cid[i]+']').prop('checked',true);
				}
				$('#odds-set').show();
			},'JSON');
		}
		else{
			$('#odds_id').val('');
			for (var i = 0 ; i < 5;i++) {
				$('input[data-value=odds_b_'+i+']').val(0);
			}
			for (var j = 0; j < 3;j++) {
				$('input[data-value=odds_s_'+j+']').val(0);
			}
			for (var k = 0; k < 3;k++) {
				$('input[data-value=odds_3abc_'+k+']').val(0);
			}
			for (var l = 0; l < 3;l++) {
				$('input[data-value=odds_4abc_'+l+']').val(0);
			}
			for (var m = 0; j=m < 3;m++) {
				$('input[data-value=odds_2abc_'+m+']').val(0);
			}
			$('input[data-value=odds_a]').val(0);
			$('input[data-value=odds_c2]').val(0);
			$('input[data-value=odds_c3]').val(0);
			$('input[data-value=odds_c4]').val(0);
			$('input[data-value=odds_c5]').val(0);
			$('input[data-value=odds_4a]').val(0);
			$('input[data-value=odds_4b]').val(0);
			$('input[data-value=odds_4c]').val(0);
			$('input[data-value=odds_4d]').val(0);
			$('input[data-value=odds_4e]').val(0);
			$('input[data-value=odds_2a]').val(0);
			$('input[data-value=odds_2b]').val(0);
			$('input[data-value=odds_2c]').val(0);
			$('input[data-value=odds_2d]').val(0);
			$('input[data-value=odds_2e]').val(0);
			$('input[data-value=odds_ec]').val(0);
			$('input[data-value=odds_ea]').val(0);
			$('input[data-value=odds_ex]').val(0);
			$('input[name=title]').val('');
		}
		$('#odds-set').show();
	}
	function del_odds(id) {
		var a = confirm('确定删除该配套？');
		if (a == true) {
			$.post("<?php  echo $this->createMobileUrl('odds',array('op'=>'del'))?>",{id:id},function (result) {
				alert(result.info);
				if (result.status == 1) {
					window.location.reload();
				}
				if (result.status == 3) {
					location.href = "<?php  echo $this->createMobileUrl('login')?>";
				}
			},'JSON')
		}
	}
	function freeze_odds(id,status) {
		if (status == 1) {
			var a = confirm('确定冻结该配套');
		}
		else{
			var a = confirm('确定解冻该配套');
		}
		if (a == true) {
			$.post("<?php  echo $this->createMobileUrl('odds',array('op'=>'freeze'))?>",{id:id,status:status},function(result) {
				alert(result.info);
				if (result.status == 1) {
					window.location.reload();
				}
				if (result.status == 3) {
					location.href = "<?php  echo $this->createMobileUrl('login')?>";
				}
			},'JSON');
		}
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
		if (cl == 'odds_3abc' || cl == 'odds_4abc' || cl == 'odds_2abc') {
			$('.'+cl).val(odds);
		}
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
	function odds_post() {
		var odds_id = $('#odds_id').val();
		var title = $('input[name=title]').val();
		var cid = []
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

		$('input[name=cid]:checked').each(function() {
			cid.push($(this).val());
		})

		var odds = {'B':odds_b,'S':odds_s,'A':odds_a,'3ABC':odds_3abc,'4ABC':odds_4abc,'2ABC':odds_2abc,'2A':odds_2a,'4A':odds_4a};
		$.post("<?php  echo $this->createMobileUrl('odds',array('op'=>'post'))?>",{odds:odds,odds_id:odds_id,title:title,area_id:cid},function(result) {
			alert(result.info);
			if (result.status == 3) {
				location.href="./index.php?i=6&c=entry&m=purchasing&do=login";
			}
			if (result.status == 1) {
				window.location.reload();
			}
		},'JSON');
	}
	function cal_shuiqia(total_money, number_type) {		
		var shui_qian_value =0;
		if (number_type == 3 ) {
			shui_qian_value = 100 - total_money ;
		}else if( number_type == 2 ){
			shui_qian_value = (1000 - total_money)/10;
		}else if( number_type == 1 ){
			shui_qian_value = (10000 - total_money)/100;
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
		var cashback_money_b = cal_shuiqia(odds_b_total,1);
		

		$('.odds_s').each(function () {
			odds_s.push(parseFloat($(this).val()));
		});
		var odds_s_total = getTotal(odds_s);
		var cashback_money_s = cal_shuiqia(odds_s_total,1);

		$('.odds_3abc').each(function () {
			odds_3abc.push(parseFloat($(this).val()));
		});
		// var odds_3abc_total = getTotal(odds_3abc);
		var cashback_money_3abc = cal_shuiqia(odds_3abc[0]*odds_3abc.length,2);
		setallodds(odds_3abc[0],'odds_3abc');

		$('.odds_4abc').each(function () {
			odds_4abc.push(parseFloat($(this).val()));
		});
		// var odds_4abc_total = getTotal(odds_4abc);
		var cashback_money_4abc = cal_shuiqia(odds_4abc[0]*odds_4abc.length,1);
		setallodds(odds_4abc[0],'odds_4abc');

		$('.odds_2abc').each(function () {
			odds_2abc.push(parseFloat($(this).val()));
		});
		// var odds_2abc_total = getTotal(odds_2abc);
		var cashback_money_2abc = cal_shuiqia(odds_2abc[0]*odds_2abc.length,3);
		setallodds(odds_2abc[0],'odds_2abc');

		$('.odds_2a').each(function () {
			odds_2a.push(parseFloat($(this).val()));
		});
		// var odds_2a_max = get_max(odds_2a);
		var cashback_money_2a = cal_shuiqia(odds_2a[0],3);
		setallodds(odds_2a[0],'odds_2a');

		$('.odds_4a').each(function () {
			odds_4a.push(parseFloat($(this).val()));
		});
		// var odds_4a_max = get_max(odds_4a);
		var cashback_money_4a = cal_shuiqia(odds_4a[0],1);
		setallodds(odds_4a[0],'odds_4a');

		$('.odds_a').each(function () {
			odds_a.push(parseFloat($(this).val()));
		});
		// var odds_a_max = get_max(odds_a);
		var cashback_money_a = cal_shuiqia(odds_a[0],2);
		setallodds(odds_a[0],'odds_a');
		console.log(cashback_money_a);

		$('#cashback_money_b').text(Math.round(cashback_money_b*100)/100);
		$('#cashback_money_s').text(Math.round(cashback_money_s*100)/100);
		$('#cashback_money_a').text(Math.round(cashback_money_a*100)/100);
		$('#cashback_money_3abc').text(Math.round(cashback_money_3abc*100)/100);
		$('#cashback_money_4a').text(Math.round(cashback_money_4a*100)/100);
		$('#cashback_money_4abc').text(Math.round(cashback_money_4abc*100)/100);
		$('#cashback_money_2a').text(Math.round(cashback_money_2a*100)/100);
		$('#cashback_money_2abc').text(Math.round(cashback_money_2abc*100)/100);
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