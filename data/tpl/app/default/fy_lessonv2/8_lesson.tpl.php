<?php defined('IN_IA') or exit('Access Denied');?><!-- 
 * 课程详情页
 * ============================================================================
 * 版权所有 2015-2017 风影随行，并保留所有权利。
 * 网站地址: http://www.haoshu888.com
 * ----------------------------------------------------------------------------
 * 这不是一个自由软件！不允许对程序代码以任何形式任何目的的再发布，作者将保留
 * 追究法律责任的权力和最终解释权。
-->
<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('_headerv2', TEMPLATE_INCLUDEPATH)) : (include template('_headerv2', TEMPLATE_INCLUDEPATH));?>
<link href="<?php echo MODULE_URL;?>template/mobile/style/cssv2/lesson.css?v=<?php  echo $versions;?>" rel="stylesheet" />
<style>
.fylesson_audio{width:90%; margin:0 auto 0 auto; padding:30px 0;}
.fylesson_audio p{padding:10px 0}
</style>

<?php  if(!empty($hisplayurl)) { ?>
<div class="follow_topbar">
	<div class="headimg"><img src="<?php  echo $avatar;?>"></div>
	<div class="info" style="height:20px;width:60%;overflow: hidden;">
		<div class="i">上次学习：</div>
		<div class="i">《<?php  echo $hissection['title'];?>》</div>
	</div>
	<div class="sub" style="background:#2691FC;" onclick="location.href='<?php  echo $hisplayurl;?>'">立即跳转</div>
</div>
<?php  } ?>
<?php  if($setting['isfollow']==1 && $member['follow']==0 && $userAgent) { ?>
<div class="follow_topbar" <?php  if(!empty($hisplayurl)) { ?>style="top:44px;"<?php  } ?>>
	<div class="headimg">
		<img src="<?php  echo $_W['attachurl'];?><?php  echo $setting['qrcode'];?>">
	</div>
	<div class="info">
		<div class="i"><?php  echo $_W['account']['name'];?></div>
		<div class="i"><?php  echo $setting['follow_word'];?></div>
	</div>
	<div class="sub" onclick="location.href='<?php  echo $this->createMobileUrl('follow');?>'">立即关注</div>
</div>
<?php  } ?>

