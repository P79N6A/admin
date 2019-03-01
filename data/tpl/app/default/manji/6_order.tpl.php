<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('header', TEMPLATE_INCLUDEPATH)) : (include template('header', TEMPLATE_INCLUDEPATH));?>
<style type="text/css">
	td{font-size: 5.5vh;font-weight: 600;line-height: 5.5vh;}
</style>
<?php  if($op == 'display') { ?>
<div class="col-xs-12">
	<link rel="stylesheet" type="text/css" href="../addons/purchasing/static/css/bootstrap-datetimepicker.min.css">
	<script type="text/javascript" src="../addons/purchasing/static/js/bootstrap-datetimepicker.min.js"></script>
	<style type="text/css">
		.input-container{display: inherit;}
	</style>
	<form action="" class="form-inline" role="form" method="get">
		<div class="form-group" >
			开始日期:
			<input type="text" name="stime" id="starttime" readonly="readonly" value="<?php  echo date('Y-m-d',time())?>" style="background: url(../addons/purchasing/static/images/date.jpg) no-repeat;background-position: right;background-size: auto 100%;">
			结束日期:
			<input type="text" name="etime" id="endtime" readonly="readonly" value="<?php  echo date('Y-m-d',time())?>" style="background: url(../addons/purchasing/static/images/date.jpg) no-repeat;background-position: right;background-size: auto 100%;">
			<!--c=site&a=entry&eid=181-->
			<input type="hidden" name="c" value="entry">
			<input type="hidden" name="i" value="6">
			<input type="hidden" name="do" value="order">
			<input type="hidden" name="m" value="manji">
			<input type="button" value="确定" class="btn btn-info" onclick="get_order();">
		</div>
	</form>
	<div id="order-list">
		
	</div>
</div>
<script type="text/javascript" src="../addons/purchasing/static/js/order.js"></script>
<script type="text/javascript">
	var obj = [];
	var sdate = '2018-07-04';
	var company = [];
	var rule = [];
	$(function() {
		get_company();
		get_rule();
		get_order();
	})
	function get_company() {
		$.post("<?php  echo $this->createMobileUrl('xiazhu',array('op'=>'get_company'))?>",{},function(result) {
			company = result;
		},'JSON');
	}
	function get_rule() {
		$.post("<?php  echo $this->createMobileUrl('xiazhu',array('op'=>'get_rule'))?>",{},function(result) {
			rule = result;
		},'JSON');
	}
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
      $('#starttime').datetimepicker({
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
      }).on('changeDate', function(ev){
        $('#endtime').datetimepicker('remove');
        var sdate=$("#starttime").val();
        var edate;
        for(var o in obj){
          if(new Date(sdate)<=new Date(obj[o])){
            var date = new Date(obj[o])
            var ndate = +date+24*60*60*1000;
            var leaveTime = new Date(ndate);
            edate = leaveTime.getFullYear()+'-'+(leaveTime.getMonth()+1)+'-'+leaveTime.getDate();

            break;
          }
        }
        $('#endtime').datetimepicker({
          language:  'zdy',
          weekStart: 1,
          todayBtn:  1,
          autoclose: 1,
          startDate:sdate,
          endDate:edate,
          minView:2,
          maxView:3
        }).on('changeDate', function(ev){

        });
      });
	$("#endtime").click(function(){
	    if($("#startDate").val()!=''){

	    }else{
	      showMsg('请选择日期');
	    }
	});
	function get_order() {
		var start = $('#starttime').val();
		var end = $('#end').val();
		$.post("<?php  echo $this->createMobileUrl('order',array('op'=>'get_order'))?>",{stime:start,etime:end},function(result) {
			var txt = '<tr><td>TOTAL TICKET:'+result.count+'</td></tr>';
			txt += '<tr><td>==================================</td></tr>';
			var list = result.list;
			for (var o = 0 in list) {
				txt += create_order(list[o]);
				txt += '<tr><td>==================================</td></tr>';
			}
			$('#order-list').html(txt);
		},'JSON');
	}
</script>
<?php  } else if($op == 'search_order') { ?>
<style type="text/css">
	.table>tbody>tr>td{border: 0;}
	.btn{border: 0;}
</style>
<script type="text/javascript" src="../addons/purchasing/static/js/order.js"></script>
<div class="col-xs-12">
	<div class="col-xs-12" style="padding: 0;">
		户口&nbsp;&nbsp;<?php  echo $my_info['account'];?>
	</div>
	<div class="col-xs-12" style="padding: 0;">
		单页&nbsp;&nbsp;<select id="order_id"><?php  if(is_array($orders)) { foreach($orders as $ord) { ?><option value="<?php  echo $ord['id'];?>">#<?php  echo $ord['uordersn'];?></option><?php  } } ?></select>
		显示&nbsp;&nbsp;<select id="size">
			<option value="50" <?php  if($psize == 50) { ?>selected<?php  } ?>>50</option>
			<option value="200" <?php  if($psize == 200) { ?>selected<?php  } ?>>200</option>
			<option value="500" <?php  if($psize == 500) { ?>selected<?php  } ?>>500</option>
			<option value="1000" <?php  if($psize == 1000) { ?>selected<?php  } ?>>1000</option>
			<option value="5000" <?php  if($psize == 5000) { ?>selected<?php  } ?>>5000</option>
			<option value="9999" <?php  if($psize == 9999) { ?>selected<?php  } ?>>9999</option>
		</select>
	</div>
	<div class="col-xs-12" style="padding: 0;">
		寻找&nbsp;&nbsp; <input type="text" name="sn" value="" style="border: 0;border-bottom: 1px solid #333"> <input type="button" class="btn btn-xs btn-primary" onclick="search_sn()" value="寻找">
	</div>
	<div id="orderd"></div>
</div>
<script type="text/javascript">
	var company = [];
	var rule = [];
	$(function() {
		get_company();
		get_rule();
		show_order("<?php  echo $first_id;?>");
	})
	$('#order_id').on('change',function() {
		var id = $(this).val();
		$('input[name=sn]').val('');
		show_order(id);
	})
	function get_company() {
		$.post("<?php  echo $this->createMobileUrl('xiazhu',array('op'=>'get_company'))?>",{},function(result) {
			company = result;
		},'JSON');
	}
	function get_rule() {
		$.post("<?php  echo $this->createMobileUrl('xiazhu',array('op'=>'get_rule'))?>",{},function(result) {
			rule = result;
		},'JSON');
	}
	function show_order(id) {
		$.post("<?php  echo $this->createMobileUrl('xiazhu',array('op'=>'order_detail'))?>",{id:id},function(result) {
			var txt = '';
			if (result.order_id>0) {
				txt += '<tr><td><button class="btn btn-warning" onclick="rebuy('+result.order_id+')">重买</button><button class="btn btn-danger" onclick="del('+result.order_id+')">删除</button></td><tr>';
				txt += create_order(result);
			}
			$('#orderd').html(txt);
		},'JSON');
	}
	function search_sn() {
		var ordersn = $('input[name=sn]').val();
		$.post("<?php  echo $this->createMobileUrl('xiazhu',array('op'=>'order_detail'))?>",{keyword:ordersn},function(result) {
			var txt = '';
			if (result.order_id>0) {
				txt += '<tr><td><button class="btn btn-warning" onclick="rebuy('+result.order_id+')">重买</button><button class="btn btn-danger" onclick="del('+result.order_id+')">删除</button></td><tr>';
				txt += create_order(result);
			}
			$('#orderd').html(txt);
		},'JSON');
	}
	function rebuy(id) {
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
	function del(id) {
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
</script>
<?php  } ?>