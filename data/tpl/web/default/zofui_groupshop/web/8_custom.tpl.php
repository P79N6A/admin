<?php defined('IN_IA') or exit('Access Denied');?>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/header', TEMPLATE_INCLUDEPATH)) : (include template('common/header', TEMPLATE_INCLUDEPATH));?>
	<link href="../addons/zofui_groupshop/public/css/weui.min.css" rel="stylesheet">
	<link href="../addons/zofui_groupshop/template/web/css/common.css" rel="stylesheet">
	
<ul class="page_top">
	<a href="<?php  echo $this->createWebUrl('custom',array('op'=>'add'))?>">
		<li class="top_btn <?php  if($op == 'add') { ?>activity_bottom<?php  } ?>">添加页面</li>
	</a>
	<a href="<?php  echo $this->createWebUrl('custom',array('op'=>'list'))?>">
		<li class="top_btn <?php  if($op == 'list') { ?>activity_bottom<?php  } ?>">管理页面</li>
	</a>
	<?php  if($op == 'edit') { ?>
		<a href="<?php  echo $this->createWebUrl('custom',array('op'=>'edit','id'=>$_GPC['id']))?>">
			<li class="top_btn <?php  if($op == 'edit') { ?>activity_bottom<?php  } ?>">编辑页面</li>
		</a>
	<?php  } ?>	
</ul>

