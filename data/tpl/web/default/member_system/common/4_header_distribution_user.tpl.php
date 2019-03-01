<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/header-base', TEMPLATE_INCLUDEPATH)) : (include template('common/header-base', TEMPLATE_INCLUDEPATH));?>
<style>
	*{
		font-family: MicrosoftYaHei;
	}
	.left-div{
		width: 50px;
		line-height: 50px;
		font-size: 14px;
		color:#0aa6ff;
		padding-left:15px;
	}
	.left-ul{
		margin-bottom: 0px;
	}
	.left-ul li{
		width: 40px;
		line-height: 40px;
		font-size: 14px;
		padding-left: 45px;
		cursor:pointer;
	}
	.left-div,.left-ul .left-ul-li-my{
		width: 100%;
		background: #c7ebff;
		border-bottom:1px solid #fff;
	}
	.left-ul li span{
		padding-left:10px;
	}
	.lili{
		color: #fff;
	}
	.left-div2 img{
		margin-left:110px;
	}
</style>
<style>
	.content-header{
	height: 30px; 
	margin-top:16px;
	margin-left:20px;
	}
	.input-group{
		width: 250px;
		/*padding:5px 0 5px 5px;*/
		border:1px solid #ddd;
		height: 30px;
	}
	.input-group span{
		width: 30px;
		background: #fff;
		border:0;
	}
	.form-control{
		padding:5px;
		width: 20px;
		height: 100%;
		border:0;
	
	}
	.content-header div{
		float:left;
	}
	.content-content{
		min-width: 100%;
	}
	.input-group2{
		margin-left:30px;
	}
	.input-group3{
		height: 30px;
	}
	.input-group3 button{
		height: 100%;
	}
	.clear{
		clear:both;
	}
	.input-group3 .div,.input-group3 .div2{
		height: 30px;
		width: 80px;
		line-height: 30px;
		text-align:center;
		border:1px solid #0aa6ff;
		cursor:pointer;
	}
	.input-group3 .div{
		color:#0aa6ff;
	}
	.input-group3 .div{
		border-right:0;
		background: #0aa6ff;
		color:#fff;
	}
	.input-group3{
		margin-left:250px;
	}
	.content-search{
		margin-top:14px;
		margin-left: 20px;
	}
	.input-group4{
		position:relative;
		width: 160px;
	}
	.content-search div{
		float:left;
	}
	.input-group5{
		margin-left:30px;
		width: 160px;
		position:relative;
	
	}
	.input-group-addon{
		cursor:pointer;
	}
	.input-years{
		width: 60px;
		height: 30px;
		line-height: 30px;
		padding-left:15px;
	}
	.input-group6{
		margin-left:30px;
	}
	.group6-span{
		color:#999;
	}
	.input-group6 input{
		border:1px solid #ddd;
		box-shadow:0 0 0 0 #fff;
		color:#999;
	}
	.input-group7{
		margin-top:6px;
		height: 20px;
		line-height: 20px;
		text-align:center;
	}
	.btn-danger-1{
		width: 60px;
		margin-left:30px;
		background: #0aa6ff;
		border:1px solid #0aa6ff;
		color:#fff;
		border-radius:2px;
	}
	.btn-danger-2{
		border-radius:2px;
	
		width: 60px;
		margin-left:10px;
		border:1px solid #0aa6ff;
		color:#0aa6ff;
		background: #fff;
	}
	.input-group4 ul,.input-group5 ul{
		width: 100%;
		position:absolute;
		background: #fdfeff;
		border:1px solid #b6e3fc;
		top:30px;
		left:0;
	}
	.input-group4 ul li,.input-group5 ul li{
		width: 100%;
		line-height: 32px;
		height: 32px;
		padding-left:30px;
		
	}
	.input-group-c4{
		margin-left: 15px;
	}
	.input-group-c5{
		margin-left: 35px;
	}
	.content-i-ul{
		display: none;
		z-index: 999;
	}
	.line-span-div{
		width:0;
		border:0;
		border-left:1px solid #ddd;
		height:20px;
	}
	.ser-margin{
		margin-left: 8px;
	}
	
	
	.right-content{
		padding:0;
	}
	.content-div-table{
		width: 100%;
		margin-top:65px;
	}
	.content-div-table table{
		width: 100%;
		
		border:1px solid #e6e6e6;
		border-left:0;
		border-right:0;
	}
	.content-div-table table tr,.content-div-table table tr th{
		border:1px solid #eee;
		border-left:0;
		border-right:0;
		text-align:center;
	}
	.content-div-table table tr th,.content-div-table table tr td{
		height: 30px;
		line-height: 30px;
	}
	.conetent-tr-td-i{
		background: #b6e3fc;
		border-top-color:#90d7ff;
	}
	.checkbox-tr-td{
		z-index: 999;
	}
	.content-table-tr{
		cursor:pointer;
	}
	.content-table-tr:hover{
		background: #b6e3fc;
		border-top-color:#90d7ff;
	}
	</style>
