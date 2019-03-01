<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/header', TEMPLATE_INCLUDEPATH)) : (include template('common/header', TEMPLATE_INCLUDEPATH));?>
<ul class="nav nav-tabs">
	<li <?php  if($op == 'post_first'|| $op == 'edit_first') { ?>class="active"<?php  } ?>><a href="<?php  echo $this->createWebUrl('sort_manager', array('op' => 'post_first'));?>">添加一级分类</a></li>
	<li <?php  if($op == 'display_first') { ?>class="active"<?php  } ?>><a href="<?php  echo $this->createWebUrl('sort_manager', array('op' => 'display_first'));?>">一级分类列表</a></li>
	<li <?php  if($op == 'post'|| $op == 'edit') { ?>class="active"<?php  } ?>><a href="<?php  echo $this->createWebUrl('sort_manager', array('op' => 'post'));?>">添加二级分类</a></li>
	<li <?php  if($op == 'display') { ?>class="active"<?php  } ?>><a href="<?php  echo $this->createWebUrl('sort_manager', array('op' => 'display'));?>">二级分类列表</a></li>
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
					<th>分类编号</th>
					<th>分类名称</th>
					<th>分类图标</th>
					<th>操作</th>
				</tr>
			</thead>
			<tbody>
				<?php  if(is_array($list)) { foreach($list as $item) { ?>
				<tr>
					<td><?php  echo $item['id'];?></td>
					<td><?php  echo $item['cate_title'];?></td>
					<td><img src="http://kake.gangbengkeji.cn/<?php  echo $item['cate_thumb'];?>" style="width: 120px;height: auto;"></td>
					<td>
						<a href="<?php  echo $this->createWebUrl('sort_manager', array('op' => 'edit', 'id'=>$item['id']))?>" title="编辑" class="btn btn-sm btn-default"><i class="fa fa-edit"></i></a>
						<a onclick="return confirm('此操作不可恢复，确认吗？'); return false;" href="<?php  echo $this->createWebUrl('sort_manager', array('op' => 'del','id' => $item['id']))?>" title="删除" class="btn btn-sm btn-danger"><i class="fa fa-remove"></i></a>
					</td>
				</tr>
				<?php  } } ?>
			</tbody>
		</table>
		<?php  echo $pager;?>
	</div>
</div>
<?php  } else if($op == 'display_first') { ?>
<div class="main">
	<div style="padding:15px;background: white;">
		<table class="table table-hover" style="table-layout: initial;">
			<thead class="navbar-inner">
				<tr>
					<th>分类编号</th>
					<th>分类名称</th>
					<th>操作</th>
				</tr>
			</thead>
			<tbody>
				<?php  if(is_array($list1)) { foreach($list1 as $item) { ?>
				<tr>
					<td><?php  echo $item['id'];?></td>
					<td><?php  echo $item['cate_title'];?></td>
					<td>
						<a href="<?php  echo $this->createWebUrl('sort_manager', array('op' => 'edit_first', 'id'=>$item['id']))?>" title="编辑" class="btn btn-sm btn-default"><i class="fa fa-edit"></i></a>
						<a onclick="return confirm('此操作不可恢复，确认吗？'); return false;" href="<?php  echo $this->createWebUrl('sort_manager', array('op' => 'del_first','id' => $item['id']))?>" title="删除" class="btn btn-sm btn-danger"><i class="fa fa-remove"></i></a>
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
				<label class="col-xs-12 col-sm-2 col-md-2 col-lg-1 control-label"><span class='red'>*</span>分类名称</label>
				<div class="col-sm-4">
					<input class="form-control" required="required" name="sort_name" id='sort_name' type="text" value="<?php  echo $second_info['cate_title'];?>">
				</div>
			</div>
			<div class="form-group">
				<label class="col-xs-12 col-sm-2 col-md-2 col-lg-1 control-label"><span class='red'>*</span>
				分类图片</label>
				<div class="col-sm-6">
						<?php  load()->func('tpl');echo tpl_form_field_image('thumb',$second_info['cate_thumb']);?>
				</div>
			</div>
			<div class="form-group">
				<label class="col-xs-12 col-sm-2 col-md-2 col-lg-1 control-label"><span class='red'>*</span>排序权重</label>
				<div class="col-sm-4">
					<input class="form-control" required="required" name="sort_weight" id='sort_weight' type="text" value="<?php  echo $second_info['sort_weight'];?>">
				</div>
			</div>
			<div class="form-group">
				<label class="col-xs-12 col-sm-2 col-md-2 col-lg-1 control-label"><span class='red'>*</span>所属一级分类</label>
				<div class="col-xs-12 col-sm-9 col-lg-9">
                    <select name="sort_type" style="width: 15%; height:30px">					
                        <option value="0">请选择</option>
							<?php  if(is_array($info)) { foreach($info as $p) { ?>
								<option <?php  if($second_info['category'] == $p['id']) { ?>selected="selected"<?php  } ?> value="<?php  echo $p['id'];?>"><?php  echo $p['cate_title'];?></option>
							<?php  } } ?>
					</select>
                </div>
			</div>
			<button type="submit" class="btn btn-primary" name="submit" id='summit_info' value="提交">保存</button>
			<input type="hidden" name="token" value="<?php  echo $_W['token'];?>" />
			</form>
	</div>
</div>

<?php  } else if($op == 'post_first' || $op == 'edit_first') { ?>
<div class="panel panel-info">
		<div class="panel-body">
			<form action="" method="post" class="form-horizontal" role="form">
			<div class="form-group">
				<label class="col-xs-12 col-sm-2 col-md-2 col-lg-1 control-label"><span class='red'>*</span>分类名称</label>
				<div class="col-sm-4">
					<input class="form-control" required="required" name="first_name" id='first_name' type="text" value="<?php  echo $first_info['cate_title'];?>">
				</div>
			</div>
			<div class="form-group">
				<label class="col-xs-12 col-sm-2 col-md-2 col-lg-1 control-label"><span class='red'>*</span>排序权重</label>
				<div class="col-sm-4">
					<input class="form-control" required="required" name="sort_weight" id='sort_weight' type="text" value="<?php  echo $first_info['sort_weight'];?>">
				</div>
			</div>
			<button type="submit" class="btn btn-primary" name="submit" id='summit_info' value="提交">保存</button>
			<input type="hidden" name="token" value="<?php  echo $_W['token'];?>" />
			</form>
	</div>
</div>
<?php  } ?>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/footer', TEMPLATE_INCLUDEPATH)) : (include template('common/footer', TEMPLATE_INCLUDEPATH));?>