<div class="page_body">
<?php  if($op == 'add' || $op == 'edit') { ?>
<link href="./resource/css/app.css" rel="stylesheet">
<link href="../addons/zofui_groupshop/template/web/css/jquery-ui.css" rel="stylesheet">
<link href="./resource/components/switch/bootstrap-switch.min.css" rel="stylesheet">
<link href="../addons/zofui_groupshop/template/web/css/custom.css" rel="stylesheet">
<script type="text/javascript" src="../addons/zofui_groupshop/public/js/lib/angular.min.js"></script>  

<div  class="app" name="custom_form">
	<div class="app clearfix"  ng-app="app"  ng-controller="custom">
<!-- {{Items}} -->
		<!-- 预览框 -->
		<div class="app-preview">
			<div class="app-header"></div>			
			<div class="app-content" ng-style="{'background':pages[0].params.bgColor}">
				<!-- 页面颜色等 -->				
                <div ng-repeat="page in pages">
                    <div ng-include="'../addons/zofui_groupshop/template/web/temp/show-'+page.temp+'.html'" id="{{page.id}}" mid="{{page.id}}" ng-click="setfocus(page.id,$event)"></div>
                </div>
				
				<!-- 其他模块 -->
                <div ng-repeat="Item in Items" class="app-mod-repeat" ng-mouseover="over(Item.id)" ng-mouseleave="out(Item.id)">
                    <div class="app-mod-move" ng-mouseover="drag(Item.id)" ng-click="setfocus(Item.id,$event)"></div>
                    <div ng-include="'../addons/zofui_groupshop/template/web/temp/show-'+Item.temp+'.html'" class="app-mod-parent" id="{{Item.id}}" ng-show="Item" mid="{{Item.id}}" finish-render-filters></div>
                    <div class="app-mod-del" ng-click="delItem(Item.id)">删除</div>
                </div>				
				
                <!-- 客服按钮 -->
                <div class="app-floatico" ng-show="pages[0].params.floatico==1" ng-style="{'width':pages[0].params.floatwidth + 'px','top':pages[0].params.floattop + '%'}" ng-class="{'app-floatico-right':pages[0].params.floatstyle=='right','absoluteico':isweb}">
                    <a href="{{pages[0].params.floatlink}}" target="_blank">
						<img ng-src="{{pages[0].params.floatimg || '../addons/zofui_groupshop/public/images/kefu.png'}}" style="height:100%; width: 100%;" ng-click="setfocus('M0')" />
					</a>
                </div>
				<!-- 返回顶部 -->
				<div id="gotoTop" go-to-top style="position:absolute;display:block" ng-if="pages[0].params.totop==1">
				  <div class="arrow"></div>
				  <div class="stick"></div>
				</div>
				<div id="gotoTop" class="imgtotop" go-to-top style="position:absolute;display:block" ng-if="pages[0].params.totop==2" ng-style="{'width':pages[0].params.totopwidth + 'px','top':pages[0].params.totoptop + '%'}">
				  <img ng-src="{{pages[0].params.totopimg || '../addons/zofui_groupshop/public/images/totop.png'}}">
				</div>				
			</div>
			<div class="app-bottom"></div>
		</div>
		
		<!-- 编辑框 -->
		<div class="app-side">
            <div class="app-panel-editor" ng-show="focus">
                <div class="app-panel-editor-ico"></div>
				<!-- 页面颜色等 -->
                <div ng-repeat="Edit in pages">
                    <div ng-include="'../addons/zofui_groupshop/template/web/temp/edit-'+Edit.temp+'.html'" ng-show="focus==Edit.id" Editid="{{Edit.id}}" >{{Edit}}</div>
                </div>
				
				<!-- 其他模块 -->
                <div ng-repeat="Edit in Items">
                    <div ng-include="'../addons/zofui_groupshop/template/web/temp/edit-'+Edit.temp+'.html'" ng-show="focus==Edit.id" Editid="{{Edit.id}}" tab-index="-1"></div>
                </div>			
            </div>
		</div>		
		
		<!-- 右下角 -->
		<div class="shop-preview col-xs-12 col-sm-9 col-lg-10">
			<div class="text-center alert ">
				<div class="app-item" ng-show="appItemShow" ng-mouseover="appItemShow = true" ng-mouseleave="appItemShow = false">
					<span class="btn btn-info app-item-modal" ng-repeat="m in modules" ng-click="addModule(m.id)">{{m.name}}</span>					
				</div>
				<div class="addmodule btn_44b549" style="background-color: #44b549;" ng-mouseover="appItemShow = true" ng-mouseleave="appItemShow = false">添加模块</div>
				<div class="geturl btn_44b549" style="background-color: #44b549;"  ng-click="searchItem('url');isgeturl = 1">获取链接</div>
				<button type="button" class="btn_44b549 js-editor-submit" ng-click="save(1)">保存</button>
			</div>
		</div>
		
		<!-- 获取内容和链接 -->
		<div id="link-search-system" class="modal fade in geturlmodal"  ng-init="geturlshow = 'none'" ng-style="{'display':geturlshow}">
			<div class="modal-dialog">	
				<div class="modal-content">
				<div class="modal-header">	
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true" ng-click="geturlshow = 'none';isgeturl = 0">×</button>	
					
					<div class="row">
					  <div class="col-xs-10">
						<div class="input-group">
						  <div class="input-group-btn">
							<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">{{searchName || '在这里选择查找的类型'}}<span class="caret"></span></button>
							<ul class="dropdown-menu" ng-if="isgeturl == 0">
							  <li ng-click="searchItem('good')" ng-show="showtype == 'url' || showtype == 'good'"><a>商品</a></li>
							  <li ng-click="searchItem('card')" ng-show="showtype == 'url' || showtype == 'card'"><a>卡券</a></li>
							  <li ng-click="searchItem('page')" ng-show="showtype == 'url' || showtype == 'page'"><a>装修页面链接</a></li>
							</ul>
							
							<ul class="dropdown-menu" ng-if="isgeturl == 1">
							  <li ng-click="searchItem('good')" ><a>商品</a></li>
							  <li role="separator" class="divider" ></li>
							  <li ng-click="searchItem('page')"><a>装修页面链接</a></li>
							</ul>							
						  </div>
						</div>
					  </div>		
					</div>
				</div>
				<div class="modal-body" style="height: 480px; overflow-y: auto;">
					<table class="table table-hover">
						<thead class="navbar-inner">
							<tr ng-show="showtype == 'good'">
								<th class="col-xs-2">缩略图</th>
								<th class="col-xs-4">标题</th>			
								<th class="col-xs-3">操作</th>
							</tr>
							<tr ng-show="showtype == 'card'">
								<th class="col-xs-4">卡券名称</th>
								<th class="col-xs-2">面值</th>	
								<th class="col-xs-3">使用条件</th>									
								<th class="col-xs-2">操作</th>
							</tr>							
							<tr ng-show="showtype == 'page'">
								<th class="col-xs-10">备注名称</th>
								<th class="col-xs-2">操作</th>
							</tr>
						</thead>
						<tbody id="searchbody">
							<tr ng-repeat="result in searchResult" ng-if="showtype == 'good'">
								<td><img ng-src="{{result.img}}" style="width:30px;height:30px"> ID：{{result.id}}</td>
								<td><a>{{result.title}}</a></td>
								<td class="copyid" style="position:relative">
									<label ng-if="isgeturl == 0" class="label label-primary" style="cursor:pointer" ng-click="pushIntoFocus(focus, result.id)">选取</label>
									<label ng-if="isgeturl == 1" class="copyurl label label-primary" style="cursor:pointer" data-url="{{result.url}}" ng-click="copyit()">复制链接</label>
								</td>
							</tr>
							
							<tr ng-repeat="result in searchResult" ng-if="showtype == 'card'">
								<td>{{result.cardname}}</td>
								<td>
									<span ng-if="result.cardtype == 1">{{result.cardvalue}}元</span>
									<span ng-if="result.cardtype == 2">{{result.cardvalue * 10}}折</span>
								</td>
								<td>订单满{{result.fullmoney}}元</td>
								<td class="copyid">
									<label class="btn_44b549" style="cursor:pointer;padding:0 5px;" ng-click="pushIntoFocus(focus, result.id)">选取</label>
								</td>
							</tr>
							<tr ng-repeat="result in searchResult" ng-if="showtype == 'page'">
								<td><a>{{result.pagename}}</a></td>
								<td class="copyid" style="position:relative">
									<label ng-if="isgeturl == 1" class="copyurl label label-primary" style="cursor:pointer" data-url="{{result.url}}" ng-click="copyit()">复制链接</label>
								</td>
							</tr>
						</tbody>
					</table>
					<span id="nexpager">
						<a class="btn btn-primary"" ng-click="tosearch(showtype,'minus');" ng-show="searchpage > 1">上一页</a>&nbsp;&nbsp;
						<a class="btn btn-primary" ng-click="tosearch(showtype,'add')" ng-show="searchResult.length >= 10">下一页</a>
					</span>
				</div>
				</div>
			</div>				
		</div>
	
	</div>
	
	
<script type="text/ng-template" id="edit-topbar.html"><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('../../../addons/zofui_groupshop/template/web/temp/edit-topbar', TEMPLATE_INCLUDEPATH)) : (include template('../../../addons/zofui_groupshop/template/web/temp/edit-topbar', TEMPLATE_INCLUDEPATH));?></script>
<script type="text/ng-template" id="edit-solid.html"><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('../../../addons/zofui_groupshop/template/web/temp/edit-solid1', TEMPLATE_INCLUDEPATH)) : (include template('../../../addons/zofui_groupshop/template/web/temp/edit-solid1', TEMPLATE_INCLUDEPATH));?></script>
<script type="text/ng-template" id="edit-cube.html"><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('../../../addons/zofui_groupshop/template/web/temp/edit-cube', TEMPLATE_INCLUDEPATH)) : (include template('../../../addons/zofui_groupshop/template/web/temp/edit-cube', TEMPLATE_INCLUDEPATH));?></script>
<script type="text/ng-template" id="edit-notice.html"><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('../../../addons/zofui_groupshop/template/web/temp/edit-notice', TEMPLATE_INCLUDEPATH)) : (include template('../../../addons/zofui_groupshop/template/web/temp/edit-notice', TEMPLATE_INCLUDEPATH));?></script>
<script type="text/ng-template" id="edit-title.html"><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('../../../addons/zofui_groupshop/template/web/temp/edit-title', TEMPLATE_INCLUDEPATH)) : (include template('../../../addons/zofui_groupshop/template/web/temp/edit-title', TEMPLATE_INCLUDEPATH));?></script>
<script type="text/ng-template" id="edit-search.html"><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('../../../addons/zofui_groupshop/template/web/temp/edit-search', TEMPLATE_INCLUDEPATH)) : (include template('../../../addons/zofui_groupshop/template/web/temp/edit-search', TEMPLATE_INCLUDEPATH));?></script>
<script type="text/ng-template" id="edit-goods1.html"><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('../../../addons/zofui_groupshop/template/web/temp/edit-goods1', TEMPLATE_INCLUDEPATH)) : (include template('../../../addons/zofui_groupshop/template/web/temp/edit-goods1', TEMPLATE_INCLUDEPATH));?></script>
<script type="text/ng-template" id="edit-richtext1.html"><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('../../../addons/zofui_groupshop/template/web/temp/edit-richtext1', TEMPLATE_INCLUDEPATH)) : (include template('../../../addons/zofui_groupshop/template/web/temp/edit-richtext1', TEMPLATE_INCLUDEPATH));?></script>



