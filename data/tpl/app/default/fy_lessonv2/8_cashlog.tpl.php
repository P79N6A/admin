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

<div id="container">
	<?php  if(empty($list)) { ?>
	<div class="log_no"><span style="line-height:18px;font-size:16px;margin-top:40px;display:inline-block;">您还没有佣金明细哦~</span></div>
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
var ajaxurl   = "<?php  echo $this->createMobileUrl('commission', array('op'=>'cashlog'));?>";
var loading = document.getElementById("loading");
$(function () {
    //根据页数读取数据  
    function getData(page) {  
        i++; //页码自动增加，保证下次调用时为新的一页。  
        $.get(ajaxurl, {page: page }, function (data) {  
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
        var mainDiv =$("#container");
        var chtml = '';
        for (var j = 0; j < result.length; j++) {
			if(result[j].status==0){
				var stustyle = ' style="color:#EA1B1B;"';
			}else if(result[j].status==1){
				var stustyle = ' style="color:#0EB90E;"';
			}else if(result[j].status==-1){
				var stustyle = ' style="color:#ABABAB;"';
			}
            chtml += '<div class="cashlog_list">';  
            chtml += '	<div class="left">'; 
			chtml += '		<div class="inner"><span>申请时间: ' + result[j].addtime + '</span><br><span>提现方式: ' + result[j].cash_way + '</span><br><span>备注: ' + result[j].remark + '</span></div>';
			chtml += '	</div>';
			chtml += '	<div class="right"><span>' + result[j].cash_num + ' 元</span><br>状态: <em '+stustyle+'>' + result[j].statu + '</em><br> 提现编号: ' + result[j].id + '</div>';
			chtml += '</div>'; 
        }
		mainDiv.append(chtml);
		if(result.length==0){
			document.getElementById("loading_div").innerHTML='<div class="loading_bd">没有了，已经到底啦</div>';
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
