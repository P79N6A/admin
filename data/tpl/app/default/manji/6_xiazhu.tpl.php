<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('header', TEMPLATE_INCLUDEPATH)) : (include template('header', TEMPLATE_INCLUDEPATH));?>
<style type="text/css">
	#orderd>tbody>tr>td{border: 0;font-size: 5vh;font-weight: 600;line-height: normal;padding: 0 1vw;}
</style>
<table class="table table-bordered" style="margin: 0;">
	<tr>
		<td style="padding: 0 4px">
			<label id="get_auto" style="margin: 0;">
				长期
				<input type="checkbox" name="count" id="count1" value="1">
			</label>
			指定期数
			<input type="text" name="count_n" value="" style="width: 40px;border: #ccc solid 1px;" onkeyup="if($(this).val() != ''){$('input[name=count]').prop('checked',false);}">
		</td>
	</tr>
</table>
<div class="col-xs-12" id="bet_main" style="padding: 0 3px;overflow-y: auto;max-height: 70vh;">
	<table class="table table-bordered" id="bet_item" style="max-height: 70vh;overflow-y: auto;">
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
				<input type="text" name="number" value="" id="number1" placeholder="number" maxlength="6" onkeyup="value=value.replace(/[^\d]/g,'');">
			</td>
			<td>
				<select name="rule" id="rule1" onchange="set_pay(1)">
				</select>
			</td>
			<td>
				<input type="text" id="pay1_1" value="" class="odd" onkeyup="num(this)" onfocus="target=$(this).attr('id');$('.odd').css('border','0');$(this).css('border','1px solid #fc5817');" readonly="readonly">
			</td>
			<td>
				<input type="text" id="pay2_1" value="" class="odd" onkeyup="num(this)" onfocus="target=$(this).attr('id');$('.odd').css('border','0');$(this).css('border','1px solid #fc5817');" readonly="readonly">
			</td>
			<td>
				<input type="text" id="pay3_1" value="" class="odd" onkeyup="num(this)" onfocus="target=$(this).attr('id');$('.odd').css('border','0');$(this).css('border','1px solid #fc5817');" readonly="readonly">
			</td>
			<td>
				<input type="text" id="pay4_1" value="" class="odd" onkeyup="num(this)" onfocus="target=$(this).attr('id');$('.odd').css('border','0');$(this).css('border','1px solid #fc5817');" readonly="readonly">
			</td>
			<td>
				<input type="text" id="pay5_1" value="" class="odd" onkeyup="num(this)" onfocus="target=$(this).attr('id');$('.odd').css('border','0');$(this).css('border','1px solid #fc5817');" readonly="readonly">
			</td>
			<td>
				<input type="text" id="pay6_1" value="" class="odd" onkeyup="num(this)" onfocus="target=$(this).attr('id');$('.odd').css('border','0');$(this).css('border','1px solid #fc5817');" readonly="readonly">
			</td>
			<td>
				<input type="text" id="pay7_1" value="" class="odd" onkeyup="num(this)" onfocus="target=$(this).attr('id');$('.odd').css('border','0');$(this).css('border','1px solid #fc5817');" readonly="readonly">
			</td>
			<td></td>
		</tr>
	</table>
	<div class="col-xs-12" style="height: 50vh;"></div>
