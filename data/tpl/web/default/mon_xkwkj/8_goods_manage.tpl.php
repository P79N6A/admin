<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/header', TEMPLATE_INCLUDEPATH)) : (include template('common/header', TEMPLATE_INCLUDEPATH));?>

<div class="main">
    <ul class="nav nav-tabs">
        <li
        <?php  if($operation== 'display') { ?> class="active"<?php  } ?>><a
            href="<?php  echo $this->createWebUrl('goodsManage');?>">商品管理</a></li>
        <li> <a href="<?php  echo $this->createWebUrl('goodsEdit');?>">添加商品</a></li>
    </ul>


    <div class="panel panel-default">
        <div class="panel-heading">
          商品管理
        </div>
        <div class="table-responsive panel-body">

            <div style="padding:15px;">
                <table class="table table-hover">
                    <thead class="navbar-inner">
                    <tr>
                        <th width="150px">商品名称</th>
                        <th width="120px">商品预览图</th>
                        <th width="260px">商品大图</th>
                        <th width="120px">添加时间</th>
                        <th style="width:400px">操作</th>
                    </tr>
                    </thead>
                    <tbody>

                    <?php  if(is_array($list)) { foreach($list as $row) { ?>
                    <tr>
                        <td><?php  echo $row['p_name'];?> </td>
                        <td><img src="<?php  echo MonUtil::getpicurl($row['p_preview_pic'])?>" height="50px" width="50px"></td>
                        <td><img src="<?php  echo MonUtil::getpicurl($row['p_pic'])?>" height="50px" width="50px" ></td>


                        <td><?php  echo date("Y-m-d H:i",$row['createtime'])?></td>

                        <td>
                            <a href="<?php  echo $this->createWebUrl('xkkjEdit', array('gid' => $row['id']))?>"  role="button" class="btn btn-default"><i class="fa fa-plus"></i>发布砍价活动</a>

                            <a href="<?php  echo $this->createWebUrl('goodsEdit', array('gid' => $row['id']))?>"  role="button" class="btn btn-default" ><i class="fa fa-edit"></i>编辑</a>
                            <a href="<?php  echo $this->createWebUrl('goodsManage', array( 'gid' => $row['id'], 'op' => 'delete'))?>" class="btn btn-danger" role="button"  onclick="return confirm('此操作不可恢复，确认删除？');return false;"><i class="fa fa-remove"></i>删除</a>
                        </td>
                    </tr>
                    <?php  } } ?>

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