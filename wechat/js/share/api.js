//获取验证码
function sendSMS(mobile, successCB) {
	successCB = successCB || $.noop;
	var encryptedMobile = makeEncrypt(mobile);
	interface_aes_login(HTTP_USER_URL + 'sms', {
		mobile: encryptedMobile
	}, function(data) {
		return successCB(data);
	});
	//	var url = HTTP_USER_URL+'sms';
	//	$.ajax({
	//		type: 'POST',
	//		url: url,
	//		data: {
	//			mobile: encryptedMobile
	//		},
	//		dataType: 'json',
	//		success: successCB,
	//		error: function () {
	//			console.log("网络出错");
	//		}
	//	})
}

/**
 * 提交数据
 * @param data 数据
 * @param successCB 成功回调
 */
function postRegisterData(data, successCB) {
	successCB = successCB || $.noop;
	interface_aes_login(HTTP_USER_URL + 'registar', {
		mobile: encryptedMobile
	}, function(data) {
		return successCB(data);
	});
//	var url = HTTP_USER_URL + 'registar';
//	$.ajax({
//		type: 'POST',
//		url: url,
//		data: data,
//		dataType: 'json',
//		success: successCB,
//		error: function() {
//			console.log("网络出错");
//		}
//	})
}