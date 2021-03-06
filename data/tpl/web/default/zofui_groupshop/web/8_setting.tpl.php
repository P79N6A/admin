<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/header', TEMPLATE_INCLUDEPATH)) : (include template('common/header', TEMPLATE_INCLUDEPATH));?>
	<link rel="stylesheet" href="../addons/zofui_groupshop/template/web/js/bootstrap-select.min.css">	
	<script src="../addons/zofui_groupshop/template/web/js/bootstrap-select.js"></script>
	<script src="../addons/zofui_groupshop/template/web/js/defaults-zh_CN.js"></script>
	<link href="../addons/zofui_groupshop/template/web/css/common.css" rel="stylesheet">
	
<ul class="page_top">
	<a href="javascript:;">
		<li class="top_btn setting_btn activity_bottom" data-show="basic_params">基本参数</li>
	</a>
	<a href="javascript:;">
		<li class="top_btn setting_btn" data-show="select_params">选项参数</li>
	</a>
	<a href="javascript:;">
		<li class="top_btn setting_btn" data-show="express_params">物流查询接口</li>
	</a>	
	<a href="javascript:;">
		<li class="top_btn setting_btn" data-show="refund_params">退款证书</li>
	</a>	
	<a href="javascript:;">
		<li class="top_btn setting_btn" data-show="site_params">分享信息</li>
	</a>	
	<a href="javascript:;">
		<li class="top_btn setting_btn" data-show="message_params">模板消息</li>
	</a>	
	<a href="javascript:;">
		<li class="top_btn setting_btn" data-show="cache_params">清理缓存</li>
	</a>	
	
</ul>

