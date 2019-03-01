<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('header', TEMPLATE_INCLUDEPATH)) : (include template('header', TEMPLATE_INCLUDEPATH));?>

<?php  if($op == 'display') { ?>
<div class="content-header content-content">
	<div class="input-group">

	 	<input type="text" class="form-control" placeholder="请输入关键字进行搜索" aria-describedby="basic-addon2">
	  	<span class="input-group-addon" id="basic-addon2">
	  		<span><div class="line-span-div"></div></span>
	  		<img src="./resource/images/distribution_user/icon_ser.png" alt="" class="ser-margin">
	  	</span>
	</div>

	<div class="input-group input-group2">
	  <input type="text" class="form-control" placeholder="请输入专属客服姓名进行搜索" aria-describedby="basic-addon2">
	  <span class="input-group-addon" id="basic-addon3">
	  	<span><div class="line-span-div"></div></span>
	  	<img src="./resource/images/distribution_user/icon_ser.png" alt="" class="ser-margin">
	  </span>
	</div>

	<div class="input-group3">
		  <div class="div">新建</div>
		  <div class="div2">删除</div>
		  <div class="clear"></div>
	</div>
	<div class="clear"></div>
</div>

<div class="content-search content-content">

		<div class="input-group input-group4">
		 	<input type="button" class="form-control form-control-i" aria-describedby="basic-addon2" value="请选择客户性别" data="0">
		  	<span class="input-group-addon input-group-addon2">
		  		<img src="./resource/images/distribution_user/icon_arrow_right2.png" alt="">
		  	</span>
		  	<ul data_s='1' class="content-i-ul">
		  		<li data_s='1' d="1">
		  			<span class="input-group-i4">
						<span><div class="line-span-div"></div></span>
		  				<img src="./resource/images/distribution_user/icon_ensure_blue.png" alt="">
		  			</span>
		  			<span class="input-group-c4">全部</span>
		  		</li>
		  		<li data_s='2' d="1">
		  			<span class="input-group-c5">男</span>
		  		</li>
		  		<li data_s="3" d="1">
		  			<span class="input-group-c5">女</span>
		  		</li>
		  	</ul>
		</div>

		<div class="input-group input-group5">
		 	<input type="button" class="form-control form-control-i" aria-describedby="basic-addon2" value="请选择客户类型" data="0">
		  	<span class="input-group-addon input-group-addon2">
		  		<img src="./resource/images/distribution_user/icon_arrow_right2.png" alt="">
		  	</span>
		  	<ul data_l='1' class="content-i-ul">
		  		<li data_l='1' d="2">
		  			<span class="input-group-i4">
		  				<span><div class="line-span-div"></div></span>
		  				<img src="./resource/images/distribution_user/icon_ensure_blue.png" alt="">
		  			</span>
		  			<span class="input-group-c4">全部</span>
		  		</li>
		  		<li data_l='1' d="2">
		  			<span class="input-group-c5">钻石客户</span>
		  		</li>
		  		<li data_l="2" d="2">
		  			<span class="input-group-c5">黄金客户</span>
		  		</li>
		  		<li data_l="3" d="2">
		  			<span class="input-group-c5">VIP</span>
		  		</li>
		  	</ul>
		</div>

		<div class="input-group6">
			<span class="group6-span">年龄：</span>
			<input type="text"	class="input-years" value="0">
			<span class="group6-span">-</span>
			<input type="text"	class="input-years" value="100">
		</div>

		<div class="input-group7">
			<button type="button" class="btn-danger-1">查询</button>
			<button type="button" class="btn-danger-2">清空</button>
		</div>
		<div class="clear"></div>
</div>

<div class="content-div-table">
	<table>
		<tr style="background: #f8f8f8;border:2px solid #e6e6e6;border-left:0px solid #fff;border-right:0px solid #fff;">
			<th style="width:50px;">选择<?php  echo $a;?></th>
			<th style="width:80px;">编号</th>
			<th style="width:260px;">公司</th>
			<th style="width:85px;">客户</th>
			<th style="width:140px;">客户联系方式</th>
			<th style="width:85px;">专属客服</th>
			<th style="width:160px;">创建时间</th>
			<th>操作</th>
		</tr>

		<tr class="content-table-tr">
			<td><input type="checkbox" class="checkbox-tr-td" data-check='0'></td>
			<td>KG-4562</td>
			<td>广州市水立方籍罗斯福顺丰到付</td>
			<td>欧阳纠结</td>
			<td>18538521111</td>
			<td>科技两份</td>
			<td>2018-10-02 10:20</td>
			<td>8888888888</td>
		</tr>

		<tr class="content-table-tr">
			<input type="hidden" value="1">
			<td><input type="checkbox" class="checkbox-tr-td" data-check='0'></td>
			<td>KG-4562</td>
			<td>广州市水立方籍罗斯福顺丰到付</td>
			<td>欧阳纠结</td>
			<td>18538521111</td>
			<td>科技两份</td>
			<td>2018-10-02 10:20</td>
			<td>8888888888</td>
		</tr>
	</table>
</div>

<?php  } else if('op'=='detail') { ?>
<div><?php  echo $id;?></div>
<?php  } ?>
<script>
	$(function(){
		$('.content-table-tr').click(function(){
			alert(1);
		});
		//点击单选按钮
		$('.checkbox-tr-td').click(function(event){
			var check_ed=$(this).attr('data-check');
			if(check_ed == '0'){
				$(this).attr('data-check','1');
				$(this).parent().parent().addClass('conetent-tr-td-i');
			}else{
				$(this).attr('data-check','0');
				$(this).parent().parent().removeClass('conetent-tr-td-i');
			}
			event.stopPropagation(); 
		});
	
		//选择客户性别，选择客户类型
		$('.content-i-ul li').click(function(){
			var li_this=$(this);
			var d=li_this.attr('d');
			var span_html='<span class="input-group-i4">'+'<img src="./resource/images/distribution_user/icon_ensure_blue.png" alt="">'+'</span>';
	
			li_this.parent().find('li .input-group-i4').remove();
			li_this.parent().find('li span').removeClass('input-group-c4,input-group-c5');
			li_this.parent().find('li span').addClass('input-group-c5');
			li_this.prepend(span_html);
	
			li_this.find('span').last().removeClass('input-group-c5');
			li_this.find('span').last().addClass('input-group-c4');
			li_this.parent().parent().find('input').val(li_this.find('span').last().text());
			li_this.parent().attr('data_s',data_d);
			if(d==1){
				var data_d=li_this.attr('data_s');
				
				$('ul[data_l]').hide();
				$('ul[data_l]').parent().find('input').attr('data','0');
				li_this.parent().hide();
	
			}if(d==2){
				var data_d=li_this.attr('data_l');
	
				$('ul[data_s]').hide();
				$('ul[data_s]').parent().find('input').attr('data','0');
				li_this.parent().hide();
				
			}
			li_this.parent().parent().find('input').attr('data','0');
			li_this.parent().parent().find('.input-group-addon img').attr('src','./resource/images/distribution_user/icon_arrow_right2.png');
	
		});
		//选择客户性别、选择客户类型，显示和隐藏
		function slideTo(obj,i_data){
			if(i_data==0){
				obj.parent().find('ul').show();
				obj.attr('data','1');
				obj.next().find('img').attr('src','./resource/images/distribution_user/icon_arrow_down2.png');
			}else{
				obj.parent().find('ul').hide();
				obj.attr('data','0');
				obj.next().find('img').attr('src','./resource/images/distribution_user/icon_arrow_right2.png');
			}
		}
		//触发显示和隐藏
		$('.form-control-i').click(function(){
			var i_data=$(this).attr('data');
			var that=$(this);
			slideTo(that,i_data);
		});
		//触发显示和隐藏
		$('.input-group-addon2').click(function(){
			var i_data=$(this).prev().attr('data');
			var that=$(this).prev();
			slideTo(that,i_data);
		});

	});
	</script>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('footer', TEMPLATE_INCLUDEPATH)) : (include template('footer', TEMPLATE_INCLUDEPATH));?>
