<?php defined('IN_IA') or exit('Access Denied');?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<link href="../addons/purchasing/template/mobile/css/mui.min.css" rel="stylesheet" />
	<title>Document</title>
	<meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no" />
	<script type="text/javascript" src="../web/resource/js/lib/jquery-1.11.1.min.js"></script>
	<style>
	 *{margin:0;padding:0;}
	.mine-ui{width: 100%;height: 100%;display: block;}
	.mine-ui-main{width: 100%;height: 100%;}
	.header{width: 100%;height: 20%;background-color:#ffffff;}
	.tr1{width: 100%;height: 50%;}
	.td1{width: 50%;height: 100% ;text-align: center; border-style: none;float: left;background-color:#ffffff;}
	.mine-ui-content{width: 100%;height:50%;background-color: #ffffff;}
	.mine-nav{list-style: none;}
	.mine-nav li{border-bottom: 1px solid #eeeeee;padding-left: 3%;}
	.mine-ui-a{text-decoration: none;color: #333;width: 100%;display: block;}
	.mine-ui-button{outline: none; border:0 !important;background-color:#ffffff; line-height: 4vw;}
	.mine-ui-btm{width: 100%;height: 10%;background-color: #ffffff;padding-left: 3%;margin-top:1%;border-style: none; margin-bottom: 3%;}
	.peilv{width: 100%;height: 60%;background-color: #ffffff;display:none;text-align: center;}
	.table1{width: 100%;max-width: 100%;border: 1px solid #ddd;border-collapse:collapse; margin-bottom: 2%;}
	.table1 td{border: 1px solid #ddd;}
	.table1 td input{border:0 !important;margin: 0 auto;}
	.mypeilv{width: 100%;}
	.back-btn{width:10%; float: left; border: 0;background-color: #ffffff;font-size: 3vw;color: #988d8d;}
	</style>
</head>
<body style="background-color: #eeeeee;width: 100%;height: 100%">
	<div class="mine-ui" id="mine-ui">
		<div class="mine-ui-main" id="mine-ui">
			<div class="header">
				<div class="tr1">
					<div class="td1" style="width: 100%;">昵称：<?php  echo $user['nickname'];?></div>
				</div>
				<div class="td1" id="jifen" style="text-align: center; width: 100%;border-bottom: 25px solid #eee;">积分：<?php  echo $user['credit1'];?></div>
			</div>
			<div class="mine-ui-content">	
				<ul class="mine-nav">	
					<!-- <li><a href="javascript:void(0);" class="mine-ui-a" onclick="peilv1()"><input type="button" id="wodepeilv" class="mine-ui-button" value="我的赔率"></a></li> -->
					<li><a href="<?php  echo $this->createMobileUrl('xiaxiantotal')?>" class="mine-ui-a"><input type="button" class="mine-ui-button" value="下线账目"></a></li>
					<li><a href="<?php  echo $this->createMobileUrl('huiyuantotal')?>" class="mine-ui-a"><input type="button" class="mine-ui-button" value="会员账目"></a></li>
					<li><a href="<?php  echo $this->createMobileUrl('mybaobiaototal')?>" class="mine-ui-a"><input type="button" class="mine-ui-button" value="我的报表"></a></li>
					<!-- <li><a href="<?php  echo $this->createMobileUrl('baobiaototal')?>" class="mine-ui-a"><input type="button" class="mine-ui-button" value="下线报表"></a></li> -->
					<li><a href="<?php  echo $this->createMobileUrl('xiaxianrec')?>" class="mine-ui-a"><input type="button" class="mine-ui-button" value="查看下线充值记录"></a></li>
					<li><a href="<?php  echo $this->createMobileUrl('huiyuanrec')?>" class="mine-ui-a"><input type="button" class="mine-ui-button" value="查看会员充值记录"></a></li>
					<li><a href="javascript:void(0)" class="mine-ui-a" onclick="set_control();"><?php  if($user['parent_control'] == 0) { ?><input type="button" class="mine-ui-button" value="代下线关"><?php  } else { ?><input type="button" class="mine-ui-button" value="代下线开"><?php  } ?></a></li>
				</ul>
			</div>
			<div class="mine-ui-btm" ><a href="<?php  echo $this->createMobileUrl('logout')?>"><input type="button" id="exit" class="mine-ui-button" value="退出登录"></a></div>
		</div>
	</div>
	<script>
		function set_control() {
			$.post("<?php  echo $this->createMobileUrl('control_set')?>",{},function(result) {
				alert(result.info);
				if (result.status == 5) {
					location.href = "<?php  echo $this->createMobileUrl('login')?>";
				}
				if (result.status == 1) {
					window.location.reload();
				}
			},'JSON');
		}
	</script>
	<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('index', TEMPLATE_INCLUDEPATH)) : (include template('index', TEMPLATE_INCLUDEPATH));?>
</body>
</html>