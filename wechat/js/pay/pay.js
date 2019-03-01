 
var paylog_id = 0;
/**********************/
//支付类型
var paytype = 0;
//支付方式图标
var payment_img = ['../../img/icon_alipay.png',
'../../img/icon_whatpay.png',
'../../img/icon_black.png', 
'../../img/icon_linepay.png'];
//余额
var credit = 0;
 
  
/**
 * 获取支付列表
 */
function get_payment_list() {
	var user =  getState();
	var paylog_id = $('#paylog_id').val();
	var param = {paylog_id: paylog_id};
	interface_aes_login(HTTP_BASE_URL + "m=distribution_orderflow&do=payment", param,
		function(response) {
			var list = response.paylist;
			var html = '';
			credit = response.credit1;

			for(var val in list) {

				var src1 = '../../img/icon_choose_pay_nor.png';
				var src = '';
				if(list[val].pay_info == "alipay") {
					src = payment_img[0];
				}
				if(list[val].pay_info == "wechat") {
					src = payment_img[1];
				}
				if(list[val].pay_info == "account") {
					src = payment_img[2];
				}
				if(list[val].pay_info == "below") {
					src = payment_img[3];
				}
				if(list[val].pay_info == "account") {
					if(credit <= 0) {
						src1 = '../../img/icon_recharge.png';
					}
				}
				html += '<div class="payment mui-table-view-cell">' +
					'<div class="order_pay_left">' +
					'<img class="mui-media-object mui-pull-left" src="' + src + '"><div>' + list[val].pay_name + '支付</div></div>' +
					'<div class="order_pay_right">' +
					'<img class="select_img select_img_' + list[val].pay_info + '"   data-id="' + list[val].id + '" src="' + src1 + '" onclick="select_img(this)" >' +
					'</div></div>';

			}
			$('#payment').html(html);
			$('#price').text(response.deposit);
			$('#credit').val(credit);
		}, 'json');
}

/**
 * 选择支付方式
 * @param {Object} obj
 */
function select_img(obj) {
	if(credit <= 0) {
		if(!$(obj).hasClass('select_img_account')) {
			$('.select_img_alipay,.select_img_wechat,.select_img_below').attr('src', '../../img/icon_choose_pay_nor.png');
			$(obj).attr('src', '../../img/icon_choose_pay_pre.png');
			paytype = $(obj).attr('data-id');
		}
	} else {
		$('.select_img_alipay,.select_img_wechat,.select_img_below').attr('src', '../../img/icon_choose_pay_nor.png');
		$(obj).attr('src', '../../img/icon_choose_pay_pre.png');
		paytype = $(obj).attr('data-id');
	}
}

//支付
function confirm_pay() {
    var user = getState();
	var paylog_id = $('#paylog_id').val();

	if(paylog_id < 1) {
		mui.toast('请选择支付订单');
		return;
	}
	if(paytype < 1) {
		mui.toast('请选择支付方式');
		return;
	}
	console.log("USER_ID=" + user.id + " TOKEN=" + user.token + " paylog_id=" + paylog_id + " paytype=" + paytype);
	//http://kake.gangbengkeji.cn/app/index.php?i=6&c=entry&m=distribution_orderflow&&version=1.0&do=go_pay&user_id=14&paylog_id=93&pay_id=2
	//http://kake.gangbengkeji.cn/app/index.php?i=6&c=entry&m=distribution_orderflow&&version='+VERSION+'&do=
	mui.post('http://kake.gangbengkeji.cn/app/index.php?i=6&c=entry&m=distribution_orderflow&&version=1.0&do=go_pay', {
			token: user.token,
			user_id: user.id,
			paylog_id: paylog_id,
			pay_id: paytype
		},
		function(response) {
			console.log("调支付接口" + JSON.stringify(response));
	 
			if (response.paytype == 3) {
				
			}
				
			if(paytype == 2) {
				beecloudPay('WX_APP');
			}

		}, 'json');
}

//支付
function beecloudPay(bcChannel) {
	//因DCloud尚未申请银联账号，故支付宝、微信使用的是DCloud的appid，银联暂时使用BeeCloud的appid，开发者这里无需判断，直接写一个appid即可；
	var _appid = "44f01a13-965f-4b27-ba9f-da678b47f3f5"
	/*
	 * 构建支付参数
	 * 
	 * app_id: BeeCloud控制台上创建的APP的appid，必填 
	 * title: 订单标题，32个字节，最长支持16个汉字；必填
	 * total_fee: 支付金额，以分为单位，大于0的整数，必填
	 * bill_no: 订单号，8~32位数字和/或字母组合,确保在商户系统中唯一，必填
	 * optional: 扩展参数,可以传入任意数量的key/value对来补充对业务逻辑的需求;此参数会在webhook回调中返回; 选填
	 * bill_timeout: 订单失效时间,必须为非零正整数，单位为秒，必须大于360。选填 
	 */
	var payData = {
		app_id: _appid,
		channel: bcChannel,
		title: "DCloud项目捐赠",
		total_fee: 1,
		bill_no: beecloud.genBillNo(),
		optional: {
			'uerId': 'beecloud',
			'phone': '4006280728'
		},
		bill_timeout: 360,
		return_url: "http://www.dcloud.io/demo/pay" //wap支付成功后的回跳地址
	};
	/*
	 *  发起支付
	 *  payData: 支付参数
	 *  cbsuccess: 支付成功回调
	 *  cberror: 支付失败回调
	 */
	beecloud.payReq(payData, function(result) {
		//		document.getElementById("status").innerHTML = 'success';
		//		document.getElementById("status").style.color = 'green'
		//		document.getElementById("status_msg").innerHTML = "-------- 支付成功 --------" + "\n感谢您的支持,我们会继续努力完善产品";
		console.log("支付成功" + result);
	}, function(e) {
		console.log("支付失败" + e);
		//		document.getElementById("status").innerHTML = 'failed';
		//		document.getElementById("status").style.color = 'red'
		//		document.getElementById("status_msg").innerHTML = "-------- 支付失败 --------\n" + "错误码：" + e.code + '\n' + e.message;
	});
}
 
 
 