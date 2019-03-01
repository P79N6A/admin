<?php defined('IN_IA') or exit('Access Denied');?><!DOCTYPE html>
<html lang="zh-CN"  ng-app="indexappaa">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<title><?php  echo $title;?></title>
		<meta charset="utf-8">
		<meta content="telephone=no, address=no" name="format-detection">
		<meta content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no" name="viewport">
		<link href="../addons/zofui_groupshop/public/css/themify-icons.css" rel="stylesheet">
		
		<link href="../addons/zofui_groupshop/public/css/sm.min.css" rel="stylesheet">
		<link href="../addons/zofui_groupshop/public/css/sm-extend.css" rel="stylesheet">
		<link href="../addons/zofui_groupshop/public/css/weui.min.css" rel="stylesheet">
		<?php  if($_GPC['op'] == 'index') { ?>
			<link href="../addons/zofui_groupshop/template/web/css/custom.css" rel="stylesheet">
			<script type="text/javascript" src="../addons/zofui_groupshop/public/js/lib/angular.min.js"></script>
		<?php  } ?>
		<link href="../addons/zofui_groupshop/public/css/common.css" rel="stylesheet">
		<script src="../addons/zofui_groupshop/public/js/lib/zepto.min.js"></script>
		<?php  if(!in_array($_GPC['do'],array('good','sort'))) { ?>
			<link href="../addons/zofui_groupshop/public/css/<?php  echo $_GPC['do'];?>.css" rel="stylesheet">
		<?php  } ?>
		<?php  echo Util::register_jssdk();?>
		<?php  if(in_array($_GPC['op'],array('cart','default','order','card','getcard','mygroup','orderinfo'))) { ?>
			<?php  $initParams['sharedata'] = array('title'=>$this->module['config']['sharetitle'],'desc'=>$this->module['config']['sharedesc'],'link'=>'','imgUrl'=>tomedia($this->module['config']['sharepic']));?>
		<?php  } ?>
		<script>
			var initParams = <?php  echo json_encode($initParams)?>,
				shareData = <?php  echo json_encode($initParams['sharedata'])?>;
		</script>
	</head>
	<body>
		<div class="page-group">

