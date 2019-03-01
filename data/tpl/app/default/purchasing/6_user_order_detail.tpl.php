<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('header', TEMPLATE_INCLUDEPATH)) : (include template('header', TEMPLATE_INCLUDEPATH));?>
<div class="col-xs-12">
	<table class="table table-bordered">
		<tr>
			<td>#单号</td>
			<td>状态</td>
			<td>公司</td>
			<td>号码</td>
			<td>输入法</td>
			<td>投注额</td>
		</tr>
		<?php  if(is_array($list)) { foreach($list as $item) { ?>
		<tr>
			<td>#<?php  echo $item['uordersn'];?></td>
			<td>
				<?php  if($item['status'] == 1) { ?>
				OK
				<?php  } else { ?>
				CANCEL
				<?php  } ?>
			</td>
			<td><?php  echo $item['number'];?></td>
			<td><?php  echo $item['company'];?></td>
			<td><?php  echo $item['rule'];?></td>
			<td><?php  echo $item['amount'];?></td>
		</tr>
		<?php  } } ?>
	</table>
</div>