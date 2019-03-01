<?php defined('IN_IA') or exit('Access Denied');?><!-- 
 * 微课堂首页
 * ============================================================================
 * 版权所有 2015-2017 风影随行，并保留所有权利。
 * 网站地址: http://www.haoshu888.com
 * ----------------------------------------------------------------------------
 * 这不是一个自由软件！不允许对程序代码以任何形式任何目的的再发布，作者将保留
 * 追究法律责任的权力和最终解释权。
-->
<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('_headerv2', TEMPLATE_INCLUDEPATH)) : (include template('_headerv2', TEMPLATE_INCLUDEPATH));?>
<style>
.weui_tab_bd{height: auto; padding-bottom: 0;}
</style>
<script src="<?php echo MODULE_URL;?>template/mobile/style/jsv2/BreakingNews.js?v=<?php  echo $versions;?>"></script>
<script type="text/javascript">
$(function() {
	$('#breakingnews').BreakingNews({
		title: '<img src="<?php echo MODULE_URL;?>template/mobile/images/ico-inform.png" style="width:32px;margin-top:4px;">',
		titlebgcolor: '#ffffff',
		linkhovercolor: '#099',
		border: '1px solid #f3f3f3',
		timer: 5000,
		effect: 'slide'
	});
});
</script>

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
<div style='height:44px;'>&nbsp;</div>
<?php  } ?>

