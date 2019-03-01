<?php defined('IN_IA') or exit('Access Denied');?><!-- 
 * 会员VIP服务订单管理
 * ============================================================================
 * 版权所有 2015-2017 风影随行，并保留所有权利。
 * 网站地址: http://www.haoshu888.com
 * ----------------------------------------------------------------------------
 * 这不是一个自由软件！不允许对程序代码以任何形式任何目的的再发布，作者将保留
 * 追究法律责任的权力和最终解释权。
 * ============================================================================
-->
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/header', TEMPLATE_INCLUDEPATH)) : (include template('common/header', TEMPLATE_INCLUDEPATH));?>
<link href="<?php echo MODULE_URL;?>template/style/fycommon.css" rel="stylesheet">
<ul class="nav nav-tabs">
	<li <?php  if($op=='display') { ?>class="active"<?php  } ?>><a href="<?php  echo $this->createWebUrl('viporder');?>">VIP订单管理</a></li>
	<li <?php  if($op=='createOrder') { ?>class="active"<?php  } ?>><a href="<?php  echo $this->createWebUrl('viporder',array('op'=>'createOrder'));?>">创建会员服务</a></li>
	<li <?php  if($op=='vipcard') { ?>class="active"<?php  } ?>><a href="<?php  echo $this->createWebUrl('viporder',array('op'=>'vipcard'));?>">VIP服务卡</a></li>
	<?php  if($op=='addVipCode') { ?>
	<li class="active"><a href="<?php  echo $this->createWebUrl('viporder', array('op'=>'addVipCode'));?>">生成VIP服务卡</a></li>
	<?php  } ?>
	<!-- <li <?php  if($op=='updateVip') { ?>class="active"<?php  } ?>><a href="<?php  echo $this->createWebUrl('viporder', array('op'=>'updateVip'));?>">同步会员VIP</a></li> -->