<div class="content-inner">
	<div class="video-wrap clearfix">
		<div id="videoarea" style="position:relative;height: 55vw;">
		<?php  if($_GPC['sectionid']>0) { ?>
			<?php  if($section['sectiontype']==1) { ?>
				<?php  if($section['savetype']==2) { ?>
					<?php  echo htmlspecialchars_decode($section['videourl']);?>
				<?php  } else { ?>
				<video id="video" src="<?php  echo $section['videourl'];?>" width="100%" height="auto" controls="controls" autobuffer="autobuffer" <?php  if(!empty($poster)) { ?>poster="<?php  echo $_W['attachurl'];?><?php  echo $poster;?>"<?php  } ?>></video>
				<?php  } ?>
			<?php  } else if($section['sectiontype']==3) { ?>
			<link rel="stylesheet" href="<?php echo MODULE_URL;?>template/mobile/APlayer/APlayer.min.css">
			<script src="<?php echo MODULE_URL;?>template/mobile/APlayer/APlayer.min.js"></script>
			<div id="main">
				<div class="fylesson_audio">
					<div id="player" class="aplayer"></div>
				</div>
			</div>
			<script>
				var ap1 = new APlayer({
					element: document.getElementById('player'),
					narrow: false,
					autoplay: false,
					showlrc: false,
					music: {
						title: "<?php  echo $section['title'];?>",
						author: "",
						url: "<?php  echo $section['videourl'];?>",
						pic: "<?php echo $poster ? $_W['attachurl'].$poster : $_W['attachurl'].$lesson['images'];?>"
					}
				});
				ap1.init();	
			</script>
			<?php  } ?>
		<?php  } else { ?>
			<img src="<?php  echo $_W['attachurl'];?><?php  echo $lesson['images'];?>" alt="<?php  echo $lesson['bookname'];?>" height ="100%" style="margin: 0 auto;display: block;">
		<?php  } ?>
		</div>
	</div>
	<ul class="course-tab">
		<li <?php  if(empty($sectionid) && $setting['lesson_show']==0) { ?>class="curr"<?php  } ?>>详情</li>
		<li <?php  if($sectionid>0 || $setting['lesson_show']==1) { ?>class="curr"<?php  } ?>>目录</li>
		<li>评价(<?php  echo $total;?>)</li>
	</ul>
	<div class="course-container">
		<div class="js-tab"  style="transform-origin:0px 0px 0px;opacity:1;transform:scale(1,1); <?php  if($sectionid>0 || $setting['lesson_show']==1) { ?>display:none;<?php  } ?>">
			<ul class="course-intro">
				<li>
					<h2 class="chapter-title">课程信息</h2>
					<p class="course-intro-title">课程名称：<?php  echo $lesson['bookname'];?></p>
					<p class="course-intro-title">课程难度：<?php  echo $lesson['difficulty'];?></p>
					<?php  if(!empty($level_name)) { ?>
					<p class="course-intro-title">免费学习：开通<a href="<?php  echo $this->createMobileUrl('vip');?>" style="color:red;"><?php  echo $level_name;?></a>即可免费学习该课程</p>
					<?php  } ?>
					<?php  if($lesson['integral']>0) { ?>
					<p class="course-intro-title">赠送积分：<?php  echo $lesson['integral'];?> 积分</p>
					<?php  } ?>
					<?php  if($lesson['validity']>0) { ?>
					<p class="course-intro-title">有效期：<span style="color:red;">自购买日起<strong><?php  echo $lesson['validity'];?></strong>天内有效</span></p>
					<?php  } ?>
				</li>
				<li>
					<h2 class="chapter-title">课程介绍</h2>
					<div class="lesson-content">
						<?php  echo htmlspecialchars_decode($lesson['descript']);?>
					</div>
				</li>
				<li>
					<h2 class="chapter-title">讲师</h2>
					<p class="teacher-intro">
						<span class="chapter-intro-user" onclick="location.href='<?php  echo $this->createMobileUrl('teacher', array('teacherid'=>$lesson['teacherid']));?>'"><img src="<?php  echo $_W['attachurl'];?><?php  echo $lesson['teacherphoto'];?>" width="50" height="50"><?php  echo $lesson['teacher'];?></span>
						<?php  echo htmlspecialchars_decode($lesson['teacherdes']);?>
					</p>
				</li>
			</ul>
		</div>
		<div class="js-tab" style="transform-origin:0px 0px 0px;opacity:1;transform:scale(1,1); <?php  if(empty($sectionid) && $setting['lesson_show']==0) { ?>display:none;<?php  } ?>">
			<ul class="course-chapter">
				<li>
					<h2 class="chapter-title" onclick="location.href='<?php  echo $this->createMobileUrl('lesson', array('id'=>$lesson['id']));?>'"><i></i><?php  echo $lesson['bookname'];?>[共<?php  echo count($section_list);?>节课]</h2>
					<?php  if($setting['stock_config']==1 && empty($isbuy) && $lesson['price']>0 && $buybtn !='close') { ?>
					<div>
						<div class="stock-info">
						<?php  if($lesson['stock'] > 0) { ?>
						当前课程剩余名额<?php  echo $lesson['stock'];?>，请尽快下单
						<?php  } else { ?>
						当前课程已售罄，下次记得早点来哦~
						<?php  } ?>
						</div>
					</div>
					<?php  } ?>
					<ul class="course-sections">
					<?php  if(!empty($section_list)) { ?>
						<?php  if(is_array($section_list)) { foreach($section_list as $sec) { ?>
						<li>
							<i class="section-icon section-icon-video"></i>
							<a href="<?php  echo $this->createMobileUrl('lesson', array('id'=>$lesson['id'],'sectionid'=>$sec['id']));?>" <?php  if($sectionid==$sec['id']) { ?>class="section-active"<?php  } ?>><?php  echo $sec['title'];?><?php  if($sec['is_free']==1) { ?><span style="color:#128C62;">[免费试听]</span><?php  } ?></a>
							<i class="section-state-icon"><?php  echo $sec['videotime'];?></i>
						</li>
						<?php  } } ?>
					<?php  } else { ?>
						<li style="height:auto;padding:10%;">
							<a style="text-align:center;">抱歉，该课程没有找到任何内容~</a>
						</li>
					<?php  } ?>
					</ul>
				</li>
			<ul>
		</div>
		<div class="js-tab" style="transform-origin: 0px 0px 0px; opacity: 1; transform: scale(1, 1); display: none;">
			<div class="swiper-slide swiper-slide-active" style="height:auto;">
                <div class="details-con shadow" id="comments_box">
					<ul class="comment" id="evaluate">
						<?php  if($allow_evaluate) { ?>
						<li class="item" style="padding:.1rem .05rem;text-align:center;">
							<div>
								有什么想要说的呢？赶紧
								<a class="btn btn-default btn-sm" href="<?php  echo $evaluate_url;?>">去评价</a>
								吧~
							</div>
						</li>
						<?php  } ?>
					</ul>
				</div>
			</div>
			<div id="loading_div" class="loading_div">
				<a href="javascript:void(0);" id="btn_Page">加载更多</a>
			</div>
		</div>
	</div>
	<?php  if(!empty($advs['img'])) { ?>
	<div style="margin-top: 10px;;">
		<a href="<?php  echo $advs['link'];?>"><img src="<?php  echo $_W['attachurl'];?><?php  echo $advs['img'];?>" style="width:100%;"></a>
	</div>
	<?php  } ?>
	
	<footer>
	    <a href="<?php  echo $this->createMobileUrl('index');?>"><?php  echo $setting['copyright'];?></a>
	</footer>
