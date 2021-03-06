<?php defined('IN_IA') or exit('Access Denied');?><div class="app-panel-editor-title">设置标题</div>


	<div class="input_item item_cell_box">
		<div class="input_title">主标题</div>
		<div class="input_form item_cell_flex">
			<span class="input_box input_box_300">
				<input type="text" class="input_input" ng-model="Edit.params.title1" placeholder="请输入主标题内容">
			</span>			
		</div>
	</div> 
 
 	<div class="input_item item_cell_box">
		<div class="input_title">链接</div>
		<div class="input_form item_cell_flex">
			<div ng-my-linker ng-my-url="Edit.params.titlehref" class="input_box_300"></div>		
		</div>
	</div> 

	<div class="input_item item_cell_box" style="margin-top: 10px;">
		<div class="input_title">上线边距</div>
		<div class="input_form item_cell_flex ">
			<div class="item_cell_box slider_box">
				<div class="slider input_box_200 margin_top_10px" data-value="{{Edit.params.paddingsize}}" data-id="{{Edit.id}}" data-name="paddingsize" data-max="50" data-min="1">
				</div>
				<div class="item_cell_flex font_13px_999 slider_font">  {{Edit.params.paddingsize}}(像素)</div>
			</div>	
		</div>
	</div> 	
	
	<div class="input_item item_cell_box" style="margin-top: 10px;">
		<div class="input_title">主标题大小</div>
		<div class="input_form item_cell_flex ">
			<div class="item_cell_box slider_box">
				<div class="slider input_box_200 margin_top_10px" data-value="{{Edit.params.fontsize1}}" data-id="{{Edit.id}}" data-name="fontsize1" data-max="100" data-min="1">
				</div>
				<div class="item_cell_flex font_13px_999 slider_font">  {{Edit.params.fontsize1}}(像素)</div>
			</div>	
		</div>
	</div> 
	
	<div class="input_item item_cell_box">
		<div class="input_title">副标题</div>
		<div class="input_form radio_form item_cell_flex">
			<label style="cursor:pointer; margin-right: 10px;"><input type="radio" name="{{Edit.id}}_showtitle2" value="1" ng-model="Edit.params.showtitle2" /> 显示</label>
			<label style="cursor:pointer; margin-right: 10px;"><input type="radio" name="{{Edit.id}}_showtitle2" value="0" ng-model="Edit.params.showtitle2" /> 不显示</label>
		</div>
	</div> 	

	<div class="input_item item_cell_box">
		<div class="input_title">左边图标</div>
		<div class="input_form radio_form item_cell_flex">
			<label style="cursor:pointer; margin-right: 10px;"><input type="radio" name="{{Edit.id}}_incoshow" value="1" ng-model="Edit.params.incoshow" /> 显示</label>
			<label style="cursor:pointer; margin-right: 10px;"><input type="radio" name="{{Edit.id}}_incoshow" value="0" ng-model="Edit.params.incoshow" /> 不显示</label>
		</div>
	</div> 
	
	<div class="input_item item_cell_box" ng-show="Edit.params.incoshow == 1">
		<div class="input_title">图标</div>
		<div class="input_form item_cell_flex">
			<div class="app-panel-editor-upload" ng-click="pageImg(Edit.id, 'inco')" style="width: 50px;height: 50px;">
				<img ng-src="{{Edit.params.inco}}" style="width:100%;height:50px" />
				<div class="app-panel-editor-upload-choose2" ng-show="Edit.params.inco">修改</div>
				<div class="app-panel-editor-upload-choose1" ng-show="!Edit.params.inco" ><i class="fa fa-plus-circle"></i></div>			
			</div>
		</div>
	</div>  
  
	<div class="input_item item_cell_box" ng-show="Edit.params.incoshow == 1" style="margin-top: 10px;">
		<div class="input_title">图标高度</div>
		<div class="input_form item_cell_flex ">
			<div class="item_cell_box slider_box">
				<div class="slider input_box_200 margin_top_10px" data-value="{{Edit.params.incoheight}}" data-id="{{Edit.id}}" data-name="incoheight" data-max="100" data-min="10">
				</div>
				<div class="item_cell_flex font_13px_999 slider_font">  {{Edit.params.incoheight}}(像素)</div>
			</div>	
		</div>
	</div> 
  
	<div class="input_item item_cell_box" ng-show="Edit.params.showtitle2 == 1">
		<div class="input_title">副标题</div>
		<div class="input_form item_cell_flex">
			<span class="input_box input_box_300">
				<input type="text" class="input_input" ng-model="Edit.params.title2" placeholder="请输入副标题内容">
			</span>			
		</div>
	</div>    
  
	<div class="input_item item_cell_box" ng-show="Edit.params.showtitle2 == 1" style="margin-top: 10px;">
		<div class="input_title">副标题大小</div>
		<div class="input_form item_cell_flex ">
			<div class="item_cell_box slider_box">
				<div class="slider input_box_200 margin_top_10px" data-value="{{Edit.params.fontsize2}}" data-id="{{Edit.id}}" data-name="fontsize2" data-max="50" data-min="1">
				</div>
				<div class="item_cell_flex font_13px_999 slider_font">  {{Edit.params.fontsize2}}(像素)</div>
			</div>	
		</div>
	</div> 
	
	
	<div class="input_item item_cell_box">
		<div class="input_title">对齐方向</div>
		<div class="input_form radio_form item_cell_flex">
			<label style="cursor:pointer; margin-right: 10px;"><input type="radio" name="{{Edit.id}}_align" value="left" ng-model="Edit.params.align" /> 居左</label>
			<label style="cursor:pointer; margin-right: 10px;"><input type="radio" name="{{Edit.id}}_align" value="center" ng-model="Edit.params.align" /> 居中</label>
			<label style="cursor:pointer; margin-right: 10px;"><input type="radio" name="{{Edit.id}}_align" value="right" ng-model="Edit.params.align" /> 居右</label>
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
  
