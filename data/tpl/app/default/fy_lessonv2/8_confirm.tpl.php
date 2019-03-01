<?php defined('IN_IA') or exit('Access Denied');?><!-- 
 * 确认下单
 * ============================================================================
 * 版权所有 2015-2017 风影随行，并保留所有权利。
 * 网站地址: http://www.haoshu888.com
 * ----------------------------------------------------------------------------
 * 这不是一个自由软件！不允许对程序代码以任何形式任何目的的再发布，作者将保留
 * 追究法律责任的权力和最终解释权。
-->
<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('_headerv2', TEMPLATE_INCLUDEPATH)) : (include template('_headerv2', TEMPLATE_INCLUDEPATH));?>
<link href="<?php echo MODULE_URL;?>template/mobile/style/cssv2/confirm.css?v=<?php  echo $versions;?>" rel="stylesheet" />
<style type="text/css">
.tabbar_wrap{margin-top:-14px;}
</style>
<div class="header-2 cbox">
	<a href="javascript:history.go(-1);" class="ico go-back"></a>
	<div class="flex title"><?php  echo $title;?></div>
</div>

<div class="order-form">
	<form id="orderForm" method="post" action="<?php  echo $this->createMobileUrl('addtoorder');?>">
	<!-- 课程订单信息 -->
	<div class="confirm-order">
		<div class="addorder_good ">
			<div class="ico"><img src="<?php  echo $teacherphoto;?>" /></div>
			<div class="shop"><?php  echo $lesson['teacher'];?>讲师</div>
			<div class="good" data-totalmaxbuy="992">
				<div class="img" onclick="location.href = '<?php  echo $lessonurl;?>'">
					<img src="<?php  echo $_W['attachurl'];?><?php  echo $lesson['images'];?>" alt=""/>
				</div>
				<div class="info" onclick="location.href = '<?php  echo $lessonurl;?>'">
					<div class="inner">
						<div class="name"><?php  echo $lesson['bookname'];?></div>
						<p style="font-size:12px;color:#B3B3B3;">规格：<?php echo $spec['spec_day']==-1 ? '长期有效' : '有效期'.$spec['spec_day'].'天';?></p>
					</div>
				</div>
				<div class="price">
					<div class="pnum">￥<span class="marketprice"><?php  echo $spec['spec_price'];?></span></div>
				</div>
			</div>
			<?php  if($setting['is_invoice']) { ?>
			<input type="text" name="invoice" placeholder="如需开具发票，请输入发票抬头">
			<?php  } ?>
		</div>
		<div class="addorder_price sel_coupon" style="margin-top:16px;">
			<div class="price" style="border:none;">
				<div class="line" style="line-height:32px;">
					优惠券 <i class="coupon"><?php  echo count($coupon_list);?>张可用</i><span>&gt;</span>
				</div>
			</div>
		</div>
		<?php  if($deduct_switch) { ?>
		<div class="addorder_price" style="margin-top:16px;">
			<div class="price" style="border:none;">
				<div class="line" style="line-height:32px;">
					积分抵扣
				</div>
			</div>
			<div id="integral_div">
				<div class="coupon-code">
					<input type="text" name="deduct_integral" id="deduct_integral" onblur="checkIntegral(this.value)" onkeyup="this.value=this.value.replace(/\D/g,'')" onafterpaste="this.value=this.value.replace(/\D/g,'')" placeholder="最多可使用<?php  echo $deduct_integral;?>积分，当前100积分可抵扣<?php  echo $market['deduct_money']*100;?>元">
					<br/>
					<span id="notice" style="font-size:12px;color:#f23030;font-weight:bold;"></span>
				</div>
			</div>
		</div>
		<?php  } ?>

		<div class="addorder_price">
			<div class="price" style="border:none;">
				<div class="line" style="line-height:33px;">课程金额<span>￥<span class="goodsprice"><?php  echo $spec['spec_price'];?></span></span></div>
				<?php  if($vipCoupon>0) { ?>
				<div class="line" style="line-height:33px;">VIP优惠<span>-￥<span class="goodsprice"><?php  echo $vipCoupon;?></span></span></div>
				<?php  } ?>
				<?php  if(count($coupon_list)>0) { ?>
				<div class="line" id="integral-div" style="line-height:33px;">优惠券抵扣<span>-￥<span class="goodsprice" id="coupon_money">0</span></span></div>
				<?php  } ?>
				<?php  if($deduct_switch) { ?>
				<div class="line" id="integral-div" style="line-height:33px;">积分抵扣<span>-￥<span class="goodsprice" id="deduct_money">0</span></span></div>
				<?php  } ?>
				<div class="line" style="line-height:33px;color:#f23030;">应付金额<span class="total" id="total" style="font-size:18px;"><?php  echo $price;?></span></div>
			</div>
		</div>
		<input type="hidden" name="id" value="<?php  echo $lesson['id'];?>"/>
		<input type="hidden" name="spec_id" value="<?php  echo $spec_id;?>"/>
		<input type="hidden" name="coupon_id" id="coupon_id" value="0"/>
		<input type="hidden" id="couponMoney" value="0"/>
		<input type="hidden" id="deducMoney" value="0"/>
		<div class="paysub" onclick="subForm()">立即支付</div>
	</div>

	<!-- 优惠券列表 -->
	<div class="common-wrapper pad52" style="display:none;">
		<div class="tab-con">
			<div class="new-coupon" onclick="useCoupon(this, 0, 0);">
				<div class="new-bdcolor bd-bd">
					<div class="newCou-bg newCou-bg"></div>
					<div class="newCou-item" style="color:#a9a9a9;">
						<div class="newCou-content cf" style="padding-bottom: 15px;">
							<div class="fl">
								<div class="ci-left">
									<strong class="pic-ch"></strong>
								</div>
								<div class="newCou-l">
									<div class="newCou-pri-content myf-newCou-pri-content">
										<span class="newCou-price myf-price">不使用优惠券</span>
									</div>
								</div>
							</div>
							<div class="newCou-r">
								<span class="newCou-date-name">&nbsp;</span>
							</div>
						</div>
					</div>
				</div>
			</div>
			<?php  if(is_array($coupon_list)) { foreach($coupon_list as $item) { ?>
			<div class="new-coupon" onclick="useCoupon(this, <?php  echo $item['id'];?>, <?php  echo $item['amount'];?>);">
				<div class="new-bdcolor bd-bd">
					<div class="newCou-bg myf-bg"></div>
					<div class="newCou-item yf-icon-color">
						<div class="newCou-title">优惠券</div>
						<div class="newCou-content cf">
							<div class="fl">
								<div class="ci-left">
									<strong class="pic-ch"></strong>
								</div>
								<div class="newCou-l">
									<div class="newCou-pri-content myf-newCou-pri-content">
										<span class="newCou-price myf-price">抵扣<?php  echo $item['amount'];?>元</span>
									</div>
								</div>
							</div>
							<div class="newCou-r">
								<span class="newCou-date-name">课程金额满<?php  echo $item['conditions'];?>元，<?php  echo $item['category_name'];?>可使用</span>
								<span class="newCou-date-content"><?php  echo date('Y-m-d',$item['addtime']);?>-<?php  echo date('Y-m-d',$item['validity']);?></span>
							</div>
						</div>
					</div>
				</div>
			</div>
			<?php  } } ?>
		</div>
		<div class="btn-bar border-1px button-middle" id="submitDiv">
			<a href="javascript:;" id="confirm-coupon" class="bb-btn02 button-change-w">确定</a>
		</div>
	</div>
	</form>
