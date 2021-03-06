<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 0) ? (include $this->template('common/header', TEMPLATE_INCLUDEPATH)) : (include template('common/header', TEMPLATE_INCLUDEPATH));?>
<div class="new-keyword" id="js-user-group-post" ng-controller="UserGroupPost" ng-cloak>
	<ol class="breadcrumb we7-breadcrumb">
		<a href="<?php  echo url('user/group/display')?>"><i class="wi wi-back-circle"></i> </a>
		<li><a href="<?php  echo url('user/group/display')?>">用户组管理</a></li>
		<li>添加用户组</li>
	</ol>
	<form class="we7-form user-group-edit" method="post" action="">
		<div class="form-group">
			<label for="" class="control-label col-sm-2">用户权限组名</label>
			<div class="form-controls col-sm-8">
				<input type="text" name="name" class="form-control" ng-model="groupInfo.name">
			</div>
		</div>
		<div class="form-group">
			<label for="" class="control-label col-sm-2">创建项目数量</label>
			<div class="form-controls col-sm-8">
				<input type="text" name="maxaccount" class="form-control" ng-model="groupInfo.maxaccount">
				<span class="help-block">限制项目的数量，为0则不允许添加。</span>
			</div>
		</div>
		<div class="form-group">
			<label for="" class="control-label col-sm-2">创建小程序数量</label>
			<div class="form-controls col-sm-8">
				<input type="text" name="maxwxapp" class="form-control" ng-model="groupInfo.maxwxapp">
				<span class="help-block">限制小程序的数量，为0则不允许添加。</span>
			</div>
		</div>
		<div class="form-group">
			<label for="" class="control-label col-sm-2">充值比例</label>
			<div class="form-controls col-sm-8">
				<input type="text" name="discount" class="form-control" ng-model="groupInfo.discount">
				<span class="help-block">用户充值余额时的比率。例如如果为2，则用户支付100元可以购买到200余额，余额可以用来续费和购买模块</span>
			</div>
		</div>
		<div class="form-group">
			<label for="" class="control-label col-sm-2">用户组年费</label>
			<div class="form-controls col-sm-8">
				<input type="text" name="price" class="form-control" ng-model="groupInfo.price">
				<span class="help-block">用户升级用户组或者续费时，费用直接从账户余额划扣</span>
			</div>
		</div>
		<div class="form-group">
			        <label for="" class="control-label col-sm-2">是否开启版权设置</label>
			        <div class="form-controls col-sm-8">
					<input type="radio" name="domain" id="status-1" <?php  if(!empty($group_info['domain'])) { ?> checked="checked" <?php  } ?> value="1" />
					<label class="radio-inline" for="status-1">
						 是
					</label>
					<input type="radio" name="domain" id="status-0" <?php  if(empty($group_info['domain'])) { ?> checked="checked" <?php  } ?> value="0" /> 
					<label class="radio-inline" for="status-0">
						否
					</label>
					<span class="help-block">设置为‘是’，该用户组下的用户将可设置独立域名和站点版权信息。</span>
			        </div>
		</div>
		<div class="form-group">
			<label for="" class="control-label col-sm-2">有效期</label>
			<div class="form-controls col-sm-8">
				<div class="input-group">
					<input type="text" name="timelimit" class="form-control" ng-model="groupInfo.timelimit">
					<span class="input-group-addon font-default">天</span>
				</div>
			<span class="help-block">设置用户组的有效期限。0为不限制期限。到期后，该用户下的所有项目只能使用 "基础服务"</span>
			</div>
		</div>
		<div class="panel we7-panel">
			<div class="panel-heading">
				选择应用权限套餐组
				<a href="<?php  echo url('module/group/post')?>" class="color-default pull-right">新建应用权限套餐组</a>
			</div>
			<div class="panel-body user-permission">
				<div ng-repeat="pack in packages">
					<div class="permission-heading">
						<input id="checkbox-{{pack.id}}" type="checkbox" name='package[]' value="{{pack.id}}" ng-checked="pack.checked">
						<label for="checkbox-{{pack.id}}" ng-bind="pack.name"></label>
						<div class="pull-right permission-edit">
							<a href="javascript:;" class="color-default js-unfold" data-toggle="collapse" data-target="#demo-{{pack.id}}" ng-click="changeText($event)">展开</a>
						</div>
					</div>
					<div class="collapse" id="demo-{{pack.id}}">
						<table class="table we7-table table-hover">
							<col width="90px" />
							<col />
							<tr class="permission-apply">
								<td class="vertical-middle">项目应用</td>
								<td>
									<ul>
										<li ng-repeat="module in pack.modules" class="col-sm-2 text-over text-left">
											<div ng-if="module.name != 'all'">
												<img ng-src="{{ module.logo }}" alt="">
												{{ module.title }}
											</div>
										</li>
									</ul>
								</td>
							</tr>
							<tr class="permission-apply">
								<td class="vertical-middle">小程序应用</td>
								<td>
									<ul>
										<li ng-repeat="wxapp in pack.wxapp">
											<span class="label label-info" ng-bind="wxapp.title"></span>
										</li>
									</ul>
								</td>
							</tr>
							<tr class="permission-template">
								<td class="vertical-middle">模板</td>
								<td><ul><li ng-repeat="tpl in pack.templates"><span class="label label-info" ng-bind="tpl.title"></span></li></ul></td>
							</tr>
						</table>
					</div>
				</div>
				<?php  if(uni_user_see_more_info(ACCOUNT_MANAGE_NAME_VICE_FOUNDER, false)) { ?>
				<div>
					<div class="permission-heading">
						<input id="checkbox-0" type="checkbox" value="-1" name='package[]' ng-checked="groupInfo.check_all">
						<label for="checkbox-0">所有服务</label>
						<div class="pull-right permission-edit">
							<a href="javascript:;" class="color-default js-unfold" data-toggle="collapse" data-target="#demo-0" ng-click="changeText($event)">展开</a>
						</div>
					</div>
					<div class="collapse" id="demo-0">
						<table  class="table we7-table table-hover">
							<col width="90px" />
							<col />
							<tr class="permission-apply">
								<td class="vertical-middle">应用</td>
								<td><ul><li><span class="label label-danger">系统所有模块</span></li></ul></td>
							</tr>
							<tr class="permission-template">
								<td class="vertical-middle">模板</td>
								<td><ul><li><span class="label label-danger">系统所有模板</span></li></ul></td>
							</tr>
						</table>
					</div>
				</div>
				<?php  } ?>
			</div>
		</div>
		<input type="submit" name="submit" value="保存" class="btn btn-primary" ng-style="{'padding': '6px 50px'}" />
		<input type="hidden" name="token" value="<?php  echo $_W['token'];?>">
	</form>
</div>
<script>
	angular.module('userGroup').value('config', {
		groupInfo: <?php echo !empty($group_info) ? json_encode($group_info) : 'null'?>,
		packages: <?php echo !empty($packages) ? json_encode($packages) : 'null'?>,
	});
	angular.bootstrap($('#js-user-group-post'), ['userGroup']);
</script>
<?php (!empty($this) && $this instanceof WeModuleSite || 0) ? (include $this->template('common/footer', TEMPLATE_INCLUDEPATH)) : (include template('common/footer', TEMPLATE_INCLUDEPATH));?>