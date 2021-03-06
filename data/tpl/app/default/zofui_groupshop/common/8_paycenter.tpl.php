<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('common/header', TEMPLATE_INCLUDEPATH)) : (include template('common/header', TEMPLATE_INCLUDEPATH));?>
<style>
	body{background:#EEE;}
	.container-fill{padding:.5em;}
	h4{margin:15px 0;}
	h4:first-of-type{margin-top:10px;}
	.panel{padding:.5em; margin-bottom:10px;}
	.nav.nav-tabs{margin-bottom:.8em;}
	.alert .form-group{margin-bottom:0;}
	#wq_card label.form-group{display:block; font-weight:normal; overflow:hidden; border-top:1px #DDD solid; padding-top:10px;padding-bottom:0;margin-bottom:0 }
	#wq_card label.form-group:first-child{border-top:0;}
	#wq_card label.form-group .col-xs-2{margin-top:0; position:relative; height:50px;}
	#wq_card label.form-group .col-xs-2 .fa{font-size:24px; color:#717171; position:absolute; top:50%; left:50%; -webkit-transform:translate(-50%, -50%); -moz-transform:translate(-50%, -50%); transform:translate(-50%, -50%);}
	#wq_card label.form-group .col-xs-2 .fa.fa-check-circle{color:#5cb85c;}
	#wq_card label.form-group .col-xs-10{padding-right:0;}
	#wq_card label.form-group input[name="type"]{opacity:0; width:0;}
	form .btn.btn-block{padding:10px 12px; margin-bottom:10px;}.item_cell_box{    display: -webkit-box;    -webkit-box-align: center;	    -webkit-align-items: center;    -ms-flex-align: center;    align-items: center;		}.item_cell_flex{    -webkit-box-flex: 1;    -webkit-flex: 1;    -ms-flex: 1;    flex: 1;	padding-left:10px;}	.order_info .item_cell_flex{	text-align:right;}.order_title{	white-space:nowrap;	overflow:hidden;}
</style>
<script>
	require(['bootstrap'], function($){
		$(function(){
		});
	});
</script>
<h4>订单信息</h4>
<div class="panel">
	<div class="clearfix order_info" style="padding-top:10px;">		<div class="item_cell_box">			<p>商品名称:</p>			<p class="item_cell_flex order_title"><?php  echo $params['title'];?></p>		</div>		<div class="item_cell_box">			<p>订单编号:</p>			<p class="item_cell_flex"><?php  echo $params['ordersn'];?></p>		</div>		<div class="item_cell_box">			<p>商家名称:</p>			<p class="item_cell_flex"><?php  echo $_W['account']['name'];?></p>		</div>		<div class="item_cell_box">			<p>支付金额:</p>			<p class="item_cell_flex">￥<?php  echo sprintf('%.2f', $params['fee']);?> 元</p>			<input type="hidden" value="<?php  echo $params['fee'];?>" name="orderfee">		</div>
	</div>
</div>

<h4>选择支付方式</h4>
<ul class="nav nav-tabs" role="tablist" style="margin-bottom:0;">
	<li class="active" data-id="direct"><a href="#direct" role="tab" data-toggle="tab" style="border-left:0;">直接到账</a></li>
	<?php  if($pay['delivery']['switch']) { ?><li data-id="delivery" class="delivery"><a href="#collect" role="tab" data-toggle="tab"><?php  if(!empty($params['delivery']['title'])) { ?><?php  echo $params['delivery']['title'];?><?php  } else { ?>货到付款<?php  } ?></a></li><?php  } ?>
	<?php  if($pay['line']['switch']) { ?><li data-id="line" class="line"><a href="#line" role="tab" data-toggle="tab">线下汇款</a></li><?php  } ?>
</ul>
<div class="panel clearfix" style="border-top-left-radius:0; border-top-right-radius:0;">
	<div class="tab-content">
		<!-- 直接到账 -->
		<div class="tab-pane animated active fadeInLeft" id="direct">
			<?php  if(!empty($pay['wechat']['switch'])) { ?>
			<div class="pay-btn" id="wechat-panel">
				<form action="<?php  echo url('mc/cash/wechat');?>" method="post">
					<input type="hidden" name="params" value="<?php  echo base64_encode(json_encode($params));?>" />
					<input type="hidden" name="encrypt_code" value="" />
					<input type="hidden" name="card_id" value="<?php  echo base64_encode($card_id);?>" />
					<input type="hidden" name="coupon_id" value="" />
					<button class="btn btn-success btn-block col-sm-12" disabled="disabled" type="submit" id="wBtn" value="wechat">微信支付(必须使用微信内置浏览器)</button>
				</form>
			</div>
			<script type="text/javascript">
				document.addEventListener('WeixinJSBridgeReady', function onBridgeReady() {
					$('#wBtn').removeAttr('disabled');
					$('#wBtn').html('微信支付');
				});
			</script>
			<?php  } ?>
			<?php  if(!empty($pay['credit']['switch'])) { ?>
			<div class="pay-btn" id="credit-panel">
				<form action="<?php  echo url('mc/cash/credit');?>" method="post">
					<input type="hidden" name="params" value="<?php  echo base64_encode(json_encode($params));?>" />
					<input type="hidden" name="encrypt_code" value="" />
					<input type="hidden" name="card_id" value="<?php  echo base64_encode($card_id);?>" />
					<input type="hidden" name="coupon_id" value="" />
					<button class="btn btn-primary btn-block col-sm-12" id="creditBtn"  type="submit" value="credit">余额支付 （余额支付当前 <?php  echo sprintf('%.2f', $credtis[$setting['creditbehaviors']['currency']]);?>元)</button>
				</form>				<input name="usercredit" value="<?php  echo $credtis[$setting['creditbehaviors']['currency']];?>" type="hidden">
			</div>			
			<?php  } ?>
		</div>

		<!-- 货到付款 -->
		<div class="tab-pane animated" id="collect">
			<?php  if($pay['delivery']['switch']) { ?>
			<div class="pay-btn" id="delivery-panel">
				<form action="<?php  echo url('mc/cash/delivery');?>" method="post">
					<input type="hidden" name="params" value="<?php  echo base64_encode(json_encode($params));?>" />
					<input type="hidden" name="encrypt_code" value="" />
					<input type="hidden" name="card_id" value="<?php  echo base64_encode($card_id);?>" />
					<input type="hidden" name="coupon_id" value="" />
					<button class="btn btn-warning btn-block col-sm-12" type="submit" value="delivery"><?php  if(!empty($params['delivery']['title'])) { ?><?php  echo $params['delivery']['title'];?><?php  } else { ?>货到付款<?php  } ?></button>
				</form>
			</div>
			<?php  } ?>
		</div>
		<!-- 线下汇款 -->
		<div class="tab-pane animated" id="line">
			<?php  if($pay['line']['switch']) { ?>
			<?php  echo htmlspecialchars_decode($pay['line']['message'])?>
			<?php  } ?>
		</div>
		<div class="tab-pane animated" id="guarantee">
			<div class="alert alert-info">
				<div class="row text-center">
					<div class="col-xs-4">
						<span class="fa-stack fa-2x">
							<i class="fa fa-adjust fa-stack-2x"></i>
							<i class="fa fa-rotate-90 fa-adjust fa-stack-2x"></i>
						</span>
						<div class="help-block">付款给微擎</div>
					</div>
					<div class="col-xs-4">
						<span class="fa-stack fa-2x">
							<i class="fa fa-adjust fa-stack-2x"></i>
						</span>
						<div class="help-block">发货/您确认收货</div>
					</div>
					<div class="col-xs-4">
						<span class="fa-stack fa-2x">
							<i class="fa fa-circle-o fa-stack-2x"></i>
						</span>
						<div class="help-block">微擎付款给商家</div>
					</div>
				</div>
			</div>
			<div class="alert alert-info clearfix">
				<label class="form-group">
					<div class="col-xs-1">
						<input type="radio" name="type" value="alipay" checked>
					</div>
					<div class="col-xs-11">
						担保支付
						<div class="help-block">还未支持</div>
					</div>
				</label>
			</div>
		</div>
	</div>
