<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('header', TEMPLATE_INCLUDEPATH)) : (include template('header', TEMPLATE_INCLUDEPATH));?>
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
	.pack{background: #fff;color: #333;}
	.order-ul{list-style: none;}
	.order-ul li{float: left;}
	#summary{width: 30%;margin-top: 10px;}
	#summary>tbody>tr>td{padding: 3px 5px;}
</style>
<div class="col-xs-12">
	<form class="form-inline" rule="form">
		<div class="form-group">
			寻找号码
			<input type="text" name="number" value="" id="number" onkeyup="value=value.replace(/[^\d]/g,'');">
		</div>
		<div class="form-group">
			寻找日期
			<input type="text" value="<?php  echo date('Y-m-d',time())?>" readonly id="date" style="background: url(../addons/purchasing/static/images/date.jpg) no-repeat;background-position: right;background-size: auto 100%;">
		</div>
		<div class="form-group">
			寻找公司
			<select id="company">
				<option value="0">ALL</option>
				<?php  if(is_array($company)) { foreach($company as $com) { ?>
				<option value="<?php  echo $com['id'];?>"><?php  echo $com['name'];?></option>
				<?php  } } ?>
			</select>
		</div>
		<div class="form-group">
			寻找类型
			<select id="type">
				<option value="0">ALL</option>
				<?php  if(is_array($type)) { foreach($type as $ty) { ?>
				<option value="<?php  echo $ty;?>"><?php  echo $ty;?></option>
				<?php  } } ?>
			</select>
		</div>
		<div class="form-group">
			寻找代理
			<select id="agent">
				<option value="0">ALL</option>
				<?php  if(is_array($agent)) { foreach($agent as $ag) { ?>
				<option value="<?php  echo $ag['id'];?>"><?php  echo $ag['account'];?></option>
				<?php  } } ?>
			</select>
		</div>
		<div class="form-group">
			<button type="button" class="btn" onclick="search_number();">搜索</button>
		</div>
	</form>
	<table class="table table-bordered" id="summary">
		
	</table>
	<table class="table table-bordered" id="detail-list">
		
	</table>
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
					<button class="btn btn-xs btn-warning" style="margin-left: 5px" onclick="rebuy()">重买</button>
				</li>
				<?php  if($_SESSION['level'] < 5) { ?>
				<li id="edit_btn">
					<button class="btn btn-xs btn-warning" style="margin-left: 5px" onclick="edit()">修改</button>
				</li>
				<li id="restore" style="display: none;">
					<button class="btn btn-xs btn-warning" style="margin-left: 5px" onclick="restore()">还原</button>
				</li>
				<?php  } ?>
				<li>
					<button class="btn btn-xs btn-danger" style="margin-left: 5px" onclick="del()">删除</button>
				</li>
				<li>
					<button class="btn btn-xs btn-warning" style="margin-left: 5px" onclick="input_type()">输入法</button>
				</li>
			</ul>
			<input type="hidden" id="order_id">
			<a href="javascript:void(0)" onclick="$('#order_detail').hide();" style="font-size: 18px;float: right;"><span>&times;</span></a>
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
<link rel="stylesheet" type="text/css" href="../addons/purchasing/static/css/bootstrap-datetimepicker.min.css">
<script type="text/javascript" src="../addons/purchasing/static/js/bootstrap-datetimepicker.min.js"></script>
<script type="text/javascript" src="../addons/purchasing/static/js/order.js"></script>
<script type="text/javascript">
	var rule = [];
	var company = [];
	var obj = [];
	var sdate = '2018-07-04';
	$.fn.datetimepicker.dates['zdy'] = {
        days: ["星期日", "星期一", "星期二", "星期三", "星期四", "星期五", "星期六"],
        daysShort: ["周日", "周一", "周二", "周三", "周四", "周五", "周六"],
        daysMin:  ["日", "一", "二", "三", "四", "五", "六"],
        months: ["1月","2月","3月","4月","5月","6月","7月","8月","9月","10月","11月","12月"],
        monthsShort: ["1月","2月","3月","4月","5月","6月","7月","8月","9月","10月","11月","12月"],
        today: "今天",
        format:"yyyy-mm-dd",
        titleFormat:"yyyy-mm-",
        weekStart:1,
        suffix: [],
        meridiem: ["上午", "下午"]
     };
    $('#date').datetimepicker({
        language:  'zdy',
        weekStart: 1,
        todayBtn:  1,
        autoclose: 1,
        startDate:sdate,
        minView:2,
        maxView:3,
        onRenderDay: function(date) {
          var date1 = date.getFullYear()+'-'
            +(date.getMonth()<9?'0'+(date.getMonth()+1):date.getMonth()+1)
            +'-'
            +(date.getDate()<10?'0'+(date.getDate()-1):date.getDate()-1);

        }
    })
    window.onload = function() {
    	get_rule();
    	get_company();
    }
    function get_rule() {
		$.post("<?php  echo $this->createMobileUrl('pc_xiazhu',array('op'=>'get_rule'))?>",{},function(result) {
			rule = result;
		},'JSON');
	}
	function get_company() {
		$.post("<?php  echo $this->createMobileUrl('pc_xiazhu',array('op'=>'get_company'))?>",{},function(result) {
			company = result;
		},'JSON');
	}
    function search_number() {
    	var number = $('#number').val();
    	var date = $('#date').val()||'';
    	var company = $('#company').val();
    	var type = $('#type').val();
    	var agent = $('#agent').val();
    	$.post("<?php  echo $this->createMobileUrl('search_number')?>",{number:number,date:date,company:company,type:type,agent:agent},function (result) {
    		var summary = result.companys;
    		var user = result.user;
    		var txt = '';
    		var tt = '';
    		if (user.length == 0) {
    			txt = '<tr><td>没有投注此号码<td><tr>';
    			$('#summary').html(txt);
    			$('#detail-list').html('');
    			return false;
    		}
    		for (var i = 0 in summary) {
    			var detail = summary[i].detail;
				for (var j in detail) {
					if (detail[j] != '0.00000000' && detail[j] != null) {
						txt += '<tr>';
	    				txt += '<td>'+summary[i].nickname+'</td>';
	    				txt += '<td>'+j+'</td>';
	    				txt += '<td>'+parseFloat(detail[j]).toFixed(2)+'</td>';
	    				txt += '</tr>';
					}
				}
    		}
    		for (var k = 0 in user) {
    			tt += '<tr>';
    			tt += '<td>'+user[k].nickname+'</td>';
    			tt += '<td>'+user[k].account+'<br>upline：'+user[k].agent+'</td>';
    			tt += '<td>';
    			var com = user[k].company;
    			for (var l = 0 in com) {
    				tt += '<table class="table table-condensed">';
    				var de = com[l].detail;
    				for (var m in de) {
						if (de[m].value != '0.00000000' && de[m].value != null) {
							tt += '<tr>';
							tt += '<td style="border-top:0;border-bottom:1px solid #ddd;width:5vw;">'+com[l].nickname+'</td>';
							tt += '<td style="border-top:0;border-bottom:1px solid #ddd;width:5vw;">'+m+'</td>';
							tt += '<td style="border-top:0;border-bottom:1px solid #ddd;width:5vw;">'+parseFloat(de[m].value).toFixed(2)+'</td>';
							tt += '<td style="border-top:0;border-bottom:1px solid #ddd;">';
							var order = de[m].order;
							for (var n = 0 in order) {
								tt += '<a href="javascript:void(0);" onclick="show_order('+order[n].id+')" style="color:#0000f0">[S:'+order[n].ordersn+']</a>';
							}
							tt += '</td>';
							tt += '</tr>';
						}
    				}
    				tt += '</table>';
    			}
    			tt += '</td></tr>';
    		}
    		$('#summary').html(txt);
    		$('#detail-list').html(tt);
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
					txt = create_order(result,txt,'xiazhu');
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
		console.log(is_auto);
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
<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('footer', TEMPLATE_INCLUDEPATH)) : (include template('footer', TEMPLATE_INCLUDEPATH));?>