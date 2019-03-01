<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('header', TEMPLATE_INCLUDEPATH)) : (include template('header', TEMPLATE_INCLUDEPATH));?>
<style>
	.recharge-area{position: fixed;width: 100%;height: 100%;top: 0;left: 0;background: rgba(0,0,0,0.4);display: none;}
	.recharge-main{width: 50%;height: 20vw;margin: 5% auto;background: #fff;}
	.recharge-head{width: 100%;text-align: center;border-bottom: 1px solid #aaa;font-size: 20px;line-height: 30px;}
	.recharge-body{width: 100%;padding: 2vw 3vw;}
	.recharge-body table tbody tr td input{width: 80%;border: 0;}
	.btn{border: 1px solid #3e3e3e;background-color: #3e3e3e;border-radius: 20px;color: #fff;padding: 3px 7px;}
	a:hover{text-indent: none;}
	.btn:hover{background: #fff;color: #333}
</style>
<link rel="stylesheet" type="text/css" href="../addons/purchasing/static/css/bootstrap-datetimepicker.min.css">
<script type="text/javascript" src="../addons/purchasing/static/js/bootstrap-datetimepicker.min.js"></script>
<?php  if($op == 'display') { ?>
<div class="col-xs-12">
	<form class="form-inline" role="form" action="" method="get">
		<input type="hidden" name="c" value="entry">
		<input type="hidden" name="i" value="<?php  echo $_GPC['i'];?>">
		<input type="hidden" name="do" value="manager">
		<input type="hidden" name="m" value="purchasing">
		<input type="hidden" name="op" value="display">
		<div class="col-xs-12" style="padding: 5px 0;">
			<div class="form-group">
				<label for="keyword">关键词</label>
				<input type="text" name="keyword" id="keyword" placeholder="请输入代理人账号" class="form-control" value="<?php  echo $_GPC['keyword'];?>">
			</div>
			<div class="form-group">
				<input type="submit" name="search" class="btn btn-success" value="搜索">
			</div>
			<?php  if($can == 1) { ?>
			<?php  if($_SESSION['level'] > 3) { ?>
			<div class="form-group">
				<a href="<?php  echo $this->createMobileUrl('agent_list',array('op'=>'addAgent','agent_id'=>$_GPC['agent_id']))?>" class="btn">创建代理</a>
			</div>
			<?php  } ?>
			<?php  if($_SESSION['level'] > 4 || !empty($_GPC['agent_id'])) { ?>
			<div class="form-group">
				<a href="<?php  echo $this->createMobileUrl('agent_list',array('op'=>'addMember','agent_id'=>$_GPC['agent_id']))?>" class="btn">创建会员</a>
			</div>
			<?php  } ?>
			<?php  } ?>
		</div>
	</form>
	<table class="table table-bordered">
		<tr>
			<td style="border: 0;"><a href="<?php  echo $this->createMobileUrl('manager',array('op'=>'display','agent_id'=>$agent_info['parent_agent']))?>">返回</a>&nbsp;<a href="<?php  echo $this->createMobileUrl('manager',array('op'=>'display'))?>">管理</a></td>
			<td class="text-right" style="border: 0;">代理账户：</td>
			<td colspan="8" style="border: 0;"><?php  if($agent_id>0) { ?><?php  echo $account;?><?php  } ?></td>
		</tr>
		<tr>
			<td></td>
			<td>账号</td>
			<td>名称</td>
			<td>下注</td>
			<td>状态</td>
			<td>积分</td>
			<td>分红/配套(JUBAO/OTHER)</td>
			<td>最后修改时间</td>
			<td>最后上线时间</td>
			<td>登录IP</td>
		</tr>
		<?php  if(is_array($list)) { foreach($list as $item) { ?>
		<tr>
			<td>
				<?php  if($item['user_type'] == 1) { ?>
				<a href="<?php  echo $this->createMobileUrl('manager',array('op'=>'member','agent_id'=>$item['id']))?>">更改</a>|<a href="<?php  echo $this->createMobileUrl('manager',array('op'=>'display','agent_id'=>$item['id']))?>">下线(<?php  echo $item['child_num'];?>)</a>
				<?php  } else { ?>
				<a href="<?php  echo $this->createMobileUrl('manager',array('member_id'=>$item['id'],'agent_id'=>$_GPC['agent_id'],'op'=>member))?>">更改</a>|下线(<?php  echo $item['child_num'];?>)
				<?php  } ?>
			</td>
			<td><?php  echo $item['account'];?></td>
			<td><?php  echo $item['nickname'];?></td>
			<td><?php  if($item['user_type'] == 1) { ?>-<?php  } else { ?><a href="<?php  echo $this->createMobileUrl('pc_xiazhu',array('member_id'=>$item['id']))?>">下注</a><?php  } ?></td>
			<td>
				<?php  if($item['user_type'] == 2) { ?>
				<a href="javascript:void(0);" onclick="set_status(<?php  echo $item['id'];?>,<?php  echo $item['status'];?>)">
				<?php  } ?>
					<?php  if($item['status'] == 0) { ?>
					<span style="color: #0f0;">活跃</span>
					<?php  } else if($item['status'] == 2) { ?>
					<span style="color: #f00;">试用</span>
					<?php  } else { ?>
					<span style="color: #ccc">禁用</span>
					<?php  } ?>
				<?php  if($item['user_type'] == 2) { ?>
				</a>
				<?php  } ?>
			</td>
			<td><?php  echo $item['credit1']+$item['credit2']?></td>
			<td><?php  if($item['user_type'] == 1) { ?><?php  echo $item['bonus'];?>%/<?php echo $item['percent']?$item['percent']:0?>%<?php  } else { ?><?php  if(!empty($item['used_odds_j'])) { ?><a href="javascript:void(0);">ID:<?php  echo $item['used_odds_j']['pid'];?></a><?php  } else { ?>没有配套<?php  } ?>/<?php  if(!empty($item['used_odds_c'])>0) { ?><a href="javascript:void(0);" onclick="get_odds(<?php  echo $ud['id'];?>)">ID:<?php  echo $item['used_odds_c']['pid'];?></a><?php  } else { ?>没有配套<?php  } ?><?php  } ?></td>
			<td><?php  if($item['last_edit_time']>0) { ?><?php  echo date('Y-m-d H:i:s',$item['last_edit_time'])?><?php  } else { ?>没有修改过<?php  } ?></td>
			<td><?php  if($item['last_login_time']>0) { ?><?php  echo date('Y-m-d H:i:s',$item['last_login_time'])?><?php  } else { ?>没有登陆过<?php  } ?></td>
			<td><?php  echo $item['last_login_ip'];?></td>
		</tr>
		<?php  } } ?>
	</table>
	<?php  echo $pager;?>
	<div id="cashback-area" class="recharge-area">
		<div class="recharge-main" style="height: 25vw;">
			<div class="recharge-head">
				代理设置
			</div>
			<div class="recharge-body">
				<table class="table table-bordered">
					<tr>
						<td>账号</td>
						<td>
							<input type="text" name="account" value="">
						</td>
						<td>昵称</td>
						<td>
							<input type="text" name="nickname" value="">
						</td>
						<td>密码</td>
						<td>
							<input type="text" name="password" value="">
						</td>
						<td></td>
						<td></td>
					</tr>
					<tr>
						<td></td>
						<td></td>
						<td>彩金</td>
						<td>
							<input type="text" name="jackpot" value="0">
						</td>
						<td>分红</td>
						<td>
							<input type="text" name="bonus" value="0">
						</td>
						<td></td>
						<td></td>
					</tr>
					<tr>
						<td colspan="8" style="text-align: center;">反水</td>
					</tr>
					<tr>
						<td>B</td>
						<td>
							<input type="text" name="cashback_b" value="0" class="cashback_agent">
						</td>
						<td>S</td>
						<td>
							<input type="text" name="cashback_s" value="0" class="cashback_agent">
						</td>
						<td>3A~EC</td>
						<td>
							<input type="text" name="cashback_a" value="0" class="cashback_agent">
						</td>
						<td>3ABC</td>
						<td>
							<input type="text" name="cashback_3abc" value="0" class="cashback_agent">
						</td>
					</tr>
					<tr>
						<td>4A~EA</td>
						<td>
							<input type="text" name="cashback_4a" value="0" class="cashback_agent">
						</td>
						<td>4AC</td>
						<td>
							<input type="text" name="cashback_4abc" value="0" class="cashback_agent">
						</td>
						<td>2A~EX</td>
						<td>
							<input type="text" name="cashback_2a" value="0" class="cashback_agent">
						</td>
						<td>2ABC</td>
						<td>
							<input type="text" name="cashback_2abc" value="0" class="cashback_agent">
						</td>
					</tr>
					<tr>
						<td colspan="8">
							<input type="hidden" name="id" id="agent_id">
							<input type="hidden" name="parent_agent" id="parent_agent" value="<?php  echo $_GPC['agent_id'];?>">
							<a href="javascript:void(0);" class="btn" onclick="edit_post()">提交</a>
							<a href="javascript:void(0);" class="btn" onclick="$('#cashback-area').hide();">取消</a>
						</td>
					</tr>
				</table>
			</div>
		</div>
	</div>
	<div id="odds-set" class="recharge-area">
		<div class="recharge-main" style="height: 30vw;width: 90%;">
			<div class="recharge-head">
				会员赔率
				<a href="javascript:void(0);" onclick="$('#odds-set').hide();"><span style="float: right;margin-right: 15px;">&times;</span></a>
			</div>
			<div class="recharge-body">
				<table class="table table-bordered">
					<tr>
						<td>头奖</td>
						<td>B</td>
						<td><input type="text" class="odds_b" name="odds[B][]" data-value="odds_b_0" readonly="readonly" style="border: 0;"></td>
						<td>S</td>
						<td><input type="text" class="odds_s" name="odds[S][]" data-value="odds_s_0" readonly="readonly" style="border: 0;"></td>
						<td>A</td>
						<td><input type="text" class="odds_a" name="odds[A][]" data-value="odds_a" readonly="readonly" style="border: 0;"></td>
						<td>3ABC</td>
						<td><input type="text" class="odds_3abc" name="odds[3ABC][]" data-value="odds_3abc_0" readonly="readonly" style="border: 0;"></td>
						<td>4A</td>
						<td><input type="text" class="odds_4a" name="odds[4A][]" data-value="odds_4a" readonly="readonly" style="border: 0;"></td>
						<td>4AC</td>
						<td><input type="text" class="odds_4abc" name="odds[4ABC][]" data-value="odds_4abc_0" readonly="readonly" style="border: 0;"></td>
						<td>2A</td>
						<td><input type="text" class="odds_2a" name="odds[2A][]" data-value="odds_2a" readonly="readonly" style="border: 0;"></td>
						<td>2ABC</td>
						<td><input type="text" class="odds_2abc" name="odds[2ABC][]" data-value="odds_2abc_0" readonly="readonly" style="border: 0;"></td>
					</tr>
					<tr>
						<td>二奖</td>
						<td>B</td>
						<td><input type="text" class="odds_b" name="odds[B][]" data-value="odds_b_1" readonly="readonly" style="border: 0;"></td>
						<td>S</td>
						<td><input type="text" class="odds_s" name="odds[S][]" data-value="odds_s_1" readonly="readonly" style="border: 0;"></td>
						<td>C2</td>
						<td><input type="text" class="odds_a" name="odds[C2][]" data-value="odds_c2" readonly="readonly" style="border: 0;"></td>
						<td>3ABC</td>
						<td><input type="text" class="odds_3abc" name="odds[3ABC][]" data-value="odds_3abc_1" readonly="readonly" style="border: 0;"></td>
						<td>4B</td>
						<td><input type="text" class="odds_4a" name="odds[4B][]" data-value="odds_4b" readonly="readonly" style="border: 0;"></td>
						<td>4AC</td>
						<td><input type="text" class="odds_4abc" name="odds[4ABC][]" data-value="odds_4abc_1" readonly="readonly" style="border: 0;"></td>
						<td>2B</td>
						<td><input type="text" class="odds_2a" name="odds[2B][]" data-value="odds_2b" readonly="readonly" style="border: 0;"></td>
						<td>2ABC</td>
						<td><input type="text" class="odds_2abc" name="odds[2ABC][]" data-value="odds_2abc_1" readonly="readonly" style="border: 0;"></td>
					</tr>
					<tr>
						<td>三奖</td>
						<td>B</td>
						<td><input type="text" class="odds_b" name="odds[B][]" data-value="odds_b_2" readonly="readonly" style="border: 0;"></td>
						<td>S</td>
						<td><input type="text" class="odds_s" name="odds[S][]" data-value="odds_s_2" readonly="readonly" style="border: 0;"></td>
						<td>C3</td>
						<td><input type="text" class="odds_a" name="odds[C3][]" data-value="odds_c3" readonly="readonly" style="border: 0;"></td>
						<td>3ABC</td>
						<td><input type="text" class="odds_3abc" name="odds[3ABC][]" data-value="odds_3abc_2" readonly="readonly" style="border: 0;"></td>
						<td>4C</td>
						<td><input type="text" class="odds_4a" name="odds[4C][]" data-value="odds_4c" readonly="readonly" style="border: 0;"></td>
						<td>4AC</td>
						<td><input type="text" class="odds_4abc" name="odds[4ABC][]" data-value="odds_4abc_2" readonly="readonly" style="border: 0;"></td>
						<td>2C</td>
						<td><input type="text" class="odds_2a" name="odds[2C][]" data-value="odds_2c" readonly="readonly" style="border: 0;"></td>
						<td>2ABC</td>
						<td><input type="text" class="odds_2abc" name="odds[2ABC][]" data-value="odds_2abc_2" readonly="readonly" style="border: 0;"></td>
					</tr>
					<tr>
						<td>特别奖</td>
						<td>B</td>
						<td><input type="text" class="odds_b" name="odds[B][]" data-value="odds_b_3" readonly="readonly" style="border: 0;"></td>
						<td></td>
						<td></td>
						<td>C4</td>
						<td><input type="text" class="odds_a" name="odds[C4][]" data-value="odds_c4" readonly="readonly" style="border: 0;"></td>
						<td></td>
						<td></td>
						<td>4D</td>
						<td><input type="text" class="odds_4a" name="odds[4D][]" data-value="odds_4d" readonly="readonly" style="border: 0;"></td>
						<td></td>
						<td></td>
						<td>2D</td>
						<td><input type="text" class="odds_2a" name="odds[2D][]" data-value="odds_2d" readonly="readonly" style="border: 0;"></td>
						<td></td>
						<td></td>
					</tr>
					<tr>
						<td>安慰奖</td>
						<td>B</td>
						<td><input type="text" class="odds_b" name="odds[B][]" data-value="odds_b_4" readonly="readonly" style="border: 0;"></td>
						<td></td>
						<td></td>
						<td>C5</td>
						<td><input type="text" class="odds_a" name="odds[C5][]" data-value="odds_c5" readonly="readonly" style="border: 0;"></td>
						<td></td>
						<td></td>
						<td>4E</td>
						<td><input type="text" class="odds_4a" name="odds[4E][]" data-value="odds_4e" readonly="readonly" style="border: 0;"></td>
						<td></td>
						<td></td>
						<td>2E</td>
						<td><input type="text" class="odds_2a" name="odds[2E][]" data-value="odds_2e" readonly="readonly" style="border: 0;"></td>
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
						<td><input type="text" class="odds_a" name="odds[EC][]" data-value="odds_ec" readonly="readonly" style="border: 0;"></td>
						<td></td>
						<td></td>
						<td>EA</td>
						<td><input type="text" class="odds_4a" name="odds[EA][]" data-value="odds_ea" readonly="readonly" style="border: 0;"></td>
						<td></td>
						<td></td>
						<td>EX</td>
						<td><input type="text" class="odds_2a" name="odds[EX][]" data-value="odds_ex" readonly="readonly" style="border: 0;"></td>
						<td></td>
						<td></td>
					</tr>
				</table>
			</div>
		</div>
	</div>
	<script type="text/javascript">
		function recharge(id) {
			var money = $('#money'+id).val();
			if (!money) {
				alert('请填写充值金额');
				return false;
			}
			$.ajax({
				url:"<?php  echo $this->createMobileUrl('manager',array('op'=>'recharge'))?>",
				type:"POST",
				data:{id:id,money:money},
				success:function(data) {
					var data = $.parseJSON(data);
					console.log(data);
					if (data.status == 1) {
						alert('充值成功');
						window.location.reload();
					}
					else{
						alert('充值失败');
					}
				}
			})
		}
		function set_status(id,status) {
			$.post("<?php  echo $this->createMobileUrl('set_status')?>",{id:id,status:status},function(result) {
				if (result.status == 1) {
					window.location.reload();
				}
			},'JSON');
		}
		function edit(uid) {
			if (uid > 0) {
				$.post("<?php  echo $this->createMobileUrl('manager',array('op'=>'get_agent'))?>",{agent_id:uid},function(result) {
					if (result.status == 3) {
						location.href="<?php  echo $this->createMobileUrl('login')?>";
					}
					else{
						var list = result.list;
						var cashback = list.cashback_percent;
						var agent = result.agent;
						$('#agent_id').val(agent.id);
						$('input[name=account]').val(agent.account);
						$('input[name=nickname]').val(agent.nickname);
						$('input[name=jackpot]').val(list.jackpot_percent);
						$('input[name=bonus]').val(list.bonus_percent);
						$('input[name=cashback_b]').val(cashback.B);
						$('input[name=cashback_s]').val(cashback.S);
						$('input[name=cashback_a]').val(cashback['A']);
						$('input[name=cashback_3abc]').val(cashback['3ABC']);
						$('input[name=cashback_4a]').val(cashback['4A']);
						$('input[name=cashback_4abc]').val(cashback['4ABC']);
						$('input[name=cashback_2a]').val(cashback['2A']);
						$('input[name=cashback_2abc]').val(cashback['2ABC']);
						$('#cashback-area').show();
					}
				},'JSON')
			}
			else{
				$('#cashback-area').show();
			}
		}
		function edit_post() {
			var agent_id = $('#agent_id').val();
			var cashback = [];
			var jackpot = parseFloat($('input[name=jackpot]').val());
			var bonus = parseFloat($('input[name=bonus]').val());
			var account = $('input[name=account]').val();
			var nickname = $('input[name=nickname]').val();
			var password = $('input[name=password]').val();
			var parent_agent = $('#parent_agent').val();
			$('.cashback_agent').each(function () {
				cashback.push(parseFloat($(this).val()));

			})
			var cashback_percent = {'B':cashback[0],'S':cashback[1],'A':cashback[2],'3ABC':cashback[3],'4A':cashback[4],'4ABC':cashback[5],'2A':cashback[6],'2ABC':cashback[7]};
			console.log(cashback_percent);
			$.post("<?php  echo $this->createMobileUrl('manager',array('op'=>'agent_post'))?>",{jackpot:jackpot,bonus:bonus,cashback:cashback_percent,account:account,nickname:nickname,password:password,id:agent_id,parent_agent:parent_agent},function(result) {
				alert(result.message);
				if (result.type == 'success') {
					window.location.reload();
				}
			},'JSON');
		}
		function get_odds(id) {
			$.post("<?php  echo $this->createMobileUrl('get_member_odds')?>",{id:id},function(result) {
				var list = result.list;
				var odds_b = list.odds_B;
				var odds_s = list.odds_S;
				var odds_3abc = list.odds_3ABC;
				var odds_4abc = list.odds_4ABC;
				var odds_2abc = list.odds_2ABC;
				for (var i = 0 in odds_b) {
					$('input[data-value=odds_b_'+i+']').val(odds_b[i]);
				}
				for (var j = 0 in odds_s) {
					$('input[data-value=odds_s_'+j+']').val(odds_s[j]);
				}
				for (var k = 0 in odds_3abc) {
					$('input[data-value=odds_3abc_'+k+']').val(odds_3abc[k]);
				}
				for (var l = 0 in odds_4abc) {
					$('input[data-value=odds_4abc_'+l+']').val(odds_4abc[l]);
				}
				for (var m = 0 in odds_2abc) {
					$('input[data-value=odds_2abc_'+m+']').val(odds_2abc[m]);
				}
				$('input[data-value=odds_a]').val(list.odds_A);
				$('input[data-value=odds_c2]').val(list.odds_C2);
				$('input[data-value=odds_c3]').val(list.odds_C3);
				$('input[data-value=odds_c4]').val(list.odds_C4);
				$('input[data-value=odds_c5]').val(list.odds_C5);
				$('input[data-value=odds_4a]').val(list.odds_4A);
				$('input[data-value=odds_4b]').val(list.odds_4B);
				$('input[data-value=odds_4c]').val(list.odds_4C);
				$('input[data-value=odds_4d]').val(list.odds_4D);
				$('input[data-value=odds_4e]').val(list.odds_4E);
				$('input[data-value=odds_2a]').val(list.odds_2A);
				$('input[data-value=odds_2b]').val(list.odds_2B);
				$('input[data-value=odds_2c]').val(list.odds_2C);
				$('input[data-value=odds_2d]').val(list.odds_2D);
				$('input[data-value=odds_2e]').val(list.odds_2E);
				$('input[data-value=odds_ec]').val(list.odds_EC);
				$('input[data-value=odds_ea]').val(list.odds_EA);
				$('input[data-value=odds_ex]').val(list.odds_EX);
				$('#odds-set').show();
			},'JSON');
		}
		function limit_bet(id,type) {
			if (type == 1) {
				var a = confirm('确定限制该用户投注吗？');
			}
			else{
				var a = confirm('确定开放该用户投注吗？');
			}
			if (a == true) {
				$.post("<?php  echo $this->createMobileUrl('set_black')?>",{id:id,type:type},function(result) {
					alert(result.info);
					if (result.status == 1) {
						window.location.reload();
					}
					if (result.status == 3) {
						location.href="./index.php?i=6&c=entry&m=purchasing&do=login";
					}
				},'JSON');
			}
		}
		function get_odds(id) {
			$.post("<?php  echo $this->createMobileUrl('get_member_odds')?>",{id:id},function(result) {
				var list = result.list;
				var odds_b = list.odds_B;
				var odds_s = list.odds_S;
				var odds_3abc = list.odds_3ABC;
				var odds_4abc = list.odds_4ABC;
				var odds_2abc = list.odds_2ABC;
				for (var i = 0 in odds_b) {
					$('input[data-value=odds_b_'+i+']').val(odds_b[i]);
				}
				for (var j = 0 in odds_s) {
					$('input[data-value=odds_s_'+j+']').val(odds_s[j]);
				}
				for (var k = 0 in odds_3abc) {
					$('input[data-value=odds_3abc_'+k+']').val(odds_3abc[k]);
				}
				for (var l = 0 in odds_4abc) {
					$('input[data-value=odds_4abc_'+l+']').val(odds_4abc[l]);
				}
				for (var m = 0 in odds_2abc) {
					$('input[data-value=odds_2abc_'+m+']').val(odds_2abc[m]);
				}
				$('input[data-value=odds_a]').val(list.odds_A);
				$('input[data-value=odds_c2]').val(list.odds_C2);
				$('input[data-value=odds_c3]').val(list.odds_C3);
				$('input[data-value=odds_c4]').val(list.odds_C4);
				$('input[data-value=odds_c5]').val(list.odds_C5);
				$('input[data-value=odds_4a]').val(list.odds_4A);
				$('input[data-value=odds_4b]').val(list.odds_4B);
				$('input[data-value=odds_4c]').val(list.odds_4C);
				$('input[data-value=odds_4d]').val(list.odds_4D);
				$('input[data-value=odds_4e]').val(list.odds_4E);
				$('input[data-value=odds_2a]').val(list.odds_2A);
				$('input[data-value=odds_2b]').val(list.odds_2B);
				$('input[data-value=odds_2c]').val(list.odds_2C);
				$('input[data-value=odds_2d]').val(list.odds_2D);
				$('input[data-value=odds_2e]').val(list.odds_2E);
				$('input[data-value=odds_ec]').val(list.odds_EC);
				$('input[data-value=odds_ea]').val(list.odds_EA);
				$('input[data-value=odds_ex]').val(list.odds_EX);
				$('#odds-set').show();
			},'JSON');
		}
	</script>
</div>
<?php  } else if($op == 'lottery') { ?>
<div class="col-xs-12">
	<?php  if($tab == 'list') { ?>
	<style type="text/css" media="screen">
		#result .table tbody tr td input{border: 1px solid #ccc;width: 18%;display: inline-block;}
	</style>
	<form class="form-inline" role="form" action="" method="get">
		<input type="hidden" name="c" value="site">
		<input type="hidden" name="a" value="entry">
		<input type="hidden" name="do" value="lottery">
		<input type="hidden" name="m" value="manji">
		<div class="col-xs-12" style="padding: 5px 0;">
			<?php  if($_SESSION['level'] <= 2) { ?>
			<div class="form-group">
				<input type="button" name="search" class="btn" value="添加开奖" onclick="edit()">
			</div>
			<?php  } ?>
		</div>
	</form>
	<table class="table">
		<tr>
			<th>开彩期</th>
			<th>盘口</th>
			<th>公司</th>
            <th>日期</th>
			<th>操作</th>
		</tr>
		<?php  if(is_array($list)) { foreach($list as $item) { ?>
		<tr>
			<td><a href="javascript:void(0);" title="点击查看中奖详情"><?php  echo $item['periods'];?></a></td>
			<td><?php  echo $item['area'];?></td>
            <td><?php  echo $item['company'];?></td>
			<td><?php  echo $item['date'];?></td>
			<td>
				<a href="<?php  echo $this->createMobileUrl('manager',array('op'=>'lottery','tab'=>'detail','date'=>$item['date']))?>" title="点击查看中奖详情">查看成绩</a>
				<a href="javascript:void(0)" onclick="del('<?php  echo $item['date'];?>',<?php  echo $item['aid'];?>)">删除</a>
			</td>
		</tr>
		<?php  } } ?>
	</table>
	<?php  echo $pager;?>
	<div id="cashback-area" class="recharge-area">
		<div class="recharge-main" style="height: auto;">
			<div class="recharge-head">
				开奖设置
			</div>
			<div class="recharge-body" style="padding: 5px;">
				<table class="table">
					<tr>
						<td style="text-align: right;width: 100px;">开彩期：</td>
						<td>
							<input type="text" name="periods" value="" style="width: 200px;border: 1px solid #ccc;">
						</td>
					</tr>
					<tr>
						<td style="text-align: right;">公司：</td>
						<td id="company_area">
							<?php  if(is_array($company)) { foreach($company as $com) { ?>
							<label style="min-width: 60px;">
								<input type="checkbox" name="company" value="<?php  echo $com['id'];?>" style="width: 15px;">
								<?php  echo $com['name'];?>
							</label>
							<?php  } } ?>
						</td>
					</tr>
					<tr>
						<td style="text-align: right;">开奖日期：</td>
						<td>
							<input type="text" id="date" value="<?php  echo date('Y-m-d',time())?>" style="width: 200px;border: 1px solid #ccc;background: url(../addons/purchasing/static/images/date.jpg) no-repeat;background-position: right;background-size: auto 100%;" readonly="readonly">
						</td>
					</tr>
					<tr>
						<td colspan="2">
							<input type="hidden" name="id" id="id">
							<a href="javascript:void(0);" class="btn" onclick="edit_post()">提交</a>
							<a href="javascript:void(0);" class="btn" onclick="$('#cashback-area').hide();">取消</a>
						</td>
					</tr>
				</table>
			</div>
		</div>
	</div>
	<script type="text/javascript">
		var obj = [];
		var sdate = '2018-07-04';
		$.fn.datetimepicker.dates['zdy'] = {
	        days: ["星期日", "星期一", "星期二", "星期三", "星期四", "星期五", "星期六"],
	        daysShort: ["周日", "周一", "周二", "周三", "周四", "周五", "周六"],
	        daysMin:  ["日", "一", "二", "三", "四", "五", "六"],
	        months: ["1月","2月","3月","4月","5月","6月","7月","8月","9月","10月","11月","12月"],
	        monthsShort: ["1月","2月","3月","4月","5月","6月","7月","8月","9月","10月","11月","12月"],
	        today: "今天",
	        format:"yyyy-mm-dd",
	        titleFormat:"yyyy-mm-",
	        weekStart:1,
	        suffix: [],
	        meridiem: ["上午", "下午"]
	    };
	    $('#date').datetimepicker({
	        language:  'zdy',
	        weekStart: 1,
	        todayBtn:  1,
	        autoclose: 1,
	        startDate:sdate,
	        minView:2,
	        maxView:3,
	        onRenderDay: function(date) {
	        	var date1 = date.getFullYear()+'-'+(date.getMonth()<9?'0'+(date.getMonth()+1):date.getMonth()+1)+'-'+(date.getDate()<10?'0'+(date.getDate()-1):date.getDate()-1);
	        }
	    }).on('changeDate',function(ev) {
	    	var date = $('#date').val();
	    	var dstr = date.split('-');
	    	var period = dstr[2]+dstr[1]+dstr[0];
	    	$('input[name=periods]').val(period);
	    })
		function edit(id) {
			if (id > 0) {
				$.post("<?php  echo $this->createMobileUrl('manager',array('op'=>'get_periods'))?>",{id:id},function(result) {
					if (result.status == 3) {
						location.href="<?php  echo $this->createMobileUrl('login')?>";
					}
					else{
						var periods = result.periods;
						$('#id').val(periods.id);
						$('input[name=periods]').val(periods.periods);
						$('input[name=periods]').attr('readonly','readonly');
						$('#area').val(periods.area);
						$('#area').attr('disabled','disbaled');
						var txt = '<label>'+periods.company+'</label>';
						$('#date').val(periods.date);
						$('#company_area').html(txt);
						$('#cashback-area').show();
					}
				},'JSON')
			}
			else{
				$('input[name=periods]').val("<?php  echo date('dmY',time())?>");
				$('#date').val('');
				$('#area').val(0);
				$('#area').removeAttr('disabled','disbaled');
				$('input[name=periods]').removeAttr('readonly');
				$('#cashback-area').show();
			}
		}
		function edit_post() {
			var id = $('#id').val();
			var periods = $('input[name=periods]').val();
			var cid = [];
			var date = $('#date').val();
			var aid = $('#area').val();
			$('input[name=company]:checked').each(function() {
				cid.push($(this).val());
			})
			$.post("<?php  echo $this->createMobileUrl('manager',array('op'=>'lottery_post'))?>",{id:id,periods:periods,date:date,cid:cid,aid:aid},function(result) {
				alert(result.message);
				if (result.type == 'success') {
					window.location.reload();
				}
			},'JSON');
		}
		function start(id) {
			$('#result_id').val(id);
			$('#result').show();
		}
		function del(date,cid) {
			var checked = confirm('确定删除该期？');
			if (checked == true) {
				$.post("<?php  echo $this->createMobileUrl('period',array('op'=>'del'))?>",{date:date,cid:cid},function (result) {
					alert(result.info);
					if (result.status == 3) {
						location.href = "<?php  echo $this->createMobileUrl('login')?>";
					}
					if (result.status == 1) {
						window.location.reload();
					}
				},'JSON');
			}
		}
	</script>
	<?php  } else if($tab == 'preinstall') { ?>
	<table class="table" style="margin-top: 5px;">
		<tr>
			<th>公司</th>
			<th>预设截止时间</th>
            <th>预设开奖时间</th>
		</tr>
		<?php  if(is_array($company)) { foreach($company as $k => $item) { ?>
		<?php  if($item['id'] != 1 || $_SESSION['level'] == 1 || $_SESSION['cid'] == 1) { ?>
		<tr>
			<td>
				<?php  echo $item['name'];?>
				<input type="hidden" name="company" value="<?php  echo $item['id'];?>">
			</td>
			<td>
				<input type="time" name="stoptime" id="stoptime_<?php  echo $item['id'];?>" value="<?php  echo date('H:i:s',$item['stoptime']);?>" style="line-height: 20px;">
			</td>
            <td>
            	<input type="time" name="endtime" id="endtime_<?php  echo $item['id'];?>" value="<?php  echo date('H:i:s',$item['endtime']);?>" style="line-height: 20px;">
            </td>
		</tr>
		<?php  } ?>
		<?php  } } ?>
	</table>
	<button class="btn" type="button" onclick="save_set();">保存</button>
	<script type="text/javascript">
		function save_set() {
			var save = [];
			$('input[name=company]').each(function() {
				var id = $(this).val();
				save.push({id:id,stoptime:$('#stoptime_'+id).val(),endtime:$('#endtime_'+id).val()});
			})
			$.post("<?php  echo $this->createMobileUrl('manager',array('op'=>'lottery','tab'=>'preinstall'))?>",{save:save},function(result) {
				alert(result.info);
				if (result.status ==3) {
					location.href = "<?php  echo $this->createMobileUrl('login')?>";
				}
				if (result.status == 1) {
					window.location.reload();
				}
			},'JSON');
		}
	</script>
	<?php  } else if($tab == 'detail') { ?>
	<style type="text/css">
		input[type=text]{width: 100px;}
	</style>
	<form action="" method="get" class="form-horizontal" role="form">
		<input type="hidden" name="c" value="entry">
		<input type="hidden" name="i" value="<?php  echo $_GPC['i'];?>">
		<input type="hidden" name="m" value="purchasing">
		<input type="hidden" name="do" value="manager">
		<input type="hidden" name="op" value="lottery">
		<input type="hidden" name="tab" value="detail">
		<div class="form-group">
			<div class="col-xs-8 col-sm-8 col-md-8 col-lg-11 ">
				日期
				<input type="text" name="date" id="date" value="<?php  echo $date;?>" style="width: 200px;border: 1px solid #ccc;background: url(../addons/purchasing/static/images/date.jpg) no-repeat;background-position: right;background-size: auto 100%;" readonly="readonly">
				<?php  if($_SESSION['level'] == 1) { ?>
				盘口
				<select name="aid">
					<?php  if(is_array($area)) { foreach($area as $a) { ?>
					<option value="<?php  echo $a['id'];?>"><?php  echo $a['area_name'];?></option>
					<?php  } } ?>
				</select>
				<?php  } ?>
				<input type="submit" name="submit" value="搜索" class="btn">
			</div>
		</div>
	</form>
	<?php  if(is_array($list)) { foreach($list as $item) { ?>
	<table class="table">
		<tr><td colspan="2"><?php  echo $item['nickname'];?><input type="hidden" name="period_id" value="<?php  echo $item['id'];?>"></td></tr>
		<tr>
			<td style="width: 80px;">头等奖</td>
			<td><input type="text" name="first" id="first_<?php  echo $item['id'];?>" value="<?php  echo $item['first_no'];?>" maxlength="4" onkeyup = "value=value.replace(/[^\d]/g,'')" onchange="set_6d(<?php  echo $item['id'];?>)" <?php  if($item['cid']==1 && $_SESSION['level'] >1) { ?>disabled<?php  } ?>></td>
		</tr>
		<tr>
			<td style="width: 80px;">二等奖</td>
			<td><input type="text" name="secound" id="secound_<?php  echo $item['id'];?>" value="<?php  echo $item['second_no'];?>" maxlength="4" onkeyup = "value=value.replace(/[^\d]/g,'')" onchange="set_6d(<?php  echo $item['id'];?>)" <?php  if($item['cid']==1 && $_SESSION['level'] >1) { ?>disabled<?php  } ?>></td>
		</tr>
		<tr>
			<td style="width: 80px;">三等奖</td>
			<td><input type="text" name="third" id="third_<?php  echo $item['id'];?>" value="<?php  echo $item['third_no'];?>" maxlength="4" onkeyup = "value=value.replace(/[^\d]/g,'')" onchange="set_6d(<?php  echo $item['id'];?>)" <?php  if($item['cid']==1 && $_SESSION['level'] >1) { ?>disabled<?php  } ?>></td>
		</tr>
		<tr>
			<td style="width: 80px;">特别奖</td>
			<td>
				<?php  if(is_array($item['special_no'])) { foreach($item['special_no'] as $k => $sp) { ?>
				<input type="text" name="special" id="special_<?php  echo $item['id'];?>_<?php  echo $k;?>" value="<?php  echo $sp;?>" maxlength="4" onkeyup = "value=value.replace(/[^\d]/g,'')" <?php  if($item['cid']==1 && $_SESSION['level'] >1) { ?>disabled<?php  } ?>>
				<?php  } } ?>
			</td>
		</tr>
		<tr>
			<td style="width: 80px;">安慰奖</td>
			<td>
				<?php  if(is_array($item['consolation_no'])) { foreach($item['consolation_no'] as $l => $con) { ?>
				<input type="text" name="consolation" id="consolation_<?php  echo $item['id'];?>_<?php  echo $l;?>" value="<?php  echo $con;?>" maxlength="4" onkeyup = "value=value.replace(/[^\d]/g,'')" <?php  if($item['cid']==1 && $_SESSION['level'] >1) { ?>disabled<?php  } ?>>
				<?php  } } ?>
			</td>
		</tr>
		<?php  if(!empty($item['5D'])) { ?>
		<tr>
			<td colspan="2">5D成绩</td>
		</tr>
		<tr>
			<td>1st</td>
			<td>
				<input type="text" name="5D" id="5D_<?php  echo $item['id'];?>_0" value="<?php  echo $item['5D']['0'];?>" maxlength="5" onkeyup = "value=value.replace(/[^\d]/g,'')" <?php  if($item['cid']==1 && $_SESSION['level'] >1) { ?>disabled<?php  } ?>>
			</td>
		</tr>
		<tr>
			<td>2nd</td>
			<td>
				<input type="text" name="5D" id="5D_<?php  echo $item['id'];?>_1" value="<?php  echo $item['5D']['1'];?>" maxlength="5" onkeyup = "value=value.replace(/[^\d]/g,'')" <?php  if($item['cid']==1 && $_SESSION['level'] >1) { ?>disabled<?php  } ?>>
			</td>
		</tr>
		<tr>
			<td>3rd</td>
			<td>
				<input type="text" name="5D" id="5D_<?php  echo $item['id'];?>_2" value="<?php  echo $item['5D']['2'];?>" maxlength="5" onkeyup = "value=value.replace(/[^\d]/g,'')" <?php  if($item['cid']==1 && $_SESSION['level'] >1) { ?>disabled<?php  } ?>>
			</td>
		</tr>
		<?php  } ?>
		<?php  if($item['has_6D'] == 1) { ?>
		<tr>
			<td>6D</td>
			<td>
				<input type="text" name="6D" id="6D_<?php  echo $item['id'];?>" value="<?php  echo $item['6D'];?>" maxlength="6" readonly="readonly">
			</td>
		</tr>
		<?php  } ?>
	</table>
	<?php  } } ?>
	<button class="btn" onclick="save_result();">保存</button>
	<script src="../DateBox/required.js" type="text/javascript" charset="utf-8"></script>
	<script type="text/javascript">
		var obj = [];
		var sdate = '2018-07-04';
		$.fn.datetimepicker.dates['zdy'] = {
	        days: ["星期日", "星期一", "星期二", "星期三", "星期四", "星期五", "星期六"],
	        daysShort: ["周日", "周一", "周二", "周三", "周四", "周五", "周六"],
	        daysMin:  ["日", "一", "二", "三", "四", "五", "六"],
	        months: ["1月","2月","3月","4月","5月","6月","7月","8月","9月","10月","11月","12月"],
	        monthsShort: ["1月","2月","3月","4月","5月","6月","7月","8月","9月","10月","11月","12月"],
	        today: "今天",
	        format:"yyyy-mm-dd",
	        titleFormat:"yyyy-mm-",
	        weekStart:1,
	        suffix: [],
	        meridiem: ["上午", "下午"]
	      };
	    $('#date').datetimepicker({
	        language:  'zdy',
	        weekStart: 1,
	        todayBtn:  1,
	        autoclose: 1,
	        startDate:sdate,
	        minView:2,
	        maxView:3,
	        onRenderDay: function(date) {
	          var date1 = date.getFullYear()+'-'
	            +(date.getMonth()<9?'0'+(date.getMonth()+1):date.getMonth()+1)
	            +'-'
	            +(date.getDate()<10?'0'+(date.getDate()-1):date.getDate()-1);

	        }
	    })
	    function save_result() {
	    	var periods = [];
	    	var date = $('input[name=date]').val();
	    	$('input[name=period_id]').each(function() {
	    		var id = $(this).val();
	    		var first = $('#first_'+id).val();
	    		var secound = $('#secound_'+id).val();
	    		var third = $('#third_'+id).val();
	    		var special = [];
	    		var consolation = [];
	    		var D5 = [];
	    		var D6 = $('#6D_'+id).val();
	    		for (var i = 0; i < 10; i++) {
	    			special.push($('#special_'+id+'_'+i).val());
	    			consolation.push($('#consolation_'+id+'_'+i).val())
	    		}
	    		for (var j = 0; j < 6; j++) {
	    			D5.push($('#5D_'+id+'_'+j).val());
	    		}
	    		periods.push({id:id,first:first,secound:secound,third:third,special:special,consolation:consolation,D5:D5,D6:D6});
	    	})
	    	$.post("<?php  echo $this->createMobileUrl('set_result')?>",{periods:periods,date:date},function(result) {
	    		alert(result.message);
	    		if (result.type == 'success') {
	    			window.location.reload();
	    		}
	    	},'JSON');
	    }
	    function set_6d(id) {
	    	var first = $('#first_'+id).val();
	    	var secound = $('#secound_'+id).val();
	    	var third = $('#third_'+id).val();
	    	var D6 = first.slice(2)+secound.slice(2)+third.slice(2);
	    	$('#6D_'+id).val(D6);
	    }
	</script>
	<?php  } else if($tab == 'special') { ?>
	<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('lottery_control', TEMPLATE_INCLUDEPATH)) : (include template('lottery_control', TEMPLATE_INCLUDEPATH));?>
	<?php  } ?>
</div>
<?php  } else if($op == 'agent_earn') { ?>
<style type="text/css">
	.main{width: auto;}
</style>
<div class="col-xs-12" style="width: 150%;">
	<form class="form-inline" role="form" action="<?php  echo $this->createMobileUrl('manager',array('op'=>'agent_earn'))?>" method="get">
		<input type="hidden" name="c" value="<?php  echo $_GPC['c'];?>">
		<input type="hidden" name="i" value="<?php  echo $_GPC['i'];?>">
		<input type="hidden" name="do" value="<?php  echo $_GPC['do'];?>">
		<input type="hidden" name="m" value="<?php  echo $_GPC['m'];?>">
		<input type="hidden" name="tab" value="<?php  echo $_GPC['tab'];?>">
		<input type="hidden" name="op" value="agent_earn">
		<div class="form-group" style="padding: 5px 0;">
			日期:
			<input type="text" name="time" id="starttime" readonly="readonly" value="<?php  echo $time;?>"  style="background: url(../addons/purchasing/static/images/date.jpg) no-repeat;background-position: right;background-size: auto 100%;">
			<div class="form-group">
				<input type="submit" name="search" class="btn btn-success" value="搜索">
				<input type="submit" name="excel" class="btn" value="下载Excel">
			</div>
		</div>
	</form>
	<?php  if(is_array($company)) { foreach($company as $com) { ?>
	<div class="col-xs-12" style="padding: 0 0 10px;width: auto;">
		<?php  if(is_array($com['list'])) { foreach($com['list'] as $i => $item) { ?>
		<table class="table table-bordered" style="width: 150px;float: left;overflow-y: auto;max-height: 60%;margin-right: 4px;">
			<tr>
				<td colspan="2"><?php  echo $com['nickname'];?>/<?php  echo $i;?></td>
			</tr>
			<tr>
				<td>号码</td>
				<td>投注额</td>
			</tr>
			<?php  if(is_array($item)) { foreach($item as $it) { ?>
			<tr>
				<td>
					<a href="javascript:void(0);" onclick="number_detail(<?php  echo $it['number'];?>,<?php  echo $com['id'];?>);"><?php  echo $it['number'];?></a>
				</td>
				<td><a href="javascript:void(0);" onclick="number_detail(<?php  echo $it['number'];?>,<?php  echo $com['id'];?>);"><?php  echo $it[$i];?></a></td>
			</tr>
			<?php  } } ?>
		</table>
		<?php  } } ?>
	</div>
	<?php  } } ?>
</div>
<script type="text/javascript">
	var obj = [];
	var sdate = '2018-07-04';
	$.fn.datetimepicker.dates['zdy'] = {
        days: ["星期日", "星期一", "星期二", "星期三", "星期四", "星期五", "星期六"],
        daysShort: ["周日", "周一", "周二", "周三", "周四", "周五", "周六"],
        daysMin:  ["日", "一", "二", "三", "四", "五", "六"],
        months: ["1月","2月","3月","4月","5月","6月","7月","8月","9月","10月","11月","12月"],
        monthsShort: ["1月","2月","3月","4月","5月","6月","7月","8月","9月","10月","11月","12月"],
        today: "今天",
        format:"yyyy-mm-dd",
        titleFormat:"yyyy-mm-",
        weekStart:1,
        suffix: [],
        meridiem: ["上午", "下午"]
      };
      $('#starttime').datetimepicker({
        language:  'zdy',
        weekStart: 1,
        todayBtn:  1,
        autoclose: 1,
        startDate:sdate,
        minView:2,
        maxView:3,
        onRenderDay: function(date) {
          var date1 = date.getFullYear()+'-'
            +(date.getMonth()<9?'0'+(date.getMonth()+1):date.getMonth()+1)
            +'-'
            +(date.getDate()<10?'0'+(date.getDate()-1):date.getDate()-1);

        }
      }).on('changeDate', function(ev){
        $('#endDate').datetimepicker('remove');
        $('#endDate').val('');
        var sdate=$("#starttime").val();
        var edate;
        for(var o in obj){
          if(new Date(sdate)<=new Date(obj[o])){
            var date = new Date(obj[o])
            var ndate = +date+24*60*60*1000;
            var leaveTime = new Date(ndate);
            edate = leaveTime.getFullYear()+'-'+(leaveTime.getMonth()+1)+'-'+leaveTime.getDate();

            break;
          }
        }
        $('#endDate').datetimepicker({
          language:  'zdy',
          weekStart: 1,
          todayBtn:  1,
          autoclose: 1,
          startDate:sdate,
          endDate:edate,
          minView:2,
          maxView:3
        }).on('changeDate', function(ev){

        });
      });
	$("#endDate").click(function(){
	    if($("#startDate").val()!=''){

	    }else{
	      showMsg('请选择日期');
	    }
	});
</script>
<?php  } else if($op == 'report') { ?>
<div class="col-xs-12">
	<?php  if($tab == 'reward') { ?>
	<form action="<?php  echo $this->createMobileUrl('manager',array('op'=>'report','tab'=>'income'));?>" class="form-inline" role="form" method="get">
		<table class="table table-bordered" style="margin-top: 10px;">
			<tr class="active">
				<td>中奖人</td>
				<td>下注时间</td>
				<td>中奖单号</td>
				<td>手机单号</td>
				<td>中奖号码</td>
				<td>投注类别</td>
				<td>中奖级别</td>
				<td>投注金额</td>
				<td>中奖金额</td>
				<td>中奖赔率</td>
			</tr>
			<?php  if(is_array($list)) { foreach($list as $item) { ?>
			<tr>
				<td><?php  echo $item['member_nikename'];?></td>
				<td><?php  echo date('Y-m-d H:i',$item['order_time'])?></td>
				<td>S:<?php  echo $item['ordersn'];?></td>
				<td>#<?php  echo $item['uordersn'];?></td>
				<td><?php  echo $item['winner_number'];?></td>
				<td><?php  echo $item['winner_type'];?></td>
				<td><?php  echo $item['winner_number_type'];?></td>
				<td><?php  echo $item['bet_money'];?></td>
				<td><?php  echo round($item['winner_money'],2)?></td>
				<td><?php  echo $item['winner_odds'];?></td>
			</tr>
			<?php  } } ?>
		</table>
		<?php  echo $pager;?>
	</form>
	<?php  } ?>
</div>
<script src="../DateBox/required.js" type="text/javascript" charset="utf-8"></script>
<?php  } else if($op == 'operation') { ?>
<style type="text/css">
	.input-container{display: inherit;}
</style>
<form action="<?php  echo $this->createMobileUrl('manager',array('op'=>'operation'));?>" class="form-inline" role="form" method="get">
	<div class="form-group" style="padding: 5px 0;">
		开始日期:
		<input type="text" name="start" id="starttime" value="<?php  echo $_GPC['start'];?>">
		结束日期:
		<input type="text" name="end" id="endtime" value="<?php  echo $_GPC['end'];?>">
		关键字：
		<input type="text" name="keyword" value="<?php  echo $_GPC['keyword'];?>">
		<!--c=site&a=entry&eid=181-->
		<input type="hidden" name="c" value="<?php  echo $_GPC['c'];?>">
		<input type="hidden" name="i" value="<?php  echo $_GPC['i'];?>">
		<input type="hidden" name="do" value="<?php  echo $_GPC['do'];?>">
		<input type="hidden" name="m" value="<?php  echo $_GPC['m'];?>">
		<input type="hidden" name="op" value="<?php  echo $_GPC['op'];?>">
		<input type="submit" value="查询" class="btn btn-info">
	</div>
</form>
<table class="table table-bordered" style="margin-top: 10px;font-size: 12px;">
	<tr class="active">
		<td>时间</td>
		<td>操作</td>
	</tr>
	<?php  if(is_array($list)) { foreach($list as $item) { ?>
	<tr>
		<td>
			<?php  echo date('Y-m-d H:i:s',$item['create_time'])?>
		</td>
		<td><?php  echo $item['operation'];?></td>
	</tr>
	<?php  } } ?>
</table>
<?php  echo $pager;?>
<script src="../DateBox/required.js" type="text/javascript" charset="utf-8"></script>
<script type="text/javascript">
	var obj = [];
	var sdate = '2018-07-04';
	$.fn.datetimepicker.dates['zdy'] = {
        days: ["星期日", "星期一", "星期二", "星期三", "星期四", "星期五", "星期六"],
        daysShort: ["周日", "周一", "周二", "周三", "周四", "周五", "周六"],
        daysMin:  ["日", "一", "二", "三", "四", "五", "六"],
        months: ["1月","2月","3月","4月","5月","6月","7月","8月","9月","10月","11月","12月"],
        monthsShort: ["1月","2月","3月","4月","5月","6月","7月","8月","9月","10月","11月","12月"],
        today: "今天",
        format:"yyyy-mm-dd",
        titleFormat:"yyyy-mm-",
        weekStart:1,
        suffix: [],
        meridiem: ["上午", "下午"]
      };
      $('#starttime').datetimepicker({
        language:  'zdy',
        weekStart: 1,
        todayBtn:  1,
        autoclose: 1,
        startDate:sdate,
        minView:2,
        maxView:3,
        onRenderDay: function(date) {
          var date1 = date.getFullYear()+'-'
            +(date.getMonth()<9?'0'+(date.getMonth()+1):date.getMonth()+1)
            +'-'
            +(date.getDate()<10?'0'+(date.getDate()-1):date.getDate()-1);

        }
      }).on('changeDate', function(ev){
        $('#endtime').datetimepicker('remove');
        var sdate=$("#starttime").val();
        var edate;
        for(var o in obj){
          if(new Date(sdate)<=new Date(obj[o])){
            var date = new Date(obj[o])
            var ndate = +date+24*60*60*1000;
            var leaveTime = new Date(ndate);
            edate = leaveTime.getFullYear()+'-'+(leaveTime.getMonth()+1)+'-'+leaveTime.getDate();

            break;
          }
        }
        $('#endtime').datetimepicker({
          language:  'zdy',
          weekStart: 1,
          todayBtn:  1,
          autoclose: 1,
          startDate:sdate,
          endDate:edate,
          minView:2,
          maxView:3
        }).on('changeDate', function(ev){

        });
      });
	$("#endtime").click(function(){
	    if($("#startDate").val()!=''){

	    }else{
	      showMsg('请选择日期');
	    }
	});
</script>
<!-- <script type="text/javascript">
	onLoadTimeChoiceDemo();
    borainTimeChoice({
        start:"#starttime",
        end:"",
        level:"YMD",
        less:true
    });
    borainTimeChoice({
        start:"#endtime",
        end:"",
        level:"YMD",
        less:true
    });
</script> -->
<?php  } ?>
<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('footer', TEMPLATE_INCLUDEPATH)) : (include template('footer', TEMPLATE_INCLUDEPATH));?>