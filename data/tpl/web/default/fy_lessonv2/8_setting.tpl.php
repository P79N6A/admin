<?php defined('IN_IA') or exit('Access Denied');?><!-- 
 * 参数设置
 * ============================================================================
 * 版权所有 2015-2017 风影随行，并保留所有权利。
 * 网站地址: http://www.haoshu888.com
 * ----------------------------------------------------------------------------
 * 这不是一个自由软件！不允许对程序代码以任何形式任何目的的再发布，作者将保留
 * 追究法律责任的权力和最终解释权。
 * ============================================================================
-->

<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/header', TEMPLATE_INCLUDEPATH)) : (include template('common/header', TEMPLATE_INCLUDEPATH));?>
<ul class="nav nav-tabs">
	<li <?php  if($op=='display' ) { ?>class="active" <?php  } ?>>
		<a href="<?php  echo $this->createWebUrl('setting');?>">全局设置</a>
	</li>
	<li <?php  if($op=='frontshow' ) { ?>class="active" <?php  } ?>>
		<a href="<?php  echo $this->createWebUrl('setting', array('op'=>'frontshow'));?>">手机端显示</a>
	</li>
	<li <?php  if($op=='templatemsg' ) { ?>class="active" <?php  } ?>>
		<a href="<?php  echo $this->createWebUrl('setting', array('op'=>'templatemsg'));?>">模版消息</a>
	</li>
	<li <?php  if($op=='vipservice' ) { ?>class="active" <?php  } ?>>
		<a href="<?php  echo $this->createWebUrl('setting', array('op'=>'vipservice'));?>">会员服务</a>
	</li>
	<?php  if($op=='vipLevel' ) { ?>
	<li class="active">
		<a href="<?php  echo $this->createWebUrl('setting', array('op'=>'vipLevel','level_id'=>$_GPC['level_id']));?>">VIP等级</a>
	</li>
	<?php  } ?>
	<li <?php  if($op=='banner' ) { ?>class="active" <?php  } ?>>
		<a href="<?php  echo $this->createWebUrl('setting', array('op'=>'banner'));?>">首页幻灯片</a>
	</li>
	<li <?php  if($op=='adv' ) { ?>class="active" <?php  } ?>>
		<a href="<?php  echo $this->createWebUrl('setting', array('op'=>'adv'));?>">课程页广告</a>
	</li>
	<li <?php  if($op=='savetype' ) { ?>class="active" <?php  } ?>>
		<a href="<?php  echo $this->createWebUrl('setting', array('op'=>'savetype'));?>">存储方式</a>
	</li>
</ul>
<style>
	.item_box img {
		width: 100%;
		height: 100%;
	}
	
	.focus-setting {
		border-bottom: 1px #428BCA dashed;
		padding-bottom: 20px;
	}