<script type="text/javascript" src="../addons/zofui_groupshop/public/js/lib/angular-ueditor.js"></script>
<script type="text/javascript" src="./resource/components/ueditor/ueditor.config.js"></script>
<script type="text/javascript" src="./resource/components/ueditor/ueditor.all.min.js"></script>
<script type="text/javascript" src="./resource/components/ueditor/ueditor.parse.js"></script>
<script type="text/javascript" src="./resource/components/ueditor/lang/zh-cn/zh-cn.js"></script>

<script type="text/javascript">
// 百度编辑器
var opts = {type: 'image',direct: false,multi: true,tabs: {'upload': 'active','browser': '','crawler': ''},path: '',dest_dir: '',global: false,thumb: false,width: 0};
UE.registerUI('myinsertimage',function(editor, uiName) {
    editor.registerCommand(uiName, {
        execCommand: function() {
            require(['fileUploader'],
            function(uploader) {
                uploader.show(function(imgs) {
                    if (imgs.length == 0) {
                        return;
                    } else if (imgs.url) {
                        editor.execCommand('insertimage', {
                            'src': imgs.url,
                            '_src': imgs.attachment,
                            'width': '100%',
                            'alt': imgs.filename
                        });
                    } else {
                        var imglist = [];
                        for (i in imgs) {
                            imglist.push({
                                'src': imgs[i]['url'],
                                '_src': imgs[i]['attachment'],
                                'width': '100%',
                                'alt': imgs[i].filename
                            });
                        }
                        editor.execCommand('insertimage', imglist);
                    }
                },
                opts);
            });
        }
    });
    var btn = new UE.ui.Button({
        name: '插入图片',
        title: '插入图片',
        cssRules: 'background-position: -726px -77px',
        onclick: function() {
            editor.execCommand(uiName);
        }
    });
    editor.addListener('selectionchange',
    function() {
        var state = editor.queryCommandState(uiName);
        if (state == -1) {
            btn.setDisabled(true);
            btn.setChecked(false);
        } else {
            btn.setDisabled(false);
            btn.setChecked(state);
        }
    });
    return btn;
},
19);

