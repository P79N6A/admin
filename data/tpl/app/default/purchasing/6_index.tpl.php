<?php defined('IN_IA') or exit('Access Denied');?><style>
	.nav-bar{bottom: 0;display: table;width: 100%;height: 16%;padding:0;box-shadow: 0 0 1px rgba(0, 0, 0, .85);}
	.nav-bar-item{display: table-cell;overflow: hidden;text-align: center;;text-overflow: ellipsis;color: #929292;}  
	.mui-icon{position: relative;font-family: Muiicons;top: 3px;width: 24px;height: 24px;padding-top: 0;padding-bottom: 0;font-weight: 400;display: inline-block;}
	.nav-bar-label{font-size: 12px;display: block;overflow: hidden;text-align: center; }
</style>
<div class="index-ui" style="position: fixed;width: 100%;bottom: 0;background: #fff;">
	<div id="app">
		<nav class="nav-bar">
			<a id="home" class="nav-bar-item" href="<?php  echo $this->createMobileUrl('home')?>">
				<span class="mui-icon <?php  if($_GPC['do'] == 'home') { ?>mui-icon-home-filled<?php  } else { ?>mui-icon-home<?php  } ?>"></span>
				<span class="nav-bar-label">首页</span>
			</a>
			<a id="mine" href="<?php  echo $this->createMobileUrl('mine')?>" class="nav-bar-item">
				<span class="mui-icon <?php  if($_GPC['do'] == 'mine') { ?>mui-icon-person-filled<?php  } else { ?>mui-icon-person<?php  } ?>"></span>
				<span class="nav-bar-label">我的</span>
			</a>
		</nav>
	</div>
</div>