<?php defined('IN_IA') or exit('Access Denied');?><?php  if($xkwkj['announcement']) { ?>
<style>
    .hd-box {
        width: 100%;
        font-size: 1.125em;
        color: #fff;
        background: #342d36;
        box-sizing: border-box;
        -webkit-box-sizing: border-box;
        height: 30px;
    }

    .hdgg {
        width: 100%;
        /* background: #f0f0f0; */
        height: 30px;
        line-height: 30px;
        position: relative;
        display: inline-block;
    }

    .hdgg img {
        width: 57px;
        position: absolute;
        top: 8.5px;
        left: 10px;
    }

    .hdgg .text {
        width: 100%;
        padding-left: 75px;
        padding-right: 13px;
        float: left;
        line-height: 30px;
        overflow: hidden;
        border: none;
        box-sizing: border-box;
        -webkit-box-sizing: border-box;
        font-size: 14px;
        -moz-box-sizing: border-box;
    }

    #demo {
        width: 100%;
        overflow: hidden;
        border: none;
        box-sizing: border-box;
        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
    }

    #indemo {
        float: left;
        width: 800%;
    }

    #demo2 {
        float: left;
    }

    #demo1 {
        float: left;
    }
</style>
<div class="hd-box">

    <div class="hdgg">
        <img src="<?php echo MON_XKWKJ_RES;?>images/gg-img.png" alt="">
        <div class="text">
            <div id="demo">
                <div id="indemo">
                    <div class="lmboxb" id="demo1">
                        <ul>
                            <li style="white-space:nowrap;"><?php  echo $xkwkj['announcement'];?></li>
                        </ul>
                    </div>

                    <div id="demo2">

                    </div>
                </div>
            </div>

        </div>
    </div>

    <script type="text/javascript">
        var speed = 30; //数字越大速度越慢
        var tab = document.getElementById("demo");   /*如果想在同个页面使用两个  不只是demo要改变   tab也要改变  tab是变量 */
        var tab1 = document.getElementById("demo1");
        var tab2 = document.getElementById("demo2");
        tab2.innerHTML = tab1.innerHTML;
        function Marquee() {
            if (tab2.offsetWidth - tab.scrollLeft <= 0)
                tab.scrollLeft -= tab1.offsetWidth
            else {
                tab.scrollLeft++;
            }
        }
        var MyMar = setInterval(Marquee, speed);
    </script>
</div>

<?php  } ?>

