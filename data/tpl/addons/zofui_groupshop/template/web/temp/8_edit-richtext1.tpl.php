<?php defined('IN_IA') or exit('Access Denied');?><div class="help-block">设置富文本</div>

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
	<div class="ueditor" ng-model="Edit.content" style="height:400px; width:100%; margin-top:10px;"></div>


