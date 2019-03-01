<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/header', TEMPLATE_INCLUDEPATH)) : (include template('common/header', TEMPLATE_INCLUDEPATH));?>
<ul class="nav nav-tabs">
	<li <?php  if(!$op || $op == 'display') { ?>class="active"<?php  } ?>><a href="<?php  echo $this->createWebUrl('orders', array('op' => 'display'));?>">订单列表</a></li>
	<li <?php  if(!$op || $op == 'display_offline') { ?>class="active"<?php  } ?>><a href="<?php  echo $this->createWebUrl('orders', array('op' => 'display_offline'));?>">线下支付</a></li>
	<!-- <li <?php  if(!$op || $op == 'refound_money') { ?>class="active"<?php  } ?>><a href="<?php  echo $this->createWebUrl('orders', array('op' => 'refund_money'));?>">退款申请</a></li> -->
</ul>
<?php  if($op == 'display') { ?>
<style type="text/css">
	.panel-body .form-group{
		margin-bottom: 5px;
	}
</style>
<form action="<?php  echo $this->createWebUrl('Orders')?>" method="get" class="form-inline" role="form">
<div class="panel panel-primary">
	<div class="panel panel-heading">
		<h3 class="panel-title">精确查询</h3>
	</div>
	<div class="panel panel-body">
		<div class="">
			<div class="form-group">
				<label class="sr-only" for="keyword"></label>
				关键词：<input type="text" class="form-control" id="keyword" placeholder="请输入关键词" value="<?php  echo $_GPC['keyword'];?>" name="keyword">
			</div>
			<input type="hidden" name="c" value="<?php  echo $_GPC['c'];?>">
            <input type="hidden" name="a" value="<?php  echo $_GPC['a'];?>">
            <input type="hidden" name="do" value="<?php  echo $_GPC['do'];?>">
            <input type="hidden" name="eid" value="<?php  echo $_GPC['eid'];?>">
            <input type="hidden" name="act" value="display">
			<input type="submit" class="btn btn-primary" value="查询">
		</div>
	</div>
</div>
</form>
<table class="table table-hover">
	<tr class="info text-center">
		<td>订单编号</td>
		<td>买家id</td>
        <td>数量</td>
        <td>总金额</td>
		<td>状态</td>
		<td>下单时间</td>
		<td>操作</td>
	</tr>
	<?php  if($orders) { ?>
	<?php  if(is_array($orders)) { foreach($orders as $o) { ?>
	<tr class="text-center">
		<td><?php  echo $o['order_sn'];?></td>
		<td><?php  echo $o['user_id'];?></td>
        <td><?php  echo $o['num'];?></td>
        <td><?php  echo $o['price'];?></td>
		<td><?php  echo $o['status'];?></td>
		<td><?php  echo $o['create_time'];?></td>
		<td>
			<input type="button" value="查看详情" class="btn btn-primary" onclick="javascript:window.location='<?php  echo $this->createWebUrl('Orders',array('op'=>'detail','id'=>$o['id']))?>'">
			<input type="button" value="取消订单" class="btn btn-primary" onclick="javascript:window.location='<?php  echo $this->createWebUrl('Orders',array('op'=>'dele','id'=>$o['id']))?>'">
		</td>
	</tr>
	<?php  } } ?>
	<?php  } else { ?>
	<tr>
		<td colspan="7" class="text-center">抱歉，没有相应内容</td>
	</tr>
	<?php  } ?>
</table>
<?php  echo $pager;?>
<?php  } else if($op == 'display_offline') { ?>
<style type="text/css">
	.panel-body .form-group{
		margin-bottom: 5px;
	}
</style>
<form action="<?php  echo $this->createWebUrl('Orders')?>" method="get" class="form-inline" role="form">
<div class="panel panel-primary">
	<div class="panel panel-heading">
		<h3 class="panel-title">精确查询</h3>
	</div>
	<div class="panel panel-body">
		<div class="">
			<div class="form-group">
				<label class="sr-only" for="keyword"></label>
				关键词：<input type="text" class="form-control" id="keyword" placeholder="请输入关键词" value="<?php  echo $_GPC['keyword'];?>" name="keyword">
			</div>
			<input type="hidden" name="c" value="<?php  echo $_GPC['c'];?>">
            <input type="hidden" name="a" value="<?php  echo $_GPC['a'];?>">
            <input type="hidden" name="do" value="<?php  echo $_GPC['do'];?>">
            <input type="hidden" name="eid" value="<?php  echo $_GPC['eid'];?>">
            <input type="hidden" name="act" value="display">
			<input type="submit" class="btn btn-primary" value="查询">
		</div>
	</div>
</div>
</form>
<table class="table table-hover">
	<tr class="info text-center">
		<td>订单编号</td>
		<td>买家id</td>
        <td>数量</td>
        <td>总金额</td>
		<td>状态</td>
		<td>下单时间</td>
		<td>操作</td>
	</tr>
	<?php  if($orders) { ?>
	<?php  if(is_array($orders)) { foreach($orders as $o) { ?>
	<tr class="text-center">
		<td><?php  echo $o['order_sn'];?></td>
		<td><?php  echo $o['user_id'];?></td>
        <td><?php  echo $o['num'];?></td>
        <td><?php  echo $o['price'];?></td>
		<td><?php  echo $o['status'];?></td>
		<td><?php  echo $o['create_time'];?></td>
		<td>
			<input type="button" value="查看详情" class="btn btn-primary" onclick="javascript:window.location='<?php  echo $this->createWebUrl('Orders',array('op'=>'detail','id'=>$o['id']))?>'">
			<input type="button" value="取消订单" class="btn btn-primary" onclick="javascript:window.location='<?php  echo $this->createWebUrl('Orders',array('op'=>'dele','id'=>$o['id']))?>'">
			<input type="button" value="线下支付审核" class="btn btn-primary" onclick="javascript:window.location='<?php  echo $this->createWebUrl('Orders',array('op'=>'offlinepass','id'=>$o['id']))?>'">
		</td>
	</tr>
	<?php  } } ?>
	<?php  } else { ?>
	<tr>
		<td colspan="7" class="text-center">抱歉，没有相应内容</td>
	</tr>
	<?php  } ?>
</table>
<?php  echo $pager;?>
<?php  } else if($op == 'detail') { ?>
<style type="text/css">
	.tb th{
		width: 10%;
		text-align: right;
	}
	.tb td{
		border-top: 1px solid #ddd !important;
	}
</style>
<div class="panel panel-info">
	<div class="panel panel-heading">
		<h3 class="panel-title">订单详情</h3>
	</div>
	<div class="panel panel-body">
		<table class="table table-hover tb">
			<tr>
				<th>订单编号：</th>
				<td><?php  echo $item['order_sn'];?></td>
				<th>下单时间：</th>
				<td><?php  echo $item['create_time'];?></td>
			</tr>
			<tr>
				<th>买家：</th>
				<td><?php  echo $item['realname'];?></td>
				<th>订单类型：</th>
				<td></td>
			</tr>
			<tr>
				<th>商品名称：</th>
				<td><?php  echo $item['goods_name'];?></td>
				<th>收货人：</th>
				<td><?php  echo $item['realname'];?></td>
			</tr>
			<tr>
				<th>联系电话：</th>
				<td><?php  echo $item['mobile'];?></td>
				<th>支付方式：</th>
				<td><?php  echo $item['pay_type'];?></td>
			</tr>
			<tr>
				<th>订单状态：</th>
                <td><?php  echo $item['status'];?></td>
                <?php  if($order['order_type'] == 2 || $order['order_type'] == 3) { ?>
                <th>熬药：</th>
                <td><?php  if($order['need_cook'] == 1) { ?>需要<?php  } else { ?>不需要<?php  } ?></td>
                <?php  } ?>
			</tr>
			<tr>
				<th>留言：</th>
				<td colspan="3"><?php  echo $item['comments'];?></td>
			</tr>
		</table>
	</div>
</div>
<?php  } else if($op == 'refound_order') { ?>
<style type="text/css">
	.panel-body .form-group{
		margin-bottom: 5px;
	}
</style>
<form action="<?php  echo $this->createWebUrl('Orders')?>" method="get" class="form-inline" role="form">
<div class="panel panel-primary">
	<div class="panel panel-heading">
		<h3 class="panel-title">精确查询</h3>
	</div>
	<div class="panel panel-body">
		<div class="">
			<div class="form-group">
				<label class="sr-only" for="keyword"></label>
				关键词：<input type="text" class="form-control" id="keyword" placeholder="请输入关键词" value="<?php  echo $_GPC['keyword'];?>" name="keyword">
			</div>
			
			<input type="hidden" name="c" value="<?php  echo $_GPC['c'];?>">
            <input type="hidden" name="a" value="<?php  echo $_GPC['a'];?>">
            <input type="hidden" name="do" value="<?php  echo $_GPC['do'];?>">
            <input type="hidden" name="eid" value="<?php  echo $_GPC['eid'];?>">
            <input type="hidden" name="act" value="display">
			<input type="submit" class="btn btn-primary" value="查询">
		</div>
	</div>
</div>
</form>
<table class="table table-hover">
	<tr class="info text-center">
		<td>订单号</td>
		<td>买家id</td>
        <td>数量</td>
        <td>总金额</td>
		<td>状态</td>
		<td>下单时间</td>
		<td>操作</td>
	</tr>
	<?php  if($orders) { ?>
	<?php  if(is_array($orders)) { foreach($orders as $o) { ?>
	<tr class="text-center">
		<td><?php  echo $o['id'];?></td>
		<td><?php  echo $o['user_id'];?></td>
        <td><?php  echo $o['num'];?></td>
        <td><?php  echo $o['price'];?></td>
		<td><?php  echo $o['status'];?></td>
		<td><?php  echo $o['create_time'];?></td>
		<td>
			<a href="<?php  echo $this->createWebUrl('bussiness_skill', array('op' => 'edit', 'id'=>$item['bussiness_id'], 'goods_id' => $item['id']))?>" title="编辑" class="btn btn-sm btn-default"><i class="fa fa-edit"></i>131</a>
			<a onclick="return confirm('此操作不可恢复，确认吗？'); return false;" href="<?php  echo $this->createWebUrl('bussiness_skill', array('op' => 'del','id' => $item['id']))?>" title="删除" class="btn btn-sm btn-danger"><i class="fa fa-remove"></i>123131</a>
		</td> 
	</tr>
	<?php  } } ?>
	<?php  } else { ?>
	<tr>
		<td colspan="7" class="text-center">抱歉，没有相应内容</td>
	</tr>
	<?php  } ?>
</table>
<?php  echo $pager;?>
<script src="<?php  echo $_W['siteroot'];?>static/js/Validform_v5.3.2_min.js"></script>
<script type="text/javascript">
	<?php  if($order['order_status'] == 0) { ?>
	var number = 1;
	<?php  } else { ?>
	var number = $('input[name=materials]').val();
	<?php  } ?>
	var option_number = 1;
	$('#add_medicine').click(function() {
			number++;
        	var txt = '';
        	txt += '<tr>';
        	txt += '<td style="position:relative"><select id="goods_id_'+number+'" style="position: absolute;width: 12vw;height: 26px;margin-top:-13px;" onchange="goods_select('+number+')">';
        	txt += "<?php  if(is_array($medicine)) { foreach($medicine as $med) { ?>";
        	txt += '<option value="'+"<?php  echo $med['price'];?>"+'">'+"<?php  echo $med['name'];?>"+'</option>';
        	txt += "<?php  } } ?>";
        	txt += '</select><input type="text" id="goods_name_'+number+'" name="name[]"  style="position: absolute;width: 11vw;margin-top:-13px;" onchange="search_goods('+number+')"></td>';
        	txt += '<td><input type="number" id="goods_number_'+number+'" name="number[]" style="width: 90%;" onchange="price_change('+number+')">&nbsp;g</td>';
        	txt += '<td><input type="text" id="all_price_'+number+'" name="price[]" style="width: 100%;"><input type="hidden" id="goods_price_'+number+'"></td>';
        	txt += '<td><input type="button" class="btn btn-danger" value="删除" id="del_medicine"></td>';
        	txt += '</tr>';
        	$('#medicine_box').append(txt);
        	$('input[id=del_medicine]').click(function() {
	        	$(this).parents('tr').remove();
	        });
        });
	$('input[id=del_medicine]').click(function() {
    	$(this).parents('tr').remove();
    });
	function search_goods(id) {
		var keyword = $('#goods_name_'+id).val();
		$.ajax({
			url:"<?php  echo $this->createWebUrl('search_goods')?>",
			data:{keyword:keyword,id:id},
			success:function(data) {
				var data = $.parseJSON(data);
				console.log(data);
				if (data.status == 1) {
					var txt = '<option value="0">请选择</option>';
					var list = data.list;
					for (var i = 0 in list) {
						txt += '<option value="'+list[i].price+'">'+list[i].name+'</option>';
					}
					$('#search_tips').empty();
					$('#goods_id_'+data.id).empty();
					$('#goods_id_'+data.id).html(txt);
					$('#goods_number_'+data.id).val('');
					$('#all_price_'+data.id).val('');
					return false;
				}
				else{
					
					$('#search_tips').html(data.info);
					return false;
				}
			}
		})
	}
	function goods_select(id) {
		var goods_price = $('#goods_id_'+id).val();
		var goods_name = $('#goods_id_'+id).find('option:selected').text();
		$('#goods_name_'+id).val(goods_name);
		$('#goods_price_'+id).val(goods_price);
		$('#goods_number_'+id).val('');
		$('#all_price_'+id).val('');
	}
	function price_change(obj) {
		var goods_number = $('#goods_number_'+obj).val();
		var price = $('#goods_price_'+obj).val();
		var total = parseInt(goods_number) * parseFloat(price);
		total = parseFloat(total.toFixed(2));
		if (!total) {
			total = 0;
		}
		$('#all_price_'+obj).val(total);
	}
	function price_submit() {
		$('#price_form').submit();
	}
</script>
<?php  } ?>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/footer', TEMPLATE_INCLUDEPATH)) : (include template('common/footer', TEMPLATE_INCLUDEPATH));?>