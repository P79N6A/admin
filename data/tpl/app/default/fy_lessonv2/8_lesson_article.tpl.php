<?php defined('IN_IA') or exit('Access Denied');?><!--
 * ============================================================================
 * 版权所有 2015-2017 风影随行，并保留所有权利。
 * 网站地址: http://www.haoshu888.com；
 * ----------------------------------------------------------------------------
 * 这不是一个自由软件！已购买用户允许对程序代码进行修改和使用，但是不允许对
 * 程序代码以任何形式任何目的的再发布，作者将保留追究法律责任的权力和最终解
 * 释权。
 * ============================================================================
-->
<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('_headerv2', TEMPLATE_INCLUDEPATH)) : (include template('_headerv2', TEMPLATE_INCLUDEPATH));?>
<link href="<?php echo MODULE_URL;?>template/mobile/style/cssv2/article.css?v=<?php  echo $versions;?>" rel="stylesheet" />

<div class="header-2 cbox">
	<a href="javascript:history.go(-1);" class="ico go-back"></a>
	<div class="flex title"><?php  echo $title;?></div>
</div>

<div class="rich_primary">
	<div class="rich_title"><?php  echo $section['title'];?></div>
	<div class="rich_mate">
		<div class="rich_mate_text"><?php  echo date('Y-m-d', $section['addtime']);?></div>
		<div class="rich_mate_text"></div>
		<a href="<?php  echo $this->createMobileUrl('teacher', array('teacherid'=>$lesson['teacherid']));?>"><div class="rich_mate_text href"><?php  echo $lesson['teacher'];?></div></a>
	</div>
	<div class="rich_content">
		<?php  echo htmlspecialchars_decode($section['content']);?>
	</div>
	<?php  if(!empty($advs['img'])) { ?>
	<div>
		<a href="<?php  echo $advs['link'];?>"><img src="<?php  echo $_W['attachurl'];?><?php  echo $advs['img'];?>" style="width: 98%;"></a>
	</div>
	<?php  } ?>
</div>

<footer>
    <a href="<?php  echo $this->createMobileUrl('index');?>"><?php  echo $setting['copyright'];?></a>
</footer>

<script type="text/javascript">
<?php  if($sectionid>0){ ?>
	var recordurl = "<?php  echo $this->createMobileUrl('record', array('lessonid'=>$_GPC['id'],'sectionid'=>$_GPC['sectionid'],'uid'=>$uid));?>";

	$(document).ready(function(){  
		$.get(recordurl, {}, function (data){});
	});
	
<?php  } ?>
</script>

<?php  echo register_jssdk(false);?>
<script type="text/javascript">
wx.ready(function(){
	var shareData = {
		title: "<?php  echo $sharelesson['title'];?>",
		desc: "<?php  echo $sharelesson['title'];?>",
		link: "<?php  echo $sharelesson['link'];?>",
		imgUrl: "<?php  echo $_W['attachurl'];?><?php echo $sharelesson['images']?$sharelesson['images']:$lesson['images']?>",
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
