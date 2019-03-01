<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/header', TEMPLATE_INCLUDEPATH)) : (include template('common/header', TEMPLATE_INCLUDEPATH));?>
<ul class="nav nav-tabs">
	<li <?php  if($op == 'display') { ?> class="active" <?php  } ?>><a href="<?php  echo $this->createWebUrl('order',array('op'=>'display'))?>">本期下注</a></li>
	<li <?php  if($op == 'history') { ?> class="active" <?php  } ?>><a href="<?php  echo $this->createWebUrl('order',array('op'=>'history'))?>">往期下注</a></li>
 </ul>
<?php  if($op == 'display') { ?>
<div class="panel">
	<div class="col-xs-12">
		<a href="<?php  echo $this->createWebUrl('order',array('op'=>'display','export'=>'export'))?>" class="btn btn-primary" style="float: right;">导出</a>
	</div>
	<table class="table">
		<thead>
			<tr>
				<td>号码</td>
				<td>下注金额</td>
				<td>预计赔付金额</td>
				<td>下注人数</td>
			</tr>
		</thead>
		<tbody>
			<?php  if(is_array($list)) { foreach($list as $item) { ?>
			<tr>
				<td><?php  echo $item['number'];?></td>
				<td><?php  echo $item['bet_total'];?></td>
				<td><?php  echo $item['pay_award'];?></td>
				<td><?php  echo $item['bet_number'];?></td>
			</tr>
			<?php  } } ?>
		</tbody>
	</table>
	<?php  echo $pager;?>
</div>

<?php  } ?>
<?php  if($op == 'history') { ?>
<form class="form-inline" role="form" action="" method="get">
	<input type="hidden" name="c" value="site">
	<input type="hidden" name="a" value="entry">
	<input type="hidden" name="do" value="order">
	<input type="hidden" name="m" value="manji">
	<div class="panel panel-info">
		<div class="panel-heading">
			筛选
		</div>
		<div class="panel-body">
			<div class="form-group">
				<label for="keyword">关键词</label>
				<input type="text" name="keyword" id="keyword" placeholder="请输入订单号" class="form-control" value="<?php  echo $_GPC['keyword'];?>">
			</div>
			<div class="form-group">
				<input type="submit" name="search" class="btn btn-success" value="搜索">
			</div>
		</div>
	</div>
</form>
<div class="panel">
	<table class="table">
		<thead>
			<tr>
				<td>编号</td>
				<td>订单号</td>
				<td>用户</td>
				<td>期数</td>
				<td>号码</td>
				<td>金额</td>
				<td>操作</td>
			</tr>
		</thead>
		<tbody>
			<?php  if(is_array($list)) { foreach($list as $item) { ?>
			<tr>
				<td><?php  echo $item['id'];?></td>
				<td><?php  echo $item['ordersn'];?></td>
				<td><?php  echo $item['nickname'];?></td>
				<td><?php  echo $item['periods'];?></td>
				<td><?php  echo $item['number'];?></td>
				<td><?php  echo $item['order_amount'];?></td>
				<td>
 				</td>
			</tr>
			<?php  } } ?>
		</tbody>
	</table>
	<?php  echo $pager;?>
</div>
<?php  } ?>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/footer', TEMPLATE_INCLUDEPATH)) : (include template('common/footer', TEMPLATE_INCLUDEPATH));?>