</style>
<?php  if($op=='display') { ?>
<div class="main">
	<form action="" method="post" class="form-horizontal form" enctype="multipart/form-data">
		<div class="panel panel-default">
			<div class="panel-heading">全局设置</div>
			<div class="panel-body">
				<div class="form-group">
					<label class="col-xs-12 col-sm-3 col-md-2 control-label">非微信端访问</label>
					<div class="col-sm-9">
						<label class="radio-inline"><input type="radio" name="visit_limit" value="1" <?php  if($setting['visit_limit']==1) { ?>checked<?php  } ?> /> 允许</label> &nbsp;
						<label class="radio-inline"><input type="radio" name="visit_limit" value="0" <?php  if($setting['visit_limit']==0) { ?>checked<?php  } ?> /> 禁止</label>
						<span class="help-block">开启非微信端访问后，用户可在浏览器里访问微课堂，<strong style="color:red;">但目前QQ浏览器未开放禁止下载按钮API，所以可能造成客户缓存下载您的视频</strong></span>
					</div>
				</div>
				<div class="form-group">
					<label class="col-xs-12 col-sm-3 col-md-2 control-label">需登录访问页面</label>
					<div class="col-sm-9">
						<label class="radio-inline"><input type="checkbox" name="login_visit[]" value="index" <?php  if(in_array('index', $login_visit)) { ?>checked<?php  } ?> /> 首页</label>&nbsp;
						<label class="radio-inline"><input type="checkbox" name="login_visit[]" value="lesson" <?php  if(in_array('lesson', $login_visit)) { ?>checked<?php  } ?> /> 课程详情页</label>&nbsp;
						<label class="radio-inline"><input type="checkbox" name="login_visit[]" value="search" <?php  if(in_array('search', $login_visit)) { ?>checked<?php  } ?> /> 全部课程</label>&nbsp;
						<label class="radio-inline"><input type="checkbox" name="login_visit[]" value="getcoupon" <?php  if(in_array('getcoupon', $login_visit)) { ?>checked<?php  } ?> /> 优惠券</label>&nbsp;
						<span class="help-block">选中的前台页面，用户在手机端需要先登录帐号才能访问</span>
					</div>
				</div>
				<div class="form-group">
					<label class="col-xs-12 col-sm-3 col-md-2 control-label">开启课程库存</label>
					<div class="col-sm-9">
						<label class="radio-inline"><input type="radio" name="stock_config" value="1" <?php  if($setting['stock_config']==1) { ?>checked<?php  } ?> /> 开启</label> &nbsp;
						<label class="radio-inline"><input type="radio" name="stock_config" value="0" <?php  if($setting['stock_config']==0) { ?>checked<?php  } ?> /> 关闭</label>
						<span class="help-block"><strong></strong>开启课程库存后，库存为0的课程将显示为“已售罄”且不能购买</span>
					</div>
				</div>
				<div class="form-group">
					<label class="col-xs-12 col-sm-3 col-md-2 control-label">引导关注公众号</label>
					<div class="col-sm-9">
						<label class="radio-inline"><input type="radio" name="isfollow" value="1" <?php  if($setting['isfollow']==1) { ?>checked<?php  } ?> /> 开启</label> &nbsp;
						<label class="radio-inline"><input type="radio" name="isfollow" value="0" <?php  if($setting['isfollow']==0) { ?>checked<?php  } ?> /> 关闭</label>
						<span class="help-block">该项仅在微信客户端中生效，未关注公众号的用户访问首页和课程页面时，顶部将出现引导关注公众号信息</span>
					</div>
				</div>
				<div class="form-group">
					<label class="col-xs-12 col-sm-3 col-md-2 control-label">引导关注提示语</label>
					<div class="col-sm-9">
						<input type="text" name="follow_word" value="<?php  echo $setting['follow_word'];?>" class="form-control" />
						<span class="help-block">建议不超过12个汉字，包括标点符号</span>
					</div>
				</div>
				<div class="form-group">
					<label class="col-xs-12 col-sm-3 col-md-2 control-label">公众号二维码</label>
					<div class="col-sm-9">
						<?php  echo tpl_form_field_image('qrcode', $setting['qrcode']);?>
					</div>
				</div>
				<div class="form-group">
					<label class="col-xs-12 col-sm-3 col-md-2 control-label">购买课程开具发票</label>
					<div class="col-sm-9">
						<label class="radio-inline"><input type="radio" name="is_invoice" value="1" <?php  if($setting['is_invoice']==1) { ?>checked<?php  } ?> /> 开启</label> &nbsp;
						<label class="radio-inline"><input type="radio" name="is_invoice" value="0" <?php  if($setting['is_invoice']==0) { ?>checked<?php  } ?> /> 关闭</label>
						<span class="help-block"><strong></strong>默认关闭，开启后用户购买课程将显示是否开具发票按钮</span>
					</div>
				</div>
				<div class="form-group">
					<label class="col-xs-12 col-sm-3 col-md-2 control-label">前台全部分类图标</label>
					<div class="col-sm-9">
						<?php  echo tpl_form_field_image('category_ico', $setting['category_ico']);?>
					</div>
				</div>
				<div class="form-group">
					<label class="col-xs-12 col-sm-3 col-md-2 control-label">会员推广海报</label>
					<div class="col-sm-9">
						<?php  echo tpl_form_field_image('posterbg', $setting['posterbg']);?>
						<span class="help-block">宽度:640 px，高度:940 px，处理技巧：从PS导出图片时，要导出为WEB所用格式(快捷键是：ctrl+shift+alt+s)，将会大大减少图片所占内存大小，提高用户打开速度！&nbsp;&nbsp;&nbsp;<a href="http://wx.haoshu888.com/sucai/posterbg.psd">模版海报下载</a></span>
					</div>
				</div>
				<div class="form-group">
					<label class="col-xs-12 col-sm-3 col-md-2 control-label">管理员openid</label>
					<div class="col-sm-9">
						<input type="text" name="manageopenid" value="<?php  echo $setting['manageopenid'];?>" class="form-control">
						<div class="help-block">
							新订单和新提现申请(到微信零钱且提现为人工审核方式)提醒管理员，多个管理员openid之间用英文状态逗号“,”隔开
						</div>
					</div>
				</div>
				<div class="form-group">
					<label class="col-xs-12 col-sm-3 col-md-2 control-label">未付款订单关闭间隔</label>
					<div class="col-sm-9">
						<div class="input-group">
							<input type="text" name="closespace" value="<?php  echo $setting['closespace'];?>" class="form-control">
							<span class="input-group-addon">分钟</span>
						</div>
						<div class="help-block">
							默认为60分钟，0表示不自动关闭未付款订单
						</div>
					</div>
				</div>
				<div class="form-group">
					<label class="col-xs-12 col-sm-3 col-md-2 control-label">讲师分成</label>
					<div class="col-sm-9">
						<div class="input-group">
							<input type="text" name="teacher_income" value="<?php  echo $setting['teacher_income'];?>" class="form-control">
							<span class="input-group-addon">%</span>
						</div>
						<div class="help-block">
							留空或0表示关闭用户申请讲师，例如设为40%，即表示用户申请讲师后，该用户的课程每次出售都以出售价格的40%作为讲师的收入。
						</div>
					</div>
				</div>
				<div class="form-group">
					<label class="col-xs-12 col-sm-3 col-md-2 control-label">开启审核课程评价</label>
					<div class="col-sm-9">
						<label class="radio-inline"><input type="radio" name="audit_evaluate" value="1" <?php  if($setting['audit_evaluate']==1) { ?>checked<?php  } ?> /> 开启</label> &nbsp;
						<label class="radio-inline"><input type="radio" name="audit_evaluate" value="0" <?php  if($setting['audit_evaluate']==0) { ?>checked<?php  } ?> /> 关闭</label>
						<span class="help-block"><strong></strong>默认关闭，开启后用户评价课程需要后台审核后显示在前台课程评价里</span>
					</div>
				</div>
				<div class="form-group">
					<label class="col-xs-12 col-sm-3 col-md-2 control-label">超时自动好评</label>
					<div class="col-sm-9">
						<div class="input-group">
							<input type="text" name="autogood" value="<?php  echo $setting['autogood'];?>" class="form-control">
							<span class="input-group-addon">天</span>
						</div>
						<div class="help-block">
							0或留空表示关闭自动好评(自购买课程日起，超过该期限未评价课程将自动好评)
						</div>
					</div>
				</div>
				<div class="form-group">
					<label class="col-xs-12 col-sm-3 col-md-2 control-label">打印视频错误信息</label>
					<div class="col-sm-9">
						<label class="radio-inline"><input type="radio" name="print_error" value="1" <?php  if($setting['print_error']==1) { ?>checked<?php  } ?> /> 开启</label> &nbsp;
						<label class="radio-inline"><input type="radio" name="print_error" value="0" <?php  if($setting['print_error']==0) { ?>checked<?php  } ?> /> 关闭</label>
						<span class="help-block">前台无法播放视频时，可开启该选项输出错误信息，平时请关闭。</span>
					</div>
				</div>
				<div class="form-group hide">
					<label class="col-xs-12 col-sm-3 col-md-2 control-label">定时任务链接</label>
					<div class="col-sm-9">
						<a href="javascript:;" id="copyCrontab"><?php  echo $_W['siteroot'];?>app/<?php  echo str_replace("./","",$this->createMobileUrl('crontab'));?></a>
						<span class="help-block">定时任务用于取消超期未支付、未评价订单、会员过期优惠券等，您可以设置服务器定时执行该URL来操作定时任务。</span>
					</div>
				</div>
			</div>
		</div>

		<div class="form-group col-sm-12">
			<input type="hidden" name="id" value="<?php  echo $setting['id'];?>" />
			<input type="submit" name="submit" value="保存设置" class="btn btn-primary col-lg-1" />
			<input type="hidden" name="token" value="<?php  echo $_W['token'];?>" />
		</div>
	</form>
</div>
<script type="text/javascript">
require(['jquery', 'util'], function($, util){
	$(function(){
		util.clip($("#copyCrontab")[0], $("#copyCrontab").text());
	});
});
</script>

<?php  } else if($op=='frontshow') { ?>
<div class="main">
	<form action="" method="post" class="form-horizontal form" enctype="multipart/form-data">
		<div class="panel panel-default">
			<div class="panel-heading">手机端设置</div>
			<div class="panel-body">
				<div class="form-group">
					<label class="col-xs-12 col-sm-3 col-md-2 control-label">网站名称</label>
					<div class="col-sm-9">
						<input type="text" name="sitename" value="<?php  echo $setting['sitename'];?>" class="form-control" />
					</div>
				</div>
				<div class="form-group">
					<label class="col-xs-12 col-sm-3 col-md-2 control-label">网站版权</label>
					<div class="col-sm-9">
						<input type="text" name="copyright" value="<?php  echo $setting['copyright'];?>" class="form-control" />
					</div>
				</div>
				<div class="form-group">
					<label class="col-xs-12 col-sm-3 col-md-2 control-label">网站logo</label>
					<div class="col-sm-9">
						<?php  echo tpl_form_field_image('logo', $setting['logo']);?>
						<span class="help-block">建议尺寸64px * 64px，建议格式PNG</span>
					</div>
				</div>
				<div class="form-group hide">
					<label class="col-xs-12 col-sm-3 col-md-2 control-label">菜单显示方式</label>
					<div class="col-sm-9">
						<label class="radio-inline"><input type="radio" name="footnav" value="0" <?php  if($setting['footnav']==0) { ?>checked<?php  } ?> /> 底部菜单</label> &nbsp;
						<label class="radio-inline"><input type="radio" name="footnav" value="1" <?php  if($setting['footnav']==1) { ?>checked<?php  } ?> /> 悬浮菜单</label>
						<span class="help-block">该菜单显示在前台手机端，默认为底部菜单</span>
					</div>
				</div>
				<div class="form-group">
					<label class="col-xs-12 col-sm-3 col-md-2 control-label">底部自选菜单</label>
					<div class="col-sm-9">
						<label class="radio-inline"><input type="radio" name="teacherlist" value="0" <?php  if($setting['teacherlist']==0) { ?>checked<?php  } ?> /> 不显示</label>&nbsp;
						<label class="radio-inline"><input type="radio" name="teacherlist" value="1" <?php  if($setting['teacherlist']==1) { ?>checked<?php  } ?> /> 讲师列表</label>&nbsp;
						<label class="radio-inline"><input type="radio" name="teacherlist" value="2" <?php  if($setting['teacherlist']==2) { ?>checked<?php  } ?> /> VIP会员</label>&nbsp;
						<label class="radio-inline"><input type="radio" name="teacherlist" value="3" <?php  if($setting['teacherlist']==3) { ?>checked<?php  } ?> /> 优惠券</label>&nbsp;
						<span class="help-block">开启该选项后，在微课堂导航栏菜单将显示相应的菜单</span>
					</div>
				</div>
				<div class="form-group">
					<label class="col-xs-12 col-sm-3 col-md-2 control-label">课程详情页默认显示</label>
					<div class="col-sm-9">
						<label class="radio-inline"><input type="radio" name="lesson_show" value="0" <?php  if($setting['lesson_show']==0) { ?>checked<?php  } ?> /> 课程详情</label>&nbsp;
						<label class="radio-inline"><input type="radio" name="lesson_show" value="1" <?php  if($setting['lesson_show']==1) { ?>checked<?php  } ?> /> 课程目录</label>
						<span class="help-block">该选项为手机端用户进入课程详情页时默认显示的页面</span>
					</div>
				</div>
				<div class="form-group">
					<label class="col-xs-12 col-sm-3 col-md-2 control-label">购买需完善信息</label>
					<div class="col-sm-9">
						<label class="radio-inline"><input type="radio" name="mustinfo" value="0" <?php  if($setting['mustinfo']==0) { ?>checked<?php  } ?> onclick="changeUserInfo(this.value)" /> 无须</label> &nbsp;
						<label class="radio-inline"><input type="radio" name="mustinfo" value="1" <?php  if($setting['mustinfo']==1) { ?>checked<?php  } ?> onclick="changeUserInfo(this.value)"/> 必须</label>
						<span class="help-block">该选项指用户在购买课程或开通会员VIP前是否需要完善信息</span>
					</div>
				</div>
				<div class="form-group" id="user_info" <?php  if($setting['mustinfo']==0) { ?>style="display:none;"<?php  } ?>>
					<label class="col-xs-12 col-sm-3 col-md-2 control-label">需完善信息</label>
					<div class="col-sm-9">
						<label class="radio-inline">
							<input type="checkbox" name="user_info[]" value="realname" <?php  if(in_array('realname',$user_info)) { ?>checked<?php  } ?>>姓名
						</label>
						<label class="radio-inline">
							<input type="checkbox" name="user_info[]" value="mobile" <?php  if(in_array('mobile',$user_info)) { ?>checked<?php  } ?>>手机号码
						</label>
						<label class="radio-inline">
							<input type="checkbox" name="user_info[]" value="msn" <?php  if(in_array('msn',$user_info)) { ?>checked<?php  } ?>>微信号
						</label>
						<label class="radio-inline">
							<input type="checkbox" name="user_info[]" value="occupation" <?php  if(in_array('occupation',$user_info)) { ?>checked<?php  } ?>>职业
						</label>
						<label class="radio-inline">
							<input type="checkbox" name="user_info[]" value="company" <?php  if(in_array('company',$user_info)) { ?>checked<?php  } ?>>公司
						</label>
						<label class="radio-inline">
							<input type="checkbox" name="user_info[]" value="graduateschool" <?php  if(in_array('graduateschool',$user_info)) { ?>checked<?php  } ?>>学校
						</label>
						<label class="radio-inline">
							<input type="checkbox" name="user_info[]" value="grade" <?php  if(in_array('grade',$user_info)) { ?>checked<?php  } ?>>班级
						</label>
						<label class="radio-inline">
							<input type="checkbox" name="user_info[]" value="address" <?php  if(in_array('address',$user_info)) { ?>checked<?php  } ?>>地址
						</label>
					</div>
				</div>
				<div class="form-group">
					<label class="col-xs-12 col-sm-3 col-md-2 control-label">修改系统手机号码</label>
					<div class="col-sm-9">
						<label class="radio-inline"><input type="radio" name="mobilechange" value="1" <?php  if($setting['mobilechange']==1) { ?>checked<?php  } ?> /> 开启</label>&nbsp;
						<label class="radio-inline"><input type="radio" name="mobilechange" value="0" <?php  if($setting['mobilechange']==0) { ?>checked<?php  } ?> /> 关闭</label>
						<span class="help-block">开启该选项后，在微课堂个人中心将显示修改全局手机号码链接</span>
					</div>
				</div>
				<div class="form-group">
					<label class="col-xs-12 col-sm-3 col-md-2 control-label">首页延迟加载</label>
					<div class="col-sm-9">
						<label class="radio-inline"><input type="radio" name="lazyload_switch" value="1" <?php  if($lazyload['lazyload_switch']==1) { ?>checked<?php  } ?> /> 开启</label>&nbsp;
						<label class="radio-inline"><input type="radio" name="lazyload_switch" value="0" <?php  if($lazyload['lazyload_switch']==0) { ?>checked<?php  } ?> /> 关闭</label>
						<span class="help-block">开启该选项后，手机端首页图片将延迟加载</span>
					</div>
				</div>
				<div class="form-group">
					<label class="col-xs-12 col-sm-3 col-md-2 control-label">加载默认图片</label>
					<div class="col-sm-9">
						<?php  echo tpl_form_field_image('lazyload_image', $lazyload['lazyload_image']);?>
						<span class="help-block">手机端首页课程封面图延迟加载默认图片，留空使用系统默认图片</span>
					</div>
				</div>
				<div class="form-group">
					<label class="col-xs-12 col-sm-3 col-md-2 control-label">自定义菜单名称①</label>
					<div class="col-sm-9">
						<input type="text" name="diy_name[]" value="<?php  echo $self_diy[0]['diy_name'];?>" placeholder="个人中心自定义菜单名称" class="form-control" />
					</div>
				</div>
				<div class="form-group">
					<label class="col-xs-12 col-sm-3 col-md-2 control-label">自定义菜单链接①</label>
					<div class="col-sm-9">
						<input type="text" name="diy_link[]" value="<?php  echo $self_diy[0]['diy_link'];?>" placeholder="个人中心自定义菜单链接，包括http://" class="form-control" />
					</div>
				</div>
				<div class="form-group hide">
					<label class="col-xs-12 col-sm-3 col-md-2 control-label">自定义菜单图标①</label>
					<div class="col-sm-9">
						<?php  echo tpl_form_field_image('diy_image[]', $self_diy[0]['diy_image']);?>
						<span class="help-block">建议尺寸64*64px，留空使用系统默认图标</span>
					</div>
				</div>
				<div class="form-group">
					<label class="col-xs-12 col-sm-3 col-md-2 control-label">自定义菜单名称②</label>
					<div class="col-sm-9">
						<input type="text" name="diy_name[]" value="<?php  echo $self_diy[1]['diy_name'];?>" placeholder="个人中心自定义菜单名称" class="form-control" />
					</div>
				</div>
				<div class="form-group">
					<label class="col-xs-12 col-sm-3 col-md-2 control-label">自定义菜单链接②</label>
					<div class="col-sm-9">
						<input type="text" name="diy_link[]" value="<?php  echo $self_diy[1]['diy_link'];?>" placeholder="个人中心自定义菜单链接，包括http://" class="form-control" />
					</div>
				</div>
				<div class="form-group hide">
					<label class="col-xs-12 col-sm-3 col-md-2 control-label">自定义菜单图标②</label>
					<div class="col-sm-9">
						<?php  echo tpl_form_field_image('diy_image[]', $self_diy[1]['diy_image']);?>
						<span class="help-block">建议尺寸64*64px，留空使用系统默认图标</span>
					</div>
				</div>
				<div class="form-group">
					<label class="col-xs-12 col-sm-3 col-md-2 control-label">自定义菜单名称③</label>
					<div class="col-sm-9">
						<input type="text" name="diy_name[]" value="<?php  echo $self_diy[2]['diy_name'];?>" placeholder="个人中心自定义菜单名称" class="form-control" />
					</div>
				</div>
				<div class="form-group">
					<label class="col-xs-12 col-sm-3 col-md-2 control-label">自定义菜单链接③</label>
					<div class="col-sm-9">
						<input type="text" name="diy_link[]" value="<?php  echo $self_diy[2]['diy_link'];?>" placeholder="个人中心自定义菜单链接，包括http://" class="form-control" />
					</div>
				</div>
				<div class="form-group hide">
					<label class="col-xs-12 col-sm-3 col-md-2 control-label">自定义菜单图标③</label>
					<div class="col-sm-9">
						<?php  echo tpl_form_field_image('diy_image[]', $self_diy[2]['diy_image']);?>
						<span class="help-block">建议尺寸64*64px，留空使用系统默认图标</span>
					</div>
				</div>
			</div>
		</div>

		<div class="form-group col-sm-12">
			<input type="hidden" name="id" value="<?php  echo $setting['id'];?>" />
			<input type="submit" name="submit" value="保存设置" class="btn btn-primary col-lg-1" />
			<input type="hidden" name="token" value="<?php  echo $_W['token'];?>" />
		</div>
	</form>
</div>
<script type="text/javascript">
function changeUserInfo(status){
	if(status==1){
		document.getElementById("user_info").style.display = "block";
	}else{
		document.getElementById("user_info").style.display = "none";
	}
}
</script>
<?php  } else if($op=='templatemsg') { ?>
<div class="main">
	<form action="" method="post" class="form-horizontal form" enctype="multipart/form-data">
		<div class="panel panel-default">
			<div class="panel-heading">
				模版消息通知 (所在行业：IT科技/互联网|电子商务)
			</div>
			<div class="panel-body">
				<div class="form-group">
					<label class="col-xs-12 col-sm-3 col-md-2 control-label">是否开启</label>
					<div class="col-sm-9">
						<label class="radio-inline"><input type="radio" name="istplnotice" value="1" id="isshow1" <?php  if($setting['istplnotice'] == 1) { ?>checked="true"<?php  } ?> /> 是</label> &nbsp;
						<label class="radio-inline"><input type="radio" name="istplnotice" value="0" id="isshow2"  <?php  if(empty($setting) || $setting['istplnotice'] == 0) { ?>checked="true"<?php  } ?> /> 否</label>
						<span class="help-block"></span>
					</div>
				</div>
				<div class="form-group">
					<label class="col-xs-12 col-sm-3 col-md-2 control-label">用户购买成功通知</label>
					<div class="col-sm-9">
						<input type="text" name="buysucc" value="<?php  echo $setting['buysucc'];?>" class="form-control" />
						<div class="help-block">
							【留空为关闭该通知】用户购买VIP服务或课程成功后模版消息通知，选择编号TM00001(购买成功通知)
						</div>
					</div>
				</div>
				<div class="form-group">
					<label class="col-xs-12 col-sm-3 col-md-2 control-label">会员到期提醒</label>
					<div class="col-sm-9">
						<input type="text" name="pastvip" value="<?php  echo $setting['pastvip'];?>" class="form-control" />
						<div class="help-block">
							【留空为关闭该通知】用户VIP服务过期提醒，选择编号TM00008(会员到期提醒)
						</div>
					</div>
				</div>
				<div class="form-group">
					<label class="col-xs-12 col-sm-3 col-md-2 control-label">佣金提醒</label>
					<div class="col-sm-9">
						<input type="text" name="cnotice" value="<?php  echo $setting['cnotice'];?>" class="form-control" />
						<div class="help-block">
							【留空为关闭该通知】下级购买课程时，上级获得佣金提醒，选择编号OPENTM201812627(佣金提醒)
						</div>
					</div>
				</div>
				<div class="form-group">
					<label class="col-xs-12 col-sm-3 col-md-2 control-label">下级代理商加入提醒</label>
					<div class="col-sm-9">
						<input type="text" name="newjoin" value="<?php  echo $setting['newjoin'];?>" class="form-control" />
						<div class="help-block">
							【留空为关闭该通知】成功推荐下级加入时，给推荐上级提醒，选择编号OPENTM405761879(下级代理商加入提醒)
						</div>
					</div>
				</div>
				<div class="form-group">
					<label class="col-xs-12 col-sm-3 col-md-2 control-label">课程通知</label>
					<div class="col-sm-9">
						<input type="text" name="newlesson" value="<?php  echo $setting['newlesson'];?>" class="form-control" />
						<div class="help-block">
							【留空为关闭该通知】讲师新开课程后，给购买过该讲师课程的学员发送消息，选择编号OPENTM400221044(课程通知)
						</div>
					</div>
				</div>
				<div class="form-group">
					<label class="col-xs-12 col-sm-3 col-md-2 control-label">订单通知(管理员)</label>
					<div class="col-sm-9">
						<input type="text" name="neworder" value="<?php  echo $setting['neworder'];?>" class="form-control" />
						<div class="help-block">
							【留空为关闭该通知】用户下新订单后通知管理员，选择编号OPENTM206930158(订单通知)
						</div>
					</div>
				</div>
				<div class="form-group">
					<label class="col-xs-12 col-sm-3 col-md-2 control-label">提现申请通知(管理员)</label>
					<div class="col-sm-9">
						<input type="text" name="newcash" value="<?php  echo $setting['newcash'];?>" class="form-control" />
						<div class="help-block">
							【留空为关闭该通知】用户申请提现到微信钱包且提现为人工审核时通知管理员，选择编号OPENTM405485000(提现申请通知)
						</div>
					</div>
				</div>
				<div class="form-group">
					<label class="col-xs-12 col-sm-3 col-md-2 control-label">申请讲师入驻审核通知</label>
					<div class="col-sm-9">
						<input type="text" name="apply_teacher" value="<?php  echo $setting['apply_teacher'];?>" class="form-control" />
						<div class="help-block">
							【留空为关闭该通知】用户申请讲师入驻时通知管理员审核，选择编号OPENTM408471635(等待审核通知)
						</div>
					</div>
				</div>
			</div>
		</div>

		<div class="form-group col-sm-12">
			<input type="hidden" name="id" value="<?php  echo $setting['id'];?>" />
			<input type="submit" name="submit" value="保存设置" class="btn btn-primary col-lg-1" />
			<input type="hidden" name="token" value="<?php  echo $_W['token'];?>" />
		</div>
	</form>
</div>

<?php  } else if($op=='vipservice') { ?>
<div class="main">
	<div class="alert alert-info">
	    请勿随意删除VIP等级，删除VIP等级会影响已购买该等级的会员使用.
	</div>
	<form action="" method="post" onsubmit="return formcheck(this)">
		<div class="panel panel-default">
			<div class="panel-heading">
				VIP等级设置
			</div>
			<div class="panel-body">
				<table class="table">
					<thead>
						<tr>
							<th style="width:8%;">ID</th>
							<th style="width:15%;">等级名称</th>
							<th style="width:12%;">有效期</th>
							<th style="width:13%;">价格</th>
							<th style="width:10%;">会员折扣</th>
							<th style="width:12%;">状态</th>
							<th style="width:13%;">排序</th>
							<th style="width:18%;">操作</th>
						</tr>
					</thead>
					<tbody>
						<?php  if(is_array($level_list)) { foreach($level_list as $item) { ?>
						<tr>
							<td><?php  echo $item['id'];?></td>
							<td><?php  echo $item['level_name'];?></td>
							<td><?php  echo $item['level_validity'];?>天</td>
							<td><?php  echo $item['level_price'];?>元</td>
							<td><?php  echo $item['discount'];?>%</td>
							<td><?php echo $item['is_show']==1 ? '显示':'隐藏';?></td>
							<td><?php  echo $item['sort'];?></td>
							<td>
                            	<a class="btn btn-default" href="<?php  echo $this->createWebUrl('setting', array('op'=>'vipLevel','level_id'=>$item['id']));?>">编辑</a>
                            	<a class="btn btn-default" href="<?php  echo $this->createWebUrl('setting', array('op'=>'delVipLevel','level_id'=>$item['id']));?>" onclick="return confirm('确认删除此等级吗？');return false;">删除</a>
							</td>
						</tr>
						<?php  } } ?>
					</tbody>
				</table>
			</div>
			<div class="panel-footer">
				<a class="btn btn-default" href="<?php  echo $this->createWebUrl('setting',array('op'=>'vipLevel'));?>"><i class="fa fa-plus"></i> 添加新等级</a>
			</div>
		</div>
	</form>
	<form action="" method="post" class="form-horizontal form" enctype="multipart/form-data">
		<div class="panel panel-default">
			<div class="panel-heading">购买会员服务</div>
			<div class="panel-body">
				<div class="form-group">
					<label class="col-xs-12 col-sm-3 col-md-2 control-label">VIP分销开关</label>
					<div class="col-sm-9">
						<label class="radio-inline"><input type="radio" name="vip_sale" value="1" <?php  if($setting['vip_sale']==1) { ?>checked<?php  } ?> /> 开启</label> &nbsp;
						<label class="radio-inline"><input type="radio" name="vip_sale" value="0" <?php  if($setting['vip_sale']==0) { ?>checked<?php  } ?> /> 关闭</label>
						<span class="help-block"><strong></strong>开启后，下级购买或续费VIP服务时，上级也会获得分销佣金</span>
					</div>
				</div>
				<div class="form-group item">
					<label class="col-xs-12 col-sm-3 col-md-2 control-label">一级佣金比例</label>
					<div class="col-sm-4">
						<div class="input-group">
							<input type="text" name="com[commission1]" value="<?php  echo $commission['commission1'];?>" class="form-control"><span class="input-group-addon">%</span>
						</div>
					</div>
				</div>
				<div class="form-group item <?php  if(in_array($setting['level'],array('1'))) { ?>hide<?php  } ?>">
					<label class="col-xs-12 col-sm-3 col-md-2 control-label">二级佣金比例</label>
					<div class="col-sm-4">
						<div class="input-group">
							<input type="text" name="com[commission2]" value="<?php  echo $commission['commission2'];?>" class="form-control"><span class="input-group-addon">%</span>
						</div>
					</div>
				</div>
				<div class="form-group item <?php  if(in_array($setting['level'],array('1','2'))) { ?>hide<?php  } ?>">
					<label class="col-xs-12 col-sm-3 col-md-2 control-label">三级佣金比例</label>
					<div class="col-sm-4">
						<div class="input-group">
							<input type="text" name="com[commission3]" value="<?php  echo $commission['commission3'];?>" class="form-control"><span class="input-group-addon">%</span>
						</div>
						<span class="help-block">留空或填写0表示使用全局佣金比例参数</span>
					</div>
				</div>
				<div class="form-group">
					<label class="col-xs-12 col-sm-3 col-md-2 control-label">会员服务描述</label>
					<div class="col-sm-9">
						<?php  echo tpl_ueditor('vipdesc', $setting['vipdesc']);?>
						<div class="help-block">
							该描述不为空时，会显示在前台手机端“VIP服务”页面，尽量仅填写文字而不包含图品、音视频等其他多媒体元素。
						</div>
					</div>
				</div>
			</div>
		</div>

		<div class="form-group col-sm-12">
			<input type="hidden" name="id" value="<?php  echo $setting['id'];?>" />
			<input type="submit" name="submit" value="保存设置" class="btn btn-primary col-lg-1" />
			<input type="hidden" name="token" value="<?php  echo $_W['token'];?>" />
		</div>
	</form>
</div>

<?php  } else if($op=='vipLevel') { ?>
<div class="main">
	<form action="" method="post" class="form-horizontal form" enctype="multipart/form-data">
		<div class="panel panel-default">
			<div class="panel-heading">
				VIP等级设置
			</div>
			<div class="panel-body">
				<div class="form-group">
					<label class="col-xs-12 col-sm-3 col-md-2 control-label"><span style="color:red">*</span> 等级名称</label>
					<div class="col-sm-9 col-xs-12">
						<input type="text" name="level_name" class="form-control" value="<?php  echo $level['level_name'];?>">
					</div>
				</div>
				<div class="form-group">
					<label class="col-xs-12 col-sm-3 col-md-2 control-label"><span style="color:red">*</span> 有效期</label>
					<div class="col-sm-9 col-xs-12">
						<div class="input-group">
							<input type="text" name="level_validity" class="form-control" value="<?php  echo $level['level_validity'];?>">
							<span class="input-group-addon">天</span>
						</div>
					</div>
				</div>
				<div class="form-group">
					<label class="col-xs-12 col-sm-3 col-md-2 control-label"><span style="color:red">*</span> 价格</label>
					<div class="col-sm-9 col-xs-12">
						<div class="input-group">
							<input type="text" name="level_price" class="form-control" value="<?php  echo $level['level_price'];?>">
							<span class="input-group-addon">元</span>
						</div>
					</div>
				</div>
				<div class="form-group">
					<label class="col-xs-12 col-sm-3 col-md-2 control-label"><span style="color:red">*</span> 是否显示</label>
					<div class="col-sm-9">
						<label class="radio-inline"><input type="radio" name="is_show" value="1" <?php  if($level['is_show']==1) { ?>checked<?php  } ?> /> 显示</label> &nbsp;
						<label class="radio-inline"><input type="radio" name="is_show" value="0" <?php  if($level['is_show']==0) { ?>checked<?php  } ?> /> 隐藏</label>
						<span class="help-block"><strong></strong>隐藏的VIP等级不会显示在手机端，且用户无法购买</span>
					</div>
				</div>
				<div class="form-group">
					<label class="col-xs-12 col-sm-3 col-md-2 control-label"><span style="color:red">*</span> 会员折扣</label>
					<div class="col-sm-9 col-xs-12">
						<div class="input-group">
							<input type="text" name="discount" class="form-control" value="<?php  echo $level['discount'];?>">
							<span class="input-group-addon">%</span>
						</div>
						<span class="help-block">会员购买课程时，享受的折扣，留空或0表示不享受任何折扣</span>
					</div>
				</div>
				<div class="form-group">
					<label class="col-xs-12 col-sm-3 col-md-2 control-label">排序</label>
					<div class="col-sm-9 col-xs-12">
						<input type="text" name="sort" class="form-control" value="<?php  echo $level['sort'];?>">
						<span class="help-block">排序越大，排序越靠前</span>
					</div>
				</div>
			</div>
		</div>
		<div class="form-group col-sm-12">
			<input type="submit" name="submit" value="提交" class="btn btn-primary col-lg-1">
			<input type="hidden" name="id" value="<?php  echo $level_id;?>">
			<input type="hidden" name="token" value="<?php  echo $_W['token'];?>">
		</div>
	</form>
</div>

<?php  } else if($op=='banner') { ?>
<div class="main">
	<form action="" method="post" class="form-horizontal form" enctype="multipart/form-data">
		<div class="panel panel-default">
			<div class="panel-heading">
				首页幻灯片
			</div>
			<div class="panel-body">
				<div class="form-group">
					<label class="col-xs-12 col-sm-3 col-md-2 control-label">幻灯片1</label>
					<div class="col-sm-9">
						<?php  echo tpl_form_field_image("banner[0][img]", $banner[0]['img']);?>
						<span>建议尺寸750px * 360px，也可根据自己需要进行设置大小</span>
					</div>
				</div>
				<div class="form-group focus-setting">
					<label class="col-xs-12 col-sm-3 col-md-2 control-label">幻灯片链接1</label>
					<div class="col-sm-9">
						<input type="text" name="banner[0][link]" value="<?php  echo $banner[0]['link'];?>" class="form-control" />
						<span>请填写完整URL地址，包括http://</span>
					</div>
				</div>
				<div class="form-group">
					<label class="col-xs-12 col-sm-3 col-md-2 control-label">幻灯片2</label>
					<div class="col-sm-9">
						<?php  echo tpl_form_field_image("banner[1][img]", $banner[1]['img']);?>
						<span>建议尺寸750px * 360px，也可根据自己需要进行设置大小</span>
					</div>
				</div>
				<div class="form-group focus-setting">
					<label class="col-xs-12 col-sm-3 col-md-2 control-label">幻灯片链接2</label>
					<div class="col-sm-9">
						<input type="text" name="banner[1][link]" value="<?php  echo $banner[1]['link'];?>" class="form-control" />
						<span>请填写完整URL地址，包括http://</span>
					</div>
				</div>
				<div class="form-group">
					<label class="col-xs-12 col-sm-3 col-md-2 control-label">幻灯片3</label>
					<div class="col-sm-9">
						<?php  echo tpl_form_field_image("banner[2][img]", $banner[2]['img']);?>
						<span>建议尺寸750px * 360px，也可根据自己需要进行设置大小</span>
					</div>
				</div>
				<div class="form-group focus-setting">
					<label class="col-xs-12 col-sm-3 col-md-2 control-label">幻灯片链接3</label>
					<div class="col-sm-9">
						<input type="text" name="banner[2][link]" value="<?php  echo $banner[2]['link'];?>" class="form-control" />
						<span>请填写完整URL地址，包括http://</span>
					</div>
				</div>
				<div class="form-group">
					<label class="col-xs-12 col-sm-3 col-md-2 control-label">幻灯片4</label>
					<div class="col-sm-9">
						<?php  echo tpl_form_field_image("banner[3][img]", $banner[3]['img']);?>
						<span>建议尺寸750px * 360px，也可根据自己需要进行设置大小</span>
					</div>
				</div>
				<div class="form-group focus-setting">
					<label class="col-xs-12 col-sm-3 col-md-2 control-label">幻灯片链接4</label>
					<div class="col-sm-9">
						<input type="text" name="banner[3][link]" value="<?php  echo $banner[3]['link'];?>" class="form-control" />
						<span>请填写完整URL地址，包括http://</span>
					</div>
				</div>
				<div class="form-group">
					<label class="col-xs-12 col-sm-3 col-md-2 control-label">幻灯片5</label>
					<div class="col-sm-9">
						<?php  echo tpl_form_field_image("banner[4][img]", $banner[4]['img']);?>
						<span>建议尺寸750px * 360px，也可根据自己需要进行设置大小</span>
					</div>
				</div>
				<div class="form-group focus-setting">
					<label class="col-xs-12 col-sm-3 col-md-2 control-label">幻灯片链接5</label>
					<div class="col-sm-9">
						<input type="text" name="banner[4][link]" value="<?php  echo $banner[4]['link'];?>" class="form-control" />
						<span>请填写完整URL地址，包括http://</span>
					</div>
				</div>
			</div>
		</div>

		<div class="form-group col-sm-12">
			<input type="hidden" name="id" value="<?php  echo $setting['id'];?>" />
			<input type="submit" name="submit" value="保存设置" class="btn btn-primary col-lg-1" />
			<input type="hidden" name="token" value="<?php  echo $_W['token'];?>" />
		</div>
	</form>
</div>

<?php  } else if($op=='adv') { ?>
<div class="main">
	<form action="" method="post" class="form-horizontal form" enctype="multipart/form-data">
		<div class="panel panel-default">
			<div class="panel-heading">
				课程页广告(该广告随机展示于课程详情页脚部)
			</div>
			<div class="panel-body">
				<div class="form-group">
					<label class="col-xs-12 col-sm-3 col-md-2 control-label">广告一</label>
					<div class="col-sm-9">
						<?php  echo tpl_form_field_image("adv[0][img]", $adv[0]['img']);?>
						<span>建议尺寸400px * 100px</span>
					</div>
				</div>
				<div class="form-group focus-setting">
					<label class="col-xs-12 col-sm-3 col-md-2 control-label">链接一</label>
					<div class="col-sm-9">
						<input type="text" name="adv[0][link]" value="<?php  echo $adv[0]['link'];?>" class="form-control" />
						<span>请填写完整URL地址，包括http://</span>
					</div>
				</div>
				<div class="form-group">
					<label class="col-xs-12 col-sm-3 col-md-2 control-label">广告二</label>
					<div class="col-sm-9">
						<?php  echo tpl_form_field_image("adv[1][img]", $adv[1]['img']);?>
						<span>建议尺寸400px * 100px</span>
					</div>
				</div>
				<div class="form-group focus-setting">
					<label class="col-xs-12 col-sm-3 col-md-2 control-label">链接二</label>
					<div class="col-sm-9">
						<input type="text" name="adv[1][link]" value="<?php  echo $adv[1]['link'];?>" class="form-control" />
						<span>请填写完整URL地址，包括http://</span>
					</div>
				</div>
				<div class="form-group">
					<label class="col-xs-12 col-sm-3 col-md-2 control-label">广告三</label>
					<div class="col-sm-9">
						<?php  echo tpl_form_field_image("adv[2][img]", $adv[2]['img']);?>
						<span>建议尺寸400px * 100px</span>
					</div>
				</div>
				<div class="form-group focus-setting">
					<label class="col-xs-12 col-sm-3 col-md-2 control-label">链接三</label>
					<div class="col-sm-9">
						<input type="text" name="adv[2][link]" value="<?php  echo $adv[2]['link'];?>" class="form-control" />
						<span>请填写完整URL地址，包括http://</span>
					</div>
				</div>
				<div class="form-group">
					<label class="col-xs-12 col-sm-3 col-md-2 control-label">广告四</label>
					<div class="col-sm-9">
						<?php  echo tpl_form_field_image("adv[3][img]", $adv[3]['img']);?>
						<span>建议尺寸400px * 100px</span>
					</div>
				</div>
				<div class="form-group focus-setting">
					<label class="col-xs-12 col-sm-3 col-md-2 control-label">链接四</label>
					<div class="col-sm-9">
						<input type="text" name="adv[3][link]" value="<?php  echo $adv[3]['link'];?>" class="form-control" />
						<span>请填写完整URL地址，包括http://</span>
					</div>
				</div>
				<div class="form-group">
					<label class="col-xs-12 col-sm-3 col-md-2 control-label">广告五</label>
					<div class="col-sm-9">
						<?php  echo tpl_form_field_image("adv[4][img]", $adv[4]['img']);?>
						<span>建议尺寸400px * 100px</span>
					</div>
				</div>
				<div class="form-group focus-setting">
					<label class="col-xs-12 col-sm-3 col-md-2 control-label">链接五</label>
					<div class="col-sm-9">
						<input type="text" name="adv[4][link]" value="<?php  echo $adv[4]['link'];?>" class="form-control" />
						<span>请填写完整URL地址，包括http://</span>
					</div>
				</div>
			</div>
		</div>

		<div class="form-group col-sm-12">
			<input type="hidden" name="id" value="<?php  echo $setting['id'];?>" />
			<input type="submit" name="submit" value="保存设置" class="btn btn-primary col-lg-1" />
			<input type="hidden" name="token" value="<?php  echo $_W['token'];?>" />
		</div>
	</form>
</div>

<?php  } else if($op=='savetype') { ?>
<div class="main">
	<form action="" method="post" class="form-horizontal form" enctype="multipart/form-data">
		<div class="panel panel-default">
			<div class="panel-heading">存储方式</div>
			<div class="panel-body">
				<div class="form-group">
					<label class="col-xs-12 col-sm-3 col-md-2 control-label">存储方式设置</label>
					<div class="col-sm-9">
						<label class="radio-inline">
                            <input type="radio" name="savetype" value="0" <?php  if($setting['savetype']==0) { ?>checked<?php  } ?>>其他存储方式
                        </label>
						<label class="radio-inline">
                            <input type="radio" name="savetype" value="1" <?php  if($setting['savetype']==1) { ?>checked<?php  } ?>>七牛云存储
                        </label>
						<label class="radio-inline">
                            <input type="radio" name="savetype" value="2" <?php  if($setting['savetype']==2) { ?>checked<?php  } ?>>腾讯云存储
                        </label>
						<span class="help-block">默认课程视频存储方式，设置后也可以在课程章节里修改</span>
					</div>
				</div>
				<!-- 七牛 Start -->
				<div class="form-group qiniu-params-admin" <?php  if($setting[ 'savetype']!=1) { ?>style="display: none;" <?php  } ?>>
					<label class="col-xs-12 col-sm-3 col-md-2 control-label">Bucket</label>
					<div class="col-sm-9">
						<input type="text" name="qiniu[bucket]" class="form-control" value="<?php  echo $qiniu['bucket'];?>" autocomplete="off">
					</div>
				</div>
				<div class="form-group qiniu-params-admin" <?php  if($setting[ 'savetype']!=1) { ?>style="display: none;" <?php  } ?>>
					<label class="col-xs-12 col-sm-3 col-md-2 control-label">七牛ACCESS_KEY</label>
					<div class="col-sm-9">
						<input type="text" name="qiniu[access_key]" class="form-control" value="<?php  echo $qiniu['access_key'];?>" autocomplete="off">
					</div>
				</div>
				<div class="form-group qiniu-params-admin" <?php  if($setting[ 'savetype']!=1) { ?>style="display: none;" <?php  } ?>>
					<label class="col-xs-12 col-sm-3 col-md-2 control-label">七牛SECRET_KEY</label>
					<div class="col-sm-9">
						<input type="text" name="qiniu[secret_key]" class="form-control" value="<?php  echo $qiniu['secret_key'];?>" autocomplete="off">
					</div>
				</div>
				<div class="form-group qiniu-params-admin" <?php  if($setting[ 'savetype']!=1) { ?>style="display: none;" <?php  } ?>>
					<label class="col-xs-12 col-sm-3 col-md-2 control-label">七牛加速域名</label>
					<div class="col-sm-9">
						<input type="text" name="qiniu[url]" class="form-control" value="<?php  echo $qiniu['url'];?>" autocomplete="off">
						<span class="help-block">不带http://，例如：v.haoshu888.com</span>
					</div>
				</div>
				<!-- 七牛 End -->

				<!-- 腾讯云 Start -->
				<div class="form-group qcloud-params-admin" <?php  if($setting[ 'savetype']!=2) { ?>style="display: none;" <?php  } ?>>
					<label class="col-xs-12 col-sm-3 col-md-2 control-label">腾讯云APPID</label>
					<div class="col-sm-9">
						<input type="text" name="qcloud[appid]" class="form-control" value="<?php  echo $qcloud['appid'];?>" autocomplete="off">
					</div>
				</div>
				<div class="form-group qcloud-params-admin" <?php  if($setting[ 'savetype']!=2) { ?>style="display: none;" <?php  } ?>>
					<label class="col-xs-12 col-sm-3 col-md-2 control-label">Bucket</label>
					<div class="col-sm-9">
						<input type="text" name="qcloud[bucket]" class="form-control" value="<?php  echo $qcloud['bucket'];?>" autocomplete="off">
					</div>
				</div>
				<div class="form-group qcloud-params-admin" <?php  if($setting[ 'savetype']!=2) { ?>style="display: none;" <?php  } ?>>
					<label class="col-xs-12 col-sm-3 col-md-2 control-label">腾讯云SecretID</label>
					<div class="col-sm-9">
						<input type="text" name="qcloud[secretid]" class="form-control" value="<?php  echo $qcloud['secretid'];?>" autocomplete="off">
					</div>
				</div>
				<div class="form-group qcloud-params-admin" <?php  if($setting[ 'savetype']!=2) { ?>style="display: none;" <?php  } ?>>
					<label class="col-xs-12 col-sm-3 col-md-2 control-label">腾讯云SecretKey</label>
					<div class="col-sm-9">
						<input type="text" name="qcloud[secretkey]" class="form-control" value="<?php  echo $qcloud['secretkey'];?>" autocomplete="off">
						<span class="help-block">不明白请查看帮助手册</span>
					</div>
				</div>
				<div class="form-group qcloud-params-admin" <?php  if($setting[ 'savetype']!=2) { ?>style="display: none;" <?php  } ?>>
					<label class="col-xs-12 col-sm-3 col-md-2 control-label">腾讯云加速域名</label>
					<div class="col-sm-9">
						<input type="text" name="qcloud[url]" class="form-control" value="<?php  echo $qcloud['url'];?>" autocomplete="off">
						<span class="help-block">不带http://，例如：video.haoshu888.com</span>
					</div>
				</div>
				<!-- 腾讯云 End -->
			</div>
		</div>

		<div class="form-group col-sm-12">
			<input type="hidden" name="id" value="<?php  echo $setting['id'];?>" />
			<input type="submit" name="submit" value="保存设置" class="btn btn-primary col-lg-1" />
			<input type="hidden" name="token" value="<?php  echo $_W['token'];?>" />
		</div>
	</form>
</div>
<script type="text/javascript">
	$(function() {
		$(':radio[name="savetype"]').click(function() {
			if($(this).val() == '0') {
				$('.qiniu-params-admin').hide();
				$('.qcloud-params-admin').hide();
			} else if($(this).val() == '1') {
				$('.qiniu-params-admin').show();
				$('.qcloud-params-admin').hide();
			} else if($(this).val() == '2') {
				$('.qiniu-params-admin').hide();
				$('.qcloud-params-admin').show();
			}
		});
	});
</script>
<?php  } ?>

<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/footer', TEMPLATE_INCLUDEPATH)) : (include template('common/footer', TEMPLATE_INCLUDEPATH));?>