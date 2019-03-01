<?php defined('IN_IA') or exit('Access Denied');?><!DOCTYPE html><html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>个人中心</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <meta name="format-detection" content="telephone=no" />
    <meta name="apple-mobile-web-app-status-bar-style" content="black" />
    <link rel="stylesheet" type="text/css" href="<?php echo MON_XKWKJ_RES;?>css/wkjm2.11.min.css?v=11" />
    <script src="<?php echo MON_XKWKJ_RES;?>js/jquery_min.js" type="text/javascript"></script>
    <script type="text/javascript">var commonjspath = 'source/plugin/tom_weikanjia/images';</script>
    <script src="<?php echo MON_XKWKJ_RES;?>js/common.js" type="text/javascript" type="text/javascript"></script>
</head>
<body><link href="<?php echo MON_XKWKJ_RES;?>css/shop_header.css" rel="stylesheet" type="text/css">
<link href="<?php echo MON_XKWKJ_RES;?>css/home.css" rel="stylesheet" position="3">
<section class="shop_header clearfix">
    <a href="javascript:history.back(-1);"><span id="shop_header_back">&nbsp;</span></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    <!--<span id="shop_header_more"><a></a><a></a><a></a></span>-->
</section>
<!--<div id="shop_header_list" style="display:none">-->
    <!--&lt;!&ndash;<ul>&ndash;&gt;-->
        <!--&lt;!&ndash;<li><a href="plugin.php?id=tom_shop&amp;mod=index">首 页</a></li>&ndash;&gt;-->
        <!--&lt;!&ndash;<li><a href="plugin.php?id=tom_pintuan&amp;mod=index">拼团商城</a></li>&ndash;&gt;-->
        <!--&lt;!&ndash;<li><a href="plugin.php?id=tom_weikanjia&amp;mod=index">砍价商城</a></li>&ndash;&gt;-->
        <!--&lt;!&ndash;<li><a href="plugin.php?id=tom_coupon&amp;mod=index">优惠券</a></li>&ndash;&gt;-->
    <!--&lt;!&ndash;</ul>&ndash;&gt;-->
<!--</div>-->
<script language="javascript">
    var show_list_tab = 0;
    $("#shop_header_more").click( function (){
        if(show_list_tab == 1){
            show_list_tab = 0;
            $("#shop_header_list").hide();
        }else{
            show_list_tab = 1;
            $("#shop_header_list").show();
        }
    });
