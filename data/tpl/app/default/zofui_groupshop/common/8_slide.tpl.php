<?php defined('IN_IA') or exit('Access Denied');?>			<div class="swiper-container" data-space-between='10' data-autoplay="3000" >
			  <div class="swiper-wrapper">
				<?php  if(is_array($slide)) { foreach($slide as $item) { ?>
				<div class="swiper-slide"><img src="<?php  echo tomedia($item)?>" alt="" style='width: 100%'></div>
				<?php  } } ?>
			  </div>
			  <div class="swiper-pagination"></div>
			</div>	