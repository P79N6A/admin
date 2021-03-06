<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/header', TEMPLATE_INCLUDEPATH)) : (include template('common/header', TEMPLATE_INCLUDEPATH));?>
	<link href="../addons/zofui_groupshop/template/web/css/common.css" rel="stylesheet">
	
	
<ul class="page_top">
	<a href="<?php  echo $this->createWebUrl('express',array('op'=>'add'))?>">
		<li class="top_btn <?php  if($op == 'add') { ?>activity_bottom<?php  } ?>">添加运费模板</li>
	</a>
	<a href="<?php  echo $this->createWebUrl('express',array('op'=>'list'))?>">
		<li class="top_btn <?php  if($op == 'list') { ?>activity_bottom<?php  } ?>">管理运费模板</li>
	</a>
	<?php  if($op == 'edit') { ?>
		<a href="<?php  echo $this->createWebUrl('express',array('op'=>'edit','id'=>$_GPC['id']))?>">
			<li class="top_btn <?php  if($op == 'edit') { ?>activity_bottom<?php  } ?>">编辑运费模板</li>
		</a>
	<?php  } ?>
</ul>

<div class="page_body">
	<?php  if($op == 'add' || $op == 'edit') { ?>
	<div class="addgood_body addexpress_body">
		<form method="post" action="">	
			
			<div class="sort_classone" style="display:block">
				<div class="input_item item_cell_box">
					<div class="input_title">运费名称</div>
					<div class="input_form item_cell_flex">
						<span class="input_box input_box_300">
							<input type="text" class="input_input" name="expressname" value="<?php  echo $info['name'];?>">
						</span>
						<p class="font_13px_999"> 填入文字，便于辨识</p>
					</div>
				</div>		
				
				<div class="input_item item_cell_box">
					<div class="input_title"></div>
					<div class="input_form item_cell_flex express_body">
						<div class="express_body_top">
							设置运费
						</div>
						<div class="express_main">
						
							<div class="express_main_item">
								<div class="item_cell_box">
									<li class="item_cell_flex express_btn_out">默认区域</li>
									<li class="express_btn_money">
										<span class="font_13px_999">下单量</span>
										<span class="input_box input_box_60">
											<input type="text" class="input_input" name="defaultnum" value="<?php  echo $info['defaultnum'];?>">
										</span>
										<span class="font_13px_999">件内，邮费</span>
										<span class="input_box input_box_60">
											<input type="text" class="input_input" name="defaultmoney" value="<?php  echo $info['defaultmoney'];?>">
										</span>
										<span class="font_13px_999">元，每增加</span>
										<span class="input_box input_box_60">
											<input type="text" class="input_input" name="defaultnumex" value="<?php  echo $info['defaultnumex'];?>">
										</span>
										<span class="font_13px_999">件，加邮费</span>
										<span class="input_box input_box_60">
											<input type="text" class="input_input" name="defaultmoneyex" value="<?php  echo $info['defaultmoneyex'];?>">
										</span>
										<span class="font_13px_999">元</span>										
									</li>
								</div>
							</div>
							<?php  if($op == 'edit') { ?>
								<?php  if(is_array($info['expressarray'])) { foreach($info['expressarray'] as $list) { ?>
								<div class="express_main_item">
									<div class="item_cell_box">
										<li class="item_cell_flex express_btn_out">
											<a href="javascript:;" class="a_href edit_province" data-toggle="modal" data-target="#myModal">编辑地区 </a>
											<input type="hidden" name="express[area][]" class="col-sm-2 area_value_input"  value="<?php  echo $list['area'];?>" />
											<span class="btn_44b549 delete_express">删除</span>
										</li>
										<li class="express_btn_money">
											<span class="font_13px_999"> 下单量 </span>
											<span class="input_box input_box_60">
												<input type="text" class="input_input" name="express[num][]" value="<?php  echo $list['num'];?>">
											</span>
											<span class="font_13px_999"> 件内，邮费 </span>
											<span class="input_box input_box_60">
												<input type="text" class="input_input" name="express[money][]" value="<?php  echo $list['money'];?>">
											</span>
											<span class="font_13px_999"> 元，每增加 </span>
											<span class="input_box input_box_60">
												<input type="text" class="input_input" name="express[numex][]" value="<?php  echo $list['numex'];?>">
											</span>
											<span class="font_13px_999"> 件，加邮费 </span>
											<span class="input_box input_box_60">
												<input type="text" class="input_input" name="express[moneyex][]" value="<?php  echo $list['moneyex'];?>">
											</span>
											<span class="font_13px_999"> 元 </span>								
										</li>
									</div>
									<div class="area_item">
										<span class="font_13px_999"><?php  echo $list['area'];?></span>
									</div>
								</div>
								<?php  } } ?>
							<?php  } ?>
						</div>
						
						<p class="font_13px_999">提示：当下单地址不在相应区域内时，会使用默认区域费用。</p>
					</div>
				</div>
								
				
			</div>
			<div class="input_item item_cell_box">
				<div class="input_title"></div>
				<div class="input_form item_cell_flex">
					<input class="btn_44b549" value="增加一个区域" type="button" id="addonearea">	
				</div>
			</div>
			
			<div class="confirm_add">
				<input class="btn_44b549" value="提交保存" type="submit" id="addexpress" name="addexpress">
				<input type="hidden" name="token" value="<?php  echo $_W['token'];?>" />
			</div>			
			
		</form>
	</div>
	
<?php  $areaArray = array('北京市','天津市','河北省','山西省','内蒙古自治区','辽宁省','吉林省','黑龙江省','上海市','江苏省','浙江省','安徽省','福建省','江西省','山东省','河南省','湖北省','湖南省','广东省','广西壮族自治区','海南省','重庆','四川省','贵州省','云南省','西藏自治区','陕西省','甘肃省','青海省','宁夏回族自治区','新疆维吾尔自治区','台湾省','香港特别行政区','澳门特别行政区','海外');?>
<div class="modal fade express_modal " id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">选择地区</h4>
      </div>
      <div class="modal-body">
			<?php  if(is_array($areaArray)) { foreach($areaArray as $item) { ?>
				<div class="col-sm-3 province_btn"><label class="province"><?php  echo $item;?> <input type="checkbox" value="<?php  echo $item;?>"></label></div>
			<?php  } } ?>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary area_confirm btn_44b549">确定</button>
      </div>
    </div>
  </div>
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
							<th class="col-sm-1">模板名称</th>							
							<th class="col-sm-3">默认区域运费</th>
							<th class="col-sm-1">最近修改时间</th>						
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
								<?php  echo $li['name'];?>
							</td>
							<td>
								下单量在
								<span class="font_ff5f27"><?php  echo $li['defaultnum'];?></span>件内，运费
								<span class="font_ff5f27"><?php  echo $li['defaultmoney'];?></span>元，每增加
								<span class="font_ff5f27"><?php  echo $li['defaultnumex'];?></span>件，加运费
								<span class="font_ff5f27"><?php  echo $li['defaultmoneyex'];?></span>元
							</td>							
							<td>
								<?php  echo date('Y-m-d H:i',$li['time'])?>
							</td>
							<td class="opclass">
								<div class="input-group select_btn deal_btn">
									<div class="btn-group">
									  <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
										  操作
										  <span class="caret"></span>
									  </button>
									  <ul class="dropdown-menu">
										<li><a href="<?php  echo $this->createWebUrl('express',array('op'=>'edit','id'=>$li['id']))?>">编辑</a></li>		
										<li role="separator" class="divider"></li>	
										<li><a href="<?php  echo $this->createWebUrl('express',array('op'=>'delete','id'=>$li['id']))?>" onclick="return confirm('删除后所有使用此模板的商品将会被包邮处理，确定删除吗？');">删除</a></li>
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
				<input type="submit" name="delete" class="btn_44b549" value="删除所选" onclick="return confirm('删除后所有使用此模板的商品将会被包邮处理，确定删除吗？');">
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