<?php defined('IN_IA') or exit('Access Denied');?><!DOCTYPE html><html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>我的订单</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <meta name="format-detection" content="telephone=no" />
    <meta name="apple-mobile-web-app-status-bar-style" content="black" />
    <link rel="stylesheet" type="text/css" href="<?php echo MON_XKWKJ_RES;?>css/wkjm2.11.min.css?v=20170605" />
    <script src="<?php echo MON_XKWKJ_RES;?>js/jquery_min.js" type="text/javascript"></script>

    <script src="<?php echo MON_XKWKJ_RES;?>js/common.js" type="text/javascript" type="text/javascript"></script>
</head>
<body><link href="<?php echo MON_XKWKJ_RES;?>css/shop_header.css" rel="stylesheet" type="text/css">
<section class="shop_header clearfix">
    <a href="javascript:history.back(-1);"><span id="shop_header_back">&nbsp;</span></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    <!--<span id="shop_header_more"><a></a><a></a><a></a></span>-->
</section>
<div id="shop_header_list" style="display:none">
    <ul>
        <!--<li><a href="plugin.php?id=tom_shop&amp;mod=index">首 页</a></li>      -->
        <!--<li><a href="plugin.php?id=tom_pintuan&amp;mod=index">拼团商城</a></li>   -->
        <!--<li><a href="plugin.php?id=tom_weikanjia&amp;mod=index">砍价商城</a></li>     -->
        <!--<li><a href="plugin.php?id=tom_coupon&amp;mod=index">优惠券</a></li>   -->
    </ul>
</div>
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
<div class="order">
    <div class="AllOrders">
        <div class="AllOrdersMenu">
            <div class="AllOrdersSubMenu <?php  if(empty($status)) { ?>active<?php  } ?>" onclick="window.location.href='<?php  echo $this->createMobileUrl('order',  array(),true)?>';">全部</div>
            <span class="biankuangK"></span>
            <div class="AllOrdersSubMenu <?php  if($status == 1) { ?>active<?php  } ?>" onclick="window.location.href='<?php  echo $this->createMobileUrl('order',  array('status'=>1),true)?>';">待付款</div>
            <span class="biankuangK"></span>
            <div class="AllOrdersSubMenu <?php  if($status == 2) { ?>active<?php  } ?>" onclick="window.location.href='<?php  echo $this->createMobileUrl('order',  array('status'=>2),true)?>';">待发货</div>
            <span class="biankuangK"></span>
            <div class="AllOrdersSubMenu <?php  if($status == 3) { ?>active<?php  } ?>" onclick="window.location.href='<?php  echo $this->createMobileUrl('order',  array('status'=>3),true)?>';">已发货</div>
        </div>

        <div class="orderlist">
            <!-- item start -->
            <?php  if(is_array($orders)) { foreach($orders as $order) { ?>
                <div class="MyOrders">
                    <a href="<?php  echo $this->createMobileUrl('OrderDetail',array('kid'=>$order['kid'],'uid'=>$order['uid']),true)?>">
                            <div class="clearfix">
                                <div class="col-xs-9 qcPadding">订单号：<span class="dingdanhao"><?php  echo $order['order_no'];?></span></div>
                                <div class="col-xs-3 qcPadding state"><?php  echo $this->getOrderStatus($order['status'], $order['pay_type'])?></div>
                            </div>
                            <div class="SubGoods clearfix">

                                    <div class="col-xs-3 qcPadding">
                                        <img src="<?php  echo MonUtil::getpicurl($order['goods_preview_pic'])?>" />
                                    </div>

                                <div class="col-xs-9 qcPadding clearfix">
                                    <div class="col-xs-9 qcPadding OrdersNews">
                                        <h4><?php  echo $order['goods_name'];?></h4>
                                        <div class="OrdersSubNews"><?php  echo date("Y-m-d H:i",$order['ocreatetime'])?></div>
                                    </div>
                                    <div class="col-xs-3 qcPadding text-right OrdersPay">
                                        <div class="PayPlace">￥<span><?php  echo $order['total_price'];?></span></div>
                                        <div class="PayPlace"><?php  if($order['pay_type']== self::PAY_TYPE_WX) { ?>在线支付<?php  } ?><?php  if($order['pay_type']== self::PAY_ZT) { ?>线下收款<?php  } ?></div>
                                    </div>
                                </div>
                            </div>
            </a>
                    <div class="MyOrdersBtn">
                        <!--<a href="javascript:;" onclick="cancelpay(446);" class="DelOrders">取消订单</a>-->

                        <?php  if($order['status'] == $this::$KJ_STATUS_XD && $order['pay_type']== self::PAY_TYPE_WX) { ?>
                                <a href="<?php  echo $this->createMobileUrl('OrderDetail',array('kid'=>$order['kid'],'uid'=>$order['uid']),true)?>"  class="SoonPay">立即付款</a>
                        <?php  } ?>


                        <?php  if($order['pay_type'] == self::PAY_ZT && $order['status']== $this::$KJ_STATUS_XD) { ?>


                             <a href="<?php  echo $this->createMobileUrl('OrderDetail',array('kid'=>$order['kid'],'uid'=>$order['uid']),true)?>"  class="DelOrders">已下单</a>
                        <?php  } ?>

                        <?php  if($order['status']!= $this::$KJ_STATUS_XD) { ?>
                               <a href="<?php  echo $this->createMobileUrl('OrderDetail',array('kid'=>$order['kid'],'uid'=>$order['uid']),true)?>"  class="DelOrders"><?php  echo $this->getOrderStatus($order['status'], $order['pay_type'])?></a>
                        <?php  } ?>

                    </div>
                </div>


            <?php  } } ?>
            <!-- item end -->



            <!--<div class="pages clearfix">-->
                <!--<ul class="clearfix">-->
                    <!--<li style="width: 40%;"><span>上一页</span></li>-->
                    <!--<li style="width: 20%;"><span>1/1</span></li>-->
                    <!--<li style="width: 40%;"><span>下一页</span></li>-->
                <!--</ul>-->
            <!--</div>-->

        </div>
    </div>
    <!-- bottom nav start -->
    <div class="bottom_block clearfix"></div>
    <div class="bottomColumn">
        <ul class="ul1 clearfix">
            <div class="bottomColumn">
                <ul class="ul1 clearfix">
                    <li><a class="kanjia" href="<?php  echo $this->createMobileUrl('HomeIndex', array(), true)?>"></a></li>
                    <li><a class="ordersShow" href="<?php  echo $this->createMobileUrl('order',  array(),true)?>"></a></li>
                    <li><a class="wode" href="<?php  echo $this->createMobileUrl('ucenter',  array(),true)?>"></a></li>
                </ul>
            </div>
        </ul>
    </div>
    <!-- bottom nav end -->
</div>
</body>
</html>