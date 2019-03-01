<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/header', TEMPLATE_INCLUDEPATH)) : (include template('common/header', TEMPLATE_INCLUDEPATH));?>
<ul class="nav nav-tabs">
	<li <?php  if($op=='display') { ?> class="active"<?php  } ?>><a href="<?php  echo $this->createWebUrl('finance');?>">财务概览</a></li>
    <li <?php  if($op=='commission' && $_GPC['status']==0) { ?> class="active"<?php  } ?>><a href="<?php  echo $this->createWebUrl('finance', array('op'=>'commission','status'=>0));?>">待打款提现申请</a></li>
	<li <?php  if($op=='commission' && $_GPC['status']==1) { ?> class="active"<?php  } ?>><a href="<?php  echo $this->createWebUrl('finance', array('op'=>'commission','status'=>1));?>">已打款提现申请</a></li>
	<li <?php  if($op=='commission' && $_GPC['status']==-1) { ?> class="active"<?php  } ?>><a href="<?php  echo $this->createWebUrl('finance', array('op'=>'commission','status'=>-1));?>">无效提现申请</a></li>
</ul>

<?php  if($op=='display') { ?>
<style>
.account-stat{overflow:hidden; color:#666;}
.account-stat .account-stat-btn{width:100%; overflow:hidden;}
.account-stat .account-stat-btn > div{text-align:center; margin-bottom:5px;margin-right:2%; float:left;width:23%; height:80px; padding-top:10px;font-size:16px; border-left:1px #DDD solid;}
.account-stat .account-stat-btn > div:first-child{border-left:0;}
.account-stat .account-stat-btn > div span{display:block; font-size:30px; font-weight:bold}
</style>

<div class="panel panel-default">
	<div class="panel-heading">
		今日销售指标
	</div>
	<div class="account-stat">
		<div class="account-stat-btn">
			<div>今日课程销售额(元)<span><?php  echo $exit['lessonOrder_amount'];?></span></div>
			<div>今日课程销售量(单)<span><?php  echo $exit['lessonOrder_num'];?></span></div>
			<div>今日VIP销售额(元)<span><?php  echo $exit['vipOrder_amount'];?></span></div>
			<div>今日VIP销售量(单)<span><?php  echo $exit['vipOrder_num'];?></span></div>
		</div>
	</div>
</div>

<div class="panel panel-default">
	<div class="panel-heading">
		昨日销售指标
	</div>
	<div class="account-stat">
		<div class="account-stat-btn">
			<div>昨日课程销售额(元)<span><?php  echo $yestoday['lessonOrder_amount'];?></span></div>
			<div>昨日课程销售量(单)<span><?php  echo $yestoday['lessonOrder_num'];?></span></div>
			<div>昨日VIP销售额(元)<span><?php  echo $yestoday['vipOrder_amount'];?></span></div>
			<div>昨日VIP销售量(单)<span><?php  echo $yestoday['vipOrder_num'];?></span></div>
		</div>
	</div>
</div>

<div class="panel panel-info">
	<div class="panel-heading">销售额趋势图</div>
	<div style="height:20px;"></div>
	<form method="get" class="form-horizontal" role="form">
		<input type="hidden" name="c" value="site" />
		<input type="hidden" name="a" value="entry" />
		<input type="hidden" name="m" value="fy_lessonv2" />
		<input type="hidden" name="do" value="finance" />
		<input type="hidden" name="op" value="display" />
		<div class="form-group">
			<label class="col-xs-12 col-sm-2 col-md-2 col-lg-1 control-label" style="width: 100px;">日期</label>
			<div class="col-sm-8 col-lg-3 col-xs-12">
				<?php  echo tpl_form_field_daterange('time', array('starttime'=>date('Y-m-d', $starttime),'endtime'=>date('Y-m-d', $endtime)));?>
			</div>
			<div class="col-sm-3 col-lg-3" style="width: 22%;">
				<button class="btn btn-default"><i class="fa fa-search"></i> 搜索</button>
			</div>
		</div>
	</form>
    <div class="panel-body">
		<div id="container" style="min-width:400px;height:400px"></div>
    </div>
</div>

<script src="<?php echo MODULE_URL;?>/template/style/Highcharts/highcharts.js"></script>
<script src="<?php echo MODULE_URL;?>/template/style/Highcharts/exporting.js"></script>
<script src="<?php echo MODULE_URL;?>/template/style/Highcharts/highcharts-zh_CN.js"></script>
<script>
var chart = new Highcharts.Chart('container', {
    title: {
        text: '销售额趋势图',
        x: -20
    },
    subtitle: {
        text: '',
        x: -20
    },
    xAxis: {
        categories: <?php  echo json_encode($day)?>
    },
    yAxis: {
        title: {
            text: '销售额(元)'
        },
        plotLines: [{
            value: 0,
            width: 1,
            color: '#808080'
        }]
    },
    tooltip: {
        valueSuffix: '元'
    },
    legend: {
        layout: 'vertical',
        align: 'right',
        verticalAlign: 'middle',
        borderWidth: 0
    },
    series: [{
        name: '课程销售额',
        data: <?php  echo json_encode($lessonOrder_amount)?>
    }, {
        name: 'VIP销售额',
        data: <?php  echo json_encode($vipOrder_amount)?>
    }]
});
</script>

<?php  } else if($op=='commission') { ?>
<div class="panel panel-info">
    <div class="panel-heading">筛选</div>
    <div class="panel-body">
        <form action="./index.php" method="get" class="form-horizontal" role="form" id="form1">
            <input type="hidden" name="c" value="site" />
            <input type="hidden" name="a" value="entry" />
            <input type="hidden" name="m" value="fy_lessonv2" />
            <input type="hidden" name="do" value="finance" />
            <input type="hidden" name="op" value="commission" />
            <input type="hidden" name="status" value="<?php  echo $status;?>" />
                <div class="form-group">
                    <label class="col-xs-12 col-sm-2 col-md-2 col-lg-1 control-label">按时间</label>
                    <div class="col-sm-2">
                       <select name='timetype' class='form-control'>
                          <option value=''>不搜索</option>
						  <option value='addtime' <?php  if($_GPC['timetype']=='addtime') { ?>selected<?php  } ?>>申请时间</option>
                          <?php  if(in_array($status, array('-1','1'))) { ?>
						  <option value='disposetime' <?php  if($_GPC['timetype']=='disposetime') { ?>selected<?php  } ?>>审核时间</option>
						  <?php  } ?>
                       </select> 
                    </div>
                    <div class="col-sm-7 col-lg-9 col-xs-12">
                        <?php  echo tpl_form_field_daterange('time', array('starttime'=>date('Y-m-d H:i', $starttime),'endtime'=>date('Y-m-d  H:i', $endtime)),true);?>
                    </div>
                </div>
				<div class="form-group">
                    <label class="col-xs-12 col-sm-2 col-md-2 col-lg-1 control-label">提现类型</label>
                    <div class="col-sm-2">
                       <select name='lesson_type' class='form-control'>
                          <option value=''>全部</option>
						  <option value='1' <?php  if($_GPC['lesson_type']==1) { ?>selected<?php  } ?>>分销佣金提现</option>
						  <option value='2' <?php  if($_GPC['lesson_type']==2) { ?>selected<?php  } ?>>课程收入提现</option>
                       </select> 
                    </div>
                </div>
				<div class="form-group">
                    <label class="col-xs-12 col-sm-2 col-md-2 col-lg-1 control-label">提现方式</label>
                    <div class="col-sm-2">
                       <select name='cash_way' class='form-control'>
                          <option value=''>全部</option>
						  <option value='1' <?php  if($_GPC['cash_way']==1) { ?>selected<?php  } ?>>提现到帐户余额</option>
						  <option value='2' <?php  if($_GPC['cash_way']==2) { ?>selected<?php  } ?>>提现到微信钱包</option>
						  <option value='3' <?php  if($_GPC['cash_way']==3) { ?>selected<?php  } ?>>提现到支付宝</option>
                       </select> 
                    </div>
                </div>
                <div class="form-group">
					<label class="col-xs-12 col-sm-2 col-md-2 col-lg-1 control-label">提现单号</label>
					<div class="col-sm-8 col-lg-9 col-xs-12">
						<input type="text" class="form-control"  name="cashid" value="<?php  echo $_GPC['cashid'];?>"/> 
					</div> 
				</div>
                <div class="form-group">
					<label class="col-xs-12 col-sm-2 col-md-2 col-lg-1 control-label">会员信息</label>
					<div class="col-sm-8 col-lg-9 col-xs-12">
						<input type="text" class="form-control"  name="nickname" value="<?php  echo $_GPC['nickname'];?>" placeholder="可搜索昵称/姓名/手机号"/> 
					</div>
				</div>
				<div class="form-group">
					<label class="col-xs-12 col-sm-2 col-md-2 col-lg-1 control-label"></label>
					<div class="col-sm-8 col-lg-9 col-xs-12">
						 <button class="btn btn-default"><i class="fa fa-search"></i> 搜索</button>
						 <button type="submit" name="export" value="1" class="btn btn-primary">导出 Excel</button>
					</div>
				</div>
        </form>
    </div>
</div>

<div class="panel panel-default">
    <div class="panel-heading">总数：<?php  echo $total;?></div>
    <div class="panel-body">
        <table class="table table-hover">
            <thead class="navbar-inner">
                <tr>
                    <th style='width:8%;'>提现单号</th>
                    <th style='width:10%;'>粉丝</th>
                    <th style='width:10%;'>提现方式</th>
                    <th style='width:10%;'>提现类型</th>
					<th style='width:10%;'>处理方式</th>
                    <th style='width:10%;'>申请佣金</th>
                    <th style='width:13%;'>申请时间</th>
                    <?php  if(in_array($status, array('-1','1'))) { ?>
					<th style='width:13%;'>审核时间</th>
					<?php  } ?>
                    <th style='width:10%;'>状态</th>
                    <th style='width:8%;'>操作</th>
                </tr>
            </thead>
            <tbody>
                <?php  if(is_array($list)) { foreach($list as $row) { ?>
                <tr>
                    <td><?php  echo $row['id'];?></td>
                    <td><img src='<?php  echo $row['avatar'];?>' style='width:30px;height:30px;padding1px;border:1px solid #ccc' /> <?php  echo $row['nickname'];?></td>
                    <td>
						<?php  if($row['cash_way']==1) { ?>
						帐户余额
						<?php  } else if($row['cash_way']==2) { ?>
						微信钱包
						<?php  } else if($row['cash_way']==3) { ?>
						支付宝
						<?php  } ?>
					</td>
					<td><?php  if($row['lesson_type']==1) { ?><span class="label" style="background-color:#e07f08;">分销佣金提现</span><?php  } else if($row['lesson_type']==2) { ?><span class="label" style="background-color:#05987d;">课程收入提现</span><?php  } ?></td>
                    <td><?php echo $row['cash_type']==1?'管理员审核':'自动到账';?></td>
                    <td><?php  echo $row['cash_num'];?> 元</td>
                    <td><?php  echo date('Y-m-d H:i',$row['addtime']);?></td>
					<?php  if($row['disposetime']>0) { ?>
					<td><?php  echo date('Y-m-d H:i',$row['disposetime']);?></td>
					<?php  } ?>
                    <td><?php  if($row['status']==0) { ?><span class="label label-primary">待打款</span><?php  } else if($row['status']==1) { ?><span class="label label-success">已打款</span><?php  } else if($row['status']==-1) { ?><span class="label label-default">无效佣金</span><?php  } ?></td>
                     <td>
                        <a class='btn btn-default' href="<?php  echo $this->createWebUrl('finance',array('op'=>'detail', 'id' => $row['id'], 'status'=>$status));?>">详情</a>		
                    </td>
                </tr>
                <?php  } } ?>
            </tbody>
        </table>
        <?php  echo $pager;?>
    </div>
</div>

<?php  } else if($op=='detail') { ?>
<style type="text/css">
.mloading-bar {
    width: 300px;
    min-height: 22px;
    text-align: center;
    background: #fff;
    box-shadow: 0px 1px 1px 2px rgba(0, 0, 0, 0.3);
    border-radius: 7px;
    padding: 20px 15px;
    font-size: 14px;
    color: #000;
    position: absolute;
    top: 42%;
    left: 50%;
    margin-left: -140px;
    margin-top: -30px;
    word-break: break-all;
	z-index:999;
	display:none;
}
#overlay{
	background:#000;
	position: absolute;
	top: 0px;
	left: 0px;
	width: 100%;
	height: 100%;
	z-index: 100;
	display:none;
}
</style>
<div class="mloading-bar" style="margin-top: -31px; margin-left: -140px;"><img src="<?php echo MODULE_URL;?>template/mobile/images/download.gif"><span class="mloading-text">打款处理中，请勿刷新或关闭浏览器...</span></div>
<div id="overlay"></div>
<div class="main">
	<form class="form-horizontal form" method="post" onsubmit="return check();">
		<div class="panel panel-default">
			<div class="panel-heading">
				<?php  if($cashlog['status']==0) { ?>待打款<?php  } else if($cashlog['status']==1) { ?>已打款<?php  } else if($cashlog['status']==-1) { ?>无线<?php  } ?>提现申请信息
			</div>
			<div class="panel-body">
				<div class="form-group">
					<label class="col-xs-12 col-sm-3 col-md-2 control-label">提现单号</label>
					<div class="col-sm-9">
						<p class="form-control-static"><?php  echo $cashlog['id'];?></p>
					</div>
				</div>
				<div class="form-group">
					<label class="col-xs-12 col-sm-3 col-md-2 control-label">粉丝信息</label>
					<div class="col-sm-9">
						<p class="form-control-static"><img src='<?php  echo $cashlog['avatar'];?>' style='width:30px;height:30px;padding1px;border:1px solid #ccc' /> <?php  echo $cashlog['nickname'];?></p>
					</div>
				</div>
				<div class="form-group">
					<label class="col-xs-12 col-sm-3 col-md-2 control-label">手机号码</label>
					<div class="col-sm-9">
						<p class="form-control-static"> <?php  echo $cashlog['mobile'];?></p>
					</div>
				</div>
				<div class="form-group">
					<label class="col-xs-12 col-sm-3 col-md-2 control-label">真实名字</label>
					<div class="col-sm-9">
						<p class="form-control-static"> <?php  echo $cashlog['realname'];?></p>
					</div>
				</div>
				<div class="form-group">
					<label class="col-xs-12 col-sm-3 col-md-2 control-label">提现金额</label>
					<div class="col-sm-9">
						<p class="form-control-static"> <?php  echo $cashlog['cash_num'];?> 元</p>
					</div>
				</div>
				<div class="form-group">
					<label class="col-xs-12 col-sm-3 col-md-2 control-label">处理状态</label>
					<div class="col-sm-9">
						<p class="form-control-static">
						<?php  if($cashlog['status']==0) { ?>
							<label>
								<input type="radio" name="status" value="0" checked>
								<span class="label label-primary" style="vertical-align:text-top;">待打款</span>
							</label>
							&nbsp;&nbsp;
							<label>
								<input type="radio" name="status" value="1">
								<span class="label label-success" style="vertical-align:text-top;">已打款</span>
							</label>
							&nbsp;&nbsp;
							<label>
								<input type="radio" name="status" value="-1">
								<span class="label label-default" style="vertical-align:text-top;">无效佣金</span>
							</label>
						<?php  } else { ?>
							<?php  if($cashlog['status']==0) { ?>
							<span class="label label-primary">待打款</span>
							<?php  } else if($cashlog['status']==1) { ?>
							<span class="label label-success">已打款</span>
							<?php  } else if($cashlog['status']==-1) { ?>
							<span class="label label-default">无效佣金</span>
							<?php  } ?>
						<?php  } ?>
						</p>
					</div>
				</div>
				<div class="form-group">
					<label class="col-xs-12 col-sm-3 col-md-2 control-label">提现方式</label>
					<div class="col-sm-9">
						<p class="form-control-static">
						<?php  if($cashlog['cash_way']==1) { ?>
						帐户余额
						<?php  } else if($cashlog['cash_way']==2) { ?>
						微信钱包
						<?php  } else if($cashlog['cash_way']==3) { ?>
						支付宝
						<?php  } ?>
						</p>
					</div>
				</div>
				<?php  if($cashlog['cash_way']==3) { ?>
				<div class="form-group">
					<label class="col-xs-12 col-sm-3 col-md-2 control-label">提现账号</label>
					<div class="col-sm-9">
						<p class="form-control-static"><?php  echo $cashlog['pay_account'];?></p>
					</div>
				</div>
				<?php  } ?>
				<div class="form-group">
					<label class="col-xs-12 col-sm-3 col-md-2 control-label">处理方式</label>
					<div class="col-sm-9">
						<p class="form-control-static">
						<?php echo $cashlog['cash_type']==1?'管理员审核':'自动到账';?>
						</p>
					</div>
				</div>
				<div class="form-group">
					<label class="col-xs-12 col-sm-3 col-md-2 control-label">申请时间</label>
					<div class="col-sm-9">
						<p class="form-control-static">
						<?php  echo date('Y-m-d H:i:s', $cashlog['addtime']);?>
						</p>
					</div>
				</div>
				<?php  if(!empty($cashlog['disposetime'])) { ?>
				<div class="form-group">
					<label class="col-xs-12 col-sm-3 col-md-2 control-label">处理时间</label>
					<div class="col-sm-9">
						<p class="form-control-static">
						<?php  echo date('Y-m-d H:i:s', $cashlog['disposetime']);?>
						</p>
					</div>
				</div>
				<?php  } ?>
				<?php  if(!empty($cashlog['partner_trade_no'])) { ?>
				<div class="form-group">
					<label class="col-xs-12 col-sm-3 col-md-2 control-label">商户订单号</label>
					<div class="col-sm-9">
						<p class="form-control-static">
						<?php  echo $cashlog['partner_trade_no'];?>
						</p>
					</div>
				</div>
				<?php  } ?>
				<?php  if(!empty($cashlog['payment_no'])) { ?>
				<div class="form-group">
					<label class="col-xs-12 col-sm-3 col-md-2 control-label">微信订单号</label>
					<div class="col-sm-9">
						<p class="form-control-static">
						<?php  echo $cashlog['payment_no'];?>
						</p>
					</div>
				</div>
				<?php  } ?>
				<?php  if(!empty($cashlog['err_code'])) { ?>
				<div class="form-group">
					<label class="col-xs-12 col-sm-3 col-md-2 control-label">错误代码</label>
					<div class="col-sm-9">
						<p class="form-control-static">
						<?php  echo $cashlog['err_code'];?>
						</p>
					</div>
				</div>
				<?php  } ?>
				<?php  if(!empty($cashlog['err_code_des'])) { ?>
				<div class="form-group">
					<label class="col-xs-12 col-sm-3 col-md-2 control-label">错误描述</label>
					<div class="col-sm-9">
						<p class="form-control-static">
						<?php  echo $cashlog['err_code_des'];?>
						</p>
					</div>
				</div>
				<?php  } ?>
				<div class="form-group">
					<label class="col-xs-12 col-sm-3 col-md-2 control-label">管理员备注</label>
					<div class="col-sm-9">
                        <?php  if($cashlog['status']==0) { ?>
							<textarea style="width:500px;height:50px;" name="remark" id="remark" class="form-control"></textarea>
						<?php  } else { ?>
							<?php  echo $cashlog['remark'];?>
						<?php  } ?>
                    </div>
				</div>
				<div class="form-group">
					<label class="col-xs-12 col-sm-3 col-md-2 control-label"></label>
					<div class="col-sm-9 col-xs-12">
						<?php  if($cashlog['status']==0) { ?>
						<input type="submit" name="submit" value="提交" class="btn btn-success col-lg-1"  onclick="showOverlay()" />
						<input type="hidden" name="token" value="<?php  echo $_W['token'];?>">
						<?php  } ?>
						<input type="button" name="back" onclick="history.back()" style="margin-left:10px;" value="返回列表" class="btn btn-default">
					</div>
				</div>
			</div>
		</div>
	</form>
</div>
<script type="text/javascript">
function check(){
	var status = $('input[name="status"]:checked').val();
	var remark = $('#remark').val();
	if(status==0){
		alert("请选择处理状态");
		return false;
	}
	if(status=='-1' && remark==''){
		alert("请输入管理员备注");
		return false;
	}

	/* 显示遮罩层 */
	$("#overlay").height("100%");
    $("#overlay").width("100%");
    $("#overlay").fadeTo(200, 0.2);
	$(".mloading-bar").show();
}
</script>

<?php  } ?>

<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/footer', TEMPLATE_INCLUDEPATH)) : (include template('common/footer', TEMPLATE_INCLUDEPATH));?>