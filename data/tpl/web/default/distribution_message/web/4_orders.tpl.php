<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/header', TEMPLATE_INCLUDEPATH)) : (include template('common/header', TEMPLATE_INCLUDEPATH));?>
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
		<td>订单号</td>
		<td>买家</td>
		<td>服务类别</td>
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
		<td><?php  echo $o['nickname'];?></td>
		<td><?php  echo $o['bussiness_skill_name'];?></td>
        <td><?php  echo $o['amount'];?></td>
        <td><?php  echo $o['bussiness_skill_total_money'];?></td>
		<td><?php  echo $o['status'];?></td>
		<td><?php  echo $o['add_time'];?></td>

		<td>
			<input type="button" value="查看详情" class="btn btn-primary" onclick="javascript:window.location='<?php  echo $this->createWebUrl('Orders',array('op'=>'detail','id'=>$o['id']))?>'">
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
				<td><?php  echo $order['order_sn'];?></td>
				<th>下单时间：</th>
				<td><?php  echo date('Y-m-d,H:m:s',$order['add_time'])?></td>
			</tr>
			<tr>
				<th>买家：</th>
				<td><?php  echo $order['buyer'];?></td>
				<th>订单类型：</th>
				<td><?php  if($order['order_type'] == 1) { ?>商城订单<?php  } else if($order['order_type'] == 2) { ?>处方订单<?php  } else if($order['order_type'] == 3) { ?>拍照订单<?php  } ?></td>
			</tr>
			<tr>
				<th>地址：</th>
				<td><?php  echo $order['province'];?><?php  echo $order['city'];?><?php  echo $order['district'];?><?php  echo $order['address'];?></td>
				<th>收货人：</th>
				<td><?php  echo $order['resiver'];?></td>
			</tr>
			<tr>
				<th>联系电话：</th>
				<td><?php  echo $order['phone'];?></td>
				<th>支付方式：</th>
				<td><?php  if($order['payment'] == 1) { ?>货到付款<?php  } else if($order['payment'] == 2) { ?>微信支付<?php  } else if($order['payment'] == 3) { ?>签约划账<?php  } else { ?>未选择<?php  } ?></td>
			</tr>
			<tr>
				<th>订单状态：</th>
                <td><?php  echo $order['status'];?></td>
                <?php  if($order['order_type'] == 2 || $order['order_type'] == 3) { ?>
                <th>熬药：</th>
                <td><?php  if($order['need_cook'] == 1) { ?>需要<?php  } else { ?>不需要<?php  } ?></td>
                <?php  } ?>
			</tr>
			<?php  if($order['order_type'] == 2 || $order['order_type'] == 3) { ?>
			<tr>
				<th>优质药材：</th>
				<td><?php  if($order['nice'] == 1) { ?>需要<?php  } else { ?>不需要<?php  } ?></td>
				<th>熬药数量：</th>
				<td><?php  echo $order['cook_number'];?></td>
			</tr>
			<tr>
				<th>是否需要发票：</th>
				<td><?php  if($order['is_bill'] == 1) { ?>需要<?php  } else { ?>不需要<?php  } ?></td>
				<th>发票抬头：</th>
				<td><?php  echo $order['bill_top'];?></td>
			</tr>
			<?php  } ?>
			<?php  if($order['shipping_status'] >= 1) { ?>
			<tr>
				<th>快递名称：</th>
				<td><?php  echo $order['express'];?></td>
				<th>快递单号：</th>
				<td><?php  echo $order['shipping_sn'];?></td>
			</tr>
			<?php  } ?>
			<tr>
				<th>留言：</th>
				<td colspan="3"><?php  echo $order['remark'];?></td>
			</tr>
		</table>
		<table>
			<tr>
				<td>
					<?php  if($order['status'] == 1) { ?>
					<input type="button" name="cencal" value="取消订单" class="btn btn-danger" data-toggle="modal" data-target="#cancel_order">
					<?php  } ?>
					<div class="modal fade" id="cancel_order" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
					    <div class="modal-dialog">
					        <div class="modal-content">
					            <div class="modal-header">
					                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					                <h4 class="modal-title" id="myModalLabel">取消订单</h4>
					            </div>
					            <form action="<?php  echo $this->createWebUrl('orders',array('op'=>'refund_order','id'=>$order['id']))?>" method="post">
					            	<div class="modal-body">
						            	确定取消该订单吗？
						            </div>
						            <div class="modal-footer">
						                <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
						                <button type="submit" class="btn btn-primary">确定</button>
						            </div>
					            </form>
					        </div><!-- /.modal-content -->
					    </div><!-- /.modal -->
					</div>
				</td>
			</tr>
		</table>
	</div>
</div>
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