</div>
<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('quicknav', TEMPLATE_INCLUDEPATH)) : (include template('quicknav', TEMPLATE_INCLUDEPATH));?>


<?php  if(!empty($lesson['weixin_qrcode'])) { ?>
<div id="cover" style="position: fixed; top: 0px; width: 100%; height: 100%; z-index: 99999999; display: none; background: rgba(0, 0, 0, 0.8);"><img src="<?php  echo $_W['attachurl'];?><?php  echo $lesson['weixin_qrcode'];?>" style="width:50%;margin-left: 25%;margin-top: 25%;"></div>
<?php  } ?>

<div id="bottom-contact" class="hide">
	<div class="contact-wrap">
		<div class="contact-wrap-title">咨询交流</div>
		<?php  if(!empty($lesson['weixin_qrcode'])) { ?>
		<div class="border-top layer-list_item">
			<a href="javascript:;" id="btn-qrcode">
				<div class="layer-list_item-icon" style="border-radius:0;">
					<img class="layer-list_item-img" src="<?php  echo $_W['attachurl'];?><?php  echo $lesson['weixin_qrcode'];?>">
				</div>
				<p class="layer-list_item-name">微信咨询</p>
				<p class="layer-list_item-info">点击弹出二维码并识别</p>
				<div class="layer-list_item-go">
					<i class="icon-font i-v-right">&gt;</i>
				</div>
			</a>
		</div>
		<?php  } ?>
		<?php  if(!empty($lesson['qq'])) { ?>
		<div class="border-top layer-list_item">
			<a href="http://wpa.qq.com/msgrd?v=3&uin=<?php  echo $lesson['qq'];?>&site=oicqzone.com&menu=yes">
				<div class="layer-list_item-icon">
					<img class="layer-list_item-img" src="<?php echo MODULE_URL;?>template/mobile/images/contact-1v1.png">
				</div>
				<p class="layer-list_item-name">QQ咨询</p>
				<p class="layer-list_item-info">QQ:<?php  echo $lesson['qq'];?></p>
				<div class="layer-list_item-go">
					<i class="icon-font i-v-right">&gt;</i>
				</div>
			</a>
		</div>
		<?php  } ?>
		<?php  if(!empty($lesson['qqgroup'])) { ?>
		<div class="contact-wrap__qun border-top">
			<div class="contact-wrap-qun-title">加群交流<span class="contact-wrap-qun-desc">(获取资料、学员交流)</span></div>
			<ul>
				<li class="layer-list_item">
					<a <?php  if(!empty($lesson['qqgroupLink'])) { ?>href="<?php  echo $lesson['qqgroupLink'];?>"<?php  } ?>>
						<div class="layer-list_item-icon">
							<img class="layer-list_item-img" src="<?php  echo $_W['attachurl'];?><?php  echo $lesson['teacherphoto'];?>">
						</div>
						<p class="layer-list_item-name z-tail"><?php  echo $lesson['teacher'];?>讲师交流群</p>
						<p class="layer-list_item-info">QQ群:<?php  echo $lesson['qqgroup'];?></p>
						<div class="layer-list_item-go">
							<i class="icon-font i-v-right">&gt;</i>
						</div>
					</a>
				</li>
			</ul>
		</div>
		<?php  } ?>
		<?php  if(empty($lesson['qq']) && empty($lesson['qqgroup']) && empty($lesson['weixin_qrcode'])) { ?>
		<div class="contact-wrap__qun border-top" style="text-align:center;">
			<div class="contact-wrap-qun-title">抱歉，未找到任何交流方式~</div>
		</div>
		<?php  } ?>
	</div>
	<div class="layer-close">关闭</div>