</div>
<div class="col-xs-12" style="padding: 0 3px;bottom: 0;background: #fff;position: absolute;">
	<input type="button" value="确认下注" class="btn btn-sm btn-danger" onclick="check_order();" style="border: 0;padding: 2vh;">
	<input type="button" value="下一行" class="btn btn-sm btn-warning" onclick="enter()" style="border: 0;padding: 2vh;">
	<a href="javascript:void(0);">
		<img src="../addons/manji/static/images/0.1.png" style="width: 10vh;" onclick="plus_money(0.1);">
	</a>
	<a href="javascript:void(0);">
		<img src="../addons/manji/static/images/0.5.png" style="width: 11vh;" onclick="plus_money(0.5);">
	</a>
	<a href="javascript:void(0);">
		<img src="../addons/manji/static/images/1.png" style="width: 12vh;" onclick="plus_money(1);">
	</a>
	<a href="javascript:void(0);">
		<img src="../addons/manji/static/images/5.png" style="width: 13vh;" onclick="plus_money(5);">
	</a>
	<a href="javascript:void(0);">
		<img src="../addons/manji/static/images/10.png" style="width: 14vh;" onclick="plus_money(10);">
	</a>
	<a href="javascript:void(0);">
		<img src="../addons/manji/static/images/50.png" style="width: 15vh;" onclick="plus_money(50);">
	</a>
	<a href="javascript:void(0);">
		<img src="../addons/manji/static/images/backspace.jpg" style="height: 12vh;" onclick="backspace();">
	</a>
	<input type="button" value="清除下注" class="btn btn-sm btn-default" onclick="window.location.reload();" style="padding: 2vh;">
</div>
<div class="recharge-area" id="order_detail">
	<div class="recharge-main">
		<div class="recharge-body" style="height: 90%;overflow-y: auto;">
			<table class="table" id="orderd" style="font-weight: 600;font-size: 14px;">
				
			</table>
		</div>
		<div class="recharge-head">
			<a href="javascript:void(0)" class="btn" onclick="window.location.reload();" style="font-size: 18px;padding: 2vh;">确认</a>
		</div>
	</div>
