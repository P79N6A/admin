<?php defined('IN_IA') or exit('Access Denied');?><!-- 
 * 讲师课程
 * ============================================================================
 * 版权所有 2015-2017 风影随行，并保留所有权利。
 * 网站地址: http://www.haoshu888.com
 * ----------------------------------------------------------------------------
 * 这不是一个自由软件！不允许对程序代码以任何形式任何目的的再发布，作者将保留
 * 追究法律责任的权力和最终解释权。
-->
<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('_headerv2', TEMPLATE_INCLUDEPATH)) : (include template('_headerv2', TEMPLATE_INCLUDEPATH));?>
<link href="<?php echo MODULE_URL;?>template/mobile/style/cssv2/teacher.css?v=<?php  echo $versions;?>" rel="stylesheet" />

<div id="cover" style="display:none;position:fixed;top:0;width:100%;height:100%;background:rgba(0,0,0,0.8);display:none;z-index:99999999;"><img src="<?php echo MODULE_URL;?>template/mobile/images/share_notice.jpg" style="width:100%;"></div>

<div class="content agency">
    <div class="agency-head cbox" <?php  if(!empty($config['teacher_bg'])) { ?>style="background-image:url(<?php  echo $_W['attachurl'];?><?php  echo $config['teacher_bg'];?>);"<?php  } ?>>
        <img src="<?php  echo $_W['attachurl'];?><?php  echo $teacher['teacherphoto'];?>" class="pic">

        <div style="width: 76%;">
            <div class="cbox">
                <h3 class="flex title te" style="width: 50%;"><?php  echo $teacher['teacher'];?></h3>
                <!--<a href="javascript:;" class="btn-share" id="share_btn" style="width: 50%;"><i class="fa fa-2x fa-fw fa-share-alt"></i></a>-->
            </div>

            <ul class="data cbox">
                <li class="flex hbox" style="width: 66%;">
                    <div class="num">
                        <p><?php  echo $total;?></p>课程数量
                    </div>
                    <span class="line"></span>
                    <div class="per">
                        <p><?php  echo $student_num;?></p>学生人数
                    </div>
                </li>
                <li id="btn-collect2" style="width: 33%;">
                    <!-- 已收藏 加上类cur -->
                    <a href="javascript:;" class="link"><i id="collect2-icon" class="fa <?php echo $collect ? 'fa-heart' : 'fa-heart-o';?>""></i> 收藏</a>
                </li>
            </ul>
        </div>
    </div>
    <ul class="details-tab agency-tab">
        <li class="cur" tab-name="course"><a href="javascript:;">全部课程(<?php  echo $total;?>)</a></li>
        <li tab-name="js"><a href="javascript:;">讲师介绍</a></li>
    </ul>

	<div class="swiper-wrapper">
		<div class="swiper-slide agency-con swiper-slide-active " id="detail-course">
			<div id="course_box">
				<ul id="js-course-list" class="course-list list-view" style="min-height:1px;">
				</ul>
				<div id="loading_div" class="loading_div">
					<a href="javascript:void(0);" id="btn_Page">加载更多</a>
				</div>
			</div>
			<footer>
			    <a href="<?php  echo $this->createMobileUrl('index');?>"><?php  echo $setting['copyright'];?></a>
			</footer>
		</div>

		<div class="swiper-slide agency-con" id="detail-school" style="height:auto;">
			<div id="school_box">
				<div class="agency-teachers shadow">
					<ul class="comment">
						<li class="item">
							<div class="right-box">
								<?php  echo htmlspecialchars_decode($teacher['teacherdes']);?>
							</div>
						</li>
					</ul>
				</div>
			</div>
			<footer>
			    <a href="<?php  echo $this->createMobileUrl('index');?>"><?php  echo $setting['copyright'];?></a>
			</footer>
		</div>
	</div>
</div>

