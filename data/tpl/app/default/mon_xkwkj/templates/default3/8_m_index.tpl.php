<?php defined('IN_IA') or exit('Access Denied');?><!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge,chrome=1">
    <!--<meta name="viewport"-->
          <!--content="width=device-width, initial-scale=1.0, user-scalable=0, minimum-scale=1.0, maximum-scale=1.0">-->


    <meta name="viewport" content="width=device-width,height=device-height,initial-scale=1.0,maximum-scale=1.0,user-scalable=no">

    <title><?php  echo $xkwkj['title'];?></title>

    <link rel="stylesheet" type="text/css"  href="<?php echo MON_XKWKJ_RES;?>template/mobile/templates/default3/css/sweet-alert.css" />
    <script type="text/javascript" src="<?php echo MON_XKWKJ_RES;?>template/mobile/templates/default3/js/sweet-alert.min.js"></script>
    <link rel="stylesheet" type="text/css" href="<?php echo MON_XKWKJ_RES;?>template/mobile/templates/default3/css/main.css?v=3">
    <link rel="stylesheet" type="text/css" href="<?php echo MON_XKWKJ_RES;?>template/mobile/templates/default3/css/mui.min.css">
    <link rel="stylesheet" type="text/css" href="<?php echo MON_XKWKJ_RES;?>template/mobile/templates/default3/css/index.css">
    <link rel="stylesheet" type="text/css" href="<?php echo MON_XKWKJ_RES;?>template/mobile/templates/default3/css/animate.css">
    <link rel="stylesheet" type="text/css" href="<?php echo MON_XKWKJ_RES;?>template/mobile/templates/default2/css/jquery.flipcountdown.css"/>
    <script src="<?php echo MON_XKWKJ_RES;?>template/mobile/templates/default3/js/zepto.js" type="text/javascript" type="text/javascript"></script>
    <script src="<?php echo MON_XKWKJ_RES;?>template/mobile/templates/default3/js/jquery.js" type="text/javascript"></script>
    <script src="<?php echo MON_XKWKJ_RES;?>template/mobile/templates/default3/js/jquery.flipcountdown.js" type="text/javascript"></script>

    <meta content="yes" name="apple-mobile-web-app-capable">
    <?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('share', TEMPLATE_INCLUDEPATH)) : (include template('share', TEMPLATE_INCLUDEPATH));?>

    </script>

    <script>
        $(function () {

            <?php  if(TIMESTAMP <$xkwkj['endtime']) { ?>
                    var NY =<?php  echo $xkwkj['endtime'];?>;
                    $('#new_year').flipcountdown({
                        size: "xs", tick: function () {
                            var nol = function (h) {
                                return h > 9 ? h : '0' + h;
                            }
                            var range = NY - Math.round((new Date()).getTime() / 1000), secday = 86400, sechour = 3600, days = parseInt(range / secday), hours = parseInt((range % secday) / sechour), min = parseInt(((range % secday) % sechour) / 60), sec = ((range % secday) % sechour) % 60;
                            return nol(days) + ' ' + nol(hours) + ' ' + nol(min) + ' ' + nol(sec) + ' ';
                        }
                    });
                    $(".xdsoft_digit2:eq(0)").text('天');
                    $(".xdsoft_digit2:eq(1)").text('时');
                    $(".xdsoft_digit2:eq(2)").text('分');
                    $(".xdsoft_digit2:eq(3)").text('秒');

                <?php  } ?>
        });

    </script>
    <style>
        .share-text {
            position: fixed;
            z-index: 15;
            top: 11px;
            right: 18px;
            width: 288px;
            height: 356px;
            background: url("<?php  echo MonUtil::defaultImg(MonUtil::$IMG_SHARE_BG,$zl)?>") no-repeat;
            -webkit-background-size: 100% auto;
            -moz-background-size: 100% auto;
            background-size: 100% auto;
        }

        .app-guide {
            background-color: rgba(0, 0, 0, .64);
            bottom: 0;
            box-shadow: 0 -1px 1px rgba(0, 0, 0, .1);
            height: 50px;
            left: 0;
            position: fixed;
            width: 100%;
            z-index: 1999;
        }
        .app-guide .guide-cont {
            display: block;
            padding: 4px 0 4px 20px;
            position: relative;
        }
        .app-guide .guide-close {
            height: 20px;
            left: 0;
            line-height: 999em;
            overflow: hidden;
            position: absolute;
            top: 0;
            width: 20px;
        }

        .app-guide .guide-close:before {
            background-color: #262626;
            border-radius: 28px;
            bottom: 2px;
            content: "";
            height: 28px;
            position: absolute;
            right: 3px;
            width: 28px;
        }

        .app-guide .guide-close:after {
            background: url("<?php echo MON_ZL_RES;?>/images/477096d1jw1esladaxya6j201v01w741.jpg")
            no-repeat scroll 0 0/9px auto rgba(0, 0, 0, 0);
            content: "";
            height: 9px;
            left: 2px;
            position: absolute;
            top: 4px;
            width: 9px;
        }

        .app-guide .guide-slogon, .app-guide .guide-dc {
            color: #fff;
            font-size: 16px;
            line-height: 20px;
            padding-left: 50px;
        }

        .app-guide .guide-logo {
            max-height: 42px;
            max-width: 42px;
            margin-right: 8px;
            vertical-align: top;
            border: 0 none;
            position: absolute;
        }

    </style>
