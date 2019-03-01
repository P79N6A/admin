<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('agent_header', TEMPLATE_INCLUDEPATH)) : (include template('agent_header', TEMPLATE_INCLUDEPATH));?>
<style type="text/css">
	.input-container{display: inherit;}
</style>
<link rel="stylesheet" href="../addons/purchasing/static/css/BeatPicker.min.css"/>
<script src="../addons/purchasing/static/js/BeatPicker.min.js"></script>
<div class="col-xs-12" style="padding: 5px 0;">
	<form action="<?php  echo $this->createMobileUrl('mybaobiao',array('agent_id'=>$_GPC['agent_id']));?>" class="form-inline" role="form" method="get">
		<div class="form-group" >
			开始日期:
			<input type="text" name="stime" id="starttime" readonly="readonly" value="<?php  echo $_GPC['stime'];?>" data-beatpicker="true" data-beatpicker-module="clear">
			结束日期:
			<input type="text" name="etime" id="endtime" readonly="readonly" value="<?php  echo $_GPC['etime'];?>" data-beatpicker="true" data-beatpicker-module="clear">
			<!--c=site&a=entry&eid=181-->
			<input type="hidden" name="c" value="<?php  echo $_GPC['c'];?>">
			<input type="hidden" name="i" value="<?php  echo $_GPC['i'];?>">
			<input type="hidden" name="do" value="<?php  echo $_GPC['do'];?>">
			<input type="hidden" name="m" value="<?php  echo $_GPC['m'];?>">
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
				<?php  if($item['user_type'] == 1) { ?><a href="<?php  echo $this->createMobileUrl('mybaobiao',array('agent_id'=>$item['agent_id'],'stime'=>$_GPC['stime'],'etime'=>$_GPC['etime']))?>" title=""><?php  echo $item['account'];?></a><?php  } else { ?><?php  echo $item['account'];?><?php  } ?>
			</td>
			<td><?php  echo $item['nickname'];?></td>
			<td>
				<?php  if($item['user_type'] == 1) { ?>
				<a href="<?php  echo $this->createMobileUrl('agent_report',array('op'=>'cathectic','stime'=>$_GPC['stime'],'etime'=>$_GPC['etime'],'agent_id'=>$item['agent_id']))?>"><?php  echo round($item['sum_bet'],2);?></a>
				<?php  } else { ?>
				<a href="<?php  echo $this->createMobileUrl('agent_report',array('op'=>'cathectic','stime'=>$_GPC['stime'],'etime'=>$_GPC['etime'],'member_id'=>$item['member_id']))?>"><?php  echo round($item['sum_bet'],2);?></a>
				<?php  } ?>
			</td>
			<td><?php  echo round($item['cashback'],2);?></td>
			<td>
				<?php  if($item['user_type'] == 1) { ?>
				<a href="<?php  echo $this->createMobileUrl('agent_report',array('op'=>'reward','stime'=>$_GPC['stime'],'etime'=>$_GPC['etime'],'agent_id'=>$item['agent_id']))?>"><?php  echo round($item['pay_award'],2);?></a>
				<?php  } else { ?>
				<a href="<?php  echo $this->createMobileUrl('agent_report',array('op'=>'reward','stime'=>$_GPC['stime'],'etime'=>$_GPC['etime'],'member_id'=>$item['member_id']))?>"><?php  echo round($item['pay_award'],2);?></a>
				<?php  } ?>
			</td>
			<td><?php  echo round($item['profit'],2);?></td>
			<td><?php  echo round($item['bonus'],2);?></td>
			<td><?php  echo round($item['net'],2);?></td>
			<td><?php  echo round($item['sum_bet'],2);?></td>
			<td><?php  echo round($item['upline_cashback'],2);?></td>
			<td><?php  echo round($item['pay_award'],2);?></td>
			<td><?php  echo round($item['upline_profit'],2);?></td>
			<td><?php  echo round($item['upline_bonus'],2);?></td>
			<td><?php  echo round($item['upline_net'],2);?></td>
			<td><?php  echo round($item['commission'],2);?></td>
			<td>0</td>
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
			<td><?php  echo round($li['total']['pay_award'],2);?></td>
			<td><?php  echo round($li['total']['upline_profit'],2);?></td>
			<td><?php  echo round($li['total']['upline_bonus'],2);?></td>
			<td><?php  echo round($li['total']['upline_net'],2);?></td>
			<td><?php  echo round($li['total']['commission'],2);?></td>
			<td></td>
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
	<?php  echo $pager;?>
</div>
<!-- <script src="../DateBox/required.js" type="text/javascript" charset="utf-8"></script>
<script type="text/javascript">
	requirejs(['../DateBox/DateBox'],function(DateBox){
		new DateBox('starttime',{type:'y-d'});
		
		new DateBox('endtime',{type:'y-d'});

	});
</script> -->