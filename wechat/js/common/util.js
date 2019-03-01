/**
 * 工具类
 * */

/**
 * 关闭webview页面
 * @parm id 页面id
 * 放在mui.plusReady(function() {closePageById(id)} );
 * */
function closePageById(id) {
	var ws = plus.webview.getWebviewById(id);
	console.log(id + "关闭" + ws);
	plus.webview.close(ws);
}
/**
 * 安卓或者ios手机环境下关闭页面
 * @param {Object} id
 */
function appClosePageById(id) {
	if(isApp() == 1) {
		closePageById(id);
	}
}

/**
 * 是否是手机环境
 * //1:APP   0:不是APP的环境
 */
function isApp() {
	var ua = window.navigator.userAgent.toLowerCase();
	if(ua.match(/Html5Plus/i)) {
		return 1;
	} else {
		return 0;
	}
	//1:APP   0:不是APP的环境
	return 1;
}

/**
 * 是否微信浏览器
 */
function is_weixin() {
	var ua = navigator.userAgent.toLowerCase();
	if(ua.match(/MicroMessenger/i) == "micromessenger") {
		return true;
	} else {
		return false;
	}
}

/**
 * 关闭webview页面
 * 放在mui.plusReady(function() {closeCurrentPage()} );
 * */
function closeCurrentPage() {
	var ws = plus.webview.currentWebview();
	plus.webview.close(ws);
}
/**
 * 刷新页面
 * @param {Object} id mui.openWindow中的id要一致
 * ps:保证同一个的页面的id唯一
 */
function refreshPageById(id) {
	var refresh = plus.webview.getWebviewById(id);
	refresh.reload(true);
}
/**
 * 安卓或者ios手机环境下刷新页面
 * @param {Object} id
 */
function appRefreshPageById(id) {
	if(isApp() == 1) {
		refreshPageById(id);
	}
}
/**
 * 网页版刷新当前页面
 */
function webRefreshCurrentPage() {
	if(isApp() != 1) {
		window.location.reload();
	}
}
/**
 * 获取当前状态
 **/
function getState() {
	var stateText = localStorage.getItem('$state') || "{}";
	return JSON.parse(stateText);
};

/**
 * 设置当前状态
 **/
function setState(state) {
	state = state || {};
	localStorage.setItem('$state', JSON.stringify(state));
};

function toMine() {
	location.href = '../../html/mine/mine.html';
	return;
}

function toHome() {
	location.href = '../../html/home/home.html';
	return;
}

function toLogin() {
	//打开登录
	location.href = '../../html/login/login.html';
	return;
}
/**
 * 登录密码加密
 * 1.加密成MD5
 * 2.将加密后的字符转asii并-3
 * 3.转回字符串
 * 4.最后加前10位的时间戳返回
 * */
function encrypt(password) {
	var passwd_md5 = hex_md5(password);
	var target = [];
	var ob = [];
	for(var i = 0; i < passwd_md5.length; i++) {
		target.push(passwd_md5.charAt(i).charCodeAt() - 3);
	}
	for(var i = 0; i < target.length; i++) {
		ob.push(String.fromCharCode(target[i]));
	}
	return ob.join("") + "-" + getNowUnixTime();
}

/**
 * 当前时间毫秒值
 * 取前10位
 * */
function getNowUnixTime() {
	var date = new Date();
	var time = date.getTime();
	return time.toString().substring(0, 10);
}

/**
 * 格式化日期
 * 2018-2-27
 * */
function formatDate(strTime) {
	var date = new Date(strTime * 1000);
	return date.getFullYear() + "-" + (date.getMonth() + 1) + "-" + date.getDate();
}

