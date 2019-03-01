<?php defined('IN_IA') or exit('Access Denied');?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
	<link rel="stylesheet" type="text/css" href="../addons/purchasing/static/css/bootstrap.min.css">
	<link href="../addons/purchasing/template/mobile/css/mui.min.css" rel="stylesheet" />
	<style>
		*{margin:0;padding:0;}
		.account-head{width: 100%;background-color: #fff;border-bottom: 1px solid #eee;}
		.account{background-color:#eee; }
		.qishu{width: 100%;background-color: #fff;border-bottom: 1px solid #eee;}
		.qishu a{text-decoration: none;color: black;text-align: center;}
		.baobiaomain{background-color:#fff;}
		.baobiaomain-table{text-align: center;border-style: none;width: 100%;}
		.baobiaomain tr{width: 100% }
		.baobiaomain td{background-color:#fff;border-bottom: 1px solid #eee;line-height: 3vw;}
	</style>
</head>
<body style="width: 100%;height: 100% ;background-color: #ffffff;">
	<div class="account-head ">
		<div style="width: 7%;background-color: white;float: left;text-align: center;">
				<a href="javascript:void(0)"class="mui-icon mui-icon-left-nav mui-pull-left" style="background-color: white;" onclick="history.go(-1)"></a>
			</div>
			<div style="width: 93%;">
				<h2 id="account-date" style="font-weight: normal;text-align: center;">第<?php  echo $periods;?>期</h2>
			</div>
	</div>
	<div class="baobiaomain">
		<table class="table table-bordered">
		<tr>
			<td>来</td>
			<td>下线佣金</td>
			<td>下线中奖</td>
			<td>下线净</td>
			<td>花红</td>
			<td>NET</td>
			<td>出给上线</td>
			<td>出给上线佣</td>
			<td>出给上线中奖</td>
			<td>出给上线净</td>
			<td>花红</td>
			<td>NET</td>
			<td>佣金赚</td>
			<td>奖金赚</td>
			<td>彩金</td>
		</tr>
		<?php  if(is_array($list)) { foreach($list as $item) { ?>
		<tr>
			<td><?php  echo $item['sum_bet'];?></td>
			<td><?php  echo $item['cashback'];?></td>
			<td><?php  echo $item['pay_award'];?></td>
			<td><?php  echo $item['profit'];?></td>
			<td><?php  echo $item['bonus'];?></td>
			<td><?php  echo $item['net'];?></td>
			<td><?php  echo $item['sum_bet'];?></td>
			<td><?php  echo $item['upline_cashback'];?></td>
			<td><?php  echo $item['pay_award'];?></td>
			<td><?php  echo $item['upline_profit'];?></td>
			<td><?php  echo $item['bonus'];?></td>
			<td><?php  echo $item['net'];?></td>
			<td><?php  echo $item['cashback_profit'];?></td>
			<td><?php  echo $item['award_profit'];?></td>
			<td><?php  echo $item['sum_bet'];?></td>
		</tr>
		<?php  } } ?>
		</table>
	</div>
</body>
</html>