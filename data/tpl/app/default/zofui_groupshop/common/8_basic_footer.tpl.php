<?php defined('IN_IA') or exit('Access Denied');?>			
		<script src="../addons/zofui_groupshop/public/js/lib/Fx.js"></script>
		<script src="../addons/zofui_groupshop/public/js/app/config.js"></script>
		<?php  if(in_array($_GPC['do'],array('good'))) { ?>
			<script>$.config = {router: false};//商品刷新后返回空白</script>
		<?php  } ?>
		<script src="../addons/zofui_groupshop/public/js/lib/sm.min.js"></script>
		<script src="../addons/zofui_groupshop/public/js/lib/sm-extend-min.js"></script>
		<script src="../addons/zofui_groupshop/public/js/app/common.js"></script>
		<script src="../addons/zofui_groupshop/public/js/app/weixinJs.js"></script>
		<script src="../addons/zofui_groupshop/public/js/app/fShopJs.js"></script>
		<?php  if($_GPC['op'] == 'index') { ?>
			<script src="../addons/zofui_groupshop/public/js/app/index.js"></script>
		<?php  } ?>		
	</body>
</html>