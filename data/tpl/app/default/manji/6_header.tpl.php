<?php defined('IN_IA') or exit('Access Denied');?><!DOCTYPE html>
<html>
<head>
	<title>下注</title>
	<link rel="stylesheet" type="text/css" href="../addons/manji/static/css/bootstrap.min.css">
	<script type="text/javascript" src="../web/resource/js/lib/jquery-1.11.1.min.js"></script>
	<script type="text/javascript" src="../addons/purchasing/static/js/bootstrap.min.js"></script>
</head>
<body>
	<style type="text/css">
		body{font-size: 4vh;}
		.recharge-area{position: fixed;width: 100%;height: 100%;top: 0;left: 0;background: rgba(0,0,0,0.4);display: none;}
		.recharge-main{width: 100%;height: 100%;background: #fff;}
		.recharge-head{width: 100%;text-align: center;font-size: 20px;line-height: 30px;padding: 0 10px;}
		.recharge-body{width: 100%;overflow-y: auto;}
		.table>tbody>tr>td>input[type=text]{width: 100%;border: 0;height: 22px;text-align: center;}
		.table>tbody>tr.input-txt>td{padding: 1px;text-align: center;}
		.btn{border: 1px solid #3e3e3e;padding: 3px 7px;margin-right: 10px;}
		.recharge-body .table tbody tr td{border: 0;font-size: 4vh;padding: 1vh;}
		input[type=checkbox]{}
		.btn-red{background: #f00;}
		.btn-blue{background: #00f;}
		.btn-green{background: #0f0;}
		select{height: 100%;border: 0;height: 22px;}
		.pack{background: url(../addons/manji/static/images/icon.png) no-repeat;background-size: 100% 100%;border: #f00 solid 1px;}
		.navbar-nav>li>a{padding: 1vh;}
		.navbar{min-height: 6vh;}
	</style>
	<nav class="navbar navbar-default" role="navigation"> 
	    <div class="container-fluid"> 
	        <ul class="nav navbar-nav navbar-left">  
	            <li <?php  if($_GPC['do'] == 'xiazhu') { ?>class="active"<?php  } ?>><a href="<?php  echo $this->createMobileUrl('xiazhu')?>">投注</a></li>
	            <li <?php  if($_GPC['do'] == 'report') { ?>class="active"<?php  } ?>><a href="<?php  echo $this->createMobileUrl('report')?>">报告</a></li>
	            <li class="dropdown <?php  if($_GPC['do'] == 'order') { ?>active<?php  } ?>">
	            	<a class="dropdown-toggle" data-toggle="dropdown" href="#">单页</a>
					<ul class="dropdown-menu">
						<li><a href="<?php  echo $this->createMobileUrl('order',array('op'=>'search_order'))?>">游览单页</a></li>
				        <li><a href="<?php  echo $this->createMobileUrl('order')?>">全部单页</a></li>
				    </ul>
	            </li>
	            <li <?php  if($_GPC['do'] == 'reward') { ?>class="active"<?php  } ?>><a href="<?php  echo $this->createMobileUrl('reward')?>">成绩</a></li>
	            <li <?php  if($_GPC['do'] == 'win') { ?>class="active"<?php  } ?>><a href="<?php  echo $this->createMobileUrl('win')?>">彩金</a></li>
	        </ul> 
	        <ul class="nav navbar-nav navbar-right">
	        	<?php  if($_GPC['do'] == 'xiazhu') { ?>
	        	<li><span style="padding: 9px 8px;background: #00b0f0;line-height: 30px;">当前积分：<?php  echo $member['credit1'];?></span></li>
	        	<?php  } ?>
	            <li><a href="javascript:void(0);" onclick="logout()">登出</a></li> 
	        </ul> 
	    </div> 
	</nav>
	<script type="text/javascript">
		function logout() {
			$.post("<?php  echo $this->createMobileUrl('logout')?>",{},function(result) {
				if (result.status == 1) {
					location.href = "<?php  echo $this->createMobileUrl('login')?>";
				}
			},'JSON');
		}
	</script>