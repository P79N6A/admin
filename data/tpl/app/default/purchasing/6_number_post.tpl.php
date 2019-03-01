<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('header', TEMPLATE_INCLUDEPATH)) : (include template('header', TEMPLATE_INCLUDEPATH));?>
<style>
	.recharge-area{position: fixed;width: 100%;height: 100%;top: 0;left: 0;background: rgba(0,0,0,0.4);display: none;}
	.recharge-main{width: 50%;height: 10vw;margin: 5% auto;background: #fff;}
	.recharge-head{width: 100%;text-align: center;border-bottom: 1px solid #aaa;font-size: 20px;line-height: 30px;}
	.recharge-body{width: 100%;padding: 2vw 3vw;}
	.recharge-body table tbody tr td input[type=text]{width: 80%;border: 0;}
	.btn{border: 1px solid #3e3e3e;background-color: #3e3e3e;border-radius: 20px;color: #fff;padding: 3px 7px;}
	a:hover{text-indent: none;}
	.btn:hover{background: #fff;color: #333}
	#odds-set div table tbody tr td{padding: 4px 8px;}
	#odds-set div table tbody tr td input[type=text]{width: 80%;height: 20px;}
</style>
<link rel="stylesheet" href="../addons/purchasing/static/css/borain-timeChoice.css">
<link rel="stylesheet" type="text/css" href="http://www.jq22.com/jquery/font-awesome.4.6.0.css">
<script src="../addons/purchasing/static/js/borain-timeChoice.js"></script>
<div class="col-xs-1" style="padding: 0;margin-top: 5px;">
	<ul class="nav nav-pills nav-stacked">
	  <li <?php  if($op == 'display' || $op == 'unpost') { ?>class="active"<?php  } ?>><a href="<?php  echo $this->createMobileUrl('number_post')?>">UNPOST</a></li>
	  <li <?php  if($op == 'posting') { ?>class="active"<?php  } ?>><a href="<?php  echo $this->createMobileUrl('number_post',array('op'=>'posting'))?>">POSTING</a></li>
	  <li <?php  if($op == 'posted') { ?>class="active"<?php  } ?>><a href="<?php  echo $this->createMobileUrl('number_post',array('op'=>'posted'))?>">POSTED</a></li>
	  <li <?php  if($op == 'return') { ?>class="active"<?php  } ?>><a href="<?php  echo $this->createMobileUrl('number_post',array('op'=>'return'))?>">RETURN</a></li>
	  <li <?php  if($op == 'setting') { ?>class="active"<?php  } ?>><a href="<?php  echo $this->createMobileUrl('number_post',array('op'=>'setting'))?>">SETTING</a></li>
	</ul>
</div>
<div class="col-xs-11" style="margin-top: 5px;">
<?php  if($op == 'display') { ?>
	<div class="col-xs-12" style="padding: 0;">
		<form action="./index.php" method="get">
			<input type="hidden" name="i" value="<?php  echo $_GPC['i'];?>">
			<input type="hidden" name="c" value="<?php  echo $_GPC['c'];?>">
			<input type="hidden" name="m" value="<?php  echo $_GPC['m'];?>">
			<input type="hidden" name="do" value="<?php  echo $_GPC['do'];?>">
			<input type="hidden" name="op" value="<?php  echo $_GPC['op'];?>">
			<input type="text" name="date" id="date" value="<?php  echo $_GPC['date'];?>" style="width: 200px;border: 1px solid #ccc;background: url(../addons/purchasing/static/images/date.jpg) no-repeat;background-position: right;background-size: auto 100%;" readonly="readonly">
			<input type="submit" name="submit" value="Search" class="btn">
		</form>
	</div>
	<table class="table table-bordered">
		<tr>
			<td>House</td>
			<td>Total_6D</td>
			<td>Total_5D</td>
			<td>Total_4D</td>
			<td>Total_3D</td>
			<td>Total_2D</td>
			<td>Total_come</td>
		</tr>
		<tr>
			<td>1</td>
			<td><?php echo $house['6D']?$house['6D']:0?></td>
			<td><?php echo $house['5D']?$house['5D']:0?></td>
			<td><?php echo $house['4D']?$house['4D']:0?></td>
			<td><?php echo $house['3D']?$house['3D']:0?></td>
			<td><?php echo $house['2D']?$house['2D']:0?></td>
			<td><?php echo $house_total?$house_total:0?></td>
		</tr>
		<tr>
			<td><a href="<?php  echo $this->createMobileUrl('number_post',array('op'=>'unpost'))?>">UNPOST</a></td>
			<td><a href="<?php  echo $this->createMobileUrl('number_post',array('op'=>'unpost','type'=>'6D'))?>"><?php echo $unpost['6D']?$unpost['6D']:0?></a></td>
			<td><a href="<?php  echo $this->createMobileUrl('number_post',array('op'=>'unpost','type'=>'5D'))?>"><?php echo $unpost['5D']?$unpost['5D']:0?></a></td>
			<td><a href="<?php  echo $this->createMobileUrl('number_post',array('op'=>'unpost','type'=>'4D'))?>"><?php echo $unpost['4D']?$unpost['4D']:0?></a></td>
			<td><a href="<?php  echo $this->createMobileUrl('number_post',array('op'=>'unpost','type'=>'3D'))?>"><?php echo $unpost['3D']?$unpost['3D']:0?></a></td>
			<td><a href="<?php  echo $this->createMobileUrl('number_post',array('op'=>'unpost','type'=>'2D'))?>"><?php echo $unpost['2D']?$unpost['2D']:0?></a></td>
			<td><a href="<?php  echo $this->createMobileUrl('number_post',array('op'=>'unpost'))?>"><?php echo $unpost_total?$unpost_total:0?></a></td>
		</tr>
		<tr>
			<td>POSTED</td>
			<td><a href="<?php  echo $this->createMobileUrl('number_post',array('op'=>'posted','type'=>'6D'))?>"><?php echo $posted['6D']?$posted['6D']:0?></a></td>
			<td><a href="<?php  echo $this->createMobileUrl('number_post',array('op'=>'posted','type'=>'5D'))?>"><?php echo $posted['5D']?$posted['5D']:0?></a></td>
			<td><a href="<?php  echo $this->createMobileUrl('number_post',array('op'=>'posted','type'=>'4D'))?>"><?php echo $posted['4D']?$posted['4D']:0?></a></td>
			<td><a href="<?php  echo $this->createMobileUrl('number_post',array('op'=>'posted','type'=>'3D'))?>"><?php echo $posted['3D']?$posted['3D']:0?></a></td>
			<td><a href="<?php  echo $this->createMobileUrl('number_post',array('op'=>'posted','type'=>'2D'))?>"><?php echo $posted['2D']?$posted['2D']:0?></a></td>
			<td><a href="<?php  echo $this->createMobileUrl('number_post',array('op'=>'posted','type'=>'6D'))?>"><?php echo $posted_total?$posted_total:0?></a></td>
		</tr>
	</table>
<?php  } else if($op == 'unpost') { ?>
	<style type="text/css">
		.table>tbody>tr>td{padding: 2px;}
	</style>
	<div class="col-xs-12" style="padding: 0;">
		<form action="./index.php" method="get">
			<input type="hidden" name="i" value="<?php  echo $_GPC['i'];?>">
			<input type="hidden" name="c" value="<?php  echo $_GPC['c'];?>">
			<input type="hidden" name="m" value="<?php  echo $_GPC['m'];?>">
			<input type="hidden" name="do" value="<?php  echo $_GPC['do'];?>">
			<input type="hidden" name="op" value="<?php  echo $_GPC['op'];?>">
			Date：
			<input type="text" name="date" id="date" value="<?php  echo $_GPC['date'];?>" style="width: 200px;border: 1px solid #ccc;background: url(../addons/purchasing/static/images/date.jpg) no-repeat;background-position: right;background-size: auto 100%;" readonly="readonly">
			Number：
			<input type="text" name="number" value="<?php  echo $_GPC['number'];?>">
			<input type="submit" name="submit" value="Search" class="btn">
		</form>
	</div>
	<?php  if(is_array($list)) { foreach($list as $key => $item) { ?>
	<div class="col-xs-12" style="overflow-x: auto;width: 1000%;">
		<?php  if(is_array($item)) { foreach($item as $num) { ?>
		<div style="margin: 10px 0;float: left;">
			<?php  echo $num['name'];?>/<?php  echo $key;?>
			<table class="table table-bordered" style="overflow-y: auto;">
				<tr>
					<td>号码</td>
					<?php  if(is_array($num['post_key'])) { foreach($num['post_key'] as $n) { ?>
					<td><?php  echo $n;?></td>
					<?php  } } ?>
				</tr>
				<?php  if(is_array($num['list'])) { foreach($num['list'] as $li) { ?>
				<tr>
					<td><?php  echo $li['number'];?></td>
					<?php  if(is_array($num['post_key'])) { foreach($num['post_key'] as $v) { ?>
					<td><?php  echo $li[$v];?></td>
					<?php  } } ?>
				</tr>
				<?php  } } ?>
			</table>
		</div>
		<?php  } } ?>
	</div>
	<?php  } } ?>
	<a href="<?php  echo $this->createMobileUrl('number_post',array('op'=>'posting','type'=>$_GPC['type']))?>" class="btn">
		<?php  if(!empty($_GPC['type'])) { ?>打出<?php  echo $_GPC['type'];?><?php  } else { ?>打出所有<?php  } ?>
	</a>
<?php  } else if($op == 'setting') { ?>
	<div class="col-xs-12" style="padding: 0;">
		<form action="./index.php" method="get">
			<input type="hidden" name="i" value="<?php  echo $_GPC['i'];?>">
			<input type="hidden" name="c" value="<?php  echo $_GPC['c'];?>">
			<input type="hidden" name="m" value="<?php  echo $_GPC['m'];?>">
			<input type="hidden" name="do" value="<?php  echo $_GPC['do'];?>">
			<input type="hidden" name="op" value="<?php  echo $_GPC['op'];?>">
			<input type="text" name="account" id="account" value="<?php  echo $_GPC['account'];?>" style="width: 200px;border: 1px solid #ccc;" placeholder="请输入账号">
			<input type="submit" name="submit" value="Search" class="btn">
		</form>
	</div>
	<div class="col-xs-12" style="padding: 0;margin-top: 5px;">
		<a href="<?php  echo $this->createMobileUrl('number_post',array('op'=>'set_account'))?>" class="btn">添加</a>
	</div>
	<table class="table table-bordered">
		<tr>
			<td>账号</td>
			<td>昵称</td>
			<?php  if(is_array($company)) { foreach($company as $com) { ?>
			<td><?php  echo $com['nickname'];?>4D合并收字</td>
			<td>优先级</td>
			<td><?php  echo $com['nickname'];?>3D合并收字</td>
			<td>优先级</td>
			<?php  } } ?>
		</tr>
		<?php  if(is_array($list)) { foreach($list as $item) { ?>
		<tr>
			<td><a href="<?php  echo $this->createMobileUrl('number_post',array('op'=>'set_account','id'=>$item['id']))?>"><?php  echo $item['account'];?></a></td>
			<td><a href="<?php  echo $this->createMobileUrl('number_post',array('op'=>'set_account','id'=>$item['id']))?>"><?php  echo $item['nickname'];?></a></td>
			<?php  if(is_array($company)) { foreach($company as $com) { ?>
			<td>
				<a href="<?php  echo $this->createMobileUrl('number_post',array('op'=>'set_account','id'=>$item['id']))?>"><?php  echo $item['eat'][$company['id']]['mating_4D'];?></a>
			</td>
			<td><a href="<?php  echo $this->createMobileUrl('number_post',array('op'=>'set_account','id'=>$item['id']))?>"><?php  echo $item['ordby_4D'];?></a></td>
			<td>
				<a href="<?php  echo $this->createMobileUrl('number_post',array('op'=>'set_account','id'=>$item['id']))?>"><?php  echo $item['eat'][$company['id']]['mating_3D'];?></a>
			</td>
			<td><a href="<?php  echo $this->createMobileUrl('number_post',array('op'=>'set_account','id'=>$item['id']))?>"><?php  echo $item['ordby_3D'];?></a></td>
			<?php  } } ?>
		</tr>
		<?php  } } ?>
	</table>
<?php  } else if($op == 'set_account') { ?>
	<style type="text/css">
		.table>tbody>tr>td{padding: 2px;}
		.table>tbody>tr>td>input[type=text]{width: 100px;height: 18px;}
	</style>
	<form action="<?php  echo $this->createMobileUrl('number_post',array('op'=>'account_post'))?>" method="post">
	<div class="col-xs-12" style="padding: 0;">
		账号：<input type="text" name="account" value="<?php  echo $member['account'];?>">
		昵称：<input type="text" name="nickname" value="<?php  echo $member['nickname'];?>">
		盘口：<select name="port_id">
			<?php  if(is_array($area)) { foreach($area as $a) { ?>
			<option value="<?php  echo $a['id'];?>" <?php  if($member['port_id']==$a['id']) { ?>selected<?php  } ?>><?php  echo $a['area_name'];?></option>
			<?php  } } ?>
		</select>
		<input type="hidden" name="id" value="<?php  echo $_GPC['id'];?>">
		<input type="submit" name="submit" value="保存" class="btn">
	</div>
	<table class="table table-bordered">
		<tr>
			<td></td>
			<td colspan="2">4D</td>
			<td colspan="2">3D</td>
		</tr>
		<tr>
			<td></td>
			<td>数额</td>
			<td>优先级</td>
			<td>数额</td>
			<td>优先级</td>
		</tr>
		<?php  if(is_array($company)) { foreach($company as $com) { ?>
		<tr>
			<td><?php  echo $com['name'];?></td>
			<td><input type="text" name="eat[<?php  echo $com['id'];?>][mating_4D]" value="<?php  echo $eat[$com['id']]['mating_4D'];?>"></td>
			<td>
				<select name="eat[<?php  echo $com['id'];?>][ordby_4D][]">
					<option value="B" <?php  if($eat[$com['id']]['ordby_4D']['0'] == 'B') { ?>selected<?php  } ?>>B</option>
					<option value="S" <?php  if($eat[$com['id']]['ordby_4D']['0'] == 'S') { ?>selected<?php  } ?>>S</option>
					<option value="4A" <?php  if($eat[$com['id']]['ordby_4D']['0'] == '4A') { ?>selected<?php  } ?>>4A</option>
					<option value="4ABC" <?php  if($eat[$com['id']]['ordby_4D']['0'] == '4ABC') { ?>selected<?php  } ?>>4ABC</option>
				</select>+<select name="eat[<?php  echo $com['id'];?>][ordby_4D][]">
					<option value="B" <?php  if($eat[$com['id']]['ordby_4D']['1'] == 'B') { ?>selected<?php  } ?>>B</option>
					<option value="S" <?php  if($eat[$com['id']]['ordby_4D']['1'] == 'S') { ?>selected<?php  } ?>>S</option>
					<option value="4A" <?php  if($eat[$com['id']]['ordby_4D']['1'] == '4A') { ?>selected<?php  } ?>>4A</option>
					<option value="4ABC" <?php  if($eat[$com['id']]['ordby_4D']['1'] == '4ABC') { ?>selected<?php  } ?>>4ABC</option>
				</select>+<select name="eat[<?php  echo $com['id'];?>][ordby_4D][]">
					<option value="B" <?php  if($eat[$com['id']]['ordby_4D']['2'] == 'B') { ?>selected<?php  } ?>>B</option>
					<option value="S" <?php  if($eat[$com['id']]['ordby_4D']['2'] == 'S') { ?>selected<?php  } ?>>S</option>
					<option value="4A" <?php  if($eat[$com['id']]['ordby_4D']['2'] == '4A') { ?>selected<?php  } ?>>4A</option>
					<option value="4ABC" <?php  if($eat[$com['id']]['ordby_4D']['2'] == '4ABC') { ?>selected<?php  } ?>>4ABC</option>
				</select>+<select name="eat[<?php  echo $com['id'];?>][ordby_4D][]">
					<option value="B" <?php  if($eat[$com['id']]['ordby_4D']['3'] == 'B') { ?>selected<?php  } ?>>B</option>
					<option value="S" <?php  if($eat[$com['id']]['ordby_4D']['3'] == 'S') { ?>selected<?php  } ?>>S</option>
					<option value="4A" <?php  if($eat[$com['id']]['ordby_4D']['3'] == '4A') { ?>selected<?php  } ?>>4A</option>
					<option value="4ABC" <?php  if($eat[$com['id']]['ordby_4D']['3'] == '4ABC') { ?>selected<?php  } ?>>4ABC</option>
				</select>
			</td>
			<td><input type="text" name="eat[<?php  echo $com['id'];?>][mating_3D]" value="<?php  echo $eat[$com['id']]['mating_3D'];?>"></td>
			<td>
				<select name="eat[<?php  echo $com['id'];?>][ordby_3D][]">
					<option value="A" <?php  if($eat[$com['id']]['ordby_3D']['0'] == 'A') { ?>selected<?php  } ?>>A</option>
					<option value="3ABC" <?php  if($eat[$com['id']]['ordby_3D']['0'] == '3ABC') { ?>selected<?php  } ?>>3ABC</option>
				</select>
			</td>
		</tr>
		<?php  } } ?>
	</table>
	<table class="table table-bordered">
		<tr>
			<td></td>
			<td colspan="6">2D</td>
			<td colspan="5">3D</td>
			<td colspan="5">4D</td>
			<td>5D</td>
			<td>6D</td>
		</tr>
		<tr>
			<td></td>
			<td>2A</td>
			<td>2B</td>
			<td>2D</td>
			<td>2E</td>
			<td>EX</td>
			<td>2ABC</td>
			<td>C2</td>
			<td>C3</td>
			<td>C4</td>
			<td>C5</td>
			<td>EC</td>
			<td>4B</td>
			<td>4C</td>
			<td>4D</td>
			<td>4E</td>
			<td>EA</td>
			<td>5D</td>
			<td>6D</td>
		</tr>
		<?php  if(is_array($company)) { foreach($company as $com) { ?>
		<tr>
			<td><?php  echo $com['name'];?></td>
			<td><input type="text" name="eat[<?php  echo $com['id'];?>][2A]" value="<?php  echo $eat[$com['id']]['2A'];?>"></td>
			<td><input type="text" name="eat[<?php  echo $com['id'];?>][2B]" value="<?php  echo $eat[$com['id']]['2B'];?>"></td>
			<td><input type="text" name="eat[<?php  echo $com['id'];?>][2C]" value="<?php  echo $eat[$com['id']]['2C'];?>"></td>
			<td><input type="text" name="eat[<?php  echo $com['id'];?>][2D]" value="<?php  echo $eat[$com['id']]['2D'];?>"></td>
			<td><input type="text" name="eat[<?php  echo $com['id'];?>][EX]" value="<?php  echo $eat[$com['id']]['EX'];?>"></td>
			<td><input type="text" name="eat[<?php  echo $com['id'];?>][2ABC]" value="<?php  echo $eat[$com['id']]['2ABC'];?>"></td>
			<td><input type="text" name="eat[<?php  echo $com['id'];?>][C2]" value="<?php  echo $eat[$com['id']]['C2'];?>"></td>
			<td><input type="text" name="eat[<?php  echo $com['id'];?>][C3]" value="<?php  echo $eat[$com['id']]['C3'];?>"></td>
			<td><input type="text" name="eat[<?php  echo $com['id'];?>][C4]" value="<?php  echo $eat[$com['id']]['C4'];?>"></td>
			<td><input type="text" name="eat[<?php  echo $com['id'];?>][C5]" value="<?php  echo $eat[$com['id']]['C5'];?>"></td>
			<td><input type="text" name="eat[<?php  echo $com['id'];?>][EC]" value="<?php  echo $eat[$com['id']]['EC'];?>"></td>
			<td><input type="text" name="eat[<?php  echo $com['id'];?>][4B]" value="<?php  echo $eat[$com['id']]['4B'];?>"></td>
			<td><input type="text" name="eat[<?php  echo $com['id'];?>][4C]" value="<?php  echo $eat[$com['id']]['4C'];?>"></td>
			<td><input type="text" name="eat[<?php  echo $com['id'];?>][4D]" value="<?php  echo $eat[$com['id']]['4D'];?>"></td>
			<td><input type="text" name="eat[<?php  echo $com['id'];?>][4E]" value="<?php  echo $eat[$com['id']]['4E'];?>"></td>
			<td><input type="text" name="eat[<?php  echo $com['id'];?>][EA]" value="<?php  echo $eat[$com['id']]['EA'];?>"></td>
			<td><input type="text" name="eat[<?php  echo $com['id'];?>][5D]" value="<?php  echo $eat[$com['id']]['5D'];?>"></td>
			<td><input type="text" name="eat[<?php  echo $com['id'];?>][6D]" value="<?php  echo $eat[$com['id']]['6D'];?>"></td>
		</tr>
		<?php  } } ?>
	</table>
	<table class="table table-bordered">
		<tr>
			<td>抽佣</td>
			<td></td>
			<td><input type="text" name="commission[B]" class="commission" value="<?php  echo $commission['B'];?>" ></td>
			<td></td>
			<td><input type="text" name="commission[S]" class="commission" value="<?php  echo $commission['S'];?>" ></td>
			<td></td>
			<td><input type="text" name="commission[A]" class="commission" value="<?php  echo $commission['A'];?>" ></td>
			<td></td>
			<td><input type="text" name="commission[3ABC]" class="commission" value="<?php  echo $commission['3ABC'];?>" ></td>
			<td></td>
			<td><input type="text" name="commission[4A]" class="commission" value="<?php  echo $commission['4A'];?>" ></td>
			<td></td>
			<td><input type="text" name="commission[4ABC]" class="commission" value="<?php  echo $commission['4ABC'];?>" ></td>
			<td></td>
			<td><input type="text" name="commission[2A]" class="commission" value="<?php  echo $commission['2A'];?>" ></td>
			<td></td>
			<td><input type="text" name="commission[2ABC]" class="commission" value="<?php  echo $commission['2ABC'];?>" ></td>
			<td></td>
			<td><input type="text" name="commission[5D]" class="commission" value="<?php  echo $commission['5D'];?>" ></td>
			<td></td>
			<td><input type="text" name="commission[6D]" class="commission" value="<?php  echo $commission['6D'];?>" ></td>
		</tr>
		<tr>
			<td>头奖</td>
			<td>B</td>
			<td><input type="text" value="<?php  echo $odds['odds_B']['0'];?>" class="odds_b" name="odds[B][]" data-value="odds_b_0" onkeyup="keyupcheck(this)"></td>
			<td>S</td>
			<td><input type="text" value="<?php  echo $odds['odds_S']['0'];?>" class="odds_s" name="odds[S][]" data-value="odds_s_0" onkeyup="keyupcheck(this)"></td>
			<td>A</td>
			<td><input type="text" value="<?php  echo $odds['odds_A'];?>" class="odds_a" name="odds[A]" data-value="odds_a" onkeyup="keyupcheck(this)"></td>
			<td>3ABC</td>
			<td><input type="text" value="<?php  echo $odds['odds_3ABC']['0'];?>" class="odds_3abc" name="odds[3ABC][]" data-value="odds_3abc_0" onkeyup="keyupcheck(this)"></td>
			<td>4A</td>
			<td><input type="text" value="<?php  echo $odds['odds_4A'];?>" class="odds_4a" name="odds[4A]" data-value="odds_4a" onkeyup="keyupcheck(this)"></td>
			<td>4AC</td>
			<td><input type="text" value="<?php  echo $odds['odds_4ABC']['0'];?>" class="odds_4abc" name="odds[4ABC][]" data-value="odds_4abc_0" onkeyup="keyupcheck(this)"></td>
			<td>2A</td>
			<td><input type="text" value="<?php  echo $odds['odds_2A'];?>" class="odds_2a" name="odds[2A]" data-value="odds_2a" onkeyup="keyupcheck(this)"></td>
			<td>2ABC</td>
			<td><input type="text" value="<?php  echo $odds['odds_2ABC']['0'];?>" class="odds_2abc" name="odds[2ABC][]" data-value="odds_2abc_0" onkeyup="keyupcheck(this)"></td>
			<td>5D/1st</td>
			<td><input type="text" value="<?php  echo $odds['odds_5D']['0'];?>" class="odds_5d" name="odds[5D][]" data-value="odds_5d_0" onkeyup="keyupcheck(this)"></td>
			<td>6D/1st</td>
			<td><input type="text" value="<?php  echo $odds['odds_6D']['0'];?>" class="odds_6d" name="odds[6D][]" data-value="odds_6d_0" onkeyup="keyupcheck(this)"></td>
		</tr>
		<tr>
			<td>二奖</td>
			<td>B</td>
			<td><input type="text" value="<?php  echo $odds['odds_B']['1'];?>" class="odds_b" name="odds[B][]" data-value="odds_b_1" onkeyup="keyupcheck(this)"></td>
			<td>S</td>
			<td><input type="text" value="<?php  echo $odds['odds_S']['1'];?>" class="odds_s" name="odds[S][]" data-value="odds_s_1" onkeyup="keyupcheck(this)"></td>
			<td>C2</td>
			<td><input type="text" value="<?php  echo $odds['odds_C2'];?>" class="odds_a" name="odds[C2]" data-value="odds_c2" onkeyup="keyupcheck(this)"></td>
			<td>3ABC</td>
			<td><input type="text" value="<?php  echo $odds['odds_3ABC']['1'];?>" class="odds_3abc" name="odds[3ABC][]" data-value="odds_3abc_1" onkeyup="keyupcheck(this)"></td>
			<td>4B</td>
			<td><input type="text" value="<?php  echo $odds['odds_4B'];?>" class="odds_4a" name="odds[4B]" data-value="odds_4b" onkeyup="keyupcheck(this)"></td>
			<td>4AC</td>
			<td><input type="text" value="<?php  echo $odds['odds_4ABC']['0'];?>" class="odds_4abc" name="odds[4ABC][]" data-value="odds_4abc_1" onkeyup="keyupcheck(this)"></td>
			<td>2B</td>
			<td><input type="text" value="<?php  echo $odds['odds_2B'];?>" class="odds_2a" name="odds[2B]" data-value="odds_2b" onkeyup="keyupcheck(this)"></td>
			<td>2ABC</td>
			<td><input type="text" value="<?php  echo $odds['odds_2ABC']['1'];?>" class="odds_2abc" name="odds[2ABC][]" data-value="odds_2abc_1" onkeyup="keyupcheck(this)"></td>
			<td>5D/2nd</td>
			<td><input type="text" value="<?php  echo $odds['odds_5D']['1'];?>" class="odds_5d" name="odds[5D][]" data-value="odds_5d_1" onkeyup="keyupcheck(this)"></td>
			<td>6D/2nd</td>
			<td><input type="text" value="<?php  echo $odds['odds_6D']['1'];?>" class="odds_6d" name="odds[6D][]" data-value="odds_6d_1" onkeyup="keyupcheck(this)"></td>
		</tr>
		<tr>
			<td>三奖</td>
			<td>B</td>
			<td><input type="text" value="<?php  echo $odds['odds_B']['2'];?>" class="odds_b" name="odds[B][]" data-value="odds_b_2" onkeyup="keyupcheck(this)"></td>
			<td>S</td>
			<td><input type="text" value="<?php  echo $odds['odds_S']['2'];?>" class="odds_s" name="odds[S][]" data-value="odds_s_2" onkeyup="keyupcheck(this)"></td>
			<td>C3</td>
			<td><input type="text" value="<?php  echo $odds['odds_C3'];?>" class="odds_a" name="odds[C3]" data-value="odds_c3" onkeyup="keyupcheck(this)"></td>
			<td>3ABC</td>
			<td><input type="text" value="<?php  echo $odds['odds_3ABC']['2'];?>" class="odds_3abc" name="odds[3ABC][]" data-value="odds_3abc_2" onkeyup="keyupcheck(this)"></td>
			<td>4C</td>
			<td><input type="text" value="<?php  echo $odds['odds_4C'];?>" class="odds_4a" name="odds[4C]" data-value="odds_4c" onkeyup="keyupcheck(this)"></td>
			<td>4AC</td>
			<td><input type="text" value="<?php  echo $odds['odds_4ABC']['2'];?>" class="odds_4abc" name="odds[4ABC][]" data-value="odds_4abc_2" onkeyup="keyupcheck(this)"></td>
			<td>2C</td>
			<td><input type="text" value="<?php  echo $odds['odds_2C'];?>" class="odds_2a" name="odds[2C]" data-value="odds_2c" onkeyup="keyupcheck(this)"></td>
			<td>2ABC</td>
			<td><input type="text" value="<?php  echo $odds['odds_2ABC']['2'];?>" class="odds_2abc" name="odds[2ABC][]" data-value="odds_2abc_2" onkeyup="keyupcheck(this)"></td>
			<td>5D/3rd</td>
			<td><input type="text" value="<?php  echo $odds['odds_5D']['2'];?>" class="odds_5d" name="odds[5D][]" data-value="odds_5d_2" onkeyup="keyupcheck(this)"></td>
			<td>6D/3rd</td>
			<td><input type="text" value="<?php  echo $odds['odds_6D']['2'];?>" class="odds_6d" name="odds[6D][]" data-value="odds_6d_2" onkeyup="keyupcheck(this)"></td>
		</tr>
		<tr>
			<td>特别奖</td>
			<td>B</td>
			<td><input type="text" value="<?php  echo $odds['odds_B']['3'];?>" class="odds_b" name="odds[B][]" data-value="odds_b_3" onkeyup="keyupcheck(this)"></td>
			<td></td>
			<td></td>
			<td>C4</td>
			<td><input type="text" value="<?php  echo $odds['odds_C4'];?>" class="odds_a" name="odds[C4]" data-value="odds_c4" onkeyup="keyupcheck(this)"></td>
			<td></td>
			<td></td>
			<td>4D</td>
			<td><input type="text" value="<?php  echo $odds['odds_4D'];?>" class="odds_4a" name="odds[4D]" data-value="odds_4d" onkeyup="keyupcheck(this)"></td>
			<td></td>
			<td></td>
			<td>2D</td>
			<td><input type="text" value="<?php  echo $odds['odds_2D'];?>" class="odds_2a" name="odds[2D]" data-value="odds_2d" onkeyup="keyupcheck(this)"></td>
			<td></td>
			<td></td>
			<td>5D/4th</td>
			<td><input type="text" value="<?php  echo $odds['odds_5D']['3'];?>" class="odds_5d" name="odds[5D][]" data-value="odds_5d_3" onkeyup="keyupcheck(this)"></td>
			<td>6D/4th</td>
			<td><input type="text" value="<?php  echo $odds['odds_6D']['3'];?>" class="odds_6d" name="odds[6D][]" data-value="odds_6d_3" onkeyup="keyupcheck(this)"></td>
		</tr>
		<tr>
			<td>安慰奖</td>
			<td>B</td>
			<td><input type="text" value="<?php  echo $odds['odds_B']['4'];?>" class="odds_b" name="odds[B][]" data-value="odds_b_4" onkeyup="keyupcheck(this)"></td>
			<td></td>
			<td></td>
			<td>C5</td>
			<td><input type="text" value="<?php  echo $odds['odds_C5'];?>" class="odds_a" name="odds[C5]" data-value="odds_c5" onkeyup="keyupcheck(this)"></td>
			<td></td>
			<td></td>
			<td>4E</td>
			<td><input type="text" value="<?php  echo $odds['odds_4E'];?>" class="odds_4a" name="odds[4E]" data-value="odds_4e" onkeyup="keyupcheck(this)"></td>
			<td></td>
			<td></td>
			<td>2E</td>
			<td><input type="text" value="<?php  echo $odds['odds_2E'];?>" class="odds_2a" name="odds[2E]" data-value="odds_2e" onkeyup="keyupcheck(this)"></td>
			<td></td>
			<td></td>
			<td>5D/5th</td>
			<td><input type="text" value="<?php  echo $odds['odds_5D']['4'];?>" class="odds_5d" name="odds[5D][]" data-value="odds_5d_4" onkeyup="keyupcheck(this)"></td>
			<td>6D/5th</td>
			<td><input type="text" value="<?php  echo $odds['odds_6D']['4'];?>" class="odds_6d" name="odds[6D][]" data-value="odds_6d_4" onkeyup="keyupcheck(this)"></td>
		</tr>
		<tr>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td>EC</td>
			<td><input type="text" value="<?php  echo $odds['odds_EC'];?>" class="odds_a" name="odds[EC]" data-value="odds_ec" onkeyup="keyupcheck(this)"></td>
			<td></td>
			<td></td>
			<td>EA</td>
			<td><input type="text" value="<?php  echo $odds['odds_EA'];?>" class="odds_4a" name="odds[EA]" data-value="odds_ea" onkeyup="keyupcheck(this)"></td>
			<td></td>
			<td></td>
			<td>EX</td>
			<td><input type="text" value="<?php  echo $odds['odds_EX'];?>" class="odds_2a" name="odds[EX]" data-value="odds_ex" onkeyup="keyupcheck(this)"></td>
			<td></td>
			<td></td>
			<td>5D/1st</td>
			<td><input type="text" value="<?php  echo $odds['odds_5D']['5'];?>" class="odds_5d" name="odds[5D][]" data-value="odds_5d_5" onkeyup="keyupcheck(this)"></td>
			<td></td>
			<td></td>
		</tr>
	</table>
	</form>
<?php  } else if($op == 'posting') { ?>
	<style type="text/css">
		.table>tbody>tr>td{padding: 2px;}
	</style>
	<?php  if(is_array($list)) { foreach($list as $key => $item) { ?>
	<?php  if(!empty($item['post_key'])) { ?>
	<div class="col-xs-12" style="overflow-x: auto;width: 1000%;">
		<div style="margin: 10px 0;float: left;">
			<?php  echo $key;?>
			<table class="table table-bordered" style="overflow-y: auto;">
				<tr>
					<td></td>
					<td>号码</td>
					<?php  if(is_array($item['post_key'])) { foreach($item['post_key'] as $n) { ?>
					<?php  if(is_array($company)) { foreach($company as $com) { ?>
					<td><?php  echo $com['nickname'];?>/<?php  echo $n;?></td>
					<?php  } } ?>
					<?php  } } ?>
				</tr>
				<?php  if(is_array($item)) { foreach($item as $k => $num) { ?>
				<?php  if($k != 'post_key') { ?>
				<tr>
					<td><input type="checkbox" name="post_id" value="<?php  echo $li['number'];?>"></td>
					<td><?php  echo $k;?></td>
					<?php  if(is_array($item['post_key'])) { foreach($item['post_key'] as $n) { ?>
					<?php  if(is_array($company)) { foreach($company as $com) { ?>
					<td><?php echo $num[$com['id']][$n]?$num[$com['id']][$n]:0?></td>
					<?php  } } ?>
					<?php  } } ?>
				</tr>
				<?php  } ?>
				<?php  } } ?>
			</table>
		</div>
	</div>
	<?php  } ?>
	<?php  } } ?>
	<div class="col-xs-12">
		<div class="col-xs-12" style="padding: 1px 0;">
			Exclude All <input type="checkbox" id="check_all">
		</div>
		<div class="col-xs-12" style="padding: 0;">
			Post to partner
			<select name="post_to">
				<?php  if(is_array($partner)) { foreach($partner as $mem) { ?>
				<option value="<?php  echo $mem['port_id'];?>"><?php  echo $mem['account'];?></option>
				<?php  } } ?>
			</select>
			<select name="post_percent">
				<option value="100">100%</option>
				<option value="90">90%</option>
				<option value="80">80%</option>
				<option value="70">70%</option>
				<option value="60">60%</option>
				<option value="50">50%</option>
				<option value="40">40%</option>
				<option value="30">30%</option>
				<option value="20">20%</option>
				<option value="10">10%</option>
			</select>
			All counter <input type="checkbox" name="company_all"> | 
			<?php  if(is_array($company)) { foreach($company as $com) { ?>
			<?php  echo $com['nickname'];?> <input type="checkbox" name="post_company" value="<?php  echo $com['id'];?>">
			<?php  } } ?>
			<input type="button" name="submit" value="Post All" class="btn">
		</div>
	</div>
	<table class="table table-bordered">
		<tr>
			<td>Partner</td>
			<td>Recieve</td>
			<td>Post</td>
			<td>Return</td>
		</tr>
		<?php  if(is_array($partner)) { foreach($partner as $mem) { ?>
		<tr>
			<td><?php  echo $mem['account'];?></td>
			<td><?php  echo $mem['rec'];?></td>
			<td><?php  echo $mem['post'];?></td>
			<td><?php  echo $mem['return'];?></td>
		</tr>
		<?php  } } ?>
	</table>
<?php  } ?>
</div>
<script type="text/javascript">
	onLoadTimeChoiceDemo();
    borainTimeChoice({
        start:"#date",
        end:"",
        level:"YMD",
        less:false
    });
    $('input[name=company_all]').click(function() {
    	var checked = $(this).is(':checked');
    	if (checked === true) {
    		$('input[name=post_company]').prop('checked',true);
    	}
    	else{
    		$('input[name=post_company]').prop('checked',false);
    	}
    })
    $('#check_all').click(function() {
    	var checked = $(this).is(':checked');
    	if (checked == true) {
    		$('input[name=post_id]').prop('checked',true);
    	}
    	else{
    		$('input[name=post_id]').prop('checked',false);
    	}
    })
    $('input[name=submit]').click(function() {
    	var post_id = [];
    	var post_to = $('select[name=post_to]').val();
    	var company = [];
    	var percent = $('select[name=post_percent]').val();
    	var type = "<?php  echo $_GPC['type'];?>";
    	$('input[post_id]:checked').each(function() {
    		post_id.push($(this).val());
    	})
    	$('input[name=post_company]:checked').each(function() {
    		company.push($(this).val());
    	})
    	$.post("<?php  echo $this->createMobileUrl('number_post',array('op'=>'post'))?>",{post_id:post_id,post_to:post_to,company:company,percent:percent,type:type},function(result) {
    		alert(result.info);
    		if (result.status == 1) {
    			location.href = "<?php  echo $this->createMobileUrl('number_post')?>";
    		}
    	},'JSON');
    })
    function keyupcheck(obj) {
			obj.value = obj.value.replace(/[^\d.]/g,""); //清除"数字"和"."以外的字符
			obj.value = obj.value.replace(/^\./g,""); //验证第一个字符是数字
			obj.value = obj.value.replace(/\.{2,}/g,"."); //只保留第一个, 清除多余的
			obj.value = obj.value.replace(".","$#$").replace(/\./g,"").replace("$#$",".");
			var cl = $(obj).attr('class');
			if (cl == 'odds_b' || cl == 'odds_s' ||  cl == 'odds_4abc' || cl == 'odds_4a') {
				var odd = [];
				$('.'+cl).each(function () {
					odd.push(parseFloat($(this).val()));
				});
				if (cl == 'odds_4a') {
					var odds_check = get_max(odd);
				}
				else{
					var odds_check = getTotal(odd);
				}
				if (odds_check>10000) {
					$(obj).val('');
				}
			}
			if (cl == 'odds_3abc' || cl == 'odds_a') {
				var odd = [];
				$('.'+cl).each(function () {
					odd.push(parseFloat($(this).val()));
				});
				if (cl == 'odds_a') {
					var odds_check = get_max(odd);
				}
				else{
					var odds_check = getTotal(odd);
				}
				if (odds_check>1000) {
					$(obj).val('');
				}
			}
			if (cl == 'odds_2abc' || cl == 'odds_2a') {
				var odd = [];
				$('.'+cl).each(function () {
					odd.push(parseFloat($(this).val()));
				});
				if (cl == 'odds_2a') {
					var odds_check = get_max(odd);
				}
				else{
					var odds_check = getTotal(odd);
				}
				if (odds_check > 100) {
					$(obj).val('');
				}
			}
		}
		function cal_shuiqia(total_money, cashback_rate, jackpot_rate,number_type) {		
			var shui_qian_value =0;
			if (number_type == 3 ) {
				shui_qian_value = 100 - total_money - cashback_rate -  	jackpot_rate;
			}else if( number_type == 2 ){
				shui_qian_value = (1000 - total_money - cashback_rate*10 - jackpot_rate*10)/10;
			}else if( number_type == 1 ){
				shui_qian_value = (10000 - total_money - cashback_rate*100 - jackpot_rate*100)/100;
			}
			else if (number_type == 4) {
				shui_qian_value = (100000 - total_money - cashback_rate*1000 - jackpot_rate*1000)/1000;
			}
			else if (number_type == 5) {
				shui_qian_value = (1000000 - total_money - cashback_rate*10000 - jackpot_rate*10000)/10000;
			}

			if (shui_qian_value < 0) {
				shui_qian_value = 0;
			}
			if ( shui_qian_value > 100 ) {
				shui_qian_value = 100;
			}
			return shui_qian_value;
		}
		function cal_cashback() {
			var odds_b = [];
			var odds_s = [];
			var odds_a = [];
			var odds_3abc = [];
			var odds_4a = [];
			var odds_4abc = [];
			var odds_2a = [];
			var odds_2abc = [];
			var odds_5d = [];
			var odds_6d = [];
			var my_cashback = [];
			var commission = [];
			var used_odds = $('#used_odds').val();

			$('.my_cashback').each(function() {
				my_cashback.push(parseFloat($(this).val()));
			});
			$('.commission').each(function() {
				commission.push(parseFloat($(this).val()));
			});

			$('.odds_b').each(function () {
				odds_b.push(parseFloat($(this).val()));
			});
			var odds_b_total = getTotal(odds_b);
			var cashback_money_b = cal_shuiqia(odds_b_total,(my_cashback[0]+commission[0]),0,1);
			

			$('.odds_s').each(function () {
				odds_s.push(parseFloat($(this).val()));
			});
			var odds_s_total = getTotal(odds_s);
			var cashback_money_s = cal_shuiqia(odds_s_total,(my_cashback[1]+commission[1]),0,1);

			$('.odds_3abc').each(function () {
				odds_3abc.push(parseFloat($(this).val()));
			});
			setallodds(odds_3abc[0],'odds_3abc');
			odds_3abc = [];
			$('.odds_3abc').each(function () {
				odds_3abc.push(parseFloat($(this).val()));
			});
			var odds_3abc_total = getTotal(odds_3abc);
			var cashback_money_3abc = cal_shuiqia(odds_3abc_total,(my_cashback[3]+commission[3]),0,2);

			$('.odds_4abc').each(function () {
				odds_4abc.push(parseFloat($(this).val()));
			});
			setallodds(odds_4abc[0],'odds_4abc');
			odds_4abc = [];
			$('.odds_4abc').each(function () {
				odds_4abc.push(parseFloat($(this).val()));
			});
			var odds_4abc_total = getTotal(odds_4abc);
			var cashback_money_4abc = cal_shuiqia(odds_4abc_total,(my_cashback[5]+commission[5]),0,1);

			$('.odds_2abc').each(function () {
				odds_2abc.push(parseFloat($(this).val()));
			});
			setallodds(odds_2abc[0],'odds_2abc');
			odds_2abc = [];
			$('.odds_2abc').each(function () {
				odds_2abc.push(parseFloat($(this).val()));
			});
			var odds_2abc_total = getTotal(odds_2abc);
			var cashback_money_2abc = cal_shuiqia(odds_2abc_total,(my_cashback[7]+commission[7]),0,3);

			$('.odds_2a').each(function () {
				odds_2a.push(parseFloat($(this).val()));
			});
			var odds_2a_max = get_max(odds_2a);
			var cashback_money_2a = cal_shuiqia(odds_2a_max,(my_cashback[6]+commission[6]),0,3);
			setallodds(odds_2a_max,'odds_2a');

			$('.odds_4a').each(function () {
				odds_4a.push(parseFloat($(this).val()));
			});
			var odds_4a_max = get_max(odds_4a);
			var cashback_money_4a = cal_shuiqia(odds_4a_max,(my_cashback[4]+commission[4]),0,1);
			setallodds(odds_4a_max,'odds_4a');

			$('.odds_a').each(function () {
				odds_a.push(parseFloat($(this).val()));
			});
			var odds_a_max = get_max(odds_a);
			var cashback_money_a = cal_shuiqia(odds_a_max,(my_cashback[2]+commission[2]),0,2);
			setallodds(odds_a_max,'odds_a');

			$('.odds_5d').each(function() {
				odds_5d.push($(this).val());
			});
			var odds_5d_total = get_5d_total(odds_5d);
			var cashback_money_5d = cal_shuiqia(odds_5d_total,(my_cashback[8]+commission[8]),0,4);

			$('.odds_6d').each(function() {
				odds_6d.push($(this).val());
			});
			var odds_6d_total = get_6d_total(odds_6d);
			var cashback_money_6d = cal_shuiqia(odds_6d_total,(my_cashback[9]+commission[9]),0,5);
			$('#cashback_money_b').text(Math.round(cashback_money_b));
			$('#cashback_money_s').text(Math.round(cashback_money_s));
			$('#cashback_money_a').text(Math.round(cashback_money_a));
			$('#cashback_money_3abc').text(Math.round(cashback_money_3abc));
			$('#cashback_money_4a').text(Math.round(cashback_money_4a));
			$('#cashback_money_4abc').text(Math.round(cashback_money_4abc));
			$('#cashback_money_2a').text(Math.round(cashback_money_2a));
			$('#cashback_money_2abc').text(Math.round(cashback_money_2abc));
			$('#cashback_money_5d').text(Math.round(cashback_money_5d));
			$('#cashback_money_6d').text(Math.round(cashback_money_6d));
		}

		function get_5d_total(odds) {
			var total_odds = 0;
			for (var i = 0; i < 6; i++) {
				if (i == 3) {
					total_odds = total_odds+(odds[i]*10*2);
				}
				else if (i == 4) {
					total_odds = total_odds+(odds[i]*100*2);
				}
				else if (i == 5) {
					total_odds = total_odds+(odds[i]*1000*2);
				}
				else{
					total_odds = total_odds+parseFloat(odds[i]);
				}
			}
			return total_odds;
		}

		function get_6d_total(odds) {
			var total_odds = 0;
			for (var i = 0; i < 5; i++) {
				if (i == 1) {
					total_odds = total_odds+(odds[i]*10*2);
				}
				else if (i == 2) {
					total_odds = total_odds+(odds[i]*100*2);
				}
				else if (i == 3) {
					total_odds = total_odds+(odds[i]*1000*2);
				}
				else if (i == 4) {
					total_odds = total_odds+(odds[i]*10000*2);
				}
				else{
					total_odds = total_odds+parseFloat(odds[i]);
				}
			}
			return total_odds;
		}
		$('input').blur(function () {
			cal_cashback();
		});
		function setallodds(odd,cl) {
			if (cl == 'odds_a') {
				$('input[data-value=odds_a]').val(odd);
				$('input[data-value=odds_c2]').val(odd);
				$('input[data-value=odds_c3]').val(odd);
				$('input[data-value=odds_c4]').val(odd/10);
				$('input[data-value=odds_c5]').val(odd/10);
				$('input[data-value=odds_ec]').val(odd/23);
			}
			if (cl == 'odds_2a') {
				$('input[data-value=odds_2a]').val(odd);
				$('input[data-value=odds_2b]').val(odd);
				$('input[data-value=odds_2c]').val(odd);
				$('input[data-value=odds_2d]').val(odd/10);
				$('input[data-value=odds_2e]').val(odd/10);
				$('input[data-value=odds_ex]').val(odd/23);
			}
			if (cl == 'odds_4a') {
				$('input[data-value=odds_4a]').val(odd);
				$('input[data-value=odds_4b]').val(odd);
				$('input[data-value=odds_4c]').val(odd);
				$('input[data-value=odds_4d]').val(odd/10);
				$('input[data-value=odds_4e]').val(odd/10);
				$('input[data-value=odds_ea]').val(odd/23);
			}
			if (cl == 'odds_s' || cl == 'odds_3abc' || cl == 'odds_4abc' || cl == 'odds_2abc') {
				$('.'+cl).val(odd);
			}
		}
		function get_max(obj) {
			var max = obj[0];
			var len = obj.length;
			for (var i = 1; i < len; i++){
				if (i >= 3) {
					odd = obj[i]*10;
				}
				else{
					odd = obj[i];
				}
				if (odd > max) {
					max = odd;
				}
			}
			return max;
		}
		function getTotal(obj) {
			var len = obj.length;
			var total = 0;
			for (var i = 0; i < len; i++) {
				if (i>=3) {
					total = total + obj[i]*10;
				}
				else{
					total = total + obj[i];
				}
			}
			return total;
		}
</script>
<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('footer', TEMPLATE_INCLUDEPATH)) : (include template('footer', TEMPLATE_INCLUDEPATH));?>