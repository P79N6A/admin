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
		.account-table{text-align: center;border-style: none;width: 100%;}
		.account-table tr{width: 100%;}
		.account-table td{background-color:#f9f4f4;width: 20%; border: 1px solid #eee;}
	</style>
</head>
<body style="width: 100%;height: 100% ;background-color: #ffffff;">
	<div class="account-head ">
		<div style="width: 7%;height: 18px;background-color: white;float: left;text-align: center;">
				<a href="huiyuantotalnum.html"class="mui-action-back mui-icon mui-icon-left-nav mui-pull-left" style="background-color: white;line-height: 3vw;"></a>
			</div>
			<div style="width: 93%;">
				<h2 id="account-date" style="font-weight: normal;font-size: 3vw;line-height: 3vw;text-align: center;">第<?php  echo $periods;?>期</h2>
			</div>
	</div>
	<div class="account">
		<table class="account-table">
			<tr>
				<td>会员</td>
				<td>总投注</td>
				<td>总赔偿</td>
				<td>总利润</td>
				<td>剩余积分</td>
			</tr>
			<?php  if(is_array($list)) { foreach($list as $item) { ?>
			<tr>
				<td><?php  echo $item['nickname'];?></td>
				<td><?php  echo $item['sum_bet'];?></td>
				<td><?php  echo $item['pay_award'];?></td>
				<td><?php  echo $item['profit'];?></td>
				<td><?php  echo $item['balance'];?></td>
			</tr>
			<?php  } } ?>
		</table>
	</div>
</body>
</html>