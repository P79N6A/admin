<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('header', TEMPLATE_INCLUDEPATH)) : (include template('header', TEMPLATE_INCLUDEPATH));?>
<style type="text/css">
	input[type=text]{width: 50px;text-align: center;}
</style>
<table class="table table-bordered">
	<tr>
		<td style="width: 80px;">头等奖</td>
		<td>
			<input type="text" name="first" value="<?php  echo $record['first_no'];?>" onkeyup="value=value.replace(/[^\d]/g,'')" maxlength="4">
		</td>
	</tr>
	<tr>
		<td style="width: 80px;">二等奖</td>
		<td>
			<input type="text" name="secound" value="<?php  echo $record['second_no'];?>" onkeyup="value=value.replace(/[^\d]/g,'')" maxlength="4">
		</td>
	</tr>
	<tr>
		<td style="width: 80px;">三等奖</td>
		<td>
			<input type="text" name="third" value="<?php  echo $record['third_no'];?>" onkeyup="value=value.replace(/[^\d]/g,'')" maxlength="4">
		</td>
	</tr>
	<tr>
		<td style="width: 80px;">特别奖</td>
		<td>
			<?php  if(is_array($record['special_no'])) { foreach($record['special_no'] as $special) { ?>
			<?php  if($special != '----') { ?>
			<input type="text" name="special" value="<?php  echo $special;?>" onkeyup="value=value.replace(/[^\d]/g,'')" maxlength="4">
			<?php  } ?>
			<?php  } } ?>
		</td>
	</tr>
	<tr>
		<td style="width: 80px;">安慰奖</td>
		<td>
			<?php  if(is_array($record['consolation_no'])) { foreach($record['consolation_no'] as $consolation) { ?>
			<input type="text" name="consolation" value="<?php  echo $consolation;?>" onkeyup="value=value.replace(/[^\d]/g,'')" maxlength="4">
			<?php  } } ?>
		</td>
	</tr>
</table>
<button class="btn btn-success">确定</button>
<script type="text/javascript">
	$('.btn').click(function() {
		var checked = confirm('一旦确认无法还原，是否确认成绩？');
		var first = $('input[name=first]').val();
		var secound = $('input[name=secound]').val();
		var third = $('input[name=third]').val();
		var special = [];
		var consolation = [];
		$('input[name=special]').each(function() {
			special.push($(this).val());
		});
		$('input[name=consolation]').each(function() {
			consolation.push($(this).val());
		});
		if (checked == true) {
			$.post("<?php  echo $this->createMobileUrl('confirm_result')?>",{first:first,secound:secound,third:third,special:special,consolation:consolation},function(result) {
				alert(result.info);
				if (result.status == 3) {
					location.href = "<?php  echo $this->createMobileUrl('login')?>";
				}
			},'JSON');
		}
	})
</script>
<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('footer', TEMPLATE_INCLUDEPATH)) : (include template('footer', TEMPLATE_INCLUDEPATH));?>