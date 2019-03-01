<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/header', TEMPLATE_INCLUDEPATH)) : (include template('common/header', TEMPLATE_INCLUDEPATH));?>
<ul class="nav nav-tabs">
	<li <?php  if($op == 'display') { ?> class="active" <?php  } ?>><a href="<?php  echo $this->createWebUrl('agent',array('op'=>'display'))?>">列表</a></li>
	<li <?php  if($op == 'add') { ?>class="active"<?php  } ?>><a href="<?php  echo $this->createWebUrl('agent',array('op'=>'add'))?>">添加</a></li>
	<li <?php  if($op == 'edit') { ?>class="active"<?php  } ?><?php  if($op != 'edit') { ?>style="display:none"<?php  } ?>><a href="<?php  echo $this->createWebUrl('agent',array('op'=>'edit'))?>">编辑</a></li>

</ul>
<?php  if($op == 'display') { ?>
<form class="form-inline" role="form" action="" method="get">
	<input type="hidden" name="c" value="site">
	<input type="hidden" name="a" value="entry">
	<input type="hidden" name="do" value="agent">
	<input type="hidden" name="m" value="agent">
	<div class="panel panel-info">
		<div class="panel-heading">
			筛选
		</div>
		<div class="panel-body">
			<div class="form-group">
				<label for="keyword">关键词</label>
				<input type="text" name="keyword" id="keyword" placeholder="请输入代理人账号" class="form-control" value="<?php  echo $_GPC['keyword'];?>">
			</div>
			<div class="form-group">
				<input type="submit" name="search" class="btn btn-success" value="搜索">
			</div>
		</div>
	</div>
</form>
<div class="panel">
	<table class="table">
		<thead>
			<tr>
				<td>编号</td>
				<td>账号</td>
				<td>昵称</td>
                <td>剩余积分</td>
                <td>上级代理</td>
				<td>时间</td>
				<td>操作</td>
			</tr>
		</thead>
		<tbody>
			<?php  if(is_array($list)) { foreach($list as $item) { ?>
			<tr>
				<td><?php  echo $item['id'];?></td>
				<td><?php  echo $item['account'];?></td>
				<td><?php  echo $item['nickname'];?></td>
                <td><?php  echo $item['credit1'];?></td>
                <td><?php  echo $item['parent_name'];?></td>
				<td><?php  echo date('Y-m-d H:i:s',$item['createtime'])?></td>
				<td>
					<a href="<?php  echo $this->createWebUrl('agent',array('op'=>'edit','id'=>$item['id']))?>"><i class="fa fa-pencil"></i>编辑</a>
					<a href="javascript:void(0);" data-toggle="modal" data-target="#edi<?php  echo $item['id'];?>"><i class="fa fa-money"></i>充值</a>
					<form action="" method="post" id="oneForm" role="form">
	                <div class="modal fade" id="edi<?php  echo $item['id'];?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	                    <div class="modal-dialog">
	                        <div class="modal-content">
	                            <div class="modal-header">
	                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
	                                <h4 class="modal-title text-center" id="">代理充值</h4>
	                            </div>
	                            <div class="modal-body">
	                                <table class="table table-bordered">
	                                    <tr>
	                                        <td class="text-right">金额:</td>
	                                        <td class="text-left"><input type="number" id="money<?php  echo $item['id'];?>" name="money"></td>
	                                    </tr>
	                                    </tr>
	                                </table>
	                            </div>
	                            <div class="modal-footer">
	                                <button type="button" class="btn btn-default col-sm-3 col-xs-offset-3" data-dismiss="modal">关闭</button>
	                                <button type="button" id="xiugai" class="btn btn-primary col-sm-3" onclick="recharge(<?php  echo $item['id'];?>)">确认</button>
	                            </div>
	                        </div><!-- /.modal-content -->
	                    </div><!-- /.modal -->
	                </div>
	                </form>
 				</td>
			</tr>
			<?php  } } ?>
		</tbody>
	</table>
	<?php  echo $pager;?>
	<script type="text/javascript">
		function recharge(id) {
			var money = $('#money'+id).val();
			if (!money) {
				alert('请填写充值金额');
				return false;
			}
			$.ajax({
				url:"<?php  echo $this->createWebUrl('agent',array('op'=>'recharge'))?>",
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
	</script>
</div>
<?php  } else if($op == 'add' || $op == 'edit') { ?>
<style type="text/css">
	.odds-table tr td input{width: 30px;border: 0;height: 100%;}
</style>
<div class="panel panel-info">
		<div class="panel-body">
			<form action="<?php  echo $this->createWebUrl('agent',array('op'=>'post'))?>" method="post" class="form-horizontal" role="form">
			<input type="hidden" name="id" value="<?php  echo $item['id'];?>">
				<div class="form-group">
					<label class="col-xs-4 col-sm-4 col-md-4 col-lg-1 control-label">账号</label>
					<div class="col-xs-8 col-sm-8 col-md-8 col-lg-11">
						<input class="form-control"  name="account" id='account' type="text" value="<?php  echo $item['account'];?>" placeholder="8~12位大小写a-zA-Z0-9账号"  <?php  if($op=="edit") { ?>readonly<?php  } ?> >
					</div>
				</div>
				<div class="form-group">
					<label class="col-xs-4 col-sm-4 col-md-4 col-lg-1 control-label">昵称</label>
					<div class="col-xs-8 col-sm-8 col-md-8 col-lg-11">
						<input class="form-control"  name="nickname" id='nickname' type="text" value="<?php  echo $item['nickname'];?>" placeholder=""    >
					</div>
				</div>

				<div class="form-group">
					<label class="col-xs-4 col-sm-4 col-md-4 col-lg-1 control-label">密码</label>
					<div class="col-xs-8 col-sm-8 col-md-8 col-lg-11">
						<input class="form-control"  name="password" id='password' type="password" value="" placeholder="">
					</div>
				</div>

				<div class="form-group">
					<label class="col-xs-4 col-sm-4 col-md-4 col-lg-1 control-label">确认密码</label>
					<div class="col-xs-8 col-sm-8 col-md-8 col-lg-11">
						<input class="form-control"  name="repassword" id='repassword' type="password" value="" placeholder="">
					</div>
				</div>

				<div class="form-group">
					<label class="col-xs-4 col-sm-4 col-md-4 col-lg-1 control-label">赔率说明</label>
					<div class="col-xs-8 col-sm-8 col-md-8 col-lg-11">
						<label class="control-label" style="text-align: left;color: red;">
							（只能修改总代理赔率）以下每项一次对应4e,4s,4a,3abc,3a,box,ibox,a1赔率,q其中4e,4s,3abc设置多个中奖等级，格式如： 1等奖赔率|2等奖赔率|3等奖赔率|特别奖赔率|安慰奖赔率
						</label>

					</div>
				</div>
				<div class="form-group">
					<table class="table table-bordered odds-table">
						<tr>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td>彩金</td>
							<td>
								<input type="text" name="jackpot" value="<?php  echo $percent['jackpot_percent'];?>">
							</td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td>分红</td>
							<td>
								<input type="text" name="bonus" value="<?php  echo $percent['bonus_percent'];?>">
							</td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
						</tr>
						<tr>
							<td>反水</td>
							<td></td>
							<td>
								<input type="text" name="cashback[B]" value="<?php echo $cashback['B']?$cashback['B']:0?>" class="cashback">
							</td>
							<td></td>
							<td>
								<input type="text" name="cashback[S]" value="<?php echo $cashback['S']?$cashback['S']:0?>" class="cashback">
							</td>
							<td></td>
							<td>
								<input type="text" name="cashback[A]" value="<?php echo $cashback['A']?$cashback['A']:0?>" class="cashback">
							</td>
							<td></td>
							<td>
								<input type="text" name="cashback[3ABC]" value="<?php echo $cashback['3ABC']?$cashback['3ABC']:0?>" class="cashback">
							</td>
							<td></td>
							<td>
								<input type="text" name="cashback[4A]" value="<?php echo $cashback['4A']?$cashback['4A']:0?>" class="cashback">
							</td>
							<td></td>
							<td>
								<input type="text" name="cashback[4ABC]" value="<?php echo $cashback['4ABC']?$cashback['4ABC']:0?>" class="cashback">
							</td>
							<td></td>
							<td>
								<input type="text" name="cashback[2A]" value="<?php echo $cashback['2A']?$cashback['2A']:0?>" class="cashback">
							</td>
							<td></td>
							<td>
								<input type="text" name="cashback[2ABC]" value="<?php echo $cashback['2ABC']?$cashback['2ABC']:0?>" class="cashback">
							</td>
						</tr>
						<tr>
							<td>水钱</td>
							<td></td>
							<td>
								<span id="cashback_money_b"><?php  echo $cashback_money['money_b'];?></span>
							</td>
							<td></td>
							<td>
								<span id="cashback_money_s"><?php  echo $cashback_money['money_s'];?></span>
							</td>
							<td></td>
							<td>
								<span id="cashback_money_a"><?php  echo $cashback_money['money_a'];?></span>
							</td>
							<td></td>
							<td>
								<span id="cashback_money_3abc"><?php  echo $cashback_money['money_3abc'];?></span>
							</td>
							<td></td>
							<td>
								<span id="cashback_money_4a"><?php  echo $cashback_money['money_4a'];?></span>
							</td>
							<td></td>
							<td>
								<span id="cashback_money_4abc"><?php  echo $cashback_money['money_4abc'];?></span>
							</td>
							<td></td>
							<td>
								<span id="cashback_money_2a"><?php  echo $cashback_money['money_2a'];?></span>
							</td>
							<td></td>
							<td>
								<span id="cashback_money_2abc"><?php  echo $cashback_money['money_2abc'];?></span>
							</td>
						</tr>
						<tr>
							<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('first_odds', TEMPLATE_INCLUDEPATH)) : (include template('first_odds', TEMPLATE_INCLUDEPATH));?>
						</tr>
						<tr>
							<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('secound_odds', TEMPLATE_INCLUDEPATH)) : (include template('secound_odds', TEMPLATE_INCLUDEPATH));?>
						</tr>
						<tr>
							<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('third_odds', TEMPLATE_INCLUDEPATH)) : (include template('third_odds', TEMPLATE_INCLUDEPATH));?>
						</tr>
						<tr>
							<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('special_odds', TEMPLATE_INCLUDEPATH)) : (include template('special_odds', TEMPLATE_INCLUDEPATH));?>
						</tr>
						<tr>
							<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('consolation_odds', TEMPLATE_INCLUDEPATH)) : (include template('consolation_odds', TEMPLATE_INCLUDEPATH));?>
						</tr>
						<tr>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td>EC</td>
							<td>
								<input type="text" name="odds[EC][]" value="<?php echo $odds['odds_EC'][0]?$odds['odds_EC'][0]:0?>" class="odds_a">
							</td>
							<td></td>
							<td></td>
							<td>EA</td>
							<td>
								<input type="text" name="odds[EA][]" value="<?php echo $odds['odds_EA'][0]?$odds['odds_EA'][0]:0?>" class="odds_4a">
							</td>
							<td></td>
							<td></td>
							<td>EX</td>
							<td>
								<input type="text" name="odds[EX][]" value="<?php echo $odds['odds_EX'][0]?$odds['odds_EX'][0]:0?>" class="odds_2a">
							</td>
							<td></td>
							<td></td>
						</tr>
					</table>
				</div>
				<div class="form-group">
					<div class="col-md-2 col-md-offset-10">
						<button type="submit" class="btn btn-primary" name="submit" id='summit_info' value="提交">保存</button>
						<input type="hidden" name="token" value="<?php  echo $_W['token'];?>" />
					</div>
				</div>


			</form>
	</div>