</script>
<div class="mcIndex gyStyleBj">
    <div class="renwuInfo">
        <img class="bjImg img-responsive" src="<?php echo MON_XKWKJ_RES;?>images/myindextp1.jpg"/>
        <div class="infoXq">
            <div class="touxiangk">
                <a href="#"><img src="<?php  echo $fansInfo['headimgurl'];?>" /></a>
            </div>
            <p class="nicheng"><?php  echo $fansInfo['nickname'];?></p>
            <div class="lanmulist">
                <!--<ul class="row qingchu ul1">-->
                    <!--&lt;!&ndash;<li class="qcPadding col-xs-6"><a href="<?php  echo $this->createMobileUrl ( 'auth',array('au'=>Value::$REDIRECT_MY_KJ))?>"><p><?php  echo $joinCount;?></p><p class="titleTextK">我的砍价</p></a></li>&ndash;&gt;-->
                    <!--&lt;!&ndash;<li class="qcPadding col-xs-6"><a href="#"><p><?php  echo $helpCount;?></p><p class="titleTextK">我帮砍的</p></a></li>&ndash;&gt;-->
                <!--</ul>-->
            </div>
        </div>
    </div>
    <div class="dingdank">
        <ul class="ul3 gyListYi">
            <li>
                <a href="<?php  echo $this->createMobileUrl('order',  array(),true)?>" class="row qingchu">
                    <div class="leftk qcPadding col-xs-5">
                        <img src="<?php echo MON_XKWKJ_RES;?>images/mcindextpS4.png" />
                        <span>全部订单</span>
                    </div>
                    <div class="rightk qcPadding col-xs-7">
                        <span>查看全部已下单商品</span>
                        <img src="<?php echo MON_XKWKJ_RES;?>images/mcindextp5.png" />
                    </div>
                </a>
            </li>
        </ul>
        <ul class="ul4 row qingchu">
            <li class="col-xs-4 qcPadding daifukuan">
                <a href="<?php  echo $this->createMobileUrl('order',  array('status'=>1),true)?>">
                    <div class="iconK">
                        <img src="<?php echo MON_XKWKJ_RES;?>images/mcindextp9.png" class="tuBianxiao" />
                        <?php  if($waitePayCount > 0) { ?><em><?php  echo $waitePayCount;?> </em><?php  } ?>
                    </div>
                    <span>待付款</span>
                </a>
            </li>
            <li class="col-xs-4 qcPadding daifahuo">
                <a href="<?php  echo $this->createMobileUrl('order',  array('status'=>$this::$KJ_STATUS_GM),true)?>">
                    <div class="iconK">
                        <img src="<?php echo MON_XKWKJ_RES;?>images/mcindextp10.png" class="tuBianxiao" />
                    </div>
                    <span>待发货</span>
                </a>
            </li>
            <li class="col-xs-4 qcPadding daishouhuo">
                <a href="<?php  echo $this->createMobileUrl('order',  array('status'=>$this::$KJ_STATUS_YFH),true)?>">
                    <div class="iconK">
                        <img src="<?php echo MON_XKWKJ_RES;?>images/mcindextp11.png" class="tuBianxiao" />
                    </div>
                    <span>已发货</span>
                </a>
            </li>
        </ul>
    </div>
    <div class="qitaList">
        <ul class="ul5 gyListYi">
            <li>
                <a href="<?php  echo $this->createMobileUrl('myaddress',  array(),true)?>" class="row qingchu">
                    <div class="leftk qcPadding col-xs-5">
                        <img src="<?php echo MON_XKWKJ_RES;?>images/mcindextp13.png"/>
                        <span>收货地址</span>
                    </div>
                    <div class="rightk qcPadding col-xs-7">
                        <span></span>
                        <img src="<?php echo MON_XKWKJ_RES;?>images/mcindextp5.png" />
                    </div>
                </a>
            </li>



            <li>
                <a href="<?php  echo $this->createMobileUrl ( 'auth',array('au'=>Value::$REDIRECT_MY_KJ))?>" class="row qingchu wkjCard">
                    <div class="leftk qcPadding col-xs-5">
                        <img src="<?php echo MON_XKWKJ_RES;?>images/lm_icon1.png">
                        <span>我的砍价</span>
                    </div>
                    <div class="rightk qcPadding col-xs-7">
                        <span><?php  echo $joinCount;?></span>
                        <img src="<?php echo MON_XKWKJ_RES;?>images/mcindextp5.png">
                    </div>
                </a>
            </li>
        </ul>
    </div>
</div>


<footer class="home-footer">
    <ul>
        <li ><a href="<?php  echo $this->createMobileUrl('HomeIndex', array(), true)?>"><i></i>首页</a></li>
        <li onclick="openCustomer()"><a><i></i>联系客服</a></li>
        <li  class="select"><a href="<?php  echo $this->createMobileUrl('ucenter',  array(),true)?>"><i></i>个人中心</a></li>
    </ul>
</footer>


<style>
    .customer_service {
        position: fixed;
        width: 100%;
        height: 100%;
        top: 0;
        left: 0;
        z-index: 9999;
    }

    .customer_service .misk {
        position: absolute;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.3);
        text-align: center;
        z-index: -1;
    }

    .customer_content {
        width: 200px;
        margin: 135px auto;
        text-align: center;
        background: white;
        padding-bottom: 5px;
    }

    .customer_content img {
        width: 200px;
        height: 200px;
        margin-bottom: 5px;
    }

    .customer_content a {
        color: #635E5E;
        font-size: 0.9rem;
    }
</style>
<div class="customer_service" id="customer_service" style="display: none">
    <div class="misk" onclick="closeCustomer()"></div>
    <div class="customer_content">
        <img src="<?php  echo MonUtil::getpicurl($this->xkkjSetting['kf'])?>"/>
        <a href="tel:"></a>
    </div>
</div>



<script>
    function openCustomer() {
        if ($(".customer_service").css("display") == "none") {
            $(".customer_service").css("display", "block");
        } else {
            $(".customer_service").css("display", "none");
        }
    }
    function closeCustomer() {
        $(".customer_service").css("display", "none");
    }
</script>




</body>
</html>