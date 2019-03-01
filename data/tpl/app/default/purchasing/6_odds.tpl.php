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
<?php  if($tab == 'display') { ?>
<div class="col-xs-12">
	<div class="col-xs-12" style="padding: 5px 0;">
		<ul class="nav nav-tabs">
            <li <?php  if($cid == 1) { ?> class="active" <?php  } ?>><a href="<?php  echo $this->createMobileUrl('manager',array('op'=>'odds','cid'=>1))?>">JUBAO</a></li>
            <?php  if($_SESSION['cid'] > 1) { ?>
            <li <?php  if($cid > 1) { ?> class="active" <?php  } ?>><a href="<?php  echo $this->createMobileUrl('manager',array('op'=>'odds','cid'=>$_SESSION['cid']))?>">Other</a></li>
            <?php  } ?>
        </ul>
	</div>
	<?php  if(($cid == 1 && $_SESSION['cid'] == 1) || ($cid != 1 && $_SESSION['cid'] != 1) || $_SESSION['level'] == 1) { ?>
	<div class="col-xs-12" style="padding: 5px 0;">
		<button type="button" class="btn" onclick="set_odds();">增加配套</button>
	</div>
	<?php  } ?>
	<?php  if(is_array($list)) { foreach($list as $gp) { ?>
	<table class="table table-bordered" style="margin-bottom: 5px;">
		<tr>
			<td colspan="6" style="text-align: center;">
				group:<?php  echo $gp['group_name'];?>
			</td>
		</tr>
		<tr>
			<td></td>
			<td></td>
			<td>ID</td>
			<td>BSAC4A2A</td>
			<td>水钱</td>
			<td>操作</td>
		</tr>
		<?php  if(is_array($gp['odds'])) { foreach($gp['odds'] as $item) { ?>
		<tr>
			<td><a href="javascript:void(0)" onclick="set_odds(<?php  echo $item['id'];?>)"><span>修改</span></a></td>
			<td><a href="javascript:void(0)" data-toggle="collapse" data-target="#detail_<?php  echo $item['id'];?>"><span>详细</span></a></td>
			<td>a<?php  echo $item['id'];?></td>
			<td><?php  echo $item['odds_B']['0'];?>/<?php  echo $item['odds_S']['0'];?>/<?php  echo $item['odds_A'];?>/<?php  echo $item['odds_3ABC']['0'];?>/<?php  echo $item['odds_4A'];?>/<?php  echo $item['odds_2A'];?></td>
			<td><?php  echo $item['cashback']['B'];?>-<?php  echo $item['cashback']['S'];?>-<?php  echo $item['cashback']['A'];?>-<?php  echo $item['cashback']['3ABC'];?>-<?php  echo $item['cashback']['4A'];?>-<?php  echo $item['cashback']['2A'];?></td>
			<td>
				<button type="button" class="btn" onclick="freeze_odds(<?php  echo $item['id'];?>,<?php  echo $item['status'];?>)"><?php  if($item['status'] == 1) { ?>冻结配套<?php  } else { ?>解冻配套<?php  } ?></button>
				<!-- <button type="button" class="btn" onclick="set_odds(<?php  echo $item['id'];?>)">修改</button> -->
				<button type="button" class="btn" onclick="del_odds(<?php  echo $item['id'];?>)">删除</button>
			</td>
		</tr>
		<tr id="detail_<?php  echo $item['id'];?>" class="collapse">
			<td colspan="7" style="padding: 0;border: 0;">
				<table class="table table-bordered">
					<tr>
						<td style="width: 3vw;">抽佣</td>
						<td>B</td>
						<td><?php  echo $item['commission']['B'];?></td>
						<td>S</td>
						<td><?php  echo $item['commission']['S'];?></td>
						<td>A~EC</td>
						<td><?php  echo $item['commission']['A'];?></td>
						<td>3ABC</td>
						<td><?php  echo $item['commission']['3ABC'];?></td>
						<td>4A~EA</td>
						<td><?php  echo $item['commission']['4A'];?></td>
						<td>4AC</td>
						<td><?php  echo $item['commission']['4ABC'];?></td>
						<td>2A~EX</td>
						<td><?php  echo $item['commission']['2A'];?></td>
						<td>2ABC</td>
						<td><?php  echo $item['commission']['2ABC'];?></td>
						<td>5D</td>
						<td><?php  echo $item['commission']['5D'];?></td>
						<td>6D</td>
						<td><?php  echo $item['commission']['6D'];?></td>
					</tr>
					<tr>
						<td>水钱</td>
						<td></td>
						<td><span><?php  echo $item['cashback']['B'];?></span></td>
						<td></td>
						<td><span><?php  echo $item['cashback']['S'];?></span></td>
						<td></td>
						<td><span><?php  echo $item['cashback']['A'];?></span></td>
						<td></td>
						<td><span><?php  echo $item['cashback']['3ABC'];?></span></td>
						<td></td>
						<td><span><?php  echo $item['cashback']['4A'];?></span></td>
						<td></td>
						<td><span><?php  echo $item['cashback']['4ABC'];?></span></td>
						<td></td>
						<td><span><?php  echo $item['cashback']['2A'];?></span></td>
						<td></td>
						<td><span><?php  echo $item['cashback']['2ABC'];?></span></td>
						<td></td>
						<td><span><?php  echo $item['cashback']['5D'];?></span></td>
						<td></td>
						<td><span><?php  echo $item['cashback']['6D'];?></span></td>
					</tr>
					<tr>
						<td>头奖</td>
						<td>B</td>
						<td><?php  echo $item['odds_B']['0'];?></td>
						<td>S</td>
						<td><?php  echo $item['odds_S']['0'];?></td>
						<td>A</td>
						<td><?php  echo $item['odds_A'];?></td>
						<td>3ABC</td>
						<td><?php  echo $item['odds_3ABC']['0'];?></td>
						<td>4A</td>
						<td><?php  echo $item['odds_4A'];?></td>
						<td>4AC</td>
						<td><?php  echo $item['odds_4ABC']['0'];?></td>
						<td>2A</td>
						<td><?php  echo $item['odds_2A'];?></td>
						<td>2ABC</td>
						<td><?php  echo $item['odds_2ABC']['0'];?></td>
						<td>5D/1st</td>
						<td><?php  echo $item['odds_5D']['0'];?></td>
						<td>6D/1st</td>
						<td><?php  echo $item['odds_6D']['0'];?></td>
					</tr>
					<tr>
						<td>二奖</td>
						<td>B</td>
						<td><?php  echo $item['odds_B']['1'];?></td>
						<td>S</td>
						<td><?php  echo $item['odds_S']['1'];?></td>
						<td>C2</td>
						<td><?php  echo $item['odds_C2'];?></td>
						<td>3ABC</td>
						<td><?php  echo $item['odds_3ABC']['1'];?></td>
						<td>4B</td>
						<td><?php  echo $item['odds_4B'];?></td>
						<td>4AC</td>
						<td><?php  echo $item['odds_4ABC']['1'];?></td>
						<td>2B</td>
						<td><?php  echo $item['odds_2B'];?></td>
						<td>2ABC</td>
						<td><?php  echo $item['odds_2ABC']['1'];?></td>
						<td>5D/2nd</td>
						<td><?php  echo $item['odds_5D']['1'];?></td>
						<td>6D/2nd</td>
						<td><?php  echo $item['odds_6D']['1'];?></td>
					</tr>
					<tr>
						<td>三奖</td>
						<td>B</td>
						<td><?php  echo $item['odds_B']['2'];?></td>
						<td>S</td>
						<td><?php  echo $item['odds_S']['2'];?></td>
						<td>C3</td>
						<td><?php  echo $item['odds_C3'];?></td>
						<td>3ABC</td>
						<td><?php  echo $item['odds_3ABC']['2'];?></td>
						<td>4C</td>
						<td><?php  echo $item['odds_4C'];?></td>
						<td>4AC</td>
						<td><?php  echo $item['odds_4ABC']['2'];?></td>
						<td>2C</td>
						<td><?php  echo $item['odds_2C'];?></td>
						<td>2ABC</td>
						<td><?php  echo $item['odds_2ABC']['2'];?></td>
						<td>5D/3rd</td>
						<td><?php  echo $item['odds_5D']['2'];?></td>
						<td>6D/3rd</td>
						<td><?php  echo $item['odds_6D']['2'];?></td>
					</tr>
					<tr>
						<td>特别奖</td>
						<td>B</td>
						<td><?php  echo $item['odds_B']['3'];?></td>
						<td></td>
						<td></td>
						<td>C4</td>
						<td><?php  echo $item['odds_C4'];?></td>
						<td></td>
						<td></td>
						<td>4D</td>
						<td><?php  echo $item['odds_4D'];?></td>
						<td></td>
						<td></td>
						<td>2D</td>
						<td><?php  echo $item['odds_2D'];?></td>
						<td></td>
						<td></td>
						<td>5D/4th</td>
						<td><?php  echo $item['odds_5D']['3'];?></td>
						<td>6D/4th</td>
						<td><?php  echo $item['odds_6D']['3'];?></td>
					</tr>
					<tr>
						<td>安慰奖</td>
						<td>B</td>
						<td><?php  echo $item['odds_B']['4'];?></td>
						<td></td>
						<td></td>
						<td>C5</td>
						<td><?php  echo $item['odds_C5'];?></td>
						<td></td>
						<td></td>
						<td>4E</td>
						<td><?php  echo $item['odds_4E'];?></td>
						<td></td>
						<td></td>
						<td>2E</td>
						<td><?php  echo $item['odds_2E'];?></td>
						<td></td>
						<td></td>
						<td>5D/5th</td>
						<td><?php  echo $item['odds_5D']['4'];?></td>
						<td>6D/5th</td>
						<td><?php  echo $item['odds_6D']['4'];?></td>
					</tr>
					<tr>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td>EC</td>
						<td><?php  echo $item['odds_EC'];?></td>
						<td></td>
						<td></td>
						<td>EA</td>
						<td><?php  echo $item['odds_EA'];?></td>
						<td></td>
						<td></td>
						<td>EX</td>
						<td><?php  echo $item['odds_EX'];?></td>
						<td></td>
						<td></td>
						<td>5D/6th</td>
						<td><?php  echo $item['odds_5D']['5'];?></td>
						<td></td>
						<td></td>
					</tr>
				</table>
			</td>
		</tr>
		<?php  } } ?>
	</table>
	<?php  } } ?>
</div>
<div id="odds-set" class="recharge-area">
	<div class="recharge-main" style="height: 25vw;width: 95%;overflow-y: auto;">
		<div class="recharge-head">
			设置配套
		</div>
		<div class="recharge-body" style="padding: 10px 15px;">
			<table class="table table-bordered">
				<tr>
					<td style="width: 70px;">分组</td>
					<td colspan="9">
						<select name="gid">
							<?php  if(is_array($group)) { foreach($group as $g) { ?>
							<option value="<?php  echo $g['id'];?>"><?php  echo $g['group_name'];?></option>
							<?php  } } ?>
						</select>
					</td>
					<?php  if($_SESSION['level'] == 1 || $_SESSION['cid'] == 1) { ?>
					<td>盘口</td>
					<td colspan="10">
						<label>
							<input type="checkbox" name="cid" value="1">JUBAO
						</label>
					</td>
					<?php  } ?>
				</tr>
				<tr>
					<td style="width: 3vw;">抽佣</td>
					<td>B</td>
					<td><input type="text" name="cashback_b" value="0" class="my_cashback"></td>
					<td>S</td>
					<td><input type="text" name="cashback_s" value="0" class="my_cashback"></td>
					<td>A~EC</td>
					<td><input type="text" name="cashback_a" value="0" class="my_cashback"></td>
					<td>3ABC</td>
					<td><input type="text" name="cashback_3abc" value="0" class="my_cashback"></td>
					<td>4A~EA</td>
					<td><input type="text" name="cashback_4a" value="0" class="my_cashback"></td>
					<td>4AC</td>
					<td><input type="text" name="cashback_4abc" value="0" class="my_cashback"></td>
					<td>2A~EX</td>
					<td><input type="text" name="cashback_2a" value="0" class="my_cashback"></td>
					<td>2ABC</td>
					<td><input type="text" name="cashback_2abc" value="0" class="my_cashback"></td>
					<td>5D</td>
					<td><input type="text" name="cashback_5d" value="0" class="my_cashback"></td>
					<td>6D</td>
					<td><input type="text" name="cashback_6d" value="0" class="my_cashback"></td>
				</tr>
				<tr>
					<td>水钱</td>
					<td></td>
					<td><span id="cashback_money_b"></span></td>
					<td></td>
					<td><span id="cashback_money_s"></span></td>
					<td></td>
					<td><span id="cashback_money_a"></span></td>
					<td></td>
					<td><span id="cashback_money_3abc"></span></td>
					<td></td>
					<td><span id="cashback_money_4a"></span></td>
					<td></td>
					<td><span id="cashback_money_4abc"></span></td>
					<td></td>
					<td><span id="cashback_money_2a"></span></td>
					<td></td>
					<td><span id="cashback_money_2abc"></span></td>
					<td></td>
					<td><span id="cashback_money_5d"></span></td>
					<td></td>
					<td><span id="cashback_money_6d"></span></td>
				</tr>
				<tr>
					<td style="width: 70px;">头奖</td>
					<td style="width: 30px;">B</td>
					<td style="width: 100px;"><input type="text" value="0" class="odds_b" name="odds[B][]" data-value="odds_b_0" onkeyup="keyupcheck(this)"></td>
					<td style="width: 30px;">S</td>
					<td style="width: 100px;"><input type="text" value="0" class="odds_s" name="odds[S][]" data-value="odds_s_0" onkeyup="keyupcheck(this)"></td>
					<td style="width: 30px;">A</td>
					<td style="width: 100px;"><input type="text" value="0" class="odds_a" name="odds[A][]" data-value="odds_a" onkeyup="keyupcheck(this)"></td>
					<td style="width: 70px;">3ABC</td>
					<td style="width: 100px;"><input type="text" value="0" class="odds_3abc" name="odds[3ABC][]" data-value="odds_3abc_0" onkeyup="keyupcheck(this)"></td>
					<td style="width: 30px;">4A</td>
					<td style="width: 100px;"><input type="text" value="0" class="odds_4a" name="odds[4A][]" data-value="odds_4a" onkeyup="keyupcheck(this)"></td>
					<td style="width: 60px;">4AC</td>
					<td style="width: 100px;"><input type="text" value="0" class="odds_4abc" name="odds[4ABC][]" data-value="odds_4abc_0" onkeyup="keyupcheck(this)"></td>
					<td style="width: 30px;">2A</td>
					<td style="width: 100px;"><input type="text" value="0" class="odds_2a" name="odds[2A][]" data-value="odds_2a" onkeyup="keyupcheck(this)"></td>
					<td style="width: 70px;">2ABC</td>
					<td style="width: 100px;"><input type="text" value="0" class="odds_2abc" name="odds[2ABC][]" data-value="odds_2abc_0" onkeyup="keyupcheck(this)"></td>
					<td style="width: 70px">5D/1st</td>
					<td style="width: 100px;"><input type="text" value="0" class="odds_5d" name="odds[5D][]" data-value="odds_5d_0" onkeyup="keyupcheck(this)"></td>
					<td style="width: 70px">6D/1st</td>
					<td style="width: 100px;"><input type="text" value="0" class="odds_6d" name="odds[6D][]" data-value="odds_6d_0" onkeyup="keyupcheck(this)"></td>
				</tr>
				<tr>
					<td>二奖</td>
					<td>B</td>
					<td><input type="text" value="0" class="odds_b" name="odds[B][]" data-value="odds_b_1" onkeyup="keyupcheck(this)"></td>
					<td>S</td>
					<td><input type="text" value="0" class="odds_s" name="odds[S][]" data-value="odds_s_1" onkeyup="keyupcheck(this)"></td>
					<td>C2</td>
					<td><input type="text" value="0" class="odds_a" name="odds[C2][]" data-value="odds_c2" onkeyup="keyupcheck(this)"></td>
					<td>3ABC</td>
					<td><input type="text" value="0" class="odds_3abc" name="odds[3ABC][]" data-value="odds_3abc_1" onkeyup="keyupcheck(this)"></td>
					<td>4B</td>
					<td><input type="text" value="0" class="odds_4a" name="odds[4B][]" data-value="odds_4b" onkeyup="keyupcheck(this)"></td>
					<td>4AC</td>
					<td><input type="text" value="0" class="odds_4abc" name="odds[4ABC][]" data-value="odds_4abc_1" onkeyup="keyupcheck(this)"></td>
					<td>2B</td>
					<td><input type="text" value="0" class="odds_2a" name="odds[2B][]" data-value="odds_2b" onkeyup="keyupcheck(this)"></td>
					<td>2ABC</td>
					<td><input type="text" value="0" class="odds_2abc" name="odds[2ABC][]" data-value="odds_2abc_1" onkeyup="keyupcheck(this)"></td>
					<td>5D/2nd</td>
					<td><input type="text" value="0" class="odds_5d" name="odds[5D][]" data-value="odds_5d_1" onkeyup="keyupcheck(this)"></td>
					<td>6D/2nd</td>
					<td><input type="text" value="0" class="odds_6d" name="odds[6D][]" data-value="odds_6d_1" onkeyup="keyupcheck(this)"></td>
				</tr>
				<tr>
					<td>三奖</td>
					<td>B</td>
					<td><input type="text" value="0" class="odds_b" name="odds[B][]" data-value="odds_b_2" onkeyup="keyupcheck(this)"></td>
					<td>S</td>
					<td><input type="text" value="0" class="odds_s" name="odds[S][]" data-value="odds_s_2" onkeyup="keyupcheck(this)"></td>
					<td>C3</td>
					<td><input type="text" value="0" class="odds_a" name="odds[C3][]" data-value="odds_c3" onkeyup="keyupcheck(this)"></td>
					<td>3ABC</td>
					<td><input type="text" value="0" class="odds_3abc" name="odds[3ABC][]" data-value="odds_3abc_2" onkeyup="keyupcheck(this)"></td>
					<td>4C</td>
					<td><input type="text" value="0" class="odds_4a" name="odds[4C][]" data-value="odds_4c" onkeyup="keyupcheck(this)"></td>
					<td>4AC</td>
					<td><input type="text" value="0" class="odds_4abc" name="odds[4ABC][]" data-value="odds_4abc_2" onkeyup="keyupcheck(this)"></td>
					<td>2C</td>
					<td><input type="text" value="0" class="odds_2a" name="odds[2C][]" data-value="odds_2c" onkeyup="keyupcheck(this)"></td>
					<td>2ABC</td>
					<td><input type="text" value="0" class="odds_2abc" name="odds[2ABC][]" data-value="odds_2abc_2" onkeyup="keyupcheck(this)"></td>
					<td>5D/3rd</td>
					<td><input type="text" value="0" class="odds_5d" name="odds[5D][]" data-value="odds_5d_2" onkeyup="keyupcheck(this)"></td>
					<td>6D/3rd</td>
					<td><input type="text" value="0" class="odds_6d" name="odds[6D][]" data-value="odds_6d_2" onkeyup="keyupcheck(this)"></td>
				</tr>
				<tr>
					<td>特别奖</td>
					<td>B</td>
					<td><input type="text" value="0" class="odds_b" name="odds[B][]" data-value="odds_b_3" onkeyup="keyupcheck(this)"></td>
					<td></td>
					<td></td>
					<td>C4</td>
					<td><input type="text" value="0" class="odds_a" name="odds[C4][]" data-value="odds_c4" onkeyup="keyupcheck(this)"></td>
					<td></td>
					<td></td>
					<td>4D</td>
					<td><input type="text" value="0" class="odds_4a" name="odds[4D][]" data-value="odds_4d" onkeyup="keyupcheck(this)"></td>
					<td></td>
					<td></td>
					<td>2D</td>
					<td><input type="text" value="0" class="odds_2a" name="odds[2D][]" data-value="odds_2d" onkeyup="keyupcheck(this)"></td>
					<td></td>
					<td></td>
					<td>5D/4th</td>
					<td><input type="text" value="0" class="odds_5d" name="odds[5D][]" data-value="odds_5d_3" onkeyup="keyupcheck(this)"></td>
					<td>6D/4th</td>
					<td><input type="text" value="0" class="odds_6d" name="odds[6D][]" data-value="odds_6d_3" onkeyup="keyupcheck(this)"></td>
				</tr>
				<tr>
					<td>安慰奖</td>
					<td>B</td>
					<td><input type="text" value="0" class="odds_b" name="odds[B][]" data-value="odds_b_4" onkeyup="keyupcheck(this)"></td>
					<td></td>
					<td></td>
					<td>C5</td>
					<td><input type="text" value="0" class="odds_a" name="odds[C5][]" data-value="odds_c5" onkeyup="keyupcheck(this)"></td>
					<td></td>
					<td></td>
					<td>4E</td>
					<td><input type="text" value="0" class="odds_4a" name="odds[4E][]" data-value="odds_4e" onkeyup="keyupcheck(this)"></td>
					<td></td>
					<td></td>
					<td>2E</td>
					<td><input type="text" value="0" class="odds_2a" name="odds[2E][]" data-value="odds_2e" onkeyup="keyupcheck(this)"></td>
					<td></td>
					<td></td>
					<td>5D/5th</td>
					<td><input type="text" value="0" class="odds_5d" name="odds[5D][]" data-value="odds_5d_4" onkeyup="keyupcheck(this)"></td>
					<td>6D/5th</td>
					<td><input type="text" value="0" class="odds_6d" name="odds[6D][]" data-value="odds_6d_4" onkeyup="keyupcheck(this)"></td>
				</tr>
				<tr>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td>EC</td>
					<td><input type="text" value="0" class="odds_a" name="odds[EC][]" data-value="odds_ec" onkeyup="keyupcheck(this)"></td>
					<td></td>
					<td></td>
					<td>EA</td>
					<td><input type="text" value="0" class="odds_4a" name="odds[EA][]" data-value="odds_ea" onkeyup="keyupcheck(this)"></td>
					<td></td>
					<td></td>
					<td>EX</td>
					<td><input type="text" value="0" class="odds_2a" name="odds[EX][]" data-value="odds_ex" onkeyup="keyupcheck(this)"></td>
					<td></td>
					<td></td>
					<td>5D/6th</td>
					<td><input type="text" value="0" class="odds_5d" name="odds[5D][]" data-value="odds_5d_5" onkeyup="keyupcheck(this)"></td>
					<td></td>
					<td></td>
				</tr>
				<tr>
					<td colspan="21">
						<input type="hidden" name="id" id="odds_id">
						<a href="javascript:void(0);" class="btn" onclick="odds_post()">提交</a>
						<a href="javascript:void(0);" class="btn" onclick="$('#odds-set').hide();">取消</a>
					</td>
				</tr>
			</table>
		</div>
	</div>
</div>
<script type="text/javascript">
	function set_odds(id) {
		if (id > 0) {
			$('#odds_id').val(id);
			$.post("<?php  echo $this->createMobileUrl('odds',array('op'=>'detail'))?>",{id:id},function(result) {
				var list = result.list;
				var odds_b = list.odds_B;
				var odds_s = list.odds_S;
				var odds_3abc = list.odds_3ABC;
				var odds_4abc = list.odds_4ABC;
				var odds_2abc = list.odds_2ABC;
				var odds_5d = list.odds_5D;
				var odds_6d = list.odds_6D;
				var commission = list.commission;
				for (var i = 0 in odds_b) {
					$('input[data-value=odds_b_'+i+']').val(odds_b[i]);
				}
				for (var j = 0 in odds_s) {
					$('input[data-value=odds_s_'+j+']').val(odds_s[j]);
				}
				for (var k = 0 in odds_3abc) {
					$('input[data-value=odds_3abc_'+k+']').val(odds_3abc[k]);
				}
				for (var l = 0 in odds_4abc) {
					$('input[data-value=odds_4abc_'+l+']').val(odds_4abc[l]);
				}
				for (var m = 0 in odds_2abc) {
					$('input[data-value=odds_2abc_'+m+']').val(odds_2abc[m]);
				}
				for (var n = 0 in odds_5d) {
					$('input[data-value=odds_5d_'+n+']').val(odds_5d[n]);
				}
				for (var o = 0 in odds_6d) {
					$('input[data-value=odds_6d_'+o+']').val(odds_6d[o]);
				}
				for (var c in commission) {
					$('input[name=cashback_'+c.toLowerCase()+']').val(commission[c]);
				}
				$('input[data-value=odds_a]').val(list.odds_A);
				$('input[data-value=odds_c2]').val(list.odds_C2);
				$('input[data-value=odds_c3]').val(list.odds_C3);
				$('input[data-value=odds_c4]').val(list.odds_C4);
				$('input[data-value=odds_c5]').val(list.odds_C5);
				$('input[data-value=odds_4a]').val(list.odds_4A);
				$('input[data-value=odds_4b]').val(list.odds_4B);
				$('input[data-value=odds_4c]').val(list.odds_4C);
				$('input[data-value=odds_4d]').val(list.odds_4D);
				$('input[data-value=odds_4e]').val(list.odds_4E);
				$('input[data-value=odds_2a]').val(list.odds_2A);
				$('input[data-value=odds_2b]').val(list.odds_2B);
				$('input[data-value=odds_2c]').val(list.odds_2C);
				$('input[data-value=odds_2d]').val(list.odds_2D);
				$('input[data-value=odds_2e]').val(list.odds_2E);
				$('input[data-value=odds_ec]').val(list.odds_EC);
				$('input[data-value=odds_ea]').val(list.odds_EA);
				$('input[data-value=odds_ex]').val(list.odds_EX);
				$('input[name=title]').val(list.title);
				var cid = list.cid;
				for (var i = 0 in cid) {
					$('input[value='+cid[i]+']').prop('checked',true);
				}
				cal_cashback();
				$('#odds-set').show();
			},'JSON');
		}
		else{
			$('#odds_id').val('');
			for (var i = 0 ; i < 5;i++) {
				$('input[data-value=odds_b_'+i+']').val(0);
			}
			for (var j = 0; j < 3;j++) {
				$('input[data-value=odds_s_'+j+']').val(0);
			}
			for (var k = 0; k < 3;k++) {
				$('input[data-value=odds_3abc_'+k+']').val(0);
			}
			for (var l = 0; l < 3;l++) {
				$('input[data-value=odds_4abc_'+l+']').val(0);
			}
			for (var m = 0; m < 3;m++) {
				$('input[data-value=odds_2abc_'+m+']').val(0);
			}
			for (var n = 0; n < 6;n++) {
				$('input[data-value=odds_5d_'+n+']').val(0);
			}
			for (var o = 0; o < 5;o++) {
				$('input[data-value=odds_6d_'+o+']').val(0);
			}
			$('.my_cashback').val(0);
			$('input[data-value=odds_a]').val(0);
			$('input[data-value=odds_c2]').val(0);
			$('input[data-value=odds_c3]').val(0);
			$('input[data-value=odds_c4]').val(0);
			$('input[data-value=odds_c5]').val(0);
			$('input[data-value=odds_4a]').val(0);
			$('input[data-value=odds_4b]').val(0);
			$('input[data-value=odds_4c]').val(0);
			$('input[data-value=odds_4d]').val(0);
			$('input[data-value=odds_4e]').val(0);
			$('input[data-value=odds_2a]').val(0);
			$('input[data-value=odds_2b]').val(0);
			$('input[data-value=odds_2c]').val(0);
			$('input[data-value=odds_2d]').val(0);
			$('input[data-value=odds_2e]').val(0);
			$('input[data-value=odds_ec]').val(0);
			$('input[data-value=odds_ea]').val(0);
			$('input[data-value=odds_ex]').val(0);
			$('input[name=title]').val('');
			$('#cashback_money_b').text(0);
			$('#cashback_money_s').text(0);
			$('#cashback_money_a').text(0);
			$('#cashback_money_3abc').text(0);
			$('#cashback_money_4a').text(0);
			$('#cashback_money_4abc').text(0);
			$('#cashback_money_2a').text(0);
			$('#cashback_money_2abc').text(0);
			$('#cashback_money_5d').text(0);
			$('#cashback_money_6d').text(0);
		}
		$('#odds-set').show();
	}
	function del_odds(id) {
		var a = confirm('确定删除该配套？');
		if (a == true) {
			$.post("<?php  echo $this->createMobileUrl('odds',array('op'=>'del'))?>",{id:id},function (result) {
				alert(result.info);
				if (result.status == 1) {
					window.location.reload();
				}
				if (result.status == 3) {
					location.href = "<?php  echo $this->createMobileUrl('login')?>";
				}
			},'JSON')
		}
	}
	function freeze_odds(id,status) {
		if (status == 1) {
			var a = confirm('确定冻结该配套');
		}
		else{
			var a = confirm('确定解冻该配套');
		}
		if (a == true) {
			$.post("<?php  echo $this->createMobileUrl('odds',array('op'=>'freeze'))?>",{id:id,status:status},function(result) {
				alert(result.info);
				if (result.status == 1) {
					window.location.reload();
				}
				if (result.status == 3) {
					location.href = "<?php  echo $this->createMobileUrl('login')?>";
				}
			},'JSON');
		}
	}
	function setallodds(odds,cl) {
		if (cl == 'odds_a') {
			$('input[data-value=odds_a]').val(odds);
			$('input[data-value=odds_c2]').val(odds);
			$('input[data-value=odds_c3]').val(odds);
			$('input[data-value=odds_c4]').val(odds/10);
			$('input[data-value=odds_c5]').val(odds/10);
			$('input[data-value=odds_ec]').val(odds/23);
		}
		if (cl == 'odds_2a') {
			$('input[data-value=odds_2a]').val(odds);
			$('input[data-value=odds_2b]').val(odds);
			$('input[data-value=odds_2c]').val(odds);
			$('input[data-value=odds_2d]').val(odds/10);
			$('input[data-value=odds_2e]').val(odds/10);
			$('input[data-value=odds_ex]').val(odds/23);
		}
		if (cl == 'odds_4a') {
			$('input[data-value=odds_4a]').val(odds);
			$('input[data-value=odds_4b]').val(odds);
			$('input[data-value=odds_4c]').val(odds);
			$('input[data-value=odds_4d]').val(odds/10);
			$('input[data-value=odds_4e]').val(odds/10);
			$('input[data-value=odds_ea]').val(odds/23);
		}
		if (cl == 'odds_3abc' || cl == 'odds_4abc' || cl == 'odds_2abc') {
			$('.'+cl).val(odds);
		}
	}
	function keyupcheck(obj) {
		obj.value=obj.value.replace(/[^\d{1,}\.\d{1,}|\d{1,}]/g,'');
		var cl = $(obj).attr('class');
		if (cl == 'odds_b' || cl == 'odds_s' ||  cl == 'odds_4abc' || cl == 'odds_4a') {
			var odds = [];
			$('.'+cl).each(function () {
				odds.push(parseFloat($(this).val()));
			});
			if (cl == 'odds_4a') {
				var odds_check = get_max(odds);
			}
			else{
				var odds_check = getTotal(odds);
			}
			if (odds_check>10000) {
				$(obj).val('');
			}
		}
		if (cl == 'odds_3abc' || cl == 'odds_a') {
			var odds = [];
			$('.'+cl).each(function () {
				odds.push(parseFloat($(this).val()));
			});
			if (cl == 'odds_a') {
				var odds_check = get_max(odds);
			}
			else{
				var odds_check = getTotal(odds);
			}
			if (odds_check>1000) {
				$(obj).val('');
			}
		}
		if (cl == 'odds_2abc' || cl == 'odds_2a') {
			var odds = [];
			$('.'+cl).each(function () {
				odds.push(parseFloat($(this).val()));
			});
			if (cl == 'odds_2a') {
				var odds_check = get_max(odds);
			}
			else{
				var odds_check = getTotal(odds);
			}
			if (odds_check > 100) {
				$(obj).val('');
			}
		}
	}
	function odds_post() {
		var odds_id = $('#odds_id').val();
		var title = $('input[name=title]').val();
		var gid = $('select[name=gid]').val();
		var cid = $('input[name=cid]:checked').val();
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
		$('.odds_b').each(function () {
			odds_b.push(parseFloat($(this).val()));
		});

		$('.odds_s').each(function () {
			odds_s.push(parseFloat($(this).val()));
		});

		$('.odds_3abc').each(function () {
			odds_3abc.push(parseFloat($(this).val()));
		});

		$('.odds_4abc').each(function () {
			odds_4abc.push(parseFloat($(this).val()));
		});

		$('.odds_2abc').each(function () {
			odds_2abc.push(parseFloat($(this).val()));
		});

		$('.odds_2a').each(function () {
			odds_2a.push(parseFloat($(this).val()));
		});

		$('.odds_4a').each(function () {
			odds_4a.push(parseFloat($(this).val()));
		});

		$('.odds_a').each(function () {
			odds_a.push(parseFloat($(this).val()));
		});
		$('.odds_5d').each(function() {
			odds_5d.push(parseFloat($(this).val()));
		});
		$('.odds_6d').each(function() {
			odds_6d.push(parseFloat($(this).val()));
		});

		var commission = {'B':$('input[name=cashback_b]').val(),'S':$('input[name=cashback_s]').val(),'A':$('input[name=cashback_a]').val(),'3ABC':$('input[name=cashback_3abc]').val(),'4A':$('input[name=cashback_4a]').val(),'4ABC':$('input[name=cashback_4abc]').val(),'2A':$('input[name=cashback_2a]').val(),'2ABC':$('input[name=cashback_2abc]').val(),'5D':$('input[name=cashback_5d]').val(),'6D':$('input[name=cashback_6d]').val()};

		var odds = {'B':odds_b,'S':odds_s,'A':odds_a,'3ABC':odds_3abc,'4ABC':odds_4abc,'2ABC':odds_2abc,'2A':odds_2a,'4A':odds_4a,'5D':odds_5d,'6D':odds_6d};
		$.post("<?php  echo $this->createMobileUrl('odds',array('op'=>'post'))?>",{odds:odds,odds_id:odds_id,title:title,area_id:cid,commission:commission,gid:gid},function(result) {
			alert(result.info);
			if (result.status == 3) {
				location.href="./index.php?i=6&c=entry&m=purchasing&do=login";
			}
			if (result.status == 1) {
				window.location.reload();
			}
		},'JSON');
	}
	function cal_shuiqia(total_money, number_type,cashback=0) {		
		var shui_qian_value =0;
		if (number_type == 3 ) {
			shui_qian_value = 100 - total_money - cashback;
		}else if( number_type == 2 ){
			shui_qian_value = (1000 - total_money)/10 - cashback;
		}else if( number_type == 1 ){
			shui_qian_value = (10000 - total_money)/100 - cashback;
		}
		else if (number_type == 4) {
			shui_qian_value = (100000 - total_money)/1000 - cashback;
		}
		else if (number_type == 5) {
			shui_qian_value = (1000000 - total_money)/10000 - cashback;
		}

		if (shui_qian_value < 0) {
			shui_qian_value = 0;
		}
		if ( shui_qian_value > 100 ) {
			shui_qian_value = 100;
		}
		return shui_qian_value;
	}

	function get_5d_total(odds) {
		var total_odds = 0;
		for (var i = 0; i < 6; i++) {
			if (i == 3) {
				total_odds = total_odds+(odds[i]*10);
			}
			else if (i == 4) {
				total_odds = total_odds+(odds[i]*100);
			}
			else if (i == 5) {
				total_odds = total_odds+(odds[i]*1000);
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

		var jackpot = parseFloat($('input[name=jackpot]').val());

		$('.my_cashback').each(function() {
			my_cashback.push(parseFloat($(this).val()));
		});

		$('.odds_b').each(function () {
			odds_b.push(parseFloat($(this).val()));
		});
		var odds_b_total = getTotal(odds_b);
		var cashback_money_b = cal_shuiqia(odds_b_total,1,my_cashback[0]);
		

		$('.odds_s').each(function () {
			odds_s.push(parseFloat($(this).val()));
		});
		var odds_s_total = getTotal(odds_s);
		var cashback_money_s = cal_shuiqia(odds_s_total,1,my_cashback[1]);

		$('.odds_3abc').each(function () {
			odds_3abc.push(parseFloat($(this).val()));
		});
		// var odds_3abc_total = getTotal(odds_3abc);
		var cashback_money_3abc = cal_shuiqia(odds_3abc[0]*odds_3abc.length,2,my_cashback[3]);
		setallodds(odds_3abc[0],'odds_3abc');

		$('.odds_4abc').each(function () {
			odds_4abc.push(parseFloat($(this).val()));
		});
		// var odds_4abc_total = getTotal(odds_4abc);
		var cashback_money_4abc = cal_shuiqia(odds_4abc[0]*odds_4abc.length,1,my_cashback[5]);
		setallodds(odds_4abc[0],'odds_4abc');

		$('.odds_2abc').each(function () {
			odds_2abc.push(parseFloat($(this).val()));
		});
		// var odds_2abc_total = getTotal(odds_2abc);
		var cashback_money_2abc = cal_shuiqia(odds_2abc[0]*odds_2abc.length,3,my_cashback[7]);
		setallodds(odds_2abc[0],'odds_2abc');

		$('.odds_2a').each(function () {
			odds_2a.push(parseFloat($(this).val()));
		});
		// var odds_2a_max = get_max(odds_2a);
		var cashback_money_2a = cal_shuiqia(odds_2a[0],3,my_cashback[6]);
		setallodds(odds_2a[0],'odds_2a');

		$('.odds_4a').each(function () {
			odds_4a.push(parseFloat($(this).val()));
		});
		// var odds_4a_max = get_max(odds_4a);
		var cashback_money_4a = cal_shuiqia(odds_4a[0],1,my_cashback[4]);
		setallodds(odds_4a[0],'odds_4a');

		$('.odds_a').each(function () {
			odds_a.push(parseFloat($(this).val()));
		});

		$('.odds_5d').each(function() {
			odds_5d.push($(this).val());
		});
		var odds_5d_total = get_5d_total(odds_5d);
		var cashback_money_5d = cal_shuiqia(odds_5d_total,4,my_cashback[8]);

		$('.odds_6d').each(function() {
			odds_6d.push($(this).val());
		});
		var odds_6d_total = get_6d_total(odds_6d);
		var cashback_money_6d = cal_shuiqia(odds_6d_total,5,my_cashback[9]);
		// var odds_a_max = get_max(odds_a);
		var cashback_money_a = cal_shuiqia(odds_a[0],2,my_cashback[2]);
		setallodds(odds_a[0],'odds_a');
		console.log(cashback_money_a);

		$('#cashback_money_b').text(Math.round(cashback_money_b*100)/100);
		$('#cashback_money_s').text(Math.round(cashback_money_s*100)/100);
		$('#cashback_money_a').text(Math.round(cashback_money_a*100)/100);
		$('#cashback_money_3abc').text(Math.round(cashback_money_3abc*100)/100);
		$('#cashback_money_4a').text(Math.round(cashback_money_4a*100)/100);
		$('#cashback_money_4abc').text(Math.round(cashback_money_4abc*100)/100);
		$('#cashback_money_2a').text(Math.round(cashback_money_2a*100)/100);
		$('#cashback_money_2abc').text(Math.round(cashback_money_2abc*100)/100);
		$('#cashback_money_5d').text(Math.round(cashback_money_5d));
		$('#cashback_money_6d').text(Math.round(cashback_money_6d));
	}

	$('input').blur(function () {
		cal_cashback();
	});
	function get_max(obj) {
		var max = obj[0];
		var len = obj.length;
		for (var i = 1; i < len; i++){
			if (i >= 3) {
				obj[i] = obj[i]*10;
			}
			if (obj[i] > max) {
				max = obj[i];
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
<?php  } else if($tab == 'D5' || $tab == 'D6') { ?>
<div class="col-xs-12" style="margin-top: 10px;">
	<div class="col-xs-12">
		<?php  if($tab == 'D5') { ?>5D<?php  } else if($tab == 'D6') { ?>6D<?php  } ?>配套
	</div>
	<table class="table table-bordered">
		<tr>
			<td style="width: 60px;">所属公司</td>
			<td>
				<?php  if(is_array($company)) { foreach($company as $com) { ?>
				<label>
					<input type="checkbox" name="company" value="<?php  echo $com['id'];?>" <?php  if(in_array($com['id'],$companys)) { ?>checked="checked"<?php  } ?>>
					<?php  echo $com['name'];?>
				</label>
				<?php  } } ?>
			</td>
		</tr>
		<tr>
			<td>1st</td>
			<td><input type="text" name="first" value="<?php  echo round($odds['first'],5)?>"></td>
		</tr>
		<tr>
			<td>2nd</td>
			<td><input type="text" name="secound" value="<?php  echo round($odds['secound'],5)?>"></td>
		</tr>
		<tr>
			<td>3rd</td>
			<td><input type="text" name="third" value="<?php  echo round($odds['third'],5)?>"></td>
		</tr>
		<tr>
			<td>4th</td>
			<td><input type="text" name="fourth" value="<?php  echo round($odds['fourth'],5)?>"></td>
		</tr>
		<tr>
			<td>5th</td>
			<td><input type="text" name="fifth" value="<?php  echo round($odds['fifth'],5)?>"></td>
		</tr>
		<?php  if($tab == 'D5') { ?>
		<tr>
			<td>6th</td>
			<td><input type="text" name="sixth" value="<?php  echo round($odds['sixth'],5)?>"></td>
		</tr>
		<?php  } ?>
	</table>
	<button class="btn" type="button" onclick="save_odds(<?php  echo $odds['id'];?>);">保存</button>
</div>
<script type="text/javascript">
	function save_odds(id) {
		var company = [];
		$('input[name=company]:checked').each(function() {
			company.push($(this).val());
		})
		var first = $('input[name=first]').val();
		var secound = $('input[name=secound]').val();
		var third = $('input[name=third]').val();
		var fourth = $('input[name=fourth]').val();
		var fifth = $('input[name=fifth]').val();
		$.post("<?php  echo $this->createMobileUrl('odds',array('op'=>'new_post'))?>",{id:id,first:first,secound:secound,third:third,fourth:fourth,fifth:fifth,company:company},function(result) {
			alert(result.info);
			if (result.status == 3) {
				location.href = "<?php  echo $this->createMobileUrl('login')?>";
			}
			if (result.status == 1) {
				window.location.reload();
			}
		},'JSON');
	}
</script>
<?php  } ?>
<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('footer', TEMPLATE_INCLUDEPATH)) : (include template('footer', TEMPLATE_INCLUDEPATH));?>