<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/header', TEMPLATE_INCLUDEPATH)) : (include template('common/header', TEMPLATE_INCLUDEPATH));?>
<link href="<?php echo MODULE_URL;?>template/style/market.css" rel="stylesheet">
<style type="text/css">
.request{
	color:red;
	font-weight:bolder;
}
</style>
<ul class="nav nav-tabs">
	<li <?php  if($op=='display') { ?>class="active" <?php  } ?>>
		<a href="<?php  echo $this->createWebUrl('market');?>">抵扣设置</a>
	</li>
	<li <?php  if($op=='coupon' ||  $op=='addCoupon') { ?>class="active" <?php  } ?>>
		<a href="<?php  echo $this->createWebUrl('market', array('op'=>'coupon'));?>">优惠券管理</a>
	</li>
	<li <?php  if($op=='couponLog' || $op=='couponDetail') { ?>class="active" <?php  } ?>>
		<a href="<?php  echo $this->createWebUrl('market', array('op'=>'couponLog'));?>">优惠券记录</a>
	</li>
</ul>

<?php  if($op=='display') { ?>
<div class="main">
	<form action="" method="post" class="form-horizontal form-validate">
		<div class="page-heading">
			<div class="panel panel-default">
				<div class="panel-body">
					<div class="col-sm-9 col-xs-12">
						<h4>积分抵扣</h4>
						<span> 开启积分抵扣, 课程最多抵扣的数目需要在课程的【营销设置】中单独设置</span>
					</div>
					<div class="col-sm-2 pull-right" style="padding-top:10px;text-align: right">
						<input type="hidden" class="js-switch" name="deduct_switch" id="creditdeduct" value="<?php  echo $market['deduct_switch'];?>">
						<div class="switchery <?php  if($market['deduct_switch']) { ?>checked<?php  } ?>"><small></small></div>
					</div>
				</div>

				<div class="form-group" id="creditdeduct-switch" <?php  if(!$market['deduct_switch']) { ?>style="display:none"<?php  } ?>>
					<label class="col-sm-2 control-label">积分抵扣比例</label>
					<div class="col-sm-5">
						<div class="input-group">
							<input type="hidden" name="credit" value="1" class="form-control">
							<span class="input-group-addon">1个积分 抵扣</span>
							<input type="text" name="deduct_money" value="<?php  echo $market['deduct_money'];?>" class="form-control">
							<span class="input-group-addon">元</span>
						</div>
						<span class="help-block">积分抵扣比例设置</span>
					</div>
				</div>
			</div>

			<div class="form-group">
				<div class="col-sm-12">
					<input type="hidden" name="token" value="<?php  echo $_W['token'];?>">
					<input type="submit" name="submit" value="保存设置" class="btn btn-primary">
				</div>
			</div>
	</form>
</div>
<script language="javascript">
    $(function () {
        $(".switchery").click(function () {
            if ($("#creditdeduct").val()==1) {
            	$("#creditdeduct").val(0);
            	$(".switchery").removeClass("checked");
                $("#creditdeduct-switch").hide();
            }else {
            	$("#creditdeduct").val(1);
            	$(".switchery").addClass("checked");
                $("#creditdeduct-switch").show();
            }
        }); 
    });
</script>

<?php  } else if($op=='coupon') { ?>
<div class="main">
    <div class="panel panel-default">
        <form id="myForm" method="post" class="form-horizontal form">
        <div class="table-responsive panel-body">
            <table class="table table-hover">
                <thead class="navbar-inner">
                <tr>
					<th style="width:4%;"><input type="checkbox" id="checkItems"></th>
                    <th style="width:9%;">排序</th>
                    <th style="width:18%;">优惠券名称</th>
                    <th style="width:10%;">面值</th>
					<th style="width:18%;">有效期</th>
					<th style="width:20%;">使用条件</th>
					<th style="width:10%;">积分兑换</th>
					<th style="width:10%;">已领/总量</th>
                    <th style="width:10%;">状态</th>
                    <th style="text-align:right;">操作</th>
                </tr>
                </thead>
                <tbody>
                <?php  if(is_array($list)) { foreach($list as $item) { ?>
                <tr>
                    <td><input type="checkbox" name="ids[]" value="<?php  echo $item['id'];?>"></td>
					<td><input type="text" class="form-control" name="displayorder[<?php  echo $item['id'];?>]" value="<?php  echo $item['displayorder'];?>"></td>
                    <td><?php  echo $item['name'];?></td>
                    <td><?php  echo $item['amount'];?> 元</td>
                    <td>
						<?php  if($item['validity_type']==1) { ?>
							<?php  echo date('Y-m-d H:i',$item['days1'])?>
						<?php  } else if($item['validity_type']==2) { ?>
							自领取后<?php  echo $item['days2'];?>天内有效
						<?php  } ?>
					</td>
					<td>消费满<?php  echo $item['conditions'];?>元，<?php  echo $item['category_name'];?>可用</td>
					<td>
						<?php  if($item['is_exchange'] == 0) { ?><span class="label label-danger">不支持</span><?php  } ?>
						<?php  if($item['is_exchange'] == 1) { ?><span class="label label-success">支持</span><?php  } ?>
					</td>
					<td><?php  echo $item['already_exchange'];?>/<?php  echo $item['total_exchange'];?></td>
					<td>
						<?php  if($item['status'] == 0) { ?><span class="label label-default">下架</span><?php  } ?>
						<?php  if($item['status'] == 1) { ?><span class="label label-success">上架</span><?php  } ?>
					</td>
                    <td style="text-align:right;">
						<a class="btn btn-default btn-sm" href="<?php  echo $this->createWebUrl('market', array('op' => 'addCoupon', 'coupon_id' => $item['id']))?>" title="编辑优惠券"><i class="fa fa-edit"></i></a>
                    </td>
                </tr>
                <?php  } } ?>
                </tbody>
				<tfoot>
					<tr>
						<td colspan="10">
							<a href="<?php  echo $this->createWebUrl('market',array('op'=>addCoupon));?>" class="btn btn-default"><i class="fa fa-plus"></i> 添加优惠券</a>&nbsp;&nbsp;&nbsp;
							<input name="submitOrder" type="submit" class="btn btn-success" value="批量修改排序">&nbsp;&nbsp;&nbsp;
							<input name="submit" type="submit" class="btn btn-danger" value="批量删除" onclick="return delAll()">
							<input type="hidden" name="token" value="<?php  echo $_W['token'];?>">
						</td>
					</tr>
				</tfoot>
            </table>
            <?php  echo $pager;?>
        </div>
    </div>
    </form>
</div>
<script type="text/javascript">
var ids = document.getElementsByName('ids[]');
$("#checkItems").click(function(){  
	if (this.checked) {
		for(var i=0;i<ids.length;i++){
			var checkElement=ids[i];
			checkElement.checked="checked";
		}
	}else{  
		for(var i=0;i<ids.length;i++){
			var checkElement=ids[i];  
			checkElement.checked=null;  
		}
	}
});
function delAll(){
	var flag = false;
	for(var i=0;i<ids.length;i++){  
		if(ids[i].checked){
			flag = true;
			break;
		}
	}
	if(!flag){  
		alert("未选中任何选项");
		return false ;
	}
	if(!confirm('该操作无法恢复，确定删除?')){
		return false;
	}

	 document.getElementById('myForm').action = "<?php  echo $this->createWebUrl('market', array('op'=>'delAllCoupon'));?>";
     document.getElementById("myForm").submit();
}
</script>

<?php  } else if($op=='addCoupon') { ?>
<div class="main">
    <form method="post" class="form-horizontal form" enctype="multipart/form-data">
        <div class="panel panel-default">
            <div class="panel-heading"><?php  if($_GPC['coupon_id']>0) { ?>编辑<?php  } else { ?>添加<?php  } ?>优惠码</div>
            <div class="panel-body">
				<div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label"><span class="request">*</span>优惠券名称</label>
                    <div class="col-sm-9">
                        <input type="text" name="name" value="<?php  echo $coupon['name'];?>" class="form-control">
                    </div>
                </div>
				<div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">优惠券图片</label>
                    <div class="col-sm-9">
                        <?php  echo tpl_form_field_image('images', $coupon['images'])?>
                        <span class="help-block">建议尺寸 200px * 200px，也可根据自己的实际情况做图片尺寸</span>
                    </div>
                </div>
				<div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label"><span class="request">*</span>优惠券面值</label>
                    <div class="col-sm-9">
                        <div class="input-group">
                            <input type="text" name="amount" value="<?php  echo $coupon['amount'];?>" class="form-control">
                            <span class="input-group-addon">元</span>
                        </div>
                    </div>
                </div>
				<div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label"><span class="request">*</span>使用金额条件</label>
                    <div class="col-sm-9">
                        <div class="input-group">
                            <input type="text" name="conditions" value="<?php  echo $coupon['conditions'];?>" class="form-control">
                            <span class="input-group-addon">元</span>
                        </div>
                        <div class="help-block">
                            课程订单需满足指定金额方可使用该优惠券
                        </div>
                    </div>
                </div>
				<div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label"><span class="request">*</span>使用分类条件</label>
                    <div class="col-sm-9">
                        <select name="category_id" class="form-control">
							<option value="0">全部分类</option>
							<?php  if(is_array($category_list)) { foreach($category_list as $item) { ?>
							<option value="<?php  echo $item['id'];?>" <?php  if($item['id']==$coupon['category_id']) { ?>selected<?php  } ?>><?php  echo $item['name'];?></option>
							<?php  } } ?>
						</select>
                        <div class="help-block">
                            指定分类下的课程可使用
                        </div>
                    </div>
                </div>
				<div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label"><span class="request">*</span>积分兑换</label>
                    <div class="col-sm-9">
						<label class="radio-inline"><input type="radio" name="is_exchange" value="1" <?php  if($coupon['is_exchange']==1) { ?>checked<?php  } ?> onclick="exchange(this.value)"/> 启用</label>&nbsp;
						<label class="radio-inline"><input type="radio" name="is_exchange" value="0" <?php  if($coupon['is_exchange']==0) { ?>checked<?php  } ?> onclick="exchange(this.value)"/> 不启用</label>
						<span class="help-block">选择启用积分兑换优惠券，优惠券将展示在手机端供用户自行兑换</span>
					</div>
                </div>
				<div class="form-group exchange" <?php  if($coupon['is_exchange']!=1) { ?>style="display:none;"<?php  } ?>>
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">兑换积分</label>
					<div class="col-sm-9">
						<div class="input-group">
							<input type="text" name="exchange_integral" value="<?php  echo $coupon['exchange_integral'];?>" class="form-control">
							<span class="input-group-addon">积分</span>
						</div>
						<span class="help-block">设置兑换每张优惠券需要消耗的积分</span>
					</div>
                </div>
				<div class="form-group exchange" <?php  if($coupon['is_exchange']!=1) { ?>style="display:none;"<?php  } ?>>
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">最大兑换数量</label>
					<div class="col-sm-9">
						<div class="input-group">
							<input type="text" name="max_exchange" value="<?php  echo $coupon['max_exchange'];?>" class="form-control">
							<span class="input-group-addon">张</span>
						</div>
						<span class="help-block">每位用户最多可兑换的优惠券数量</span>
					</div>
                </div>
				<div class="form-group exchange" <?php  if($coupon['is_exchange']!=1) { ?>style="display:none;"<?php  } ?>>
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">兑换总数量</label>
					<div class="col-sm-9">
						<div class="input-group">
							<input type="text" name="total_exchange" value="<?php  echo $coupon['total_exchange'];?>" class="form-control">
							<span class="input-group-addon">张</span>
						</div>
					</div>
                </div>
				<div class="form-group exchange" <?php  if($coupon['is_exchange']!=1) { ?>style="display:none;"<?php  } ?>>
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">已兑换数量</label>
					<div class="col-sm-9">
						<div class="input-group">
							<input type="text" name="already_exchange" value="<?php  echo $coupon['already_exchange'];?>" class="form-control">
							<span class="input-group-addon">张</span>
						</div>
					</div>
                </div>
				<div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label"><span class="request">*</span>有效期方式</label>
                    <div class="col-sm-9">
						<label class="radio-inline"><input type="radio" name="validity_type" value="1" <?php  if($coupon['validity_type']==1) { ?>checked<?php  } ?> onclick="changeType(this.value)"/> 固定日期</label>&nbsp;
						<label class="radio-inline"><input type="radio" name="validity_type" value="2" <?php  if($coupon['validity_type']==2) { ?>checked<?php  } ?> onclick="changeType(this.value)"/> 自增天数</label>
						<span class="help-block">固定日期为指定日期前有效，自增天数为自用户领取时往后指定时间内有效</span>
					</div>
                </div>
				<div id="validity1" class="form-group" <?php  if($coupon['validity_type']!=1) { ?>style="display:none;"<?php  } ?>>
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">固定有效期</label>
                    <div class="col-sm-9">
						<?php  echo tpl_form_field_date('days1', $coupon['days1'], true);?>
						<span class="help-block">指定日期前，该优惠券有效</span>
					</div>
                </div>
				<div id="validity2" class="form-group" <?php  if($coupon['validity_type']!=2) { ?>style="display:none;"<?php  } ?>>
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">自增有效期</label>
					<div class="col-sm-9">
						<div class="input-group">
							<input type="text" name="days2" value="<?php  echo $coupon['days2'];?>" class="form-control">
							<span class="input-group-addon">天</span>
						</div>
						<span class="help-block">用户领取之后，指定天数内该优惠券有效</span>
					</div>
                </div>
				<div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label"><span class="request">*</span>排序</label>
                    <div class="col-sm-9">
                        <input type="text" name="displayorder" value="<?php  echo $coupon['displayorder'];?>" class="form-control">
						<span class="help-block">排序越大，排名越靠前</span>
                    </div>
                </div>
				<div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label"><span class="request">*</span>状态</label>
                    <div class="col-sm-9">
						<label class="radio-inline"><input type="radio" name="status" value="1" <?php  if($coupon['status']==1) { ?>checked<?php  } ?>/> 上架</label>&nbsp;
						<label class="radio-inline"><input type="radio" name="status" value="0" <?php  if($coupon['status']==0) { ?>checked<?php  } ?>/> 下架</label>
						<span class="help-block">用户将无法领取或获得下架的优惠券，已获得的优惠券继续使用</span>
					</div>
                </div>
            </div>
        </div>

        <div class="form-group col-sm-12">
            <input type="submit" name="submit" value="提交" class="btn btn-primary col-lg-1"/>
            <input type="hidden" name="token" value="<?php  echo $_W['token'];?>" />
        </div>
    </form>
</div>
<script type="text/javascript">
function changeType(type){
	if(type==1){
		$("#validity1").show();
		$("#validity2").hide();
	}else{
		$("#validity2").show();
		$("#validity1").hide();
	}
}
function exchange(status){
	if(status==1){
		$(".exchange").show();
	}else{
		$(".exchange").hide();
	}
}
</script>

<?php  } else if($op=='couponLog') { ?>
<div class="main">
    <div class="panel panel-info">
        <div class="panel-heading">筛选</div>
        <div class="panel-body">
            <form method="get" class="form-horizontal" role="form">
                <input type="hidden" name="c" value="site" />
                <input type="hidden" name="a" value="entry" />
                <input type="hidden" name="m" value="fy_lessonv2" />
                <input type="hidden" name="do" value="market" />
                <input type="hidden" name="op" value="couponLog" />
                <div class="form-group">
                    <label class="col-xs-12 col-sm-2 col-md-2 col-lg-2 control-label" style="width: 100px;">用户信息</label>
                    <div class="col-sm-2 col-lg-3">
                        <input class="form-control" name="nickname" id="" type="text" value="<?php  echo $_GPC['nickname'];?>" placeholder="昵称/姓名/手机号码">
                    </div>
					<label class="col-xs-12 col-sm-2 col-md-2 col-lg-1 control-label" style="width:100px;">状态</label>
                    <div class="col-sm-8 col-lg-3 col-xs-12">
                        <select name="status" class="form-control">
                            <option value="">不限</option>
							<option value="0" <?php  if(in_array($_GPC['status'],array('0'))) { ?> selected="selected" <?php  } ?>>未使用</option>
							<option value="1" <?php  if($_GPC['status'] == 1) { ?> selected="selected" <?php  } ?>>已使用</option>
                            <option value="-1" <?php  if($_GPC['status'] == -1) { ?> selected="selected" <?php  } ?>>已过期</option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
					<label class="col-xs-12 col-sm-2 col-md-2 col-lg-1 control-label" style="width: 100px;">添加时间</label>
                    <div class="col-sm-8 col-lg-3 col-xs-12">
                        <?php echo tpl_form_field_daterange('time', array('starttime'=>($starttime ? date('Y-m-d', $starttime) : false),'endtime'=> ($endtime ? date('Y-m-d', $endtime) : false)));?>
                    </div>
                    <div class="col-sm-3 col-lg-3">
                        <button class="btn btn-default"><i class="fa fa-search"></i> 搜索</button>&nbsp;&nbsp;&nbsp;
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="panel panel-default">
        <form action="" method="post" class="form-horizontal form" >
        <div class="table-responsive panel-body">
            <table class="table table-hover">
                <thead class="navbar-inner">
                <tr>
                    <th style="width:8%;">ID</th>
                    <th style="width:20%;">昵称/手机号码</th>
					<th style="width:12%;">优惠券面值</th>
                    <th style="width:20%;">使用条件</th>
                    <th style="width:15%;">有效期</th>
					<th style="width:10%;">状态</th>
					<th style="width:15%;">添加时间</th>
                    <th style="text-align:right;">操作</th>
                </tr>
                </thead>
                <tbody>
                <?php  if(is_array($list)) { foreach($list as $item) { ?>
                <tr>
                    <td><?php  echo $item['id'];?></td>
                    <td><?php  echo $item['nickname'];?><br/><?php  echo $item['mobile'];?></td>
					<td><?php  echo $item['amount'];?>元</td>
                    <td>满<?php  echo $item['conditions'];?>元<br/><?php  echo $item['category_name'];?> 可用</td>
                    <td><?php  echo date('Y-m-d H:i', $item['validity'])?></td>
					<td>
						<?php  if($item['status']==0) { ?>
							<span class="label label-success">未使用</span>
						<?php  } else if($item['status']==1) { ?>
							<span class="label label-danger">已使用</span>
						<?php  } else if($item['status']==-1) { ?>
							<span class="label label-default">已过期</span>
						<?php  } ?>
					</td>
                    <td><?php  echo date('Y-m-d H:i', $item['addtime'])?></td>
                    <td style="text-align:right;">
                        <a class="btn btn-default btn-sm" href="<?php  echo $this->createWebUrl('market', array('op' => 'couponDetail', 'id' => $item['id']))?>" title="查看"><i class="fa fa-pencil"></i></a>
                    </td>
                </tr>
                <?php  } } ?>
                </tbody>
            </table>
            <?php  echo $pager;?>
        </div>
    </div>
    </form>
</div>
<?php  } else if($op=='couponDetail') { ?>
<style type="text/css">
.form-group{padding: 20px 0;}
</style>
<div class="main">
	<div class="panel panel-default">
		<div class="panel-heading">
			优惠券详情
		</div>
		<div class="panel-body">
			<div class="form-group">
				<label class="col-xs-12 col-sm-3 col-md-2 control-label">会员ID/昵称</label>
				<div class="col-sm-9">
					<p class="form-control-static"><?php  echo $member_coupon['uid'];?> / <?php  echo $member_coupon['nickname'];?></p>
				</div>
			</div>
			<div class="form-group">
				<label class="col-xs-12 col-sm-3 col-md-2 control-label">会员姓名/手机号码</label>
				<div class="col-sm-9">
					<p class="form-control-static"><?php  echo $member_coupon['realname'];?> / <?php  echo $member_coupon['mobile'];?></p>
				</div>
			</div>
			<div class="form-group">
				<label class="col-xs-12 col-sm-3 col-md-2 control-label">优惠券状态</label>
				<div class="col-sm-9">
					<p class="form-control-static">
						<?php  if($member_coupon['status']==0) { ?>
							<span class="label label-success">未使用</span>
						<?php  } else if($member_coupon['status']==1) { ?>
							<span class="label label-danger">已使用</span>
						<?php  } else if($member_coupon['status']==-1) { ?>
							<span class="label label-default">已过期</span>
						<?php  } ?>
					</p>
				</div>
			</div>
			<div class="form-group">
				<label class="col-xs-12 col-sm-3 col-md-2 control-label">优惠券面值</label>
				<div class="col-sm-9">
					<p class="form-control-static"><?php  echo $member_coupon['amount'];?> 元</p>
				</div>
			</div>
			<div class="form-group">
				<label class="col-xs-12 col-sm-3 col-md-2 control-label">使用条件</label>
				<div class="col-sm-9">
					<p class="form-control-static"><?php  echo $category_name;?>，消费满<?php  echo $member_coupon['conditions'];?>元可用</p>
				</div>
			</div>
			<div class="form-group">
				<label class="col-xs-12 col-sm-3 col-md-2 control-label">优惠券有效期</label>
				<div class="col-sm-9">
					<p class="form-control-static"><?php  echo date('Y-m-d H:i:s', $member_coupon['validity']);?></p>
				</div>
			</div>
			<div class="form-group">
				<label class="col-xs-12 col-sm-3 col-md-2 control-label">使用订单号</label>
				<div class="col-sm-9">
					<p class="form-control-static"><?php echo $member_coupon['ordersn'] ? $member_coupon['ordersn'] : "无";?></p>
				</div>
			</div>
			<div class="form-group">
				<label class="col-xs-12 col-sm-3 col-md-2 control-label">使用时间</label>
				<div class="col-sm-9">
					<p class="form-control-static">
					<?php  if($member_coupon['update_time']>0) { ?>
						<?php  echo date('Y-m-d H:i:s', $member_coupon['update_time']);?>
					<?php  } else { ?>
						无
					<?php  } ?>
					</p>
				</div>
			</div>
			<div class="form-group">
				<label class="col-xs-12 col-sm-3 col-md-2 control-label">来源</label>
				<div class="col-sm-9">
					<p class="form-control-static">
					<?php  if($member_coupon['source']==1) { ?>
						优惠码转换
					<?php  } else if($member_coupon['source']==2) { ?>
						购买课程赠送
					<?php  } else if($member_coupon['source']==3) { ?>
						邀请下级成员赠送
					<?php  } else if($member_coupon['source']==4) { ?>
						分享课程赠送
					<?php  } else if($member_coupon['source']==5) { ?>
						积分兑换
					<?php  } ?>
					</p>
				</div>
			</div>
		</div>
	</div>
	<div class="form-group col-sm-12">
		<input type="button" onclick="window.history.go(-1);" value="返回" class="btn btn-default col-lg-1">
	</div>
</div>

<?php  } ?>


<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/footer', TEMPLATE_INCLUDEPATH)) : (include template('common/footer', TEMPLATE_INCLUDEPATH));?>