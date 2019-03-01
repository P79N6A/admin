<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/header', TEMPLATE_INCLUDEPATH)) : (include template('common/header', TEMPLATE_INCLUDEPATH));?>
<ul class="nav nav-tabs">
	<li <?php  if($op == 'post'|| $op == 'edit') { ?>class="active"<?php  } ?>><a href="<?php  echo $this->createWebUrl('store_manager', array('op' => 'post'));?>">添加商品库存</a></li>
	<li <?php  if($op == 'display') { ?>class="active"<?php  } ?>><a href="<?php  echo $this->createWebUrl('store_manager', array('op' => 'display'));?>">商品库存列表</a></li>
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
	<div style="padding:15px;background: white;">
		<table class="table table-hover" style="table-layout: initial;">
			<thead class="navbar-inner">
				<tr>
					<th>商品编号</th>
					<th>组合编号</th>
					<th>组合</th>
					<th>商品名称</th>
					<th>库存</th>
					<th>操作</th>
				</tr>
			</thead>
			<tbody>
				<?php  if(is_array($list)) { foreach($list as $item) { ?>
				<tr>
					<td><?php  echo $item['goods_id'];?></td>
					<td><?php  echo $item['value'];?></td>
					<td><?php  echo $item['value_name'];?></td>
					<td><?php  echo $item['name'];?></td>
					<td><?php  echo $item['goods_number'];?></td>
					<td>
						<a href="<?php  echo $this->createWebUrl('store_manager', array('op' => 'edit', 'id'=>$item['bussiness_id'], 'goods_id' => $item['id']))?>" title="编辑" class="btn btn-sm btn-default"><i class="fa fa-edit"></i></a>
						<a onclick="return confirm('此操作不可恢复，确认吗？'); return false;" href="<?php  echo $this->createWebUrl('store_manager', array('op' => 'del','id' => $item['id']))?>" title="删除" class="btn btn-sm btn-danger"><i class="fa fa-remove"></i></a>
					</td>
				</tr>
				<?php  } } ?>
			</tbody>
		</table>
		<?php  echo $pager;?>
	</div>
</div>
<?php  } else if($op == 'post' || $op == 'edit') { ?>
<div class="panel panel-info">
		<div class="panel-body">
			<form action="" method="post" class="form-horizontal" role="form">
			<input type="hidden" name="id" value="<?php  echo $item['id'];?>">
			<div class="form-group">
				<label class="col-xs-12 col-sm-2 col-md-2 col-lg-1 control-label"><span class='red'>*</span>商品名称</label>
				<div class="col-xs-12 col-sm-9 col-lg-9">
                    <select name="store_id" style="width: 20%; height:30px" onchange="send_goods(this.value)">					
                        <option value="0">请选择</option>
							<?php  if(is_array($item_store)) { foreach($item_store as $p) { ?>
								<option value="<?php  echo $p['goods_id'];?>"><?php  echo $p['goods_name'];?></option>
							<?php  } } ?>
					</select>
                </div>
			</div>
			<!-- <div class="form-group">
				<label class="col-xs-12 col-sm-2 col-md-2 col-lg-1 control-label"><span class='red'>*</span>长度规格</label>
				<div class="col-xs-12 col-sm-9 col-lg-9">
                    <select name="length_id" style="width: 15%; height:30px" id ="length_id">				
                        <option value="0">请选择</option>
							<?php  if(is_array($item_shape)) { foreach($item_shape as $p) { ?>
								<option value="<?php  echo $p['id'];?>"><?php  echo $p['title'];?></option>
							<?php  } } ?>
					</select>
                </div>
			</div> -->
			<div class="form-group">
				<label class="col-xs-12 col-sm-2 col-md-2 col-lg-1 control-label"><span class='red'>*</span>颜色规格</label>
				<div class="col-xs-12 col-sm-9 col-lg-9">
                     <select name="color_id" style="width: 20%; height:30px" id="color_id">					
                        <option value="0">请选择</option>
							<?php  if(is_array($item_color)) { foreach($item_color as $p) { ?>
								<option value="<?php  echo $p['id'];?>"><?php  echo $p['title'];?></option>
							<?php  } } ?>
					</select>
                </div>
			</div>
			<div class="form-group">
				<label class="col-xs-12 col-sm-2 col-md-2 col-lg-1 control-label"><span class='red'>*</span>库存</label>
				<div class="col-sm-3">
					<input class="form-control"  name="stock" id='stock' type="text" value="<?php  echo $item['goods_price'];?>">
				</div>
			</div>
			<div class="form-group">
				<label class="col-xs-12 col-sm-2 col-md-2 col-lg-1 control-label"><span class='red'>*</span>价格</label>
				<div class="col-sm-3">
					<input class="form-control"  name="price" id='price' type="text" value="<?php  echo $item['goods_price'];?>">
				</div>
			</div>
			<!-- <div class="form-group">
				<label class="col-xs-12 col-sm-2 col-md-2 col-lg-1 control-label"><span class='red'>*</span>第三种规格</label>
				<div class="col-xs-12 col-sm-9 col-lg-9">
                     <select name="store_name" style="width: 15%; height:30px">					
                        <option value="0">请选择</option>
							<?php  if(is_array($item_color)) { foreach($item_color as $p) { ?>
								<option value="<?php  echo $p['id'];?>"><?php  echo $p['title'];?></option>
							<?php  } } ?>
					</select>
                </div>
			</div> -->
			<div class="form-group">
				<label class="col-xs-12 col-sm-2 col-md-2 col-lg-1 control-label"><span class='red'>*</span>单位</label>
				<div class="col-sm-3">
					<input class="form-control" required="required" name="unit" id='unit' type="text" value="">
				</div>
			</div>
			<div class="form-group">
				<label class="col-xs-12 col-sm-2 col-md-2 col-lg-1 control-label">组合图标</label>
				<div class="col-sm-6">
					<?php  load()->func('tpl');echo tpl_form_field_image('thumb',$item['thumb']);?>
				</div>
			</div>
			<button type="submit" class="btn btn-primary" name="submit" id='summit_info' value="提交">保存</button>
			<input type="hidden" name="token" value="<?php  echo $_W['token'];?>" />
			</form>
	</div>
</div>

<script>
    function send_goods(goods_id){
	    $.post("<?php  echo $this->createWebUrl('store_manager',array('op'=>'getStaff'))?>",
			{goods_id:goods_id},
			function(response){
	        var list1 = response.list1;
	        var list2 = response.list2;
	        var html='<option value="0">请选择</option>';
	        for(var i=0;i<list1.length;i++){
	            html +='<option value="'+list1[i].id+'">'+list1[i].value+'</option>';
			}
			$('#color_id').html(html);
			html ='';

			for(var j=0;j<list2.length;j++){
	            html +='<option value="'+list2[j].id+'">'+list2[j].value+'</option>';
			}
			$('#length_id').html(html);
		},'json');
	}
</script>
<?php  } ?>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/footer', TEMPLATE_INCLUDEPATH)) : (include template('common/footer', TEMPLATE_INCLUDEPATH));?>
