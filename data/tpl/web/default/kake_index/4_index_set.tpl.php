<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/header', TEMPLATE_INCLUDEPATH)) : (include template('common/header', TEMPLATE_INCLUDEPATH));?>
<div class="main">
	<form action="<?php  echo $this->createWebUrl('index_set')?>" method="post" class="form-horizontal form">
		<div class="panel panel-default">
			<div class="panel-heading">
				首页设置
			</div>
			<div class="panel-body">
				<div class="form-group">
					<label class="col-xs-12 col-sm-3 col-md-2 control-label">顶部图片</label>
					<div class="col-sm-9 col-xs-12"><?php  echo tpl_form_field_image('top_img', $setting['top_img'])?></div>
				</div>
				<div class="form-group">
					<label class="col-xs-12 col-sm-3 col-md-2 control-label">简介背景</label>
					<div class="col-sm-9 col-xs-12">
						<?php  echo tpl_form_field_image('info_img', $setting['info_img'])?>
					</div>
				</div>
				<div class="form-group">
					<label class="col-xs-12 col-sm-3 col-md-2 control-label"><span style="color:red">*</span>简介</label>
					<div class="col-sm-9 col-xs-12">
						<textarea class="form-control" cols="70" name="info"><?php  echo $setting['info'];?></textarea>
					</div>
				</div>

				<div class="form-group">
					<label class="col-xs-12 col-sm-3 col-md-2 control-label">授权背景</label>
					<div class="col-sm-9 col-xs-12">
						<?php  echo tpl_form_field_image('protocol_img', $setting['protocol_img'])?>
					</div>
				</div>
				<div class="form-group">
					<label class="col-xs-12 col-sm-3 col-md-2 control-label">授权描述</label>
					<div class="col-sm-9 col-xs-12">
						<textarea name="protocol" class="form-control" cols="70"><?php  echo $setting['protocol'];?></textarea>
					</div>
				</div>
			</div>
		</div>
		<div class="form-group col-sm-12">
			<input type="submit" name="submit" value="保存" class="btn btn-primary col-lg-1" />
			<input type="hidden" name="token" value="<?php  echo $_W['token'];?>" />
		</div>
	</form>
</div>



<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/footer', TEMPLATE_INCLUDEPATH)) : (include template('common/footer', TEMPLATE_INCLUDEPATH));?>