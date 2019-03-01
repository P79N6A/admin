<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('agent_header', TEMPLATE_INCLUDEPATH)) : (include template('agent_header', TEMPLATE_INCLUDEPATH));?>
<?php  if($op == 'display') { ?>
<div class="col-xs-12">
	<form class="form-inline" role="form" action="" method="get">
		<input type="hidden" name="c" value="entry">
		<input type="hidden" name="i" value="<?php  echo $_GPC['i'];?>">
		<input type="hidden" name="do" value="home">
		<input type="hidden" name="m" value="purchasing">
		<input type="hidden" name="op" value="display">
		<div class="col-xs-12" style="padding: 5px 0;">
			<div class="form-group">
				<label for="keyword">关键词</label>
				<input type="text" name="keyword" id="keyword" placeholder="请输入账号" class="form-control" value="<?php  echo $_GPC['keyword'];?>">
			</div>
			<div class="form-group">
				<input type="submit" name="search" class="btn" value="搜索">
			</div>
			<?php  if($can == 1) { ?>
			<div class="form-group">
				<a href="<?php  echo $this->createMobileUrl('home',array('op'=>'addAgent','agent_id'=>$_GPC['agent_id']))?>" class="btn">创建代理</a>
			</div>
			<div class="form-group">
				<a href="<?php  echo $this->createMobileUrl('home',array('op'=>'addMember','agent_id'=>$_GPC['agent_id']))?>" class="btn">创建会员</a>
			</div>
			<?php  } ?>
			<?php  if($user_id == $_SESSION['uid']) { ?>
			<div class="form-group">
				<?php  if($control == 1) { ?>
				<a href="javascript:void(0)" class="btn" style="background: #fff;color: #333;" onclick="set_control();">代下线开</a>
				<?php  } else { ?>
				<a href="javascript:void(0)" class="btn" onclick="set_control();">代下线关</a>
				<?php  } ?>
			</div>
			<?php  } ?>
		</div>
	</form>
	<table class="table table-bordered">
		<tr>
			<td style="border: 0;"><a href="javascript:history.back(-1)">返回</a>&nbsp;<a href="<?php  echo $this->createMobileUrl('home',array('op'=>'display'))?>">管理</a></td>
			<td class="text-right" style="border: 0;">代理账户：</td>
			<td colspan="5" style="border: 0;"><?php  echo $account;?></td>
		</tr>
		<tr>
			<td></td>
			<td>账号</td>
			<td>名称</td>
			<td>状态</td>
			<td>积分</td>
			<td>分红</td>
			<td>最后上线时间</td>
		</tr>
		<?php  if(is_array($list)) { foreach($list as $item) { ?>
		<tr>
			<td>
				<?php  if($item['user_type'] == 1) { ?>
				<a href="<?php  echo $this->createMobileUrl('home',array('op'=>'detail','agent_id'=>$item['id']))?>">更改</a>|<a href="<?php  echo $this->createMobileUrl('home',array('op'=>'display','agent_id'=>$item['id']))?>">下线(<?php  echo $item['child_num'];?>)</a>
				<?php  } else { ?>
				<a href="<?php  echo $this->createMobileUrl('member_detail',array('member_id'=>$item['id'],'agent_id'=>$_GPC['agent_id']))?>">更改</a>|下线(<?php  echo $item['child_num'];?>)
				<?php  } ?>
			</td>
			<td><?php  echo $item['account'];?></td>
			<td><?php  echo $item['nickname'];?></td>
			<td><?php  if($item['status'] == 0) { ?><span style="color: #0f0;">活跃</span><?php  } else if($item['status'] == 2) { ?><span style="color: #f00;">使用</span><?php  } else { ?><span style="color: #ccc">禁用</span><?php  } ?></td>
			<td><?php  echo $item['score'];?></td>
			<td><?php  if($item['user_type'] == 1) { ?><?php  echo $item['bonus'];?>%<?php  } else { ?>会员<?php  } ?></td>
			<td><?php  if($item['login_time']>0) { ?><?php  echo date('Y-m-d H:i:s',$item['login_time'])?><?php  } else { ?>没有登陆过<?php  } ?></td>
		</tr>
		<?php  } } ?>
	</table>
</div>
<script type="text/javascript">
	function set_control() {
			$.post("<?php  echo $this->createMobileUrl('control_set')?>",{},function(result) {
				alert(result.info);
				if (result.status == 5) {
					location.href = "<?php  echo $this->createMobileUrl('login')?>";
				}
				if (result.status == 1) {
					location.href = "<?php  echo $this->createMobileUrl('manager',array('op'=>'display','agent_id'=>$member['parent_agent']))?>";
				}
			},'JSON');
		}
</script>
<?php  } else if($op == 'detail') { ?>
<div class="col-xs-12">
	<div class="col-xs-12" style="padding: 10px 0;">
		<a href="<?php  echo $this->createMobileUrl('home',array('op'=>'detail','tab'=>'display','agent_id'=>$_GPC['agent_id']))?>" class="btn" <?php  if($tab == 'display') { ?>style="background:#fff;color: #333;"<?php  } ?>>反水</a>
		<a href="<?php  echo $this->createMobileUrl('home',array('op'=>'detail','tab'=>'charge','agent_id'=>$_GPC['agent_id']))?>" class="btn" <?php  if($tab == 'charge') { ?>style="background:#fff;color: #333;"<?php  } ?>>积分</a>
		<!-- <a href="<?php  echo $this->createMobileUrl('home',array('op'=>'detail','tab'=>'minus','agent_id'=>$_GPC['agent_id']))?>" class="btn" <?php  if($tab == 'minus') { ?>style="background:#fff;color: #333;"<?php  } ?>>减值</a> -->
		<a href="<?php  echo $this->createMobileUrl('home',array('op'=>'detail','tab'=>'limit','agent_id'=>$_GPC['agent_id']))?>" class="btn" <?php  if($tab == 'limit') { ?>style="background:#fff;color: #333;"<?php  } ?>>限额</a>
		<a href="<?php  echo $this->createMobileUrl('home',array('op'=>'detail','tab'=>'password','agent_id'=>$_GPC['agent_id']))?>" class="btn" <?php  if($tab == 'password') { ?>style="background:#fff;color: #333;"<?php  } ?>>名称密码</a>
	</div>
	<div class="col-xs-12" style="border: 1px solid #eee;">
		账号信息：<?php  echo $member['account'];?>(当前积分：<?php  echo $member['credit1'];?>)
	</div>
	<?php  if($tab == 'display') { ?>
	<style type="text/css" media="screen">
		table tr td input{width: 100%;}
	</style>
	<table class="table table-bordered">
		<tr>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td>分红</td>
			<td><input type="text" name="bonus" value="<?php  echo $bonus;?>"></td>
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
			<td style="width: 3vw;">反水</td>
			<td>B</td>
			<td><input type="text" name="cashback_b" value="<?php  echo $cash['B'];?>" class="cashback_agent"></td>
			<td>S</td>
			<td><input type="text" name="cashback_s" value="<?php  echo $cash['S'];?>" class="cashback_agent"></td>
			<td>A~EC</td>
			<td><input type="text" name="cashback_a" value="<?php  echo $cash['A'];?>" class="cashback_agent"></td>
			<td>3ABC</td>
			<td><input type="text" name="cashback_3abc" value="<?php  echo $cash['3ABC'];?>" class="cashback_agent"></td>
			<td>4A~EA</td>
			<td><input type="text" name="cashback_4a" value="<?php  echo $cash['4A'];?>" class="cashback_agent"></td>
			<td>4AC</td>
			<td><input type="text" name="cashback_4abc" value="<?php  echo $cash['4ABC'];?>" class="cashback_agent"></td>
			<td>2A~EX</td>
			<td><input type="text" name="cashback_2a" value="<?php  echo $cash['2A'];?>" class="cashback_agent"></td>
			<td>2ABC</td>
			<td><input type="text" name="cashback_2abc" value="<?php  echo $cash['2ABC'];?>" class="cashback_agent"></td>
		</tr>
		<tr>
			<td colspan="17">
				<input type="hidden" name="id" id="cuser_id" value="<?php  echo $_GPC['agent_id'];?>">
				<a href="javascript:void(0);" class="btn" onclick="cashback_post()">提交</a>
			</td>
		</tr>
	</table>
	<script type="text/javascript">
		function cashback_post() {
			var id = $('#cuser_id').val();
			var cashback_b = $('input[name=cashback_b]').val();
			var cashback_s = $('input[name=cashback_s]').val();
			var cashback_a = $('input[name=cashback_a]').val();
			var cashback_3abc = $('input[name=cashback_3abc]').val();
			var cashback_4a = $('input[name=cashback_4a]').val();
			var cashback_4abc = $('input[name=cashback_4abc]').val();
			var cashback_2a = $('input[name=cashback_2a]').val();
			var cashback_2abc = $('input[name=cashback_2abc]').val();
			var bonus = $('input[name=bonus]').val();
			var cashback = {"B":cashback_b,"S":cashback_s,"A":cashback_a,"3ABC":cashback_3abc,"4A":cashback_4a,"4ABC":cashback_4abc,"2A":cashback_2a,"2ABC":cashback_2abc};
			$.post("<?php  echo $this->createMobileUrl('set_percent')?>",{agent_id:id,cashback:cashback,bonus:bonus},function(result) {
				alert(result.info);
				if (result.status == 1) {
					location.href = "<?php  echo $this->createMobileUrl('manager',array('op'=>'display','agent_id'=>$member['parent_agent']))?>";
				}
				if (result.status == 3) {
					location.href = "<?php  echo $this->createMobileUrl('login')?>";
				}
			},'JSON');
		}
	</script>
	<?php  } else if($tab == 'charge') { ?>
	<table class="table">
		<tr>
			<td style="width: 5vw;text-align: right;">金额：</td>
			<td><input type="text" name="money" id="money"></td>
		</tr>
		<tr>
			<td colspan="2">
				<input type="hidden" name="id" id="user_id" value="<?php  echo $_GPC['agent_id'];?>" onkeyup="check_num(this);">
				<a href="javascript:void(0);" class="btn" onclick="recharge_post()">提交</a>
			</td>
		</tr>
	</table>
	<script type="text/javascript">
		function recharge_post() {
			var score = $('#money').val();
			var user_id = $('#user_id').val();
			if (score.indexOf('-') == 0) {
				var type = 2;
				score = score.replace(/\-/g,"");
			}
			else{
				var type = 1;
			}
			var user_type = 1;
			var agent_id = $('#agent_id').val();
			if (!score) {
				alert('请填写充值分数');
				return false;
			}
			$.post("<?php  echo $this->createMobileUrl('change_score')?>",{score:score,agent_id:user_id,score_type:type,user_type:user_type,user_id:agent_id},function (result) {
				if (result.status == 405) {
					alert(result.info);
					location.href = "<?php  echo $this->createMobileUrl('login')?>";
				}
				if (result.status == 300) {
					alert(result.info);
				}
				if (result.status == 200) {
					alert(result.info);
					location.href = "<?php  echo $this->createMobileUrl('manager',array('op'=>'display','agent_id'=>$member['parent_agent']))?>";
				}
			},'JSON')
		}
		function check_num(obj){
			obj.value = obj.value.replace(/[^\d.-]/g,""); //清除"数字"和"."以外的字符
			obj.value = obj.value.replace(/^\./g,""); //验证第一个字符是数字
			obj.value = obj.value.replace(/\.{2,}/g,"."); //只保留第一个, 清除多余的
			obj.value = obj.value.replace(/\-{2,}/g,"-"); //只保留第一个, 清除多余的
			obj.value = obj.value.replace(".","$#$").replace(/\./g,"").replace("$#$",".");
			obj.value = obj.value.replace("-","$#$").replace(/\-/g,"").replace("$#$","-");
			obj.value = obj.value.replace(/^(\-)*(\d+)\.(\d\d).*$/,'$1$2.$3'); //只能输入两个小数
			if (obj.value.indexOf('-') > 0) {
				obj.value = obj.value.replace(/\-/g,"");
			}
		}
	</script>
	<?php  } else if($tab == 'minus') { ?>
	<table class="table">
		<tr>
			<td style="width: 5vw;text-align: right;">减值金额：</td>
			<td><input type="text" name="money" id="money"></td>
		</tr>
		<tr>
			<td colspan="2">
				<input type="hidden" name="id" id="user_id" value="<?php  echo $_GPC['agent_id'];?>">
				<a href="javascript:void(0);" class="btn" onclick="recharge_post()">提交</a>
			</td>
		</tr>
	</table>
	<script type="text/javascript">
		function recharge_post() {
			var score = $('#money').val();
			var user_id = $('#user_id').val();
			var type = 2;
			var user_type = 1;
			var agent_id = $('#agent_id').val();
			if (!score) {
				alert('请填写减值分数');
				return false;
			}
			$.post("<?php  echo $this->createMobileUrl('change_score')?>",{score:score,agent_id:user_id,score_type:type,user_type:user_type,user_id:agent_id},function (result) {
				if (result.status == 405) {
					alert(result.info);
					location.href = "<?php  echo $this->createMobileUrl('login')?>";
				}
				if (result.status == 300) {
					alert(result.info);
				}
				if (result.status == 200) {
					alert(result.info);
					location.href = "<?php  echo $this->createMobileUrl('manager',array('op'=>'display','agent_id'=>$member['parent_agent']))?>";
				}
			},'JSON')
		}
	</script>
	<?php  } else if($tab == 'limit') { ?>
	<table class="table">
		<tr>
			<td style="width: 5vw;text-align: right;">限额金额：</td>
			<td><input type="text" name="limit" id="limit"></td>
		</tr>
		<tr>
			<td colspan="2">
				<input type="hidden" name="id" id="luser_id" value="<?php  echo $_GPC['agent_id'];?>">
				<a href="javascript:void(0);" class="btn" onclick="limit_post()">提交</a>
			</td>
		</tr>
	</table>
	<script type="text/javascript">
		function limit_post() {
			var limit = $('#limit').val();
			var id = $('#luser_id').val();
			$.post("<?php  echo $this->createMobileUrl('set_limit')?>",{id:id,limit:limit},function(result) {
				alert(result.info);
				if (result.status == 1) {
					location.href = "<?php  echo $this->createMobileUrl('manager',array('op'=>'display','agent_id'=>$member['parent_agent']))?>";
				}
				if (result.status == 3) {
					location.href = "<?php  echo $this->createMobileUrl('login')?>";
				}
			},'JSON');
		}
	</script>
	<?php  } else if($tab == 'password') { ?>
	<table class="table">
		<tr>
			<td style="width: 4vw;text-align: right;">密码：</td>
			<td><input type="text" name="password" id="password"></td>
		</tr>
		<tr>
			<td colspan="2">
				<input type="hidden" name="id" id="puser_id" value="<?php  echo $_GPC['agent_id'];?>">
				<input type="hidden" name="user_type" id="puser_type" value="1">
				<a href="javascript:void(0);" class="btn" onclick="password_post()">提交</a>
			</td>
		</tr>
	</table>
	<script type="text/javascript">
		function password_post() {
			var user_id = $('#puser_id').val();
			var user_type = $('#puser_type').val();
			var password = $('#password').val();
			if (!password || password == '') {
				alert('请输入密码');
				return false;
			}
			$.post("<?php  echo $this->createMobileUrl('set_password')?>",{user_id:user_id,user_type:user_type,password:password},function(result) {
				if (result.status == 405) {
					alert(result.info);
					location.href = "<?php  echo $this->createMobileUrl('login')?>";
				}
				if (result.status == 300) {
					alert(result.info);
				}
				if (result.status == 200) {
					alert(result.info);
					location.href = "<?php  echo $this->createMobileUrl('manager',array('op'=>'display','agent_id'=>$member['parent_agent']))?>";
				}
			},'JSON')
		}
	</script>
	<?php  } ?>
</div>
<?php  } else if($op == 'addAgent') { ?>
<style type="text/css" media="screen">
	table tr td input{width: 100%;height: 100%;border: 0;}
</style>
<div class="col-xs-12" style="padding: 5px 0;">
	<div class="slide-group">	
		<table class="table table-bordered">
			<tr>
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
		<table class="table table-bordered">
			<tr>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td>积分</td>
				<td><input type="text" name="credit" value="0"></td>
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
				<td style="width: 6vw;">上线反水</td>
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
				<td><input type="text" name="cashback[B]" value="0" class="cashback_agent"></td>
				<td>S</td>
				<td><input type="text" name="cashback[S]" value="0" class="cashback_agent"></td>
				<td>A~EC</td>
				<td><input type="text" name="cashback[A]" value="0" class="cashback_agent"></td>
				<td>3ABC</td>
				<td><input type="text" name="cashback[3ABC]" value="0" class="cashback_agent"></td>
				<td>4A~EA</td>
				<td><input type="text" name="cashback[4A]" value="0" class="cashback_agent"></td>
				<td>4AC</td>
				<td><input type="text" name="cashback[4ABC]" value="0" class="cashback_agent"></td>
				<td>2A~EX</td>
				<td><input type="text" name="cashback[2A]" value="0" class="cashback_agent"></td>
				<td>2ABC</td>
				<td><input type="text" name="cashback[2ABC]" value="0" class="cashback_agent"></td>
			</tr>
		</table>
	</div>
	<div style="height: 20%;">
		<div style="width: 50%;height: 100%;float: left;">
			<button type="button" class="btn" id="btn1" onclick="add_agent('<?php  echo $this->createMobileUrl('add_account',array('agent_id'=>$_GPC['agent_id']))?>');">确认添加</button>
		</div>
	</div>
</div>
<script type="text/javascript" src="../addons/purchasing/static/js/agent.js"></script>
<?php  } else if($op == 'addMember') { ?>
<style type="text/css">
	table tr td input{width: 100%;height: 100%;border: 0;}
	.save-area{width: 100%;height: 100%;background: rgba(0,0,0,0.4);top: 0;left: 0;position: fixed;display: none;}
	.save-div{width: 30%;background: #fff;margin: 15% auto;}
	.get-area{width: 100%;height: 100%;background: rgba(0,0,0,0.4);top: 0;left: 0;position: fixed;display: none;}
	.get-div{width: 30%;background: #fff;margin: 15% auto;}
	.save-title{height: 2vw;line-height: 2vw;text-align: center;background: #333;}
	.save-title p{font-size: 18px;color: #FFF;padding: 0 8px;}
	.save-body{padding: 8px;}
	.save-bottom{height: 1.5vw;width: 100%;border-top: 1px solid #ccc;}
	.save-btn{width: 50%;float: left;line-height: 1.5vw;height: 100%;text-align: center;}
	.save-btn a{color: #333;}
	.odds-table{width: 100%;text-align: center;}
	.odds-table tr td{padding: 4px 0;border-top: 1px solid #ccc;}
	#odds-title{width: 50%;margin: 0 auto;display: block;}
</style>
<div class="col-xs-12" style="padding: 5px 0;">
	<table class="table table-bordered">
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
	<table class="table table-bordered">
		<tr>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td>积分</td>
			<td><input type="text" name="credit" value="0"></td>
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
			<td>上线反水</td>
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
		<tr>
			<td>抽佣</td>
			<td></td>
			<td><input type="text" class="commission" value="0" ></td>
			<td></td>
			<td><input type="text" class="commission" value="0" ></td>
			<td></td>
			<td><input type="text" class="commission" value="0" ></td>
			<td></td>
			<td><input type="text" class="commission" value="0" ></td>
			<td></td>
			<td><input type="text" class="commission" value="0" ></td>
			<td></td>
			<td><input type="text" class="commission" value="0" ></td>
			<td></td>
			<td><input type="text" class="commission" value="0" ></td>
			<td></td>
			<td><input type="text" class="commission" value="0" ></td>
		</tr>
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
	<div style="width: 33%;height: 100%;float: left;">
		<button type="button" class="btn" id="btn1" onclick="add_player('<?php  echo $this->createMobileUrl('add_player',array('agent_id'=>$_GPC['agent_id']))?>');">确认添加</button>
	</div>
	<div style="width: 33%;height: 100%;float: left;">
		<button type="button" class="btn" onclick="$('.save-area').show();">保存配置</button>
	</div>
	<div style="width: 33%;height: 100%;float: left;">
		<button type="button" class="btn" onclick="$('.get-area').show();">使用配置</button>
	</div>
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
</div>
<?php  } ?>