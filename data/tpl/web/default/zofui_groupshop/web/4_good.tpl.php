<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/header', TEMPLATE_INCLUDEPATH)) : (include template('common/header', TEMPLATE_INCLUDEPATH));?>
	<link rel="stylesheet" href="../addons/zofui_groupshop/template/web/js/bootstrap-select.min.css">	
	<script src="../addons/zofui_groupshop/template/web/js/bootstrap-select.js"></script>
	<script src="../addons/zofui_groupshop/template/web/js/defaults-zh_CN.js"></script>
	<link href="../addons/zofui_groupshop/template/web/css/common.css" rel="stylesheet">
	
<ul class="page_top">
	<a href="<?php  echo $this->createWebUrl('good',array('op'=>'add'))?>">
		<li class="top_btn <?php  if($op == 'add') { ?>activity_bottom<?php  } ?>">添加商品</li>
	</a>
	<a href="<?php  echo $this->createWebUrl('good',array('op'=>'list'))?>">
		<li class="top_btn <?php  if($op == 'list') { ?>activity_bottom<?php  } ?>">管理商品</li>
	</a>
	<?php  if($op == 'edit') { ?>
		<a href="<?php  echo $this->createWebUrl('good',array('op'=>'edit','id'=>$_GPC['id']))?>">
			<li class="top_btn <?php  if($op == 'edit') { ?>activity_bottom<?php  } ?>">编辑商品</li>
		</a>
	<?php  } ?>
</ul>

<div class="page_body">

