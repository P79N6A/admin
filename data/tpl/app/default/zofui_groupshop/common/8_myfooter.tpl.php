<?php defined('IN_IA') or exit('Access Denied');?>		<!-- 底部导航 -->
<?php  $cartnum = modulefunc('zofui_groupshop', 'getCartNumber', array (
  'module' => 'zofui_groupshop',
  'func' => 'getCartNumber',
  'assign' => 'cartnum',
  'limit' => 10,
  'index' => 'iteration',
  'multiid' => 0,
  'uniacid' => 8,
  'acid' => 0,
)); if(is_array($cartnum)) { $i=0; foreach($cartnum as $i => $row) { $i++; $row['iteration'] = $i; ?><?php  } } ?>
		<?php  if(empty($share[0]['params']['bar'])) { ?>
			<div class="foot_box">
				<ul class="fixed_bottom">
				<a href="<?php  echo $this->createMobileUrl('index')?>"><li <?php  if($_GPC['do']=='index') { ?>class="font_ff5f27"<?php  } ?>><span class="ti-home"></span>首页</li></a>
				<a href="<?php  echo $this->createMobileUrl('sort')?>"><li <?php  if($_GPC['do']=='sort') { ?>class="font_ff5f27"<?php  } ?>><span class="ti-align-justify"></span>分类</li></a>
				<?php  if($this->module['config']['shoptype'] == 1) { ?>
					<a href="<?php  echo $this->createMobileUrl('user',array('op'=>'mygroup'))?>">
						<li <?php  if($_GPC['op']=='mygroup') { ?>class="font_ff5f27"<?php  } ?>><span class="ti-layout-grid4-alt"></span>团购单</li>
					</a>
				<?php  } else { ?>
					<a href="<?php  echo $this->createMobileUrl('cart')?>">
						<li <?php  if($_GPC['do']=='cart') { ?>class="font_ff5f27"<?php  } ?>><span class="ti-shopping-cart"><i class="inco_num"><?php  echo $cartnum;?></i></span>购物车</li>
					</a>
				<?php  } ?>
				<a href="<?php  echo $this->createMobileUrl('user')?>"><li <?php  if($_GPC['do']=='user' && $this->module['config']['shoptype'] !=1 ) { ?>class="font_ff5f27"<?php  } ?>><span class="ti-user"></span>我的</li></a>
				</ul>
			</div>
		<?php  } ?>
	</div>

<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('common/basic_footer', TEMPLATE_INCLUDEPATH)) : (include template('common/basic_footer', TEMPLATE_INCLUDEPATH));?>

		

