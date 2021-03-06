<?php defined('IN_IA') or exit('Access Denied');?><div class="app-panel-editor-title">幻灯片设置<span class="tips">请保持图片大小一致</span></div>

	<div class="input_item item_cell_box">
		<div class="input_title">按钮形状</div>
		<div class="input_form radio_form item_cell_flex">
			<label style="cursor:pointer; margin-right: 10px;"><input type="radio" name="{{Edit.id}}_style" value="shape2" ng-model="Edit.params.shape"> 正方形</label>
			<label style="cursor:pointer; margin-right: 10px;"><input type="radio" name="{{Edit.id}}_style" value="shape3" ng-model="Edit.params.shape"> 圆形</label>
		</div>
	</div> 
	
	<div class="input_item item_cell_box">
		<div class="input_title">按钮位置</div>
		<div class="input_form radio_form item_cell_flex">
			<label style="cursor:pointer; margin-right: 10px;"><input type="radio" name="{{Edit.id}}_align" value="left" ng-model="Edit.params.align"> 居左</label>
			<label style="cursor:pointer; margin-right: 10px;"><input type="radio" name="{{Edit.id}}_align" value="center" ng-model="Edit.params.align"> 居中</label>
			<label style="cursor:pointer; margin-right: 10px;"><input type="radio" name="{{Edit.id}}_align" value="right" ng-model="Edit.params.align"> 居右</label>
		</div>
	</div> 
	
	<div class="input_item item_cell_box">
		<div class="input_title">按钮颜色</div>
		<div class="input_form item_cell_flex">
			<span class="input_box input_box_50">
				<input class="input_input" type="color" ng-model="Edit.params.color" />
				
			</span>	
			<span class="input_box input_box_100">
				<input class="input_input" type="text" ng-model="Edit.params.color" />
			</span>
		</div>
	</div>
	
	
	<div class="input_item slide_item" ng-repeat="banner in Edit.data">
		<div class="input_form item_cell_flex">
			<div class="app-panel-editor-del" title="删除" ng-click="delItemChild(Edit.id, banner.id)">×</div>
			<div class="row">
				<div class="col-xs-3" ng-click="uploadImgChild(Edit.id, banner.id)">
					<img ng-src="{{banner.imgurl}}" width="100%" ng-show="banner.imgurl" />
					<div class="app-panel-editor-goodimg-t1" ng-show="!banner.imgurl"><i class="fa fa-plus-circle"></i> 选择图片</div>
					<div class="app-panel-editor-goodimg-t2" ng-show="banner.imgurl">重新选择图片</div>				
				</div>
				<div class="col-xs-9">
					<div class="form-group">
						<div class="form-control-static ">
							<div ng-my-linker ng-my-url="banner.hrefurl" ></div>
						</div>
					</div>
					
				</div>
			</div>			
			
		</div>
	</div>	
	<div class="app-panel-editor-sub1" ng-click="addItemChild('banner', Edit.id)"><i class="fa fa-plus-circle"></i> 添加图片</div>
	