<?php  if($op == 'add' || $op == 'edit') { ?>
<form action="" method="post" class="addgood_body" name="addgood_form">
	<div class="input_item item_cell_box">
		<div class="input_title">商品标题</div>
		<div class="input_form item_cell_flex">
			<span class="input_box input_box_600">
				<input type="text" class="input_input" name="title" value="<?php  echo $info['title'];?>">
			</span>
		</div>
	</div>
	
	<div class="input_item item_cell_box">
		<div class="input_title">商品简述</div>
		<div class="input_form item_cell_flex">
			<textarea class="input_textarea input_box_600" rows="3" name="descrip"><?php  echo $info['descrip'];?></textarea>
		</div>
	</div>
	
	<div class="input_item item_cell_box good_price">
		<div class="input_title">商品价格</div>
		<div class="input_form item_cell_flex">
			<span class="input_box">原价：</span><span class="input_box input_box_100">
				<input type="text" class="input_input" name="oldprice" value="<?php  echo $info['oldprice'];?>">
			</span>
			<span class="input_box">现价：</span><span class="input_box input_box_100">
				<input type="text" class="input_input" name="nowprice" value="<?php  echo $info['nowprice'];?>">
			</span>
			<span class="input_box">团购价：</span><span class="input_box input_box_100">
				<input type="text" class="input_input" name="groupprice" value="<?php  echo $info['groupprice'];?>">
			</span>	
			<p class="font_13px_999"> 当使用不同价格规格的时候，此处填入规格中价格和团购价中的最小数值即可。价格以规格中填的值为准。</p>	
		</div>
	</div>	
	
	<div class="input_item">
		<div class="item_cell_box good_price">
			<div class="input_title">库存/销量/序号</div>
			<div class="input_form item_cell_flex">
				<span class="input_box">库存：</span><span class="input_box input_box_100">
					<input type="text" class="input_input"  name="stock" value="<?php  echo $info['stock'];?>">
				</span>
				<span class="input_box">销量：</span><span class="input_box input_box_100">
					<input type="text" class="input_input"  name="sales" value="<?php  echo $info['sales'];?>">
				</span>
				<span class="input_box">排序号：</span><span class="input_box input_box_100">
					<input type="text" class="input_input"  name="order" value="<?php  echo $info['order'];?>">
				</span>	
			</div>
		</div>
		<div class="item_cell_box good_price">
			<div class="input_title"></div>
			<div class="input_form item_cell_flex">
				<p class="font_13px_999"> 都应填入正整数。销量在商品页面展示的销量，虚假数据。排序号越大的商品越排前面</p>	
			</div>
		</div>
	</div>
	
	<div class="input_item item_cell_box">
		<div class="input_title">满团人数</div>
		<div class="input_form item_cell_flex">
			<span class="input_box input_box_100">
				<input type="text" class="input_input" name="groupnum" value="<?php  echo $info['groupnum'];?>">
			</span>人，组团限
			<span class="input_box input_box_100">
				<input type="text" class="input_input" name="groupendtime" value="<?php  echo $info['groupendtime'];?>">
			</span>小时内，赠送个人
			<span class="input_box input_box_100">
				<input type="text" class="input_input" name="usercredit" value="<?php  echo $info['usercredit'];?>">
			</span>积分
			<p class="font_13px_999">提示：组团限时可填小数，填0.1是0.1小时，也就是6分钟，人数和积分必须填整数</p>	
		</div>
	</div>
	
	<div class="input_item item_cell_box">
		<div class="input_title">限制下单量</div>
		<div class="input_form item_cell_flex">
			单次下单,最多下单<span class="input_box input_box_100">
				<input type="text" class="input_input" name="maxallow" value="<?php  echo $info['maxallow'];?>">
			</span>件
			<p class="font_13px_999">提示：请设置一个正整数。系统是提交订单就会减相应库存，这个数值是防止买家恶意下大数量的不支付订单导致商品库存不足而 其他买家无法购买的问题。</p>
		</div>
	</div>		
	<div class="input_item item_cell_box good_sort">
		<div class="input_title">商品分类</div>
		<div class="input_form item_cell_flex checkbox good_sort_in">
			<?php  if(is_array($allsort)) { foreach($allsort as $list) { ?>
				<?php  if($list['class'] == 2) { ?>
				<label>
				<input type="checkbox"  name="sort[]" value="<?php  echo $list['id'];?>" <?php  if(in_array($list['id'],(array)$info['sort'])) { ?>checked="checked"<?php  } ?>> <?php  echo $list['name'];?>
				</label>
				<?php  } ?>
			<?php  } } ?>
		</div>
	</div>
	
	<div class="input_item item_cell_box good_rule">
		<div class="input_title">商品规格</div>
		<div class="input_form item_cell_flex checkbox good_rule_type">
			<label><input type="radio" name="ruletype" value="0" <?php  if($info['ruletype'] == 0) { ?>checked="checked"<?php  } ?>> 无规格</label>
			<label><input type="radio" name="ruletype" value="1" data-show="good_samerule" <?php  if($info['ruletype'] == 1) { ?>checked="checked"<?php  } ?>> 相同价格规格</label>
			<label><input type="radio" name="ruletype" value="2" data-show="good_diffrule" <?php  if($info['ruletype'] == 2) { ?>checked="checked"<?php  } ?>> 不同价格规格</label>
		</div>
	</div>
	
	<div class="input_item ">
		<div class="good_samerule show_rule"  <?php  if($info['ruletype'] == 1) { ?>style="display:block"<?php  } ?> >
			<div class="rule_append_box">
				<?php  if($op == 'add') { ?>
				<div class="item_cell_box good_rule_body">
					<div class="input_title"></div>
					<div class="input_form item_cell_flex">
						<div>
							规格名称: 
							<span class="rule_name"></span><input type="hidden" name="samerulename[]">
						</div>
						<div class="item_cell_box">
							<p>规格属性:</p>&nbsp;
							<p class="rule_pro item_cell_flex"></p>
							<input type="hidden" name="samerulepro[]">
						</div>
						<div class="add_btn_box">
							<span class="input_box input_box_200">
								<input type="text" class="input_input" >
							</span>
							<span class="font_13px_999 add_btn edit_rule_item" data-type="1">编辑名称</span>&nbsp;&nbsp;
							<span class="font_13px_999 add_btn edit_rule_item" data-type="2">添加属性</span>&nbsp;&nbsp;
							<span class="font_13px_999 add_btn reset_rule_pro" >重置属性</span>
						</div>
					</div>
					<span class="fa fa-times deletethis_rule"></span>
				</div>
				<?php  } else if($op == 'edit' && $info['ruletype'] == 1) { ?>
					<?php  if(is_array($info['rulearray'])) { foreach($info['rulearray'] as $item) { ?>
						<div class="item_cell_box good_rule_body">
							<div class="input_title"></div>
							<div class="input_form item_cell_flex">
								<div>
									规格名称: 
									<span class="rule_name"><?php  echo $item['name'];?></span><input type="hidden" name="samerulename[]" value="<?php  echo $item['name'];?>">
								</div>
								<div class="item_cell_box">
									<p>规格属性:</p>&nbsp;
									<p class="rule_pro item_cell_flex"><?php  echo $item['pro'];?></p>
									<input type="hidden" name="samerulepro[]" value="<?php  echo $item['pro'];?>">
								</div>
								<div class="add_btn_box">
									<span class="input_box input_box_200">
										<input type="text" class="input_input" >
									</span>
									<span class="font_13px_999 add_btn edit_rule_item" data-type="1">编辑名称</span>&nbsp;&nbsp;
									<span class="font_13px_999 add_btn edit_rule_item" data-type="2">添加属性</span>&nbsp;&nbsp;
									<span class="font_13px_999 add_btn reset_rule_pro" >重置属性</span>
								</div>
							</div>
							<span class="fa fa-times deletethis_rule"></span>
						</div>
					<?php  } } ?>
				<?php  } ?>
			</div>
			
			<div class="item_cell_box margin_top_10px">
				<div class="input_title"></div>
				<div class="input_form item_cell_flex">
					<span class="btn_44b549 add_a_rule" data-type="1">增加一条规格</span>	
					<span class="font_13px_999"><a class="a_href" href="../addons/zofui_groupshop/public/images/example.jpg" target="_blank">参考设置实例</a></span>
				</div>
			</div>			
		</div>
		
		<div class="good_diffrule show_rule" <?php  if($info['ruletype'] == 2) { ?>style="display:block"<?php  } ?>>
			<div class="rule_append_box">
			<?php  if($op == 'add') { ?>
				<div class="item_cell_box good_rule_body">
					<div class="input_title"></div>
					<div class="input_form item_cell_flex">
						<div>
							名称:&nbsp;
							<span class="input_box input_box_150">
								<input type="text" class="input_input" name="diffrulename[]">
							</span>	&nbsp;&nbsp;
							现价:&nbsp;
							<span class="input_box input_box_100">
								<input type="text" class="input_input" name="diffnowprice[]">
							</span>元&nbsp;
							团购价:&nbsp;
							<span class="input_box input_box_100">
								<input type="text" class="input_input" name="diffgroupprice[]">
							</span>元							
						</div>
					</div>
					<span class="fa fa-times deletethis_rule"></span>
				</div>
			<?php  } else if($op == 'edit' && $info['ruletype'] == 2) { ?>
				<?php  if(is_array($info['rulearray'])) { foreach($info['rulearray'] as $item) { ?>
					<div class="item_cell_box good_rule_body">
						<div class="input_title"></div>
						<div class="input_form item_cell_flex">
							<div>
								名称:&nbsp;
								<span class="input_box input_box_150">
									<input type="text" class="input_input" name="diffrulename[]"  value="<?php  echo $item['name'];?>">
								</span>	&nbsp;&nbsp;
								现价:&nbsp;
								<span class="input_box input_box_100">
									<input type="text" class="input_input" name="diffnowprice[]"  value="<?php  echo $item['nowprice'];?>">
								</span>元&nbsp;
								团购价:&nbsp;
								<span class="input_box input_box_100">
									<input type="text" class="input_input" name="diffgroupprice[]"  value="<?php  echo $item['groupprice'];?>">
								</span>元							
							</div>
						</div>
						<span class="fa fa-times deletethis_rule"></span>
					</div>					
				<?php  } } ?>
			<?php  } ?>
			</div>

			<div class="item_cell_box margin_top_10px">
				<div class="input_title"></div>
				<div class="input_form item_cell_flex">
					<span class="btn_44b549 add_a_rule" data-type="2">增加一条规格</span>	
					<span class="font_13px_999"><a class="a_href" href="../addons/zofui_groupshop/public/images/example.jpg" target="_blank">参考设置实例</a></span>
				</div>
			</div>			
		</div>		
		
	</div>
	
	<div class="input_item item_cell_box good_inco">
		<div class="input_title">商品标签</div>
		<div class="input_form item_cell_flex checkbox good_inco_list">
			<div class="inco_append_box">
				<label><input type="checkbox" name="inco[]" <?php  if(in_array('包邮',(array)$info['inco'])) { ?>checked="checked"<?php  } ?> value="包邮" > 包邮</label>
				<label><input type="checkbox" name="inco[]" <?php  if(in_array('24小时发货',(array)$info['inco'])) { ?>checked="checked"<?php  } ?> value="24小时发货" > 24小时发货</label>
				<label><input type="checkbox" name="inco[]" <?php  if(in_array('正品保证',(array)$info['inco'])) { ?>checked="checked"<?php  } ?> value="正品保证" > 正品保证</label>
				<label><input type="checkbox" name="inco[]" <?php  if(in_array('限时抢购',(array)$info['inco'])) { ?>checked="checked"<?php  } ?> value="限时抢购" > 限时抢购</label>
				<label><input type="checkbox" name="inco[]" <?php  if(in_array('热卖推荐',(array)$info['inco'])) { ?>checked="checked"<?php  } ?> value="热卖推荐" > 热卖推荐</label>
				<label><input type="checkbox" name="inco[]" <?php  if(in_array('清仓优惠',(array)$info['inco'])) { ?>checked="checked"<?php  } ?> value="清仓优惠" > 清仓优惠</label>
				<?php  if(is_array($info['inco'])) { foreach($info['inco'] as $item) { ?>
					<?php  if(!in_array($item,array('包邮','24小时发货','正品保证','限时抢购','热卖推荐','清仓优惠'))) { ?>
						<label>
						<input type="checkbox" name="inco[]"checked="checked" value="<?php  echo $item;?>" > <?php  echo $item;?>
						</label>
					<?php  } ?>
				<?php  } } ?>
			</div>
			<p class="add_btn_box">
				<span class="input_box input_box_200">
					<input type="text" class="input_input">
				</span>
				<span class="font_13px_999 add_btn add_a_inco">添加一个标签</span>
			</p>	
		</div>
	</div>
	
	<div class="input_item item_cell_box good_rule">
		<div class="input_title">商品运费</div>
		<div class="input_form item_cell_flex checkbox good_rule_type">
			<label>
				<input type="radio" name="expresstype" value="0" <?php  if($info['expresstype'] == 0) { ?>checked="checked"<?php  } ?>> 包邮
			</label>
			<label>
			<input type="radio" name="expresstype" value="1" data-show="single_express" <?php  if($info['expresstype'] == 1) { ?>checked="checked"<?php  } ?>> 单独运费
			</label>
			<label>
			<input type="radio" name="expresstype" value="2" data-show="model_express" <?php  if($info['expresstype'] == 2) { ?>checked="checked"<?php  } ?>> 使用运费模板
			</label>			
		</div>
	</div>	
	
	<div class="input_item good_rule good_express_value single_express"  <?php  if($info['expresstype'] == 1) { ?>style="display:block"<?php  } ?>>
		<div class="item_cell_box">	
			<div class="input_title"></div>
			<div class="input_form item_cell_flex">
				<span class="input_box input_box_200">
					<input type="text" class="input_input" name="expressmoney" value="<?php  echo $info['expressmoney'];?>">
				</span>
				<p class="font_13px_999"> 输入每件商品的运费</p>
			</div>
		</div>
	</div>	
	
	<div class="input_item  good_rule good_express_value model_express" <?php  if($info['expresstype'] == 2) { ?>style="display:block"<?php  } ?>>
		<div class="item_cell_box">
			<div class="input_title"></div>
			<div class="input_form item_cell_flex" >
				<select class="selectpicker show-tick input_select input_box_200" name="expressid" data-size="6">
					<?php  if(is_array($allexpress)) { foreach($allexpress as $list) { ?>
						<option value="<?php  echo $list['id'];?>" <?php  if($info['expressid'] == $list['id']) { ?>selected="selected"<?php  } ?>><?php  echo $list['name'];?></option>
					<?php  } } ?>
				</select>
			</div>	
		</div>
	</div>		
	
	<div class="input_item item_cell_box good_inco good_activity">
		<div class="input_title">营销活动</div>
		<div class="input_form item_cell_flex checkbox activity_list">
			<label class="activity_onoff" data-show="good_activity_credit">
				<input type="checkbox"  name="iscredit" value="1" <?php  if($info['iscredit'] == 1) { ?>checked="checked"<?php  } ?>> 积分抵扣
			</label>
			<label class="activity_onoff" data-show="good_activity_express">
				<input type="checkbox" name="isfreeexpress" value="1" <?php  if($info['isfreeexpress'] == 1) { ?>checked="checked"<?php  } ?>> 满额包邮
			</label>
			<label class="activity_onoff" data-show="good_activity_fullminus">
				<input type="checkbox" name="isfirstcut" value="1" <?php  if($info['isfirstcut'] == 1) { ?>checked="checked"<?php  } ?>> 首单优惠
			</label>
			<label class="activity_onoff" data-show="good_activity_card">
				<input type="checkbox" name="iscard" value="1" <?php  if($info['iscard'] == 1) { ?>checked="checked"<?php  } ?>> 是否允许使用优惠券
			</label>
		</div>
	</div>	
	
	<div class="input_item item_cell_box good_inco good_activity_body good_activity_credit" <?php  if($info['iscredit'] == 1) { ?>style="display:-webkit-box"<?php  } ?>>
		<div class="input_title"></div>
		<div class="input_form item_cell_flex">
			<p class="activity_title">积分抵扣</p>
			每1点个人积分，抵扣<span class="font_ff5f27 creditratio"><?php  echo $this->module['config']['creditratio']?></span>元，最多可使用
			<span class="input_box input_box_100">
				<input type="text" class="input_input" name="maxcredit" value="<?php  echo $info['maxcredit'];?>">
			</span> 积分
		</div>
	</div>
	
	<div class="input_item item_cell_box good_inco good_activity_body good_activity_express" <?php  if($info['isfreeexpress'] == 1) { ?>style="display:-webkit-box"<?php  } ?>>
		<div class="input_title"></div>
		<div class="input_form item_cell_flex">
			<p class="activity_title">满额包邮</p>
			订单金额满
			<span class="input_box input_box_100">
				<input type="text" class="input_input" name="fullmoney" value="<?php  echo $info['fullmoney'];?>">
			</span>元才包邮			
		</div>
	</div>	
	
	<div class="input_item item_cell_box good_inco good_activity_body good_activity_fullminus" <?php  if($info['isfirstcut'] == 1) { ?>style="display:-webkit-box"<?php  } ?>>
		<div class="input_title"></div>
		<div class="input_form item_cell_flex">
			<p class="activity_title">首单优惠</p>
			会员第一次在平台购物，且订单中有此商品，优惠
			<span class="input_box input_box_100">
				<input type="text" class="input_input" name="firstcutmoney"  value="<?php  echo $info['firstcutmoney'];?>">
			</span>元		
		</div>
	</div>	
	<div class="input_item item_cell_box good_inco good_activity_body good_activity_card" <?php  if($info['iscard'] == 1) { ?>style="display:-webkit-box"<?php  } ?>>
		<div class="input_title"></div>
		<div class="input_form item_cell_flex">
			<p class="activity_title">已允许使用优惠券</p>		
		</div>
	</div>	
	
	<div class="input_item item_cell_box good_rule good_limit">
		<div class="input_title">商品限购</div>
		<div class="input_form item_cell_flex checkbox good_rule_type">
			<label><input type="radio" name="limitbuy" value="0" <?php  if($info['limitbuy'] == '0') { ?>checked="checked"<?php  } ?>> 不限购</label>
			<label><input type="radio" name="limitbuy" value="1" data-show="good_limit_body" <?php  if($info['limitbuy'] == '1') { ?>checked="checked"<?php  } ?>> 限量购买</label>
		</div>
	</div>		
	
	<div class="input_item  good_rule good_limit_body" <?php  if($info['limitbuy'] == '1') { ?>style="display:block"<?php  } ?>>
		<div class="item_cell_box">
			<div class="input_title"></div>
			<div class="input_form item_cell_flex good_rule_type">
				每
				<span class="input_box input_box_100">
					<input type="text" class="input_input" name="limittime" value="<?php  echo $info['limittime'];?>">
				</span>天，每个微信号限购					
				<span class="input_box input_box_100">
					<input type="text" class="input_input" name="limitnum" value="<?php  echo $info['limitnum'];?>">
				</span>件
			</div>
		</div>
	</div>		
	
	<div class="input_item item_cell_box good_rule good_pic">
		<div class="input_title">商品图片</div>
		<div class="input_form item_cell_flex checkbox good_rule_type">
			<?php  echo tpl_form_field_multi_image('pic', $info['pic'],'');?>
			<p class="font_13px_999">提示：第一张图片将被作为封面图，请保持每张图片的尺寸大小一致。</p>
		</div>
	</div>		
	
	<div class="input_item item_cell_box good_rule">
		<div class="input_title">是否上架</div>
		<div class="input_form item_cell_flex checkbox good_rule_type">
			<label><input type="radio" name="status" value="0" <?php  if($info['status'] == 0) { ?>checked="checked"<?php  } ?>> 立即上架</label>
			<label><input type="radio" name="status" value="1" <?php  if($info['status'] == 1) { ?>checked="checked"<?php  } ?>> 暂不上架</label>			
		</div>
	</div>	
	<div class="input_item item_cell_box good_rule">
		<div class="input_title">是否显示最近团</div>
		<div class="input_form item_cell_flex checkbox good_rule_type">
			<label><input type="radio" name="isshowgroup" value="1" <?php  if($info['isshowgroup'] == 1) { ?>checked="checked"<?php  } ?>> 显示</label>
			<label><input type="radio" name="isshowgroup" value="0" <?php  if($info['isshowgroup'] == 0) { ?>checked="checked"<?php  } ?>> 不显示</label>	
			<p class="font_13px_999">提示：最近团是在商品底部显示的最近开启的团，便于会员快速组团，最多显示2个团。</p>
		</div>
	</div>
	
	<div class="input_item item_cell_box good_rule good_params">
		<div class="input_title">商品参数</div>
		<div class="input_form item_cell_flex good_rule_type good_params_body">
			<div class="good_params_top">
				<div class="params_name_div">
					参数名称
				</div>
				<div class="params_pro_div">
					参数属性
				</div>				
			</div>
			<div class="good_params_list">
				<?php  if(is_array($info['params'])) { foreach($info['params'] as $item) { ?>
					<div class="good_params_item">
						<div class="params_name_div">
							<span class="input_box input_box_100">
								<input type="text" class="input_input" name="paramsname[]" value="<?php  echo $item['name'];?>">
							</span>
						</div>
						<div class="params_pro_div">
							<span class="input_box input_box_300">
								<input type="text" class="input_input" name="paramspro[]" value="<?php  echo $item['pro'];?>">
							</span>	
							<a href="javascript:;" class="a_href deletethis_params">删除</a>
						</div>
					</div>
				<?php  } } ?>			
			</div>			
			<div class="good_params_bot">
				<div class="good_params_item">
					<div class="params_name_div">
						<span class="input_box input_box_100">
							<input type="text" class="input_input" name="addparamsname">
						</span>
					</div>
					<div class="params_pro_div">
						<span class="input_box input_box_300">
							<input type="text" class="input_input" name="addparamspro">
						</span>	
						<a href="javascript:;" class="a_href add_a_params">添加</a>
					</div>
				</div>
			</div>				
			
		</div>
	</div>	
	
	<div class="input_item item_cell_box good_rule good_detail">
		<div class="input_title">商品详情</div>
		<div class="input_form item_cell_flex checkbox good_rule_type">
			<?php  echo tpl_ueditor('detail', htmlspecialchars_decode($info['detail']));?>
		</div>
	</div>
<?php  if(empty($_GPC['look'])) { ?>	
	<div class="confirm_add">
		<input name="confirm_addgood" value="提交保存" class="btn_44b549" type="submit">
		<input name="checkaddgood" value="1" class="btn_44b549" type="hidden">
	</div>	
<?php  } ?>
</form>	

<?php  } else if($op == 'list') { ?>

	<div class="list_body">
		<div class="list_top">
			  <form action="./index.php" method="get" class="form-horizontal search_box" role="form" id="form1" style="margin-right:10px;">
					<input type="hidden" name="c" value="site" />
					<input type="hidden" name="a" value="entry" />
					<input type="hidden" name="m" value="zofui_groupshop" />
					<input type="hidden" name="do" value="good" />
					<input type="hidden" name="op" value="list" />
				<div class="col-xs-3" style="padding:0;margin-right: 10px;">
					<div class="input-group">
					  <input type="text" class="form-control" name="for" placeholder="商品ID、商品标题">
					  <span class="input-group-btn">
						<button class="btn btn-default" type="submit" ><span class="glyphicon glyphicon-search" aria-hidden="true"></span></button>
					  </span>
					</div>
				</div>
				</form>
			
			<div class="input-group select_btn">
				<div class="btn-group">
				  <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
					  <?php  if($_GPC['stock']=='no') { ?>已无库存
					  <?php  } else if($_GPC['stock']=='yes') { ?>有库存
					  <?php  } else { ?>有无库存
					  <?php  } ?>
					  <span class="caret"></span>
				  </button>
				  <ul class="dropdown-menu">
					<li><a href="<?php  echo WebCommon::structGoodUrl($_GPC,'stock','no')?>">已无库存</a></li>		
					<li role="separator" class="divider"></li>	
					<li><a href="<?php  echo WebCommon::structGoodUrl($_GPC,'stock','yes')?>">有库存</a></li>		
					<li role="separator" class="divider"></li>				
					<li><a href="<?php  echo WebCommon::structGoodUrl($_GPC,'stock','')?>">有无库存</a></li>
				  </ul>
				</div>	
			</div>	
			
			<div class="input-group select_btn">
				<div class="btn-group">
				  <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
					  <?php  if($_GPC['activity']=='1') { ?> 参与积分抵扣商品
					  <?php  } else if($_GPC['activity']=='2') { ?>参与满额包邮商品
					  <?php  } else if($_GPC['activity']=='3') { ?>参与首单优惠商品
					  <?php  } else if($_GPC['activity']=='4') { ?>允许使用优惠券商品
					  <?php  } else { ?>是否参与优惠活动
					  <?php  } ?>
					  <span class="caret"></span>
				  </button>
				  <ul class="dropdown-menu">
					<li><a href="<?php  echo WebCommon::structGoodUrl($_GPC,'activity','1')?>">参与积分抵扣商品</a></li>		
					<li role="separator" class="divider"></li>	
					<li><a href="<?php  echo WebCommon::structGoodUrl($_GPC,'activity','2')?>">参与满额包邮商品</a></li>		
					<li role="separator" class="divider"></li>	
					<li><a href="<?php  echo WebCommon::structGoodUrl($_GPC,'activity','3')?>">参与首单优惠商品</a></li>		
					<li role="separator" class="divider"></li>	
					<li><a href="<?php  echo WebCommon::structGoodUrl($_GPC,'activity','4')?>">允许使用优惠券商品</a></li>		
					<li role="separator" class="divider"></li>
					<li><a href="<?php  echo WebCommon::structGoodUrl($_GPC,'activity','')?>">是否参与优惠活动</a></li>
				  </ul>
				</div>	
			</div>	
			<div class="input-group select_btn">
				<div class="btn-group">
				  <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
					  <?php  if($_GPC['limit']=='1') { ?>限购商品
					  <?php  } else if($_GPC['limit']=='2') { ?>未限购商品
					  <?php  } else { ?>是否限购
					  <?php  } ?>
					  <span class="caret"></span>
				  </button>
				  <ul class="dropdown-menu">
					<li><a href="<?php  echo WebCommon::structGoodUrl($_GPC,'limit','1')?>">限购商品</a></li>		
					<li role="separator" class="divider"></li>	
					<li><a href="<?php  echo WebCommon::structGoodUrl($_GPC,'limit','2')?>">未限购商品</a></li>		
					<li role="separator" class="divider"></li>				
					<li><a href="<?php  echo WebCommon::structGoodUrl($_GPC,'limit','')?>">是否限购</a></li>
				  </ul>
				</div>	
			</div>				
			<div class="input-group select_btn">
				<div class="btn-group">
				  <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
					  <?php  if($_GPC['status']=='1') { ?>上架商品
					  <?php  } else if($_GPC['status']=='2') { ?>下架商品
					  <?php  } else { ?>商品状态
					  <?php  } ?>
					  <span class="caret"></span>
				  </button>
				  <ul class="dropdown-menu">
					<li><a href="<?php  echo WebCommon::structGoodUrl($_GPC,'status','0')?>">上架商品</a></li>		
					<li role="separator" class="divider"></li>	
					<li><a href="<?php  echo WebCommon::structGoodUrl($_GPC,'status','1')?>">下架商品</a></li>		
					<li role="separator" class="divider"></li>
					<li><a href="<?php  echo WebCommon::structGoodUrl($_GPC,'status','')?>">商品状态</a></li>
				  </ul>
				</div>	
			</div>				
			<div class="input-group select_btn">
				<div class="btn-group">
				  <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
					  <?php  if($_GPC['order']== 'nowprice') { ?>现价排序
					  <?php  } else if($_GPC['order']== 'groupprice') { ?>团购价排序
					  <?php  } else if($_GPC['order']== 'stock') { ?>库存排序					  
					  <?php  } else if($_GPC['order']=='realsales') { ?>真实销量排序
					  <?php  } else if($_GPC['order']=='usercredit') { ?>赠送积分量排序
					  <?php  } else if($_GPC['order']=='id') { ?>最新排序					  
					  <?php  } else { ?>序号排序	
					  <?php  } ?>
					  <span class="caret"></span>
				  </button>
				  <ul class="dropdown-menu" style="overflow-y:scroll;height:200px;">
					<li><a href="<?php  echo WebCommon::structGoodUrl($_GPC,'order','nowprice')?>">现价排序</a></li>		
					<li role="separator" class="divider"></li>	
					<li><a href="<?php  echo WebCommon::structGoodUrl($_GPC,'order','groupprice')?>">团购价排序</a></li>		
					<li role="separator" class="divider"></li>
					<li><a href="<?php  echo WebCommon::structGoodUrl($_GPC,'order','stock')?>">库存排序</a></li>		
					<li role="separator" class="divider"></li>
					<li><a href="<?php  echo WebCommon::structGoodUrl($_GPC,'order','realsales')?>">真实销量排序</a></li>		
					<li role="separator" class="divider"></li>
					<li><a href="<?php  echo WebCommon::structGoodUrl($_GPC,'order','usercredit')?>">赠送积分量排序</a></li>		
					<li role="separator" class="divider"></li>					
					<li><a href="<?php  echo WebCommon::structGoodUrl($_GPC,'order','id')?>">最新排序</a></li>		
					<li role="separator" class="divider"></li>									
					<li><a href="<?php  echo WebCommon::structGoodUrl($_GPC,'order','')?>">序号排序</a></li>
				  </ul>
				</div>
			</div>			
			
			<div class="input-group select_btn">
				<div class="btn-group">
				  <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
					  <?php  if($_GPC['by']== 1) { ?>正序
					  <?php  } else { ?>倒序
					  <?php  } ?>
					  <span class="caret"></span>
				  </button>
				  <ul class="dropdown-menu">
					<li><a href="<?php  echo WebCommon::structGoodUrl($_GPC,'by',1)?>">正序</a></li>		
					<li role="separator" class="divider"></li>	
					<li><a href="<?php  echo WebCommon::structOrderUrl($_GPC,'by','')?>">倒序</a></li>
				  </ul>
				</div>
			</div>			
			
		</div>
		<div class="list_table good_list">
<form action="" method="post">
				<table class="table table-hover">
					<thead>
						<tr>
							<th class="col-sm-1">
								<label class="my_checkbox">
								<input class="" type="checkbox" name="" onclick="var ck = this.checked;$('.goodid_check input').each(function(){this.checked = ck});"> 全选/取消
								</label>
							</th>
							<th class="col-sm-2">标题/图片</th>
							<th class="col-sm-1">价格</th>
							<th class="col-sm-1">库存等</th>
							<th class="col-sm-1">排序/分类</th>
							<th class="col-sm-1">参与活动</th>
							<th class="col-sm-1">其他</th>
							<th class="col-sm-1">操作</th>
						</tr>
					</thead>
					<tbody>
						<?php  if(is_array($list)) { foreach($list as $li) { ?>
						<tr>
							<td class="">
								<label class="my_checkbox goodid_check">
									<input type="checkbox" name="checkid[]" value="<?php  echo $li['id'];?>" class=""> <?php  echo $li['id'];?>
								</label>
							</td>
							<td>
								<li><?php  echo $li['title'];?></li>
								<li class="good_list_img">
									<?php  if(is_array($li['pic'])) { foreach($li['pic'] as $pic) { ?>
									<img src="<?php  echo tomedia($pic)?>">
									<?php  } } ?>
								</li>
							</td>
							<td class="font_13px_999">
								<li>原来价：<span class="font_ff5f27"><?php  echo $li['oldprice'];?></span></li>
								<li>现在价：<span class="font_ff5f27"><?php  echo $li['nowprice'];?></span></li>								
								<li>团购价：<span class="font_ff5f27"><?php  echo $li['groupprice'];?></span></li>								
							</td>
							<td class="font_13px_999">
								<li>库存量：<span class="font_ff5f27"><?php  echo $li['stock'];?></span></li>
								<li>真销量：<span class="font_ff5f27"><?php  echo $li['realsales'];?></span></li>								
								<li>满团数：<span class="font_ff5f27"><?php  echo $li['groupnum'];?></span></li>
							</td>
							<td class="opclass">
								<span class="input_box input_box_100" style="width: 94px;">
									<input type="text" class="input_input" name="order[<?php  echo $li['id'];?>]" value="<?php  echo $li['order'];?>">
								</span>
								
								<div class="input-group select_btn single_sort">
									<div class="btn-group">
									  <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
											所属分类
											<span class="caret"></span>
									  </button>
									  <ul class="dropdown-menu change_sort_menu">
										<div class="sort_menu_box">
											<?php  if(is_array($allsort)) { foreach($allsort as $sort) { ?>
												<?php  if($sort['class'] == 2) { ?>
													<li class="removefromcart ">
														<label class="my_checkbox" >
															<input class="" type="checkbox" <?php  if(in_array($sort['id'],(array)$li['sort'])) { ?>checked="checked"<?php  } ?> value="<?php  echo $sort['id'];?>" name="singlesortvalue[]"><?php  echo $sort['name'];?>
														</label>
													</li>
													<li role="separator" class="divider"></li>
												<?php  } ?>
											<?php  } } ?>
										</div>
										<li class="change_sort_btns">
											<input type="button" name="changesinglesort" data-id="<?php  echo $li['id'];?>" class="btn_44b549" value="确定">&nbsp;&nbsp;
											<input class="btn btn-default" type="button" value="取消">
										</li>
									  </ul>
									</div>	
								</div>
								
							</td>
							<td class="font_13px_999">
								<?php  if($li['iscredit'] == 1) { ?><li>积分抵扣</li><?php  } ?>
								<?php  if($li['isfreeexpress'] == 1) { ?><li>满额包邮</li><?php  } ?>
								<?php  if($li['isfirstcut'] == 1) { ?><li>首单优惠</li><?php  } ?>
								<?php  if($li['iscard'] == 1) { ?><li>使用优惠券</li><?php  } ?>
							</td>
							<td style="position:relative">
								<?php  if($li['limitbuy'] == 1) { ?><li><?php  echo $li['limittime'];?>天内限购<?php  echo $li['limitnum'];?>件</li><?php  } ?>
								<?php  if($li['status'] == 0) { ?>
									<?php  if($li['stock'] <= 0) { ?>
										<li><span class="font_ff5f27">已售罄</span></li>
									<?php  } else { ?>
										<li><span>上架中</span></li>
									<?php  } ?>
								<?php  } else if($li['status'] == 1) { ?>
									<li><span class="font_ff5f27">已下架</span></li>
								<?php  } ?>
								<a data-href="<?php echo $_W['siteroot'].'app/index.php?i='.$_W['uniacid'].'&c=entry&do=good&id='.$li['id'].'&m=zofui_groupshop'?>" href="javascript:;" class="a_href copy_url" >复制链接</a>
							</td>
							<td class="opclass">
								<a class="a_href" target="_blank" href="<?php  echo $this->createWebUrl('good',array('op'=>'edit','id'=>$li['id']))?>">编辑</a>
								<a class="a_href" target="_blank" href="<?php  echo $this->createWebUrl('comment',array('op'=>'add','gid'=>$li['id']))?>">加评价</a>
								<a class="a_href" href="<?php  echo $this->createWebUrl('good',array('op'=>'delete','id'=>$li['id']))?>" onclick="return confirm('为了保证此商品的团和订单信息的完整，删除商品是将商品移入垃圾站内，确定要删除吗？');">删除</a>
							</td>
						</tr>
						<?php  } } ?>						
					</tbody>
				</table>		
		</div>		
		<div class="list_bottom item_cell_box good_list good_list_bot">
			<div class="item_cell_flex">
				<label class="">
					<input class="" type="checkbox" name="" onclick="var ck = this.checked;$('.goodid_check input').each(function(){this.checked = ck});"> 全选/取消
				</label>&nbsp;&nbsp;&nbsp;
				<input type="submit" name="delete" class="btn_44b549" value="删除所选" onclick="return confirm('为了保证此商品的团和订单信息的完整，删除商品是将商品移入垃圾站内，确定要删除吗？');">
				<input type="submit" name="upgood" class="btn_44b549" value="上架所选" onclick="return confirm('确认对所选商品批量上架吗？');">
				<input type="submit" name="downgood" class="btn_44b549" value="下架所选" onclick="return confirm('确认对所选商品批量下架吗？');">
				<input type="submit" name="suborder" class="btn_44b549" value="提交排序">
				<a href="javascript:;" class="btn_44b549 testdata_btn" data-op="good">增加5条测试数据</a>
				<div class="input-group select_btn">
					<div class="btn-group">
					  <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
							设置分类
							<span class="caret"></span>
					  </button>
					  <ul class="dropdown-menu change_sort_menu">
						<div class="sort_menu_box">
							<?php  if(is_array($allsort)) { foreach($allsort as $sort) { ?>
								<?php  if($sort['class'] == 2) { ?>
									<li class="removefromcart ">
										<label class="my_checkbox" >
											<input class="" type="checkbox" value="<?php  echo $sort['id'];?>" name="sortvalue[]"><?php  echo $sort['name'];?>
										</label>						
									</li>		
									<li role="separator" class="divider"></li>	
								<?php  } ?>
							<?php  } } ?>
						</div>
						<li class="change_sort_btns">
							<input type="submit" name="changesort" class="btn_44b549" value="确定">&nbsp;&nbsp;
							<input class="btn btn-default" type="button" value="取消">
						</li>
					  </ul>
					</div>	
				</div>
				
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