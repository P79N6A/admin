<?php defined('IN_IA') or exit('Access Denied');?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>支付宝充值</title>
    <style type="text/css">
        body{
            background: #eee;
            padding: 0;
        }
        .header{
            width: 100%;
            height: 23vw;
            background: #fff;
            padding: 3vw 0;
        }
        .table{
            width: 100%;
        }
        .table tr{
            width: 100%;
        }
        .table tr td{
            width: 33.3%;
        }
        .table tr td a{
            width: 80%;
            margin-left: 3vw;
            margin-top: 2vw;
            height: 10vw;
            display: block;
            border: #ccc solid 1px;
            color: #ccc;
            border-radius: 5px;
            text-align: center;
            line-height: 5vw;
            font-size: 3vw;
            text-decoration: none;
        }
        .table tr td a p{
            margin: 0;
        }
        .input-body{
            width: 90%;
            height: 7vw;
            border: #ccc solid 1px;
            border-radius: 5px;
            padding: 2vw;
            margin-top: 2vw;
            margin-left: 2vw;
        }
        .input-body input{
            border: 0;
            background: #fff;
            font-size: 4vw;
            padding-left: 2vw
        }
        .ative{
            border: #ffde00 solid 1px;
            color: #ffde00;
        }
        .btn{
            width: 70%;
            margin: 8vw auto;
            height: 10vw;
            font-size: 4vw;
            line-height: 10vw;
            background: #ffde00;
            border-radius: 50px;
            display: block;
            border: #ffde00 solid 1px;
            color: #fff;
        }
    </style>
    <script type="text/javascript" src="../addons/distribution_orderflow/template/js/jquery-1.11.1.min.js"></script>
