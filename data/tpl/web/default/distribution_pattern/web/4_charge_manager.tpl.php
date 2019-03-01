<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/header', TEMPLATE_INCLUDEPATH)) : (include template('common/header', TEMPLATE_INCLUDEPATH));?>
<ul class="nav nav-tabs">
	<li <?php  if($op == 'income_display') { ?>class="active"<?php  } ?>><a href="<?php  echo $this->createWebUrl('charge_manager', array('op' => 'income_display'));?>">流水分析</a></li>
	<li <?php  if($op == 'display') { ?>class="active"<?php  } ?>><a href="<?php  echo $this->createWebUrl('charge_manager', array('op' => 'display'));?>">团队列表</a></li>
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
					<th>用户id</th>
					<th>用户昵称</th>
					<th>用户姓名</th>
				</tr>
			</thead>
			<tbody>
				<?php  if(is_array($list)) { foreach($list as $item) { ?>
				<tr>
					<td><?php  echo $item['user_id'];?></td>
					<td><?php  echo $item['nickname'];?></td>
					<td><?php  echo $item['realname'];?></td>
				
				<!-- 	<td>
						<a href="<?php  echo $this->createWebUrl('goods_manager', array('op' => 'edit', 'goods_id' => $item['goods_id']))?>" title="编辑" class="btn btn-sm btn-default"><i class="fa fa-edit"></i></a>
						<a onclick="return confirm('此操作不可恢复，确认吗？'); return false;" href="<?php  echo $this->createWebUrl('goods_manager', array('op' => 'del','goods_id' => $item['goods_id']))?>" title="删除" class="btn btn-sm btn-danger"><i class="fa fa-remove"></i></a>
					</td> -->
				</tr>
				<?php  } } ?>
			</tbody>
		</table>
		<?php  echo $pager;?>
	</div>
</div>
<?php  } else if(!$op ||  $op == 'income_display') { ?>
<div class="panel panel-info">
	<div class="panel-heading">
		<h3 class="panel-title">流水概况</h3>
	</div>
	<div class="panel-body">
		<form action="<?php  echo $this->createWebUrl('site_data');?>" class="form-inline" role="form" method="get">
			<div class="form-group">
				开始日期:
				<?php  echo tpl_form_field_date('stime',$stime);?>
				结束日期:
				<?php  echo tpl_form_field_date('etime',$etime);?>
				<!--c=site&a=entry&eid=181-->
				<input type="hidden" name="c" value="<?php  echo $_GPC['c'];?>">
				<input type="hidden" name="a" value="<?php  echo $_GPC['a'];?>">
				<input type="hidden" name="do" value="<?php  echo $_GPC['do'];?>">
				<input type="hidden" name="m" value="<?php  echo $_GPC['m'];?>">
				<input type="hidden" name="op" value="income_display">
				<input type="submit" value="查询" class="btn btn-info">
			</div>
			<table class="table table-bordered">
				<tr class="active">
					<td>日期</td>
					<td>总注册用户</td>
					<!-- <td>每日新注册</td>
					<td>每日登录</td>
					<td>每日付费用户数</td> -->
					<td>支付购买订单数</td>
					<td>申请退款数</td>
					<td>支付订单流水</td>
					<!-- <td>礼物流水</td> -->
					<td>充值余额流水</td>
					<td>消费流水</td>
				</tr>
				<?php  if(is_array($list)) { foreach($list as $item) { ?>
				<tr>
					<td><?php  echo $item['stime_formated'];?></td>
					<td><?php  echo $item['all_member'];?></td>
					<!-- <td><?php  echo $item['registar_all'];?></td>
					<td><?php  echo $item['login_all'];?></td>
					<td><?php  echo $item['user_pay'];?></td> -->
					<td><?php  echo $item['order_ok'];?></td>
					<td><?php  echo $item['refund_com'];?></td>
					<td><?php  echo $item['order_common'];?></td>
					<!-- <td><?php  echo $item['gift_common'];?></td> -->
					<td><?php  echo $item['recharge_com'];?></td>
					<td><?php  echo $item['cash'];?></td>
				</tr>
				<?php  } } ?>
			</table>
		</form>
	</div>
</div>
<?php  } else if($op == 'post' || $op == 'edit') { ?>
<div class="panel panel-info">
		<div class="panel-body">
			<form action="" method="post" class="form-horizontal" role="form">
			<input type="hidden" name="id" value="<?php  echo $item['id'];?>">
			<div class="form-group">
				<label class="col-xs-12 col-sm-2 col-md-2 col-lg-1 control-label"><span class='red'>*</span>商品名称</label>
				<div class="col-sm-9">
					<input class="form-control" required="required" name="goods_name" id='goods_name' type="text" value="<?php  echo $item['goods_name'];?>">
				</div>
			</div>
			<div class="form-group">
				<label class="col-xs-12 col-sm-2 col-md-2 col-lg-1 control-label"><span class='red'>*</span>商品价格</label>
				<div class="col-sm-9">
					<input class="form-control" required="required" name="goods_price" id='goods_price' type="text" value="<?php  echo $item['goods_price'];?>">
				</div>
			</div>
			<div class="form-group">
				<label class="col-xs-12 col-sm-2 col-md-2 col-lg-1 control-label"><span class='red'>*</span>是否上架</label>
				<div class="col-sm-9">
					<label>
						<input type="radio" name="status" value="0" <?php  if($room['tag'] == 0) { ?>checked="checked"<?php  } ?>>否
					</label>
					<label>
						<input type="radio" name="status" value="1" <?php  if($room['tag'] == 1) { ?>checked="checked"<?php  } ?>>是
					</label>
				</div>
			</div>
			<div class="form-group">
				<label class="col-xs-12 col-sm-2 col-md-2 col-lg-1 control-label"><span class='red'>*</span>商品分类</label>
				<div class="col-xs-12 col-sm-9 col-lg-9">
                    <select name="goods_type" style="width: 15%; height:30px">					
                        <option value="0">请选择</option>
							<?php  if(is_array($store_type)) { foreach($store_type as $p) { ?>
								<option value="<?php  echo $p['id'];?>"><?php  echo $p['cate_title'];?></option>
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
			<button type="submit" class="btn btn-primary" name="submit" id='summit_info' value="提交">保存</button>
			<input type="hidden" name="token" value="<?php  echo $_W['token'];?>" />
			</form>
	</div>
</div>
<?php  } ?>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/footer', TEMPLATE_INCLUDEPATH)) : (include template('common/footer', TEMPLATE_INCLUDEPATH));?>