<?php  if(FRAME == 'system') { ?>
<?php  cache_build_frame_menu();?>
<?php  } ?>
<div data-skin="default" class="skin-default <?php  if($_GPC['main-lg']) { ?> main-lg-body <?php  } ?>">
<?php  $frames = buildframes(FRAME);_calc_current_frames($frames);?>
<div class="head">
	<nav class="navbar navbar-default" role="navigation">
		<div class="container <?php  if(!empty($frames['section']['platform_module_menu']['plugin_menu'])) { ?>plugin-head<?php  } ?>">
			<div class="navbar-header">
				<a class="navbar-brand" href="<?php  echo $_W['siteroot'];?>">
					<img src="<?php  if(!empty($_W['setting']['copyright']['blogo'])) { ?><?php  echo tomedia($_W['setting']['copyright']['blogo'])?><?php  } else { ?>./resource/images/logo/logo.png<?php  } ?>" class="pull-left" width="110px" height="35px">
					<span class="version hidden"><?php echo IMS_VERSION;?></span>
				</a>
			</div>
			<?php  if(!empty($_W['uid'])) { ?>
			<div class="collapse navbar-collapse">
				<ul class="nav navbar-nav navbar-left">
					<?php  global $top_nav?>
					<?php  if(is_array($top_nav)) { foreach($top_nav as $nav) { ?>
					<li<?php  if(FRAME == $nav['name']) { ?> class="active"<?php  } ?>><a href="<?php  if(empty($nav['url'])) { ?><?php  echo url('home/welcome/' . $nav['name']);?><?php  } else { ?><?php  echo $nav['url'];?><?php  } ?>" <?php  if(!empty($nav['blank'])) { ?>target="_blank"<?php  } ?>><?php  echo $nav['title'];?></a></li>
					<?php  } } ?>
				</ul>
				<ul class="nav navbar-nav navbar-right">
					<li class="dropdown">
						<a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown"><i class="wi wi-user color-gray"></i><?php  echo $_W['user']['username'];?> <span class="caret"></span></a>
						<ul class="dropdown-menu color-gray" role="menu">
							<li>
								<a href="<?php  echo url('user/profile');?>" target="_blank"><i class="wi wi-account color-gray"></i> 我的账号</a>
							</li>
							<?php  if($_W['isfounder']) { ?>
							<li class="divider"></li>
							<?php  if(uni_user_see_more_info(ACCOUNT_MANAGE_NAME_VICE_FOUNDER, false)) { ?>
							<li><a href="<?php  echo url('cloud/upgrade');?>" target="_blank"><i class="wi wi-update color-gray"></i> 自动更新</a></li>
							<?php  } ?>
							<li><a href="<?php  echo url('system/updatecache');?>" target="_blank"><i class="wi wi-cache color-gray"></i> 更新缓存</a></li>
							<li class="divider"></li>
							<?php  } ?>
							<li>
								<a href="<?php  echo url('user/logout');?>"><i class="fa fa-sign-out color-gray"></i> 退出系统</a>
							</li>
						</ul>
					</li>
				</ul>
			</div>
			<?php  } else { ?>
			<div class="collapse navbar-collapse">
				<ul class="nav navbar-nav navbar-right">
					<li class="dropdown"><a href="<?php  echo url('user/register');?>">注册</a></li>
					<li class="dropdown"><a href="<?php  echo url('user/login');?>">登录</a></li>
				</ul>
			</div>
			<?php  } ?>
		</div>
	</nav>
</div>
<?php  if(empty($_COOKIE['check_setmeal']) && !empty($_W['account']['endtime']) && ($_W['account']['endtime'] - TIMESTAMP < (6*86400))) { ?> 
<div class="system-tips we7-body-alert" id="setmeal-tips">
	<div class="container text-right">
		<div class="alert-info">
			<a href="<?php  if($_W['isfounder']) { ?><?php  echo url('user/edit', array('uid' => $_W['account']['uid']));?><?php  } else { ?>javascript:void(0);<?php  } ?>">
				该项目管理员服务有效期：<?php  echo date('Y-m-d', $_W['account']['starttime']);?> ~ <?php  echo date('Y-m-d', $_W['account']['endtime']);?>.
				<?php  if($_W['account']['endtime'] < TIMESTAMP) { ?>
				目前已到期，请联系管理员续费
				<?php  } else { ?>
				将在<?php  echo floor(($_W['account']['endtime'] - strtotime(date('Y-m-d')))/86400);?>天后到期，请及时付费
				<?php  } ?>
			</a>
			<span class="tips-close" onclick="check_setmeal_hide();"><i class="wi wi-error-sign"></i></span>
		</div>
	</div>
</div>
<script> 

	function check_setmeal_hide() {
		util.cookie.set('check_setmeal', 1, 1800);
		$('#setmeal-tips').hide();
		return false;
	}
</script>

<?php  } ?> 
<div class="main">

