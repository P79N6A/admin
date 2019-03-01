<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/header', TEMPLATE_INCLUDEPATH)) : (include template('common/header', TEMPLATE_INCLUDEPATH));?>

<script type='text/javascript' src='resource/js/lib/jquery-1.11.1.min.js'></script>
<script type="text/javascript" src="../addons/wdl_shopping/images/jquery.gcjs.js"></script>
<script type="text/javascript" src="../addons/wdl_shopping/images/jquery.form.js"></script>
<script type="text/javascript" src="../addons/wdl_shopping/images/tooltipbox.js"></script>

<style type="text/css">
	.red {float:left;color:red}
	.white{float:left;color:#fff}
	.tooltipbox {
		background:#fef8dd;border:1px solid #c40808; position:absolute; left:0;top:0; text-align:center;height:20px;
		color:#c40808;padding:2px 5px 1px 5px; border-radius:3px;z-index:1000;
	}
	.red { float:left;color:red}
</style>

<div class="main">
	<form action="" method="post" class="form-horizontal form" enctype="multipart/form-data" id="form1">
		<div class="panel panel-default">
			<div class="panel-heading">
				微商城小程序设置
			</div>
			<div class="panel-body">
				<div class="form-group">
					<label class="col-xs-12 col-sm-3 col-md-2 control-label">选择小程序对接的模块</label>
					<div class="col-sm-9 col-xs-12">
						<label class='radio-inline'><input type="radio" name="wxapp_is" value="0" <?php  if($settings['wxapp_is'] == 0) { ?> checked="true" <?php  } ?>>默认</label>
						<span class="help-block">请选择小程序对接的模块</span>
					</div>
				</div>
			</div>
		</div>
		<div class="panel panel-default">
			<div class="panel-heading">
				提醒设置
			</div>
			<div class="panel-body">
				<div class="form-group">
					<label class="col-xs-12 col-sm-3 col-md-2 control-label">提醒接收邮箱</label>
					<div class="col-sm-9 col-xs-12">
						<input type="text" name="noticeemail" class="form-control" value="<?php  echo $settings['noticeemail'];?>" />
					</div>
				</div>
				<div class="form-group">
					<label class="col-xs-12 col-sm-3 col-md-2 control-label">短信提示号码</label>
					<div class="col-sm-9 col-xs-12">
						<input type="text" name="mobile" class="form-control" value="<?php  echo $settings['mobile'];?>" />
					</div>
				</div>
                <div class="form-group">
					<label class="col-xs-12 col-sm-3 col-md-2 control-label">短信模板ID</label>
					<div class="col-sm-9 col-xs-12">
						<input type="text" name="sms_id" class="form-control" value="<?php  echo $settings['sms_id'];?>" />
                         <div class="help-block">阿里大鱼短息模板ID，可设置变量${phone},${name}</div>
					</div>
				</div>
				<div class="form-group">
					<label class="col-xs-12 col-sm-3 col-md-2 control-label">模板消息提醒</label>
					<div class="col-sm-9 col-xs-12">
						<label class='radio-inline'><input type="radio" name="template" value="1"  <?php  if($settings['template'] == 1) { ?> checked="true" <?php  } ?> onclick="$('#templateid').show();"> 开启</label>
						<label class='radio-inline'><input type="radio" name="template" value="0" <?php  if($settings['template'] == 0) { ?> checked="true" <?php  } ?> onclick="$('#templateid').hide();">关闭</label>
					</div>
				</div>
				<div class="form-group" id="templateid" <?php  if(!$settings['template']) { ?>style="display: none;"<?php  } ?>>
					<label class="col-xs-12 col-sm-3 col-md-2 control-label">粉丝消费模板ID</label>
					<div class="col-sm-9 col-xs-12">
						<input type="text" name="templateid" class="form-control" value="<?php  echo $settings['templateid'];?>" />
						<span class="help-block">请在“微信公众平台”选择行业为：“消费品 - 消费品”，添加标题为：”下单通知“，编号为：“OPENTM207102348”的模板</span>
					</div>
				</div>
			</div>
		</div>
		<div class="panel panel-default">
			<div class="panel-heading">商城信息</div>
			<div class="panel-body">
				<div class="form-group">
					<label class="col-xs-12 col-sm-3 col-md-2 control-label">品牌名称</label>
					<div class="col-sm-9 col-xs-12">
						<input type="text" name="shopname" class="form-control" value="<?php  echo $settings['shopname'];?>" />
					</div>
				</div>
				<div class="form-group">
					<label class="col-xs-12 col-sm-3 col-md-2 control-label">官方网址</label>
					<div class="col-sm-9 col-xs-12">
						<input type="text" name="officialweb" class="form-control" value="<?php  echo $settings['officialweb'];?>" />
					</div>
				</div>
				<div class="form-group">
					<label class="col-xs-12 col-sm-3 col-md-2 control-label">品牌图片</label>
					<div class="col-sm-9 col-xs-12">
						<?php  echo tpl_form_field_image('logo', $settings['logo'])?>
					</div>
				</div>
				<div class="form-group">
					<label class="col-xs-12 col-sm-3 col-md-2 control-label">联系电话</label>
					<div class="col-sm-9 col-xs-12">
						<input type="text" name="phone" class="form-control" value="<?php  echo $settings['phone'];?>" />
					</div>
				</div>
				<div class="form-group">
					<label class="col-xs-12 col-sm-3 col-md-2 control-label">所在地址</label>
					<div class="col-sm-9 col-xs-12">
						<input type="text" name="address" class="form-control" value="<?php  echo $settings['address'];?>" />
					</div>
				</div>
				<div class="form-group">
					<label class="col-xs-12 col-sm-3 col-md-2 control-label">品牌介绍</label>
					<div class="col-sm-9 col-xs-12">
						<textarea name="description" class="form-control richtext" cols="70"><?php  echo $settings['description'];?></textarea>
					</div>
				</div>
			</div>
		</div>
		<div class="form-group col-sm-12">
			<input type="submit" name="submit" value="提交" class="btn btn-primary col-lg-1" />
			<input type="hidden" name="token" value="<?php  echo $_W['token'];?>" />
		</div>
	</form>
</div>

<script language='javascript'>
	require(['jquery', 'util'], function($, u){
		$(function(){
			u.editor($('.richtext')[0]);
		});
	});
</script>

<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/footer', TEMPLATE_INCLUDEPATH)) : (include template('common/footer', TEMPLATE_INCLUDEPATH));?>