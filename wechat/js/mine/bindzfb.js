/*
 * 绑定支付宝
 */

var bingzfb = new Vue({
	el: "#content",
	data: {
		realname: '',
		zfb: ''
	},
	methods: {}
});

function getzfb() {
	interface_aes_login(HTTP_USER_URL + 'iszfb', {}, function(data) {
		//	mui.post(HTTP_USER_URL + "iszfb",{
		//		user_id : getState().id,
		//		token : getState().token
		//		},function(data){
		//console.log("支付宝"+JSON.stringify(data));
		bingzfb.realname = data.is_realname;
		bingzfb.zfb = data.zfb;
	}, 'json');
}

function getCode() {
	interface_aes_login(HTTP_USER_URL + 'sendsms', {}, function(data) {
		//	mui.post(HTTP_USER_URL + "sendsms",{
		//		user_id : getState().id,
		//		token : getState().token
		//		},function(data){
		mui.toast(data.info);
	}, 'json');
}

function bindzfb() {
	var name = $('#real_name').val().trim();
	if(name == '') {
		mui.toast("请输入姓名");
		return;
	}
	var zfb1 = $('#account_zfb1').val().trim();
	var zfb2 = $('#account_zfb2').val().trim();
	if(zfb1 == '' || zfb2 == "") {
		mui.toast("请输入支付宝账号");
		return;
	}

	if(zfb1 != zfb2) {
		mui.toast("两次输入的支付宝账号不一致");
		return;
	}

	var code = $('#code').val().trim();

	if(code == '') {
		mui.toast("请输入验证码");
		return;
	}
	var param = {
		realname: name,
		zfb: zfb1,
		code: code
	};
	interface_aes_login(HTTP_USER_URL + 'zfbbinging', {}, function(data) {
		//	mui.post(HTTP_USER_URL + "zfbbinging",{
		//		user_id : getState().id,
		//		token : getState().token,
		//		realname : name,
		//		zfb : zfb1,
		//		code :code
		//	},function(data){
		mui.toast(data.info);
		if(data.status == 200) {
			setTimeout(function() {
				appClosePageById('bindzfb');
			}, 500);
		}

	}, 'json');
}

getzfb();