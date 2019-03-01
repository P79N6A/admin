<?php defined('IN_IA') or exit('Access Denied');?><!-- 
 * 日志管理
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
	<li <?php  if($op=='display') { ?>class="active"<?php  } ?>><a href="<?php  echo $this->createWebUrl('syslog');?>">日志列表</a></li>
</ul>
<?php  if($op=='display') { ?>
<style type="text/css">
.descript{
    white-space:normal !important;
    overflow:auto !important;
	text-overflow: inherit !important;
}
</style>
<div class="main">
	<div class="panel panel-info">
        <div class="panel-heading">筛选</div>
        <div class="panel-body">
            <form action="./index.php" method="get" class="form-horizontal" role="form">
                <input type="hidden" name="c" value="site" />
                <input type="hidden" name="a" value="entry" />
                <input type="hidden" name="m" value="fy_lessonv2" />
                <input type="hidden" name="do" value="syslog" />
                <input type="hidden" name="op" value="display" />
                <div class="form-group">
                    <label class="col-xs-12 col-sm-2 col-md-2 col-lg-1 control-label" style="width:100px;">模块操作</label>
                    <div class="col-sm-2 col-lg-3">
                        <input class="form-control" name="function" type="text" value="<?php  echo $_GPC['function'];?>">
                    </div>
					<label class="col-xs-12 col-sm-2 col-md-2 col-lg-1 control-label" style="width:100px;">操作类型</label>
                    <div class="col-sm-8 col-lg-3 col-xs-12">
                        <select name="log_type" class="form-control">
                            <option value="">全部类型</option>
							<option value="1" <?php  if($_GPC['log_type'] == 1) { ?> selected="selected" <?php  } ?>>新增</option>
							<option value="2" <?php  if($_GPC['log_type'] == 2) { ?> selected="selected" <?php  } ?>>删除</option>
							<option value="3" <?php  if($_GPC['log_type'] == 3) { ?> selected="selected" <?php  } ?>>更改</option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
					<?php  if($_W['user']['groupid']==0) { ?>
					<label class="col-xs-12 col-sm-2 col-md-2 col-lg-1 control-label" style="width:100px;">操作员</label>
                    <div class="col-sm-8 col-lg-3 col-xs-12">
                        <select name="admin_uid" class="form-control">
                            <option value="">全部操作员</option>
							<?php  if(is_array($admin_list)) { foreach($admin_list as $admin) { ?>
							<option value="<?php  echo $admin['uid'];?>" <?php  if($_GPC['admin_uid'] == $admin['uid']) { ?>selected="selected" <?php  } ?>><?php  echo $admin['username'];?></option>
							<?php  } } ?>
                        </select>
                    </div>
					<?php  } ?>
                    <label class="col-xs-12 col-sm-2 col-md-2 col-lg-1 control-label" style="width: 100px;">操作时间</label>
                    <div class="col-sm-8 col-lg-3 col-xs-12">
					<?php echo tpl_form_field_daterange('time', array('starttime'=>($starttime ? date('Y-m-d', $starttime) : false),'endtime'=> ($endtime ? date('Y-m-d', $endtime) : false)));?>
                    </div>
                    <div class="col-sm-3 col-lg-3" style="width: 18%;">
                        <button class="btn btn-default"><i class="fa fa-search"></i> 搜索</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="panel panel-default">
        <form action="<?php  echo $this->createWebUrl('syslog', array('op'=>'delAllLog'));?>" method="post" class="form-horizontal form">
        <div class="table-responsive panel-body">
            <table class="table table-hover">
                <thead class="navbar-inner">
                <tr>
                    <th style="width:8%;">操作员</th>
                    <th style="width:8%;">操作类型</th>
                    <th style="width:20%;">操作模块</th>
					<th style="width:30%;">操作描述</th>
					<th style="width:12%;">操作IP</th>
                    <th style="width:15%;">操作时间</th>
                </tr>
                </thead>
                <tbody>
                <?php  if(is_array($list)) { foreach($list as $item) { ?>
                <tr>
					<td><?php  echo $item['admin_username'];?></td>
                    <td>
						<?php  if($item['log_type']==1) { ?>
						<span class="label label-success">新增</span>
						<?php  } else if($item['log_type']==2) { ?>
						<span class="label label-danger">删除</span>
						<?php  } else if($item['log_type']==3) { ?>
						<span class="label label-warning">更改</span>
						<?php  } ?>
					</td>
                    <td><?php  echo $item['function'];?></td>
					<td class="descript"><?php  echo $item['content'];?></td>
					<td><?php  echo $item['ip'];?></td>
                    <td><?php  echo date('Y-m-d H:i:s',$item['addtime'])?></td>
                </tr>
                <?php  } } ?>
                </tbody>
            </table>
            <?php  echo $pager;?>
        </div>
    </div>
    </form>
</div>
<?php  } ?>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/footer', TEMPLATE_INCLUDEPATH)) : (include template('common/footer', TEMPLATE_INCLUDEPATH));?>