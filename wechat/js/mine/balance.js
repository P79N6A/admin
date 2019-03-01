$('label').click(function() {
            var type = $('input[name=type]:checked').val();
            if (type == 1) {
                $('#alipay').attr('src','../../img/icon_choose_pre.png');
                $('#wechat').attr('src','../../img/icon_choose_pay_nor2.png');
            }
            else{
                $('#wechat').attr('src','../../img/icon_choose_pre.png');
                $('#alipay').attr('src','../../img/icon_choose_pay_nor2.png');
            }
        })
function set_recharge(value) {
	            $('input[name=price]').val(value);
	            $('.table tr td a').css({"border":"#ccc solid 1px","color":"#ccc"});
	            $('#price_'+value).css({"border":"#ffde00 solid 1px","color":"#ffde00"});
	            $('input[name=button]').val('确定充值');
	        }
	        $('input[name=price]').blur(function() {
	            var data = $(this).val();
	            if (!data) {
	                $('input[name=button]').val('请选择金额');
	            }
	            else{
	                $('input[name=button]').val('确定充值');
	            }
	        })
function getUserInfo(callback) {
	callback = callback || $.noop;
	interface_aes_login(HTTP_USER_URL + 'usercenter', {}, function(data) {
		if(data.status == 200) {
			userInfo.userInfos = convertUserInfo(data);
		}
		return callback(data);
	});
}
/**
 *个人信息转换
 * */
function convertUserInfo(obj) {
	var newitems = [];
	var items = obj.list;
	newitems.push({
		src: HTTP_SRC_URL + items.avatar,
		credit: items.credit1,
	});
	return newitems;
}

function go_pay () {
	var price = $('input[name=price]').val();
	var type = $('input[name=type]:checked').val();
	var param = {price:price,type:type,user_id:getState().id};
	$.post(HTTP_ORDER_FLOW_URL+'appzfbpayment&op=post',param,function(data){
		weixinpay(data);
	},'json');
}

function weixinpay (data) {
	wx.chooseWXPay({
	timestamp: getNowUnixTime(), // 支付签名时间戳，注意微信jssdk中的所有使用timestamp字段均为小写。但最新版的支付后台生成签名使用的timeStamp字段名需大写其中的S字符
	nonceStr: data.nonce_str, // 支付签名随机串，不长于 32 位
	package: data.prepay_id, // 统一支付接口返回的prepay_id参数值，提交格式如：prepay_id=\*\*\*）
	signType: 'MD5', // 签名方式，默认为'SHA1'，使用新版支付需传入'MD5'
	paySign: data.sign, // 支付签名
	success: function (res) {
		alert('支付成功');
	}
	});
}