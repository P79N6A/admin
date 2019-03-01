<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('common/myheader', TEMPLATE_INCLUDEPATH)) : (include template('common/myheader', TEMPLATE_INCLUDEPATH));?>
		 
	<?php  if($_GPC['op'] == 'index') { ?>
		<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('temp/index/index', TEMPLATE_INCLUDEPATH)) : (include template('temp/index/index', TEMPLATE_INCLUDEPATH));?>
		
	<?php  } else if($_GPC['op'] == 'sort') { ?>
		<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('temp/index/sort', TEMPLATE_INCLUDEPATH)) : (include template('temp/index/sort', TEMPLATE_INCLUDEPATH));?>
		
	<?php  } ?>
	

	
	
<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('common/myfooter', TEMPLATE_INCLUDEPATH)) : (include template('common/myfooter', TEMPLATE_INCLUDEPATH));?>