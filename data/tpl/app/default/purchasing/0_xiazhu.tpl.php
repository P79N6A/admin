<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('header', TEMPLATE_INCLUDEPATH)) : (include template('header', TEMPLATE_INCLUDEPATH));?>
<?php  if($op == 'display') { ?>
<style type="text/css">
	.recharge-area{position: fixed;width: 100%;height: 100%;top: 0;left: 0;background: rgba(0,0,0,0.4);display: none;}
	.recharge-main{width: 30%;height: 30vw;margin: 5% auto;background: #fff;}
	.recharge-head{width: 100%;text-align: center;font-size: 20px;line-height: 30px;padding: 0 10px;}
	.recharge-body{width: 100%;overflow-y: auto;}
	.table>tbody>tr>td>input[type=text]{width: 100%;border: 0;height: 22px;text-align: center;}
	.table>tbody>tr.input-txt>td{padding: 1px;text-align: center;}
	.btn{border: 1px solid #3e3e3e;background-color: #3e3e3e;border-radius: 20px;color: #fff;padding: 3px 7px;margin-right: 10px;}
	input[type=checkbox]{}
	.btn:hover{background: #fff;color: #333}
	.pack{background: #fff;color: #333;}
	.btn-red{background: #f00;}
	.btn-blue{background: #00f;}
	.btn-green{background: #0f0;}
	select{height: 100%;border: 0;height: 22px;}
	.pack{background: #fff;color: #333;}
</style>
<div class="col-xs-12" style="padding: 5px 0;">
	<div class="col-xs-12" style="padding: 6px 0;text-align: center;">
		JUBAO：<span class="btn">random <?php  echo $jackpot['big_jackpot'];?></span><span class="btn">major <?php  echo $jackpot['middle_jackpot'];?></span><span class="btn">minor <?php  echo $jackpot['small_jackpot'];?></span>
	</div>
	<div class="col-xs-12" style="padding: 6px 0;">
		<span style="padding: 4px 8px;background: #00b0f0;">当前积分：<?php  echo $member['credit1'];?></span>
	</div>
	<table class="table table-bordered">
		<tr>
			<td>
				多天投注
			</td>
			<td>
				<label>
					<input type="checkbox" name="count" id="count1" value="1">
					长期
				</label>
			</td>
			<td>
				<label>
					<input type="checkbox" name="count" id="count2" value="2">
					指定期数
				</label>
				<input type="text" name="count_n" value="" style="width: 40px;border: #ccc solid 1px;">
			</td>
			<td colspan="10">
				
			</td>
		</tr>
		<tr id="company1">
		</tr>
		<tr class="input-txt">
			<td>
				<select name="type" id="type1">
					<option value="0">special</option>
					<option value="1">BOX</option>
					<option value="2">iBOX</option>
					<option value="3">(0~9)包头</option>
					<option value="4">(0~9)包尾</option>
				</select>
			</td>
			<td>
				<input type="text" name="number" value="" id="number1" placeholder="number" maxlength="4" onkeyup="value=value.replace(/[^\d]/g,'');">
			</td>
			<td>
				<select name="rule" id="rule1" onchange="set_pay(1)">
				</select>
			</td>
			<td>
				<input type="text" id="pay1_1" value="" class="odd" onkeyup="num(this)">
			</td>
			<td>
				<input type="text" id="pay2_1" value="" class="odd" onkeyup="num(this)">
			</td>
			<td>
				<input type="text" id="pay3_1" value="" class="odd" onkeyup="num(this)">
			</td>
			<td>
				<input type="text" id="pay4_1" value="" class="odd" onkeyup="num(this)">
			</td>
			<td>
				<input type="text" id="pay5_1" value="" class="odd" onkeyup="num(this)">
			</td>
			<td>
				<input type="text" id="pay6_1" value="" class="odd" onkeyup="num(this)">
			</td>
			<td>
				<input type="text" id="pay7_1" value="" class="odd" onkeyup="num(this)">
			</td>
			<td>
			</td>
			<td>
				<span id="has_jp1"></span>
			</td>
			<td>
				<span id="bet_total1"></span>
			</td>
		</tr>
	</table>
	<div class="col-xs-6" style="padding: 6px 0;">
		<input type="button" name="button" value="确认下注" class="btn" onclick="check_order();">
		<input type="button" name="reset" value="清除下注" class="btn" onclick="window.location.reload();">
	</div>
	<div class="col-xs-12" style="height: 30%;">
		<form class="form-inline" rule="form">
			<div class="form-group">
				<input type="text" name="ordersn" value="">
			</div>
			<div class="form-group">
				<button type="button" class="btn" onclick="search_sn();">寻找单号</button>
			</div>
			<div class="form-group">
				<input type="text" name="number" value="">
			</div>
			<div class="form-group">
				<button type="button" class="btn" onclick="search_number();">寻找号码</button>
			</div>
		</form>
		<table class="table table-bordered" style="height: 80%;overflow-y: auto;">
			<tr id="list-title">
				<td>时间</td>
				<td>户口单号</td>
				<td>总单号</td>
			</tr>
		</table>
	</div>
</div>
<div class="recharge-area" id="order_detail">
	<div class="recharge-main">
		<div class="recharge-head" style="text-align:right;">
			<a href="javascript:void(0)" onclick="window.location.reload();" style="font-size: 18px;"><span>&times;</span></a>
		</div>
		<div class="recharge-body" style="height: 90%;overflow-y: auto;">
			<table class="table" id="orderd">
				
			</table>
		</div>
	</div>
</div>
<script type="text/javascript">
	var item=1
	var vitem = 0;
	var target = '';
	var company = [];
	var rule = [];
	var post = 0;
	$('label').click(function() {
		$('input[name=count]').prop('checked',false);
		var check = $(this).children('input').is(':checked');
		if (check == true) {
			$(this).children('input').prop('checked',false);
		}
		else{
			$(this).children('input').prop('checked',true);
		}
	})
	function num(obj,val){
		obj.value = obj.value.replace(/[^\d.]/g,""); //清除"数字"和"."以外的字符
		obj.value = obj.value.replace(/^\./g,""); //验证第一个字符是数字
		obj.value = obj.value.replace(/\.{2,}/g,""); //只保留第一个, 清除多余的
		obj.value = obj.value.replace(".","$#$").replace(/\./g,"").replace("$#$",".");
		obj.value = obj.value.replace(/^(\-)*(\d+)\.(\d\d).*$/,'$1$2.$3'); //只能输入两个小数
	}
	window.document.onkeydown = keybord;
	function keybord(obj) {
		if (obj.keyCode == 13 && !obj.shiftKey) {
			enter();
		}
		else if (obj.keyCode == 13 && obj.shiftKey) {
			check_order();
		}
	}
	function enter() {
		item++;
		var txt = '<tr id="company'+item+'"><td colspan="13">';
		for (var i = 0 in company) {
			txt += '<a href="javascript:void(0);" id="com'+company[i].id+'_'+item+'" class="btn" style="border-radius: 0;" data-value="'+company[i].id+'" onclick="var has = $(this).hasClass(\'pack\');check_com('+item+','+company[i].id+',has);">'+company[i].nickname+'</a>';
		}
		txt += '</td></tr><tr class="input-txt"><td><select name="type" id="type'+item+'"><option value="0">special</option><option value="1">BOX</option><option value="2">iBOX</option><option value="3">(0~9)包头</option><option value="4">(0~9)包尾</option></select></td><td><input type="text" id="number'+item+'" placeholder="number"></td><td><select name="rule" id="rule'+item+'" onchange="set_pay('+item+')">';
		console.log(rule);
		for (var j = 0 in rule) {
			txt += '<option value="'+rule[j].id+'">'+rule[j].title+'</option>';
		}
		txt += '</select></td>';
		var content = rule[0].content;
		var array = content.split(',');
		for (var k = 1; k < 8; k++) {
			if (!array[k-1]) {
				array[k-1] = '';
			}
			txt += '<td><input type="text" id="pay'+k+'_'+item+'" placeholder="'+array[k-1]+'" onkeyup="num(this)"></td>';
		}
		txt += '<td><button type="button" id="follow'+item+'" class="btn" style="border-radius: 0" onclick="follow('+item+')">跟</button></td>';
		txt += '<td><span id="has_jp'+item+'"></span></td>';
		txt += '<td><span id="bet_total'+item+'"></span></td>';
		txt += '</tr>';
		$('table').append(txt);
	}
	function get_company() {
		$.post("<?php  echo $this->createMobileUrl('pc_xiazhu',array('op'=>'get_company'))?>",{},function(result) {
			company = result;
			var txt = '<td colspan="13">';
			for (var i = 0 in company) {
				txt += '<a href="javascript:void(0);" id="com'+company[i].id+'_1" class="btn" style="border-radius: 0;" data-value="'+company[i].id+'" onclick="var has = $(this).hasClass(\'pack\');check_com(1,'+company[i].id+',has);">'+company[i].nickname+'</a>';
			}
			txt += '</td>';
			$('#company1').html(txt);
		},'JSON');
	}
	function follow(e) {
		var prev = parseInt(e)-1;
		var type = $('#type'+prev).val();
		var number = $('#number'+prev).val();
		var rule_pick = $('#rule'+prev).val();
		var pay = [];
		var com = [];
		for (var i = 1; i < 8; i++) {
			pay.push($('#pay'+i+'_'+prev).val());
		}
		for (var j = 0 in company) {
			var has = $('#com'+company[j].id+'_'+prev).hasClass('pack');
			if (has == true) {
				com.push(company[j].id);
			}
		}
		if (number != '') {
			$('#type'+e).val(type);
			$('#rule'+e).val(rule_pick);
			for (var k = 0; k < 8; k++) {
				var d = parseInt(k)+1;
				if (pay[k] > 0 && pay[k] != '') {
					$('#pay'+d+'_'+e).val(pay[k]);
				}
			}
			for (var l = 0 in com) {
				$('#com'+com[l]+'_'+e).addClass('pack');
			}
		}
		set_pay(e);
	}
	function check_com(e,id,has) {
		if (has == true) {
			$('#com'+id+'_'+e).removeClass('pack');
		}
		else{
			$('#com'+id+'_'+e).addClass('pack');
		}
	}
	function get_rule() {
		$.post("<?php  echo $this->createMobileUrl('pc_xiazhu',array('op'=>'get_rule'))?>",{},function(result) {
			rule = result;
			var txt = '';
			for (var i = 0 in rule) {
				txt += '<option value="'+rule[i].id+'">'+rule[i].title+'</option>';
			}
			var content = rule[0].content;
			var array = content.split(',');
			for (var k = 0; k < 7; k++) {
				var d = parseInt(k)+1;
				$('#pay'+d+'_1').attr('placeholder',array[k]);
			}
			$('#rule1').html(txt);
		},'JSON');
	}
	function set_pay(e) {
		var id = parseInt($('#rule'+e).val());
		var k = id-1;
		var content = rule[k].content;
		var array = content.split(',');
		for (var i = 0 ; i < 8;i++) {
			var d = parseInt(i)+1;
			if (!array[i]) {
				array[i] = '';
			}
			$('#pay'+d+'_'+e).attr('placeholder',array[i]);
		}
	}
	function check_order() {
		var data = [];
		var days_type = $('input[name=count]:checked').val();
		var days = $('input[name=count_n]').val();
		for (var i = 1;i <= item;i++) {
			var type = $('#type'+i).val();
			var number = $('#number'+i).val();
			var ruler = $('#rule'+i).val();
			var pay = [];
			var com = [];
			for (var k = 0 in company) {
				var has = $('#com'+company[k].id+'_'+i).hasClass('pack');
				if (has == true) {
					com.push(company[k].id);
				}
			}
			for (var j = 1; j < 9; j++) {
				var money = $('#pay'+j+'_'+i).val();
				if (money != '') {
					pay.push(money);
				}
				else{
					pay.push(0);
				}
			}
			data.push({"type":type,"number":number,"rule":ruler,"pay":pay,"company":com});
		}
		$.post("<?php  echo $this->createMobileUrl('pc_xiazhu',array('op'=>'check_order'))?>",{data:data,member_id:"<?php  echo $_GPC['member_id'];?>",days_type:days_type,days:days},function (result) {
			if (result.status == 2) {
				alert(result.info);
			}
			if (result.status == 3) {
				location.href="<?php  echo $this->createMobileUrl('login')?>";
			}
			if (result.status == 4) {
				var a = confirm('本单已经投注，是否重复投注');
				if (a == true) {
					bet_post();
				}
			}
			if (result.status == 1) {
				bet_post();
			}
		},"JSON");
	}
	function bet_post() {
		var data = [];
		var days_type = $('input[name=count]:checked').val();
		var days = $('input[name=count_n]').val();
		if (post == 1) {
			alert('本单已在下注，请请刷新重下');
			return false;
		}
		post = 1;
		for (var i = 1;i <= item;i++) {
			var type = $('#type'+i).val();
			var number = $('#number'+i).val();
			var ruler = $('#rule'+i).val();
			var pay = [];
			var com = [];
			for (var k = 0 in company) {
				var has = $('#com'+company[k].id+'_'+i).hasClass('pack');
				if (has == true) {
					com.push(company[k].id);
				}
			}
			for (var j = 1; j < 9; j++) {
				var money = $('#pay'+j+'_'+i).val();
				if (money != '') {
					pay.push(money);
				}
				else{
					pay.push(0);
				}
			}
			data.push({"type":type,"number":number,"rule":ruler,"pay":pay,"company":com});
		}
		$.post("<?php  echo $this->createMobileUrl('pc_xiazhu',array('op'=>'post'))?>",{data:data,member_id:"<?php  echo $_GPC['member_id'];?>",days_type:days_type,days:days},function(result) {
			console.log(result.uorder);
			if (result.status == 2) {
				alert(result.info);
			}
			if (result.status == 3) {
				location.href="<?php  echo $this->createMobileUrl('login')?>";
			}
			if (result.status == 1) {
				var txt = '<tr><td>'+result.account+'&nbsp;&nbsp;#'+result.sn+'</td></tr>';
				txt += '<tr><td>B：'+result.ordertime+'</td></tr>';
				var end = result.end;
				for (var i in end) {
					txt += '<tr><td>D：'+i+'('+end[i]+')</td></tr>';
				}
				txt += '<tr><td> </td></tr>';
				var uorder = result.uorder;
				for (var key in uorder) {
					txt += '<tr><td>='+key+'=</td></tr>';
					var value = uorder[key];
					for (var j = 0 in value) {
						var number = value[j].number;
						if (value[j].type == 1) {
							txt += '<tr><td>{'+number+'}&nbsp;&nbsp;&nbsp;&nbsp;';
						}
						if (value[j].type == 2) {
							txt += '<tr><td>IB{'+number+'}&nbsp;&nbsp;&nbsp;&nbsp;';
						}
						if (value[j].type == 3) {
							txt += '<tr><td>{0~9}'+number.slice(1)+'&nbsp;&nbsp;&nbsp;&nbsp;';
						}
						if (value[j].type == 4) {
							txt += '<tr><td>'+number.substr(0,3)+'{0~9}&nbsp;&nbsp;&nbsp;&nbsp;';
						}
						if (value[j].type == 0) {
							txt += '<tr><td>'+number+'&nbsp;&nbsp;&nbsp;&nbsp;';
						}
						var pay = value[j].pay;
						for (var k = 0 in pay) {
							for (var l = 0 in rule) {
								if (value[j].rule == rule[l].id) {
									var rule_content = rule[l].content;
									var content = rule_content.split(',');
									if (content[k] != undefined && pay[k] > 0) {
										txt += content[k]+'：'+pay[k]+'&nbsp;&nbsp;';
									}
								}
							}
						}
						txt += '</td></tr>';
					}
				}
				txt += '<tr><td>$'+result.amount+'&nbsp;&nbsp;[x：'+result.counts+']</td></tr>';
				txt += '<tr><td> </td></tr>';
				txt += '<tr><td>Bayaran ikut resit.</td></tr>';
				txt += '<tr><td>S:'+result.pid+'</td></tr>';
				$('#orderd').html(txt);
				$('#order_detail').show();
			}
			
		},'JSON')
	}
	function get_order() {
		$.post("<?php  echo $this->createMobileUrl('pc_xiazhu',array('op'=>'get_order'))?>",{member_id:"<?php  echo $_GPC['member_id'];?>"},function(result) {
			console.log(result);
			var txt = '';
			for (var i = 0 in result) {
				txt += '<tr><td><a href="javascript:void(0);" onclick="show_order('+result[i].id+')">'+result[i].time+'</a></td><td><a href="javascript:void(0);" onclick="show_order('+result[i].id+')">'+result[i].uordersn+'</a></td><td><a href="javascript:void(0);" onclick="show_order('+result[i].id+')">'+result[i].ordersn+'</a></td></tr>';
			}
			$('#list-title').nextAll().remove();
			$('#list-title').after(txt);
		},'JSON')
	}
	function show_order(id) {
		$.post("<?php  echo $this->createMobileUrl('pc_xiazhu',array('op'=>'order_detail'))?>",{id:id},function(result) {
			var txt = '<tr><td>'+result.account+'&nbsp;&nbsp;#'+result.sn+'</td></tr>';
			txt += '<tr><td>B：'+result.ordertime+'</td></tr>';
			var end = result.end;
			for (var i in end) {
				txt += '<tr><td>D：'+i+'('+end[i]+')</td></tr>';
			}
			txt += '<tr><td> </td></tr>';
			var uorder = result.uorder;
			for (var key in uorder) {
				txt += '<tr><td>='+key+'=</td></tr>';
				var value = uorder[key];
				for (var j = 0 in value) {
					var number = value[j].number
					if (value[j].mode == 1) {
						txt += '<tr><td>{'+number+'}&nbsp;&nbsp;&nbsp;&nbsp;';
					}
					if (value[j].mode == 2) {
						txt += '<tr><td>IB{'+number+'}&nbsp;&nbsp;&nbsp;&nbsp;';
					}
					if (value[j].mode == 3) {
						txt += '<tr><td>{0~9}'+number.slice(1)+'&nbsp;&nbsp;&nbsp;&nbsp;';
					}
					if (value[j].mode == 4) {
						txt += '<tr><td>'+number.substr(0,3)+'{0~9}&nbsp;&nbsp;&nbsp;&nbsp;';
					}
					if (value[j].mode == 0) {
						txt += '<tr><td>'+number+'&nbsp;&nbsp;&nbsp;&nbsp;';
					}
					var pay = value[j].pay;
					for (var k in pay) {
						if (pay[k] > 0) {
							txt += k+'：'+pay[k]+'&nbsp;&nbsp;';
						}
					}
					txt += '</td></tr>';
				}
			}
			txt += '<tr><td>$'+result.amount+'&nbsp;&nbsp;[x：'+result.counts+']</td></tr>';
			txt += '<tr><td> </td></tr>';
			txt += '<tr><td>Bayaran ikut resit.</td></tr>';
			txt += '<tr><td>S:'+result.pid+'</td></tr>';
			$('#orderd').html(txt);
			$('#order_detail').show();
		},'JSON');
	}
	$(function() {
		get_company();
		get_rule();
		get_order();
	})
	$('.del-item').click(function() {
		$(this).parent().parent().remove();
	})
	$('input[name=number]').click(function() {
		vitem = $(this).attr('data-value');
	})
	$('input[name=pack]').click(function() {
		if ($(this).hasClass('pack') == true) {
			$('input[name=pack]').removeClass('pack');
			$(this).removeClass('pack');
		}
		else{
			$('input[name=pack]').removeClass('pack');
			$(this).addClass('pack');
		}
	})
	$('.odd').click(function() {
		$('input[name=pack]').removeClass('pack');
		target = $(this).attr('id');
	})
	$('input[name=submit]').click(function() {
		var odds = [];
		$('input[name=number]').each(function() {
			var item = $(this).attr('data-value');
			odds.push({number:$(this).val(),pay_B:$('#B'+item).val(),pay_S:$('#S'+item).val(),pay_A:$('#A'+item).val(),pay_4A:$('#4A'+item).val(),pay_C2:$('#C2'+item).val(),pay_C3:$('#C3'+item).val(),pay_C4:$('#C4'+item).val(),pay_C5:$('#C5'+item).val(),pay_3ABC:$('#3ABC'+item).val(),pay_4B:$('#4B'+item).val(),pay_4C:$('#4C'+item).val(),pay_4D:$('#4D'+item).val(),pay_4E:$('#4E'+item).val(),pay_4ABC:$('#4ABC'+item).val(),pay_2A:$('#2A'+item).val(),pay_2B:$('#2B'+item).val(),pay_2C:$('#2C'+item).val(),pay_2D:$('#2D'+item).val(),pay_2E:$('#2E'+item).val(),pay_EC:$('#EC'+item).val(),pay_EA:$('#EA'+item).val(),pay_EX:$('#EX'+item).val(),pay_2ABC:$('#2ABC'+item).val()});
		})
		$.post("<?php  echo $this->createMobileUrl('pc_xiazhu',array('op'=>'post'))?>",{odds:odds},function(result) {
			alert(result.info);
			if (result.status == 1) {
				
			}
		},"JSON")
	})
</script>
<?php  } ?>