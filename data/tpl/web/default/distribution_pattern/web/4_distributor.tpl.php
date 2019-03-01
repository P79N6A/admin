<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/header', TEMPLATE_INCLUDEPATH)) : (include template('common/header', TEMPLATE_INCLUDEPATH));?>
<ul class="nav nav-tabs">
	<li <?php  if($op == 'post'|| $op == 'edit') { ?>class="active"<?php  } ?>><a href="<?php  echo $this->createWebUrl('distributor', array('op' => 'post'));?>">添加商家</a></li>
	<li <?php  if(!$op || $op == 'display') { ?>class="active"<?php  } ?>><a href="<?php  echo $this->createWebUrl('distributor', array('op' => 'display'));?>">商家列表</a></li>
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
					<th>分销商编号</th>
					<th>分销商名字</th>
					<th>分销商提成比例</th>
					<th>分销商电话</th>
					<th>入驻时间</th>
					<th>操作</th>
				</tr>
			</thead>
			<tbody>
				<?php  if(is_array($list)) { foreach($list as $item) { ?>
				<tr>
					<td><?php  echo $item['id'];?></td>
					<td><?php  echo $item['realname'];?></td>
					<td><?php  echo $item['ratio'];?></td>
					<td><?php  echo $item['mobile'];?></td>
					<td><?php  echo $item['create_time'];?></td>
					<td>
						<a href="<?php  echo $this->createWebUrl('bussiness_skill', array('op' => 'post','id' => $item['id'],'name' => $item['name']))?>" title="添加技能" class="btn btn-sm btn-warning"><i class="fa fa-war">添加技能</i></a>
						<a href="<?php  echo $this->createWebUrl('bussiness', array('op' => 'edit', 'id' => $item['id']))?>" title="编辑" class="btn btn-sm btn-default"><i class="fa fa-edit"></i></a>
						<a onclick="return confirm('此操作不可恢复，确认吗？'); return false;" href="<?php  echo $this->createWebUrl('bussiness', array('op' => 'del','id' => $item['id']))?>" title="删除" class="btn btn-sm btn-danger"><i class="fa fa-remove"></i></a>
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
				<label class="col-xs-12 col-sm-2 col-md-2 col-lg-1 control-label"><span class='red'>*</span>
				分销商id</label>
				<div class="col-sm-3">
					<input class="form-control" required="required" name="name" id='name' type="text" value="<?php  echo $item['name'];?>">
				</div>
			</div>
			<div class="form-group">
				<label class="col-xs-12 col-sm-2 col-md-2 col-lg-1 control-label"><span class='red'>*</span>
				分销等级</label>
				<div class="col-sm-3">
					<input class="form-control" required="required" name="name" id='name' type="text" value="<?php  echo $item['name'];?>">
				</div>
			</div>
			<div class="form-group">
				<label class="col-xs-12 col-sm-2 col-md-2 col-lg-1 control-label"><span class='red'>*</span>
				分销抽成</label>
				<div class="col-sm-3">
					<input class="form-control" required="required" name="name" id='name' type="text" value="<?php  echo $item['name'];?>">
				</div>
			</div>
			<div class="form-group">
				<label class="col-xs-12 col-sm-2 col-md-2 col-lg-1 control-label"><span class='red'>*</span>联系电话</label>
				<div class="col-sm-6">
					<input class="form-control" required="required" name="mobile" id='mobile' type="text" value="<?php  echo $item['mobile'];?>">
				</div>
			</div>
			<button type="submit" class="btn btn-primary" name="submit" id='summit_info' value="提交">保存</button>
			<input type="hidden" name="token" value="<?php  echo $_W['token'];?>" />
			</form>
	</div>
</div>
<script>
$(function(){
	$("#summit_info").click(function(){
		});
	});
	
</script>

<?php  } ?>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/footer', TEMPLATE_INCLUDEPATH)) : (include template('common/footer', TEMPLATE_INCLUDEPATH));?>