/****************加密/解密******************/
//判断访问终端
var browser = {
	versions: function() {
		var u = navigator.userAgent,
			app = navigator.appVersion;
		return {
			trident: u.indexOf('Trident') > -1, //IE内核
			presto: u.indexOf('Presto') > -1, //opera内核
			webKit: u.indexOf('AppleWebKit') > -1, //苹果、谷歌内核
			gecko: u.indexOf('Gecko') > -1 && u.indexOf('KHTML') == -1, //火狐内核
			mobile: !!u.match(/AppleWebKit.*Mobile.*/), //是否为移动终端
			ios: !!u.match(/\(i[^;]+;( U;)? CPU.+Mac OS X/), //ios终端
			android: u.indexOf('Android') > -1 || u.indexOf('Adr') > -1, //android终端
			iPhone: u.indexOf('iPhone') > -1, //是否为iPhone或者QQHD浏览器
			iPad: u.indexOf('iPad') > -1, //是否iPad
			webApp: u.indexOf('Safari') == -1, //是否web应该程序，没有头部与底部
			weixin: u.indexOf('MicroMessenger') > -1, //是否微信 （2015-01-22新增）
			qq: u.match(/\sQQ/i) == " qq" //是否QQ
		};
	}(),
	language: (navigator.browserLanguage || navigator.language).toLowerCase()
};

function getQueryString(name) {
	var reg = new RegExp("(^|&)" + name + "=([^&]*)(&|$)");
	var r = window.location.search.substr(1).match(reg);
	if(r != null) return decodeURI(r[2]);
	return "";
}

function aes_encrypt(data, key, iv) { //加密
	var key = CryptoJS.enc.Latin1.parse(key);
	var iv = CryptoJS.enc.Latin1.parse(iv);
	var srcs = CryptoJS.enc.Utf8.parse(data);

	var encrypted = CryptoJS.AES.encrypt(srcs, key, {
		iv: iv,
		mode: CryptoJS.mode.CBC,
		padding: CryptoJS.pad.Pkcs7
	});
	return encrypted.toString();
}

function aes_decrypt(encrypted, key, iv) { //解密
	var key = CryptoJS.enc.Latin1.parse(key);
	var iv = CryptoJS.enc.Latin1.parse(iv);
	var decrypted = CryptoJS.AES.decrypt(encrypted, key, {
		iv: iv,
		mode: CryptoJS.mode.CBC,
		padding: CryptoJS.pad.Pkcs7
	});
	return decrypted.toString(CryptoJS.enc.Utf8);
}
/**
 * 通过密码和偏移量进行AES对称加密
 * 1.http://tool.chacuo.net/cryptaes  在线AES加密解密
 * 2.AES加密模式:ECB 填充:pkcs7padding 数据块:128位 密码:AES_KEY 偏移量:AES_IV 输出:base64 字符集:utf8
 * @param {Object} message
 */
function makeEncrypt(message) {
	return aes_encrypt(message, AES_KEY, AES_IV);
}

function makeDecrypt(encrypted) {
	return aes_decrypt(encrypted, AES_KEY, AES_IV);
}

/**
 * 11位手机号码校验
 * @param {Object} mobile 手机号
 */
function mobile_validate(mobile) {
	var myreg = /^[1][3,4,5,7,8][0-9]{9}$/;
	if(myreg.test(mobile) && !isEmpty(mobile)) {
		return true;
	} else {
		mui.toast('请输入正确的手机号码');
		return false;
	}
}

function password_validate(password) {
	var error = [0, 'ok'];
	if(password == '') {
		error = [1, '密码不能为空'];
	}
	if(!/^[a-zA-Z0-9.]{6,20}$/.test(password)) {
		error = [1, '请输入正确的密码'];
	}
	return error;
}

/**
 * 四位验证码校验
 * @param {Object} code
 */
function verify_validate(code) {
	var error = [0, 'ok'];
	if(code == '') {
		error = [1, '验证码不能为空'];
	}
	if(!/^[0-9]{4}$/.test(code)) {
		error = [1, '请输入正确的验证码'];
	}
	return error;
}

/**
 * 手机 密码 验证码错误提示
 * @param {Object} err
 */
function show_error(err) {
	if(err[0]) {
		mui.toast(err[1]);
		return;
	}
}

//全局过滤器，可以在任何一个页面使用
Vue.filter("money", function(value, type) {
	return "￥" + value.toFixed(2) + type;
})

/**
 * 大于0的正整数
 */
function check_number(number) {
	var reg = /[1-9]\d/;
	if(reg.test(number)) {
		return true;
	}
	return false;
}

function openProductDetail(goods_id) {
	console.log("打开商品详情" + goods_id);
	var extras = {
		goodsId: goods_id
	};
	mui_storage_set('goods_detail_form_data', extras);
	mui.openWindow({
		id: "goodsDetail",
		url: "../../html/goods/goodsDetail.html",
		show: {
			autoShow: true,
			aniShow: 'pop-in',
			duration: 300
		},
		extras: {
			goods_detail_form_data: extras
		}
	});
	//	window.location.href = '../../html/goods/goodsDetail.html?goodsId=' + goods_id;

}

/**
 * 存储对象数据
 * @param {Object} key
 * @param {Object} val
 */
function storage(key, val) {
	if(typeof val == 'object') {
		localStorage.setItem(key, JSON.stringify(val));
	} else {
		var val = localStorage.getItem(key);
		return JSON.parse(val);
	}
}
/**
 * 判断对象未定义
 * 应用场景:判断有无数据或者是否为空串
 * @param {Object} obj
 */
function isEmpty(obj) {
	if(obj === undefined || obj == '') {
		return true;
	} else {
		return false;
	}
}
/**
 * 获取用户登陆状态
 */
function get_user_login_state() {
	var state = getState();
	if((state.id > 0) && (state.token != '')) {
		return true;
	}
	return false;
}

/**
 * url参数数组
 */
function getParams() {
	var query = window.location.search;
	query = query.replace('?', '');
	var queryArr = query.split('&');
	var params = {};
	if(queryArr.length > 0) {
		queryArr.forEach(function(item, index) {
			var itemArr = item.split('=');
			params[itemArr[0]] = itemArr[1];
		});
	}
	return params;
}

/**
 * 获取location.href第一个参数
 * window.location.href = '../../html/goods/goodsDetail.html?goodsId=' + goods_id;
 */
function getHrefParam() {
	var url = location.search; //获取url中"?"符后的字串 ('?modFlag=business&role=1')  
	var _param1 = url.split("?")[1];
	var _param2 = _param1.split("=")[1];
	console.log("获取第一个参数" + _param2);
	return _param2;
}

/**
 * AES 接口加密 
 * @param {Object} url
 * @param {Object} param 时间戳
 * @param {Object} callback
 */
function interface_aes(url, param, callback) {
	callback = callback || $.noop;
	var _timestamp = getNowUnixTime();
	param.timestamp = _timestamp;
	var encrypt_param = makeEncrypt(JSON.stringify(param));
	if (is_weixin()) {
		mui.post(WECHAT_URL, {
			data: encrypt_param,url:url
		}, function(data) {
			return callback(data);
		}, 'json');
	}
	else{
		mui.post(url, {
			data: encrypt_param
		}, function(data) {
			return callback(data);
		}, 'json');
	}
}

/**
 * AES 接口加密
 * @param {Object} url
 * @param {Object} param 登录token,时间戳
 * @param {Object} callback
 */
function interface_aes_login(url, param, callback) {
	callback = callback || $.noop;
	var _timestamp = getNowUnixTime();
	var state = getState();
	param.user_id = state.id;
	param.token = state.token;
	param.timestamp = _timestamp;
	var encrypt_param = makeEncrypt(JSON.stringify(param));
	if (is_weixin()) {
		mui.post(WECHAT_URL, {
			data: encrypt_param,url:url
		}, function(data) {
			return callback(data);
		}, 'json');
	}
	else{
		mui.post(url, {
			data: encrypt_param
		}, function(data) {
			return callback(data);
		}, 'json');
	}
}