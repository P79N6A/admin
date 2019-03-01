<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/header', TEMPLATE_INCLUDEPATH)) : (include template('common/header', TEMPLATE_INCLUDEPATH));?>
	<link href="../addons/zofui_groupshop/template/web/css/common.css" rel="stylesheet">
	
	
<ul class="page_top">
	<a href="<?php  echo $this->createWebUrl('sort',array('op'=>'add'))?>">
		<li class="top_btn <?php  if($op == 'add') { ?>activity_bottom<?php  } ?>">添加分类</li>
	</a>
	<a href="<?php  echo $this->createWebUrl('sort',array('op'=>'list','class'=>1))?>">
		<li class="top_btn <?php  if($_GPC['class'] == 1) { ?>activity_bottom<?php  } ?>">管理一级分类</li>
	</a>
	<a href="<?php  echo $this->createWebUrl('sort',array('op'=>'list','class'=>2))?>">
		<li class="top_btn <?php  if($_GPC['class'] == 2) { ?>activity_bottom<?php  } ?>">管理二级分类</li>
	</a>
	<?php  if($op == 'edit') { ?>
		<a href="<?php  echo $this->createWebUrl('sort',array('op'=>'edit','id'=>$_GPC['id']))?>">
			<li class="top_btn <?php  if($op == 'edit') { ?>activity_bottom<?php  } ?>">编辑分类</li>
		</a>
	<?php  } ?>	
</ul>