<div class="page_body">
<form action="" method="post" class="addgood_body" name="setting_form">
	
	<div class="basic_params setting_item" style="display:block">
		
		<div class="input_item item_cell_box">
			<div class="input_title">积分抵扣比例</div>
			<div class="input_form item_cell_flex">
				<span class="input_box input_box_200">
					<input type="text" class="input_input" name="creditratio" value="<?php  echo $settings['creditratio'];?>">
				</span> 元
				<p class="font_13px_999">下单时每1积分可抵扣的金额，可填小数，最多2位小数。模-块-由-折-翼-天-使-资-源-社-区-提-供</p>
			</div>
		</div>	
		
		<div class="input_item item_cell_box">
			<div class="input_title">联系电话</div>
			<div class="input_form item_cell_flex">
				<span class="input_box input_box_200">
					<input type="text" class="input_input" name="adminmobile" value="<?php  echo $settings['adminmobile'];?>">
				</span>
				<p class="font_13px_999">在前端订单详情页面展示。</p>
			</div>
		</div>			
		<div class="input_item item_cell_box">
			<div class="input_title">自动取消订单期限</div>
			<div class="input_form item_cell_flex">
				<span class="input_box input_box_200">
					<input type="text" class="input_input" name="autocancelordertime" value="<?php  echo $settings['autocancelordertime'];?>">
				</span>分钟
				<p class="font_13px_999">单位/分钟，会员下单后，在这个时间内没有支付，系统自动取消订单。一天等于：1440 分钟</p>
			</div>
		</div>
		<div class="input_item item_cell_box">
			<div class="input_title">自动取消前</div>
			<div class="input_form item_cell_flex">
				<span class="input_box input_box_200">
					<input type="text" class="input_input" name="remindmessagetime" value="<?php  echo $settings['remindmessagetime'];?>">
				</span>分钟，发提醒支付消息
				<p class="font_13px_999">单位/分钟，如果填0，那么不发提醒消息消息。这个值通过计算必须在创建订单时间和自动取消时间之间，否则失效。</p>
			</div>
		</div>		
		<div class="input_item item_cell_box">
			<div class="input_title">自动确认订单期限</div>
			<div class="input_form item_cell_flex">
				<span class="input_box input_box_200">
					<input type="text" class="input_input" name="autofinishordertime" value="<?php  echo $settings['autofinishordertime'];?>">
				</span>分钟
				<p class="font_13px_999">单位/分钟，后台发货后，在这个时间内没有确认收货，系统自动确认收货。一天等于：1440 分钟</p>
			</div>
		</div>
		
		<div class="input_item item_cell_box">
			<div class="input_title">客服类型</div>
			<div class="input_form item_cell_flex checkbox good_rule_type">
				<label><input type="radio" name="kefutype" value="1" <?php  if($settings['kefutype'] == 1) { ?>checked="checked"<?php  } ?>> 百度商桥</label>
				<label><input type="radio" name="kefutype" value="2"  <?php  if($settings['kefutype'] == 2) { ?>checked="checked"<?php  } ?>> QQ客服</label>
				<label><input type="radio" name="kefutype" value="3"  <?php  if($settings['kefutype'] == 3) { ?>checked="checked"<?php  } ?>> 都不使用</label>
				<p class="font_13px_999">提示：在商品页面、订单详情页面点击相应链接进入联系客服页面，首页的链接需在设计页面的时候独立加上。</p>
			</div>
		</div>		
		<div class="input_item item_cell_box">
			<div class="input_title">百度商桥沟通URL</div>
			<div class="input_form item_cell_flex">
				<span class="input_box input_box_200">
					<input type="text" class="input_input" name="baidubridge" value="<?php  echo $settings['baidubridge'];?>">
				</span>
				<p class="font_13px_999">下载<a target="_blank" href="http://qiao.baidu.com/experience/index.html" class="a_href">百度商桥</a>软件后，在基础设置-站点管理-获取代码-独立沟通链接内</p>
			</div>
		</div>		
		<div class="input_item item_cell_box">
			<div class="input_title">QQ客服号码</div>
			<div class="input_form item_cell_flex">
				<span class="input_box input_box_200">
					<input type="text" class="input_input" name="qqkefu" value="<?php  echo $settings['qqkefu'];?>">
				</span>			
				<p class="font_13px_999">若使用QQ客服，在此填入客服QQ号码，若无法跳转到QQ，请点<a class="a_href" href="http://shang.qq.com/v3/widget.html">我</a>去开启服务</p>
			</div>
		</div>		
		<div class="input_item item_cell_box">
			<div class="input_title">站点管理员</div>
			<div class="input_form item_cell_flex">
				<span class="input_box input_box_200">
					<input type="text" class="input_input" name="adminnickname" value="<?php  echo $settings['adminnickname'];?>">
				</span>
					<img id="adminheadimg" src="<?php  echo $settings['adminheadimg'];?>" width="30px" height="30px" >
					<input type="hidden" class="input_input" name="adminopenid" value="<?php  echo $settings['adminopenid'];?>">
					<input type="hidden" class="input_input" name="adminheadimg" value="<?php  echo $settings['adminheadimg'];?>">
				<span class="btn_44b549 search_admin" style="padding: 6px;font-size:12px;">按昵称搜索</span>
				<p class="font_13px_999">提示：输入管理员昵称点击搜索，然后提交保存即可设置站点管理员，会员支付后管理员将收到通知，并可点击通知查看订单详情。如果没有搜索成功，请使用管理员微信访问一次前端个人中心。</p>
			</div>
		</div>			
		
	</div>
	
	<div class="select_params setting_item">
		<div class="input_item item_cell_box">
			<div class="input_title">审核商品评价</div>
			<div class="input_form item_cell_flex checkbox good_rule_type">
				<label><input type="radio" name="commentshow" value="1" <?php  if($settings['commentshow'] == 1) { ?>checked="checked"<?php  } ?>> 审核</label>
				<label><input type="radio" name="commentshow" value="2"  <?php  if($settings['commentshow'] == 2) { ?>checked="checked"<?php  } ?>> 不审核</label>
				<p class="font_13px_999">若不审核，用户对商品评价后会立即显示评价</p>
			</div>
		</div>
		<div class="input_item item_cell_box good_rule">
			<div class="input_title">启用分类级数</div>
			<div class="input_form item_cell_flex checkbox good_rule_type">
				<label><input type="radio" name="sorttype" value="1"  <?php  if(intval($settings['sorttype']) == 1) { ?>checked="checked"<?php  } ?>> 只启用二级分类</label>
				<label><input type="radio" name="sorttype" value="2"  <?php  if(intval($settings['sorttype']) == 2) { ?>checked="checked"<?php  } ?>> 同时启用一、二级分类</label>
				<p class="font_13px_999"> 提示：若商品比较单一，建议只启用二级分类便于会员检索商品</p>
			</div>
		</div>
		<div class="input_item item_cell_box good_rule">
			<div class="input_title">开关退款申请</div>
			<div class="input_form item_cell_flex checkbox good_rule_type">
				<label><input type="radio" name="iscanrefund" value="1"  <?php  if(intval($settings['iscanrefund']) == 1) { ?>checked="checked"<?php  } ?>> 开启</label>
				<label><input type="radio" name="iscanrefund" value="2"  <?php  if(intval($settings['iscanrefund']) == 2) { ?>checked="checked"<?php  } ?>> 关闭</label>
				<p class="font_13px_999"> 提示：开启后会员在前端可以申请退款，并且只有待支付且是单独下单的订单才可以退款。</p>
			</div>
		</div>	
		<div class="input_item item_cell_box good_rule">
			<div class="input_title">取消订单是否退卡券</div>
			<div class="input_form item_cell_flex checkbox good_rule_type">
				<label><input type="radio" name="isreturncard" value="1"  <?php  if(intval($settings['isreturncard']) == 1) { ?>checked="checked"<?php  } ?>> 退还</label>
				<label><input type="radio" name="isreturncard" value="2"  <?php  if(intval($settings['isreturncard']) == 2) { ?>checked="checked"<?php  } ?>> 不退还</label>
				<p class="font_13px_999"> 提示：设置的是会员主动和系统自动取消未支付的订单是否退还订单使用的优惠券。</p>
			</div>
		</div>			
		<div class="input_item item_cell_box good_rule">
			<div class="input_title">取消订单是否退积分</div>
			<div class="input_form item_cell_flex checkbox good_rule_type">
				<label><input type="radio" name="isreturncredit" value="1"  <?php  if(intval($settings['isreturncredit']) == 1) { ?>checked="checked"<?php  } ?>> 退还</label>
				<label><input type="radio" name="isreturncredit" value="2"  <?php  if(intval($settings['isreturncredit']) == 2) { ?>checked="checked"<?php  } ?>> 不退还</label>
				<p class="font_13px_999"> 提示：设置的是会员主动和系统自动取消未支付的订单是否退还订单使用的积分。</p>
			</div>
		</div>		
		
		<div class="input_item item_cell_box good_rule">
			<div class="input_title">失败团是否自动退款</div>
			<div class="input_form item_cell_flex checkbox good_rule_type">
				<label><input type="radio" name="isautorefundgroup" value="1"  <?php  if(intval($settings['isautorefundgroup']) == 1) { ?>checked="checked"<?php  } ?>> 自动退款</label>
				<label><input type="radio" name="isautorefundgroup" value="2"  <?php  if(intval($settings['isautorefundgroup']) == 2) { ?>checked="checked"<?php  } ?>> 不自动退款</label>
				<p class="font_13px_999"> 提示：如果开启自动退款，团失败后，计划任务自动为失败的团订单退款。只有设置自动退款后产生的团才自动退款,之前的团需手动全团退款</p>
			</div>
		</div>	
		<div class="input_item item_cell_box good_rule">
			<div class="input_title">是否必须关注</div>
			<div class="input_form item_cell_flex checkbox good_rule_type">
				<label><input type="radio" name="ismustfollow" value="1"  <?php  if(intval($settings['ismustfollow']) == 1) { ?>checked="checked"<?php  } ?>> 必须关注</label>
				<label><input type="radio" name="ismustfollow" value="2"  <?php  if(intval($settings['ismustfollow']) == 2) { ?>checked="checked"<?php  } ?>> 不必关注</label>
				<p class="font_13px_999"> 提示：如果开启必须关注，未关注的会员打开任何页面都只显示提示关注及公众号二维码。</p>
			</div>
		</div>	
		<div class="input_item item_cell_box good_rule">
			<div class="input_title">商城模式</div>
			<div class="input_form item_cell_flex checkbox good_rule_type">
				<label><input type="radio" name="shoptype" value="0"  <?php  if(intval($settings['shoptype']) == 0) { ?>checked="checked"<?php  } ?>> 团购+普通商城</label>
				<label><input type="radio" name="shoptype" value="1"  <?php  if(intval($settings['shoptype']) == 1) { ?>checked="checked"<?php  } ?>> 团购</label>
				<label><input type="radio" name="shoptype" value="2"  <?php  if(intval($settings['shoptype']) == 2) { ?>checked="checked"<?php  } ?>> 普通商城</label>
				<p class="font_13px_999"> 提示：设置成普通商城后，买家无法团购，后台编辑商品内关于团购的参数随便填写就行。设置成团购后，没有购物车等，具体的在前台看。变更商城模式后，设计的页面内的商品价格不会自动变化，需在设计页面将商品模块删除重新加入商品</p>
			</div>
		</div>			
		
	</div>	
	<div class="express_params setting_item">
		<div class="input_item item_cell_box">
			<div class="input_title">快递鸟商户ID</div>
			<div class="input_form item_cell_flex">
				<span class="input_box input_box_200">
					<input type="text" class="input_input" name="kdniaoid" value="<?php  echo $settings['kdniaoid'];?>">
				</span>
				<p class="font_13px_999">提示：此商户号是用于查询物流轨迹信息。每个账户每天只能调用接口3000次。<a target="_blank" href="http://www.kdniao.com/UserCenter/Index.aspx" class="a_href">申请快递鸟账户</a>后登陆账户，找到商户id和api key填入</p>
			</div>
		</div>
		<div class="input_item item_cell_box">
			<div class="input_title">快递鸟API key</div>
			<div class="input_form item_cell_flex">
				<span class="input_box input_box_200">
					<input type="text" class="input_input" name="kdniaokey" value="<?php  echo $settings['kdniaokey'];?>">
				</span>
			</div>
		</div>			
	</div>
	<div class="refund_params setting_item">
		<div class="input_item item_cell_box">
			<div class="input_title">cert证书</div>
			<div class="input_form item_cell_flex input_box_400">
				<textarea class="input_input" name="cert" rows="6" placeholder="为保证安全性, 不显示证书内容. 若要修改, 请直接粘贴"></textarea>
				<p class="font_13px_999">从商户平台上下载支付证书, 解压并取得其中的 <mark>apiclient_cert.pem</mark> 用记事本打开并复制文件内容, 填至此处</p>
			</div>
		</div>
		
		<div class="input_item item_cell_box">
			<div class="input_title">key证书</div>
			<div class="input_form item_cell_flex input_box_400">
				<textarea class="input_input" name="key" rows="6" placeholder="为保证安全性, 不显示证书内容. 若要修改, 请直接粘贴"></textarea>
				<p class="font_13px_999">从商户平台上下载支付证书, 解压并取得其中的 <mark>apiclient_key.pem</mark> 用记事本打开并复制文件内容, 填至此处</p>
			</div>
		</div>

		<div class="input_item item_cell_box">
			<div class="input_title">rootca证书</div>
			<div class="input_form item_cell_flex input_box_400">
				<textarea class="input_input" name="rootca" rows="6" placeholder="为保证安全性, 不显示证书内容. 若要修改, 请直接粘贴"></textarea>
				<p class="font_13px_999">从商户平台上下载支付证书, 解压并取得其中的 <mark>rootca.pem</mark> 用记事本打开并复制文件内容, 填至此处</p>
			</div>
		</div>		
		
	</div>	
	<div class="site_params setting_item">
		<div class="input_item item_cell_box">
			<div class="input_title">分享标题</div>
			<div class="input_form item_cell_flex">
				<span class="input_box input_box_300">
					<input type="text" class="input_input" name="sharetitle" value="<?php  echo $settings['sharetitle'];?>">
				</span>
				<p class="font_13px_999">提示：此分享信息在分类、个人中心、购物车、我的订单、卡券、我的团购、订单详情页面有效。</p>
			</div>
		</div>			
		<div class="input_item item_cell_box">
			<div class="input_title">分享描述</div>
			<div class="input_form item_cell_flex">
				<span class="input_box input_box_300">
					<input type="text" class="input_input" name="sharedesc" value="<?php  echo $settings['sharedesc'];?>">
				</span>
			</div>
		</div>			
		<div class="input_item item_cell_box good_rule good_pic headimg_box">
			<div class="input_title">分享图片</div>
			<div class="input_form item_cell_flex checkbox">
				<?php  echo  WebCommon::tpl_form_field_image('sharepic',$settings['sharepic'])?>
			</div>
		</div>
		
	</div>	
	
	<div class="message_params setting_item">
		<p class="font_13px_999">请将行业选择在IT/互联网+消费品/消费品</p>
		<div class="item_cell_box message_box">
			<div class="input_title">支付成功通知</div>
			<div class="input_form item_cell_flex">
			
				<div class="item_cell_box">
					<div class="input_title font_13px_999">模板ID</div>
					<div class="item_cell_flex">
						<span class="input_box input_box_400">
							<input type="text" class="input_input" name="a_id" value="<?php  echo $settings['a_id'];?>">
						</span>
						<p class="font_13px_999">提示：在公众号后台模板消息搜索‘商品支付成功通知’——编号：OPENTM206425979</p>
					</div>
				</div>
				
				<div class="input_item item_cell_box">
					<div class="input_title font_13px_999">备注内容</div>
					<div class="item_cell_flex">
						<span class="input_box input_box_400">
							<input type="text" class="input_input" name="a_remark" value="<?php  echo $settings['a_remark'];?>">
						</span>
						<p class="font_13px_999">提示：备注内容是模板消息底部文字内容，比如可填：感谢您对我们的支持。</p>
					</div>
				</div>
			</div>
		</div>
		
		<div class="item_cell_box message_box">
			<div class="input_title">开团提醒通知</div>
			<div class="input_form item_cell_flex">
			
				<div class="item_cell_box">
					<div class="input_title font_13px_999">模板ID</div>
					<div class="item_cell_flex">
						<span class="input_box input_box_400">
							<input type="text" class="input_input" name="b_id" value="<?php  echo $settings['b_id'];?>">
						</span>
						<p class="font_13px_999">提示：在公众号后台模板消息搜索‘开团成功提醒’——编号：OPENTM407307456</p>
					</div>
				</div>
				
				<div class="input_item item_cell_box">
					<div class="input_title font_13px_999">备注内容</div>
					<div class="item_cell_flex">
						<span class="input_box input_box_400">
							<input type="text" class="input_input" name="b_remark" value="<?php  echo $settings['b_remark'];?>">
						</span>
					</div>
				</div>
			</div>
		</div>	
		
		<div class="item_cell_box message_box">
			<div class="input_title">参团提醒通知</div>
			<div class="input_form item_cell_flex">
			
				<div class="item_cell_box">
					<div class="input_title font_13px_999">模板ID</div>
					<div class="item_cell_flex">
						<span class="input_box input_box_400">
							<input type="text" class="input_input" name="c_id" value="<?php  echo $settings['c_id'];?>">
						</span>
						<p class="font_13px_999">提示：在公众号后台模板消息搜索‘参团成功通知’——编号：OPENTM400048581</p>
					</div>
				</div>
				
				<div class="input_item item_cell_box">
					<div class="input_title font_13px_999">备注内容</div>
					<div class="item_cell_flex">
						<span class="input_box input_box_400">
							<input type="text" class="input_input" name="c_remark" value="<?php  echo $settings['c_remark'];?>">
						</span>
					</div>
				</div>
			</div>
		</div>		
		<div class="item_cell_box message_box">
			<div class="input_title">团购成功通知</div>
			<div class="input_form item_cell_flex">
			
				<div class="item_cell_box">
					<div class="input_title font_13px_999">模板ID</div>
					<div class="item_cell_flex">
						<span class="input_box input_box_400">
							<input type="text" class="input_input" name="d_id" value="<?php  echo $settings['d_id'];?>">
						</span>
						<p class="font_13px_999">提示：在公众号后台模板消息搜索‘团购成功通知’——编号：OPENTM206953990</p>
					</div>
				</div>
				
				<div class="input_item item_cell_box">
					<div class="input_title font_13px_999">备注内容</div>
					<div class="item_cell_flex">
						<span class="input_box input_box_400">
							<input type="text" class="input_input" name="d_remark" value="<?php  echo $settings['d_remark'];?>">
						</span>
					</div>
				</div>
			</div>
		</div>			
		<div class="item_cell_box message_box">
			<div class="input_title">订单发货通知</div>
			<div class="input_form item_cell_flex">
			
				<div class="item_cell_box">
					<div class="input_title font_13px_999">模板ID</div>
					<div class="item_cell_flex">
						<span class="input_box input_box_400">
							<input type="text" class="input_input" name="e_id" value="<?php  echo $settings['e_id'];?>">
						</span>
						<p class="font_13px_999">提示：在公众号后台模板消息搜索‘订单发货通知’——编号：OPENTM202243318</p>
					</div>
				</div>
				
				<div class="input_item item_cell_box">
					<div class="input_title font_13px_999">备注内容</div>
					<div class="item_cell_flex">
						<span class="input_box input_box_400">
							<input type="text" class="input_input" name="e_remark" value="<?php  echo $settings['e_remark'];?>">
						</span>
					</div>
				</div>
			</div>
		</div>		
		<div class="item_cell_box message_box">
			<div class="input_title">订单退款提醒</div>
			<div class="input_form item_cell_flex">
			
				<div class="item_cell_box">
					<div class="input_title font_13px_999">模板ID</div>
					<div class="item_cell_flex">
						<span class="input_box input_box_400">
							<input type="text" class="input_input" name="f_id" value="<?php  echo $settings['f_id'];?>">
						</span>
						<p class="font_13px_999">提示：在公众号后台模板消息搜索‘订单退款提醒’——编号：OPENTM200565278</p>
					</div>
				</div>
				
				<div class="input_item item_cell_box">
					<div class="input_title font_13px_999">备注内容</div>
					<div class="item_cell_flex">
						<span class="input_box input_box_400">
							<input type="text" class="input_input" name="f_remark" value="<?php  echo $settings['f_remark'];?>">
						</span>
					</div>
				</div>
			</div>
		</div>			
		<div class="item_cell_box message_box">
			<div class="input_title">组团失败提醒</div>
			<div class="input_form item_cell_flex">
			
				<div class="item_cell_box">
					<div class="input_title font_13px_999">模板ID</div>
					<div class="item_cell_flex">
						<span class="input_box input_box_400">
							<input type="text" class="input_input" name="g_id" value="<?php  echo $settings['g_id'];?>">
						</span>
						<p class="font_13px_999">提示：在公众号后台模板消息搜索‘组团失败提醒’——编号：OPENTM400833482</p>
					</div>
				</div>
				
				<div class="input_item item_cell_box">
					<div class="input_title font_13px_999">备注内容</div>
					<div class="item_cell_flex">
						<span class="input_box input_box_400">
							<input type="text" class="input_input" name="g_remark" value="<?php  echo $settings['g_remark'];?>">
						</span>
					</div>
				</div>
			</div>
		</div>		
		<div class="item_cell_box message_box">
			<div class="input_title">订单完成通知</div>
			<div class="input_form item_cell_flex">
			
				<div class="item_cell_box">
					<div class="input_title font_13px_999">模板ID</div>
					<div class="item_cell_flex">
						<span class="input_box input_box_400">
							<input type="text" class="input_input" name="h_id" value="<?php  echo $settings['h_id'];?>">
						</span>
						<p class="font_13px_999">提示：在公众号后台模板消息搜索‘订单完成通知’——编号：OPENTM202521011</p>
					</div>
				</div>
				
				<div class="input_item item_cell_box">
					<div class="input_title font_13px_999">备注内容</div>
					<div class="item_cell_flex">
						<span class="input_box input_box_400">
							<input type="text" class="input_input" name="h_remark" value="<?php  echo $settings['h_remark'];?>">
						</span>
						<p class="font_13px_999">提示：此消息只有在系统自动完成订单时才发送。</p>
					</div>
				</div>
			</div>
		</div>
		<div class="item_cell_box message_box">
			<div class="input_title">订单取消通知</div>
			<div class="input_form item_cell_flex">
			
				<div class="item_cell_box">
					<div class="input_title font_13px_999">模板ID</div>
					<div class="item_cell_flex">
						<span class="input_box input_box_400">
							<input type="text" class="input_input" name="i_id" value="<?php  echo $settings['i_id'];?>">
						</span>
						<p class="font_13px_999">提示：在公众号后台模板消息搜索‘订单取消通知’——编号：OPENTM400925266</p>
					</div>
				</div>
				
				<div class="input_item item_cell_box">
					<div class="input_title font_13px_999">备注内容</div>
					<div class="item_cell_flex">
						<span class="input_box input_box_400">
							<input type="text" class="input_input" name="i_remark" value="<?php  echo $settings['i_remark'];?>">
						</span>
					</div>
				</div>
			</div>
		</div>			
		
		<div class="item_cell_box message_box">
			<div class="input_title">售出成功通知</div>
			<div class="input_form item_cell_flex">
				<div class="item_cell_box">
					<div class="input_title font_13px_999">模板ID</div>
					<div class="item_cell_flex">
						<span class="input_box input_box_400">
							<input type="text" class="input_input" name="j_id" value="<?php  echo $settings['j_id'];?>">
						</span>
						<p class="font_13px_999">提示：在公众号后台模板消息搜索‘售出成功通知’——编号：OPENTM406074965</p>
					</div>
				</div>
				<div class="input_item item_cell_box">
					<div class="input_title font_13px_999">备注内容</div>
					<div class="item_cell_flex">
						<span class="input_box input_box_400">
							<input type="text" class="input_input" name="j_remark" value="<?php  echo $settings['j_remark'];?>">
						</span>
						<p class="font_13px_999">提示：此消息只发给管理员</p>
					</div>
				</div>
			</div>
		</div>
		<div class="item_cell_box message_box">
			<div class="input_title">未支付提醒通知</div>
			<div class="input_form item_cell_flex">
				<div class="item_cell_box">
					<div class="input_title font_13px_999">模板ID</div>
					<div class="item_cell_flex">
						<span class="input_box input_box_400">
							<input type="text" class="input_input" name="k_id" value="<?php  echo $settings['k_id'];?>">
						</span>
						<p class="font_13px_999">提示：在公众号后台模板消息搜索‘未支付提醒通知’——编号：TM00470</p>
					</div>
				</div>
				<div class="input_item item_cell_box">
					<div class="input_title font_13px_999">备注内容</div>
					<div class="item_cell_flex">
						<span class="input_box input_box_400">
							<input type="text" class="input_input" name="k_remark" value="<?php  echo $settings['k_remark'];?>">
						</span>
					</div>
				</div>
			</div>
		</div>
		
	</div>	
	<div class="cache_params setting_item">
		<div class="input_item item_cell_box">
			<div class="input_title">清理缓存</div>
			<div class="input_form item_cell_flex">
				<input name="deletecache" value="立即清理" class="btn_44b549" type="button">
				<p class="font_13px_999">清理缓存不会对运营有影响，建议每天清理一次</p>
			</div>
		</div>
	</div>
	
	</div>
	
	<div class="confirm_add">
		<input name="submit" value="提交保存" class="btn_44b549" type="submit">
		<input type="hidden" name="token" value="<?php  echo $_W['token'];?>" />
	</div>	
</form>	

</div>

	<script src="../addons/zofui_groupshop/template/web/js/fsjs.js"></script>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/footer', TEMPLATE_INCLUDEPATH)) : (include template('common/footer', TEMPLATE_INCLUDEPATH));?>