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
<link rel="stylesheet" href="../addons/purchasing/static/css/borain-timeChoice.css">
<link rel="stylesheet" type="text/css" href="http://www.jq22.com/jquery/font-awesome.4.6.0.css">
<script src="../addons/purchasing/static/js/borain-timeChoice.js"></script>
<?php  if($op == 'display') { ?>
<script type="text/javascript" src="../web/resource/js/lib/bootstrap.min.js"></script>
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
			<div class="form-group">
				<input type="button" name="search" class="btn" value="新建代理" onclick="edit()">
			</div>
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
			<td>分红</td>
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
			<td><?php  if($item['status'] == 0) { ?><span style="color: #0f0;">活跃</span><?php  } else if($item['status'] == 2) { ?><span style="color: #f00;">试用</span><?php  } else { ?><span style="color: #ccc">禁用</span><?php  } ?></td>
			<td><?php  echo $item['credit1'];?></td>
			<td><?php  if($item['user_type'] == 1) { ?><?php  echo $item['bonus'];?>%<?php  } else { ?>会员<?php  } ?></td>
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
	</script>
</div>
<?php  } else if($op == 'member') { ?>
<div class="col-xs-12">
	<form class="form-inline" role="form" action="" method="get">
		<input type="hidden" name="c" value="entry">
		<input type="hidden" name="1" value="<?php  echo $_GPC['i'];?>">
		<input type="hidden" name="do" value="manager">
		<input type="hidden" name="m" value="purchasing">
		<input type="hidden" name="op" value="member">
		<div class="col-xs-12" style="padding: 5px 0;">
			<div class="form-group">
				<label for="keyword">关键词</label>
				<input type="text" name="keyword" id="keyword" placeholder="请输入会员名称或账号" class="form-control" value="<?php  echo $_GPC['keyword'];?>">
			</div>
			<div class="form-group">
				<input type="submit" name="search" class="btn btn-success" value="搜索">
			</div>
		</div>
	</form>
	<table class="table">
		<tr>
			<th>账号</th>
			<th>昵称</th>
			<th>剩余积分</th>
			<th>上级代理</th>
			<th>创建时间</th>
			<th>操作</th>
		</tr>
		<?php  if(is_array($list)) { foreach($list as $item) { ?>
		<tr>
			<td><?php  echo $item['account'];?></td>
			<td><?php  echo $item['nickname'];?></td>
            <td><?php  echo $item['credit1'];?></td>
            <td><?php  echo $item['parent_name'];?></td>
			<td><?php  echo date('Y-m-d H:i:s',$item['createtime'])?></td>
			<td>
				<a href="javascript:void(0);" onclick="get_odds(<?php  echo $item['id'];?>)">查看赔率</a>
				<a href="<?php  echo $this->createMobileUrl('manager',array('op'=>'report','member_id'=>$item['id'],'tab'=>'cathectic'))?>" title="查看会员往期投注明细">投注明细</a>
				<a href="<?php  echo $this->createMobileUrl('manager',array('op'=>'report','member_id'=>$item['id'],'tab'=>'reward'))?>" title="查看会员往期中奖明细">中奖明细</a>
				<?php  if($item['is_black'] == 0) { ?>
				<a href="javascript:void(0);" title="限制用户投注" onclick="limit_bet(<?php  echo $item['id'];?>,1)">限制投注</a>
				<?php  } else { ?>
				<a href="javascript:void(0);" title="解除投注限制" onclick="limit_bet(<?php  echo $item['id'];?>,2)">解除限制</a>
				<?php  } ?>
			</td>
		</tr>
		<?php  } } ?>
	</table>
	<?php  echo $pager;?>
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
</script>
<?php  } else if($op == 'lottery') { ?>
<div class="col-xs-12">
	<?php  if($tab == 'list') { ?>
	<form class="form-inline" role="form" action="" method="get">
		<input type="hidden" name="c" value="site">
		<input type="hidden" name="a" value="entry">
		<input type="hidden" name="do" value="lottery">
		<input type="hidden" name="m" value="manji">
		<div class="col-xs-12" style="padding: 5px 0;">
			<div class="form-group">
				<label for="keyword">关键词</label>
				<input type="text" name="keyword" id="keyword" placeholder="请输入期数" class="form-control" value="<?php  echo $_GPC['keyword'];?>">
			</div>
			<div class="form-group">
				<input type="submit" name="search" class="btn btn-success" value="搜索">
			</div>
			<?php  if($_SESSION['level'] == 1) { ?>
			<div class="form-group">
				<input type="button" name="search" class="btn" value="添加开奖" onclick="edit()">
			</div>
			<?php  } ?>
		</div>
	</form>
	<table class="table">
		<tr>
			<th>期数 </th>
			<th>公司</th>
            <th>投注截止时间</th>
			<th>开奖开始时间</th>
			<th>操作</th>
		</tr>
		<?php  if(is_array($list)) { foreach($list as $item) { ?>
		<tr>
			<td><a href="javascript:void(0);" title="点击查看中奖详情"><?php  echo $item['periods'];?></a></td>
			<td><?php  echo $item['company'];?></td>
            <td><?php  echo date('Y-m-d H:i:s',$item['stoptime'])?></td>
			<td><?php  echo date('Y-m-d H:i:s',$item['endtime'])?></td>
			<td>
				<?php  if($_SESSION['level'] == 1) { ?>
				<a href="javascript:void(0);" onclick="edit(<?php  echo $item['id'];?>)">编辑</a>
				<?php  } ?>
				<a href="<?php  echo $this->createMobileUrl('manager',array('op'=>'lottery','tab'=>'detail','id'=>$item['id']))?>" title="点击查看中奖详情">查看中奖详情</a>
			</td>
		</tr>
		<?php  } } ?>
	</table>
	<?php  echo $pager;?>
	<div id="cashback-area" class="recharge-area">
		<div class="recharge-main" style="height: 300px;">
			<div class="recharge-head">
				开奖设置
			</div>
			<div class="recharge-body">
				<table class="table">
					<tr>
						<td style="text-align: right;">开奖期数：</td>
						<td>
							<input type="text" name="periods" value="" style="width: 200px;border: 1px solid #ccc;">
						</td>
					</tr>
					<tr>
						<td style="text-align: right;">公司</td>
						<td>
							<select name="cid">
								<option value="0">请选择</option>
								<?php  if(is_array($company)) { foreach($company as $com) { ?>
								<option value="<?php  echo $com['id'];?>"><?php  echo $com['name'];?></option>
								<?php  } } ?>
							</select>
						</td>
					</tr>
					<tr>
						<td style="text-align: right;">投注截止时间：</td>
						<td>
							<input type="text" id="stoptime" value="" style="width: 200px;border: 1px solid #ccc;" readonly="readonly" style="background: url(../addons/purchasing/static/images/date.jpg) no-repeat;background-position: right;background-size: auto 100%;">
						</td>
					</tr>
					<tr>
						<td style="text-align: right;">开奖开始时间：</td>
						<td>
							<input type="text" id="endtime" value="" style="width: 200px;border: 1px solid #ccc;" readonly="readonly" style="background: url(../addons/purchasing/static/images/date.jpg) no-repeat;background-position: right;background-size: auto 100%;">
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
	<script src="../DateBox/required.js" type="text/javascript" charset="utf-8"></script>
	<script type="text/javascript">
		onLoadTimeChoiceDemo();
	    borainTimeChoice({
	        start:"#stoptime",
	        level:"HM",
	        less:false
	    });
	     borainTimeChoice({
	        start:"#endtime",
	        level:"HM",
	        less:false
	    });
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
						$('select[name=cid]').val(periods.cid);
						$('#stoptime').val(periods.stoptime);
						$('#endtime').val(periods.endtime);
						$('#cashback-area').show();
					}
				},'JSON')
			}
			else{
				$('input[name=periods]').val('');
				$('#stoptime').val('');
				$('#endtime').val('');
				$('select[name=cid]').val(0);
				$('input[name=periods]').removeAttr('readonly');
				$('#cashback-area').show();
			}
		}
		function edit_post() {
			var id = $('#id').val();
			var periods = $('input[name=periods]').val();
			var cid = $('select[name=cid]').val();
			var stoptime = $('#stoptime').val();
			var endtime = $('#endtime').val();
			$.post("<?php  echo $this->createMobileUrl('manager',array('op'=>'lottery_post'))?>",{id:id,periods:periods,stoptime:stoptime,endtime:endtime,cid:cid},function(result) {
				alert(result.message);
				if (result.type == 'success') {
					window.location.reload();
				}
			},'JSON');
		}
	</script>
	<?php  } else if($tab == 'detail') { ?>
	<form action="" method="post" class="form-horizontal" role="form">
		<input type="hidden" name="period_id" value="<?php  echo $_GPC['id'];?>">
		<div class="form-group">
			<label class="col-xs-4  col-sm-4 col-md-4 col-lg-1 control-label">开奖期数</label>
			<div class="col-xs-8 col-sm-8 col-md-8 col-lg-11 ">
				<label class="control-label"><?php  echo $item['periods'];?></label>
			</div>
		</div>
		<div class="form-group">
			<label class="col-xs-4  col-sm-4 col-md-4 col-lg-1 control-label">一等奖</label>
			<div class="col-xs-8 col-sm-8 col-md-8 col-lg-11">
				<label class="control-label"><?php  echo $item['first_no'];?></label>
			</div>
		</div>
		<div class="form-group">
			<label class="col-xs-4  col-sm-4 col-md-4 col-lg-1 control-label">二等奖</label>
			<div class="col-xs-8 col-sm-8 col-md-8 col-lg-11">
				<label class="control-label"><?php  echo $item['second_no'];?></label>
			</div>
		</div>
		<div class="form-group">
			<label class="col-xs-4  col-sm-4 col-md-4 col-lg-1 control-label">三等奖</label>
			<div class="col-xs-8 col-sm-8 col-md-8 col-lg-11">
				<label class="control-label"><?php  echo $item['third_no'];?></label>
			</div>
		</div>
		<div class="form-group">
			<label class="col-xs-4  col-sm-4 col-md-4 col-lg-1 control-label">特等奖</label>
			<div class="col-xs-8 col-sm-8 col-md-8 col-lg-11">
				<label class="control-label"><?php  echo $item['special_no'];?></label>
			</div>
		</div>
		<div class="form-group">
			<label class="col-xs-4  col-sm-4 col-md-4 col-lg-1 control-label">安慰奖</label>
			<div class="col-xs-8 col-sm-8 col-md-8 col-lg-11">
				<label class="control-label"><?php  echo $item['consolation_no'];?></label>
			</div>
			</div>



		<div class="form-group">
			<label class="col-xs-4  col-sm-4 col-md-4 col-lg-1 control-label">一等奖名单</label>
			<div class="col-xs-8 col-sm-8 col-md-8 col-lg-11">
				<div class="row">
					<?php  if(is_array($first)) { foreach($first as $k => $f) { ?>
					<div class="col-xs-2 col-sm-2 col-md-2 col-lg-2"><?php  echo $k;?>:<?php  echo $f;?></div>
					<?php  } } ?>
				</div>
			</div>
		</div>

		<div class="form-group">
			<label class="col-xs-4  col-sm-4 col-md-4 col-lg-1 control-label">二等奖名单</label>
			<div class="col-xs-8 col-sm-8 col-md-8 col-lg-11">
				<div class="row">
					<?php  if(is_array($second)) { foreach($second as $k => $f) { ?>
					<div class="col-xs-2 col-sm-2 col-md-2 col-lg-2"><?php  echo $k;?>:<?php  echo $f;?></div>
					<?php  } } ?>
				</div>
			</div>
		</div>

		<div class="form-group">
			<label class="col-xs-4  col-sm-4 col-md-4 col-lg-1 control-label">三等奖名单</label>
			<div class="col-xs-8 col-sm-8 col-md-8 col-lg-11">
				<div class="row">
					<?php  if(is_array($third)) { foreach($third as $k => $f) { ?>
					<div class="col-xs-2 col-sm-2 col-md-2 col-lg-2"><?php  echo $k;?>:<?php  echo $f;?></div>
					<?php  } } ?>
				</div>
			</div>
		</div>

		<div class="form-group">
			<label class="col-xs-4  col-sm-4 col-md-4 col-lg-1 control-label">特等奖名单</label>
			<div class="col-xs-8 col-sm-8 col-md-8 col-lg-11">
				<div class="row">
					<?php  if(is_array($specia)) { foreach($specia as $k => $f) { ?>
					<div class="col-xs-2 col-sm-2 col-md-2 col-lg-2"><?php  echo $k;?>:<?php  echo $f;?></div>
					<?php  } } ?>
				</div>
			</div>
		</div>
		<div class="form-group">
			<label class="col-xs-4  col-sm-4 col-md-4 col-lg-1 control-label">安慰奖名单</label>
			<div class="col-xs-8 col-sm-8 col-md-8 col-lg-11">
				<div class="row">
					<?php  if(is_array($consolation)) { foreach($consolation as $k => $f) { ?>
					<div class="col-xs-2 col-sm-2 col-md-2 col-lg-2"><?php  echo $k;?>:<?php  echo $f;?></div>
					<?php  } } ?>
				</div>
			</div>
		</div>

		<!-- <div class="form-group">
			<label class="col-xs-4  col-sm-4 col-md-4 col-lg-1 control-label"></label>
			<div class="col-xs-8 col-sm-8 col-md-8 col-lg-11">
				 <input type="button" class="btn btn-success sendBtn" value="发送中奖消息">
			</div>
		</div> -->
	</form>
	<?php  } ?>
