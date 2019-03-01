<?php defined('IN_IA') or exit('Access Denied');?><!-- 
 * 分销设置
 * ============================================================================
 * 版权所有 2015-2017 风影随行，并保留所有权利。
 * 网站地址: http://www.haoshu888.com
 * ----------------------------------------------------------------------------
 * 这不是一个自由软件！不允许对程序代码以任何形式任何目的的再发布，作者将保留
 * 追究法律责任的权力和最终解释权。
 * ============================================================================
-->

<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/header', TEMPLATE_INCLUDEPATH)) : (include template('common/header', TEMPLATE_INCLUDEPATH));?>
<ul class="nav nav-tabs">
    <li><a href="<?php  echo $this->createWebUrl('agent');?>">分销商管理</a></li>
	<li><a href="<?php  echo $this->createWebUrl('commission', array('op'=>'commissionlog'));?>">分销佣金明细</a></li>
	<li><a href="<?php  echo $this->createWebUrl('commission', array('op'=>'statis'));?>">分销佣金统计</a></li>
	<li><a href="<?php  echo $this->createWebUrl('commission', array('op'=>'level'));?>">分销商等级</a></li>
	<li class="active"><a href="<?php  echo $this->createWebUrl('comsetting');?>">分销设置</a></li>
</ul>
<style>
.item_box img{
	width: 100%;
	height: 100%;
}
.focus-setting{
	border-bottom:1px #428BCA dashed;
	padding-bottom:20px;
}
</style>
<div class="main">
	<form action="" method="post" class="form-horizontal form" enctype="multipart/form-data">
		<div class="panel panel-default">
            <div class="panel-heading">分销功能</div>
            <div class="panel-body">
				<div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">分销功能</label>
                    <div class="col-sm-9">
                        <label class="radio-inline"><input type="radio" name="is_sale" value="1" id="issale1" <?php  if($setting['is_sale'] == 1) { ?>checked="true"<?php  } ?> /> 开启</label>
                        &nbsp;
                        <label class="radio-inline"><input type="radio" name="is_sale" value="0" id="issale2"  <?php  if(empty($setting) || $setting['is_sale'] == 0) { ?>checked="true"<?php  } ?> /> 关闭</label>
                        <span class="help-block"></span>
                    </div>
                </div>
				<div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">分销内购</label>
                    <div class="col-sm-9">
                        <label class="radio-inline"><input type="radio" name="self_sale" value="1" id="selfsale1" <?php  if($setting['self_sale'] == 1) { ?>checked="true"<?php  } ?> /> 开启</label>
                        &nbsp;
                        <label class="radio-inline"><input type="radio" name="self_sale" value="0" id="selfsale2"  <?php  if(empty($setting) || $setting['self_sale'] == 0) { ?>checked="true"<?php  } ?> /> 关闭</label>
                        <span class="help-block">开启分销内购，购买人获得一级分销佣金</span>
                    </div>
                </div>
				<div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">分销商默认状态</label>
                    <div class="col-sm-9">
                        <label class="radio-inline"><input type="radio" name="agent_status" value="1" <?php  if($setting['agent_status'] == 1) { ?>checked="true"<?php  } ?> onclick="changeAgentStatus(this.value)"/> 正常</label>
                        &nbsp;
                        <label class="radio-inline"><input type="radio" name="agent_status" value="0" <?php  if(empty($setting) || $setting['agent_status'] == 0) { ?>checked="true"<?php  } ?> onclick="changeAgentStatus(this.value)"/> 冻结</label>
                        <span class="help-block">正常状态即用户进入微课堂即成为分销商，可以发展下级；冻结状态的分销商不能发展下级，需要满足分销商条件后转为正常状态方可发展下级。</span>
                    </div>
                </div>
				<div class="form-group <?php  if($setting['agent_status']==1) { ?>hide<?php  } ?>" id="agent_condition">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">分销商冻结状态转正常</label>
                    <div class="col-sm-3">
						<span class="help-block">1、购买订单累计金额满指定金额</span>
						<div class="input-group">
							<input type="text" name="order_amount" value="<?php  echo $agent_condition['order_amount'];?>" class="form-control" placeholder="0表示不限制"><span class="input-group-addon">元</span>
						</div>
					</div>
					<div class="col-sm-3">
						<span class="help-block">2、购买订单累计满指定订单数</span>
						<div class="input-group">
							<input type="text" name="order_total" value="<?php  echo $agent_condition['order_total'];?>" class="form-control" placeholder="0表示不限制"><span class="input-group-addon">单</span>
						</div>
					</div>
                </div>
				<div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">分销获得佣金身份</label>
                    <div class="col-sm-9">
                        <label class="radio-inline"><input type="radio" name="sale_rank" value="1" id="selfsale1" <?php  if(empty($setting) || $setting['sale_rank'] == 1) { ?>checked="true"<?php  } ?> /> 任何人</label>
                        &nbsp;
                        <label class="radio-inline"><input type="radio" name="sale_rank" value="2" id="selfsale2"  <?php  if($setting['sale_rank'] == 2) { ?>checked="true"<?php  } ?> /> VIP身份</label>
                        <span class="help-block">分销身份是指用户A推广了下级B，下级B消费付款时，上级A即可获得佣金(或上级A必须为VIP身份时才能获得佣金)</span>
                    </div>
                </div>
				<div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">佣金提现方式</label>
                    <div class="col-sm-9">
						<input name="cash_way[]" type="checkbox" value="credit" <?php  if(in_array('credit',$cash_way)) { ?>checked<?php  } ?> /> 提现到余额&nbsp;&nbsp;&nbsp;
						<input name="cash_way[]" type="checkbox" value="weachat" <?php  if(in_array('weachat',$cash_way)) { ?>checked<?php  } ?> /> 提现到微信钱包&nbsp;&nbsp;&nbsp;
						<input name="cash_way[]" type="checkbox" value="alipay" <?php  if(in_array('alipay',$cash_way)) { ?>checked<?php  } ?> /> 提现到支付宝
                    </div>
                </div>
				<div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">佣金提现处理方式</label>
                    <div class="col-sm-9">
                        <label class="radio-inline"><input type="radio" name="cash_type" value="1" id="cashtype1" <?php  if(empty($setting) || $setting['cash_type'] == 1) { ?>checked="true"<?php  } ?> /> 管理员审核</label>
                        &nbsp;
                        <label class="radio-inline"><input type="radio" name="cash_type" value="2" id="cashtype2"  <?php  if($setting['cash_type'] == 2) { ?>checked="true"<?php  } ?> /> 自动到账</label>
                        <span class="help-block">1、管理员审核是指会员提交佣金提现申请后，需由管理员审核通过后，佣金才会提现到账；自动到账无需管理员审核，佣金即刻到账；<br/>2、提现到余额即刻，无需管理员审核；<br/>3、提现到微信钱包可设置管理员审核或自动到账；<br/>4、由于支付宝关闭转账接口，提现到支付宝须管理员线下打款，该方式主要用于过渡新开通微信没法开通微信企业付款。</span>
                    </div>
                </div>
				<div class="form-group item">
					<label class="col-xs-12 col-sm-3 col-md-2 control-label">提现最低金额</label>
					<div class="col-sm-4">
						<div class="input-group">
							<input type="text" name="cash_lower" value="<?php  echo $setting['cash_lower'];?>" class="form-control"><span class="input-group-addon">元</span>
						</div>
						<span class="help-block">提现金额最少为1.00元</span>
					</div>
				</div>
				<div class="form-group item">
					<label class="col-xs-12 col-sm-3 col-md-2 control-label">分销等级</label>
					<div class="col-sm-4">
						<select name="level" class="form-control" onchange="checklevel(this.value);">
							<option value="1" <?php  if($setting['level']==1) { ?>selected<?php  } ?>>一级分销</option>
							<option value="2" <?php  if($setting['level']==2) { ?>selected<?php  } ?>>二级分销</option>
							<option value="3" <?php  if($setting['level']==3) { ?>selected<?php  } ?>>三级分销</option>
						</select>
					</div>
				</div>
				<div class="form-group item" id="level1">
					<label class="col-xs-12 col-sm-3 col-md-2 control-label">一级佣金比例</label>
					<div class="col-sm-4">
						<div class="input-group">
							<input type="text" name="commission1" value="<?php  echo $commission['commission1'];?>" class="form-control"><span class="input-group-addon">%</span>
						</div>
					</div>
				</div>
				<div class="form-group item <?php  if(in_array($setting['level'],array('1'))) { ?>hide<?php  } ?>" id="level2">
					<label class="col-xs-12 col-sm-3 col-md-2 control-label">二级佣金比例</label>
					<div class="col-sm-4">
						<div class="input-group">
							<input type="text" name="commission2" value="<?php  echo $commission['commission2'];?>" class="form-control"><span class="input-group-addon">%</span>
						</div>
					</div>
				</div>
				<div class="form-group item <?php  if(in_array($setting['level'],array('1','2'))) { ?>hide<?php  } ?>" id="level3">
					<label class="col-xs-12 col-sm-3 col-md-2 control-label">三级佣金比例</label>
					<div class="col-sm-4">
						<div class="input-group">
							<input type="text" name="commission3" value="<?php  echo $commission['commission3'];?>" class="form-control"><span class="input-group-addon">%</span>
						</div>
					</div>
				</div>
				<div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">升级条件</label>
                    <div class="col-sm-4 col-xs-12">
                        <div class="input-group">
							<span class="input-group-addon">分销佣金累计满</span>
							<input type="text" name="updatemoney" class="form-control" value="<?php  echo $commission['updatemoney'];?>">
							<span class="input-group-addon">元</span>
                        </div>
                        <span class="help-block">分销商升级条件，不填写默认为不自动升级</span>
                    </div>
                </div>
				<div class="form-group">
					<label class="col-xs-12 col-sm-3 col-md-2 control-label">直接推荐下级奖励</label>
					<div class="col-sm-4 col-xs-12">
                        <div class="input-group">
							<input type="text" name="rec_income" class="form-control" value="<?php  echo $setting['rec_income'];?>">
							<span class="input-group-addon">元</span>
                        </div>
                        <span class="help-block">0为关闭：每直接推荐一个下级成员，给予奖励的金额</span>
                    </div>
				</div>

				<div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">推广链接标题</label>
                    <div class="col-sm-9">
						<input type="text" name="sharelinktitle" value="<?php  echo $sharelink['title'];?>" class="form-control">
						<span>该分享用于前台“个人中心—>分销中心—>二维码推广”下面的链接分享</span>
                    </div>
                </div>
				<div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">推广链接描述</label>
                    <div class="col-sm-9">
                        <textarea style="height:70px;" class="form-control" name="sharelinkdesc"><?php  echo $sharelink['desc'];?></textarea>
                    </div>
                </div>
				<div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">推广链接图片</label>
                    <div class="col-sm-9">
                        <?php  echo tpl_form_field_image("sharelinkimg", $sharelink['images']);?>
                    </div>
                </div>

				<div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">分享课程描述</label>
                    <div class="col-sm-9">
                        <textarea style="height:70px;" class="form-control" name="sharelessontitle"><?php  echo $sharelesson['title'];?></textarea>
						<span>变量：【课程名称】</span>
                    </div>
                </div>
				<div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">分享课程图片</label>
                    <div class="col-sm-9">
                        <?php  echo tpl_form_field_image("sharelessonimg", $sharelesson['images']);?>
						<span>留空将使用课程封面图</span>
                    </div>
                </div>

				<div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">分享讲师描述</label>
                    <div class="col-sm-9">
                        <textarea style="height:70px;" class="form-control" name="shareteachertitle"><?php  echo $shareteacher['title'];?></textarea>
						<span>变量：【讲师名称】</span>
                    </div>
                </div>
				<div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">分享讲师图片</label>
                    <div class="col-sm-9">
                        <?php  echo tpl_form_field_image("shareteacherimg", $shareteacher['images']);?>
						<span>留空将使用讲师相片</span>
                    </div>
                </div>
				<div class="form-group item">
					<label class="col-xs-12 col-sm-3 col-md-2 control-label">会员推广海报</label>
					<div class="col-sm-4">
						<select name="clearposter" class="form-control">
							<option value="0">不进行任何操作</option>
							<option value="1">清空会员海报缓存</option>
						</select>
					</div>
				</div>
			</div>
        </div>
		<div class="panel panel-default">
            <div class="panel-heading">证书设置(佣金提现使用)</div>
			<div class="panel-body">
				<div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">身份标识(appId)</label>
                    <div class="col-sm-9">
                        <input type="text" value="<?php  echo $_W['account']['key'];?>" class="form-control" readonly/>
                    </div>
                </div>
				<div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">身份密钥(appSecret)</label>
                    <div class="col-sm-9">
                        <input type="text"value="<?php  echo $_W['account']['secret'];?>" class="form-control"  readonly/>
                    </div>
                </div>
				<div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">微信支付商户号(MchId)</label>
                    <div class="col-sm-9">
                        <input type="text" name="mchid" value="<?php  echo $setting['mchid'];?>" class="form-control"/>
						<span>公众号支付请求中用于加密的密钥Key</span>
                    </div>
                </div>
				<div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">商户支付密钥(API密钥)</label>
                    <div class="col-sm-9">
                        <input type="text" name="mchkey" value="<?php  echo $setting['mchkey'];?>" class="form-control"/>
						<span>此值需要手动在腾讯商户后台API密钥保持一致，<a href="http://bbs.we7.cc/thread-5788-1-1.html" target="_blank">查看设置教程</a></span>
                    </div>
                </div>
				<div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">服务器IP</label>
                    <div class="col-sm-9">
                        <input type="text" name="serverIp" value="<?php  echo $setting['serverIp'];?>" class="form-control"/>
						<span>企业付款正常时可忽略此项；当提示“client_ip非法未填写时”可手动配置IP地址</span>
                    </div>
                </div>
				<div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">CERT证书文件</label>
                    <div class="col-sm-4 col-xs-12">
                        <input type="file" name="apiclient_cert" class="form-control" />
						<span class="help-block">
							<?php  if($cert) { ?>
							<span class='label label-success'>已上传</span>
							<?php  } else { ?>
							<span class='label label-danger'>未上传</span>
							<?php  } ?>
							下载证书 cert.zip 中的 apiclient_cert.pem 文件
						</span>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">KEY密钥文件</label>
                    <div class="col-sm-4 col-xs-12">
                        <input type="file" name="apiclient_key" class="form-control" />
						<span class="help-block">
							<?php  if($key) { ?>
							<span class='label label-success'>已上传</span>
							<?php  } else { ?>
							<span class='label label-danger'>未上传</span>
							<?php  } ?>
							下载证书 cert.zip 中的 apiclient_key.pem 文件
						</span>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">ROOT文件</label>
                    <div class="col-sm-4 col-xs-12">
                        <input type="file" name="rootca" class="form-control" />
						<span class="help-block">
							<?php  if($rootca) { ?>
							<span class='label label-success'>已上传</span>
							<?php  } else { ?>
							<span class='label label-danger'>未上传</span>
							<?php  } ?>
							下载证书 cert.zip 中的 rootca.pem 文件
						</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="form-group col-sm-12">
            <input type="hidden" name="id" value="<?php  echo $setting['id'];?>" />
            <input type="submit" name="submit" value="保存设置" class="btn btn-primary col-lg-1" />
            <input type="hidden" name="token" value="<?php  echo $_W['token'];?>" />
        </div>
	</form>
</div>
<script type="text/javascript">
function checklevel(obj){
	if(obj==1){
		$("#level2").addClass("hide");
		$("#level3").addClass("hide");
	}else if(obj==2){
		$("#level2").removeClass("hide");
		$("#level3").addClass("hide");
	}else if(obj==3){
		$("#level2").removeClass("hide");
		$("#level3").removeClass("hide");
	}
}
function changeAgentStatus(status){
	if(status==0){
		$("#agent_condition").removeClass("hide");
	}else{
		$("#agent_condition").addClass("hide");
	}
}
</script>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/footer', TEMPLATE_INCLUDEPATH)) : (include template('common/footer', TEMPLATE_INCLUDEPATH));?>