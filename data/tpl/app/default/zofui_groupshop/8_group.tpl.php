<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('common/myheader', TEMPLATE_INCLUDEPATH)) : (include template('common/myheader', TEMPLATE_INCLUDEPATH));?>
<link href="../addons/zofui_groupshop/public/css/group.css" rel="stylesheet">
<div id="page_group" class="page page-current  page_group">
	
	<div class="content" >
		
			<header class="header-banner banner-success">
				<div class="banner">
					<div>
						<div class="avatar-wrap">
							<div class="avatar">
								<?php  if($groupinfo['gstatus'] == 1) { ?>
									<img src="../addons/zofui_groupshop/public/images/tuan_pic1.png">
								<?php  } else if($groupinfo['gstatus'] == 2 || $groupinfo['gstatus'] == 4) { ?>
									<img src="../addons/zofui_groupshop/public/images/tuan_pic3.png">
								<?php  } else if($groupinfo['gstatus'] == 3) { ?>
									<img src="../addons/zofui_groupshop/public/images/tuan_pic2.png">
								<?php  } ?>
							</div>
						</div>
					</div>
					<div>
						<div class="banner-info">
							<?php  if($groupinfo['gstatus'] == 1) { ?>
								<?php  if(!empty($isingroup)) { ?>
									<p>再邀请<em><?php  echo $groupinfo['lastnumber'];?></em>个小伙伴参与就组团成功了</p>
								<?php  } else { ?>
									<p>终于等到你，快来<em>参团</em>吧！</p>
									<p>还差<em><?php  echo $groupinfo['lastnumber'];?></em>个小伙伴就可以组团成功啦</p>
								<?php  } ?>
							<?php  } else if($groupinfo['gstatus'] == 2 || $groupinfo['gstatus']  == 4) { ?>
								<p>团购失败了！</p>								
							<?php  } else if($groupinfo['gstatus'] == 3) { ?>
								<p>团购已成功！</p>
							<?php  } ?>
						</div>
					</div>				
				</div>
			</header>
		
			
		<!--商品详情-->
		<div class="goods-detail router">
			<div class="head-bar">
				<div class="time-info">
					<span class="little-timer">
						<span class="slogan">团购商品</span>
					</span>
				</div>
			</div>
			<a href="<?php  echo $this->createMobileUrl('good',array('id'=>$groupinfo['gid']))?>" class="item">
				<div class="image">
					<div>
						<img src="<?php  echo tomedia($groupinfo['pic'])?>"  />
					</div>
				</div>
				<div class="info">
					<p class="name"><?php  echo $groupinfo['title'];?></p>
					<div class="price-info">
						<div>
						
							<p class="price">
								<span class="member">团购价格：</span>
								<span class="sale-price"><?php  echo $groupinfo['groupprice'];?></span></span>
								<span class="member">元/件</span>
							</p>
							<p class="origin-price">商品原价：<del>￥<?php  echo $groupinfo['oldprice'];?></del></p>
						</div>
					</div>
				</div>
			</a>
			
		</div>
    
		<!--参团人员信息-->
		<div class="member-info">
			<div class="head-bar">
				<div class="time-info">
					<?php  if($groupinfo['gstatus'] == 1) { ?>
						<span class="little-timer lasttime" id="little_timer" data-time="<?php  echo $groupinfo['overtime'];?>">
							<span class="slogan">本团于</span>
							<span class='number day' id='day'>00</span><span>天</span>
							<span class='number hour' id='hour'>00</span><span>:</span>
							<span class='number minite' id='minite'>00</span><span>:</span>
							<span class='number second' id='second'>00</span><span class="slogan"> 后结束</span>
						</span>
					<?php  } else { ?>
						<span class="little-timer" id="little_timer" >
							<span class="slogan"><?php  if($groupinfo['gstatus'] == 3) { ?>本团已完成<?php  } else { ?>本团已结束<?php  } ?></span>
						</span>						
					<?php  } ?>
				</div>
			</div>
			<div class="member-list">
				<?php  if($groupinfo['gstatus'] == 1) { ?>
					<div class="flag">已有<?php  echo $groupinfo['fullnumber'] - $groupinfo['lastnumber']?>人参团，还需要<?php  echo $groupinfo['lastnumber'];?>人，下一个会是你么？</div>
				<?php  } else if($groupinfo['gstatus'] == 2 || $groupinfo['gstatus'] == 4) { ?>
					<div class="flag">真是遗憾，组团失败了</div>
				<?php  } else if($groupinfo['gstatus'] == 3) { ?>
					<div class="flag">小伙伴太给力了，已组团成功了</div>					
				<?php  } ?>
				<ul class="list">
				<?php  if(is_array($member)) { foreach($member as $k => $item) { ?>
					<?php  if($k <= 1) { ?>
						<li>
							<span class="avatar captain" style="background-image:url(<?php  echo $item['headimgurl'];?>);"></span>
							<span class="name"><?php  echo $item['nickname'];?></span>
							<span class="time"><?php  echo date('Y-m-d H:i',$item['paytime'])?></span>
						</li>
					<?php  } ?>
				<?php  } } ?>	
				</ul>
			</div>
			<div class="member-avatar">
				<ul class="avatar-list">
				<?php  if(is_array($member)) { foreach($member as $k => $item) { ?>
					<?php  if($k > 1) { ?>						
					<li class="">
						<img src="<?php  echo $item['headimgurl'];?>">
					</li>
					<?php  } ?>
				<?php  } } ?>
				</ul>
				<li class="group_moremember"><span class="ti-angle-down"></span></li>
			</div>			
		</div>
		<!--活动说明-->
		<div class="block">
			<div class="guide">
				<a href="javascript:;" class="more-rules">
					<span>玩法说明</span>
				</a>
				<div class="procedure">
					<div class="pb">
						<span class="pb-seq">1</span>
						<div class="pb-text">
							<p>选择</p>
							<p>心仪商品</p>
						</div>
					</div>
					<div class="interval">
						<span class="interval-arrow"></span>
					</div>
					<div class="pb <?php  if($groupinfo['status'] == 1 && !$isingroup) { ?>orange<?php  } ?>">
						<span class="pb-seq">2</span>
						<div class="pb-text">
							<p>支付开团</p>
							<p>或参团</p>
						</div>
					</div>
					<div class="interval">
						<span class="interval-arrow"></span>
					</div>
					<div class="pb <?php  if($groupinfo['status'] == 1 && $isingroup) { ?>orange<?php  } ?>">
						<span class="pb-seq">3</span>
						<div class="pb-text">
							<p>等待好友</p>
							<p>参团支付</p>
						</div>
					</div>
					<div class="interval">
						<span class="interval-arrow"></span>
					</div>
					<div class="pb <?php  if($groupinfo['status'] == 3) { ?>orange<?php  } ?>">
						<span class="pb-seq">4</span>
						<div class="pb-text">
							<p>达到人数</p>
							<p>组团成功</p>
						</div>
					</div>
				
				</div>
				<div class="rule-text">
					<span class="light"></span>
					<span>支付开团并喊好友参团，组团成功后等待商家发货；如组团失败，则系统自动将款项原路退还。</span>
				</div>
			</div>
		</div>

		<img class="group_plane" src="../addons/zofui_groupshop/public/images/fly.png">
		
	</div>
	
	<div class="group_bottom">
		<ul class="fixed_bottom <?php  if($_W['isajax']) { ?>router<?php  } ?>">
			<?php  if($_W['isajax']) { ?>
			<a href="javascript:;"><li class="fl" id="gotoback"><span class="ti-angle-left">返回</span></li></a>	
			<?php  } else { ?>
				<?php  if(empty($_SERVER['HTTP_REFERER']) || !empty($_GPC['toindex'])) { ?>
					<a href="<?php  echo $this->createMobileUrl('index')?>"><li class="fl"><span class="ti-angle-left">主页</span></li></a>
				<?php  } else { ?>
					<a href="<?php  echo $_SERVER['HTTP_REFERER']?>"><li class="fl"><span class="ti-angle-left">返回</span></li></a>
				<?php  } ?>
			<?php  } ?>
		<?php  if($groupinfo['gstatus'] == 1) { ?>
			<?php  if(empty($isingroup)) { ?>
				<a href="<?php  echo $this->createMobileUrl('good',array('id'=>$groupinfo['gid'],'groupid'=>$groupinfo['id']))?>"><li class="fr back_ff5f27">我要参团</li></a>			
				<a href="<?php  echo $this->createMobileUrl('good',array('id'=>$groupinfo['gid']))?>"><li class="fr back_fdd000">独立开团</li></a>
			<?php  } else { ?>
				<a href="<?php  echo $this->createMobileUrl('good',array('id'=>$groupinfo['gid']))?>"><li class="fr back_ff5f27">再开个团</li></a>			
				<a href="javascript:;" class="call_family"><li class="fr back_fdd000">喊好友参团</li></a>
			<?php  } ?>
		<?php  } else { ?>
			<a href="<?php  echo $this->createMobileUrl('good',array('id'=>$groupinfo['gid']))?>"><li class="fr back_ff5f27">重新开团</li></a>
		<?php  } ?>
		</ul>
	</div>
</div>
<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('common/basic_footer', TEMPLATE_INCLUDEPATH)) : (include template('common/basic_footer', TEMPLATE_INCLUDEPATH));?>