</div>
<input type="hidden" name="token" value="<?php  echo $_W['token'];?>" />
<script type="text/javascript">
	require(['bootstrap'], function($){
		$('.nav li').click(function(){
			if ($(this).attr('data-id') == 'delivery') {
				$('#coupon').hide();
				$('#order_card').hide();
				$('#wq_card').find('.fa').removeClass('text-danger');
				$('#wq_card .btn-primary').trigger('click');
				$('.pay-btn input[name="coupon_id"]').val(0);
			} else {
				$('#coupon').show();
			}
		});

		if ($('#direct .pay-btn').size() == 0) {
			$('.nav-tabs a[href="#collect"]').trigger('click');
			return false;
		}

		$('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
			var from = $(e.relatedTarget).attr('href');
			var to = $(e.delegateTarget).attr('href');
			if($(to).index() < $(from).index()) {
				$(to).removeClass('fadeInRight fadeInLeft').addClass('fadeInLeft');
			} else {
				$(to).removeClass('fadeInRight fadeInLeft').addClass('fadeInRight');
			}
		});

		$('#card').click(function(){
			$('.bs-example-modal-lg').modal('show');
		});
		var cards_str = '<?php  echo $cards_str;?>';
		if (cards_str) {
			cards_str = $.parseJSON(cards_str);
		} else {
			cards_str = {};
		}
		$('#wq_card .form-group').click(function(){
			var status = $(this).find('.fa').hasClass('fa-circle-thin');
			$(this).siblings().find('.fa').removeClass('fa-check-circle').addClass("fa-circle-thin");
			if(status) {
				$(this).find('.fa').removeClass('fa-circle-thin');
				$(this).find('.fa').addClass('fa-check-circle');
			} else {
				$(this).find('.fa').removeClass('fa-check-circle');
				$(this).find('.fa').addClass('fa-circle-thin');
			}
		});

		$('#wq_card .btn-primary').click(function(){
			var checked_card = $('#wq_card .fa.fa-check-circle').attr('data-id');
			if(checked_card && cards_str[checked_card]) {
				$('#wq_card_info').html('已抵用'+cards_str[checked_card].discount_cn+'元');
				$('#order_card span:first').html('-￥'+cards_str[checked_card].discount_cn+'元');
				$('.pay-btn input[name="coupon_id"]').val(checked_card);
				$('#order_card').show();
			} else {
				$('.pay-btn input[name="coupon_id"]').val(0);
				$('#wq_card_info').html('未使用 <i class="fa fa-angle-right"></i>');
				$('#order_card').hide();
			}
			$('.bs-example-modal-lg').modal('hide');
		});				$('#creditBtn').click(function(){			var credit = $('input[name=usercredit]').val()*1,				fee = $('input[name=orderfee]').val();			if(credit < fee){				alert('您的余额不足，请选择微信支付');return false;			}		});		
	});
</script><?php  $footer_off = 1?>
<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('common/footer', TEMPLATE_INCLUDEPATH)) : (include template('common/footer', TEMPLATE_INCLUDEPATH));?>