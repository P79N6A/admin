function isApp() {
	var ua = window.navigator.userAgent.toLowerCase();
	// console.log(ua);//mozilla/5.0 (iphone; cpu iphone os 9_1 like mac os x) applewebkit/601.1.46 (khtml, like gecko)version/9.0 mobile/13b143 safari/601.1
	if(ua.match(/Html5Plus/i)) {
		return 1;
	} else {
		return 0;
	}
	//1:APP   0:不是APP的环境
	return 1;
}

function mui_plusReady(callback) {
	if(!isApp()) {
		callback();
	} else {
		mui.plusReady(callback);
	}
}

//保存数据到本地
function mui_storage_set(key, data) {
	if(typeof data == 'object') {
		data = JSON.stringify(data);
	}
	localStorage.setItem(key, data);

}

//获取本地数据
function mui_storage_get(key) {
	var data;
	if(isApp()) {
		var req = plus.webview.currentWebview();
		data = req[key];
	} else {
		console.log("app2 ")
		data = localStorage.getItem(key) || '{}';
		data = JSON.parse(data);
	}
	return data;
}

/**
 * 关闭webview页面
 * 放在mui.plusReady(function() {closeCurrentPage()} );
 * */
function closeCurrentPage() {
	var ws = plus.webview.currentWebview();
	plus.webview.close(ws);
}

//APP环境下,打开新页面,关闭当前页面
//非APP,不用关闭页面
function app_close_current_page() {
	console.log("app 关闭当前页面");
	if(isApp() === 1) {
		closeCurrentPage();
	}
}