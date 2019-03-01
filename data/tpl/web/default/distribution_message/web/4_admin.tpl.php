<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/header', TEMPLATE_INCLUDEPATH)) : (include template('common/header', TEMPLATE_INCLUDEPATH));?>
<ul class="nav nav-tabs">
	<li <?php  if($op == 'post') { ?>class="active"<?php  } ?>><a href="<?php  echo $this->createWebUrl('admin', array('op' => 'post'));?>">添加管理员</a></li>
	<li <?php  if(!$op || $op == 'display') { ?>class="active"<?php  } ?>><a href="<?php  echo $this->createWebUrl('admin', array('op' => 'display'));?>">管理员列表</a></li>
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
					<th>管理员编号</th>
					<th>管理员昵称</th>
					<th>管理员电话</th>
				</tr>
			</thead>
			<tbody>
				<?php  if(is_array($list)) { foreach($list as $item) { ?>
				<tr>
					<td><?php  echo $item['id'];?></td>
					<td><?php  echo $item['nickname'];?></td>
					<td><?php  echo $item['mobile'];?></td>
					<td>
						<a href="<?php  echo $this->createWebUrl('admin', array('op' => 'edit', 'id' => $item['id']))?>" title="编辑" class="btn btn-sm btn-default"><i class="fa fa-edit"></i></a>
						<a onclick="return confirm('此操作不可恢复，确认吗？'); return false;" href="<?php  echo $this->createWebUrl('admin', array('op' => 'del','id' => $item['id']))?>" title="删除" class="btn btn-sm btn-danger"><i class="fa fa-remove"></i></a>
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
            <input type="hidden" name="openid" value="<?php  echo $item['openid'];?>">
			<div class="form-group">
				<label class="col-xs-12 col-sm-2 col-md-2 col-lg-1 control-label"><span class='red'>*</span>管理员昵称</label>
				<div class="col-sm-9">
					<input class="form-control" required="required" name="keyword" id='keyword' type="text" value="<?php  echo $item['nickname'];?>">
                    <input class="form-control" required="required" type="button" onclick="find_admin()" value="搜索">
				</div>
			</div>
			<div class="form-group">
				<label class="col-xs-12 col-sm-2 col-md-2 col-lg-1 control-label">选择用户<?php  if(empty($id)) { ?>(搜索后选项出现)<?php  } ?></label>
				<div class="col-sm-4">
				<?php  if($id) { ?>
					<select class="form-control" disabled="disabled">
						<option value="<?php  echo $info['nickname'];?>" selected="selected"><?php  echo $item['nickname'];?></option>
					</select>
					<input type="hidden" name="user_id" value="<?php  echo $item['user_id'];?>">
				<?php  } else { ?>
					<select name="openid" id="openid" class="form-control">
						<option>请选择</option>
					</select>
				<?php  } ?>
				</div>
			</div>

			<div class="form-group">
				<label class="col-xs-12 col-sm-2 col-md-2 col-lg-1 control-label"><span class='red'>*</span>管理员电话</label>
				<div class="col-sm-9">
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
<script type="text/javascript">
	function find_admin() {
		var keyword = $('#keyword').val();

		$.ajax({
			url:"<?php  echo $this->createWebUrl('admin',array('op'=>'find_admin'))?>",
			type:'POST',
			data:{keyword:keyword},
			success:function(data) {
				var data = $.parseJSON(data);
				console.log(data);
				var txt = '<option>请选择</option>';
				for(var i=0 in data){
					txt += '<option value="'+data[i].openid+'">' ;
					txt += data[i].nickname + '</option>';
				$("#openid").empty().html(txt);
				}
			}
		})
	}
</script>
<?php  } ?>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/footer', TEMPLATE_INCLUDEPATH)) : (include template('common/footer', TEMPLATE_INCLUDEPATH));?>
