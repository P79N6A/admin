<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/header', TEMPLATE_INCLUDEPATH)) : (include template('common/header', TEMPLATE_INCLUDEPATH));?>

<div class="main">
    <ul class="nav nav-tabs">
        <li
        <?php  if($operation== 'display') { ?> class="active"<?php  } ?>><a
            href="<?php  echo $this->createWebUrl('xkkjManage');?>">砍价活动管理</a></li>
        <li
        <?php  if($operation == 'post') { ?> class="active"<?php  } ?>> <a
            href="<?php  echo $this->createWebUrl('xkkjEdit');?>">添加砍价活动</a></li>
    </ul>



    <div class="panel panel-default">
        <div class="panel-heading">
           炫酷微砍价
        </div>
        <div class="table-responsive panel-body">

            <div style="padding:15px;">
                <table class="table table-hover">
                    <thead class="navbar-inner">
                    <tr>
                        <th style="width: 20px">
                            <input type="checkbox" class="check_all" />
                        </th>
                        <th width="80px">排序</th>
                        <th width="150px">标题</th>
                        <th width="100px">访问/分享(次数)</th>
                        <th width="120px">原始价/最低价</th>

                        <th width="260px">活动时间</th>

                        <th width="120px">是否首页显示</th>

                        <th width="120px">海报管理</th>

                        <th width="80px">活动入口链接</th>
                        <th style="width:300px">操作</th>
                    </tr>
                    </thead>
                    <tbody>

                    <?php  if(is_array($list)) { foreach($list as $row) { ?>
                    <tr>
                        <td class="with-checkbox">
                            <input type="checkbox" name="check" value="<?php  echo $row['id'];?>">
                        </td>
                        <td><input type="text" value="<?php  echo $row['index_sort'];?>" name="input_sort" class="form-control" data="<?php  echo $row['id'];?>" ></td>


                        <td><?php  echo $row['title'];?> </td>
                        <td>  <a href="<?php  echo $this->createWebUrl('viewAnalysis', array( 'kid' => $row['id']))?>" role="button" target="_blank"><i class="fa fa-align-left"></i><?php  echo $row['vcount'];?>/<?php  echo $row['sharecount'];?></a>

                        </td>

                        <td><?php  echo $row['p_y_price'];?>/<?php  echo $row['p_low_price'];?> </td>
                        <td><?php  echo date("Y-m-d H:i",$row['starttime'])?>至<br/><?php  echo date("Y-m-d H:i",$row['endtime'])?></td>

                        <style>
                            .switch:before {
                                content: ' ';
                                position: absolute;
                                left: 1px;
                                top: 1px;
                                width: 0px;
                                height: 0px;
                                background: transparent;
                                z-index: 1;
                                border-radius: 0px;
                                -moz-border-radius: 0px;
                                -webkit-border-radius: 0px;
                            }

                            .switch:after {
                                content: ' ';
                                height: 0px;
                                width: 0px;
                                border-radius: 0px;
                                background: transparent;
                                position: absolute;
                                z-index: 2;
                                top: 0px;
                                left: 0px;
                                -webkit-transition-duration: 300ms;
                                transition-duration: 300ms;
                                -webkit-box-shadow: 0 0px 0px;
                                box-shadow: 0 0px 0px;
                            }
                         </style>
                        <td class="switch" style="background: transparent; border-radius: 0px; ">

                            <input type="checkbox" value="1" <?php  if($row['show_index_enable'] == 1) { ?> checked="checked" <?php  } ?> data="<?php  echo $row['id'];?>"/>

                        </td>



                        <td tyle="overflow: inherit;" >

                            <div class="btn-group">
                                <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    海报管理
                                    <span class="caret"></span>
                                </button>
                                <ul class="dropdown-menu">


                                    <li>
                                        <a href="<?php  echo $this->createWebUrl('designer_poster', array( 'kid' => $row['id']))?>"   role="button"  ><i class="fa fa-file"></i>设计海报</a>
                                    </li>

                                    <li>
                                        <a href="<?php  echo $this->createWebUrl('poster', array( 'kid' => $row['id']))?>" role="button"><i class="fa fa-file"></i>生成的海报(用户触发生成)</a>
                                    </li>

                                </ul>
                            </div>

                        </td>


                        <!--<td ><?php  if($row['show_index_enable'] == 1) { ?><span class="label label-info">显示</span><?php  } else { ?><span class="label label-danger">不显示</span><?php  } ?></td>-->


                        <td><input type="text" class="form-control" value="<?php  echo  MonUtil::str_murl($this->createMobileUrl('Auth', array('kid' => $row['id'], 'au'=>1)))?>"> </td>
                        <td style="overflow: inherit;">


                            <div class="btn-group">
                                <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                   更多操作
                                    <span class="caret"></span>
                                </button>
                                <ul class="dropdown-menu">

                                    <li>
                                        <a href="<?php  echo $this->createWebUrl('copykj', array( 'kid' => $row['id']))?>"   role="button"  onclick="return confirm('确定要复制新建活动吗？');return false;" ><i class="fa fa-file"></i>复制活动</a>
                                    </li>

                                    <li> <a href="<?php  echo $this->createWebUrl('joinUser', array( 'kid' => $row['id']))?>"  role="button"><i class="fa fa-user"></i>报名用户</a></li>



                                    <li>
                                        <a href="<?php  echo $this->createWebUrl('orderList', array( 'kid' => $row['id']))?>" role="button"><i class="fa fa-list-alt"></i>订单</a>
                                    </li>



                                    <li>
                                        <a href="<?php  echo $this->createWebUrl('viewAnalysis', array( 'kid' => $row['id']))?>" role="button"><i class="fa fa-align-left"></i>访问/分享统计</a>
                                    </li>


                                    <li>
                                        <a href="<?php  echo $this->createWebUrl('xkkjEdit', array('kid' => $row['id']))?>"  role="button"><i class="fa fa-edit"></i>编辑</a>
                                    </li>


                                </ul>
                            </div>

                            <a href="<?php  echo $this->createWebUrl('xkkjManage', array( 'kid' => $row['id'], 'op' => 'delete'))?>" class="btn btn-danger" role="button"  onclick="return confirm('此操作不可恢复，确认删除？');return false;"><i class="fa fa-remove"></i>删除</a>
                        </td>
                    </tr>

                    <?php  } } ?>
                    <tr>
                        <td colspan="10">

                            <input type="button" class="btn btn-primary" name="deleteall" value="删除选择的" />


                            <input type="button" class="btn btn-info" name="updateSort" id="updateSort" value="更新排序" />
                        </td>
                    </tr>
                    </tbody>
                </table>
                <?php  echo $pager;?>
            </div>

        </div>
    </div>




