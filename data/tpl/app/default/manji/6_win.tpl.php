<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('header', TEMPLATE_INCLUDEPATH)) : (include template('header', TEMPLATE_INCLUDEPATH));?>
<div class="col-xs-12">
	<link rel="stylesheet" type="text/css" href="../addons/purchasing/static/css/bootstrap-datetimepicker.min.css">
	<script type="text/javascript" src="../addons/purchasing/static/js/bootstrap-datetimepicker.min.js"></script>
	<style type="text/css">
		.input-container{display: inherit;}
		.table>tbody>tr>td{font-size: 4vh;font-weight: 600;}
	</style>
	<form action="" class="form-inline" role="form" method="get">
		<div class="form-group" >
			日期:
			<input type="text" name="date" id="date" readonly="readonly" value="<?php  echo $date;?>" style="background: url(../addons/purchasing/static/images/date.jpg) no-repeat;background-position: right;background-size: auto 100%;">
			<input type="hidden" name="c" value="entry">
			<input type="hidden" name="i" value="6">
			<input type="hidden" name="do" value="win">
			<input type="hidden" name="m" value="manji">
			<input type="submit" value="确定" class="btn btn-info">
		</div>
	</form>
</div>
<div class="col-xs-12" style="max-height: 80vh;overflow-y: auto;margin-top: 2vh">
	<table class="table table-bordered table-condensed">
		<tr>
			<td>号码</td>
			<td>投注</td>
			<td>中奖</td>
			<td>奖金</td>
			<td>总单号</td>
			<td>手机单号</td>
		</tr>
		<?php  if(is_array($jackpot)) { foreach($jackpot as $j) { ?>
		<tr>
			<td><?php  echo $j['number_team'];?></td>
			<td><?php  echo $j['bet_money'];?></td>
			<td><?php  echo $j['win_type'];?></td>
			<td><?php  echo $j['win_money'];?></td>
			<td><?php  echo $j['ordersn'];?></td>
			<td><?php  echo $j['uordersn'];?></td>
		</tr>
		<?php  } } ?>
	</table>
</div>
<script type="text/javascript">
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
</script>