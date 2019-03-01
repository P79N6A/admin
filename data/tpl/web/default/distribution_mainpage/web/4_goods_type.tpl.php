<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/header', TEMPLATE_INCLUDEPATH)) : (include template('common/header', TEMPLATE_INCLUDEPATH));?>
<ul class="nav nav-tabs">
	<li <?php  if($op == 'post'|| $op == 'edit') { ?>class="active"<?php  } ?>><a href="<?php  echo $this->createWebUrl('goods_type', array('op' => 'post'));?>">添加商品规格</a></li>
	<li <?php  if($op == 'display') { ?>class="active"<?php  } ?>><a href="<?php  echo $this->createWebUrl('goods_type', array('op' => 'display'));?>">规格列表</a></li>
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
					<th>商品编号</th>
					<th>商品名称</th>
					<th>商品规格</th>
					<th>规格所属</th>
					<th>操作</th>
				</tr>
			</thead>
			<tbody>
				<?php  if(is_array($list)) { foreach($list as $item) { ?>
				<tr>
					<td><?php  echo $item['goods_id'];?></td>
					<td><?php  echo $item['goods_name'];?></td>
					<td><?php  echo $item['value'];?></td>
					<td><?php  echo $item['type'];?></td>
					<td>
						<a href="<?php  echo $this->createWebUrl('goods_type', array('op' => 'edit','id' => $item['id']))?>" title="编辑" class="btn btn-sm btn-default"><i class="fa fa-edit"></i></a>
						<a onclick="return confirm('此操作不可恢复，确认吗？'); return false;" href="<?php  echo $this->createWebUrl('goods_type', array('op' => 'del','id' => $item['id']))?>" title="删除" class="btn btn-sm btn-danger"><i class="fa fa-remove"></i></a>
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
			<div class="form-group">
				<label class="col-xs-12 col-sm-2 col-md-2 col-lg-1 control-label"><span class='red'>*</span>商品名称</label>
				<div class="col-xs-12 col-sm-9 col-lg-9">
                    <select name="goods_id" style="width: 20%; height:30px">					
                        <option value="0">请选择</option>
							<?php  if(is_array($store_type)) { foreach($store_type as $p) { ?>
								<option <?php  if($item['goods_id'] == $p['goods_id']) { ?>selected="selected"<?php  } ?> value="<?php  echo $p['goods_id'];?>"><?php  echo $p['goods_name'];?></option>
							<?php  } } ?>
					</select>
                </div>
			</div>
			<div class="form-group">
				<label class="col-xs-12 col-sm-2 col-md-2 col-lg-1 control-label"><span class='red'>*</span>规格类型</label>
				<div class="col-xs-12 col-sm-9 col-lg-9">
                    <select name="type" style="width: 15%; height:30px">					
                        <option value="0">请选择</option>
							<?php  if(is_array($type)) { foreach($type as $p) { ?>
								<option value="<?php  echo $p['id'];?>"><?php  echo $p['title'];?></option>
							<?php  } } ?>
					</select>
                </div>
			</div>
			<div class="form-group">
				<label class="col-xs-12 col-sm-2 col-md-2 col-lg-1 control-label"><span class='red'>*</span>具体规格</label>
				<div class="col-sm-4">
					<input class="form-control" required="required" name="total_type" id='total_type' type="text" value="<?php  echo $item['value'];?>">
				</div>
			</div>
			<button type="submit" class="btn btn-primary" name="submit" id='summit_info' value="提交">保存</button>
			<input type="hidden" name="token" value="<?php  echo $_W['token'];?>" />
			</form>
	</div>
</div>
<?php  } ?>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/footer', TEMPLATE_INCLUDEPATH)) : (include template('common/footer', TEMPLATE_INCLUDEPATH));?>
