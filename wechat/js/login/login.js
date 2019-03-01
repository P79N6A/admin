/**
 * 手机号登录
 * @param {Object} loginInfo 手机号和密码
 * @param {Object} callback 接口回调--返回数据
 */
function login(loginInfo, callback) {
	callback = callback || $.noop;
	console.log("登录-未加密" + JSON.stringify(loginInfo));
	var encrypt_param = makeEncrypt(JSON.stringify(loginInfo));
	console.log("登录-AES加密" + encrypt_param);
	if (is_weixin()) {
		var send_url = WECHAT_URL;
		var param = {data: encrypt_param,url:HTTP_USER_URL + 'login'};
	}
	else{
		var send_url = HTTP_USER_URL + 'login';
		var param = {data: encrypt_param};
	}
	mui.post(send_url, param, function(data) {
		return callback(data);
	}, 'json');
};
/**
 * 获取第三方微信登录access_token
 * 获取后和微信的openid与unionid,3个参数,
 * 后台验证https://api.weixin.qq.com/sns/userinfo?openid=?&unionid=?&access_token=?
 * @param {Object} callback
 */
function getThirdLoginAccessToken(callback) {
	mui.post('https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=wx86f654aa160691bc&secret=a1544a9a1137ee284d04b806ae744b16', {}, function(data) {
		console.log("获取第三方微信登录token" + JSON.stringify(data));
		return callback(data);
	}, 'json');
}
/**
 * 第三方登录
 * @param {Object} loginInfo
 * @param {Object} callback
 */
function thirdLogin(type, loginInfo, callback) {
	callback = callback || $.noop;
	loginInfo = loginInfo || {};
	loginInfo.type = type || '';
	if(type == 1) {
		loginInfo.openid = loginInfo.openid || '';
		loginInfo.union_id = loginInfo.union_id || '';
		loginInfo.access_token = loginInfo.access_token || '';
		console.log("第三方微信登录1" + JSON.stringify(loginInfo));
	} else {
		loginInfo.openid = loginInfo.openid || '';
		loginInfo.union_id = loginInfo.union_id || '';
		console.log("第三方QQ登录1" + JSON.stringify(loginInfo));
	}
	interface_aes(HTTP_USER_URL + 'thirdlogin', loginInfo, function(data) {
		//	mui.post(HTTP_USER_URL + 'thirdlogin', loginInfo, function(data) {
		return callback(data);
	}, 'json');
};

/**
 * 演示程序当前的 “注册/登录” 等操作，是基于 “本地存储” 完成的
 * 当您要参考这个演示程序进行相关 app 的开发时，
 * 请注意将相关方法调整成 “基于服务端Service” 的实现。
 **/
(function($, owner) {
	/**
	 * 用户登录
	 **/
	owner.login = function(loginInfo, callback) {
		callback = callback || $.noop;
		loginInfo = loginInfo || {};
		loginInfo.account = loginInfo.account || '';
		loginInfo.password = loginInfo.password || '';
		if(loginInfo.account.length < 5) {
			return callback('账号最短为 5 个字符');
		}
		if(loginInfo.password.length < 6) {
			return callback('密码最短为 6 个字符');
		}
		var users = JSON.parse(localStorage.getItem('$users') || '[]');
		var authed = users.some(function(user) {
			return loginInfo.account == user.account && loginInfo.password == user.password;
		});
		if(authed) {
			return owner.createState(loginInfo.account, callback);
		} else {
			return callback('用户名或密码错误');
		}
	};

	owner.createState = function(name, callback) {
		var state = owner.getState();
		state.account = name;
		state.token = "token123456789";
		owner.setState(state);
		return callback();
	};

	/**
	 * 新用户注册
	 **/
	owner.reg = function(regInfo, callback) {
		callback = callback || $.noop;
		regInfo = regInfo || {};
		regInfo.account = regInfo.account || '';
		regInfo.password = regInfo.password || '';
		if(regInfo.account.length < 5) {
			return callback('用户名最短需要 5 个字符');
		}
		if(regInfo.password.length < 6) {
			return callback('密码最短需要 6 个字符');
		}
		if(!checkEmail(regInfo.email)) {
			return callback('邮箱地址不合法');
		}
		var users = JSON.parse(localStorage.getItem('$users') || '[]');
		users.push(regInfo);
		localStorage.setItem('$users', JSON.stringify(users));
		return callback();
	};

	var checkEmail = function(email) {
		email = email || '';
		return(email.length > 3 && email.indexOf('@') > -1);
	};

	/**
	 * 找回密码
	 **/
	owner.forgetPassword = function(email, callback) {
		callback = callback || $.noop;
		if(!checkEmail(email)) {
			return callback('邮箱地址不合法');
		}
		return callback(null, '新的随机密码已经发送到您的邮箱，请查收邮件。');
	};

	/**
	 * 获取应用本地配置
	 **/
	owner.setSettings = function(settings) {
		settings = settings || {};
		localStorage.setItem('$settings', JSON.stringify(settings));
	}

	/**
	 * 设置应用本地配置
	 **/
	owner.getSettings = function() {
		var settingsText = localStorage.getItem('$settings') || "{}";
		return JSON.parse(settingsText);
	}
	/**
	 * 获取当前状态
	 **/
	owner.getState = function() {
		var stateText = localStorage.getItem('$state') || "{}";
		return JSON.parse(stateText);
	};
	/**
	 * 获取本地是否安装客户端
	 **/
	owner.isInstalled = function(id) {
		if(id === 'qihoo' && mui.os.plus) {
			return true;
		}
		if(mui.os.android) {
			var main = plus.android.runtimeMainActivity();
			var packageManager = main.getPackageManager();
			var PackageManager = plus.android.importClass(packageManager)
			var packageName = {
				"qq": "com.tencent.mobileqq",
				"weixin": "com.tencent.mm",
				"sinaweibo": "com.sina.weibo"
			}
			try {
				return packageManager.getPackageInfo(packageName[id], PackageManager.GET_ACTIVITIES);
			} catch(e) {}
		} else {
			switch(id) {
				case "qq":
					var TencentOAuth = plus.ios.import("TencentOAuth");
					return TencentOAuth.iphoneQQInstalled();
				case "weixin":
					var WXApi = plus.ios.import("WXApi");
					return WXApi.isWXAppInstalled()
				case "sinaweibo":
					var SinaAPI = plus.ios.import("WeiboSDK");
					return SinaAPI.isWeiboAppInstalled()
				default:
					break;
			}
		}
	}
}(mui, window.app = {}));