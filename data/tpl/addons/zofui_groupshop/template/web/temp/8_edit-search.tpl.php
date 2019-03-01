<?php defined('IN_IA') or exit('Access Denied');?><div class="app-panel-editor-title">设置搜索框</div>
	<div class="input_item item_cell_box">
		<div class="input_title">提示文字</div>
		<div class="input_form item_cell_flex">
			<span class="input_box input_box_300">
				<input type="text" class="input_input" ng-model="Edit.params.placeholder" placeholder="搜索框提示文字">
			</span>			
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

	<div class="input_item item_cell_box" style="margin-top: 10px;">
		<div class="input_title">输入框圆角</div>
		<div class="input_form item_cell_flex">
			<div class="item_cell_box slider_box">
				<div class="slider input_box_200 margin_top_10px" data-value="{{Edit.params.border}}" data-id="{{Edit.id}}" data-name="border" data-max="10" data-min="0">
				</div>
				<div class="item_cell_flex font_13px_999 slider_font">  {{Edit.params.border}}(像素)</div>
			</div>
		</div>
	</div> 	
	
	<div class="input_item item_cell_box" style="margin-top: 10px;">
		<div class="input_title">上下边距</div>
		<div class="input_form item_cell_flex">
			<div class="item_cell_box slider_box">
				<div class="slider input_box_200 margin_top_10px" data-value="{{Edit.params.padding}}" data-id="{{Edit.id}}" data-name="padding" data-max="50" data-min="0">
				</div>
				<div class="item_cell_flex font_13px_999 slider_font">  {{Edit.params.padding}}(像素)</div>
			</div>
		</div>
	</div> 	
	