</div>
<script type="text/javascript" src="../addons/purchasing/static/js/order.js"></script>
<script type="text/javascript">
	var item=1
	var vitem = 0;
	var target = '';
	var company = [];
	var rule = [];
	var post = 0;
	$('#get_auto').on('click',function() {
		var check = $(this).children('input').is(':checked');
		if (check == true) {
			$('input[name=count_n]').val('');
		}
	})
	function num(obj,val){
		obj.value = obj.value.replace(/[^\d.]/g,""); //清除"数字"和"."以外的字符
		obj.value = obj.value.replace(/^\./g,""); //验证第一个字符是数字
		obj.value = obj.value.replace(/\.{2,}/g,""); //只保留第一个, 清除多余的
		obj.value = obj.value.replace(".","$#$").replace(/\./g,"").replace("$#$",".");
		obj.value = obj.value.replace(/^(\-)*(\d+)\.(\d\d).*$/,'$1$2.$3'); //只能输入两个小数
	}
	function plus_money(money) {
		var old_money = $('#'+target).val();
		if (old_money == '') {
			old_money = 0;
		}
		var end_money = money + parseFloat(old_money);
		$('#'+target).val(end_money);
	}
	function backspace() {
		var val = $('#'+target).val();
		val = val.substr(0,val.length-1);
		console.log(val);
		$('#'+target).val(val);
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
		if (item > 25) {
			return false;
		}
		console.log(item);
		item++;
		var txt = '<tr id="company'+item+'"><td colspan="13" style="padding: 0 4px;">';
		for (var i = 0 in company) {
			txt += '<a href="javascript:void(0);" id="com'+company[i].id+'_'+item+'" class="btn" style="border-radius: 0;" data-value="'+company[i].id+'" onclick="var has = $(this).hasClass(\'pack\');check_com('+item+','+company[i].id+',has);">'+company[i].nickname+'</a>';
		}
		txt += '</td></tr><tr class="input-txt"><td><select name="type" id="type'+item+'"><option value="0">special</option><option value="1">BOX</option><option value="2">iBOX</option><option value="3">(0~9)包头</option><option value="4">(0~9)包尾</option></select></td><td><input type="text" name="number" id="number'+item+'" placeholder="number"></td><td><select name="rule" id="rule'+item+'" onchange="set_pay('+item+')">';
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
			txt += '<td><input type="text" class="odd" id="pay'+k+'_'+item+'" placeholder="'+array[k-1]+'" onkeyup="num(this)"  onfocus="target=$(this).attr(\'id\');$(\'.odd\').css(\'border\',\'0\');$(this).css(\'border\',\'1px solid #fc5817\')" readonly="readonly"></td>';
		}
		txt += '<td><button type="button" id="follow'+item+'" class="btn" style="border-radius: 0" onclick="follow('+item+')">跟</button></td>';
		txt += '</tr>';
		$('#bet_item').append(txt);
		$("#bet_main").scrollTop($("#bet_item")[0].scrollHeight);
	}
	function get_company() {
		$.post("<?php  echo $this->createMobileUrl('xiazhu',array('op'=>'get_company'))?>",{},function(result) {
			company = result;
			var txt = '<td colspan="13" style="padding: 0 4px;">';
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
	$(document).on('blur','input[name=number]',function() {
		console.log(123);
		var number = $(this).val();
		var id = $(this).attr('id');
		var k = id.replace(/number/,'');
		var ruled = $('#rule'+k).val();
		for (var j = 0 in rule) {
			if (ruled == rule[j].id) {
				var content = rule[j].content;
			}
		}
		var len = number.length;
		$('#rule'+k).removeAttr('disabled','disabled');
		$('#rule'+k).find('option[value=0]').remove();
		set_pay(1);
		if (len == 2) {
			for (var i = 1; i < 8; i++) {
				var pl = $('#pay'+i+'_'+k).attr('placeholder');
				if (pl == 'B' || pl == 'S' || pl == '4A' || pl == '4B' || pl == '4C' || pl == '4D' || pl == '4E' || pl == 'EA' || pl == '4ABC' || pl == 'A' || pl == 'C2' || pl == 'C3' || pl == 'C4' || pl == 'C5' || pl == 'C' || pl == '3ABC' || pl == 'EC' || pl == '') {
					$('#pay'+i+'_'+k).val('');
					$('#pay'+i+'_'+k).attr('disabled','disabled');
				}
				else{
					$('#pay'+i+'_'+k).removeAttr('disabled','disabled');
				}
			}
		}
		if (len == 3) {
			for (var i = 1; i < 8; i++) {
				var pl = $('#pay'+i+'_'+k).attr('placeholder');
				if (content.indexOf('B,') == 0 || content.indexOf(',B') != -1 || content.indexOf('S,') == 0 || content.indexOf(',S') != -1) {
					if (pl == 'B' || pl == 'S' || pl == '4A' || pl == '4B' || pl == '4C' || pl == '4D' || pl == '4E' || pl == 'EA' || pl == '4ABC' || pl == '') {
						$('#pay'+i+'_'+k).val('');
						$('#pay'+i+'_'+k).attr('disabled','disabled');
					}
					else{
						$('#pay'+i+'_'+k).removeAttr('disabled','disabled');
					}
				}
				else{
					if (pl == 'B' || pl == 'S' || pl == '4A' || pl == '4B' || pl == '4C' || pl == '4D' || pl == '4E' || pl == 'EA' || pl == '4ABC' || pl == '2A' || pl == '2B' || pl == '2C' || pl == '2D' || pl == '2E' || pl == '2ABC' || pl == 'EX' || pl == '') {
						$('#pay'+i+'_'+k).val('');
						$('#pay'+i+'_'+k).attr('disabled','disabled');
					}
					else{
						$('#pay'+i+'_'+k).removeAttr('disabled','disabled');
					}
				}
			}
		}
		if (len == 4) {
			for (var i = 1; i < 8; i++) {
				var pl = $('#pay'+i+'_'+k).attr('placeholder');
				if (content.indexOf('B,') == 0 || content.indexOf(',B') != -1 || content.indexOf('S,') == 0 || content.indexOf(',S') != -1) {
					if (pl == '') {
						$('#pay'+i+'_'+k).val('');
						$('#pay'+i+'_'+k).attr('disabled','disabled');
					}
					else{
						$('#pay'+i+'_'+k).removeAttr('disabled','disabled');
					}
				}
				else{
					if (pl == '2A' || pl == '2B' || pl == '2C' || pl == '2D' || pl == '2E' || pl == 'EX' || pl == '2ABC' || pl == 'A' || pl == 'C2' || pl == 'C3' || pl == 'C4' || pl == 'C5' || pl == 'C' || pl == '3ABC' || pl == 'EC' || pl == '') {
						$('#pay'+i+'_'+k).val('');
						$('#pay'+i+'_'+k).attr('disabled','disabled');
					}
					else{
						$('#pay'+i+'_'+k).removeAttr('disabled','disabled');
					}
				}
			}
		}
		if (len == 5 || len == 6) {
			for (var i = 1; i < 8; i++) {
				$('#pay'+i+'_'+k).removeAttr('placeholder');
				if (i == 1) {
					$('#pay'+i+'_'+k).removeAttr('disabled','disabled');
				}
				else{
					$('#pay'+i+'_'+k).val('');
					$('#pay'+i+'_'+k).attr('disabled','disabled');
				}
			}
			var option = '<option value="0">'+len+'D<option>';
			$('#rule'+k).append(option);
			$('#rule'+k).val(0);
			$('#rule'+k).attr('disabled','disabled');
		}
		if (len == 1) {
			for (var i = 1; i < 8; i++) {
				$('#pay'+i+'_'+k).val('');
				$('#pay'+i+'_'+k).attr('disabled','disabled');
			}
		}
	})
	function check_com(e,id,has) {
		if (has == true) {
			$('#com'+id+'_'+e).removeClass('pack');
		}
		else{
			$('#com'+id+'_'+e).addClass('pack');
		}
	}
	function get_rule() {
		$.post("<?php  echo $this->createMobileUrl('xiazhu',array('op'=>'get_rule'))?>",{},function(result) {
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
		var number = $('#number'+e).val();
		var len = number.length;
		for (var k = 0 in rule) {
			if (id == rule[k].id) {
				var content = rule[k].content;
			}
		}
		var array = content.split(',');
		for (var i = 0 ; i < 8;i++) {
			var d = parseInt(i)+1;
			if (!array[i]) {
				array[i] = '';
				$('#pay'+d+'_'+e).val('');
				$('#pay'+d+'_'+e).attr('placeholder',array[i]);
				$('#pay'+d+'_'+e).attr('disabled','disabled');
			}
			else{
				$('#pay'+d+'_'+e).attr('placeholder',array[i]);
				var pl = array[i];
				if (len == 1) {
					$('#pay'+d+'_'+e).val('');
					$('#pay'+d+'_'+e).attr('disabled','disabled');
				}
				if (len == 5 || len == 6) {
					$('#pay'+d+'_'+e).removeAttr('placeholder');
					if (d == 1) {
						$('#pay'+d+'_'+e).removeAttr('disabled','disabled');
					}
					else{
						$('#pay'+d+'_'+e).val('');
						$('#pay'+d+'_'+e).attr('disabled','disabled');
					}
				}
				if (content.indexOf('B,') == 0 || content.indexOf(',B') != -1 || content.indexOf('S,') == 0 || content.indexOf(',S') != -1) {
					if (len == 2) {
						if (pl == 'B' || pl == 'S' || pl == '4A' || pl == '4B' || pl == '4C' || pl == '4D' || pl == '4E' || pl == 'EA' || pl == '4ABC' || pl == 'A' || pl == 'C2' || pl == 'C3' || pl == 'C4' || pl == 'C5' || pl == 'C' || pl == '3ABC' || pl == 'EC' || pl == '') {
							$('#pay'+d+'_'+e).val('');
							$('#pay'+d+'_'+e).attr('disabled','disabled');
						}
						else{
							$('#pay'+d+'_'+e).removeAttr('disabled','disabled');
						}
					}
					if (len == 3) {
						if (pl == 'B' || pl == 'S' || pl == '4A' || pl == '4B' || pl == '4C' || pl == '4D' || pl == '4E' || pl == 'EA' || pl == '4ABC' || pl == '') {
							$('#pay'+d+'_'+e).val('');
							$('#pay'+d+'_'+e).attr('disabled','disabled');
						}
						else{
							$('#pay'+d+'_'+e).removeAttr('disabled','disabled');
						}
					}
					if (len == 4) {
						if (pl == '') {
							$('#pay'+d+'_'+e).val('');
							$('#pay'+d+'_'+e).attr('disabled','disabled');
						}
						else{
							$('#pay'+d+'_'+e).removeAttr('disabled','disabled');
						}
					}
				}
				else{
					if (len == 2) {
						if (pl == 'B' || pl == 'S' || pl == '4A' || pl == '4B' || pl == '4C' || pl == '4D' || pl == '4E' || pl == 'EA' || pl == '4ABC' || pl == 'A' || pl == 'C2' || pl == 'C3' || pl == 'C4' || pl == 'C5' || pl == 'C' || pl == '3ABC' || pl == 'EC' || pl == '') {
							$('#pay'+d+'_'+e).val('');
							$('#pay'+d+'_'+e).attr('disabled','disabled');
						}
						else{
							$('#pay'+d+'_'+e).removeAttr('disabled','disabled');
						}
					}
					if (len == 3) {
						if (pl == 'B' || pl == 'S' || pl == '4A' || pl == '4B' || pl == '4C' || pl == '4D' || pl == '4E' || pl == 'EA' || pl == '4ABC' || pl == '2A' || pl == '2B' || pl == '2C' || pl == '2D' || pl == '2E' || pl == '2ABC' || pl == 'EX' || pl == '') {
							$('#pay'+d+'_'+e).val('');
							$('#pay'+d+'_'+e).attr('disabled','disabled');
						}
						else{
							$('#pay'+d+'_'+e).removeAttr('disabled','disabled');
						}
					}
					if (len == 4) {
						if (pl == '2A' || pl == '2B' || pl == '2C' || pl == '2D' || pl == '2E' || pl == 'EX' || pl == '2ABC' || pl == 'A' || pl == 'C2' || pl == 'C3' || pl == 'C4' || pl == 'C5' || pl == 'C' || pl == '3ABC' || pl == 'EC' || pl == '') {
							$('#pay'+d+'_'+e).val('');
							$('#pay'+d+'_'+e).attr('disabled','disabled');
						}
						else{
							$('#pay'+d+'_'+e).removeAttr('disabled','disabled');
						}
					}
				}
			}
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
		$.post("<?php  echo $this->createMobileUrl('xiazhu',array('op'=>'check_order'))?>",{data:data,member_id:"<?php  echo $_GPC['member_id'];?>",days_type:days_type,days:days},function (result) {
			if (result.status == 2) {
				alert(result.info);
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
		$.post("<?php  echo $this->createMobileUrl('xiazhu',array('op'=>'post'))?>",{data:data,member_id:"<?php  echo $_GPC['member_id'];?>",days_type:days_type,days:days},function(result) {
			console.log(result.uorder);
			if (result.status == 2) {
				alert(result.info);
			}
			if (result.status == 3) {
				location.href="<?php  echo $this->createMobileUrl('login')?>";
			}
			if (result.status == 1) {
				var txt = '';
				txt += create_order(result);
				$('#orderd').html(txt);
				$('#order_detail').show();
			}
			
		},'JSON')
	}
	function get_order() {
		$.post("<?php  echo $this->createMobileUrl('xiazhu',array('op'=>'get_order'))?>",{member_id:"<?php  echo $_GPC['member_id'];?>"},function(result) {
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
		$.post("<?php  echo $this->createMobileUrl('xiazhu',array('op'=>'order_detail'))?>",{id:id},function(result) {
			var txt = '';
			txt += create_order(result);
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
</script>