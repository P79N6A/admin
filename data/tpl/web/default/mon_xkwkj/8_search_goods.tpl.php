<?php defined('IN_IA') or exit('Access Denied');?>


<table class="table table-hover">
	<thead class="navbar-inner">
	<tr>
		<th>商品</th>
		<th>预览图</th>
		<th >操作</th>
	</tr>
	</thead>
	<tbody>

	<?php  if(is_array($goods)) { foreach($goods as $item) { ?>
	<tr>

		<td><?php  echo $item['p_name'];?> </td>
		<td><img src="<?php  echo MonUtil::getpicurl($item['p_preview_pic'])?>" height="50px" width="50px"></td>
		<td>
			<a href="javascript:void(0)" onclick='select_entry(<?php  echo json_encode($item['entry']);?>)' class="btn btn-default" role="button" >选择</a>
		</td>
	</tr>
	<?php  } } ?>

	</tbody>
</table>
