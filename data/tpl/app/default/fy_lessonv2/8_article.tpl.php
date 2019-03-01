<?php defined('IN_IA') or exit('Access Denied');?><!--
 * ============================================================================
 * 版权所有 2015-2017 风影随行，并保留所有权利。
 * 网站地址: http://www.haoshu888.com；
 * ----------------------------------------------------------------------------
 * 这不是一个自由软件！已购买用户允许对程序代码进行修改和使用，但是不允许对
 * 程序代码以任何形式任何目的的再发布，作者将保留追究法律责任的权力和最终解
 * 释权。
 * ============================================================================
-->
<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('_headerv2', TEMPLATE_INCLUDEPATH)) : (include template('_headerv2', TEMPLATE_INCLUDEPATH));?>
<link href="<?php echo MODULE_URL;?>template/mobile/style/cssv2/article.css?v=<?php  echo $versions;?>" rel="stylesheet" />

<div class="header-2 cbox">
	<a href="javascript:history.go(-1);" class="ico go-back"></a>
	<div class="flex title" style="max-width:70%;"><?php  echo $title;?></div>
</div>

<?php  if($op=='display') { ?>
<div class="rich_primary">
	<div class="rich_title"><?php  echo $article['title'];?></div>
	<div class="rich_content">
		<?php  echo htmlspecialchars_decode($article['content']);?>
	</div>
	<div class="rich_tool">
	<?php  if(!empty($article['linkurl'])) { ?>
		<a href="<?php  echo $article['linkurl'];?>"><div class="rich_tool_text link">阅读原文</div></a>
	<?php  } ?>
		<div class="rich_tool_text">阅读 <?php  echo $article['view'];?></div>
	</div>
</div>
<?php  echo register_jssdk(false);?>
<script type="text/javascript">
wx.ready(function(){
	var shareData = {
		title: "<?php  echo $article['title'];?> - <?php  echo $setting['sitename'];?> - <?php  echo $_W['account']['name'];?>",
		desc: "<?php  echo $article['desc'];?>",
		link: "<?php  echo $shareurl;?>",
		imgUrl: "<?php  echo $_W['attachurl'];?><?php  echo $article['images'];?>",
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

<?php  } else if($op=='list') { ?>
<ul class="article_list">
</ul>
<div id="loading_div" class="loading_div">
	<a href="javascript:void(0);" id="btn_Page">加载更多</a>
</div>

<div id="loading" style="position:fixed;top:0;left:0;width:100%;height:100%;background:rgba(0,0,0,0.6);z-index:9999;"><div class="spinner"><div class="bounce1"></div><div class="bounce2"></div><div class="bounce3"></div></div></div>

<script type="text/javascript">
var i = 1; //设置当前页数，全局变量
var ajaxurl = "<?php  echo $this->createMobileUrl('article', array('op'=>'list','method'=>'ajaxgetlist'));?>";
var articleurl = "<?php  echo $this->createMobileUrl('article');?>";
var loading = document.getElementById("loading");
$(function () {
    //根据页数读取数据  
    function getData(page) {  
        i++; //页码自动增加，保证下次调用时为新的一页。  
        $.get(ajaxurl, {page: page}, function (data) {  
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
        var mainDiv =$(".article_list");
        var chtml = '';  
        for (var j = 0; j < result.length; j++) {
			chtml += '<li>';
            chtml += '	<a href="' + articleurl + '&aid=' + result[j].id + '">';  
			chtml += '		<div class="title">[ID:' + result[j].id + ']' + result[j].title + '</div>';
			chtml += '		<div class="createtime">' + result[j].addtime + '</div>';
			chtml += '	</a>';
			chtml += '<li>';
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
