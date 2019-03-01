<?php defined('IN_IA') or exit('Access Denied');?><div class="btn_mark">
	<div class="btn_home">
		<i class="mt15 fa fa-plus"></i>
	</div>
	<div class="btn_mark_bg"></div>
	<a class="btn_menu btn_index" href="<?php  echo $this->createMobileUrl('index');?>"><i class="mt12 fa fa-home"></i></a>
	<a class="btn_menu btn_spread" href="<?php  echo $this->createMobileUrl('search');?>"><i class="mt12 fa fa-video-camera"></i></a>
	<a class="btn_menu btn_course" href="<?php  echo $this->createMobileUrl('mylesson');?>"><i class="mt12 fa fa-book"></i></a>
	<a class="btn_menu btn_my" href="<?php  echo $this->createMobileUrl('self');?>"><i class="mt12 fa fa-user"></i></a>
</div>
<script type="text/javascript">
	$(function() {
		$(".weui_tabbar a").click(function() {
			$(this).addClass("weui_bar_item_on").siblings().removeClass("weui_bar_item_on");
		});
		$(".btn_home").click(function(e) {
			e.preventDefault();
			e.stopPropagation();
			$(this).parent().toggleClass("active");
			$(".btn_qq_box").toggle();
		});
		$(".btn_mark").click(function(e) {
			$(this).toggleClass("active");
			$(".btn_qq_box").toggle();
		});
	})
</script>
<!-- /快捷导航 -->