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
<?php  if($tab == 'display') { ?>
<div class="col-xs-12">
	<div class="col-xs-12" style="padding: 5px 0;">
		<a href="<?php  echo $this->createMobileUrl('manager',array('op'=>'limit','tab'=>'create'))?>" class="btn">添加控制</a>
	</div>
	<table class="table table-bordered">
		<tr>
			<td></td>
			<?php  if($_SESSION['level'] == 1) { ?>
			<td>盘口</td>
			<?php  } ?>
			<td>标题</td>
			<td>创建时间</td>
			<td>修改时间</td>
		</tr>
		<?php  if(is_array($list)) { foreach($list as $item) { ?>
		<tr>
			<td>
				<a href="<?php  echo $this->createMobileUrl('manager',array('op'=>'limit','tab'=>'edit','id'=>$item['id']))?>">更改</a>|
				<a href="<?php  echo $this->createMobileUrl('manager',array('op'=>'limit','tab'=>'detail','id'=>$item['id']))?>">查看</a>
			</td>
			<?php  if($_SESSION['level'] == 1) { ?>
			<td><?php  echo $item['area_name'];?></td>
			<?php  } ?>
			<td><?php  echo $item['title'];?></td>
			<td><?php  echo date('Y-m-d H:i:s',$item['createtime'])?></td>
			<td><?php  echo date('Y-m-d H:i:s',$item['edittime'])?></td>
		</tr>
		<?php  } } ?>
	</table>
</div>
<?php  } else if($tab == 'edit' || $tab == 'create') { ?>
<div class="col-xs-12">
	<div class="col-xs-12" style="padding: 5px 0;">
		<a href="<?php  echo $this->createMobileUrl('manager',array('op'=>'limit'))?>" class="btn">管理</a>
	</div>
	<form action="<?php  echo $this->createMobileUrl('limit',array('op'=>'post'))?>" method="post">
		<div class="col-xs-12" style="padding: 0 0 5px;">
			标题：<input type="text" name="title" value="<?php  echo $limit['title'];?>">
			<?php  if($_SESSION['level'] == 1) { ?>
			盘口：
			<select name="cid">
				<?php  if(is_array($area)) { foreach($area as $a) { ?>
				<option value="<?php  echo $a['id'];?>" <?php  if($limit['cid'] == $a['id']) { ?>selected="selected"<?php  } ?>><?php  echo $a['area_name'];?></option>
				<?php  } } ?>
			</select>
			<?php  } ?>
			<br>
			<label>
				<input type="checkbox" name="same" value="1">
				All same
			</label>
		</div>
		<table class="table table-bordered">
			<?php  if(is_array($company)) { foreach($company as $item) { ?>
			<tr>
				<td colspan="26"><?php  echo $item['nickname'];?></td>
			</tr>
			<tr>
				<td>
				</td>
				<?php  if(is_array($beto)) { foreach($beto as $bet) { ?>
				<td><?php  echo $bet;?></td>
				<?php  } } ?>
			</tr>
			<tr>
				<td>
					<label style="width: 80px;">
						全部一样
						<input type="checkbox" name="line_same" value="1" id="same_<?php  echo $item['id'];?>">
					</label>
				</td>
				<?php  if(is_array($beto)) { foreach($beto as $b) { ?>
				<td><input type="text" name="limit[<?php  echo $item['id'];?>][<?php  echo $b;?>]" value="<?php  echo $item[$b];?>" class="limit_<?php  echo $item['id'];?> limit" data-value="<?php  echo $item['id'];?>" style="width: 80px;"></td>
				<?php  } } ?>
			</tr>
			<?php  } } ?>
		</table>
		<input type="hidden" name="id" value="<?php  echo $limit['id'];?>">
		<input type="submit" name="submit" value="提交" class="btn">
	</form>
</div>
<script type="text/javascript">
	$('.limit').on('keyup',function() {
		var id = $(this).attr('data-value');
		var checked = $('#same_'+id).is(':checked');
		if (checked == true) {
			$('.limit_'+id).val($(this).val());
		}
	})
</script>
<?php  } else if($tab == detail) { ?>
<div class="col-xs-12">
	<div class="col-xs-12" style="padding: 5px 0;">
		<a href="<?php  echo $this->createMobileUrl('manager',array('op'=>'limit','tab'=>'create'))?>" class="btn">创建</a>
		<a href="<?php  echo $this->createMobileUrl('manager',array('op'=>'limit','tab'=>'edit','id'=>$limit['id']))?>" class="btn">修改</a>
		<a href="javascript:void(0);" class="btn" onclick="del(<?php  echo $limit['id'];?>)">删除</a>
		<a href="<?php  echo $this->createMobileUrl('manager',array('op'=>'limit'))?>" class="btn">管理</a>
	</div>
	<div class="col-xs-12" style="padding: 0;">
		标题：<?php  echo $limit['title'];?><br>
		创建时间：<?php  echo date('Y-m-d H:i:s',$limit['createtime'])?><br>
		修改时间：<?php  echo date('Y-m-d H:i:s',$limit['edittime'])?>
	</div>
	<table class="table">
		<?php  if(is_array($company)) { foreach($company as $item) { ?>
		<tr>
			<td colspan="23"><?php  echo $item['nickname'];?></td>
		</tr>
		<tr>
			<?php  if(is_array($beto)) { foreach($beto as $bet) { ?>
			<td><?php  echo $bet;?></td>
			<?php  } } ?>
		</tr>
		<tr>
			<?php  if(is_array($beto)) { foreach($beto as $b) { ?>
			<td><?php  echo $item[$b];?></td>
			<?php  } } ?>
		</tr>
		<?php  } } ?>
	</table>
</div>
<script type="text/javascript">
	function del(id) {
		var checked = confirm('确定删除该配套？');
		if (checked == true) {
			$.post("<?php  echo $this->createMobileUrl('limit',array('op'=>'del'))?>",{id:id},function(result) {
				alert(result.message);
				location.href = result.redirect;
			},'JSON');
		}
	}
</script>
<?php  } else if($tab == 'time') { ?>
<div class="col-xs-12">
	<div class="col-xs-12" style="padding: 5px 0;">
		危险时间
	</div>
	<form action="<?php  echo $this->createMobileUrl('limit',array('op'=>'time_post'))?>" method="post">
		<button type="button" class="btn" onclick="add_time();">添加</button>
		<table class="table table-bordered">
			<tr>
				<?php  if($_SESSION['level'] == 1) { ?>
				<td>盘口</td>
				<?php  } ?>
				<td>时间</td>
				<td>配套</td>
			</tr>
			<?php  if(is_array($list)) { foreach($list as $key => $item) { ?>
			<tr>
				<?php  if($_SESSION['level'] == 1) { ?>
				<td>
					<select name="limit[<?php  echo $key;?>][cid]">
						<?php  if(is_array($area)) { foreach($area as $a) { ?>
						<option value="<?php  echo $a['ic'];?>" <?php  if($item['cid'] == $a['id']) { ?>selected="selected"<?php  } ?>><?php  echo $a['area_name'];?></option>
						<?php  } } ?>
					</select>
				</td>
				<?php  } ?>
				<td>
					<input type="time" name="limit[<?php  echo $key;?>][time]" value="<?php  echo date('H:i',$item['time'])?>">
				</td>
				<td>
					<select name="limit[<?php  echo $key;?>][limit]">
						<?php  if(is_array($limit)) { foreach($limit as $li) { ?>
						<option value="<?php  echo $li['id'];?>" <?php  if($item['limit'] == $li['id']) { ?>selected="selected"<?php  } ?>><?php  echo $li['title'];?></option>
						<?php  } } ?>
					</select>
				</td>
			</tr>
			<?php  } } ?>
		</table>
		<input type="submit" name="submit" value="提交" class="btn">
	</form>
</div>
<script type="text/javascript">
	var number = parseInt("<?php  echo count($list);?>");
	function add_time() {
		$.post("<?php  echo $this->createMobileUrl('limit',array('op'=>'get_limit'))?>",{},function(result) {
			var level = parseInt("<?php  echo $_SESSION['level'];?>");
			var list = result.list;
			var area = result.area;
			var txt = '<tr>';
				if (level == 1) {
					txt += '<td>';
					txt += '<select name="limit['+number+'][cid]">';
					for (var j=0 in area) {
						txt += '<option value="'+area[j].id+'">'+area[j].area_name+'</option>';
					}
					txt += '</select>';
					txt += '</td>';
				}
				txt += '<td><input type="time" name="limit['+number+'][time]"></td>';
				txt += '<td>';
				txt += '<select name="limit['+number+'][limit]">';
				for (var i = 0 in list) {
					txt += '<option value="'+list[i].id+'">'+list[i].title+'</option>';
				}
				txt += '</select></td></tr>';
			$('table').append(txt);
			number++;
		},'JSON');
	}
</script>
<?php  } else if($tab == 'red') { ?>
<style type="text/css">
	table td{text-align: center;}
</style>
<table class="table">
	<tr>
		<td>操作</td>
		<td>红字控制</td>
	</tr>
	<tr>
		<td>
			<a href="<?php  echo $this->createMobileUrl('manager',array('op'=>'limit','tab'=>'red_detail','type'=>1))?>">查看</a>|
			<a href="<?php  echo $this->createMobileUrl('manager',array('op'=>'limit','tab'=>'red_edit','type'=>1))?>">修改</a>
		</td>
		<td>
			<table class="table">
				<tr>
					<td style="border: 0;">
						<button class="btn" type="button" onclick="del(1);">删除</button>
					</td>
					<td style="border: 0;">号码</td>
					<td style="border: 0;">创建时间</td>
					<td style="border: 0;">类型</td>
				</tr>
				<?php  if(is_array($sample)) { foreach($sample as $item) { ?>
				<tr>
					<td style="border: 0;">
						<input type="checkbox" name="sample_id" value="<?php  echo $item['id'];?>">
					</td>
					<td style="border: 0;">
						<?php  echo $item['number'];?>
					</td>
					<td style="border: 0;">
						<?php  echo date('Y-m-d H:i:s',$item['createtime'])?>
					</td>
					<td style="border: 0;">
						<?php  if($item['mode'] == 0) { ?>
						----
						<?php  } else if($item['mode'] == 1 || $item['mode'] == 2) { ?>
						{<?php  echo $item['number'];?>}
						<?php  } else if($item['mode'] == 3) { ?>
						{0~9}<?php  echo substr($item['number'],1)?>
						<?php  } else if($item['mode'] == 4) { ?>
						<?php  echo substr($item['number'],0,strlen($item['number'])-1)?>
						<?php  } ?>
					</td>
				</tr>
				<?php  } } ?>
			</table>
		</td>
	</tr>
	<tr>
		<td>
			<a href="<?php  echo $this->createMobileUrl('manager',array('op'=>'limit','tab'=>'red_detail','type'=>2))?>">查看</a>|
			<a href="<?php  echo $this->createMobileUrl('manager',array('op'=>'limit','tab'=>'red_edit','type'=>2))?>">修改</a>
		</td>
		<td>
			<table class="table">
				<tr>
					<td style="border: 0;">
						<button class="btn" type="button" onclick="del(2)">删除</button>
					</td>
					<td style="border: 0;">号码</td>
					<td style="border: 0;">创建时间</td>
					<td style="border: 0;">类型</td>
				</tr>
				<?php  if(is_array($total)) { foreach($total as $more) { ?>
				<tr>
					<td style="border: 0;">
						<input type="checkbox" name="total_id" value="<?php  echo $more['id'];?>">
					</td>
					<td style="border: 0;">
						<?php  echo $more['number'];?>
					</td>
					<td style="border: 0;">
						<?php  echo date('Y-m-d H:i:s',$more['createtime'])?>
					</td>
					<td style="border: 0;">
						<?php  if($more['mode'] == 0) { ?>
						----
						<?php  } else if($more['mode'] == 1 || $more['mode'] == 2) { ?>
						{<?php  echo $more['number'];?>}
						<?php  } else if($more['mode'] == 3) { ?>
						{0~9}<?php  echo substr($more['number'],1)?>
						<?php  } else if($more['mode'] == 4) { ?>
						<?php  echo substr($more['number'],0,strlen($more['number'])-1)?>
						<?php  } ?>
					</td>
				</tr>
				<?php  } } ?>
			</table>
		</td>
	</tr>
</table>
<script type="text/javascript">
	function del(type) {
		var ids = [];
		var checked = confirm('确定删除这些字吗？');
		if (type == 1) {
			$('input[name=sample_id]:checked').each(function() {
				ids.push($(this).val());
			})
		}
		if (type == 2) {
			$('input[name=total_id]:checked').each(function() {
				ids.push($(this).val());
			})
		}
		if (checked == true) {
			$.post("<?php  echo $this->createMobileUrl('limit',array('op'=>'red_array_del'))?>",{id:ids},function(result) {
				alert(result.message);
				location.href = result.redirect;
			},'JSON');
		}
	}
</script>
<?php  } else if($tab == 'red_detail' || $tab == 'red_edit') { ?>
<div class="col-xs-12" style="padding: 5px;">
	<a href="<?php  echo $this->createMobileUrl('manager',array('op'=>'limit','tab'=>'red_create','type'=>$_GPC['type']))?>" class="btn">添加红字</a>
	<a href="<?php  echo $this->createMobileUrl('manager',array('op'=>'limit','tab'=>'red'))?>" class="btn" style="margin-left: 5px;">管理</a>
</div>
<table class="table">
	<tr>
		<td>操作</td>
		<?php  if($_SESSION['level'] == 1) { ?>
		<td>盘口</td>
		<?php  } ?>
		<td>号码</td>
		<td>详情</td>
	</tr>
	<?php  if(is_array($list)) { foreach($list as $item) { ?>
	<tr>
		<td>
			<a href="javascript:void(0);" onclick="del(<?php  echo $item['id'];?>)">删除</a>
		</td>
		<?php  if($_SESSION['level'] == 1) { ?>
		<td><?php  echo $item['area_name'];?></td>
		<?php  } ?>
		<td><?php  echo $item['number'];?></td>
		<td>
			<table class="table">
				<?php  if(is_array($item['bet_limit'])) { foreach($item['bet_limit'] as $key => $bet) { ?>
				<tr>
					<td style="border: 0;"><?php  echo $com[$key];?></td>
					<?php  if(is_array($bet)) { foreach($bet as $e => $b) { ?>
					<td style="border: 0;"><?php  echo $e;?>：<?php  echo $b;?></td>
					<?php  } } ?>
				</tr>
				<?php  } } ?>
			</table>
		</td>
	</tr>
	<?php  } } ?>
</table>
<script type="text/javascript">
	function del(id) {
		var checked = confirm('确定删除该号码?');
		if (checked == true) {
			$.post("<?php  echo $this->createMobileUrl('limit',array('op'=>'red_del'))?>",{id:id},function(result) {
				alert(result.message);
				location.href = result.redirect;
			},'JSON');
		}
	}
</script>
<?php  } else if($tab == 'red_create') { ?>
<form action="<?php  echo $this->createMobileUrl('limit',array('op'=>'red_post'))?>" method="post">
	<div class="col-xs-12">
		<table>
			<tr>
				<td>号码：</td>
				<td>
					<input type="text" name="number" value="" onkeyup="this.value=this.value.replace(/[^\d\,]/g,'')">
					(一次添加多个字，请使用英文符号","隔开。)
					<input type="hidden" name="type" value="<?php  echo $_GPC['type'];?>">
				</td>
				<?php  if($_SESSION['level'] == 1) { ?>
				<td>
					<select name="cid">
						<option value="0">盘口</option>
						<?php  if(is_array($area)) { foreach($area as $a) { ?>
						<option value="<?php  echo $a['id'];?>"><?php  echo $a['area_name'];?></option>
						<?php  } } ?>
					</select>
				</td>
				<?php  } ?>
				<td style="padding: 0 5px;">
					<select name="mode">
						<option value="0">special</option>
						<option value="1">BOX</option>
						<option value="2">iBOX</option>
						<option value="3">{0~9}234</option>
						<option value="4">123{0~9}</option>
					</select>
				</td>
				<td>
					<input type="submit" name="submit" value="提交" class="btn">
				</td>
			</tr>
			<tr>
				<td colspan="4">
					<label>
						<input type="checkbox" name="same" value="1">
						All same
					</label>
				</td>
			</tr>
		</table>
	</div>
	<table class="table table-bordered">
		<?php  if(is_array($company)) { foreach($company as $item) { ?>
		<tr>
			<td colspan="26"><?php  echo $item['nickname'];?></td>
		</tr>
		<tr>
			<td>
			</td>
			<?php  if(is_array($beto)) { foreach($beto as $bet) { ?>
			<td><?php  echo $bet;?></td>
			<?php  } } ?>
		</tr>
		<tr>
			<td>
				<label style="width: 80px;">
					全部一样
					<input type="checkbox" name="line_same" value="1" id="same_<?php  echo $item['id'];?>">
				</label>
			</td>
			<?php  if(is_array($beto)) { foreach($beto as $b) { ?>
			<td><input type="text" name="limit[<?php  echo $item['id'];?>][<?php  echo $b;?>]" value="" class="limit_<?php  echo $item['id'];?> limit" data-value="<?php  echo $item['id'];?>" style="width: 80px;"></td>
			<?php  } } ?>
		</tr>
		<?php  } } ?>
	</table>	
</form>
<script type="text/javascript">
	$('.limit').on('keyup',function() {
		var id = $(this).attr('data-value');
		var checked = $('#same_'+id).is(':checked');
		if (checked == true) {
			$('.limit_'+id).val($(this).val());
		}
	})
</script>
<?php  } ?>
<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('footer', TEMPLATE_INCLUDEPATH)) : (include template('footer', TEMPLATE_INCLUDEPATH));?>