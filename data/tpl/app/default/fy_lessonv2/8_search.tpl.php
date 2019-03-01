<?php defined('IN_IA') or exit('Access Denied');?><!-- 
 * 微课堂首页
 * ============================================================================
 * 版权所有 2015-2017 风影随行，并保留所有权利。
 * 网站地址: http://www.haoshu888.com
 * ----------------------------------------------------------------------------
 * 这不是一个自由软件！不允许对程序代码以任何形式任何目的的再发布，作者将保留
 * 追究法律责任的权力和最终解释权。
-->
<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('_headerv2', TEMPLATE_INCLUDEPATH)) : (include template('_headerv2', TEMPLATE_INCLUDEPATH));?>
<link href="<?php echo MODULE_URL;?>template/mobile/style/cssv2/search.css?v=<?php  echo $versions;?>" rel="stylesheet" />

<?php  if($op=='display') { ?>
<!-- 顶部搜索框 -->
<header class="m-header z-img-ready border-top">
	<p class="header_logo" onclick="location.href='<?php  echo $this->createMobileUrl('index');?>'"><span class="logo-pic" style="background-image:url(<?php  echo $_W['attachurl'];?><?php  echo $setting['logo'];?>);"></span>微课堂v2</p>
	<div class="search_btn" id="search_btn">搜索</div>
	<div class="header_search">
		<div class="u-search">
			<i class="icon-font i-search"></i>
			<input type="text" id="searchInput" class="search_input z-abled" value="<?php  echo $_GPC['keyword'];?>" autocorrect="off" placeholder="搜索课程/老师">
		</div>
	</div>
</header>
<!-- /顶部搜索框 -->

<!-- 筛选条件 -->
<div id="nav" class="nav">
	<div id="sort-list" class="dropdown">
		<div class="dropdown_description">
			<?php  echo $sortname;?> <i class="fa fa-angle-down"></i>
			<div id="contact_ico" class="contact_ico"><i class="fa fa-angle-up"></i></div>
		</div>
	</div>
	<div class="dropdown" onclick="location.href='<?php  echo $this->createMobileUrl('search', array('op'=>'allcategory'));?>'">
		<div class="dropdown_description"><?php  echo $catname;?> <i class="fa fa-angle-down" id="nav_ico"></i></div>
	</div>
</div>
<div class="dropdown_wrapper" id="dropdown_wrapper">
	<ul class="dropdown_menu">
		<li class="dropdown_item <?php  if(empty($sort)) { ?>z-open<?php  } ?>" onclick="goSearch('')">综合排序</li>
		<li class="dropdown_item <?php  if($sort=='free') { ?>z-open<?php  } ?>" onclick="goSearch('free')">免费课程</li>
		<li class="dropdown_item <?php  if($sort=='price') { ?>z-open<?php  } ?>" onclick="goSearch('price')">价格优先</li>
		<li class="dropdown_item <?php  if($sort=='hot') { ?>z-open<?php  } ?>" onclick="goSearch('hot')">人气优先</li>
		<li class="dropdown_item <?php  if($sort=='score') { ?>z-open<?php  } ?>" onclick="goSearch('score')">好评优先</li>
	</ul>
</div>
<input type="hidden" id="sort" value="0"/>
<!-- /筛选条件 -->

<!-- 课程列表 -->
<div class="section">
	<div style="margin:90px auto 10px;">
		<?php  if(!empty($cat_id) || !empty($keyword)) { ?>
		<div class="search-result-toast">
			共找到<span class="search-result-word"><?php  echo $total;?></span>门课程
		</div>
		<?php  } ?>
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
<!-- /课程列表 -->

<!-- 遮罩层 -->
<div id="sort_background" class="dropdown__background"></div>
<!-- /遮罩层 -->
<div id="loading" style="position:fixed;top:0;left:0;width:100%;height:100%;background:rgba(0,0,0,0.6);z-index:999999999;"><div class="spinner"><div class="bounce1"></div><div class="bounce2"></div><div class="bounce3"></div></div></div>

<script type="text/javascript">
var nav = document.getElementById("nav");
var dropdown_wrapper = document.getElementById("dropdown_wrapper");
var contact_ico = document.getElementById("contact_ico");
var sort_background = document.getElementById("sort_background");

$("#sort-list").on("click", function(){
	var sort = $("#sort").val();
	if(sort==0){
		$("#sort").val(1);
		dropdown_wrapper.style.display = "block";
		contact_ico.style.display = "block";
		nav.style.borderBottomColor = "#23b8ff";
		sort_background.style.display = "block";
	}else{
		$("#sort").val(0);
		dropdown_wrapper.style.display = "none";
		contact_ico.style.display = "none";
		nav.style.borderBottomColor = "#e2e2e2";
		sort_background.style.display = "none";
	}
});
$("#sort_background").on("click", function(){
	$("#sort").val(0);
	dropdown_wrapper.style.display = "none";
	contact_ico.style.display = "none";
	nav.style.borderBottomColor = "#e2e2e2";
	sort_background.style.display = "none";
});

function goSearch(sort){
	var siteUrl = "<?php  echo $_W['siteurl'];?>";
	if(sort=='free'){
		siteUrl = siteUrl + "&sort=free";
	}else if(sort=='price'){
		siteUrl = siteUrl + "&sort=price";
	}else if(sort=='hot'){
		siteUrl = siteUrl + "&sort=hot";
	}else if(sort=='score'){
		siteUrl = siteUrl + "&sort=score";
	}else{
		siteUrl = siteUrl + "&sort=";
	}
	
	location.href = siteUrl;
}

var search = function() {
    var keywords = $.trim($("#searchInput").val());
    if (keywords == '') {
        searchUrl = '<?php  echo $this->createMobileUrl("search");?>';
    } else {
        searchUrl = '<?php  echo $this->createMobileUrl("search");?>&keyword=' + encodeURIComponent(keywords);
    }
    document.location.href = searchUrl;
    return false;
};
$("#searchInput").keydown(function(event) {
	if (event.keyCode == 13) {
		search();
	}
});
$("#search_btn").on("click", function(){
	search();
});
</script>
<script type="text/javascript">
var i = 1; //设置当前页数，全局变量
var ajaxUrl   = "<?php  echo $_W['siteUrl'];?>";
var attachUrl = "<?php  echo $_W['attachurl'];?>";
var lessonUrl = "<?php  echo $this->createMobileUrl('lesson');?>";
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
        var mainDiv =$("#js-course-list");
        var chtml = '';  
        for (var j = 0; j < result.length; j++) {
            chtml += '<li class="lesson_list">';
            chtml += '	<a href="' + lessonUrl + '&id=' + result[j].id + '" class="package">';
            chtml += '		<div class="package__cover-wrap">';
            chtml += '			<div class="package__cover" style="background-image: url(' + attachUrl + result[j].images + ');">';
            chtml += '				<span class="package__cover-tips package__cover-tips--status">' + result[j].buyTotal + '人已学习</span>';
            chtml += '			</div>';
            chtml += '		</div>';
            chtml += '		<div class="package__content">';
            chtml += '			<h3 class="package__name">' + result[j].bookname + '</h3>';
            chtml += '			<div class="package__info">';
            chtml += '				<span class="u-price">' + result[j].price + '</span>';
            chtml += '			</div>';
            chtml += '			<div class="package__info">';
            chtml += '				<span>共<i class="blue-color">' + result[j].soncount + '</i>节课程</span>';
            if(result[j].score>0){
            chtml += '				<div class="package__course-num"><i class="blue-color">' + result[j].score_rate + '%</i>好评</div>';
          }else{
          	chtml += '				<div class="package__course-num"><i class="blue-color">' + result[j].score_rate + '</div>';
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
    	loading.style.display = 'block';
        getData(i);
        $(window).scroll(scrollHandler);
    });
  
});
</script>