</div>

<script type="text/javascript">


    require(['bootstrap.switch', 'util', 'trade'], function($, u, trade){
               trade.init();
                $('.switch :checkbox').bootstrapSwitch();

                $('.switch :checkbox').on('switchChange.bootstrapSwitch', function(e, state){

                  $this = $(this);

                    var kid = $this.attr('data');

                    var show_index_enable = this.checked ? 1 : 0;

                    $.post("<?php  echo $this->createWebUrl('indexShowEnable')?>", {"kid":kid, "show_index_enable":show_index_enable}, function(resp){
                        if(resp.code != 200) {
                            util.message('操作失败, 请稍后重试.')
                        } else {
                           // location.reload();
                        }
                    }, "json");

            });

    });

</script>


<script>
    $(function(){

        $(".check_all").click(function(){

            var checked = $(this).get(0).checked;
            $("input[type=checkbox]").each(function(i){
                $(this).get(0).checked=checked;
            });

        });


        $("#updateSort").click(function() {
            var sortArray = new Array();
            $("input[name='input_sort']").each(function(i) {

                var kid = $(this).attr('data');

                sortArray[i] = kid + "|" + $(this).val();


            });

            $.post('<?php  echo $this->createWebUrl('updateSort')?>', {sortArray:sortArray}, function(data){
                if(data.code == 200) {
                    alert("更新成功");
                    location.reload();
                } else {
                    alert("更新失败，稍后再试!");
                }

            }, 'json');

        });

        $("input[name=deleteall]").click(function(){


            var check = $("input:checked");
            if (check.length < 1){
                alert('请选择要删除的记录!');
                return false;
            }
            if (confirm("确认要删除选择的记录?")){
                var id = new Array();
                check.each(function(i){
                    id[i] = $(this).val();
                });


                $.post('<?php  echo $this->createWebUrl('DeleteXkWkj')?>', {idArr:id}, function(data){

                    if(data.code==200) {
                        alert("删除成功");
                        location.reload();
                    } else {
                        alert("删除出错，稍后再试!");
                    }

                }, 'json');
            }

        });
    });</script>
<script>
    function drop_confirm(msg, url){
        if (confirm(msg)){
            window.location = url;
        }
    }
</script>


<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/footer', TEMPLATE_INCLUDEPATH)) : (include template('common/footer', TEMPLATE_INCLUDEPATH));?>