</div>
<div id="layer-bg" class="hide"></div>

<!--课程规格start-->
<div class="flick-menu-mask" onclick="closeSpec();" style="display: none;"></div>
<div class="spec-menu-content spec-menu-show" style="display: none;">
	<div class="spec-menu-top bdr-b">
		<div class="spec-first-pic">
			<img id="spec_image" src="<?php  echo $_W['attachurl'];?><?php  echo $lesson['images'];?>" onerror="imgErr(this)">
		</div>
		<a class="rt-close-btn-wrap spec-menu-close" onclick="closeSpec();">
			<p class="flick-menu-close"></p>
		</a>
		<div class="spec-price" id="specJdPri" style="display: block">
			<span class="yang-pic spec-yang-pic"></span>
			<span id="spec_price"> ￥<?php  echo $lesson['price'];?> </span>
		</div>
	</div>
	<div class="spec-menu-middle">
		<div class="prod-spec" id="prodSpecArea">
			<!-- 已选 -->
			<div class="spec-desc">
				<span class="part-note-msg">已选</span>
				<div id="specDetailInfo_spec" class="base-txt">
				</div>
			</div>
			<div class="nature-container" id="natureCotainer">
				<div class="pro-color">
					<span class="part-note-msg"> 规格 </span>
					<p id="color">
						<?php  if(is_array($spec_list)) { foreach($spec_list as $spec) { ?>
							<?php  if($spec['spec_day']==-1) { ?>
							<a class="a-item spec_<?php  echo $spec['spec_id'];?>" onclick="updateColorSizeSpec(<?php  echo $spec['spec_id'];?>,<?php  echo $spec['spec_price'];?>, <?php  echo $spec['spec_day'];?>)" href="javascript:void(0)">长期有效</a>
							<?php  } else { ?>
							<a class="a-item spec_<?php  echo $spec['spec_id'];?>" onclick="updateColorSizeSpec(<?php  echo $spec['spec_id'];?>,<?php  echo $spec['spec_price'];?>, <?php  echo $spec['spec_day'];?>)" href="javascript:void(0)">有效期<?php  echo $spec['spec_day'];?>天</a>
							<?php  } ?>
						<?php  } } ?>
					</p>
					<input type="hidden" id="spec_id" value=""/>
				</div>
			</div>
		</div>
	</div>
	<div class="flick-menu-btn spec-menu-btn">
		<a class="directorder" style="background-color: #f23030;transform-origin: 0px 0px 0px; opacity: 1; transform: scale(1, 1);" id="buy_now">立即购买</a>
	</div>
</div>
<!--课程规格end-->

<ul class="d-buynow">
	<li class="btn-qq"><a href="javascript:;" id="btn-qq"><i class="ico ico-lessonqq"></i>咨询</a></li>
	<li class="btn-collect" id="btn-collect"><a href="javascript:;" <?php  if(!empty($collect)) { ?>class="cur"<?php  } ?>><i class="ico ico-collect"></i>收藏</a></li>
	<li class="btn-phone" id="btn-lxb" style="display: none;"><a href="javascript:;"><i class="ico ico-phone"></i>咨询</a></li>
	<?php  if(empty($section_list)) { ?>
		<li class="btn-buy"><a href="javascript:;" class="buy buy_now gray"><p class="num" style="padding-top:22px;"><em class="money"></em>未完善</p></a></li>
	<?php  } else { ?>
		<?php  if($play) { ?>
		<li class="btn-buy"><a href="<?php  echo $this->createMobileUrl('lesson', array('id'=>$lesson['id'],'sectionid'=>$section_list[0]['id']));?>" class="buy buy_now blue"><p class="num" style="padding-top:22px;"><em class="money"></em>开始学习</p></a></li>
		<?php  } else { ?>
			<?php  if($setting['stock_config']==1 && $lesson['stock']==0) { ?>
				<li class="btn-buy"><a href="javascript:;" class="buy buy_now gray" style="background-color:#7D7D7D;"><p class="num" style="padding-top:22px;"><em class="money"></em>已售罄</p></a></li>
			<?php  } else { ?>
				<li class="btn-buy" id="buy-now"><a href="javascript:;" class="buy buy_now red"><p class="num"><?php echo $config['buynow_name']?$config['buynow_name']:'立即购买';?></p></a></li>
			<?php  } ?>
		<?php  } ?>
	<?php  } ?>
