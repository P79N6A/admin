<?php defined('IN_IA') or exit('Access Denied');?>
<style>
    .hdwf_box {
        background: rgba(0, 0, 0, 0.63);
        border-radius: 50%;
        width: 45px;
        height: 45px;
        position: fixed;
        right: 1%;
        top: 16%;
        color: #FFF;
        text-align: center;
        z-index: 2;
    }

    .hdwf_box div {
        width: 80%;
        font-size: 11px;
        line-height: 15px;
        margin: 0 auto;
        margin-top: 8px;
    }

    #audio_btn {
        position: fixed;
        right: -2%;
        top: 12%;
        z-index: 4;
        display: none;
        width: 50px;
        height: 50px;
        background-repeat: no-repeat;
        cursor: pointer;
    }

    .play_yinfu {
        background-image: url(<?php echo MON_XKWKJ_RES;?>images/music.gif);
        background-repeat: no-repeat;
        background-position: center center;
        background-size: 60px 60px;
    }

    .off {
        background: url(<?php echo MON_XKWKJ_RES;?>images/music_off.png);
        background-size: 30px 30px;
    }

    .rotate {
        left: 10px;
        top: 10px;
        width: 30px;
        height: 30px;
        background-size: 100% 100%;
        background-image: url(<?php echo MON_XKWKJ_RES;?>images/music_off.png);
        -webkit-animation: rotating 1.2s linear infinite;
        -moz-animation: rotating 1.2s linear infinite;
        -o-animation: rotating 1.2s linear infinite;
        animation: rotating 1.2s linear infinite;
    }


    @-webkit-keyframes rotating {
        from {
            -webkit-transform: rotate(0)
        }
        to {
            -webkit-transform: rotate(360deg)
        }
    }

    @keyframes rotating {
        from {
            transform: rotate(0)
        }
        to {
            transform: rotate(360deg)
        }
    }

    @-moz-keyframes rotating {
        from {
            -moz-transform: rotate(0)
        }
        to {
            -moz-transform: rotate(360deg)
        }
    }

    .kanjia_contact_fix {
        position: fixed;
        right: 10px;
        bottom: 15%;
        width: 95px;
        height: 35px;
        background: rgba(0, 0, 0, 0.8);
        border-radius: 17px;
        color: #fff;
        font-size: 14px;
        text-align: center;
        line-height: 35px;
        z-index: 4;
    }

    .icon_kanjia_call {
        width: 16px;
        height: 18px;
        display: inline-block;
        background-position: -269px -323px;
        margin-right: 6px;
        vertical-align: -4px;
    }


    .icon_knajia_music, .icon_kanjia_call, .dialog-content.kanjia .close01, .dialog-content.hongbao_share .close01 {
        background-image: url(<?php echo MON_XKWKJ_RES;?>/images/icon01.png);
        background-repeat: no-repeat;
        background-size: 500px;
    }

</style>





<?php  if($poster_setting['qr_enable'] == 1) { ?>
      <a href="javascript:showPoster()">
        <div class="hdwf_box" style="top:22%;">
            <div>活动<br>海报</div>
        </div>
       </a>
<?php  } ?>

<?php  if($xkwkj['show_index_enable']) { ?>



<a href="<?php  echo $this->createMobileUrl('HomeIndex', array(), true)?>">
    <div class="hdwf_box" style="top:32%;">
        <div>更多<br>砍价</div>
    </div>
</a>



<a href="<?php  echo $this->createMobileUrl('ucenter',  array(),true)?>">
    <div class="hdwf_box" style="top:40%;">
        <div>个人<br/>中心</div>
    </div>
</a>

<?php  } ?>



<?php  if($xkwkj['hfbk_enable'] == 1 && !empty($user)) { ?>

<a href="javascript:helpbk()">
    <div class="hdwf_box" style="top:50%;">
        <div>回复<br/>帮砍</div>
    </div>
</a>

<?php  } ?>