<div class="container">
	<a href="javascript:;" class="js-big-main button-to-big color-gray" title="加宽"><?php  if($_GPC['main-lg']) { ?>正常<?php  } else { ?>宽屏<?php  } ?></a>
	
	<div class="panel panel-content main-panel-content <?php  if(!empty($frames['section']['platform_module_menu']['plugin_menu'])) { ?>panel-content-plugin<?php  } ?>">
		<div class="content-head panel-heading main-panel-heading">
			<span style="margin-left:30px;"><img style="width:18px;" src="http://kake.gangbengkeji.cn/web/resource/images/distribution_user/icon_coustom.png" alt=""></span>
			<span style="font-size:17px;font-family:MicrosoftYaHei;margin-left:10px;">客户管理</span>

		</div>
	<div class="panel-body clearfix main-panel-body <?php  if(!empty($_W['setting']['copyright']['leftmenufixed'])) { ?>menu-fixed<?php  } ?>">
	<div class="left-menu">
			<div class="left-menu-content">
				<div class="left-div left-div2" data="0"> 
					<span>客户信息</span>
					<img src="./resource/images/distribution_user/icon_arrow_blue_down.png" alt="">
				</div>
				<ul class="left-ul">
					
						<li data="1" class="left-ul-li-my lili">
							<img src="./resource/images/distribution_user/icon_data1.png" alt="">
							<span>客户资料</span>

						</li>

					
						<!-- <li data="2" class="left-ul-li-my">
							<img src="./resource/images/distribution_user/icon_data2.png" alt="">
							<span>登陆资料</span>
						</li> -->
					

					<a href="http://kake.gangbengkeji.cn/web/index.php?c=site&a=entry&op=display&do=index&m=member_system">
						<li data="3" class="left-ul-li-my">
							<img src="./resource/images/distribution_user/icon_data3.png" alt="">
							<span>客户订单</span>
						</li>
					</a>

						<li data="4" class="left-ul-li-my">
							<img src="./resource/images/distribution_user/icon_data4.png" alt="">
							<span>客户流失</span>
						</li>
				
					
					
						<li data="5" class="left-ul-li-my">
							<img src="./resource/images/distribution_user/icon_data5.png" alt="">
							<span>客户类型</span>
						</li>
						
				</ul>
				
				<div class="left-div left-div2" data="0">
					<span>消息提醒</span>
					<img src="./resource/images/distribution_user/icon_arrow_blue_down.png" alt="">
				</div>
				<ul class="left-ul">
					
						
							<li data="6" class="left-ul-li-my">
								<img src="./resource/images/distribution_user/icon_data6.png" alt="">
								<span>短息提醒</span>
							</li>
						
					

					
						<li data="7" class="left-ul-li-my">
							<img src="./resource/images/distribution_user/icon_data7.png" alt="">
							<span>短信模板</span>
						</li>
					
				</ul>

				<div class="left-div" data="0">
					<span>历史记录</span>
				</div>
				<ul class="left-ul">
					
						<li data="8" class="left-ul-li-my">
							<img src="./resource/images/distribution_user/icon_data8.png" alt="">
							<span>操作记录</span>
						</li>
					
				</ul>
			</div>
	</div>	
	<script>
	
	$(function(){
		
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
	<div class="right-content">
		<script>
			$(function(){
				var a=$('.lili').attr('class');
				var data=$('.lili').attr('data');
				if(a == 'left-ul-li-my lili' && data == '1'){
					var b=$('.lili');
					b.css('background-color','#0aa6ff');
					var url='./resource/images/distribution_user/icon_d'+data+".png";

					b.find('img').attr('src',url);


					b.css('background-color','#0aa6ff');
				}

				$('.left-ul-li-my').click(function(){
					$('.left-ul-li-my').css('background','#c7ebff');
					$('.left-ul-li-my').css('color','#333');
					var that=$(this);

					$('.left-ul-li-my').each(function(){
						var t=$(this);
						var now_data=t.attr('data');
						var url2="./resource/images/distribution_user/icon_data"+now_data+".png";
						t.find('img').attr('src',url2);
					});
					that.css('background','#0aa6ff');
					that.css('color','#fff');
					var data2=that.attr('data');
					var url3="./resource/images/distribution_user/icon_d"+data2+".png";
					that.find('img').attr('src',url3);


				});

				$('.left-div2').click(function(){
					var data_div=$(this).attr('data');
					if(data_div == 0){
						$(this).next().slideUp();
						$(this).attr('data','1');
						$(this).find('img').attr('src',"./resource/images/distribution_user/icon_arrow_blue_right.png");
					}else{
						$(this).next().slideDown();
						$(this).attr('data','0');
						$(this).find('img').attr('src',"./resource/images/distribution_user/icon_arrow_blue_down.png");
					}
				});
			});

		</script>

