<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('header', TEMPLATE_INCLUDEPATH)) : (include template('header', TEMPLATE_INCLUDEPATH));?>
<table class="table table-bordered">
	<tr>
		<td colspan="4">共：<?php  echo $all_total;?> 条：<?php  echo $count;?></td>
	</tr>
	<tr>
		<td>单ID</td>
		<td>用户ID</td>
		<td>佣金</td>
		<td>佣金和</td>
		<td>反水</td>
	</tr>
	<?php  if(is_array($ordercash)) { foreach($ordercash as $order) { ?>
	<tr>
		<td><?php  echo $order['id'];?></td>
		<td><?php  echo $order['user_id'];?></td>
		<td>
			<?php  if(is_array($order['cash'])) { foreach($order['cash'] as $key => $cash) { ?>
			&nbsp;<?php  echo $key;?>:<?php  echo $cash['cashback'];?>&nbsp;反水：<?php  echo $cash['percent'];?>&nbsp;
			<?php  } } ?>
		</td>
		<td>
			<?php  echo $order['total'];?>
		</td>
		<td><?php  echo json_encode($order['percent'])?></td>
	</tr>
	<?php  } } ?>
</table>