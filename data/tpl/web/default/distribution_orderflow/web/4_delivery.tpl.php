<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/header', TEMPLATE_INCLUDEPATH)) : (include template('common/header', TEMPLATE_INCLUDEPATH));?>
<ul class="nav nav-tabs">
	<li <?php  if(!$op || $op == 'display') { ?>class="active"<?php  } ?>><a href="<?php  echo $this->createWebUrl('delivery', array('op' => 'display'));?>">待发货列表</a></li>
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
<form action="" method="get" class="form-horizontal" role="form">
<div class="panel panel-info">
        <div class="panel-body">
                <input type="hidden" name="c" value="site" />
                <input type="hidden" name="a" value="entry" />
                <input type="hidden" name="m" value="distribution_orderflow" />
                <input type="hidden" name="do" value="delivery" />
                <div class="form-group">
                    <label class="col-xs-12 col-sm-2 col-md-2 col-lg-1 control-label">关键字</label>
                    <div class="col-xs-12 col-sm-9 col-lg-9">
                        <input class="form-control" name="keyword" id="keyword" type="text" value="<?php  echo $_GPC['keyword'];?>" placeholder="请输入用户id">
                    </div>
                </div>
                <div class="form-group">
                	<label class="col-xs-12 col-sm-2 col-md-2 col-lg-1 control-label"></label>
                    <div class=" col-xs-12 col-sm-2 col-lg-2">
                        <button class="btn btn-default" ><i class="fa fa-search"></i>搜索</button>
                   	</div>
                </div>
        </div>
    </div>
</form>
	<div style="padding:15px;background: white;">
		<table class="table table-hover" style="table-layout: initial;">
			<thead class="navbar-inner">
				<tr>
					<th>用户id</th>
					<th>用户姓名</th>
					<th>下单时间</th>
					<th>订单金额</th>
					<th>操作</th>
				</tr>
			</thead>
			<tbody>
				<?php  if(is_array($list)) { foreach($list as $item) { ?>
				<tr>
					<td><?php  echo $item['user_id'];?></td>
					<td><?php  echo $item['realname'];?></td>
					<td><?php  echo $item['create_time'];?></td>
					<td><?php  echo $item['price'];?></td>
					<td>
						<a href="<?php  echo $this->createWebUrl('delivery', array('op' => 'send_goods','id' => $item['id']))?>" title="发货" class="btn btn-sm btn-info">发货<i class="fa fa-edit"></i></a>
						<a onclick="return confirm('此操作不可恢复，确认吗？'); return false;" href="<?php  echo $this->createWebUrl('delivery', array('op' => 'del','id' => $item['id']))?>" title="删除" class="btn btn-sm btn-danger">删除<i class="fa fa-remove"></i></a>
					</td>
				</tr>
				<?php  } } ?>
			</tbody>
		</table>
		<?php  echo $pager;?>
	</div>
</div>
<?php  } else if($op == 'send_goods') { ?>
<div class="panel panel-info">
		<div class="panel-body">
			<form action="<?php  echo $this->createWebUrl('delivery', array('op' => 'send_goods','id' => $item['id']))?>" method="post" class="form-horizontal" role="form">
			<div class="form-group">
				<label class="col-xs-12 col-sm-2 col-md-2 col-lg-1 control-label">订单id</label>
				<div class="col-sm-3">
					<input class="form-control" name="order_id" id='order_id' type="text" min="0" value="<?php  echo $item['id'];?>">
				</div>
			</div>
			<div class="form-group">
				<label class="col-xs-12 col-sm-2 col-md-2 col-lg-1 control-label">快递单号</label>
				<div class="col-sm-3">
					<input class="form-control" name="order_sn" id='order_sn' type="text" min="0" value="">
				</div>
			</div>
			<div class="col-xs-12 col-sm-9 col-lg-9">
                <select name="express_id" style="width: 15%; height:30px">					
                    <option value="0">请选择</option>
					<?php  if(is_array($selectlist)) { foreach($selectlist as $p) { ?>
					<option value="<?php  echo $p['express_id'];?>"><?php  echo $p['express_name'];?></option>
					<?php  } } ?>
				</select>
            </div>
            <div class="col-sm-3">
					<button type="submit" class="btn btn-primary" name="submit" id='summit_info' value="提交">发货</button>
			</div>
			</form>
		</div>
</div>
<?php  } ?>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/footer', TEMPLATE_INCLUDEPATH)) : (include template('common/footer', TEMPLATE_INCLUDEPATH));?>
