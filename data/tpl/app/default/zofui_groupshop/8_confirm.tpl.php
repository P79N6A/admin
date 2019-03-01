<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('common/myheader', TEMPLATE_INCLUDEPATH)) : (include template('common/myheader', TEMPLATE_INCLUDEPATH));?>	
<form action="<?php  echo $this->createMobileUrl('pay')?>" method="post">	
    <div id="page_confirm" class="page page-current page_confirm">
		<div class="content  native-scroll">
	
			<div class="confirm_address item_cell_box confirm_item">
				<li ><span class="ti-location-pin font_ff5f27"></span></li>
				<li class="item_cell_flex">
					<?php  if($userinfo['openid'] == '111111a' || $userinfo['openid'] == '222222a') { ?>
					<div class="confirm_address_in">
						<input name="address" value="广东省,深圳市,福田区,欢乐街道111号" type="hidden">
						<input name="province" type="hidden" value="广东省">
						<input name="tel" type="hidden" value="13112345678">
						<input name="name" type="hidden" value="熊二">
					</div>
					<?php  } else { ?>
						<div class="confirm_address_in">选择收货地址</div>
					<?php  } ?>
				</li>
				<li><span class="ti-angle-right"></span></li>	
			</div>
			<?php  if(is_array($orderinfo['goodinfo'])) { foreach($orderinfo['goodinfo'] as $item) { ?>
				<div class="confirm_goods confirm_item" data-id="<?php  echo $item['id'];?>">
					<div class="confirm_good_item item_cell_box">
						<div class="confirm_good_left">
							<img src="<?php  echo tomedia($item['pic']['0'])?>">
						</div>
						<div class="confirm_good_right item_cell_flex">
							<a href="" >
								<div class="good_title"><?php  echo $item['title'];?></div>
							</a>
							<div class="font_13px_999">
								<p class="confirm_rule">规格：<?php  echo $item['buyrule'];?></p>
								<p class="confirm_rule">单价：<span class="font_ff5f27">￥<?php  echo $item['buyprice'];?></span></p>
								<p class="confirm_rule">数量：<span class="font_ff5f27"><?php  echo $item['buynumber'];?></span></p>
							</div>
						</div>
					</div>
					<div class="buy_number item_cell_box">
						<div class="confirm_express font_13px_999">
							<li class=""><span>运费:</span>
							<?php  if($item['buyexpressmoney'] == 0) { ?>
								<span class="font_ff5f27 good_item_expressa">包邮</span>
								<?php  if($item['buyfreeexpressmoney'] >0) { ?> 
									<font style="font-size:12px;" class="good_item_express">(免<?php  echo $item['buyfreeexpressmoney'];?>元运费)</font>
								<?php  } ?>
							<?php  } else { ?>	
								<span class="font_ff5f27 good_item_express"><?php  echo $item['buyexpressmoney'];?></span>元
							<?php  } ?>
							</li>
						</div>
						<li class="item_cell_flex select_good_num" data-stock="<?php  echo $item['stock'];?>">
							<font class="font_13px_999">小计:
								<font class="font_ff5f27 good_item_toal"><?php  echo $item['buynumber']*$item['buyprice'] + $item['buyexpressmoney']?></font>元
							</font>
						</li>
					</div>
				</div>
			<?php  } } ?>
			<div class="confirm_message confirm_item margin_top_5px">
				<div class="guy_task_item weui_cells_form">
					<div class="weui_cell guy_task_input">
						<div class="weui_cell_bd weui_cell_primary">
							<textarea class="weui_textarea" name="ordermessage" rows="2" placeholder="可在此输入留言文字"></textarea>
						</div>
					</div>
				</div>
			</div>

			<div class="confirm_activity confirm_item">
			
				<div class="weui_cell weui_cell_select confirm_activity_item">
					<div class="weui_cell_bd weui_cell_primary">
						<select class="weui_select" name="credit">
							<?php  if($orderinfo['minuscredit'] > 0) { ?>
								<option value="<?php  echo $orderinfo['minuscredit'];?>" >抵扣<span class="font_ff5f27"><?php  echo $orderinfo['minuscredit'];?></span>积分</option>
								<option value="0" >不参与积分抵扣</option>
							<?php  } else { ?>
								<option value="0" >积分抵扣</option>
							<?php  } ?>
						</select>
						<?php  if($orderinfo['minuscredit'] > 0) { ?>
							<p class="font_13px_999 activity_notice activity_credit_notice">优惠<span class="font_ff5f27"><?php  echo $orderinfo['minuscreditmoney'];?></span>元</p>
						<?php  } else { ?>
							<p class="font_13px_999 activity_notice activity_credit_notice">不可抵扣</p>							
						<?php  } ?>
					</div>
				</div>
				
				<div class="weui_cells weui_cells_access confirm_activity_item" <?php  if($orderinfo['iscard'] == 1 && !empty($cardinfo)) { ?>id="to_select_card"<?php  } ?>>
					<a class="weui_cell activity_other" href="javascript:;">
						<div class="weui_cell_bd weui_cell_primary">
							<p>优惠券</p>
						</div>
						<?php  if($orderinfo['iscard'] == 1 && !empty($cardinfo)) { ?>
							<div class="weui_cell_ft font_13px_999 activity_card_notice">选择优惠券</div>
						<?php  } else { ?>
							<div class="weui_cell_ft font_13px_999 activity_card_notice">不可使用</div>
						<?php  } ?>
					</a>
				</div>
				
				<div class="weui_cells weui_cells_access confirm_activity_item need_hide_after">
					<a class="weui_cell activity_other" href="javascript:;">
						<div class="weui_cell_bd weui_cell_primary">
							<p>满额包邮</p>
						</div>
						<?php  if($orderinfo['totalfreeexpress'] > 0) { ?>
							<div class="weui_cell_ft font_13px_999">已免<span class="font_ff5f27"><?php  echo $orderinfo['totalfreeexpress'];?></span>元邮费</div>
						<?php  } else { ?>
							<div class="weui_cell_ft font_13px_999">无此活动</div>
						<?php  } ?>
					</a>
				</div>
				<div class="weui_cells weui_cells_access confirm_activity_item need_hide_after">
					<a class="weui_cell activity_other" href="javascript:;">
						<div class="weui_cell_bd weui_cell_primary">
							<p>首单优惠</p>
						</div>
						<?php  if($orderinfo['firstcutmoney'] > 0) { ?>
							<div class="weui_cell_ft font_13px_999">优惠<span class="font_ff5f27"><?php  echo $orderinfo['firstcutmoney'];?></span>元</div>
						<?php  } else { ?>
							<div class="weui_cell_ft font_13px_999">不可优惠</div>
						<?php  } ?>
					</a>
				</div>
			</div>
		</div>
	</div>
	<div class="confirm_bottom confirm_item fixed_bottom item_cell_box">
		<li id="gotoback"><a href="javascript:;">返回</a></li>
		<li class="item_cell_flex font_13px_999">共<span class="font_ff5f27"><?php  echo $orderinfo['totalnum'];?></span>件，合计:
			<span class="total_fee">￥
				<font id="total_fee"><?php  echo $orderinfo['totalmoney']['1'];?></font>
			</span>
		</li>
		<li>
		<input name="paygood" type="submit" value="提交订单">
		<input name="token" type="hidden" value="<?php  echo $_W['token'];?>" />
		</li>
	</div>
	
	<!-- 选择优惠券 -->
	<div id="sideup_card" class="sideuper">
		<div id="actionSheet_wrap">
			<div class="weui_mask_transition" id="mask"></div>
			<div class="weui_actionsheet sideuper_body" id="weui_actionsheet">	
				<div class="weui_actionsheet_menu sideup_card_body sideuper_body_in">
					<div class="select_card_item item_cell_box">
						<div class="font_ff5f27 card_item_left"><font class="card_value_inco">￥</font><span class="card_value">0</span></div>
						<div class="item_cell_flex">
							<p class="font_13px_999">不使用优惠券</p>
							<p class="font_13px_999"></p>
						</div>
						<div class=" weui_cells weui_cells_checkbox">
							<label class="weui_cell weui_check_label activity_checked_card" for="s0">
								<div class="weui_cell_hd">
									<input type="radio" class="weui_check" name="checkedcard" value="0" id="s0" >
									<i class="weui_icon_checked"></i>
								</div>
							</label>
						</div>
					</div>
					<?php  if(is_array($cardinfo)) { foreach($cardinfo as $item) { ?>
						<div class="select_card_item item_cell_box">
							<div class="font_ff5f27 card_item_left">
								<?php  if($item['cardtype'] == 1) { ?>
								<font class="card_value_inco">￥</font><span class="card_value"><?php  echo $item['cardvalue']*10/10?></span>
								<?php  } else if($item['cardtype'] == 2) { ?>
								<span class="card_value"><?php  echo $item['cardvalue']*10?></span><font class="card_value_inco">折</font>
								<?php  } ?>
							</div>
							<div class="item_cell_flex">
								<p class="font_13px_999">订单满<?php  echo $item['fullmoney'];?>元可用</p>
								<p class="font_13px_999"><span class="card_item_time"><?php  echo Util::lastTime($item['overtime'],false)?>天后过期</span></p>
							</div>
							<div class=" weui_cells weui_cells_checkbox">
								<label class="weui_cell weui_check_label activity_checked_card" for="<?php  echo $item['usercardid'];?>">
									<div class="weui_cell_hd">
										<input type="radio" class="weui_check" name="checkedcard" value="<?php  echo $item['usercardid'];?>" id="<?php  echo $item['usercardid'];?>" >
										<i class="weui_icon_checked"></i>
									</div>
								</label>
							</div>
						</div>
					<?php  } } ?>
					
				</div>
				<div class="sideuper_bottom">
					<input value="关 闭" type="button" class="fff_button cancel" id="actionsheet_cancel">
				</div>
			</div>
		</div>
	</div>
</form>	
	<script>
		var orderinfo = <?php  echo json_encode($orderinfo)?>;
	</script>
<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('common/basic_footer', TEMPLATE_INCLUDEPATH)) : (include template('common/basic_footer', TEMPLATE_INCLUDEPATH));?>
	