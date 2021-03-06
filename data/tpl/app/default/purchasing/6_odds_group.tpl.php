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
		<button class="btn" type="button" onclick="edit(0)">增加分组</button>
	</div>
	<table class="table">
		<tr>
			<td>ID</td>
			<td>分组名</td>
			<td>操作</td>
		</tr>
		<?php  if(is_array($list)) { foreach($list as $item) { ?>
		<tr>
			<td><?php  echo $item['id'];?></td>
			<td><?php  echo $item['group_name'];?></td>
			<td>
				<input type="hidden" id="name_<?php  echo $item['id'];?>" value="<?php  echo $item['group_name'];?>">
				<button class="btn" type="button" onclick="edit(<?php  echo $item['id'];?>);">修改</button>
				<button class="btn" type="button" onclick="del(<?php  echo $item['id'];?>)">删除</button>
			</td>
		</tr>
		<?php  } } ?>
		<?php  echo $pager;?>
	</table>
</div>
<div id="cashback-area" class="recharge-area">
	<div class="recharge-main" style="height: auto;">
		<div class="recharge-head">
			分组设置
		</div>
		<div class="recharge-body" style="padding: 5px;">
			<table class="table">
				<tr>
					<td style="text-align: right;width: 100px;">分组名：</td>
					<td>
						<input type="text" name="group_name" value="" style="width: 200px;border: 1px solid #ccc;">
					</td>
				</tr>
				<tr>
					<td colspan="2">
						<input type="hidden" name="id" id="id">
						<a href="javascript:void(0);" class="btn" onclick="post()">提交</a>
						<a href="javascript:void(0);" class="btn" onclick="$('#cashback-area').hide();">取消</a>
					</td>
				</tr>
			</table>
		</div>
	</div>
</div>
<script type="text/javascript">
	function edit(id) {
		var name = $('#name_'+id).val();
		$('input[name=group_name]').val(name);
		$('#id').val(id);
		$('.recharge-area').show();
	}
	function post() {
		var id = $('#id').val();
		var name = $('input[name=group_name]').val();
		$.post("<?php  echo $this->createMobileUrl('odds',array('op'=>'group_post'))?>",{id:id,name:name},function(result) {
			alert(result.info);
			if (result.status == 3) {
				location.href = "<?php  echo $this->createMobileUrl('login')?>";
			}
			if (result.status == 1) {
				window.location.reload();
			}
		},'JSON');
	}
	function del(id) {
		var checked = confirm("分组删除后该分组所有配套将归为未分组,确定删除吗？");
		if (checked == true) {
			$.post("<?php  echo $this->createMobileUrl('odds',array('op'=>'group_del'))?>",{id:id},function(result) {
				alert(result.info);
				if (result.status == 3) {
					location.href = "<?php  echo $this->createMobileUrl('login')?>";
				}
				if (result.status == 1) {
					window.location.reload();
				}
			},'JSON');
		}
	}
</script>
<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('footer', TEMPLATE_INCLUDEPATH)) : (include template('footer', TEMPLATE_INCLUDEPATH));?>