</head>
<body>
    <form action="<?php  echo $this->createMobileUrl('appzfbpayment',array('op'=>post))?>" method="post">
    <div class="header">
        <?php  if($item) { ?>
        <img src="../<?php  echo $item['avatar'];?>" style="width: 15vw;display: block;margin: 0 auto 2vw auto;">
        <?php  } else { ?>
        <img src="../addons/distribution_orderflow/template/images/fx_logo.png" style="width: 15vw;display: block;margin: 0 auto 2vw auto;">
        <?php  } ?>
        <p style="text-align: center;font-size: 4vw;margin: 0;">￥<?php  echo number_format($item['credit1'], 2);?></p>
    </div>
    <input type="hidden" name="mobile_type">
    <input type="hidden" name="user_id" value="<?php  echo $_GPC['user_id'];?>">
    <p style="font-size: 4vw;line-height: 8vw;margin: 0;padding: 0 3vw;">充值金额</p>
    <div style="width: 100%;background: #fff;padding: 3vw 0;height: 45vw;">
        <table class="table">
            <tr>
                <td>
                    <a href="javascript:void(0);" onclick="set_recharge(20)" id="price_20">
                        <p>200金币</p>
                        <p>￥20</p>
                    </a>
                </td>
                <td>
                    <a href="javascript:void(0);" onclick="set_recharge(50)" id="price_50">
                        <p>500金币</p>
                        <p>￥50</p>
                    </a>
                </td>
                <td>
                    <a href="javascript:void(0);" onclick="set_recharge(100)" id="price_100">
                        <p>1000金币</p>
                        <p>￥100</p>
                    </a>
                </td>
            </tr>
            <tr>
                <td>
                    <a href="javascript:void(0);" onclick="set_recharge(200)" id="price_200">
                        <p>2000金币</p>
                        <p>￥200</p>
                    </a>
                </td>
                <td>
                    <a href="javascript:void(0);" onclick="set_recharge(500)" id="price_500">
                        <p>5000金币</p>
                        <p>￥500</p>
                    </a>
                </td>
                <td>
                    <a href="javascript:void(0);" onclick="set_recharge(1000)" id="price_1000">
                        <p>10000金币</p>
                        <p>￥1000</p>
                    </a>
                </td>
            </tr>
        </table>
        <div class="input-body">
            <span style="font-size: 5vw">￥</span>
            <input type="text" name="price" placeholder="请输入其它金额">
        </div>
    </div>
    <p style="font-size: 4vw;line-height: 8vw;margin: 0;padding: 0 3vw;">请选择支付方式</p>
    <div id="alipay_choice" style="width: 100%;background: #fff;padding: 3vw 0;height: 8vw;border-bottom: 1px solid #ccc">
        <img src="../addons/distribution_orderflow/template/images/alipay.png" style="width: 7vw;margin-left: 5vw;margin-right: 3vw;float: left;">
        <p style="font-size: 4vw;margin: 1vw 0;float: left;">支付宝支付</p>
        <label><img id="alipay" src="../addons/distribution_orderflow/template/images/icon_unuse.png" style="width: 5vw;float: right;margin: 1vw 5vw 1vw;"><input type="radio" name="type" value="1"  style="display: none;"></label>
    </div>
    <div id="wechat_chioce" style="width: 100%;background: #fff;padding: 3vw 0;height: 8vw;">
        <img src="../addons/distribution_orderflow/template/images/wechat.png" style="width: 7vw;margin-left: 5vw;margin-right: 3vw;float: left;">
        <p style="font-size: 4vw;margin: 1vw 0;float: left;">微信支付</p>
        <label><img id="wechat" src="../addons/distribution_orderflow/template/images/used.png" style="width: 5vw;float: right;margin: 1vw 5vw 1vw;"><input type="radio" name="type" value="2" checked="checked"  style="display: none;"></label>
    </div>
    <input type="submit" name="submit" disabled="disabled" value="请选择金额" class="btn">
    </form>
    <script type="text/javascript">
        // var param = "<?php  echo $result;?>";
        // console.log(param);
        // location.href = param.mweb_url;
        function set_recharge(value) {
            $('input[name=price]').val(value);
            $('.table tr td a').css({"border":"#ccc solid 1px","color":"#ccc"});
            $('#price_'+value).css({"border":"#ffde00 solid 1px","color":"#ffde00"});
            $('input[name=submit]').attr('disabled',false);
            $('input[name=submit]').val('确定充值');
        }
        $('input[name=price]').blur(function() {
            var data = $(this).val();
            if (!data) {
                $('input[name=submit]').attr('disabled',true);
                $('input[name=submit]').val('请选择金额');
            }
            else{
                $('input[name=submit]').attr('disabled',false);
                $('input[name=submit]').val('确定充值');
            }
        })
        var id = 123;

        $('label').click(function() {
            var type = $('input[name=type]:checked').val();
            if (type == 1) {
                $('#alipay').attr('src','../addons/distribution_orderflow/template/images/used.png');
                $('#wechat').attr('src','../addons/distribution_orderflow/template/images/icon_unuse.png');
            }
            else{
                $('#wechat').attr('src','../addons/distribution_orderflow/template/images/used.png');
                $('#alipay').attr('src','../addons/distribution_orderflow/template/images/icon_unuse.png');
            }
        })

        window.onload = function() {
            var u = navigator.userAgent;
            var isAndroid = u.indexOf('Android') > -1 || u.indexOf('Adr') > -1; //android终端
            var isiOS = !!u.match(/\(i[^;]+;( U;)? CPU.+Mac OS X/); //ios终端
            if (isAndroid == true) {
                $('input[name=mobile_type]').val(1);
            }
            else if(isiOS == true){
                $('input[name=mobile_type]').val(2);
            }
        }

        if (isWeiXin()) {
            $('#alipay_choice').hide();
        }

        function isWeiXin() {
            var ua = window.navigator.userAgent.toLowerCase();
            console.log(ua);//mozilla/5.0 (iphone; cpu iphone os 9_1 like mac os x) applewebkit/601.1.46 (khtml, like gecko)version/9.0 mobile/13b143 safari/601.1
            if (ua.match(/MicroMessenger/i) == 'micromessenger') {
                return true;
            } else {
                return false;
            }
        }
    </script>
</body>
</html>

