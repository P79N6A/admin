<?php defined('IN_IA') or exit('Access Denied');?><div class="app-panel-editor-title">设置公告</div>

	<div class="input_item item_cell_box">
		<div class="input_title">显示条数</div>
		<div class="input_form radio_form item_cell_flex">
			<label style="cursor:pointer; margin-right: 10px;"><input type="radio" name="{{Edit.id}}_shownum" value="1" ng-model="Edit.params.shownum" /> 一条</label>
			<label style="cursor:pointer; margin-right: 10px;"><input type="radio" name="{{Edit.id}}_shownum" value="2" ng-model="Edit.params.shownum" /> 两条</label>
		</div>
	</div>
	<div class="input_item item_cell_box">
		<div class="input_title">左边图片</div>
		<div class="input_form item_cell_flex">
			<div class="item_cell_box">
			<div class="app-panel-editor-upload" ng-click="pageImg(Edit.id, 'imgurl')" style="height:50px; width: 50px;">
				<img ng-src="{{Edit.params.imgurl}}" width="100%;" />
				<div class="app-panel-editor-upload-choose2" ng-show="Edit.params.imgurl">修改</div>
				<div class="app-panel-editor-upload-choose1" ng-show="!Edit.params.imgurl" style="line-height:50px;"><i class="fa fa-plus-circle"></i></div>
			</div>
			<div class="item_cell_flex">
				<label style="cursor:pointer; margin-left: 10px;">
				<input type="radio" name="{{Edit.id}}_kefuimg" value="right" ng-click="Edit.params.imgurl = '../addons/zofui_groupshop/public/images/notice.jpg'" /> 使用默认图标</label>
			</div>
			</div>
		</div>
	</div>	
	
	<div class="input_item item_cell_box">
		<div class="input_title">文字颜色</div>
		<div class="input_form item_cell_flex">
			<span class="input_box input_box_50">
				<input class="input_input" type="color" ng-model="Edit.params.color" />
			</span>	
			<span class="input_box input_box_100">
				<input class="input_input" type="text" ng-model="Edit.params.color" />
			</span>
		</div>
	</div>		
	<div class="input_item item_cell_box">
		<div class="input_title">背景颜色</div>
		<div class="input_form item_cell_flex">
			<span class="input_box input_box_50">
				<input class="input_input" type="color" ng-model="Edit.params.bgcolor" />
			</span>	
			<span class="input_box input_box_100">
				<input class="input_input" type="text" ng-model="Edit.params.bgcolor" />
			</span>
		</div>
	</div>	
	<div class="input_item item_cell_box" ng-show="Edit.params.shownum == 2">
		<div class="input_title">分割线颜色</div>
		<div class="input_form item_cell_flex">
			<span class="input_box input_box_50">
				<input class="input_input" type="color" ng-model="Edit.params.bottomcolor" />
			</span>	
			<span class="input_box input_box_100">
				<input class="input_input" type="text" ng-model="Edit.params.bottomcolor" />
			</span>
		</div>
	</div>	
	<div class="input_item item_cell_box" style="margin-top: 10px;">
		<div class="input_title">滚动间隔</div>
		<div class="input_form item_cell_flex">
			<div class="item_cell_box slider_box">
				<div class="slider input_box_200 margin_top_10px" data-value="{{Edit.params.timer}}" data-id="{{Edit.id}}" data-name="timer" data-max="10" data-min="1">
				</div>
				<div class="item_cell_flex font_13px_999 slider_font">  {{Edit.params.timer}}(秒)</div>
			</div>	
		</div>
	</div>  	
	
	
<div ng-repeat="notice in Edit.data">
    <div class="row" style="margin-top: 10px;background: #f3f4f9;padding: 10px 0;position:relative">
		<div class="app-panel-editor-del" title="删除" ng-click="delItemChild(Edit.id, notice.id)">×</div>

		<div class=" item_cell_box margin_top_5px" style="background:#f3f4f9">
			<div class="input_title">标题</div>
			<div class="input_form item_cell_flex">
				<span class="input_box input_box_400">
					<input type="text" class="input_input" ng-model="notice.title" placeholder="">
				</span>			
			</div>
		</div> 			
		<div class=" item_cell_box margin_top_5px">
			<div class="input_title">链接</div>
			<div class="input_form item_cell_flex">
				<div ng-my-linker ng-my-url="notice.url" class="input_box_400"></div>		
			</div>
		</div>
    </div>
</div>
<div class="app-panel-editor-sub1" ng-click="addItemChild('notice', Edit.id)"><i class="fa fa-plus-circle"></i> 添加公告</div>	
  