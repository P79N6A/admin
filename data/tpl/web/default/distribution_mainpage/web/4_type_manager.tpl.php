<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/header', TEMPLATE_INCLUDEPATH)) : (include template('common/header', TEMPLATE_INCLUDEPATH));?>
<ul class="nav nav-tabs">
	<li <?php  if($op == 'post'|| $op == 'edit') { ?>class="active"<?php  } ?>><a href="<?php  echo $this->createWebUrl('type_manager', array('op' => 'post'));?>">添加规格</a></li>
	<li <?php  if($op == 'display') { ?>class="active"<?php  } ?>><a href="<?php  echo $this->createWebUrl('type_manager', array('op' => 'display'));?>">规格列表</a></li>
</ul>
<style>
.table td span{display:inline-block;margin-top:4px;}
.table td input{margin-bottom:0;}
th{
	text-align: center !important;
}
td{
	text-align: center !important;
}
.red{color:red;font-weight:bold}
</style>
<?php  if(!$op ||  $op == 'display') { ?>
<div class="main">
	<div style="padding:15px;background: white;">
		<table class="table table-hover" style="table-layout: initial;">
			<thead class="navbar-inner">
				<tr>
					<th>规格编号</th>
					<th>规格名称</th>
					<th>操作</th>
				</tr>
			</thead>
			<tbody>
				<?php  if(is_array($list)) { foreach($list as $item) { ?>
				<tr>
					<td><?php  echo $item['id'];?></td>
					<td><?php  echo $item['title'];?></td>
					<td>
						<a href="<?php  echo $this->createWebUrl('type_manager', array('op' => 'edit', 'id' => $item['id']))?>" title="编辑" class="btn btn-sm btn-default"><i class="fa fa-edit"></i></a>
						<a onclick="return confirm('此操作不可恢复，确认吗？'); return false;" href="<?php  echo $this->createWebUrl('type_manager', array('op' => 'del','id' => $item['id']))?>" title="删除" class="btn btn-sm btn-danger"><i class="fa fa-remove"></i></a>
					</td>
				</tr>
				<?php  } } ?>
			</tbody>
		</table>
		<?php  echo $pager;?>
	</div>
</div>
<?php  } else if($op == 'post' || $op == 'edit') { ?>
<div class="panel panel-info">
		<div class="panel-body">
			<form action="" method="post" class="form-horizontal" role="form">
			<input type="hidden" name="id" value="<?php  echo $item['id'];?>">
			<div class="form-group">
				<label class="col-xs-12 col-sm-2 col-md-2 col-lg-1 control-label"><span class='red'>*</span>规格名称</label>
				<div class="col-sm-5">
					<input class="form-control" required="required" name="title" id='title' type="text" value="<?php  echo $item['title'];?>">
				</div>
			</div>
			<button type="submit" class="btn btn-primary" name="submit" id='summit_info' value="提交">保存</button>
			<input type="hidden" name="token" value="<?php  echo $_W['token'];?>" />
			</form>
	</div>
</div>
<?php  } ?>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/footer', TEMPLATE_INCLUDEPATH)) : (include template('common/footer', TEMPLATE_INCLUDEPATH));?>
