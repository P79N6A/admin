<?php defined('IN_IA') or exit('Access Denied');?><!DOCTYPE html>
<html lang="zh-CN" ng-app="WmallAPP">
<head><title><?php  echo $xkwkj['title'];?></title>
    <meta charset="utf-8">
    <meta content="" name="description">
    <meta content="" name="keywords">
    <meta content="eric.wu" name="author">
    <meta content="application/xhtml+xml;charset=UTF-8" http-equiv="Content-Type">
    <meta content="telephone=no, address=no" name="format-detection">
    <meta content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no"
          name="viewport">
    <link href="<?php echo MON_XKWKJ_RES;?>css/reset.css" rel="stylesheet"/>
    <link href="<?php echo MON_XKWKJ_RES;?>css/common.css" rel="stylesheet"/>
    <link href="<?php echo MON_XKWKJ_RES;?>css/bargain.css?v=4" rel="stylesheet"/>

    <link rel="stylesheet" type="text/css"
          href="<?php echo MON_XKWKJ_RES;?>/css/sweet-alert.css">
    <script type="text/javascript" src="<?php echo MON_XKWKJ_RES;?>/js/sweet-alert.min.js"></script>
    <style>
        *[data-mask='help'] .help_pic{
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: url(php echo MonUtil::defaultImg(MonUtil::$IMG_SHARE_BG,$xkwkj)}) no-repeat center top rgba(0,0,0,0.93);
            background-size: 100%;
            z-index: 100;
        }


        .leftk {
            float: left;
            width: 80px;
            text-align: right;
            margin-top: 4px;
            margin-left: 10px;
        }

        .clearfix {
            zoom: 1;
        }

        .regist {
            border: 1px solid #ffffff;
            width: 100%;
            height: 100%;
            text-align: center;

        }

        .regist li {
            list-style: none;
            padding: 0;
            margin-top: 20px;
            margin-bottom: 20px;

        }



    </style>
    <script src="<?php echo MON_XKWKJ_RES;?>js/jquery_min.js"></script>
    <?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('headcss', TEMPLATE_INCLUDEPATH)) : (include template('headcss', TEMPLATE_INCLUDEPATH));?>
    <?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('share', TEMPLATE_INCLUDEPATH)) : (include template('share', TEMPLATE_INCLUDEPATH));?>
    <script>
        var  basePath = "<?php echo MON_XKWKJ_RES;?>";
        var collectUserInfo = false;
        <?php  if($collectUserInfo) { ?>
            var collectUserInfo = true;
        <?php  } ?>

        APP = {
            config: {
                needTime: true, //是否需要计时，如果不需要请设为false，这很重要，因为倒计时到点时js会自动刷新页面
                time: {
                    currentTime: "<?php  echo $curtime;?>",
                    calcWhat: "end",
                    //计算距离开始的时间填"start", 计算距离结束的时间填"end"
                    startTime: "<?php  echo $starttime;?>",//活动开始时间(请按此字符串格式赋值)
                    endTime: "<?php  echo $endtime;?>",//活动结束时间（请按此字符串格式赋值）
                }, cut_amount: <?php  echo $kjPrice;?>
            },
            urls: {
                cut_list: '<?php  echo $this->createMobileUrl('KjFirendList',array('uid'=>$user['uid']), true)?>'

            }
        }

    </script>
    <script src="<?php echo MON_XKWKJ_RES;?>js/sea.js"></script>
    <script>            (function (l) {
        seajs.config({
            base: "./",
            map: [[".js", (l && l[1] || "") + ".js"]]
        });
        seajs.use("<?php echo MON_XKWKJ_RES;?>js/bargain.js?v=8899");
    })(location.href.match(/de(\-\d+)bug/));

    </script>
