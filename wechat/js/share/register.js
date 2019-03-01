 
	var userId = getQueryString('user_id');

	$(".J-authCode").on("click", function () {
	
		var isDisable = $(this).hasClass("disabled");
		if (!isDisable) {
			var phone = $(".J-phoneInput").val();
			if (phone.length === 0) {
				mui.toast("请输入手机号码");
				return;
			}
			if (!/^1[3,4,5,7,8]\d{9}$/.test(phone)) {
				mui.toast("请输入正确的手机号码");	
				return;
			}
			//在这里发起请求获取验证码
			sendSMS(phone, function (res) {
				if (res.status !== 200) {
					mui.toast(res.info);
				}
				console.log(res);
			});
			//这里开始倒计时
			limitAuthCode(60);
		}
	});

	$(".J-registerBtn").on("click", function () {
		console.log("点击提交");
		var phone = $(".J-phoneInput").val();
		var code = $(".J-authCodeInput").val();
		var password = $(".J-passwordInput").val();
		if (phone.length === 0) {
			mui.toast("请输入手机号码");
			return;
		}
		
		if (!/^1[3,4,5,7,8]\d{9}$/.test(phone)) {
			mui.toast("请输入正确的手机号码");
			return;
		}
		if (code.length === 0) {
			mui.toast("请输入验证码");
			return;
		}
		if (password.length === 0) {
			mui.toast("请输入密码");
			return;
		}
		if (!/^[a-zA-Z0-9.]{6,20}$/.test(password)) {
			mui.toast("请输入正确的密码");
			return;
		}
		var data = {
			mobile: phone,
			password: encrypt(password),
			code: code,
			step: 'second',
			agentid: userId
		};
		var btn = $(this);
		mui.toast("注册中...");
		postRegisterData(data, function (res) {
			var status = res.status;
			if (status === 200) {
				//成功注册
				location.href = '../login/login.html';
			} else if (status === 300) {
				mui.toast("您已经注册过了");
			} else {
				mui.toast(res.info);
			}
		})
	});
 


/**
 * 验证码倒计时
 */
function limitAuthCode(second) {
	var $authCode = $(".J-authCode");
	if (second > 0) {
		$authCode.text('获取验证码(' + second + 's)');
		$authCode.addClass("disabled");
		setTimeout(function () {
			second--;
			limitAuthCode(second);
		}, 1000);
	} else {
		$authCode.removeClass("disabled");
		$authCode.text('获取验证码');
	}
}
