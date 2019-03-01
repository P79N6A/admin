function login(loginInfo, callback) {
	callback = callback || $.noop;
	loginInfo = loginInfo || {};
	loginInfo.account = loginInfo.account || '';
	loginInfo.password = loginInfo.password || '';
	mui.post('http://kake.gangbengkeji.cn/app/index.php?i=4&c=entry&m=purchasing&do=login', loginInfo, function(data) {
		console.log("login");
		return callback(data);
	}, 'json');

};

function toIndex() {
	//打开首页
	mui.openWindow({
		id: 'index',
		url: 'html/index.html'
	});
}