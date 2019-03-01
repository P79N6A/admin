<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/header', TEMPLATE_INCLUDEPATH)) : (include template('common/header', TEMPLATE_INCLUDEPATH));?>
<ul class="nav nav-tabs">
	<li <?php  if($op == 'display') { ?> class="active" <?php  } ?>><a href="<?php  echo $this->createWebUrl('lottery',array('op'=>'display'))?>">期数列表</a></li>
	<li <?php  if($op == 'add') { ?>class="active"<?php  } ?>><a href="<?php  echo $this->createWebUrl('lottery',array('op'=>'add'))?>">添加</a></li>
	<li <?php  if($op == 'edit') { ?>class="active"<?php  } ?><?php  if($op != 'edit') { ?>style="display:none"<?php  } ?>><a href="<?php  echo $this->createWebUrl('lottery',array('op'=>'edit'))?>">编辑</a></li>
	<li <?php  if($op == 'lottery_number') { ?>class="active"<?php  } ?><?php  if($op != 'lottery_number') { ?>style="display:none"<?php  } ?>><a href="javascript:;">号码设置</a></li>

</ul>
<?php  if($op == 'lottery_number') { ?>

<script language="javascript">  
function sumbit_sure(){  
	var gnl=confirm("您确认要提交吗？一旦提交不能修改");  
	if (gnl==true){  
		return true;  
	}else{  
		return false;  
	}  
}  
</script>  

<div class="panel panel-info">
		<div class="panel-body">
			<form action="<?php  echo $this->createWebUrl('lottery',array('op'=>'lottery_number','type'=>1))?>" method="post"  onsubmit="return sumbit_sure()"  class="form-horizontal" role="form">
			<input type="hidden" name="id" value="<?php  echo $period_id;?>">
				<div class="form-group">
					<label class="col-xs-4 col-sm-4 col-md-4 col-lg-1 control-label">一等奖</label>
					<div class="col-xs-8 col-sm-8 col-md-8 col-lg-11">
						<input  class="form-control"  name="first_no" id='first_no' type="text" value="<?php  echo $item['first_no'];?>" placeholder="一等奖"  >
					</div>
				</div>
				<div class="form-group">
					<label class="col-xs-4 col-sm-4 col-md-4 col-lg-1 control-label">二等奖</label>
					<div class="col-xs-8 col-sm-8 col-md-8 col-lg-11">
						<input  class="form-control"  name="second_no" id='second_no' type="text" value="<?php  echo $item['second_no'];?>" placeholder="二等奖"  >
					</div>
				</div>

				<div class="form-group">
					<label class="col-xs-4 col-sm-4 col-md-4 col-lg-1 control-label">三等奖</label>
					<div class="col-xs-8 col-sm-8 col-md-8 col-lg-11">
						<input  class="form-control"  name="third_no" id='third_no' type="text" value="<?php  echo $item['third_no'];?>" placeholder="三等奖"  >
					</div>
				</div>


				<div class="form-group">
					<label class="col-xs-4 col-sm-4 col-md-4 col-lg-1 control-label">特等奖</label>
					<div class="col-xs-8 col-sm-8 col-md-8 col-lg-11">
						<div class="row col-lg-12">
							<?php  if(is_array($special_no)) { foreach($special_no as $sno) { ?>
							<div class="col-xs-2 col-sm-2 col-md-2 col-lg-2 form-group">
								<input class="form-control"  name="special_no[]"   type="text" value="<?php  echo $sno;?>" placeholder="特等奖">
                                <!--
                                <button type="button" name ="first_no_btn" style=" width:12px;" class="btn btn-primary">1</button>
                                <button type="button" name ="second_no_btn" style=" width:12px;" class="btn btn-success">2</button>
                                <button type="button" name ="third_no_btn" style=" width:12px;" class="btn btn-danger">3</button>
                                -->
							</div>
							<?php  } } ?>
						</div>
					</div>
				</div>

				<div class="form-group">
					<label class="col-xs-4 col-sm-4 col-md-4 col-lg-1 control-label">安慰奖</label>
					<div class="col-xs-8 col-sm-8 col-md-8 col-lg-11">
						<div class="row col-lg-12">
							<?php  if(is_array($consolation_no)) { foreach($consolation_no as $cno) { ?>
							<div class="col-xs-2 col-sm-2 col-md-2 col-lg-2 form-group">
								<input class="form-control"  name="consolation_no[]"   type="text" value="<?php  echo $cno;?>" placeholder="安慰奖">
							</div>
							<?php  } } ?>
						</div>
					</div>
				</div>

				<div class="form-group">
					<div class="col-xs-4 col-md-4 col-md-offset-4">
						<button type="submit" class="btn btn-primary" name="submit" id='summit_info' value="提交">开奖</button>
						<input type="hidden" name="token" value="<?php  echo $_W['token'];?>" />
					</div>

				</div>


			</form>
	</div>
</div>
<script>

function WidthCheck(strObj, maxLen){ 
	var w = 0; 
	//length 获取字数数，不区分汉子和英文 
	
	var newStr = '';
	for (var i=0; i<strObj.val().length; i++) { 
	//charCodeAt()获取字符串中某一个字符的编码 
		var c = strObj.val()[i];
		
	   //单字节加1 
		if (c >= 0 && c <= 9 && c!= ' ') { 
			 newStr +=c;
		}
		
		if( c == '-'){
			newStr +=c;
		}
		//alert(newStr);
		if (newStr.length >= maxLen) { 
			break; 
		} 
	} 
	
	 strObj.val( newStr );
} 
$('.form-control').on('input propertychange', function() {
    //alert($(this).val().length + ' characters');
	
	
	
		  $("input[name^='consolation_no']").each(function(i, el) {

			WidthCheck( $(this), 4);
			
		  });

		  $("input[name^='special_no']").each(function(i, el) {
			WidthCheck( $(this), 4);
		  });
		  
		WidthCheck( $('#first_no'), 4);
		WidthCheck( $('#second_no'), 4);
		WidthCheck( $('#third_no'), 4);

	if( $(this).val().length == 4 ){
		//获取安慰奖
	
		  consolation_no = {};
		  $("input[name^='consolation_no']").each(function(i, el) {
			consolation_no[i] =$(this).val();
			
		  });
		
		//获取特等奖
		
		  special_no = {};
		  $("input[name^='special_no']").each(function(i, el) {
			 special_no[i] =$(this).val();
			WidthCheck( $(this), 4);
		  });
		//获取一、二、三等奖
		first_no = $('#first_no').val();
		second_no = $('#second_no').val();
		third_no = $('#third_no').val();

		
		$.post("<?php  echo $this->createWebUrl('lottery',array('op'=>'send_lottery_Info'))?>",
		{period_id:'<?php  echo $period_id;?>',first_no:first_no,second_no:second_no,third_no:third_no,special_no:special_no,consolation_no:consolation_no},
		function(result){
   			//$("span").html(result);
			//var obj = JSON.parse(result);
			//console.log(result);
			//alert( obj.msg);
  		});
	}
});

 </script>
<?php  } ?>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/footer', TEMPLATE_INCLUDEPATH)) : (include template('common/footer', TEMPLATE_INCLUDEPATH));?>