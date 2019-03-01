<?php defined('IN_IA') or exit('Access Denied');?><!-- 
 * 收藏页面
 * ============================================================================
 * 版权所有 2015-2017 风影随行，并保留所有权利。
 * 网站地址: http://www.haoshu888.com
 * ----------------------------------------------------------------------------
 * 这不是一个自由软件！不允许对程序代码以任何形式任何目的的再发布，作者将保留
 * 追究法律责任的权力和最终解释权。
-->
<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('_headerv2', TEMPLATE_INCLUDEPATH)) : (include template('_headerv2', TEMPLATE_INCLUDEPATH));?>
<link href="<?php echo MODULE_URL;?>template/mobile/style/cssv2/search.css?v=<?php  echo $versions;?>" rel="stylesheet" />

<div class="header-2 cbox">
	<a href="javascript:history.go(-1);" class="ico go-back"></a>
	<div class="flex title"><?php  echo $title;?></div>
</div>

<?php  if($ctype==1) { ?>
<div style="margin:10px auto;">
	<?php  if(!empty($lessonlist)) { ?>
	<ul id="course-list" class="course-list list-view" style="min-height:1px;">
	</ul>
	<div id="loading_div" class="loading_div">
		<a href="javascript:void(0);" id="btn_Page">加载更多</a>
	</div>
	<?php  } else { ?>
	<div class="my_empty">
	    <div class="empty_bd  my_course_empty">
	        <h3>您还没有收藏任何课程~</h3>
	        <p><a href="<?php  echo $this->createMobileUrl('index');?>">到首页去看看</a></p>
	    </div>
	</div>
	<?php  } ?>
</div>

<div id="loading" style="position:fixed;top:0;left:0;width:100%;height:100%;background:rgba(0,0,0,0.6);z-index:9999;"><div class="spinner"><div class="bounce1"></div><div class="bounce2"></div><div class="bounce3"></div></div></div>


<script type="text/javascript">
var i = 1; //设置当前页数，全局变量
var ajaxUrl = "<?php  echo $this->createMobileUrl('collect', array('op'=>'ajaxgetlesson','ctype'=>1));?>";
var attachUrl = "<?php  echo $_W['attachurl'];?>";
var lessonUrl = "<?php  echo $this->createMobileUrl('lesson');?>";
var loading = document.getElementById("loading");
$(function () {
    //根据页数读取数据  
    function getData(page) {  
        i++; //页码自动增加，保证下次调用时为新的一页。  
        $.get(ajaxUrl, {page: page}, function (data) {  
            if (data.length > 0) {
				loading.style.display = 'none';
                var jsonObj = JSON.parse(data);
                insertDiv(jsonObj);  
            }
        });  
       
    } 
    //初始化加载第一页数据  
    getData(1);

    //生成数据html,append到div中  
    function insertDiv(result) {  
        var mainDiv =$("#course-list");
        var chtml = '';  
        for (var j = 0; j < result.length; j++) {  
            chtml += '<li class="lesson_list">';  
            chtml += '	<a href="' + lessonUrl + '&id=' + result[j].id + '" class="package">'; 
            chtml += '		<div class="package__cover-wrap">';
            chtml += '			<div class="package__cover" style="background-image:url('+attachUrl+result[j].images + ');" alt="'+result[j].bookname+'">';
            chtml += '				<span class="package__cover-tips package__cover-tips--status">'+result[j].buynum_total+'人已学习</span>';
            chtml += '			</div>';
            chtml += '		</div>';
            chtml += '		<div class="package__content">';
            chtml += '			<h3 class="package__name">'+result[j].bookname+'</h3>';
            chtml += '			<div class="package__info">';
            chtml += '				<span class="u-price">'+result[j].price+'</span>';
            chtml += '			</div>';
            chtml += '			<div class="package__info">';
            chtml += '				<span>共<i class="blue-color">'+result[j].seccount+'</i>节课程</span>	';
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
		loading.style.display = 'block';
        getData(i);
        $(window).scroll(scrollHandler);
    });
  
});
</script>
<?php  } else if($ctype==2) { ?>
<style>
a.package{padding: 15px 0 15px 90px;}
a.package .package__cover-wrap{width: 80px;}
a.package .package__cover-wrap .package__cover{background-size: 80px 80px;}
a.package .package__content .package__info{height: 80px;overflow: hidden;}
a.package .package__cover-wrap .package__cover .package__cover-tips{text-align:center;background-color: rgba(0, 0, 0, .5);}
</style>
<div style="margin:10px auto;">
	<?php  if(!empty($teacherlist)) { ?>
	<ul id="teacher-list" class="course-list list-view" style="min-height:1px;">
	</ul>
	<div id="loading_div" class="loading_div">
		<a href="javascript:void(0);" id="btn_Page">加载更多</a>
	</div>
	<?php  } else { ?>
	<div class="my_empty">
	    <div class="empty_bd  my_course_empty">
	        <h3>您还没有收藏任何讲师~</h3>
	    </div>
	</div>
	<?php  } ?>
</div>

<div id="loading" style="position:fixed;top:0;left:0;width:100%;height:100%;background:rgba(0,0,0,0.6);z-index:9999;"><div class="spinner"><div class="bounce1"></div><div class="bounce2"></div><div class="bounce3"></div></div></div>

<script type="text/javascript">
var i = 1; //设置当前页数，全局变量
var ajaxUrl = "<?php  echo $this->createMobileUrl('collect', array('op'=>'ajaxgetteacher','ctype'=>2));?>";
var attachUrl = "<?php  echo $_W['attachurl'];?>";
var teacherUrl = "<?php  echo $this->createMobileUrl('teacher');?>";
var loading = document.getElementById("loading");
$(function () {
    //根据页数读取数据  
    function getData(page) {  
        i++; //页码自动增加，保证下次调用时为新的一页。  
        $.get(ajaxUrl, {page: page}, function (data) {  
            if (data.length > 0) {
				loading.style.display = 'none';
                var jsonObj = JSON.parse(data);
                insertDiv(jsonObj);  
            }
        });  
       
    } 
    //初始化加载第一页数据  
    getData(1);

    //生成数据html,append到div中  
    function insertDiv(result) {  
        var mainDiv =$("#teacher-list");
        var chtml = '';  
        for (var j = 0; j < result.length; j++) {
            chtml += '<li class="lesson_list">';
            chtml += '	<a href="' + teacherUrl + '&teacherid=' + result[j].id + '" class="package">';
            chtml += '		<div class="package__cover-wrap">';
            chtml += '			<div class="package__cover" style="background-image: url(' + attachUrl + result[j].teacherphoto + ');">';
            chtml += '				<span class="package__cover-tips package__cover-tips--status">' + result[j].teacher + '</span>';
            chtml += '			</div>';
            chtml += '		</div>';
            chtml += '		<div class="package__content">';
            chtml += '			<div class="package__info">';
            chtml += '				<i class="u-price">讲师简介：</i>' + result[j].teacherdes;
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
		loading.style.display = 'block';
        getData(i);
        $(window).scroll(scrollHandler);
    });
  
});
</script>
<?php  } ?>

<footer>
    <a href="<?php  echo $this->createMobileUrl('index');?>"><?php  echo $setting['copyright'];?></a>
</footer>

<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('_footerv2', TEMPLATE_INCLUDEPATH)) : (include template('_footerv2', TEMPLATE_INCLUDEPATH));?>