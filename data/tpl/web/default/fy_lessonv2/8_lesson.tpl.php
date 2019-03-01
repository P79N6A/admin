<?php defined('IN_IA') or exit('Access Denied');?><!--
 * 课程管理
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
    <li <?php  if($op=='display') { ?>class="active"<?php  } ?>><a href="<?php  echo $this->createWebUrl('lesson');?>">课程列表</a></li>
	<li <?php  if($op=='postlesson') { ?>class="active"<?php  } ?>><a href="<?php  echo $this->createWebUrl('lesson', array('op'=>'postlesson','id'=>$_GPC['pid']));?>"><?php  if($_GPC['id']>0) { ?>编辑<?php  } else { ?>添加<?php  } ?>课程</a></li>
	<?php  if($op=='postsection') { ?>
	<li class="active"><a href="<?php  echo $this->createWebUrl('lesson', array('op'=>'postsection','pid'=>$_GPC['pid'],'id'=>$_GPC['id']));?>"><?php  if($_GPC['id']>0) { ?>编辑<?php  } else { ?>添加<?php  } ?>章节</a></li>
	<?php  } ?>
	<?php  if($op=='viewsection') { ?>
	<li class="active"><a href="<?php  echo $this->createWebUrl('lesson', array('op'=>'viewsection', 'pid'=>$_GPC['pid']));?>">【<?php  echo $lesson['bookname'];?>】章节列表</a></li>
	<?php  } ?>
	<li <?php  if($op=='record') { ?>class="active"<?php  } ?>><a href="<?php  echo $this->createWebUrl('lesson', array('op'=>'record'));?>">学习记录</a></li>
