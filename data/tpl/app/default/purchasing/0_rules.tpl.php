<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('header', TEMPLATE_INCLUDEPATH)) : (include template('header', TEMPLATE_INCLUDEPATH));?>
<style type="text/css" media="screen">
	.recharge-area{position: fixed;width: 100%;height: 100%;top: 0;left: 0;background: rgba(0,0,0,0.4);display: none;}
	.recharge-main{width: 50%;height: 10vw;margin: 5% auto;background: #fff;}
	.recharge-head{width: 100%;text-align: center;border-bottom: 1px solid #aaa;font-size: 20px;line-height: 30px;}
	.recharge-body{width: 100%;padding: 2vw 3vw;}
	.recharge-body table tbody tr td input[type=text]{width: 80%;border: 0;}
	.btn{border: 1px solid #3e3e3e;background-color: #3e3e3e;border-radius: 20px;color: #fff;padding: 3px 7px;}
	a:hover{text-indent: none;}
	.btn:hover{background: #fff;color: #333}
</style>
<div class="col-xs-12">
	<div class="col-xs-12" style="padding: 6px 0;">
		<button class="btn" type="button" onclick="$('#rule-set').show();">添加玩法</button>
	</div>
	<table class="table">
		<tr>
			<td>ID</td>
			<td>标题</td>
			<td>内容</td>
			<td>操作</td>
		</tr>
		<?php  if(is_array($rules)) { foreach($rules as $r) { ?>
		<tr>
			<td><?php  echo $r['id'];?></td>
			<td><?php  echo $r['title'];?></td>
			<td><?php  echo $r['content'];?></td>
			<td>
				<a href="javascript:void(0);" class="btn" onclick="del(<?php  echo $r['id'];?>)">删除</a>
			</td>
		</tr>
		<?php  } } ?>
	</table>
	<?php  echo $pager;?>
</div>
<?php  $bet = array('B','S','A','C2','C3','C4','C5','EC','3ABC','4A','4B','4C','4D','4E','EA','4ABC','2A','2B','2C','2D','2E','EX','2ABC')?>
<div id="rule-set" class="recharge-area">
	<div class="recharge-main" style="height: 25vw;width: 95%;overflow-y: auto;">
		<div class="recharge-head">
			设置玩法
		</div>
		<div class="recharge-body" style="padding: 10px 15px;">
			<table class="table table-bordered">
				<tr>
					<td style="width: 70px;">标题</td>
					<td colspan="7">
						<input type="text" name="title" value="">
					</td>
				</tr>
				<tr>
					<td>内容</td>
					<td>
						<select name="content">
							<option value=""></option>
							<?php  if(is_array($bet)) { foreach($bet as $b) { ?>
							<option value="<?php  echo $b;?>"><?php  echo $b;?></option>
							<?php  } } ?>
						</select>
					</td>
					<td>
						<select name="content">
							<option value=""></option>
							<?php  if(is_array($bet)) { foreach($bet as $b) { ?>
							<option value="<?php  echo $b;?>"><?php  echo $b;?></option>
							<?php  } } ?>
						</select>
					</td>
					<td>
						<select name="content">
							<option value=""></option>
							<?php  if(is_array($bet)) { foreach($bet as $b) { ?>
							<option value="<?php  echo $b;?>"><?php  echo $b;?></option>
							<?php  } } ?>
						</select>
					</td>
					<td>
						<select name="content">
							<option value=""></option>
							<?php  if(is_array($bet)) { foreach($bet as $b) { ?>
							<option value="<?php  echo $b;?>"><?php  echo $b;?></option>
							<?php  } } ?>
						</select>
					</td>
					<td>
						<select name="content">
							<option value=""></option>
							<?php  if(is_array($bet)) { foreach($bet as $b) { ?>
							<option value="<?php  echo $b;?>"><?php  echo $b;?></option>
							<?php  } } ?>
						</select>
					</td>
					<td>
						<select name="content">
							<option value=""></option>
							<?php  if(is_array($bet)) { foreach($bet as $b) { ?>
							<option value="<?php  echo $b;?>"><?php  echo $b;?></option>
							<?php  } } ?>
						</select>
					</td>
					<td>
						<select name="content">
							<option value=""></option>
							<?php  if(is_array($bet)) { foreach($bet as $b) { ?>
							<option value="<?php  echo $b;?>"><?php  echo $b;?></option>
							<?php  } } ?>
						</select>
					</td>
				</tr>
				<tr>
					<td colspan="8">
						<input type="hidden" name="id" id="odds_id">
						<a href="javascript:void(0);" class="btn" onclick="rule_post()">提交</a>
						<a href="javascript:void(0);" class="btn" onclick="$('#rule-set').hide();">取消</a>
					</td>
				</tr>
			</table>
		</div>
	</div>
</div>
<script type="text/javascript">
	function rule_post() {
		var content = [];
		var title = $('input[name=title]').val();
		$('select[name=content]').each(function() {
			content.push($(this).val());
		})
		$.post("<?php  echo $this->createMobileUrl('set_rule',array('op'=>'post'))?>",{title:title,content:content},function(result) {
			alert(result.info);
			if (result.status == 3) {
				window.location.href = "<?php  echo $this->createMobileUrl('login')?>";
			}
			if (result.status == 1) {
				window.location.reload();
			}
		},'JSON');
	}
</script>