<?php defined('IN_IA') or exit('Access Denied');?><!-- 
 * 个人中心
 * ============================================================================
 * 版权所有 2015-2017 风影随行，并保留所有权利。
 * 网站地址: http://www.haoshu888.com
 * ----------------------------------------------------------------------------
 * 这不是一个自由软件！不允许对程序代码以任何形式任何目的的再发布，作者将保留
 * 追究法律责任的权力和最终解释权。
-->
<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('_headerv2', TEMPLATE_INCLUDEPATH)) : (include template('_headerv2', TEMPLATE_INCLUDEPATH));?>
<link href="<?php echo MODULE_URL;?>template/mobile/style/cssv2/new_self.css?v=<?php  echo $versions;?>" rel="stylesheet" />

<div class="global-content-c">
	<div class="my-main fadeIn animated">
		<div class="my-head" <?php  if(!empty($config['ucenter_bg'])) { ?>style="background-image:url(<?php  echo $_W['attachurl'];?><?php  echo $config['ucenter_bg'];?>);"<?php  } ?>>
			<div class="my-head-c">
				<div class="setting" onclick="location.href='<?php  echo url('mc/profile')?>'">
					<i class="fa fa-cog fa-spin fa-lg"></i>
				</div>
				<div>
					<span id="my-set-avatar" class="my-head-c-avatar img-bgloading">
						<i><img class="qmavatar" src="<?php  echo $avatar;?>" height="100%"></i>
					</span>
					<span>
						<strong class="nickname" onclick="location.href='<?php  echo url('mc/profile')?>'"><?php echo $memberinfo['nickname'] ? $memberinfo['nickname'] : '未设置';?></strong>
						<span class="studentno">学号:<?php  echo $studentno;?></span>
					</span>
				</div>
			</div>
			<div class="water">
				<div class="water-1"></div>
				<div class="water-2"></div>
			</div>
			<a class="my-head-vip slideInRight" href="<?php  echo $this->createMobileUrl('vip');?>"></a>
		</div>
		<div class="my-message-scroll">
			<div class="my-data">
				<ul class="weui-flex">
					<li class="wallet weui-flex__item bottom-line" onclick="location.href='<?php  echo url('entry', array('m'=>'recharge', 'do'=>'pay'));?>'">
						<strong class="c-main">￥<?php  echo $memberinfo['credit2'];?></strong>
						<span>会员余额</span>
					</li>
					<li class="credit weui-flex__item bottom-line" onclick="location.href='<?php  echo url('mc/bond/credits', array('credittype' => 'credit1', 'type' => 'record', 'period' => '1'))?>'">
						<strong><?php  echo $memberinfo['credit1'];?></strong>
						<span>会员积分</span>
					</li>
				</ul>
			</div>
			<div class="my-apps clear">
				<a class="my-apps-a" href="<?php  echo $this->createMobileUrl('history');?>">
					<div class="my-apps-c clear">
						<span class="z"><i class="fa fa-blue fa-hourglass-half"></i> 我的足迹 <i class="fa fa-angle-right"></i></span>
					</div>
				</a>
				<a class="my-apps-a" href="<?php  echo $this->createMobileUrl('collect', array('ctype'=>1));?>">
					<div class="my-apps-c clear">
						<span class="z"><i class="fa fa-red fa-heart"></i> 收藏课程 <i class="fa fa-angle-right"></i></span>
					</div>
				</a>
				<a class="my-apps-a" href="<?php  echo $this->createMobileUrl('collect', array('ctype'=>2));?>">
					<div class="my-apps-c clear">
						<span class="z"><i class="fa fa-red fa-gratipay"></i> 收藏讲师 <i class="fa fa-angle-right"></i></span>
					</div>
				</a>
				<?php  if($setting['teacher_income']>0 || !empty($teacher)) { ?>
				<a class="my-apps-a" href="<?php  echo $this->createMobileUrl('teachercenter');?>">
					<div class="my-apps-c clear">
						<span class="z"><i class="fa fa-orange fa-free-code-camp"></i> 讲师中心 <i class="fa fa-angle-right"></i></span>
					</div>
				</a>
				<?php  } ?>
				<?php  if($setting['is_sale']==1) { ?>
		  			<?php  if(($setting['sale_rank']==1) || ($setting['sale_rank']==2 && !empty($memberVip))) { ?>
		  			<a class="my-apps-a" href="<?php  echo $this->createMobileUrl('commission');?>">
						<div class="my-apps-c clear">
							<span class="z"><i class="fa red-color fa-share-alt"></i> <?php echo $config['share_name']?$config['share_name']:'分销中心';?> <i class="fa fa-angle-right"></i></span>
						</div>
					</a>
		  			<?php  } ?>
		  		<?php  } ?>
		  		<?php  if($setting['mobilechange']==1) { ?>
		  		<a class="my-apps-a" href="<?php  echo url('mc/bond/mobile',array('op'=>'mobilechange'));?>">
					<div class="my-apps-c clear">
						<span class="z"><i class="fa fa-edit"></i> 修改手机 <i class="fa fa-angle-right"></i></span>
					</div>
				</a>
		  		<?php  } ?>
				<a class="my-apps-a" href="<?php  echo $this->createMobileUrl('coupon');?>">
					<div class="my-apps-c clear">
						<span class="z"><i class="fa fa-pink fa-money"></i>&nbsp;优惠券&nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-angle-right"></i></span>
					</div>
				</a>

				<?php  if(!empty($self_diy)) { ?>
					<?php  if(is_array($self_diy)) { foreach($self_diy as $item) { ?>
					<a class="my-apps-a" href="<?php  echo $item['diy_link'];?>">
						<div class="my-apps-c clear">
							<span class="z"><i class="fa fa-orange fa-link"></i> <?php  echo $item['diy_name'];?> <i class="fa fa-angle-right"></i></span>
						</div>
					</a>
					<?php  } } ?>
				<?php  } ?>
			</div>
			<div class="logout">
				<a href="<?php  echo url('mc/home/login_out');?>">退出登录</a>
			</div>
		</div>
	</div>

</div>
<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('_footerv2', TEMPLATE_INCLUDEPATH)) : (include template('_footerv2', TEMPLATE_INCLUDEPATH));?>