</ul>
<?php  if($operation == 'display') { ?>
<div class="main">
    <div class="panel panel-info">
        <div class="panel-heading">筛选</div>
        <div class="panel-body">
            <form action="./index.php" method="get" class="form-horizontal" role="form">
                <input type="hidden" name="c" value="site" />
                <input type="hidden" name="a" value="entry" />
                <input type="hidden" name="m" value="fy_lessonv2" />
                <input type="hidden" name="do" value="viporder" />
                <input type="hidden" name="op" value="display" />
                <div class="form-group">
                    <label class="col-xs-12 col-sm-2 col-md-2 col-lg-1 control-label" style="width:100px;">订单编号</label>
                    <div class="col-sm-2 col-lg-3">
                        <input class="form-control" name="ordersn" type="text" value="<?php  echo $_GPC['ordersn'];?>">
                    </div>
					<label class="col-xs-12 col-sm-2 col-md-2 col-lg-2 control-label" style="width: 100px;">用户昵称</label>
                    <div class="col-sm-2 col-lg-3">
                        <input class="form-control" name="nickname" id="" type="text" value="<?php  echo $_GPC['nickname'];?>">
                    </div>
                </div>
                <div class="form-group">
					<label class="col-xs-12 col-sm-2 col-md-2 col-lg-1 control-label" style="width:100px;">订单状态</label>
                    <div class="col-sm-8 col-lg-3 col-xs-12">
                        <select name="status" class="form-control">
                            <option value="">不限</option>
							<option value="0" <?php  if(in_array($_GPC['status'],array('0'))) { ?> selected="selected" <?php  } ?>>待付款</option>
							<option value="1" <?php  if($_GPC['status'] == 1) { ?> selected="selected" <?php  } ?>>已付款</option>
                        </select>
                    </div>
                    <label class="col-xs-12 col-sm-2 col-md-2 col-lg-1 control-label" style="width: 100px;">下单时间</label>
                    <div class="col-sm-8 col-lg-3 col-xs-12">
                        <?php echo tpl_form_field_daterange('time', array('starttime'=>($starttime ? date('Y-m-d', $starttime) : false),'endtime'=> ($endtime ? date('Y-m-d', $endtime) : false)));?>
                    </div>
                    <div class="col-sm-3 col-lg-3">
                        <button class="btn btn-default"><i class="fa fa-search"></i> 搜索</button>&nbsp;&nbsp;&nbsp;&nbsp;
						<button type="submit" name="export" value="1" class="btn btn-success">导出Excel</button>
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
                    <th style="width:15%;">订单编号</th>
                    <th style="width:10%;">用户昵称</th>
                    <th style="width:16%;">服务内容</th>
                    <th style="width:10%;">服务价格</th>
					<th style="width:14%;">一二三级佣金</th>
                    <th style="width:10%;">支付方式</th>
                    <th style="width:10%;">订单状态</th>
                    <th style="width:13%;">下单时间</th>
                    <th style="text-align:right;">删除</th>
                </tr>
                </thead>
                <tbody style="font-size: 13px;">
                <?php  if(is_array($list)) { foreach($list as $item) { ?>
                <tr>
                    <td><?php  if($item['paytype']=='vipcard') { ?><a href="<?php  echo $this->createWebUrl('viporder', array('op'=>'vipcard','ordersn'=>$item['ordersn']));?>"><?php  echo $item['ordersn'];?></a><?php  } else { ?><?php  echo $item['ordersn'];?><?php  } ?></td>
                    <td><?php  echo $item['nickname'];?>/<?php  echo $item['realname'];?>/<?php  echo $item['mobile'];?></td>
                    <td><?php echo $item['level']['level_name'] ? $item['level']['level_name'] : '默认VIP';?>-<?php  echo $item['viptime'];?>天</td>
                    <td><?php  echo $item['vipmoney'];?> 元</td>
					<td><?php  echo $item['commission1'];?> / <?php  echo $item['commission2'];?> / <?php  echo $item['commission3'];?></td>
                    <td>
						<span class="label label-info">
						<?php  if($item['paytype'] == 'credit') { ?>余额支付
						<?php  } else if($item['paytype'] == 'wechat') { ?>微信支付
						<?php  } else if($item['paytype'] == 'alipay') { ?>支付宝支付
						<?php  } else if($item['paytype'] == 'vipcard') { ?>服务卡支付
						<?php  } else { ?>无<?php  } ?>
						</span>
                    </td>
                    <td>
                        <?php  if($item['status'] == 0) { ?><span class="label label-danger">未付款</span><?php  } ?>
						<?php  if($item['status'] == 1) { ?><span class="label label-success">已付款</span><?php  } ?>
                    </td>
                    <td><?php  echo date('Y-m-d H:i:s', $item['addtime'])?></td>
                    <td style="text-align:right;">
                        <a class="btn btn-default btn-sm" href="<?php  echo $this->createWebUrl('viporder', array('op' => 'delete', 'id' => $item['id'], 'page'=>$_GPC['page']))?>" title="删除订单" onclick="return confirm('此操作不可恢复，确认删除？');return false;"><i class="fa fa-times"></i></a>
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

<?php  } else if($op=='createOrder') { ?>
<div class="main">
    <form action="" method="post" class="form-horizontal form" enctype="multipart/form-data" onkeydown="if(event.keyCode==13){return false;}">
        <div class="panel panel-default">
            <div class="panel-heading">创建会员服务</div>
            <div class="panel-body">
				<div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">选择用户</label>
                    <div class="col-sm-9 col-xs-12">
                        <div class='input-group'>
                            <input type="text" id='nickname' maxlength="30" class="form-control" readonly />
							<input type="hidden" id='uid' name="uid"/>
                            <div class='input-group-btn'>
                                <button class="btn btn-default" type="button" onclick="popwin = $('#modal-module-member').modal();">选择用户</button>
                            </div>
                        </div>
                        <div id="modal-module-member"  class="modal fade" tabindex="-1">
                            <div class="modal-dialog" style='width: 920px;'>
                                <div class="modal-content">
                                    <div class="modal-header"><button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button><h3>选择用户</h3></div>
                                    <div class="modal-body" >
                                        <div class="row">
                                            <div class="input-group">
                                                <input type="text" class="form-control" name="kmember" value="" id="search-km" placeholder="请输入用户昵称/姓名/手机号" />
                                                <span class='input-group-btn'><button type="button" class="btn btn-default" onclick="search_member();">搜索</button></span>
                                            </div>
                                        </div>
                                        <div id="module-member" style="padding-top:5px;"></div>
                                    </div>
                                    <div class="modal-footer"><a href="javascript:;" class="btn btn-default" data-dismiss="modal" aria-hidden="true">关闭</a></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
				<div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">VIP等级</label>
                    <div class="col-sm-9">
                        <select name="level_id" class="form-control">
                        	<option>请选择...</option>
                        	<?php  if(is_array($level_list)) { foreach($level_list as $level) { ?>
                        	<option value="<?php  echo $level['id'];?>"><?php  echo $level['level_name'];?></option>
                        	<?php  } } ?>
                        </select>
                        <div class="help-block">
                        	选择指定VIP等级的VIP服务卡
                        </div>
                    </div>
                </div>
				<div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">有效期</label>
                    <div class="col-sm-9">
                        <?php  echo tpl_form_field_date('validity', time()+31*86400, true);?>
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
function search_member() {
	var uniacid = <?php  echo $uniacid?>;
	if ($.trim($('#search-km').val()) == '') {
		document.getElementById('search-km').focus();
		return;
	}
	$("#module-member").html("正在搜索....");
	$.get("<?php  echo $this->createWebUrl('getlessonormember', array('op'=>'getMember'))?>", { 
		uniacid:uniacid,keyword: $.trim($('#search-km').val())
	}, function (dat) {
		$('#module-member').html(dat);
	});
}
function select_member(obj) {
	$("#nickname").val(obj.nickname);
	$("#uid").val(obj.uid);
}
</script>

<?php  } else if($op=='vipcard') { ?>
<div class="mloading-bar" style="margin-top: -31px; margin-left: -140px;"><img src="<?php echo MODULE_URL;?>template/mobile/images/download.gif"><span class="mloading-text">上传处理中，请稍候...</span></div>
<div id="overlay"></div>
<script type="text/javascript">
/* 显示遮罩层 */
function showOverlay() {
    $("#overlay").height("100%");
    $("#overlay").width("100%");
    $("#overlay").fadeTo(200, 0);
	$(".mloading-bar").show();
}
</script>
<div class="main">
    <div class="panel panel-info">
        <div class="panel-heading">添加VIP服务卡</div>
        <div class="panel-body">
            <a class="btn btn-primary" style="margin-right:10px;" onclick="location.href='<?php  echo $this->createWebUrl('viporder', array('op'=>'addVipCode'));?>'"><i class="fa fa-plus"></i> 在线生成</a>
        </div>
    </div>

	<div class="panel panel-info">
        <div class="panel-heading">筛选</div>
        <div class="panel-body">
            <form action="./index.php" method="get" class="form-horizontal" role="form">
                <input type="hidden" name="c" value="site" />
                <input type="hidden" name="a" value="entry" />
                <input type="hidden" name="m" value="fy_lessonv2" />
                <input type="hidden" name="do" value="viporder" />
                <input type="hidden" name="op" value="vipcard" />
                <div class="form-group">
                    <label class="col-xs-12 col-sm-2 col-md-2 col-lg-1 control-label" style="width:100px;">订单编号</label>
                    <div class="col-sm-2 col-lg-3">
                        <input class="form-control" name="ordersn" type="text" value="<?php  echo $_GPC['ordersn'];?>">
                    </div>
					<label class="col-xs-12 col-sm-2 col-md-2 col-lg-2 control-label" style="width: 100px;">用户昵称</label>
                    <div class="col-sm-2 col-lg-3">
                        <input class="form-control" name="nickname" id="" type="text" value="<?php  echo $_GPC['nickname'];?>">
                    </div>
                </div>
                <div class="form-group">
					<label class="col-xs-12 col-sm-2 col-md-2 col-lg-1 control-label" style="width:100px;">服务卡状态</label>
                    <div class="col-sm-8 col-lg-3 col-xs-12">
                        <select name="is_use" class="form-control">
                            <option value="">全部状态</option>
							<option value="0" <?php  if(in_array($_GPC['is_use'],array('0'))) { ?> selected="selected" <?php  } ?>>未使用</option>
							<option value="1" <?php  if($_GPC['is_use'] == 1) { ?> selected="selected" <?php  } ?>>已使用</option>
							<option value="-1" <?php  if($_GPC['is_use'] == -1) { ?> selected="selected" <?php  } ?>>已过期</option>
                        </select>
                    </div>
                    <label class="col-xs-12 col-sm-2 col-md-2 col-lg-1 control-label" style="width:100px;">VIP等级</label>
                    <div class="col-sm-8 col-lg-3 col-xs-12">
                        <select name="level_id" class="form-control">
                            <option value="">全部等级</option>
                            <?php  if(is_array($level_list)) { foreach($level_list as $level) { ?>
                            <option value="<?php  echo $level['id'];?>" <?php  if($_GPC['level_id']==$level['id']) { ?>selected<?php  } ?>><?php  echo $level['level_name'];?></option>
                            <?php  } } ?>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-xs-12 col-sm-2 col-md-2 col-lg-1 control-label" style="width: 100px;">使用时间</label>
                    <div class="col-sm-8 col-lg-3 col-xs-12">
					<?php echo tpl_form_field_daterange('time', array('starttime'=>($starttime ? date('Y-m-d', $starttime) : false),'endtime'=> ($endtime ? date('Y-m-d', $endtime) : false)));?>
                    </div>
                    <div class="col-sm-3 col-lg-3">
                        <button class="btn btn-default"><i class="fa fa-search"></i> 搜索</button>&nbsp;&nbsp;
						<button type="submit" name="export" value="1" class="btn btn-success">导出 Excel</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    
    <div class="panel panel-default">
        <form action="<?php  echo $this->createWebUrl('viporder', array('op'=>'delAllCard'));?>" method="post" class="form-horizontal form">
        <div class="table-responsive panel-body">
            <table class="table table-hover">
                <thead class="navbar-inner">
                <tr>
					<th style="width:4%;"><input type="checkbox" id="checkItems"></th>
                    <th style="width:12%;">服务卡号</th>
                    <th style="width:18%;">卡密</th>
                    <th style="width:8%;">卡时长</th>
					<th style="width:12%;">有效期</th>
                    <th style="width:10%;">卡状态</th>
                    <th style="width:10%;">VIP等级</th>
					<th style="width:16%;">使用订单号</th>
                    <th style="text-align:right;">操作</th>
                </tr>
                </thead>
                <tbody style="font-size:13px;">
                <?php  if(is_array($list)) { foreach($list as $item) { ?>
                <tr>
                    <td><input type="checkbox" name="ids[]" value="<?php  echo $item['id'];?>"></td>
					<td><?php  echo $item['card_id'];?></td>
                    <td><?php  echo $item['password'];?></td>
                    <td><?php  echo $item['viptime'];?> 天</td>
                    <td><?php  echo date('Y-m-d H:i',$item['validity'])?></td>
					<td>
						<?php  if($item['is_use'] == 0 && time() > $item['validity']) { ?><span class="label label-default">已过期</span><?php  } ?>
						<?php  if($item['is_use'] == 0 && time() <= $item['validity']) { ?><span class="label label-success">未使用</span><?php  } ?>
						<?php  if($item['is_use'] == 1) { ?><span class="label label-warning">已使用</span><?php  } ?>
					</td>
					<td><?php  echo $item['level']['level_name'];?></td>
                    <td><a href="<?php  echo $this->createWebUrl('viporder', array('ordersn'=>$item['ordersn']));?>"><?php  echo $item['ordersn'];?></a></td>
                    <td style="text-align:right;">
                        <a class="btn btn-default btn-sm" href="<?php  echo $this->createWebUrl('viporder', array('op' => 'delCard', 'id' => $item['id']))?>" title="删除服务卡" onclick="return confirm('此操作不可恢复，确认删除？');return false;"><i class="fa fa-times"></i></a>
                    </td>
                </tr>
                <?php  } } ?>
                </tbody>
				<tfoot>
					<tr>
						<td colspan="9">
							<input name="submit" type="submit" class="btn btn-primary" value="批量删除" onclick="return delAll()">
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

	return true;
}
</script>

<?php  } else if($op=='addVipCode') { ?>
<div class="mloading-bar" style="margin-top: -31px; margin-left: -140px;"><img src="<?php echo MODULE_URL;?>template/mobile/images/download.gif"><span class="mloading-text">处理中，请稍候...</span></div>
<div id="overlay"></div>
<script type="text/javascript">
/* 显示遮罩层 */
function showOverlay() {
    $("#overlay").height("100%");
    $("#overlay").width("100%");
    $("#overlay").fadeTo(200, 0);
	$(".mloading-bar").show();
}
</script>
<div class="main">
    <form action="" method="post" class="form-horizontal form" enctype="multipart/form-data">
        <div class="panel panel-default">
            <div class="panel-heading">生成VIP服务卡</div>
            <div class="panel-body">
				<div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">服务卡前缀</label>
                    <div class="col-sm-9">
                        <input type="text" name="prefix" maxlength="2" value="VP" class="form-control">
                        <div class="help-block">
                        	支持自定义优惠码的2位前缀，如：VP
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">VIP等级</label>
                    <div class="col-sm-9">
                        <select name="level_id" class="form-control">
                        	<option>请选择...</option>
                        	<?php  if(is_array($level_list)) { foreach($level_list as $level) { ?>
                        	<option value="<?php  echo $level['id'];?>"><?php  echo $level['level_name'];?></option>
                        	<?php  } } ?>
                        </select>
                        <div class="help-block">
                        	选择生成指定VIP等级的VIP服务卡
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">生成数量</label>
                    <div class="col-sm-9">
                        <div class="input-group">
                            <input type="text" name="number" value="" class="form-control">
                            <span class="input-group-addon">张</span>
                        </div>
                        <div class="help-block">
                        	建议单次生成不要超过500张，一次生成大量服务卡会占用大量服务器资源
                        </div>
                    </div>
                </div>
				<div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">服务卡时长</label>
                    <div class="col-sm-9">
                        <div class="input-group">
                            <input type="text" name="days" value="" class="form-control">
                            <span class="input-group-addon">天</span>
                        </div>
                    </div>
                </div>
				<div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">有效期</label>
                    <div class="col-sm-9">
                        <?php  echo tpl_form_field_date('validity', strtotime('+31 day'), true);?>
                    </div>
                </div>
            </div>
        </div>

        <div class="form-group col-sm-12">
            <input type="submit" name="submit" value="提交" class="btn btn-primary col-lg-1" onclick="showOverlay()"/>
            <input type="hidden" name="token" value="<?php  echo $_W['token'];?>" />
        </div>
    </form>
</div>
<?php  } else if($op=='updateVip') { ?>
<div class="mloading-bar" style="margin-top: -31px; margin-left: -140px;"><img src="<?php echo MODULE_URL;?>template/mobile/images/download.gif"><span class="mloading-text">同步数据中，请勿关闭或刷新...</span></div>
<div id="overlay"></div>
<script type="text/javascript">
/* 显示遮罩层 */
function showOverlay() {
    $("#overlay").height("100%");
    $("#overlay").width("100%");
    $("#overlay").fadeTo(200, 0);
	$(".mloading-bar").show();
}
</script>
<div class="main">
	<div class="alert alert-info">
	    <span style="color:red;">【请勿重复操作不同VIP等级】</span>由于微课堂V1系统仅存在单VIP等级，升级到微课堂V2版本后，请在先在“基本设置——会员服务”里增加VIP会员等级，然后在下面选择指定的VIP等级，即可同步原先的VIP会员到指定的VIP等级之下。
	</div>
    <form action="" method="post" class="form-horizontal form" enctype="multipart/form-data">
        <div class="panel panel-default">
            <div class="panel-heading">同步会员VIP</div>
            <div class="panel-body">
				<div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">VIP等级</label>
                    <div class="col-sm-9">
                    	<select name="level_id" class="form-control">
                    		<option>请选择...</option>
                    		<?php  if(is_array($level_list)) { foreach($level_list as $level) { ?>
                    		<option value="<?php  echo $level['id'];?>"><?php  echo $level['level_name'];?></option>
                    		<?php  } } ?>
                    	</select>
                        <div class="help-block">
                        	选择指定VIP等级操作后，原微课堂系统的VIP用户将自动完成迁移到该指定VIP等级之下，请勿重复选择不同VIP等级进行操作。
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="form-group col-sm-12">
            <input type="submit" name="submit" value="提交" class="btn btn-primary col-lg-1" onclick="showOverlay()"/>
            <input type="hidden" name="token" value="<?php  echo $_W['token'];?>" />
        </div>
    </form>
</div>
<?php  } ?>

<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/footer', TEMPLATE_INCLUDEPATH)) : (include template('common/footer', TEMPLATE_INCLUDEPATH));?>