<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/header', TEMPLATE_INCLUDEPATH)) : (include template('common/header', TEMPLATE_INCLUDEPATH));?>
<ul class="nav nav-tabs">
	<li <?php  if($op == 'post'|| $op == 'edit') { ?>class="active"<?php  } ?>><a href="<?php  echo $this->createWebUrl('goods_manager', array('op' => 'post'));?>">添加商品</a></li>
	<li <?php  if($op == 'display') { ?>class="active"<?php  } ?>><a href="<?php  echo $this->createWebUrl('goods_manager', array('op' => 'display'));?>">商品列表</a></li>
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
					<th>商品价格</th>
					<th>商品名称</th>
					<th>上架状态</th>
					<th>添加时间</th>
					<th>下单量</th>
					<th>操作</th>
				</tr>
			</thead>
			<tbody>
				<?php  if(is_array($list)) { foreach($list as $item) { ?>
				<tr>
					<td><?php  echo $item['goods_id'];?></td>
					<td><?php  echo $item['goods_price'];?></td>
					<td><?php  echo $item['goods_name'];?></td>
					<td><?php  echo $item['status'];?></td>
					<td><?php  echo $item['create_time'];?></td>
					<td><?php  echo $item['order_num'];?></td>
					<td>
						<a href="<?php  echo $this->createWebUrl('goods_manager', array('op' => 'edit', 'goods_id' => $item['goods_id']))?>" title="编辑" class="btn btn-sm btn-default"><i class="fa fa-edit"></i></a>
						<a onclick="return confirm('此操作不可恢复，确认吗？'); return false;" href="<?php  echo $this->createWebUrl('goods_manager', array('op' => 'del','goods_id' => $item['goods_id']))?>" title="删除" class="btn btn-sm btn-danger"><i class="fa fa-remove"></i></a>
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
				<label class="col-xs-12 col-sm-2 col-md-2 col-lg-1 control-label"><span class='red'>*</span>商品名称</label>
				<div class="col-sm-5">
					<input class="form-control" required="required" name="goods_name" id='goods_name' type="text" value="<?php  echo $item['goods_name'];?>">
				</div>
			</div>
			<div class="form-group">
				<label class="col-xs-12 col-sm-2 col-md-2 col-lg-1 control-label"><span class='red'>*</span>商品价格</label>
				<div class="col-sm-5">
					<input class="form-control" required="required" name="goods_price" id='goods_price' type="text" value="<?php  echo $item['goods_price'];?>">
				</div>
			</div>
			<div class="form-group">
				<label class="col-xs-12 col-sm-2 col-md-2 col-lg-1 control-label"><span class='red'>*</span>商品单位</label>
				<div class="col-sm-5">
					<input class="form-control" required="required" name="goods_unit" id='goods_unit' type="text" value="<?php  echo $item['unit'];?>">
				</div>
			</div>
			<div class="form-group">
				<label class="col-xs-12 col-sm-2 col-md-2 col-lg-1 control-label"><span class='red'>*</span>是否上架</label>
				<div class="col-sm-9">
					<label>
						<input type="radio" name="status" value="0" <?php  if($item['status'] == 0) { ?>checked="checked"<?php  } ?>>否
					</label>
					<label>
						<input type="radio" name="status" value="1" <?php  if($item['status'] == 1) { ?>checked="checked"<?php  } ?>>是
					</label>
				</div>
			</div>
			<div class="form-group">
				<label class="col-xs-12 col-sm-2 col-md-2 col-lg-1 control-label"><span class='red'>*</span>商品二级分类</label>
				<div class="col-xs-12 col-sm-9 col-lg-9">
                    <select name="goods_type" style="width: 15%; height:30px">					
                        <option value="0">请选择</option>
							<?php  if(is_array($second_type)) { foreach($second_type as $p) { ?>
								<option <?php  if($item['goods_type'] == $p['id']) { ?>selected="selected"<?php  } ?> value="<?php  echo $p['id'];?>"><?php  echo $p['cate_title'];?></option>
							<?php  } } ?>
					</select>
                </div>
			</div>
			<div class="form-group">
				<label class="col-xs-12 col-sm-2 col-md-2 col-lg-1 control-label"><span class='red'>*</span>
				商品图片</label>
				<div class="col-sm-6">
					<?php  load()->func('tpl');echo tpl_form_field_image('thumb',$item['thumb']);?>
				</div>
			</div>
			<div class="form-group">
				<label class="col-xs-12 col-sm-2 col-md-2 col-lg-1 control-label"><span class='red'>*</span>
				商品详情</label>
				<div class="col-sm-6">
					<?php  echo tpl_ueditor('info',$item['info'])?>
				</div>
			</div>
			<button type="submit" class="btn btn-primary" name="submit" id='summit_info' value="提交">保存</button>
			<input type="hidden" name="token" value="<?php  echo $_W['token'];?>" />
			</form>
	</div>
</div>
<?php  } ?>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/footer', TEMPLATE_INCLUDEPATH)) : (include template('common/footer', TEMPLATE_INCLUDEPATH));?>
