<?php defined('IN_IA') or exit('Access Denied');?><!--
 * 讲师管理
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
    <li <?php  if($op=='display') { ?>class="active"<?php  } ?>><a href="<?php  echo $this->createWebUrl('teacher');?>">讲师列表</a></li>
    <li <?php  if($op=='post') { ?>class="active"<?php  } ?>><a href="<?php  echo $this->createWebUrl('teacher', array('op'=>'post', 'id'=>$_GPC['id']));?>"><?php  if($_GPC['id']>0) { ?>编辑<?php  } else { ?>添加<?php  } ?>讲师</a></li>
	<li <?php  if($op=='income') { ?>class="active"<?php  } ?>><a href="<?php  echo $this->createWebUrl('teacher', array('op'=>'income'));?>">讲师收入明细</a></li>
</ul>
<?php  if($operation == 'display') { ?>
<style type="text/css">
.form-controls{display: inline-block; width:70px;}
.cblock{display:block !important;}
.cnone{display:none !important;}
</style>
<div class="main">
	<div class="panel panel-info">
        <div class="panel-heading">筛选</div>
        <div class="panel-body">
            <form action="./index.php" method="get" class="form-horizontal" role="form">
                <input type="hidden" name="c" value="site">
                <input type="hidden" name="a" value="entry">
                <input type="hidden" name="m" value="fy_lessonv2">
                <input type="hidden" name="do" value="teacher">
                <input type="hidden" name="op" value="display">
                <div class="form-group">
				    <label class="col-xs-12 col-sm-2 col-md-2 col-lg-1 control-label" style="width:100px;">讲师名称</label>
                    <div class="col-sm-2 col-lg-3">
                        <input class="form-control" name="teacher" value="<?php  echo $_GPC['teacher'];?>">
                    </div>
					<label class="col-xs-12 col-sm-2 col-md-2 col-lg-1 control-label" style="width: 100px;">首拼音字母</label>
					<div class="col-sm-2 col-lg-3">
                        <input class="form-control" name="letter" value="<?php  echo $_GPC['letter'];?>">
                    </div>
                </div>
				<div class="form-group">
				    <label class="col-xs-12 col-sm-2 col-md-2 col-lg-1 control-label" style="width:100px;">讲师状态</label>
                    <div class="col-sm-2 col-lg-3">
                        <select name="status" class="form-control">
                            <option value="">不限</option>
							<option value="1" <?php  if($_GPC['status']==1) { ?>selected<?php  } ?>>审核通过</option>
                            <option value="2" <?php  if($_GPC['status']==2) { ?>selected<?php  } ?>>待审核</option>
							<option value="-1" <?php  if($_GPC['status']==-1) { ?>selected<?php  } ?>>未通过</option>
                        </select>
                    </div>
					<label class="col-xs-12 col-sm-2 col-md-2 col-lg-1 control-label" style="width:100px;">讲师类型</label>
                    <div class="col-sm-2 col-lg-3">
                        <select name="teachertype" class="form-control">
                            <option value="">不限</option>
							<option value="1" <?php  if($_GPC['teachertype']==1) { ?>selected<?php  } ?>>后台添加</option>
                            <option value="2" <?php  if($_GPC['teachertype']==2) { ?>selected<?php  } ?>>自行申请</option>
                        </select>
                    </div>
                    <button class="btn btn-default"><i class="fa fa-search"></i> 搜索</button>
                </div>
            </form>
        </div>
    </div>
	<div class="panel panel-default">
        <div class="table-responsive panel-body">
            <table class="table table-hover">
                <thead class="navbar-inner">
                <tr>
                    <th style="width:8%;">讲师编号</th>
                    <th style="width:10%;">讲师名称</th>
					<th style="width:9%;">待提现佣金</th>
					<th style="width:10%;">讲师QQ</th>
					<th style="width:10%;">讲师微信</th>
					<th style="width:10%;">讲师类型</th>
                    <th style="width:8%;">讲师相片</th>
					<th style="width:8%;">状态</th>
                    <th style="width:13%;">添加时间</th>
                    <th style="width:8%; text-align:right;">查看/删除</th>
                </tr>
                </thead>
                <tbody>
					<?php  if(is_array($list)) { foreach($list as $teacher) { ?>
                    <tr>
						<td><?php  echo $teacher['id'];?></td>
						<td><?php  echo $teacher['teacher'];?></td>
						<td><?php echo $teacher['member']['nopay_lesson']?$teacher['member']['nopay_lesson']:0;?>元</td>
						<td><?php  echo $teacher['qq'];?></td>
						<td>
							<?php  if(!empty($teacher['weixin_qrcode'])) { ?>
							<img src="<?php  echo $_W['attachurl'];?><?php  echo $teacher['weixin_qrcode'];?>" height="40">
							<?php  } else { ?>
							未上传
							<?php  } ?>
						</td>
						<td>
							<?php  if(!empty($teacher['uid'])) { ?>
								<span class="label label-primary">自行申请</span>
							<?php  } else { ?>
								<span class="label label-default">后台添加</span>
							<?php  } ?>
						</td>
						<td><img src="<?php  echo $_W['attachurl'];?><?php  echo $teacher['teacherphoto'];?>" height="40"></td>
						<td>
							<?php  if($teacher['status']==-1) { ?>
								<span class="label label-default">未通过</span>
							<?php  } else if($teacher['status']==1) { ?>
								<span class="label label-success">审核通过</span>
							<?php  } else if($teacher['status']==2) { ?>
								<span class="label label-danger">待审核</span>
							<?php  } ?>
						</td>
						<td><?php  echo date('Y-m-d H:i',$teacher['addtime']);?></td>
						<td style="text-align:right;">
							<a class="btn btn-default btn-sm" href="<?php  echo $this->createWebUrl('teacher', array('op'=>'post', 'id'=>$teacher['id']));?>" title="修改"><i class="fa fa-pencil"></i></a>
							<a class="btn btn-default btn-sm" href="<?php  echo $this->createWebUrl('teacher', array('op'=>'delete', 'id'=>$teacher['id']));?>" title="删除" onclick="return confirm('此操作不可恢复，确认删除？');return false;"><i class="fa fa-times"></i></a>
						</td>
					</tr>
					<?php  } } ?>
				</tbody>
            </table>
			<?php  echo $pager;?>
		</div>
	</div>
</div>

<?php  } else if($operation == 'post') { ?>
<div class="main">
	<form action="" method="post" class="form-horizontal form" enctype="multipart/form-data">
        <div class="panel panel-default">
            <div class="panel-heading">讲师信息</div>
            <div class="panel-body">
				<div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">讲师名称</label>
                    <div class="col-sm-9">
                        <input type="text" name="teacher" class="form-control" value="<?php  echo $teacher['teacher'];?>" />
                    </div>
                </div>
				<div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">首拼音字母</label>
                    <div class="col-xs-12 col-sm-2">
					   <select class="form-control" name="first_letter">
					     <option value="">请选择...</option>
						 <?php  if(is_array($letter)) { foreach($letter as $let) { ?>
						  <option value="<?php  echo $let;?>" <?php  if($teacher['first_letter']==$let) { ?>selected<?php  } ?>><?php  echo $let;?></option>
						 <?php  } } ?>
					   </select>
                   </div>
                </div>
				<div class="form-group">
					<label class="col-xs-12 col-sm-3 col-md-2 control-label"></label>
					<div class="col-xs-12 col-sm-9">
					   <span>讲师名称首拼音字母，例如：李明，请选择L</span>
				   </div>
				</div>
				<div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">讲师QQ</label>
                    <div class="col-sm-9">
                        <input type="text" name="qq" class="form-control" value="<?php  echo $teacher['qq'];?>" />
						<span class="help-block">留空将不显示在前台</span>
                    </div>
                </div>
				<div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">讲师QQ群</label>
                    <div class="col-sm-9">
                        <input type="text" name="qqgroup" class="form-control" value="<?php  echo $teacher['qqgroup'];?>" />
						<span class="help-block">留空将不显示在前台</span>
                    </div>
                </div>
				<div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">加QQ群链接</label>
                    <div class="col-sm-9">
                        <input type="text" name="qqgroupLink" class="form-control" value="<?php  echo $teacher['qqgroupLink'];?>" />
						<span class="help-block">添加QQ群加群连接后，前台点击“咨询—QQ群”后将自动添加群。<a href="http://www.haoshu888.com/zonghe/1134.html" target="_blank">如何获取QQ群加群链接?</a></span>
                    </div>
                </div>
				<div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">微信二维码</label>
                    <div class="col-sm-9">
                        <?php  echo tpl_form_field_image('weixin_qrcode', $teacher['weixin_qrcode']);?>
                    </div>
                </div>
				<div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">讲师状态</label>
                    <div class="col-sm-9">
						<p class="form-control-static">
							<input type="radio" name="status" value="1" <?php  if($teacher['status']==1) { ?>checked<?php  } ?>>
							<span class="label label-success" style="vertical-align:text-top;">审核通过</span>
							&nbsp;&nbsp;
							<input type="radio" name="status" value="2" <?php  if($teacher['status']==2) { ?>checked<?php  } ?>>
							<span class="label label-danger" style="vertical-align:text-top;">待审核</span>
							&nbsp;&nbsp;
							<input type="radio" name="status" value="-1" <?php  if($teacher['status']==-1) { ?>checked<?php  } ?>>
							<span class="label label-default" style="vertical-align:text-top;">审核未通过</span>
						</p>
					</div>
                </div>
				<div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">上传课程权限</label>
                    <div class="col-sm-9">
						<p class="form-control-static">
							<input type="radio" name="upload" value="1" <?php  if($teacher['upload']==1) { ?>checked<?php  } ?>>
							<span class="label label-success" style="vertical-align:text-top;">允许上传</span>
							&nbsp;&nbsp;
							<input type="radio" name="upload" value="0" <?php  if($teacher['upload']==0) { ?>checked<?php  } ?>>
							<span class="label label-danger" style="vertical-align:text-top;">禁止上传</span>
							<span class="help-block">禁止上传状态下的讲师将无法在讲师平台上传课程</span>
						</p>
					</div>
                </div>
                <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">讲师介绍</label>
                    <div class="col-sm-9">
						<?php  echo tpl_ueditor('teacherdes', $teacher['teacherdes']);?>
                    </div>
                </div>
				<div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">讲师相片</label>
                    <div class="col-sm-9">
                        <?php  echo tpl_form_field_image('teacherphoto', $teacher['teacherphoto']);?>
                    </div>
                </div>
            </div>
        </div>
        <div class="form-group col-sm-12">
            <input type="submit" name="submit" value="保存" class="btn btn-primary col-lg-1" />
            <input type="hidden" name="token" value="<?php  echo $_W['token'];?>" />
			<input type="hidden" name="id" value="<?php  echo $id;?>" />
        </div>
	</form>
</div>
<?php  } else if($operation == 'income') { ?>
<style type="text/css">
.form-controls{display: inline-block; width:70px;}
.cblock{display:block !important;}
.cnone{display:none !important;}
</style>
<div class="main">
	<div class="panel panel-info">
        <div class="panel-heading">筛选</div>
        <div class="panel-body">
            <form action="./index.php" method="get" class="form-horizontal" role="form">
                <input type="hidden" name="c" value="site">
                <input type="hidden" name="a" value="entry">
                <input type="hidden" name="m" value="fy_lessonv2">
                <input type="hidden" name="do" value="teacher">
                <input type="hidden" name="op" value="income">
                <div class="form-group">
				    <label class="col-xs-12 col-sm-2 col-md-2 col-lg-1 control-label" style="width:100px;">讲师名称</label>
                    <div class="col-sm-2 col-lg-3">
                        <input class="form-control" name="teacher" value="<?php  echo $_GPC['teacher'];?>">
                    </div>
					<label class="col-xs-12 col-sm-2 col-md-2 col-lg-1 control-label" style="width: 100px;">课程名称</label>
					<div class="col-sm-2 col-lg-3">
                        <input class="form-control" name="lesson" value="<?php  echo $_GPC['lesson'];?>">
                    </div>
                </div>
				<div class="form-group">
					<label class="col-xs-12 col-sm-2 col-md-2 col-lg-1 control-label" style="width: 100px;">下单时间</label>
                    <div class="col-sm-8 col-lg-3 col-xs-12">
                        <?php  echo tpl_form_field_daterange('time', array('starttime'=>date('Y-m-d', $starttime),'endtime'=>date('Y-m-d', $endtime)));?>
                    </div>
				    <label class="col-xs-12 col-sm-2 col-md-2 col-lg-1 control-label" style="width: 100px;">订单编号</label>
					<div class="col-sm-2 col-lg-3">
                        <input class="form-control" name="ordersn" value="<?php  echo $_GPC['ordersn'];?>">
                    </div>
                    <button class="btn btn-default"><i class="fa fa-search"></i> 搜索</button>
					<button type="submit" name="export" value="1" class="btn btn-success">导出 Excel</button>
                </div>
            </form>
        </div>
    </div>
	<div class="panel panel-default">
        <div class="table-responsive panel-body">
            <table class="table table-hover">
                <thead class="navbar-inner">
                <tr>
                    <th style="width:8%;">ID</th>
                    <th style="width:10%;">讲师名称</th>
					<th style="width:14%;">订单编号</th>
                    <th style="width:22%;">课程名称</th>
					<th style="width:10%;">课程售价</th>
                    <th style="width:10%;">讲师分成</th>
					<th style="width:10%;">讲师收入</th>
					<th style="width:13%;">添加时间</th>
                </tr>
                </thead>
                <tbody>
					<?php  if(is_array($list)) { foreach($list as $item) { ?>
                    <tr>
						<td><?php  echo $item['id'];?></td>
						<td><?php  echo $item['teacher'];?></td>
						<td><?php  echo $item['ordersn'];?></td>
						<td>《<?php  echo $item['bookname'];?>》</td>
						<td><?php  echo $item['orderprice'];?> 元</td>
						<td><?php  echo $item['teacher_income'];?>%</td>
						<td><?php  echo $item['income_amount'];?> 元</td>
						<td><?php  echo date('Y-m-d H:i',$item['addtime']);?></td>
					</tr>
					<?php  } } ?>
				</tbody>
            </table>
		</div>
	</div>
	<?php  echo $pager;?>
</div>

<?php  } ?>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/footer', TEMPLATE_INCLUDEPATH)) : (include template('common/footer', TEMPLATE_INCLUDEPATH));?>