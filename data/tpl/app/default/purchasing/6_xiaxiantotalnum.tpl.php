<?php defined('IN_IA') or exit('Access Denied');?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
	<link href="css/mui.min.css" rel="stylesheet" />
	<style>
		*{margin:0;padding:0;}
		.account-head{width: 100%;background-color: #fff;}
		.account{background-color:#eee; }
		.qishu{width: 100%;background-color: #fff;border-bottom: 1px solid #eee;}
		.qishu a{text-decoration: none;color: black;text-align: center;}
	</style>
</head>
<body style="width: 100%;height: 100% ;background-color: #ffffff;">
	<div class="account-head ">
		<div style="width: 7%;height: 18px;background-color: white;float: left;text-align: center;">
				<a href="mine.html"class="mui-action-back mui-icon mui-icon-left-nav mui-pull-left" style="background-color: white;line-height: 3vw;"></a>
			</div>
			<div style="width: 93%;">
				<h2 id="account-date" style="font-weight: normal;font-size: 3vw;line-height: 3vw;text-align: center;">下线总期数（点我查询）</h2>
		</div>
	</div>
	<div class="qishu" id="xiaxianqishu">
		<a href="<?php  echo $this->createMobileUrl('junior_record',array('period_id'=>$item['id']))?>">
			<div id="" style="width: 50%;float: left; border-bottom: 1px solid #eee;">期数</div>
			<div id="" style="width: 50%;float: left; border-bottom: 1px solid #eee;">日期</div>
		</a>
		<?php  if(is_array($list)) { foreach($list as $item) { ?>
		<a href="<?php  echo $this->createMobileUrl('junior_record',array('period_id'=>$item['id']))?>">
			<div id="" style="width: 50%;float: left; border-bottom: 1px solid #eee;"><?php  echo $item['periods'];?>期</div>
			<div id="" style="width: 50%;float: left; border-bottom: 1px solid #eee;"><?php  echo $item['date'];?></div>
		</a>
		<?php  } } ?>
	</div>
</body>
</html>