<div class="page_body">
	<?php  if($op == 'add' || $op == 'edit') { ?>
	<div class="addgood_body">
		<form method="post" action="">	
			<div class="input_item item_cell_box good_rule" <?php  if($op == 'edit') { ?>style="display:none"<?php  } ?>>
				<div class="input_title">分类级数</div>
				<div class="input_form item_cell_flex checkbox good_rule_type">
					<label><input type="radio" name="sorttype" value="1"  <?php  if($info['class'] == 1) { ?>checked="checked"<?php  } ?>> 一级分类</label>
					<label><input type="radio" name="sorttype" value="2"  <?php  if($info['class'] == 2) { ?>checked="checked"<?php  } ?>> 二级分类</label>		
				</div>
			</div>
			
			<div class="sort_classone" style="display:block">
				<div class="input_item item_cell_box">
					<div class="input_title">分类名称</div>
					<div class="input_form item_cell_flex">
						<span class="input_box input_box_300">
							<input type="text" class="input_input" name="sortname" value="<?php  echo $info['name'];?>">
						</span>
						<p class="font_13px_999"> 填入文字</p>
					</div>
				</div>		
				
				<div class="input_item item_cell_box">
					<div class="input_title">分类排序</div>
					<div class="input_form item_cell_flex">
						<span class="input_box input_box_300">
							<input type="text" class="input_input" name="sortorder" value="<?php  echo $info['order'];?>">
						</span>
						<p class="font_13px_999"> 填入正整数，数字越大越排前面</p>			
					</div>
				</div>
				
			</div>
			
			<div class="sort_classtwo" <?php  if($op == 'add' || ($op == 'edit' && $info['class'] == 1)) { ?>style="display:none"<?php  } ?>>
				<div class="input_item item_cell_box good_rule">
					<div class="input_title">所属一级分类</div>
					<div class="input_form item_cell_flex checkbox good_rule_type sort_tosort">
						<?php  if(is_array($allsort)) { foreach($allsort as $list) { ?>
							<?php  if($list['class'] == 1) { ?>
								<label>
									<input type="radio" name="upsort" value="<?php  echo $list['id'];?>" <?php  if($info['parentid'] == $list['id']) { ?>checked="checked"<?php  } ?>> <?php  echo $list['name'];?>
								</label>
							<?php  } ?>
						<?php  } } ?>
					</div>
				</div>
				
			</div>	
			
			<div class="input_item item_cell_box">
				<div class="input_title"></div>
				<div class="input_form item_cell_flex">
					<input class="btn_44b549" value="立即保存" type="submit" id="addsort" name="addsort">	
					<input type="hidden" name="token" value="<?php  echo $_W['token'];?>" />
				</div>
			</div>	
		</form>	
	</div>
	
<?php  } else if($op == 'list') { ?>
	
	<div class="list_body">
		<!-- <div class="list_top">
			<div class="input-group select_btn">
				<div class="btn-group">
				  <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
					  <?php  if($_GPC['command']=='yes') { ?>精品推荐商品
					  <?php  } else if($_GPC['command']=='no') { ?>非精品推荐商品
					  <?php  } else { ?>是否精品推荐
					  <?php  } ?>
					  <span class="caret"></span>
				  </button>
				  <ul class="dropdown-menu">
					<li><a href="">精品推荐商品</a></li>		
					<li role="separator" class="divider"></li>	
					<li><a href="">非精品推荐商品</a></li>		
					<li role="separator" class="divider"></li>				
					<li><a href="">是否精品推荐</a></li>
				  </ul>
				</div>	
			</div>	
			
		</div> -->
		<div class="list_table sort_list">
<form action="" method="post">
				<table class="table table-hover">
					<thead>
						<tr>
							<th class="col-sm-1">
								<label class="my_checkbox">
								<input class="" type="checkbox" name="" onclick="var ck = this.checked;$(':checkbox').each(function(){this.checked = ck});"> 全选/取消
								</label>
							</th>
							<th class="col-sm-1">上级</th>							
							<th class="col-sm-1">名称</th>
							<th class="col-sm-1">排序</th>						
							<th class="col-sm-1">操作</th>
						</tr>
					</thead>
					<tbody>
						<?php  if(is_array($list)) { foreach($list as $li) { ?>
						<tr>
							<td class="">
								<label class="my_checkbox">
									<input type="checkbox" name="checkid[]" value="<?php  echo $li['id'];?>" class=""> <?php  echo $li['id'];?>
								</label>
							</td>
							<td>
								<?php  if($li['class'] == 1) { ?>
									一级分类无上级
								<?php  } else { ?>
									<?php  if(is_array($allsort)) { foreach($allsort as $all) { ?>
										<?php  if($li['parentid'] == $all['id']) { ?>
											<?php  echo $all['name'];?>
										<?php  } ?>
									<?php  } } ?>
								<?php  } ?>
							</td>							
							<td>
								<?php  echo $li['name'];?>
							</td>
							<td>
								<input type="tel" name="order[<?php  echo $li['id'];?>]" value="<?php  echo $li['order'];?>" class="input_input edit_input">
							</td>
							<td class="opclass">
								<div class="input-group select_btn deal_btn">
									<div class="btn-group">
									  <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
										  操作
										  <span class="caret"></span>
									  </button>
									  <ul class="dropdown-menu">
										<li><a href="<?php  echo $this->createWebUrl('sort',array('op'=>'edit','id'=>$li['id']))?>">编辑</a></li>		
										<li role="separator" class="divider"></li>	
										<li><a href="<?php  echo $this->createWebUrl('sort',array('op'=>'delete','id'=>$li['id']))?>" onclick="return confirm('删除后不可恢复，确定要删除吗？');">删除</a></li>
									  </ul>
									</div>
								</div>								
							</td>
						</tr>
						<?php  } } ?>						
					</tbody>
				</table>		
			
		</div>		
		<div class="list_bottom item_cell_box sort_list">
			<div class="item_cell_flex">
				<label class="">
					<input class="" type="checkbox" name="" onclick="var ck = this.checked;$(':checkbox').each(function(){this.checked = ck});"> 全选/取消
				</label>&nbsp;&nbsp;&nbsp;
				<input type="submit" name="delete" class="btn_44b549" value="删除所选" onclick="return confirm('删除后不可恢复，确定要删除吗？');">
				<input type="submit" name="suborder" class="btn_44b549" value="提交排序">
				<input name="token" type="hidden" value="<?php  echo $_W['token'];?>" />
			</div>
			<div class=""><?php  echo $pager;?></div>
		</div>
</form>			
	</div>
	
<?php  } ?>
	
</div>




	<script src="../addons/zofui_groupshop/template/web/js/fsjs.js"></script>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/footer', TEMPLATE_INCLUDEPATH)) : (include template('common/footer', TEMPLATE_INCLUDEPATH));?>