</head>
<body onselectstart="return true;" ondragstart="return false;">
<div data-role="container" class="container">

    <?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('shotmenu', TEMPLATE_INCLUDEPATH)) : (include template('shotmenu', TEMPLATE_INCLUDEPATH));?>


    <header data-role="header">
        <div class="banner-top">
            <div class="left-div" style="float: left"><span><font class="color-red"><?php  echo $xkwkj['vcount'];?></font>人查看</span> <font class="color-red"><?php  echo $xkwkj['sharecount'];?></font>人分享</span> <font class="color-red"><?php  echo $joinCount;?></font>人报名</span></div>
        </div>


    </header>

    <section data-role="body" class="body" <?php  if($xkwkj['show_index_enable']) { ?> style="padding-bottom: 100px" <?php  } ?>>

        <form id="form1" action="<?php  echo $this->createMobileUrl('SelfKj',array('kid'=>$xkwkj['id'], 'fu'=> $fu),true)?>" method="post">

            <!--请将表单所有需要的隐藏输入加在此处-->                    <!--随机武器序列-->

            <input type="hidden" id="weapon_seq" name="seq_weapon" value="1"> <!--随机昵称序列-->
            <input type="hidden" id="name_seq" name="seq_name" value="1"> <!--若能获取真正昵称，则请赋值，若不能获取则不必赋值-->
            <input type="hidden" id="funame" name="funame" value="">
            <input type="hidden" id="futel" name="futel" value="">
            <div class="section_div">
                <div class="title_time">
                    <?php  if($status == $this::$KJ_STATUS_ZC) { ?>
                    <div>
                        <span>剩余时间</span>
                        <span class="time hours">00</span>
                        <span>:</span>
                        <span class="time minutes">00</span>
                        <span>:</span>
                        <span class="time seconds">00</span>
                    </div>
                    <?php  } else { ?>
                    <div>
                        <span><?php  echo $statusText;?></span>

                    </div>
                    <?php  } ?>

                    <div class='fr'>剩余<?php  echo $leftCount;?>件</div>
                </div>
            </div>
            <?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('kj_announcement', TEMPLATE_INCLUDEPATH)) : (include template('kj_announcement', TEMPLATE_INCLUDEPATH));?>
            <div class="section_div">
                <div class="poster"><img
                        src="<?php  echo MonUtil::getpicurl($goods['p_pic'])?>">

                    <div class="goods"><a href="<?php  echo $goods['p_url'];?>">
                        <div class="goods_pic"><img src="<?php  echo MonUtil::getpicurl($goods['p_preview_pic'])?>">
                        </div>
                        <div class="goods_des" style="text-decoration: underline"><?php  echo $goods['p_name'];?></div>
                        <div class="goods_price">原价<br>￥<?php  echo $xkwkj['p_y_price'];?></div>
                        <div class="goods_price">底价<br>￥<?php  echo $xkwkj['p_low_price'];?></div>
                    </a></div>
                </div>
            </div>



            <div class="section_div">
                <div class="price_board">                                                <!--当前价，已砍-->
                    <img
                        src="<?php echo MON_XKWKJ_RES;?>images/bargain_3.png">

                    <div class="price"><span>￥<?php  echo $xkwkj['p_y_price'];?></span></div>
                    <div class="cut_price"><span>￥0.00</span></div>
                </div>
            </div>
            <div class="section_div">
                <div class="msg_board">
                    <div class="avatar"><i></i></div>
                    <!--若获取不到用户昵称，则统一填少侠-->
                    <div><span class="avatar_name"><?php  echo $user['nickname'];?></span><?php  echo $this->getTipMsg($xkwkj, $this::$TIP_U_FIRST)?></div>
                </div>
            </div>
            <div class="section_div"><!--手起刀落 红色-->
                <?php  if($status == $this::$KJ_STATUS_ZC) { ?>

                     <?php  if($collectUserInfo) { ?>

                            <ul class="regist">
                                <li class="clearfix"><strong class="leftk">参加姓名：</strong>
                                   <input id="uname" type="text" name="uname" class="regist_input" style="height: 30px; width: 60%">
                                </li>
                                <li class="clearfix"><strong class="leftk">手机号码：</strong>
                                   <input id="tel" type="text" name="tel" class="regist_input" style="height: 30px; width: 60%">
                                </li>
                            </ul>
                      <?php  } ?>

                     <div class="btn_wrapper"><a href="javascript:;" class="cut_one_btn shadow_red cut_1"></a></div>
                <?php  } else { ?>
                      <div class="btn_wrapper"><a href="<?php  echo $xkwkj['zgg_url'];?>" class="cut_one_btn shadow_red cut_3"></a></div>
                <?php  } ?>
            </div>

        </form>



    <style>
        .kj-top {
            width: 100%;
            float: left;
            position: relative;
        }

        .kj-top img {
            width: 100%;
            float: left;
        }

        .scrollUl {
            width: 96%;
            float: left;
            position: absolute;
            bottom: 23%;
            left: 2%;
            text-align: center;
            height: 30px;
            font: 600 12px/52px "";
        }

        .scrollUl li {
            float: left;
            text-align: center;
            width: 33.3%;
        }

        .sd01 {
            cursor: pointer;
            color: #fed90d;
            background: none;
        }

        .sd02 {
            cursor: pointer;
            color: #fff;
            background: none;
        }

        .sd02 {
            cursor: pointer;
            color: #fff;
            background: none;
        }

        .phb-list {
            float: left;
            background: #483b4b;
            width: 100%;
            padding: 10px 8px;
            margin: 0;
        <?php  if($xkwkj['show_index_enable']) { ?>
        margin-bottom: 100px;
        <?php  } ?>
        box-sizing: border-box;
        -webkit-box-sizing: border-box;
        }

        .list_wrapper .cut_list .weapon_pic>img {
            display: inline-block;
            width: 46px;
            height: 46px;
            border-radius: 1000px;
            background: #342d36;
            vertical-align: middle;
        }
    </style>

    <script type="text/javascript">

        function scrollDoor(){
        }
        scrollDoor.prototype = {
            sd : function(menus,divs,openClass,closeClass){
                var _this = this;
                if(menus.length != divs.length)
                {
                    alert("菜单层数量和内容层数量不一样!");
                    return false;
                }
                for(var i = 0 ; i < menus.length ; i++)
                {
                    _this.$(menus[i]).value = i;
                    _this.$(menus[i]).onmouseover = function(){

                        for(var j = 0 ; j < menus.length ; j++)
                        {
                            _this.$(menus[j]).className = closeClass;
                            _this.$(divs[j]).style.display = "none";
                        }
                        _this.$(menus[this.value]).className = openClass;
                        _this.$(divs[this.value]).style.display = "block";
                    }
                }
            },
            $ : function(oid){
                if(typeof(oid) == "string")
                    return document.getElementById(oid);
                return oid;
            }
        }
        window.onload = function(){
            var SDmodel = new scrollDoor();
            SDmodel.sd(["m01","m02","m03"],["c01","c02","c03"],"sd01","sd02","sd03");
        }

        function check_des()
        {
            $("#m01").attr("class","sd01");
            $("#m02").attr("class","sd02");
            $("#m03").attr("class","sd02");

//            $("#c01").show();
//            $("#c02").hide();
//            $("#c03").hide();

            var pos = $("#comehere").offset().top;
            $("html,body").animate({scrollTop: pos}, 500);

        }
    </script>
    <div class="kj-top">
        <img src="<?php echo MON_XKWKJ_RES;?>images/kj-top.jpg" alt="">
        <ul class="scrollUl">
            <li class="sd01" id="m01" value="0">活动说明</li>
            <li class="sd02" id="m02" value="1">帮砍团</li>
            <li class="sd02" id="m03" value="2">排行榜（<?php  echo $joinCount;?>）</li>
        </ul>
    </div>



    <div class="phb-list content">

        <div id="c01" style="border-bottom-width: 1px; border-bottom-style: dashed; border-bottom-color: rgb(255, 255, 255); display: block;">
            <?php  echo $xkwkj['kj_intro'];?>
        </div>

        <div id="c02" class="hidden" style="display: none;">
             <font color="white">赶快找人帮您砍价吧！</font>
        </div>



        <div id="c03" class="hidden" style="display: none;">
            <div class="section_div">
                <div class="list_wrapper">
                    <ul class="cut_list" id="cut_list2">

                        <?php  if(is_array($ranklist)) { foreach($ranklist as $juser) { ?>
                        <li>
                            <div>
                                <div class="weapon_pic">
                                    <img src="<?php  echo $juser['headimgurl'];?>">
                                </div>
                                <div class="message">
                                    <span class="user_name"><?php  echo $juser['nickname'];?> 已砍掉 <?php  echo round($xkwkj['p_y_price']-$juser['price'], 2)?>元</span>
                                    <span class="amount">当前金额<?php  echo $juser['price'];?></span> 元
                                </div>
                            </div>
                        </li>
                        <?php  } } ?>


                    </ul>
                </div>
            </div>
        </div>

    </div>

    <?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('follow', TEMPLATE_INCLUDEPATH)) : (include template('follow', TEMPLATE_INCLUDEPATH));?>

    <footer data-role="footer">                <!--有活动说明的页面请添加此段-->
        <div data-role="mask" data-mask="instruction" id="mask_instruction" class="mask_instruction">
            <div class="mask_bkg"></div>
            <div class="dialogue_wrapper">
                <div class="d_header"></div>
                <div class="d_body" id="wrapper">
                    <div>
                        <?php  echo $xkwkj['kj_intro'];?>
                    </div>
                </div>
                <div class="d_footer">我知道了</div>
            </div>
        </div>
        <!--需要弹出砍价成功后动画的页面请添加此段-->
        <div data-role="mask" data-mask="animation" id="mask_animation" class="mask_animation">
            <div class="mask_bkg"></div>
            <div id="wallet" class="wallet"></div>
            <div id="sword" class="sword"></div>
            <div id="praise" class="praise">
                <div class="hint">你用 <span class="sword_name">庖丁菜刀</span> 砍掉了 <span class="money">5</span> 元</div>
                <div class="great"></div>
            </div>
        </div>
    </footer>
    <?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('foot', TEMPLATE_INCLUDEPATH)) : (include template('foot', TEMPLATE_INCLUDEPATH));?>
</div>

<script>


    function showFollowDialog() {

        showFollow(true);
      //  $("#guanzu").show();

        //alert("我操");

        /*
        swal({
                    title: "提示",
                    text: "<?php  echo $xkwkj['follow_dlg_tip'];?>",
                    type: "warning",
                    showCancelButton: true,
                    cancelButtonText: "取消",
                    confirmButtonColor: "#DD6B55",
                    confirmButtonText: "<?php  echo $xkwkj['follow_btn_name'];?>",
                    closeOnConfirm: false },
                function(){

                    window.top.location.href ="<?php  echo $xkwkj['follow_url'];?>";

                });*/

    }
</script>
<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('gmusic', TEMPLATE_INCLUDEPATH)) : (include template('gmusic', TEMPLATE_INCLUDEPATH));?>
</body>
</html>
