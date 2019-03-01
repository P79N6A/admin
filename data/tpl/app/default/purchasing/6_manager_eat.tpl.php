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
<?php  if($op == 'manager_eat') { ?>
<div class="col-xs-12">
	<form class="form-inline" role="form" action="" method="get">
		<input type="hidden" name="c" value="entry">
		<input type="hidden" name="i" value="<?php  echo $_GPC['i'];?>">
		<input type="hidden" name="do" value="manager">
		<input type="hidden" name="m" value="purchasing">
		<input type="hidden" name="op" value="manager_eat">
		<div class="col-xs-12" style="padding: 5px 0;">
			<div class="form-group">
				<label for="keyword">账号</label>
				<input type="text" name="keyword" id="account" placeholder="请输入账号" class="form-control" value="<?php  echo $_GPC['account'];?>">
			</div>
			<div class="form-group">
				<input type="submit" name="search" class="btn btn-success" value="搜索">
			</div>
		</div>
	</form>
	<table class="table table-bordered">
		<tr>
			<td class="text-right" style="border: 0;">户口：</td>
			<td colspan="8" style="border: 0;"><?php  if($agent_id>0) { ?><?php  echo $account;?><?php  } ?></td>
		</tr>
		<tr>
			<td></td>
			<td>账号</td>
			<td>名称</td>
			<td>状态</td>
			<td>积分</td>
			<td>分红/配套</td>
			<td>最后修改时间</td>
			<td>最后上线时间</td>
			<td>登录IP</td>
		</tr>
		<?php  if(is_array($list)) { foreach($list as $item) { ?>
		<tr>
			<td>
				<a href="<?php  echo $this->createMobileUrl('manager_eat',array('op'=>'edit','agent_id'=>$item['id']))?>">更改</a>
			</td>
			<td><?php  echo $item['account'];?></td>
			<td><?php  echo $item['nickname'];?></td>
			<td>
				<?php  if($item['user_type'] == 2) { ?>
				<a href="javascript:void(0);" onclick="set_status(<?php  echo $item['id'];?>,<?php  echo $item['status'];?>)">
				<?php  } ?>
					<?php  if($item['status'] == 0) { ?>
					<span style="color: #0f0;">活跃</span>
					<?php  } else if($item['status'] == 2) { ?>
					<span style="color: #f00;">试用</span>
					<?php  } else { ?>
					<span style="color: #ccc">禁用</span>
					<?php  } ?>
				<?php  if($item['user_type'] == 2) { ?>
				</a>
				<?php  } ?>
			</td>
			<td><?php  echo $item['credit1'];?></td>
			<td><?php  if($item['user_type'] == 1) { ?><?php  echo $item['bonus'];?>%<?php  } else { ?><?php  if(is_array($item['used_odds'])) { foreach($item['used_odds'] as $ud) { ?><a href="javascript:void(0);" onclick="get_odds(<?php  echo $ud['id'];?>)"><?php  echo $ud['title'];?></a> <?php  } } ?><?php  } ?></td>
			<td><?php  if($item['last_edit_time']>0) { ?><?php  echo date('Y-m-d H:i:s',$item['last_edit_time'])?><?php  } else { ?>没有修改过<?php  } ?></td>
			<td><?php  if($item['last_login_time']>0) { ?><?php  echo date('Y-m-d H:i:s',$item['last_login_time'])?><?php  } else { ?>没有登陆过<?php  } ?></td>
			<td><?php  echo $item['last_login_ip'];?></td>
		</tr>
		<?php  } } ?>
	</table>
	<?php  echo $pager;?>
</div>
<?php  } else if($op == 'edit') { ?>
<style type="text/css">
	.inset_table tr td{padding: 2px 3px;}
</style>
<div class="col-xs-12">
	<form action="<?php  echo $this->createMobileUrl('manager_eat',array('op'=>'edit_post'))?>" method="post">
		<input type="hidden" name="agent_id" value="<?php  echo $agent;?>">
		<div class="col-xs-4"  style="margin-bottom: 10px;">
			<p>账号：<?php  echo $member['account'];?></p>
			<table class="inset_table" style="border: 1px solid #ccc;">
				<tr>
					<td>吃字比例</td>
					<td><input type="text" name="percent" value="<?php  echo $eat['percent'];?>" style="width: 40px;">%</td>
					<td></td>
				</tr>
				<tr>
					<td>4D类型</td>
					<td>
						<select name="type_4d" onchange="change_4d()">
							<option value="1" <?php  if($eat['type_4d'] == 1) { ?>selected="selected"<?php  } ?>>AMT</option>
							<option value="2" <?php  if($eat['type_4d'] == 2) { ?>selected="selected"<?php  } ?>>TOT</option>
						</select>
					</td>
					<td>
						<select name="type_count" onchange="change_4d()">
							<option value="4" <?php  if(count($ordby) == 4) { ?>selected<?php  } ?>>4项</option>
							<option value="3" <?php  if(count($ordby) == 3) { ?>selected<?php  } ?>>3项</option>
						</select>
					</td>
				</tr>
				<tr>
					<td>3D类型</td>
					<td>
						<select name="type_3d" onchange="change_3d()">
							<option value="1" <?php  if($eat['type_3d'] == 1) { ?>selected="selected"<?php  } ?>>AMT</option>
							<option value="2" <?php  if($eat['type_3d'] == 2) { ?>selected="selected"<?php  } ?>>TOT</option>
						</select>
					</td>
					<td></td>
				</tr>
				<tr>
					<td>吃字分红</td>
					<td>
						<?php  if($member['level'] == 4) { ?>
						<label>
							<input type="checkbox" name="is_filter" value="1" <?php  if($eat['is_filter'] == 1) { ?> checked="checked"<?php  } ?>>
							过滤
						</label>
						<?php  } ?>
					</td>
					<td></td>
				</tr>
			</table>
		</div>
		<div class="col-xs-12">
			<table class="table table-bordered">
				<tr style="background: #000;color: #fff">
					<td>company</td>
					<?php  if(is_array($bet_4D)) { foreach($bet_4D as $b) { ?>
					<?php  if($b == 'mutiple') { ?>
					<td class="bet_4d bet_4d_<?php  echo $b;?>" style="width: 260px;">
						<?php  if(is_array($ordby)) { foreach($ordby as $k => $ord) { ?>
						<select name="ordby[]" style="color: #333;width: 50px;">
							<option value="B" <?php  if($ord == 'B') { ?>selected<?php  } ?>>B</option>
							<option value="S" <?php  if($ord == 'S') { ?>selected<?php  } ?>>S</option>
							<option value="4A" <?php  if($ord == '4A') { ?>selected<?php  } ?>>4A</option>
							<option value="4ABC" <?php  if($ord == '4ABC') { ?>selected<?php  } ?>>4ABC</option>
						</select><?php  if($k < count($ordby)-1) { ?>+<?php  } ?>
						<?php  } } ?>
					</td>
					<?php  } else { ?>
					<td class="bet_4d bet_<?php  echo $b;?>"><?php  echo $b;?></td>
					<?php  } ?>
					<?php  } } ?>
					<?php  if(is_array($bet_3D)) { foreach($bet_3D as $a) { ?>
					<?php  if($a == 'mutiple') { ?>
					<td class="bet_3d bet_3d_<?php  echo $a;?>" style="width: 150px;">
						<?php  if(is_array($ordby_3d)) { foreach($ordby_3d as $o => $ord_3d) { ?>
						<select name="ordby_3d[]" style="color: #333;width: 50px;">
							<option value="A" <?php  if($ord_3d == 'A') { ?>selected<?php  } ?>>A</option>
							<option value="3ABC" <?php  if($ord_3d == '3ABC') { ?>selected<?php  } ?>>3ABC</option>
						</select><?php  if($o < count($ordby_3d)-1) { ?>+<?php  } ?>
						<?php  } } ?>
					</td>
					<?php  } else { ?>
					<td class="bet_3d bet_<?php  echo $a;?>"><?php  echo $a;?></td>
					<?php  } ?>
					<?php  } } ?>
				</tr>
				<?php  if(is_array($company)) { foreach($company as $com) { ?>
				<tr class="mating_item" data-value="<?php  echo $com['id'];?>">
					<td class="name_<?php  echo $com['id'];?>"><?php  echo $com['nickname'];?></td>
					<?php  if(is_array($bet_4D)) { foreach($bet_4D as $b) { ?>
					<td class="mating_<?php  echo $com['id'];?>_<?php  echo $b;?>"><input type="text" name="mating[4D][<?php  echo $com['id'];?>][<?php  echo $b;?>]" style="width: 100%;" value="<?php  echo $mating_4D[$com['id']][$b];?>"></td>
					<?php  } } ?>
					<?php  if(is_array($bet_3D)) { foreach($bet_3D as $a) { ?>
					<td class="mating_3d_<?php  echo $com['id'];?>_<?php  echo $a;?>"><input type="text" name="mating[3D][<?php  echo $com['id'];?>][<?php  echo $a;?>]" style="width: 100%;" value="<?php  echo $mating_3D[$com['id']][$a];?>"></td>
					<?php  } } ?>
				</tr>
				<?php  } } ?>
			</table>
			<input type="submit" name="submit" value="保存" class="btn">
		</div>
	</form>
</div>
<script type="text/javascript">
	function change_4d() {
		var type = $('select[name=type_4d]').val();
		var count = $('select[name=type_count]').val();
		if (type == 1) {
			var txt = '<td>company</td><td class="bet_4d bet_B">B</td><td class="bet_4d bet_S">S</td><td class="bet_4d bet_4A">4A</td><td class="bet_4d bet_4ABC">4ABC</td>';
			$('.mating_item').each(function() {
				var id = $(this).attr('data-value');
				var name = $('.name_'+id).text();
				var mating_txt = '<td class="name_'+id+'">'+name+'</td><td class="mating_'+id+'_B"><input type="text" name="mating['+id+'][4D][B]" style="width: 100%;"></td>';
					mating_txt += '<td class="mating_'+id+'_S"><input type="text" name="mating[4D]['+id+'][S]" style="width: 100%;"></td>';
					mating_txt += '<td class="mating_'+id+'_4A"><input type="text" name="mating[4D]['+id+'][4A]" style="width: 100%;"></td>';
					mating_txt += '<td class="mating_'+id+'_4ABC"><input type="text" name="mating[4D]['+id+'][4ABC]" style="width: 100%;"></td>';
					$('.mating_'+id+'_4B').prevAll().remove();
					$('.mating_'+id+'_4B').before(mating_txt);
			});
			$('.bet_4B').prevAll().remove();
			$('.bet_4B').before(txt);
		}
		if (type == 2) {
			if (count == 4) {
				var txt = '<td>company</td><td class="bet_4d bet_4d_mutiple" style="width: 260px;">';
					txt += '<select name="ordby[]" style="color: #333;width: 50px;">';
					txt += '<option value="B">B</option>';
					txt += '<option value="S">S</option>';
					txt += '<option value="4A">4A</option>';
					txt += '<option value="4ABC">4ABC</option>';
					txt += '</select>';
					txt += '+';
					txt += '<select name="ordby[]" style="color: #333;width: 50px;">';
					txt += '<option value="B">B</option>';
					txt += '<option value="S">S</option>';
					txt += '<option value="4A">4A</option>';
					txt += '<option value="4ABC">4ABC</option>';
					txt += '</select>';
					txt += '+';
					txt += '<select name="ordby[]" style="color: #333;width: 50px;">';
					txt += '<option value="B">B</option>';
					txt += '<option value="S">S</option>';
					txt += '<option value="4A">4A</option>';
					txt += '<option value="4ABC">4ABC</option>';
					txt += '</select>';
					txt += '+';
					txt += '<select name="ordby[]" style="color: #333;width: 50px;">';
					txt += '<option value="B">B</option>';
					txt += '<option value="S">S</option>';
					txt += '<option value="4A">4A</option>';
					txt += '<option value="4ABC">4ABC</option>';
					txt += '</select>';
					txt += '</td>';
				$('.mating_item').each(function() {
					var id = $(this).attr('data-value');
					var name = $('.name_'+id).text();
					var mating_txt = '<td class="name_'+id+'">'+name+'</td><td class="mating_'+id+'_mutiple"><input type="text" name="mating[4D]['+id+'][mutiple]" style="width: 100%;"></td>';
						$('.mating_'+id+'_4B').prevAll().remove();
						$('.mating_'+id+'_4B').before(mating_txt);
				});
				$('.bet_4B').prevAll().remove();
				$('.bet_4B').before(txt);
			}
			if (count == 3) {
				var txt = '<td>company</td><td class="bet_4d bet_4d_mutiple" style="width: 260px;">';
					txt += '<select name="ordby[]" style="color: #333;width: 50px;">';
					txt += '<option value="B">B</option>';
					txt += '<option value="S">S</option>';
					txt += '<option value="4A">4A</option>';
					txt += '<option value="4ABC">4ABC</option>';
					txt += '</select>';
					txt += '+';
					txt += '<select name="ordby[]" style="color: #333;width: 50px;">';
					txt += '<option value="B">B</option>';
					txt += '<option value="S">S</option>';
					txt += '<option value="4A">4A</option>';
					txt += '<option value="4ABC">4ABC</option>';
					txt += '</select>';
					txt += '+';
					txt += '<select name="ordby[]" style="color: #333;width: 50px;">';
					txt += '<option value="B">B</option>';
					txt += '<option value="S">S</option>';
					txt += '<option value="4A">4A</option>';
					txt += '<option value="4ABC">4ABC</option>';
					txt += '</select>';
					txt += '</td>';
					txt += '<td>ot</td>';
				$('.mating_item').each(function() {
					var id = $(this).attr('data-value');
					var name = $('.name_'+id).text();
					var mating_txt = '<td class="name_'+id+'">'+name+'</td><td class="mating_'+id+'_mutiple"><input type="text" name="mating[4D]['+id+'][mutiple]" style="width: 100%;"></td>';
						mating_txt += '<td class="mating_'+id+'_ot"><input type="text" name="mating[4D]['+id+'][ot]" style="width: 100%;"></td>'
						$('.mating_'+id+'_4B').prevAll().remove();
						$('.mating_'+id+'_4B').before(mating_txt);
				});
				$('.bet_4B').prevAll().remove();
				$('.bet_4B').before(txt);
			}
		}
	}
	function change_3d() {
		var type = $('select[name=type_3d]').val();
		if (type == 1) {
			var txt = '<td class="bet_3d bet_A">A</td><td class="bet_3d bet_3ABC">3ABC</td>';
			$('.mating_item').each(function() {
				var id = $(this).attr('data-value');
				var mating_txt = '<td class="mating_3d_'+id+'_A"><input type="text" name="mating[3D]['+id+'][A]" style="width: 100%;"></td>';
					mating_txt += '<td class="mating_3d_'+id+'_3ABC"><input type="text" name="mating[3D]['+id+'][3ABC]" style="width: 100%;"></td>';
					$('.mating_3d_'+id+'_mutiple').remove();
					$('.mating_3d_'+id+'_C2').before(mating_txt);
			});
			$('.bet_3d_mutiple').remove();
			$('.bet_C2').before(txt);
		}
		if (type == 2) {
			var txt = '<td class="bet_3d bet_3d_mutiple" style="width: 150px;">';
				txt += '<select name="ordby_3d[]" style="color: #333;width: 50px;">';
				txt += '<option value="A">A</option>';
				txt += '<option value="3ABC">3ABC</option>';
				txt += '</select>';
				txt += '+';
				txt += '<select name="ordby_3d[]" style="color: #333;width: 50px;">';
				txt += '<option value="A">A</option>';
				txt += '<option value="3ABC">3ABC</option>';
				txt += '</select>';
				txt += '</td>';
			$('.mating_item').each(function() {
				var id = $(this).attr('data-value');
				var mating_txt = '<td class="mating_3d_'+id+'_mutiple"><input type="text" name="mating[3D]['+id+'][mutiple]" style="width: 100%;"></td>';
					$('.mating_3d_'+id+'_A').remove();
					$('.mating_3d_'+id+'_3ABC').remove();
					$('.mating_3d_'+id+'_C2').before(mating_txt);
			});
			$('.bet_A').remove();
			$('.bet_3ABC').remove();
			$('.bet_C2').before(txt);
		}
	}
</script>
<?php  } ?>
<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('footer', TEMPLATE_INCLUDEPATH)) : (include template('footer', TEMPLATE_INCLUDEPATH));?>