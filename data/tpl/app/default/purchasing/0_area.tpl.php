<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('header', TEMPLATE_INCLUDEPATH)) : (include template('header', TEMPLATE_INCLUDEPATH));?>
<style>
	.recharge-area{position: fixed;width: 100%;height: 100%;top: 0;left: 0;background: rgba(0,0,0,0.4);display: none;}
	.recharge-main{width: 50%;height: 10vw;margin: 5% auto;background: #fff;}
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
			$('#area_id').val(id);
		}
		$('input[name=area_name]').val(name);
		$('#set-area').show();
	}
	function edit_post() {
		var name = $('input[name=area_name]').val();
		var id = $('#area_id').val();
		if (!name || name=="") {
			alert('请输入盘口名称');
		}
		$.post("<?php  echo $this->createMobileUrl('set_area')?>",{id:id,name:name},function(result) {
			alert(result.info);
			if (result.status == 1) {
				window.location.reload();
			}
		},'JSON');
	}
</script>