<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/header', TEMPLATE_INCLUDEPATH)) : (include template('common/header', TEMPLATE_INCLUDEPATH));?>
<ul class="nav nav-tabs">
	<li <?php  if($op == 'display') { ?> class="active" <?php  } ?>><a href="<?php  echo $this->createWebUrl('lottery',array('op'=>'display'))?>">期数列表</a></li>
	<li <?php  if($op == 'add') { ?>class="active"<?php  } ?>><a href="<?php  echo $this->createWebUrl('lottery',array('op'=>'add'))?>">添加</a></li>
	<li <?php  if($op == 'edit') { ?>class="active"<?php  } ?><?php  if($op != 'edit') { ?>style="display:none"<?php  } ?>><a href="<?php  echo $this->createWebUrl('lottery',array('op'=>'edit'))?>">编辑</a></li>
	<li <?php  if($op == 'lottery_number') { ?>class="active"<?php  } ?><?php  if($op != 'lottery_number') { ?>style="display:none"<?php  } ?>><a href="javascript:;">号码设置</a></li>

</ul>
<?php  if($op == 'display') { ?>
<form class="form-inline" role="form" action="" method="get">
	<input type="hidden" name="c" value="site">
	<input type="hidden" name="a" value="entry">
	<input type="hidden" name="do" value="lottery">
	<input type="hidden" name="m" value="manji">
	<div class="panel panel-info">
		<div class="panel-heading">
			筛选
		</div>
		<div class="panel-body">
			<div class="form-group">
				<label for="keyword">关键词</label>
				<input type="text" name="keyword" id="keyword" placeholder="请输入期数" class="form-control" value="<?php  echo $_GPC['keyword'];?>">
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
				<td>期数 </td>
				<td>下注开始时间</td>
                	<td>投注截止时间</td>
				<td>开奖开始时间</td>
			
				<td>操作</td>
			</tr>
		</thead>
		<tbody>
			<?php  if(is_array($list)) { foreach($list as $item) { ?>
			<tr>
				<td><?php  echo $item['id'];?></td>
				<td><a href="<?php  echo $this->createWebUrl('lottery',array('op'=>'detail','id'=>$item['id']))?>" title="点击查看中奖详情"><?php  echo $item['periods'];?></a></td>
				<td><?php  echo date('Y-m-d H:i:s',$item['starttime'])?></td>
                	<td><?php  echo date('Y-m-d H:i:s',$item['stoptime'])?></td>
				<td><?php  echo date('Y-m-d H:i:s',$item['endtime'])?></td>
			
				<td>
					<a href="<?php  echo $this->createWebUrl('lottery',array('op'=>'edit','id'=>$item['id']))?>"><i class="fa fa-pencil"></i>编辑</a>
					<a href="<?php  echo $this->createWebUrl('lottery',array('op'=>'lottery_number','id'=>$item['id']))?>"><i class="fa fa-pencil"></i>添加号码</a>
					<a href="<?php  echo $this->createWebUrl('lottery',array('op'=>'detail','id'=>$item['id']))?>" title="点击查看中奖详情">查看中奖详情</a>
				</td>
			</tr>
			<?php  } } ?>
		</tbody>
	</table>
	<?php  echo $pager;?>
</div>
<?php  } else if($op == 'add' || $op == 'edit') { ?>

<script language="javascript">  
function sumbit_sure(){  
	var gnl=confirm("您确认要提交吗？一旦提交 不能修改");  
	if (gnl==true){  
		return true;  
	}else{  
		return false;  
	}  
}  
</script>  

<div class="panel panel-info">
		<div class="panel-body">
			<form action="<?php  echo $this->createWebUrl('lottery',array('op'=>'post'))?>"  onsubmit="return sumbit_sure()" method="post" class="form-horizontal" role="form">
				<input type="hidden" name="id" value="<?php  echo $_GPC['id'];?>">
				<div class="form-group">
					<label class="col-xs-4 col-sm-4 col-md-4 col-lg-1 control-label">期数</label>
					<div class="col-xs-8 col-sm-8 col-md-8 col-lg-11">
						<input class="form-control"  name="periods" id='periods' type="text" value="<?php  echo $item['periods'];?>" placeholder="如：201801010001">
					</div>
				</div>
				<div class="form-group">
					<label class="col-xs-4 col-sm-4 col-md-4 col-lg-1 control-label">下注开始时间</label>
					<div class="col-xs-8 col-sm-8 col-md-8 col-lg-11">
						<?php  echo  tpl_form_field_date('starttime',$item['starttime'],true)?>
					</div>

				</div>

				<div class="form-group">
					<label class="col-xs-4  col-sm-4 col-md-4 col-lg-1 control-label">开奖开始时间</label>
					<div class="col-xs-8 col-sm-8 col-md-8 col-lg-11">
						<?php  echo  tpl_form_field_date('endtime',$item['endtime'],true)?>
					</div>
				</div>
               <!--
				<div class="form-group">
					<label class="col-xs-4  col-sm-4 col-md-4 col-lg-1 control-label">投注截止时间</label>
					<div class="col-xs-8 col-sm-8 col-md-8 col-lg-11">
						<?php  echo  tpl_form_field_date('stoptime',$item['stoptime'],true)?>
					</div>
				</div>
				-->
				<div class="form-group">
					<div class="col-md-4 col-md-offset-4">
						<input type="submit" class="btn btn-primary" name="submit" id='summit_info' value="开奖"/>
						<input type="hidden" name="token" value="<?php  echo $_W['token'];?>" />
					</div>

				</div>


			</form>
		</div>
</div>
<script>
 </script>
<?php  } ?>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/footer', TEMPLATE_INCLUDEPATH)) : (include template('common/footer', TEMPLATE_INCLUDEPATH));?>