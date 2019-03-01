<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/header', TEMPLATE_INCLUDEPATH)) : (include template('common/header', TEMPLATE_INCLUDEPATH));?>

<div class="main">
    <ul class="nav nav-tabs">
        <li ><a href="<?php  echo $this->createWebUrl('xkkjManage');?>">活动管理</a></li>
        <li class="active" > <a href="<?php  echo $this->createWebUrl('registers');?>">注册用户</a></li>
    </ul>

    <style>


        .ibox-title .label {
            float: left;
            margin-left: 4px;
        }



        .ibox {
            clear: both;
            margin-bottom: 25px;
            margin-top: 0;
            padding: 0;
            border: 1px solid #bce8f1;
        }

        .ibox-title {
            -moz-border-bottom-colors: none;
            -moz-border-left-colors: none;
            -moz-border-right-colors: none;
            -moz-border-top-colors: none;
            background-color: #ffffff;
            border-color: #e7eaec;
            -webkit-border-image: none;
            -o-border-image: none;
            border-image: none;
            border-style: solid solid none;
            border-width: 4px 0px 0;
            color: inherit;
            margin-bottom: 0;
            padding: 14px 15px 7px;
            min-height: 48px;
        }

        .ibox-content {
            clear: both;
        }

        .ibox-content {
            background-color: #ffffff;
            color: inherit;
            padding: 15px 20px 20px 20px;
            border-color: #e7eaec;
            -webkit-border-image: none;
            -o-border-image: none;
            border-image: none;
            border-style: solid solid none;
            border-width: 1px 0px;
        }

    </style>


    <div class="row">

        <div class="col-md-3" >
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <span class="label label-success pull-right">活动期间</span>
                    <h5>注册人数</h5>

                </div>
                <div class="ibox-content">
                    <h1 class="no-margins"><?php  echo $ttotal;?>人</h1>

                    <small></small>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <span class="label label-info pull-right">今日</span>
                    <h5>注册人数</h5>

                </div>
                <div class="ibox-content">
                    <h1 class="no-margins"><?php  echo $today;?>人</h1>

                    <small></small>
                </div>
            </div>
        </div>


        <div class="col-md-3">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <span class="label label-info pull-right">昨日</span>
                    <h5>注册人数</h5>

                </div>
                <div class="ibox-content">
                    <h1 class="no-margins"><?php  echo $yesterday;?>人</h1>

                    <small></small>
                </div>
            </div>
        </div>


        <div class="col-md-3">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <span class="label label-info pull-right">上周</span>
                    <h5>注册人数</h5>

                </div>
                <div class="ibox-content">
                    <h1 class="no-margins"><?php  echo $lastweek;?>人</h1>

                    <small></small>
                </div>
            </div>
        </div>




    </div>


    <div class="panel panel-info">
        <div class="panel-heading">注册用户</div>
        <div class="panel-body">
            <form action="./index.php" method="get" class="form-horizontal" role="form">

                <input type="hidden" name="a" value="entry" />
                <input type="hidden" name="c" value="site" />
                <input type="hidden" name="m" value="<?php echo MON_XKWKJ;?>" />
                <input type="hidden" name="do" value="registers" />

                <div class="form-group">
                    <label class="col-xs-12 col-sm-2 col-md-2 col-lg-1 control-label">昵称</label>
                    <div class="col-sm-8 col-lg-9">
                        <input class="form-control" name="keyword" id="" type="text"
                               value="<?php  echo $_GPC['keyword'];?>" placeholder="请输入昵称搜索">
                    </div>
                    <div class=" col-xs-12 col-sm-2 col-lg-2">
                        <button class="btn btn-primary pull-left span2"
                                style='margin-left: 95px;'>
                            <i class="icon-search icon-large"></i> 搜索
                        </button>
                    </div>
                </div>

            </form>
        </div>




    </div>

    <a class="btn btn-default" href="<?php  echo $this->createWebUrl('downloadRegisters')?>"><i class="fa fa-arrow-down"></i>导出注册用户</a>

    <p/>

    <div class="panel panel-default">
        <div class="table-responsive panel-body">
            <table class="table table-hover">
                <thead>
                <tr>
                    <th style="width:100px;">昵称(点击昵称查看详细)</th>
                    <th style="width:30px;">头像</th>
                    <th style="width:30px;">注册姓名</th>
                    <th style="width:30px;">注册手机</th>
                    <th style="width:100px;">注册时间</th>
                    <th style="width:150px;">操作</th>
                </tr>
                </thead>
                <tbody>


                <?php  if(is_array($list)) { foreach($list as $row) { ?>
                <tr>

                    <td><a href="<?php  echo $this->createWebUrl('userDetail',array('openid'=>$row['openid']));?>" target="_blank" class="nick-name" ><?php  echo $row['nickname'];?></a></td>
                    <td><img src="<?php  echo $row['headimgurl'];?>" height="30px" width="30px"></td>
                    <td><?php  echo $row['uname'];?></td>
                    <td><?php  echo $row['tel'];?></td>
                    <td><?php  echo date("Y-m-d H:i:s",$row['createtime'])?></td>

                    <td style="overflow: inherit;">

                        <a  href="<?php  echo $this->createWebUrl('userwkj',array('openid'=>$row['openid']));?>" title="参与的活动"  role="button">
                            <i class="fa fa-th-list"></i>参与的活动</a>


                        <a  target="_blank" rel="tooltip" href="<?php  echo $this->createWebUrl('userDetail',array('openid'=>$row['openid']));?>" title="用户信息">
                            <i class="fa fa fa-user"></i>用户信息</a>

                        <a href="<?php  echo $this->createWebUrl('registers', array( 'openid' => $row['openid'], 'op' => 'delete'))?>"
                           onclick="return confirm('此操作不可恢复，确认删除？');return false;" title="删除"
                           class="btn btn-danger"><i class="fa fa-remove"></i>删除</a>
                    </td>

                </tr>
                <?php  } } ?>

                </tbody>

            </table>
            <?php  echo $pager;?>
        </div>
    </div>










</div>

<script>
    $(function(){
    });

</script>
<script>
    function drop_confirm(msg, url){
        if (confirm(msg)){
            window.location = url;
        }
    }
</script>



<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/footer', TEMPLATE_INCLUDEPATH)) : (include template('common/footer', TEMPLATE_INCLUDEPATH));?>