/**
 * 关闭webview页面
 * @parm id 页面id
 * 放在mui.plusReady(function() {closePageById(id)} );
 * */
function closePageById(id) {
	var ws = plus.webview.getWebviewById(id);
	plus.webview.close(ws);
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

/**
 * 加密
 * 1.加密成MD5
 * 2.讲加密后的字符转asii并-3
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
	//console.log("password=" + password + " passwd_md5=" + passwd_md5 + " target=" + target + " ob=" + ob.join("") + "time" + getNowUnixTime());
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