</div>
<script type="text/javascript" src="../addons/purchasing/static/js/agent.js"></script>
<!-- <script>
	$('input').blur(function () {
		var odds_b = [];
		var odds_s = [];
		var odds_a = [];
		var odds_3abc = [];
		var odds_4a = [];
		var odds_4abc = [];
		var odds_2a = [];
		var odds_2abc = [];
		var cashback = [];

		var jackpot = parseInt($('input[name=jackpot]').val());
		$('.cashback').each(function () {
			cashback.push(parseInt($(this).val()));
		})

		$('.odds_b').each(function () {
			odds_b.push(parseInt($(this).val()));
		});
		var odds_b_total = eval(odds_b.join("+"));
		if (odds_b_total > 1000) {
			var cashback_b = 10000-odds_b_total-(cashback[0]*100)-(jackpot*100);
		}
		if (odds_b_total > 100 && odds_b_total < 1000) {
			var cashback_b = 1000-odds_b_total-(cashback[0]*10)-(jackpot*10);
		}
		if (odds_b_total < 100) {
			var cashback_b = 100-odds_b_total-cashback[0]-jackpot;
		}

		$('.odds_s').each(function () {
			odds_s.push(parseInt($(this).val()));
		});
		var odds_s_total = eval(odds_s.join("+"));
		if (odds_s_total > 1000) {
			var cashback_s = 10000-odds_s_total-(cashback[1]*100)-(jackpot*100);
		}
		if (odds_s_total > 100 && odds_s_total < 1000) {
			var cashback_s = 1000-odds_s_total-(cashback[1]*10)-(jackpot*10);
		}
		if (odds_s_total < 100) {
			var cashback_s = 100-odds_s_total-cashback[1]-jackpot;
		}

		$('.odds_3abc').each(function () {
			odds_3abc.push(parseInt($(this).val()));
		});
		var odds_3abc_total = eval(odds_3abc.join("+"));
		if (odds_3abc_total > 1000) {
			var cashback_3abc = 10000-odds_3abc_total-(cashback[2]*100)-(jackpot*100);
		}
		if (odds_3abc_total > 100 && odds_3abc_total < 1000) {
			var cashback_3abc = 1000-odds_3abc_total-(cashback[2]*10)-(jackpot*10);
		}
		if (odds_3abc_total < 100) {
			var cashback_3abc = 100-odds_3abc_total-cashback[2]-jackpot;
		}

		$('.odds_4abc').each(function () {
			odds_4abc.push(parseInt($(this).val()));
		});
		var odds_4abc_total = eval(odds_4abc.join("+"));
		if (odds_4abc_total > 1000) {
			var cashback_4abc = 10000-odds_4abc_total-(cashback[3]*100)-(jackpot*100);
		}
		if (odds_4abc_total > 100 && odds_4abc_total < 1000) {
			var cashback_4abc = 1000-odds_4abc_total-(cashback[3]*10)-(jackpot*10);
		}
		if (odds_4abc_total < 100) {
			var cashback_4abc = 100-odds_4abc_total-cashback[3]-jackpot;
		}

		$('.odds_2abc').each(function () {
			odds_2abc.push(parseInt($(this).val()));
		});
		var odds_2abc_total = eval(odds_2abc.join("+"));
		if (odds_2abc_total > 1000) {
			var cashback_2abc = 10000-odds_2abc_total-(cashback[4]*100)-(jackpot*100);
		}
		if (odds_2abc_total > 100 && odds_2abc_total < 1000) {
			var cashback_2abc = 1000-odds_2abc_total-(cashback[4]*10)-(jackpot*10);
		}
		if (odds_2abc_total < 100) {
			var cashback_2abc = 100-odds_2abc_total-cashback[4]-jackpot;
		}

		$('.odds_2a').each(function () {
			odds_2a.push(parseInt($(this).val()));
		});
		var odds_2a_max = get_max(odds_2a);
		if (odds_2a_max > 1000) {
			var cashback_2a = 10000-odds_2a_max-(cashback[5]*100)-(jackpot*100);
		}
		if (odds_2a_max >= 100 && odds_2a_max < 1000) {
			var cashback_2a = 1000-odds_2a_max-(cashback[5]*10)-(jackpot*10);
		}
		if (odds_2a_max < 100) {
			var cashback_2a = 100-odds_2a_max-cashback[5]-jackpot;
		}
		console.log(cashback[5]);

		$('.odds_4a').each(function () {
			odds_4a.push(parseInt($(this).val()));
		});
		var odds_4a_max = get_max(odds_4a);
		if (odds_4a_max > 1000) {
			var cashback_4a = 10000-odds_4a_max-(cashback[6]*100)-(jackpot*100);
		}
		if (odds_4a_max >= 100 && odds_4a_max < 1000) {
			var cashback_4a = 1000-odds_4a_max-(cashback[6]*10)-(jackpot*10);
		}
		if (odds_4a_max < 100) {
			var cashback_4a = 100-odds_4a_max-cashback[6]-jackpot;
		}
		console.log(cashback[6]);

		$('.odds_a').each(function () {
			odds_a.push(parseInt($(this).val()));
		});
		var odds_a_max = get_max(odds_a);
		if (odds_a_max > 1000) {
			var cashback_a = 10000-odds_a_max-(cashback[7]*100)-(jackpot*100);
		}
		if (odds_a_max >= 100 && odds_a_max < 1000) {
			var cashback_a = 1000-odds_a_max-(cashback[7]*10)-(jackpot*10);
		}
		if (odds_a_max < 100) {
			var cashback_a = 100-odds_a_max-cashback[7]-jackpot;
		}
		console.log(cashback[7]);

		$('#cashback_money_b').html(cashback_b/100);
		$('#cashback_money_s').html(cashback_s/100);
		$('#cashback_money_a').html(cashback_a/100);
		$('#cashback_money_3abc').html(cashback_3abc/100);
		$('#cashback_money_4a').html(cashback_4a/100);
		$('#cashback_money_4abc').html(cashback_4abc/100);
		$('#cashback_money_2a').html(cashback_2a/100);
		$('#cashback_money_2abc').html(cashback_2abc/100);
	})

	function get_max(obj) {
		var max = obj[0];
		var len = obj.length;
		for (var i = 1; i < len; i++){
			if (obj[i] > max) {
				max = obj[i];
			}
		}
		return max;
	}
</script> -->
<?php  } ?>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/footer', TEMPLATE_INCLUDEPATH)) : (include template('common/footer', TEMPLATE_INCLUDEPATH));?>