<?php  } else if($op=='allcategory') { ?>
<!-- 分类 START-->
<div class="allcategory-wrap">
	<a class="allcategory" href="<?php  echo $this->createMobileUrl('search');?>">全部分类</a>
</div>
<?php  if(is_array($categorylist)) { foreach($categorylist as $category) { ?>
	<?php  if($category['is_show']==1) { ?>
	<div class="cat_box">
		<h3 class="cat_tit">
			<span class="cat_ico"><img src="<?php  echo $_W['attachurl'];?><?php  echo $category['ico'];?>" /></span>
			<span class="cat_name"><a href="<?php  echo $this->createMobileUrl('search', array('cat_id'=>$category['id']));?>"><?php  echo $category['name'];?></a></span>
		</h3>
	    <div>
	    	<ul class="cat_list">
    		<?php  if(is_array($category['child'])) { foreach($category['child'] as $item) { ?>
				<?php  if($item['is_show']==1) { ?>
	            <li><a href="<?php  echo $this->createMobileUrl('search', array('cat_id'=>$item['id']));?>"><?php  echo $item['name'];?></a></li>
	        	<?php  } ?>
			<?php  } } ?>
	    	</ul>
	    </div>
	</div>
	<?php  } ?>
<?php  } } ?>

<!-- 分类 END-->
<?php  } ?>
<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('_footerv2', TEMPLATE_INCLUDEPATH)) : (include template('_footerv2', TEMPLATE_INCLUDEPATH));?>