</ul>

<script type="text/javascript">
var i = 1; //设置当前页数，全局变量
var ajaxurl = "<?php  echo $this->createMobileUrl('lesson', array('op'=>'ajaxgetlist','id'=>$id,'sectionid'=>$sectionid));?>";

$(function () {
    //根据页数读取数据  
    function getData(page) {  
        i++; //页码自动增加，保证下次调用时为新的一页
        $.get(ajaxurl, {page: page}, function (data) {  
            if (data.length > 0) {
                var jsonObj = JSON.parse(data);
                insertDiv(jsonObj);  
            }
        });
       
    } 
    //初始化加载第一页数据  
    getData(1);

    //生成数据html,append到div中  
    function insertDiv(result) {  
        var mainDiv =$("#evaluate");
        var chtml = '';  
        for (var j = 0; j < result.length; j++) {  
            chtml += '<li class="item">';  
			chtml += '	<div class="hbox">';
			chtml += '		<div class="avatar">';
			chtml += '			<img src="' + result[j].avatar + '">';
			chtml += '			<h4 class="name te">' + result[j].nickname + '</h4>';
			chtml += '		</div>';
			chtml += '		<div class="right-box">';
			chtml += '			<p class="praise"><i class="ico ico-credit ' + result[j].ico + '"></i> ' + result[j].grade + ' <span class="fr"> ' + result[j].addtime + ' </span></p>';
			chtml += '			<p class="info"> ' + result[j].content + ' </p>';
			if(result[j].reply !=null){
			chtml += '			<p class="info reply"> <font>讲师回复：</font>' + result[j].reply + ' </p>';
			}
			chtml += '		</div>';
			chtml += '	</div>';
			chtml += '</li>'; 
        }
		mainDiv.append(chtml);
		if(result.length==0){
			document.getElementById("loading_div").innerHTML='<div class="loading_bd">没有了，已经到底了</div>';
		}
    }  
  
    //==============核心代码=============  
    var winH = $(window).height(); //页面可视区域高度   
  
    var scrollHandler = function () {  
        var pageH = $(document.body).height();  
        var scrollT = $(window).scrollTop(); //滚动条top   
        var aa = (pageH - winH - scrollT) / winH;  
        if (aa < 0.02) { 
            if (i % 1 === 0) {
                getData(i);  
                $(window).unbind('scroll');  
                $("#btn_Page").show();
            } else {  
                getData(i);  
                $("#btn_Page").hide();
            }  
        }  
    }  
    //定义鼠标滚动事件
    $(window).scroll(scrollHandler);
    //继续加载按钮事件
    $("#btn_Page").click(function () {
        getData(i);
        $(window).scroll(scrollHandler);
    });
    
    //单规格课程自动选中    
    <?php  if(count($spec_list)==1){ ?>
	    var spec_id = <?php  echo $spec_list[0]['spec_id']; ?>;
	    var spec_price = <?php  echo $spec_list[0]['spec_price']; ?>;
	    var spec_day = <?php  echo $spec_list[0]['spec_day']; ?>;
	    updateColorSizeSpec(spec_id, spec_price, spec_day);
	<?php  } ?>
});

// “章节”、“课程详情”tab切换
$(".course-tab").on("click", 'li', function() {
	var $currItem = $(this),
	index = $currItem.index();

	$currItem.addClass('curr').siblings().removeClass('curr');
	$(".js-tab").hide().eq(index).show();

});

