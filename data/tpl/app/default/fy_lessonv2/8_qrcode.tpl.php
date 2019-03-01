<?php defined('IN_IA') or exit('Access Denied');?><!-- 
 * 二维码推广
 * ============================================================================
 * 版权所有 2015-2016 风影随行，并保留所有权利。
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

<!-- 系统生成图片 -->
<div class="qrcode_img">
	<img src="<?php  echo $imagepath;?>" />
</div>
<!-- /系统生成图片 -->

<!-- 分销提示 -->
<div class="qrcode_info">
	<div class="title">
		<div class="ico"><i class="fa fa-cubes"></i></div>
		<div class="text">如何获取佣金</div>
	</div>
	<div class="con">
		<div class="line">
		<div class="t1">第一步</div>
			<div class="t2">
				<div class="t3">转发首页、课程详情页、讲师主页或本页面二维码图片给好友；</div>
			</div>
	  </div>
	  <div class="line">
		<div class="t1">第二步</div>
			<div class="t2">
				<div class="t3">从您转发的链接或图片进入微课堂的好友，系统将永久记录该推荐关系，好友每次进行消费，您将获得一定比例的佣金；</div>
			</div>
	  </div>
	  <div class="line">
		<div class="t1">第三步</div>
			<div class="t2">
				<div class="t3">您可以在【佣金明细】里查看您所获的佣金明细。</div>
			</div>
	   </div>
	</div>
	<div class="info2">说明：分享后会带有独有的推荐码，您的好友访问之后，系统会自动检测并记录客户关系。如果您的好友已被其他人抢先发展成了客户，他就不能成为您的客户，以最早发展成为客户为准。</div>
</div>
<!-- /分销提示 -->

<!-- 底部浮层 -->
<div class="qrcode_bottom">
	<div id="btn1" class="sub" style="margin:0px;"> 链接推广</div>
	<div id="btn2" class="sub"> 图片推广</div>
</div>
<div id='cover'><img src='<?php echo MODULE_URL;?>template/mobile/images/share_notice.jpg' style='width:100%;' /></div>
<!-- /底部浮层 -->

<!-- 版权信息 -->
<footer>
    <a href="<?php  echo $this->createMobileUrl('index');?>"><?php  echo $setting['copyright'];?></a>
</footer>
<!-- /版权信息 -->

<!-- 快捷导航 -->
<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('quicknav', TEMPLATE_INCLUDEPATH)) : (include template('quicknav', TEMPLATE_INCLUDEPATH));?>
<!-- /快捷导航 -->

<script language="javascript">
$('#btn1').click(function(){
	var ua = window.navigator.userAgent.toLowerCase();
	if (ua.match(/MicroMessenger/i) == 'micromessenger') {
		$('#cover').fadeIn(200).unbind('click').click(function(){
			$(this).fadeOut(100);
		});
	} else {
		alert("您未在微信客户端里访问，请使用图片推广方式");
	}
});
$('#btn2').click(function(){
	  alert('长按图片收藏，然后发送给好友');
});
</script>

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
