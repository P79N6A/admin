<?php defined('IN_IA') or exit('Access Denied');?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>login</title>
	<meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no" />
	<style>
		.header{width: 100%;height: 30%;margin: 0 auto;}
		.ui-title{width: 100%;height:auto; font-size: 3vw;color: #000; display: inline-block;overflow: hidden;margin: 0 auto;text-align: center;font-weight: normal;box-shadow: 0 1px 0 1px #EEEEEE;}
		.login-content{padding-top:12%;background-color: white;}
		.input-center{width: 100%;height: 10%;text-align: center;font-size: 3vw;outline: none;}
		.btn_black{color: white;font-size:4vw; border: 1px solid #333333;background-color: #333333;border-radius: 15px;width: 80%;margin: auto 10%;}
		.btn_black:enabled:active{color: white;font-size:4vw; border: 1px solid #000000;background-color: #000000;border-radius: 15px;width: 80%;margin: 0 10%;}
	</style>
	<script type="text/javascript" src="../web/resource/js/lib/jquery-1.11.1.min.js"></script>
</head>
<body style="background-color: white; margin:0 auto; height:100%;width: 100%;font-family: 'Helvetica Neue', Helvetica, sans-serif;">
	<div class="header">
		<h1 class="ui-title">登录</h1>
	</div>
	<form action="" method="post">
		<div class="login-content">
			<div>
				<input type="text" name="account" id="account" class="input-center" style="border: none;" placeholder="请输入账号" >
			</div>
			<div style="border-top: 1px solid #EEEEEE;height:1px; margin:auto 20px;"></div>
			<div style="margin-top: 3%; ">
				<input type="password" name="password" id="password" class="input-center" style="border: none;" placeholder="请输入密码">
			</div>
			<div style="border-top: 1px solid #EEEEEE;height:1px; margin-left: 20px;margin-right: 20px;"></div>
			<input type="button" name="submit" id="login" class="btn_black" style="margin-top: 7%" value="登录">
		</div>
	</form>
	<script type="text/javascript">
		$('input[name=submit]').click(function() {
			var account = $('#account').val();
			var password = $('#password').val();
			$.post("<?php  echo $this->createMobileUrl('login')?>",{account:account,password:password},function(result) {
				if (result.status == 200) {
					window.location.href = "<?php  echo $this->createMobileUrl('xiazhu')?>";
				}
				else{
					alert(result.info);
				}
			},'JSON');
		})
	</script>
</body>
</html>