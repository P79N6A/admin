<?php defined('IN_IA') or exit('Access Denied');?><!DOCTYPE html><html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>收货地址</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <meta name="format-detection" content="telephone=no" />
    <meta name="apple-mobile-web-app-status-bar-style" content="black" />
    <link rel="stylesheet" type="text/css" href="<?php echo MON_XKWKJ_RES;?>css/wkjm2.11.min.css?v=20170605" />
    <script src="<?php echo MON_XKWKJ_RES;?>js/jquery_min.js" type="text/javascript"></script>
</head>
<body><link href="<?php echo MON_XKWKJ_RES;?>css/shop_header.css?v=20170605" rel="stylesheet" type="text/css">
<section class="shop_header clearfix">
    <a href="javascript:history.back(-1);"><span id="shop_header_back">&nbsp;</span></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    <!--<span id="shop_header_more"><a></a><a></a><a></a></span>-->
</section>
<!--<div id="shop_header_list" style="display:none">-->
    <!--&lt;!&ndash;<ul>&ndash;&gt;-->
        <!--&lt;!&ndash;<li><a href="plugin.php?id=tom_shop&amp;mod=index">首 页</a></li>        <li><a href="plugin.php?id=tom_pintuan&amp;mod=index">拼团商城</a></li>        <li><a href="plugin.php?id=tom_weikanjia&amp;mod=index">砍价商城</a></li>        <li><a href="plugin.php?id=tom_coupon&amp;mod=index">优惠券</a></li>    </ul>&ndash;&gt;-->
<!--&lt;!&ndash;</div>&ndash;&gt;-->
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
<div class="PersonalCenter" id="PersonalCenter">
    <div class="PersonalDatum" id="setUpMain">

        <div class="PersonalDatumUnit clearfix">
            <div class="PublicFuzhuJsk"></div>
            <div class="col-xs-4 qcPadding MenuName">收货地址</div>
            <div class="col-xs-8 qcPadding text-right">
                <img class="ChoiceMenu text-right active" src="<?php echo MON_XKWKJ_RES;?>images/mcindextp5.png" alt="" />
            </div>
        </div>

        <div class="AddressList">
            <!-- item start -->


            <?php  if(is_array($addresses)) { foreach($addresses as $address) { ?>
            <div class="AddressSubList clearfix">
                <div class="col-xs-1 qcPadding">
                    <?php  if($address['is_default'] == 1) { ?>
                       <img class="AddressChoice" src="<?php echo MON_XKWKJ_RES;?>images/choice.png" alt="" />
                    <?php  } else { ?>
                       <img class="AddressChoice" src="<?php echo MON_XKWKJ_RES;?>images/nochoice.png" alt="" />
                    <?php  } ?>
                </div>
                <a href="<?php  if(empty($kid)) { ?><?php  echo $this->createMobileUrl('editAddress',  array('aid'=> $address['id'], 'op'=> 'display'),true)?><?php  } else { ?> <?php  echo $this->createMobileUrl('submitOrder',array('kid'=> $kid, 'addid'=> $address['id']),true)?><?php  } ?>"  class="col-xs-11 qcPadding AddressNews">
                    <div>
                        <span class="addressee"><?php  echo $address['uname'];?></span>
                        <span class="tel"><?php  echo $address['tel'];?></span>
                    </div>
                    <div class="address"><?php  echo $address['address'];?></div>
                </a>
            </div>
            <?php  } } ?>
            <!-- item end -->
            <div class="AddAddress">
                <a href="<?php  echo $this->createMobileUrl('editAddress',  array('op'=> 'add', 'kid'=> $kid ),true)?>">+添加新地址</a>
            </div>
        </div>
    </div>
    <!-- bottom nav start -->
    <div class="bottom_block clearfix"></div>

    <!--<div class="bottomColumn">-->
        <!--<ul class="ul1 clearfix">-->
            <!--<li><a class="kanjia" href="<?php  echo $this->createMobileUrl('HomeIndex', array(), true)?>"></a></li>-->
            <!--<li><a class="orders" href="<?php  echo $this->createMobileUrl('order',  array(),true)?>"></a></li>-->
            <!--<li><a class="wodeShow" href="<?php  echo $this->createMobileUrl('ucenter',  array(),true)?>"></a></li>-->
        <!--</ul>-->
    <!--</div>-->
    <!-- bottom nav end -->
    <div class="FuzhuShade"></div>
</div>
<div style="display: none;"></div>


</body>
</html>