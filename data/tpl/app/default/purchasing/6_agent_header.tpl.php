<?php defined('IN_IA') or exit('Access Denied');?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>代理端</title>
	<link rel="stylesheet" href="../addons/purchasing/static/css/bootstrap.min.css">
	<script type="text/javascript" src="../web/resource/js/lib/jquery-1.11.1.min.js"></script>
	<style>
		.btn{border: 1px solid #3e3e3e;background-color: #3e3e3e;border-radius: 20px;color: #fff;padding: 3px 7px;}
		.btn:hover{background: #fff;color: #333}
		a:hover{text-indent: none;}
		a{color: #333;}
	</style>
</head>
<body>
	<ul class="nav nav-tabs">
		<li <?php  if($_GPC['do'] == 'home' || $_GPC['do'] == 'member_detail') { ?> class="active" <?php  } ?>><a href="<?php  echo $this->createMobileUrl('home',array('op'=>'display'))?>">下线管理</a></li>
		<li <?php  if($_GPC['do'] == 'order') { ?>class="active"<?php  } ?>><a href="<?php  echo $this->createMobileUrl('order')?>">投注管理</a></li>
		<li <?php  if($_GPC['do'] == 'mybaobiao') { ?> class="active" <?php  } ?>><a href="<?php  echo $this->createMobileUrl('mybaobiao')?>">结算报表</a></li>
		<li <?php  if($_GPC['do'] == 'recharge_log') { ?>class="active"<?php  } ?>><a href="<?php  echo $this->createMobileUrl('recharge_log')?>">冲减值记录</a></li>
		<li style="float: right;"><a href="<?php  echo $this->createMobileUrl('logout')?>">登出</a></li>
		<li style="float: right;padding: 10px 15px;">账号：<?php  echo $manager['account'];?></li>
	</ul>
	<div class="col-xs-12 main">