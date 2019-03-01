<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/header', TEMPLATE_INCLUDEPATH)) : (include template('common/header', TEMPLATE_INCLUDEPATH));?>
<ul class="nav nav-tabs">
	<li <?php  if($op == 'display') { ?> class="active" <?php  } ?>><a href="<?php  echo $this->createWebUrl('lottery',array('op'=>'display'))?>">期数列表</a></li>
	<li <?php  if($op == 'add') { ?>class="active"<?php  } ?>><a href="<?php  echo $this->createWebUrl('lottery',array('op'=>'add'))?>">添加</a></li>
	<li <?php  if($op == 'edit') { ?>class="active"<?php  } ?><?php  if($op != 'edit') { ?>style="display:none"<?php  } ?>><a href="<?php  echo $this->createWebUrl('lottery',array('op'=>'edit'))?>">编辑</a></li>
	<li <?php  if($op == 'lottery_number') { ?>class="active"<?php  } ?><?php  if($op != 'lottery_number') { ?>style="display:none"<?php  } ?>><a href="javascript:;">号码设置</a></li>
	<li <?php  if($op == 'detail') { ?>class="active"<?php  } ?><?php  if($op != 'detail') { ?>style="display:none"<?php  } ?>><a href="javascript:;">中奖详情</a></li>

</ul>
<?php  if($op == 'detail') { ?>

<div class="panel panel-info">
    <div class="panel-body">
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
						<?php  if(is_array($first)) { foreach($first as $f) { ?>
						<div class="col-xs-2 col-sm-2 col-md-2 col-lg-2"><?php  echo $f['id'];?>:<?php  echo $f['nickname'];?></div>
						<?php  } } ?>
					</div>
				</div>
			</div>

			<div class="form-group">
				<label class="col-xs-4  col-sm-4 col-md-4 col-lg-1 control-label">二等奖名单</label>
				<div class="col-xs-8 col-sm-8 col-md-8 col-lg-11">
					<div class="row">
						<?php  if(is_array($second)) { foreach($second as $f) { ?>
						<div class="col-xs-2 col-sm-2 col-md-2 col-lg-2"><?php  echo $f['id'];?>:<?php  echo $f['nickname'];?></div>
						<?php  } } ?>
					</div>
				</div>
			</div>

			<div class="form-group">
				<label class="col-xs-4  col-sm-4 col-md-4 col-lg-1 control-label">三等奖名单</label>
				<div class="col-xs-8 col-sm-8 col-md-8 col-lg-11">
					<div class="row">
						<?php  if(is_array($third)) { foreach($third as $f) { ?>
						<div class="col-xs-2 col-sm-2 col-md-2 col-lg-2"><?php  echo $f['id'];?>:<?php  echo $f['nickname'];?></div>
						<?php  } } ?>
					</div>
				</div>
			</div>

			<div class="form-group">
				<label class="col-xs-4  col-sm-4 col-md-4 col-lg-1 control-label">特等奖名单</label>
				<div class="col-xs-8 col-sm-8 col-md-8 col-lg-11">
					<div class="row">
						<?php  if(is_array($special)) { foreach($special as $f) { ?>
						<div class="col-xs-2 col-sm-2 col-md-2 col-lg-2"><?php  echo $f['id'];?>:<?php  echo $f['nickname'];?></div>
						<?php  } } ?>
					</div>
				</div>
			</div>
			<div class="form-group">
				<label class="col-xs-4  col-sm-4 col-md-4 col-lg-1 control-label">安慰奖名单</label>
				<div class="col-xs-8 col-sm-8 col-md-8 col-lg-11">
					<div class="row">
						<?php  if(is_array($consolation)) { foreach($consolation as $f) { ?>
						<div class="col-xs-2 col-sm-2 col-md-2 col-lg-2"><?php  echo $f['id'];?>:<?php  echo $f['nickname'];?></div>
						<?php  } } ?>
					</div>
				</div>
			</div>

			<div class="form-group">
				<label class="col-xs-4  col-sm-4 col-md-4 col-lg-1 control-label"></label>
				<div class="col-xs-8 col-sm-8 col-md-8 col-lg-11">
					 <input type="button" class="btn btn-success sendBtn" value="发送中奖消息">
				</div>
			</div>
		</form>
	</div>
</div>
<script>
	$('.sendBtn').click(function(){
		var id = $('input[name=period_id]').val();
	    $.post("<?php  echo $this->createWebUrl('lottery',array('op'=>'send_msg'))?>",{period_id:id},function(response){
	        alert(response.msg);
		},'json');
	});
 </script>
<?php  } ?>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/footer', TEMPLATE_INCLUDEPATH)) : (include template('common/footer', TEMPLATE_INCLUDEPATH));?>