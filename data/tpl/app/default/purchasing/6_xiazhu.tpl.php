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
	.order-ul{list-style: none;}
	.order-ul li{float: left;}
</style>
<div class="col-xs-12" style="padding: 5px 0;">
	<div class="col-xs-12" style="padding: 6px 0;text-align: center;">
		JUBAO：<span class="btn">random <?php  echo $jackpot['big_jackpot'];?></span><span class="btn">major <?php  echo $jackpot['middle_jackpot'];?></span><span class="btn">minor <?php  echo $jackpot['small_jackpot'];?></span>
		JBLOTTO<span class="btn">random <?php  echo $total_jackpot['big_jackpot'];?></span><span class="btn">major <?php  echo $total_jackpot['middle_jackpot'];?></span><span class="btn">minor <?php  echo $total_jackpot['small_jackpot'];?></span>
	</div>
	<div class="col-xs-12" style="padding: 6px 0;">
		<span style="padding: 4px 8px;background: #00b0f0;">当前积分：<?php  echo $member['credit1']+$member['credit2']?></span>
		<span style="padding: 4px 8px;background: #00b0f0;">ID：<?php  echo $member['account'];?></span>
	</div>
	<table class="table table-bordered" id="bet-table">
		<tr>
			<td>
				多天投注
			</td>
			<td>
				<label id="get_auto">
					<input type="checkbox" name="count" id="count1" value="1">
					长期
				</label>
			</td>
			<td>
				指定期数
				<input type="text" name="count_n" value="" style="width: 40px;border: #ccc solid 1px;" onkeyup="if($(this).val() != ''){$('input[name=count]').prop('checked',false);}">
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
				<input type="text" name="number" value="" id="number1" placeholder="number" maxlength="6" onkeyup="value=value.replace(/[^\d]/g,'');">
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
		<input type="button" name="button" value="确认下注" class="btn" onclick="if (post == 1) {alert('请勿重复投注');}post = 1;check_order();">
		<input type="button" name="reset" value="清除下注" class="btn" onclick="window.location.reload();">
	</div>
	<div class="col-xs-12" style="height: 30%;">
		<form class="form-inline" rule="form">
			<div class="form-group">
				<input type="text" name="ordersn" value="" onkeyup="check_num(this)">
			</div>
			<div class="form-group">
				<button type="button" class="btn" onclick="search_sn();">寻找单号</button>
			</div>
			<div class="form-group">
				<input type="text" name="search_number" value="" onkeyup="value=value.replace(/[^\d]/g,'');">
			</div>
			<div class="form-group">
				<input type="text" name="search_number" value="<?php  echo $date['date'];?>" id="date" style="background: url(../addons/purchasing/static/images/date.jpg) no-repeat;background-position: right;background-size: auto 100%;">
			</div>
			<div class="form-group">
				<button type="button" class="btn" onclick="get_number();">寻找号码</button>
			</div>
		</form>
		<table class="table table-bordered" style="height: 80%;overflow-y: auto;">
			<tr id="list-title">
				<td>时间</td>
				<td>户口单号</td>
				<td>投注额</td>
				<td>总单号</td>
			</tr>
		</table>
	</div>
</div>
<div class="recharge-area" id="order_detail">
	<div class="recharge-main">
		<div class="recharge-head">
			<ul class="order-ul" style="margin: 5px 0;">
				<li>
					<label class="btn auto">
					</label>
				</li>
				<li>
					<button class="btn" style="margin-left: 5px" onclick="rebuy()">重买</button>
				</li>
				<?php  if($_SESSION['level'] < 5) { ?>
				<li id="edit_btn">
					<button class="btn" style="margin-left: 5px" onclick="edit()">修改</button>
				</li>
				<li id="restore" style="display: none;">
					<button class="btn" style="margin-left: 5px" onclick="restore()">还原</button>
				</li>
				<?php  } ?>
				<li id="delete">
					<button class="btn" style="margin-left: 5px" onclick="del()">删除</button>
				</li>
				<li>
					<button class="btn" style="margin-left: 5px" onclick="input_type()">输入法</button>
				</li>
			</ul>
			<input type="hidden" id="order_id">
			<a href="javascript:void(0)" onclick="{window.location.reload();}" style="font-size: 18px;float: right;"><span>&times;</span></a>
		</div>
		<div class="recharge-body" style="height: 90%;overflow-y: auto;">
			<div style="width: 100%;display: inline-block;word-break: break-word;">
				<div style="width: 100%;">
					TICKET
				</div>
				<table class="table" id="orderd">
				
				</table>
			</div>
			<div id="writing" style="width: 49%;display: none;">
				<div style="width: 100%;">
					WRITING
				</div>
				<table class="table" style="">
				
				</table>
			</div>
		</div>
	</div>
