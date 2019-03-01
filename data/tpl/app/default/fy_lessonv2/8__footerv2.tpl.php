<?php defined('IN_IA') or exit('Access Denied');?>		<!-- 底部导航 -->
		<div class="weui_tabbar <?php  if(($_GPC['do']=='lesson' && $section['sectiontype']!=2) || $_GPC['do']=='confirm') { ?>hidden<?php  } ?>">
			<a href="<?php  echo $this->createMobileUrl('index');?>" class="weui_tabbar_item <?php  if($_GPC['do']=='index') { ?>weui_bar_item_on<?php  } ?>">
				<div class="weui_tabbar_icon">
					<i class="fa fa-home menu_on" style="font-size: 24px;"></i>
				</div>
				<p class="weui_tabbar_label">首 页</p>
			</a>
			<a href="<?php  echo $this->createMobileUrl('search');?>" class="weui_tabbar_item <?php  if($_GPC['do']=='search') { ?>weui_bar_item_on<?php  } ?>">
				<div class="weui_tabbar_icon">
					<i class="fa fa-video-camera"></i>
				</div>
				<p class="weui_tabbar_label">全部课程</p>
			</a>
			<?php  if($setting['teacherlist']==1) { ?>
			<a href="<?php  echo $this->createMobileUrl('teacherlist');?>" class="weui_tabbar_item <?php  if($_GPC['do']=='teacherlist') { ?>weui_bar_item_on<?php  } ?>">
				<div class="weui_tabbar_icon">
					<i class="fa fa-list-ul"></i>
				</div>
				<p class="weui_tabbar_label">讲师列表</p>
			</a>
			<?php  } else if($setting['teacherlist']==2) { ?>
			<a href="<?php  echo $this->createMobileUrl('vip');?>" class="weui_tabbar_item <?php  if($_GPC['do']=='vip') { ?>weui_bar_item_on<?php  } ?>">
				<div class="weui_tabbar_icon">
					<i class="fa fa-diamond"></i>
				</div>
				<p class="weui_tabbar_label">VIP会员</p>
			</a>
			<?php  } else if($setting['teacherlist']==3) { ?>
			<a href="<?php  echo $this->createMobileUrl('getcoupon');?>" class="weui_tabbar_item <?php  if($_GPC['do']=='getcoupon') { ?>weui_bar_item_on<?php  } ?>">
				<div class="weui_tabbar_icon">
					<i class="fa fa-gift"></i>
				</div>
				<p class="weui_tabbar_label">优惠券</p>
			</a>
			<?php  } ?>
			<a href="<?php  echo $this->createMobileUrl('mylesson');?>" class="weui_tabbar_item <?php  if($_GPC['do']=='mylesson') { ?>weui_bar_item_on<?php  } ?>">
				<div class="weui_tabbar_icon">
					<i class="fa fa-book"></i>
				</div>
				<p class="weui_tabbar_label">我的课程</p>
			</a>
			<a href="<?php  echo $this->createMobileUrl('self');?>" class="weui_tabbar_item <?php  if($_GPC['do']=='self') { ?>weui_bar_item_on<?php  } ?>">
				<div class="weui_tabbar_icon">
					<i class="fa fa-user"></i>
				</div>
				<p class="weui_tabbar_label">个人中心</p>
			</a>
		</div>
		<!-- /底部导航 -->
	</div>
</div>
<script src="<?php echo MODULE_URL;?>template/mobile/style/jsv2/swiper.3.1.7.min.js"></script>
<script>
	//动画效果
	var mySwiper = new Swiper('.swiper-container', {
		pagination: '.swiper-pagination',
		/*分页器焦点*/
		effect: 'coverflow',
		/*动画过渡效果*/
		paginationClickable: true,
		/*添加点击效果*/
		centeredSlides: true,
		/*活动内容居中*/
		autoplay: 5000,
		/*自动滑动时间*/
		autoplayDisableOnInteraction: false,
		/*用户操作动画，3s后可以继续执行动画*/
		preloadImages: false,
		lazyLoading: true
	});
	//   分类为两个时的样式
	var $gridNum = $('.grid_wrap .grid_item')
	if($gridNum.length == 2) {
		$gridNum.first().css('border-right', '1px solid #f1f1f5')
	}
	//课程为奇数时图片平铺
	$('.course_main').each(function() {
		var $item = $(this).find(' .course_item');
		var itemNum = $item.length % 2;
		if(itemNum == 1 && $(this).hasClass('course_live')) {
			var $firstitem = $item.first(),
				$img = $firstitem.find("img");
			$firstitem.css('width', "100%");
			var wd = $firstitem.width() || window.innerWidth - 20;
			var boxh = Math.ceil(wd / 2);
			$img.wrap("<div class='big-box' style='height:" + boxh + "px'></div>");
		} else if(itemNum == 1 && $(this).hasClass('course_other')) {
			var $lastitem = $item.last(),
				$img = $lastitem.find("img");
			$lastitem.css('width', "100%");
			var wd = $lastitem.width() || window.innerWidth - 20;
			var boxh = Math.ceil(wd / 2);
			$img.wrap("<div class='big-box' style='height:" + boxh + "px'></div>");
		}
	});
</script>

	</body>
</html>