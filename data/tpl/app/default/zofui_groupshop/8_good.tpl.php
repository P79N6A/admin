<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('common/myheader', TEMPLATE_INCLUDEPATH)) : (include template('common/myheader', TEMPLATE_INCLUDEPATH));?>

    <div id="page_good" class="page page-current  page_good">
		<?php  if(!empty($good['id'])) { ?>
		<div class="content" >		
			<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('common/slide', TEMPLATE_INCLUDEPATH)) : (include template('common/slide', TEMPLATE_INCLUDEPATH));?>
			<div class="good_page_price good_page_item">
				<li class="price"><span class="nowprice">￥<?php  echo $good['nowprice'];?> </span> <span class="font_13px_999 oldprice">￥<?php  echo $good['oldprice'];?></span></li>
				<li class="salenum font_13px_999">销量:<?php  echo $good['sales'];?></li>	
			</div>
			<div class="good_page_title good_page_item">
				<li class="good_title_target"><?php  echo $good['title'];?></li>
				<li class="desc font_13px_999"><?php  echo $good['descrip'];?></li>
			</div>
			<?php  if(!empty($good['inco'])) { ?>
			<div class="good_page_icon good_page_item item_cell_box">
				<ul class="inco_list item_cell_flex">
					<?php  if(is_array($good['inco'])) { foreach($good['inco'] as $item) { ?>
					<li class="fs_icon"><span class="ti-check"></span> <?php  echo $item;?></li>
					<?php  } } ?>
				</ul>
				<span class="ti-angle-right"></span>
			</div>
			<?php  } ?>
			<?php  if(!empty($good['iscredit']) || !empty($good['isfreeexpress']) || !empty($good['isfirstcut']) || !empty($good['iscard'])) { ?>
			<div class="good_page_activity good_page_item item_cell_box">
				<ul class="activity_list inco_list item_cell_flex">
					<?php  if($good['iscredit'] == 1) { ?><li class="fs_icon"><span>抵</span> 积分抵扣</li><?php  } ?>
					<?php  if($good['isfreeexpress'] == 1) { ?><li class="fs_icon"><span>减</span> 满<?php  echo $good['fullmoney'];?>包邮</li><?php  } ?>
					<?php  if($good['isfirstcut'] == 1) { ?><li class="fs_icon"><span>首</span> 首单优惠</li><?php  } ?>		
					<?php  if($good['iscard'] == 1) { ?><li class="fs_icon"><span>券</span> 可用优惠券</li><?php  } ?>		
				</ul>
				<span class="ti-angle-right"></span>
			</div>
			<?php  } ?>
			<div class="good_page_btn good_page_item margin_top_5px">
				<ul class="detail_btn item_cell_box good_detail" data-type="detail_body" data-content="<?php  echo $good['detail'];?>">
					<li data-detail="<?php  echo $good['detail'];?>" class="item_cell_flex">商品详情</li>
					<li class="ti-angle-right"></li>
				</ul>
				<ul class="detail_btn item_cell_box good_params" data-type="params_body">
					<li data-detail="<?php  echo $good['detail'];?>" class="item_cell_flex">商品参数</li>
					<li class="ti-angle-right"></li>
				</ul>
				<ul class="detail_btn item_cell_box good_comment" style="border:0" data-type="comment_body">
					<li data-detail="<?php  echo $good['detail'];?>" class="item_cell_flex">买家评论<i class="comment_number"><?php  echo $commentnumber['all'];?></i></li>
					<li class="ti-angle-right"></li>
				</ul>
			</div>
			
			<?php  if(!empty($group)) { ?>
				<div class="good_page_group good_page_item margin_top_5px">
					<?php  if(is_array($group)) { foreach($group as $item) { ?>
					<a href="<?php  echo $this->createMobileUrl('group',array('groupid'=>$item['id']))?>">
						<ul class="item_cell_box good_detail" >
							<li class="good_group_headimg"><img src="<?php  echo $item['headimgurl']?>"></li>
							<li class="item_cell_flex good_group_nickname">
								<p class="item_nickname"><?php  echo $item['nickname'];?></p>
							</li>
							<li class="item_cell_flex good_group_data">
								<p class="font_12px font_ff5f27">还差<?php  echo $item['lastnumber'];?>人</p>
								<p class="font_12px lasttime" data-time="<?php  echo $item['overtime'];?>">剩余 
									<span class='day' >00</span>天
									<span class='hour'>00</span>:
									<span class='minite'>00</span>:
									<span class='second'>00</span>
								</p>
							</li>
							<li class="good_group_end">
								去参团<span class="ti-angle-right"></span>
							</li>
						</ul>
					</a>
					<?php  } } ?>
				</div>
			<?php  } ?>
			
		</div>
		
			<!-- 商品详情 -->
			<div id="sideup_gooddetail" class="sideuper">
				<div id="actionSheet_wrap">
					<div class="weui_mask_transition" id="mask"></div>
					<div class="weui_actionsheet sideuper_body" id="weui_actionsheet">	
						<div class="detail_btn_list">
							<li class="detail_btn activity_bottom detail_body_bot" data-type="detail_body" data-content="<?php  echo $good['detail'];?>">商品详情</li>
							<li class="detail_btn params_body_bot" data-type="params_body">商品参数</li>
							<li class="detail_btn comment_body_bot" data-type="comment_body">买家评论</li>
						</div>		
						<div class="weui_actionsheet_menu sideup_gooddetail_body sideuper_body_in">
							<div class="detail_body detail_item"></div>
							<div class="params_body detail_item">
							<?php  if(is_array($good['params'])) { foreach($good['params'] as $item) { ?>
								<li class="params_item">
									<p><?php  echo $item['name'];?></p>
									<p><?php  echo $item['pro'];?></p>
								</li>
							<?php  } } ?>	
							</div>				
							<div class="comment_body detail_item">
								<li class="comment_type">
									<span data-type="all" class="comment_type_activity">全部(<?php  echo $commentnumber['all'];?>)</span> 
									<span data-type="good">好评(<?php  echo $commentnumber['good'];?>)</span> 
									<span data-type="soso">中评(<?php  echo $commentnumber['soso'];?>)</span> 
									<span data-type="bad">差评(<?php  echo $commentnumber['bad'];?>)</span>
								</li>
								<div class="comment_list"></div>
								<div class="more"><span class="look_more">查看更多</span></div>
							</div>				
						</div>
						<span id="actionsheet_cancel" class="detail_close ti-close"></span>
					</div>
				</div>
			</div>


			<!-- 购买.加入购物车 -->
			<div id="sideup_buy" class="sideuper">
				<div id="actionSheet_wrap">
					<div class="weui_mask_transition" id="mask"></div>
					<div class="weui_actionsheet sideuper_body" id="weui_actionsheet">	
						<div class="weui_actionsheet_menu sideup_buy_body sideuper_body_in">
							<div class="buy_item_img">
								<img src="<?php  echo tomedia($good['pic']['0'])?>">
							</div>
							<div class="buy_price">
								<li id="buy_price_item">单价: <span class="font_ff5f27"><?php  echo $good['nowprice'];?> 元</span></li>
								<li>库存: <span class="font_ff5f27"><?php  echo $good['stock'];?></span></li>
							</div>	
							<?php  if($good['ruletype'] != 0) { ?>
							<div class="buy_rule">
								<?php  if($good['ruletype'] == 1) { ?>
									<?php  if(is_array($good['rulearray'])) { foreach($good['rulearray'] as $k => $item) { ?>
									<ul class="buy_rule_item">
										<li class="rule_name"><?php  echo $item['name'];?></li>
										<li>
											<?php  if(is_array($item['pro'])) { foreach($item['pro'] as $in) { ?>
												<label><span><?php  echo $in;?></span><input type="radio" name="rulepro<?php  echo $k;?>" value="<?php  echo $in;?>" /></label>
											<?php  } } ?>
										</li>
									</ul>
									<?php  } } ?>
								<?php  } else if($good['ruletype'] == 2) { ?>
									<ul class="buy_rule_item">
										<li>请选择规格</li>
										<li>
											<?php  if(is_array($good['rulearray'])) { foreach($good['rulearray'] as $key => $item) { ?>
												<label data-now="<?php  echo $item['nowprice'];?>" data-group="<?php  echo $item['groupprice'];?>">
													<span><?php  echo $key;?></span><input type="radio" name="rulepro" value="<?php  echo $key;?>" />
												</label>
											<?php  } } ?>
										</li>
									</ul>
									
								<?php  } ?>
							</div>	
							<?php  } ?>
							<div class="buy_number item_cell_box">
								<li class="">数量</li>
								<li class="item_cell_flex select_good_num" data-stock="<?php  echo $good['stock'];?>">
									<span data-type="add" class="fr">+</span>
									<input class="fr" name="buynumber" type="tel" value="1" />
									<span data-type="minus" class="fr">-</span>
								</li>
							</div>
						</div>
						<div class="sideuper_bottom">
							<!-- <input value="关 闭" type="button" class="fff_button cancel" id="actionsheet_cancel">			
							<input value="确 定" type="button" class="fff_button confirm" id="buy_confirm"> -->
							<a href="javascript:;" onclick="" class="fff_button cancel good_bottomclose" id="actionsheet_cancel" >关 闭</a>
							<a href="javascript:;" onclick="" class="fff_button confirm" id="buy_confirm" >确 定</a>
						</div>
						
					</div>
				</div>

				<input type="hidden" name="goodstock" value="<?php  echo $good['stock'];?>"/>
				<input type="hidden" name="goodtype" value="<?php  echo $good['ruletype'];?>"/>
				<input type="hidden" name="goodstatus" value="<?php  echo $good['status'];?>"/>
				<input type="hidden" name="goodid" value="<?php  echo $good['id'];?>"/>
				<input type="hidden" name="goodprice" value="<?php  echo $good['nowprice'];?>"/>
				<input type="hidden" name="goodgroupprice" value="<?php  echo $good['groupprice'];?>"/>	
			</div>			
			<!-- 商品页脚 -->
			
			<div class="good_foot">
				<ul class="fixed_bottom">
				<?php  if($_W['isajax']) { ?>
					<li id="good_foot_back"><span class="good_foot_inco ti-back-left"></span>返回</li>
				<?php  } else { ?>
					<li><a href="<?php  echo $this->createMobileUrl('index')?>"><span class="good_foot_inco ti-back-left"></span>主页</a></li>
				<?php  } ?>
				<?php  if($this->module['config']['shoptype'] == 0) { ?>
					<?php  if(empty($_GPC['groupid'])) { ?>
						<li class="buy_btn" data-type="cart"><span class="good_foot_inco ti-download"></span>购物车</li>
						<li class="buy_btn" data-type="single" id="singlebuy" ><span>￥<?php  echo $good['nowprice'];?></span>单独购买</li>
						<li class="buy_btn group_buy_btn" data-type="group"><span>￥<?php  echo $good['groupprice'];?></span>团购（<?php  echo $good['groupnum'];?>人）</li>
					<?php  } else { ?>
						<li class="buy_btn joingroup" data-type="joingroup" data-group="<?php  echo $_GPC['groupid'];?>" id="joingroup" >立即参团</li>
						<a href="<?php  echo $this->createMobileUrl('good',array('id'=>$_GPC['id'],'deal'=>'newgroup'))?>"><li class="creategroup" >创建新团</li></a>
					<?php  } ?>
				<?php  } else if($this->module['config']['shoptype'] == 1) { ?> <!-- 只有团购 -->
					<?php  if(empty($_GPC['groupid'])) { ?>
						<li class="buy_btn group_buy_btn shoptype2_buy" data-type="group"><span>￥<?php  echo $good['groupprice'];?></span>团购（<?php  echo $good['groupnum'];?>人）</li>
					<?php  } else { ?>
						<li class="buy_btn joingroup" data-type="joingroup" data-group="<?php  echo $_GPC['groupid'];?>" id="joingroup" >立即参团</li>
						<a href="<?php  echo $this->createMobileUrl('good',array('id'=>$_GPC['id'],'deal'=>'newgroup'))?>"><li class="creategroup" >创建新团</li></a>
					<?php  } ?>					
				<?php  } else if($this->module['config']['shoptype'] == 2) { ?> <!-- 普通商城 -->
						<li class="buy_btn" data-type="cart"><span class="good_foot_inco ti-download"></span>购物车</li>
						<li class="buy_btn shoptype3_buy" data-type="single" id="singlebuy" ><span>￥<?php  echo $good['nowprice'];?></span>购买</li>				
				<?php  } ?>
				<i class="clear"></i>
				</ul>
			</div>		

		<?php  } else { ?>
			<li style="text-align:center;margin-top:20px">
				<h3>此商品已删除或下架</h3>
				<?php  if($_W['isajax']) { ?>
					<a style="display:inline-block;margin-top:20px;background:#fff;padding:5px 20px;border-radius:3px;" href="javascript:;" id="good_foot_back">返回</a>
				<?php  } else { ?>
					<a style="display:inline-block;margin-top:20px;background:#fff;padding:5px 20px;border-radius:3px;" href="<?php  echo $this->createMobileUrl('index')?>" >主页</a>
				<?php  } ?>
			</li>
		<?php  } ?>
		<?php  if($this->module['config']['kefutype'] == 1) { ?>
		<div class="kefu">
			<a href="<?php  echo $this->module['config']['baidubridge']?>" ><img src="../addons/zofui_groupshop/public/images/kefu_good.png"></a>
		</div>
		<?php  } else if($this->module['config']['kefutype'] == 2) { ?>
			<div class="kefu"><a href="http://wpa.qq.com/msgrd?v=3&uin=<?php  echo $this->module['config']['qqkefu']?>&site=cjrm&menu=yes"><img src="../addons/zofui_groupshop/public/images/kefu_good.png"></a></div>
		<?php  } ?>		
		
	</div>
</div>	
<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('common/basic_footer', TEMPLATE_INCLUDEPATH)) : (include template('common/basic_footer', TEMPLATE_INCLUDEPATH));?>