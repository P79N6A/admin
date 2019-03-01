<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('header', TEMPLATE_INCLUDEPATH)) : (include template('header', TEMPLATE_INCLUDEPATH));?>
<style type="text/css">
	#input-type>tbody>tr>td,#order_detail>tbody>tr>td{border: 0;}
	.btn{border: 1px solid #3e3e3e;background-color: #3e3e3e;border-radius: 20px;color: #fff;padding: 3px 7px;margin-right: 10px;}
	.col-xs-12{padding: 5px 8px;}
	.order-ul{list-style: none;}
	.order-ul li{float: left;}
</style>
<div class="col-xs-12">
	<div class="col-xs-12">
		S单号：<input type="text" name="ordersn" id="ordersn">
		<button type="button" style="margin-left: 5px;" class="btn">搜索</button>
	</div>
	<table class="table table-bordered">
		<tr>
			<td colspan="4">游览</td>
		</tr>
		<tr>
			<td>
				单页：<br>
				<div class="col-xs-12" id="order_btn">
					
				</div>
				<table class="table" id="order_detail">
					<tr>
						<td>
							NO TICKET
						</td>
					</tr>
				</table>
				<input type="hidden" id="order_id" value="">
			</td>
			<td>
				输入法：<br>
				<table class="table" id="input-type">
					<tr>
						<td>
							NO TICKET
						</td>
					</tr>
				</table>
			</td>
		</tr>
	</table>
</div>
<script type="text/javascript" src="../addons/purchasing/static/js/order.js"></script>
<script type="text/javascript">
	var rule = [];
	$(function() {
		get_rule();
	})
	$('button').click(function() {
		var ordersn = $('#ordersn').val();
		$.post("<?php  echo $this->createMobileUrl('search_order',array('op'=>'order'))?>",{ordersn:ordersn},function(result) {
			if (result.order_id > 0) {
				var btn_txt = '<ul class="order-ul" style="margin: 5px 0;"><li><label class="btn auto"></label></li><li><button class="btn btn-xs btn-warning" style="margin-left: 5px" onclick="rebuy()">重买</button></li><li id="edit_btn"><button class="btn" style="margin-left: 5px" onclick="edit()">修改</button></li><li><button class="btn" style="margin<button class="btn" style="margin-left: 5px" onclick="del()">删除</button></li><li id="restore" style="display: none;"><button class="btn" style="margin-left: 5px" onclick="restore()">还原</button></li></ul>';
				$('#order_btn').html(btn_txt);
				var txt = '';
				txt = create_order(result,txt,'xiazhu');
			}
			else{
				var txt = '<tr><td>NO TICKET</td></tr>'
			}
			$('#order_detail').html(txt);
			input_type();
		},'JSON');
	});
	function get_rule() {
		$.post("<?php  echo $this->createMobileUrl('pc_xiazhu',array('op'=>'get_rule'))?>",{},function(result) {
			rule = result;
		},'JSON');
	}
	function rebuy() {
		var id = $('#order_id').val();
		var checked = confirm('重买后订单可能会发生变化，请检查！');
		if (checked == true) {
			$.post("<?php  echo $this->createMobileUrl('order_control',array('op'=>'rebuy'))?>",{id:id},function(result) {
				if (result.status == 2) {
					alert(result.info);
				}
				if (result.status == 3) {
					location.href="<?php  echo $this->createMobileUrl('login')?>";
				}
				if (result.status == 1) {
					alert(result.info);
					var txt = '';
					txt = create_order(result);
					$('#orderd').html(txt);
					$('#order_detail').show();
				}
			},'JSON');
		}
	}
	function del() {
		var id = $('#order_id').val();
		$.post("<?php  echo $this->createMobileUrl('order_control',array('op'=>'del'))?>",{id:id},function(result) {
			alert(result.info);
			if (result.status == 3) {
				location.href = "<?php  echo $this->createMobileUrl('login')?>";
			}
			if (result.status == 1) {
				window.location.reload();
			}
		},'JSON');
	}
	function restore() {
		var id = $('#order_id').val();
		$.post("<?php  echo $this->createMobileUrl('order_control',array('op'=>'restore'))?>",{id:id},function(result) {
			alert(result.info);
			if (result.status == 3) {
				location.href = "<?php  echo $this->createMobileUrl('login')?>";
			}
			if (result.status == 1) {
				window.location.reload();
			}
		},'JSON');
	}
	function change_auto() {
		var id = $('#order_id').val();
		var is_auto = $('#auto').is(':checked');
		console.log(is_auto);
		$.post("<?php  echo $this->createMobileUrl('order_control',array('op'=>'change_days'))?>",{id:id,is_auto:is_auto},function(result) {
			alert(result.info);
			if (result.status == 3) {
				location.href = "<?php  echo $this->createMobileUrl('login')?>";
			}
			if (result.status == 1) {
				window.location.reload();
			}
		},'JSON')
	}
	function edit() {
		var id = $('#order_id').val();
		var url = "<?php  echo $this->createMobileUrl('pc_xiazhu',array('op'=>'edit_order'))?>&id="+id;
		var title = '修改单页';
		window.open(url, title, "location=no,status=no,scrollvars=no,width=1000,height=600");
	}
	function input_type() {
		var id = $('#order_id').val();
		$.post("<?php  echo $this->createMobileUrl('pc_xiazhu',array('op'=>'get_writing'))?>",{id:id},function(result) {
			$('#input-type').html(result.write);
		},'JSON')
	}
</script>
<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('footer', TEMPLATE_INCLUDEPATH)) : (include template('footer', TEMPLATE_INCLUDEPATH));?>