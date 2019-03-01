<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/header', TEMPLATE_INCLUDEPATH)) : (include template('common/header', TEMPLATE_INCLUDEPATH));?>
<ul class="nav nav-tabs">
	<li <?php  if($op == 'display') { ?>class="active"<?php  } ?>><a href="<?php  echo $this->createWebUrl('report',array('op'=>'display'));?>">营收概况</a></li>
	<li <?php  if($op == 'cathectic') { ?>class="active"<?php  } ?>><a href="<?php  echo $this->createWebUrl('report',array('op'=>'cathectic'))?>">投注明细</a></li>
	<li <?php  if($op == 'reward') { ?>class="active"<?php  } ?>><a href="<?php  echo $this->createWebUrl('report',array('op'=>'reward'))?>">中奖明细</a></li>
 </ul>
<?php  if($op == 'display') { ?>
<div class="panel panel-info">
	<div class="panel-heading">
		<h3 class="panel-title">收益总览</h3>
	</div>
	<div class="panel-body">
		<form action="<?php  echo $this->createWebUrl('report');?>" class="form-inline" role="form" method="get">
			<div class="form-group" >
				开始日期:
				<?php  echo tpl_form_field_date('stime',$stime);?>
				结束日期:
				<?php  echo tpl_form_field_date('etime',$etime);?>
				<!--c=site&a=entry&eid=181-->
				<input type="hidden" name="c" value="<?php  echo $_GPC['c'];?>">
				<input type="hidden" name="a" value="<?php  echo $_GPC['a'];?>">
				<input type="hidden" name="do" value="<?php  echo $_GPC['do'];?>">
				<input type="hidden" name="m" value="<?php  echo $_GPC['m'];?>">
				<input type="hidden" name="op" value="display">
				<input type="submit" value="查询" class="btn btn-info">
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
						<a href="<?php  echo $this->createWebUrl('report',array('op'=>'detail','id'=>$item['id']))?>" style="margin-right: 10px;">明细</a><a href="<?php  echo $this->createWebUrl('report',array('op'=>'downline','period_id'=>$item['id']))?>">下线结算表</a>
					</td>
				</tr>
				<?php  } } ?>
			</table>
		</form>
	</div>
</div>
<?php  } ?>
<?php  if($op == 'detail') { ?>
<div class="panel panel-info">
	<div class="panel-heading">
		<h3 class="panel-title">代理总览</h3>
	</div>
	<div class="panel-body">
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
	                            	<a href="<?php  echo $this->createWebUrl('report',array('op'=>'detail','id'=>$id,'purchasing_id'=>$item['id']))?>" class="btn btn-default col-sm-3 col-xs-offset-3">查看下级</a>
	                                <a href="<?php  echo $this->createWebUrl('report',array('op'=>'member','id'=>$id,'agent_id'=>$item['id']))?>" class="btn btn-primary col-sm-3">查看会员</a>
	                            </div>
	                        </div><!-- /.modal-content -->
	                    </div><!-- /.modal -->
	                </div>
				</td>
			</tr>
			<?php  } } ?>
		</table>
		<?php  echo $pager;?>
	</div>
</div>
<?php  } ?>
<?php  if($op == 'member') { ?>
<div class="panel panel-info">
	<div class="panel-heading">
		<h3 class="panel-title">会员总览</h3>
	</div>
	<div class="panel-body">
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
	</div>
</div>
<?php  } ?>
<?php  if($op == 'cathectic') { ?>
<style type="text/css">
	.right-content{padding: 0;}
	.table>tbody>tr>td{padding: 0;text-align: center;}
</style>
<div class="panel panel-info">
	<div class="panel-heading">
		<h3 class="panel-title">投注明细</h3>
	</div>
	<div class="panel-body">
		<form action="<?php  echo $this->createWebUrl('report');?>" class="form-inline" role="form" method="get">
			<div class="form-group" >
				期数:
				<input type="text" name="periods" value="<?php  echo $_GPC['periods'];?>">
				投注人:
				<input type="text" name="member" value="<?php  echo $_GPC['member'];?>">
				<!--c=site&a=entry&eid=181-->
				<input type="hidden" name="c" value="<?php  echo $_GPC['c'];?>">
				<input type="hidden" name="a" value="<?php  echo $_GPC['a'];?>">
				<input type="hidden" name="do" value="<?php  echo $_GPC['do'];?>">
				<input type="hidden" name="m" value="<?php  echo $_GPC['m'];?>">
				<input type="hidden" name="op" value="cathectic">
				<input type="submit" value="查询" class="btn btn-info">
			</div>

			<table class="table table-bordered" style="margin-top: 10px;">
				<tr class="active">
					<td>投注人</td>
					<td>时间</td>
					<td>期数</td>
					<td>号码</td>
					<td>B</td>
					<td>S</td>
					<td>A</td>
					<td>C2</td>
					<td>C3</td>
					<td>C4</td>
					<td>C5</td>
					<td>EC</td>
					<td>3ABC</td>
					<td>4A</td>
					<td>4B</td>
					<td>4C</td>
					<td>4D</td>
					<td>4E</td>
					<td>EA</td>
					<td>4AC</td>
					<td>2A</td>
					<td>2B</td>
					<td>2C</td>
					<td>2D</td>
					<td>2E</td>
					<td>EX</td>
					<td>2ABC</td>
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
					<td><?php  echo $item['pay_C2'];?></td>
					<td><?php  echo $item['pay_C3'];?></td>
					<td><?php  echo $item['pay_C4'];?></td>
					<td><?php  echo $item['pay_C5'];?></td>
					<td><?php  echo $item['pay_EC'];?></td>
					<td><?php  echo $item['pay_3ABC'];?></td>
					<td><?php  echo $item['pay_4A'];?></td>
					<td><?php  echo $item['pay_4B'];?></td>
					<td><?php  echo $item['pay_4C'];?></td>
					<td><?php  echo $item['pay_4D'];?></td>
					<td><?php  echo $item['pay_4E'];?></td>
					<td><?php  echo $item['pay_EA'];?></td>
					<td><?php  echo $item['pay_4ABC'];?></td>
					<td><?php  echo $item['pay_2A'];?></td>
					<td><?php  echo $item['pay_2B'];?></td>
					<td><?php  echo $item['pay_2C'];?></td>
					<td><?php  echo $item['pay_2D'];?></td>
					<td><?php  echo $item['pay_2E'];?></td>
					<td><?php  echo $item['pay_EX'];?></td>
					<td><?php  echo $item['pay_2ABC'];?></td>
				</tr>
				<?php  } } ?>
			</table>
			<?php  echo $pager;?>
		</form>
	</div>
