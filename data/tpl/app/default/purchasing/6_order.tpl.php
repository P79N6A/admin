<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('header', TEMPLATE_INCLUDEPATH)) : (include template('header', TEMPLATE_INCLUDEPATH));?>
<style>
	.recharge-area{position: fixed;width: 100%;height: 100%;top: 0;left: 0;background: rgba(0,0,0,0.4);display: none;}
	.recharge-main{width: 50%;height: 20vw;margin: 5% auto;background: #fff;}
	.recharge-head{width: 100%;text-align: center;border-bottom: 1px solid #aaa;font-size: 20px;line-height: 30px;}
	.recharge-body{width: 100%;padding: 2vw 3vw;}
	.recharge-body table tbody tr td input{width: 80%;border: 0;}
	.btn{border: 1px solid #3e3e3e;background-color: #3e3e3e;border-radius: 20px;color: #fff;padding: 3px 7px;}
	a:hover{text-indent: none;}
	.btn:hover{background: #fff;color: #333}
</style>
<link rel="stylesheet" type="text/css" href="../addons/purchasing/static/css/bootstrap-datetimepicker.min.css">
<script type="text/javascript" src="../addons/purchasing/static/js/bootstrap-datetimepicker.min.js"></script>
<style type="text/css">
	table tr td{text-align: center;}
	#details tr td{text-align: left;border: 0;}
	.recharge-main{width: 30%;height: 30vw;margin: 5% auto;background: #fff;}
	.recharge-body{overflow-y: auto;height: 90%;}
</style>
<div class="col-xs-12">
	<div class="col-xs-12" style="padding: 10px 0;">
		<a href="<?php  echo $this->createMobileUrl('order',array('length'=>4,'time'=>$_GPC['time']))?>" class="btn">4D</a>
		<a href="<?php  echo $this->createMobileUrl('order',array('length'=>3,'time'=>$_GPC['time']))?>" class="btn">3D</a>
		<a href="<?php  echo $this->createMobileUrl('order',array('length'=>2,'time'=>$_GPC['time']))?>" class="btn">2D</a>
	</div>
	<style type="text/css">
		.input-container{display: inherit;}
	</style>
	<form class="form-inline" role="form" action="<?php  echo $this->createMobileUrl('manager',array('op'=>'order'))?>" method="get">
		<input type="hidden" name="c" value="<?php  echo $_GPC['c'];?>">
		<input type="hidden" name="i" value="<?php  echo $_GPC['i'];?>">
		<input type="hidden" name="do" value="<?php  echo $_GPC['do'];?>">
		<input type="hidden" name="m" value="<?php  echo $_GPC['m'];?>">
		<input type="hidden" name="length" value="<?php  echo $_GPC['length'];?>">
		<input type="hidden" name="op" value="order">
		<div class="form-group" style="padding: 5px 0;">
			寻找号码：
			<input type="text" name="number" value="<?php  echo $_GPC['number'];?>">
			日期:
			<input type="text" name="time" id="starttime" readonly="readonly" value="<?php  echo $time;?>"  style="background: url(../addons/purchasing/static/images/date.jpg) no-repeat;background-position: right;background-size: auto 100%;">
			<div class="form-group">
				<input type="submit" name="search" class="btn btn-success" value="搜索">
				<input type="submit" name="excel" class="btn" value="下载Excel">
			</div>
		</div>
	</form>
	<div class="col-xs-12" style="padding: 0;">
		<?php  if(is_array($company)) { foreach($company as $com) { ?>
		<?php  echo $com['nickname'];?>：<?php  echo round($com['total'],2)?>
		<?php  } } ?>
	</div>
	<?php  if(is_array($company)) { foreach($company as $com) { ?>
	<div class="col-xs-12" style="padding: 0 0 10px;">
		<p><?php  echo $com['name'];?></p>
		<?php  if(is_array($com['list'])) { foreach($com['list'] as $i => $item) { ?>
		<?php  $len = 100/$count;?>
		<table class="table table-bordered" style="width: <?php  echo $len;?>%;float: left;">
			<tr>
				<td colspan="2">共：<?php  echo $com['order_count'][$i];?></td>
			</tr>
			<tr>
				<td colspan="2"><?php  echo $i;?>&nbsp;&nbsp;&nbsp;&nbsp;合计：<?php  echo number_format($com['amount'][$i],2);?></td>
			</tr>
			<tr>
				<td>号码</td>
				<td>投注额</td>
			</tr>
			<tr>
				<td colspan="2" style="padding: 0;">
					<div style="overflow-y: auto;max-height: 300px;">
						<table class="table table-bordered">
							<?php  if(is_array($item)) { foreach($item as $it) { ?>
							<?php  if($it[$i] > 0) { ?>
							<tr>
								<td>
									<a href="javascript:void(0);" onclick="number_detail('<?php  echo $it['number'];?>',<?php  echo $com['id'];?>);">
										<?php  if($length >= 4) { ?>
										<?php  echo $it['number'];?>
										<?php  } else if($length == 3) { ?>
										<?php  echo substr($it['number'],-3)?>
										<?php  } else if($length == 2) { ?>
										<?php  echo substr($it['number'],-2)?>
										<?php  } ?>
									</a>
								</td>
								<td><a href="javascript:void(0);" onclick="number_detail('<?php  echo $it['number'];?>',<?php  echo $com['id'];?>);"><?php  echo number_format($it[$i],2)?></a></td>
							</tr>
							<?php  } ?>
							<?php  } } ?>
						</table>
					</div>
				</td>
			</tr>
		</table>
		<?php  } } ?>
	</div>
	<?php  } } ?>
	<div id="number_detail" class="recharge-area">
		<div class="recharge-main">
			<div class="recharge-head" id="number-title">
				
			</div>
			<div class="recharge-body">
				<table class="table table-bordered" id="number_list">
					
				</table>
			</div>
		</div>
	</div>
	<div id="order_list" class="recharge-area">
		<div class="recharge-main">
			<div class="recharge-head" id="list-title">
				
			</div>
			<div class="recharge-body">
				<table class="table table-bordered" id="orders">
					
				</table>
			</div>
		</div>
	</div>
	<div id="order_detail" class="recharge-area">
		<div class="recharge-main">
			<div class="recharge-head" id="detail-title">
				详细单页<a href="javascript:void(0)" onclick="$('#order_detail').hide();"><span style="float: right;margin-right: 15px;">&times;</span></a>
			</div>
			<div class="recharge-body">
				<table class="table" id="details" style="max-width: 100%;">
					
				</table>
			</div>
		</div>
	</div>
	<script src="../DateBox/required.js" type="text/javascript" charset="utf-8"></script>
	<script type="text/javascript" src="../addons/purchasing/static/js/order.js"></script>
	<script type="text/javascript">
		var rule = [];
		$(function() {
			get_rule();
		})
		function number_detail(number,company) {
			var time = "<?php  echo $_GPC['time'];?>";
			var title = number+'<a href="javascript:void(0)" onclick="$(\'#number_detail\').hide();"><span style="float: right;margin-right: 15px;">&times;</span></a>';
			$('#number-title').html(title);
			$.post("<?php  echo $this->createMobileUrl('number_detail',array('op'=>'get_number'))?>",{number:number,time:time,company:company},function(result) {
				console.log(result.list);
				var list = result.list;
				var txt = '';
				$('#number_list').empty();
				if (list.length > 0) {
					list.forEach(function(item,key) {
						if (item.number > 0) {
							txt += '<tr>';
							txt += '<td><a href="javascript:void(0);" onclick="order_list(\''+result.number+'\',\''+item.key+'\','+result.company+')">'+item.key+'</a></td>';
							txt += '<td><a href="javascript:void(0);" onclick="order_list(\''+result.number+'\',\''+item.key+'\','+result.company+')">'+item.number+'</a></td>';
							txt += '</tr>';
						}
					});
					$('#number_list').html(txt);
				}
				$('#number_detail').show();
			},"JSON");
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
		function order_list(number,pay,company) {
			$('#number_detail').hide();
			var time = "<?php  echo $_GPC['time'];?>";
			var title = number+'&nbsp;&nbsp;&nbsp;'+pay+'<a href="javascript:void(0)" onclick="$(\'#order_list\').hide();"><span style="float: right;margin-right: 15px;">&times;</span></a>';
			$('#list-title').html(title);
			$.post("<?php  echo $this->createMobileUrl('number_detail',array('op'=>'get_order'))?>",{number:number,time:time,pay:pay,company},function(result) {
				console.log(result.list);
				var list = result.list;
				var txt = '';
				$('#orders').empty();
				if (list.length > 0) {
					list.forEach(function(item,key) {
						if (item.money > 0) {
							txt += '<tr>';
							txt += '<td><a href="javascript:void(0);" onclick="order_detail('+item.id+')">'+item.username+'</a></td>';
							txt += '<td><a href="javascript:void(0);" onclick="order_detail('+item.id+')">'+item.money+'</a></td>';
							txt += '</tr>';
						}
					});
					$('#orders').html(txt);
				}
				$('#order_list').show();
			},"JSON");
		}
		function order_detail(id) {
			$('#order_list').hide();
			$.post("<?php  echo $this->createMobileUrl('number_detail',array('op'=>'get_detail'))?>",{id:id},function(result) {
				console.log(result.detial);
				var txt = '';
				txt = create_order(result);
				$('#details').html(txt);
				$('#order_detail').show();
			},'JSON')
		}
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
		      showMsg('请先选择入住时间！');
		    }
		});
	</script>
</div>
<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('footer', TEMPLATE_INCLUDEPATH)) : (include template('footer', TEMPLATE_INCLUDEPATH));?>