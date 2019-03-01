<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('header', TEMPLATE_INCLUDEPATH)) : (include template('header', TEMPLATE_INCLUDEPATH));?>
<style type="text/css">
	.btn{border: 1px solid #3e3e3e;background-color: #3e3e3e;border-radius: 20px;color: #fff;padding: 3px 7px;}
	.btn:hover{background: #fff;color: #333}
	a:hover{text-indent: none;}
	a{color: #333;}
</style>
<div class="col-xs-12">
	<div class="col-xs-12" style="padding: 10px 0;">
		<a href="<?php  echo $this->createMobileUrl('manager',array('op'=>'member','tab'=>'display','agent_id'=>$_GPC['agent_id']))?>" class="btn" <?php  if($tab == 'display') { ?>style="background:#fff;color: #333;"<?php  } ?>>反水</a>
		<a href="<?php  echo $this->createMobileUrl('manager',array('op'=>'member','tab'=>'charge','agent_id'=>$_GPC['agent_id']))?>" class="btn" <?php  if($tab == 'charge') { ?>style="background:#fff;color: #333;"<?php  } ?>>积分</a>
		<!-- <a href="<?php  echo $this->createMobileUrl('manager',array('op'=>'member','tab'=>'minus','agent_id'=>$_GPC['agent_id']))?>" class="btn" <?php  if($tab == 'minus') { ?>style="background:#fff;color: #333;"<?php  } ?>>减值</a> -->
		<a href="<?php  echo $this->createMobileUrl('manager',array('op'=>'member','tab'=>'limit','agent_id'=>$_GPC['agent_id']))?>" class="btn" <?php  if($tab == 'limit') { ?>style="background:#fff;color: #333;"<?php  } ?>>限额</a>
		<a href="<?php  echo $this->createMobileUrl('manager',array('op'=>'member','tab'=>'password','agent_id'=>$_GPC['agent_id']))?>" class="btn" <?php  if($tab == 'password') { ?>style="background:#fff;color: #333;"<?php  } ?>>名称密码</a>
	</div>
	<div class="col-xs-12" style="border: 1px solid #eee;">
		账号信息：<?php  echo $member['account'];?>(积分：<?php  echo $member['credit1'];?>)
	</div>
	<?php  if($tab == 'display') { ?>
	<style type="text/css" media="screen">
		table tr td input{width: 100%;}
	</style>
	<table class="table table-bordered">
		<tr>
			<td>配套</td>
			<td colspan="16">
				<?php  if(is_array($odds)) { foreach($odds as $odd) { ?>
				<label style="min-width: 50px;">
					<input type="checkbox" name="odds_id" value="<?php  echo $odd['id'];?>" style="width: auto;" <?php  if(in_array($odd['id'],$agent_ids)) { ?> checked="checked" <?php  } ?>><?php  echo $odd['title'];?>
				</label>
				<?php  } } ?>
			</td>
		</tr>
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
			<td style="width: 3vw;">上线反水</td>
			<td>B</td>
			<td><?php  echo $parent_cashback['B'];?></td>
			<td>S</td>
			<td><?php  echo $parent_cashback['S'];?></td>
			<td>A~EC</td>
			<td><?php  echo $parent_cashback['A'];?></td>
			<td>3ABC</td>
			<td><?php  echo $parent_cashback['3ABC'];?></td>
			<td>4A~EA</td>
			<td><?php  echo $parent_cashback['4A'];?></td>
			<td>4AC</td>
			<td><?php  echo $parent_cashback['4ABC'];?></td>
			<td>2A~EX</td>
			<td><?php  echo $parent_cashback['2A'];?></td>
			<td>2ABC</td>
			<td><?php  echo $parent_cashback['2ABC'];?></td>
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
			var odds = [];
			var cashback_b = $('input[name=cashback_b]').val();
			var cashback_s = $('input[name=cashback_s]').val();
			var cashback_a = $('input[name=cashback_a]').val();
			var cashback_3abc = $('input[name=cashback_3abc]').val();
			var cashback_4a = $('input[name=cashback_4a]').val();
			var cashback_4abc = $('input[name=cashback_4abc]').val();
			var cashback_2a = $('input[name=cashback_2a]').val();
			var cashback_2abc = $('input[name=cashback_2abc]').val();
			var jackpot = $('input[name=jackpot]').val();
			var bonus = $('input[name=bonus]').val();
			var cashback = {"B":cashback_b,"S":cashback_s,"A":cashback_a,"3ABC":cashback_3abc,"4A":cashback_4a,"4ABC":cashback_4abc,"2A":cashback_2a,"2ABC":cashback_2abc};
			$('input[name=odds_id]:checked').each(function() {
				odds.push($(this).val());
			})
			$.post("<?php  echo $this->createMobileUrl('set_percent')?>",{agent_id:id,cashback:cashback,jackpot:jackpot,bonus:bonus,odds:odds},function(result) {
				alert(result.info);
				if (result.status == 1) {
					location.href = "<?php  echo $this->createMobileUrl('manager',array('op'=>'display','agent_id'=>$member['parent_agent']))?>";
				}
				if (result.status == 3) {
					location.href = "<?php  echo $this->createMobileUrl('login')?>";
				}
			},'JSON');
		}
		$('.cashback_agent').keyup(function() {
			num(this);
		})
		function num(obj){
			obj.value = obj.value.replace(/[^\d.]/g,""); //清除"数字"和"."以外的字符
			obj.value = obj.value.replace(/^\./g,""); //验证第一个字符是数字
			obj.value = obj.value.replace(/\.{2,}/g,"."); //只保留第一个, 清除多余的
			obj.value = obj.value.replace(".","$#$").replace(/\./g,"").replace("$#$",".");
		}
	</script>
	<?php  } else if($tab == 'charge') { ?>
	<table class="table">
		<tr>
			<td style="width: 5vw;text-align: right;">金额：</td>
			<td><input type="text" name="money" id="money" onkeyup="check_num(this);"></td>
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
			<td style="width: 4vw;text-align: right;">名称：</td>
			<td>
				<input type="text" name="nickname" id="nickname" value="<?php  echo $member['nickname'];?>">
			</td>
		</tr>
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
			var nickname = $('#nickname').val();
			$.post("<?php  echo $this->createMobileUrl('set_password')?>",{user_id:user_id,user_type:user_type,password:password,nickname:nickname},function(result) {
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