$(function(){
     $('.app-mod-8-main-img img').each(function(){
         $(this).height($(this).width());    
     });
     $('.app-mod-12 img').each(function(){
         $(this).height($(this).width());    
     });
     $('.app-mod-cube table  tr').each(function(){
     	if( $(this).children().length<=0){
     		$(this).html('<td></td>');
     	}
     });
	
});
	
	//传参
	var pageparams = {
		basicparams : <?php  echo $page['basicparams'];?>,
		params : <?php echo empty($page['params'])?'[]':$page['params']?>,
		pagename : "<?php  echo $page['pagename'];?>",
		pagetype : "<?php  echo $page['type'];?>",
		pageid : "<?php  echo $_GET['id'];?>"
	};
	
</script>
<script type="text/javascript" src="../addons/zofui_groupshop/template/web/js/custom.js"></script>
</form>	

<?php  } else if($op == 'list') { ?>

	<div class="list_body">
		<div class="list_top">
			
		</div>
		<div class="list_table good_list">
<form action="" method="post">
				<table class="table table-hover">
					<thead>
						<tr>
							<th class="col-sm-1">
								<label class="my_checkbox">
								<input class="" type="checkbox" name="" onclick="var ck = this.checked;$('.goodid_check input').each(function(){this.checked = ck});"> 全选/取消
								</label>
							</th>
							<th class="col-sm-1">备注名称</th>
							<th class="col-sm-2">页面标题</th>
							<th class="col-sm-1">类型</th>
							<th class="col-sm-1">是否首页</th>
							<th class="col-sm-2">最近修改</th>
							<th class="col-sm-2">操作</th>
						</tr>
					</thead>
					<tbody>
						<?php  if(is_array($list)) { foreach($list as $li) { ?>
						<tr>
							<td class="">
								<label class="my_checkbox goodid_check">
									<input type="checkbox" name="checkid[]" value="<?php  echo $li['id'];?>" class=""> <?php  echo $li['id'];?>
								</label>
							</td>
							<td>
								<?php  echo $li['pagename'];?>
							</td>
							<td>
								<?php  echo $li['pagetitle'];?>
							</td>							
							<td>
								<?php  if($li['type'] == 1) { ?>
									综合页面
								<?php  } else { ?>
									无
								<?php  } ?>
							</td>
							<td>
								<?php  if($li['status'] == 0) { ?><span class="font_ff5f27">用做首页</span><?php  } else { ?>未做首页<?php  } ?>
							</td>
							<td class="font_13px_999">
								<?php  echo date('Y-m-d H:i:s',$li['time'])?>							
							</td>
							<td style="position:relative">
								<a href="javascript:;" class="a_href copy_url" data-href="<?php echo $_W['siteroot'].'app/index.php?i='.$_W['uniacid'].'&c=entry&do=index&id='.$li['id'].'&m=zofui_groupshop'?>">复制链接</a>&nbsp;
								<a href="<?php  echo $this->createWebUrl('custom',array('op'=>'toindex','id'=>$li['id']))?>" class="a_href">设为首页</a>&nbsp;
								<a href="<?php  echo $this->createWebUrl('custom',array('op'=>'edit','id'=>$li['id']))?>" class="a_href">编辑</a>&nbsp;
								<a href="<?php  echo $this->createWebUrl('custom',array('op'=>'delete','id'=>$li['id']))?>" class="a_href" onclick="return confirm('删除后不可恢复，确定要删除吗？');">删除</a>
							</td>
						</tr>
						<?php  } } ?>						
					</tbody>
				</table>		
		</div>		
		<div class="list_bottom item_cell_box good_list good_list_bot">
			<div class="item_cell_flex">
				<label class="">
					<input class="" type="checkbox" name="" onclick="var ck = this.checked;$('.goodid_check input').each(function(){this.checked = ck});"> 全选/取消
				</label>&nbsp;&nbsp;&nbsp;
				<input type="submit" name="delete" class="btn_44b549" value="删除所选" onclick="return confirm('删除后不可恢复，确定要删除吗？');">
				<input name="token" type="hidden" value="<?php  echo $_W['token'];?>" />
			</div>
			<div class=""><?php  echo $pager;?></div>
		</div>
</div>			
	</div>

	<script src="../addons/zofui_groupshop/template/web/js/fsjs.js"></script>
<?php  } ?>
</div>

<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/footer', TEMPLATE_INCLUDEPATH)) : (include template('common/footer', TEMPLATE_INCLUDEPATH));?>

