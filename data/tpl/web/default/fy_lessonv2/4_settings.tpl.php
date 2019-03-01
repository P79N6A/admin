<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/header', TEMPLATE_INCLUDEPATH)) : (include template('common/header', TEMPLATE_INCLUDEPATH));?>
<style type="text/css">
.red{color:red;}
</style>
<div class="main">
	<form action="" method="post" class="form-horizontal form" enctype="multipart/form-data">
        <div class="panel panel-default">
            <div class="panel-heading">参数设置  <span class="red">[以下所有参数不修改的选项请留空]</span></div>
            <div class="panel-body">
				<div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">[立即购买]名称</label>
                    <div class="col-sm-9">
                        <input type="text" name="buynow_name" value="<?php  echo $settings['buynow_name'];?>" class="form-control">
						<span class="help-block">课程详情页右下角“立即购买”自定义名称</span>
                    </div>
                </div>
				<div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">[分销中心]名称</label>
                    <div class="col-sm-9">
                        <input type="text" name="share_name" value="<?php  echo $settings['share_name'];?>" class="form-control">
						<span class="help-block">个人中心里面的“分销中心”自定义名称</span>
                    </div>
                </div>
				<div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">个人中心背景图</label>
                    <div class="col-sm-9">
						<?php  echo tpl_form_field_image('ucenter_bg', $settings['ucenter_bg']);?>
						<span class="help-block">建议尺寸 534px * 300px，JPG格式</span>
                    </div>
                </div>
				<div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">讲师主页背景图</label>
                    <div class="col-sm-9">
						<?php  echo tpl_form_field_image('teacher_bg', $settings['teacher_bg']);?>
						<span class="help-block">建议尺寸 500px * 220px，JPG格式</span>
                    </div>
                </div>
				<div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">手机端首页底部图片</label>
                    <div class="col-sm-9">
						<?php  echo tpl_form_field_image('index_slogan', $settings['index_slogan']);?>
						<span class="help-block">建议尺寸 750px * 26px，PNG格式</span>
                    </div>
                </div>
				<div class="form-group hide">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">导航栏<span class="red">[首页]</span>名称</label>
                    <div class="col-sm-9">
                        <input type="text" name="index_name" value="<?php  echo $settings['index_name'];?>" class="form-control">
						<span class="help-block">底下导航栏“首页”的名称</span>
                    </div>
                </div>
				<div class="form-group hide">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">导航栏<span class="red">[首页]</span>链接</label>
                    <div class="col-sm-9">
                        <input type="text" name="index_link" value="<?php  echo $settings['index_link'];?>" class="form-control">
						<span class="help-block">【不修改链接请留空】底下导航栏“首页”的链接，请填写完整url链接，包括http://开头</span>
                    </div>
                </div>
				<div class="form-group hide">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">导航栏<span class="red">[首页]</span>图标</label>
                    <div class="col-sm-9">
						<?php  echo tpl_form_field_image('index_icon', $settings['index_icon']);?>
						<span class="help-block">建议尺寸64px * 64px大小的透明png图片</span>
                    </div>
                </div>

				<div class="form-group hide">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">导航栏<span class="red">[搜索]</span>名称</label>
                    <div class="col-sm-9">
                        <input type="text" name="search_name" value="<?php  echo $settings['search_name'];?>" class="form-control">
						<span class="help-block">底下导航栏“搜索”的名称</span>
                    </div>
                </div>
				<div class="form-group hide">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">导航栏<span class="red">[搜索]</span>链接</label>
                    <div class="col-sm-9">
                        <input type="text" name="search_link" value="<?php  echo $settings['search_link'];?>" class="form-control">
						<span class="help-block">【不修改链接请留空】底下导航栏“搜索”的链接，请填写完整url链接，包括http://开头</span>
                    </div>
                </div>
				<div class="form-group hide">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">导航栏<span class="red">[搜索]</span>图标</label>
                    <div class="col-sm-9">
						<?php  echo tpl_form_field_image('search_icon', $settings['search_icon']);?>
						<span class="help-block">建议尺寸64px * 64px大小的透明png图片</span>
                    </div>
                </div>

				<div class="form-group hide">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">导航栏<span class="red">[讲师列表]</span>名称</label>
                    <div class="col-sm-9">
                        <input type="text" name="teacher_name" value="<?php  echo $settings['teacher_name'];?>" class="form-control">
						<span class="help-block">底下导航栏“讲师列表”的名称</span>
                    </div>
                </div>
				<div class="form-group hide">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">导航栏<span class="red">[讲师列表]</span>链接</label>
                    <div class="col-sm-9">
                        <input type="text" name="teacher_link" value="<?php  echo $settings['teacher_link'];?>" class="form-control">
						<span class="help-block">【不修改链接请留空】底下导航栏“讲师列表”的链接，请填写完整url链接，包括http://开头</span>
                    </div>
                </div>
				<div class="form-group hide">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">导航栏<span class="red">[讲师列表]</span>图标</label>
                    <div class="col-sm-9">
						<?php  echo tpl_form_field_image('teacher_icon', $settings['teacher_icon']);?>
						<span class="help-block">建议尺寸64px * 64px大小的透明png图片</span>
                    </div>
                </div>

				<div class="form-group hide">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">导航栏<span class="red">[我的课程]</span>名称</label>
                    <div class="col-sm-9">
                        <input type="text" name="lesson_name" value="<?php  echo $settings['lesson_name'];?>" class="form-control">
						<span class="help-block">底下导航栏“我的课程”的名称</span>
                    </div>
                </div>
				<div class="form-group hide">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">导航栏<span class="red">[我的课程]</span>链接</label>
                    <div class="col-sm-9">
                        <input type="text" name="lesson_link" value="<?php  echo $settings['lesson_link'];?>" class="form-control">
						<span class="help-block">【不修改链接请留空】底下导航栏“我的课程”的链接，请填写完整url链接，包括http://开头</span>
                    </div>
                </div>
				<div class="form-group hide">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">导航栏<span class="red">[我的课程]</span>图标</label>
                    <div class="col-sm-9">
						<?php  echo tpl_form_field_image('lesson_icon', $settings['lesson_icon']);?>
						<span class="help-block">建议尺寸64px * 64px大小的透明png图片</span>
                    </div>
                </div>

				<div class="form-group hide">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">导航栏<span class="red">[个人中心]</span>名称</label>
                    <div class="col-sm-9">
                        <input type="text" name="self_name" value="<?php  echo $settings['self_name'];?>" class="form-control">
						<span class="help-block">底下导航栏“个人中心”的名称</span>
                    </div>
                </div>
				<div class="form-group hide">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">导航栏<span class="red">[个人中心]</span>链接</label>
                    <div class="col-sm-9">
                        <input type="text" name="self_link" value="<?php  echo $settings['self_link'];?>" class="form-control">
						<span class="help-block">【不修改链接请留空】底下导航栏“个人中心”的链接，请填写完整url链接，包括http://开头</span>
                    </div>
                </div>
				<div class="form-group hide">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">导航栏<span class="red">[个人中心]</span>图标</label>
                    <div class="col-sm-9">
						<?php  echo tpl_form_field_image('self_icon', $settings['self_icon']);?>
						<span class="help-block">建议尺寸64px * 64px大小的透明png图片</span>
                    </div>
                </div>

            </div>
        </div>

        <div class="form-group col-sm-12">
            <input type="submit" name="submit" value="保存设置" class="btn btn-primary col-lg-1" />
            <input type="hidden" name="token" value="<?php  echo $_W['token'];?>" />
        </div>
	</form>
</div>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/footer', TEMPLATE_INCLUDEPATH)) : (include template('common/footer', TEMPLATE_INCLUDEPATH));?>