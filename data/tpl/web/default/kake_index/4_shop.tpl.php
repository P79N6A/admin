<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/header', TEMPLATE_INCLUDEPATH)) : (include template('common/header', TEMPLATE_INCLUDEPATH));?>
<script type="text/javascript" src="resource/js/lib/jquery-ui-1.10.3.min.js"></script>
<ul class="nav nav-tabs">
	<li <?php  if($op == 'display') { ?>class="active"<?php  } ?>><a href="<?php  echo $this->createWebUrl('shop', array('op' => 'display'))?>">门店管理</a></li>
	<li <?php  if($op == 'post') { ?>class="active"<?php  } ?>><a href="<?php  echo $this->createWebUrl('shop', array('op' => 'post'))?>">添加门店</a></li>
</ul>
<?php  if($op == 'display') { ?>
<div class="main">
	<div class="panel panel-info">
	<div class="panel-heading">筛选</div>
	<div class="panel-body">
		<form action="./index.php" method="get" class="form-horizontal" role="form">
			<input type="hidden" name="c" value="site" />
			<input type="hidden" name="a" value="entry" />
			<input type="hidden" name="m" value="kake_index" />
			<input type="hidden" name="do" value="shop" />
			<input type="hidden" name="op" value="display" />
			<div class="form-group">
				<label class="col-xs-12 col-sm-2 col-md-2 col-lg-1 control-label">关键字</label>
				<div class="col-xs-12 col-sm-8 col-lg-9">
					<input class="form-control" name="keyword" id="" type="text" value="<?php  echo $_GPC['keyword'];?>">
				</div>
			</div>

			<div class="form-group">
				<div class="col-xs-12 col-sm-2 col-lg-2">
					<button class="btn btn-default"><i class="fa fa-search"></i> 搜索</button>
				</div>
			</div>

			<div class="form-group">
			</div>
		</form>
	</div>
</div>
<style>
.label{cursor:pointer;}
</style>
<div class="panel panel-default">
	<div class="panel-body table-responsive">
		<table class="table table-hover">
			<thead class="navbar-inner">
				<tr>
					<th style="width:10%;">门店名</th>
					<th style="width: 5%;">联系人</th>
					<th style="width:10%;">联系电话</th>
					<th style="width:25%;">地址</th>
					<th style="text-align:right; width:20%;">操作</th>
				</tr>
			</thead>
			<tbody>
				<?php  if(is_array($list)) { foreach($list as $item) { ?>
				<tr>
					<td><?php  echo $item['name'];?></td>
					<td>
						<?php  echo $item['contacts'];?>
					</td>
					<td>
						<?php  echo $item['phone'];?>
					</td>
					<td>
						<?php  echo $item['province'];?><?php  echo $item['city'];?><?php  echo $item['district'];?><?php  echo $item['address'];?>
					</td>
					<td style="text-align:right;">
						<a href="<?php  echo $this->createWebUrl('shop', array('id' => $item['id'], 'op' => 'post'))?>"class="btn btn-default btn-sm" data-toggle="tooltip" data-placement="top" title="编辑"><i class="fa fa-pencil"></i></a>&nbsp;&nbsp;
						<a href="<?php  echo $this->createWebUrl('shop', array('id' => $item['id'], 'op' => 'delete'))?>" onclick="return confirm('此操作不可恢复，确认删除？');return false;" class="btn btn-default btn-sm" data-toggle="tooltip" data-placement="top" title="删除"><i class="fa fa-times"></i></a>
					</td>
				</tr>
				<?php  } } ?>
			</tbody>
		</table>
		<?php  echo $pager;?>
	</div>
	</div>
</div>
<?php  } else if($op == 'post') { ?>
<div class="main">
	<form action="" method="post" class="form-horizontal form">
		<input type="hidden" name="id" value="<?php  echo $_GPC['id'];?>">
		<div class="panel panel-default">
			<div class="panel-heading">
				<?php  if(empty($id)) { ?>添加门店<?php  } else { ?>编辑门店<?php  } ?>
			</div>
			<div class="panel-body">
				<div class="form-group">
					<label class="col-xs-12 col-sm-3 col-md-2 control-label"><span style='color:red'>*</span>门店名</label>
					<div class="col-sm-9 col-xs-12">
						<input type="text" name="name" id="name" class="form-control" value="<?php  echo $shop['name'];?>" />
					</div>
				</div>
				<div class="form-group">
					<label class="col-xs-12 col-sm-3 col-md-2 control-label">联系人</label>
					<div class="col-sm-9 col-xs-12">
						<input type="text" name="contacts" class="form-control" value="<?php  echo $shop['contacts'];?>">
					</div>
				</div>
				<div class="form-group">
					<label class="col-xs-12 col-sm-3 col-md-2 control-label">地区</label>
					<div class="col-sm-9 col-xs-12">
						<?php  echo tpl_form_field_district('district',array('province'=>$shop['province'],'city'=>$shop['city'],'district'=>$shop['district']));?>
					</div>
				</div>
				<div class="form-group">
					<label class="col-xs-12 col-sm-3 col-md-2 control-label">详细地址</label>
					<div class="col-sm-9 col-xs-12">
						<input type="text" name="address" value="<?php  echo $shop['address'];?>" class="form-control">
					</div>
				</div>
			</div>
		</div>
		<div class="form-group col-sm-12">
			<input type="submit" name="submit" value="保存" class="btn btn-primary col-lg-1" />
			<input type="hidden" name="token" value="<?php  echo $_W['token'];?>" />
		</div>
	</form>
</div>

<?php  } ?>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/footer', TEMPLATE_INCLUDEPATH)) : (include template('common/footer', TEMPLATE_INCLUDEPATH));?>