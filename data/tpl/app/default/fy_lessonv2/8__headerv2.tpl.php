<?php defined('IN_IA') or exit('Access Denied');?><!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
		<meta name="format-detection" content="telephone=no">
		<title><?php  if(!empty($title)) { ?><?php  echo $title;?> - <?php  } ?><?php  echo $setting['sitename'];?></title>
		<script src="<?php echo MODULE_URL;?>template/mobile/style/jsv2/jquery.min.js?v=<?php  echo $versions;?>"></script>
		<?php  if($_GPC['do']=='lesson') { ?>
		<script src="<?php echo MODULE_URL;?>template/mobile/style/jsv2/common.js?v=<?php  echo $versions;?>"></script>
		<?php  } ?>
		<link rel="stylesheet" href="<?php echo MODULE_URL;?>template/mobile/style/cssv2/weui.min.css?v=<?php  echo $versions;?>" />
		<link rel="stylesheet" href="<?php echo MODULE_URL;?>template/mobile/style/cssv2/fonts/font-awesome.min.css?v=<?php  echo $versions;?>"/>
		<link rel="stylesheet" href="<?php echo MODULE_URL;?>template/mobile/style/cssv2/index.css?v=<?php  echo $versions;?>"/>
	</head>
	<body>
		<div class="tabbar tabbar_wrap page_wrap">
			<div class="weui_tab">