</div>
<?php  } ?>
<?php  if($op == 'reward') { ?>
<div class="panel panel-info">
	<div class="panel-heading">
		<h3 class="panel-title">投注明细</h3>
	</div>
	<div class="panel-body">
		<form action="<?php  echo $this->createWebUrl('report');?>" class="form-inline" role="form" method="get">
			<div class="form-group" >
				期数:
				<input type="text" name="periods" value="<?php  echo $_GPC['periods'];?>">
				中奖人:
				<input type="text" name="member" value="<?php  echo $_GPC['member'];?>">
				<!--c=site&a=entry&eid=181-->
				<input type="hidden" name="c" value="<?php  echo $_GPC['c'];?>">
				<input type="hidden" name="a" value="<?php  echo $_GPC['a'];?>">
				<input type="hidden" name="do" value="<?php  echo $_GPC['do'];?>">
				<input type="hidden" name="m" value="<?php  echo $_GPC['m'];?>">
				<input type="hidden" name="op" value="reward">
				<input type="submit" value="查询" class="btn btn-info">
			</div>

			<table class="table table-bordered" style="margin-top: 10px;">
				<tr class="active">
					<td>中奖人</td>
					<td>代理人</td>
					<td>中奖时间</td>
					<td>开奖期数</td>
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
					<td><?php  echo $item['agent_name'];?></td>
					<td><?php  echo date('Y-m-d H:i',$item['create_time'])?></td>
					<td><?php  echo $item['period_num'];?></td>
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
	</div>
</div>
<?php  } ?>
<?php  if($op == 'downline') { ?>
<div class="panel panel-info">
	<div class="panel-heading">
		<h3 class="panel-title">下线结算表</h3>
	</div>
	<div class="panel-body">
		<table class="table table-bordered" style="margin-top: 10px;font-size: 12px;">
			<tr class="active">
				<td>代理</td>
				<td>来</td>
				<td>下线中奖</td>
				<td>下线佣金</td>
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
				<td>彩金</td>
			</tr>
			<?php  if(is_array($list)) { foreach($list as $item) { ?>
			<tr>
				<td>
					<a href="<?php  echo $this->createWebUrl('report',array('op'=>'downline','period_id'=>$_GPC['period_id'],'id'=>$item['id']))?>">
						<?php  echo $item['nickname'];?>
					</a>
				</td>
				<td><?php  echo $item['sum_bet'];?></td>
				<td><?php  echo $item['pay_award'];?></td>
				<td><?php  echo $item['cashback'];?></td>
				<td><?php  echo $item['profit'];?></td>
				<td><?php  echo $item['bonus'];?></td>
				<td><?php  echo $item['net'];?></td>
				<td><?php  echo $item['sum_bet'];?></td>
				<td><?php  echo $item['upline_cashback'];?></td>
				<td><?php  echo $item['pay_award'];?></td>
				<td><?php  echo $item['upline_profit'];?></td>
				<td><?php  echo $item['upline_bonus'];?></td>
				<td><?php  echo $item['upline_net'];?></td>
				<td>0</td>
				<td>0</td>
				<td><?php  echo $item['jackpot_profit'];?></td>
			</tr>
			<?php  } } ?>
		</table>
		<?php  echo $pager;?>
	</div>
</div>
<?php  } ?>

 
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/footer', TEMPLATE_INCLUDEPATH)) : (include template('common/footer', TEMPLATE_INCLUDEPATH));?>
