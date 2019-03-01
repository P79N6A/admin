<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/header', TEMPLATE_INCLUDEPATH)) : (include template('common/header', TEMPLATE_INCLUDEPATH));?>
<ul class="nav nav-tabs">
	<li <?php  if($op == 'display') { ?>class="active"<?php  } ?>><a href="<?php  echo $this->createWebUrl('income');?>">收入列表</a></li>
</ul>
<?php  if($op == 'display') { ?>
<div class="main">
	<form action="" method="post" class="form-horizontal" role="form">
		<div class="panel panel-info">
	        <div class="panel-heading">筛选</div>
	        <div class="panel-body">
                <div class="form-group">
                    <label class="col-xs-12 col-sm-2 col-md-2 col-lg-1 control-label">礼物名称</label>
                    <div class="col-xs-12 col-sm-9 col-lg-9">
                        <input type="text" name="keyword" class="form-control" value="<?php  echo $_GPC['keyword'];?>">
                    </div>
                    <div class=" col-xs-12 col-sm-2 col-lg-2">
                        <button class="btn btn-default" ><i class="fa fa-search"></i> 搜索</button>
                   	</div>
                </div>
	        </div>
	    </div>
	</form>
	<div style="padding:15px;background: white;">
		<table class="table table-hover" style="table-layout: initial;">
			<thead class="navbar-inner">
				<tr>
               		<th>ID</th>
					<th>排序</th>
					<th>礼物名称</th>
					<th>房间ID</th>
					<th>小图片</th>
					<th>图片</th>
					<th>金额</th>
					<th>经验值</th>
					<th>贡献值</th>
					<th>魅力值</th>
					<th>特效等级</th>
					<th>操作</th>
				</tr>
			</thead>
			<tbody>
				<?php  if(is_array($list)) { foreach($list as $item) { ?>
				<tr>
                	<td><?php  echo $item['id'];?></td>
					<td><?php  echo $item['sort'];?></td>
					<td><?php  echo $item['gift_name'];?></td>
					<td><?php  echo $item['room_id'];?></td>
					<td><img src="/attachment/<?php  echo $item['thumb'];?>" style="width: 40px;height: auto;"></td>
					<td><img src="/attachment/<?php  echo $item['photo'];?>" style="width: 40px;height: auto;"></td>
					<td><?php  echo $item['price'];?></td>
					<td><?php  echo $item['exp_value'];?></td>
					<td><?php  echo $item['devote_value'];?></td>
					<td><?php  echo $item['charm_value'];?></td>
				</tr>
				<?php  } } ?>
			</tbody>
		</table>
		<?php  echo $pager;?>
	</div>
</div>
<?php  } ?>
<script type="text/javascript">

</script>
<?php  } ?>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/footer', TEMPLATE_INCLUDEPATH)) : (include template('common/footer', TEMPLATE_INCLUDEPATH));?>