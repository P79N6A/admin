<?php defined('IN_IA') or exit('Access Denied');?><!DOCTYPE html>
<html lang="en">
<head>
	<link rel="stylesheet" href="../addons/purchasing/template/mobile/css/mui.min.css">
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no" />
	<meta name="apple-mobile-web-app-capable" content="yes">
	<meta name="apple-mobile-web-app-status-bar-style" content="black">
	<script type="text/javascript" src="../web/resource/js/lib/jquery-1.11.1.min.js"></script>
	<title></title>
<style>
	.home-ui{width: 100%;height:100%;margin-bottom: 20vw;}
	.mui-slider{position: relative;z-index: 1;overflow: hidden;width: 100%;height: 100%}
	.mui-slider-indicator{width: 100%;height: 15%;}
	.mui-control-item{width: 50%;height:100%;font-size: 2vw;text-align: center;text-decoration: none;color: black;float: left;line-height: 4vw;background-color: white;}
	.block-style{width: 100%}
	.slider-bar{height: 1%;z-index: 1;transform: translateZ(0);width: 100%;}
	.home-main{width: 100%;height: 100%;position: relative;display: inline-block;}
	.slide-group{font-size: 1vw;}
	.line10{border-top: 10px solid #eeeeee;}
	.slide-group tr{background-color: white;margin: 5px auto;border-bottom: 5px solid #eee;}
	.slide-group td{background-color: white;text-align: center; border-style: none;}
	.table1{width: 100%;max-width: 100%;border: 1px solid #ddd;border-collapse:collapse;line-height: 2vw;}
	.table1 td{border: 1px solid #ddd;width: 1%;font-size: 14px;}
	.table1 td input{margin:0; height: 100%; border:0 !important;width: 100px;}
	.btn{border-radius: 4px;border: 2px solid white; color: #fff; display: block;margin: 0 auto;outline-style: none;width:40%;}
	.input1{ border: 0;  text-align: center;}
	.btn{border-radius: 15px;background-color:#333333; color: white; display: block;margin: 10px auto;outline-style: none;width:40%;font-size:2vw}
	.save-area{width: 100%;height: 100%;background: rgba(0,0,0,0.4);top: 0;left: 0;position: fixed;display: none;}
	.save-div{width: 30%;height: 149px;background: #fff;margin: 15% auto;}
	.get-area{width: 100%;height: 100%;background: rgba(0,0,0,0.4);top: 0;left: 0;position: fixed;display: none;}
	.get-div{width: 30%;background: #fff;margin: 15% auto;}
	.save-title{height: 2vw;line-height: 2vw;text-align: center;background: #333;}
	.save-title p{font-size: 18px;color: #FFF;padding: 0 8px;}
	.save-body{padding: 8px;}
	.save-bottom{height: 2vw;width: 100%;border-top: 1px solid #ccc;}
	.save-btn{width: 50%;float: left;line-height: 2vw;height: 100%;text-align: center;}
	.save-btn a{color: #333;}
	.odds-table{width: 100%;text-align: center;}
	.odds-table tr td{padding: 4px 0;border-top: 1px solid #ccc;}
</style>
</head>
<body style="width: 100%;height: 100%;background-color: #eeeeee">
	<div class="home-ui">
		<div id="slider" class="mui-slider" style="position: inherit;">
			<div class="mui-slider-indicator" style="position: inherit;" >
				<a href="#item1mobile" class="mui-control-item" id="xiaxian" onclick="myfun1()">下线</a>
				<?php  if($can == 1) { ?><a href="#item2mobile" class="mui-control-item" id="member" onclick="myfun2()">会员</a><?php  } ?>
			</div>			
		</div>
		<div id="item1mobile" class="home-main" style="display: block;">
			<div class="slide-group">	
				<table class="table1">
					<tr style="border-top: 5px solid #eee; ">
						<td>新账户</td>
						<td><input type="text" name="agent_account" class="input1" placeholder="请输入账户名称" style="width: 100%;"></td>
						<td>昵称</td>
						<td><input type="text" name="agent_nickname" class="input1" placeholder="请输入昵称" style="width: 100%;"></td>
					</tr>
					<tr>
						<td>密码</td>
						<td><input type="text" name="agent_password" class="input1" placeholder="请输入密码" style="width: 100%;"></td>
						<td>确认密码</td>
						<td><input type="text" name="agent_repassword" class="input1" placeholder="请再次输入密码" style="width: 100%;"></td>
					</tr>
				</table>
			<table class="table1">
				<tr>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td>彩金</td>
					<td><input type="text" name="jackpot" value="<?php  echo $jackpot;?>" readonly="readonly"></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td>分红</td>
					<td><input type="text" name="bonus" value="0"></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
				</tr>
				<tr>
					<td>我的反水</td>
					<td></td>
					<td><input type="text" class="my_cashback_agent" value="<?php  echo $cash['B'];?>" readonly="readonly"></td>
					<td></td>
					<td><input type="text" class="my_cashback_agent" value="<?php  echo $cash['S'];?>" readonly="readonly"></td>
					<td></td>
					<td><input type="text" class="my_cashback_agent" value="<?php  echo $cash['A'];?>" readonly="readonly"></td>
					<td></td>
					<td><input type="text" class="my_cashback_agent" value="<?php  echo $cash['3ABC'];?>" readonly="readonly"></td>
					<td></td>
					<td><input type="text" class="my_cashback_agent" value="<?php  echo $cash['4A'];?>" readonly="readonly"></td>
					<td></td>
					<td><input type="text" class="my_cashback_agent" value="<?php  echo $cash['4ABC'];?>" readonly="readonly"></td>
					<td></td>
					<td><input type="text" class="my_cashback_agent" value="<?php  echo $cash['2A'];?>" readonly="readonly"></td>
					<td></td>
					<td><input type="text" class="my_cashback_agent" value="<?php  echo $cash['2ABC'];?>" readonly="readonly"></td>
				</tr>
				<tr>
					<td>反水</td>
					<td>B</td>
					<td><input type="text" name="cashback[B]" value="<?php  echo $cash['B'];?>" class="cashback_agent"></td>
					<td>S</td>
					<td><input type="text" name="cashback[S]" value="<?php  echo $cash['S'];?>" class="cashback_agent"></td>
					<td>A~EC</td>
					<td><input type="text" name="cashback[A]" value="<?php  echo $cash['A'];?>" class="cashback_agent"></td>
					<td>3ABC</td>
					<td><input type="text" name="cashback[3ABC]" value="<?php  echo $cash['3ABC'];?>" class="cashback_agent"></td>
					<td>4A~EA</td>
					<td><input type="text" name="cashback[4A]" value="<?php  echo $cash['4A'];?>" class="cashback_agent"></td>
					<td>4AC</td>
					<td><input type="text" name="cashback[4ABC]" value="<?php  echo $cash['4ABC'];?>" class="cashback_agent"></td>
					<td>2A~EX</td>
					<td><input type="text" name="cashback[2A]" value="<?php  echo $cash['2A'];?>" class="cashback_agent"></td>
					<td>2ABC</td>
					<td><input type="text" name="cashback[2ABC]" value="<?php  echo $cash['2ABC'];?>" class="cashback_agent"></td>
				</tr>
				<!-- <tr>
					<td>水钱</td>
					<td></td>
					<td><span id="cashback_money_b_agent"></span></td>
					<td></td>
					<td><span id="cashback_money_s_agent"></span></td>
					<td></td>
					<td><span id="cashback_money_a_agent"></span></td>
					<td></td>
					<td><span id="cashback_money_3abc_agent"></span></td>
					<td></td>
					<td><span id="cashback_money_4a_agent"></span></td>
					<td></td>
					<td><span id="cashback_money_4abc_agent"></span></td>
					<td></td>
					<td><span id="cashback_money_2a_agent"></span></td>
					<td></td>
					<td><span id="cashback_money_2abc_agent"></span></td>
				</tr>
				<tr>
					<td>头奖</td>
					<td>B</td>
					<td><input type="text" value="0" class="odds_b_agent"></td>
					<td>S</td>
					<td><input type="text" value="0" class="odds_s_agent"></td>
					<td>A</td>
					<td><input type="text" value="0" class="odds_a_agent"></td>
					<td>3ABC</td>
					<td><input type="text" value="0" class="odds_3abc_agent"></td>
					<td>4A</td>
					<td><input type="text" value="0" class="odds_4a_agent"></td>
					<td>4AC</td>
					<td><input type="text" value="0" class="odds_4abc_agent"></td>
					<td>2A</td>
					<td><input type="text" value="0" class="odds_2a_agent"></td>
					<td>2ABC</td>
					<td><input type="text" value="0" class="odds_2abc_agent"></td>
				</tr>
				<tr>
					<td>二奖</td>
					<td>B</td>
					<td><input type="text" value="0" class="odds_b_agent"></td>
					<td>S</td>
					<td><input type="text" value="0" class="odds_s_agent"></td>
					<td>C2</td>
					<td><input type="text" value="0" class="odds_a_agent"></td>
					<td>3ABC</td>
					<td><input type="text" value="0" class="odds_3abc_agent"></td>
					<td>4B</td>
					<td><input type="text" value="0" class="odds_4a_agent"></td>
					<td>4AC</td>
					<td><input type="text" value="0" class="odds_4abc_agent"></td>
					<td>2B</td>
					<td><input type="text" value="0" class="odds_2a_agent"></td>
					<td>2ABC</td>
					<td><input type="text" value="0" class="odds_2abc_agent"></td>
				</tr>
				<tr>
					<td>三奖</td>
					<td>B</td>
					<td><input type="text" value="0" class="odds_b_agent"></td>
					<td>S</td>
					<td><input type="text" value="0" class="odds_s_agent"></td>
					<td>C3</td>
					<td><input type="text" value="0" class="odds_a_agent"></td>
					<td>3ABC</td>
					<td><input type="text" value="0" class="odds_3abc_agent"></td>
					<td>4C</td>
					<td><input type="text" value="0" class="odds_4a_agent"></td>
					<td>4AC</td>
					<td><input type="text" value="0" class="odds_4abc_agent"></td>
					<td>2C</td>
					<td><input type="text" value="0" class="odds_2a_agent"></td>
					<td>2ABC</td>
					<td><input type="text" value="0" class="odds_2abc_agent"></td>
				</tr>
				<tr>
					<td>特别奖</td>
					<td>B</td>
					<td><input type="text" value="0" class="odds_b_agent"></td>
					<td></td>
					<td></td>
					<td>C4</td>
					<td><input type="text" value="0" class="odds_a_agent"></td>
					<td></td>
					<td></td>
					<td>4D</td>
					<td><input type="text" value="0" class="odds_4a_agent"></td>
					<td></td>
					<td></td>
					<td>2D</td>
					<td><input type="text" value="0" class="odds_2a_agent"></td>
					<td></td>
					<td></td>
				</tr>
				<tr>
					<td>安慰奖</td>
					<td>B</td>
					<td><input type="text" value="0" class="odds_b_agent"></td>
					<td></td>
					<td></td>
					<td>C5</td>
					<td><input type="text" value="0" class="odds_a_agent"></td>
					<td></td>
					<td></td>
					<td>4E</td>
					<td><input type="text" value="0" class="odds_4a_agent"></td>
					<td></td>
					<td></td>
					<td>2E</td>
					<td><input type="text" value="0" class="odds_2a_agent"></td>
					<td></td>
					<td></td>
				</tr>
				<tr>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td>EC</td>
					<td><input type="text" value="0" class="odds_a_agent"></td>
					<td></td>
					<td></td>
					<td>EA</td>
					<td><input type="text" value="0" class="odds_4a_agent"></td>
					<td></td>
					<td></td>
					<td>EX</td>
					<td><input type="text" value="0" class="odds_2a_agent"></td>
					<td></td>
					<td></td>
				</tr> -->
			</table>
			</div>
			<div style="height: 20%;">
				<div style="width: 50%;height: 100%;float: left;">
					<button type="button" class="btn" id="btn1" onclick="add_agent('<?php  echo $this->createMobileUrl('add_account',array('agent_id'=>$_GPC['agent_id']))?>');">确认添加</button>
				</div>
				<div style="width: 50%;height: 100%;float: left;">
					<button type="button" id="btn2" class="btn" onclick="location.href = '<?php  echo $this->createMobileUrl('addrec')?>'">添加记录</button>
				</div>
			</div>
		</div>
		<?php  if($can == 1) { ?>
		<div id="item2mobile" class="home-main" style="display: none;">
			<div class="slide-group">	
				<table class="table1">
					<tr style="border-top: 5px solid #eee; ">
						<td>新账户</td>
						<td><input type="text" name="account" class="input1" placeholder="请输入账户名称" style="width: 100%;"></td>
						<td>昵称</td>
						<td><input type="text" name="nickname" class="input1" placeholder="请输入昵称" style="width: 100%;"></td>
					</tr>
					<tr>
						<td>密码</td>
						<td><input type="text" name="password" class="input1" placeholder="请输入密码" style="width: 100%;"></td>
						<td>确认密码</td>
						<td><input type="text" name="repassword" class="input1" placeholder="请再次输入密码" style="width: 100%;"></td>
					</tr>
				</table>
				<table class="table1">
					<tr>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td>彩金</td>
						<td><input type="text" value="<?php  echo $jackpot;?>" readonly="readonly"></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
					</tr>
					<tr>
						<td>我的反水</td>
						<td></td>
						<td><input type="text" class="my_cashback" value="<?php  echo $cash['B'];?>" readonly="readonly"></td>
						<td></td>
						<td><input type="text" class="my_cashback" value="<?php  echo $cash['S'];?>" readonly="readonly"></td>
						<td></td>
						<td><input type="text" class="my_cashback" value="<?php  echo $cash['A'];?>" readonly="readonly"></td>
						<td></td>
						<td><input type="text" class="my_cashback" value="<?php  echo $cash['3ABC'];?>" readonly="readonly"></td>
						<td></td>
						<td><input type="text" class="my_cashback" value="<?php  echo $cash['4A'];?>" readonly="readonly"></td>
						<td></td>
						<td><input type="text" class="my_cashback" value="<?php  echo $cash['4ABC'];?>" readonly="readonly"></td>
						<td></td>
						<td><input type="text" class="my_cashback" value="<?php  echo $cash['2A'];?>" readonly="readonly"></td>
						<td></td>
						<td><input type="text" class="my_cashback" value="<?php  echo $cash['2ABC'];?>" readonly="readonly"></td>
					</tr>
					<!-- <tr>
						<td>反水</td>
						<td></td>
						<td><input type="text" value="<?php  echo $cash['B'];?>" class="cashback"></td>
						<td></td>
						<td><input type="text" value="<?php  echo $cash['S'];?>" class="cashback"></td>
						<td></td>
						<td><input type="text" value="<?php  echo $cash['A'];?>" class="cashback"></td>
						<td></td>
						<td><input type="text" value="<?php  echo $cash['3ABC'];?>" class="cashback"></td>
						<td></td>
						<td><input type="text" value="<?php  echo $cash['4A'];?>" class="cashback"></td>
						<td></td>
						<td><input type="text" value="<?php  echo $cash['4ABC'];?>" class="cashback"></td>
						<td></td>
						<td><input type="text" value="<?php  echo $cash['2A'];?>" class="cashback"></td>
						<td></td>
						<td><input type="text" value="<?php  echo $cash['2ABC'];?>" class="cashback"></td>
					</tr> -->
					<tr>
						<td>水钱</td>
						<td></td>
						<td><span id="cashback_money_b"></span></td>
						<td></td>
						<td><span id="cashback_money_s"></span></td>
						<td></td>
						<td><span id="cashback_money_a"></span></td>
						<td></td>
						<td><span id="cashback_money_3abc"></span></td>
						<td></td>
						<td><span id="cashback_money_4a"></span></td>
						<td></td>
						<td><span id="cashback_money_4abc"></span></td>
						<td></td>
						<td><span id="cashback_money_2a"></span></td>
						<td></td>
						<td><span id="cashback_money_2abc"></span></td>
					</tr>
					<tr>
						<td>头奖</td>
						<td>B</td>
						<td><input type="text" value="0" class="odds_b" name="odds[B][]" data-value="odds_b_0" onkeyup="keyupcheck(this)"></td>
						<td>S</td>
						<td><input type="text" value="0" class="odds_s" name="odds[S][]" data-value="odds_s_0" onkeyup="keyupcheck(this)"></td>
						<td>A</td>
						<td><input type="text" value="0" class="odds_a" name="odds[A][]" data-value="odds_a" onkeyup="keyupcheck(this)"></td>
						<td>3ABC</td>
						<td><input type="text" value="0" class="odds_3abc" name="odds[3ABC][]" data-value="odds_3abc_0" onkeyup="keyupcheck(this)"></td>
						<td>4A</td>
						<td><input type="text" value="0" class="odds_4a" name="odds[4A][]" data-value="odds_4a" onkeyup="keyupcheck(this)"></td>
						<td>4AC</td>
						<td><input type="text" value="0" class="odds_4abc" name="odds[4ABC][]" data-value="odds_4abc_0" onkeyup="keyupcheck(this)"></td>
						<td>2A</td>
						<td><input type="text" value="0" class="odds_2a" name="odds[2A][]" data-value="odds_2a" onkeyup="keyupcheck(this)"></td>
						<td>2ABC</td>
						<td><input type="text" value="0" class="odds_2abc" name="odds[2ABC][]" data-value="odds_2abc_0" onkeyup="keyupcheck(this)"></td>
					</tr>
					<tr>
						<td>二奖</td>
						<td>B</td>
						<td><input type="text" value="0" class="odds_b" name="odds[B][]" data-value="odds_b_1" onkeyup="keyupcheck(this)"></td>
						<td>S</td>
						<td><input type="text" value="0" class="odds_s" name="odds[S][]" data-value="odds_s_1" onkeyup="keyupcheck(this)"></td>
						<td>C2</td>
						<td><input type="text" value="0" class="odds_a" name="odds[C2][]" data-value="odds_c2" onkeyup="keyupcheck(this)"></td>
						<td>3ABC</td>
						<td><input type="text" value="0" class="odds_3abc" name="odds[3ABC][]" data-value="odds_3abc_1" onkeyup="keyupcheck(this)"></td>
						<td>4B</td>
						<td><input type="text" value="0" class="odds_4a" name="odds[4B][]" data-value="odds_4b" onkeyup="keyupcheck(this)"></td>
						<td>4AC</td>
						<td><input type="text" value="0" class="odds_4abc" name="odds[4ABC][]" data-value="odds_4abc_1" onkeyup="keyupcheck(this)"></td>
						<td>2B</td>
						<td><input type="text" value="0" class="odds_2a" name="odds[2B][]" data-value="odds_2b" onkeyup="keyupcheck(this)"></td>
						<td>2ABC</td>
						<td><input type="text" value="0" class="odds_2abc" name="odds[2ABC][]" data-value="odds_2abc_1" onkeyup="keyupcheck(this)"></td>
					</tr>
					<tr>
						<td>三奖</td>
						<td>B</td>
						<td><input type="text" value="0" class="odds_b" name="odds[B][]" data-value="odds_b_2" onkeyup="keyupcheck(this)"></td>
						<td>S</td>
						<td><input type="text" value="0" class="odds_s" name="odds[S][]" data-value="odds_s_2" onkeyup="keyupcheck(this)"></td>
						<td>C3</td>
						<td><input type="text" value="0" class="odds_a" name="odds[C3][]" data-value="odds_c3" onkeyup="keyupcheck(this)"></td>
						<td>3ABC</td>
						<td><input type="text" value="0" class="odds_3abc" name="odds[3ABC][]" data-value="odds_3abc_2" onkeyup="keyupcheck(this)"></td>
						<td>4C</td>
						<td><input type="text" value="0" class="odds_4a" name="odds[4C][]" data-value="odds_4c" onkeyup="keyupcheck(this)"></td>
						<td>4AC</td>
						<td><input type="text" value="0" class="odds_4abc" name="odds[4ABC][]" data-value="odds_4abc_2" onkeyup="keyupcheck(this)"></td>
						<td>2C</td>
						<td><input type="text" value="0" class="odds_2a" name="odds[2C][]" data-value="odds_2c" onkeyup="keyupcheck(this)"></td>
						<td>2ABC</td>
						<td><input type="text" value="0" class="odds_2abc" name="odds[2ABC][]" data-value="odds_2abc_2" onkeyup="keyupcheck(this)"></td>
					</tr>
					<tr>
						<td>特别奖</td>
						<td>B</td>
						<td><input type="text" value="0" class="odds_b" name="odds[B][]" data-value="odds_b_3" onkeyup="keyupcheck(this)"></td>
						<td></td>
						<td></td>
						<td>C4</td>
						<td><input type="text" value="0" class="odds_a" name="odds[C4][]" data-value="odds_c4" onkeyup="keyupcheck(this)"></td>
						<td></td>
						<td></td>
						<td>4D</td>
						<td><input type="text" value="0" class="odds_4a" name="odds[4D][]" data-value="odds_4d" onkeyup="keyupcheck(this)"></td>
						<td></td>
						<td></td>
						<td>2D</td>
						<td><input type="text" value="0" class="odds_2a" name="odds[2D][]" data-value="odds_2d" onkeyup="keyupcheck(this)"></td>
						<td></td>
						<td></td>
					</tr>
					<tr>
						<td>安慰奖</td>
						<td>B</td>
						<td><input type="text" value="0" class="odds_b" name="odds[B][]" data-value="odds_b_4" onkeyup="keyupcheck(this)"></td>
						<td></td>
						<td></td>
						<td>C5</td>
						<td><input type="text" value="0" class="odds_a" name="odds[C5][]" data-value="odds_c5" onkeyup="keyupcheck(this)"></td>
						<td></td>
						<td></td>
						<td>4E</td>
						<td><input type="text" value="0" class="odds_4a" name="odds[4E][]" data-value="odds_4e" onkeyup="keyupcheck(this)"></td>
						<td></td>
						<td></td>
						<td>2E</td>
						<td><input type="text" value="0" class="odds_2a" name="odds[2E][]" data-value="odds_2e" onkeyup="keyupcheck(this)"></td>
						<td></td>
						<td></td>
					</tr>
					<tr>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td>EC</td>
						<td><input type="text" value="0" class="odds_a" name="odds[EC][]" data-value="odds_ec" onkeyup="keyupcheck(this)"></td>
						<td></td>
						<td></td>
						<td>EA</td>
						<td><input type="text" value="0" class="odds_4a" name="odds[EA][]" data-value="odds_ea" onkeyup="keyupcheck(this)"></td>
						<td></td>
						<td></td>
						<td>EX</td>
						<td><input type="text" value="0" class="odds_2a" name="odds[EX][]" data-value="odds_ex" onkeyup="keyupcheck(this)"></td>
						<td></td>
						<td></td>
					</tr>
				</table>
			</div>
			<div style="height: 20%;">
				<div style="width: 25%;height: 100%;float: left;">
					<button type="button" class="btn" id="btn1" onclick="add_player('<?php  echo $this->createMobileUrl('add_player',array('agent_id'=>$_GPC['agent_id']))?>');">确认添加</button>
				</div>
				<div style="width: 25%;height: 100%;float: left;">
					<button type="button" class="btn" onclick="$('.save-area').show();">保存配置</button>
				</div>
				<div style="width: 25%;height: 100%;float: left;">
					<button type="button" class="btn" onclick="$('.get-area').show();">使用配置</button>
				</div>
				<div style="width: 25%;height: 100%;float: left;">
					<button type="button" id="btn2" class="btn" onclick="location.href = '<?php  echo $this->createMobileUrl('addrec')?>'">添加记录</button>
				</div>
			</div>
		</div>
		<?php  } ?>
	</div>
	<div class="save-area">
		<div class="save-div">
			<div class="save-title">
				<p>保存配置</p>
			</div>
			<div class="save-body">
				<input type="text" name="odds-title" placeholder="请输入配置名称" id="odds-title">
			</div>
			<div class="save-bottom">
				<div class="save-btn" style="border-right: 1px solid #ccc;">
					<a href="javascript:void(0);" onclick="save_odds('<?php  echo $this->createMobileUrl('save_odds')?>');">保存</a>
				</div>
				<div class="save-btn">
					<a href="javascript:void(0);" onclick="$('.save-area').hide();">取消</a>
				</div>
			</div>
		</div>
	</div>
	<div class="get-area">
		<div class="get-div">
			<div class="save-title">
				<p>选择配置<span style="float: right;color: #fff;" onclick="$('.get-area').hide();">&times;</span></p>
			</div>
			<div class="get-body">
				<table class="odds-table">
					<?php  if(is_array($odds)) { foreach($odds as $item) { ?>
					<tr onclick="use_odds('<?php  echo $this->createMobileUrl('get_odds')?>',<?php  echo $item['id'];?>);">
						<td><?php  echo $item['title'];?></td>
					</tr>
					<?php  } } ?>
					<tr onclick="$('.get-area').hide();">
						<td>取消</td>
					</tr>
				</table>
			</div>
		</div>
	</div>
	<script type="text/javascript" src="../addons/purchasing/static/js/agent.js"></script>
	<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('index', TEMPLATE_INCLUDEPATH)) : (include template('index', TEMPLATE_INCLUDEPATH));?>
</body>
</html>