<?php  if($xkwkj['bgmusic']) { ?>
<div class="video_exist play_yinfu" id="audio_btn" style="display: block;">
    <div id="yinfu" class="rotate"></div>
    <audio preload="auto" autoplay="" id="media" src="<?php  echo MonUtil::getpicurl($xkwkj['bgmusic'])?>" loop=""></audio>
</div>
<?php  } ?>


<?php  if($xkwkj['shtel']) { ?>
<div class="kanjia_contact_fix"><a href="tel:<?php  echo $xkwkj['shtel'];?>" style="color:#FFF;"><i class="icon_kanjia_call"></i>联系商家</a></div>

<?php  } ?>



<style>

    .black {
        width: 100%;
        height: 100%;
        position: fixed;
        top: 0;
        left: 0;
        background-color: rgba(0,0,0,0.7);
        padding: 1.4rem 1rem;
        box-sizing: border-box;
        z-index: 100;
        display: none;
    }

    .Bcolor {
        color: #ff5d38;
    }


    .fix-tl-100 {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        z-index: 500;
    }

    .bpro {
        font-size: 1.2rem;
        text-align: center;
        margin-top: 1rem;
        color: #fff;
    }

    .dialog-black-mask {
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.5);
    }

    .basewrap {
        min-width: 320px;
        max-width: 640px;
        margin: 0 auto;
    }

    .dialog-content.kanjia_share {
        width: 300px;
        max-width: none;
        border-radius: 0;
        text-align: left;
        overflow: visible;
        margin-top: 15px;
        background: #eaeaec;
    }


    .dialog-content {
        position: fixed;
        z-index: 500;
        width: 80%;
        max-width: 300px;
        top: 50%;
        left: 50%;
        -webkit-transform: translate(-50%, -50%);
        transform: translate(-50%, -50%);
        background-color: #FFFFFF;
        text-align: center;
        border-radius: 3px;
        overflow: hidden;
    }

    .close_tuchulai {
        width: 3.4rem;
        height: 3.4rem;
        position: absolute;
        bottom: -70px;
        left: 50%;
        display: block;
        transform: translate(-50%, 0);
        -webkit-transform: translate(-50%, 0);
        background-position: -14.7rem -34.8rem;
        background-image: url(<?php echo MON_XKWKJ_RES;?>/images/icon01.png);
        background-repeat: no-repeat;
        background-size: 50rem;

    }





</style>



<?php  if($poster_setting['qr_enable'] == 1) { ?>

<div class="black" style="overflow: auto; display: none;">
    <div class="fix-tl-100 fenxiang_tk_js" style="display: block;">
        <div class="bpro"><i class="Bcolor">长按并保存起来</i>，发送到朋友圈或群聊</div>
        <div class="basewrap dialog-black-mask" style="background: rgba(0,0,0,.9);"></div>
        <div class="dialog-content kanjia_share" style="margin-top: 0px;width:80%;">
            <img id="InviteCardImage" src="" style="width:100%;">
            <span class="close_tuchulai" style="cursor:pointer;bottom: -3.5rem;"></span>
        </div>
    </div>

</div>
<?php  } ?>


<link rel="stylesheet" type="text/css"  href="<?php echo MON_XKWKJ_RES;?>plugin/layer/layer.css" />
<script src="<?php echo MON_XKWKJ_RES;?>plugin/layer/layer.js" type="text/javascript" type="text/javascript"></script>

<script>

    function helpbk() {
        showBkFollow(true);

    }

    function showPoster() {
        <?php  if($poster_setting['qr_enable'] == 1) { ?>
        $(".black,.fenxiang_tk_js").show();
            layer.open({type:2,content: '加载中',shadeClose:false});
             $("#InviteCardImage").attr("src", "<?php  echo $this->createPoster($xkwkj['id'], $user['id'] );?>");
            layer.closeAll();
        <?php  } ?>
    }

    $(".close,.close_tuchulai").click(function(e) {
        $(".black,.vBlack").hide();
        e.stopPropagation();
    });


</script>
