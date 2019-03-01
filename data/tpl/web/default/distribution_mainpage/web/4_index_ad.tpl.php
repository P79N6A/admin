<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/header', TEMPLATE_INCLUDEPATH)) : (include template('common/header', TEMPLATE_INCLUDEPATH));?>
<ul class="nav nav-tabs">
	<li <?php  if($op == 'add'||$op == 'edit' ) { ?>class="active"<?php  } ?>><a href="<?php  echo $this->createWebUrl('index_ad', array('op' => 'add'));?>">添加广告</a></li>
	<li <?php  if(!$op || $op == 'display' ) { ?>class="active"<?php  } ?>><a href="<?php  echo $this->createWebUrl('index_ad', array('op' => 'display'));?>">广告列表</a></li>
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
<?php  if($op == 'display') { ?>
<div class="main">
	<div style="padding:15px;background: white;">
		<table class="table table-hover" style="table-layout: initial;">
			<thead class="navbar-inner">
				<tr>
					<th>序号</th>
					<th>广告名称</th>
					<th>广告图片</th>
					<th>广告链接</th>
					<th>操作</th>
				</tr>
			</thead>
			<tbody>
				<?php  if(is_array($list)) { foreach($list as $item) { ?>
				<tr>
					<td><?php  echo $item['id'];?></td>
					<td><?php  echo $item['name'];?></td>
					<td><img src="http://kake.gangbengkeji.cn/<?php  echo $item['thumb'];?>" style="width: 120px;height: auto;"></td>
					<td><?php  echo $item['url'];?></td>
					<td>
						<a href="<?php  echo $this->createWebUrl('index_ad', array('op' => 'edit', 'id' => $item['id']))?>" title="编辑" class="btn btn-sm btn-default"><i class="fa fa-edit"></i></a>
						<a onclick="return confirm('此操作不可恢复，确认吗？'); return false;" href="<?php  echo $this->createWebUrl('index_ad', array('op' => 'del_ad','id' => $item['id']))?>" title="删除" class="btn btn-sm btn-danger"><i class="fa fa-remove"></i></a>
					</td>
				</tr>
				<?php  } } ?>
			</tbody>
		</table>
		<?php  echo $pager;?>
	</div>
</div>
<?php  } ?>
<?php  if($op == 'add'  ||$op == 'edit') { ?>
<div class="panel panel-info">
		<div class="panel-body">
			<form action="<?php  echo $this->createWebUrl('index_ad',array('op'=>'post'))?>" method="post" class="form-horizontal" role="form">
			<input type="hidden" name="id" value="<?php  echo $item['id'];?>">
				<div class="form-group">
					<label class="col-xs-12 col-sm-2 col-md-2 col-lg-1 control-label"><span class='red'>*</span>名称</label>
					<div class="col-sm-9">
						<input class="form-control" required="required" name="name" id='name' type="text" value="<?php  echo $item['name'];?>">
					</div>
				</div>

				<div class="form-group">
					<label class="col-xs-12 col-sm-2 col-md-2 col-lg-1 control-label"><span class='red'>*</span>描述</label>
					<div class="col-sm-9">
						<textarea class="form-control" required="required" name="content" id='content'  > <?php  echo $item['content'];?></textarea>
					</div>
				</div>
				<div class="form-group">
					<label class="col-xs-12 col-sm-2 col-md-2 col-lg-1 control-label"><span class='red'>*</span>图片</label>
					<div class="col-sm-6">
						<?php  load()->func('tpl');echo tpl_form_field_image('image',$item['image']);?>
					</div>
				</div>

				<div class="form-group">
					<label class="col-xs-12 col-sm-2 col-md-2 col-lg-1 control-label"><span class='red'>*</span>缩略图(大小小于32k)</label>
					<div class="col-sm-6">
						<?php  load()->func('tpl');echo tpl_form_field_image('thumb',$item['thumb'] );?>
					</div>
				</div>
				<div class="form-group">
					<label class="col-xs-12 col-sm-2 col-md-2 col-lg-1 control-label"><span class='red'>*</span>跳转地址</label>
					<div class="col-sm-9">
						<input class="form-control" required="required" name="url" id='url' type="text" value="<?php  echo $item['url'];?>">
					</div>
				</div>
				<!-- <div class="form-group">
					<label class="col-xs-12 col-sm-2 col-md-2 col-lg-1 control-label"><span class='red'>*</span>分享地址</label>
					<div class="col-sm-9">
						<input class="form-control" required="required" name="share_url" id='share_url' type="text" value="<?php  echo $item['url'];?>">
					</div>
				</div> -->
			<button type="submit" class="btn btn-primary" name="submit" id='summit_info' value="提交">保存</button>
			<input type="hidden" name="token" value="<?php  echo $_W['token'];?>" />
			</form>
	</div>
</div>
<?php  } ?>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/footer', TEMPLATE_INCLUDEPATH)) : (include template('common/footer', TEMPLATE_INCLUDEPATH));?>
