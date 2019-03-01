<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('header', TEMPLATE_INCLUDEPATH)) : (include template('header', TEMPLATE_INCLUDEPATH));?>
<?php  if(is_array($company)) { foreach($company as $com) { ?>
<?php  if(count($com['list']) > 0) { ?>
<div class="col-xs-12" style="padding: 0 0 10px;">
	<p><?php  echo $com['name'];?></p>
	<?php  if(is_array($com['list'])) { foreach($com['list'] as $i => $item) { ?>
	<?php  if(count($item) > 0) { ?>
	<table class="table table-bordered" style="float: left;width: 10%;">
		<tr><td colspan="2">共：<?php  echo count($item)?></td></tr>
		<tr><td colspan="2"><?php  echo $i;?><span style="float: right;">总计：<?php  echo number_format($com['total'][$i],2)?></span></td></tr>
		<tr>
			<td>号码</td>
			<td>投注额</td>
		</tr>
		<tr>
			<td colspan="2" style="padding: 0;">
				<div style="overflow-y: auto;max-height: 300px;">
					<table class="table table-bordered">
						<?php  if(is_array($item)) { foreach($item as $it) { ?>
						<?php  if($it['money'] > 0) { ?>
						<tr>
							<td>
								<a href="javascript:void(0);">
									<?php  echo $it['number'];?>
								</a>
							</td>
							<td><a href="javascript:void(0);"><?php  echo number_format($it['money'],2)?></a></td>
						</tr>
						<?php  } ?>
						<?php  } } ?>
					</table>
				</div>
			</td>
		</tr>
	</table>
	<?php  } ?>
	<?php  } } ?>
</div>
<?php  } ?>
<?php  } } ?>
<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('footer', TEMPLATE_INCLUDEPATH)) : (include template('footer', TEMPLATE_INCLUDEPATH));?>