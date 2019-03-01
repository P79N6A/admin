<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/header', TEMPLATE_INCLUDEPATH)) : (include template('common/header', TEMPLATE_INCLUDEPATH));?>
	<link href="../addons/zofui_groupshop/template/web/css/common.css" rel="stylesheet">
	
<ul class="page_top">
	<a href="<?php  echo $this->createWebUrl('group',array('op'=>'list','gstatus'=>''))?>">
		<li class="top_btn <?php  if(empty($_GPC['gstatus']) && $op != 'info') { ?>activity_bottom<?php  } ?>">全部团</li>
	</a>
	<a href="<?php  echo $this->createWebUrl('group',array('op'=>'list','gstatus'=>1))?>">
		<li class="top_btn <?php  if($_GPC['gstatus'] == 1) { ?>activity_bottom<?php  } ?>">组团中</li>
	</a>
	<a href="<?php  echo $this->createWebUrl('group',array('op'=>'list','gstatus'=>3))?>">
		<li class="top_btn <?php  if($_GPC['gstatus'] == 3) { ?>activity_bottom<?php  } ?>">已完成</li>
	</a>
	<a href="<?php  echo $this->createWebUrl('group',array('op'=>'list','gstatus'=>2))?>">
		<li class="top_btn <?php  if($_GPC['gstatus'] == 2) { ?>activity_bottom<?php  } ?>">已失败</li>
	</a>	
	<?php  if($op == 'info') { ?>
		<a href="<?php  echo $this->createWebUrl('group',array('op'=>'info','id'=>$_GPC['id']))?>">
			<li class="top_btn <?php  if($op == 'info') { ?>activity_bottom<?php  } ?>">团订单</li>
		</a>
	<?php  } ?>
</ul>

<div class="page_body">

<?php  if($op == 'list') { ?>
	
	<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('../../../addons/zofui_groupshop/template/web/common/grouplist', TEMPLATE_INCLUDEPATH)) : (include template('../../../addons/zofui_groupshop/template/web/common/grouplist', TEMPLATE_INCLUDEPATH));?>
	
<?php  } else if($op == 'info') { ?>	
	
	<div class="group_info order_info">
		<div class="panel panel-default">
		  <div class="panel-heading">团基本信息</div>
		  <div class="panel-body">			
			<div class=" item_cell_box">
				<div class="">
					<p>
						<img src="<?php  echo tomedia($groupinfo['pic'])?>" width="40px" height="40px">
						<a class="a_href" href="<?php  echo $this->createWebUrl('good',array('op'=>'edit','id'=>$_GPC['id']))?>" >234141234143141321</a>
						<span>当前状态:
						<font class="font_ff5f27">
							<?php  if($groupinfo['gstatus'] == 1) { ?>
								组团中
							<?php  } else if($groupinfo['gstatus'] == 2) { ?>
								组团失败
							<?php  } else if($groupinfo['gstatus'] == 3) { ?>
								组团成功
							<?php  } else if($groupinfo['gstatus'] == 4) { ?>
								退款中
							<?php  } ?>
						</font>
						</span>
						<span>满团人数:<font class="font_ff5f27"><?php  echo $groupinfo['fullnumber'];?></font>人</span>
						<span>剩余人数:<font class="font_ff5f27"><?php  echo $groupinfo['lastnumber'];?></font>人</span>
						<span>创团时间:<font class="font_ff5f27"><?php  echo date('Y-m-d H:i:s',$groupinfo['createtime'])?></font></span>
					</p>
				</div>
			</div>		
			
		  </div>
		</div>	
		
		
	</div>
	
	<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('../../../addons/zofui_groupshop/template/web/common/orderlist', TEMPLATE_INCLUDEPATH)) : (include template('../../../addons/zofui_groupshop/template/web/common/orderlist', TEMPLATE_INCLUDEPATH));?>
<?php  } ?>
</div>




<script src="../addons/zofui_groupshop/template/web/js/fsjs.js"></script>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/footer', TEMPLATE_INCLUDEPATH)) : (include template('common/footer', TEMPLATE_INCLUDEPATH));?>