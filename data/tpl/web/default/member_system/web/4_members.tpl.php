<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/header_distribution_user', TEMPLATE_INCLUDEPATH)) : (include template('common/header_distribution_user', TEMPLATE_INCLUDEPATH));?>
<ul class="nav nav-tabs">
	<li <?php  if(!$op || $op == 'display') { ?>class="active"<?php  } ?>><a href="<?php  echo $this->createWebUrl('members', array('op' => 'display'));?>">用户管理</a></li>
	<li <?php  if(!$op || $op == 'add_post') { ?>class="active"<?php  } ?>><a href="<?php  echo $this->createWebUrl('members', array('op' => 'add_post'));?>">用户添加</a></li>
	<li><a href="<?php  echo $this->createWebUrl('recharge');?>">充值记录</a></li>
</ul>
<style>
.table td span{display:inline-block;margin-top:4px;}
.table td input{margin-bottom:0;}
th{
	text-align: center !important;
}
td{
	text-align: center !important;
}
.red{color:red;font-weight:bold}
</style>
<?php  if(!$op ||  $op == 'display') { ?>
<div class="main">
<form action="" method="get" class="form-horizontal" role="form">
<div class="panel panel-info">
        <div class="panel-heading">筛选</div>
        <div class="panel-body">
                <input type="hidden" name="c" value="site" />
                <input type="hidden" name="a" value="entry" />
                <input type="hidden" name="m" value="db_play" />
                <input type="hidden" name="do" value="members" />
                <div class="form-group">
                    <label class="col-xs-12 col-sm-2 col-md-2 col-lg-1 control-label">关键字</label>
                    <div class="col-xs-12 col-sm-9 col-lg-9">
                        <input class="form-control" name="keyword" id="" type="text" value="<?php  echo $_GPC['keyword'];?>" placeholder="请输入用户昵称/电话">
                    </div>
                </div>
                
                <div class="form-group">
                <label class="col-xs-12 col-sm-2 col-md-2 col-lg-1 control-label"></label>
                    <div class=" col-xs-12 col-sm-2 col-lg-2">
                        <button class="btn btn-default" ><i class="fa fa-search"></i> 搜索</button>
                   	</div>
                </div>
        </div>
    </div>
</form>

	<div style="padding:15px;background: white;">
		<table class="table table-hover" style="table-layout: initial;">
			<thead class="navbar-inner">
				<tr>
               		<th>用户ID</th>
                    <th>靓号ID</th>
					<th>用户信息</th>
					<th>电话</th>
					<th>支付宝账号</th>
					<th>支付宝实名</th>
					<th>签约公司</th>
					<th>邀请人数</th>
					<th>余额</th>
					<th>积分</th>
					<th>状态</th>
					<th>操作</th>
				</tr>
			</thead>
			<tbody>
				<?php  if(is_array($list)) { foreach($list as $item) { ?>
				<tr>
                	<td><?php  echo $item['id'];?></td>
                    <td><?php  echo $item['user_no'];?></td>
					<td><?php  echo $item['nickname'];?></td>
					<td><?php  echo $item['mobile'];?></td>
					<td><?php  echo $item['zfb'];?></td>
					<td><?php  echo $item['realname'];?></td>
					<td><?php  echo $item['title'];?></td>
					<td><?php  echo $item['number'];?></td>
					<td><?php  echo $item['credit1'];?></td>
					<td><?php  echo $item['credit2'];?></td>
					<td data-id='<?php  echo $item["id"];?>'><label class="label <?php  if($item['is_black']) { ?>label-success<?php  } else { ?>label-default<?php  } ?> is_ok" data-tid="<?php  echo $item['id'];?>"><?php  if($item['is_black']) { ?>启用<?php  } else { ?>禁用<?php  } ?></label></td>
					<td>
						<a href="<?php  echo $this->createWebUrl('billlog', array('op' => 'display', 'mid' => $item['id']))?>" title="消费记录" class="btn btn-sm btn-default"><i class="fa fa-area-chart"></i></a>
						<a href="<?php  echo $this->createWebUrl('recharge', array('op' => 'display', 'mid' => $item['id']))?>" title="充值记录" class="btn btn-sm btn-default"><i class="fa fa-bar-chart"></i></a>
						<a href="<?php  echo $this->createWebUrl('serve', array('op' => 'display', 'mid' => $item['id']))?>" title="查看服务" class="btn btn-sm btn-warning"><i class="fa fa-edit"></i></a>
                        <a href="javascript:void(0);" title="修改" class="btn btn-sm btn-warning"  data-toggle="modal" data-target="#edi<?php  echo $item['id'];?>"><i class="fa fa-edit">修改</i></a>
                        <?php  if($item['groupid']>0) { ?>
						<a href="<?php  echo $this->createWebUrl('members', array('op' => 'del_group', 'id' => $item['id']))?>" title="解约" class="btn btn-sm btn-warning"><i class="fa fa-edit">解约</i></a>
                        <?php  } ?>
						<form action="" method="post" id="oneForm" role="form">
		                <div class="modal fade" id="edi<?php  echo $item['id'];?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		                    <div class="modal-dialog">
		                        <div class="modal-content">
		                            <div class="modal-header">
		                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
		                                <h4 class="modal-title text-center" id="">修改用户资料</h4>
		                            </div>
		                            <div class="modal-body">
		                                <table class="table table-bordered">
                                        
                                           <tr>
		                                        <td class="text-right">靓号:</td>
		                                        <td class="text-left"><input type="text" id="user_no<?php  echo $item['id'];?>" name="user_no" value="<?php  echo $item['user_no'];?>"></td>
		                                    </tr>
		                                    <tr>
		                                        <td class="text-right">昵称:</td>
		                                        <td class="text-left"><input type="text" id="nickname<?php  echo $item['id'];?>" name="nickname" value="<?php  echo $item['nickname'];?>"></td>
		                                    </tr>
		                                    <tr>
		                                    	<td class="text-right">性别:</td>
		                                    	<td>
		                                    		<label>
		                                    			<input type="radio" name="sex<?php  echo $item['id'];?>"  value="1" <?php  if($item['sex'] == 1) { ?>checked="checked"<?php  } ?>>男
		                                    		</label>
		                                    		<label>
		                                    			<input type="radio" name="sex<?php  echo $item['id'];?>" value="2" <?php  if($item['sex'] == 2) { ?>checked="checked"<?php  } ?>>女
		                                    		</lab0el>
		                                    	</td>
		                                    </tr>
		                                    <tr>
		                                        <td class="text-right">YY号:</td>
		                                        <td class="text-left"><input type="text" id="ramsn<?php  echo $item['id'];?>" name="YY" value="<?php  echo $item['YY'];?>"></td>
		                                    </tr>
											<tr>
												<td class="text-right">支付宝账号:</td>
												<td class="text-left"><input type="text" id="zfb<?php  echo $item['id'];?>" name="zfb" value="<?php  echo $item['zfb'];?>"></td>
											</tr>
											<tr>
												<td class="text-right">技能抽成:</td>
												<td class="text-left"><input type="text" id="rebate<?php  echo $item['id'];?>" name="rebate" value="<?php  echo $item['rebate'];?>"></td>
											</tr>
		                                    <tr>
		                                    	<td class="text-right">是否拉黑:</td>
		                                    	<td>
		                                    		<label>
		                                    			<input type="radio" name="is_black"  value="0" <?php  if($item['is_black'] == 0) { ?>checked="checked"<?php  } ?>>否
		                                    		</label>
		                                    		<label>
		                                    			<input type="radio" name="is_black" value="1" <?php  if($item['is_black'] == 1) { ?>checked="checked"<?php  } ?>>是
		                                    		</lab0el>
		                                    	</td>
		                                    </tr>
		                                </table>
		                            </div>
		                            <div class="modal-footer">
		                                <button type="button" class="btn btn-default col-sm-3 col-xs-offset-3" data-dismiss="modal">关闭</button>
		                                <button type="button" id="xiugai" class="btn btn-primary col-sm-3" onclick="ed_user(<?php  echo $item['id'];?>)">确认</button>
		                            </div>
		                        </div><!-- /.modal-content -->
		                    </div><!-- /.modal -->
		                </div>
		                </form>
					</td>
				</tr>
				<?php  } } ?>
			</tbody>
		</table>
		<?php  echo $pager;?>
	</div>
	<script>
$(function(){
	$(".is_ok").click(function(){
		var that = $(this);
		var id = $(this).attr('data-tid');
		$.ajax({
			type:'post',
			url:"<?php  echo $this->createWebUrl('members',array('op'=>'check_status'))?>",
			data:{id:id},
			success:function(data){
				var data = $.parseJSON(data);
				if(data == 21){
					that.empty();
					that.removeClass('label-success');
					that.addClass('label-default');
					that.html("禁用");
				}
				if(data == 11){
					that.empty();
					that.removeClass('label-default');
					that.addClass('label-success');
					that.html("启用");
				}
			}
		});
	});
});
function ed_user(id) {
	var user_no = $('#user_no'+id).val();
	var nickname = $('#nickname'+id).val();
	var yynum = $('#ramsn'+id).val();
	var zfb = $('#zfb'+id).val();
	var rebate = $('#rebate'+id).val();
	var sex = $('input[name=sex'+id+']:checked').val();
	var is_black = $('input[name=is_black]:checked').val();
	$.ajax({
		url:"<?php  echo $this->createWebUrl('members',array('op'=>'editor_user'))?>",
		type:'post',
		data:{user_no:user_no,nickname:nickname,yy:yynum,id:id,is_black:is_black,zfb:zfb,sex:sex,rebate:rebate},
		success:function(data) {
			console.log(data);
			alert(data);
			window.location.reload();
		}
	})
}
</script>
</div>
<?php  } else if($op == 'add_post') { ?>
<div class="panel panel-info">
	<div class="panel-body">
		<form action="<?php  echo $this->createWebUrl('members', array('op' => 'add'));?>" method="post" class="form-horizontal" role="form">
			<div class="form-group">
				<label class="col-xs-12 col-sm-2 col-md-2 col-lg-1 control-label">用户手机号</label>
				<div class="col-sm-9">
					<input class="form-control" name="mobile" id="groups_mobile" type="text" value="">
				</div>
			</div>

			<div class="form-group">
				<label class="col-xs-12 col-sm-2 col-md-2 col-lg-1 control-label">用户密码</label>
				<div class="col-sm-9">
					<input class="form-control" name="password" id="" type="password" value="">
				</div>
			</div>
			<button type="submit" class="btn btn-primary" name="submit" id='summit_info' value="提交">保存</button>
		</form>
	</div>
</div>
<script>
	require(['jquery', 'util'], function ($, u) {
		$(function () {
			u.editor($('#detail')[0]);
		});
	});

	$(function(){
		$("#summit_info").click(function(){
			var mobile = $("#groups_mobile").val();
			if (mobile && mobile.search(/^([0-9]{11})?$/) == -1) {
				alert('请输入正确的手机号码！');
				return false;
			}
		});
	});
</script>
<?php  } else if($op == 'post') { ?>
<div class="panel panel-info">
		<div class="panel-body">
			<form action="" method="post" class="form-horizontal" role="form">
			<input type="hidden" name="id" value="<?php  echo $item['id'];?>">
			
			<div class="form-group">
				<label class="col-xs-12 col-sm-2 col-md-2 col-lg-1 control-label">排序</label>
				<div class="col-sm-9">
					<input class="form-control" name="displayorder" id='displayorder' type="number" min="0" value="<?php  echo $item['displayorder'];?>">
				</div>
			</div>
			
			<div class="form-group">
				<label class="col-xs-12 col-sm-2 col-md-2 col-lg-1 control-label"><span class='red'>*</span>工会名称</label>
				<div class="col-sm-9">
					<input class="form-control" required="required" name="title" id='title' type="text" value="<?php  echo $item['title'];?>">
				</div>
			</div>
			
			<div class="form-group">
				<label class="col-xs-12 col-sm-2 col-md-2 col-lg-1 control-label">工会logo</label>
				<div class="col-sm-9">
					<?php  echo tpl_form_field_image('thumb',$item['thumb']);?>
				</div>
			</div>
			<div class="form-group">
				<label class="col-xs-12 col-sm-2 col-md-2 col-lg-1 control-label">工会联系人</label>
				<div class="col-sm-9">
					<input class="form-control" name="groups_name" id="groups_name" type="text" value="<?php  echo $item['groups_name'];?>">
				</div>
			</div>
			
			<div class="form-group">
				<label class="col-xs-12 col-sm-2 col-md-2 col-lg-1 control-label">工会联系电话</label>
				<div class="col-sm-9">
					<input class="form-control" name="groups_mobile" id="groups_mobile" type="text" value="<?php  echo $item['groups_mobile'];?>">
				</div>
			</div>
			
			<div class="form-group">
				<label class="col-xs-12 col-sm-2 col-md-2 col-lg-1 control-label">工会简介</label>
				<div class="col-sm-9">
					<input class="form-control" name="des" id="des" type="text" value="<?php  echo $item['des'];?>">
				</div>
			</div>
			
			<div class="form-group">
	            <label class="col-xs-12 col-sm-2 col-md-2 col-lg-1 control-label">工会详情</label>
	            <div class="col-sm-9 col-xs-12">
	                <textarea style="height: 60px;" id="detail" name="detail" class="form-control span7" cols="60"><?php  echo $item['detail'];?></textarea>
	            </div>
	        </div>
			
			<div class="form-group">
				<label class="col-xs-12 col-sm-2 col-md-2 col-lg-1 control-label">状态</label>
				<div class="col-sm-9">
					<label><input type="radio" name="isshow" checked="checked" value="0"> 禁用</label>
					<label style="margin-left: 10px;"><input type="radio" name="isshow" <?php  if($item['isshow']) { ?>checked="checked"<?php  } ?> value="1"> 启用</label>
				</div>
			</div>
			<button type="submit" class="btn btn-primary" name="submit" id='summit_info' value="提交">保存</button>
			<input type="hidden" name="token" value="<?php  echo $_W['token'];?>" />
			</form>
	</div>
</div>
<script>
require(['jquery', 'util'], function ($, u) {
    $(function () {
        u.editor($('#detail')[0]);
    });
});

$(function(){
	$("#summit_info").click(function(){
		var mobile = $("#groups_mobile").val();
		if (mobile && mobile.search(/^([0-9]{11})?$/) == -1) {
			alert('请输入正确的手机号码！');
			return false;
		}
	});
});
</script>
<?php  } ?>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/footer', TEMPLATE_INCLUDEPATH)) : (include template('common/footer', TEMPLATE_INCLUDEPATH));?>
