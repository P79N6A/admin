<?php defined('IN_IA') or exit('Access Denied');?><div style='max-height:500px;overflow:auto;min-width:850px;'>
	<table class="table table-hover" style="min-width:850px;">
		<tbody>   
			<?php  if(is_array($list)) { foreach($list as $row) { ?>
			<tr>
				<td><img src="<?php  echo $_W['attachurl'];?><?php  echo $row['images'];?>" style='width:30px;height:30px;padding1px;border:1px solid #ccc' /> <?php  echo $row['bookname'];?></td>
				<td><?php  if($row['validity']==0) { ?>长期有效<?php  } else { ?>有效期<?php  echo $row['validity'];?>天<?php  } ?></td>
				<td style="width:80px;"><a href="javascript:;" onclick='select_lesson(<?php  echo json_encode($row);?>)' data-dismiss="modal">选择</a></td>
			</tr>
			<?php  } } ?>
			<?php  if(count($list)<=0) { ?>
			<tr> 
				<td colspan='3' align='center'>未找到相关课程</td>
			</tr>
			<?php  } ?>
		</tbody>
	</table>
</div>