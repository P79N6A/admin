<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('_header', TEMPLATE_INCLUDEPATH)) : (include template('_header', TEMPLATE_INCLUDEPATH));?>
<div class="page-heading"> <h2>会员管理</h2> </div>
<style type="text/css">
    .show:hover{
    	position: fixed;
        z-index: 1001;
    }
    .show:hover > img{
        transform: scale(5, 5);
        transition: .3s transform;
    }
</style>
<table class="table table-hover table-responsive">
	<thead class="navbar-inner">
		<tr>
			<th>姓名：</th>
			<td><?php  echo $op['name'];?></td>
			<th>性别：</th>
			<td><?php  echo $op['sex'];?></td>
		</tr>
		<tr>
			<th>生日：</th>
			<td><?php  echo $op['birthday'];?></td>
			<th>城市：</th>
			<td><?php  echo $op['city'];?></td>
		</tr>
		<tr>
			<th>车牌号：</th>
			<td><?php  echo $op['plate_0'];?><?php  echo $op['plate_1'];?></td>
			<th>车架号后6位：</th>
			<td><?php  echo $op['vin'];?></td>
		</tr>
		<tr>
			<th>品牌型号：</th>
			<td><?php  echo $op['brand'];?></td>
			<th>车价水平：</th>
			<td><?php  echo $op['price'];?></td>
		</tr>
		<tr>
			<th>发票：</th>
			<td><?php  echo $op['incoive'];?></td>
			<th>发票抬头：</th>
			<td><?php  echo $op['invoice_title'];?></td>
		</tr>
		<tr>
			<th colspan="4">上传照片：</th>
		</tr>
		<tr>
			<?php  if(is_array($op['thumb'])) { foreach($op['thumb'] as $img) { ?>
			<td>
				<a class="show" target='_blank' href='<?php  echo tomedia($img)?>'><img style='width:100px;padding:1px;border:1px solid #ccc' src="../attachment/<?php  echo $img;?>"></a>
			</td>
			<?php  } } ?>
		</tr>
		<?php  if($item['status'] == 0) { ?>
		<tr>
			<td>
				<a href="<?php  echo webUrl('order/vip/vip_agree',array('id'=>$item['id']))?>" class="btn btn-primary"  data-toggle='ajaxPost' data-confirm="确认通过该用户的会员申请吗？">通过</a>
				<a href="<?php  echo webUrl('order/vip/vip_refuse',array('id'=>$item['id']))?>" class="btn btn-danger"  data-toggle='ajaxModal'>不通过</a>
			</td>
		</tr>
		<?php  } ?>
		<?php  if($item['status'] == 1) { ?>
		<tr>
			<td colspan="4" style="text-align: center;">审核通过</td>
		</tr>
		<?php  } ?>
		<?php  if($item['status'] == 2) { ?>
		<tr>
			<td colspan="4" style="text-align: center;">审核不通过 <a href="<?php  echo webUrl('order/vip/reset',array('id'=>$item['id']))?>" class="btn  btn-primary">重提交</a></td>
		</tr>
		<tr>
			<td>原因：</td>
			<td colspan="3"><?php  echo $item['reason'];?></td>
		</tr>
		<?php  } ?>
	</thead>

</table>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('_footer', TEMPLATE_INCLUDEPATH)) : (include template('_footer', TEMPLATE_INCLUDEPATH));?>