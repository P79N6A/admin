<?php defined('IN_IA') or exit('Access Denied');?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>万字后台</title>
	<link rel="stylesheet" href="../addons/purchasing/static/css/bootstrap.min.css">
	<script type="text/javascript" src="../web/resource/js/lib/jquery-1.11.1.min.js"></script>
	<script type="text/javascript" src="../addons/purchasing/static/js/bootstrap.min.js"></script>
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
	<ul class="nav nav-pills">
		<li <?php  if($op == 'main') { ?> class="active" <?php  } ?>><a href="<?php  echo $this->createMobileUrl('manager',array('op'=>'main'))?>">主页</a></li>
		<?php  if($_SESSION['level'] == 1) { ?>
		<li <?php  if($op == 'area') { ?> class="active" <?php  } ?>><a href="<?php  echo $this->createMobileUrl('manager',array('op'=>'area'))?>">盘口管理</a></li>
		<li <?php  if($op == 'company') { ?> class="active" <?php  } ?>><a href="<?php  echo $this->createMobileUrl('manager',array('op'=>'company'))?>">公司管理</a></li>
		<?php  } ?>
		<?php  if($_SESSION['level'] == 2) { ?>
		<li  class="dropdown <?php  if($_GPC['do'] == 'number_post') { ?>active<?php  } ?>" >
			<a class="dropdown-toggle"href="<?php  echo $this->createMobileUrl('number_post')?>">换字</a>
		</li>
		<?php  } ?>
		<?php  if($_SESSION['level'] <= 2) { ?>
		<li  class="dropdown <?php  if($op == 'odds') { ?>active<?php  } ?>" >
			<a class="dropdown-toggle" data-toggle="dropdown" href="#">配套管理</a>
			<ul class="dropdown-menu">
		        <li><a href="<?php  echo $this->createMobileUrl('manager',array('op'=>'odds'))?>">配套列表</a></li>
		        <li><a href="<?php  echo $this->createMobileUrl('manager',array('op'=>'odds_group'))?>">配套分组</a></li>
		    </ul>
		</li>
		<li <?php  if($op == 'rule') { ?> class="active" <?php  } ?>><a href="<?php  echo $this->createMobileUrl('manager',array('op'=>'rule'))?>">玩法设置</a></li>
		<li  class="dropdown <?php  if($op == 'limit') { ?>active<?php  } ?>" >
			<a class="dropdown-toggle" data-toggle="dropdown" href="#">销售限制</a>
			<ul class="dropdown-menu">
		        <li><a href="<?php  echo $this->createMobileUrl('manager',array('op'=>'limit'))?>">销售量控制</a></li>
		        <li><a href="<?php  echo $this->createMobileUrl('manager',array('op'=>'limit','tab'=>'time'))?>">时间设置</a></li>
		        <li><a href="<?php  echo $this->createMobileUrl('manager',array('op'=>'limit','tab'=>'red'))?>">红字控制</a></li>
		    </ul>
		</li>
		<li class="dropdown <?php  if($op == 'lottery') { ?>active<?php  } ?>">
			<a class="dropdown-toggle" data-toggle="dropdown" href="#">开奖管理</a>
			<ul class="dropdown-menu">
		        <li><a href="<?php  echo $this->createMobileUrl('manager',array('op'=>'lottery'))?>">期数管理</a></li>
		        <li><a href="<?php  echo $this->createMobileUrl('manager',array('op'=>'lottery','tab'=>'preinstall'))?>">开奖预设</a></li>
		        <li><a href="<?php  echo $this->createMobileUrl('manager',array('op'=>'lottery','tab'=>'detail'))?>">成绩管理</a></li>
		        <?php  if($_SESSION['level'] == 1) { ?>
		        <li><a href="<?php  echo $this->createMobileUrl('manager',array('op'=>'lottery','tab'=>'special'))?>">特别设置</a></li>
		        <?php  } ?>
		    </ul>
		</li>
		<?php  } ?>
		<?php  if($_SESSION['level'] == 2) { ?>
		<li <?php  if($op == 'manager') { ?> class="active" <?php  } ?>><a href="<?php  echo $this->createMobileUrl('manager',array('op'=>'display'))?>">户口管理</a></li>
		<?php  } ?>
		<?php  if($_SESSION['level'] > 3 || $_SESSION['level'] < 2) { ?>
		<li <?php  if($op == 'display') { ?> class="active" <?php  } ?>><a href="<?php  echo $this->createMobileUrl('manager',array('op'=>'display'))?>">账号管理</a></li>
		<?php  } ?>
		<li class="dropdown <?php  if($op == 'order') { ?>active<?php  } ?>">
			<a class="dropdown-toggle" data-toggle="dropdown"  href="$">下注管理</a>
			<ul class="dropdown-menu">
		        <li><a href="<?php  echo $this->createMobileUrl('manager',array('op'=>'order'))?>">下注管理</a></li>
		        <li><a href="<?php  echo $this->createMobileUrl('manager',array('op'=>'order','tab'=>'users'))?>">户口销售</a></li>
		    </ul>
		</li>
		<li class="dropdown <?php  if($op == 'agent_earn') { ?>active<?php  } ?>">
			<a class="dropdown-toggle" data-toggle="dropdown"  href="$">吃字图</a>
			<ul class="dropdown-menu">
		        <li><a href="<?php  echo $this->createMobileUrl('manager',array('op'=>'agent_earn','tab'=>'4D'))?>">4D</a></li>
		        <li><a href="<?php  echo $this->createMobileUrl('manager',array('op'=>'agent_earn','tab'=>'3D'))?>">3D</a></li>
		        <li><a href="<?php  echo $this->createMobileUrl('manager',array('op'=>'agent_earn','tab'=>'2D'))?>">2D</a></li>
		    </ul>
		</li>
		<li <?php  if($op == 'manager_eat') { ?> class="active" <?php  } ?>><a href="<?php  echo $this->createMobileUrl('manager',array('op'=>'manager_eat'))?>">管理吃字</a></li>
		<li <?php  if($op == 'search_order') { ?> class="active" <?php  } ?>><a href="<?php  echo $this->createMobileUrl('manager',array('op'=>'search_order'))?>">游览投注</a></li>
		<li <?php  if($op == 'search_number') { ?>class="active"<?php  } ?>><a href="<?php  echo $this->createMobileUrl('manager',array('op'=>'search_number'))?>">寻找号码</a></li>
		<li <?php  if($op == 'report') { ?>class="active"<?php  } ?>><a href="<?php  echo $this->createMobileUrl('manager',array('op'=>'report'))?>">报表管理</a></li>
		<li <?php  if($op == 'operation') { ?>class="active"<?php  } ?>><a href="<?php  echo $this->createMobileUrl('manager',array('op'=>'operation'))?>">操作记录</a></li>
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