//展开QQ咨询
$("#btn-qq").click(function() {
	$("#bottom-contact").removeClass("hide");
	$("#layer-bg").removeClass("hide");
});
//关闭QQ咨询
$(".layer-close").click(function() {
	$("#bottom-contact").addClass("hide");
	$("#layer-bg").addClass("hide");

});
function GetQueryString(name){
	var reg = new RegExp("(^|&)"+ name +"=([^&]*)(&|$)");
	var r = window.location.search.substr(1).match(reg);
	if(r!=null)return  unescape(r[2]); return null;
}

//微信二维码
$('#btn-qrcode').click(function(){
	$('#cover').fadeIn(200).unbind('click').click(function(){
		$(this).fadeOut(100);
	})
});

//课程规格
$("#buy-now").click(function() {
	$(".flick-menu-mask").show();
	$(".spec-menu-show").show();
});
function closeSpec(){
	$(".flick-menu-mask").hide();
	$(".spec-menu-show").hide();
}

function updateColorSizeSpec(spec_id, spec_price, spec_day){
	$(".a-item").removeClass("selected");
	$(".spec_"+spec_id).addClass("selected");
	$("#spec_id").val(spec_id);
	document.getElementById("spec_price").innerHTML = "￥"+spec_price;
	document.getElementById("specDetailInfo_spec").innerHTML = spec_day==-1 ? '长期有效' : "有效期"+spec_day+"天";
}

//立即购买
$("#buy_now").click(function(){
	var spec_id = $("#spec_id").val();
	if(!spec_id){
		alert("请选择课程规格");
		return false;
	}
	location.href = "<?php  echo $this->createMobileUrl('confirm', array('id'=>$lesson['id']));?>&spec_id="+spec_id;
});

$("#btn-collect").click(function(){
	var id = GetQueryString('id');
	var ajaxurl = "<?php  echo $this->createMobileUrl('updatecollect', array('ctype'=>'lesson','uid'=>$uid));?>";
	$.ajax({
        type:'post',
        url:ajaxurl,
        data:{id:id},
        dataType:'json',     
        success:function(data){
            if(data=='1'){
				$("#btn-collect a").addClass("cur");
			}else if(data=='2'){
				$("#btn-collect a").removeClass("cur");
			}
        }
    });
});

<?php  if($sectionid>0){ ?>
	var video = document.getElementById("video");
	var recordurl = "<?php  echo $this->createMobileUrl('record', array('lessonid'=>$_GPC['id'],'sectionid'=>$_GPC['sectionid'],'uid'=>$uid));?>";

	<?php  if($section['sectiontype']==1){ ?>
		video.addEventListener("timeupdate",function(){
			//每隔20秒记录一次播放时间
			var currentTime = Math.floor(video.currentTime);
			if(currentTime!=0 && currentTime%20==0){
				$.get(recordurl, {currentTime:currentTime}, function (data){});
			}
		});
		video.addEventListener("ended",function(){
			//播放结束后记录
			var duration = video.duration.toFixed(1);
			$.get(recordurl, {currentTime:duration}, function (data){});
		});
	<?php  }else{ ?>
		$(document).ready(function(){  
			$.get(recordurl, {}, function (data){});
		});
	<?php  } ?>
<?php  } ?>
</script>

<?php  echo register_jssdk(false);?>
<script type="text/javascript">
wx.ready(function(){
	var shareData = {
		title: "<?php  echo $sharelesson['title'];?>",
		desc: "<?php  echo $sharelesson['desc'];?>",
		link: "<?php  echo $sharelesson['link'];?>",
		imgUrl: "<?php  echo $_W['attachurl'];?><?php echo $sharelesson['images']?$sharelesson['images']:$lesson['images']?>",
		trigger: function (res) {},
		complete: function (res) {},
		success: function (res) {},
		cancel: function (res) {},
		fail: function (res) {}
	};
	wx.onMenuShareTimeline(shareData);
	wx.onMenuShareAppMessage(shareData);
	wx.onMenuShareQQ(shareData);
	wx.onMenuShareWeibo(shareData);
	wx.onMenuShareQZone(shareData);
	
});
</script>

<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('_footerv2', TEMPLATE_INCLUDEPATH)) : (include template('_footerv2', TEMPLATE_INCLUDEPATH));?>