</head>
<body class="index">



<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('templates/default3/kj_announcement', TEMPLATE_INCLUDEPATH)) : (include template('templates/default3/kj_announcement', TEMPLATE_INCLUDEPATH));?>

<header>

    <div class="banner-top">
        <div class="left-div" style="float: left"><span><font class="color-red"><?php  echo $xkwkj['vcount'];?></font>人查看</span> <font class="color-red"><?php  echo $xkwkj['sharecount'];?></font>人分享</span> <font class="color-red"><?php  echo $joinCount;?></font>人报名</span>  <span><font class="color-red">剩余<?php  echo $leftCount;?></font>件</span></div>
    </div>
    <banner>
        <div id="slider"><img src="<?php  echo MonUtil::getpicurl($goods['p_pic'])?>">

            <div class="banner-title color-white">  <a href="<?php  echo $goods['p_url'];?>" class="banner-title color-white" style="text-decoration: underline; "><?php  echo $xkwkj['title'];?></a></div>
        </div>
    </banner>
</header>


<main>
    <div class="mui-card-content">
        <div class="banner-time">


            <?php  if($status == $this::$KJ_STATUS_ZC) { ?>


            <?php  if(TIMESTAMP < $xkwkj['endtime']) { ?>
            <div style="height:23px;line-height:23px;text-align:center;">活动到期时间</div>
            <?php  } else { ?>
            <div style="height:23px;line-height:23px;text-align:center;">活动已结束</div>
            <?php  } ?>
            <?php  if(TIMESTAMP <$xkwkj['endtime']) { ?>
            <div id="new_year" style="text-align:center;"></div>
            <?php  } ?>

            <?php  } else { ?>
            <div>
                <div style="height:23px;line-height:23px;text-align:center;"><?php  echo $statusText;?></div>
            </div>
            <?php  } ?>

        </div>
    </div>


    <div class="mui-card-content mui-card-content1">
        <div class="left"><font class="color-orange">原价:</font> <font class="color-red"><?php  echo $xkwkj['p_y_price'];?>元</font></div>
        <div class="right"><font class="color-orange">底价:</font> <font class="color-red"><?php  echo $xkwkj['p_low_price'];?>元</font></div>
        <div class="clear"></div>
        <div class="card-button">
            <div class="container zlinfo" style="margin-top:10px">
                <h4><?php  echo $userInfo['nickname'];?>，<?php  echo $this->getTipMsg($xkwkj, $this::$TIP_U_FIRST)?></h4>
                <table style="border: 1px solid #c5c8d0;width:100%" cellspacing="0">
                    <tr>
                        <td style="padding: 8px 6px;border-bottom: 1px solid #c5c8d0;border-right:1px solid #c5c8d0;text-align:center">
                            昵称
                        </td>
                        <td style="border-bottom: 1px solid #c5c8d0;border-right:1px solid #c5c8d0;width:33%;text-align:center">
                            当前价格
                        </td>
                        <td style="border-bottom: 1px solid #c5c8d0;width:33%;text-align:center">已砍价格</td>
                    </tr>
                    <tr>
                        <td style="padding: 8px 6px;border-right:1px solid #c5c8d0;text-align:center"><?php  echo $userInfo['nickname'];?></td>
                        <td style="border-right:1px solid #c5c8d0;text-align:center"><font color="red"><strong><?php  echo $xkwkj['p_y_price'];?></strong></font>
                        </td>
                        <td style="text-align:center">0</td>
                    </tr>
                </table>



                <div class="act cf">


                    <?php  if($status == $this::$KJ_STATUS_ZC) { ?>

                    <?php  if($collectUserInfo) { ?>


                    <div class="baoming">
                        <form id="add_form"><input type="hidden" name="act" value="add"><input type="hidden" name="act_id"
                                                                                               value="3"><input
                                type="hidden" name="formhash" value="272781f3">
                            <dl>
                                <dt><em class="fred">*</em> 姓名：</dt>
                                <dd><input name="xm" id="xm" placeholder="请填写姓名" type="text"></dd>
                            </dl>
                            <dl>
                                <dt><em class="fred">*</em> 手机：</dt>
                                <dd><input name="tel" id="tel" placeholder="请填写手机号" type="text"></dd>
                            </dl>
                            <dl>
                                <dd><span class="showuerr"></span></dd>
                            </dl>
                        </form>
                        <a id="clearframe"></a>
                        <script></script>
                    </div>


                    <?php  } ?>

                    <a class="btn-base btn-3" href="javascript:kj()"><i></i><span>自砍一刀</span></a>
                    <?php  } else { ?>
                    <a class="btn-base btn-3" href="<?php  echo $xkwkj['zgg_url'];?>"><i></i><span>逛一逛</span></a>
                    <?php  } ?>
                </div>
            </div>
        </div>
    </div>



    <div class="mui-card-content">
        <div class="card-title card-text"><i></i>活动说明</div>
        <?php  echo $xkwkj['kj_intro'];?>
    </div>



    <div class="mui-card-content">
        <div class="card-title card-text"><i></i>排行榜</div>
        <div class="card-rank">

            <div class="joinList">
                <div class="container">
                    <article>

                        <ul class="scrollUl">
                            <li class="on" id="m01" >排行榜</li>
                            <li  id="m02" >帮砍团</li>
                        </ul>

                        <section>


                            <section id="srank">
                                <table class="wx_list" cellspacing="0">
                                    <tbody>
                                    <tr class="btitle">
                                        <td class="order" >排名</td>
                                        <td class="author" style="text-align: center" width="100px">昵称</td>
                                        <td class="order" width="30px" style="text-align: center" >头像</td>
                                        <td class="jphone" style="text-align: center" >砍掉金额</td>
                                        <td class="jphone" style="text-align: center" >当前金额</td>
                                    </tr>


                                    <!--<tr >-->
                                        <!--<td class="order"><?php  echo $index+1; ?></td>-->
                                        <!--<td class="author"  style="text-align: center" >灯防盗放沙发斯蒂芬<br/></td>-->
                                        <!--<td class="author" style="text-align: center" >33</td>-->
                                        <!--<td class="jphone" style="text-align: center" >33</td>-->
                                        <!--<td class="floor zhuli_c" style="text-align: center" >33</td>-->
                                    <!--</tr>-->



                                    <?php 
                                    for ($index = 0; $index <count($ranklist); $index++) {
                                        $rankuser = $ranklist[$index];
                                ?>
                                    <tr class=" <?php  if($index+1 <= $zl['top_tag']) {echo 'top ';} if(($index+1)%2 == 0 ) {echo 'two';}  ?>">
                                        <td class="order"><?php  echo $index+1; ?></td>
                                        <td class="author"  style="text-align: center" ><?php   echo $rankuser['nickname'];  ?></td>
                                        <td class="author" style="text-align: center" ><img src="<?php   echo $rankuser['headimgurl'];  ?>" height="30px;" width="30px"></td>
                                        <td class="jphone" style="text-align: center" ><?php  echo  round($xkwkj['p_y_price']-$rankuser['price'], 2) ?></td>
                                        <td class="floor zhuli_c" style="text-align: center" ><?php  echo $rankuser['price'] ; ?></td>
                                    </tr>
                                    <?php 
                                    }
                                ?>

                                    </tbody>
                                </table>
                            </section>


                            <section id="shelp" style="display: none">
                                <table class="wx_list" cellspacing="0">
                                    <tbody>
                                    <tr class="btitle">
                                        <td class="order" style="text-align: center">帮砍昵称</td>
                                        <td class="order" style="text-align: center" >帮砍头像</td>
                                        <td class="author" style="text-align: center">砍掉金额</td>
                                    </tr>
                                    <tr class=" ">
                                        <td class="order" colspan="3"><font color="red">暂无帮砍团，赶快参加活动吧！！！</font></td>
                                    </tr>
                                    </tbody>
                                </table>
                            </section>


                        </section>
                    </article>
                </div>
            </div>

        </div>
    </div>

    <?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('shotmenu', TEMPLATE_INCLUDEPATH)) : (include template('shotmenu', TEMPLATE_INCLUDEPATH));?>
    <?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('follow', TEMPLATE_INCLUDEPATH)) : (include template('follow', TEMPLATE_INCLUDEPATH));?>

