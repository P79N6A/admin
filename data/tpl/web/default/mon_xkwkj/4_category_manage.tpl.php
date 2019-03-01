<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/header', TEMPLATE_INCLUDEPATH)) : (include template('common/header', TEMPLATE_INCLUDEPATH));?>

<div class="main">
    <ul class="nav nav-tabs">
        <li class="active" ><a
            href="<?php  echo $this->createWebUrl('categorySetting');?>">类别管理</a></li>
       <li><a href="<?php  echo $this->createWebUrl('categoryedit');?>">添加类别</a></li>
    </ul>



    <div class="panel panel-default">
        <div class="panel-heading">
           类别挂历
        </div>
        <div class="table-responsive panel-body">

            <div style="padding:15px;">
                <table class="table table-hover">
                    <thead class="navbar-inner">
                    <tr>

                        <th width="80px">排序</th>
                        <th width="150px">名称</th>
                        <th width="120px">图标</th>
                        <th style="width:200px">操作</th>
                    </tr>
                    </thead>
                    <tbody>

                    <?php  if(is_array($list)) { foreach($list as $row) { ?>
                    <tr>

                        <td>
                            <input type="text" value="<?php  echo $row['display_sort'];?>" name="input_sort" class="form-control" data="<?php  echo $row['id'];?>">
                        </td>

                        <td><?php  echo $row['typname'];?> </td>
                        <td>
                            <?php  if($row['icon_type'] == 1) { ?>
                               <img src="<?php  echo MonUtil::getpicurl($row['typeicon'])?>" width="50px" height="50px">
                            <?php  } else { ?>
                                <img src="<?php  echo $row['systypeicon'];?>" width="50px" height="50px">
                            <?php  } ?>
                        </td>

                        <td >
                            <a href="<?php  echo $this->createWebUrl('categoryedit', array( 'cid' => $row['id']))?>"  role="button" class="btn btn-default" ><i class="fa fa-edit"></i>编辑</a>
                            <a href="<?php  echo $this->createWebUrl('categorySetting', array( 'cid' => $row['id'], 'op' => 'delete'))?>" class="btn btn-danger" role="button"  onclick="return confirm('此操作不可恢复，确认删除？');return false;"><i class="fa fa-remove"></i>删除</a>
                        </td>
                    </tr>
                    <?php  } } ?>
                    <tr>
                        <td colspan="8">
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



<script>
    $(function() {


        $("#updateSort").click(function () {
            var sortArray = new Array();
            $("input[name='input_sort']").each(function (i) {

                var kid = $(this).attr('data');

                sortArray[i] = kid + "|" + $(this).val();


            });

            $.post('<?php  echo $this->createWebUrl('updateCatetorySort')?>', {sortArray: sortArray}, function (data) {
                if (data.code == 200) {
                    alert("更新成功");
                    location.reload();
                } else {
                    alert("更新失败，稍后再试!");
                }

            }, 'json'
            )
            ;

        });


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