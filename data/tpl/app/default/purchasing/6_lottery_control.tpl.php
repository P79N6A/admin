<?php defined('IN_IA') or exit('Access Denied');?><div class="col-xs-12">
	特别号码：
	<select name="special">
		<option value="A" <?php  if($number['0'] == 'A') { ?>selected<?php  } ?>>A</option>
		<option value="B" <?php  if($number['0'] == 'B') { ?>selected<?php  } ?>>B</option>
		<option value="C" <?php  if($number['0'] == 'C') { ?>selected<?php  } ?>>C</option>
		<option value="D" <?php  if($number['0'] == 'D') { ?>selected<?php  } ?>>D</option>
		<option value="E" <?php  if($number['0'] == 'E') { ?>selected<?php  } ?>>E</option>
		<option value="F" <?php  if($number['0'] == 'F') { ?>selected<?php  } ?>>F</option>
		<option value="G" <?php  if($number['0'] == 'G') { ?>selected<?php  } ?>>G</option>
		<option value="H" <?php  if($number['0'] == 'H') { ?>selected<?php  } ?>>H</option>
		<option value="I" <?php  if($number['0'] == 'I') { ?>selected<?php  } ?>>I</option>
		<option value="J" <?php  if($number['0'] == 'J') { ?>selected<?php  } ?>>J</option>
		<option value="K" <?php  if($number['0'] == 'K') { ?>selected<?php  } ?>>K</option>
		<option value="L" <?php  if($number['0'] == 'L') { ?>selected<?php  } ?>>L</option>
		<option value="M" <?php  if($number['0'] == 'M') { ?>selected<?php  } ?>>M</option>
	</select>
	-
	<select name="special">
		<option value="A" <?php  if($number['1'] == 'A') { ?>selected<?php  } ?>>A</option>
		<option value="B" <?php  if($number['1'] == 'B') { ?>selected<?php  } ?>>B</option>
		<option value="C" <?php  if($number['1'] == 'C') { ?>selected<?php  } ?>>C</option>
		<option value="D" <?php  if($number['1'] == 'D') { ?>selected<?php  } ?>>D</option>
		<option value="E" <?php  if($number['1'] == 'E') { ?>selected<?php  } ?>>E</option>
		<option value="F" <?php  if($number['1'] == 'F') { ?>selected<?php  } ?>>F</option>
		<option value="G" <?php  if($number['1'] == 'G') { ?>selected<?php  } ?>>G</option>
		<option value="H" <?php  if($number['1'] == 'H') { ?>selected<?php  } ?>>H</option>
		<option value="I" <?php  if($number['1'] == 'I') { ?>selected<?php  } ?>>I</option>
		<option value="J" <?php  if($number['1'] == 'J') { ?>selected<?php  } ?>>J</option>
		<option value="K" <?php  if($number['1'] == 'K') { ?>selected<?php  } ?>>K</option>
		<option value="L" <?php  if($number['1'] == 'L') { ?>selected<?php  } ?>>L</option>
		<option value="M" <?php  if($number['1'] == 'M') { ?>selected<?php  } ?>>M</option>
	</select>
	-
	<select name="special">
		<option value="A" <?php  if($number['2'] == 'A') { ?>selected<?php  } ?>>A</option>
		<option value="B" <?php  if($number['2'] == 'B') { ?>selected<?php  } ?>>B</option>
		<option value="C" <?php  if($number['2'] == 'C') { ?>selected<?php  } ?>>C</option>
		<option value="D" <?php  if($number['2'] == 'D') { ?>selected<?php  } ?>>D</option>
		<option value="E" <?php  if($number['2'] == 'E') { ?>selected<?php  } ?>>E</option>
		<option value="F" <?php  if($number['2'] == 'F') { ?>selected<?php  } ?>>F</option>
		<option value="G" <?php  if($number['2'] == 'G') { ?>selected<?php  } ?>>G</option>
		<option value="H" <?php  if($number['2'] == 'H') { ?>selected<?php  } ?>>H</option>
		<option value="I" <?php  if($number['2'] == 'I') { ?>selected<?php  } ?>>I</option>
		<option value="J" <?php  if($number['2'] == 'J') { ?>selected<?php  } ?>>J</option>
		<option value="K" <?php  if($number['2'] == 'K') { ?>selected<?php  } ?>>K</option>
		<option value="L" <?php  if($number['2'] == 'L') { ?>selected<?php  } ?>>L</option>
		<option value="M" <?php  if($number['2'] == 'M') { ?>selected<?php  } ?>>M</option>
	</select>
</div>
<div>
	<table class="table table-bordered">
		<tr>
			<td>
				开奖分水线：
			</td>
			<td>
				<input type="text" name="dividing" value="<?php  echo $lot_limmit;?>">
			</td>
		</tr>
		<tr>
			<td colspan="4">
				<button type="button" class="btn" onclick="save_post()">保存</button>
			</td>
		</tr>
	</table>
</div>
<script type="text/javascript">
	function save_post() {
		var special = [];
		var dividing = [];
		$('select').each(function() {
			special.push($(this).val());
		});
		$('input').each(function() {
			dividing.push($(this).val());
		})
		$.post("<?php  echo $this->createMobileUrl('manager',array('op'=>'lottery','tab'=>'special'));?>",{special:special,dividing:dividing},function(result) {
			alert(result.info);
			if (result.status == 1) {
				window.location.reload();
			}
		},'JSON');
	}
</script>