</main>

<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('templates/default3/foot', TEMPLATE_INCLUDEPATH)) : (include template('templates/default3/foot', TEMPLATE_INCLUDEPATH));?>

<script src="<?php echo MON_XKWKJ_RES;?>template/mobile/templates/default2/js/view.js" type="text/javascript" type="text/javascript"></script>
<script src="<?php echo MON_XKWKJ_RES;?>template/mobile/templates/default2/js/main.js" type="text/javascript" type="text/javascript"></script>

<script>

    var collectUserInfo = false;
        <?php  if($collectUserInfo) { ?>
        var collectUserInfo = true;
     <?php  } ?>

     var submintStatus = 0;

         function kj() {

        if (submintStatus == 1) {
            tipMsg("提交中，请稍后不要多次提交");
            return ;
        }

        if (collectUserInfo) {
            var uname = $("#xm").val();
            var tel = $("#tel").val();

            if (uname== '') {
                tipMsg("请输入用户名");
                return;
            }

            if (!/1[3-8]+\d{9}/.test(tel)) {
                tipMsg("请输入正确的联系方式");
                return ;
            }
        }

        if (!inlimitLocation) {
            tipMsg("对不起!未获取到您的位置信息，或您不在活动地区限制范围内！无法参与活动！感谢您的参与！");
            return;
        }


        submintStatus = 1;
        $.ajax({
            type: "POST",
            dataType:'json',
            url: "<?php  echo $this->createMobileUrl('SelfKj',array('kid'=>$xkwkj['id'], 'fu'=> $fu),true)?>",
            data:{"funame":uname,"futel":tel, "weapon_seq": 1, "name_seq": 1},
            success: function (res) {
                submintStatus = 0;

                if (res.code !=1 ) {

                    if (res.code == 2) {
                        showFollow(true);
                    } else {
                        tipMsg(res.msg);
                    }
                } else {
                    swal({
                                title: "提示",
                                text: "太棒了，砍掉了" + res.price + "元!赶快邀请小伙伴帮您砍价吧！",
                                type: "success",
                                showCancelButton: false,
                                confirmButtonColor: "#DD6B55",
                                confirmButtonText: "确定",
                                closeOnConfirm: true },
                            function(){
                                window.location.reload();
                            });
                }
            }
        });

    }


    $(function() {
        $("#m01").click(function(){
            $(this).addClass("on");
            $("#m02").removeClass("on");
            $("#srank").show();
            $("#shelp").hide();
          }
        );

        $("#m02").click(function(){
                    $(this).addClass("on");
                    $("#m01").removeClass("on");

                    $("#srank").hide();
                    $("#shelp").show();

                }
        );

    });

    function checkMobile(s) {
        var regu = /^[1][3|7|8|4|5][0-9]{9}$/;
        var re = new RegExp(regu);
        if (re.test(s)) {
            return true;
        } else {
            return false;
        }
    }

    function tipMsg(txt){

        swal({
                    title: "提示",
                    text: txt,
                    type: "warning",
                    showCancelButton: false,
                    confirmButtonColor: "#DD6B55",
                    confirmButtonText: "确定",
                    closeOnConfirm: true },
                function(){

                });
    }

    $(function(){

    });


    function showFollowDialog() {
        showFollow(true);
    }

</script>

<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('gmusic', TEMPLATE_INCLUDEPATH)) : (include template('gmusic', TEMPLATE_INCLUDEPATH));?>

</body>
</html>