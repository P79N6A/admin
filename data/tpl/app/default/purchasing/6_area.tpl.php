<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('header', TEMPLATE_INCLUDEPATH)) : (include template('header', TEMPLATE_INCLUDEPATH));?>
<style>
	.recharge-area{position: fixed;width: 100%;height: 100%;top: 0;left: 0;background: rgba(0,0,0,0.4);display: none;}
	.recharge-main{width: 50%;height: 20vw;margin: 5% auto;background: #fff;}
	.recharge-head{width: 100%;text-align: center;border-bottom: 1px solid #aaa;font-size: 20px;line-height: 30px;}
	.recharge-body{width: 100%;padding: 2vw 3vw;}
	.recharge-body table tbody tr td input{width: 80%;border: 0;}
	.btn{border: 1px solid #3e3e3e;background-color: #3e3e3e;border-radius: 20px;color: #fff;padding: 3px 7px;}
	a:hover{text-indent: none;}
	.btn:hover{background: #fff;color: #333}
</style>
<div class="col-xs-12">
	<div class="col-xs-12" style="padding: 5px 0;">
		<input type="button" name="create" value="增加盘口" class="btn" onclick="area_show()">
	</div>
	<table class="table table-bordered">
		<tr>
			<td>盘口名称</td>
			<td>增加时间</td>
			<td>最后修改时间</td>
			<td>操作</td>
		</tr>
		<?php  if(is_array($list)) { foreach($list as $item) { ?>
		<tr>
			<td><?php  echo $item['area_name'];?></td>
			<td><?php  echo date('Y-m-d H:i',$item['createtime'])?></td>
			<td><?php  if($item['edittime'] > 0) { ?><?php  echo date('Y-m-d H:i:s',$item['edittime'])?><?php  } else { ?>没有修改过<?php  } ?></td>
			<td>
				<input type="hidden" name="name" value="<?php  echo $item['area_name'];?>" id="name<?php  echo $item['id'];?>">
				<input type="hidden" name="mac" value="<?php  echo $item['mac'];?>" id="mac<?php  echo $item['id'];?>">
				<input type="hidden" name="moac" value="<?php  echo $item['moac'];?>" id="moac<?php  echo $item['id'];?>">
				<input type="hidden" name="aac" value="<?php  echo $item['aac'];?>" id="aac<?php  echo $item['id'];?>">
				<a href="javascript:void(0);" class="btn" onclick="area_show(<?php  echo $item['id'];?>)">修改</a>
			</td>
		</tr>
		<?php  } } ?>
	</table>
</div>
<div id="set-area" class="recharge-area">
	<div class="recharge-main">
		<div class="recharge-head">
			盘口设置
		</div>
		<div class="recharge-body">
			<table class="table table-bordered">
				<tr>
					<td>名称</td>
					<td>
						<input type="text" name="area_name" value="">
					</td>
				</tr>
				<tr>
					<td>manager1</td>
					<td>
						账号：<input type="text" name="account" value="" id="manager_account" style="width: 40%;border-bottom: 1px solid #aaa;">
						密码：<input type="text" name="password" value="" id="manager_password" style="width: 40%;border-bottom: 1px solid #aaa;">
					</td>
				</tr>
				<tr>
					<td>manager2</td>
					<td>
						账号：<input type="text" name="account" value="" id="money_account" style="width: 40%;border-bottom: 1px solid #aaa;">
						密码：<input type="text" name="password" value="" id="money_password" style="width: 40%;border-bottom: 1px solid #aaa;">
					</td>
				</tr>
				<tr>
					<td>manager3</td>
					<td>
						账号：<input type="text" name="account" value="" id="agent_account" style="width: 40%;border-bottom: 1px solid #aaa;">
						密码：<input type="text" name="password" value="" id="agent_password" style="width: 40%;border-bottom: 1px solid #aaa;">
					</td>
				</tr>
				<tr>
					<td colspan="2">
						<input type="hidden" name="id" id="area_id">
						<a href="javascript:void(0);" class="btn" onclick="edit_post()">提交</a>
						<a href="javascript:void(0);" class="btn" onclick="$('#set-area').hide();">取消</a>
					</td>
				</tr>
			</table>
		</div>
	</div>
</div>
<script type="text/javascript">
	function area_show(id) {
		if (id > 0) {
			var name = $('#name'+id).val();
			var manager_account = $('#mac'+id).val();
			var money_account = $('#moac'+id).val();
			var agent_account = $('#aac'+id).val();
			$('#area_id').val(id);
		}
		$('#manager_account').val(manager_account);
		$('#money_account').val(money_account);
		$('#agent_account').val(agent_account);
		$('input[name=area_name]').val(name);
		$('#set-area').show();
	}
	function edit_post() {
		var name = $('input[name=area_name]').val();
		var id = $('#area_id').val();
		var manager_account = $('#manager_account').val();
		var manager_password = $('#manager_password').val();
		var money_account = $('#money_account').val();
		var money_password = $('#money_password').val();
		var agent_account = $('#agent_account').val();
		var agent_password = $('#agent_password').val();
		if (!name || name=="") {
			alert('请输入盘口名称');
		}
		if (!name || name=="") {
			alert('请输入公司名称');
			return false;
		}
		if (!manager_account || manager_account=="") {
			alert('请设置管理员');
			return false;
		}
		if (!money_account || money_account=="") {
			alert('请设置财务员');
			return false;
		}
		if (!agent_account || agent_account=="") {
			alert('请设置总代');
			return false;
		}
		$.post("<?php  echo $this->createMobileUrl('set_area')?>",{id:id,name:name,manager_account:manager_account,manager_password:manager_password,money_account:money_account,money_password:money_password,agent_account:agent_account,agent_password:agent_password},function(result) {
			alert(result.info);
			if (result.status == 1) {
				window.location.reload();
			}
		},'JSON');
	}
</script>
<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('footer', TEMPLATE_INCLUDEPATH)) : (include template('footer', TEMPLATE_INCLUDEPATH));?>