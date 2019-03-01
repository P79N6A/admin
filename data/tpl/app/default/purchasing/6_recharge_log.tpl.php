<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('agent_header', TEMPLATE_INCLUDEPATH)) : (include template('agent_header', TEMPLATE_INCLUDEPATH));?>
<div class="col-xs-12" style="padding: 5px 0;">
	<div class="col-xs-12" style="padding: 10px 0;">
		<a href="<?php  echo $this->createMobileUrl('recharge_log',array('op'=>'display'))?>" class="btn" <?php  if($op == 'display') { ?>style="background:#fff;color: #333;"<?php  } ?>>代理</a>
		<a href="<?php  echo $this->createMobileUrl('recharge_log',array('op'=>'member'))?>" class="btn" <?php  if($op == 'member') { ?>style="background:#fff;color: #333;"<?php  } ?>>会员</a>
	</div>
	<form action="<?php  echo $this->createMobileUrl('recharge_log',array('agent_id'=>$_GPC['agent_id']));?>" class="form-inline" role="form" method="get">
		<div class="form-group" >
			关键字：
			<input type="text" name="keyword" value="<?php  echo $_GPC['keyword'];?>">
			开始日期:
			<input type="text" name="stime" id="starttime" readonly="readonly" value="<?php  echo $_GPC['stime'];?>">
			结束日期:
			<input type="text" name="etime" id="endtime" readonly="readonly" value="<?php  echo $_GPC['etime'];?>">
			<!--c=site&a=entry&eid=181-->
			<input type="hidden" name="c" value="<?php  echo $_GPC['c'];?>">
			<input type="hidden" name="i" value="<?php  echo $_GPC['i'];?>">
			<input type="hidden" name="do" value="<?php  echo $_GPC['do'];?>">
			<input type="hidden" name="m" value="<?php  echo $_GPC['m'];?>">
			<input type="hidden" name="op" value="<?php  echo $_GPC['op'];?>">
			<input type="submit" value="查询" class="btn btn-info">
		</div>
	</form>
	<table class="table table-bordered" style="margin-top: 10px;">
		<tr>
			<th>账号</th>
			<th>昵称</th>
			<th>金额</th>
			<th>类型</th>
			<th>时间</th>
		</tr>
		<?php  if(is_array($list)) { foreach($list as $item) { ?>
		<tr>
			<td><?php  echo $item['account'];?></td>
			<td><?php  echo $item['nickname'];?></td>
			<td><?php  echo $item['score'];?></td>
			<td><?php  if($item['score_type'] == 1) { ?>充值<?php  } else { ?>减值<?php  } ?></td>
			<td><?php  echo $item['create_time'];?></td>
		</tr>
		<?php  } } ?>
	</table>
</div>