</div>
<link rel="stylesheet" href="../addons/purchasing/static/css/borain-timeChoice.css">
<link rel="stylesheet" type="text/css" href="http://www.jq22.com/jquery/font-awesome.4.6.0.css">
<script type="text/javascript" src="../addons/purchasing/static/js/order.js"></script>
<script src="../addons/purchasing/static/js/borain-timeChoice.js"></script>
<script type="text/javascript">
	onLoadTimeChoiceDemo();
    borainTimeChoice({
        start:"#date",
        level:"YMD",
        less:false
    });
	var item=1
	var vitem = 0;
	var target = '';
	var company = [];
	var rule = [];
	var post = 0;
	var d2item = ['2A','2B','2C','2D','2E','EX','2ABC'];
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
	function check_num(obj,val){
		obj.value = obj.value.replace(/[^\d#]/g,""); //清除"数字"和"."以外的字符
		obj.value = obj.value.replace(/\#{2,}/g,""); //只保留第一个, 清除多余的
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
		item++;
		var txt = '<tr id="company'+item+'"><td colspan="13">';
		for (var i = 0 in company) {
			txt += '<a href="javascript:void(0);" id="com'+company[i].id+'_'+item+'" class="btn" style="border-radius: 0;" data-value="'+company[i].id+'" onclick="var has = $(this).hasClass(\'pack\');check_com('+item+','+company[i].id+',has);">'+company[i].nickname+'</a>';
		}
		txt += '</td></tr><tr class="input-txt"><td><select name="type" id="type'+item+'"><option value="0">special</option><option value="1">BOX</option><option value="2">iBOX</option><option value="3">(0~9)包头</option><option value="4">(0~9)包尾</option></select></td><td><input type="text" name="number" id="number'+item+'" placeholder="number" maxlength="4"  onkeyup="this.value=this.value.replace(/\D/g,\'\')"></td><td><select name="rule" id="rule'+item+'" onchange="set_pay('+item+')">';
		for (var j = 0 in rule) {
			txt += '<option value="'+rule[j].id+'">'+rule[j].title+'</option>';
		}
		txt += '</select></td>';
		var content = rule[0].content;
		var array = content.split(',');
		for (var k = 1; k < 8; k++) {
			if (!array[k-1]) {
				array[k-1] = '';
				txt += '<td><input type="text" id="pay'+k+'_'+item+'" placeholder="'+array[k-1]+'" disabled="disabled" onkeyup="num(this)"></td>';
			}
			else{
				txt += '<td><input type="text" id="pay'+k+'_'+item+'" placeholder="'+array[k-1]+'" onkeyup="num(this)"></td>';
			}
		}
		txt += '<td><button type="button" id="follow'+item+'" class="btn" style="border-radius: 0" onclick="follow('+item+')">跟</button></td>';
		txt += '<td><span id="has_jp'+item+'"></span></td>';
		txt += '<td><span id="bet_total'+item+'"></span></td>';
		txt += '</tr>';
		$('#bet-table').append(txt);
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
				if (!array[k]) {
				array[k] = '';
				$('#pay'+d+'_1').val('');
				$('#pay'+d+'_1').attr('placeholder',array[k]);
				$('#pay'+d+'_1').attr('disabled','disabled');
			}
			else{
				$('#pay'+d+'_1').attr('placeholder',array[k]);
				$('#pay'+d+'_1').removeAttr('disabled');
			}
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
		$.post("<?php  echo $this->createMobileUrl('pc_xiazhu',array('op'=>'check_order'))?>",{data:data,member_id:"<?php  echo $_GPC['member_id'];?>",days_type:days_type,days:days},function (result) {
			if (result.status == 2) {
				alert(result.info);
			}
			if (result.status == 3) {
				location.href="<?php  echo $this->createMobileUrl('login')?>";
			}
			if (result.status == 4) {
				alert('本单已经投注，无法重复投注');
				return false;
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
		$.post("<?php  echo $this->createMobileUrl('pc_xiazhu',array('op'=>'get_order'))?>",{member_id:"<?php  echo $_GPC['member_id'];?>"},function(result) {
			var txt = '';
			for (var i = 0 in result) {
				txt += '<tr><td><a href="javascript:void(0);" onclick="show_order('+result[i].id+')">'+result[i].time+'</a></td><td><a href="javascript:void(0);" onclick="show_order('+result[i].id+')">'+result[i].uordersn+'</a></td><td><a href="javascript:void(0);" onclick="show_order('+result[i].id+')"">'+result[i].order_amount+'</a></td><td><a href="javascript:void(0);" onclick="show_order('+result[i].id+')">'+result[i].ordersn+'</a></td></tr>';
			}
			$('#list-title').nextAll().remove();
			$('#list-title').after(txt);
		},'JSON')
	}
	function get_number() {
		var number = $('input[name=search_number]').val();
		var date = $('#date').val();
		$.post("<?php  echo $this->createMobileUrl('pc_xiazhu',array('op'=>'search_number'))?>",{number:number,member_id:"<?php  echo $_GPC['member_id'];?>",date:date},function(result) {
			var txt = '';
			for (var i = 0 in result) {
				txt += '<tr><td><a href="javascript:void(0);" onclick="show_order('+result[i].id+')">'+result[i].time+'</a></td><td><a href="javascript:void(0);" onclick="show_order('+result[i].id+')">'+result[i].uordersn+'</a></td><td><a href="javascript:void(0);" onclick="show_order('+result[i].id+')"">'+result[i].order_amount+'</a></td><td><a href="javascript:void(0);" onclick="show_order('+result[i].id+')">'+result[i].ordersn+'</a></td></tr>';
			}
			$('#list-title').nextAll().remove();
			$('#list-title').after(txt);
		},'JSON');
	}
	function show_order(id) {
		$.post("<?php  echo $this->createMobileUrl('pc_xiazhu',array('op'=>'order_detail'))?>",{id:id},function(result) {
			var txt = '';
			txt = create_order(result,txt,'xiazhu');
			$('#orderd').html(txt);
			$('#order_detail').show();
		},'JSON');
	}
	function search_sn() {
		var ordersn = $('input[name=ordersn]').val();
		$.post("<?php  echo $this->createMobileUrl('pc_xiazhu',array('op'=>'order_detail'))?>",{keyword:ordersn,member_id:"<?php  echo $_GPC['member_id'];?>"},function(result) {
			var txt = '';
			txt = create_order(result,txt,'xiazhu');
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
	function rebuy() {
		var id = $('#order_id').val();
		var checked = confirm('重买后订单可能会发生变化，请检查！');
		if (checked == true) {
			$.post("<?php  echo $this->createMobileUrl('order_control',array('op'=>'rebuy'))?>",{id:id},function(result) {
				if (result.status == 2) {
					alert(result.info);
				}
				if (result.status == 3) {
					location.href="<?php  echo $this->createMobileUrl('login')?>";
				}
				if (result.status == 1) {
					alert(result.info);
					var txt = '';
					txt = create_order(result);
					$('#orderd').html(txt);
					$('#order_detail').show();
				}
			},'JSON');
		}
	}
	function del() {
		var id = $('#order_id').val();
		$.post("<?php  echo $this->createMobileUrl('order_control',array('op'=>'del'))?>",{id:id},function(result) {
			alert(result.info);
			if (result.status == 3) {
				location.href = "<?php  echo $this->createMobileUrl('login')?>";
			}
			if (result.status == 1) {
				window.location.reload();
			}
		},'JSON');
	}
	function restore() {
		var id = $('#order_id').val();
		$.post("<?php  echo $this->createMobileUrl('order_control',array('op'=>'restore'))?>",{id:id},function(result) {
			alert(result.info);
			if (result.status == 3) {
				location.href = "<?php  echo $this->createMobileUrl('login')?>";
			}
			if (result.status == 1) {
				window.location.reload();
			}
		},'JSON');
	}
	function change_auto() {
		var id = $('#order_id').val();
		var is_auto = $('#auto').is(':checked');
		$.post("<?php  echo $this->createMobileUrl('order_control',array('op'=>'change_days'))?>",{id:id,is_auto:is_auto},function(result) {
			alert(result.info);
			if (result.status == 3) {
				location.href = "<?php  echo $this->createMobileUrl('login')?>";
			}
			if (result.status == 1) {
				window.location.reload();
			}
		},'JSON')
	}
	function edit() {
		var id = $('#order_id').val();
		var url = "<?php  echo $this->createMobileUrl('pc_xiazhu',array('op'=>'edit_order'))?>&id="+id;
		var title = '修改单页';
		window.open(url, title, "location=no,status=no,scrollvars=no,width=1000,height=600");
	}
	function input_type() {
		var id = $('#order_id').val();
		$.post("<?php  echo $this->createMobileUrl('pc_xiazhu',array('op'=>'get_writing'))?>",{id:id},function(result) {
			$('#writing').find('.table').html(result.write);
			$('.recharge-main').css('width','60%');
			$('#orderd').parent().css('width','50%');
			$('#writing').css('display','inline-block');
		},'JSON')
	}
</script>
<?php  } ?>
<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('footer', TEMPLATE_INCLUDEPATH)) : (include template('footer', TEMPLATE_INCLUDEPATH));?>