</div>

<div id="spinners" style="display:none;"><div class="spinner"><div class="bounce1"></div><div class="bounce2"></div><div class="bounce3"></div></div></div>

<script type="text/javascript">

//选择优惠券
$(".sel_coupon").click(function(){
	$(".confirm-order").hide();
	$(".common-wrapper").show();
});

$("#confirm-coupon").click(function(){
	$(".confirm-order").show();
	$(".common-wrapper").hide();
});

function useCoupon(o, couponId, amount){
	$(".pic-ch").removeClass("pic-ched");
	$(o).find("strong").addClass("pic-ched");
	$("#coupon_id").val(couponId);
	$("#couponMoney").val(amount);
}
//计算优惠券金额
$("#confirm-coupon").click(function(){
	var couponMoney = parseFloat($("#couponMoney").val());
	var total = parseFloat(document.getElementById("total").innerHTML);
	var coupon_money = parseFloat(document.getElementById("coupon_money").innerHTML);
	var price = <?php echo $price ? $price : '0'?>;

	document.getElementById("coupon_money").innerHTML = couponMoney;

	var lastTotal = (total + coupon_money - couponMoney).toFixed(2);
	if(lastTotal<=0){
		lastTotal = 0;
		$("#couponMoney").val(price);
		document.getElementById("coupon_money").innerHTML = price;
	}

	document.getElementById("total").innerHTML = lastTotal;
	 
});

//计算积分抵扣金额
function checkIntegral(integral){
	var deduct_integral = <?php echo $deduct_integral ? $deduct_integral : 0?>;
	var deduct_money = <?php echo $market['deduct_money'] ? $market['deduct_money'] : 0?>;

	if(integral > deduct_integral){
		document.getElementById("notice").innerHTML = "当前最多可使用"+deduct_integral+"个积分，请重新输入";
		return false;
	}else{
		document.getElementById("notice").innerHTML = "可帮您抵扣" + (integral*deduct_money).toFixed(2) + "元";
	}

	var total = parseFloat(document.getElementById("total").innerHTML);
	var nowCouponAmount = (integral*deduct_money).toFixed(2);
	if(nowCouponAmount > total){
		document.getElementById("notice").innerHTML = "当前输入积分抵消金额大于应付金额，请重新输入";
		return false;
	}

	document.getElementById("deduct_money").innerHTML = nowCouponAmount;

	var lastTotal = (total + parseFloat($("#deducMoney").val()) - nowCouponAmount).toFixed(2);
	if(lastTotal<=0){
		lastTotal = 0;
	}
	document.getElementById("total").innerHTML = lastTotal;
	$("#deducMoney").val(nowCouponAmount);

}

function subForm(){
	var credit1 = <?php  echo $member['credit1'];?>;
	var deduct_integral = $("#deduct_integral").val();
	var lesson_integral = <?php echo $deduct_integral ? $deduct_integral : 0?>;
	if(deduct_integral > lesson_integral){
		alert("当前课程最多可使用"+lesson_integral+"积分，请重新输入");
		return false;
	}
	if(deduct_integral > credit1){
		alert("您的积分不足，请重新输入");
		return false;
	}

	document.getElementById("spinners").style.display = 'block';
	document.getElementById("orderForm").submit();
}
</script>

<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('_footerv2', TEMPLATE_INCLUDEPATH)) : (include template('_footerv2', TEMPLATE_INCLUDEPATH));?>
