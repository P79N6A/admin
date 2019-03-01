<?php defined('IN_IA') or exit('Access Denied');?>			</div>
		</div>
	</div>
</div>
<!-- 3 div--><!-- 9 -->
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('footer_base', TEMPLATE_INCLUDEPATH)) : (include template('footer_base', TEMPLATE_INCLUDEPATH));?>