<div class="weui_tab_bd">
	<!-- 广告轮播图 -->
	<?php  if(!empty($setting['banner'])) { ?>
	<div class="swiper-container">
		<div class="swiper-wrapper">
			<!--图片一-->
			<?php  if(is_array($banner)) { foreach($banner as $item) { ?> <?php  if(!empty($item['img'])) { ?>
			<div class="swiper-slide">
				<a href="<?php  echo $item['link'];?>">
					<img class="swiper-lazy" data-src="<?php  echo $_W['attachurl'];?><?php  echo $item['img'];?>">
				</a>
			</div>
			<?php  } ?> <?php  } } ?>
			<!--图片一end-->
		</div>
		<div class="swiper-pagination"></div>
	</div>
	<?php  } ?>
	<!-- /广告轮播图 -->

	<!-- 分类 -->
	<?php  if(!empty($category_list)) { ?>
	<div class="grid_wrap bor_no">
		<?php  if(is_array($category_list)) { foreach($category_list as $item) { ?>
		<a class="grid_item uc-flex1" href="<?php  echo $this->createMobileUrl('search', array('cat_id'=>$item['id']));?>">
			<div class="grid_hd">
				<img src="<?php  echo $_W['attachurl'];?><?php  echo $item['ico'];?>" alt="<?php  echo $item['name'];?>" />
			</div>
			<div class="grid_bd">
				<p><?php  echo $item['name'];?></p>
			</div>
		</a>
		<?php  } } ?>
		<a class="grid_item uc-flex1" href="<?php  echo $this->createMobileUrl('search',array('op'=>'allcategory'));?>">
			<div class="grid_hd">
				<img src="<?php  echo $allCategoryIco;?>" alt="全部分类">
			</div>
			<div class="grid_bd">
				<p>全部分类</p>
			</div>
		</a>
	</div>
	<?php  } ?>
	<!-- /分类 -->
	
	<!-- 公告 -->
	<?php  if(!empty($articlelist) && is_array($articlelist)) { ?>
	<div class="BreakingNewsController easing" id="breakingnews">
		<div class="bn-title" onclick="location.href='<?php  echo $this->createMobileUrl('article', array('op'=>'list'));?>'"></div>
		<ul>
			<?php  if(is_array($articlelist)) { foreach($articlelist as $article) { ?>
			<li><a href="<?php  echo $this->createMobileUrl('article', array('op'=>'display','aid'=>$article['id']));?>">[<?php  echo date('m-d',$article['addtime']);?>]<?php  echo $article['title'];?></a></li>
			<?php  } } ?>
		</ul>
		<div class="bn-arrows" onclick="location.href='<?php  echo $this->createMobileUrl('article', array('op'=>'list'));?>'">更多</div>	
	</div>
	<?php  } ?>

	<!-- /公告 -->

	<!-- 课程板块遍历 -->
	<?php  if(!empty($list)) { ?> <?php  if(is_array($list)) { foreach($list as $rec) { ?>
	<div class="course_wrap mt10">
		<h2 class="course_hd"><span class="bor-l"></span><?php  echo $rec['rec_name'];?></h2> <?php  if($rec['show_style']==1) { ?>
		<ul class="course_main course_other">
			<?php  if(is_array($rec['lesson'])) { foreach($rec['lesson'] as $item) { ?>
			<li class="course_item">
				<a href="<?php  echo $this->createMobileUrl('lesson', array('op'=>'display', 'id'=>$item['id']));?>">
					<div class="course_pic">
						<?php  if(!empty($item['vipview']) && $item['vipview']!='null') { ?>
						<span class="course_style courseO"><i>VIP</i></span> <?php  } ?>
						<img class="lazy" src="<?php  echo $_W['attachurl'];?><?php  echo $item['images'];?>" alt="<?php  echo $item['bookname'];?>" />
						<p class="course_living"><?php  echo $item['bookname'];?></p>
					</div>
					<p>
						<span class="fl red-color"><?php echo $item['price']>0?'¥'.$item['price']:'免费';?></span>
						<span class="fr">共<i class="blue-color"><?php  echo $item['count'];?></i>节课</span>
					</p>
					<p>
						<?php  if($setting['stock_config']==1) { ?>
						<span class="fl">仅剩:<?php  echo $item['stock'];?></span> <?php  } ?>
						<span class="fr"><i class="blue-color"><?php  if($item['price']>0) { ?><?php  echo $item['buynum']+$item['virtual_buynum'];?><?php  } else { ?><?php  echo $item['buynum']+$item['virtual_buynum']+$item['visit'];?><?php  } ?></i>人已学习</span>
					</p>
				</a>
			</li>
			<?php  } } ?>
		</ul>
		<?php  } else if($rec['show_style']==2) { ?>
		<ul class="course_main course_live">
			<li class="course_item" style="width:100%;">
				<a href="<?php  echo $this->createMobileUrl('lesson', array('op'=>'display', 'id'=>$rec['lesson'][0]['id']));?>">
					<div class="course_pic">
						<img class="lazy" src="<?php  echo $_W['attachurl'];?><?php  echo $rec['lesson'][0]['images'];?>" alt="<?php  echo $rec['lesson'][0]['bookname'];?>" style="height:184px" />
					</div>
					<h3><?php  echo $rec['lesson'][0]['bookname'];?></h3>
					<p>
						<span class="fl red-color" style="font-size:13px;"><?php echo $rec['lesson'][0]['price']>0?'¥'.$rec['lesson'][0]['price']:'免费';?></span>
						<span class="fr">已有<i class="blue-color"><?php  if($rec['lesson'][0]['price']>0) { ?><?php  echo $rec['lesson'][0]['buynum']+$rec['lesson'][0]['virtual_buynum'];?><?php  } else { ?><?php  echo $rec['lesson'][0]['buynum']+$rec['lesson'][0]['virtual_buynum']+$rec['lesson'][0]['visit'];?><?php  } ?></i>人学习</span>
					</p>
				</a>
			</li>
			<?php  if(is_array($rec['lesson'])) { foreach($rec['lesson'] as $key => $item) { ?> <?php  if($key>0) { ?>
			<li class="course_item">
				<a href="<?php  echo $this->createMobileUrl('lesson', array('op'=>'display', 'id'=>$item['id']));?>">
					<div class="course_pic">
						<img class="lazy" src="<?php  echo $_W['attachurl'];?><?php  echo $item['images'];?>" alt="<?php  echo $item['bookname'];?>" />
						<p class="course_living"><?php  echo $item['bookname'];?></p>
					</div>
					<p>
						<span class="fl red-color"><?php echo $item['price']>0?'¥'.$item['price']:'免费';?></span>
						<span class="fr">共<i class="blue-color"><?php  echo $item['count'];?></i>节课</span>
					</p>
					<p>
						<?php  if($setting['stock_config']==1) { ?>
						<span class="fl">仅剩:<?php  echo $item['stock'];?></span> <?php  } ?>
						<span class="fr"><i class="blue-color"><?php  if($item['price']>0) { ?><?php  echo $item['buynum']+$item['virtual_buynum'];?><?php  } else { ?><?php  echo $item['buynum']+$item['virtual_buynum']+$item['visit'];?><?php  } ?></i>人已学习</span>
					</p>
				</a>
			</li>
			<?php  } ?> <?php  } } ?>
		</ul>
		<?php  } else if($rec['show_style']==3) { ?>
		<ul class="course_main course_live">
			<?php  if(is_array($rec['lesson'])) { foreach($rec['lesson'] as $item) { ?>
			<li class="course_item" style="width:100%;">
				<a href="<?php  echo $this->createMobileUrl('lesson', array('op'=>'display', 'id'=>$item['id']));?>">
					<div class="course_pic">
						<img class="lazy" src="<?php  echo $_W['attachurl'];?><?php  echo $item['images'];?>" alt="<?php  echo $item['bookname'];?>" style="height:184px" />
						<p class="course_living"><?php  echo $item['bookname'];?></p>
					</div>
				</a>
			</li>
			<?php  } } ?>
		</ul>
		<?php  } ?>
	</div>
	<?php  } } ?> <?php  } ?>
	<!-- /课程板块遍历 -->
	
	<?php  if(!empty($config['index_slogan'])) { ?>
	<div class="slogan_wrap">
		<div class="slogan_bd" style="background-image:url(<?php  echo $_W['attachurl'];?><?php  echo $config['index_slogan'];?>);"></div>
	</div>
	<?php  } ?>
</div>
<footer>
    <a href="<?php  echo $this->createMobileUrl('index');?>"><?php  echo $setting['copyright'];?></a>
</footer>

<?php  echo register_jssdk(false);?>
<script type="text/javascript">
wx.ready(function(){
	var shareData = {
		title: "<?php  echo $sharelink['title'];?> - <?php  echo $setting['sitename'];?>",
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