<?php defined('IN_IA') or exit('Access Denied');?><!-- 
 * 佣金提现
 * ============================================================================
 * 版权所有 2015-2017 风影随行，并保留所有权利。
 * 网站地址: http://www.haoshu888.com
 * ----------------------------------------------------------------------------
 * 这不是一个自由软件！不允许对程序代码以任何形式任何目的的再发布，作者将保留
 * 追究法律责任的权力和最终解释权。
-->
<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('_headerv2', TEMPLATE_INCLUDEPATH)) : (include template('_headerv2', TEMPLATE_INCLUDEPATH));?>
<link href="<?php echo MODULE_URL;?>template/mobile/style/cssv2/commission.css?v=<?php  echo $versions;?>" rel="stylesheet" />
<style type="text/css">
.tabbar_wrap {
	-webkit-overflow-scrolling: unset;
}
</style>
<div class="header-2 cbox">
	<a href="javascript:history.go(-1);" class="ico go-back"></a>
	<div class="flex title"><?php  echo $title;?></div>
</div>

<div class="lesson_cash">
	<div class="balance_img" style="background-image:url(<?php  echo $avatar;?>);"></div>
	<div class="balance_text">当前可提现佣金</div>
	<div class="balance_num">￥<?php  echo $member['nopay_commission'];?></div>
	<form method="post" action="" onsubmit="return checknum();">
		<div class="balance_num">
		   <select name="cash_way" id="cash_way" onchange="selCashType(this.value)" style="width:95%; height:38px; font-size:16px; margin:5px auto; border:1px solid #eee; padding:0px 2%; text-align:center;">
			<?php  if(!empty($setting_cashway)) { ?>
				<?php  if(count($setting_cashway)>1) { ?>
					<option value="">请选择提现方式</option>
				<?php  } ?>
				<?php  if(is_array($setting_cashway)) { foreach($setting_cashway as $way) { ?>
					<?php  if($way=='credit') { ?>
					<option value="1">提现到余额</option>
					<?php  } ?>
					<?php  if($way=='weachat') { ?>
					<option value="2">提现到微信钱包</option>
					<?php  } ?>
					<?php  if($way=='alipay') { ?>
					<option value="3">提现到支付宝</option>
					<?php  } ?>
				<?php  } } ?>
			<?php  } else { ?>
				<option value="">暂无有效提现方式，请联系管理员</option>
			<?php  } ?>
		   </select>
		   <input type="text" name="pay_account" id="pay_account" class="cash" value="<?php  echo $lastcashlog['pay_account'];?>" style="display:none;" placeholder="请输入支付宝帐号">
		   <input type="text" name="cash_num" id="cash_num" class="cash" placeholder="请输入提现金额">
		</div>
		<div class="balance_num">
			<input type="submit" name="submit" class="balance_sub" value="提交申请" />
			<input type="hidden" name="token" value="<?php  echo $_W['token'];?>" />
		</div>
	</form>
</div>

<div id="spinners" style="display:none;"><div class="spinner"><div class="bounce1"></div><div class="bounce2"></div><div class="bounce3"></div></div></div>

<script type="text/javascript">
function checknum(){
	var cash_way = $("#cash_way").val();
	var num = $("#cash_num").val();
	var pay_account = $("#pay_account").val();
	var total = <?php  echo $member['nopay_commission']?>;
	var cash_lower = <?php  echo $setting['cash_lower']?>;
	if(cash_way==''){
		alert("请选择提现方式");
		return false;
	}
	if(cash_way==3 && pay_account==''){
		alert("请输入提现帐号");
		return false;
	}
	if(num=='' || num<=0){
		alert("请输入提现金额");
		return false;
	}
	if(num > total){
		alert("您当前可提现额度为"+total+"元");
		return false;
	}
	if(num < cash_lower){
		alert("当前系统最低提现额度为"+cash_lower+"元");
		return false;
	}

	document.getElementById("spinners").style.display = 'block';
}
function selCashType(cash_type){
	if(cash_type==3){
		document.getElementById("pay_account").style.display = 'block';
	}else{
		document.getElementById("pay_account").style.display = 'none';
	}
}
</script>

<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('_footerv2', TEMPLATE_INCLUDEPATH)) : (include template('_footerv2', TEMPLATE_INCLUDEPATH));?>
