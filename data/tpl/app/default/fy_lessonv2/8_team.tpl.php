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
<link href="<?php echo MODULE_URL;?>template/mobile/style/cssv2/commission.css?v=<?php  echo $versions;?>" rel="stylesheet" />

<div class="header-2 cbox">
	<a href="javascript:history.go(-1);" class="ico go-back"></a>
	<div class="flex title"><?php  echo $title;?></div>
</div>

<div class="team_top">
    <div class="title"> <?php  echo $sontitle;?></div>
</div>

<div class="team_tab">
	<?php  if($level==1 || empty($level)) { ?>
    <div class="team_nav team_navon" style='width:100%'>一级会员</div>
	<?php  } else if($level==2) { ?>
    <div class="team_nav team_navon" style='width:50%'>二级会员</div>
	<?php  } else if($level==3) { ?>
    <div class="team_nav team_navon" style='width:33.3%'>三级会员</div>
	<?php  } ?>
</div>
<div class="team_list_head">
        <div class="info">成员信息</div>
        <div class="num">Ta的佣金/成员</div>
</div>
<div id="teamlist">
	<?php  if(empty($teamlist)) { ?>
	<div class="team_no"><span style="line-height:100px; font-size:16px;">Ta的团队还没有任何成员~</span></div>
	<?php  } ?>
</div>
<div id="loading_div" class="loading_div">
	<a href="javascript:void(0);" id="btn_Page">加载更多</a>
</div>

<footer>
    <a href="<?php  echo $this->createMobileUrl('index');?>"><?php  echo $setting['copyright'];?></a>
</footer>

<div id="loading" style="position:fixed;top:0;left:0;width:100%;height:100%;background:rgba(0,0,0,0.6);z-index:9999;"><div class="spinner"><div class="bounce1"></div><div class="bounce2"></div><div class="bounce3"></div></div></div>

<script type="text/javascript">
var i = 1; //设置当前页数，全局变量
var ajaxurl = "<?php  echo $this->createMobileUrl('team', array('leval'=>$leval,'mid'=>$mid));?>";
var level = <?php  echo $level?>;
var fxlevel = <?php  echo $setting['level']?>;
var murl = "<?php  echo $this->createMobileUrl('team');?>";
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
        var mainDiv =$("#teamlist");
        var chtml = '';  
        for (var j = 0; j < result.length; j++) {
		if(level==1){
			if(fxlevel>1){
				chtml += '<div class="team_list" onclick="location.href=\'' + murl + '&level=2&mid=' +result[j].uid+ '\'">';
			}else{
				chtml += '<div class="team_list">';
			}
            
		}else if(level==2){
			if(fxlevel>2){
				chtml += '<div class="team_list" onclick="location.href=\'' + murl + '&level=3&mid=' +result[j].uid+ '\'">';
			}else{
				chtml += '<div class="team_list">';
			}
		}else if(level==3){
			chtml += '<div class="team_list">';
		}
			chtml += '	<div class="img"><img src="' +result[j].avatar+ '"></div>';
			chtml += '	<div class="info">' +result[j].nickname+ '<br><span>' +result[j].addtime+ '</span></div>';
			chtml += '	<div class="num">+' +result[j].commission+ '<br><span>' +result[j].recnum+ ' 个成员</span></div>';
			chtml += '</div>'; 
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

<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('_footerv2', TEMPLATE_INCLUDEPATH)) : (include template('_footerv2', TEMPLATE_INCLUDEPATH));?>