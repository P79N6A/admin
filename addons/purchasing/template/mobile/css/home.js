/*
 *添加下线代理
 * */
function addLine(lineInfo, callback) {
	callback = callback || $.noop;
	lineInfo = lineInfo || {};
	lineInfo.line_account = lineInfo.line_account || '';
	lineInfo.line_nickname = lineInfo.line_nickname || '';
	lineInfo.line_password = lineInfo.line_password || '';
	lineInfo.line_repassword = lineInfo.line_repassword || '';
	var oddsInfo = oddsInfo || {};
	oddsInfo.odds_4b = lineInfo.odds_4b || '';
	oddsInfo.odds_4s = lineInfo.odds_4s || '';
	oddsInfo.odds_4a = lineInfo.odds_4a || '';
	oddsInfo.odds_3abc = lineInfo.odds_3abc || '';
	oddsInfo.odds_3a = lineInfo.odds_3a || '';
	oddsInfo.odds_box = lineInfo.odds_box || '';
	oddsInfo.odds_ibox = lineInfo.odds_ibox || '';
	oddsInfo.odds_a1 = lineInfo.odds_a1 || '';
	if(lineInfo.line_account.length < 1) {
		return callback('账号不能为空');
	}
	if(lineInfo.line_nickname.length < 1) {
		return callback('昵称不能为空');
	}
	if(lineInfo.line_password.length < 1) {
		return callback('密码不能为空');
	}
	if(lineInfo.line_repassword.length < 1) {
		return callback('确认密码不能为空');
	}
	if(lineInfo.line_password != lineInfo.line_repassword) {
		return callback('两次输入的密码不一致');
	}
	if(oddsInfo.odds_4b.length < 1) {
		return callback('4B1赔率不能为空');
	}
	if(oddsInfo.odds_4s.length < 1) {
		return callback('4B赔率不能为空');
	}
	if(oddsInfo.odds_4a.length < 1) {
		return callback('4A赔率不能为空');
	}
	if(oddsInfo.odds_3abc.length < 1) {
		return callback('3ABC赔率不能为空');
	}
	if(oddsInfo.odds_3a.length < 1) {
		return callback('3A赔率不能为空');
	}
	if(oddsInfo.odds_box.length < 1) {
		return callback('BOX赔率不能为空');
	}
	if(oddsInfo.odds_ibox.length < 1) {
		return callback('IBOX赔率不能为空');
	}
	if(oddsInfo.odds_a1.length < 1) {
		return callback('A1赔率不能为空');
	}
	var state = getState();
	var password_md5 = encrypt(lineInfo.line_repassword);
	mui.post('http://kake.gangbengkeji.cn/app/index.php?i=4&c=entry&m=purchasing&do=add_account', {
		user_id: state.id,
		token: state.token,
		account: lineInfo.line_account,
		nickname: lineInfo.line_nickname,
		password: password_md5,
		type: '1'

	}, function(data) {
		console.log("添加账号" + JSON.stringify(data));
		if(data.status == 200) {
			console.log("添加账号成功");
			setLineOdds(oddsInfo, callback, data.agent_id);
			//return callback();
		} else {
			return callback(data.info);
		}
	}, 'json');
};

/*
 *设置下线赔率
 * */
function setLineOdds(oddsInfo, callback, agent_id) {
	var state = getState();
	console.log("设置赔率" + state.id + " " + state.token + " " + agent_id + " " + oddsInfo.odds_4b);
	mui.post('http://kake.gangbengkeji.cn/app/index.php?i=4&c=entry&m=purchasing&do=set_odds', {
		user_id: state.id,
		token: state.token,
		agent_id: agent_id,
		odds1: oddsInfo.odds_4b,
		odds2: oddsInfo.odds_4s,
		odds3: oddsInfo.odds_4a,
		odds4: oddsInfo.odds_3abc,
		odds5: oddsInfo.odds_3a,
		odds6: oddsInfo.odds_box,
		odds7: oddsInfo.odds_ibox,
		odds8: oddsInfo.odds_a1
	}, function(data) {
		console.log("设置赔率" + JSON.stringify(data));
		if(data.status == 200) {
			console.log("添加账号成功");
			mui.toast('添加下线成功');
			return callback();
		} else {
			return callback(data.info);
		}
	}, 'json');
};

/*
 *添加下线代理
 * */
function addVip(vipInfo, callback) {
	callback = callback || $.noop;
	vipInfo = vipInfo || {};
	vipInfo.vip_account = vipInfo.vip_account || '';
	vipInfo.vip_nickname = vipInfo.vip_nickname || '';
	vipInfo.vip_password = vipInfo.vip_password || '';
	vipInfo.vip_repassword = vipInfo.vip_repassword || '';
	if(vipInfo.vip_account.length < 1) {
		return callback('账号不能为空');
	}
	if(vipInfo.vip_nickname.length < 1) {
		return callback('昵称不能为空');
	}
	if(vipInfo.vip_password.length < 1) {
		return callback('密码不能为空');
	}
	if(vipInfo.vip_repassword.length < 1) {
		return callback('确认密码不能为空');
	}
	var state = getState();
	var password_md5 = encrypt(vipInfo.vip_repassword);
	console.log("添加会员" + JSON.stringify(vipInfo)+password_md5);
	mui.post('http://kake.gangbengkeji.cn/app/index.php?i=4&c=entry&m=purchasing&do=add_account', {
		user_id: state.id,
		token: state.token,
		account: vipInfo.line_account,
		nickname: vipInfo.line_nickname,
		password: password_md5,
		type: '2'

	}, function(data) {
		console.log("添加会员" + JSON.stringify(data));
		if(data.status == 200) {
			console.log("添加账号成功");
			mui.toast('添加会员成功');
			return callback();
		} else {
			return callback(data.info);
		}
	}, 'json');
};