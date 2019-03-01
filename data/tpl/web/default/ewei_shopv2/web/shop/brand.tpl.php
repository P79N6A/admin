<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('_header', TEMPLATE_INCLUDEPATH)) : (include template('_header', TEMPLATE_INCLUDEPATH));?>
<div class="page-heading"> 
    <span class='pull-right'>
        <a class='btn btn-primary btn-sm' href="<?php  echo webUrl('shop/brand/post')?>" data-toggle='ajaxModal'><i class='fa fa-plus'></i> 添加品牌</a>
    </span>
    <h2>品牌管理</h2> 
</div>
<form action="./index.php" method="get" class="form-horizontal form-search" role="form">
    <input type="hidden" name="c" value="site" />
    <input type="hidden" name="a" value="entry" />
    <input type="hidden" name="m" value="ewei_shopv2" />
    <input type="hidden" name="do" value="web" />
    <input type="hidden" name="r"  value="shop.brand" />
    <div class="page-toolbar row m-b-sm m-t-sm">
        <div class="col-sm-4">
            <div class="input-group">				 
                <input type="text" class="input-sm form-control" name='keyword' value="<?php  echo $_GPC['keyword'];?>" placeholder="首字母/品牌名称"> <span class="input-group-btn">	
                <button class="btn btn-sm btn-primary" type="submit"> 搜索</button> </span>
            </div> 
        </div>	
    </div>
</form>
<table class="table table-hover table-responsive">
	<tr>
        <th>首字母</th>
        <th>品牌名称</th>
        <th style="">操作</th>
    </tr>
    <?php  if(is_array($list)) { foreach($list as $item) { ?>
    <tr>
    	<td><?php  echo $item['first_one'];?></td>
    	<td><?php  echo $item['brand'];?></td>
    	<td>
            <a  class='btn btn-default btn-sm' href="<?php  echo webUrl('shop/brand/car', array('id' => $item['id']))?>" title="车型" data-toggle='ajaxModal'><i class='fa fa-list'></i> </a>
    		<a  class='btn btn-default btn-sm' href="<?php  echo webUrl('shop/brand/post', array('id' => $item['id']))?>" title="编辑" data-toggle='ajaxModal'><i class='fa fa-edit'></i> </a>
    		<a  class='btn btn-default btn-sm' data-toggle='ajaxRemove' href="<?php  echo webUrl('shop/brand/delete', array('id' => $item['id']))?>" data-confirm='确认要删除该品牌吗?？'><i class='fa fa-remove'></i> </a>
    	</td>
    </tr>
    <?php  } } ?>
</table>
<?php  echo $pager;?>              
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('_footer', TEMPLATE_INCLUDEPATH)) : (include template('_footer', TEMPLATE_INCLUDEPATH));?>