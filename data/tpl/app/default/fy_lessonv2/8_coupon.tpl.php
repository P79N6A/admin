<?php defined('IN_IA') or exit('Access Denied');?><!-- 
 * 优惠券管理
 * ============================================================================
 * 版权所有 2015-2017 风影随行，并保留所有权利。
 * 网站地址: http://www.haoshu888.com
 * ----------------------------------------------------------------------------
 * 这不是一个自由软件！不允许对程序代码以任何形式任何目的的再发布，作者将保留
 * 追究法律责任的权力和最终解释权。
-->
<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('_headerv2', TEMPLATE_INCLUDEPATH)) : (include template('_headerv2', TEMPLATE_INCLUDEPATH));?>
<link href="<?php echo MODULE_URL;?>template/mobile/style/cssv2/coupon.css?v=<?php  echo $versions;?>" rel="stylesheet"/>
<style type="text/css">
.tabbar_wrap {
	-webkit-overflow-scrolling: unset;
}
</style>
<div class="header-2 cbox">
	<a href="javascript:history.go(-1);" class="ico go-back"></a>
	<div class="flex title"><?php  echo $title;?></div>
</div>

<div id="loading" style="position:fixed;top:0;left:0;width:100%;height:100%;background:rgba(0,0,0,0.6);z-index:100000000;"><div class="spinner"><div class="bounce1"></div><div class="bounce2"></div><div class="bounce3"></div></div></div>

<?php  if($op=='display') { ?>
<!-- 顶部导航  -->
<ul class="tab_wrap">
	<li class="tab_item <?php  if($_GPC['status']=='0' || $_GPC['status']=='') { ?>tab_item_on<?php  } ?>">
		<a href="<?php  echo $this->createMobileUrl('coupon', array('status'=>'0'));?>">未使用</a>
	</li>
	<li class="tab_item <?php  if($_GPC['status']=='1') { ?>tab_item_on<?php  } ?>">
		<a href="<?php  echo $this->createMobileUrl('coupon', array('status'=>1));?>">已使用</a>
	</li>
	<li class="tab_item <?php  if($_GPC['status']=='-1') { ?>tab_item_on<?php  } ?>">
		<a href="<?php  echo $this->createMobileUrl('coupon', array('status'=>-1));?>">已过期</a>
	</li>
</ul>
<!-- /顶部导航  -->

<?php  if(!empty($list)) { ?>
<div>
	<div class="pepper-con">
		<div class="pepper-w">
		</div>
	</div>
	<div class="more-pepper"><a href="<?php  echo $this->createMobileUrl('coupon', array('op'=>'addCoupon'));?>">课程优惠码转换 <i class="fa fa-exchange"></i></a></div>
</div>
<?php  } else { ?>
<div class="my_empty" style="height:40%;top:89px;">
	<div class="empty_bd  my_course_empty">
		<h3>没有找到任何优惠券~</h3>
	</div>
</div>
<div class="more-pepper" style="margin-top:75%;"><a href="<?php  echo $this->createMobileUrl('coupon', array('op'=>'addCoupon'));?>">课程优惠码转换 <i class="fa fa-exchange"></i></a></div>
<?php  } ?>
<div class="more-pepper"><a href="<?php  echo $this->createMobileUrl('getcoupon');?>">更多好券，去兑换中心看看 <i class="fa fa-long-arrow-right"></i></a></div>

<div id="loading_div" class="loading_div">
	<a href="javascript:void(0);" id="btn_Page">加载更多</a>
</div>

<script type="text/javascript">
function GetQueryString(name) {
	var reg = new RegExp("(^|&)" + name + "=([^&]*)(&|$)");
	var r = window.location.search.substr(1).match(reg);
	if(r != null) return unescape(r[2]);
	return null;
}

var i = 1; //设置当前页数，全局变量
var status = GetQueryString('status');
var ajaxurl   = "<?php  echo $this->createMobileUrl('coupon');?>";
var loading = document.getElementById("loading");
$(function () {
    //根据页数读取数据  
    function getData(page) {  
        i++; //页码自动增加，保证下次调用时为新的一页。  
        $.get(ajaxurl, {page: page, status:status}, function (data) {  
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
        var mainDiv =$(".pepper-w");
        var chtml = '';  
        for (var j = 0; j < result.length; j++) {  
            chtml += '<div class="pepper '+ result[j].classname +'">';  
            chtml += '	 <div class="pepper-l">'; 
			chtml += '		<p class="pepper-l-num">';
			chtml += '			<span> ¥'+ result[j].amount +'</span>';
			chtml += '		</p>';
			chtml += '		<p class="pepper-l-con">使用条件：课程金额满'+ result[j].conditions +'元，' +result[j].category_name+ '可使用</p>';
			chtml += '	</div>';
			chtml += '	<div class="pepper-r">';
			chtml += '		<span>课程券</span>';		
			chtml += '		<div>'+ result[j].startDate +'<br>'+ result[j].startTime +'<p class="pepper-line">~</p>'+ result[j].endDate +'<br>'+ result[j].endTime +'</div>';
			chtml += '		<i class="right-arrow"></i>'; 
			chtml += '	</div>';
			chtml += '</div>';
			if(result[j].classname=='pepper-red'){
			chtml += '<div class="pepper-b">';
			chtml += '	<div class="pb-con">获取途径：' +result[j].source_name+ '</div>';
			chtml += '	<div class="pb-border"></div>';
			chtml += '</div>';
			}else{
			chtml += '<div class="pepper-b">';
			chtml += '	<div class="pb-con" style="background:#949393;">获取途径：' +result[j].source_name+ '</div>';
			chtml += '</div>';
			}
        }
		mainDiv.append(chtml);
		if(result.length==0){
			document.getElementById("loading_div").innerHTML='<div class="loading_bd" style="height:17px;">没有了，已经到底啦</div>';
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

<?php  } else if($op=='addCoupon') { ?>
<div class="vipcard">
	<form method="post" action="" onsubmit="return checknum();">
		<div class="balance_num">
			<label class="vipcard-title">请输入课程优惠码：</label>
			<input type="text" name="card_password" id="card_password" value="<?php  echo $_GPC['code'];?>" style="width:90%; height:38px; font-size:16px; margin:auto; border:1px solid #eee; padding:0px 2%; text-align:center;">
		</div>
		<div class="balance_num">
			<input type="submit" name="submit" class="balance_sub" value="立即转换" />
			<input type="hidden" name="token" value="<?php  echo $_W['token'];?>" />
		</div>
	</form>
</div>

<script type="text/javascript">
document.getElementById("loading").style.display = 'none';

function checknum(){
	var card_password = $("#card_password").val();
	if(card_password==''){
		alert("请输入课程优惠码");
		return false;
	}
	document.getElementById("loading").style.display = 'block';
}
</script>
<?php  } ?>

<footer>
    <a href="<?php  echo $this->createMobileUrl('index');?>"><?php  echo $setting['copyright'];?></a>
</footer>

<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('_footerv2', TEMPLATE_INCLUDEPATH)) : (include template('_footerv2', TEMPLATE_INCLUDEPATH));?>