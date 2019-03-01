<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('header', TEMPLATE_INCLUDEPATH)) : (include template('header', TEMPLATE_INCLUDEPATH));?>
<link rel="stylesheet" type="text/css" href="../addons/purchasing/static/css/bootstrap-datetimepicker.min.css">
<script type="text/javascript" src="../addons/purchasing/static/js/bootstrap-datetimepicker.min.js"></script>
<style type="text/css">
	input[type=text]{width: 100px;}
	.table>tbody>tr>td{border: 0;font-size: 5vh;font-weight: 600;line-height: normal;padding: 0 1vw;}
</style>
<form action="" method="get" class="form-horizontal" role="form">
	<input type="hidden" name="c" value="entry">
	<input type="hidden" name="i" value="<?php  echo $_GPC['i'];?>">
	<input type="hidden" name="m" value="manji">
	<input type="hidden" name="do" value="reward">
	<div class="form-group">
		<div class="col-xs-8 col-sm-8 col-md-8 col-lg-11 ">
			日期
			<input type="text" name="date" id="date" value="<?php  echo $date;?>" style="width: 200px;border: 1px solid #ccc;background: url(../addons/purchasing/static/images/date.jpg) no-repeat;background-position: right;background-size: auto 100%;" readonly="readonly">
			<input type="submit" name="submit" value="搜索" class="btn">
		</div>
	</div>
</form>
<div class="col-xs-12" style="max-height: 80vh;overflow-y: auto;">
<?php  if(is_array($list)) { foreach($list as $item) { ?>
	<table class="table">
		<tr><td colspan="2"><?php  echo $item['nickname'];?><input type="hidden" name="period_id" value="<?php  echo $item['id'];?>"></td></tr>
		<tr>
			<td style="width: 5vw;">1st</td>
			<td><span><?php  echo $item['first_no'];?></span></td>
		</tr>
		<tr>
			<td style="width: 5vw;">2nd</td>
			<td><span><?php  echo $item['second_no'];?></span></td>
		</tr>
		<tr>
			<td style="width: 5vw;">3rd</td>
			<td><span><?php  echo $item['third_no'];?></span></td>
		</tr>
		<tr>
			<td style="width: 5vw;">4th</td>
			<td>
				<?php  if(is_array($item['special_no'])) { foreach($item['special_no'] as $k => $sp) { ?>
				<span><?php  echo $sp;?></span>&nbsp;&nbsp;
				<?php  } } ?>
			</td>
		</tr>
		<tr>
			<td style="width: 5vw;">5th</td>
			<td>
				<?php  if(is_array($item['consolation_no'])) { foreach($item['consolation_no'] as $l => $con) { ?>
				<span><?php  echo $con;?></span>&nbsp;&nbsp;
				<?php  } } ?>
			</td>
		</tr>
		<?php  if(!empty($item['5D'])) { ?>
		<?php  $D5_title=array('1st','2nd','3rd','4th','5th','6th')?>
		<tr>
			<td colspan="2">5D成绩</td>
		</tr>
		<?php  if(is_array($item['5D'])) { foreach($item['5D'] as $i => $d) { ?>
		<tr>
			<td style="width: 5vw;"><?php  echo $D5_title[$i];?></td>
			<td><span><?php  echo $d;?></span></td>
		</tr>
		<?php  } } ?>
		<?php  } ?>
		<?php  if($item['has_6D'] == 1) { ?>
		<tr>
			<td style="width: 5vw;">6D成绩</td>
			<td>
				<span><?php  echo $item['6D'];?></span>
			</td>
		</tr>
		<?php  } ?>
	</table>
<?php  } } ?>
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