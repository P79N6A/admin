<?php defined('IN_IA') or exit('Access Denied');?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
	<link href="css/mui.min.css" rel="stylesheet" />
	<link rel="stylesheet" type="text/css" href="../addons/purchasing/static/css/bootstrap.min.css">
	<script type="text/javascript" src="../web/resource/js/lib/jquery-1.11.1.min.js"></script>
	<style>
		*{margin:0;padding:0;}
		.account-head{width: 100%;background-color: #fff;}
		.account{background-color:#eee; }
		.rec a{text-decoration: none;color: black;}
		.rec{background-color: #fff;display: table;}
		.record{width: 100%;background-color: #fff;text-align: center; }
		.addrec-table{width: 100%;border-style: none;line-height: 18px;text-align: center;}
		.addrec-table tr{width: 100%}
		.addrec-table td{border: 1px solid #eee;}
	</style>
</head>
<body style="width: 100%;height: 100% ;background-color: #eee;">
	<div class="account-head ">
		<div style="width: 7%;height: 25px;background-color: white;float: left;text-align: center;">
				<a href="mine.html"class="mui-action-back mui-icon mui-icon-left-nav mui-pull-left" style="background-color: white;line-height: 4vw;float: left;"></a>
		</div>
		<div style="width: 93%;" class="rec">
			<h2 id="addrec" style="font-weight: normal;font-size: 18px;line-height: 18px;text-align: center;width: 42%;display: table-cell;float: left;"><a href="javascript:void(0);" onclick="funadd()">充值记录</a>
			</h2>
			<h2 id="decrec" style="font-weight: normal;font-size: 18px;line-height: 18px;text-align: center;display: table-cell;width: 50%;display: block;float: left;"><a href="javascript:void(0);" onclick="fundec()">减值记录</a>
			</h2>
		</div>
	</div>
	<div style="height: 1px;width: 100%;border-top:1px solid #eee;"></div>
	<div id="rec3" class="record">
		<table class="table table-bordered">
			<tr class="rec-title" id="type1">
				<td>代理名称</td>
				<td>充值金额</td>
				<td>充值时间</td>
			</tr>
		</table>
	</div>
	<div id="rec4" class="record" style="display: none;">
		<table class="table table-bordered">
			<tr class="rec-title" id="type2">
				<td>代理名称</td>
				<td>减值金额</td>
				<td>减值时间</td>
			</tr>
		</table>
	</div>
	<script>
		var score_type = 1;
		var page = 1;
		$(function() {
			get_list(1,1);
		})
		function fundec(){
			document.getElementById('rec3').style.display="none";
			document.getElementById('rec4').style.display="block";
			get_list(2,1);
		}
		function funadd(){
			document.getElementById('rec3').style.display="block";
			document.getElementById('rec4').style.display="none";
			get_list(1,1);
		}
		function get_list(type,page) {
			score_type = type;
			if (page == 1) {
				$('.rec-title').nextAll().remove();
			}
			$.post("<?php  echo $this->createMobileUrl('xiaxianrec')?>",{page:page,score_type:score_type},function(result) {
				if (result.status == 1) {
					var list = result.list;
					var txt = '';
					for (var i = 0 in list) {
						txt += '<tr>';
						txt += '<td>'+list[i].nickname+'</td>';
						txt += '<td>'+list[i].score+'</td>';
						txt += '<td>'+list[i].create_time+'</td>';
						txt += '</tr>';
					}
					if (result.type == 1) {
						$('#type1').after(txt);
					}
					else{
						$('#type2').after(txt);
					}
				}
			},'JSON');
		}
		$(window).scroll(function() {
			if (($(this)[0].scrollTop + $(this).height() + 60) >= $(this)[0].scrollHeight) {
		        page++;
		        get_list(score_type,page);
		    }
		})
	</script>
</body>