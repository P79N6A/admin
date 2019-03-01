<?php defined('IN_IA') or exit('Access Denied');?><!-- 
 * 分销中心
 * ============================================================================
 * 版权所有 2015-2017 风影随行，并保留所有权利。
 * 网站地址: http://www.haoshu888.com
 * ----------------------------------------------------------------------------
 * 这不是一个自由软件！不允许对程序代码以任何形式任何目的的再发布，作者将保留
 * 追究法律责任的权力和最终解释权。
-->
<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('_headerv2', TEMPLATE_INCLUDEPATH)) : (include template('_headerv2', TEMPLATE_INCLUDEPATH));?>
<link href="<?php echo MODULE_URL;?>template/mobile/style/cssv2/commission.css?v=<?php  echo $versions;?>" rel="stylesheet" />

<div class="header-2 cbox">
	<a href="javascript:history.go(-1);" class="ico go-back"></a>
	<div class="flex title"><?php  echo $title;?></div>
</div>

<?php  if($setting['isfollow']==1 && $fans['follow']==0 && $userAgent) { ?>
<div class="follow_topbar">
	<div class="headimg">
		<img src="<?php  echo $_W['attachurl'];?><?php  echo $setting['qrcode'];?>">
	</div>
	<div class="info">
		<div class="i"><?php  echo $_W['account']['name'];?></div>
		<div class="i"><?php  echo $setting['follow_word'];?></div>
	</div>
	<div class="sub" onclick="location.href='<?php  echo $this->createMobileUrl('follow');?>'">立即关注</div>
</div>
<?php  } ?>
<div id="container">
	<div class="commission-topbar">
        <div class="user_face" style="background-image:url(<?php  echo $avatar;?>);background-size:contain;"></div>
        <div class="user_info">
            <div class="user_name"><?php  echo $member['nickname'];?> <span>[<?php  echo $levelname;?> /上级:<?php echo $parent['nickname']?$parent['nickname']:'总店';?>] </span></div>
            <div class="user_date">加入时间：<?php  echo date('Y-m-d H:i', $member['addtime']);?></div>
        </div>
    </div> 
    <div class="commission-top">
        <div class="top_1">
            <div class="text">累计佣金：<?php  echo sprintf("%.2f", $member['pay_commission']+$member['nopay_commission']);?> 元<br>可提现佣金（元）</div>
			<a href="<?php  echo $this->createMobileUrl('commission', array('op'=>'cashlog'));?>"><div class="ico"></div></a>
        </div>
        <div class="top_2"><?php  echo $member['nopay_commission'];?><a href="<?php  if($member['nopay_commission']<$setting['cash_lower']) { ?>javascript:;<?php  } else { ?><?php  echo $this->createMobileUrl('commission', array('op'=>'cash'));?><?php  } ?>" id="cash_btn"><span class="<?php  if($member['nopay_commission']<$setting['cash_lower']) { ?>disabled<?php  } ?>">提现</span></a></div>
    </div> 
    <div class="commission-menu"> 
		<a href="<?php  echo $this->createMobileUrl('team', array('level'=>'1'));?>"><div class="nav nav1"><i class="ico ico-team"></i><div class="title">我的团队</div><div class="con"><span><?php  echo $total;?></span>个成员</div></div></a>
		<a href="<?php  echo $this->createMobileUrl('commission', array('op'=>'commissionlog'));?>"><div class="nav nav2"><i class="ico ico-commission"></i><div class="title">佣金明细</div><div class="con">佣金提现明细</div></div></a>
        <a href="<?php  echo $posterUrl;?>"><div class="nav nav3"><i class="ico ico-qrcode"></i><div class="title">二维码</div><div class="con">推广二维码</div></div></a>        
    </div>
</div>

<footer>
    <a href="<?php  echo $this->createMobileUrl('index');?>"><?php  echo $setting['copyright'];?></a>
</footer>

<?php  if($member['nopay_commission']<$setting['cash_lower']) { ?>
<script type="text/javascript">
var cash_lower = <?php  echo $setting['cash_lower'];?>;
$("#cash_btn").click(function(){
	alert("当前提现最低额度为"+cash_lower+"元");
});
</script>
<?php  } ?>

<?php  echo register_jssdk(false);?>
<script type="text/javascript">
wx.ready(function(){
	var shareData = {
		title: "<?php  echo $sharelink['title'];?> - <?php  echo $setting['sitename'];?> - <?php  echo $_W['account']['name'];?>",
		desc: "<?php  echo $sharelink['desc'];?>",
		link: "<?php  echo $shareurl;?>",
		imgUrl: "<?php  echo $_W['attachurl'];?><?php  echo $sharelink['images'];?>",
		trigger: function (res) {},
		complete: function (res) {},
		success: function (res) {},
		cancel: function (res) {},
		fail: function (res) {}
	};
	wx.onMenuShareTimeline(shareData);
	wx.onMenuShareAppMessage(shareData);
	wx.onMenuShareQQ(shareData);
	wx.onMenuShareWeibo(shareData);
	wx.onMenuShareQZone(shareData);
	
});
</script>

<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('_footerv2', TEMPLATE_INCLUDEPATH)) : (include template('_footerv2', TEMPLATE_INCLUDEPATH));?>