</div>
<?php  } else if($op == 'order') { ?>
<style type="text/css">
	table tr td{text-align: center;}
	.recharge-main{width: 30%;height: 30vw;margin: 5% auto;background: #fff;overflow-y: auto;}
</style>
<div class="col-xs-12">
	<div class="col-xs-12" style="padding: 10px 0;">
		<a href="<?php  echo $this->createMobileUrl('manager',array('op'=>'order','length'=>4))?>" class="btn">4D</a>
		<a href="<?php  echo $this->createMobileUrl('manager',array('op'=>'order','length'=>3))?>" class="btn">3D</a>
		<a href="<?php  echo $this->createMobileUrl('manager',array('op'=>'order','length'=>2))?>" class="btn">2D</a>
	</div>
	<style type="text/css">
		.input-container{display: inherit;}
	</style>
	<form class="form-inline" role="form" action="<?php  echo $this->createMobileUrl('manager',array('op'=>'order'))?>" method="get">
		<input type="hidden" name="c" value="<?php  echo $_GPC['c'];?>">
		<input type="hidden" name="i" value="<?php  echo $_GPC['i'];?>">
		<input type="hidden" name="do" value="<?php  echo $_GPC['do'];?>">
		<input type="hidden" name="m" value="<?php  echo $_GPC['m'];?>">
		<input type="hidden" name="length" value="<?php  echo $_GPC['length'];?>">
		<input type="hidden" name="op" value="order">
		<div class="form-group" style="padding: 5px 0;">
			日期:
			<input type="text" name="time" id="starttime" readonly="readonly" value="<?php  echo $_GPC['time'];?>"  style="background: url(../addons/purchasing/static/images/date.jpg) no-repeat;background-position: right;background-size: auto 100%;">
			<div class="form-group">
				<input type="submit" name="search" class="btn btn-success" value="搜索">
			</div>
		</div>
	</form>
	<?php  if(is_array($list)) { foreach($list as $i => $item) { ?>
	<?php  $len = 100/$count;?>
	<table class="table table-bordered" style="width: <?php  echo $len;?>%;float: left;overflow-y: auto;max-height: 60%;">
		<tr>
			<td colspan="2"><?php  echo $i;?></td>
		</tr>
		<tr>
			<td>号码</td>
			<td>投注额</td>
		</tr>
		<?php  if(is_array($item)) { foreach($item as $it) { ?>
		<tr>
			<td>
				<a href="javascript:void(0);" onclick="number_detail(<?php  echo $it['number'];?>);"><?php  echo $it['number'];?></a>
			</td>
			<td><?php  echo $it[$i];?></td>
		</tr>
		<?php  } } ?>
	</table>
	<?php  } } ?>
	<div id="number_detail" class="recharge-area">
		<div class="recharge-main">
			<div class="recharge-head" id="number-title">
				
			</div>
			<div class="recharge-body">
				<table class="table table-bordered" id="number_list">
					
				</table>
			</div>
		</div>
	</div>
	<div id="order_list" class="recharge-area">
		<div class="recharge-main">
			<div class="recharge-head" id="list-title">
				
			</div>
			<div class="recharge-body">
				<table class="table table-bordered" id="orders">
					
				</table>
			</div>
		</div>
	</div>
	<div id="order_detail" class="recharge-area">
		<div class="recharge-main">
			<div class="recharge-head" id="detail-title">
				详细单页<a href="javascript:void(0)" onclick="$('#order_detail').hide();"><span style="float: right;margin-right: 15px;">&times;</span></a>
			</div>
			<div class="recharge-body">
				<table class="table" id="details" style="max-width: 100%;">
					
				</table>
			</div>
		</div>
	</div>
	<script src="../DateBox/required.js" type="text/javascript" charset="utf-8"></script>
	<script type="text/javascript">
		function number_detail(number) {
			var time = "<?php  echo $_GPC['time'];?>";
			var title = number+'<a href="javascript:void(0)" onclick="$(\'#number_detail\').hide();"><span style="float: right;margin-right: 15px;">&times;</span></a>';
			$('#number-title').html(title);
			$.post("<?php  echo $this->createMobileUrl('number_detail',array('op'=>'get_number'))?>",{number:number,time:time},function(result) {
				console.log(result.list);
				var list = result.list;
				var txt = '';
				$('#number_list').empty();
				if (list.length > 0) {
					list.forEach(function(item,key) {
						if (item.number > 0) {
							txt += '<tr>';
							txt += '<td>'+item.key+'</td>';
							txt += '<td><a href="javascript:void(0);" onclick="order_list('+result.number+',\''+item.key+'\')">'+item.number+'</a></td>';
							txt += '</tr>';
						}
					});
					$('#number_list').html(txt);
				}
				$('#number_detail').show();
			},"JSON");
		}
		function order_list(number,pay) {
			$('#number_detail').hide();
			var time = "<?php  echo $_GPC['time'];?>";
			var title = number+'&nbsp;&nbsp;&nbsp;'+pay+'<a href="javascript:void(0)" onclick="$(\'#order_list\').hide();"><span style="float: right;margin-right: 15px;">&times;</span></a>';
			$('#list-title').html(title);
			$.post("<?php  echo $this->createMobileUrl('number_detail',array('op'=>'get_order'))?>",{number:number,time:time,pay:pay},function(result) {
				console.log(result.list);
				var list = result.list;
				var txt = '';
				$('#orders').empty();
				if (list.length > 0) {
					list.forEach(function(item,key) {
						if (item.money > 0) {
							txt += '<tr>';
							txt += '<td>'+item.username+'</td>';
							txt += '<td><a href="javascript:void(0);" onclick="order_detail('+item.id+')">'+item.money+'</a></td>';
							txt += '</tr>';
						}
					});
					$('#orders').html(txt);
				}
				$('#order_list').show();
			},"JSON");
		}
		function order_detail(id) {
			$('#order_list').hide();
			$.post("<?php  echo $this->createMobileUrl('number_detail',array('op'=>'get_detail'))?>",{id:id},function(result) {
				console.log(result.detial);
				var list = result.list;
				var txt = '';
				$('#details').empty();
				if (list.length > 0) {
					list.forEach(function(item,key) {
						txt += '<tr>';
						txt += '<td style="text-align: left;word-break:break-all;max-width: 100%;">'+item.value+'</td>';
						txt += '</tr>';
					});
					$('#details').html(txt);
				}
				$('#order_detail').show();
			},'JSON')
		}
		onLoadTimeChoiceDemo();
	    borainTimeChoice({
	        start:"#starttime",
	        level:"YMD",
	        less:false
	    });
	</script>
</div>
<?php  } else if($op == 'report') { ?>
<div class="col-xs-12">
	<?php  if(empty($member_id)) { ?>
	<!-- <div class="col-xs-12" style="padding: 5px 0;">
		<a href="<?php  echo $this->createMobileUrl('manager',array('op'=>'report','tab'=>'display'))?>" class="btn" <?php  if($tab == 'display') { ?>style="background:#fff;color: #333;"<?php  } ?>>营收概况</a>
		<a href="<?php  echo $this->createMobileUrl('manager',array('op'=>'report','tab'=>'cathectic'))?>" class="btn" <?php  if($tab == 'cathectic') { ?>style="background:#fff;color: #333;"<?php  } ?>>投注明细</a>
		<a href="<?php  echo $this->createMobileUrl('manager',array('op'=>'report','tab'=>'reward'))?>" class="btn" <?php  if($tab == 'reward') { ?>style="background:#fff;color: #333;"<?php  } ?>>中奖明细</a>
		<a href="<?php  echo $this->createMobileUrl('manager',array('op'=>'report','tab'=>'downline'))?>" class="btn" <?php  if($tab == 'downline') { ?>style="background:#fff;color: #333;"<?php  } ?>>下线结算表</a>
	</div> -->
	<?php  } ?>
	<?php  if($tab == 'display') { ?>
	<style type="text/css">
		.input-container{display: inherit;}
	</style>
	<form action="<?php  echo $this->createMobileUrl('manager',array('op'=>'report','tab'=>'display'));?>" class="form-inline" role="form" method="get">
		<div class="col-xs-12" style="padding: 5px 0;">
			<div class="form-group" >
				开始日期:
				<input type="text" name="stime" id="starttime" readonly="readonly"  style="background: url(../addons/purchasing/static/images/date.jpg) no-repeat;background-position: right;background-size: auto 100%;">
				结束日期:
				<input type="text" name="etime" id="endtime" readonly="readonly"  style="background: url(../addons/purchasing/static/images/date.jpg) no-repeat;background-position: right;background-size: auto 100%;">
				<!--c=site&a=entry&eid=181-->
				<input type="hidden" name="c" value="<?php  echo $_GPC['c'];?>">
				<input type="hidden" name="i" value="<?php  echo $_GPC['i'];?>">
				<input type="hidden" name="do" value="<?php  echo $_GPC['do'];?>">
				<input type="hidden" name="m" value="<?php  echo $_GPC['m'];?>">
				<input type="hidden" name="op" value="report">
				<input type="hidden" name="tab" value="display">
				<input type="submit" value="查询" class="btn btn-info">
			</div>
		</div>
		<table class="table table-bordered" style="margin-top: 10px;">
			<tr class="active">
				<td>期数</td>
				<td>时间</td>
				<td>总投注</td>
				<td>总赔奖</td>
				<td>总利润</td>
				<td>中奖人数</td>
				<td>操作</td>
			</tr>
			<?php  if(is_array($list)) { foreach($list as $item) { ?>
			<tr>
				<td><?php  echo $item['periods'];?></td>
				<td><?php  echo $item['date'];?></td>
				<td><?php echo $item['sum_bet']?$item['sum_bet']:0?></td>
				<td><?php echo $item['pay_award']?$item['pay_award']:0?></td>
				<td><?php  echo $item['profit'];?></td>
				<td><?php  echo $item['winner_num'];?></td>
				<td>
					<a href="<?php  echo $this->createMobileUrl('manager',array('op'=>'report','tab'=>'detail','id'=>$item['id']))?>" style="margin-right: 10px;">明细</a>
				</td>
			</tr>
			<?php  } } ?>
		</table>
	</form>
	<?php  } else if($tab == 'detail') { ?>
	<script type="text/javascript" src="../web/resource/js/lib/bootstrap.min.js"></script>
	<table class="table table-bordered" style="margin-top: 10px;">
		<tr>
			<td>期数：<?php  echo $periods;?></td>
		</tr>
		<tr class="active">
			<td>代理</td>
			<td>总投注</td>
			<td>总赔奖</td>
			<td>总利润</td>
		</tr>
		<?php  if(is_array($list)) { foreach($list as $item) { ?>
		<tr>
			<td><a href="javascript:void(0);" data-toggle="modal" data-target="#check<?php  echo $item['id'];?>"><?php  echo $item['nickname'];?></a></td>
			<td><?php echo $item['sum_bet']?$item['sum_bet']:0?></td>
			<td><?php echo $item['pay_award']?$item['pay_award']:0?></td>
			<td>
				<?php  echo $item['profit'];?>
				<div class="modal fade" id="check<?php  echo $item['id'];?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                <h4 class="modal-title text-center" id=""></h4>
                            </div>
                            <div class="modal-footer">
                            	<a href="<?php  echo $this->createMobileUrl('manager',array('op'=>'report','id'=>$id,'purchasing_id'=>$item['id'],'tab'=>'detail'))?>" class="btn btn-default col-sm-3 col-xs-offset-3">查看下级</a>
                                <a href="<?php  echo $this->createMobileUrl('manager',array('op'=>'report','id'=>$id,'agent_id'=>$item['id'],'tab'=>'member'))?>" class="btn btn-primary col-sm-3">查看会员</a>
                            </div>
                        </div><!-- /.modal-content -->
                    </div><!-- /.modal -->
                </div>
			</td>
		</tr>
		<?php  } } ?>
	</table>
	<?php  echo $pager;?>
	<?php  } else if($tab == 'member') { ?>
	<table class="table table-bordered" style="margin-top: 10px;">
		<tr>
			<td>期数：<?php  echo $periods;?></td>
		</tr>
		<tr class="active">
			<td>会员名</td>
			<td>总投注</td>
			<td>总赔奖</td>
			<td>总利润</td>
			<td>剩余积分</td>
		</tr>
		<?php  if(is_array($list)) { foreach($list as $item) { ?>
		<tr>
			<td><?php  echo $item['nickname'];?></td>
			<td><?php echo $item['bet']?$item['bet']:0?></td>
			<td><?php echo $item['pay_award']?$item['pay_award']:0?></td>
			<td><?php  echo $item['profit'];?></td>
			<td><?php  echo $item['balance'];?></td>
		</tr>
		<?php  } } ?>
	</table>
	<?php  echo $pager;?>
	<?php  } else if($tab == 'cathectic') { ?>
	<form action="<?php  echo $this->createMobileUrl('manager',array('op'=>'report','tab'=>'cathectic'));?>" class="form-inline" role="form" method="get">
		<?php  if(empty($member_id)) { ?>
		<div class="form-group" >
			期数:
			<input type="text" name="periods" value="<?php  echo $_GPC['periods'];?>">
			投注人:
			<input type="text" name="member" value="<?php  echo $_GPC['member'];?>">
			<!--c=site&a=entry&eid=181-->
			<input type="hidden" name="c" value="<?php  echo $_GPC['c'];?>">
			<input type="hidden" name="i" value="<?php  echo $_GPC['i'];?>">
			<input type="hidden" name="do" value="<?php  echo $_GPC['do'];?>">
			<input type="hidden" name="m" value="<?php  echo $_GPC['m'];?>">
			<input type="hidden" name="op" value="report">
			<input type="hidden" name="tab" value="cathectic">
			<input type="submit" value="查询" class="btn btn-info">
		</div>
		<?php  } ?>

		<table class="table table-bordered" style="margin-top: 10px;">
			<tr class="active">
				<td>投注人</td>
				<td>时间</td>
				<td>期数</td>
				<td>号码</td>
				<td>B</td>
				<td>S</td>
				<td>A</td>
				<td>3ABC</td>
				<td>C2</td>
				<td>C3</td>
				<td>C4</td>
				<td>C5</td>
				<td>EC</td>
				<td>4A</td>
				<td>4ABC</td>
				<td>4B</td>
				<td>4C</td>
				<td>4D</td>
				<td>4E</td>
				<td>EA</td>
				<td>2A</td>
				<td>2ABC</td>
				<td>2B</td>
				<td>2C</td>
				<td>2D</td>
				<td>2E</td>
				<td>EX</td>
			</tr>
			<?php  if(is_array($list)) { foreach($list as $item) { ?>
			<tr>
				<td><?php  echo $item['nickname'];?></td>
				<td><?php  echo date('Y-m-d H:i',$item['createtime'])?></td>
				<td><?php  echo $item['periods'];?></td>
				<td><?php  echo $item['number'];?></td>
				<td><?php  echo $item['pay_B'];?></td>
				<td><?php  echo $item['pay_S'];?></td>
				<td><?php  echo $item['pay_A'];?></td>
				<td><?php  echo $item['pay_3ABC'];?></td>
				<td><?php  echo $item['pay_C2'];?></td>
				<td><?php  echo $item['pay_C3'];?></td>
				<td><?php  echo $item['pay_C4'];?></td>
				<td><?php  echo $item['pay_C5'];?></td>
				<td><?php  echo $item['pay_EC'];?></td>
				<td><?php  echo $item['pay_4A'];?></td>
				<td><?php  echo $item['pay_4ABC'];?></td>
				<td><?php  echo $item['pay_4B'];?></td>
				<td><?php  echo $item['pay_4C'];?></td>
				<td><?php  echo $item['pay_4D'];?></td>
				<td><?php  echo $item['pay_4E'];?></td>
				<td><?php  echo $item['pay_EA'];?></td>
				<td><?php  echo $item['pay_2A'];?></td>
				<td><?php  echo $item['pay_2ABC'];?></td>
				<td><?php  echo $item['pay_2B'];?></td>
				<td><?php  echo $item['pay_2C'];?></td>
				<td><?php  echo $item['pay_2D'];?></td>
				<td><?php  echo $item['pay_2E'];?></td>
				<td><?php  echo $item['pay_EX'];?></td>
			</tr>
			<?php  } } ?>
		</table>
		<?php  echo $pager;?>
	</form>
	<?php  } else if($tab == 'reward') { ?>
	<form action="<?php  echo $this->createMobileUrl('manager',array('op'=>'report','tab'=>'income'));?>" class="form-inline" role="form" method="get">
		<?php  if(empty($member_id)) { ?>
		<div class="form-group" >
			期数:
			<input type="text" name="periods" value="<?php  echo $_GPC['periods'];?>">
			中奖人:
			<input type="text" name="member" value="<?php  echo $_GPC['member'];?>">
			<!--c=site&a=entry&eid=181-->
			<input type="hidden" name="c" value="<?php  echo $_GPC['c'];?>">
			<input type="hidden" name="i" value="<?php  echo $_GPC['i'];?>">
			<input type="hidden" name="do" value="<?php  echo $_GPC['do'];?>">
			<input type="hidden" name="m" value="<?php  echo $_GPC['m'];?>">
			<input type="hidden" name="op" value="reward">
			<input type="submit" value="查询" class="btn btn-info">
		</div>
		<?php  } ?>

		<table class="table table-bordered" style="margin-top: 10px;">
			<tr class="active">
				<td>中奖人</td>
				<td>开奖期数</td>
				<td>下注时间</td>
				<td>中奖单号</td>
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
				<td><?php  echo $item['period_num'];?></td>
				<td><?php  echo date('Y-m-d H:i',$item['order_time'])?></td>
				<td>S:<?php  echo $item['order_id'];?></td>
				<td><?php  echo $item['winner_number'];?></td>
				<td><?php  echo $item['winner_type'];?></td>
				<td><?php  echo $item['winner_number_type'];?></td>
				<td><?php  echo $item['bet_money'];?></td>
				<td><?php  echo $item['winner_money'];?></td>
				<td><?php  echo $item['winner_odds'];?></td>
			</tr>
			<?php  } } ?>
		</table>
		<?php  echo $pager;?>
	</form>
	<?php  } else if($tab == 'downline') { ?>
	<style type="text/css">
		.input-container{display: inherit;}
	</style>
	<form action="<?php  echo $this->createMobileUrl('manager',array('agent_id'=>$_GPC['agent_id']));?>" class="form-inline" role="form" method="get">
		<div class="form-group" >
			开始日期:
			<input type="text" name="stime" id="starttime" readonly="readonly" value="<?php  echo $_GPC['stime'];?>" style="background: url(../addons/purchasing/static/images/date.jpg) no-repeat;background-position: right;background-size: auto 100%;">
			结束日期:
			<input type="text" name="etime" id="endtime" readonly="readonly" value="<?php  echo $_GPC['etime'];?>" style="background: url(../addons/purchasing/static/images/date.jpg) no-repeat;background-position: right;background-size: auto 100%;">
			<!--c=site&a=entry&eid=181-->
			<input type="hidden" name="c" value="<?php  echo $_GPC['c'];?>">
			<input type="hidden" name="i" value="<?php  echo $_GPC['i'];?>">
			<input type="hidden" name="do" value="<?php  echo $_GPC['do'];?>">
			<input type="hidden" name="m" value="<?php  echo $_GPC['m'];?>">
			<input type="hidden" name="op" value="<?php  echo $_GPC['op'];?>">
			<input type="hidden" name="tab" value="<?php  echo $_GPC['tab'];?>">
			<input type="submit" value="查询" class="btn btn-info">
		</div>
	</form>
	<table class="table table-bordered" style="margin-top: 10px;font-size: 12px;">
		<tr>
			<td colspan="16">下线报告：<?php  echo $account;?></td>
		</tr>
		<tr class="active">
			<td>代理</td>
			<td>名称</td>
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
		</tr>
		<?php  if(is_array($list)) { foreach($list as $li) { ?>
		<tr>
			<td colspan="16">期数：<?php  echo $li['periods'];?></td>
		</tr>
		<?php  if(is_array($li['list'])) { foreach($li['list'] as $item) { ?>
		<?php  if($item['sum_bet'] > 0) { ?>
		<tr>
			<td>
				<?php  if($item['user_type'] == 1) { ?><a href="<?php  echo $this->createMobileUrl('manager',array('op'=>'report','tab'=>'downline','id'=>$item['agent_id'],'stime'=>$_GPC['stime'],'etime'=>$_GPC['etime']))?>" title=""><?php  echo $item['account'];?></a><?php  } else { ?><?php  echo $item['account'];?><?php  } ?>
			</td>
			<td><?php  echo $item['nickname'];?></td>
			<td>
				<?php  if($item['user_type'] == 1) { ?>
				<a href="<?php  echo $this->createMobileUrl('manager',array('op'=>'report','tab'=>'cathectic','stime'=>$_GPC['stime'],'etime'=>$_GPC['etime'],'agent_id'=>$item['agent_id']))?>"><?php  echo round($item['sum_bet'],2);?></a>
				<?php  } else { ?>
				<a href="<?php  echo $this->createMobileUrl('manager',array('op'=>'report','tab'=>'cathectic','stime'=>$_GPC['stime'],'etime'=>$_GPC['etime'],'member_id'=>$item['member_id']))?>"><?php  echo round($item['sum_bet'],2);?></a>
				<?php  } ?>
			</td>
			<td><?php  echo round($item['cashback'],2);?></td>
			<td>
				<?php  if($item['user_type'] == 1) { ?>
				<a href="<?php  echo $this->createMobileUrl('manager',array('op'=>'report','tab'=>'reward','stime'=>$_GPC['stime'],'etime'=>$_GPC['etime'],'agent_id'=>$item['agent_id']))?>"><?php  echo round($item['pay_award'],2);?></a>
				<?php  } else { ?>
				<a href="<?php  echo $this->createMobileUrl('manager',array('op'=>'report','tab'=>'reward','stime'=>$_GPC['stime'],'etime'=>$_GPC['etime'],'member_id'=>$item['member_id']))?>"><?php  echo round($item['pay_award'],2);?></a>
				<?php  } ?>
			</td>
			<td><?php  echo round($item['profit'],2);?></td>
			<td><?php  echo round($item['bonus'],2);?></td>
			<td><?php  echo round($item['net'],2);?></td>
			<td><?php  echo round($item['sum_bet'],2);?></td>
			<td><?php  echo round($item['upline_cashback'],2);?></td>
			<td><?php  echo round($item['upline_pay_award'],2);?></td>
			<td><?php  echo round($item['upline_profit'],2);?></td>
			<td><?php  echo round($item['upline_bonus'],2);?></td>
			<td><?php  echo round($item['upline_net'],2);?></td>
			<td><?php  echo round($item['commission'],2);?></td>
			<td><?php  echo round($item['bonus_earn'],2);?></td>
		</tr>
		<?php  } ?>
		<?php  } } ?>
		<tr>
			<td></td>
			<td>总共：</td>
			<td><?php  echo round($li['total']['sum_bet'],2);?></td>
			<td><?php  echo round($li['total']['cashback'],2);?></td>
			<td><?php  echo round($li['total']['pay_award'],2);?></td>
			<td><?php  echo round($li['total']['profit'],2);?></td>
			<td><?php  echo round($li['total']['bonus'],2);?></td>
			<td><?php  echo round($li['total']['net'],2);?></td>
			<td><?php  echo round($li['total']['sum_bet'],2);?></td>
			<td><?php  echo round($li['total']['upline_cashback'],2);?></td>
			<td><?php  echo round($li['total']['upline_pay_award'],2);?></td>
			<td><?php  echo round($li['total']['upline_profit'],2);?></td>
			<td><?php  echo round($li['total']['upline_bonus'],2);?></td>
			<td><?php  echo round($li['total']['upline_net'],2);?></td>
			<td><?php  echo round($li['total']['commission'],2);?></td>
			<td><?php  echo round($li['total']['bonus_earn'],2);?></td>
		</tr>
		<?php  } } ?>
	</table>
	<table class="table table-bordered">
		<tr>
			<td colspan="16"> 公司总账</td>
		</tr>
		<tr>
			<td></td>
			<td>来</td>
			<td>下线佣金</td>
			<td>下线中奖</td>
			<td>下线净</td>
		</tr>
		<?php  if(is_array($total_list)) { foreach($total_list as $tl) { ?>
		<tr>
			<td><?php  echo $tl['account'];?></td>
			<td><?php  echo round($tl['sum_bet'],2);?></td>
			<td><?php  echo round($tl['upline_cashback'],2);?></td>
			<td><?php  echo round($tl['pay_award'],2);?></td>
			<td><?php  echo round($tl['upline_profit'],2);?></td>
		</tr>
		<?php  } } ?>
		<tr>
			<td>总共：</td>
			<td><?php  echo round($all_total['sum_bet'],2);?></td>
			<td><?php  echo round($all_total['upline_cashback'],2);?></td>
			<td><?php  echo round($all_total['pay_award'],2);?></td>
			<td><?php  echo round($all_total['upline_profit'],2);?></td>
		</tr>
	</table>
	<?php  } ?>
</div>
<script src="../DateBox/required.js" type="text/javascript" charset="utf-8"></script>
<script type="text/javascript">
	onLoadTimeChoiceDemo();
    borainTimeChoice({
        start:"#starttime",
        level:"YMD",
        less:false
    });
    borainTimeChoice({
        start:"#endtime",
        level:"YMD",
        less:false
    });
</script>
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
	onLoadTimeChoiceDemo();
    borainTimeChoice({
        start:"#starttime",
        level:"YMD",
        less:false
    });
     borainTimeChoice({
        start:"#endtime",
        level:"YMD",
        less:false
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