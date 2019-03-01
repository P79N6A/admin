<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('header', TEMPLATE_INCLUDEPATH)) : (include template('header', TEMPLATE_INCLUDEPATH));?>
<link rel="stylesheet" type="text/css" href="../addons/purchasing/static/css/bootstrap-datetimepicker.min.css">
<script type="text/javascript" src="../addons/purchasing/static/js/bootstrap-datetimepicker.min.js"></script>
<style type="text/css">
	.input-container{display: inherit;}
  .table>tbody>tr>td{font-size: 5.5vh;font-weight: 600;line-height: normal;padding: 0 1vw;}
</style>
<form action="" class="form-inline" role="form" method="get">
	<div class="form-group" >
		开始日期:
		<input type="text" name="stime" id="starttime" readonly="readonly" value="<?php  echo $start;?>" style="background: url(../addons/purchasing/static/images/date.jpg) no-repeat;background-position: right;background-size: auto 100%;">
		结束日期:
		<input type="text" name="etime" id="endtime" readonly="readonly" value="<?php  echo $end;?>" style="background: url(../addons/purchasing/static/images/date.jpg) no-repeat;background-position: right;background-size: auto 100%;">
		<!--c=site&a=entry&eid=181-->
		<input type="hidden" name="c" value="entry">
		<input type="hidden" name="i" value="6">
		<input type="hidden" name="do" value="report">
		<input type="hidden" name="m" value="manji">
		<input type="submit" value="查询" class="btn btn-info">
	</div>
</form>
<table class="table table-condensed" style="margin-top: 10px;">
  <tr><td style="border: 0;"><?php  echo $member['account'];?> (<?php  echo date('d/m',strtotime($start))?>-<?php  echo date('d/m',strtotime($end))?>)</td></tr>
	<tr><td style="border: 0;">=Summary=</td></tr>
	<?php  if(is_array($reports)) { foreach($reports as $rp) { ?>
	<tr><td style="border: 0;">D:<?php  echo $rp['date'];?></td></tr>
	<tr><td style="border: 0;">S:<?php  echo number_format($rp['sum_bet'],2)?></td></tr>
	<tr><td style="border: 0;">N:<?php  echo number_format($rp['net'],2)?></td></tr>
	<tr><td style="border: 0;">W:<?php  if($rp['pay_award'] > 0) { ?>-<?php  } ?><?php  echo number_format($rp['pay_award'],2)?></td></tr>
  <tr><td style="border: 0;">J:<?php  echo number_format($rp['jackpot'],2)?></td></tr>
	<tr><td style="border: 0;">T:<?php  echo number_format($rp['total'],2)?></td></tr>
  <tr><td style="border: 0;padding: 2vh;"></td></tr>
	<?php  } } ?>
	<tr><td style="border: 0;">TOTAL:<?php  echo number_format($total,2)?></td></tr>
	<tr><td style="border: 0;">====================================</td></tr>
	<tr><td style="border: 0;"></td></tr>
	<tr><td style="border: 0;"></td></tr>
	<tr><td style="border: 0;">************************************************</td></tr>
  <?php  if(is_array($v['win'])) { foreach($v['win'] as $w) { ?>
  <tr><td style="border: 0;">#<?php  echo $w['uordersn'];?>/<?php  echo $rp['cnickname'];?>/<?php  echo $w['winner_number_type'];?>/<?php  echo $w['winner_type'];?>&nbsp;&nbsp;<?php  echo $w['bet_number'];?>&nbsp;&nbsp;$<?php  echo $w['bet_money'];?>&nbsp;&nbsp;=<?php  echo number_format($w['winner_money'],2)?></td></tr>
  <?php  } } ?>
	<tr><td style="border: 0;">************************************************</td></tr>
</table>
<script src="../DateBox/required.js" type="text/javascript" charset="utf-8"></script>
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
</script>