<?php defined('IN_IA') or exit('Access Denied');?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>万字后台</title>
	<link rel="stylesheet" href="../addons/purchasing/static/css/bootstrap.min.css">
	<script type="text/javascript" src="../web/resource/js/lib/jquery-1.11.1.min.js"></script>
	<style>
		a{color: #333;}
		.btn_click{background: #fff;color: #333}
	</style>
</head>
<body>
	<div class="col-xs-12">
		<?php  if(is_array($handicap)) { foreach($handicap as $hand) { ?>
		<input type="button" name="hand" value="<?php  echo $hand['area_name'];?>" class="btn <?php  if($_SESSION['area'] == $hand['id']) { ?>btn_click<?php  } ?>">
		<?php  } } ?>
	</div>
	<ul class="nav nav-tabs">
		<li <?php  if($op == 'main') { ?> class="active" <?php  } ?>><a href="<?php  echo $this->createMobileUrl('manager',array('op'=>'main'))?>">主页</a></li>
		<?php  if($_SESSION['level'] == 1) { ?>
		<li <?php  if($op == 'area') { ?> class="active" <?php  } ?>><a href="<?php  echo $this->createMobileUrl('manager',array('op'=>'area'))?>">盘口管理</a></li>
		<li <?php  if($op == 'company') { ?> class="active" <?php  } ?>><a href="<?php  echo $this->createMobileUrl('manager',array('op'=>'company'))?>">公司管理</a></li>
		<li <?php  if($op == 'odds') { ?> class="active" <?php  } ?>><a href="<?php  echo $this->createMobileUrl('manager',array('op'=>'odds'))?>">配套管理</a></li>
		<li <?php  if($op == 'rule') { ?> class="active" <?php  } ?>><a href="<?php  echo $this->createMobileUrl('manager',array('op'=>'rule'))?>">玩法设置</a></li>
		<!-- <li <?php  if($op == 'limit') { ?> class="active" <?php  } ?>><a href="<?php  echo $this->createMobileUrl('manager',array('op'=>'limit'))?>">销售限制</a></li> -->
		<?php  } ?>
		<li <?php  if($op == 'display') { ?> class="active" <?php  } ?>><a href="<?php  echo $this->createMobileUrl('manager',array('op'=>'display'))?>">账号管理</a></li>
		<li <?php  if($op == 'lottery') { ?>class="active"<?php  } ?>><a href="<?php  echo $this->createMobileUrl('manager',array('op'=>'lottery'))?>">开奖管理</a></li>
		<li <?php  if($op == 'order') { ?>class="active"<?php  } ?>><a href="<?php  echo $this->createMobileUrl('manager',array('op'=>'order'))?>">下注管理</a></li>
		<li <?php  if($op == 'report') { ?>class="active"<?php  } ?>><a href="<?php  echo $this->createMobileUrl('manager',array('op'=>'report'))?>">报表管理</a></li>
		<?php  if($_SESSION['level'] == 1) { ?>
		<li <?php  if($op == 'operation') { ?>class="active"<?php  } ?>><a href="<?php  echo $this->createMobileUrl('manager',array('op'=>'operation'))?>">操作记录</a></li>
		<?php  } ?>
		<li style="float: right;"><a href="<?php  echo $this->createMobileUrl('logout')?>">登出</a></li>
		<li style="float: right;margin-right: 15px;padding: 10px 15px;">登录账号:<?php  echo $manager['account'];?></li>
	</ul>
	<script type="text/javascript">
		$('input[name=hand]').click(function() {
			var area_id = $(this).val();
			$>post("<?php  echo $this->createMobileUrl('select_area')?>",{area_id:area_id},function(result) {
				window.location.reload();
			},'JSON')
		})
	</script>
	<div class="col-xs-12 main">