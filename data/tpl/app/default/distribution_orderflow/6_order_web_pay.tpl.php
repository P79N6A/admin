<?php defined('IN_IA') or exit('Access Denied');?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>确认订单</title>
	<script type="text/javascript" src="../addons/distribution_orderflow/template/js/jquery-1.11.1.min.js"></script>
    <script src="../addons/distribution_orderflow/template/js/messenger.js"></script>
	<style type="text/css">
		.btn{
            width: 70%;
            margin: 8vw auto;
            height: 12vw;
            font-size: 5vw;
            line-height: 12vw;
            background: #ffde00;
            border-radius: 50px;
            display: block;
            border: #ffde00 solid 1px;
            color: #fff;
        }
	</style>
</head>
<body>
	<div style="width: 100%;">
        <div style="width: 100%;height: 6vw;background: #fff;padding: 2vw 0;box-shadow: 0 5px 5px #eee;margin-bottom: 3vw;text-align: center;">
            <img src="../addons/distribution_orderflow/template/images/icon_arrow_left.png" style="height: 4vw;float: left;margin-left: 4vw;" onclick="javascript:history.back(-1);">
            <span style="font-size: 4vw;">确认支付</span>
        </div>
        <form action="<?php  echo $this->createMobileUrl('web_payment',array('op'=>'post'))?>" method="post" style="padding: 0 4vw">
			<input type="hidden" name="user_id" value="<?php  echo $_GPC['user_id'];?>">
			<input type="hidden" name="paylog_id" value="<?php  echo $_GPC['paylog_id'];?>">
			<?php  if(is_array($payment)) { foreach($payment as $item) { ?>
			<div style="width: 100%;background: #fff;padding: 3vw 0;height: 8vw;border-bottom: 1px solid #ccc">
		        <img src="../addons/distribution_orderflow/template/images/<?php  echo $item['pay_info'];?>.png" style="width: 7vw;margin-left: 5vw;margin-right: 3vw;float: left;">
		        <p style="font-size: 4vw;margin: 1vw 0;float: left;">
                <?php  echo $item['pay_name'];?><?php  if($item['id'] == 1) { ?>（￥<?php  echo $user['credit1'];?>）<?php  } ?></p>
		        <?php  if($item['id'] == 1 && $user['credit1'] < $money) { ?>
		        <label id="recharge" onclick="sendMessage('parent','recharge')">
                    <img src="../addons/distribution_orderflow/template/images/icon_recharge.png" style="width: 6vw;float: right;margin: 1vw 5vw 1vw;">
                </label>
		        <?php  } else { ?>
		        <label class="choice">
                    <img id="<?php  echo $item['pay_info'];?>" src="../addons/distribution_orderflow/template/images/icon_unuse.png" style="width: 6vw;float: right;margin: 1vw 5vw 1vw;">
                    <input type="radio"  name="type"  value="<?php  echo $item['id'];?>"  style="display: none;">
                </label>
		        <?php  } ?>
		    </div>
		    <?php  } } ?>
		    <button type="submit" class="btn">确认支付定金 ￥<?php  echo $money;?></button>
		</form>
	</div>
	<script type="text/javascript">
        var status = "<?php  echo $order['status'];?>";
        var pay_type = "<?php  echo $order['pay_type'];?>";
        var messenger = new Messenger('iframe1', 'MessengerDemo');

        messenger.addTarget(window.parent, 'parent');

        function sendMessage(name,msg) {
            messenger.targets[name].send(msg);
        }
		$('.choice').click(function() {
            var type = $('input[name=type]:checked').val();
            if (type == 1) {
            	$('#account').attr('src','../addons/distribution_orderflow/template/images/used.png');
                $('#alipay').attr('src','../addons/distribution_orderflow/template/images/icon_unuse.png');
                $('#wechat').attr('src','../addons/distribution_orderflow/template/images/icon_unuse.png');
                $('#below').attr('src','../addons/distribution_orderflow/template/images/icon_unuse.png');
            }
            else if (type == 2) {
            	$('#wechat').attr('src','../addons/distribution_orderflow/template/images/used.png');
                $('#alipay').attr('src','../addons/distribution_orderflow/template/images/icon_unuse.png');
                $('#below').attr('src','../addons/distribution_orderflow/template/images/icon_unuse.png');
                $('#account').attr('src','../addons/distribution_orderflow/template/images/icon_unuse.png');
            }
            else if (type == 3) {
            	$('#wechat').attr('src','../addons/distribution_orderflow/template/images/icon_unuse.png');
                $('#alipay').attr('src','../addons/distribution_orderflow/template/images/used.png');
                $('#below').attr('src','../addons/distribution_orderflow/template/images/icon_unuse.png');
                $('#account').attr('src','../addons/distribution_orderflow/template/images/icon_unuse.png');
            }
            else{
                $('#wechat').attr('src','../addons/distribution_orderflow/template/images/icon_unuse.png');
                $('#alipay').attr('src','../addons/distribution_orderflow/template/images/icon_unuse.png');
                $('#below').attr('src','../addons/distribution_orderflow/template/images/used.png');
                $('#account').attr('src','../addons/distribution_orderflow/template/images/icon_unuse.png');
            } 
            
        })

        $('form').submit(function() {
            var type = $('input[type=radio]:checked').val();
            if (!type) {
                alert('请选择支付方式');
                return false;
            }
        })
        
        
	</script>
</body>
</html>