<script type="text/javascript">
var i = 1; //设置当前页数，全局变量
var ajaxurl   = "<?php  echo $this->createMobileUrl('teacher', array('op'=>'ajaxgetlesson', 'teacherid'=>$teacherid));?>";
var lessonurl = "<?php  echo $this->createMobileUrl('lesson');?>";
var attachurl = "<?php  echo $_W['attachurl'];?>";
var loading = document.getElementById("loading");
var teacherself = "<?php  echo $teacherself;?>";
$(function () {
    //根据页数读取数据  
    function getData(page) {  
        i++; //页码自动增加，保证下次调用时为新的一页。  
        $.get(ajaxurl, {page: page }, function (data) {  
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
        var mainDiv =$("#js-course-list");
        var chtml = '';  
        for (var j = 0; j < result.length; j++) {  
            chtml += '<li class="lesson_list">';  
            chtml += '	<a href="' + lessonurl + '&id=' + result[j].id + '" class="package">'; 
            chtml += '		<div class="package__cover-wrap">';
            chtml += '			<div class="package__cover" style="background-image:url('+attachurl+result[j].images + ');" alt="'+result[j].bookname+'">';
            chtml += '				<span class="package__cover-tips package__cover-tips--status">'+result[j].virtualandbuynum+'人已学习</span>';
            chtml += '			</div>';
            chtml += '		</div>';
            chtml += '		<div class="package__content">';
            chtml += '			<h3 class="package__name">'+result[j].bookname+'</h3>';
            chtml += '			<div class="package__info">';
            chtml += '				<span class="u-price">'+result[j].price+'</span>';
            chtml += '			</div>';
            chtml += '			<div class="package__info">';
            chtml += '				<span>共<i class="blue-color">'+result[j].seccount+'</i>节课程</span>	';
            if(teacherself==1){
            chtml += '				<div class="package__course-num">讲师收益:<i class="blue-color">'+result[j].teacher_income+'%</i></div>';
            }
            chtml += '			</div>';
            chtml += '		</div>';
            chtml += '	</a>';
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
  
});  
</script>
<script type="text/javascript">
//切换tab
$(".agency-tab").on("click", 'li', function() {
	var $currItem = $(this),
	index = $currItem.index();

	$currItem.addClass('cur').siblings().removeClass('cur');
	$(".agency-con").hide().eq(index).show();
});

$('.btn-share').click(function(){
	var ua = window.navigator.userAgent.toLowerCase();
	if (ua.match(/MicroMessenger/i) == 'micromessenger') {
		$('#cover').fadeIn(200).unbind('click').click(function(){
			$(this).fadeOut(100);
		});
	} else {
		alert("您未在微信客户端里访问，请使用图片海报推广方式");
	}
});

function GetQueryString(name){
	var reg = new RegExp("(^|&)"+ name +"=([^&]*)(&|$)");
	var r = window.location.search.substr(1).match(reg);
	if(r!=null)return  unescape(r[2]); return null;
}

$("#btn-collect2").click(function(){
	var id = GetQueryString('teacherid');
	var ajaxurl = "<?php  echo $this->createMobileUrl('updatecollect', array('ctype'=>'teacher','uid'=>$uid));?>";
	$.ajax({
        type:'post',
        url:ajaxurl,
        data:{id:id},
        dataType:'json',     
        success:function(data){
            if(data=='1'){
            	$("#collect2-icon").removeClass("fa-heart-o");
				$("#collect2-icon").addClass("fa-heart");
			}else if(data=='2'){
				$("#collect2-icon").addClass("fa-heart-o");
				$("#collect2-icon").removeClass("fa-heart");
			}
        }
    });
});
</script>

<?php  echo register_jssdk(false);?>
<script type="text/javascript">
wx.ready(function(){
	var shareData = {
		title: "<?php  echo $teacher['teacher'];?>讲师主页 - <?php  echo $setting['sitename'];?>",
		desc: "<?php  echo $shareteacher['title'];?>",
		link: "<?php  echo $shareurl;?>",
		imgUrl: "<?php  echo $_W['attachurl'];?><?php echo $shareteacher['images']?$shareteacher['images']:$teacher['teacherphoto']?>",
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