</ul>
<?php  if($operation == 'display') { ?>
<link href="<?php echo MODULE_URL;?>template/style/lessonlist.css" rel="stylesheet">
<div class="main">
	<div class="panel panel-info">
        <div class="panel-heading">筛选</div>
        <div class="panel-body">
            <form action="./index.php" method="get" class="form-horizontal" role="form">
                <input type="hidden" name="c" value="site" />
                <input type="hidden" name="a" value="entry" />
                <input type="hidden" name="m" value="fy_lessonv2" />
                <input type="hidden" name="do" value="lesson" />
                <input type="hidden" name="op" value="display" />
                <div class="form-group">
                    <label class="col-xs-12 col-sm-2 col-md-2 col-lg-1 control-label" style="width:100px;">课程名称</label>
                    <div class="col-sm-2 col-lg-3">
                        <input class="form-control" name="bookname" id="" type="text" value="<?php  echo $_GPC['bookname'];?>">
                    </div>
					<label class="col-xs-12 col-sm-2 col-md-2 col-lg-1 control-label" style="width:100px;">讲师名称</label>
                    <div class="col-sm-2 col-lg-3">
                        <input class="form-control" name="teacher" id="" type="text" value="<?php  echo $_GPC['teacher'];?>">
                    </div>
                </div>
				<div class="form-group">
					<label class="col-xs-12 col-sm-2 col-md-2 col-lg-1 control-label" style="width:100px;">课程性质</label>
                    <div class="col-sm-8 col-lg-3 col-xs-12">
                        <select name="is_free" class="form-control">
                            <option value="">不限</option>
							<option value="0" <?php  if(in_array($_GPC['is_free'], array('0'))) { ?>selected<?php  } ?>>免费课程</option>
							<option value="1" <?php  if(in_array($_GPC['is_free'], array('1'))) { ?>selected<?php  } ?>>付费课程</option>
                        </select>
                    </div>
                    <label class="col-xs-12 col-sm-2 col-md-2 col-lg-1 control-label" style="width:100px;">课程状态</label>
                    <div class="col-sm-8 col-lg-3 col-xs-12">
                        <select name="status" class="form-control">
                            <option value="">不限</option>
							<option value="1" <?php  if(in_array($_GPC['status'], array('1'))) { ?>selected<?php  } ?>>上架</option>
							<option value="0" <?php  if(in_array($_GPC['status'], array('0'))) { ?>selected<?php  } ?>>下架</option>
							<option value="-1" <?php  if(in_array($_GPC['status'], array('-1'))) { ?>selected<?php  } ?>>暂停销售</option>
							<option value="2" <?php  if(in_array($_GPC['status'], array('2'))) { ?>selected<?php  } ?>>审核中</option>
							<option value="999" <?php  if(in_array($_GPC['status'], array('999'))) { ?>selected<?php  } ?>>库存紧张</option>
                        </select>
                    </div>
                </div>
				<div class="form-group">
					<label class="col-xs-12 col-sm-2 col-md-2 col-lg-1 control-label" style="width:100px;">课程分类</label>
                    <div class="col-sm-3">
                        <select name="pid" class="form-control" id="category_parent" onchange="renderCategory(this.value)">
                            <option value="">请选择一级分类</option>
							<?php  if(is_array($category)) { foreach($category as $cat) { ?>
							   <option value="<?php  echo $cat['id'];?>"><?php  echo $cat['name'];?></option>
							<?php  } } ?>
                        </select>
                    </div>
					<div class="col-sm-3">
                        <select name="cid" class="form-control" id="category_child">
                            <option value="">请选择二级分类</option>
                        </select>
                    </div>
                </div>
				<div class="form-group">
					<label class="col-xs-12 col-sm-2 col-md-2 col-lg-1 control-label" style="width:100px;">课程板块 </label>
                    <div class="col-sm-8 col-lg-3 col-xs-12">
                        <select name="recid" class="form-control">
                            <option value="">不限</option>
							<?php  if(is_array($rec_list)) { foreach($rec_list as $rec) { ?>
							   <option value="<?php  echo $rec['id'];?>" <?php  if($_GPC['recid']==$rec['id']) { ?>selected<?php  } ?>><?php  echo $rec['rec_name'];?></option>
							<?php  } } ?>
                        </select>
                    </div>
					<div class="col-sm-3 col-lg-3" style="width: 18%;">
                        <button class="btn btn-default"><i class="fa fa-search"></i> 搜索</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
	<div class="category">
		<form action="" method="post">
			<div class="panel panel-default">
				<div class="panel-body table-responsive">
					<div class="dd" id="div_nestable">
					<?php  if(is_array($list)) { foreach($list as $parent) { ?>
						<ol class="dd-list" style="margin-bottom:15px;">
							<li class="dd-item">
								<button data-action="collapse" id="collapse<?php  echo $parent['id'];?>" type="button" style="display:none;" onclick="collapse(<?php  echo $parent['id'];?>);">Collapse</button>
								<?php  if(!empty($parent['section'])) { ?>
								<button data-action="expand" id="expand<?php  echo $parent['id'];?>"   type="button" style="display: block;" onclick="expand(<?php  echo $parent['id'];?>);">Expand</button>
								<?php  } else { ?>
								<button data-action="collapse" type="button" style="display: block;">collapse</button>
								<?php  } ?>
								
								<div class="dd-handle" style="width:100%;background:#eff5e9;">
									<input type="text" class="form-control" name="lessonorder[<?php  echo $parent['id'];?>]" value="<?php  echo $parent['displayorder'];?>" style="width: 70px;display:inline-block;">&nbsp;&nbsp;[ID: <?php  echo $parent['id'];?>] <?php  echo $parent['bookname'];?>&nbsp;&nbsp; 【分类:<?php  echo $parent['category']['name'];?>】 | 【价格:<?php  echo $parent['price'];?>】|【销量:<?php  echo $parent['buynum'];?>】|【库存：<span <?php  if($parent['stock']<10) { ?>class="stock"<?php  } ?>><?php  echo $parent['stock'];?></span>】<?php  if($parent['status']==0) { ?><a class="btn btn-danger btn-sm" style="padding:2px 10px;">下架</a><?php  } else if($parent['status']==1) { ?><a class="btn btn-success btn-sm" style="padding:2px 10px;">上架</a><?php  } else if($parent['status']==2) { ?><a class="btn btn-warning btn-sm" style="padding:2px 10px;">审核中</a><?php  } else if($parent['status']==-1) { ?><a class="btn btn-warning btn-sm" style="padding:2px 10px;">暂停销售</a><?php  } ?>
									<span class="pull-right">
										<a class="btn btn-default btn-sm" href="javascript:;"><?php  echo $parent['visit'];?>人访问</a>
										<a class="btn btn-default btn-sm" href="<?php  echo $this->createWebUrl('lesson', array('op'=>'viewsection','pid'=>$parent['id']));?>" title="预览章节"><i class="fa fa-search"></i></a>
										<a class="btn btn-default btn-sm" href="<?php  echo $this->createWebUrl('lesson', array('op'=>'qrcode','lessonid'=>$parent['id']));?>" title="下载课程二维码"><i class="fa fa-download"></i></a>
										<a class="btn btn-default btn-sm" href="<?php  echo $this->createWebUrl('lesson', array('op'=>'postlesson', 'id'=>$parent['id'],'refurl'=>$_W['siteurl']));?>" title="修改"><i class="fa fa-edit"></i></a>
										<a class="btn btn-default btn-sm" href="<?php  echo $this->createWebUrl('lesson', array('op'=>'delete','pid'=>$parent['id']));?>" title="删除" onclick="return confirm('确认删除此课程吗？');return false;"><i class="fa fa-remove"></i></a>
									</span>
									<div style="padding-top:10px;font-size:14px;">链接：<a href="javascript:;" id="copy<?php  echo $parent['id'];?>"><?php  echo $_W['siteroot'];?>app/<?php  echo $this->createMobileUrl('lesson', array('id'=>$parent['id']));?></a></div>
								</div>
								<script type="text/javascript">
								require(['jquery', 'util'], function($, util){
									$(function(){
										util.clip($("#copy<?php  echo $parent['id'];?>")[0], $("#copy<?php  echo $parent['id'];?>").text());
									});
								});
								</script>
								<?php  if(is_array($parent['section'])) { foreach($parent['section'] as $son) { ?>
								<ol class="dd-list cid<?php  echo $parent['id'];?>" style="width:100%;display:none;">
									<li class="dd-item">
										<div class="dd-handle"><input type="text" class="form-control" name="sectionorder[<?php  echo $son['id'];?>]" value="<?php  echo $son['displayorder'];?>" style="width: 70px;display:inline-block;">&nbsp;&nbsp;<?php  echo $son['title'];?>
											<span class="pull-right">
												<a class="btn btn-default btn-sm" href="<?php  echo $this->createWebUrl('lesson', array('op'=>'postsection', 'id'=>$son['id'], 'pid'=>$son['parentid'],'refurl'=>$_W['siteurl']));?>" title="修改"><i class="fa fa-edit"></i></a>
												<a class="btn btn-default btn-sm" href="<?php  echo $this->createWebUrl('lesson', array('op'=>'delete','cid'=>$son['id']));?>" title="删除" onclick="return confirm('确认删除此章节吗？');return false;"><i class="fa fa-remove"></i></a>
											</span>
										</div>
									</li>
								</ol>
								<?php  } } ?>
							</li>
						</ol>
					<?php  } } ?>
						<table class="table">
							<tbody>
								<tr>
									<td>
										<a href="<?php  echo $this->createWebUrl('lesson', array('op'=>'postlesson'));?>" class="btn btn-default"><i class="fa fa-plus"></i> 添加新课程</a>
										<input name="submit" type="submit" class="btn btn-primary" value="批量修改排序">
										<input type="hidden" name="token" value="<?php  echo $_W['token'];?>">
									</td>
								</tr>
							</tbody>
						</table>
						<?php  echo $pager;?>
					</div>
				</div>
			</div>
		</form>
	</div>
</div>
<script type="text/javascript">
function collapse(obj){
	$("#collapse"+obj).hide();
	$("#expand"+obj).show();
	$(".cid"+obj).hide();
}
function expand(obj){
	$("#expand"+obj).hide();
	$("#collapse"+obj).show();
	$(".cid"+obj).show();
}


var category = <?php  echo json_encode($category);?>;
var pid = <?php echo $_GPC['pid']?$_GPC['pid']:0?>;
var html = '<option value="0">请选择一级分类</option>';
$(function(){
	$("#category_parent").find("option[value='"+pid+"']").attr("selected",true);
	document.getElementById("category_parent").onchange();
});

function renderCategory(id){
	var chtml = '<option value="0">请选择二级分类</option>';
	var cid = <?php echo $_GPC['cid']?$_GPC['cid']:0?>;
	for(var i in category){
		if(category[i].id==id){
			var child = category[i].child;
			for(var j in child){
				if(child[j].id==cid){
					chtml += '<option value="' + child[j].id+'" selected>' + child[j].name + '</option>';
				}else{
					chtml += '<option value="' + child[j].id+'">' + child[j].name + '</option>';
				}
			}
			$("#category_child").html(chtml);
		}
	}
}
</script>
<?php  } else if($operation == 'postlesson') { ?>
<div class="main">
    <form action="" method="post" class="form-horizontal form" enctype="multipart/form-data">
        <div class="panel panel-default">
            <div class="panel-heading">课程信息</div>
            <div class="panel-body">
                <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label"><span style="color:red;font-weight:bolder;">*</span>课程名称</label>
                    <div class="col-sm-9">
                        <input type="text" name="bookname" class="form-control" value="<?php  echo $lesson['bookname'];?>" />
                    </div>
                </div>
				<div class="form-group">
					<label class="col-xs-12 col-sm-4 col-md-3 col-lg-2 control-label"><span style="color:red;font-weight:bolder;">*</span>课程分类</label>
					<div class="col-sm-8 col-xs-12">
						<div class="row row-fix tpl-category-container">
							<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
								<select class="form-control" id="category_parent" name="pid" onchange="renderCategory(this.value)">
									<option value="0">请选择一级分类</option>
									<?php  if(is_array($category)) { foreach($category as $item) { ?>
									<option value="<?php  echo $item['id'];?>"><?php  echo $item['name'];?></option>
									<?php  } } ?>
								</select>
							</div>
							<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
								<select class="form-control" id="category_child" name="cid">
									<option value="0">请选择二级分类</option>
								</select>
							</div>
						</div>
					</div>
				</div>
				<div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label"><span style="color:red;font-weight:bolder;">*</span>讲师名称</label>
                    <div class="col-sm-3">
						<select name="teacherid" class="form-control">
						    <option value="">请选择...</option>
						    <?php  if(is_array($teacher_list)) { foreach($teacher_list as $teacher) { ?>
						    <option value="<?php  echo $teacher['id'];?>" <?php  if($teacher['id']==$lesson['teacherid']) { ?>selected<?php  } ?>><?php  echo $teacher['first_letter'];?>-<?php  echo $teacher['teacher'];?></option>
						    <?php  } } ?>
						</select>
					</div>
                </div>
                <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label"><span style="color:red;font-weight:bolder;">*</span>课程封面</label>
                    <div class="col-sm-9">
                        <?php  echo tpl_form_field_image('images', $lesson['images'])?>
                        <span class="help-block">建议尺寸 600 * 350px，也可根据自己的实际情况做图片尺寸</span>
                    </div>
                </div>
				<div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">视频预播放封面</label>
                    <div class="col-sm-9">
                        <?php  echo tpl_form_field_multi_image('poster',$poster)?>
                        <span class="help-block">根据视频大小制作图片尺寸，多张图片将随机获取一张作为预播放封面</span>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">课程价格</label>
                    <div class="col-sm-9">
                        <div class="input-group">
                            <input type="text" name="price" class="form-control" value="<?php  echo $lesson['price'];?>" readonly="readonly"/>
                            <span class="input-group-addon">元</span>
                        </div>
						<div class="help-block">该选项无需填写，系统自动获取最低价格，0为免费课程</div>
                    </div>
                </div>
				<div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">课程规格</label>
                    <div class="col-sm-9">
                    	<?php  if(is_array($spec_list)) { foreach($spec_list as $item) { ?>
                        <div class="form-group item">
		                    <div class="col-sm-6">
		                        <div class="input-group">
		                            <span class="input-group-addon">有效期</span>
		                            	<input type="text" name="spec_time[]" value="<?php  echo $item['spec_day'];?>" class="form-control">
		                            	<span class="input-group-addon">天</span>
		                            	<span class="input-group-addon">需</span>
		                            	<input type="text" name="spec_price[]" value="<?php  echo $item['spec_price'];?>" class="form-control">
		                            	<span class="input-group-addon">元</span>
		                        </div>
		                    </div>
                		</div>
                		<?php  } } ?>
                		<div id="specdiv"></div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label"></label>
                    <div class="col-sm-9 col-xs-12">
                        <a href="javascript:;" id="spec-add"><i class="fa fa-plus-circle"></i> 添加新规格</a>
                        <span class="help-block">有效期为-1表示永久有效，保存时，留空的规格将自动删除</span>
                    </div>
                </div>
				<div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">库存</label>
                    <div class="col-sm-9">
                        <input type="text" name="stock" class="form-control" value="<?php  echo $lesson['stock'];?>" />
						<span class="help-block">如需开启库存，请先在“基本设置—>全局设置”里开启课程库存</span>
                    </div>
                </div>
				<div class="form-group">
					<label class="col-xs-12 col-sm-3 col-md-2 control-label">VIP会员课程折扣</label>
					<div class="col-sm-9">
						<label class="radio-inline">
							<input type="radio" name="isdiscount" value="1" <?php  if($lesson['isdiscount']==1) { ?>checked<?php  } ?>>开启
						</label>
						<label class="radio-inline">
							<input type="radio" name="isdiscount" value="0" <?php  if($lesson['isdiscount']==0) { ?>checked<?php  } ?>>关闭
						</label>
						<span class="help-block">开启VIP会员课程折扣后，VIP会员购买课程将享受优惠</span>
					</div>
				</div>
				<div class="form-group vip-discount" <?php  if($lesson['isdiscount']==0) { ?>style="display: none;"<?php  } ?>>
					<label class="col-xs-12 col-sm-3 col-md-2 control-label">会员折扣</label>
					<div class="col-sm-9">
						<div class="input-group">
							<input type="text" name="vipdiscount" class="form-control" value="<?php  echo $lesson['vipdiscount'];?>" />
							<span class="input-group-addon">%</span>
						</div>
						<span class="help-block">开启VIP会员课程折扣后，该项留空或为0表示使用当前会员对应的VIP会员等级最低折扣</span>
					</div>
				</div>
				<div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">赠送积分</label>
                    <div class="col-sm-9">
                        <div class="input-group">
                            <input type="text" name="integral" class="form-control" value="<?php  echo $lesson['integral'];?>" />
                            <span class="input-group-addon">积分</span>
                        </div>
						<div class="help-block">购买该课程赠送的积分数，0为不赠送</div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">抵扣积分</label>
                    <div class="col-sm-9">
                        <div class="input-group">
                            <input type="text" name="deduct_integral" class="form-control" value="<?php  echo $lesson['deduct_integral'];?>" />
                            <span class="input-group-addon">积分</span>
                        </div>
						<div class="help-block">用户购买课程时可用积分抵扣的数量，<strong style="color:#777;">请先在“营销管理—>抵扣设置”里设置积分抵扣</strong></div>
                    </div>
                </div>
				<div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">讲师分成</label>
                    <div class="col-sm-9">
                        <div class="input-group">
                            <input type="text" name="teacher_income" class="form-control" value="<?php  if(!empty($id)) { ?><?php  echo $lesson['teacher_income'];?><?php  } else { ?><?php  echo $setting['teacher_income'];?><?php  } ?>" />
                            <span class="input-group-addon">%</span>
                        </div>
						<div class="help-block">讲师分成 = 课程售价 x 讲师分成百分比</div>
                    </div>
                </div>
				<div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">虚拟购买人数</label>
                    <div class="col-sm-9">
                        <div class="input-group">
                            <input type="text" name="virtual_buynum" class="form-control" value="<?php  echo $lesson['virtual_buynum'];?>" />
                            <span class="input-group-addon">人</span>
                        </div>
						<div class="help-block">前台购买人数=真实购买人数+虚拟购买人数+访问课程人数</div>
                    </div>
                </div>
				<div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">课程难度</label>
                    <div class="col-sm-9">
                        <input type="text" name="difficulty" class="form-control" value="<?php  echo $lesson['difficulty'];?>" />
						<div class="help-block">例如：入门篇、进阶篇、高级篇</div>
                    </div>
                </div>
				<div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">课程介绍</label>
                    <div class="col-sm-9">
                        <div class="input-group">
							<?php  echo tpl_ueditor('descript', $lesson['descript']);?>
                        </div>
						<div class="help-block"></div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">排序</label>
                    <div class="col-sm-9">
                        <input type="text" name="displayorder" class="form-control" value="<?php  echo $lesson['displayorder'];?>" />
                    </div>
                </div>
				<div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">推荐到板块</label>
                    <div class="col-xs-9 col-sm-9" style="margin-top: 7px;">
					   <?php  if(is_array($rec_list)) { foreach($rec_list as $key => $rec) { ?>
							<input type="checkbox" name="recid[]" value="<?php  echo $rec['id'];?>" <?php  if(in_array($rec['id'],$recidarr)) { ?>checked<?php  } ?>><?php  echo $rec['rec_name'];?>&nbsp;&nbsp;
							<?php  if(($key+1)%4==0) { ?><br/><?php  } ?>
					   <?php  } } ?>
                   </div>
                </div>
				<div class="form-group item">
					<label class="col-xs-12 col-sm-3 col-md-2 control-label">一级佣金比例</label>
					<div class="col-sm-4">
						<div class="input-group">
							<input type="text" name="commission1" value="<?php  echo $commission['commission1'];?>" class="form-control"><span class="input-group-addon">%</span>
						</div>
						<span class="help-block">留空使用系统全局佣金比例</span>
					</div>
				</div>
				<div class="form-group item <?php  if(in_array($setting['level'],array('1'))) { ?>hide<?php  } ?>">
					<label class="col-xs-12 col-sm-3 col-md-2 control-label">二级佣金比例</label>
					<div class="col-sm-4">
						<div class="input-group">
							<input type="text" name="commission2" value="<?php  echo $commission['commission2'];?>" class="form-control"><span class="input-group-addon">%</span>
						</div>
						<span class="help-block">留空使用系统全局佣金比例</span>
					</div>
				</div>
				<div class="form-group item <?php  if(in_array($setting['level'],array('1','2'))) { ?>hide<?php  } ?>">
					<label class="col-xs-12 col-sm-3 col-md-2 control-label">三级佣金比例</label>
					<div class="col-sm-4">
						<div class="input-group">
							<input type="text" name="commission3" value="<?php  echo $commission['commission3'];?>" class="form-control"><span class="input-group-addon">%</span>
						</div>
						<span class="help-block">留空使用系统全局佣金比例</span>
					</div>
				</div>
				<div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">免费学习等级</label>
                    <div class="col-xs-9 col-sm-9" style="margin-top: 7px;">
					   <?php  if(is_array($level_list)) { foreach($level_list as $key => $level) { ?>
							<input type="checkbox" name="vipview[]" value="<?php  echo $level['id'];?>" <?php  if(in_array($level['id'],$vipview)) { ?>checked<?php  } ?>><?php  echo $level['level_name'];?>&nbsp;&nbsp;
							<?php  if(($key+1)%4==0) { ?><br/><?php  } ?>
					   <?php  } } ?>
					   <span class="help-block">选中的VIP等级级别会员可免费学习该课程</span>
                  </div>
                </div>
				<div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label"><span style="color:red;font-weight:bolder;">*</span>课程状态</label>
                    <div class="col-sm-9">
                        <label class="radio-inline"><input type="radio" name="status" value="1" <?php  if(empty($lesson) || $lesson['status'] == 1) { ?>checked="true"<?php  } ?> /> 上架</label>
                        &nbsp;&nbsp;
                        <label class="radio-inline"><input type="radio" name="status" value="0" <?php  if(!empty($lesson) && $lesson['status'] == 0) { ?>checked="true"<?php  } ?> /> 下架</label>
						&nbsp;&nbsp;
                        <label class="radio-inline"><input type="radio" name="status" value="2" <?php  if($lesson['status'] == 2) { ?>checked="true"<?php  } ?> /> 审核中</label>
						&nbsp;&nbsp;
                        <label class="radio-inline"><input type="radio" name="status" value="-1" <?php  if($lesson['status'] == -1) { ?>checked="true"<?php  } ?> /> 暂停销售</label>
                        <span class="help-block">【上架】课程正常销售，【下架】【审核中】课程将不能再进行观看或购买，【暂停销售】已购买课程用户可正常观看，未购买用户不能查看</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="form-group col-sm-12">
            <input type="submit" name="submit" value="提交" class="btn btn-primary col-lg-1" />
            <input type="hidden" name="token" value="<?php  echo $_W['token'];?>" />
			<input type="hidden" name="id" value="<?php  echo $lesson['id'];?>" />
        </div>
    </form>
</div>
<script type="text/javascript">
 $(function () {
	$(':radio[name="isdiscount"]').click(function () {
	   if ($(this).val()=='0') {
			$('.vip-discount').hide();
		} else {

			$('.vip-discount').show();
		}
	});
});

//添加规格按钮
$("#spec-add").click(function () {
    var spec_html = '';
    spec_html += '<div class="form-group item">';
    spec_html += '	<div class="col-sm-6">';
    spec_html += '		<div class="input-group">';
    spec_html += '			<span class="input-group-addon">有效期</span>';
    spec_html += '			<input type="text" name="spec_time[]" class="form-control">';
    spec_html += '			<span class="input-group-addon">天</span>';
    spec_html += '			<span class="input-group-addon">需</span>';
    spec_html += '			<input type="text" name="spec_price[]" class="form-control">';
    spec_html += '			<span class="input-group-addon">元</span>';
    spec_html += '		</div>';
    spec_html += '	</div>';
    spec_html += '</div>';

    $("#specdiv").append(spec_html);
});
</script>
<script type="text/javascript">
var category = <?php  echo json_encode($category);?>;
var pid = <?php echo $lesson['pid']?$lesson['pid']:0?>;
var html = '<option value="0">请选择一级分类</option>';
$(function(){
	$("#category_parent").find("option[value='"+pid+"']").attr("selected",true);
	document.getElementById("category_parent").onchange();
});

function renderCategory(id){
	var chtml = '<option value="0">请选择二级分类</option>';
	var cid = <?php echo $lesson['cid']?$lesson['cid']:0?>;
	for(var i in category){
		if(category[i].id==id){
			var child = category[i].child;
			for(var j in child){
				if(child[j].id==cid){
					chtml += '<option value="' + child[j].id+'" selected>' + child[j].name + '</option>';
				}else{
					chtml += '<option value="' + child[j].id+'">' + child[j].name + '</option>';
				}
			}
			$("#category_child").html(chtml);
		}
	}
}
</script>

<?php  } else if($operation == 'postsection') { ?>
<div class="main">
    <form action="" method="post" class="form-horizontal form" enctype="multipart/form-data">
        <div class="panel panel-default">
            <div class="panel-heading">章节信息</div>
            <div class="panel-body">
				<div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">当前课程</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" value="<?php  echo $lesson['bookname'];?>" readonly/>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">章节名称</label>
                    <div class="col-sm-9">
                        <input type="text" name="title" class="form-control" value="<?php  echo $section['title'];?>" />
						<div class="help-block">例如 第一节：初步认识HTML、1-1 初步认识HTML</div>
                    </div>
                </div>
				<div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">章节类型</label>
                    <div class="col-sm-9">
						<label class="radio-inline"><input type="radio" id="vtype" class="vtype" name="sectiontype" value="1" <?php  if($section['sectiontype'] == 1) { ?>checked="true"<?php  } ?> /> 视频章节</label>&nbsp;&nbsp;&nbsp;
						<label class="radio-inline"><input type="radio" class="vtype" name="sectiontype" value="3" <?php  if($section['sectiontype'] == 3) { ?>checked="true"<?php  } ?> /> 音频章节</label>&nbsp;&nbsp;&nbsp;
                        <label class="radio-inline"><input type="radio" id="atype" name="sectiontype" value="2" <?php  if($section['sectiontype'] == 2) { ?>checked="true"<?php  } ?> /> 图文章节</label>
                        <label class="radio-inline"><input type="radio" id="utype" name="sectiontype" value="4" <?php  if($section['sectiontype'] == 4) { ?>checked="true"<?php  } ?> /> 外链章节</label>
                    </div>
                </div>
				<div class="form-group videoaudio" <?php  if(!in_array($section['sectiontype'], array('1','3'))) { ?>style="display:none;"<?php  } ?>>
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">存储方式</label>
                    <div class="col-sm-9">
						<label class="radio-inline"><input type="radio" id="noqiniu" name="savetype" value="0" <?php  if($section['savetype'] == 0) { ?>checked="true"<?php  } ?> /> 其他存储方式</label>&nbsp;&nbsp;&nbsp;
                        <label class="radio-inline"><input type="radio" id="qiniu" name="savetype" value="1" <?php  if($section['savetype'] == 1) { ?>checked="true"<?php  } ?> /> 七牛云存储</label>
						<label class="radio-inline"><input type="radio" id="code" name="savetype" value="2" <?php  if($section['savetype'] == 2) { ?>checked="true"<?php  } ?> /> 内嵌代码方式</label>
						<label class="radio-inline"><input type="radio" id="qcloud" name="savetype" value="3" <?php  if($section['savetype'] == 3) { ?>checked="true"<?php  } ?> /> 腾讯云存储</label>
                    </div>
                </div>
				<div class="form-group videoaudio" <?php  if(!in_array($section['sectiontype'], array('1','3'))) { ?>style="display:none;"<?php  } ?>>
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">视频/音频URL</label>
                    <div class="col-sm-9">
						<textarea id="videourl" name="videourl" class="form-control" style="min-height:100px;"><?php  echo $section['videourl'];?></textarea>
						<div class="help-block">七牛、腾讯云存储和其他存储请用URL如：http://wx.fy_lessonv2888.com/e1.mp4(注意区分url大小写)，建议使用视频格式用mp4，音频格式用mp3</div>
                    </div>
                </div>
				<div class="form-group videoaudio" <?php  if(!in_array($section['sectiontype'], array('1','3'))) { ?>style="display:none;"<?php  } ?>>
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">视频/音频时长</label>
                    <div class="col-sm-9">
                        <input type="text" name="videotime" class="form-control" value="<?php  echo $section['videotime'];?>" />
						<div class="help-block">请输入视频/音频时长，例如：13分钟, 8分钟</div>
                    </div>
                </div>
				<div class="form-group scontent" <?php  if($section['sectiontype']!=2) { ?>style="display:none;"<?php  } ?>>
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">图文章节内容</label>
                    <div class="col-sm-9">
                        <?php  echo tpl_ueditor('content', $section['content']);?>
						<div class="help-block">请填写图文章节内容</div>
                    </div>
                </div>
                <div class="form-group linkurl" <?php  if($section['sectiontype']!=4) { ?>style="display:none;"<?php  } ?>>
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">外链URL</label>
                    <div class="col-sm-9">
						<textarea  name="linkurl" class="form-control" style="min-height:100px;"><?php  echo $section['videourl'];?></textarea>
						<div class="help-block">外链章节将跳转到其他页面，填写完整的外链链接url，包括http://</div>
                    </div>
                </div>
				<div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">排序</label>
                    <div class="col-sm-9">
                        <input type="text" name="displayorder" class="form-control" value="<?php  echo $section['displayorder'];?>" />
                    </div>
                </div>
				<div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">试听章节</label>
                    <div class="col-sm-9">
                        <label class="radio-inline"><input type="radio" name="is_free" value="1" <?php  if($section['is_free'] == 1) { ?>checked="true"<?php  } ?> /> 是</label>
                        &nbsp;&nbsp;&nbsp;
                        <label class="radio-inline"><input type="radio" name="is_free" value="0" <?php  if(empty($section) || $section['is_free'] == 0) { ?>checked="true"<?php  } ?> /> 否</label>
                        <span class="help-block"></span>
                    </div>
                </div>
				<div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">是否上架</label>
                    <div class="col-sm-9">
                        <label class="radio-inline"><input type="radio" name="status" value="1" <?php  if(empty($section) || $section['status'] == 1) { ?>checked="true"<?php  } ?> /> 是</label>
                        &nbsp;&nbsp;&nbsp;
                        <label class="radio-inline"><input type="radio" name="status" value="0" <?php  if(!empty($section) && $section['status'] == 0) { ?>checked="true"<?php  } ?> /> 否</label>
                        <span class="help-block"></span>
                    </div>
                </div>
            </div>
        </div>
        <div class="form-group col-sm-12">
            <input type="submit" name="submit" value="提交" class="btn btn-primary col-lg-1" />
            <input type="hidden" name="token" value="<?php  echo $_W['token'];?>" />
			<input type="hidden" name="id" value="<?php  echo $id;?>" />
			<input type="hidden" name="pid" value="<?php  echo $pid;?>" />
        </div>
    </form>
</div>
<script type="text/javascript">
var qimiuurl = "<?php  echo $qiniu['url']?>";
var securl   = "<?php  echo $section['videourl']?>";
var videourl = document.getElementById("videourl");
$("#noqiniu").click(function(){
	videourl.value = securl;
});
$("#qiniu").click(function(){
	videourl.value = qimiuurl;
});
$("#code").click(function(){
	videourl.value = "<iframe  frameborder=0  width=100%  height=40%  src=这里替换内嵌视频地址  allowfullscreen></iframe>";
});
$("#qcloud").click(function(){
	videourl.value = "";
});
$(".vtype").click(function(){
	$(".videoaudio").show();
	$(".scontent").hide();
	$(".linkurl").hide();
});
$("#atype").click(function(){
	$(".videoaudio").hide();
	$(".scontent").show();
	$(".linkurl").hide();
});
$("#utype").click(function(){
	$(".videoaudio").hide();
	$(".scontent").hide();
	$(".linkurl").show();
});

var sid = <?php echo $id>0 ? $id : 0;?>;
if(sid==0){
	document.getElementById("vtype").click();
}
</script>

<?php  } else if($operation == 'viewsection') { ?>
<div class="main">
	<div class="panel panel-default">
        <div class="panel-body">
            <a class="btn btn-primary" href="<?php  echo $this->createWebUrl('lesson', array('op'=>'postsection','pid'=>$lesson['id']));?>"><i class="fa fa-plus"></i> 添加章节</a>&nbsp;&nbsp;
			<a class="btn btn-success" href="<?php  echo $this->createWebUrl('lesson', array('op'=>'informStudent','lessonid'=>$lesson['id']));?>"><i class="fa fa-newspaper-o"></i> 通知学员开课</a>
        </div>
    </div>
	<form action="" method="post" class="form-horizontal form">
		<div class="panel panel-default">
			<div class="panel-body table-responsive">
				<table class="table table-hover">
					<thead class="navbar-inner">
						<tr>
							<th style="width:10%;text-align:center;">排序</th>
							<th style="width:28%;">章节名称</th>
							<th style="width:9%;text-align:center;">试听章节</th>
							<th style="width:9%;text-align:center;">章节类型</th>
							<th style="width:9%;text-align:center;">章节状态</th>
							<th style="width:15%;text-align:center;">添加时间</th>
							<th style="width:10%;text-align:center;">操作</th>
						</tr>
					</thead>
					<tbody>
						<?php  if(is_array($section_list)) { foreach($section_list as $sec) { ?>
						<tr>
							<td style="text-align:center;"><input type="text" class="form-control" name="sectionorder[<?php  echo $sec['id'];?>]" value="<?php  echo $sec['displayorder'];?>"></td>
							<td>[ID：<?php  echo $sec['id'];?>] <?php  echo $sec['title'];?></td>
							<td style="text-align:center;"><?php echo $sec['is_free']==1?'试听章节':'付费章节';?></td>
							<td style="text-align:center;"><?php  if($sec['sectiontype']==1) { ?>视频章节<?php  } else if($sec['sectiontype']==2) { ?>图文章节<?php  } else if($sec['sectiontype']==3) { ?>音频章节<?php  } else if($sec['sectiontype']==4) { ?>外链章节<?php  } ?></td>
							<td style="text-align:center;"><?php echo $sec['status']==1?'显示':'隐藏';?></td>
							<td style="text-align:center;"><?php  echo date('Y-m-d H:i:s',$sec['addtime']);?></td>
							<td style="text-align:center;">
								<a class="btn btn-default btn-sm" href="<?php  echo $this->createWebUrl('lesson', array('op'=>'postsection', 'id'=>$sec['id'], 'pid'=>$sec['parentid']));?>" title="修改"><i class="fa fa-edit"></i></a>
								<a class="btn btn-default btn-sm" href="<?php  echo $this->createWebUrl('lesson', array('op'=>'delete','cid'=>$sec['id']));?>" title="删除" onclick="return confirm('确认删除此章节吗？');return false;"><i class="fa fa-remove"></i></a>
							</td>
						</tr>
						<?php  } } ?>
					</tbody>
				</table>
				<table class="table">
					<tbody>
						<tr>
							<td>
								<input name="submit" type="submit" class="btn btn-primary" value="批量修改排序">
								<input type="hidden" name="token" value="<?php  echo $_W['token'];?>">
								<input type="hidden" name="pid" value="<?php  echo $pid;?>">
							</td>
						</tr>
					</tbody>
				</table>
			 </div>
		 </div>
		 <?php  echo $pager;?>
	</form>
  </div>
<?php  } else if($op=='record') { ?>
<style>
.col-lg-3{width:22%;}
</style>
<div class="main">
    <div class="panel panel-info">
        <div class="panel-heading">筛选</div>
        <div class="panel-body">
            <form action="./index.php" method="get" class="form-horizontal form" enctype="multipart/form-data" onkeydown="if(event.keyCode==13){return false;}">
				<input type="hidden" name="c" value="site" />
                <input type="hidden" name="a" value="entry" />
                <input type="hidden" name="m" value="fy_lessonv2" />
                <input type="hidden" name="do" value="lesson" />
                <input type="hidden" name="op" value="record" />
                <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">选择课程</label>
                    <div class="col-sm-9 col-xs-12">
                        <div class='input-group'>
                            <input type="text" id='bookname' maxlength="30" class="form-control" readonly />
							<input type="hidden" id='lessonid' name="lessonid"/>
                            <div class='input-group-btn'>
                                <button class="btn btn-default" type="button" onclick="popwin = $('#modal-module-menus').modal();">选择课程</button>
                            </div>
                        </div>
                        <div id="modal-module-menus"  class="modal fade" tabindex="-1">
                            <div class="modal-dialog" style='width: 920px;'>
                                <div class="modal-content">
                                    <div class="modal-header"><button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button><h3>选择课程</h3></div>
                                    <div class="modal-body" >
                                        <div class="row">
                                            <div class="input-group">
                                                <input type="text" class="form-control" name="keyword" value="" id="search-kwd" placeholder="请输入课程名称" />
                                                <span class='input-group-btn'><button type="button" class="btn btn-default" onclick="search_lesson();">搜索</button></span>
                                            </div>
                                        </div>
                                        <div id="module-menus" style="padding-top:5px;"></div>
                                    </div>
                                    <div class="modal-footer"><a href="javascript:;" class="btn btn-default" data-dismiss="modal" aria-hidden="true">关闭</a></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
				<div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">选择用户</label>
                    <div class="col-sm-9 col-xs-12">
                        <div class='input-group'>
                            <input type="text" id='nickname' maxlength="30" class="form-control" readonly />
							<input type="hidden" id='uid' name="uid"/>
                            <div class='input-group-btn'>
                                <button class="btn btn-default" type="button" onclick="popwin = $('#modal-module-member').modal();">选择用户</button>
                            </div>
                        </div>
                        <div id="modal-module-member"  class="modal fade" tabindex="-1">
                            <div class="modal-dialog" style='width: 920px;'>
                                <div class="modal-content">
                                    <div class="modal-header"><button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button><h3>选择用户</h3></div>
                                    <div class="modal-body" >
                                        <div class="row">
                                            <div class="input-group">
                                                <input type="text" class="form-control" name="kmember" value="" id="search-km" placeholder="请输入用户昵称/姓名/手机号" />
                                                <span class='input-group-btn'><button type="button" class="btn btn-default" onclick="search_member();">搜索</button></span>
                                            </div>
                                        </div>
                                        <div id="module-member" style="padding-top:5px;"></div>
                                    </div>
                                    <div class="modal-footer"><a href="javascript:;" class="btn btn-default" data-dismiss="modal" aria-hidden="true">关闭</a></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
				<div class="form-group">
					<label class="col-xs-12 col-sm-2 col-md-2 col-lg-1 control-label" style="width:100px;"></label>
                    <div class="col-sm-3 col-lg-3">
                        <button class="btn btn-default"><i class="fa fa-search"></i> 搜索</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    
    <div class="panel panel-default">
        <form action="" method="post" class="form-horizontal form" >
        <div class="table-responsive panel-body">
            <table class="table table-hover">
                <thead class="navbar-inner">
                <tr>
                    <th style="width:35%;">课程名称</th>
                    <th style="width:35%;">章节名称 / 学习时长</th>
                    <th>会员昵称</th>
                    <th>学习时间</th>
                </tr>
                </thead>
                <tbody>
                <?php  if(is_array($list)) { foreach($list as $item) { ?>
                <tr>
                    <td>《<?php  echo $item['bookname'];?>》</td>
                    <td><?php  echo $item['title'];?><br/><?php  echo $item['playtime'];?></td>
                    <td><?php  echo $item['user']['nickname'];?></td>
					<td><?php  echo date('Y-m-d H:i:s', $item['addtime']);?></td>
                </tr>
                <?php  } } ?>
                </tbody>
            </table>
            <?php  echo $pager;?>
        </div>
    </div>
    </form>
</div>
<script type="text/javascript">
function search_lesson() {
	var uniacid = <?php  echo $uniacid?>;
	if ($.trim($('#search-kwd').val()) == '') {
		document.getElementById('search-kwd').focus();
		return;
	}
	$("#module-menus").html("正在搜索....");
	$.get("<?php  echo $this->createWebUrl('getlessonormember', array('op'=>'getLesson'))?>", { 
		uniacid:uniacid,keyword: $.trim($('#search-kwd').val())
	}, function (dat) {
		$('#module-menus').html(dat);
	});
}
function select_lesson(obj) {
	$("#bookname").val(obj.bookname);
	$("#lessonid").val(obj.id);
	$("#price").val(obj.price);
	$("#teacher_income").val(obj.teacher_income);
	$("#validity").val(obj.validity);
}

function search_member() {
	var uniacid = <?php  echo $uniacid?>;
	if ($.trim($('#search-km').val()) == '') {
		document.getElementById('search-km').focus();
		return;
	}
	$("#module-member").html("正在搜索....");
	$.get("<?php  echo $this->createWebUrl('getlessonormember', array('op'=>'getMember'))?>", { 
		uniacid:uniacid,keyword: $.trim($('#search-km').val())
	}, function (dat) {
		$('#module-member').html(dat);
	});
}
function select_member(obj) {
	$("#nickname").val(obj.nickname);
	$("#uid").val(obj.uid);
}
</script>
<?php  } ?>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/footer', TEMPLATE_INCLUDEPATH)) : (include template('common/footer', TEMPLATE_INCLUDEPATH));?>